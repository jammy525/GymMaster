<head>
   <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
	<?php 
		//echo $this->Html->css('bootstrap.min');
		
		$session = $this->request->session();
		if($session->read("User.is_rtl") == "1")
		{
			//echo $this->Html->css('bootstrap-rtl.min');
			//echo $this->Html->css('AdminLTE-rtl.min');
			echo "<style>
					div.success,div.error{
						right : 15px;
					}
				  </style>";
		}
		else
		{
                    //echo $this->Html->css('AdminLTE.min');
		}
                echo $this->Html->css('assets/global/plugins/font-awesome/css/font-awesome.min.css');
                echo $this->Html->css('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
                echo $this->Html->css('assets/global/plugins/bootstrap/css/bootstrap.min.css');
                echo $this->Html->css('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
                
                echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css');
                echo $this->Html->css('assets/global/plugins/morris/morris.css');
                echo $this->Html->css('assets/global/plugins/fullcalendar/fullcalendar.min.css');
                echo $this->Html->css('assets/global/plugins/jqvmap/jqvmap/jqvmap.css');
                echo $this->Html->css('assets/global/plugins/datatables/datatables.min.css');
                echo $this->Html->css('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
                echo $this->Html->css('assets/global/css/components.min.css');
                echo $this->Html->css('assets/global/css/plugins.min.css');
                
                echo $this->Html->css('assets/layouts/layout/css/layout.min.css');
                echo $this->Html->css('assets/layouts/layout/css/themes/darkblue.min.css');
                echo $this->Html->css('assets/layouts/layout/css/custom.min.css');
               
		
		
		/*echo $this->Html->css('skins/skin-green.min');
		
		
		echo $this->Html->css('plugins/morris/morris');
		echo $this->Html->css('plugins/jvectormap/jquery-jvectormap-1.2.2');
		echo $this->Html->css('plugins/datepicker/datepicker3');
		echo $this->Html->css('plugins/daterangepicker/daterangepicker-bs3');
		echo $this->Html->css('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min');
		echo $this->Html->css('validationEngine/validationEngine.jquery');
		
		echo $this->Html->css('dataTables.css');	
		echo $this->Html->css('bootstrap-datepaginator');
		echo $this->Html->meta('icon') ;
                
		echo $this->Html->css('gym_custom');
		echo $this->Html->css('gym_responsive');
		
		echo $this->Html->css('ionicons.min.css');
		*/
   
		
		//echo $this->Html->script('raphael-min');
		//echo $this->Html->script('moment.min') ;
		$dtp_lang = $session->read("User.dtp_lang");
		if($this->request->action == "addWorkout")
		{ ?> 
		<script>moment.locale('<?php echo $dtp_lang;?>');</script>
		<?php } 
                echo $this->Html->script('assets/global/plugins/jquery.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap/js/bootstrap.min.js');
echo $this->Html->script('assets/global/plugins/js.cookie.min.js');
echo $this->Html->script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
echo $this->Html->script('assets/global/plugins/jquery.blockui.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');

        echo $this->Html->script('assets/global/plugins/moment.min.js');
        echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js');
        echo $this->Html->script('assets/global/plugins/morris/morris.min.js');
        echo $this->Html->script('assets/global/plugins/morris/raphael-min.js');
        echo $this->Html->script('assets/global/plugins/counterup/jquery.waypoints.min.js');
        echo $this->Html->script('assets/global/plugins/counterup/jquery.counterup.min.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/amcharts.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/serial.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/pie.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/radar.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/themes/light.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/themes/patterns.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amcharts/themes/chalk.js');
        echo $this->Html->script('assets/global/plugins/amcharts/ammap/ammap.js');
        echo $this->Html->script('assets/global/plugins/amcharts/ammap/maps/js/worldLow.js');
        echo $this->Html->script('assets/global/plugins/amcharts/amstockcharts/amstock.js');
        echo $this->Html->script('assets/global/plugins/fullcalendar/fullcalendar.min.js');
        echo $this->Html->script('assets/global/plugins/horizontal-timeline/horizontal-timeline.js');
        echo $this->Html->script('assets/global/plugins/flot/jquery.flot.min.js');
        echo $this->Html->script('assets/global/plugins/flot/jquery.flot.resize.min.js');
        echo $this->Html->script('assets/global/plugins/flot/jquery.flot.categories.min.js');
        echo $this->Html->script('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js');
        echo $this->Html->script('assets/global/plugins/jquery.sparkline.min.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js');
        echo $this->Html->script('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js');
        echo $this->Html->script('assets/global/scripts/datatable.js');
        echo $this->Html->script('assets/global/plugins/datatables/datatables.min.js');
        echo $this->Html->script('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
        echo $this->Html->script('assets/global/scripts/app.min.js');
        //echo $this->Html->script('assets/pages/scripts/table-datatables-managed.min.js');
        echo $this->Html->script('assets/pages/scripts/table-datatables-buttons.min.js');
        echo $this->Html->script('assets/pages/scripts/dashboard.min.js');
        
        echo $this->Html->script('assets/layouts/layout/scripts/layout.min.js');
        echo $this->Html->script('assets/layouts/layout/scripts/demo.min.js');
        echo $this->Html->script('assets/layouts/global/scripts/quick-sidebar.min.js');
        echo $this->Html->script('assets/layouts/global/scripts/quick-nav.min.js');
		/*echo $this->Html->script('jQuery/jQuery-2.1.4.min.js');
		echo $this->Html->script('bootstrap/js/bootstrap.min.js') ;
		echo $this->Html->script('jquery-ui.min') ;
		echo $this->Html->script('morris/morris.js');
		echo $this->Html->script('morris/morris.min.js');
		echo $this->Html->script('jvectormap/jquery-jvectormap-1.2.2.min.js') ;
		echo $this->Html->script('jvectormap/jquery-jvectormap-world-mill-en.js') ;
		echo $this->Html->script('knob/jquery.knob.js') ;
		echo $this->Html->script('daterangepicker/daterangepicker.js');
		
		echo $this->Html->script('bootstrap-datepaginator');
		echo $this->Html->script('datepicker/bootstrap-datepicker.js');		
		
		echo $this->Html->script("datepicker/locales/bootstrap-datepicker.{$dtp_lang}");
		
		echo $this->Html->script('datatables/jquery.dataTables.min.js'); 
		echo $this->Html->script('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
		echo $this->Html->script('slimScroll/jquery.slimscroll.min.js');
		echo $this->Html->script('fastclick/fastclick.min.js');
                */
                echo $this->Html->script('daterangepicker/daterangepicker.js');
		
		echo $this->Html->script('bootstrap-datepaginator');
		echo $this->Html->script('datepicker/bootstrap-datepicker.js');		
		
		echo $this->Html->script("datepicker/locales/bootstrap-datepicker.{$dtp_lang}");
		echo $this->Html->script('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
		?>
		<script>
  var AdminLTEOptions = {
    //Enable sidebar expand on hover effect for sidebar mini
    //This option is forced to true if both the fixed layout and sidebar mini
    //are used together
    sidebarExpandOnHover: false,
    //BoxRefresh Plugin
    enableBoxRefresh: true,
    //Bootstrap.js tooltip
    enableBSToppltip: false
	 // BSTooltipSelector: "[data-toggle='tooltip']"
  };
</script>
		<?php
	         echo $this->Html->script('app.min.js');
		echo $this->Html->script('validationEngine/languages/jquery.validationEngine-en');
		echo $this->Html->script('validationEngine/jquery.validationEngine'); 
		echo $this->Html->script('gym_ajax'); 
	

		echo $this->fetch('meta'); 
		echo $this->fetch('css');
		echo $this->fetch('script');
                 
                
	?>
	
	<script>
		$(document).ready(function(){
                    $(".validateForm").validationEngine(); 
                    $('.textarea').wysihtml5();
                    
                    $(".hasDatepicker,.datepick,.mem_valid_from,.date,.mem_valid_from,.sell-date,.dob,.hasdatepicker,.datepicker-days").datepicker({
                        language: "<?php echo $dtp_lang;?>",
                        format: "<?php echo $this->Gym->get_js_dateformat($this->Gym->getSettings("date_format")); ?>",
                        forceParse: false

                    });	
		
		})		
	</script>
</head>
