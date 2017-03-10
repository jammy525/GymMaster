<?php
namespace App\Controller;
use App\Controller\AppController;

class ClassTypeController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent("GYMFunction");
	}
       
	
	public function classtypeList(){ 
            $session = $this->request->session()->read("User");
            switch($session["role_name"]){
                CASE "administrator" :
                        $data = $this->ClassType->find("all")->contain(['GymMember'])->hydrate(false)->toArray();
                break;

                CASE "licensee" :
                        $data = $this->ClassType->find("all")->contain(['GymMember'])->where(["ClassType.created_by"=>$session["id"]])->orWhere(['ClassType.role_name' => 'administrator'])->hydrate(false)->toArray();
                break;

                CASE "staff_member" :
                        $data = $this->ClassType->find("all")->where(["OR"=>[["notice_for"=>"staff_member"],["notice_for"=>"all"]]])->hydrate(false)->toArray();
                break;
		
            }
            
            $this->set("data",$data);
            
	}
        
	public function addclassType(){
            $session = $this->request->session()->read("User");
            $this->set("edit",false);
            $this->set("title",__("Add Class Type"));
            //$classes = $this->GymLocation->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"]);
            //$this->set("classes",$classes);

            if($this->request->is("post")){
                
             
                $row = $this->ClassType->newEntity();			
                //$this->request->data["start_date"] = date("Y-m-d",strtotime($this->request->data["start_date"]));		
                //$this->request->data["end_date"] = date("Y-m-d",strtotime($this->request->data["end_date"]));		
                //$this->request->data["created_by"] = $session["id"];	

                /*SANITIZATION*/
                //$this->request->data["comment"] = $this->GYMFunction->sanitize_string($this->request->data["comment"]);
                /*SANITIZATION*/
                $this->request->data["updated_by"] = $session["id"];
                $this->request->data["created_date"] = date("Y-m-d H:i:s");
                $this->request->data["updated_date"] = date("Y-m-d H:i:s");
                $this->request->data["role_name"]= $session["role_name"];
                 //$this->request->data["updated_by"] = $session["id"];
                
                $row = $this->ClassType->patchEntity($row,$this->request->data);
                if($this->ClassType->save($row)){				
                    $this->Flash->success(__("Success! Location Successfully Saved."));
                    return $this->redirect(["action"=>"classtypeList"]);			
                }else{
                    $this->Flash->error(__("Error! Location Not Saved.Please Try Again."));
                }
            }		
	}
        
	public function editclassType($pid){	
           
            $session = $this->request->session()->read("User");
            $this->set("edit",true);	
            $this->set("title",__("Edit Class Type"));
            $row = $this->ClassType->get($pid);
            $this->set("data",$row->toArray());

             /** Edit record checked roles permissions* */
            if ($session["role_name"] == "licensee" || $session["role_name"] == "staff_member") {
                if ($row['created_by'] != $session['id']) {
                    $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                    return $this->redirect(["action" => "classtypeList"]);
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
                 $this->request->data["updated_by"] = $session["id"];
                 $this->request->data["updated_date"] = date("Y-m-d H:i:s");
                
                $row = $this->ClassType->patchEntity($row,$this->request->data);
                if($this->ClassType->save($row)){
                    $this->Flash->success(__("Success! Record Successfully Updated."));
                    return $this->redirect(["action"=>"classtypeList"]);
                }else{
                    $this->Flash->error(__("Error! Record Not Updated.Please Try Again."));
                }
            }
            $this->render("addclassType");
	}
	
	public function deleteclassType($did)
	{
		
            $session = $this->request->session()->read("User");
            $row = $this->ClassType->get($did);
                
        /** Edit record checked roles permissions* */
      if ($session["role_name"] == "licensee" || $session["role_name"] == "staff_member") {
            if ($row['created_by'] != $session['id']) {
                $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                return $this->redirect(["action" => "classtypeList"]);
            }
        }

        /** End here * */
        if($this->ClassType->delete($row))
		{
			$this->Flash->success(__("Success! Record Deleted Successfully Updated."));
			return $this->redirect(["action"=>"classtypeList"]); 
		} 		
	}
	
	public function isAuthorized($user)
	{
		return parent::isAuthorizedCustom($user);
	}
}
