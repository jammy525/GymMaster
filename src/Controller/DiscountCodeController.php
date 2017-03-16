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
        //$this->set("GYMFunction",$this->GYMFunction);
        $session = $this->request->session()->read("User");
        switch($session["role_name"]){
            CASE "administrator" :
                    //$data = $this->DiscountCode->find("all")->contain(['GymMember'])->hydrate(false)->toArray();
                $data = $this->DiscountCode
                                ->find('all',[
                                    'fields'=>[
                                        'DiscountCode.id',
                                        'DiscountCode.code',
                                        'DiscountCode.discount',
                                        'DiscountCode.created_by',
                                        'DiscountCode.created_at',
                                        'DiscountCode.membership',
                                        'DiscountCode.valid_till',
                                        'DiscountCode.status',
                                        'GymMember.id'
                                        ]
                                    ])
                                ->contain(['GymMember'])->hydrate(false)->toArray();
            break;

            CASE "licensee" :
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
                $valid_till = strtotime($this->request->data["valid_till"]);
                $this->request->data["valid_till"] = $valid_till;
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
            //$this->GYMFunction->pre($row);
            if($this->DiscountCode->save($row)){				
                $this->Flash->success(__("Success! Discount Code Successfully Saved."));
                return $this->redirect(["action"=>"discountCodeList"]);			
            }else{
                $this->Flash->error(__("Error! Discount Code Not Saved.Please Try Again."));
            }
        }		
    }
        
    public function editDiscountCode($pid){	

        $session = $this->request->session()->read("User");
        $this->set("edit",true);	
        $this->set("title",__("Edit Discount Code"));
        $row = $this->DiscountCode->get($pid)->toArray();
        
        /** Edit record checked permissions* */
        if ($session["role_name"] == "licensee") {
            if($row['created_by'] != $session['id']){
                $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                return $this->redirect(["action" => "discountCodeList"]);
            }
        }
        
        $this->set("data",$row);
        
        $memberships = $this->DiscountCode->Membership->find("list",["keyField"=>"id","valueField"=>"membership_label"]);
        $this->set("memberships",$memberships);
        
        $this->render("addDiscountCode");
        
        if($this->request->is("post")){
            $row = $this->DiscountCode->get($pid);
            $this->request->data['membership'] = json_encode($this->request->data['membership']);
            
            if(isset($this->request->data["valid_till"]) && $this->request->data["valid_till"] !=''){
                $valid_till = strtotime($this->request->data["valid_till"]);
                $this->request->data["valid_till"] = $valid_till;
            }else{
                $this->request->data["valid_till"] = 1;
            }
            $row = $this->DiscountCode->patchEntity($row,$this->request->data);
            if($this->DiscountCode->save($row)){
                $this->Flash->success(__("Success! Record Successfully Updated."));
                return $this->redirect(["action"=>"discountCodeList"]);
            }else{
                $this->Flash->error(__("Error! Record Not Updated.Please Try Again."));
            }
        }
        ///$this->render("addLocation");
    }
	
    public function deleteDiscountCode($did){

        $session = $this->request->session()->read("User");
        $row = $this->DiscountCode->get($did);

        /** Edit record checked roles permissions* */
        if ($session["role_name"] == "licensee") {
            if ($row['created_by'] != $session['id']) {
                $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Delete This Record."));
                return $this->redirect(["action" => "discountCodeList"]);
            }
        }

        /** End here * */
        if($this->DiscountCode->delete($row)){
            $this->Flash->success(__("Success! Record Deleted Successfully Updated."));
            return $this->redirect(["action"=>"discountCodeList"]); 
        } 		
    }

    public function isAuthorized($user){
        return parent::isAuthorizedCustom($user);
    }
}
