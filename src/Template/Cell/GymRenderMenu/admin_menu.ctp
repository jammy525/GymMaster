<?php

$session = $this->request->session();
	$role_id = $session->read("User.role_id");
	$is_rtl = $session->read("User.is_rtl");
	$pull = ($is_rtl == "1") ? "pull-left":"pull-right";

if($is_rtl == "1") { ?>
<style>
    .treeview a {
        display: inline-block !important;
        width : 100% !important;
    }
    .treeview i:first-child{
        float:right !important;
        padding-top : 5px;
    }
    .treeview span{
        float: right !important;
        margin-right: 5px !important;
    }
</style>
<?php } ?>
<br>
<!--  <div class="user-panel">
<div class="pull-left image">
			  <?php //echo $this->Html->image('user2-160x160.jpg',array("class"=>"img-circle","alt"=>"User Image")); ?>
        </div>
<div class="pull-left info">
<p><?php //echo $session->read("User.display_name");?></p>
<a href="#"><i class="fa fa-circle text-success"></i> <?php //echo __("Online");?></a>
</div>
</div>-->		  
<!-- <form action="#" method="get" class="sidebar-form">
       <div class="input-group">
         <input type="text" name="q" class="form-control" placeholder="Search...">
         <span class="input-group-btn">
           <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
         </span>
       </div>
     </form> -->
<br>
		 <?php 
			foreach($menus as $menu){
				$controller[] = $menu['controller'];
				$action[] = $menu['action'];
			}
                        //echo '<pre>';print_r($controller);print_r($action);die;
		  ?>


<ul class="sidebar-menu">
    <!-- <li class="header">MAIN NAVIGATION</li> -->		 
    <li class= "treeview <?php echo ($this->request->controller == "Dashboard") ? "active" : "";?>" style="<?php echo (in_array('Dashboard', $controller) && in_array('index', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("Dashboard","index");?>">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/dashboard.png"></i> <span><?php echo __('Dashboard');?></span></i> 
        </a>             
    </li>

    <li class="treeview <?php echo ($this->request->controller == "Membership") ? "active" : "";?>" style="<?php echo (in_array('Membership', $controller) && in_array('membershipList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("membership","membership_list");?>">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/membership-type.png"></i> <span><?php echo __('Membership Type');?></span>  
        </a>			   
    </li>

    <li class="treeview <?php echo ($this->request->controller == "GymGroup") ? "active" : "";?>" style="<?php echo (in_array('GymGroup', $controller) && in_array('GroupList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymGroup","GroupList");?>">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/group.png"></i> <span><?php echo __('Group');?></span> 
        </a>
    </li>			

    <!--<li class="treeview <?php echo ($this->request->controller == "GymNutrition" || $this->request->controller == "ClassSchedule" || $this->request->controller == "ClassType" || $this->request->controller == "GymClass") ? "active" : "";?>">
        <a href="#">
            <i class="fa fa-calendar"></i> <span><?php echo __("Class & Nutrition Schedule");?></span><i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">	
            <li class="<?php echo ($this->request->action == "classtypeList" || $this->request->action == "classtypeList" || $this->request->action == "editclassType"|| $this->request->action == "addclassTYpe") ? "active" : "";?>" style="<?php echo (in_array('ClassSchedule', $controller) && in_array('classtypeList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("classType","classtypeList");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Class Type');?></span></i>
                </a>
            </li>

            <li class="<?php echo ($this->request->action == "classesList" || $this->request->action == "classesList" || $this->request->action == "editClasses"|| $this->request->action == "addClasses") ? "active" : "";?>" style="<?php echo (in_array('ClassSchedule', $controller) && in_array('ClassesList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymClass","classesList");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Classes');?></span></i>
                </a>
            </li>

            <li class="<?php echo ($this->request->action == "classList" || $this->request->action == "viewSchedule" || $this->request->action == "editClass"|| $this->request->action == "addClass") ? "active" : "";?>" style="<?php echo (in_array('ClassSchedule', $controller) && in_array('ClassSchedule', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("classSchedule","classList");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Class Schedule');?></span></i>
                </a>
            </li>
            <li class="<?php echo ($this->request->action == "nutritionList" || $this->request->action == "addnutritionSchedule" || $this->request->action == "viewNutirion") ? "active" : "";?>">
                <a href="<?php echo $this->Gym->createurl("GymNutrition","nutritionList");?>"><i class="fa fa-circle-o"></i><?php echo __('Nutrition Schedule');?></a>
            </li>	
        </ul>	
    </li>-->
    
    <li class="treeview <?php echo ($this->request->controller == "GymNutrition" || $this->request->controller == "ClassSchedule" || $this->request->controller == "ClassType" || $this->request->controller == "GymClass") ? "active" : "";?>" style="<?php echo (in_array('ClassType', $controller) && in_array('classtypeList', $action) ) ? 'display:block' : 'display:none';?>">
                    <a href="#">
                        <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/class-schedule.png"></i> <span><?php echo __("Class & Schedule");?></span><i class="fa fa-angle-left <?php echo $pull;?>"></i>
                    </a>
                    <ul class="treeview-menu">	
                        <li class="<?php echo ($this->request->action == "classtypeList" || $this->request->action == "classtypeList" || $this->request->action == "editclassType"|| $this->request->action == "addclassTYpe") ? "active" : "";?>" style="<?php echo (in_array('ClassType', $controller) && in_array('classtypeList', $action) ) ? 'display:block' : 'display:none';?>">
                            <a href="<?php echo $this->Gym->createurl("ClassType","classtypeList");?>">
                                <i class="fa fa-circle-o"></i><span><?php echo __('Class Type');?></span></i>
                            </a>
                        </li>
                        
                        <li class="<?php echo ($this->request->action == "classesList" || $this->request->action == "classesList" || $this->request->action == "editClasses"|| $this->request->action == "addClasses") ? "active" : "";?>" style="<?php echo (in_array('GymClass', $controller) && in_array('ClassesList', $action) ) ? 'display:block' : 'display:none';?>">
                            <a href="<?php echo $this->Gym->createurl("GymClass","classesList");?>">
                                <i class="fa fa-circle-o"></i><span><?php echo __('Classes');?></span></i>
                            </a>
                        </li>
                        
                        <li class="<?php echo ($this->request->action == "classList" || $this->request->action == "viewSchedule" || $this->request->action == "editClass"|| $this->request->action == "addClass") ? "active" : "";?>" style="<?php echo (in_array('ClassSchedule', $controller) && in_array('classList', $action) ) ? 'display:block' : 'display:none';?>">
                            <a href="<?php echo $this->Gym->createurl("ClassSchedule","classList");?>">
                                <i class="fa fa-circle-o"></i><span><?php echo __('Class Schedule');?></span></i>
                            </a>
                        </li>
                        <li class="<?php echo ($this->request->action == "viewSchedules" || $this->request->action == "viewSchedules") ? "active" : "";?>" style="<?php echo (in_array('ClassSchedule', $controller) && in_array('viewSchedules', $action) ) ? 'display:block' : 'display:none';?>">
                            <a href="<?php echo $this->Gym->createurl("ClassSchedule","viewSchedules");?>"><i class="fa fa-circle-o"></i><?php echo __('Schedule Lists');?></a>
                        </li>	
                       <!-- <li class="<?php //echo ($this->request->action == "nutritionList" || $this->request->action == "addnutritionSchedule" || $this->request->action == "viewNutirion") ? "active" : "";?>">
                            <a href="<?php //echo $this->Gym->createurl("GymNutrition","nutritionList");?>"><i class="fa fa-circle-o"></i><?php //echo __('Nutrition Schedule');?></a>
                        </li>-->	
                    </ul>	
		</li>
    <?php if($role_id != '4'){?>
    <li class="treeview <?php echo ($this->request->controller == "GymMember" || $this->request->controller == "Licensee" || $this->request->controller == "StaffMembers" || $this->request->controller == "GymAccountant") ? "active" : "";?>">
        <a href="#">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/staff-member.png"></i> <span><?php echo __('Member Management');?></span></i><i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">

            <li class="<?php echo ($this->request->action == "licenseeList" || $this->request->action == "addLicensee" || $this->request->action == "editLicensee" || $this->request->action == "viewLicensee") ? "active" : "";?>" style="<?php echo (in_array('Licensee', $controller) && in_array('licenseeList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("Licensee","licenseeList");?>"><i class="fa fa-circle-o"></i><?php echo __('Licensee');?></a>
            </li>

            <li class="<?php echo ($this->request->action == "staffList" || $this->request->action == "addStaff") ? "active" : "";?>"  style="<?php echo (in_array('StaffMembers', $controller) && in_array('StaffList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("StaffMembers","StaffList");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Staff Member');?></span>
                </a>
            </li>

            <li class="<?php echo ($this->request->action == "memberList" || $this->request->action == "addMember" || $this->request->action == "editMember" || $this->request->action == "viewMember") ? "active" : "";?>" style="<?php echo (in_array('GymMember', $controller) && in_array('memberList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymMember","memberList");?>"><i class="fa fa-circle-o"></i><?php echo __('Members');?></a>
            </li>

            <li class="treeview <?php echo ($this->request->action == "accountantList" || $this->request->action == "addAccountant" || $this->request->action == "editAccountant") ? "active" : "";?>" style="<?php echo (in_array('GymAccountant', $controller) && in_array('accountantList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymAccountant","accountantList");?>">
                    <i class="fa fa-circle-o"></i> <span><?php echo __("Accountant");?></span>
                </a>
            </li>

        </ul>			  
    </li>
    <?php }?>
    <li class="treeview <?php echo ($this->request->controller == "Activity") ? "active" : "";?>" style="<?php echo (in_array('Activity', $controller) && in_array('activityList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("Activity","activityList");?>">
            <i class="fa fa-bicycle"></i> <span><?php echo __('Activity');?></span>  
        </a>
    </li>

    <li class="treeview <?php echo ($this->request->controller == "GymAssignWorkout" || $this->request->controller == "GymDailyWorkout") ? "active" : "";?>" style="<?php echo (in_array('GymDailyWorkout', $controller) && in_array('workoutList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymAssignWorkout","WorkoutLog");?>">
            <i class="fa fa-hand-grab-o"></i> <span><?php echo __('Workout');?></span><i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo ($this->request->action == "workoutLog" || $this->request->action == "assignWorkout" || $this->request->action == "viewWorkouts") ? "active" : "";?>" style="<?php echo (in_array('GymAssignWorkout', $controller) && in_array('WorkoutLog', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymAssignWorkout","WorkoutLog");?>"><i class="fa fa-circle-o"></i><?php echo __('Assign Workout');?></a>
            </li>
            <li class="<?php echo ($this->request->action == "workoutList" || $this->request->action == "addWorkout" || $this->request->action =="addMeasurment" || $this->request->action =="viewWorkout" || $this->request->action =="editMeasurment") ? "active" : "";?>" style="<?php echo (in_array('GymDailyWorkout', $controller) && in_array('workoutList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymDailyWorkout","workoutList");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Daily Workout');?></span></i>
                </a>
            </li>				
        </ul>	
    </li>			
    <li class="treeview <?php echo ($this->request->controller == "GymProduct" || $this->request->controller == "GymStore") ? "active" : "";?>" style="<?php echo (in_array('GymProduct', $controller) && in_array('productList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymProduct","productList");?>">
            <i class="fa fa-tags"></i> <span><?php echo __("Store & Products");?></span><i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo ($this->request->action == "productList" || $this->request->action == "addProduct" || $this->request->action == "editProduct") ? "active" : "";?>" style="<?php echo (in_array('GymProduct', $controller) && in_array('productList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymProduct","productList");?>"><i class="fa fa-circle-o"></i><?php echo __('Product');?></a>
            </li>
            <li class="<?php echo ($this->request->action == "sellRecord" || $this->request->action == "sellProduct" || $this->request->action == "editRecord") ? "active" : "";?>" style="<?php echo (in_array('GymStore', $controller) && in_array('sellRecord', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymStore","sellRecord");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Store');?></span>
                </a>
            </li>				
        </ul>
    </li>		
    <li class="treeview <?php echo ($this->request->controller == "GymReservation") ? "active" : "";?>" style="<?php echo (in_array('GymReservation', $controller) && in_array('reservationList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymReservation","reservationList");?>">
            <i class="fa fa-ticket"></i> <span><?php echo __("Reservation");?></span>  
        </a>
    </li>
    <li class="treeview <?php echo ($this->request->controller == "GymAttendance") ? "active" : "";?>" style="<?php echo (in_array('GymAttendance', $controller) ) ? 'display:block' : 'display:none';?>">
        <a href="#">
            <i class="fa fa-braille"></i> <span><?php echo __("Attendance Management");?></span><i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">	
            <li class="<?php echo ($this->request->action == "attendance" || $this->request->action == "attendance") ? "active" : "";?>" style="<?php echo (in_array('GymAttendance', $controller) && in_array('attendance', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymAttendance","attendance");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Member Attendance');?></span></i>
                </a>
            </li>
            <li class="<?php echo ($this->request->action == "staffAttendance" || $this->request->action == "staffAttendance") ? "active" : "";?>" style="<?php echo (in_array('GymAttendance', $controller) && in_array('staffAttendance', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("GymAttendance","staffAttendance");?>">
                    <i class="fa fa-circle-o"></i><span><?php echo __('Staff Attendance');?></span></i>
                </a>
            </li>


        </ul>	
    </li>			
    <li class="treeview <?php echo ($this->request->controller == "MembershipPayment") ? "active" : "";?>" style="<?php echo (in_array('MembershipPayment', $controller) && in_array('paymentList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("MembershipPayment","paymentList");?>">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/payment.png"></i> 
            <span><?php echo __("Subscription Management");?></span><i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo ($this->request->action == "paymentList" || $this->request->action == "generatePaymentInvoice" || $this->request->action == "membershipEdit") ? "active" : "";?>" style="<?php echo (in_array('MembershipPayment', $controller) && in_array('paymentList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("MembershipPayment","paymentList");?>">
                    <i class="fa fa-circle-o"></i> <span><?php echo __('Membership Payment');?></span></i>
                </a>
            </li>
            <li class="<?php echo ($this->request->action == "incomeList" || $this->request->action == "addIncome" || $this->request->action == "incomeEdit") ? "active" : "";?>" style="<?php echo (in_array('MembershipPayment', $controller) && in_array('incomeList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("MembershipPayment","incomeList");?>">
                    <i class="fa fa-circle-o"></i><?php echo __('Income');?>
                </a>
            </li>
            <li class="<?php echo ($this->request->action == "expenseList" || $this->request->action == "addExpense" || $this->request->action == "expenseEdit") ? "active" : "";?>" style="<?php echo (in_array('MembershipPayment', $controller) && in_array('expenseList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("MembershipPayment","expenseList");?>">
                    <i class="fa fa-circle-o"></i><?php echo __('Expenses');?>
                </a>
            </li>
        </ul> 

    </li>	
    <li class="treeview <?php echo ($this->request->controller == "GymMessage") ? "active" : "";?>" style="<?php echo (in_array('GymMessage', $controller) && in_array('composeMessage', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymMessage","composeMessage");?>">
            <i class="fa fa-commenting"></i> <span><?php echo __("Message");?></span>  
        </a>
    </li>
    <li class="treeview <?php echo ($this->request->controller == "GymNewsletter") ? "active" : "";?>" style="<?php echo (in_array('GymNewsletter', $controller) && in_array('setting', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymNewsletter","setting");?>">
            <i class="fa fa-envelope-square"></i> <span><?php echo __("Newsletter");?></span>  
        </a>
    </li>
    <li class="treeview <?php echo ($this->request->controller == "GymNotice") ? "active" : "";?>" style="<?php echo (in_array('GymNotice', $controller) && in_array('noticeList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymNotice","noticeList");?>">
            <i class="fa fa-bell"></i> <span><?php echo __("Notice");?></span>  
        </a>
    </li>
    
    <li class="treeview <?php echo ($this->request->controller == "CustomerNotes") ? "active" : "";?>" style="<?php echo (in_array('CustomerNotes', $controller) && in_array('customerNotesList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("CustomerNotes","customerNotesList");?>">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/notice.png"></i> <span><?php echo __("Customer Notes");?></span>  
        </a>
    </li>

    <li class="treeview <?php echo ($this->request->controller == "GymLocation") ? "active" : "";?>" style="<?php echo (in_array('GymLocation', $controller) && in_array('locationList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymLocation","locationList");?>">
            <i class="fa fa-map-marker"></i> <span><?php echo __("Location");?></span>  
        </a>
    </li>
    <li class="treeview <?php echo (($this->request->controller == "DiscountCode")) ? "active" : "";?>" style="<?php echo (in_array('DiscountCode', $controller) && in_array('discountCodeList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("DiscountCode","discountCodeList");?>">
            <i class="fa fa-cart-arrow-down"></i> <span><?php echo __('Discount Codes');?></span>
        </a>
    </li>
    <!--<li class="treeview <?php echo ( ($this->request->controller == "DiscountCode") || ($this->request->controller == "ReferralUrl") ) ? "active" : "";?>" style="<?php echo (in_array('DiscountCode', $controller) && in_array('discountCodeList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="#">
            <i class="fa fa-cart-arrow-down"></i> <span><?php echo __("Discount & Referral");?></span>
            <i class="fa fa-angle-left <?php echo $pull;?>"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo ($this->request->action == "discountCodeList" || $this->request->action == "addDiscountCode" || $this->request->action == "editDiscountCode") ? "active" : "";?>" style="<?php echo (in_array('DiscountCode', $controller) && in_array('discountCodeList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("DiscountCode","discountCodeList");?>">
                    <i class="fa fa-circle-o"></i> <span><?php echo __('Discount Codes');?></span>
                </a>
            </li>
            <li class="<?php echo ($this->request->action == "referralUrlList" || $this->request->action == "addreferralUrl" || $this->request->action == "editreferralUrl") ? "active" : "";?>" style="<?php echo (in_array('ReferralUrl', $controller) && in_array('referralUrlList', $action) ) ? 'display:block' : 'display:none';?>">
                <a href="<?php echo $this->Gym->createurl("ReferralUrl","referralUrlList");?>">
                    <i class="fa fa-circle-o"></i><?php echo __('Referral URLs');?>
                </a>
            </li>
        </ul> 

    </li>-->
    <li class="treeview <?php echo ($this->request->controller == "Refer") ? "active" : "";?>" style="<?php echo (in_array('Refer', $controller) && in_array('referFriend', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("Refer","referFriend");?>">
            <i class="fa fa-users"></i> <span><?php echo __('Refer a Friend');?></span>  
        </a>			   
    </li>
    <li class="treeview <?php echo ($this->request->controller == "Reports") ? "active" : "";?>" style="<?php echo (in_array('Reports', $controller) && in_array('membershipReport', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("Reports","membershipReport");?>">
            <i class="fa fa-file-text-o"></i> <span><?php echo __("Report");?></span> 
        </a>
    </li> 			
    <li class="treeview <?php echo ($this->request->controller == "gymEmailSetting") ? "active" : "";?>" style="<?php echo (in_array('gymEmailSetting', $controller) && in_array('index', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("gymEmailSetting","index");?>">
            <i class="fa fa-envelope-o"></i> <span><?php echo __("Email Settings");?></span></i>
        </a>
    </li>			
    <li class="treeview <?php echo ($this->request->controller == "GeneralSetting") ? "active" : "";?>" style="<?php echo (in_array('GeneralSetting', $controller) && in_array('saveSetting', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GeneralSetting","saveSetting");?>">
            <i class="fa fa-sliders"></i> <span><?php echo __("General Settings");?></span></i>
        </a>
    </li>
    <li class="treeview <?php echo ($this->request->controller == "GymAccessRoles") ? "active" : "";?>" style="<?php echo (in_array('GymAccessRoles', $controller) && in_array('AccessRolesList', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymAccessRoles","AccessRolesList");?>">
            <i class="fa fa-object-group"></i> <span><?php echo __('Members Role');?></span> 
        </a>
    </li>

    <li class="treeview <?php echo ($this->request->controller == "GymAccessright") ? "active" : "";?>" style="<?php echo (in_array('GymAccessright', $controller) && in_array('accessRight', $action) ) ? 'display:block' : 'display:none';?>">
        <a href="<?php echo $this->Gym->createurl("GymAccessright","accessRight");?>">
            <i class="icone"><img src="<?php echo $this->request->base;?>/webroot/img/icon/access-Rights.png"></i> <span><?php echo __("Access Right");?></span>
        </a>
    </li>

</ul>


