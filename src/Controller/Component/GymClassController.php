<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

Class GymClassController extends AppController
{
	public function initialize()
	{
			parent::initialize();
                        $this->loadComponent("GYMFunction");
	}
		
	public function ClassesList()
	{ 
		// var_dump($this->request->session()->read("Config.username"));
		$session = $this->request->session()->read("User");
                switch($session["role_name"]){
                CASE "administrator" :
                        $data = $this->GymClass->find("all")->contain(['GymMember'])->hydrate(false)->toArray();
                break;

                CASE "franchise" :
                        $data = $this->GymClass->find("all")->contain(['GymMember'])->where(["GymClass.created_by"=>$session["id"]])->hydrate(false)->toArray();
                break;

                CASE "staff_member" :
                        $data = $this->GymClass->find("all")->where(["OR"=>[["notice_for"=>"staff_member"],["notice_for"=>"all"]]])->hydrate(false)->toArray();
                break;
		
              }
		$this->set("data",$data);
	}
	
	public function addClasses()
	{	
                $session = $this->request->session()->read("User");
                $this->set("classes",null);	
		$this->set("edit",false);
		$this->set("title",__("Add Class"));
                $classtype = $this->GymClass->ClassType->find("list",["keyField"=>"id","valueField"=>"title"]);		
		$classtype = $classtype->toArray();
                $this->set('classtype',$classtype);
		if($this->request->is("post"))
		{
                   
			
			$group = $this->GymClass->newEntity();
			$new_name = $this->GYMFunction->uploadImage($this->request->data["image"]);
			$this->request->data["image"] =  $new_name;
			$this->request->data["created_by"] = $session["id"];
                        $this->request->data["updated_by"] = $session["id"];
                        $this->request->data["created_date"] = date("Y-m-d H:i:s");
                        $this->request->data["updated_date"] = date("Y-m-d H:i:s");			
			$group = $this->GymClass->patchEntity($group,$this->request->data);
			
			if($this->GymClass->save($group))
			{
				$this->Flash->Success(__("Success! Class Added Successfully."));
				return $this->redirect(["action"=>"classesList"]);
			}			
		}
	}

	public function editClasses($id){
		$this->set("classes",null);	
                $session = $this->request->session()->read("User");
                $this->set("title",__("Edit Class"));
                $classtype = $this->GymClass->ClassType->find("list",["keyField"=>"id","valueField"=>"title"]);		
		$classtype = $classtype->toArray();
                $this->set('classtype',$classtype);
		$row1 = $this->GymClass->get($id);
		$row = $row1->toArray();		
		$this->set("edit",true);
		$this->set("data",$row);
		$this->render("addClasses");
		if($this->request->is("post"))
		{
			$this->request->data["updated_by"] = $session["id"];
                        $this->request->data["updated_date"] = date("Y-m-d H:i:s");
                        
			if(!empty($this->request->data["image"]['name']))
			{
				$new_name = $this->GYMFunction->uploadImage($this->request->data["image"]);
				$this->request->data["image"] =  $new_name;
			}else{
				$this->request->data["image"] = $row['image'];
			}
			$group = $this->GymClass->patchEntity($row1,$this->request->data);
			if($this->GymClass->save($group))
			{
				$this->Flash->success(__("Success! Record Updated Successfully"));
				return $this->redirect(["action"=>"classesList"]);
			}
		}
	}	
	
	public function deleteClasses($id = null)
	{
		if($id != null)
		{
			$row = $this->GymClass->get($id);
			if($this->GymClass->delete($row))
			{
				$this->Flash->success(__("Success! Record Deleted Successfully"));
				return $this->redirect(["action"=>"classesList"]);
			}
		}
	}
	
	public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}

}