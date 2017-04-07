<?php
echo $this->Html->script('jQuery/jQuery-2.1.4.min.js');
echo $this->Html->script('jquery-ui.min');
echo $this->Html->css('bootstrap.min');

$is_rtl = $this->Gym->getSettings("enable_rtl");
if($is_rtl)
{
	echo $this->Html->css('bootstrap-rtl.min');
}
echo $this->Html->script('bootstrap/js/bootstrap.min.js');
echo $this->Html->css('plugins/datepicker/datepicker3');
echo $this->Html->script('datepicker/bootstrap-datepicker.js');
$dtp_lang = $this->gym->getSettings("datepicker_lang");
echo $this->Html->script("datepicker/locales/bootstrap-datepicker.{$dtp_lang}");
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
echo $this->Html->css('validationEngine/validationEngine.jquery');
echo $this->Html->script('validationEngine/languages/jquery.validationEngine-en');
echo $this->Html->script('validationEngine/jquery.validationEngine'); 
?>
<style>
.content{   
   padding-bottom: 0;
}

body *{
	    font-family: "Roboto", sans-serif;
}
.datepicker.dropdown-menu {   
    max-width: 300px;
}
.form-control {
    height: 34px !important;
	font-size: 14px !important;
}
#form-head{
	color : #eee;
}
</style>
<script type="text/javascript">
$(document).ready(function() {	
$(".validateForm").validationEngine();
	$('.group_list').multiselect({
		includeSelectAllOption: true	
	});
	
	var box_height = $(".box").height();
	var box_height = box_height + 500 ;
	$(".content-wrapper").css("height",box_height+"px");
	
	$('.class_list').multiselect({
		includeSelectAllOption: true	
	});
	
	$(".datepick").datepicker({format: 'yyyy-mm-dd',"language" : "<?php echo $dtp_lang;?>"});
		
	$(".content-wrapper").css("height","2600px");
	
	$(".mem_valid_from").datepicker({format: 'yyyy-mm-dd'}).on("changeDate",function(ev){
				var ajaxurl = $("#mem_date_check_path").val();
				var date = ev.target.value;	
				var membership = $(".membership_id option:selected").val();		
				if(membership != "")
				{
					var curr_data = { date : date, membership:membership};
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
									},
							error: function(e){
									console.log(e.responseText);
							}
						});
				}else{
					$(".valid_to").val("Select Membership");
				}
			});	
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h3 id='form-head'>
				<i class="fa fa-user"></i>
				<?php echo __("Member Registration");?>
			  </h3>			  
			</section>
		</div>
		<div class="panel">
		<?php				
			echo $this->Form->create("addgroup",["type"=>"file","class"=>"validateForm form-horizontal","role"=>"form"]);
			echo "<fieldset><legend>". __('Personal Information')."</legend>";
			echo "<br>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="member_id">'. __("Member ID").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"member_id","id"=>"member_id","class"=>"form-control","disabled"=>"disabled","value"=>(($edit)?$data['member_id']:$member_id)]);
			echo "</div>";	
			echo "</div>";
			
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="first_name">'. __("First Name").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"first_name","id"=>"first_name","class"=>"form-control validate[required]","value"=>(($edit)?$data['first_name']:'')]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="middle_name">'. __("Middle Name").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"middle_name","id"=>"middle_name","class"=>"form-control","value"=>""]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="last_name">'. __("Last Name").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"last_name","id"=>"last_name","class"=>"form-control validate[required]","value"=>""]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="gender">'. __("Gender").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6 checkbox">';
			$radio = [
						['value' => 'male', 'text' => 'Male'],
						['value' => 'female', 'text' => 'Female']
					];
			echo $this->Form->radio("gender",$radio,['default'=>'male']);			
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="birth_date">'. __("Date of birth").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"birth_date","id"=>"birth_date","class"=>"form-control dob validate[required] datepick","value"=>(($edit)?date("Y-m-d",strtotime($data['birth_date'])):'')]);
			echo "</div>";	
			echo "</div>";
					
			//echo "<div class='form-group'>";	
			//echo '<label class="control-label col-md-2" for="assign_class">'. __("Class").'<span class="text-danger"> *</span></label>';
			//echo '<div class="col-md-6">';			
			//echo @$this->Form->select("assign_class",$classes,["default"=>$member_class,"class"=>"class_list form-control validate[required]","multiple"=>"multiple"]);
			//echo "</div>";			
			//echo "</div>";			
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="assign_group">'. __("Group").'</label>';
			echo '<div class="col-md-2">';			
			echo @$this->Form->select("assign_group",$groups,["default"=>json_decode($data['assign_group']),"multiple"=>"multiple","class"=>"form-control group_list"]);
			echo "</div>";				
			echo "</div>";
			echo "</fieldset>";
						
			echo "<fieldset><legend>". __('Contact Information')."</legend>";
			echo "<br>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="address">'. __("Address").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"address","id"=>"address","class"=>"form-control validate[required]","value"=>""]);
			echo "</div>";	
			echo "</div>";	
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="city">'. __("City").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"city","id"=>"city","class"=>"form-control validate[required]","value"=>""]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="state">'. __("state").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"state","id"=>"state","class"=>"form-control","value"=>(($edit)?$data['state']:'')]);
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
			echo $this->Form->input("",["label"=>false,"name"=>"email","id"=>"email","class"=>"form-control validate[required,custom[email],ajax[isEmailUnique2]","value"=>(($edit)?$data['email']:'')]);
			echo "</div>";	
			echo "</div>";			
			echo "</fieldset>";
						
			echo "<fieldset><legend>". __('Login Information')."</legend>";
			echo "<br>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="username">'. __("Username").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"username","id"=>"username","class"=>"form-control validate[required,ajax[isUserNameUnique2]","value"=>(($edit)?$data['username']:''),"readonly"=> (($edit)?true:false)]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="password">'. __("Password").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';
			echo $this->Form->password("",["label"=>false,"name"=>"password","id"=>"password","class"=>"form-control validate[required]","value"=>(($edit)?$data['password']:'')]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Display Image").'</label>';
			echo '<div class="col-md-4">';
			echo $this->Form->file("image",["class"=>"form-control"]);
			$image = ($edit && !empty($data['image'])) ? $data['image'] : "profile-placeholder.png";
			echo "<br><img width='150' src='{$this->request->webroot}webroot/upload/{$image}'>";
			echo "</div>";	
			echo "</div>";			
			echo "</fieldset>";
			
			echo "<fieldset><legend>". __('More Information')."</legend>";			
			echo "<br>";
                        
                        echo "<div class='form-group'>";	
                        echo '<label class="control-label col-md-2" for="associated_licensee">'. __("Select Licensee").'<span class="text-danger"> *</span></label>';
                        echo '<div class="col-md-6">';			
                        echo @$this->Form->select("associated_licensee",$licensee,["empty"=>__("Select Licensee"),"class"=>"form-control validate[required]"]);
                        echo "</div>";
                        echo "</div>";
                        
			//echo "<div class='form-group'>";	
			//echo '<label class="control-label col-md-2" for="email">'. __("Interested Area").'</label>';
			//echo '<div class="col-md-6">';			
			//echo @$this->Form->select("intrested_area",$interest,["default"=>$data['intrested_area'],"empty"=>__("Select Interest"),"class"=>"form-control interest_list"]);
			//echo "</div>";				
			//echo "</div>";
			
			//echo "<div class='form-group'>";	
			//echo '<label class="control-label col-md-2" for="email">'. __("Source").'</label>';
			//echo '<div class="col-md-6">';			
			//echo @$this->Form->select("g_source",$source,["default"=>$data['source'],"empty"=>__("Select Source"),"class"=>"form-control source_list"]);
			//echo "</div>";				
			//echo "</div>";
			
			//echo "<div class='form-group class-member'>";	
			//echo '<label class="control-label col-md-2" for="email">'. __("Membership").'<span class="text-danger"> *</span></label>';
			//echo '<div class="col-md-6">';			
			//echo @$this->Form->select("selected_membership",$membership,["default"=>$data['selected_membership'],"empty"=>__("Select Membership"),"class"=>"form-control validate[required] membership_id"]);
			//echo "</div>";	
			//echo "</div>";	
			
			//echo "<div class='form-group class-member'>";	
			//echo '<label class="control-label col-md-2" for="email">'. __("Select Joining Date").'<span class="text-danger"> *</span></label>';
			//echo '<div class="col-md-2">';
			//echo $this->Form->input("",["label"=>false,"name"=>"membership_valid_from","class"=>"form-control validate[required] mem_valid_from","value"=>(($edit && $data['membership_valid_from']!="")?date("Y-m-d",strtotime($data['membership_valid_from'])):'')]);
			//echo "</div>";
			//echo '<div class="col-md-1 no-padding text-center">';
			// echo "To";
			//echo "</div>";
			//echo '<div class="col-md-2">';
			//echo $this->Form->input("",["type"=>"hidden","label"=>false,"name"=>"membership_valid_to","class"=>"form-control validate[required] valid_to","value"=>(($edit && $data['membership_valid_to']!="")?date("Y-m-d",strtotime($data['membership_valid_to'])):''),"readonly"=>true]);
			//echo "</div>";
			//echo "</div>";
                        
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="inquiry_date">'. __("Inquiry Date").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"inquiry_date","id"=>"inquiry_date","class"=>"form-control datepick","value"=>""]);
			echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="trial_end_date">'. __("Trial End Date").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"trial_end_date","id"=>"trial_end_date","class"=>"form-control datepick","value"=>""]);
			echo "</div>";	
			echo "</div>";
			?>
			<div class="form-group">
				<div class="control-label col-md-2">
					<label><?php echo __("Class Type");?></label>
				</div>
				<div class="col-md-6">
					<label class="radio-inline"><input type="radio" name="class_type" value="Group" class="membership_status_type" <?php echo ($edit && $data['class_type'] == "Group") ? "checked":"checked";?>><?php echo __("Group");?></label>
					<label class="radio-inline"><input type="radio" name="class_type" value="Individual" class="membership_status_type" <?php echo ($edit && $data['class_type'] == "Individual") ? "checked":"";?>><?php echo __("Individual");?></label>
					
				</div>
			</div>	
			<div class="form-group">
				<div class="control-label col-md-2">
					<label><?php echo __("Member Type");?></label>
				</div>
				<div class="col-md-6">
					<label class="radio-inline"><input type="radio" name="member_type" value="Member" class="membership_status_type" <?php echo ($edit && $data['member_type'] == "Member") ? "checked":"checked";?>><?php echo __("Member");?></label>
					<label class="radio-inline"><input type="radio" name="member_type" value="Prospect" class="membership_status_type" <?php echo ($edit && $data['member_type'] == "Prospect") ? "checked":"";?>><?php echo __("Prospect");?></label>
					<label class="radio-inline"><input type="radio" name="member_type" value="Alumni" class="membership_status_type" <?php echo ($edit && $data['member_type'] == "Alumni") ? "checked":"";?>><?php echo __("Alumni");?></label>
				</div>
			</div>	
			
			<?php
                        if(@$data['member_type']=='Prospect' || @$data['member_type']=='Alumni')
                        {
                            $styles="style='display:none;'";
                        }else{
                             $styles="style='display:block;'";
                        }
                        
			echo "<div class='form-group class-member'  $styles>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Membership").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("selected_membership",$membership,["default"=>$data['selected_membership'],"empty"=>__("Select Membership"),"class"=>"form-control validate[required] membership_id"]);
			echo "</div>";	
			//echo '<div class="col-md-2">';
			//echo "<a href='{$this->request->base}/Membership/add/' class='btn btn-flat btn-default'>".__("Add Membership")."</a>";
			//echo "</div>";	
			echo "</div>";
			
			echo "<div class='form-group class-member'  $styles >";	
			echo '<label class="control-label col-md-2" for="membership_valid_from">'. __("Membership Valid From").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-2">';
			echo $this->Form->input("",["label"=>false,"name"=>"membership_valid_from","id"=>"membership_valid_from","class"=>"form-control validate[required] mem_valid_from","value"=>(($edit && $data['membership_valid_from']!="")?date("Y-m-d",strtotime($data['membership_valid_from'])):'')]);
			echo "</div>";
			echo '<div class="col-md-1 no-padding text-center">';
			echo "To";
			echo "</div>";
			echo '<div class="col-md-2">';
			echo $this->Form->input("",["label"=>false,"name"=>"membership_valid_to","class"=>"form-control validate[required] valid_to","value"=>(($edit && $data['membership_valid_to']!="")?date("Y-m-d",strtotime($data['membership_valid_to'])):''),"readonly"=>true]);
			echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="first_pay_date">'. __("First Payment Date").'</label>';
			echo '<div class="col-md-6">';
			echo $this->Form->input("",["label"=>false,"name"=>"first_pay_date","id"=>"first_pay_date","class"=>"form-control datepick","value"=>(($edit)?date("Y-m-d",strtotime($data['first_pay_date'])):'')]);
			echo "</div>";	
			echo "</div>";
			
			
			echo "</fieldset>";








							
			echo "<br>";
			echo '<div class="form-group">';
			echo '<div class="col-md-4 col-sm-6 col-xs-6">';
			echo $this->Form->button(__("Save Member"),['class'=>"col-md-offset-2 btn btn-flat btn-success","name"=>"add_member"]);
			echo "</div>";
			echo '<div class="col-md-5 col-sm-6 col-xs-6 pull-right">';
			echo "<a href='".$this->request->base ."/Users/' class='btn btn-success'>".__('Go Back')."</a>";
			echo '</div>';
			echo '</div>';
			echo $this->Form->end();
		?>
		<input type="hidden" value="<?php echo $this->request->base;?>/MemberRegistration/getMembershipEndDate/" id="mem_date_check_path">
		
		</div>			
	</div>
</section>
 <script>
		$(".membership_status_type").change(function(){
			if($(this).val() == "Prospect" || $(this).val() == "Alumni" )
			{
				$(".class-member").hide("SlideDown");
				$(".class-member input,.class-member select").attr("disabled", "disabled");				
			}else{
				$(".class-member").show("SlideUp");
				$(".class-member input,.class-member select").removeAttr("disabled");	
				$("#available_classes").attr("disabled", "disabled");
			}
		});
	if($(".membership_status_type:checked").val() == "Prospect" || $(".membership_status_type:checked").val() == "Alumni")
	{ 
		$(".class-member").hide("SlideDown");
		$(".class-member input,.class-member select").attr("disabled", "disabled");		
	}
</script>
