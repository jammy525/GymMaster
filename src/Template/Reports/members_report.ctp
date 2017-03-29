<script type="text/javascript">
$(document).ready(function() {
   $("#startdate").datepicker({
        todayBtn:  1,
        autoclose: true,
        forceParse: false

        
        
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
    });

    $("#enddate").datepicker({  forceParse: false})
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        });
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
				<?php echo __("Member Report");?>
                    <small><?php echo __("Reports");?></small>
                </h1>
               
            </section>
        </div>
        <hr>
        <div class="box-body">
            <form method="post">  
               
                <label  class="control-label col-md-2" ><?php echo __('Select Member');?></label>
                <div class="form-group col-md-2">
                    <select name="member_type" class="form-control" >
                        <option value="all">All Member</option>
                        <option value="new">New Member</option>
                         <option value="old">Old Member</option>
                     </select>

                </div>
                 <label  class="control-label col-md-1" ><?php echo __('From');?></label>
                <div class="form-group col-md-2">
                    <input type="text" name="startdate" data-date-format="<?php echo $this->Gym->get_js_dateformat($this->Gym->getSettings("date_format")); ?>" id="startdate" class="form-control" value="<?php echo date($this->Gym->getSettings("date_format"),$startdate);?>">		
                </div>
                  <label  class="control-label col-md-1" ><?php echo __('To');?></label>
                <div class="form-group col-md-2">
                    <input type="text" name="enddate" data-date-format="<?php echo $this->Gym->get_js_dateformat($this->Gym->getSettings("date_format")); ?>" id="enddate" class="form-control" value="<?php echo date($this->Gym->getSettings("date_format"),$enddate);?>">		
                </div>
                <div class="form-group col-md-1">
                    <input type="submit" name="attendance_report" Value="<?php echo __('Search');?>"  class="btn btn-flat btn-success"/>
                </div> 


            </form>
 <!-- END -->
        </div>	
        <hr>
         
        <section class="content-header">
                <ol class="breadcrumb">
                    <a href="<?php echo $this->Gym->createurl("Reports","mexportExcel/".$startdate.'/'.$enddate);?>" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Export Excel");?></a>
                    &nbsp;
                    <a href="<?php echo $this->Gym->createurl("Reports","mpdfView/".$startdate.'/'.$enddate);?>" class="btn btn-flat btn-custom"><i class="fa fa-pie-chart"></i> <?php echo __("Export Pdf");?></a>
                    &nbsp;
                    <a href="<?php echo $this->Gym->createurl("Reports","mpdfView/".$startdate.'/'.$enddate.'/1');?>" target="_blank" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Print Report");?></a>
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