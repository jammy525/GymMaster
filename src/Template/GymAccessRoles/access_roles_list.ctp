<?php $session = $this->request->session()->read("User");?>
<script>
$(document).ready(function(){		
	$(".mydataTable").DataTable({
		"responsive": true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},	                           
	                  {"bSortable": false}],
	"language" : {<?php echo $this->Gym->data_table_lang();?>}	
	});
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
				<i class="fa fa-bars"></i>
				<?php echo __("Access Roles List");?>
				<small><?php echo __("Roles");?></small>
			  </h1>
			  <?php
				if($session["role_name"] == "administrator")
				{ ?>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymAccessRoles","addAccessRoles");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Access Roles");?></a>
			  </ol>
			  <?php } ?>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<table class="mydataTable table table-striped">
			<thead>
				<tr>
					<th><?php echo __("Role Name");?></th>
					<th><?php echo __("Role Slug");?></th>
					<th><?php echo __("Role Status ");?></th>					
					<th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
				$status = ($row['status'] == "1") ? "Active" : "Deactive";	
				echo "
				<tr>					
					<td>{$row['name']}</td>
					<td>{$row['slug']}</td>
					<td>{$status}</td>
					<td>";			
				if($session["role_name"] == "administrator")
				{ 
				echo "<a href='".$this->Gym->createurl('GymAccessRoles','editAccessRoles')."/{$row['id']}' class='btn btn-flat btn-primary' title='Edit'><i class='fa fa-edit'></i></a>
					<a href='".$this->Gym->createurl('GymGroup','deleteAccessRoles')."/{$row['id']}' class='btn btn-flat btn-danger' title='Delete' onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fa fa-trash-o'></i></a>";
				}
					//echo " <a href='javascript:void(0)' data-url='".$this->request->base ."/GymAjax/viewAccessRole/{$row['slug']}' class='view-grp-member btn btn-flat btn-info' id={$row['id']}><i class='fa fa-eye'></i> ".__("View")."</a>
					echo "
					</td>
				</tr>
				";
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Role Name");?></th>
					<th><?php echo __("Role Slug");?></th>
					<th><?php echo __("Role Status ");?></th>					
					<th><?php echo __("Action");?></th>
				</tr>
			</tfoot>
		</table>
		</div>	
		<div class="overlay gym-overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</section>