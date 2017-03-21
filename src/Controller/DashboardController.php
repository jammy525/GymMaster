<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use GoogleCharts;

class DashboardController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent("GYMFunction");
		require_once(ROOT . DS .'vendor' . DS  . 'chart' . DS . 'GoogleCharts.class.php');		
	}
	
	public function index()
	{
		$session = $this->request->session()->read("User");
               //print_r($session); die;
		switch($session["role_name"])
		{
			CASE "administrator":
				return $this->redirect(["action"=>"adminDashboard"]);
			break;
			
			CASE "licensee":
				return $this->redirect(["action"=>"licenseeDashboard"]);
			break;

			CASE "member":
				return $this->redirect(["action"=>"memberDashboard"]);
			break;
                    
			default:	
				return $this->redirect(["action"=>"staffAccDashboard"]);
		}
               
               //return $this->redirect(["action"=>"adminDashboard"]);
	}
        
        
	public function adminDashboard()
	{
            //$access_tbl = TableRegistry::get("GymAccessright");
            //$menus = $access_tbl->find("all")->hydrate(false)->toArray();		
            //$this->set("menus",$menus);

            $session = $this->request->session()->read("User");
            $conn = ConnectionManager::get('default');
            $this->autoRender = false;
            $mem_table = TableRegistry::get("GymMember");
            $grp_tbl = TableRegistry::get("GymGroup");
            $message_tbl = TableRegistry::get("GymMessage");
            $membership_tbl = TableRegistry::get("Membership");				
            $notice_tbl = TableRegistry::get("gym_notice");
            $class_tbl = TableRegistry::get("gym_class");

            $members = $mem_table->find("all")->where(["role_name"=>"member"]);
            $members = $members->count();

            $staff_members = $mem_table->find("all")->where(["role_name"=>"staff_member"]);
            $staff_members = $staff_members->count();

            $licensee = $mem_table->find("all")->where(["role_name"=>"licensee"]);
            $licensee = $licensee->count();

            $curr_id = intval($session["id"]);
            $messages = $message_tbl->find("all")->where(["receiver"=>$curr_id]);
            $messages = $messages->count();

            $groups = $grp_tbl->find("all");
            $groups = $groups->count();
            
            $classes=$class_tbl->find("all")->hydrate(false)->toArray();

            $membership = $membership_tbl->find("all")->limit(5)->select(["membership_label","gmgt_membershipimage"])->hydrate(false)->toArray();
            $groups_data = $grp_tbl->find("all")->limit(5)->select(["name","image"])->hydrate(false)->toArray();

            $cal_lang = $this->GYMFunction->getSettings("calendar_lang");

            $this->set("cal_lang",$cal_lang);
            $this->set("members",$members);
            $this->set("staff_members",$staff_members);
            $this->set("licensee",$licensee);
            $this->set("messages",$messages);
            $this->set("groups",$groups);
            $this->set("membership",$membership);
            $this->set("groups_data",$groups_data);
            $this->set("classes",  $classes);
            
            
            ################ New Members Reports #################
            
              $report_21 ="SELECT count(*) as newcount
					from `gym_member`  where gym_member.created_date >  ( CURDATE() - INTERVAL 10 DAY ) AND gym_member.role_name = 'member'";
                              
		               $report_21 = $conn->execute($report_21);
		               $report_21 = $report_21->fetchAll('assoc');
                               $newval=(int)($report_21[0]['newcount']);
                $mem_tbl = TableRegistry::get("GymMember");
		$chart_array_members = array();
		$chart_array_members[] = array('Membership','Number Of Member');
		$chart_array = array();
					
		
                $olds=$members-$newval; 
                
                $myarray=array('Old Members'=>$olds,'New Members'=>$newval);
                
		if(!empty($newval))
		{
			
				$chart_array_members[1]=array('Old Members',$olds);
                                $chart_array_members[2]=array('New Members',$newval);
			
		}
                 
               $this->set("chart_array_members",$chart_array_members); 
               
                ################## MEMBER SALES REPORT #############################
               
               //$mlistval="";
               
                $report_22 = "SELECT  mph.mp_id,
                        SUM( IF(  mph.payment_method =  'Cash',  mph.amount , 0 ) ) AS  'Cash',
                        SUM( IF(  mph.payment_method <>  'Cash',  mph.amount , 0 ) ) AS 'Online'
                        from membership_payment_history as mph INNER JOIN membership_payment as mp on mph.mp_id=mp.mp_id";
                $report_22 = $conn->execute($report_22);
                $report_22 = $report_22->fetchAll('assoc');
               // print_r( $report_22);
                $chart_array_sales = array();
		$chart_array_sales[] = array('Payment Method','Amount');
                if(!empty($report_22))
		{
                     $chart_array_sales[1]=array('Cash Payment',(int)$report_22[0]['Cash']);
                     $chart_array_sales[2]=array('Online Payment',(int)$report_22[0]['Online']);
                      
                        
                }
                $total_sales=(int)$report_22[0]['Cash']+(int)$report_22[0]['Online'];
                //print_r($chart_array_sales);
                $this->set("report_22",$report_22);
                $this->set("total_sales",$total_sales);
                $this->set("chart_array_sales",$chart_array_sales);
                
              ################## MEMBER BOOKING REPORT #############################
                
                 $report_23 = "SELECT  count(mph.mp_id) as total_booking
                        from membership_payment_history as mph INNER JOIN membership_payment as mp on mph.mp_id=mp.mp_id";
                $report_23 = $conn->execute($report_23);
                $report_23 = $report_23->fetchAll('assoc');
                
                 $chart_array_booking = array();
		$chart_array_booking[] = array('Booking','No of booking');
                if(!empty($report_23))
		{
                    $chart_array_booking[1] = array('Total Bookings',(int)$report_23[0]['total_booking']);
                }
                $this->set("chart_array_booking",$chart_array_booking);
                $this->set("total_booking",(int)$report_23[0]['total_booking']);
                
               ################## UPCOMING SCHEDULE #############################
                
                $date=date('Y-m-d');
                $next_date=date('Y-m-d', strtotime('+1 day', strtotime($date)));
              
                $up_schedule ="SELECT class_schedule.start_date,class_schedule.end_date,class_schedule.class_name,class_schedule.assign_staff_mem,class_schedule_list.days, class_schedule_list.start_time,class_schedule_list.end_time from `class_schedule` INNER JOIN class_schedule_list ON class_schedule.id=class_schedule_list.class_id where class_schedule.end_date <= '$next_date' order by class_schedule.start_date ASC ";
                $up_schedule = $conn->execute($up_schedule);
                $up_schedule = $up_schedule->fetchAll('assoc');
                $this->set("up_schedule",$up_schedule);     
                
                ################## UPCOMING APPOINTMENT #############################
                $date=date('Y-m-d');
                //$next_date=date('Y-m-d', strtotime('+1 day', strtotime($date)));
              
                $up_appointment ="SELECT gpp.status, gpp.appointment_name,gpp.class_id,gpp.appointment_date, gpp.start_time, gpp.end_time, gcls.name, gm.first_name, gm.middle_name, gm.last_name from gym_appointment as gpp INNER JOIN gym_class  as gcls ON gpp.class_id=gcls.id INNER JOIN gym_member gm on gpp.created_by=gm.id where gpp.appointment_date >= '$date' order by gpp.appointment_date ASC limit 3 ";
                $up_appointment = $conn->execute($up_appointment);
                $up_appointment = $up_appointment->fetchAll('assoc');
                $this->set("up_appointment",$up_appointment);     
                
               ################################################
            
            
            
            

            $month =array('1'=>"January",'2'=>"February",'3'=>"March",'4'=>"April",
            '5'=>"May",'6'=>"June",'7'=>"July",'8'=>"August",
            '9'=>"September",'10'=>"Octomber",'11'=>"November",'12'=>"December",);
            $year = date('Y');

            /* $q="SELECT EXTRACT(MONTH FROM created_date) as date_d,sum(paid_amount) as count_c FROM `membership_payment` WHERE YEAR(created_date) = '".$year."' group by month(created_date) ORDER BY month(created_date) ASC";    NOT WORKING ON MYSQL 5.7/PHP 5.7*/
            $q="SELECT EXTRACT(MONTH FROM created_date) as date_d,sum(paid_amount) as count_c FROM `membership_payment` WHERE YEAR(created_date) = '".$year."' group by date_d ORDER BY date_d ASC";

            $result = $conn->execute($q);
            $result = $result->fetchAll('assoc');		
            $chart_array_pay = array();
            $chart_array_pay[] = array('Month','Fee Payment');
            foreach($result as $r){
                $chart_array_pay[]=array( $month[$r["date_d"]],(int)$r["count_c"]);
            }
            $this->set("chart_array_pay",$chart_array_pay); 
            $this->set("result_pay",$result); 





            ################################################	

            $chart_array = array();
            $report_2 ="SELECT  at.class_id,cl.class_name,
                                    SUM(case when `status` ='Present' then 1 else 0 end) as Present,
                                    SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
                                    from `gym_attendance` as at,`class_schedule` as cl where at.attendance_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK) AND at.class_id = cl.id  AND at.role_name = 'member' GROUP BY at.class_id";
            $report_2 = $conn->execute($report_2);
            $report_2 = $report_2->fetchAll('assoc');			
            $report_2 = $report_2;
            $chart_array_at[] = array(__('Class'),__('Present'),__('Absent'));	
            if(!empty($report_2))
            {
                    foreach($report_2 as $result)
                    {			
                            $cls = $result['class_name'];					
                            $chart_array_at[] = [$result['class_name'],(int)$result["Present"],(int)$result["Absent"]];
                    }
            }
            $this->set("report_member",$report_2); 
            $this->set("chart_array_at",$chart_array_at);

            ##################STAFF ATTENDANCE REPORT#############################	

            // $sdate = '2016-07-01';
            // $edate = '2016-08-12';
            $report_2 = null;

            $chart_array_staff = array();
            $report_2 ="SELECT  at.user_id,
                            SUM(case when `status` ='Present' then 1 else 0 end) as Present,
                            SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
                            from `gym_attendance` as at where at.attendance_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK)  AND at.role_name = 'staff_member' GROUP BY at.user_id";

            $report_2 = $conn->execute($report_2);
            $report_2 = $report_2->fetchAll('assoc');

            $chart_array_staff[] = array(__('Staff Member'),__('Present'),__('Absent'));
            if(!empty($report_2))
            {
                    foreach($report_2 as $result)
                    {
                            $user_name = $this->GYMFunction->get_user_name($result["user_id"]);
                            $chart_array_staff[] = array("$user_name",(int)$result["Present"],(int)$result["Absent"]);
                    }
            } 			
            $this->set("chart_array_staff",$chart_array_staff);
            $this->set("report_sataff",$report_2);
            // var_dump($report_2);die;
            $cal_array = $this->getCalendarData();
            $this->set("cal_array",$cal_array);		

            $this->render("dashboard");
	}

	public function licenseeDashboard()
	{
            //die('1233');
		$session = $this->request->session()->read("User");
		$conn = ConnectionManager::get('default');
		$this->autoRender = false;
		$mem_table = TableRegistry::get("GymMember");
		$grp_tbl = TableRegistry::get("GymGroup");
		$message_tbl = TableRegistry::get("GymMessage");
		$membership_tbl = TableRegistry::get("Membership");				
		$notice_tbl = TableRegistry::get("gym_notice");		
		
		$staff_members = $mem_table->find("all")->where(["role_name"=>"staff_member","created_by"=>$session["id"]]);
		$staff_members = $staff_members->count();
                
                $assigned_staff=$mem_table->find("all")->where(["role_name"=>"staff_member","created_by"=>$session["id"]])->hydrate(false)->toArray();
                $string='';
                if(!empty($assigned_staff))
			{
				foreach($assigned_staff as $astaff)
				{
                                   //echo "<pre>"; print_r($astaff);
					$astaff_list[] = $astaff["id"];
                                       $string .= $astaff["id"].', ' ;
				}
                                $astaff_lists = substr($string, 0, -2);
                               // print_r( $astaff_lists);
                                $member_lists=$members = $mem_table->find("all")->where(["role_name"=>"member","created_by"=>$session["id"]])->orWhere(["created_by IN"=>$astaff_list]);
		                $members = $members->count();
                               // New member count
                                $report_21 = "SELECT count(*) as newcount
					from `gym_member`  where gym_member.created_date >  ( CURDATE() - INTERVAL 10 DAY ) AND gym_member.role_name = 'member' AND  gym_member.created_by ='" . $session["id"] . "' OR  gym_member.created_by IN ($astaff_lists)";
                                $report_21 = $conn->execute($report_21);
                                $report_21 = $report_21->fetchAll('assoc');
                                $newval = (int) ($report_21[0]['newcount']);
                                
                                // Member Sales Count
                                 
                               
                        }else{
                           $member_lists= $members = $mem_table->find("all")->where(["role_name"=>"member","created_by"=>$session["id"]]);
		            $members = $members->count();
                            $report_21 ="SELECT count(*) as newcount
					from `gym_member`  where gym_member.created_date >  ( CURDATE() - INTERVAL 10 DAY ) AND gym_member.role_name = 'member' AND  gym_member.created_by ='".$session["id"]."'";
                              
		               $report_21 = $conn->execute($report_21);
		               $report_21 = $report_21->fetchAll('assoc');
                               $newval=(int)($report_21[0]['newcount']);
                        }
                  
		//print_r($astaff_list);
		$curr_id = intval($session["id"]);
		$messages = $message_tbl->find("all")->where(["receiver"=>$curr_id]);
		$messages = $messages->count();
		
		$groups = $grp_tbl->find("all");
		$groups = $groups->count();
		
		$membership = $membership_tbl->find("all")->limit(5)->select(["membership_label","gmgt_membershipimage"])->hydrate(false)->toArray();
		$groups_data = $grp_tbl->find("all")->limit(5)->select(["name","image"])->hydrate(false)->toArray();
		
		$cal_lang = $this->GYMFunction->getSettings("calendar_lang");
		
		$this->set("cal_lang",$cal_lang);
		$this->set("members",$members);
                $this->set("member_lists",$member_lists);
		$this->set("staff_members",$staff_members);
		$this->set("messages",$messages);
		$this->set("groups",$groups);
		$this->set("membership",$membership);
		$this->set("groups_data",$groups_data);
		
		################################################
		$paylistval="";
               foreach($member_lists->hydrate(false)->toArray() as $mlist)
               {
                  // echo "<pre>";print_r($mlist);
                 $paylistval .= $mlist["id"].', ' ;
               }
                $payment_mem_lists = substr($paylistval, 0, -2);
		$month =array('1'=>"January",'2'=>"February",'3'=>"March",'4'=>"April",
		'5'=>"May",'6'=>"June",'7'=>"July",'8'=>"August",
		'9'=>"September",'10'=>"Octomber",'11'=>"November",'12'=>"December",);
		$year = date('Y');
		
		/* $q="SELECT EXTRACT(MONTH FROM created_date) as date_d,sum(paid_amount) as count_c FROM `membership_payment` WHERE YEAR(created_date) = '".$year."' group by month(created_date) ORDER BY month(created_date) ASC";    NOT WORKING ON MYSQL 5.7/PHP 5.7*/
		$q="SELECT EXTRACT(MONTH FROM created_date) as date_d,sum(paid_amount) as count_c FROM `membership_payment` WHERE YEAR(created_date) = '".$year."' AND member_id IN($payment_mem_lists)  group by date_d ORDER BY date_d ASC";
				
		$result = $conn->execute($q);
		$result = $result->fetchAll('assoc');		
		$chart_array_pay = array();
		$chart_array_pay[] = array('Month','Fee Payment');
		foreach($result as $r)
		{

			$chart_array_pay[]=array( $month[$r["date_d"]],(int)$r["count_c"]);
		}
		$this->set("chart_array_pay",$chart_array_pay); 
		$this->set("result_pay",$result); 
		
		
		
		
		
		################################################	
		
		$chart_array = array();
		$report_2 ="SELECT  at.class_id,cl.class_name,
					SUM(case when `status` ='Present' then 1 else 0 end) as Present,
					SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
					from `gym_attendance` as at,`class_schedule` as cl where at.attendance_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK) AND at.class_id = cl.id  AND at.role_name = 'member' GROUP BY at.class_id";
		$report_2 = $conn->execute($report_2);
		$report_2 = $report_2->fetchAll('assoc');			
		$report_2 = $report_2;
		$chart_array_at[] = array(__('Class'),__('Present'),__('Absent'));	
		if(!empty($report_2))
		{
			foreach($report_2 as $result)
			{			
				$cls = $result['class_name'];					
				$chart_array_at[] = [$result['class_name'],(int)$result["Present"],(int)$result["Absent"]];
			}
		}
		$this->set("report_member",$report_2); 
		$this->set("chart_array_at",$chart_array_at);
               // $this->set("newval",$newval);
                
                 ################ New Members Reports #################
              
                 $mem_tbl = TableRegistry::get("GymMember");
		$chart_array_members = array();
		$chart_array_members[] = array('Membership','Number Of Member');
		$chart_array = array();
					
		
                $olds=$members-$newval; 
                
                $myarray=array('Old Members'=>$olds,'New Members'=>$newval);
                
		if(!empty($newval))
		{
			
				$chart_array_members[1]=array('Old Members',$olds);
                                $chart_array_members[2]=array('New Members',$newval);
			
		}
                 
               $this->set("chart_array_members",$chart_array_members); 
               
              ################## MEMBER SALES REPORT #############################
               
               $mlistval="";
               foreach($member_lists->hydrate(false)->toArray() as $mlist)
               {
                  // echo "<pre>";print_r($mlist);
                 $mlistval .= $mlist["id"].', ' ;
               }
                $amem_lists = substr($mlistval, 0, -2);
                $report_22 = "SELECT  mph.mp_id,
                        SUM( IF(  mph.payment_method =  'Cash',  mph.amount , 0 ) ) AS  'Cash',
                        SUM( IF(  mph.payment_method <>  'Cash',  mph.amount , 0 ) ) AS 'Online'
                        from membership_payment_history as mph INNER JOIN membership_payment as mp on mph.mp_id=mp.mp_id where mp.member_id IN ($amem_lists)";
                $report_22 = $conn->execute($report_22);
                $report_22 = $report_22->fetchAll('assoc');
               // print_r( $report_22);
                $chart_array_sales = array();
		$chart_array_sales[] = array('Payment Method','Amount');
                if(!empty($report_22))
		{
                     $chart_array_sales[1]=array('Cash Payment',(int)$report_22[0]['Cash']);
                     $chart_array_sales[2]=array('Online Payment',(int)$report_22[0]['Online']);
                      
                        
                }
                $total_sales=(int)$report_22[0]['Cash']+(int)$report_22[0]['Online'];
                //print_r($chart_array_sales);
                $this->set("report_22",$report_22);
                $this->set("total_sales",$total_sales);
                $this->set("chart_array_sales",$chart_array_sales);
                
               ################## MEMBER BOOKING REPORT #############################
                
                 $report_23 = "SELECT  count(mph.mp_id) as total_booking
                        from membership_payment_history as mph INNER JOIN membership_payment as mp on mph.mp_id=mp.mp_id where mp.member_id IN ($amem_lists)";
                $report_23 = $conn->execute($report_23);
                $report_23 = $report_23->fetchAll('assoc');
                
                 $chart_array_booking = array();
		$chart_array_booking[] = array('Booking','No of booking');
                if(!empty($report_23))
		{
                    $chart_array_booking[1] = array('Total Bookings',(int)$report_23[0]['total_booking']);
                }
                $this->set("chart_array_booking",$chart_array_booking);
                 $this->set("total_booking",(int)$report_23[0]['total_booking']);
                
              ##################STAFF ATTENDANCE REPORT#############################	
	
		// $sdate = '2016-07-01';
		// $edate = '2016-08-12';
		$report_2 = null;
		
		$chart_array_staff = array();
		$report_2 ="SELECT  at.user_id,
				SUM(case when `status` ='Present' then 1 else 0 end) as Present,
				SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
				from `gym_attendance` as at where at.attendance_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK)  AND at.role_name = 'staff_member' GROUP BY at.user_id";
		
		$report_2 = $conn->execute($report_2);
		$report_2 = $report_2->fetchAll('assoc');
		
		$chart_array_staff[] = array(__('Staff Member'),__('Present'),__('Absent'));
		if(!empty($report_2))
		{
                    foreach($report_2 as $result)
                    {
                            $user_name = $this->GYMFunction->get_user_name($result["user_id"]);
                            $chart_array_staff[] = array("$user_name",(int)$result["Present"],(int)$result["Absent"]);
                    }
		} 			
		$this->set("chart_array_staff",$chart_array_staff);
		$this->set("report_sataff",$report_2);
		// var_dump($report_2);die;
		$cal_array = $this->getCalendarData();
		$this->set("cal_array",$cal_array);		
		//print_r($cal_array); die;
		$this->render("licensee_dashboard");
                
               
	}

	
	public function memberDashboard()
	{
		$session = $this->request->session()->read("User");
		$uid = intval($session["id"]);
		$conn = ConnectionManager::get('default');		
		$mem_table = TableRegistry::get("GymMember");
		$grp_tbl = TableRegistry::get("GymGroup");
		$message_tbl = TableRegistry::get("GymMessage");
		$membership_tbl = TableRegistry::get("Membership");		
		$res_tbl = TableRegistry::get("gym_reservation");		
		$notice_tbl = TableRegistry::get("gym_notice");	
                $member_class_tbl = TableRegistry::get("gym_member_class");	
                $membership_payment = TableRegistry::get("membership_payment");
		
		$members = $mem_table->find("all")->where(["role_name"=>"member"]);
		$members = $members->count();
		
		$staff_members = $mem_table->find("all")->where(["role_name"=>"staff_member"]);
		$staff_members = $staff_members->count();
		
		$curr_id = $uid;
		$messages = $message_tbl->find("all")->where(["receiver"=>$curr_id]);
		$messages = $messages->count();
		
		$groups = $grp_tbl->find("all");
		$groups = $groups->count();
		########### Membership Status ########################
                
                $membership_info = $membership_payment->find("all")->where(["member_id"=>$curr_id])->hydrate(false)->toArray();
               
                ########### Class Schedule ###########################
                
                $member_class_schedule ="select * from class_schedule_list as csl Left Join gym_member_class gmc on csl.class_id=gmc.assign_schedule where gmc.member_id=$curr_id order by csl.start_time ASC";
		
		$member_class_schedule = $conn->execute($member_class_schedule);
		$member_class_schedule = $member_class_schedule->fetchAll('assoc');
                
                ################# Attendence Report ######################################
                $report_2 = null;
		
		$chart_array_member = array();
		$report_2 ="SELECT  at.schedule_id,at.status,
				SUM(case when `status` ='Present' then 1 else 0 end) as Present,
				SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
				from `gym_attendance` as at where at.role_name = 'member' and at.user_id=$curr_id GROUP BY at.schedule_id";
		
		$report_2 = $conn->execute($report_2);
		$report_2 = $report_2->fetchAll('assoc');
		
		$chart_array_member[] = array(__('Staff Member'),__('Present'),__('Absent'));
		if(!empty($report_2))
		{
                    foreach($report_2 as $result)
                    {
                           $schedule_id = $result["schedule_id"];
                         
                           ///
                            $class_schedule_list_table = TableRegistry::get("ClassScheduleList");
                            $datass = $class_schedule_list_table->find('all')->where(["id"=> $schedule_id])->toArray();
                           $time_schedule=$datass[0]["start_time"]." - ".$datass[0]["end_time"]; 
                           //
                           
                            $chart_array_member[] = array(" $time_schedule",(int)$result["Present"],(int)$result["Absent"]);
                    }
		} 
               // print_r($chart_array_member);
		$this->set("chart_array_member",$chart_array_member);
		$this->set("report_member",$report_2);
                
                ######################## Member Payment History ##########################
                
                $payment_history ="SELECT mph.amount,mph.payment_method,mph.paid_by_date
				from `membership_payment_history` as mph INNER JOIN membership_payment as mp on mph.mp_id=mp.mp_id where mp.member_id=$curr_id ORDER BY mph.paid_by_date DESC limit 5";
		
		$payment_history = $conn->execute($payment_history);
		$payment_history = $payment_history->fetchAll('assoc');
                
                #########################################################################
                
                
		$membership = $membership_tbl->find("all")->limit(5)->select(["membership_label","gmgt_membershipimage"])->where(["id"=>$membership_info[0]['membership_id']])->hydrate(false)->toArray();
                
		$groups_data = $grp_tbl->find("all")->limit(5)->select(["name","image"])->hydrate(false)->toArray();
		
		$cal_array = $this->getCalendarData();
		
		$cal_lang = $this->GYMFunction->getSettings("calendar_lang");
		
		$this->set("cal_lang",$cal_lang);
		$this->set("cal_array",$cal_array);
		$this->set("members",$members);
		$this->set("staff_members",$staff_members);
		$this->set("messages",$messages);
		$this->set("groups",$groups);
		$this->set("membership",$membership);
                $this->set("membership_info",$membership_info[0]);
                $this->set("member_class_schedule",$member_class_schedule);
                  $this->set("payment_history",$payment_history);
		$this->set("groups_data",$groups_data);
	
		$weight_data["data"] = $this->GYMFunction->generate_chart("Weight",$uid);
		$weight_data["option"] = $this->GYMFunction->report_option("Weight");
		$this->set("weight_data",$weight_data);
		
		$height_data["data"] = $this->GYMFunction->generate_chart("Height",$uid);
		$height_data["option"] = $this->GYMFunction->report_option("Height");
		$this->set("height_data",$height_data);		
		
		$thigh_data["data"] = $this->GYMFunction->generate_chart("Thigh",$uid);
		$thigh_data["option"] = $this->GYMFunction->report_option("Thigh");
		$this->set("thigh_data",$thigh_data);
		
		$chest_data["data"] = $this->GYMFunction->generate_chart("Chest",$uid);
		$chest_data["option"] = $this->GYMFunction->report_option("Chest");
		$this->set("chest_data",$chest_data);
		
		$waist_data["data"] = $this->GYMFunction->generate_chart("Waist",$uid);
		$waist_data["option"] = $this->GYMFunction->report_option("Waist");
		$this->set("waist_data",$waist_data);
		
		$arms_data["data"] = $this->GYMFunction->generate_chart("Arms",$uid);
		$arms_data["option"] = $this->GYMFunction->report_option("Arms");
		$this->set("arms_data",$arms_data);
		
		$fat_data["data"] = $this->GYMFunction->generate_chart("Fat",$uid);
		$fat_data["option"] = $this->GYMFunction->report_option("Fat");
		$this->set("fat_data",$fat_data);
	}
	
	public function staffAccDashboard()
	{
		$session = $this->request->session()->read("User");
		$uid = intval($session["id"]);
		$conn = ConnectionManager::get('default');		
		$mem_table = TableRegistry::get("GymMember");
		$grp_tbl = TableRegistry::get("GymGroup");
		$message_tbl = TableRegistry::get("GymMessage");
		$membership_tbl = TableRegistry::get("Membership");		
		$res_tbl = TableRegistry::get("gym_reservation");		
		$notice_tbl = TableRegistry::get("gym_notice");		
		$curr_id = $uid;
		//$members = $mem_table->find("all")->where(["role_name"=>"member"]);
                $member_lists=$members = $mem_table->find("all")->where(["role_name"=>"member","created_by"=>$curr_id]);
		$members = $members->count();
		
		$staff_members = $mem_table->find("all")->where(["role_name"=>"staff_member"]);
		$staff_members = $staff_members->count();
		
		
		$messages = $message_tbl->find("all")->where(["receiver"=>$curr_id]);
		$messages = $messages->count();
		
		$groups = $grp_tbl->find("all");
		$groups = $groups->count();
		
		$membership = $membership_tbl->find("all")->limit(5)->select(["membership_label","gmgt_membershipimage"])->hydrate(false)->toArray();
		$groups_data = $grp_tbl->find("all")->limit(5)->select(["name","image"])->hydrate(false)->toArray();
		
		$cal_array = $this->getCalendarData();
		
		$cal_lang = $this->GYMFunction->getSettings("calendar_lang");
                
		 ################ New Members Reports #################

                $report_21 ="SELECT count(*) as newcount
                                          from `gym_member`  where gym_member.created_date >  ( CURDATE() - INTERVAL 10 DAY ) AND gym_member.role_name = 'member' and gym_member.created_by=$curr_id";

                                 $report_21 = $conn->execute($report_21);
                                 $report_21 = $report_21->fetchAll('assoc');
                                 $newval=(int)($report_21[0]['newcount']);
                  $mem_tbl = TableRegistry::get("GymMember");
                  $chart_array_members = array();
                  $chart_array_members[] = array('Membership','Number Of Member');
                  $chart_array = array();


                  $olds=$members-$newval; 

                  $myarray=array('Old Members'=>$olds,'New Members'=>$newval);

                  if(!empty($newval))
                  {

                                  $chart_array_members[1]=array('Old Members',$olds);
                                  $chart_array_members[2]=array('New Members',$newval);

                  }

                  $this->set("chart_array_members",$chart_array_members); 
                  
                 ################## MEMBER SALES REPORT #############################
               
               $mlistval="";
               foreach($member_lists->hydrate(false)->toArray() as $mlist)
               {
                  // echo "<pre>";print_r($mlist);
                 $mlistval .= $mlist["id"].', ' ;
               }
                $amem_lists = substr($mlistval, 0, -2);
               
                $report_22 = "SELECT  mph.mp_id,
                        SUM( IF(  mph.payment_method =  'Cash',  mph.amount , 0 ) ) AS  'Cash',
                        SUM( IF(  mph.payment_method <>  'Cash',  mph.amount , 0 ) ) AS 'Online'
                        from membership_payment_history as mph INNER JOIN membership_payment as mp on mph.mp_id=mp.mp_id where mp.member_id IN ($amem_lists)";
                $report_22 = $conn->execute($report_22);
                $report_22 = $report_22->fetchAll('assoc');
               // print_r( $report_22);
                $chart_array_sales = array();
		$chart_array_sales[] = array('Payment Method','Amount');
                if(!empty($report_22))
		{
                     $chart_array_sales[1]=array('Cash Payment',(int)$report_22[0]['Cash']);
                     $chart_array_sales[2]=array('Online Payment',(int)$report_22[0]['Online']);
                      
                        
                }
                $total_sales=(int)$report_22[0]['Cash']+(int)$report_22[0]['Online'];
                //print_r($chart_array_sales);
                $this->set("report_22",$report_22);
                $this->set("total_sales",$total_sales);
                $this->set("chart_array_sales",$chart_array_sales);
                
                
                ################## CLASS SCHEDULE #############################
                
                $date=date('Y-m-d');
                $next_date=date('Y-m-d', strtotime('+1 day', strtotime($date)));
              
                $up_schedule ="SELECT class_schedule.start_date,class_schedule.end_date,class_schedule.class_name,class_schedule.assign_staff_mem,class_schedule_list.days, class_schedule_list.start_time,class_schedule_list.end_time from `class_schedule` INNER JOIN class_schedule_list ON class_schedule.id=class_schedule_list.class_id where class_schedule.end_date >= '$date' and class_schedule.assign_staff_mem='$curr_id' order by class_schedule.start_date ASC ";
                $up_schedule = $conn->execute($up_schedule);
                $up_schedule = $up_schedule->fetchAll('assoc');
                $this->set("up_schedule",$up_schedule);     
                
                
                ####################################################################
		$this->set("cal_lang",$cal_lang);
		$this->set("cal_array",$cal_array);
		$this->set("members",$members);
		$this->set("staff_members",$staff_members);
		$this->set("messages",$messages);
		$this->set("groups",$groups);
		$this->set("membership",$membership);
		$this->set("groups_data",$groups_data);
		//die('hbjhb');
	}

	public function getCalendarData()
	{
		$session = $this->request->session()->read("User");
		$res_tbl = TableRegistry::get("gym_reservation");
		$mem_table = TableRegistry::get("GymMember");
		$grp_tbl = TableRegistry::get("GymGroup");
		$message_tbl = TableRegistry::get("GymMessage");
		$membership_tbl = TableRegistry::get("Membership");				
		$notice_tbl = TableRegistry::get("gym_notice");		
		
		$reservationdata = $res_tbl->find("all")->hydrate(false)->toArray();
		$cal_array = array();
		
		if(!empty($reservationdata))
		{
			foreach ($reservationdata as $retrieved_data){
				$start_time = str_ireplace([":AM",":PM"],[" AM"," PM"],$retrieved_data["start_time"]);
				$end_time = str_ireplace([":AM",":PM"],[" AM"," PM"],$retrieved_data["end_time"]);				
				$start_time = date("H:i:s", strtotime($start_time)); 
				$end_time = date("H:i:s", strtotime($end_time)); 
				
				$cal_array [] = array (
						'title' => $retrieved_data["event_name"],
						'start' => $retrieved_data["event_date"]->format("Y-m-d")."T{$start_time}",
						'end' => $retrieved_data["event_date"]->format("Y-m-d")."T{$end_time}",
						
				);
			}
		}
		
		$birthday_boys=$mem_table->find("all")->where(["role_name"=>"member"])->group("id")->hydrate(false)->toArray();
		$boys_list="";
		if (! empty ( $birthday_boys )) {
			foreach ( $birthday_boys as $boys ) {
				//$boys_list.=$boys->display_name." ";
				$startdate = $boys["birth_date"]->format("Y");
				$enddate = $startdate + 90;
				$years = range($startdate,$enddate,1);
				
				foreach($years as $year)
				{				
					/* $cal_array [] = array (
							'title' => $boys["first_name"]."'s Birthday",
							'start' =>$boys["birth_date"]->format("Y-m-d"),
							'end' => $boys["birth_date"]->format("Y-m-d"),
							'backgroundColor' => '#F25656' */
					 $cal_array [] = array (
						'title' => $boys["first_name"]."'s Birthday",
						'start' =>"{$year}-{$boys["birth_date"]->format("m-d")}",
						'end' => "{$year}-{$boys["birth_date"]->format("m-d")}",
						'backgroundColor' => '#F25656');
				}
			}
		}
		##################################
		$all_notice = "";
		if($session["role_name"] == "administrator")
		{
			$all_notice = $notice_tbl->find("all")->hydrate(false)->toArray();
		}
		else{
			$all_notice = $notice_tbl->find("all")->where(["OR"=>[["notice_for"=>"all"],["notice_for"=>$session["role_name"]]]])->hydrate(false)->toArray();
		}
		
		if (! empty ( $all_notice )) {
			foreach ( $all_notice as $notice ) {
				$i=1;				
				$cal_array[] = array (
						'title' => $notice["notice_title"],
						'start' => $notice["start_date"]->format("Y-m-d"),
						'end' => date('Y-m-d',strtotime($notice["end_date"]->format("Y-m-d").' +'.$i.' days')),
						'color' => '#12AFCB'
				);	
				
			}
		}		
		return $cal_array;		
	}
	
	/*public function isAuthorized($user)
	{
		$role_name = $user["role_name"];
		$curr_action = $this->request->action;
		$admin_actions = ["index","adminDashboard","memberDashboard","staffAccDashboard"];
		$members_actions = ["index","memberDashboard"];
		$staff_acc_actions = ["index","staffAccDashboard"];
		switch($role_name)
		{
			CASE "administrator":
				if(in_array($curr_action,$admin_actions))
				{return true;}else{return false;}
			break;
			
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
	}*/
        
        public function isAuthorized($user){
            return parent::isAuthorizedCustom($user);
	}
}
