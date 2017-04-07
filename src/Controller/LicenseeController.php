<?php
namespace App\Controller;
use Cake\App\Controller;
use Cake\ORM\TableRegistry;
class LicenseeController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent("GYMFunction");	
	}
	
	public function licenseeList()
	{ 	
            $data = $this->Licensee->GymMember->find()->contain(['GymLocation'])->where(["GymMember.role_name"=>"licensee"])->select(['GymLocation.location'])->select($this->Licensee->GymMember)->hydrate(false)->toArray();
            $this->set("data",$data);
	}
	
	public function addLicensee(){
            $this->set("edit",false);
            $this->set("title",__("Add Licensee"));

            //$roles = $this->Licensee->GymMember->GymRoles->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            //$this->set("roles",$roles);
            
            $location = $this->Licensee->GymMember->GymLocation
                    ->find("list",["keyField"=>"id","valueField"=>"location"])
                    ->where(['status'=>1])
                    ->hydrate(false)->toArray();
            
            $this->set("location",$location);

            //$specialization = $this->Licensee->GymMember->Specialization->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            //$this->set("specialization",$specialization);		

            if($this->request->is("post")){
                
                $plainPassword = $this->request->data['password'];
                // Active User
                $session = $this->request->session()->read("User");
                
                $licensee = $this->Licensee->GymMember->newEntity();

                $image = $this->GYMFunction->uploadImage($this->request->data['image']);
                $this->request->data['image'] = (!empty($image)) ? $image : "profile-placeholder.png";
                $this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
                $this->request->data['created_date'] = date("Y-m-d");
                $this->request->data["activated"]= 1;
                $this->request->data["created_by"]= $session['id'];
                $this->request->data["alert_sent"]= 1;
                $this->request->data["role_name"]= 'licensee';
                $this->request->data["role_id"]= 2;
                $this->request->data["alert_sent"]= 1;
                 
                
                //$row = $this->Licensee->GymMember->newEntity();	
                $licensee = $this->Licensee->GymMember->patchEntity($licensee,$this->request->data);
                
                if($saveResult = $this->Licensee->GymMember->save($licensee)){
                    $mailArrUser = [
                        "template"=>"registration_user_mail",
                        "subject"=>"GoTribe : Registration Confirmation",
                        "emailFormat"=>"html",
                        "to"=>$saveResult['email'],
                        "addTo"=>"jameel.ahmad@rnf.tech",
                        "cc"=>"imran.khan@rnf.tech",
                        "addCc"=>"jameel.ahmad@rnf.tech",
                        "bcc"=>"jameel.ahmad@rnf.tech",
                        "addBcc"=>"jameel.ahmad@rnf.tech",
                        "viewVars"=>[
                                'name'=>$saveResult['first_name'] . ' ' . $saveResult['last_name'],
                                'email'=>$saveResult['email'],
                                'username'=>$saveResult['username'],
                                'password'=>$plainPassword
                            ]
                    ];
                    $mailArrAdmin = [
                        "template"=>"registration_admin_mail",
                        "subject"=>"GoTribe : User Registered",
                        "emailFormat"=>"html",
                        "to"=>$this->GYMFunction->getSettings('email'),
                        "addTo"=>"jameel.ahmad@rnf.tech",
                        "cc"=>"imran.khan@rnf.tech",
                        "addCc"=>"jameel.ahmad@rnf.tech",
                        "bcc"=>"jameel.ahmad@rnf.tech",
                        "addBcc"=>"jameel.ahmad@rnf.tech",
                        "viewVars"=>[
                                'name'=>$saveResult['first_name'] . ' ' . $saveResult['last_name'],
                                'email'=>$saveResult['email'],
                                'username'=>$saveResult['username'],
                                'password'=>$plainPassword,
                                'adminName'=>$this->GYMFunction->getSettings('name'),
                            ]
                    ];
                    if($this->GYMFunction->sendEmail($mailArrUser) && $this->GYMFunction->sendEmail($mailArrAdmin)){
                        $this->Flash->success(__("Success! Record Successfully Saved."));
                        return $this->redirect(["action"=>"licenseeList"]);
                    }
                    
                }else{				
                    if($licensee->errors()){	
                        foreach($licensee->errors() as $error){
                            foreach($licensee as $key=>$value){
                                $this->Flash->error(__($value));
                            }						
                        }
                    }
                }
            }
	}
	
	public function editLicensee($id){
            $this->set("edit",true);
            $this->set("title",__("Edit Licensee"));

            $data = $this->Licensee->GymMember->get($id)->toArray();
            //$roles = $this->Licensee->GymMember->GymRoles->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            //$specialization = $this->Licensee->GymMember->Specialization->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
            $location = $this->Licensee->GymMember->GymLocation
                    ->find("list",["keyField"=>"id","valueField"=>"location"])
                    ->where(['status'=>1])
                    ->hydrate(false)->toArray();
            $this->set("location",$location);
            //$this->set("specialization",$specialization);
            //$this->set("roles",$roles);		
            $this->set("data",$data);
            $this->render("AddLicensee");

            if($this->request->is("post")){
                $row = $this->Licensee->GymMember->get($id);
                $this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
                //$this->request->data['s_specialization'] = json_encode($this->request->data['s_specialization']);
                $image = $this->GYMFunction->uploadImage($this->request->data['image']);
                if($image != ""){
                    $this->request->data['image'] = $image;
                }else{
                    unset($this->request->data['image']);
                }
                /* $this->request->data['image'] = (!empty($image)) ? $image : "logo.png";*/
                $update = $this->Licensee->GymMember->patchEntity($row,$this->request->data);
                if($this->Licensee->GymMember->save($update)){
                    $this->Flash->success(__("Success! Record Updated Successfully."));
                    return $this->redirect(["action"=>"licenseeList"]);
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
	
	public function deleteLicensee($id){
            $row = $this->Licensee->GymMember->get($id);
            if($this->Licensee->GymMember->delete($row)){
                $this->Flash->success(__("Success! Licensee Deleted Successfully."));
                return $this->redirect($this->referer());
            }
	}
        
	public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}
}
