<?php 
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#specialization').multiselect({
		includeSelectAllOption: true	
	});
	// $(".dob").datepicker({format: '<?php //echo $this->Gym->getSettings("date_format"); ?>'});
	//$(".dob").datepicker({format:"yyyy-mm-dd"});
	var box_height = $(".box").height();
	var box_height = box_height + 500 ;
	$(".content-wrapper").css("height",box_height+"px");
});

function validate_multiselect()
{		
	var specialization = $("#specialization").val();
	if(specialization == null)
	{
		alert("Select Specialization.");
		return false;
	}else{
		return true;
	}	 		
}
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">			
			  <h1>		
				<i class="fa fa-user"></i>
				<?php echo $title;?>
				<small><?php echo __("Licensee");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("Licensee","LicenseeList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Licensee List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">			
			<?php				
			echo $this->Form->create("addgroup",["type"=>"file","class"=>"validateForm form-horizontal","role"=>"form"]);
			
                        ?>
                    <input type="hidden" id="itsId" value="<?php echo ($edit) ? $data['id'] : '';?>">
                    <?php
                        
                        echo "<fieldset><legend>". __('Licensee Information')."</legend>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="first_name">'. __("Licensee Name").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"first_name", "id"=>"first_name", "class"=>"form-control validate[required]","value"=>(($edit)?$data['first_name']:'')]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="middle_name">'. __("Middle Name").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"middle_name", "id"=>"middle_name" ,"class"=>"form-control","value"=>(($edit)?$data['middle_name']:'')]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="last_name">'. __("Last Name").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"last_name", "id"=>"last_name", "class"=>"form-control","value"=>(($edit)?$data['last_name']:'')]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="birth_date">'. __("Date of joining").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"birth_date","id"=>"birth_date","class"=>"form-control dob validate[required]","value"=>(($edit)? date($this->Gym->getSettings("date_format"), strtotime($data['birth_date'])):'')]);
			echo "</div>";	
			echo "</div>";	
			
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="location_id">'. __("Location").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("location_id",$location,["default"=>$data['location_id'],"empty"=>__("Select Location"),"class"=>"form-control validate[required] location_list"]);
			echo "</div>";	
			echo '<div class="col-md-2">';
			echo "<a href='javascript:void(0)' class='add-location btn btn-flat btn-success' data-url='{$this->Gym->createurl("GymAjax","addLocation")}'>".__("Add/Remove")."</a>";
			echo "</div>";	
			echo "</div>";
                        
			//echo "<div class='form-group'>";	
			//echo '<label class="control-label col-md-2" for="email">'. __("Assign Role").'<span class="text-danger"> *</span></label>';
			//echo '<div class="col-md-6">';			
			//echo @$this->Form->select("role",$roles,["default"=>$data['role'],"empty"=>__("Select Role"),"class"=>"form-control validate[required] roles_list"]);
			//echo "</div>";	
			//echo '<div class="col-md-2">';
			//echo "<a href='javascript:void(0)' class='add-role btn btn-flat btn-success' data-url='{$this->Gym->createurl("GymAjax","addLocation")}'>".__("Add/Remove")."</a>";
			//echo "</div>";	
			//echo "</div>";	
			
			//echo "<div class='form-group'>";	
			//echo '<label class="control-label col-md-2" for="email">'. __("Specialization").'<span class="text-danger"> *</span></label>';
			//echo '<div class="col-md-8">';			
			//echo @$this->Form->select("s_specialization",$specialization,["default"=>json_decode($data['s_specialization']),"multiple"=>"multiple","class"=>"form-control validate[required] specialization_list","id"=>"specialization"]);
			//echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='add-spec btn btn-flat btn-success' data-url='{$this->request->base}/GymAjax/AddSpecialization'>".__("Add/Remove")."</a>";
			//echo "</div>";
			//echo "</div>";				
			echo "</fieldset>";
			
			echo "<fieldset><legend>". __('Contact Information')."</legend>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="address">'. __("Home Town Address").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"address","id"=>"address","class"=>"form-control validate[required]","value"=>(($edit)?$data['address']:'')]);
			echo "</div>";	
			echo "</div>";	
                        
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="state">'. __("State").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"state","id"=>"state","class"=>"form-control validate[required]","value"=>(($edit)?$data['state']:'')]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="city">'. __("City").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"city","id"=>"city","class"=>"form-control validate[required]","value"=>(($edit)?$data['city']:'')]);
			echo "</div>";	
			echo "</div>";
                        
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="zipcode">'. __("Zip code").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"zipcode","id"=>"zipcode","class"=>"form-control validate[required]","value"=>(($edit)?$data['zipcode']:'')]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="mobile">'. __("Mobile Number").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo '<div class="input-group">';
			echo '<div class="input-group-addon">+'.$this->Gym->getCountryCode($this->Gym->getSettings("country")).'</div>';
			echo $this->Form->input("",["label"=>false,"name"=>"mobile","id"=>"mobile","class"=>"form-control validate[required]","value"=>(($edit)?$data['mobile']:'')]);
			echo "</div>";	
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="phone">'. __("Phone").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"phone","id"=>"phone","class"=>"form-control","value"=>(($edit)?$data['phone']:'')]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Email").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"email","class"=>"form-control validate[required,custom[email],ajax[isEmailUnique1]]","value"=>(($edit)?$data['email']:'')]);
			echo "</div>";	
			echo "</div>";			
			echo "</fieldset>";
			
			echo "<fieldset><legend>". __('Login Information')."</legend>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="username">'. __("Username").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"username","id"=>"username","class"=>"form-control validate[required,ajax[isUserNameUnique1]]","value"=>(($edit)?$data['username']:''),"readonly"=> (($edit)?true:false)]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="password">'. __("Password").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->password("",["label"=>false,"name"=>"password","id"=>"password","class"=>"form-control validate[required]","value"=>(($edit)?$data['password']:'')]);
			echo "</div>";	
			echo "</div>";
                        
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="gender">'. __("Gender").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6 checkbox">';
			$radio = [
						['value' => 'male', 'text' => __('Male')],
						['value' => 'female', 'text' => __('Female')]
					];
			echo $this->Form->radio("gender",$radio,['default'=>($edit)?$data["gender"]:'male']);			
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="image">'. __("Display Image").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-4">';
			echo $this->Form->file("image",["class"=>"form-control"]);
			$image = ($edit && !empty($data['image'])) ? $data['image'] : "profile-placeholder.png";
			echo "<br><img width='100' src='{$this->request->webroot}webroot/upload/{$image}'>";
			echo "</div>";	
			echo "</div>";			
			echo "</fieldset>";
			
			echo $this->Form->button(__("Save Licensee"),['class'=>"btn btn-flat btn-primary","name"=>"add_group"]);
			echo $this->Form->end();
			?>				
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
	<br>
</section>
