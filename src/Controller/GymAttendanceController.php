<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use App\Model\Validation\GymAttendanceValidator;
class GymAttendanceController extends AppController
{
	public function attendance()
    {
		//$classes = $this->GymAttendance->ClassSchedule->find("list",["keyField"=>"id","valueField"=>"class_name"]);
		$classes = $this->GymAttendance->GymClass->find("list",["keyField"=>"id","valueField"=>"name"]);
		$this->set("classes",$classes);
		$this->set("view_attendance",false);
		$session = $this->request->session()->read("User");
		
		if($this->request->is("post") && isset($this->request->data["attendence"]))
		{
			$class_id = $this->request->data["class_id"];			
			$att_date = date("Y-m-d",strtotime($this->request->data["curr_date"]));
			if($session["role_name"] == "staff_member")
			{
				// $data = $this->GymAttendance->GymMember->find("all")->where(["member_type"=>"Member","assign_class" => $class_id,"assign_staff_mem"=>$session["id"],"membership_valid_from <= " => $att_date,"membership_valid_to >= "=> $att_date])->hydrate(false)->toArray();
				$data = $this->GymAttendance->GymMemberClass->find("all")->contain(["GymMember"])->where(["GymMember.member_type"=>"Member","GymMember.membership_status"=>"Continue","GymMemberClass.assign_class" => $class_id,"GymMember.assign_staff_mem"=>$session["id"],"GymMember.membership_valid_from <= " => $att_date,"GymMember.membership_valid_to >= "=> $att_date])->hydrate(false)->toArray();
			}
			else{
				// $data = $this->GymAttendance->GymMember->find("all")->where(["role_name"=>"member","member_type"=>"Member","assign_class" => $class_id,"membership_valid_from <= " => $att_date,"membership_valid_to >= "=> $att_date])->hydrate(false)->toArray();
				$data = $this->GymAttendance->GymMemberClass->find("all")->contain(["GymMember"])->where(["GymMember.role_name"=>"member","GymMember.member_type"=>"Member","GymMember.membership_status"=>"Continue","GymMemberClass.assign_class" => $class_id,"GymMember.membership_valid_from <= " => $att_date,"GymMember.membership_valid_to >= "=> $att_date])->hydrate(false)->toArray();
                                
			}
                        
			$this->set("data",$data);		
			$this->set("class_id",$class_id);		
			$this->set("attendance_date",$att_date);		
			$this->set("view_attendance",true);			
		}
		if($this->request->is("post") && isset($this->request->data["save_attendance"]) && isset($this->request->data["attendance"]))
		{
			
                    
                    
                            
			$attendances = $this->request->data["attendance"];			
			$save_row = array();
			$att_date = $this->request->data["attendance_date"];
			$class_id = $this->request->data["class_id"];
			foreach($attendances as $atts)
			{
				$data = array();
                                $data_array=array();
				$data_array=explode('-',$atts);
                                $att=$data_array[0];
                                $schedule_id=$data_array[1];
				$data["user_id"] = $att; 
                                $data["schedule_id"] = $schedule_id; 
				$data["class_id"] = $this->request->data["class_id"]; 
				$data["attendance_date"] = $this->request->data["attendance_date"]; 
				$data["status"] = $this->request->data["status"];
				$data["attendance_by"] = $session["id"]; 
				$data["role_name"] = "member"; 
				$query = $this->GymAttendance->find("all")->where(["user_id"=>$att,"schedule_id"=> $schedule_id,"class_id"=>$class_id,"attendance_date"=>$att_date]);
				$count = $query->count();				
				if($count == 1)
				{
					$erow = $this->GymAttendance->find("all")->where(["user_id"=>$att,"schedule_id"=> $schedule_id,"class_id"=>$class_id,"attendance_date"=>$att_date])->first();
					$erow->status = $this->request->data["status"];				
					if($this->GymAttendance->save($erow))
					{
						$success = 1;
					}
				}else{
					$save_row[] = $data;
				}
				
				
			}
			$ma_row = $this->GymAttendance->newEntities($save_row);
			foreach($ma_row as $m_row)
			{
				if($this->GymAttendance->save($m_row))
				{
					$success = 1;
				}else{
					$success = 0;
				}
			}
			if($success)
			{
				$this->Flash->success(__("Success! Attendance Saved Successfully."));
			}			
		}
    }
	
	public function staffAttendance()
    {		
		$this->set("view_attendance",false);
		$session = $this->request->session()->read("User");
		if($this->request->is("post") && isset($this->request->data["staff_attendence"]))
		{
                         /*$validator = new GymAttendanceValidator();
                         $errors = $validator->errors($this->request->data());
                          if (empty($errors)) {
                            $this->Flash->success('Your message was sent successfully');
                             $this->redirect(['action' => 'Attendence']);
                            } else {
                            $this->set('errors', $errors);
                            }
                            */
			$att_date = date("Y-m-d",strtotime($this->request->data["curr_date"]));
			//$data = $this->GymAttendance->GymMember->find("all")->where(["role_name"=>"staff_member"])->hydrate(false)->toArray();
			if($session["role_name"] == "administrator")
			{
                        $data = $this->GymAttendance->ClassSchedule->find()->contain(["GymMember","ClassScheduleList"])->where(["GymMember.role_name"=>"staff_member"])->hydrate(false)->toArray();
                        }else{
                          $data = $this->GymAttendance->ClassSchedule->find()->contain(["GymMember","ClassScheduleList"])->where(["GymMember.role_name"=>"staff_member","GymMember.created_by"=>$session["id"]])->hydrate(false)->toArray();
                        
                        }
                       // echo "<pre>"; print_r($data); die;
                        $this->set("data",$data);
			$this->set("attendance_date",$att_date);		
			$this->set("view_attendance",true);			
		}
		
		if($this->request->is("post") && isset($this->request->data["save_staff_attendance"]))
		{
			$attendances = array();
			if(isset($this->request->data["attendance"]))
			{$attendances = $this->request->data["attendance"];}
			// var_dump($this->request->data["attendance"]);die;
			$save_row = array();
			$att_date = $this->request->data["attendance_date"];
			if(!empty($attendances))
			{
				foreach($attendances as $atts)
				{
					$data = array();
                                        $data_array=array();
                                        $data_array=explode('-',$atts);
                                        $att=$data_array[0];
                                        $schedule_id=$data_array[1];
                                        $class_id=$data_array[2];
					$data["user_id"] = $att; 
                                        $data["schedule_id"] = $schedule_id; 
                                        $data["class_id"] = $class_id;
					$data["attendance_date"] = $this->request->data["attendance_date"]; 
					$data["status"] = $this->request->data["status"];
					$data["attendance_by"] = $session["id"]; 
					$data["role_name"] = "staff_member"; 
					$query = $this->GymAttendance->find("all")->where(["user_id"=>$att,"schedule_id"=>$schedule_id,"attendance_date"=>$att_date]);
					$count = $query->count();				
					if($count == 1)
					{
						$erow = $this->GymAttendance->find("all")->where(["user_id"=>$att,"schedule_id"=>$schedule_id,"attendance_date"=>$att_date])->first();
						$erow->status = $this->request->data["status"];				
						if($this->GymAttendance->save($erow))
						{
							$success = 1;
						}
					}else{
						$save_row[] = $data;
					}
					
					
				}
				$ma_row = $this->GymAttendance->newEntities($save_row);
				foreach($ma_row as $m_row)
				{
					if($this->GymAttendance->save($m_row))
					{
						$success = 1;
					}else{
						$success = 0;
					}
				}
				if($success)
				{
					$this->Flash->success(__("Success! Attendance Saved Successfully."));
				}
			}
			else{
				$this->Flash->error(__("Error! Please Select Member/Staff-Member."));
			}
		}
    }
	
	public function isAuthorized($user)
	{
		return parent::isAuthorizedCustom($user);
	}
}
