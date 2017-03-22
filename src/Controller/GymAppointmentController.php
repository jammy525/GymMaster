<?php
namespace App\Controller;
// use App\Controller\AppController;

class GymAppointmentController extends AppController
{
	public function appointmentList()
    {
		$data = $this->GymAppointment->find()->contain(["GymClass"])->hydrate(false)->toArray();
		$this->set("data",$data);
    }
	
	public function addAppointment()
    {
		$session = $this->request->session()->read("User");
		$this->set("edit",false);
		$class_places = $this->GymAppointment->GymClass->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false);
		$this->set("class_places",$class_places);
		
		if($this->request->is("post"))
		{
			$row = $this->GymAppointment->newEntity();
			$this->request->data["created_by"] = $session["id"];
                        $this->request->data["class_id"] = $this->request->data["class_id"];
                        $this->request->data['days'] = json_encode($this->request->data['days']);
			$this->request->data["created_date"] = date("Y-m-d");
			$this->request->data["appointment_date"] = date("Y-m-d",strtotime($this->request->data["appointment_date"]));
                        $this->request->data["appointment_end_date"] = date("Y-m-d",strtotime($this->request->data["appointment_end_date"]));
			$this->request->data['start_time'] = $this->request->data['start_hrs'].":".$this->request->data['start_min'].":".$this->request->data['start_ampm'];
			$this->request->data['end_time'] = $this->request->data['end_hrs'].":".$this->request->data['end_min'].":".$this->request->data['end_ampm'];
			$row = $this->GymAppointment->patchEntity($row,$this->request->data);		
			if($this->GymAppointment->save($row))
			{
				$this->Flash->success(__("Success! Record Saved Successfully"));
				return $this->redirect(["action"=>"appointmentList"]);
			}
		}
    }
	 public function editAppointment($id)
    {
		$this->set("edit",true);
		$row = $this->GymAppointment->get($id);	
		$class_places = $this->GymAppointment->GymClass->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false);
		$this->set("class_places",$class_places);
		$row['start_hrs'] =  explode(":",$row['start_time'])[0];
		@$row['start_min'] =  explode(":",$row['start_time'])[1];
		@$row['start_ampm'] =  explode(":",$row['start_time'])[2];		
		$row['end_hrs'] =  explode(":",$row['end_time'])[0];
		$row['end_min'] =  explode(":",$row['end_time'])[1];
		$row['end_ampm'] =  explode(":",$row['end_time'])[2];
		
		$this->set("data",$row->toArray());
		$event_places = $this->GymAppointment->GYmClass->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false);
		$this->set("event_places",$event_places);
		$this->render("addAppointment");
		$row = "";
		if($this->request->is("post"))
		{
			$row = $this->GymAppointment->get($id);	
                        $this->request->data["class_id"] = $this->request->data["class_id"];
                        $this->request->data['days'] = json_encode($this->request->data['days']);
			$this->request->data["appointment_date"] = date("Y-m-d",strtotime($this->request->data["appointment_date"]));
                        $this->request->data["appointment_end_date"] = date("Y-m-d",strtotime($this->request->data["appointment_end_date"]));
			
			//$this->request->data["event_date"] = date("Y-m-d",strtotime($this->request->data["event_date"]));
			$this->request->data['start_time'] = $this->request->data['start_hrs'].":".$this->request->data['start_min'].":".$this->request->data['start_ampm'];
			$this->request->data['end_time'] = $this->request->data['end_hrs'].":".$this->request->data['end_min'].":".$this->request->data['end_ampm'];
			
			$row = $this->GymAppointment->patchEntity($row,$this->request->data);
			if($this->GymAppointment->save($row))
			{
				$this->Flash->success(__("Success! Record Saved Successfully"));
				return $this->redirect(["action"=>"appointmentList"]);
			}
			
		}
    }
	
	public function deleteAppointment($did)
    {
		$drow = $this->GymAppointment->get($did);
		if($this->GymAppointment->delete($drow))
		{
			$this->Flash->success(__("Success! Record Deleted Successfully"));
			return $this->redirect(["action"=>"appointmentList"]);
		}
    }
	
	
	public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$members_actions = ["appointmentList"];
		// $staff__acc_actions = ["productList","addProduct","editProduct"];
		switch($role_name)
		{			
			CASE "member":
				if(in_array($curr_action,$members_actions))
				{return true;}else{return false;}
			break;
			
			// CASE "staff_member":
				// if(in_array($curr_action,$staff__acc_actions))
				// {return true;}else{ return false;}
			// break;
			
			// CASE "accountant":
				// if(in_array($curr_action,$staff__acc_actions))
				// {return true;}else{return false;}
			// break;
		}		
		return parent::isAuthorized($user);
	}
}
