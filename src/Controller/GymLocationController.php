<?php
namespace App\Controller;
use App\Controller\AppController;

class GymLocationController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent("GYMFunction");
	}
	
	public function locationList(){ 
            $session = $this->request->session()->read("User");
            switch($session["role_name"]){
                CASE "administrator" :
                        $data = $this->GymLocation->find("all")->contain(['GymMember'])->hydrate(false)->toArray();
                break;

                CASE "franchise" :
                        $data = $this->GymLocation->find("all")->contain(['GymMember'])->where(["GymLocation.created_by"=>$session["id"]])->hydrate(false)->toArray();
                break;

                CASE "staff_member" :
                        $data = $this->GymLocation->find("all")->where(["OR"=>[["notice_for"=>"staff_member"],["notice_for"=>"all"]]])->hydrate(false)->toArray();
                break;

                /**
                    CASE "member" :
                            $class_ids = $this->GYMFunction->get_class_by_member($session["id"]);
                            if(!empty($class_ids))
                            {
                                    $data = $this->GymLocation->find("all")->where(["OR"=>[["class_id IN"=>$class_ids],["notice_for"=>"member"],["notice_for"=>"all"]]])->hydrate(false)->toArray();
                            }else{
                                    $data = $this->GymLocation->find("all")->where(["OR"=>[["notice_for"=>"member"],["notice_for"=>"all"]]])->hydrate(false)->toArray();
                            }
                    break;

                    CASE "accountant" : 
                            $data = $this->GymLocation->find("all")->where(["OR"=>[["notice_for"=>"accountant"],["notice_for"=>"all"]]])->hydrate(false)->toArray();
                    break;
                */			
            }
            
            $this->set("data",$data);
	}
        
	public function addLocation(){
            $session = $this->request->session()->read("User");
            $this->set("edit",false);
            $this->set("title",__("Add Location"));
            //$classes = $this->GymLocation->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"]);
            //$this->set("classes",$classes);

            if($this->request->is("post")){
                $row = $this->GymLocation->newEntity();			
                //$this->request->data["start_date"] = date("Y-m-d",strtotime($this->request->data["start_date"]));		
                //$this->request->data["end_date"] = date("Y-m-d",strtotime($this->request->data["end_date"]));		
                //$this->request->data["created_by"] = $session["id"];	

                /*SANITIZATION*/
                //$this->request->data["comment"] = $this->GYMFunction->sanitize_string($this->request->data["comment"]);
                /*SANITIZATION*/

                $row = $this->GymLocation->patchEntity($row,$this->request->data);
                if($this->GymLocation->save($row)){				
                    $this->Flash->success(__("Success! Location Successfully Saved."));
                    return $this->redirect(["action"=>"locationList"]);			
                }else{
                    $this->Flash->error(__("Error! Location Not Saved.Please Try Again."));
                }
            }		
	}
        
	public function editLocation($pid){	
            $this->set("edit",true);	
            $this->set("title",__("Edit Location"));
            $row = $this->GymLocation->get($pid);
            $this->set("data",$row->toArray());

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
		$row = $this->GymLocation->get($did);
		if($this->GymLocation->delete($row))
		{
			$this->Flash->success(__("Success! Record Deleted Successfully Updated."));
			return $this->redirect(["action"=>"locationList"]); 
		} 		
	}
	
	public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$members_actions = ["noticeList"];
		$staff_acc_actions = ["noticeList"];
		switch($role_name)
		{			
			CASE "member":
				if(in_array($curr_action,$members_actions))
				{return true;}else{return false;}
			break;
			
			CASE "staff_member":
				if(in_array($curr_action,$staff_acc_actions))
				{return true;}else{ return false;}
			break;
			
			CASE "accountant":
				if(in_array($curr_action,$staff_acc_actions))
				{return true;}else{return false;}
			break;
		}		
		return parent::isAuthorized($user);
	}
}
