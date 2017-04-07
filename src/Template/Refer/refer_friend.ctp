<script>
    $(document).ready(function () {
        $(".hasdatepicker").datepicker({rtl: true});
    });

    
</script>

<section class="content">
    <br>
    <div class="col-md-12 box box-default">		
        <div class="box-header">
            <section class="content-header">
                <h1>
                    <i class="fa fa-plus"></i>
                    <?php echo __("Refer a Friend"); ?>
                    <small><?php echo __("Refer"); ?></small>
                </h1>
                <ol class="breadcrumb">
                      <!-- <a href="<?php // echo $this->Gym->createurl("GymNotice","NoticeList"); ?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php //echo __("Notice List"); ?></a> -->
                </ol>
            </section>
        </div>
        <hr>
        <div class="box-body">

            <div class="col-md-12">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#message_form').validationEngine();
                    });
                </script>
                <div class="mailbox-content">
                    <h2></h2>
                    <form name="class_form" action="" method="post" class="form-horizontal" id="message_form">
                        

                        <input type="hidden" name="action" value="insert">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="to"><?php echo __("Refer To"); ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input id="refer_to" class="form-control validate[required,custome[email]] text-input" type="text" name="refer_to">

                            </div>	
                        </div>
                        <div id="smgt_select_class">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="sms_template"><?php echo __("Select Class"); ?></label>
                                <div class="col-sm-8">				
                                    <?php echo $this->Form->select("class_id", $classes, ["empty" => __("None"), "class" => "form-control"]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="subject"><?php echo __("Subject"); ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input id="subject" class="form-control validate[required] text-input" type="text" name="subject">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="subject"><?php echo __("Message Comment"); ?></label>
                            <div class="col-sm-8">
                                <textarea name="message_body" id="message_body" class="form-control text-input"></textarea>
                            </div>
                        </div>											

                        <div class="form-group">
                            <div class="col-sm-10">
                                <div class="pull-right">
                                    <input type="submit" value="<?php echo __("Send"); ?>" name="save_message" class="btn btn-flat btn-success">
                                </div>
                            </div>
                        </div>

                    </form>				
                </div>
            </div>



            <!-- END -->
        </div>
        <div class='overlay gym-overlay'>
            <i class='fa fa-refresh fa-spin'></i>
        </div>
    </div>
</section>