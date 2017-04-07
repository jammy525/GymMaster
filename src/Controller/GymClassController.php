<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

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

                CASE "licensee" :
                        $data = $this->GymClass->find("all")->contain(['GymMember'])->where(["GymClass.created_by"=>$session["id"]])->orWhere(['GymClass.role_name' => 'administrator'])->hydrate(false)->toArray();
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
                if($session["role_name"]=='administrator')
                {
                  $classtype = $this->GymClass->ClassType->find("list",["keyField"=>"id","valueField"=>"title"]);	   
                }else{
                   $classtype = $this->GymClass->ClassType->find("list",["keyField"=>"id","valueField"=>"title"])->where(["ClassType.created_by"=>$session["id"]])->orWhere(['ClassType.role_name' => 'administrator']); 
                }
               	
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
                         $this->request->data["role_name"]= $session["role_name"];
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
                if($session["role_name"]=='administrator')
                {
                  $classtype = $this->GymClass->ClassType->find("list",["keyField"=>"id","valueField"=>"title"]);	   
                }else{
                   $classtype = $this->GymClass->ClassType->find("list",["keyField"=>"id","valueField"=>"title"])->where(["ClassType.created_by"=>$session["id"]])->orWhere(['ClassType.role_name' => 'administrator']); 
                }	
		$classtype = $classtype->toArray();
                $this->set('classtype',$classtype);
		$row1 = $this->GymClass->get($id);
		$row = $row1->toArray();		
		$this->set("edit",true);
		$this->set("data",$row);
		$this->render("addClasses");
                /** Edit record checked roles permissions* */
                 if ($session["role_name"] == "licensee" || $session["role_name"] == "staff_member") {
                    if ($row['created_by'] != $session['id']) {
                        $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                        return $this->redirect(["action" => "classesList"]);
                    }
                }

            /** End here * */
            
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
              $session = $this->request->session()->read("User");
		if($id != null)
		{
			$row = $this->GymClass->get($id);
                        
                        /** Edit record checked roles permissions* */
                        if ($session["role_name"] == "licensee" || $session["role_name"] == "staff_member") {
                            if ($row['created_by'] != $session['id']) {
                                $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                                return $this->redirect(["action" => "classesList"]);
                            }
                        }

                        /** End here * */
                        
                        $conn = ConnectionManager::get('default');
                        $report_21 ="SELECT count(*) as newcount from `class_schedule` where class_name=$id";  
                        $report_21 = $conn->execute($report_21);
                        $report_21 = $report_21->fetchAll('assoc');
                        
                        if($report_21[0]['newcount']>0)
                        {
                            $this->Flash->error(__("Sorry! This class already have schedule."));
                            return $this->redirect(["action" => "classesList"]);
                        }
                        /****/
                      
        
			if($this->GymClass->delete($row))
			{
				$this->Flash->success(__("Success! Record Deleted Successfully"));
				return $this->redirect(["action"=>"classesList"]);
			}
		}
	}
	
	public function isAuthorized($user)
	{
		return parent::isAuthorizedCustom($user);
	}

}