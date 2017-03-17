<?php $session = $this->request->session()->read("User");?>
<script>
$(document).ready(function(){		
	$(".mydataTable").DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[	                 
	                  {"bSortable": true},
	                  {"bSortable": true},
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
				<i class="fa fa-bars"></i>
				<?php echo __("Member Note List");?>
				<small><?php echo __("Note");?></small>
			  </h1>
			  <?php
			if($session["role_name"] == "staff_member")
			{ ?>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("CustomerNotes","addCustomerNotes");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Customer Notes");?></a>
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
					<th><?php echo __("Comment");?></th>
					<th><?php echo __("Note For");?></th>
					<th><?php echo __("Class");?></th>
                                        <th><?php echo __("Added By");?></th>
                                        <th><?php echo __("Asso. Licensee");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
                            //echo '<pre>';print_r($row);die;
				echo "<tr>";
                                    echo "<td>{$row['note_title']}</td>
                                        <td>{$row['comment']}</td>
                                        <td>". ucwords($row['NoteForCN']['first_name'] . " " . $row['NoteForCN']['last_name'])."</td>
                                        <td>". ($row['gym_clas']['name']) ."</td>
                                        <td>". ucwords($row['CreatedByCN']['first_name'] . " " . $row['CreatedByCN']['last_name']) ."</td>
                                        <td>". ucwords($row['AssociatedLicenseeCN']['first_name'] . " " . $row['AssociatedLicenseeCN']['last_name']) ."</td>
                                        <td>";
                                        if($session["id"] == $row['CreatedByCN']['id'] || $session["role_id"] == 1 || $session["role_id"] == 2){
                                                echo " <a href='".$this->request->base ."/customer-notes/edit-customer-notes/{$row['id']}' class='btn btn-flat btn-primary' title='".__('Edit')."'><i class='fa fa-edit'></i></a>
                                                        <a href='{$this->request->base}/customer-notes/delete-customer-notes/{$row['id']}' class='btn btn-flat btn-danger' title='".__('Delete')."' onclick=\"return confirm('Are you sure you want to delete this product?')\"><i class='fa fa-trash'></i></a>";
                                        }
                                        echo  " <a href='javascript:void(0)' id='{$row['id']}' data-url='".$this->request->base ."/GymAjax/view_customer_notes' class='view_jmodal btn btn-flat btn-info' title='".__('View')."' ><i class='fa fa-eye'></i> ".__('View')."</a>";    
                                        echo  "</td>";
                                echo  "</tr>";
			}
			?>
			<tfoot>
				<tr>
					<th><?php echo __("Title");?></th>
					<th><?php echo __("Comment");?></th>
					<th><?php echo __("Note For");?></th>
					<th><?php echo __("Class");?></th>
                                        <th><?php echo __("Added By");?></th>
                                        <th><?php echo __("Asso. Licensee");?></th>
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
