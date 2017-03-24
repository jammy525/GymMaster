<?php
echo $this->Html->css('fullcalendar');
echo $this->Html->script('moment.min');
echo $this->Html->script('fullcalendar.min');
echo $this->Html->script('lang-all');
?>
<style>
.content-wrapper, .right-side {   
    background-color: #F1F4F9 !important;
}
.panel-heading{
	height: 52px;
	background-color: #1DB198;
	padding: 0 0 0 21px;
	margin: 0;
}
.panel-heading .panel-title {	
    font-size: 16px;
	color :#eee;
    float: left;
    margin: 0;
    padding: 0;
	line-height :3em;
    font-weight: 600; 
}
</style>
<script>	
	 $(document).ready(function() {	
		 $('#calendar').fullCalendar({
			 header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
			lang: '<?php echo $cal_lang;?>',
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: <?php echo json_encode($cal_array);?>
			
		});
	});
</script>
<?php 
    $session = $this->request->session();
    $pull = ($session->read("User.is_rtl") == "1") ? "pull-left" : "pull-right";	

    //foreach($menus as $menu){
            //$controller[] = $menu['controller'];
            //$action[] = $menu['action'];
    //}
    //echo '<pre>';print_r($controller);print_r($action);die;
?>
<section class="content">
    <div id="main-wrapper">		
        <div class="row"><!-- Start Row2 -->
            <div class="row left_section col-md-12 col-sm-12">
                <?php if($session->read('User.role_id') == 1){?>
                <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
                    <a href="<?php echo $this->request->base ."/Licensee/licenseeList";?>">
                        <div class="panel info-box panel-white">
                            <div class="panel-body member">
                                <img src="<?php echo $this->request->base;?>/webroot/img/dashboard/group.png" class="dashboard_background">
                                <div class="info-box-stats">
                                    <p class="counter"><?php echo $licensee;?> <span class="info-box-title"><?php echo __("Licensee");?></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php }?>
                <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
                    <a href="<?php echo $this->request->base ."/GymMember/memberList";?>">
                        <div class="panel info-box panel-white">
                            <div class="panel-body member">
                                <img src="<?php echo $this->request->base;?>/webroot/img/dashboard/member.png" class="dashboard_background">
                                <div class="info-box-stats">
                                    <p class="counter"><?php echo $members;?> <span class="info-box-title"><?php echo __("Member");?></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
                    <a href="<?php echo $this->request->base ."/staff-members/staff-list";?>">
                        <div class="panel info-box panel-white">
                            <div class="panel-body staff-member">
                                <img src="<?php echo $this->request->base;?>/webroot/img/dashboard/staff-member.png" class="dashboard_background">
                                <div class="info-box-stats">
                                    <p class="counter"><?php echo $staff_members;?><span class="info-box-title"><?php echo __("Staff Member");?></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
			
               <!-- <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
                    <a href="<?php echo $this->request->base ."/gym-group/group-list";?>">
                        <div class="panel info-box panel-white">
                            <div class="panel-body group">
                                <img src="<?php echo $this->request->base;?>/webroot/img/dashboard/group.png" class="dashboard_background">
                                <div class="info-box-stats groups-label">
                                    <p class="counter"><?php echo $groups;?><span class="info-box-title"><?php echo __("Group");?></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>-->
                <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
                    <a href="<?php echo $this->request->base ."/gym-message/inbox";?>">
                        <div class="panel info-box panel-white">
                            <div class="panel-body message no-padding">
                                <img src="<?php echo $this->request->base;?>/webroot/img/dashboard/message.png" class="dashboard_background_message">
                                <div class="info-box-stats">
                                    <p class="counter"><?php echo $messages;?><span class="info-box-title"><?php echo __("Message");?></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Active Member Report-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo __("Members Report"); ?></h3>						
                        </div>
                        <?php
                        $options1 = Array(
                            'title' => __('Total Members : ' . $members),
                            'legend' => 'bottom',
                            'colors' => array('#22BAA0', '#F25656'),
                            'pieHole' => 0.5
                        );
                        $GoogleChartss = new GoogleCharts;
                        // print_r($chart_array_members);
                        $charts = $GoogleChartss->load('PieChart', 'chart_div_member')->get($chart_array_members, $options1);
                        ?>
                        <?php if (isset($data) && empty($data)) { ?>

                            <div class="clear col-md-12">
                                <i>
                                    <?php echo __("There is not enough data to generate report."); ?>
                                </i>
                            </div>
                        <?php } ?>
                        <div id="chart_div_member" style="width: 100%; height: 300px;"></div>		  
                        <!-- Javascript --> 
                        <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
                        <script type="text/javascript">
                            <?php
                            if (!empty($chart_array_members)) {
                                echo $charts;
                            }
                            ?>
                                                    </script>

                    </div> 
                </div> 
            </div> 

            <!--Sales Report -->
                  <!-- Secound Section start here -->
                           <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Sales Report"); ?></h3>						
                                     </div>
                                     <?php
                                     $options_sales = Array(
                                         'title' => __('Total Sales : $'.number_format($total_sales,2)),
                                         'legend' => 'bottom',
                                         'colors' => array('#22BAA0', '#F25656'),
                                         'pieHole' => 0.5
                                     );
                                     $GoogleChartSales = new GoogleCharts;
                                     // print_r($chart_array_members);
                                     $chartsales = $GoogleChartSales->load('PieChart', 'chart_div_sales')->get($chart_array_sales, $options_sales);
                                     ?>
                                     <?php if (isset($report_22) && empty($report_22)) { ?>

                                         <div class="clear col-md-12">
                                             <i>
                                                 <?php echo __("There is not enough data to generate report."); ?>
                                             </i>
                                         </div>
                                     <?php } ?>
                                     <div id="chart_div_sales" style="width: 100%; height: 300px;"></div>		  
                                     <!-- Javascript --> 
                                     <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
                                     <script type="text/javascript">
                                        <?php if (!empty($chart_array_sales)) {
                                            echo $chartsales;
                                        }
                                        ?>
                                     </script>

                                 </div> 
                             </div> 
                         </div> 
                          <!-- booking Report-->
                          <div class="col-md-6 col-sm-6 col-xs-12">
			<?php
			 $options_book = Array(
                                         'title' => __('Total Booking : '.($total_booking)),
                                         'legend' => 'bottom',
                                          'pieSliceText' => 'value',
                                         'colors' => array('#F25656'),
                                         //'is3D' => true,
                                         'pieSliceTextStyle' => array('color'=> 'black'),
                                         'pieHole' => 0.5
                                     );

			
		
			
			$GoogleChart_book= new GoogleCharts;
			$chart_book = $GoogleChart_book->load( 'PieChart' , 'booking_report' )->get( $chart_array_booking , $options_book );
			?>
			<div class="panel panel-white">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo __('Booking Report');?></h3>						
				</div>
				<div class="panel-body">
					<div id="booking_report" style="width: 100%; height: 300px;">
						<?php
						
						if(empty($chart_array_booking))
							echo __('There is not enough data to generate report');?>
					</div>  
					  <!-- Javascript --> 
					  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
					  <script type="text/javascript">
						<?php
						if(!empty($chart_array_booking))
							echo $chart_book;?>
						</script>
				</div>
			</div>
			</div>
                          <!-- Payment By Month -->
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php
                              $options = Array(
                                  'title' => __('Payment by month'),
                                  'titleTextStyle' => Array('color' => '#66707e', 'fontSize' => 14, 'bold' => true, 'italic' => false, 'fontName' => 'open sans'),
                                  'legend' => Array('position' => 'bottom',
                                      'textStyle' => Array('color' => '#66707e', 'fontSize' => 14, 'bold' => true, 'italic' => false, 'fontName' => 'open sans')),
                                  //'bar'  => Array('groupWidth' => '70%'),
                                  //'lagend' => Array('position' => 'none'),
                                  'hAxis' => Array(
                                      'title' => __('Month'),
                                      'titleTextStyle' => Array('color' => '#66707e', 'fontSize' => 14, 'bold' => true, 'italic' => false, 'fontName' => 'open sans'),
                                      'textStyle' => Array('color' => '#66707e', 'fontSize' => 11),
                                      'maxAlternation' => 2

                                  //'annotations' =>Array('textStyle'=>Array('fontSize'=>5))
                                  ),
                                  'vAxis' => Array(
                                      'title' => __('Payment'),
                                      'minValue' => 0,
                                      'maxValue' => 5,
                                      'format' => '#',
                                      'titleTextStyle' => Array('color' => '#66707e', 'fontSize' => 14, 'bold' => true, 'italic' => false, 'fontName' => 'open sans'),
                                      'textStyle' => Array('color' => '#66707e', 'fontSize' => 12)
                                  ),
                                  'colors' => array('#22BAA0')
                              );

                              $GoogleCharts = new GoogleCharts;
                              $chart = $GoogleCharts->load('column', 'chart_div1')->get($chart_array_pay, $options);
                              ?>
                              <div class="panel panel-white">
                                  <div class="panel-heading">
                                      <h3 class="panel-title"><?php echo __('Payment'); ?></h3>						
                                  </div>
                                  <div class="panel-body">
                                      <div id="chart_div1" style="width: 100%; height: 300px;">
                                        <?php
                                        if (empty($result_pay))
                                            echo __('There is not enough data to generate report');
                                        ?>
                                      </div>
                                      <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
                                      <script type="text/javascript">
                                        <?php
                                        if (!empty($result_pay))
                                            echo $chart;
                                        ?>
                                      </script>
                                  </div>
                              </div>



                          </div>	
                          <!-- -->
                          <!-- Upcomming schedule -->
                          <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Upcoming Schedule"); ?></h3>						
                                     </div>
                                     <?php 
                                     $custom_date_array=array();
                                     $date=date("Y-m-d");
                                    $next_date=date('Y-m-d', strtotime('+1 day', strtotime($date)));
                                    $day = date('l', strtotime($next_date));
                                 
                                   
                                     if(!empty($up_schedule))
                                     {
                                         
                                       foreach($up_schedule as $schedule){
                                          
                                     ?>
                                     <div class="panel panel-default workout-block" >				
				  <div class="panel-heading">  <br>
                                      <i class="fa fa-calendar"></i>  <span class="work_date"><?php echo date('F j, Y', strtotime($next_date));?></span> ------ <span class="work_date"><?php echo $day;?></span>					
                                    </div>
				  <br>
				  <div class="work_out_datalist_header">
					<div class="col-md-3 col-sm-3">  
						<strong>Class Name</strong>
					</div>
					<div class="col-md-9 col-sm-12 hidden-xs">
						<span class="col-md-4">Staff Name</span>
						<span class="col-md-4">Start Time</span>
						<span class="col-md-4">End Time</span>
						
					</div>
				    </div>	
                                  <?php
                                  
                                   
                                   $days = json_decode($schedule['days']);
                                     if(in_array($day, $days))
                                     {
                                    
                                    ?>
					      <div class="work_out_datalist">
						<div class="col-md-3 day_name"><?php echo $this->Gym->get_classes_by_id($schedule['class_name']) ?></div>
						<div class="col-md-9 col-xs-12">
						<div class="col-md-12">
							<span class="col-md-4 col-sm-4 col-xs-4"><?php echo $this->Gym->get_user_name($schedule['assign_staff_mem']) ?></span>   
							<span class="col-md-4 col-sm-4 col-xs-4"><?php echo $schedule['start_time'];?></span>
							<span class="col-md-4 col-sm-4 col-xs-4"><?php echo $schedule['end_time'];?></span>
							
						</div>
						</div>
					    </div>
                                     <?php }else{ ?>
                                         
                                         
                                        <div class="work_out_datalist">
						<div class="col-md-3 day_name"><?php echo $this->Gym->get_classes_by_id($schedule['class_name']) ?></div>
						<div class="col-md-9 col-xs-12">
						<div class="col-md-12">
							<span class="col-md-4 col-sm-4 col-xs-4">--</span>   
							<span class="col-md-4 col-sm-4 col-xs-4"> -- </span>
							<span class="col-md-4 col-sm-4 col-xs-4"> -- </span>
							
						</div>
						</div>
					    </div> 
                                         
                                   <?php  }
                                     
                                     ?>				
				</div>
                                         <?php } } else { echo "<div style='text-align:center;padding:10px;'>Sorry ! No any schedule.</div>";}?>
                                     
                                     
                                 </div>
                             </div>
                </div>
                <!-- -->
                       <!-- -->
                          <!-- Upcoming appointment -->
                          <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Upcoming Appointment"); ?></h3>						
                                     </div>
                                     <?php 
                                    
                                 
                                   
                                     if(!empty($up_appointment))
                                     {
                                         
                                       foreach($up_appointment as $appointment){
                                         $date= $appointment['appointment_date'];
                                         $date1= $appointment['appointment_end_date'];
                                          $day = date('l', strtotime($date)); 
                                     ?>
                                     <div class="panel panel-default workout-block" >				
				  <div class="panel-heading">  <br>
                                      <i class="fa fa-calendar"></i>  <span class="work_date"><?php echo date('F j, Y', strtotime($date));?></span> to  <span class="work_date"><?php echo date('F j, Y', strtotime($date1));?></span>					
                                    </div>
				  <br>
				  <div class="work_out_datalist_header">
					<div class="col-md-1 col-sm-1">  
						<strong>Status</strong>
					</div>
                                      <div class="col-md-2 col-sm-2">  
						<strong>Class Name</strong>
					</div>
					<div class="col-md-9 col-sm-12 hidden-xs">
                                                 <span class="col-md-3">Location</span>
						<span class="col-md-3">Staff Name</span>
						<span class="col-md-3">Start Time</span>
						<span class="col-md-3">End Time</span>
						
					</div>
				    </div>	
                                   <div class="work_out_datalist">
                                                <?php
                                                if($appointment['status']==1)
                                                {
                                                    $style="style='background:#22BAA0; border-radius: 50%;color:#fff;line-height: 500px;line-height: 30px;text-align: center;'";
                                                    $sname="Open";
                                                }else{
                                                    $style="style='background:#F25656; border-radius: 50%;color:#fff;line-height: 500px;line-height: 30px;text-align: center;'";
                                                    $sname="Closed";
                                                }
                                                ?>
                                                <div class="col-md-1 day_name" <?php echo $style?>><?php echo  $sname; ?></div>
						<div class="col-md-2 day_name"><?php echo $appointment['name']; ?></div>
						<div class="col-md-9 col-xs-12">
						<div class="col-md-12">
                                                        <span class="col-md-3 col-sm-3 col-xs-3"><?php echo $this->Gym->get_location_by_class_id($appointment['class_id']);?></span> 
							<span class="col-md-3 col-sm-3 col-xs-3"><?php echo $appointment['first_name']." ".$appointment['last_name']; ?></span>   
							<span class="col-md-3 col-sm-3 col-xs-3"><?php echo $appointment['start_time'];?></span>
							<span class="col-md-3 col-sm-3 col-xs-3"><?php echo $appointment['end_time'];?></span>
							
						</div>
						</div>
					    </div>
                                     		
				</div>
                                         <?php } } else { echo "<div style='text-align:center;padding:10px;'>Sorry ! No any Appointment.</div>";}?>
                                     
                                     
                                 </div>
                             </div>
                </div>
                <!-- -->    
                          <!-- -->
            
            <?php /* ?><div class="col-md-4 membership-list <?php echo $pull;?> col-sm-4 col-xs-12">
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo __("Membership");?></h3>						
                    </div>
                    <div class="panel-body">
                        <?php 
                        foreach($membership as $ms){
                            $m_img = (!empty($ms["gmgt_membershipimage"])) ? $ms["gmgt_membershipimage"] : "Thumbnail-img2.png";
                            ?>
                            <p>
                                <img src="<?php echo $this->request->base ."/webroot/upload/" .$m_img; ?>" height="40px" width="40px" class="img-circle">
                                <?php echo $ms["membership_label"];?>
                            </p>
                        <?php
                        } ?>
                    </div>
                </div>
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo __("Group List");?></h3>						
                    </div>
                    <div class="panel-body">
                        <?php 
                        foreach($groups_data as $gd)
                        {?>
                            <p>
                                <img src="<?php echo $this->request->base ."/webroot/upload/" .$gd["image"]; ?>" height="40px" width="40px" class="img-circle">
                                <?php echo $gd["name"];?>
                            </p>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div id="calendar"></div>
                    </div>
                </div>
			
		</div>	<!-- End row2 -->
		<div class="row inline"><!-- Start Row3 -->
					
			<div class="col-md-6 col-sm-6 col-xs-12">
			<?php
			$options = Array(
			'title' => __('Member Attendance Report'),
			'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
			'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
			
						'hAxis' => Array(
								'title' =>  __('Class'),
										'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
								'textStyle' => Array('color' => '#66707e','fontSize' => 10),
								'maxAlternation' => 2
			
			
								),
								'vAxis' => Array(
										'title' =>  __('No of Member'),
					'minValue' => 0,
					'maxValue' => 5,
					'format' => '#',
					'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
					'textStyle' => Array('color' => '#66707e','fontSize' => 12)
								),
										'colors' => array('#22BAA0','#f25656')
										);
			
		
			
			$GoogleCharts = new GoogleCharts;
			$chart = $GoogleCharts->load( 'column' , 'attendance_report' )->get( $chart_array_at , $options );
			?>
			<div class="panel panel-white">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo __('Member Attendance Report');?></h3>						
				</div>
				<div class="panel-body">
					<div id="attendance_report" style="width: 100%; height: 500px;">
						<?php
						
						if(empty($report_member))
							echo __('There is not enough data to generate report');?>
					</div>  
					  <!-- Javascript --> 
					  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
					  <script type="text/javascript">
						<?php
						if(!empty($report_member))
							echo $chart;?>
						</script>
				</div>
			</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<?php
			$options12 = Array(
			'title' => __('Staff Attendance Report'),
			'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
			'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
			
						'hAxis' => Array(
								'title' =>  __('Staff Member'),
										'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
								'textStyle' => Array('color' => '#66707e','fontSize' => 10),
								'maxAlternation' => 2
			
			
								),
								'vAxis' => Array(
										'title' =>  __('Number of Staff Members'),
					'minValue' => 0,
					'maxValue' => 5,
					'format' => '#',
					'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
					'textStyle' => Array('color' => '#66707e','fontSize' => 12)
								),
										'colors' => array('#22BAA0','#f25656')
										);
			$GoogleCharts = new GoogleCharts;
			$chart_staff = $GoogleCharts->load( 'column' , 'staff_att_report' )->get( $chart_array_staff , $options12 );
			// var_dump($chart_staff);die;
			?>
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __('Staff Attendance');?></h3>						
					</div>
					<div class="panel-body">
						<div id="staff_att_report" style="width: 100%; height: 500px;">
						<?php
						if(empty($report_sataff))
						echo __('There is not enough data to generate report');?>
						</div>
								
			  <!-- Javascript --> 
			  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
			  <script type="text/javascript">
						<?php 
						if(!empty($report_sataff))
						{echo $chart_staff;}?>
			</script>
								</div>
							</div>
						</div>
			</div><!-- End Row3 --><?php */ ?>
			
			
	</div>
 </div>
</section>
