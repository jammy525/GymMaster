<?php

echo $this->Html->css('payment');
echo $this->Html->script('jquery.creditCardValidator');
echo $this->Html->script('card');
$session = $this->request->session()->read("User");
?>
<section class="content">
    <br>
    <div class="col-md-12 box box-default">		
        <div class="box-header">
            <section class="content-header">
                <h1>
                    <i class="fa fa-plus"></i>
                    <?php echo __("Upgrade MemberShip"); ?>
                    <small><?php echo __("Payment"); ?></small>
                </h1>
                <!--<ol class="breadcrumb">
                        <a href="<?php echo $this->Gym->createurl("MembershipPayment", "expenseList"); ?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Expense List"); ?></a>
                </ol>-->
            </section>
        </div>
        <hr>
        
        <div class="box-body" id="paymentGrid" >
            <?php
          // print_r($data);
            ?>
            <div class="col-md-7">
                <label class="control-label col-md-12"><strong>Membership Name: </strong>  <?php echo $data['membership_label']?></label>
                <label class="control-label col-md-12"><strong>Membership Period  : </strong> <?php echo $data['membership_length']?> Days</label>
                <label class="control-label col-md-12"><strong>Membership Limit  :  </strong><?php echo $data['membership_class_limit']?> </label>
                <label class="control-label col-md-12"><strong>Membership Amount  :  </strong>$<?php echo $data['membership_amount']?> </label>
                <label class="control-label col-md-12"><strong>Membership Description  :  </strong>    <?php echo $data['membership_description']?> </label>
            </div>
            <div class="col-md-5">
            <form method="post"  id="paymentForm">
                <strong>Payment details</strong>
                <input type="hidden" name="planID" id="planID" value="<?php echo $data['id']?>">
                <ul>

                    <li>
                        <label>Card Number </label>
                        <input type="text" name="card_number" id="card_number"  maxlength="20" placeholder="1234 5678 9012 3456"/>
                    </li>
                    <li>
                        <label>Name on Card</label>
                        <input type="text" name="card_name" id="card_name" placeholder="Ashok Singh"/>
                    </li>
                    <li class="vertical">

                        <ul>
                            <li>
                                <label>Expires</label>
                                <input type="text" name="expiry_month" id="expiry_month" maxlength="2" placeholder="MM" class="inputLeft marginRight" />
                                <input type="text" name="expiry_year" id="expiry_year" maxlength="2" placeholder="YY"  class="inputLeft "/>
                            </li>
                            <li style="text-align:right">
                                <label>CVV</label>
                                <input type="text" name="cvv" id="cvv" maxlength="3" placeholder="123" class="inputRight"/>
                            </li>
                        </ul>

                    </li>
                    <li>
                        <input type="submit" id="paymentButton" value="Proceed" disabled="true" class="disable">
                    </li>
                </ul>
            </form>
                <input type="hidden" value="<?php echo $this->request->base;?>/GymAjax/upgrade_payment" id="mem_class_url">
            </div>
            
        </div>
        <div id="orderInfo"></div>
    </div>
</section>
<script>
$(document).ready(function(){
   
        /*Payment Form */
    
$("#paymentForm").submit(function() 
{
var datastring = $(this).serialize();
 var ajaxurl = $("#mem_class_url").val();
$.ajax({
type: "POST",
url: ajaxurl,
data: datastring,
dataType: "json",
beforeSend: function()
{  
$("#paymentButton").val('Processing..');
},
success: function(data) 
{

$.each(data.OrderStatus, function(i,data)
{
var HTML;
if(data)
{
 $("#paymentGrid").slideUp("slow");  
 $("#orderInfo").fadeIn("slow");

if(data.status == '1')
{
HTML="Order <span>#12345</span> has been created successfully."; 
}
else if(data.status == '2')
{
HTML="Transaction has been failed, please use other card."; 
}
else
{
HTML="Card number is not valid, please use other card."; 
}

$("#orderInfo").html(HTML);
}


});


},
error: function(){ alert('error handing here'); }
});
return false;

});
});
    </script>