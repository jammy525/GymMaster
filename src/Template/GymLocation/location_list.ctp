<?php $session = $this->request->session()->read("User");?>
<script>
$(document).ready(function(){		
	$(".mydataTable").DataTable({
		"responsive": true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                 
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},	 
                          {"bSortable": true},
	                  {"bSortable": false}],
	"language" : {<?php echo $this->Gym->data_table_lang();?>}
	});
});		
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-map-marker"></i>
				<?php echo __("Location List");?>
				<small><?php echo __("Location");?></small>
			  </h1>
			  <?php
			if($session["role_name"] == "administrator" || $session["role_name"] == "licensee" || $session["id"] == 1 || $session["id"] == 2 ){ ?>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("GymLocation","addLocation");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Location");?></a>
			  </ol>
			<?php } ?>
			</section>
		</div>
		<hr>
		<div class="box-body">
                    <table class="mydataTable table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __("Title");?></th>
                                <th><?php echo __("Location");?></th>
                                <th><?php echo __("Created By");?></th>
                                <th><?php echo __("Status");?></th>
                                <th><?php echo __("Created Date");?></th>
                                <th><?php echo __("Action");?></th>
                            </tr>
                        </thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
				echo "<tr>";
				echo "<td>{$row['title']}</td>
					  <td>{$row['location']}</td>
                                          <td>{$row['gym_member']['first_name']}</td>
					  <td>".(($row['status']) ? '<span class="label label-success">Active</span>' :'<span class="label label-warning">Inactive</span>')."</td>
                                          <td>".date('M d,Y H:i A',time($row['created_date'])) ."</td>
					  <td>";
				if($session["role_name"] == "administrator" || $session["role_name"] == "licensee")
				{
					echo " <a href='".$this->request->base ."/GymLocation/editLocation/{$row['id']}' class='btn btn-flat btn-primary' title='".__('Edit')."'><i class='fa fa-edit'></i></a>
						<a href='{$this->request->base}/GymLocation/deleteLocation/{$row['id']}' class='btn btn-flat btn-danger' title='".__('Delete')."' onclick=\"return confirm('Are you sure you want to delete this location?')\"><i class='fa fa-trash'></i></a>";
				}
				echo  " <a href='javascript:void(0)' id='{$row['id']}' data-url='".$this->request->base ."/GymAjax/view-location' class='view_jmodal btn btn-flat btn-info' title='".__('View')."' ><i class='fa fa-eye'></i> ".__('View')."</a>";    
				echo  "</td>";
				echo  "</tr>";
			}
			?>
			<tfoot>
                            <tr>
                                <th><?php echo __("Title")?></th>
                                <th><?php echo __("Location");?></th>
                                <th><?php echo __("Created By");?></th>
                                <th><?php echo __("Status");?></th>
                                <th><?php echo __("Created Date");?></th>
                                <th><?php echo __("Action");?></th>
                            </tr>
			</tfoot>	
                    </table>
		<!-- END -->
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
