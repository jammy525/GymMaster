<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
?>
<script>
$(document).ready(function() {
$(".mem_list_workout").select2();
$(".date").datepicker();
var box_height = $(".box").height();
var box_height = box_height + 100 ;
$(".content-wrapper").css("height",box_height+"px");

/* FETCH Activity On Page Load */

	var member_id = $(".mem_list_workout option:selected").val()	
	var ajaxurl = $("#getcategory").attr("data-url");
	var curr_data = {member_id:member_id};
	$.ajax({
		url : ajaxurl,
		type : "POST",
		data : curr_data,
		success : function(result)
		{
			$("#append").html("");			
			$("#append").append(result);			
		},
		error : function(e)
		{
			console.log(e.responseText);
		}
	});
	
/* FETCH Activity On Page Load */


});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-hand-grab-o"></i>
				<?php echo $title;?>
				<small><?php echo __("Assign Member Class");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymMember","memberList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __(" Members List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php
                 // echo "<pre>";print_r($member_data);
			echo $this->Form->create("assignMember",["class"=>"validateForm form-horizontal","role"=>"form"]);
		?>
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Select Member :");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->select("user_id",$members,["default"=>($edit)?$this->request->params["pass"]:"","class"=>"mem_list_workout"]);
				?>
			<input type="hidden" id="getcategory" data-url="<?php echo $this->request->base;?>/GymAjax/getCategoriesByMember" >
			</div>
			
		</div>		
		<div class="form-group">
			<label class="col-md-3 control-label" for="Membership"><?php echo __('Membership :');?></label>
			<div class="col-md-8">
				<?php echo $member_data['membership']['membership_label'];?>
			</div>
		</div>
                 <div class="form-group">
			<label class="col-md-3 control-label" for="Membership Status"><?php echo __('Membership Status :');?></label>
			<div class="col-md-8">
				<?php echo $member_data['membership_status'];?>
			</div>
		</div>	
                 <div class="form-group">
			<label class="col-md-3 control-label" for="Membership Start Date"><?php echo __('Membership Start Date :');?></label>
			<div class="col-md-8">
				<?php echo date($this->Gym->getSettings("date_format"),strtotime($member_data['membership_valid_from']));?>
			</div>
		 </div>	
                 <div class="form-group">
			<label class="col-md-3 control-label" for="Membership End Date"><?php echo __('Membership End Date :');?></label>
			<div class="col-md-8">
				<?php echo date($this->Gym->getSettings("date_format"),strtotime($member_data['membership_valid_to']));?>
			</div>
		 </div>	
		
		<div class="form-group">
			<label class="col-sm-1 control-label"></label>
	         <div class="col-sm-10 border">
				<br>
                                <div class="col-md-12"><label class="list-group-item bg-default"><?php echo __("Assign Class Schedule");?></label></div>    
                    <?php 
                           // print_r($member_data);
                          
                            foreach ($schedule_list as $data){
                               $class_schedule_list=$data['class_schedule_list'];
                                $clas=$data['class_name'];
                                //print_r($membership_classes);
                                if(@in_array($clas,$membership_classes))
				{ 
                                foreach($class_schedule_list as $row){
                                   //echo $clas;print_r($member_class);
                                ?>
                      <div class="col-md-4">
                           <div class="checkbox">
                               <label><input type="checkbox"  name="assign_class[]" <?php if(in_array($row['id'], $member_class)){echo "checked";}else{ echo "";} ?> value="<?php echo $data['class_name'].'-'.$row['id'];?>" id="<?php //echo $key;?>" ><?php echo $this->Gym->get_classes_by_id($data['class_name']); ?> </label>
                            </div>
                           
                      </div>
                      <div class="col-md-4" style="word-wrap: break-word;">
                            <div class="checkbox">
                            <label><?php echo implode(",",json_decode($row["days"])); ?> </label>
                            </div>
                       </div>
                     <div class="col-md-4">
                            <div class="checkbox">
                            <label><?php echo $row['start_time']." - ".$row['end_time']; ?> </label>
                            </div>
                           
                      </div> 
                                <div class="col-md-12">&nbsp;</div>
                                <?php 
                                
                                } 
                                
                                } 
                                
                                }?>
                                <div class="col-md-12">&nbsp;</div>
			</div>
		</div>	
		
		<div id="display_rout_list"></div>		
		
		<div class="col-md-offset-2 col-sm-8 schedule-save-button">
        	
        	<input type="submit" value="<?php if($edit){ echo __('Save '); }else{ echo __('Save');}?>" name="save_assign" class="btn btn-flat btn-success"/>
                </div>
		
		
		<?php 
		$this->Form->end();
                ?>
		
				
		<br><br>
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
