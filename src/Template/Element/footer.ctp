<?php 
	$session = $this->request->session();
	$footer = $session->read("User.footer");
	$version = $session->read("User.version");
	$pull = ($session->read("User.is_rtl") == "1") ? "pull-left" : "pull-right"	;

 




?>
    <div class="page-footer">
        <div class="<?php echo $pull;?> hidden-xs">
          <b><?php echo _("Version");?></b> <?php echo $version;?>
        </div>
      <!--  <strong>Copyright &copy; 2016-2017 <a href=""> Das Infomedia</a> .</strong> All rights reserved.-->
	  <span><?php echo $footer;?></span>
          <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
    </div>

