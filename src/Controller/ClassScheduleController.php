<?php
namespace App\Controller;
use App\Controller\AppController;

class ClassScheduleController extends AppController
{
	public function initialize(){
            parent::initialize();
            $this->loadComponent("GYMFunction");		
	}
	
	public function classList($class_id=null){		
            // $data = $this->ClassSchedule->find("all")->hydrate(false)->toArray();
             ///
             $data = array();
            $session = $this->request->session()->read("User");
                switch($session["role_name"]){
                CASE "administrator" :
                if($class_id){
                    $data = $this->ClassSchedule->find()->where(["ClassSchedule.class_name"=>$class_id]);
                  }else{
                   $data = $this->ClassSchedule->find();  
                   }
                break;

                CASE "franchise" :
                 if($class_id){
                    $data = $this->ClassSchedule->find()->where(["ClassSchedule.class_name"=>$class_id,"ClassSchedule.created_by"=>$session["id"]]);
                   }else{
                   $data = $this->ClassSchedule->find()->where(["ClassSchedule.created_by"=>$session["id"]])->orWhere(['ClassSchedule.role_name' => 'administrator']);  
                   }
                break;

                CASE "staff_member" :
                   if($class_id){
                    $data = $this->ClassSchedule->find()->where(["ClassSchedule.class_name"=>$class_id,"ClassSchedule.assign_staff_mem"=>$session["id"]]);
                    }else{
                    $data = $this->ClassSchedule->find()->where(["ClassSchedule.assign_staff_mem"=>$session["id"]]);  
                   }
                break;
		
              }
            ///
            
            
            
            $data = $data->contain(["GymMember","GymLocation"])->select(["ClassSchedule.id","ClassSchedule.class_name","ClassSchedule.assign_staff_mem","ClassSchedule.start_date","ClassSchedule.end_date","GymMember.first_name","GymMember.last_name","GymLocation.location"])->hydrate(false)->toArray();
            $this->set("data",$data);		
	}
	
	public function addClass($class_id=null){
            $this->set("edit",false);
            $this->set("title",__("Add Class Schedule"));	
            $session = $this->request->session()->read("User");
            if($session["role_name"]=='administrator')
                {
                  $staff = $this->ClassSchedule->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);
                }else{
                  $staff = $this->ClassSchedule->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"])->where(["GymMember.created_by"=>$session["id"]])->orWhere(['GymMember.created_role' => 'administrator']);  
                }
            $staff = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])]);
            $staff = $staff->toArray();
            $this->set("staff",$staff);
            
           // $location = $this->ClassSchedule->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"]);	
             if($session["role_name"]=='administrator')
                {
                   $location = $this->ClassSchedule->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"]);	
                }else{
                    $location = $this->ClassSchedule->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"])->where(["GymLocation.created_by" => $session["id"]])->orWhere(['GymLocation.role_name' => 'administrator']);
                }
            //$location = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])]);
            $location = $location->toArray();
            $this->set("location",$location);
            
            $this->set("assistant_staff",$staff);
             if($class_id){
                   $classes= $this->ClassSchedule->GymClass->find("list",["keyField"=>"id","valueField"=>"name"])->where(["id"=>$class_id]);
                   $data['class_name']=$class_id;
                   $this->set("data",$data);
             }else{
                  if($session["role_name"]=='administrator')
                   {
                   $classes= $this->ClassSchedule->GymClass->find("list",["keyField"=>"id","valueField"=>"name"]);
                   }else{
                     $classes= $this->ClassSchedule->GymClass->find("list",["keyField"=>"id","valueField"=>"name"])->where(["GymClass.created_by"=>$session["id"]])->orWhere(['GymClass.role_name' => 'administrator']);  
                   }
             }
            $this->set("classes",$classes);
            
            
            if($this->request->is("post")){
                
                $time_list = $this->request->data["time_list"];			

                $class = $this->ClassSchedule->newEntity();
                $this->request->data['days'] = json_encode($this->request->data['days']);
                $this->request->data['start_time'] = $this->request->data['start_hrs'].":".$this->request->data['start_min'].":".$this->request->data['start_ampm'];
                $this->request->data['end_time'] = $this->request->data['end_hrs'].":".$this->request->data['end_min'].":".$this->request->data['end_ampm'];
                $this->request->data["created_date"] = date("Y-m-d H:i:s");
                $this->request->data["updated_date"] = date("Y-m-d H:i:s");
                $this->request->data["created_by"] = $session["id"];
                $this->request->data["updated_by"] = $session["id"];	


                $class = $this->ClassSchedule->patchEntity($class,$this->request->data);
                if($this->ClassSchedule->save($class)){
                    $class_id = $class->id;
                   foreach($time_list as $time){
                        $schedule = array();
                        $time = json_decode($time);
                        $schedule["class_id"] = $class_id;
                        $schedule["days"] = json_encode($time[0]);
                        $schedule["start_time"] = $time[1];
                        $schedule["end_time"] = $time[2];
                        $schedule_row = $this->ClassSchedule->ClassScheduleList->newEntity();
                        $schedule_row = $this->ClassSchedule->ClassScheduleList->patchEntity($schedule_row,$schedule);
                        $this->ClassSchedule->ClassScheduleList->save($schedule_row);						
                   }
                    $this->Flash->success(__("Success! Record Saved Successfully"));
                }else{
                    $this->Flash->error(__("Error! There was an error while updating,Please try again later."));
                }			
                return $this->redirect(["action"=>"classList"]);
            }
	}
	
	public function editClass($id){
            $this->set("edit",true);
            $this->set("title",__("Edit Class Schedule"));
            $session = $this->request->session()->read("User");
            $row = $this->ClassSchedule->get($id)->toArray();
            $row['start_hrs'] =  explode(":",$row['start_time'])[0];
            @$row['start_min'] =  explode(":",$row['start_time'])[1];
            @$row['start_ampm'] =  explode(":",$row['start_time'])[2];

            $row['end_hrs'] =  explode(":",$row['end_time'])[0];
            $row['end_min'] =  explode(":",$row['end_time'])[1];
            $row['end_ampm'] =  explode(":",$row['end_time'])[2];

            $schedule_list = $this->ClassSchedule->ClassScheduleList->find()->where(["class_id"=>$id])->hydrate(false)->toArray();

            $this->set("schedule_list",$schedule_list);
            $this->set("data",$row);
              if($session["role_name"]=='administrator')
                {
                  $staff = $this->ClassSchedule->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);
                }else{
                  $staff = $this->ClassSchedule->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"])->where(["GymMember.created_by"=>$session["id"]])->orWhere(['GymMember.created_role' => 'administrator']);  
                }
            //$staff = $this->ClassSchedule->GymMember->find("list",["keyField"=>"id","valueField"=>"name"])->where(["role_name"=>"staff_member"]);		
            $staff = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])]);
            $staff = $staff->toArray();
            $this->set("staff",$staff);
            $this->set("assistant_staff",$staff);
             if($session["role_name"]=='administrator')
                {
                   $location = $this->ClassSchedule->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"]);	
                }else{
                    $location = $this->ClassSchedule->GymLocation->find("list",["keyField"=>"id","valueField"=>"location"])->where(["GymLocation.created_by" => $session["id"]])->orWhere(['GymLocation.role_name' => 'administrator']);; 
                }
            //$location = $staff->select(["id","name"=>$staff->func()->concat(["first_name"=>"literal"," ","last_name"=>"literal"])]);
            $location = $location->toArray();
            $this->set("location",$location);
            
            ///$classes= $this->ClassSchedule->GymClass->find("list",["keyField"=>"id","valueField"=>"name"]);
            if ($session["role_name"] == 'administrator') {
               $classes = $this->ClassSchedule->GymClass->find("list", ["keyField" => "id", "valueField" => "name"]);
              } else {
               $classes = $this->ClassSchedule->GymClass->find("list", ["keyField" => "id", "valueField" => "name"])->where(["GymClass.created_by" => $session["id"]])->orWhere(['GymClass.role_name' => 'administrator']);
             }
             
          $this->set("classes",$classes);
            
            $this->render("addClass");
                  
             /** Edit record checked roles permissions* */
               if ($session["role_name"] == "franchise" || $session["role_name"] == "staff_member") {
                    if ($row['created_by'] != $session['id']) {
                        $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                        return $this->redirect(["action" => "classList"]);
                    }
                }

            /** End here * */

            if($this->request->is("post")){ 
               $time_list = $this->request->data["time_list"];
                $class = $this->ClassSchedule->get($id);
                $this->request->data['days'] = json_encode($this->request->data['days']);
                $this->request->data['start_time'] = $this->request->data['start_hrs'].":".$this->request->data['start_min'].":".$this->request->data['start_ampm'];
                $this->request->data['end_time'] = $this->request->data['end_hrs'].":".$this->request->data['end_min'].":".$this->request->data['end_ampm'];
                $this->request->data["updated_date"] = date("Y-m-d H:i:s");
                $this->request->data["updated_by"] = $session["id"];	
                
                $class = $this->ClassSchedule->patchEntity($class,$this->request->data());

                if($this->ClassSchedule->save($class)){			
                    $this->ClassSchedule->ClassScheduleList->deleteAll(["class_id"=>$id]);
                    foreach($time_list as $time){	
                        $schedule = array();
                        $time = json_decode($time);
                        $schedule["class_id"] = $id;
                        $schedule["days"] = json_encode($time[0]);
                        $schedule["start_time"] = $time[1];
                        $schedule["end_time"] = $time[2];
                        $schedule_row = $this->ClassSchedule->ClassScheduleList->newEntity();
                        $schedule_row = $this->ClassSchedule->ClassScheduleList->patchEntity($schedule_row,$schedule);
                        $this->ClassSchedule->ClassScheduleList->save($schedule_row);
                   }
                }			
                $this->Flash->success(__("Success! Record Updated Successfully"));
                return $this->redirect(["action"=>"classList"]);
            }	
	}
	
	public function deleteClass($id){
              $session = $this->request->session()->read("User");
              $row = $this->ClassSchedule->get($id);
            
             /** Edit record checked roles permissions* */
                if ($session["role_name"] == "franchise" || $session["role_name"] == "staff_member") {
                    if ($row['created_by'] != $session['id']) {
                        $this->Flash->error(__("Success! You Do Not Have Sufficient Permissions to Edit This Record."));
                        return $this->redirect(["action" => "classList"]);
                    }
                }

            /** End here * */
            if($this->ClassSchedule->delete($row)){
                $this->ClassSchedule->ClassScheduleList->deleteAll(["class_id"=>$id]);
                $this->Flash->success(__("Success! Class Schedule Deleted Successfully."));
                return $this->redirect($this->referer());
            }
	}
	
	public function viewSchedules(){
          
            // $classes = $this->ClassSchedule->find("all")->hydrate(false)->toArray();
            $session = $this->request->session()->read("User");	
            if($session["role_name"]=="member"){
                $classes_list = $this->ClassSchedule->GymMemberClass->find()->where(["member_id"=>$session["id"]])->hydrate(false)->toArray();
                if(!empty($classes_list)){
                    foreach($classes_list as $class){
                        $assign_class[] = $class["assign_class"];
                    }				
                    // var_dump($assign_class);die;
                    $classes = $this->ClassSchedule->ClassScheduleList->find("all")->where(["class_id IN"=>$assign_class])->hydrate(false)->toArray();
                }
            }
            else{
                $classes = $this->ClassSchedule->ClassScheduleList->find("all")->hydrate(false)->toArray();
            }
            
            if($this->request->is("post")){
              $date=$this->request->data['search_date'];
              $class_id=$this->request->data['class_name'];
             
              if($class_id)
              {
                   $conditions = array('ClassSchedule.start_date <=' => $date, 'ClassSchedule.end_date >=' => $date, 'ClassSchedule.class_name'=> $class_id);
              }else{
                  $conditions = array('ClassSchedule.start_date <=' => $date, 'ClassSchedule.end_date >=' => $date);
              }
              
              $row=$this->ClassSchedule->find()->contain(["GymMember","GymLocation","GymClass","ClassScheduleList"])->where($conditions)->hydrate(false)->toArray(); 
               $this->set("class_name",$class_id);
            }else{
             $date=date('Y-m-d');
             $conditions = array('ClassSchedule.start_date <=' => $date, 'ClassSchedule.end_date >=' => $date);
             } 
             
            $row=$this->ClassSchedule->find()->contain(["GymMember","GymLocation","GymClass","ClassScheduleList"])->where($conditions)->hydrate(false)->toArray();
            $this->set("search_date",$date);
               //$row = $row[0];
         // echo "<pre>"; print_r($classes);  echo "</pre>"; die;
             
           $this->set("classes",$classes);
           $class_list= $this->ClassSchedule->GymClass->find("list",["keyField"=>"id","valueField"=>"name"]);
           $this->set("class_list",$class_list);
           
           // $this->render("viewSchedule");
            $this->set("data",$row);	
            
	}
        public function deleteSchedule($id)
        {
             $row = $this->ClassSchedule->ClassScheduleList->get($id);
            if($this->ClassSchedule->ClassScheduleList->delete($row)){
                $this->Flash->success(__("Success! Class Schedule Deleted Successfully."));
                return $this->redirect($this->referer());
            }
        }


        public function isAuthorized($user)
	{
		return parent::isAuthorizedCustom($user);
	}
}
