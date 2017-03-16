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
});
</script>
<section class="content">
	<br>
	<div class="col-md-8 box box-default col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-offset-2">		
		<div class="box-header">
			<section class="content-header">
			  <h3 id='form-head'>
				<i class="fa fa-user"></i>
				<?php echo __("Reset Password");?>
			  </h3>			  
			</section>
		</div>
		<div class="panel">
		<?php				
			echo $this->Form->create("",["class"=>"validateForm form-horizontal","role"=>"form"]);
			
			echo "<fieldset><legend>". __('Reset Password')."</legend>";			
			echo "<br>";
			echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="email">'. __("Email").'</label>';
			echo '<div class="col-md-6">';			
			echo $this->Form->input("",["label"=>false,"name"=>"email","class"=>"form-control validate[required,custom[email]]","value"=>""]);
			echo "</div>";				
			echo "</div>";
			echo "</fieldset>";
                        
			echo "<br>";
			echo '<div class="form-group">';
			echo '<div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-4">';
			echo $this->Form->button(__("Reset"),['class'=>"btn btn-flat btn-success","name"=>"reset"]);
                        //echo $this->Form->button(__("Login"),['class'=>"btn btn-flat btn-success pull-right","name"=>"login"]);
                        echo '<p class="message"><a href="'.$this->request->base.'/users/login">'. __("Login").'</a>';
                        echo '<p class="message"><a href="'.$this->request->base.'/MemberRegistration/">'.__("Member Registration").'</a>';
			echo "</div>";
			echo '</div>';
			echo $this->Form->end();
		?>
		
		</div>			
	</div>
</section>