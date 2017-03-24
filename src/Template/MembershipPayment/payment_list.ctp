<?php $session = $this->request->session()->read("User"); ?>
<script type="text/javascript">
    $(function () {
        $(document).tooltip();
    });
    $(document).ready(function () {
        jQuery(".expense_form").validationEngine();
        jQuery('#payment_list').DataTable({
            "responsive": true,
            "order": [[1, "asc"]],
            "aoColumns": [
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true, "sWidth": "1"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true},
                {"bSortable": false}],
            "language": {<?php echo $this->Gym->data_table_lang(); ?>}
        });
    });
</script>
<section class="content">
    <br>
    <div class="col-md-12 box box-default">		
        <div class="box-header">
            <section class="content-header">
                <h1>
                    <i class="fa fa-plus"></i>
                    <?php echo __("Payment"); ?>
                    <small><?php echo __("Workout Daily"); ?></small>
                </h1>
                <?php
                if ($session["role_name"] == "administrator" || $session["role_name"] == "licensee" || $session["role_name"] == "staff_member") {
                    ?>
                    <ol class="breadcrumb">
                        <a href="<?php echo $this->Gym->createurl("MembershipPayment", "generatePaymentInvoice"); ?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Generate Payment Invoice"); ?></a>
                    </ol>
                <?php } ?>
            </section>
        </div>
        <hr>
        <div class="box-body">
            <table id="payment_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><?php echo __('Title', 'gym_mgt'); ?></th>
                        <th><?php echo __('Member Name', 'gym_mgt'); ?></th>
                        <th><?php echo __('Amount', 'gym_mgt'); ?></th>
                        <th><?php echo __('Paid Amount', 'gym_mgt'); ?></th>
                        <th><?php echo __('Due Amount', 'gym_mgt'); ?></th>
                        <th><?php echo __('Membership Start Date', 'gym_mgt'); ?></th>
                        <th><?php echo __('Membership End Date', 'gym_mgt'); ?></th>
                        <th><?php echo __('Payment Status', 'gym_mgt'); ?></th>
                        <th><?php echo __('Plan Status', 'gym_mgt'); ?></th>
                        <th><?php echo __('Action', 'gym_mgt'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $row) {
                            
                            if($row['mem_plan_status'] == 1 && $row['payment_status'] == 1 ){
                                $plan_status = "<span class='label label-success'>Current</span>";
                                
                            }else if ($row['mem_plan_status'] == 2 && $row['payment_status'] == 0) {
                                $plan_status = "<span class='label label-warning'>Wish</span>";
                                
                            }else if ($row['mem_plan_status'] == 0 && $row['payment_status'] == 1 ){
                                $plan_status = "<span class='label label-warning'>Disabled</span>";
                            }else if ($row['mem_plan_status'] == 0 && $row['payment_status'] ==  0){
                                $plan_status = "<span class='label label-default'>Pending</span>";
                            }else if ($row['mem_plan_status'] == 3 && $row['payment_status'] ==  1){
                                $plan_status = "<span class='label label-danger'>Expired</span>";
                            }else if ($row['mem_plan_status'] == 2 && $row['payment_status'] ==  1){
                                $plan_status = "<span class='label label-danger'>Changed</span>";
                            }
                            
                            if( __($this->Gym->get_membership_paymentstatus($row['mp_id'])) == 'Fully Paid'){
                                $pay_status = "<span class='label label-success'>".__($this->Gym->get_membership_paymentstatus($row['mp_id']))."</span>";
                            }else if(__($this->Gym->get_membership_paymentstatus($row['mp_id'])) == 'Not Paid'){
                                $pay_status = "<span class='label label-default'>".__($this->Gym->get_membership_paymentstatus($row['mp_id']))."</span>";
                            }else if(__($this->Gym->get_membership_paymentstatus($row['mp_id'])) == 'Partially Paid'){
                                $pay_status = "<span class='label label-warning'>".__($this->Gym->get_membership_paymentstatus($row['mp_id']))."</span>";
                            }
                            // $due = ($row['membership_amount']- $row['paid_amount'])+($row['membership']['signup_fee']);
                            $due = ($row['membership_amount'] - $row['paid_amount']);
                            echo "<tr>
								<td>{$row['membership']['membership_label']}</td>
								<td>{$row['gym_member']['first_name']} {$row['gym_member']['last_name']}</td>
								<td>" . $this->Gym->get_currency_symbol() . " {$row['membership_amount']}</td>
								<td>" . $this->Gym->get_currency_symbol() . " {$row['paid_amount']}</td>
								<td>" . $this->Gym->get_currency_symbol() . " {$due}</td>
								<td>" . date($this->Gym->getSettings("date_format"), strtotime($row["start_date"])) . "</td>
								<td>" . date($this->Gym->getSettings("date_format"), strtotime($row["end_date"])) . "</td>
								<td>".$pay_status ."</td>
                                                                <td>".$plan_status."</td>
								<td>";
                                                                if($due <= 0){
                                                                    echo "<a href='javascript:void(0)' class='btn btn-flat btn-default' onclick=\"alert('No Dues')\">" . __('Pay') . "</a>";
                                                                }else{
                                                                    echo "<a href='javascript:void(0)' class='btn btn-flat btn-default amt_pay' data-url='" . $this->request->base . "/GymAjax/gymPay/{$row['mp_id']}'>" . __('Pay') . "</a>";
                                                                }
								echo "<a href='javascript:void(0)' class='btn btn-flat btn-info view_invoice' data-url='" . $this->request->base . "/GymAjax/viewInvoice/{$row['mp_id']}'><i class='fa fa-eye'></i></a>
                                                                <a href='" . $this->request->base . "/MembershipPayment/MembershipEdit/{$row['mp_id']}' class='btn btn-flat btn-primary' title='Edit'><i class='fa fa-edit'></i></a>";
                            if ($session["role_name"] == "administrator" || $session["role_name"] == "licensee") {
                                echo "<a href='" . $this->request->base . "/MembershipPayment/deletePayment/{$row['mp_id']}' class='btn btn-flat btn-danger' onclick=\"return confirm('Are you sure,You want to delete this record?')\"><i class='fa fa-trash'></i></a>";
                            }
                            echo "</td>
						</tr>";
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><?php echo __('Title', 'gym_mgt'); ?></th>
                        <th><?php echo __('Member Name', 'gym_mgt'); ?></th>
                        <th><?php echo __('Amount', 'gym_mgt'); ?></th>
                        <th><?php echo __('Paid Amount', 'gym_mgt'); ?></th>
                        <th><?php echo __('Due Amount', 'gym_mgt'); ?></th>
                        <th><?php echo __('Membership Start Date', 'gym_mgt'); ?></th>
                        <th><?php echo __('Membership End Date', 'gym_mgt'); ?></th>
                        <th><?php echo __('Payment Status', 'gym_mgt'); ?></th>
                        <th><?php echo __('Plan Status', 'gym_mgt'); ?></th>
                        <th><?php echo __('Action', 'gym_mgt'); ?></th>
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