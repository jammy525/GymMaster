<script type="text/javascript">
    $(document).ready(function () {
        $('.sdate').datepicker({dateFormat: "yy-mm-dd"});
        $('.edate').datepicker({dateFormat: "yy-mm-dd"});
    });
</script>

<script>
    $(document).ready(function () {
        var table = $(".mydataTable").DataTable({
            "bPaginate": true,
            "bFilter": false,
            "bInfo": false
        });
        //table.column(4).visible( false );
    });
</script>

<section class="content">
    <br>
    <div class="col-md-12 box box-default">		
        <div class="box-header">
            <section class="content-header">
                <h1>
                    <i class="fa fa-bar-chart"></i>
				<?php echo __("Membership Report");?>
                    <small><?php echo __("Reports");?></small>
                </h1>
               
            </section>
        </div>
        <hr>
        <div class="box-body">
            <form method="post">  
                <div class="form-group col-md-2">
                    <div><strong><?php echo __('Search By');?></strong></div>
                </div>
                <div class="form-group col-md-3">
                    <select name="membership_status" class="form-control" >
                        <option value="">Select Membership Status</option>
                        <option value="Continue" <?php if($membership_status=='Continue'){echo "selected";}?>>Active</option>
                        <!--<option value="Dropped" <?php if($membership_status=='Dropped'){echo "selected";}?>>Dropped</option>-->
                        <option value="Expired" <?php if($membership_status=='Expired'){echo "selected";}?>>Expired</option>
                        
                    </select>

                </div>
                <div class="form-group col-md-3">
				<?php echo @$this->Form->select("location_id",$location,["default"=>$location_id,"empty"=>__("Select Location"),"class"=>"form-control location_list"]);?>		
                </div>
                <div class="form-group col-md-4">
                    <input type="submit" name="attendance_report" Value="<?php echo __('Search');?>"  class="btn btn-flat btn-success"/>
                </div> 


            </form>
 <!-- END -->
        </div>	
        <hr>
         <?php
          if($membership_status==''){$membership_status=0;}
           if($location_id==''){$location_id=0;}
         ?>
        <section class="content-header">
                <ol class="breadcrumb">
                    <a href="<?php echo $this->Gym->createurl("Reports","exportExcel/".$membership_status.'/'.$location_id);?>" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Export Excel");?></a>
                    &nbsp;
                    <a href="<?php echo $this->Gym->createurl("Reports","pdfView/".$membership_status.'/'.$location_id);?>" class="btn btn-flat btn-custom"><i class="fa fa-pie-chart"></i> <?php echo __("Export Pdf");?></a>
                    &nbsp;
                    <a href="<?php echo $this->Gym->createurl("Reports","pdfView/".$membership_status.'/'.$location_id.'/1');?>" target="_blank" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Print Report");?></a>
                </ol>
            </section>
        <br>
        <table class="mydataTable table table-striped">
            <thead>
                <tr>
                    <th><?php echo __("Photo");?></th>
                    <th ><?php echo __("Member ID");?></th>
                    <th><?php echo __("Name");?></th>
                    <th ><?php echo __("Email");?></th>
                    <th><?php echo __("Phone");?></th>
                    <th style="width:20%"><?php echo __("Location");?></th>
                    <th><?php echo __("Status");?></th>					
                </tr>
            </thead>
            <tbody>
                            <?php
                        // echo "<pre>"; print_r($member_data);
				foreach($member_data as $row)
				{
                                      echo "<tr>
					<td><img src='{$this->request->webroot}upload/{$row['image']}' class='membership-img img-circle'></td>
					<td>{$row['member_id']}</td>
                                        <td>{$row['first_name']} {$row['last_name']}</td>
                                        <td>{$row['email']}</td>  
					<td>{$row['mobile']}</td>
                                         <td>{$this->Gym->get_member_report_location($row['associated_licensee'])}</td>
                                         <td>{$this->Gym->get_member_report_plan_status($row['selected_membership'],$row['id'])}</td>
					</tr>";
				}
			?>
            </tbody>
            </tbody>
        </table>
        <div class="overlay gym-overlay">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>
</section>