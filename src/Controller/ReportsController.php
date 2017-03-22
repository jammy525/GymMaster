<?php
namespace App\Controller;
use Cake\App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use GoogleCharts;

class ReportsController extends AppController
{
	
      
      
      public function initialize()
	{
		parent::initialize();
                $this->loadComponent('RequestHandler');
		require_once(ROOT . DS .'vendor' . DS  . 'chart' . DS . 'GoogleCharts.class.php');
                require_once(ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'PHPExcel.php');
                
	}
	
	public function membershipReport()
	{
		$membership_tbl = TableRegistry::get("Membership");		
		$member_ship_array = array();
		$chart_array = array();
		$chart_array[] = array('Membership','Number Of Member');

		$data = $membership_tbl->find("all")->select(["Membership.membership_label"]);
		$data = $data->leftjoin(["GymMember"=>"gym_member"],["GymMember.selected_membership = Membership.id"])->select(["count"=>$data->func()->count("GymMember.id")])->group("Membership.id")->hydrate(false)->toArray();
		if(!empty($data))
		{
			foreach($data as $result)
			{
				$chart_array[]=[$result["membership_label"],$result["count"]];
			}
		}
		$this->set("data",$data); 
		$this->set("chart_array",$chart_array); 
	}
	
	public function attendanceReport()
    {
		if($this->request->is("post"))
		{
			$att_tbl = TableRegistry::get("gym_attendance");	
			$cls_tbl = TableRegistry::get("class_schedule");
			
			$sdate = date('Y-m-d',strtotime($this->request->data['sdate']));
			$edate = date('Y-m-d',strtotime($this->request->data['edate']));
			//$sdate = '2015-09-01';
			//$edate = '2015-09-10';
			$conn = ConnectionManager::get('default');	
			
			 $report_2 = "SELECT  at.class_id,cl.class_name, 
				SUM(case when `status` ='Present' then 1 else 0 end) as Present, 
				SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 
				from `gym_attendance` as at,`class_schedule` as cl where `attendance_date` BETWEEN '{$sdate}' AND '{$edate}' AND at.class_id = cl.class_name AND at.role_name = 'member' GROUP BY at.class_id";
			
			$report_2 = $conn->execute($report_2);
			$report_2 = $report_2->fetchAll('assoc');			
			$report_2 = $report_2;
			$chart_array[] = array(__('Class'),__('Present'),__('Absent'));
			if(!empty($report_2))
			{
				foreach($report_2 as $result)
				{			
					$cls = $result['class_name'];					
					$chart_array[] = [$result['class_name'],(int)$result["Present"],(int)$result["Absent"]];
				}
			}
			$this->set("report_2",$report_2); 
			$this->set("chart_array",$chart_array); 
		}
    }
	
	public function membershipStatusReport()
	{
		$mem_tbl = TableRegistry::get("GymMember");
		$chart_array = array();
		$chart_array[] = array('Membership','Number Of Member');

		// $data = $mem_tbl->find("all")->where(["membership_status"=>"Expired"])->orWhere(["membership_status"=>"Continue"])->orWhere(["membership_status"=>"Dropped"]);
		$data = $mem_tbl->find("all")->where(["role_name"=>"member","OR"=>[["membership_status"=>"Expired"],["membership_status"=>"Continue"],["membership_status"=>"Dropped"]]]);
		$data = $data->select(["membership_status","count"=>$data->func()->count('membership_status')])->group("membership_status")->hydrate(false)->toArray();
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$chart_array[]=array( $row['membership_status'],$row['count']);
			}
		}		
		$this->set("data",$data); 
		$this->set("chart_array",$chart_array); 
	}
	
	public function paymentReport()
	{			
		$conn = ConnectionManager::get('default');
		$table_name = TableRegistry::get("membership_payment");
		
		$month =array('1'=>"January",'2'=>"February",'3'=>"March",'4'=>"April",
		'5'=>"May",'6'=>"June",'7'=>"July",'8'=>"August",
		'9'=>"September",'10'=>"Octomber",'11'=>"November",'12'=>"December",);
		$year = date('Y');
		
		$q="SELECT EXTRACT(MONTH FROM created_date) as date,sum(paid_amount) as count FROM `membership_payment` WHERE YEAR(created_date) =".$year." group by month(created_date) ORDER BY created_date ASC";
				
		$result = $conn->execute($q);
		$result = $result->fetchAll('assoc');		
		$chart_array = array();
		$chart_array[] = array('Month','Fee 	Payment');
		if(!empty($result))
		{
			foreach($result as $r)
			{

				$chart_array[]=array( $month[$r["date"]],(int)$r["count"]);
			}
		}
		$this->set("result",$result); 		
		$this->set("chart_array",$chart_array); 		
	}
        
        public function membersReport($output_type = 'D', $file = 'my_spreadsheet.xlsx') {
        
        $location_tbl = TableRegistry::get("gym_location");
        $session = $this->request->session()->read("User");
        if ($session["role_name"] == 'administrator') {
            $location = $location_tbl->find("list", ["keyField" => "id", "valueField" => "location"]);
        } else {
            $location = $location_tbl->find("list", ["keyField" => "id", "valueField" => "location"])->where(["GymLocation.created_by" => $session["id"]])->orWhere(['GymLocation.role_name' => 'administrator']);
        }
        $location = $location->toArray();
        $this->set("location", $location);
       
        $conn = ConnectionManager::get('default');
        if($this->request->is("post")){
            $where="";
            $membership_status=$this->request->data['membership_status'];
            $location_id=$this->request->data['location_id'];
            if($membership_status!='')
            {
                $where .=" AND gym_member.membership_status='".$membership_status."'";
            }
            if($location_id!='')
            {
                 $where .=" AND class_schedule.location_id='".$location_id."'";
            }
            $search_query= "SELECT gym_member.id,gym_member.image,gym_member.member_id,gym_member.first_name,gym_member.middle_name,gym_member.last_name,gym_member.membership_status,gym_member.mobile,gym_member.email,gym_member_class.assign_class from `gym_member` Left JOIN `gym_member_class` on  gym_member.id=gym_member_class.member_id  Left JOIN class_schedule ON gym_member_class.assign_class = class_schedule.class_name  where gym_member.role_name = 'member' $where GROUP BY gym_member.id";
        }else{
            $membership_status='';
             $location_id='';
            $search_query= "SELECT gym_member.id,gym_member.image,gym_member.member_id,gym_member.first_name,gym_member.middle_name,gym_member.last_name,gym_member.membership_status,gym_member.mobile,gym_member.email,gym_member_class.assign_class from `gym_member` Left JOIN `gym_member_class` on  gym_member.id=gym_member_class.member_id   INNER JOIN class_schedule ON gym_member_class.assign_class = class_schedule.class_name  where gym_member.role_name = 'member' GROUP BY gym_member.id";
        }
        $search_query = $conn->execute($search_query);
        $search_query = $search_query->fetchAll('assoc');
        $this->set("member_data", $search_query);
        $this->set("membership_status", $membership_status); 
        $this->set("location_id", $location_id);
        /* if ($this->request->is("post")) {
            $att_tbl = TableRegistry::get("gym_attendance");
            $cls_tbl = TableRegistry::get("class_schedule");

            $sdate = date('Y-m-d', strtotime($this->request->data['sdate']));
            $edate = date('Y-m-d', strtotime($this->request->data['edate']));
            //$sdate = '2015-09-01';
            //$edate = '2015-09-10';
            $conn = ConnectionManager::get('default');

            $report_2 = "SELECT  at.class_id,cl.class_name, 
				SUM(case when `status` ='Present' then 1 else 0 end) as Present, 
				SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 
				from `gym_attendance` as at,`class_schedule` as cl where `attendance_date` BETWEEN '{$sdate}' AND '{$edate}' AND at.class_id = cl.class_name AND at.role_name = 'member' GROUP BY at.class_id";

            $report_2 = $conn->execute($report_2);
            $report_2 = $report_2->fetchAll('assoc');
            $report_2 = $report_2;
            $chart_array[] = array(__('Class'), __('Present'), __('Absent'));
            if (!empty($report_2)) {
                foreach ($report_2 as $result) {
                    $cls = $result['class_name'];
                    $chart_array[] = [$result['class_name'], (int) $result["Present"], (int) $result["Absent"]];
                }
            }
            $this->set("report_2", $report_2);
            $this->set("chart_array", $chart_array);
        }
       * */
      
              
               // Member  Membership  Status Graph
                 
                 if(!isset($this->request->data['sdate']))
                 {
                    $sdate=date('Y-m-d'); 
                 }
                 if(!isset($this->request->data['edate']))
                 {
                    $edate=date('Y-m-d'); 
                 }
                // $edate=$this->request->data['edate'];
                $mem_tbl = TableRegistry::get("GymMember");
		$chart_array = array();
		$chart_array[] = array('Membership','Number Of Member');

		// $data = $mem_tbl->find("all")->where(["membership_status"=>"Expired"])->orWhere(["membership_status"=>"Continue"])->orWhere(["membership_status"=>"Dropped"]);
		$data = $mem_tbl->find("all")->where(["role_name"=>"member","OR"=>[["membership_status"=>"Expired"],["membership_status"=>"Continue"],["membership_status"=>"Dropped"]]]);
		$data = $data->select(["membership_status","count"=>$data->func()->count('membership_status')])->group("membership_status")->hydrate(false)->toArray();
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$chart_array[]=array( $row['membership_status'],$row['count']);
			}
		}		
		$this->set("data",$data); 
		$this->set("chart_array",$chart_array); 
                
                // Member Location Graph
                
                 $location_graph= "SELECT  at.class_id,cl.class_name, 
				SUM(case when `status` ='Present' then 1 else 0 end) as Present, 
				SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 
				from `gym_attendance` as at,`class_schedule` as cl where at.class_id = cl.class_name AND at.role_name = 'member' GROUP BY at.class_id";
                
                  
                $location_graph = $conn->execute($location_graph);
                $location_graph = $location_graph->fetchAll('assoc');
                // Member location Status
                /*$chart_array_location = array();
		$chart_array_location[] = array('Location','Number Of Member');
                
                $data = $mem_tbl->find("all")->where(["role_name"=>"member"]);
		$data = $data->select(["membership_status","count"=>$data->func()->count('membership_status')])->group("membership_status")->hydrate(false)->toArray();
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$chart_array[]=array( $row['membership_status'],$row['count']);
			}
		}		
		$this->set("data",$data); 
		$this->set("chart_array",$chart_array);*/
                
                /// Member Lising
               //  $mem_tbl = TableRegistry::get("GymMember");
               ///  $users = $mem_tbl->find("all")->where(["role_name"=>"member"]);
                 //$this->set("member_data",$users);
                 
    }
    
            public function exportExcel($output_type = 'D', $file = 'Member_Report.xlsx') {
                 $mem_tbl = TableRegistry::get("GymMember");
                 $users = $mem_tbl->find("all")->where(["role_name"=>"member"])->hydrate(false)->toArray();
                 $this->set("users",$users);
                 //echo "<pre>";print_r($users); die;
                 $this->set(compact('user', 'output_type', 'file'));
                 $this->viewBuilder()->layout('xls/default');
                 $this->viewBuilder()->template('xls/member_report');
                 $this->RequestHandler->respondAs('xlsx');
                 $this->render();
            }
             public function pdfView($ftype = '0'){
                 //echo $ftype;
                // echo $this->request['myArgument']; die;
                 $mem_tbl = TableRegistry::get("GymMember");
                 $users = $mem_tbl->find("all")->where(["role_name"=>"member"])->hydrate(false)->toArray();
                 $this->set("users",$users);
                 //echo "<pre>";print_r($users); die;
                 $this->viewBuilder()->layout('pdf/pdf');
                 $this->set('title', 'My Great Title');
                 $this->set('ftype', $ftype);
                 
                 $this->viewBuilder()->template('pdf/member_report');
                 $this->set('filename', date('Y-m-d') . '_Member.pdf');
                 $this->response->type('pdf');
            }

}