<?php $session = $this->request->session()->read("User");
 

?>
<script>
/*$('#sample_1').dataTable( {
    "responsive": true,
  "autoWidth": false
} );*/
</script>
<?php /*
<div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">Buttons</span>
                                        </div>
                                        <div class="tools"> </div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Office</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Office</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                    <td>61</td>
                                                    <td>2011/04/25</td>
                                                    <td>$320,800</td>
                                                </tr>
                                                <tr>
                                                    <td>Garrett Winters</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>63</td>
                                                    <td>2011/07/25</td>
                                                    <td>$170,750</td>
                                                </tr>
                                                <tr>
                                                    <td>Ashton Cox</td>
                                                    <td>Junior Technical Author</td>
                                                    <td>San Francisco</td>
                                                    <td>66</td>
                                                    <td>2009/01/12</td>
                                                    <td>$86,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Cedric Kelly</td>
                                                    <td>Senior Javascript Developer</td>
                                                    <td>Edinburgh</td>
                                                    <td>22</td>
                                                    <td>2012/03/29</td>
                                                    <td>$433,060</td>
                                                </tr>
                                                <tr>
                                                    <td>Airi Satou</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>33</td>
                                                    <td>2008/11/28</td>
                                                    <td>$162,700</td>
                                                </tr>
                                                <tr>
                                                    <td>Brielle Williamson</td>
                                                    <td>Integration Specialist</td>
                                                    <td>New York</td>
                                                    <td>61</td>
                                                    <td>2012/12/02</td>
                                                    <td>$372,000</td>
                                                </tr>
                                               
                                               
                                               
                                                <tr>
                                                    <td>Michael Bruce</td>
                                                    <td>Javascript Developer</td>
                                                    <td>Singapore</td>
                                                    <td>29</td>
                                                    <td>2011/06/27</td>
                                                    <td>$183,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Donna Snider</td>
                                                    <td>Customer Support</td>
                                                    <td>New York</td>
                                                    <td>27</td>
                                                    <td>2011/01/25</td>
                                                    <td>$112,000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div><?php */ ?>


<div class="col-md-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="icon-settings font-dark"></i>
                <span class="caption-subject bold uppercase"> <?php echo __("Members List"); ?>
                </span>
                 
            </div>
            <div class="actions">
                <div class="tools"> </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <?php
                            if ($session["role_name"] == "administrator" || $session["role_name"] == "licensee") {
                                ?>

                                <a href="<?php echo $this->Gym->createurl("GymMember", "addMember"); ?>" class="btn sbold green"><?php echo __("Add Member"); ?> <i class="fa fa-plus"></i></a>

                        <?php } ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
            <table class="mydataTable table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                <thead>
                    

                    <tr>
                    <th style="width:100% !important"><?php echo __("Photo"); ?></th>
                    <th><?php echo __("Member Name"); ?></th>
                    <th><?php echo __("Member ID"); ?></th>					
                    <th width="18%"><?php echo __("Assign Class"); ?></th>					
                    <th><?php echo __("Membership Status"); ?></th>					
                    <th><?php echo __("Action"); ?></th>
                    <th><?php echo __("Status"); ?></th>
                    </tr>
                   
                </thead>
                <tbody>
                    <?php
                foreach ($data as $row) {
                    //echo '<pre>';print_r($row);
                    if (isset($row['unsubscribed_member']['unsubscribed_status']) && $row['unsubscribed_member']['unsubscribed_status'] == 1) {
                        $memship_status = '<span class="label label-warning">Discontinued</span>';
                    } else if (isset($row['unsubscribed_member']['unsubscribed_status']) && $row['unsubscribed_member']['unsubscribed_status'] == 0) {
                        $memship_status = '<span class="label label-success">Continue</span>';
                    } else {
                        $memship_status = '<span class="label label-success">Continue</span>';
                    }



                    if ($this->Gym->get_member_assign_class($row['id']) > 0) {
                        $assign_label = "<i class='fa fa-pencil'></i>Update Assign Class";
                    } else {
                        $assign_label = "<i class='fa fa-plus'></i>Assign Class";
                    }
                    echo "<tr class='odd gradeX'>
					<td style='width: 100%'><img src='{$this->request->base}/webroot/upload/{$row['image']}' width='100' class='membership-img img-circle'></td>
					<td>{$row['first_name']} {$row['last_name']}</td>
					<td>{$row['member_id']}</td>
					<td><a href='{$this->request->base}/GymMember/assign-member/{$row['id']}' title='Assign Classes'>" . $assign_label . "</a></td>";
                    //<td>{$row['membership_status']}</td>
                    echo "<td>" . $memship_status . "</td><td><div class='btn-group'>
                                <button class='btn btn-xs green dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false'> Actions
                                    <i class='fa fa-angle-down'></i>
                                </button>
                                <ul class='dropdown-menu pull-left' role='menu'>
                                    <li>
                                        <a href='{$this->request->base}/GymMember/viewMember/{$row['id']}'>
                                            <i class='icon-docs'></i> New Post </a>
                                    </li>";
                                     if ($session["role_name"] == "administrator" || $session["role_name"] == "licensee") {
                                    echo "<li>
                                        <a href='{$this->request->base}/GymMember/editMember/{$row['id']}'>
                                            <i class='icon-tag'></i> New Comment </a>
                                    </li>
                                    <li>
                                        <a href='{$this->request->base}/GymMember/deleteMember/{$row['id']}'>
                                            <i class='icon-user'></i> New User </a>
                                    </li>
                                    <li class='divider'> </li>
                                    <li>
                                        <a href='{$this->request->base}/GymMember/unsubscribe/{$row['id']}'>
                                            <i class='icon-flag'></i> Comments
                                            <span class='badge badge-success'>4</span>
                                        </a>
                                    </li>";
                                     } 
                                     echo "<li>
                                        <a href='{$this->request->base}/GymMember/viewAttendance/{$row['id']}'>
                                            <i class='icon-flag'></i> Comments
                                            <span class='badge badge-success'>4</span>
                                        </a>
                                    </li>
                                </ul>
                            </div></td>
				 <td>";
                    if ($row["activated"] == 0) {
                        echo "<a class='btn btn-success btn-flat' onclick=\"return confirm('Are you sure,you want to activate this account?');\" href='" . $this->request->base . "/GymMember/activateMember/{$row['id']}'>" . __('Activate') . "</a>";
                    } else {
                        echo "<span class='btn btn-flat btn-default'>" . __('Activated') . "</span>";
                    }
                    echo "</td>
                                        
                                        
					</tr>";
                }
                ?>
                   
                    


                </tbody>
            </table>
        </div>
    </div>

    
    
    	
    
</div>

