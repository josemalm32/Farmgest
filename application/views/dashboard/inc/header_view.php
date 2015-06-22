

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nutrimondego | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta http-equiv="refresh" content="900;url=<?=base_url()?>index.php/home/lockscreen" />
        <?php
            foreach($css_files as $file): ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
            <?php endforeach; ?>
            <?php foreach($js_files as $file): ?>
                <script src="<?php echo $file; ?>"></script>
            <?php endforeach; ?>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=base_url()?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?=base_url()?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?=base_url()?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?=base_url()?>public/css/nutrimondego.css" rel="stylesheet" type="text/css" />

    </head>
   <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?=base_url()?>index.php/dashboard" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->

                <?php echo $this->session->userdata('entity') ?>
                
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <?php if ($id == 2 || $id == 3): ?>
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <label>Reports</label>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach($query as $row) :?>
                                            <li><!-- Query item -->
                                                <a href="<?=base_url()?>index.php/finances/test_query/<?php echo $row['id'] ?>">
                                                    <h3>
                                                        <?php echo $row['id'] ?> <?php echo $row['title'] ?>
                                                    </h3>
                                                </a>
                                            </li><!-- end task item -->
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all Query</a>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">1</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 1 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?=base_url()?>/public/img/avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?=base_url()?>/public/img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Design Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?=base_url()?>/public/img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?=base_url()?>/public/img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Sales Department
                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?=base_url()?>/public/img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">5</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 5 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                            </a>
                            <ul class="dropdown-menu">
                                
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                    <?php foreach($task as $row) :?>
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    <?php echo $row['id_task'] ?> <?php echo $row['name'] ?>
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="<?=base_url()?>index.php/dashboard/g_tasks_menu">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata('name') ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?=base_url()?>/public/img/avatar5.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $this->session->userdata('name') ?>
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?=base_url()?>index.php/dashboard/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?=base_url()?>/public/img/avatar5.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $this->session->userdata('name') ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <?php if ($id == 1): ?>
                            <li class="treeview">
                        <?php endif; ?>
                            <a href="<?=base_url()?>index.php/dashboard">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>  
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                        </li>
                        <?php if ($id == 2): ?>
                            <li class="<?php echo $active ?>">
                        <?php else: ?>
                            <li class="treeview">
                        <?php endif; ?>
                            <a href="#">
                                <i class="fa fa-th"></i> 
                                <span>Finances</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?=base_url()?>index.php/finances/fin_expenses_menu"><i class="fa fa-angle-double-right"></i>Expenses</a></li>
                                <li><a href="<?=base_url()?>index.php/finances/fin_expenses_detail_menu"><i class="fa fa-angle-double-right"></i>Expenses Detail</a></li>
                                <li><a href="<?=base_url()?>index.php/finances/fin_expenses_type_menu"><i class="fa fa-angle-double-right"></i>Expenses Type</a></li>   
                                <li><a href="<?=base_url()?>index.php/finances/fin_orders_menu"><i class="fa fa-angle-double-right"></i>Orders</a></li>
                                <li><a href="<?=base_url()?>index.php/finances/fin_orders_detail_menu"><i class="fa fa-angle-double-right"></i>Orders Detail</a></li> 
                                <li><a href="<?=base_url()?>index.php/finances/fin_vendor_client_menu"><i class="fa fa-angle-double-right"></i>Customer/Vendors</a></li>
                                <li><a href="<?=base_url()?>index.php/finances/fin_orders_plants_menu"><i class="fa fa-angle-double-right"></i>Plants Orders</a></li>
                                <li><a href="<?=base_url()?>index.php/finances/fin_product_type_menu"><i class="fa fa-angle-double-right"></i>Product Type</a></li>           
                            </ul>
                        </li>
                        <?php if ($id == 3): ?>
                            <li class="<?php echo $active ?>">
                        <?php else: ?>
                            <li class="treeview">
                        <?php endif; ?>
                            <a href="#">
                                <i class="fa fa-home"></i>
                                <span>Traceability</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?=base_url()?>index.php/rastreability/prod_season_menu"><i class="fa fa-angle-double-right"></i>Season</a></li>
                                <li><a href="<?=base_url()?>index.php/rastreability/prod_season_problems_menu"><i class="fa fa-angle-double-right"></i>Season Problems</a></li>    
                                <li><a href="<?=base_url()?>index.php/rastreability/prod_fertilization_menu"><i class="fa fa-angle-double-right"></i>Fertilization</a></li>
                                <li><a href="<?=base_url()?>index.php/rastreability/prod_treatment_menu"><i class="fa fa-angle-double-right"></i>Treatment</a></li>
                                <li><a href="<?=base_url()?>index.php/rastreability/prod_season_harvast_menu"><i class="fa fa-angle-double-right"></i>Season Harvast</a></li>
                            </ul>
                        </li>
                        <?php if ($id == 4): ?>
                            <li class="<?php echo $active ?>">
                        <?php else: ?>
                            <li class="treeview">
                        <?php endif; ?>
                            <a href="#">
                                <i class="fa fa-table"></i> 
                                <span>Operation</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?=base_url()?>index.php/operation/prod_storage_menu"><i class="fa fa-angle-double-right"></i>Production Storage</a></li>  
                                <li><a href="<?=base_url()?>index.php/operation/prod_storage_consum_menu"><i class="fa fa-angle-double-right"></i>Production Storage Consumed</a></li>
                                <li><a href="<?=base_url()?>index.php/operation/g_contacts_menu"><i class="fa fa-angle-double-right"></i>Contacts</a></li>  
                                <li><a href="<?=base_url()?>index.php/operation/g_tasks_menu"><i class="fa fa-angle-double-right"></i>Tasks</a></li>  
                                <li><a href="<?=base_url()?>index.php/operation/g_tasks_users_menu"><i class="fa fa-angle-double-right"></i>Users Tasks</a></li>  
                                <li><a href="<?=base_url()?>index.php/operation/g_alarms_menu"><i class="fa fa-angle-double-right"></i>Alarms</a></li>  
                                <li><a href="<?=base_url()?>index.php/operation/g_documents_menu"><i class="fa fa-angle-double-right"></i>Documents</a></li> 
                                <li><a href="<?=base_url()?>index.php/operation/g_documents_labels_menu"><i class="fa fa-angle-double-right"></i>Documents Labels</a></li>   
                                <li><a href="<?=base_url()?>index.php/operation/g_assets_reserve_menu"><i class="fa fa-angle-double-right"></i>Assets Reserve</a></li> 
                                <li><a href="<?=base_url()?>index.php/operation/globalgap_documentation_menu"><i class="fa fa-angle-double-right"></i>GlobalGap Documentation Support</a></li>  
                                <li><a href="<?=base_url()?>index.php/operation/globalgap_response_menu"><i class="fa fa-angle-double-right"></i>GlobalGap Response</a></li>   
                            </ul>
                        </li>
                        <?php if ($id == 5): ?>
                            <li class="<?php echo $active ?>">
                        <?php else: ?>
                            <li class="treeview">
                        <?php endif; ?>
                            <a href="#">
                                <i class="fa fa-folder"></i> 
                                <span>Configuration</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?=base_url()?>index.php/configuration/g_changelog_menu"><i class="fa fa-angle-double-right"></i>ChangeLog</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/g_menus_menu"><i class="fa fa-angle-double-right"></i>Menus</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/rep_configuration_menu"><i class="fa fa-angle-double-right"></i>Configuration</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/g_assets_category_menu"><i class="fa fa-angle-double-right"></i>Assets Category</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/g_assets_menu"><i class="fa fa-angle-double-right"></i>Assets</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/g_labels_menu"><i class="fa fa-angle-double-right"></i>Labels</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/entity_menu"><i class="fa fa-angle-double-right"></i>Entitys</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/farm_menu"><i class="fa fa-angle-double-right"></i>Farms</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/users_menu"><i class="fa fa-angle-double-right"></i>Users</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/prod_storage_house_menu"><i class="fa fa-angle-double-right"></i>Production Storage House</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/prod_sorts_menu"><i class="fa fa-angle-double-right"></i>Production Sorts</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/prod_fields_menu"><i class="fa fa-angle-double-right"></i>Production Fields</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/prod_fields_sections_menu"><i class="fa fa-angle-double-right"></i>Production FieldSection</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/globalgap_menu"><i class="fa fa-angle-double-right"></i>GlobalGap</a></li>
                                <li><a href="<?=base_url()?>index.php/configuration/globalgap_402_menu"><i class="fa fa-angle-double-right"></i>GlobalGap 402</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>