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
		<?Php /* ?><div class="row left_section col-md-8 col-sm-8">
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
			</div>
			<div class="col-md-4 membership-list <?php echo $pull;?> col-sm-4 col-xs-12">
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
			
		</div><?php */ ?>	<!-- End row2 -->
		<?php /* ?><div class="row inline"><!-- Start Row3 -->
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Weight Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="weight_report" style="width: 100%; height: 250px;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$weight_chart = $GoogleCharts->load( 'LineChart' , 'weight_report' )->get( $weight_data["data"] , $weight_data["option"] );
						
							if(empty($weight_data["data"]) || count($weight_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($weight_data["data"]) && count($weight_data["data"]) > 1)
							echo $weight_chart;?>
						</script>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Waist  Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="waist_report" style="width: 100%; height: 250px;float:left;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$waist_chart = $GoogleCharts->load( 'LineChart' , 'waist_report' )->get( $waist_data["data"] , $waist_data["option"] );
						
							if(empty($waist_data["data"]) || count($waist_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($waist_data["data"]) && count($waist_data["data"]) > 1)
							echo $waist_chart;?>
						</script>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Thigh Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="thing_report" style="width: 100%; height: 250px;float:left;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$thing_chart = $GoogleCharts->load( 'LineChart' , 'thing_report' )->get( $thigh_data["data"] , $thigh_data["option"] );
						
							if(empty($thigh_data["data"]) || count($thigh_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($thigh_data["data"]) && count($thigh_data["data"]) > 1)
							echo $thing_chart;?>
						</script>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Arms Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="arms_report" style="width: 100%; height: 250px;float:left;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$arms_chart = $GoogleCharts->load( 'LineChart' , 'arms_report' )->get( $arms_data["data"] , $arms_data["option"] );
						
							if(empty($arms_data["data"]) || count($arms_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($arms_data["data"]) && count($arms_data["data"]) > 1)
							echo $arms_chart;?>
						</script>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Height Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="height_report" style="width: 100%; height: 250px;float:left;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$height_chart = $GoogleCharts->load( 'LineChart' , 'height_report' )->get( $height_data["data"] , $height_data["option"] );
						
							if(empty($height_data["data"]) || count($height_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($height_data["data"]) && count($height_data["data"]) > 1)
							echo $height_chart;?>
						</script>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Chest Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="chest_report" style="width: 100%; height: 250px;float:left;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$chest_chart = $GoogleCharts->load( 'LineChart' , 'chest_report' )->get( $chest_data["data"] , $chest_data["option"] );
						
							if(empty($chest_data["data"]) || count($chest_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($chest_data["data"]) && count($chest_data["data"]) > 1)
							echo $chest_chart;?>
						</script>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __("Fat Progress Report");?></h3>						
					</div>
					<div class="panel-body">	
						<div id="fat_report" style="width: 100%; height: 250px;float:left;">
							<?php 
							$GoogleCharts = new GoogleCharts;
							$fat_chart = $GoogleCharts->load( 'LineChart' , 'fat_report' )->get( $fat_data["data"] , $fat_data["option"] );
						
							if(empty($fat_data["data"]) || count($fat_data["data"]) == 1)
							echo __('There is not enough data to generate report'); ?>
						</div>  
						<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						<script type="text/javascript">
							<?php 
							if(!empty($fat_data["data"]) && count($fat_data["data"]) > 1)
							echo $fat_chart;?>
						</script>
					</div>
				</div>
			</div>
		</div> <?php */ ?><!-- End Row3 -->
		       <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Membership Plan"); ?></h3>						
                                     </div>
                                     <?php //print_r($membership);
                                     if(!empty($membership[0]))
                                     {
                                     ?>
                                     <div class="panel panel-default workout-block" >				
				  <div class="panel-heading">  <br>
                                      <i class="fa fa-calendar"></i> Start From <span class="work_date"><?php echo date('F j, Y', strtotime($membership_info['start_date']));?></span> TO <span class="work_date"><?php echo date('F j, Y', strtotime($membership_info['end_date']));?></span>					
                                    </div>
				  <br>
				  <div class="work_out_datalist_header">
					<div class="col-md-3 col-sm-3">  
						<strong>Plan Name</strong>
					</div>
					<div class="col-md-9 col-sm-12 hidden-xs">
						<span class="col-md-4">Total Amount</span>
						<span class="col-md-4">Paid Amount</span>
						<span class="col-md-4">Status</span>
						
					</div>
				    </div>				
					      <div class="work_out_datalist">
						<div class="col-md-3 day_name"><?php echo $membership[0]['membership_label']?></div>
						<div class="col-md-9 col-xs-12">
						<div class="col-md-12">
							<span class="col-md-4 col-sm-4 col-xs-4">$<?php echo number_format($membership_info['membership_amount'],2);?></span>   
							<span class="col-md-4 col-sm-4 col-xs-4">$<?php echo number_format($membership_info['paid_amount'],2);?></span>
							<span class="col-md-4 col-sm-4 col-xs-4"><?php echo $membership_info['membership_status']?></span>
							
						</div>
						</div>
					    </div>
									
				</div>
                                     <?php } else { echo "Sorry ! You have not take any membership plan.";}?>
                                     
                                     
                                 </div>
                             </div>
                </div>
                <!-- -->
                
                       <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Class Schedule"); ?></h3>						
                                     </div>
                                     
                                     <!--<div class="work_out_datalist_header">
					<div class="col-md-3 col-sm-3">  
						<strong>Days</strong>
					</div>
					<div class="col-md-9 col-sm-12 hidden-xs">
						<span class="col-md-4">Class Name</span>
						<span class="col-md-4">Start Time</span>
						<span class="col-md-4">End Time</span>
						
					</div>
				    </div>-->
                                     
                                     <?php 
                                     if(!empty($member_class_schedule)){
                                         
                                         foreach($member_class_schedule as $mclass){
                                            // print_r($mclass);
                                             ?>
                                             
                                       <div class="panel panel-default workout-block" >				
                                                 <div class="panel-heading">  <br>
                                                     <i class="fa fa-calendar"></i> Days <span class="work_date"><?php echo implode(",",json_decode($mclass["days"])); ?></span>					
                                                 </div>
                                                 <br>
                                                 <div class="work_out_datalist_header">
                                                     <div class="col-md-4 col-sm-4">  
                                                         <strong>Class Name</strong>
                                                     </div>
                                                     <div class="col-md-8 col-sm-12 hidden-xs">
                                                        <span class="col-md-6">Start Time</span>
                                                         <span class="col-md-6">End Time</span>

                                                     </div>
                                                 </div>				
                                                 <div class="work_out_datalist">
                                                     <div class="col-md-4 day_name"><?php  echo $this->Gym->get_classes_by_id($mclass['assign_class']); ?></div>
                                                     <div class="col-md-8 col-xs-12">
                                                         <div class="col-md-12">
                                                            <span class="col-md-6 col-sm-6 col-xs-6"><?php echo $mclass['start_time'] ?></span>
                                                             <span class="col-md-6 col-sm-6 col-xs-6"><?php echo $mclass['end_time'] ?></span>

                                                         </div>
                                                     </div>
                                                 </div>

                                             </div>
                                     
                                        <?php }
                                     }else{
                                         
                                         echo "<div style='text-align:center'>Not assign schedule</div>";
                                     }
                                     ?>
                                     
                                     
                                 </div>
                             </div>
                </div>
                
                <!-- -->
                <div class="col-md-6 col-sm-6 col-xs-12">
			<?php
                        
			$options12 = Array(
			//'title' => __('Staff Attendance Report'),
                         
			'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
			'legend' =>Array('position' => 'bottom',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
			
						'hAxis' => Array(
								'title' =>  __('Schedule Time'),
										'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
								'textStyle' => Array('color' => '#66707e','fontSize' => 10),
								'maxAlternation' => 2
			
			
								),
								'vAxis' => Array(
										'title' =>  __('Number of days'),
					'minValue' => 0,
				        'maxValue' => 100,
					'format' => '#',
					'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
					'textStyle' => Array('color' => '#66707e','fontSize' => 12)
								),
										'colors' => array('#22BAA0','#f25656')
										);
			$GoogleCharts = new GoogleCharts;
			$chart_staff = $GoogleCharts->load( 'column' , 'member_att_report' )->get( $chart_array_member , $options12 );
			// var_dump($chart_staff);die;
			?>
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo __('Attendance Report');?></h3>						
					</div>
					<div class="panel-body">
						<div id="member_att_report" style="width: 100%; height: 300px;">
						<?php
						if(empty($report_member))
						echo __('There is not enough data to generate report');?>
						</div>
								
			  <!-- Javascript --> 
			  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
			  <script type="text/javascript">
						<?php 
						if(!empty($report_member))
						{echo $chart_staff;}?>
			</script>
								</div>
			</div>
                    </div>
                <!---->
                 <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="panel panel-white">
                                 <div class="panel-body">
                                     <div class="panel-heading">
                                         <h3 class="panel-title"><?php echo __("Payment History"); ?></h3>						
                                     </div>
                                     
                                     <?php 
                                     if(!empty($payment_history)){
                                         
                                         foreach($payment_history as $payment){
                                             //print_r($payment);
                                             ?>
                                             
                                       <div class="panel panel-default workout-block" >				
                                                 
                                                 <br>
                                                 <div class="work_out_datalist_header">
                                                     <div class="col-md-4 col-sm-4">  
                                                         <strong>Payment Method</strong>
                                                     </div>
                                                     <div class="col-md-8 col-sm-12 hidden-xs">
                                                        <span class="col-md-6">Amount</span>
                                                         <span class="col-md-6">Date</span>

                                                     </div>
                                                 </div>				
                                                 <div class="work_out_datalist">
                                                     <div class="col-md-4 day_name"><?php  echo $payment['payment_method']; ?></div>
                                                     <div class="col-md-8 col-xs-12">
                                                         <div class="col-md-12">
                                                            <span class="col-md-6 col-sm-6 col-xs-6">$<?php echo $payment['amount'] ?></span>
                                                             <span class="col-md-6 col-sm-6 col-xs-6"><?php echo $payment['paid_by_date'] ?></span>

                                                         </div>
                                                     </div>
                                                 </div>

                                             </div>
                                     
                                        <?php }
                                     }else{
                                         
                                         echo "Sorry! not found";
                                     }
                                     ?>
                                     
                                 </div>
                             </div>
                 </div>
                <!-- -->
			
	
 </div>
</section>