<div class="modal-header">
    <h4 class="modal-title" id="gridSystemModalLabel"><?php echo __("Invoice"); ?></h4>
    </div>
        <div class="modal-body">
            <div id="invoice_print"> 
                <table width="100%" border="0">
                    <tbody>
                        <tr>
                            <td width="70%">
                                <img style="max-height:80px;max-width:100px;" src="<?php echo $sys_data[0]["gym_logo"]; ?>">
                            </td>
                            <td align="right" width="24%">
                                <h5><?php
                                    $issue_date = $data[0]['created_date']->format($sys_data[0]['date_format']);
                                    $issue_date = date($sys_data[0]['date_format'], strtotime($issue_date));
                                    echo __('Issue Date') . " : " . $issue_date;
                                    ?></h5>
                                <h5><?php
                                    echo __('Status') . " : ";
                                    echo "<span class='btn btn-success btn-xs'>";
                                    echo __($this->Gym->get_membership_paymentstatus($mp_id));
                                    echo "</span>";
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
                            <td align="<?php echo $float_l; ?>">
                                <h4><?php echo __('Payment To'); ?> </h4>
                            </td>
                            <td align="<?php echo $float_r; ?>">
                                <h4><?php echo __('Bill To'); ?> </h4>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" align="<?php echo $float_l; ?>">
                                <?php
                                echo $sys_data[0]["name"] . "<br>";
                                echo $sys_data[0]["address"] . ",";
                                echo $sys_data[0]["country"] . "<br>";
                                echo $sys_data[0]["office_number"] . "<br>";
                                ?>
                            </td>
                            <td valign="top" align="<?php echo $float_r; ?>">
                                <?php
                                $member_id = $data[0]["member_id"];
                                echo $data[0]["gym_member"]["first_name"] . " " . $data[0]["gym_member"]["last_name"] . "<br>";
                                echo $data[0]["gym_member"]["address"] . ",";
                                echo $data[0]["gym_member"]["city"] . ",";
                                echo $data[0]["gym_member"]["zipcode"] . ",<BR>";
                                echo $data[0]["gym_member"]["state"] . ",";
                                echo $sys_data[0]["country"] . ",";
                                echo $data[0]["gym_member"]["mobile"] . "<br>";
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
                            <th class="text-center"> <?php echo __('Membership Type'); ?></th>
                            <th class="text-center"> <?php echo __('Membership Fee'); ?></th>
                            <th class="text-center"><?php echo __('Total'); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center"><?php echo $data[0]["membership"]["membership_label"]; ?></td>

                            <td class="text-center"><?php echo $this->Gym->get_currency_symbol(); ?> <?php echo number_format((float)($data[0]["membership"]["membership_amount"]), 2, '.', ''); ?></td>
                            <td class="text-center"><?php echo $this->Gym->get_currency_symbol(); ?> <?php echo $subtotal = number_format((float)($data[0]["membership"]["membership_amount"]), 2, '.', '') /* + intval($data[0]["membership"]["signup_fee"]); */ ?></td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" border="0">
                    
                    <tr>
                        <td width="80%" align="<?php echo $float_r; ?>"><?php echo __('Subtotal :'); ?></td>
                        <td align="<?php //echo $float_r; ?>"><?php echo $this->Gym->get_currency_symbol(); ?> <?php echo number_format((float)($subtotal), 2, '.', ''); ?></td>
                    </tr>
                    <tr>
                        <td width="80%" align="<?php echo $float_r; ?>"><?php echo __('Payment Made :'); ?></td>
                        <td align="<?php //echo $float_r; ?>"><?php echo $this->Gym->get_currency_symbol(); ?> <?php echo number_format((float)($data[0]["paid_amount"]), 2, '.', ''); ?></td>
                    </tr>
                    <tr>
                        <td width="80%" align="<?php echo $float_r; ?>"><?php echo __('Due Amount  :'); ?></td>
                        <td align="<?php //echo $float_r; ?>"><?php echo $this->Gym->get_currency_symbol(); ?> <?php echo number_format((float)($subtotal - $data[0]["paid_amount"]), 2, '.', '');  ?></td>
                    </tr>
                    			
                </table>
                <hr>
                <?php if (!empty($history_data)) {
                    ?>
                    <h4><?php echo __('Payment History'); ?></h4>
                    <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo __('Date'); ?></th>
                                <th class="text-center"> <?php echo __('Amount'); ?></th>
                                <th class="text-center"><?php echo __('Method'); ?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($history_data as $retrive_date) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo date($sys_data[0]['date_format'], strtotime($retrive_date["paid_by_date"])); ?></td>
                                    <td class="text-center"><?php echo $this->Gym->get_currency_symbol(); ?> <?php echo $retrive_date["amount"]; ?></td>
                                    <td class="text-center"><?php echo $retrive_date["payment_method"]; ?></td>
                                </tr>
            <?php } ?>
                        </tbody>
                    </table>
        <?php } ?>
            </div>
            
        </div>