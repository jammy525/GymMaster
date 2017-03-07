<?php
namespace App\Controller;
use Cake\App\Controller;
use Cake\ORM\TableRegistry;
class FranchiseController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent("GYMFunction");	
	}
	
	public function franchiseList()
	{ 	
            $data = $this->Franchise->GymMember->find()->contain(['GymLocation'])->where(["GymMember.role_name"=>"franchise"])->select(['GymLocation.location'])->select($this->Franchise->GymMember)->hydrate(false)->toArray();
            $this->set("data",$data);
	}
	
	public function addFranchise(){
            $this->set("edit",false);
            $this->set("title",__("Add Franchise"));

            //$roles = $this->Franchise->GymMember->GymRoles->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            //$this->set("roles",$roles);
            
            $location = $this->Franchise->GymMember->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"])->hydrate(false)->toArray();
            $this->set("location",$location);

            //$specialization = $this->Franchise->GymMember->Specialization->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            //$this->set("specialization",$specialization);		

            if($this->request->is("post")){
                // Active User
                $session = $this->request->session()->read("User");
                
                $franchise = $this->Franchise->GymMember->newEntity();

                $image = $this->GYMFunction->uploadImage($this->request->data['image']);
                $this->request->data['image'] = (!empty($image)) ? $image : "profile-placeholder.png";
                $this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
                $this->request->data['created_date'] = date("Y-m-d");
                $this->request->data["activated"]= 1;
                $this->request->data["created_by"]= $session['id'];
                $this->request->data["alert_sent"]= 1;
                $this->request->data["role_name"]= 'franchise';
                $this->request->data["role_id"]= 2;
                $this->request->data["alert_sent"]= 1;
                 
                
                //$row = $this->Franchise->GymMember->newEntity();	
                $franchise = $this->Franchise->GymMember->patchEntity($franchise,$this->request->data);
                
                if($this->Franchise->GymMember->save($franchise)){
                    $this->Flash->success(__("Success! Record Successfully Saved."));
                    return $this->redirect(["action"=>"franchiseList"]);
                }else{				
                    if($franchise->errors()){	
                        foreach($franchise->errors() as $error){
                            foreach($franchise as $key=>$value){
                                $this->Flash->error(__($value));
                            }						
                        }
                    }
                }
            }
	}
	
	public function editFranchise($id){
            $this->set("edit",true);
            $this->set("title",__("Edit Franchise"));

            $data = $this->Franchise->GymMember->get($id)->toArray();
            //$roles = $this->Franchise->GymMember->GymRoles->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            //$specialization = $this->Franchise->GymMember->Specialization->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            $location = $this->Franchise->GymMember->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"])->hydrate(false)->toArray();
            $this->set("location",$location);
            //$this->set("specialization",$specialization);
            //$this->set("roles",$roles);		
            $this->set("data",$data);
            $this->render("AddFranchise");

            if($this->request->is("post")){
                $row = $this->Franchise->GymMember->get($id);
                $this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
                //$this->request->data['s_specialization'] = json_encode($this->request->data['s_specialization']);
                $image = $this->GYMFunction->uploadImage($this->request->data['image']);
                if($image != ""){
                    $this->request->data['image'] = $image;
                }else{
                    unset($this->request->data['image']);
                }
                /* $this->request->data['image'] = (!empty($image)) ? $image : "logo.png";*/
                $update = $this->Franchise->GymMember->patchEntity($row,$this->request->data);
                if($this->Franchise->GymMember->save($update)){
                    $this->Flash->success(__("Success! Record Updated Successfully."));
                    return $this->redirect(["action"=>"franchiseList"]);
                }else{				
                    if($update->errors()){	
                        foreach($update->errors() as $error){

                            foreach($error as $key=>$value){
                                    $this->Flash->error(__($value));
                            }						
                        }
                    }
                }
            }
	}
	
	public function deleteFranchise($id){
            $row = $this->Franchise->GymMember->get($id);
            if($this->Franchise->GymMember->delete($row)){
                $this->Flash->success(__("Success! Franchise Deleted Successfully."));
                return $this->redirect($this->referer());
            }
	}
        
	public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}
}