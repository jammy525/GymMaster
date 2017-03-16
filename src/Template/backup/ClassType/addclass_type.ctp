<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
?>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-plus"></i>
                                <?php echo $title;?>
				<small><?php echo __("Class Type");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("ClassType","ClasstypeList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Class Type List");?></a>
			 </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">					
		<form class="validateForm form-horizontal" method="post" role="form">		
                    
                    <!-- hidden field for created by input -->
                    <input type="hidden" name="created_by" id="created_by" class="form-control validate[required]" value="<?php echo $this->request->session()->read("User.id");?>">
            
                    
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="title"><?php  echo __("Title");?><span class="text-danger"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" name="title" id="title" class="form-control validate[required]" value="<?php echo ($edit)?$data["title"] : "";?>">
                        </div>	
                    </div>
                    
                    <div class='form-group'>	
                        <label class="control-label col-md-2" for="description"><?php  echo __("Description");?></label>
                        <div class="col-md-6">
                            <textarea name="description" id="description" class="form-control" ><?php echo ($edit)?$data["description"] : "";?></textarea>
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
                        <input type="submit" value="<?php echo __("Save");?>" name="save_classtype" class="btn btn-flat btn-success">
                    </div>
                </form>
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
