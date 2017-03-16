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
				<?php echo __("Class List");?>
				<small><?php echo __("Class");?></small>
			  </h1>
	
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymClass","addClasses");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Class");?></a>
			  </ol>

			</section>
		</div>
		<hr>
		<div class="box-body">
		<table class="mydataTable table table-striped">
			<thead>
				<tr>
					<th><?php echo __("Photo");?></th>
					<th><?php echo __("Class Name");?></th>
					<th><?php echo __("Class Type");?></th>	
                                        <th><?php echo __("Class Schedule");?></th>	
                                         <th><?php echo __("Created Date");?></th>
					<th><?php echo __("Action");?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
                           
				$image = ($row['image'] == "") ? "logo.png" : $row['image'];
				echo "
				<tr>					
					<td><img src='".$this->request->webroot ."upload/{$image}' class='membership-img img-circle'></img></td>
					<td>{$row['name']}</td>
					<td>".$this->Gym->get_class_type($row["class_type_id"])."</td>";
                                        
                                  if($this->Gym->get_classes_scheduled_by_id($row["id"])>0)
                                  {
                                    echo "<td><a href='{$this->request->base}/class-schedule/class-list/{$row['id']}' title='Scheduled'>".$this->Gym->get_classes_scheduled_by_id($row["id"])." Scheduled</a> | <a href='{$this->request->base}/class-schedule/add-class/{$row['id']}' title='Add Scheduled'> <i class='fa fa-plus'></i> Schedule</a> </td>";  
                                  }else{
                                      echo "<td>Not Scheduled | <a href='{$this->request->base}/class-schedule/add-class/{$row['id']}' title='Add Scheduled'> <i class='fa fa-plus'></i> Schedule</a></td>";
                                      
                                  }
                                    
                                         echo "<td>".date('M d,Y H:i A',time($row['created_date'])) ."</td>
					<td>";			
				if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member" || $session["role_name"] == "licensee" ||$session["role_name"] == "accountant")
				{ 
				echo "<a href='".$this->Gym->createurl('GymClass','editClasses')."/{$row['id']}' class='btn btn-flat btn-primary' title='Edit'><i class='fa fa-edit'></i></a>
					<a href='".$this->Gym->createurl('GymClass','deleteClasses')."/{$row['id']}' class='btn btn-flat btn-danger' title='Delete' onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fa fa-trash-o'></i></a>";
				}
					echo "</td>
				</tr>
				";
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo __("Photo");?></th>
					<th><?php echo __("Class Name");?></th>
					<th><?php echo __("Class Type");?></th>	
                                        <th><?php echo __("Class Schedule");?></th>	
                                         <th><?php echo __("Created Date");?></th>
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
