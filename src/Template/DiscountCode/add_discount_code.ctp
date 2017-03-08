<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#membership').multiselect({
            includeSelectAllOption: true	
    });
    var date = new Date();
    $("#valid_till").datepicker({
        format: "<?php echo $this->Gym->getSettings('date_format'); ?>",
        startDate: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0),
        enableOnReadonly: false
    });
    var box_height = $(".box").height();
    var box_height = box_height + 500 ;
    $(".content-wrapper").css("height",box_height+"px");
});

function validate_multiselect(){		
    var specialization = $("#membership").val();
    if(specialization == null){
            alert("Select Memberships associated with this code.");
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
				<i class="fa fa-plus"></i>
                                <?php echo $title;?>
				<small><?php echo __("Add Discount Code");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("DiscountCode","discountCodeList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Discount Code List");?></a>
			 </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">					
		<form class="validateForm form-horizontal" method="post" role="form" onsubmit="return validate_multiselect()">		
                    
                    <!-- hidden field for created by input -->
                    <input type="hidden" name="created_by" id="created_by" class="form-control validate[required]" value="<?php echo $this->request->session()->read("User.id");?>">
            
                    
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="code"><?php  echo __("Discount Code");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" name="code" id="code" class="form-control validate[required,custom[onlyLetterNumber]]" value="">
                        </div>	
                    </div>
                    
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="discount"><?php  echo __("Discount Rate(%)");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" name="discount" id="discount" class="form-control validate[required,custom[number]]" value="">
                        </div>	
                    </div>
                    <?php
                        echo "<div class='form-group'>";	
			echo '<label class="control-label col-md-2" for="membership">'. __("Membership").'<span class="text-danger"> *</span></label>';
			echo '<div class="col-md-6">';			
			echo @$this->Form->select("membership",$memberships,["default"=>json_decode($data['membership']),"multiple"=>"multiple","class"=>"form-control validate[required] membership_list","id"=>"membership"]);
			echo "</div>";
			echo "</div>";	
                    ?>
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="valid_till"><?php  echo __("Validity");?></label>
                        <div class="col-md-6">
                            <input type="text" name="valid_till" id="valid_till" class="form-control" value="" readonly="eadonly">
                        </div>	
                    </div>
                    
                    <div class='form-group'>
                        <label class="control-label col-md-2" for="status"><?php  echo __("Status");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6 checkbox">
                            <?php $radio = [
                                            ['value' => '1', 'text' => __('Active')],
                                            ['value' => '0', 'text' => __('Inactive')]
					];
                            echo $this->Form->radio("status",$radio,['default'=>($edit)?$data["status"]:1]);
                        ?>
                        </div>
                    </div>
                    
                    <div class="col-md-offset-2 col-md-6">
                        <input type="submit" value="<?php echo __("Save");?>" name="save_discount_code" class="btn btn-flat btn-success">
                    </div>
                </form>
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
