<?php $session = $this->request->session()->read("User");?>
<script type="text/javascript">
$(document).ready(function() {
	$(".date").datepicker({
            forceParse: true
        })
});
</script>
<?php //echo $this->Gym->get_js_dateformat($this->Gym->getSettings("date_format"));die; ?>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-calendar"></i>
				<?php echo __("Class Schedules");?>
				<small><?php echo __("Class Schedule");?></small>
			  </h1>
			 <!-- <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("ClassSchedule","classList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Class List");?></a>
			  </ol>-->
			</section>
		</div>
		<hr>
                 <?php echo $this->Form->create("viewSchedules",["class"=>"validateForm form-horizontal","role"=>"form"]);?>
                <div class="box-body">
                    <table class="table table-bordered">
                       
                        <tr>
                            <td width="15%">Search by date: </td><td><?php echo $this->Form->input("",["label"=>false,"placeholder" =>"Search Date","name"=>"search_date","class"=>"date validate[required] form-control","value"=>date($this->Gym->getSettings("date_format"),strtotime($search_date))]);?></td>
                            <td>Search by class name</td><td><?php echo @$this->Form->select("class_name",$class_list,["default"=>$class_name,"empty"=>__("Select Class Name"),"class"=>"form-control"]);?></td>
                            <td><?php echo $this->Form->button(__("Search"),['class'=>"btn btn-flat btn-success col-md-offset-2","name"=>"search"]);?></td>
                        </tr>
                        
                    </table>
                </div>
                <?php echo $this->Form->end();?>
		<div class="box-body">
		<table class="table table-bordered table-striped">
                    <thead>
				<tr>
					<th><?php
                                        $originalDate = $search_date;
                                        echo $newDate = date($this->Gym->getSettings("date_format"), strtotime($originalDate));
                                        $day=date("l", strtotime($originalDate));
                                        ?>
                                        </th>
                                        <th><?php echo __("Classes");?> </th>
					<th><?php echo __("Teacher");?> </th>	
                                        <th><?php echo __("Location");?></th>	
                                         <th><?php echo __("Action");?></th>
					
				</tr>
			</thead>
		<?php
               // echo "<pre>"; print_r($data);echo "</pre>";
                foreach($data as $row){
              // $days = ["Sunday"=>"Sunday","Monday"=>"Monday","Tuesday"=>"Tuesday","Wednesday"=>"Wednesday","Thursday"=>"Thursday","Friday"=>"Friday","Saturday"=>"Saturday"];
		$class_schedule_list=$row['class_schedule_list'];
                foreach($class_schedule_list as $schedule_list)
		{
                    $days=json_decode($schedule_list['days']);
                     
                    if(in_array($day,$days))
				{
                        echo "<tr><td>{$schedule_list['start_time']} - {$schedule_list['end_time']}</td><td>{$row['gym_clas']['name']}";
			//print_r($classes);	
                       /* foreach($classes as $class)
			{
				$days = json_decode($class['days']);
				if(in_array($day,$days))
				{ ?>					
					<div class="btn-group m-b-sm">
						<button class="btn btn-flat btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id="<?php echo $class['id'];?>"><?php echo $this->Gym->get_class_schedule_name($class['class_id']);?><span class="time"> <?php echo "({$class['start_time']}-{$class['end_time']})";?> </span></span><span class="caret"></span></button>
						<ul role="menu" class="dropdown-menu">
							<?php if($session["role_name"] == "administrator" || $session["role_name"] == "staff_member")
							{?>
							<li><a href="<?php echo "{$this->request->base}/ClassSchedule/editClass/{$class['class_id']}";?>"><?php echo __("Edit");?></a></li>
						<?php }else{
							echo "<script>$('.caret').hide();</script>";
						}?>
						<!-- <li><a href="<?php echo "{$this->request->base}/ClassSchedule/deleteClass/{$class['id']}";?>" onClick="return confirm('Are you sure you want to delete this record?');"><?php echo __("Delete");?></a></li> -->
						 </ul>
					</div>
		<?php	}
			}*/	
			echo "</td><td>{$row['gym_member']['first_name']} {$row['gym_member']['last_name']}</td>
                        <td>{$row['gym_location']['location']}</td><td>";?>
                        <div class="btn-group m-b-sm">
                        <button class="btn btn-flat dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i></button>
                        <ul role="menu" class="dropdown-menu" style="right: 0px;">
                         <li><a href="<?php echo "{$this->request->base}/ClassSchedule/editSchedule/".$schedule_list['id'];?>"><i class="fa fa-pencil" aria-hidden="true"></i><?php echo __("Edit class setup");?></a></li>
                         <li><a href="<?php echo "{$this->request->base}/ClassSchedule/deleteSchedule/".$schedule_list['id'];?>"  onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-ban" aria-hidden="true"></i><?php echo __("delete class schedule");?></a></li>
                         <li><a href="<?php echo "{$this->request->base}/ClassSchedule/editClass/".$row['id'];?>"><i class="fa fa-user" aria-hidden="true"></i><?php echo __("Change instrucor");?></a></li>
                         <!--<li><a href="<?php echo "{$this->request->base}/ClassSchedule/editClass/";?>"><?php echo __("Assign Location");?></a></li>-->
                         <!-- <li><a href="<?php echo "{$this->request->base}/ClassSchedule/deleteClass/{$class['id']}";?>" onClick="return confirm('Are you sure you want to delete this record?');"><?php echo __("Delete");?></a></li> -->
                         </ul>
                        </div>
                       <?php echo "</td></tr>";
                        
                 }     
		}
                }
		?>
                                           
		</table>
		</div>		
	</div>
</section>
