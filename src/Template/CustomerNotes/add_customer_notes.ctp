<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
?>
<script>
$(document).ready(function(){
	$(".hasdatepicker").datepicker({format:"yyyy-mm-dd"});	
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-plus"></i>
				<?php echo __("Add Member Notes");?>
				<small><?php echo __("Notes");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("CustomerNotes","customerNotesList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Member Notes List");?></a>
			 </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">					
		<form class="validateForm form-horizontal" method="post" role="form">		
		
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="note_title"><?php  echo __("Note Title");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" name="note_title" id="note_title" class="form-control validate[required]" value="<?php echo ($edit)?$data["note_title"] : "";?>">
                        </div>	
                    </div>
                    
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="note_for"><?php  echo __("Note For");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                        <?php 
                            //$for = ["all"=>__("All"),"member"=>__("Member"),"staff_member"=>__("Staff Member"),"accountant"=>__("Accountant")];
                            //echo $this->Form->select("note_for",$note_for,["default"=>($edit)?array($data['note_for']):"","class"=>"form-control validate[required]"]);
                            echo @$this->Form->select("note_for",$note_for,["default"=>($edit)?array($data['note_for']):"","empty"=>__("Select Member"),"class"=>"form-control validate[required]"]);
                        ?>
                        </div>	
                    </div>
                    
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="class_id"><?php  echo __("Class");?></label>
                        <div class="col-md-6">
                        <?php 
                            echo $this->Form->select("class_id",$classes,["empty"=>__("Select Class"),"default"=>($edit)?array($data['class_id']):"","class"=>"form-control"]);
                        ?>
                        </div>		
                    </div>
		
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="start_date"><?php  echo __("Start Date");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                                <input type="text" name="start_date" class="hasdatepicker form-control validate[required]" value="<?php echo ($edit)?date("Y-m-d",strtotime($data["start_date"])): "";?>">
                        </div>	
                    </div>
		
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="end_date"><?php  echo __("End Date");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" name="end_date" class="hasdatepicker form-control validate[required]" value="<?php echo ($edit)?date("Y-m-d",strtotime($data["end_date"])) : "";?>">
                        </div>	
                    </div>
		
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="comment"><?php  echo __("Comment");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                            <textarea type="text" name="comment" id="comment" class="form-control validate[required]"><?php echo ($edit)?$data["comment"] : "";?>
                            </textarea>
                        </div>	
                    </div>
                    <div class="col-md-offset-2 col-md-6">
                        <input type="submit" value="<?php echo __("Save");?>" name="save_note" class="btn btn-flat btn-success">
                    </div>
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
