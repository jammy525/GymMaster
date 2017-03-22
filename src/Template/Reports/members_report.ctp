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
				<?php echo __("Member Report");?>
                    <small><?php echo __("Reports");?></small>
                </h1>
                <ol class="breadcrumb">
                    <a href="<?php echo $this->Gym->createurl("Reports","exportExcel");?>" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Export Excel");?></a>
                    &nbsp;
                    <a href="<?php echo $this->Gym->createurl("Reports","pdfView");?>" class="btn btn-flat btn-custom"><i class="fa fa-pie-chart"></i> <?php echo __("Export Pdf");?></a>
                    &nbsp;
                    <a href="<?php echo $this->Gym->createurl("Reports","pdfView/1");?>" class="btn btn-flat btn-custom"><i class="fa fa-bar-chart"></i> <?php echo __("Print Report");?></a>
                </ol>
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
                        <option value="Continue" <?php if($membership_status=='Continue'){echo "selected";}?>>Continue</option>
                        <option value="Dropped" <?php if($membership_status=='Dropped'){echo "selected";}?>>Dropped</option>
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


		<?php
		if(isset($_REQUEST['attendance_report']))
		{
			$options = Array(
				'title' => __('Member Attendance Report','gym_mgt'),
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
					
				'hAxis' => Array(
						'title' =>  __('Class','gym_mgt'),
						'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
						'textStyle' => Array('color' => '#66707e','fontSize' => 10),
						'maxAlternation' => 2
				),
				'vAxis' => Array(
						'title' =>  __('No of Member','gym_mgt'),
						'minValue' => 0,
						'maxValue' => 5,
						'format' => '#',
						'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
						'textStyle' => Array('color' => '#66707e','fontSize' => 12)
				),
				'colors' => array('#22BAA0','#f25656')
			);
			$GoogleCharts = new GoogleCharts;
			if(isset($report_2) && count($report_2) >0)
			{
				$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
    		?>
            <div id="chart_div" style="width: 100%; height: 500px;margin-top: 100px;"></div>

            <!-- Javascript --> 
            <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
            <script type="text/javascript">
                          <?php echo $chart;?>
            </script>
		<?php }
 if(isset($report_2) && empty($report_2)) {?>

            <div class="clear col-md-12">
                <i>
  <?php echo __("There is not enough data to generate report.");?>
                </i>
            </div>
  <?php }
			
		}
		
	?>	


            <!-- END -->
        </div>	
        <div class="box-body">
            <div class="col-md-6">
		<?php
		 $options = Array(
					 		'title' => __('Member Membership Status'),
 							'colors' => array('#22BAA0','#F25656','#12AFCB')
					 		);
		$GoogleCharts = new GoogleCharts;
		$chart = $GoogleCharts->load( 'PieChart' , 'chart_div' )->get( $chart_array , $options );	
		?>	
		<?php 
		 if(isset($data) && empty($data)) {?>

                <div class="clear col-md-12">
                    <i>
		  <?php echo __("There is not enough data to generate report.");?>
                    </i>
                </div>
                 <?php } ?>
                <div id="chart_div" style="width: 100%; height: 200px;"></div>		  
                <!-- Javascript --> 
                <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
                <script type="text/javascript">
                        <?php if(!empty($data))
                                                {echo $chart;}?>
                </script>

            </div>
            <div class="col-md-6">
                        <?php $options = Array(
					 		'title' => __('Member Location'),
 							'colors' => array('#22BAA0','#F25656','#12AFCB')
					 		);
                        $GoogleChartss = new GoogleCharts;                               
                        $charts = $GoogleChartss->load( 'PieChart' , 'chart_divs' )->get( $chart_array , $options );
                         ?>

		<?php 
		 if(isset($data) && empty($data)) {?>

                <div class="clear col-md-12">
                    <i>
		  <?php echo __("There is not enough data to generate report.");?>
                    </i>
                </div>
                 <?php } ?>
                <div id="chart_divs" style="width: 100%; height: 200px;"></div>		  
                <!-- Javascript --> 
                <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
                <script type="text/javascript">
                        <?php if(!empty($data))
                                                {echo $charts;}?>
                </script>


            </div>
            <hr>
            <!-- Member Listing Report -->

            <!-- -->
        </div>
        <table class="mydataTable table table-striped">
            <thead>
                <tr>
                    <th><?php echo __("Photo");?></th>
                    <th ><?php echo __("Member ID");?></th>
                    <th><?php echo __("Name");?></th>
                    <th ><?php echo __("Email");?></th>
                    <th><?php echo __("Phone");?></th>
                    <th><?php echo __("Location");?></th>
                    <th><?php echo __("Status");?></th>					
                </tr>
            </thead>
            <tbody>
                            <?php
                        // echo "<pre>"; print_r($member_data);
				foreach($member_data as $row)
				{
                                      if($row['assign_class']!='')
                                      {
                                          $location=$this->Gym->get_location_by_class_id($row['assign_class']);
                                      }else{
                                           $location=" --- ";
                                      }
                                      echo "<tr>
					<td><img src='{$this->request->base}/webroot/upload/{$row['image']}' class='membership-img img-circle'></td>
					<td>{$row['member_id']}</td>
                                        <td>{$row['first_name']} {$row['last_name']}</td>
                                        <td>{$row['email']}</td>  
					<td>{$row['mobile']}</td>
                                         <td>{$location}</td>
                                         <td>{$row['membership_status']}</td>
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