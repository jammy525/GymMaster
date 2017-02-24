<?php 
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

Class GymAjaxController extends AppController
{
	public function initialize()
	{
		parent::initialize();	
		$this->autoRender = false;
	}
	
	public function addCategory()
	{
		$category_table = TableRegistry::get("Category");
		$categories = $category_table->find("all");
		$categories = $categories->toArray();
		if($this->request->is('ajax'))
		{	
		?>	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Category");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="cat_name form-control" placeholder="<?php echo __("enter category name");?>">
				</div>
				<div class="col-sm-4">
					<button class="add-category btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveCategory";?>"><?php echo  __("Add Category");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="category_list">
					<thead>
						<tr>
							<th><?php echo __("Category");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($categories as $category)
						{
							echo "<tr id='row-{$category->id}'>
							<td>{$category->name}</td>
							<td><button class='del-category btn btn-flat btn-danger' del-id='{$category->id}' data-url='{$this->request->base}/GymAjax/deleteCategory'>".__("Delete")."</button></td>
							</tr>";
						}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
		<?php	
		}		
	}
	
	public function saveCategory()
	{
		$return = array();
		$category_table = TableRegistry::get("Category");
		$category = $category_table->newEntity();
		$name = $this->request->data['name'];
		$category->name = $name;
		if($category_table->save($category))
		{
			$id = $category->id;
			$return[0] = "<tr id='row-{$id}'><td>{$name}</td><td><button del-id='{$id}' class='del-category btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteCategory'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$name}</option>";
			echo json_encode($return);
		}else{
			echo false;
		}		
	}
	
	public function deleteCategory()
	{
		$category_table = TableRegistry::get("Category");		
		$did = $this->request->data['did'];
		$row = $category_table->get($did);
		if($category_table->delete($row))
		{echo true;} else {echo false;}
	}
	
	public function addInstalmentPlan()
	{
		$plan_table = TableRegistry::get("Installment_Plan");
		$plans = $plan_table->find("all");
		$plans = $plans->toArray();
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Instalment Plan");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4">
					<input type="text" name="number" id="number" class="cat_name form-control" placeholder="<?php echo __("Enter Duration Number");?>">
				</div>
				<div class="col-sm-3 no-padding">
					<select name="duration" id="duration" class="form-control">
						<option value=""><?php echo __("Select Duration");?></option>
						<option value="Days"><?php echo __("Days");?></option>
						<option value="Week"><?php echo __("Week");?></option>
						<option value="Month"><?php echo __("Month");?></option>
						<option value="Year"><?php echo __("Year");?></option>						
					</select>
				</div>
				<div class="col-sm-2">
					<button class="add-plan btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/savePlan";?>"><?php echo  __("Add Category");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="plan_list">
					<thead>
						<tr>
							<th><?php echo __("Plan");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($plans as $plan)
						{
							echo "<tr id='row-{$plan->id}'>
							<td>{$plan->number} {$plan->duration}</td>
							<td><button class='del-plan btn btn-flat btn-danger' del-id='{$plan->id}' data-url='{$this->request->base}/GymAjax/deletePlan'>".__("Delete")."</button></td>
							</tr>";
						}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
		<?php
	}
	
	public function savePlan()
	{
		$plan_table = TableRegistry::get("Installment_Plan");
		$plan = $plan_table->newEntity();
		$return = array();
		$number = $this->request->data['number'];
		$duration = $this->request->data['duration'];
		$plan->number = intval($number);
		$plan->duration = $duration;
		if($plan_table->save($plan))
		{
			$id = $plan->id;
			$return[0] = "<tr id='row-{$id}'><td>{$number} {$duration}</td><td><button del-id='{$id}' class='del-plan btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deletePlan'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$number} {$duration}</option>";
			echo json_encode($return);			
		}	
	}
	
	public function deletePlan()
	{
		$plan = TableRegistry::get("Installment_Plan");
		$row = $plan->get($this->request->data['did']);
		if($plan->delete($row))
		{echo true;} else {echo false;}
	}
	
	public function deleteMembership()
	{
		$did = $this->request->data['did'];
		$membership_table = TableRegistry::get("Membership");
		$row = $membership_table->get($did);
		echo ($membership_table->delete($row)) ? true : false ;		
	}
	
	public function addRole()
	{
		$role_table = TableRegistry::get("GymRoles");
		$roles = $role_table->find()->all()->toArray();		
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Role");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="role_name form-control" placeholder="<?php echo __("Enter Role");?>">
				</div>
				<div class="col-sm-4">
					<button class="save-role btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveRole";?>"><?php echo  __("Add Role");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="roles_list">
					<thead>
						<tr>
							<th><?php echo __("Category");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($roles))
					{
						foreach($roles as $role)
						{
							echo "<tr id='row-{$role->id}'>
							<td>{$role->name}</td>
							<td><button class='del-role btn btn-flat btn-danger' del-id='{$role->id}' data-url='{$this->request->base}/GymAjax/deleteRole/{$role->id}'>".__("Delete")."</button></td>
							</tr>";
						}
					}else{echo "<tr><td colspan='2'>".__("No roles added")."</td></tr>";}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
	<?php
	}
	
	public function saveRole()
	{
		$return = array();
		$role_table = TableRegistry::get("GymRoles");
		$role = $role_table->newEntity();
		$name = $this->request->data['role'];
		$role->name = $name;
		if($role_table->save($role))
		{
			$id = $role->id;
			$return[0] = "<tr id='row-{$id}'><td>{$name}</td><td><button del-id='{$id}' class='del-role btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteRole/{$id}'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$name}</option>";
			echo json_encode($return);
		}else{
			echo false;
		}		
	}
	
	public function deleteRole($did)
	{
		//$did = $this->request->data['did'];
		$role_table = TableRegistry::get("GymRoles");
		$row = $role_table->get($did);
		echo ($role_table->delete($row)) ? true : false ;		
	}
        
        public function addLocation(){
            $location_table = TableRegistry::get("GymLocation");
            $locations = $location_table->find()->contain(["GymMember"])->where(["status"=>1])->all()->toArray();		
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Location");?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <input type="text" class="location_name form-control" placeholder="<?php echo __("Enter Location");?>">
                    </div>
                    <div class="col-sm-4">
                        <button class="save-location btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveLocation";?>"><?php echo  __("Add Location");?></button>
                    </div>
		</div>
		<hr>
		<div class="row">
                    <div class="col-sm-12 table table-striped">
                        <table class="table" id="location_list">
                            <thead>
                                <tr>
                                    <th><?php echo __("Location Name");?></th>
                                    <th><?php echo __("Created By");?></th>
                                    <th><?php echo __("Action");?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($locations)){
                                    foreach($locations as $location){
                                        $delPermission = 'true';
                                        if($this->request->session()->read("User.role_id") != 1){
                                            if($location->created_by != $this->request->session()->read("User.id")){
                                                $delPermission = 'false';
                                            }
                                        }
                                        echo "<tr id='row-{$location->id}'>
                                        <td>{$location->location}</td>
                                        <td>{$location->gym_member->first_name}</td>
                                        <td><button class='del-location btn btn-flat btn-danger' del-permission='{$delPermission}' del-id='{$location->id}' data-url='{$this->request->base}/GymAjax/deleteLocation/{$location->id}'>".__("Delete")."</button></td>
                                        </tr>";
                                    }
                                }else{echo "<tr><td colspan='2'>".__("No location added")."</td></tr>";}
                                ?>
                            </tbody>
			</table>
                    </div>
		</div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
            </div>
	<?php
	}
        
        public function saveLocation(){ 
            $return = array();
            $location_table = TableRegistry::get("GymLocation");
            $location = $location_table->newEntity();
            $name = $this->request->data['location'];
            $location->location = $name;
            $location->title = $name;
            $location->created_by = $this->request->session()->read("User.id");
            if($location_table->save($location)){
                $id = $location->id;
                $return[0] = "<tr id='row-{$id}'><td>{$name}</td><td>".$this->request->session()->read("User.display_name")."</td><td><button del-id='{$id}' class='del-location btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteLocation/{$id}'>".__("Delete")."</button></td></tr>";
                $return[1] = "<option value='{$id}'>{$name}</option>";
                echo json_encode($return);
            }else{
                echo false;
            }		
	}
	
	public function deleteLocation($did){
            //$did = $this->request->data['did'];
            $location_table = TableRegistry::get("GymLocation");
            $row = $location_table->get($did);
            echo ($location_table->delete($row)) ? true : false ;		
	}
	
	public function AddSpecialization()
	{
		if($this->request->is("ajax"))
		{
		$specialization_table = TableRegistry::get("Specialization");
		$specialization = $specialization_table->find()->all()->toArray();		
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Specialization");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="spec_name form-control" placeholder="<?php echo __("Enter Specialization");?>">
				</div>
				<div class="col-sm-4">
					<button class="save-spec btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveSpecialization";?>"><?php echo  __("Add Role");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="specialization_list">
					<thead>
						<tr>
							<th><?php echo __("Category");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($specialization))
					{
						foreach($specialization as $spec)
						{
							echo "<tr id='row-{$spec->id}'>
							<td>{$spec->name}</td>
							<td><button class='del-spec btn btn-flat btn-danger' del-id='{$spec->id}' data-url='{$this->request->base}/GymAjax/deleteSpecialization/{$spec->id}'>".__("Delete")."</button></td>
							</tr>";
						}
					}else{echo "<tr><td colspan='2'>".__("No roles added")."</td></tr>";}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
			<?php
			die;
		}
	}
	
	public function saveSpecialization()
	{
		$return = array();
		$specialization_table = TableRegistry::get("Specialization");
		$spec = $specialization_table->newEntity();
		$name = $this->request->data['name'];
		$spec->name = $name;
		if($specialization_table->save($spec))
		{
			$id = $spec->id;
			$return[0] = "<tr id='row-{$id}'><td>{$name}</td><td><button del-id='{$id}' class='del-spec btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteSpecialization/{$id}'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$name}</option>";
			echo json_encode($return);
		}else{
			echo false;
		}		
	}
	
	public function deleteSpecialization($did)
	{		
		$specialization_table = TableRegistry::get("Specialization");
		$row = $specialization_table->get($did);
		echo ($specialization_table->delete($row)) ? true : false ;		
	}
	
	public function interestList()
	{
		$interest_table = TableRegistry::get("GymInterestArea");
		$interest = $interest_table->find()->all()->toArray();		
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Interest");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="interest form-control" placeholder="<?php echo __("Enter Interest");?>">
				</div>
				<div class="col-sm-4">
					<button class="save-interest btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveInterest";?>"><?php echo  __("Add Interest");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="interest_list">
					<thead>
						<tr>
							<th><?php echo __("Interest");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($interest))
					{
						foreach($interest as $row)
						{
							echo "<tr id='row-{$row->id}'>
							<td>{$row->interest}</td>
							<td><button class='del-interest btn btn-flat btn-danger' del-id='{$row->id}' data-url='{$this->request->base}/GymAjax/deleteInterest/{$row->id}'>".__("Delete")."</button></td>
							</tr>";
						}
					}else{echo "<tr><td colspan='2'>".__("No record added yet")."</td></tr>";}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
	<?php
	}	
	
	public function saveInterest()
	{
		$return = array();
		$interest_table = TableRegistry::get("GymInterestArea");
		$interest_row = $interest_table->newEntity();
		$interest = $this->request->data['interest'];
		$interest_row->interest = $interest;
		if($interest_table->save($interest_row))
		{
			$id = $interest_row->id;
			$return[0] = "<tr id='row-{$id}'><td>{$interest}</td><td><button del-id='{$id}' class='del-interest btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteInterest/{$id}'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$interest}</option>";
			echo json_encode($return);
		}else{
			echo false;
		}		
	}
	
	public function deleteInterest($did)
	{		
		$interest_table = TableRegistry::get("GymInterestArea");
		$row = $interest_table->get($did);
		echo ($interest_table->delete($row)) ? true : false ;		
	}
	
	public function sourceList()
	{
		$interest_table = TableRegistry::get("gymSource");
		$source = $interest_table->find()->all()->toArray();		
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Source");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="source form-control" placeholder="<?php echo __("Enter Source");?>">
				</div>
				<div class="col-sm-4">
					<button class="save-source btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveSource";?>"><?php echo  __("Add Source");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="source_list">
					<thead>
						<tr>
							<th><?php echo __("Source List");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($source))
					{
						foreach($source as $row)
						{
							echo "<tr id='row-{$row->id}'>
							<td>{$row->source_name}</td>
							<td><button class='del-source btn btn-flat btn-danger' del-id='{$row->id}' data-url='{$this->request->base}/GymAjax/deleteSource/{$row->id}'>".__("Delete")."</button></td>
							</tr>";
						}
					}else{echo "<tr><td colspan='2'>".__("No record added yet")."</td></tr>";}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
	<?php
	}
	
	public function saveSource()
	{
		$return = array();
		$source_table = TableRegistry::get("gymSource");
		$row = $source_table->newEntity();
		$source = $this->request->data['source'];
		$row->source_name = $source;
		if($source_table->save($row))
		{
			$id = $row->id;
			$return[0] = "<tr id='row-{$id}'><td>{$source}</td><td><button del-id='{$id}' class='del-source btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteSource/{$id}'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$source}</option>";
			echo json_encode($return);
		}else{
			echo false;
		}		
	}
	
	public function deleteSource($did)
	{		
		$source_table = TableRegistry::get("gymSource");
		$row = $source_table->get($did);
		echo ($source_table->delete($row)) ? true : false ;		
	}
	
	public function getMembershipEndDate()
	{
		$this->loadComponent("GYMFunction");
		$format = $this->GYMFunction->date_format();
		// $format = str_ireplace(array("yyyy","yy","dd","mm"),array("y","y","d","m"),$format);
		// $format = str_replace("yy","Y",$format);
		// $format = str_replace("dd","d",$format);
		// $format = str_replace("mm","m",$format);
		$date = $this->request->data["date"];
		$date = str_replace("/","-",$date);
		$membership_id = $this->request->data["membership"];
		$date1 = date("Y-m-d",strtotime($date));
		$membership_table =  TableRegistry::get("Membership");
		$row = $membership_table->get($membership_id)->toArray();
		$period = $row["membership_length"];
		$end_date = date($format,strtotime($date1 . " + {$period} days"));
		echo $end_date;
	}
	
	public function levelsList()
	{
		$level_table = TableRegistry::get("GymLevels");
		$levels = $level_table->find()->all()->toArray();		
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Levels");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="level form-control" placeholder="<?php echo __("Enter Level");?>">
				</div>
				<div class="col-sm-4">
					<button class="save-level btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveLevel";?>"><?php echo  __("Add Level");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="level_list">
					<thead>
						<tr>
							<th><?php echo __("Levels");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($levels))
					{
						foreach($levels as $row)
						{
							echo "<tr id='row-{$row->id}'>
							<td>{$row->level}</td>
							<td><button class='del-level btn btn-flat btn-danger' del-id='{$row->id}' data-url='{$this->request->base}/GymAjax/deleteLevel/{$row->id}'>".__("Delete")."</button></td>
							</tr>";
						}
					}else{echo "<tr><td colspan='2'>".__("No record added yet")."</td></tr>";}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
	<?php
	}
	
		
	public function saveLevel()
	{
		$return = array();
		$level_table = TableRegistry::get("GymLevels");
		$row = $level_table->newEntity();
		$level = $this->request->data['level'];
		$row->level = $level;
		if($level_table->save($row))
		{
			$id = $row->id;
			$return[0] = "<tr id='row-{$id}'><td>{$level}</td><td><button del-id='{$id}' class='del-level btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteLevel/{$id}'>".__("Delete")."</button></td></tr>";
			$return[1] = "<option value='{$id}'>{$level}</option>";
			echo json_encode($return);
		}else{
			echo false;
		}		
	}
	
	public function deleteLevel($did)
	{		
		$level_table = TableRegistry::get("GymLevels");
		$row = $level_table->get($did);
		echo ($level_table->delete($row)) ? true : false ;		
	}
	
	function gmgtAddWorkout()
	{
		if($this->request->data('data_array') != null)
		{
			$data_array = $this->request->data('data_array');
			$data_value = json_encode($data_array);
			echo "<input type='hidden' value='".htmlspecialchars($data_value,ENT_QUOTES)."' name='activity_list[]'>";
		}		
	}
	
	public function deleteWorkoutData($id)
	{
		$workour_data_table = TableRegistry::get("GymWorkoutData");
		if($workour_data_table->deleteAll(["workout_id"=>$id]))
		{
			$assign_table = TableRegistry::get("GymAssignWorkout");
			$row = $assign_table->get($id);
			if($assign_table->delete($row))
			{
				echo true;
			}else{
				echo false;
			}
		}
		else{
				echo false;
			}
	}
	
	public function gymWorkoutData()
	{
		$conn = ConnectionManager::get('default');
		$uid=$this->request->data['uid'];
		$sel_date=date("Y-m-d",strtotime($this->request->data['sel_date']));
		$daily_table = TableRegistry::get("GymDailyWorkout");
		$user_workout_table = TableRegistry::get("GymUserWorkout");
		$record_data = $daily_table->find()->where(["member_id"=>$uid,"record_date"=>$sel_date])->select(["id","note"])->hydrate(false)->toArray();
		$dd_array = array();
		if(!empty($record_data))
		{
			$user_data = $user_workout_table->find()->where(["user_workout_id"=>$record_data[0]["id"]])->select($user_workout_table)->hydrate(false)->toArray();
			foreach($user_data as $ud)
			{
				$wn = $ud['workout_name'];
				$dd_array[$wn] = $ud;			
			}
			echo "<input type='hidden' name='edit' value='yes'>";
			echo "<input type='hidden' name='user_workout_id' value='{$record_data[0]["id"]}'>";
		}
		// var_dump($dd_array);
		// die;
		$assign_table = TableRegistry::get("GymAssignWorkout");
		$workout_table = TableRegistry::get("GymWorkoutData");
		$activity_table = TableRegistry::get("Activity");
		$date = date('Y-m-d');
		$record_date = date('Y-m-d',strtotime($sel_date));
		$day_name = date('l', strtotime($record_date));
		$sql = "SELECT * FROM `gym_assign_workout` as workout,`gym_workout_data` as workoutdata WHERE  workout.user_id = {$uid} 
		AND  workout.id = workoutdata.workout_id 
		AND workoutdata.day_name = '{$day_name}'		
		AND '".$record_date."' BETWEEN workout.start_date and workout.end_date";
		/* AND ('".$record_date."' >= workout.start_date AND '".$record_date."' <= workout.end_date)"; */
		$stmt = $conn->execute($sql);
		$results = $stmt->fetchAll('assoc');	
		// var_dump($results);
		// die;
		if(!empty($results)){
			echo $option="<div class='work_out_datalist_header'><div class='col-md-10'>
					<span class='col-md-3'>".__('Activity')."</span>
					<span class='col-md-2'>".__('Sets')."</span>
					<span class='col-md-2'>".__('Reps')."</span>
					<span class='col-md-2'>".__('KG')."</span>
					<span class='col-md-3'>".__('Rest Time')."</span>
					</div></div>";
			foreach ($results as $retrieved_data){			
			$activity = $activity_table->get($retrieved_data['workout_name'])->toArray();
			$act_name = $activity["title"];
			echo $option="<div class='work_out_datalist'><div class='col-sm-10'>
				<input type='hidden' name='workouts_array[]' value='".$retrieved_data['id']."'>
				<input type='hidden' name='workout_name_".$retrieved_data['id']."' value='".$retrieved_data['workout_name']."'>
				<span class='col-md-3'>".$act_name."</span>
				<span class='col-md-2'>".$retrieved_data['sets']." ".__('Sets')."</span>
				<span class='col-md-2'>".$retrieved_data['reps']."  ".__('Reps')."</span>
				<span class='col-md-2'>".$retrieved_data['kg']."  ".__('Kg')."</span>
				<span class='col-md-2'>".$retrieved_data['time']."  ".__('Min')."</span>
			</div>";
			$wrk_name = $retrieved_data['workout_name'];
			echo "<div class='col-sm-10'>
				<span class='col-md-3'>".__('Your Workout')."</span>
				<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='sets' name='sets_".$retrieved_data['id']."' width='50px' value='".((!empty($record_data)) ? $dd_array[$wrk_name]['sets'] : '')."'></span>
				<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='reps' name='reps_".$retrieved_data['id']."' width='50px' value='".((!empty($record_data)) ? $dd_array[$wrk_name]['reps'] : '')."'></span>
				<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='kg' name='kg_".$retrieved_data['id']."' width='50px' value='".((!empty($record_data)) ? $dd_array[$wrk_name]['kg'] : '')."'></span>
				<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='rest' name='rest_".$retrieved_data['id']."' width='50px' value='".((!empty($record_data)) ? $dd_array[$wrk_name]['rest_time'] : '')."'></span>
			</div></div>"; 
			}
		}
		else
		{			
			echo $option = "<div class='work_out_datalist'>
			<div class='col-sm-10'>
			<span class='col-md-10  text-right'><strong>".__('No Workout assigned for today.You can add data from below.')."</strong></span>
			<input type='hidden' name='new_data' value='yes'>
			</div>			
			<hr>";?>
			<div class='form-group'>
				<label class="control-label col-md-3" for="email"><?php echo __("Level");?><span class="text-danger"> *</span></label>
				<div class="col-md-6">
					<select class="form-control level_list validate[required]" name="level_id">
						<option value=''><?php echo __("Select Level");?></option>
						<?php 
						$levels_table = TableRegistry::get("GymLevels");
						$levels = $levels_table->find("list",["keyField"=>"id","valueField"=>"level"])->hydrate(false)->toArray();
						$this->set("levels",$levels);
						foreach($levels as $key=>$level)
						{
							echo "<option value='{$key}'>{$level}</option>";
						}
						?>
					</select>					
				</div>
				<div class="col-md-3">
					<a href="javascript:void(0);" class="btn btn-default btn-flat level-list" data-url="<?php echo $this->request->base;?>/GymAjax/levelsList"><?php echo __("Add Level");?></a>
				</div>
			</div>	
			<div class='row'>
				<div class='col-md-3 col-xs-5 col-sm-3'>
					<div class="cat_list">
					<?php
					$cat_table = TableRegistry::get("Category");
					$categories = $cat_table->find("list",["keyField"=>"id","valueField"=>"name"])->hydrate(false)->toArray();
					echo "<ul class='list-group'>
							<li class='list-group-item bg-default'>".__("Category List")."</li>";
					foreach($categories as $key=>$value)
					{
						echo  "<li class='list-group-item'>{$value} <span class='pull-right'><input type='checkbox' id='{$key}' class='show_workout'></span></li>";
					}
					echo "</ul>";					
					?>
					</div>
				</div>
				<div class='col-md-9'>
				<input type="hidden" id="get_url" value="<?php echo $this->request->base;?>/GymAjax/getWorkoutByCategory/">
				<?php
				echo "<div class='work_out_datalist_header'>
					<div class='col-md-12'>
					<span class='col-md-3'>".__('Activity')."</span>
					<span class='col-md-2'>".__('Sets')."</span>
					<span class='col-md-2'>".__('Reps')."</span>
					<span class='col-md-2'>".__('KG')."</span>
					<span class='col-md-3'>".__('Rest Time')."</span>
					</div></div>";
				echo "<div class='activity_data'></div>";						
				?>
				</div>
			</div>		
	<?php	
		}
		
		// }
	}
	
	public function getWorkoutDates()
	{
		$uid = $this->request->data["uid"];
		$assign_table = TableRegistry::get("GymAssignWorkout");
		$data = $assign_table->find()->where(["user_id"=>$uid])->select(["GymAssignWorkout.id","GymAssignWorkout.start_date","GymAssignWorkout.end_date"])->hydrate(false)->toArray();
		$x=1;
		if(!empty($data))
		{
			foreach($data as $rec)
			{
				$wid[] = $rec["id"];			
				$date_rages[$x]["start_date"]=$rec["start_date"]->format("Y-m-d");
				$date_rages[$x]["end_date"]=$rec["end_date"]->format("Y-m-d");
				$date_rages[$x]["wid"] = $rec["id"];
				$x++;
			}
			
			$workout_table = TableRegistry::get("GymWorkoutData");
			foreach($wid as $workout_id)
			{
				$days[$workout_id] = $workout_table->find()->where(["workout_id"=>$workout_id])->select(["day_name"])->group("day_name")->hydrate(false)->toArray();
			}
			
			foreach($date_rages as $period)
			{
				$start = new \DateTime($period["start_date"]);
				$start->format('Y-m-d');
				$end = new \DateTime($period["end_date"]);
				$end->format('Y-m-d');
				$daterange = new \DatePeriod($start, new \DateInterval('P1D'), $end);
				
				// $start = clone $start;
				// while ($start <= $end) {
					// $daterange[] = $start->format('Y-m-d');
					// $start->modify('+1 day');
				// }
				
				$period_wid = $period["wid"];
				$assign_days = array();
				foreach($days[$period_wid] as $wd)
				{
					$assign_days[]=$wd["day_name"];
				}
				
				foreach($daterange as $date)
				{										
					// $curr_date = $date;			
					$curr_date = $date->format("Y-m-d");			
					$sel_day = date('l',strtotime($curr_date));	
					if(in_array($sel_day,$assign_days))
					{
						$dates[]= $curr_date;						
					}
				}
				if($start->format("Y-m-d") == $end->format("Y-m-d")) //IF start date and end date is same.than also add in array.
				{
					$day = date('l',strtotime($start->format("Y-m-d")));	
					if(in_array($day,$assign_days))
					{
						$dates[]= $start->format("Y-m-d");						
					}					
				}
				
			}
			echo json_encode($dates);					
		}
		echo false;
	}
	
	public function getWorkoutByCategory()
	{
		if($this->request->is("ajax"))
		{
			$cat_id = $this->request->data['cat_id'];
			$activity_table = TableRegistry::get("Activity");
			$activities = $activity_table->find("list",["keyField"=>"id","valueField"=>"title"])->where(["cat_id"=>$cat_id])->hydrate(false)->toArray();
			if(!empty($activities))
			{
				echo "<div class='activity_block' id='act_block_{$cat_id}'>";
				foreach($activities as $key=>$activity)
				{					
					echo "<div id='activity_{$key}' class='col-md-12 activity_row'>	
						<input type='hidden' name='activity_name[]' value='{$key}'>
						<span class='col-md-3'>{$activity}</span>
						<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='sets' name='sets_{$key}' width='50px'></span>
						<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='reps' name='reps_{$key}' width='50px'></span>
						<span class='col-md-2'><input type='text' class='my-workouts validate[required]' id='kg' name='kg_{$key}' width='50px'></span>
						<span class='col-md-3'><input type='text' class='my-workouts validate[required]' id='rest' name='rest_{$key}' width='50px'></span>
					</div>";
				}
				echo "</div>";
			}
			else{
				echo false;
			}
		}
	}
	
	public function GymViewMeasurment()
	{
		if($this->request->is("ajax"))
		{
			$user_id = $this->request->data["user_id"];
			$measurment_table = TableRegistry::get("GymMeasurement");
			$data = $measurment_table->find()->where(["user_id"=>$user_id])->hydrate(false)->toArray();			
			?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Edit/Delete Measurement");?></h4>
			</div>
			<div class="modal-body">			
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="level_list">
					<thead>
						<tr>
							<th><?php echo __("Image");?></th>
							<th><?php echo __("Measurement");?></th>
							<th><?php echo __("Result");?></th>
							<th><?php echo __("Record Date");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>					
					<?php
					if(!empty($data))
					{
						foreach($data as $row)
						{
							echo "<tr id='row_{$row['id']}'>
									<td><img src='{$this->request->webroot}webroot/upload/{$row['image']}' class='membership-img img-circle'></td>
									<td>{$row['result_measurment']}</td>
									<td>{$row['result']}</td>
									<td>{$row['result_date']}</td>
									<td>
									<a href='".$this->request->base ."/GymDailyWorkout/editMeasurment/{$row['id']}' class='btn btn-flat btn-primary' title='Edit'><i class='fa fa-edit'></i></a>
									<a href='javascript:void(0)' data-url='{$this->request->base}/GymAjax/deleteMeasurment/{$row['id']}' class='delete_measurment btn btn-flat btn-danger view-measurement-popup' did='{$row['id']}' title='Delete'><i class='fa fa-trash'></i></a>      
									</td>
							</tr>";
						}
					}else{
						echo "<tr><td>".__("No Data Found.")."</td></tr>";
					}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
			<?php
		}		
	}
		
	public function deleteMeasurment($did)
	{
		if($this->request->is("ajax"))
		{
			$measurement_table = TableRegistry::get("GymMeasurement");			
			$row = $measurement_table->get($did);
			if($measurement_table->delete($row))
			{echo true;}
			else{ echo false;}
		}
	}
	
	function gymAddNutrition()
	{
		if(isset($_REQUEST['data_array']))
		{
			$data_array = $this->request->data['data_array'];
			$data_value = json_encode($data_array);
			echo "<input type='hidden' value='".htmlspecialchars($data_value,ENT_QUOTES)."' name='activity_list[]'>";
			//var_dump($data_array);
		}
		die;
	}
	
	public function deleteNutritionData($id)
	{
		$nutrition_data_table = TableRegistry::get("GymNutritionData");
		if($nutrition_data_table->deleteAll(["nutrition_id"=>$id]))
		{
			$nutrition_table = TableRegistry::get("GymNutrition");
			$row = $nutrition_table->get($id);
			if($nutrition_table->delete($row))
			{
				echo true;
			}else{
				echo false;
			}
		}
		else{
				echo false;
			}
	}
	
	public function EventPlaceList()
	{
				
		$event_tbl = TableRegistry::get("GymEventPlace");
		$event_places = $event_tbl->find()->all()->toArray();		
		?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add/Remove Event Place");?></h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<input type="text" class="place_name form-control" placeholder="<?php echo __("Enter Place Name");?>">
				</div>
				<div class="col-sm-4">
					<button class="save-event-place btn btn-flat btn-success" data-url="<?php echo $this->request->base."/GymAjax/saveEventPlace";?>"><?php echo  __("Add Place");?></button>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-12 table table-striped">
					<table class="table" id="events_place_list">
					<thead>
						<tr>
							<th><?php echo __("Place Name");?></th>
							<th><?php echo __("Action");?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($event_places))
					{
						foreach($event_places as $place)
						{
							echo "<tr id='row-{$place->id}'>
							<td>{$place->place}</td>
							<td><button class='del-event-place btn btn-flat btn-danger' del-id='{$place->id}' data-url='{$this->request->base}/GymAjax/deleteEventPlace/{$place->id}'>".__("Delete")."</button></td>
							</tr>";
						}
					}else{echo "<tr><td colspan='2'>".__("No roles added")."</td></tr>";}
					?>
					</tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>
	<?php
	}
	
	public function saveEventPlace()
	{
		if($this->request->is("ajax"))
		{
			$return = array();
			$event_tbl = TableRegistry::get("GymEventPlace");
			$row = $event_tbl->newEntity();
			$place_name = $this->request->data['place_name'];
			$row->place = $place_name;
			if($event_tbl->save($row))
			{
				$id = $row->id;
				$return[0] = "<tr id='row-{$id}'><td>{$place_name}</td><td><button del-id='{$id}' class='del-event-place btn btn-flat btn-danger' data-url='{$this->request->base}/GymAjax/deleteEventPlace/{$id}'>".__("Delete")."</button></td></tr>";
				$return[1] = "<option value='{$id}'>{$place_name}</option>";
				echo json_encode($return);
			}
			else{ echo false; }		
		}
	}
	
	public function deleteEventPlace($did)
	{
		if($this->request->is("ajax"))
		{
			$event_tbl = TableRegistry::get("GymEventPlace");
			$row = $event_tbl->get($did);
			echo ($event_tbl->delete($row)) ? true : false ;		
		}
	}
	
	public function viewGroupMember($gid)
	{
		if($this->request->is("ajax"))
		{
			$grp_tbl = TableRegistry::get("GymMember");
			$data = $grp_tbl->find("all")->where(["assign_group LIKE"=> '%"'.$gid.'"%',"role_name"=>"member"])->select(["first_name","last_name","image"])->hydrate(false)->toArray();
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Group Members");?></h4>
		</div>
		<div class="modal-body">
		<table class="table table-hover">
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				echo "<tr>
						<td><img src='".$this->request->base ."/webroot/upload/{$row['image']}' class='membership-img img-circle'/></td>
						<td>{$row['first_name']} {$row['last_name']}</td>
					</tr>";
			}
		}else{
			echo "<tr>".__("No Members Assigned Yet.")."</tr>";
		}
		?>
		</table>
		</div>
		<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
		</div>
		<?php
		die;
		}		
	}
	
	public function gymPay($mp_id)
	{	$this->loadComponent("GYMFunction");
		$session = $this->request->session()->read("User");
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Add Payment");?></h4>
		</div>
		<div class="modal-body">		
			<form name="expense_form" action="" method="post" class="form-horizontal validateForm">
         		<input type="hidden" name="action" value="gmgt_member_add_payment">
		<input type="hidden" name="mp_id" value="<?php echo $mp_id;?>">
		<input type="hidden" name="created_by" value="<?php echo $session["id"];?>">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="amount"><?php echo __("Paid Amount");?><span class="text-danger">*</span></label>
			<div class="col-sm-8">
				<div class='input-group'>
					<span class='input-group-addon'><?php echo $this->GYMFunction->get_currency_symbol();?></span>
					<input id="amount" class="form-control validate[required] text-input" type="text" value="" name="amount">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" for="payment_method"><?php echo __("Payment By");?><span class="text-danger">*</span></label>
			<div class="col-sm-8">
				<select name="payment_method" id="payment_method" class="form-control">
					<?php 
					if($session["role_name"] == "member")
					{ ?>
						<option value="Paypal"><?php echo __("Paypal");?></option>
				<?php }
					else{ ?>		
					<option value="Cash"><?php echo __("Cash");?></option>
					<option value="Cheque"><?php echo __("Cheque");?></option>
					<option value="Bank Transfer"><?php echo __("Bank Transfer");?></option>
				<?php } ?>	
				</select>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	 <input type="submit" value="<?php echo __("Add Payment");?>" name="add_fee_payment" class="btn btn-flat btn-success">
        </div>
		</form>		
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
		</div>
	<?php
	}
	
	public function getAmountByMemberships()
	{
		if($this->request->is('ajax'))
		{
			$mid = $this->request->data['mid'];
			$mem_tbl = TableRegistry::get("Membership");
			$row = $mem_tbl->get($mid)->toArray();
			echo $row['membership_amount'];
			die;
		}
	}
	public function viewInvoice($mp_id)
	{
		$this->loadComponent("GYMFunction");
		$payment_tbl = TableRegistry::get("MembershipPayment");
		$setting_tbl = TableRegistry::get("GeneralSetting");
		$pay_history_tbl = TableRegistry::get("MembershipPaymentHistory");
		
		$sys_data = $setting_tbl->find()->select(["name","address","gym_logo","date_format","office_number","country"])->hydrate(false)->toArray();
		$sys_data[0]["gym_logo"] = (!empty($sys_data[0]["gym_logo"])) ? $this->request->base . "/webroot/upload/".  $sys_data[0]["gym_logo"] : $this->request->base . "/webroot/img/Thumbnail-img.png";
		$data = $payment_tbl->find("all")->contain(["GymMember","Membership"])->where(["mp_id"=>$mp_id])->hydrate(false)->toArray();
		$history_data = $pay_history_tbl->find("all")->where(["mp_id"=>$mp_id])->hydrate(false)->toArray();
		
		$session = $this->request->session();
		$float_l = ($session->read("User.is_rtl") == "1") ? "right" : "left";
		$float_r = ($session->read("User.is_rtl") == "1") ? "left" : "right";
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Invoice");?></h4>
		</div>
		<div class="modal-body">
		<div id="invoice_print"> 
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td width="70%">
						<img style="max-height:80px;" src="<?php echo $sys_data[0]["gym_logo"]; ?>">
					</td>
					<td align="right" width="24%">
						<h5><?php $issue_date=$data[0]['created_date']->format("Y-m-d");
							$issue_date= date($sys_data[0]['date_format'],strtotime($issue_date));
							echo __('Issue Date')." : ". $issue_date;?></h5>
						<h5><?php echo __('Status')." : "; echo "<span class='btn btn-success btn-xs'>";
							echo __($this->GYMFunction->get_membership_paymentstatus($mp_id));
							echo "</span>";?>
						</h5>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td align="<?php echo $float_l;?>">
						<h4><?php echo __('Payment To');?> </h4>
					</td>
					<td align="<?php echo $float_r;?>">
						<h4><?php echo __('Bill To');?> </h4>
					</td>
				</tr>
				<tr>
					<td valign="top" align="<?php echo $float_l;?>">
						<?php echo $sys_data[0]["name"]."<br>"; 
						 echo $sys_data[0]["address"].","; 
						 echo $sys_data[0]["country"]."<br>"; 
						 echo $sys_data[0]["office_number"]."<br>"; 
						?>
					</td>
					<td valign="top" align="<?php echo $float_r;?>">
						<?php
						$member_id=$data[0]["member_id"];				
						echo $data[0]["gym_member"]["first_name"]." ".$data[0]["gym_member"]["last_name"]."<br>"; 
						echo $data[0]["gym_member"]["address"].","; 
						echo $data[0]["gym_member"]["city"].","; 
						echo $data[0]["gym_member"]["zipcode"].",<BR>"; 
						echo $data[0]["gym_member"]["state"].","; 
						echo $sys_data[0]["country"].","; 
						echo $data[0]["gym_member"]["mobile"]."<br>"; 
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center"> <?php echo __('Membership Type');?></th>
					<!--<th class="text-center"> <?php echo __('Sign Up Fee');?></th> -->
					<th class="text-center"> <?php echo __('Membership Fee');?></th>
					<th><?php echo __('Total');?> </th>
				</tr>
			</thead>
			<tbody>
				<td>1</td>
				<td class="text-center"><?php echo $data[0]["membership"]["membership_label"];?></td>
			<!-- <td class="text-center"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $data[0]["membership"]["signup_fee"];?></td> -->
				<td class="text-center"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $data[0]["membership"]["membership_amount"];?></td>
				<td class="text-center"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $subtotal = intval($data[0]["membership"]["membership_amount"]) /* + intval($data[0]["membership"]["signup_fee"]);*/ ?></td>
			</tbody>
		</table>
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td width="80%" align="<?php echo $float_r;?>"><?php echo __('Subtotal :');?></td>
					<td align="<?php echo $float_r;?>"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $subtotal;?></td>
				</tr>
				<tr>
					<td width="80%" align="<?php echo $float_r;?>"><?php echo __('Payment Made :');?></td>
					<td align="<?php echo $float_r;?>"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $data[0]["paid_amount"];?></td>
				</tr>
				<tr>
					<td width="80%" align="<?php echo $float_r;?>"><?php echo __('Due Amount  :');?></td>
					<td align="<?php echo $float_r;?>"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $subtotal - $data[0]["paid_amount"];?></td>
				</tr>
			</tbody>			
		</table>
		<hr>
		<?php if(!empty($history_data))
		{?>
		<h4><?php echo __('Payment History');?></h4>
		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
		<thead>
				<tr>
					<th class="text-center"><?php echo __('Date');?></th>
					<th class="text-center"> <?php echo __('Amount');?></th>
					<th class="text-center"><?php echo __('Method');?> </th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($history_data as  $retrive_date)
				{?>
					<tr>
					<td class="text-center"><?php echo $retrive_date["paid_by_date"];?></td>
					<td class="text-center"><?php echo $this->GYMFunction->get_currency_symbol();?> <?php echo $retrive_date["amount"];?></td>
					<td class="text-center"><?php echo $retrive_date["payment_method"];?></td>
					</tr>
		  <?php }?>
			</tbody>
		</table>
		<?php }?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
		</div>
	<?php
	}
	
	public function viewIncomeExpense($id)
	{
		$this->loadComponent("GYMFunction");
		$in_ex_table = TableRegistry::get("GymIncomeExpense");
		$setting_tbl = TableRegistry::get("GeneralSetting");	
		$mem_tbl = TableRegistry::get("GymMember");	
		$type = $this->request->data["type"];		
		$sys_data = $setting_tbl->find()->select(["name","address","gym_logo","date_format","office_number","country"])->hydrate(false)->toArray();
		$sys_data[0]["gym_logo"] = (!empty($sys_data[0]["gym_logo"])) ? $this->request->base . "/webroot/upload/".  $sys_data[0]["gym_logo"] : $this->request->base . "/webroot/img/Thumbnail-img.png";
		if($type == "income")
		{
			$data = $in_ex_table->find("all")->contain(["GymMember"])->where(["GymIncomeExpense.id"=>$id])->hydrate(false)->toArray();
		}
		else if($type == "expense"){
			$data = $in_ex_table->find("all")->where(["GymIncomeExpense.id"=>$id])->select($in_ex_table);
			$data = $data->rightjoin(["GymMember"=>"gym_member"],
									["GymIncomeExpense.receiver_id = GymMember.id"])->select($mem_tbl)->hydrate(false)->toArray();
			$data[0]["gym_member"] = $data[0]["GymMember"];
			unset($data[0]["GymMember"]);
		}
		$session = $this->request->session();
		$float_l = ($session->read("User.is_rtl") == "1") ? "right" : "left";
		$float_r = ($session->read("User.is_rtl") == "1") ? "left" : "right";
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Invoice");?></h4>
		</div>
		<div class="modal-body">
		<div id="invoice_print"> 
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td width="70%">
						<img style="max-height:80px;" src="<?php echo $sys_data[0]["gym_logo"]; ?>">
					</td>
					<td align="<?php echo $float_r;?>" width="24%">
						<h5><?php $issue_date=$data[0]['invoice_date']->format("Y-m-d");
							$issue_date= date($sys_data[0]['date_format'],strtotime($issue_date));
							echo __('Issue Date')." : ". $issue_date;?></h5>
						<h5><?php echo __('Status')." : "; 
							echo __($data[0]["payment_status"]);
							?>
						</h5>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td align="<?php echo $float_l;?>">
						<h4><?php echo __('Payment To');?> </h4>
					</td>
					<td align="<?php echo $float_r;?>">
						<h4><?php echo __('Bill To');?> </h4>
					</td>
				</tr>
				<tr>
					<td valign="top" align="<?php echo $float_l;?>">
						<?php echo $sys_data[0]["name"]."<br>"; 
						 echo $sys_data[0]["address"].","; 
						 echo $sys_data[0]["country"]."<br>"; 
						 echo $sys_data[0]["office_number"]."<br>"; 
						?>
					</td>
					<td valign="top" align="<?php echo $float_r;?>">
						<?php
						if($type == "income")
						{						
							echo $data[0]["gym_member"]["first_name"]." ".$data[0]["gym_member"]["last_name"]."<br>"; 
							echo $data[0]["gym_member"]["address"].","; 
							echo $data[0]["gym_member"]["city"].","; 
							echo $data[0]["gym_member"]["zipcode"].",<BR>"; 
							echo $data[0]["gym_member"]["state"].","; 
							echo $sys_data[0]["country"].","; 
							echo $data[0]["gym_member"]["mobile"]."<br>"; 
						}
						else if($type == "expense")
						{
							echo $data[0]["supplier_name"]."<br>";
						}
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<h4><?php echo __("Invoice Entries");?></h4>
		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center"> <?php echo __('Date');?></th>
					<th class="text-center"> <?php echo __('Entry');?></th>
					<th class="text-center"> <?php echo __('Price');?></th>
					<th class="text-center"> <?php echo __('Username');?></th>					
				</tr>
			</thead>
			<tbody>
			<?php
			$entries = json_decode($data[0]["entry"]);
			$i = 1 ;
			foreach($entries as $entry)
			{ ?>
				<tr>
				<td><?php echo $i; ?></td>
				<td class="text-center"><?php echo $data[0]["invoice_date"];?></td>
				<td class="text-center"><?php echo $entry->entry;?></td>
				<td class="text-center"><?php echo $this->GYMFunction->get_currency_symbol();?>  <?php echo $entry->amount;?></td>
				<td class="text-center"><?php echo $data[0]["gym_member"]["first_name"] . " ". $data[0]["gym_member"]["first_name"];?></td>
				</tr>
	  <?php	$i++;
			} ?>
			</tbody>
		</table>
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td width="80%" align="<?php echo $float_r;?>"><?php echo __('Grand Total :');?></td>
					<td align="<?php echo $float_r;?>"><?php echo $this->GYMFunction->get_currency_symbol();?>  <?php echo $data[0]["total_amount"];?></td>
				</tr>				
			</tbody>			
		</table>		
		</div>
		</div>
		<div class="modal-footer">
			<div class="print-button pull-left">
				<a href="<?php echo $this->request->base . "/MembershipPayment/printInvoice/{$data[0]['id']}/{$type}";?>" target="_blank" class="btn btn-flat btn-success"><?php echo __("Print"); ?></a>
			</div>
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
		</div>
		<?php
	}
	
	public function viewNotice(){
		if($this->request->is("ajax"))
		{
			$id = $this->request->data["id"];
			$notice_tbl = TableRegistry::get("GymNotice");
			$row = $notice_tbl->get($id)->toArray();
		?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" id="gridSystemModalLabel"><?php echo __("Notice Detail");?></h3>
			</div>
			<div class="modal-body">		
				<div class="panel panel-white form-horizontal">
				  <div class="form-group">
					<label for="notice_title" class="col-sm-3"><?php echo __("Notice Title ");?>          : </label>
					<div class="col-sm-9"> <?php echo $row["notice_title"]; ?> </div>
				  </div>
				  <div class="form-group">
					<label for="notice_title" class="col-sm-3">
					<?php echo __("Notice Comment");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["comment"]; ?></div>
				  </div>
				  <div class="form-group">
					<label for="notice_title" class="col-sm-3">
					<?php echo __("Notice For");?>    : </label>
					<div class="col-sm-9"> <?php echo ucwords(str_replace("_"," ",$row['notice_for'])); ?> </div>
				  </div>
				  <div class="form-group">
					<label for="notice_title" class="col-sm-3">
					<?php echo __("Start Date");?>    : </label>
					<div class="col-sm-9"> <?php echo $row["start_date"]; ?></div>
				  </div>
				  <div class="form-group">
					<label for="notice_title" class="col-sm-3">
					<?php echo __("End Date ");?>   : </label>
					<div class="col-sm-9"> <?php echo $row["end_date"]; ?> </div>
				  </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>	
		<?php
		}
	}
        
        public function viewLocation(){
            if($this->request->is("ajax")){
                $id = $this->request->data["id"];
                $location_tbl = TableRegistry::get("GymLocation");
                //$row = $location_tbl->find()->contain(['GymMember'])->toArray();
                $row = $location_tbl->find()->contain(['GymMember'])->where(["GymLocation.id"=>$id])->hydrate(false)->toArray();
                $row = $row[0];
                //echo '<pre>';print_r($row);die;
                ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="gridSystemModalLabel"><?php echo __("Location Detail");?></h3>
                </div>
                <div class="modal-body">		
                    <div class="panel panel-white form-horizontal">
                        <div class="form-group">
                            <label for="title" class="col-sm-3"><?php echo __("Title ");?>          : </label>
                            <div class="col-sm-9"> <?php echo $row["title"]; ?> </div>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-sm-3">
                            <?php echo __("Location");?>                : </label>
                            <div class="col-sm-9"> <?php echo $row["location"]; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-3"><?php echo __("Created By ");?>          : </label>
                            <div class="col-sm-9"> <?php echo $row['gym_member']['first_name']; ?> </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3">
                            <?php echo __("Status");?>    : </label>
                            <div class="col-sm-9"> <?php echo ($row["status"]) ? '<span class="label label-success">Active</span>' :'<span class="label label-warning">Inactive</span>'; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="created_date" class="col-sm-3">
                            <?php echo __("Created Date ");?>   : </label>
                            <div class="col-sm-9"> <?php echo $row["created_date"]; ?> </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
                </div>	
                <?php
            }
	}

	public function getMembershipClasses()
	{
		if($this->request->is("ajax"))
		{
			$membership_id = $this->request->data["m_id"];
			$mem_tbl = TableRegistry::get("Membership");
			$class_tbl = TableRegistry::get("ClassSchedule");
			$mem_classes = $mem_tbl->get($membership_id)->toArray();
			$mem_classes = json_decode($mem_classes["membership_class"]);
			$data = null;
			if(!empty($mem_classes))
			{				
				foreach($mem_classes as $class)
				{
					$class_data = $class_tbl->find()->where(["id"=>$class])->hydrate(false)->toArray();
					if(!empty($class_data))
					{
						$class_data = $class_data[0];
						$data .= "<option value='{$class_data['id']}'>{$class_data['class_name']}</option>";
					}					
				}
			}
			echo $data;			
		}
		
		die;
	}
	
	public function getCategoriesByMember()
	{
		if($this->request->is("ajax"))
		{
			$member_id = $this->request->data["member_id"];
			$member_tbl = TableRegistry::get("gym_member");
			$data = $member_tbl->get($member_id)->toArray();
			$membership = $data["selected_membership"];
			$activity = TableRegistry::get("activity");
			$mem_activity_tbl = TableRegistry::get("membership_activity");
			$activities = $mem_activity_tbl->find()->where(["membership_id"=>$membership]);
			$activities = $activities->leftjoin(["activity"=>"activity"],
										["activity.id = membership_activity.activity_id"])->select($activity)->hydrate(false)->toArray();
			foreach($activities as $activity)
			{ ?>
				<label class="activity_title"><strong><!-- Category Name here --></strong></label>	
				<div class="sub-class">
				<div class="checkbox child">				  			
				<label>
				<input type="checkbox" value="" name="avtivity_id[]" value="<?php echo $activity["activity"]["id"];?>" class="activity_check" id="<?php echo $activity["activity"]["id"];?>" data-val="activity" activity_title = "<?php echo $activity["activity"]["title"]; ?>">
				<?php echo $activity["activity"]["title"]; ?> 
				</label>
				<div id="reps_sets_<?php echo $activity["activity"]["id"];?>"></div>
				</div>				
				<div class="clear"></div>
				</div>
			<?php } 
		}
		$this->autoRender = false;
	}
        
        public function viewFranchise()
	{
            //echo $this->request->data["id"];die;
		if($this->request->is("ajax"))
		{
			$id = $this->request->data["id"];
                        $member_tbl = TableRegistry::get("Franchise");
                        $row = $member_tbl->GymMember->find()->contain(['GymLocation'])->where(["GymMember.role_name"=>"franchise","GymMember.role_id"=>2, "GymMember.id"=>$id])->hydrate(false)->toArray();
			//$member_tbl = TableRegistry::get("GymMember");
			//$row = $member_tbl->GymMember->get($id)->contain(['GymLocation'])->where(["GymMember.role_name"=>"franchise","GymMember.role_id"=>2])->toArray();
                        //echo '<pre>'; print_r($row);die;
                        $row = $row[0];
		?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" id="gridSystemModalLabel"><?php echo __("Franchise Detail");?></h3>
			</div>
			<div class="modal-body">		
				<div class="panel panel-white form-horizontal">
                                    <div class="form-group">
                                          <div class="col-sm-9"> <img width="200" src="<?php echo $this->request->webroot ."upload/".$row['image'];?>" class="img-responsive"></img></div>
                                    </div>
                                    <div class="form-group">
                                          <label for="username" class="col-sm-3"><?php echo __("Usern Name");?>          : </label>
                                          <div class="col-sm-9"> <?php echo $row["username"]; ?> </div>
                                    </div>
                                    <div class="form-group">
                                          <label for="franchise_title" class="col-sm-3"><?php echo __("Name");?>          : </label>
                                          <div class="col-sm-9"> <?php echo $row["first_name"] . ( (isset($row["middle_name"])) ? (' '.$row["middle_name"] ) : '' ) . ( (isset($row["last_name"])) ? (' '.$row["last_name"] ) : '' ); ?> </div>
                                    </div>
                                    <div class="form-group">
                                          <label for="location" class="col-sm-3">
                                          <?php echo __("Location");?>                : </label>
                                          <div class="col-sm-9"> <?php echo $row['gym_location']["location"]; ?></div>
                                    </div>
                                    <div class="form-group">
					<label for="address" class="col-sm-3">
					<?php echo __("Address");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["address"]; ?></div>
                                    </div>
                                    <div class="form-group">
					<label for="city" class="col-sm-3">
					<?php echo __("City");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["city"]; ?></div>
                                    </div>
                                    <div class="form-group">
					<label for="state" class="col-sm-3">
					<?php echo __("State");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["state"]; ?></div>
                                    </div>
                                    <div class="form-group">
					<label for="zipcode" class="col-sm-3">
					<?php echo __("Zip Code");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["zipcode"]; ?></div>
                                    </div>
                                    <div class="form-group">
					<label for="mobile" class="col-sm-3">
					<?php echo __("Mobile");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["mobile"]; ?></div>
                                    </div>
                                    <?php if(isset($row["phone"]) && $row["phone"] != ''){?>
                                    <div class="form-group">
					<label for="phone" class="col-sm-3">
					<?php echo __("Phone");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["phone"]; ?></div>
                                    </div>
                                    <?php }?>
                                    <?php if(isset($row["email"]) && $row["email"] != ''){?>
                                    <div class="form-group">
					<label for="email" class="col-sm-3">
					<?php echo __("Email");?>                : </label>
					<div class="col-sm-9"> <?php echo $row["email"]; ?></div>
                                    </div>
                                    <?php }?>
                                    
				  
				  <div class="form-group">
					<label for="created_date" class="col-sm-3">
					<?php echo __("Created Date");?>    : </label>
					<div class="col-sm-9"> <?php echo date('F d, Y', strtotime($row["created_date"])); ?></div>
				  </div>
				  
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close");?></button>				
			</div>	
		<?php
		}
	}
}