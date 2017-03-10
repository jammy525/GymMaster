<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

Class GymGroupController extends AppController
{
	public function initialize()
	{
			parent::initialize();
	}
		
	public function GroupList()
	{ 
		// var_dump($this->request->session()->read("Config.username"));
		$data = $this->GymGroup->find("all")->hydrate(false)->toArray();
		$this->set("data",$data);
	}
	
	public function addGroup()
	{		
		$this->set("edit",false);
		$this->set("title",__("Add Group"));
                $session = $this->request->session()->read("User");	
		if($this->request->is("post"))
		{
			$this->loadComponent("GYMFunction");
			$group = $this->GymGroup->newEntity();
			$new_name = $this->GYMFunction->uploadImage($this->request->data["image"]);
			$this->request->data["image"] =  $new_name;
			$this->request->data["created_date"] = date("Y-m-d");
                        $this->request->data["created_by"] = $session["id"];			
			$group = $this->GymGroup->patchEntity($group,$this->request->data);
			
			if($this->GymGroup->save($group))
			{
				$this->Flash->Success(__("Success! Group Added Successfully."));
				return $this->redirect(["action"=>"groupList"]);
			}			
		}
	}

	public function editGroup($id){
		$this->set("title",__("Edit Group"));	
		$row1 = $this->GymGroup->get($id);
                $session = $this->request->session()->read("User");
		$row = $row1->toArray();		
		$this->set("edit",true);
		$this->set("data",$row);
		$this->render("addGroup");
		if($this->request->is("post"))
		{
			$this->loadComponent("GYMFunction");
			if(!empty($this->request->data["image"]['name']))
			{
				$new_name = $this->GYMFunction->uploadImage($this->request->data["image"]);
				$this->request->data["image"] =  $new_name;
			}else{
				$this->request->data["image"] = $row['image'];
			}
			$group = $this->GymGroup->patchEntity($row1,$this->request->data);
			if($this->GymGroup->save($group))
			{
				$this->Flash->success(__("Success! Record Updated Successfully"));
				return $this->redirect(["action"=>"groupList"]);
			}
		}
	}	
	
	public function deleteGroup($id = null)
	{
		if($id != null)
		{
			$row = $this->GymGroup->get($id);
			if($this->GymGroup->delete($row))
			{
				$this->Flash->success(__("Success! Record Deleted Successfully"));
				return $this->redirect(["action"=>"groupList"]);
			}
		}
	}
	
	public function isAuthorized($user)
	{
		$this->loadComponent("GYMFunction");
		$role_name = $user["role_name"];
		$controller = $this->request->controller;
		$curr_action = $this->request->action;
		$actions_list = $this->GYMFunction->getActionsByRoles($user["role_id"], $controller);
		switch($role_name)
		{			
			CASE $role_name:
				if(in_array($curr_action,$actions_list))
				{return true;}else{return false;}
			break;

		}
		return parent::isAuthorized($user);
	}

}
