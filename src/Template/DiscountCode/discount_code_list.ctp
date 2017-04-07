<?php 
$session = $this->request->session()->read("User");
?>
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
				<?php echo __("Discount Code List");?>
				<small><?php echo __("Discount Code");?></small>
			  </h1>
			  <?php
			if($session["role_name"] == "administrator" || $session["role_name"] == "licensee" || $session["id"] == 1 || $session["id"] == 2 ){ ?>
			  <ol class="breadcrumb">				
				<a href="<?php echo $this->Gym->createurl("DiscountCode","addDiscountCode");?>" class="btn btn-flat btn-custom"><i class="fa fa-plus"></i> <?php echo __("Add Discount Code");?></a>
			  </ol>
			<?php } ?>
			</section>
		</div>
		<hr>
		<div class="box-body">
                    <table class="mydataTable table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __("Code");?></th>
                                <th><?php echo __("Discount");?></th>
                                <th><?php echo __("Membership");?></th>
                                <th><?php echo __("Created By");?></th>
                                <th><?php echo __("Created On");?></th>
                                <th><?php echo __("Expires On");?></th>
                                <th><?php echo __("Status");?></th>
                                <th><?php echo __("Action");?></th>
                            </tr>
                        </thead>
			<tbody>
			<?php
			foreach($data as $row)
			{
                            $membershipIdsArr = json_decode($row['membership'], true);
                            $membershipIds = implode(',', $membershipIdsArr);
                            $membershipArr = $this->Gym->get_membership_names($membershipIds);
                            //echo '<pre>';print_r($membershipArr);die;
                            $membershipList = '';
                            foreach($membershipArr as $membership){
                                $membershipList .= '<span class="badge">'.$membership['membership_label'].'</span>';
                            }
                            
                            $expires_on = (isset($row['valid_till']) && $row['valid_till'] == 1) ? '<span class="label label-warning">No Exipry</span>' : (date($this->Gym->getSettings("date_format"),($row['valid_till'])));
				echo "<tr>";
				echo "<td>{$row['code']}</td>
                                    <td>{$row['discount']}%</td>
                                    <td>".$membershipList."</td>
                                    <td>".$this->Gym->get_user_name($row['gym_member']['id'])."</td>
                                    <td>".date($this->Gym->getSettings("date_format"),strtotime($row['created_at']))." </td>
                                    <td>".$expires_on." </td>
                                    <td>".(($row['status']) ? '<span class="label label-success">Active</span>' :'<span class="label label-warning">Inactive</span>')."</td>
                                    <td>";
				if($session["role_name"] == "administrator" || $session["role_name"] == "licensee")
				{
					echo " <a href='".$this->request->base ."/discount-code/edit-discount-code/{$row['id']}' class='btn btn-flat btn-primary' title='".__('Edit')."'><i class='fa fa-edit'></i></a>
						<a href='{$this->request->base}/discount-code/delete-discount-code/{$row['id']}' class='btn btn-flat btn-danger' title='".__('Delete')."' onclick=\"return confirm('Are you sure you want to delete this code?')\"><i class='fa fa-trash'></i></a>";
				}
				echo  "</td>";
				echo  "</tr>";
			}
			?>
			<tfoot>
                            <tr>
                                <th><?php echo __("Code");?></th>
                                <th><?php echo __("Discount");?></th>
                                <th><?php echo __("On Membership");?></th>
                                <th><?php echo __("Created By");?></th>
                                <th><?php echo __("Created On");?></th>
                                <th><?php echo __("Expires On");?></th>
                                <th><?php echo __("Status");?></th>
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
