<?php
echo $this->Html->css('fullcalendar');
echo $this->Html->script('moment.min');
echo $this->Html->script('fullcalendar.min');
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
				editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: <?php echo json_encode($cal_array);?>
			
		});
	});
</script>
<?php 
	$session = $this->request->session();
	$pull = ($session->read("User.is_rtl") == "1") ? "pull-left" : "pull-right";	
?>
<section class="content">
<div id="main-wrapper">		
		<div class="row"><!-- Start Row2 -->
		<!--<div class="row left_section col-md-12 col-sm-12">
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
			
			<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
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
			</div>
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
			</div>-->
                
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
                  
                         <!-- Upcomming schedule -->
                          <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Class Schedule"); ?></h3>						
                                     </div>
                                     <?php 
                                     $custom_date_array=array();
                                     $date=date("Y-m-d");
                                    //$next_date=date('Y-m-d',  strtotime($date));
                                    $day = date('l', strtotime($date));
                                 
                                   
                                     if(!empty($up_schedule))
                                     {
                                         
                                       foreach($up_schedule as $schedule){
                                         // print_r($schedule);
                                          
                                     ?>
                                     <div class="panel panel-default workout-block" >				
				  <div class="panel-heading">  <br>
                                      <i class="fa fa-calendar"></i>  <span class="work_date"><?php echo date('F j, Y', strtotime($date));?></span> ------ <span class="work_date"><?php echo $day;?></span>					
                                    </div>
				  <br>
				  <div class="work_out_datalist_header">
					<div class="col-md-2 col-sm-2">  
						<strong>Class Name</strong>
					</div>
					<div class="col-md-10 col-sm-12 hidden-xs">
						<span class="col-md-4">Location Name</span>
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
						<div class="col-md-2 day_name"><?php echo $this->Gym->get_classes_by_id($schedule['class_name']) ?></div>
						<div class="col-md-10 col-xs-12">
						<div class="col-md-12">
							<span class="col-md-4 col-sm-4 col-xs-4"><?php echo $this->Gym->get_location_by_class_id($schedule['class_name']) ?></span>   
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
							<span class="col-md-4 col-sm-4 col-xs-4"> -- </span>   
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
                          <!-- booking Report-->
			<?php /* ?><div class="col-md-4 membership-list <?php echo $pull;?> col-sm-4 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Membership");?></h3>						
					</div>
					<div class="panel-body">
						<?php 
						foreach($membership as $ms)
						{
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
						<div id="calendar">
						</div>
				</div>
			</div>
			
		</div>	<!-- End row2 --><?php */ ?>
					
	</div>
 </div>
</section>