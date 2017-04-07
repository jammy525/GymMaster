<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Database\Expression\IdentifierExpression;
// use GoogleCharts;

Class GymMemberController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		/* $this->loadComponent('Csrf'); */
		$this->loadComponent("GYMFunction");
		require_once(ROOT . DS .'vendor' . DS  . 'chart' . DS . 'GoogleCharts.class.php');
		$session = $this->request->session()->read("User");
		$this->set("session",$session);		
	}
        
        private function crypto_rand_secure($min, $max) {
            $range = $max - $min;
            if ($range < 1)
                return $min; // not so random...
            $log = ceil(log($range, 2));
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            } while ($rnd > $range);
            return $min + $rnd;
        }

        private function getToken($user_id,$length) {
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet); // edited

            for ($i = 0; $i < $length; $i++) {
                $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
            }

            //$referralCode = $this->GymMember->ReferralCode->find()->where(["code"=>$token])->first();
            //if(count($referralCode) > 0){
                //return $this->getToken($length);
            //}
            return $user_id.$token;
        }
	
	public function memberList()
	{
		$session = $this->request->session()->read("User");
		if($session["role_name"] == "administrator")
		{
			/* $data = $this->GymMember->find("all")->where(["OR"=>[["role_name"=>"member"],["role_name"=>"administrator"]]])->hydrate(false)->toArray(); */
			$data = $this->GymMember->find("all")
                                ->contain(['UnsubscribedMember'])
                                ->where(["role_name"=>"member"])->hydrate(false)->toArray();
		}
		else if($session["role_name"] == "member"){
			$uid = intval($session["id"]);
			if($this->GYMFunction->getSettings("member_can_view_other"))
			{
				$data = $this->GymMember->find("all")
                                        ->contain(['UnsubscribedMember'])
                                        ->where(["role_name"=>"member"])->hydrate(false)->toArray();
			}else{
				$data = $this->GymMember->find("all")
                                        ->contain(['UnsubscribedMember'])
                                        ->where(["id"=>$uid])->hydrate(false)->toArray();
			}
			
		}
		else if($session["role_name"] == "staff_member"){
			$uid = intval($session["id"]);
			if($this->GYMFunction->getSettings("staff_can_view_own_member"))
			{
				$data = $this->GymMember->find("all")
                                        ->contain(['UnsubscribedMember'])
                                        ->where(["assign_staff_mem"=>$uid])->hydrate(false)->toArray();
			}else{
				$data = $this->GymMember->find("all")
                                        ->contain(['UnsubscribedMember'])
                                        ->where(["role_name"=>"member"])->hydrate(false)->toArray();
			}
		}else if($session["role_name"] == "licensee")
		{       $uid = intval($session["id"]);
			/* $data = $this->GymMember->find("all")->where(["OR"=>[["role_name"=>"member"],["role_name"=>"administrator"]]])->hydrate(false)->toArray(); */
			$data = $this->GymMember->find("all")
                                ->contain(['UnsubscribedMember'])
                                ->where(["associated_licensee"=>$uid,"role_name"=>"member"])
                                ->hydrate(false)->toArray();
		}
		else{
			$data = $this->GymMember->find("all")
                                ->contain(['UnsubscribedMember'])
                                ->where(["role_name"=>"member"])->hydrate(false)->toArray();
		}
                //$this->GYMFunction->pre($data);
				
		$this->set("data",$data);	
	}
	
	public function addMember(){	
            $this->set("edit",false);
            $this->set("title",__("Add Member"));

            $lastid = $this->GymMember->find("all",["fields"=>"id"])->last();
            $lastid = ($lastid != null) ? $lastid->id + 1 : 01 ;
            $session = $this->request->session()->read("User");
            $member = $this->GymMember->newEntity();
            $m = date("d");
            $y = date("y");
            $prefix = "M".$lastid;
            $member_id = $prefix.$m.$y;

            $this->set("member_id",$member_id);

            $staff = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);
            $staff = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
            
            $licensee = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"licensee"]);
            $licensee = $licensee->select(["id","name"=>$licensee->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();

            $referrer_by = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_id !="=>"1"]);
            $referrer_by = $referrer_by->select(["id","name"=>$referrer_by->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();

            $classes = $this->GymMember->GymClass->find("list",["keyField"=>"id","valueField"=>"name"]);

            $groups = $this->GymMember->GymGroup->find("list",["keyField"=>"id","valueField"=>"name"]);
            $interest = $this->GymMember->GymInterestArea->find("list",["keyField"=>"id","valueField"=>"interest"]);
            $source = $this->GymMember->GymSource->find("list",["keyField"=>"id","valueField"=>"source_name"]);
            //$membership = $this->GymMember->Membership->find("list",["keyField"=>"id","valueField"=>"membership_label"]);
            $memCats = $this->GymMember->Category->find('all')->hydrate(false)->toArray();
            foreach($memCats as $memCat){
                $membership[$memCat['name']] = $this->GymMember->Membership->find("list", ["keyField" => "id", "valueField" => "membership_label"])->where(['membership_cat_id'=>$memCat['id']])->hydrate(false)->toArray();
            }
            $this->set("staff",$staff);
            $this->set("classes",$classes);
            $this->set("groups",$groups);
            $this->set("interest",$interest);
            $this->set("source",$source);
            $this->set("membership",$membership);
            $this->set("referrer_by",$referrer_by);
            $this->set("licensee",$licensee);

            if($this->request->is("post"))
            {
                $plainPassword = $this->request->data['password']; // send into mail
                
                $this->request->data['role_id'] = 4;
                $this->request->data['alert_sent'] = 1;
                //$this->request->data['assign_staff_mem'] = '';
                //$this->request->data['role_id'] = 4;

                $this->request->data['member_id'] = $member_id;
                $this->request->data['created_by']=$session["id"];  
                //$this->request->data['assign_group']=0;
                $image = $this->GYMFunction->uploadImage($this->request->data['image']);
                $this->request->data['image'] = (!empty($image)) ? $image : "profile-placeholder.png";
                $this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
                $this->request->data['inquiry_date'] = date("Y-m-d",strtotime($this->request->data['inquiry_date']));
                $this->request->data['trial_end_date'] = date("Y-m-d",strtotime($this->request->data['trial_end_date']));
                if(isset($this->request->data['membership_valid_from'])){
                    $this->request->data['membership_valid_from'] = date("Y-m-d",strtotime($this->request->data['membership_valid_from']));

                }
                if(isset($this->request->data['membership_valid_to'])){
                    $this->request->data['membership_valid_to'] = date("Y-m-d",strtotime($this->request->data['membership_valid_to']));
                }
                $this->request->data['first_pay_date'] = date("Y-m-d",strtotime($this->request->data['first_pay_date']));
                $this->request->data['created_date'] = date("Y-m-d");
                $this->request->data['assign_group'] = json_encode($this->request->data['assign_group']);
                switch($this->request->data['member_type']){
                    CASE "Member":
                            $this->request->data['membership_status'] = "Continue";
                    break;
                    CASE "Prospect":
                            $this->request->data['membership_status'] = "Not Available";
                    break;
                    CASE "Alumni":
                            $this->request->data['membership_status'] = "Expired";
                    break;

                }
                $this->request->data["role_name"]="member";
                $this->request->data["activated"]= 1;
                $member = $this->GymMember->patchEntity($member,$this->request->data);

                if($saveResult = $this->GymMember->save($member)){
                    //echo '<pre>',$saveResult['id'];die;
                    $this->request->data['member_id'] = $member->id;
                    $this->GYMFunction->add_membership_history($this->request->data);
                    // Referral Code Generation 
                    $referralCode = $this->GymMember->ReferralCode->newEntity();
                    $referralCodeArray['user_id'] = $saveResult['id'];
                    $referralCodeArray['code'] = $this->getToken($saveResult['id'],8);
                    $referralCode = $this->GymMember->ReferralCode->patchEntity($referralCode,$referralCodeArray);
                    
                    if($this->addPaymentHistory($this->request->data) && $this->GymMember->ReferralCode->save($referralCode)){
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
                        $associated_licensee = $this->GYMFunction->get_user_detail($saveResult['associated_licensee']);
                        $mailArrAdmin = [
                            "template"=>"registration_admin_mail",
                            "subject"=>"GoTribe : User Registered",
                            "emailFormat"=>"html",
                            "to"=>$associated_licensee['email'],
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
                                    'adminName'=>$associated_licensee['first_name'] . ' ' . $associated_licensee['last_name'],
                                ]
                        ];
                        if($this->GYMFunction->sendEmail($mailArrUser) && $this->GYMFunction->sendEmail($mailArrAdmin)){
                            $this->Flash->success(__("Success! Record Saved Successfully."));
                        }
                    }

                    //foreach($this->request->data["assign_class"] as $class)
                    //{
                            //$new_row = $this->GymMember->GymMemberClass->newEntity();
                            //$data = array();
                            //$data["member_id"] = $member->id;
                            //$data["assign_class"] = $class;
                            //$new_row = $this->GymMember->GymMemberClass->patchEntity($new_row,$data);
                            //$this->GymMember->GymMemberClass->save($new_row);
                    //}
                }else{				
                    if($member->errors()){	
                        foreach($member->errors() as $error){
                            foreach($error as $key=>$value){
                                $this->Flash->error(__($value));
                            }						
                        }
                    }
                }	
                return $this->redirect(["action"=>"memberList"]);
            }		
	}
	
	
	public function addPaymentHistory($data)
	{
		$row = $this->GymMember->MembershipPayment->newEntity();
		$save["member_id"] = $data["member_id"];
		$save["membership_id"] = $data["selected_membership"];
		$save["membership_amount"] = $this->GYMFunction->get_membership_amount($data["selected_membership"]);
		$save["paid_amount"] = 0;
		$save["start_date"] = $data["membership_valid_from"];
		$save["end_date"] = $data["membership_valid_to"];
		$save["membership_status"] = $data["membership_status"];
		$save["payment_status"] = 0;
		$save["created_date"] = date("Y-m-d");
		$save["created_dby"] = 1;
		$row = $this->GymMember->MembershipPayment->patchEntity($row,$save);
		if($this->GymMember->MembershipPayment->save($row))
		{return true;}else{return false;}
	}
	
	public function editMember($id)
	{
		$this->set("edit",true);
		$this->set("title",__("Edit Member"));
		$this->set("eid",$id);
		
		$session = $this->request->session()->read("User");
		$data = $this->GymMember->get($id)->toArray();
		
		$membership_classes = $this->GymMember->Membership->find()->where(["id"=>$data['selected_membership']])->select(["membership_class"])->hydrate(false)->toArray();		
			
		// $membership_classes = (json_decode($membership_classes[0]["membership_class"])); /*ERROR IN NEW PHP 5.7 VERSION */
		/* if(!empty($membership_classes)) FOR PHP 5.7 But NOT WORKNIG*/
		if(!empty($membership_classes)){
			$membership_classes = $membership_classes[0]["membership_class"];
			$membership_classes = str_ireplace(array("[","]","'"),"",$membership_classes);
			$membership_classes = explode(",",$membership_classes);	
			$classes = $this->GymMember->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"])->where(["id IN"=>$membership_classes])->toArray();

		}
		else{
			//$classes = array();
                    $classes = $this->GymMember->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"]);
		}
                
		/*if(!empty($membership_classes)) 
		{
			$classes = $this->GymMember->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"])->where(["id IN"=>$membership_classes])->toArray();
		}else{
			$classes = array();
		} */
				
		$member_classes = $this->GymMember->GymMemberClass->find()->where(["member_id"=>$id])->select(["assign_class"])->hydrate(false)->toArray();
		$mem_classes = array();
		foreach($member_classes as $mc)
		{
			$mem_classes[] = $mc["assign_class"];
		}
		
		$this->set("member_class",$mem_classes);
		if($session["id"] != $data["created_by"] && $session["role_name"] == 'licensee')
		{
			echo $this->Flash->error("No sneaking around! ;( ");
			return $this->redirect(["action"=>"memberList"]);			
		}
	
		$this->set("data",$data);		
		$staff = $this->GymMember->find("list",["keyField"=>"id","valueField"=>["name"]])->where(["role_name"=>"staff_member"]);
		$staff = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
		 $licensee = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"licensee"]);
            $licensee = $licensee->select(["id","name"=>$licensee->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();

		$groups = $this->GymMember->GymGroup->find("list",["keyField"=>"id","valueField"=>"name"]);
		$interest = $this->GymMember->GymInterestArea->find("list",["keyField"=>"id","valueField"=>"interest"]);
		$source = $this->GymMember->GymSource->find("list",["keyField"=>"id","valueField"=>"source_name"]);
		//$membership = $this->GymMember->Membership->find("list",["keyField"=>"id","valueField"=>"membership_label"]);
                $memCats = $this->GymMember->Category->find('all')->hydrate(false)->toArray();
                foreach($memCats as $memCat){
                    $membership[$memCat['name']] = $this->GymMember->Membership->find("list", ["keyField" => "id", "valueField" => "membership_label"])->where(['membership_cat_id'=>$memCat['id']])->hydrate(false)->toArray();
                }
		$this->set("staff",$staff);
		$this->set("classes",$classes);
		$this->set("groups",$groups);
		$this->set("interest",$interest);
		$this->set("source",$source);
		$this->set("membership",$membership);
		$this->set("referrer_by",$staff);
                 $this->set("licensee",$licensee);
				
		$this->render("addMember");		

		if($this->request->is("post"))
		{
			$row = $this->GymMember->get($id);			
			$image = $this->GYMFunction->uploadImage($this->request->data['image']);
			if($image != "")
			{
				$this->request->data['image'] = $image;
			}else{
				unset($this->request->data['image']);
			}
                        
			/* $this->request->data['image'] = $image ; */
			$this->request->data['birth_date'] = date("Y-m-d",strtotime($this->request->data['birth_date']));
			$this->request->data['inquiry_date'] = date("Y-m-d",strtotime($this->request->data['inquiry_date']));
			$this->request->data['trial_end_date'] = date("Y-m-d",strtotime($this->request->data['trial_end_date']));
			if(isset($this->request->data['membership_valid_from']))
			{
				$this->request->data['membership_valid_from'] = date("Y-m-d",strtotime($this->request->data['membership_valid_from']));
			}
			if(isset($this->request->data['membership_valid_to']))
			{
				$this->request->data['membership_valid_to'] = date("Y-m-d",strtotime($this->request->data['membership_valid_to']));
			}
			$this->request->data['first_pay_date'] = date("Y-m-d",strtotime($this->request->data['first_pay_date']));
			$this->request->data['assign_group'] = json_encode($this->request->data['assign_group']);
			// $this->request->data['assign_group']=0;
                         $this->request->data['created_by']=$session["id"];
                         
			$update = $this->GymMember->patchEntity($row,$this->request->data);
			if($this->GymMember->save($update))
			{
				$this->Flash->success(__("Success! Record Saved Successfully."));
				//$this->GymMember->GymMemberClass->deleteAll(["member_id"=>$id]);
				/*foreach($this->request->data["assign_class"] as $class)
				{
					$data = array();
					$new_row = $this->GymMember->GymMemberClass->newEntity();
					$data["member_id"] = $id;
					$data["assign_class"] = $class;
					$new_row = $this->GymMember->GymMemberClass->patchEntity($new_row,$data);
					$this->GymMember->GymMemberClass->save($new_row);
				}*/
				return $this->redirect(["action"=>"memberList"]);
			}
			else
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
	
	public function deleteMember($id)
	{
	      
              $session = $this->request->session()->read("User");
              $row = $this->GymMember->get($id);
                
                if($session["id"] != $row["created_by"] && $session["role_name"] == 'licensee')
		{
			echo $this->Flash->error("No sneaking around! ;( ");
			return $this->redirect(["action"=>"memberList"]);			
		}
                
		if($this->GymMember->delete($row))
		{
			$this->Flash->success(__("Success! Record Deleted Successfully."));
			return $this->redirect($this->referer());
		}		
	}
	
	public function viewMember($id)
	{
		$weight_data["data"] = $this->GYMFunction->generate_chart("Weight",$id);
		$weight_data["option"] = $this->GYMFunction->report_option("Weight");
		$this->set("weight_data",$weight_data);
		
		$height_data["data"] = $this->GYMFunction->generate_chart("Height",$id);
		$height_data["option"] = $this->GYMFunction->report_option("Height");
		$this->set("height_data",$height_data);		
		
		$thigh_data["data"] = $this->GYMFunction->generate_chart("Thigh",$id);
		$thigh_data["option"] = $this->GYMFunction->report_option("Thigh");
		$this->set("thigh_data",$thigh_data);
		
		$chest_data["data"] = $this->GYMFunction->generate_chart("Chest",$id);
		$chest_data["option"] = $this->GYMFunction->report_option("Chest");
		$this->set("chest_data",$chest_data);
		
		$waist_data["data"] = $this->GYMFunction->generate_chart("Waist",$id);
		$waist_data["option"] = $this->GYMFunction->report_option("Waist");
		$this->set("waist_data",$waist_data);
		
		$arms_data["data"] = $this->GYMFunction->generate_chart("Arms",$id);
		$arms_data["option"] = $this->GYMFunction->report_option("Arms");
		$this->set("arms_data",$arms_data);
		
		$fat_data["data"] = $this->GYMFunction->generate_chart("Fat",$id);
		$fat_data["option"] = $this->GYMFunction->report_option("Fat");
		$this->set("fat_data",$fat_data);

		$photos = $this->GymMember->GymMeasurement->find()->where(["user_id"=>$id])->select(["image"])->hydrate(false)->toArray();
		$this->set("photos",$photos);
		
		$history = $this->GymMember->MembershipPayment->find()->contain(["Membership"])->where(["MembershipPayment.member_id"=>$id])->hydrate(false)->toArray();
		// $history = $this->GymMember->MembershipHistory->find()->contain(["Membership"])->where(["MembershipHistory.member_id"=>$id])->hydrate(false)->toArray();
		$this->set("history",$history);
		
		##########################################
		//// $data = $this->GymMember->find()->where(["GymMember.id"=>$id])->contain(['Membership','GymInterestArea','StaffMembers','ClassSchedule'])->select(["Membership.membership_label","GymInterestArea.interest","StaffMembers.first_name","StaffMembers.last_name","ClassSchedule.class_name"])->select($this->GymMember)->hydrate(false)->toArray();
		// $data = $this->GymMember->find()->where(["GymMember.id"=>$id])->contain(['Membership','GymInterestArea','ClassSchedule'])->select(["Membership.membership_label","GymInterestArea.interest","ClassSchedule.class_name"])->select($this->GymMember)->hydrate(false)->toArray();
		$data = $this->GymMember->find()->where(["GymMember.id"=>$id])->contain(['Membership','GymInterestArea'])->select(["Membership.membership_label","GymInterestArea.interest"])->select($this->GymMember)->hydrate(false)->toArray();
		// var_dump($data);die;
		$this->set("data",$data[0]);		
	}
	
	public function viewAttendance()
	{	
		$this->set("view",false);	
		if($this->request->is("post"))
		{ 			
			$uid = $this->request->params["pass"][0];			
			/* $uid = $this->request->data["uid"];  */
			$s_date = date("Y-m-d",strtotime($this->request->data["sdate"]));
			$e_date = date("Y-m-d",strtotime($this->request->data["edate"]));			
		
			// $data = $this->GymMember->GymAttendance->find("all")->where(function($exp){
				// return $exp
						// ->eq("user_id",$uid)
						// ->gte("attendance_date",$s_date)
						// ->lte("attendance_date",$e_date);
			// })->hydrate(false)->toArray();
			
			$conditions = array(
						'conditions' => array(
						'and' => array(
										array('attendance_date <=' => $e_date,
											  'attendance_date >=' => $s_date
											 ),							
							'user_id' => $uid
							)));
			$data = $this->GymMember->GymAttendance->find('all', $conditions)->hydrate(false)->toArray();
			
			$this->set("data",$data);
			$this->set("s_date",$s_date);
			$this->set("e_date",$e_date);
			$this->set("view",true);
			// var_dump($data);die;
		}
	}
	
	public function activateMember($aid)
	{
            $this->autoRender = false;
            $row = $this->GymMember->get($aid);
            $row->activated = 1;
            if($this->GymMember->save($row))
            {
                    $this->Flash->success(__("Success! Member activated successfully."));
                    return $this->redirect(["action"=>"memberList"]);
            }
	}
        public function assignMember($mid)
        {
               $this->set("edit",true);
	       $this->set("title",__("Assign Class"));
               $members = array();
               $session = $this->request->session()->read("User");
               
               if($session["role_name"] == "staff_member")
		{
			$members = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"member","assign_staff_mem"=>$session["id"],"id"=>$mid]);
			$members = $members->select(["id","name"=>$members->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
			
		}
                else if($session["role_name"] == "licensee")
                {
                        $members = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"member","created_by"=>$session["id"],"id"=>$mid]);
			$members = $members->select(["id","name"=>$members->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
		
                }
		else{
			$members = $this->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"member","member_type"=>"Member","id"=>$mid]);
			$members = $members->select(["id","name"=>$members->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])])->hydrate(false)->toArray();
		}
                if ($session["role_name"] == 'administrator') {
                    $classes = $this->GymMember->GymClass->find("list", ["keyField" => "id", "valueField" => "name"]);
                      } else {
                    $classes = $this->GymMember->GymClass->find("list", ["keyField" => "id", "valueField" => "name"])->where(["GymClass.created_by" => $session["id"]])->orWhere(['GymClass.role_name' => 'administrator']);
                }
             
                $this->set("classes",$classes);
		$this->set("members",$members);
                /// 
                $member_classes = $this->GymMember->GymMemberClass->find()->where(["member_id"=>$mid])->select(["assign_schedule"])->hydrate(false)->toArray();
		$mem_classes = array();
		foreach($member_classes as $mc)
		{
			$mem_classes[] = $mc["assign_schedule"];
		}
		
		$this->set("member_class",$mem_classes);
                
                $member_data = $this->GymMember->find()->where(["GymMember.id"=>$mid])->contain(['Membership','GymInterestArea'])->select(["Membership.membership_label","Membership.membership_class","GymInterestArea.interest"])->select($this->GymMember)->hydrate(false)->toArray();
		$this->set("member_data",$member_data[0]);
                $membership_classes = json_decode($member_data[0]['membership']["membership_class"]);
                /*if(!empty($membership_classes)) 
		{
			$membership_classes = $member_data[0]['membership']["membership_class"];
			$membership_classes = str_ireplace(array("[","]","'"),"",$membership_classes);
			$membership_classes = explode(",",$membership_classes);	
			
                 }*/
                // echo "<pre>";print_r($membership_classes);
                 $this->set("membership_classes",$membership_classes);
                 $schedule_list = $this->GymMember->ClassSchedule->find()->contain(['ClassScheduleList'])->select(["ClassSchedule.class_name","ClassSchedule.id"])->hydrate(false)->toArray();
                 $this->set("schedule_list",$schedule_list);
                
                 if($this->request->is("post"))
		 {
                        if(empty($this->request->data["assign_class"]))
                        {
                            echo $this->Flash->error("Please assign class or add class in your membership plan! ;( ");
                            return $this->redirect($this->referer());
                        }
                               $this->GymMember->GymMemberClass->deleteAll(["member_id"=>$mid]);
                                foreach($this->request->data["assign_class"] as $assign_data)
				{
                                   
                                        $newdata=explode('-',$assign_data);
                                        $data = array();
					$new_row = $this->GymMember->GymMemberClass->newEntity();
					$data["member_id"] = $mid;
					$data["assign_class"] =  $newdata[0];
                                        $data["assign_schedule"] =  $newdata[1];
					$new_row = $this->GymMember->GymMemberClass->patchEntity($new_row,$data);
					$this->GymMember->GymMemberClass->save($new_row);
				}
                      $this->Flash->success(__("Success! Member class assign successfully."));
                       return $this->redirect($this->referer());
                 }
        }
	
        
        public function unsubscribe($user_id){
            $session = $this->request->session()->read("User");
            $row = $this->GymMember->UnsubscribedMember->newEntity();
            $row_update_array['mem_id'] = $user_id;
            $row_update_array['unsubscribed_by'] = $session['id'];
            $row_update_array['reason'] = 'test reason';
            $row_update_array['unsubscribed_status'] = 1;
            
            $row = $this->GymMember->UnsubscribedMember->patchEntity($row, $row_update_array);
            if ($this->GymMember->UnsubscribedMember->save($row)) {
                $this->Flash->success(__("Success! Plan unsubscribed."));
                return $this->redirect(["action" => "memberList"]);
            }
	}
        
	
	/*
	public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$members_actions = ["viewMember","memberList","viewAttendance"];
		$staff_acc_actions = ["memberList","viewMember","viewAttendance"];
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
         * */
        
        
        
        public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}

}
