<script type="text/javascript">
$(document).ready(function() {	
	$(".content-wrapper").css("min-height","1550px");
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-key"></i>
				<?php echo __("Access Right Settings");?>
				<small><?php echo __("Access Right");?></small>
			  </h1>			  
			</section>
		</div>
		<hr>
		<div class="box-body">	
		<form name="student_form" action="" method="post" class="form-horizontal" id="access_right_form">
			<div class="row">
				<div class="col-md-2 col-sm-3 col-xs-3"><?php echo __("Menu");?></div>
				<?php 
					foreach($roles as $role){
						echo '<div class="col-md-2 col-sm-3 col-xs-3">
							'.$role['name'].'
						</div>';
				} ?>
			</div>
			<?php 
				//echo '<pre>'; print_r($menus); 
				foreach($menus as $key=>$menu){
					echo '<div class="row">
						<div class="col-md-2 col-sm-3 col-xs-5 ">
							<span class="menu-label">
								<strong>'.$key.'</strong>
							</span>
						</div>
					</div>';		
					foreach($menu as $menu_key=>$menu_val){
						echo '<div class="row">
								<div class="col-md-2 col-sm-3 col-xs-5 ">
									<span class="menu-label">
										'.$menu_val['name'].'
									</span>
								</div>';
						foreach($roles as $role){
							$checked = (in_array($role['id'], explode(',',$menu_val['assigned_roles']))) ? "checked":" ";	
							echo '<div class="col-md-2 col-sm-3 col-xs-2">
									<div class="checkbox">
										<label>
											<input type="checkbox" value="1" '.$checked.' name="'.$role['id'].'_'.$menu_key.'" readonly="">
										</label>
									</div>
								</div>';
						}
						echo '</div>';
					 } 
				 } ?>

		<br>
		
		<div class="col-sm-offset-2 col-sm-8 row_bottom">
        	
        	<input type="submit" value="<?php echo __("Save");?>" name="save_access_right" class="btn btn-flat btn-success">
        </div>
        
        	
        </form>
		
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
