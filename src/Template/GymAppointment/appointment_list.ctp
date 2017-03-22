<?php $session = $this->request->session()->read("User");?>
<script>
$( function() {
    $( document ).tooltip();
  } );
  </script>
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
	                  {"bSortable": true},	                                            
	                  {"bSortable": false,"visible":false}],
	"language" : {<?php echo $this->Gym->data_table_lang();?>}	
	});
});		
</script>
<?php
if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member" || $session["role_name"] == "accountant")
{ ?>
<script>

$(document).ready(function(){
	var table = $(".mydataTable").DataTable();
	table.column(5).visible( true );
});
</script>
<?php } ?>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-bars"></i>
				<?php echo __("Appointment List");?>
				<small><?php echo __("Appointment");?></small>
			  </h1>
			   <?php
			if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member" || $session["role_name"] == "accountant")
			{ ?>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("GymAppointment","addAppointment");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Appointment");?></a>
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
                                        <th><?php echo __("Class Name");?></th>
					<th><?php echo __("Start Date");?></th>
					<th><?php echo __("End Date");?></th>
					<th><?php echo __("Time");?></th>
					<th><?php echo __("Staus");?></th>
                                        <th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
                           // echo "<pre>"; print_r($row);
                              if($row['status']==1){$style="style='color:#22BAA0'";$status="Open";}else{$style="style='color:#F25656'"; $status="Closed";}
				echo "<tr>
					<td>{$row['appointment_name']}</td>
                                         <td>{$row['gym_clas']['name']}</td>
					<td>".date($this->Gym->getSettings("date_format"),strtotime($row["appointment_date"]))."</td>
                                        <td>".date($this->Gym->getSettings("date_format"),strtotime($row["appointment_end_date"]))."</td>
					<td>{$row['start_time']}--{$row['end_time']}</td>
					<td {$style}>{$status}</td>
					<td>
						<a href='".$this->request->base ."/GymAppointment/editAppointment/{$row['id']}' class='btn btn-primary btn-flat' title='Edit'><i class='fa fa-edit'></i> </a>
						<a href='".$this->request->base ."/GymAppointment/deleteAppointment/{$row['id']}' class='btn btn-danger btn-flat' title='Delete' onclick=\"return confirm('Are you sure you want to delete this record?')\"><i class='fa fa-trash'></i></a>
					</td>
				</tr>";
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Title");?></th>
                                        <th><?php echo __("Class Name");?></th>
					<th><?php echo __("Start Date");?></th>
					<th><?php echo __("End Date");?></th>
					<th><?php echo __("Time");?></th>
                                        <th><?php echo __("Staus");?></th>
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
