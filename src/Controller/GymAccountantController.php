<?php
namespace App\Controller;
use Cake\App\Controller;

class GymAccountantController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent("GYMFunction");
	}
	
	public function accountantList()
	{		
		$data = $this->GymAccountant->GymMember->find("all")->where(["GymMember.role_name"=>"accountant"])->hydrate(false)->toArray();
		$this->set("data",$data);	
	}
	
	public function addAccountant()
	{
		$session = $this->request->session()->read("User");
		$this->set("edit",false);			
		$this->set("title",__("Add Accountant"));
		
		if($this->request->is("post"))
		{
		
                    $lastid = $this->GymAccountant->GymMember->find("all",["fields"=>"id"])->last();
                    $lastid = ($lastid != null) ? $lastid->id + 1 : 01 ;
                    $m = date("d");
                    $y = date("y");
                    $prefix = "A".$lastid;
                    $member_id = $prefix.$m.$y;
                    
                    $accountant = $this->GymAccountant->GymMember->newEntity();
			
			$image = $this->GYMFunction->uploadImage($this->request->data['image']);
			$this->request->data['image'] = (!empty($image)) ? $image : "profile-placeholder.png";
			$this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
			$this->request->data['created_date'] = date("Y-m-d");
			$this->request->data['created_by'] = $session["id"];
			$this->request->data['role_name'] = "accountant";
                        $this->request->data['role_id'] = 5;
                        $this->request->data['activated'] = 1;
                        $this->request->data['member_id'] = $member_id;
		
			$accountant = $this->GymAccountant->GymMember->patchEntity($accountant,$this->request->data);
			if($this->GymAccountant->GymMember->save($accountant))
			{
				$this->Flash->success(__("Success! Record Successfully Saved."));
				return $this->redirect(["action"=>"accountantList"]);
			}else
			{				
				if($accountant->errors())
				{	
					foreach($accountant->errors() as $error)
					{
						foreach($error as $key=>$value)
						{
							$this->Flash->error(__($value));
						}						
					}
				}
			}
		}
	}
	
	public function editAccountant($id)
	{
		$this->set("edit",true);
		$this->set("title",__("Edit Accountant"));
		
		$data = $this->GymAccountant->GymMember->get($id);			
		$this->set("data",$data->toArray());
		$this->render("addAccountant");
		
		if($this->request->is("post"))
		{
			$row = $this->GymAccountant->GymMember->get($id);
			$this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
			$image = $this->GYMFunction->uploadImage($this->request->data['image']);
			if($image != "")
			{
				$this->request->data['image'] = $image;
			}else{
				unset($this->request->data['image']);
			}			
			$update = $this->GymAccountant->GymMember->patchEntity($row,$this->request->data);
			if($this->GymAccountant->GymMember->save($update))
			{
				$this->Flash->success(__("Success! Record Updated Successfully."));
				return $this->redirect(["action"=>"accountantList"]);
			}else
			{				
				if($update->errors())
				{	
					foreach($update->errors() as $error)
					{
						foreach($error as $key=>$value)
						{
							$this->Flash->error(__($value));
						}						
					}
				}
			}
		}
	}
	
	public function deleteAccountant($id)
	{
		$row = $this->GymAccountant->GymMember->get($id);
		if($this->GymAccountant->GymMember->delete($row))
		{
			$this->Flash->success(__("Success! Accountant Deleted Successfully."));
			return $this->redirect($this->referer());
		}
	}
	
	public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}
}