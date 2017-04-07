<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
    <?= $this->Element('header') ?>

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
        <div class="page-wrapper">
            <?= $this->Element('topbar') ?>	
            <div class="clearfix"> </div>
            <div class="page-container">
                <div class="page-sidebar-wrapper">
                    <?= ""/* $this->Element('sidebar') */ ?>
                    <?php
                    /* $session = $this->request->session()->read("User");
                      $role_name = $session["role_name"];
                      switch($role_name)
                      {
                      CASE "administrator":
                      $menu_cell = $this->cell('GymRenderMenu::adminMenu');
                      break;

                      CASE "member":
                      $menu_cell = $this->cell('GymRenderMenu::memberMenu');
                      break;

                      CASE "staff_member":
                      $menu_cell = $this->cell('GymRenderMenu::staffMenu');
                      break;

                      CASE "accountant":
                      $menu_cell = $this->cell('GymRenderMenu::accMenu');
                      break;
                      } */
                    $menu_cell = $this->cell('GymRenderMenu::adminMenu');
                    ?>

                    <?= $menu_cell ?>

                </div>

                <!--      <div class="page-content-wrapper">
                           <div class="page-content">
                               
                               <div class="page-bar">
                                   <ul class="page-breadcrumb">
                                       <li>
                                           <a href="#">Home</a>
                                           <i class="fa fa-circle"></i>
                                       </li>
                                       <li>
                                           <span>Dashboard</span>
                                       </li>
                                   </ul>
                                   <div class="page-toolbar">
                                       <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                           <i class="icon-calendar"></i>&nbsp;
                                           <span class="thin uppercase hidden-xs"></span>&nbsp;
                                           <i class="fa fa-angle-down"></i>
                                       </div>
                                   </div>
                               </div>
                               
                                <div class="row">
                                <div class="body-overlay">
                                  <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                                </div>
                              
                                 <script>
                                   $(".body-overlay").css("display","block");
                                   $("body").css("overflow-y","hidden");
                                 </script>
                <?= $this->Flash->Render() ?>
                <?= $this->fetch('content') ?>
                               
                                        <div class="modal fade gym-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                          <div class="modal-dialog modal-lg gym-modal">
                                                <div class="modal-content">			
                                                
                                                </div>
                                          </div>
                                        </div>
                                </div>
                           </div>
                           
                      </div>-->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->

                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">Tables</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Datatables</span>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->

                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->

                        <div class="row">
                            
                              
                                 
                            <?= $this->Flash->Render() ?>
                            <?= $this->fetch('content') ?>
                            <div class="modal fade gym-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                <div class="modal-dialog modal-lg gym-modal">
                                    <div class="modal-content">			

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- END CONTENT BODY -->
                </div>
            </div>
            <?= $this->Element('footer') ?>

            
        </div>

    </body>
</html>