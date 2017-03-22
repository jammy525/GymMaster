<?php 
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.day_list').multiselect({
		includeSelectAllOption: true	
	});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
	// $(".date").datepicker( {format: '<?php echo $this->Gym->getSettings("date_format"); ?>'} );
	$(".date").datepicker( {format: 'yyyy-mm-dd'} );
        $(".class_list").change(function(){
           var class_id=$(this).val();
           var ajaxurl = $("#mem_class_url").val();
            if(class_id != "")
				{
					var curr_data = {class_id:class_id};
					$(".valid_to").val("Calculatind date..");
					$.ajax({
							url :ajaxurl,
							type : 'POST',
							data : curr_data,
							success : function(response)
									{
										// $(".valid_to").val($.datepicker.formatDate('<?php echo $this->Gym->getSettings("date_format"); ?>',new Date(response)));
										$(".valid_to").val(response);
										// alert(response);
										// console.log(response);
									}
						});
				}else{
					$(".valid_to").val(0);
				}
        });
	
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-bars"></i>
				<?php echo __("Add Appointment");?>
				<small><?php echo __("Appointment");?></small>
			  </h1>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("GymAppointment","appointmentList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Appointment List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
                    <input type="hidden" value="<?php echo $this->request->base;?>/GymAjax/get_appointment_classes" id="mem_class_url">
		<?php
			echo $this->Form->create("appointment_Add",["class"=>"validateForm form-horizontal","role"=>"form"]);
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Title").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"appointment_name","class"=>"form-control validate[required]","value"=>(($edit)?$data['appointment_name']:'')]);
			echo "</div>";	
			echo "</div>";

			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Start Date").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"appointment_date","class"=>"form-control date","value"=>(($edit)?date(($this->Gym->getSettings("date_format")),strtotime($data["appointment_date"])):'')]);
			echo "</div>";	
			echo "</div>";
			
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Select Days").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			$days = ["Sunday"=>__("Sunday"),"Monday"=>__("Monday"),"Tuesday"=>__("Tuesday"),"Wednesday"=>__("Wednesday"),"Thursday"=>__("Thursday"),"Friday"=>__("Friday"),"Saturday"=>__("Saturday")];
			echo @$this->Form->select("days",$days,["default"=>json_decode($data['days']),"multiple"=>"multiple","class"=>"form-control validate[required] day_list"]);
			echo "</div>";				
			echo "</div>";	
                        
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("End Date").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"appointment_end_date","class"=>"form-control date","value"=>(($edit)?date($this->Gym->getSettings("date_format"),strtotime($data["appointment_end_date"])):'')]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Class Name").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("class_id",$class_places,["default"=>$data['class_id'],"empty"=>__("Select Class Schedule"),"class"=>"form-control class_list validate[required]"]);
			echo "</div>";	
			//echo '<div class="col-md-2">';
			//echo "<a href='javascript:void(0)' data-url='{$this->request->base}/GymAjax/EventPlaceList' id='eventplace_list' class='btn btn-flat btn-default'>".__("Add or Remove")."</a>";
			//echo "</div>";	
			echo "</div>";			
			
			$hrs = ["0","1","2","3","4","5","6","7","8","9","10","11","12"];
			$min = ["00"=>"00","15"=>"15","30"=>"30","45"=>"45"];
			$ampm = ["AM"=>"AM","PM"=>"PM"];
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Start Time").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_hrs",$hrs,["default"=>$data['start_hrs'],"empty"=>__("Select Time"),"class"=>"form-control validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_min",$min,["default"=>$data['start_min'],"class"=>"form-control"]);
			echo "</div>";
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("start_ampm",$ampm,["default"=>$data['start_ampm'],"class"=>"form-control"]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("End Time").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_hrs",$hrs,["default"=>$data['end_hrs'],"empty"=>__("Select Time"),"class"=>"form-control validate[required]"]);
			echo "</div>";	
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_min",$min,["default"=>$data['end_min'],"class"=>"form-control"]);
			echo "</div>";
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("end_ampm",$ampm,["default"=>$data['end_ampm'],"class"=>"form-control"]);
			echo "</div>";
			echo "</div>";
			?>
                       <div class="form-group">
				<div class="control-label col-md-2">
					<label><?php echo __("Status");?></label>
				</div>
				<div class="col-md-6">
					<label class="radio-inline"><input type="radio" name="status" value="1" class="appointment_status_type" <?php echo ($edit && $data['status'] == 1) ? "checked":"checked";?>><?php echo __("Open");?></label>
					<label class="radio-inline"><input type="radio" name="status" value="0" class="appointment_status_type" <?php echo ($edit && $data['status'] == 0) ? "checked":"";?>><?php echo __("Closed");?></label>
					
				</div>
			</div>
                        <?php
			echo "<br>";
			echo $this->Form->button(__("Save Class"),['class'=>"btn btn-flat btn-success col-md-offset-2","name"=>"add_class"]);
			echo $this->Form->end();
		?>
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>