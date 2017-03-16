<script>
$(document).ready(function(){	
	
	var box_height = $(".box").height();
	var box_height = box_height + 300 ;
	$(".content-wrapper").css("height",box_height+"px");
	$(".content-wrapper").css("min-height","500px");
});		
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-object-group"></i>
				<?php echo $title;?>
				<small><?php echo __("Access Roles");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymGroup","Access Roles List");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i><?php echo __("Access Roles List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
			<div class="col-md-6">
			<?php
			
			echo $this->Form->create("addaccessroles");
			
			echo "<div class='form-group'>";							
			echo $this->Form->input(__("Access Role Name"),["name"=>"name","class"=>"form-control validate[required]","value"=>(($edit)?$data['name']:'')]);
			echo "</div>";	

			echo $this->Form->button(__("Save Access Role"),['class'=>"btn btn-flat btn-primary","name"=>"add_access_roles"]);
			echo $this->Form->end();
			?>
			</div>	
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>