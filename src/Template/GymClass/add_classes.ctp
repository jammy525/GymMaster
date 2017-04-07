<?php $session = $this->request->session()->read("User");?>
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
				<small><?php echo __("Class");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymClass","ClassesList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Class List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
			
			<?php
			
			echo $this->Form->create($classes,["type"=>"file","class"=>"validateForm form-horizontal"]);
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-3'>".__("Class Name")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->input("",["label"=>false,"name"=>"name","class"=>"form-control validate[required]","value"=>($edit)?$data['name']:""]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-3'>".__("Class Type")."<span class='text-danger'> *</span></label>";
			echo "<div class='col-md-5'>";
			echo $this->Form->select("class_type_id",$classtype,["default"=>($edit)?$data["class_type_id"]:"","empty"=>__("Select Class Type"),"class"=>"form-control validate[required] cat_list"]);
			echo "</div>";			
			echo "<div class='col-md-2'>";			
			echo $this->Form->button(__("Add Class Type"),["class"=>"form-control add_category btn btn-success btn-flat","type"=>"button","data-url"=>$this->Gym->createurl("GymAjax","addClassType")]);
			echo "</div>";	
			echo "</div>";

			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-3'>".__("Class Description")."</label>";
			echo "<div class='col-md-8'>";			
			echo $this->Form->textarea("description",["rows"=>"15","class"=>"form-control textarea","value"=>($edit)?$data['description']:""]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
			echo "<label class='control-label col-md-3'>".__("Class Image")."</label>";
			echo "<div class='col-md-8'>";
			echo $this->Form->file("image",["class"=>"form-control"]);
			echo "</div>";			
			echo "</div>";	
			
			$url =  (isset($data['image']) && $data['image'] != "") ? $this->request->webroot ."/upload/" . $data['image'] : $this->request->webroot ."/upload/logo.png";
			echo "<div class='col-md-offset-3'>";
			echo "<img src='{$url}'>";
			echo "</div>";
			echo "<br><br>";
			
			echo "<br>";
			echo "<div class='col-md-offset-3'>";
			echo $this->Form->button(__("Save Class"),['class'=>"btn btn-flat btn-success","name"=>"add_class"]);
			echo "</div>";	
			echo $this->Form->end();
			echo "<br>";
			?>
				
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>