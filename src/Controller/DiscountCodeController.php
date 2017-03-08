<?php
namespace App\Controller;
use App\Controller\AppController;

class DiscountCodeController extends AppController{
    
    public function initialize()
    {
            parent::initialize();
            $this->loadComponent("GYMFunction");
            
    }
	
    public function discountCodeList(){
        $this->set("GYMFunction",$this->GYMFunction);
        $session = $this->request->session()->read("User");
        switch($session["role_name"]){
            CASE "administrator" :
                    $data = $this->DiscountCode->find("all")->contain(['GymMember'])->hydrate(false)->toArray();
            break;

            CASE "franchise" :
                    $data = $this->DiscountCode->find("all")->contain(['GymMember'])->where(["DiscountCode.created_by"=>$session["id"]])->hydrate(false)->toArray();
            break;		
        }

        $this->set("data",$data);
    }
        
    public function addDiscountCode(){
        $session = $this->request->session()->read("User");
        $this->set("edit",false);
        $this->set("title",__("Add Discount Code"));
        
        $memberships = $this->DiscountCode->Membership->find("list",["keyField"=>"id","valueField"=>"membership_label"]);
        $this->set("memberships",$memberships);

        if($this->request->is("post")){
            
            $row = $this->DiscountCode->newEntity();
            
            if(isset($this->request->data["valid_till"]) && $this->request->data["valid_till"] !=''){
                $this->request->data["valid_till"] = strtotime($this->request->data["valid_till"]);
            }else{
                $this->request->data["valid_till"] = 1;
            }
            $this->request->data["created_by"] = $session["id"];	
            $this->request->data['membership'] = json_encode($this->request->data['membership']);

            /*SANITIZATION*/
            //$this->request->data["comment"] = $this->GYMFunction->sanitize_string($this->request->data["comment"]);
            /*SANITIZATION*/
            
            //$this->GYMFunction->pre($this->request->data);

            $row = $this->DiscountCode->patchEntity($row,$this->request->data);
            if($this->DiscountCode->save($row)){				
                $this->Flash->success(__("Success! Discount Code Successfully Saved."));
                return $this->redirect(["action"=>"discountCodeList"]);			
            }else{
                $this->Flash->error(__("Error! Discount Code Not Saved.Please Try Again."));
            }
        }		
    }
        
    public function editLocation($pid){	

        $session = $this->request->session()->read("User");
        $this->set("edit",true);	
        $this->set("title",__("Edit Location"));
        $row = $this->GymLocation->get($pid);
        $this->set("data",$row->toArray());

         /** Edit record checked roles permissions* */
        if ($session["role_name"] == "franchise") {
            if ($row['created_by'] != $session['id']) {
                $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                return $this->redirect(["action" => "locationList"]);
            }
        }

    /** End here * */
    //$classes = $this->GymLocation->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"]);
        //$this->set("classes",$classes);

        if($this->request->is("post")){
            //$this->request->data["start_date"] = date("Y-m-d",strtotime($this->request->data["start_date"]));		
            //$this->request->data["end_date"] = date("Y-m-d",strtotime($this->request->data["end_date"]));

            /*SANITIZATION*/
            //$this->request->data["comment"] = $this->GYMFunction->sanitize_string($this->request->data["comment"]);
            /*SANITIZATION*/

            $row = $this->GymLocation->patchEntity($row,$this->request->data);
            if($this->GymLocation->save($row)){
                $this->Flash->success(__("Success! Record Successfully Updated."));
                return $this->redirect(["action"=>"locationList"]);
            }else{
                $this->Flash->error(__("Error! Record Not Updated.Please Try Again."));
            }
        }
        $this->render("addLocation");
    }
	
    public function deleteLocation($did)
    {

        $session = $this->request->session()->read("User");
        $row = $this->GymLocation->get($did);

    /** Edit record checked roles permissions* */
    if ($session["role_name"] == "franchise") {
        if ($row['created_by'] != $session['id']) {
            $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
            return $this->redirect(["action" => "locationList"]);
        }
    }

    /** End here * */
    if($this->GymLocation->delete($row))
            {
                    $this->Flash->success(__("Success! Record Deleted Successfully Updated."));
                    return $this->redirect(["action"=>"locationList"]); 
            } 		
    }

    public function isAuthorized($user){
        return parent::isAuthorizedCustom($user);
    }
}
