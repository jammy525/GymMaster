<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

Class GymAccessRolesController extends AppController
{
	public function initialize()
	{
			parent::initialize();
	}
		
	public function AccessRolesList()
	{ 
		// var_dump($this->request->session()->read("Config.username"));
		$data = $this->GymAccessRoles->find("all")->hydrate(false)->toArray();
		$this->set("data",$data);
	}
	
	public function addAccessRoles()
	{		
		$this->set("edit",false);
		$this->set("title",__("Add Access Roles"));	
		if($this->request->is("post"))
		{
			$access_roles = $this->GymAccessRoles->newEntity();
			$this->request->data["slug"] = str_replace(' ', '_', strtolower($this->request->data["name"]));
			$this->request->data["created_date"] = date("Y-m-d");			
			$access_roles = $this->GymAccessRoles->patchEntity($access_roles,$this->request->data);
			
			if($this->GymAccessRoles->save($access_roles))
			{
				$this->Flash->Success(__("Success! Access Roles Added Successfully."));
				return $this->redirect(["action"=>"accessRolesList"]);
			}			
		}
	}

	public function editAccessRoles($id){
		$this->set("title",__("Edit Access Roles"));	
		$row1 = $this->GymAccessRoles->get($id);
		$row = $row1->toArray();		
		$this->set("edit",true);
		$this->set("data",$row);
		$this->render("addAccessRoles");
		if($this->request->is("post"))
		{
			//$this->request->data["slug"] = str_replace(' ', '_', strtolower($this->request->data["name"]));
			$access_roles = $this->GymAccessRoles->patchEntity($row1,$this->request->data);
			if($this->GymAccessRoles->save($access_roles))
			{
				$this->Flash->success(__("Success! Access Roles Updated Successfully"));
				return $this->redirect(["action"=>"accessRolesList"]);
			}
		}
	}	
	
	public function deleteAccessRoles($id = null)
	{
		if($id != null)
		{
			$row = $this->GymAccessRoles->get($id);
			if($this->GymAccessRoles->delete($row))
			{
				$this->Flash->success(__("Success! Access Roles Deleted Successfully"));
				return $this->redirect(["action"=>"accessRolesList"]);
			}
		}
	}
	
	public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}
}