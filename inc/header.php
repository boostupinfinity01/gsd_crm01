<?php
include('connection.php');
    
    $logged_user_id = "";
    $logged_user_actype = 0;
    $logged_username = "";
    if(getSession('log_userid') > 0)
    {
        $logged_user_id  = getSession('log_userid');
        $logged_user_actype = getSession('log_usertype');
        $logged_username = getSession('log_username');
        
        $get_name_query = "SELECT `user_pimage` FROM `users` WHERE `user_id`=$logged_user_id;";
        $get_name_result = $conn->query($get_name_query);
        $get_name_data = $get_name_result->fetch_assoc();
        $logged_user_img = $get_name_data['user_pimage'];  
        
        $form_pages = array();
        $add_perm = array();
        $edit_perm = array();
        $view_perm= array();
        $del_perm = array();
        
        $add_pr_pg1 = $add_pr_pg2 = $add_pr_pg3 = $add_pr_pg4 = $add_pr_pg5 = $add_pr_pg6 = $add_pr_pg7 = $add_pr_pg8 = $add_pr_pg9 = $add_pr_pg10 = 0;
        $edit_pr_pg1 = $edit_pr_pg2 = $edit_pr_pg3 = $edit_pr_pg4 = $edit_pr_pg5 = $edit_pr_pg6 = $edit_pr_pg7 = $edit_pr_pg8 = $edit_pr_pg9 = $edit_pr_pg10 = 0;
        $view_pr_pg1 = $view_pr_pg2 = $view_pr_pg3 = $view_pr_pg4 = $view_pr_pg5 = $view_pr_pg6 = $view_pr_pg7 = $view_pr_pg8 = $view_pr_pg9 = $view_pr_pg10 = 0;
        $delete_pr_pg1 = $delete_pr_pg2 = $delete_pr_pg3 = $delete_pr_pg4 = $delete_pr_pg5 = $delete_pr_pg6 = $delete_pr_pg7 = $delete_pr_pg8 = $delete_pr_pg9 = $delete_pr_pg10 = 0;
        
        $get_permissions_sql = "SELECT * FROM `user_permission_tb`;";
        $get_permissions_query = $conn->query($get_permissions_sql);
        
        while($get_permissions_result = $get_permissions_query->fetch_assoc())
        {
            $form_pages[] = $get_permissions_result['form_page'];
            $add_perm[] = $get_permissions_result['pr_add'];
            $edit_perm[] = $get_permissions_result['pr_edit'];
            $view_perm[] = $get_permissions_result['pr_view'];
            $del_perm[] = $get_permissions_result['pr_delete'];
        }
        
        
        $pages_length = count($form_pages);
        
        for($i=0;$i<$pages_length;$i++)
        {
            $x = $form_pages[$i];
            $add_pr_arr = explode(",",$add_perm[$i]);
            $edit_pr_arr = explode(",",$edit_perm[$i]);
            $view_pr_arr = explode(",",$view_perm[$i]);
            $del_pr_arr = explode(",",$del_perm[$i]);
            
            switch ($x) {
                case 1:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg1 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg1 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg1 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg1 = 1;
                    }
                    break;
                case 2:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg2 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg2 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg2 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg2 = 1;
                    }
                    break;
                case 3:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg3 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg3 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg3 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg3 = 1;
                    }
                    break;
                case 4:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg4 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg4 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg4 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg4 = 1;
                    }
                    break;
                case 5:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg5 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg5 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg5 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg5 = 1;
                    }
                    break;
                case 6:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg6 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg6 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg6 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg6 = 1;
                    }
                    break;
                case 7:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg7 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg7 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg7 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg7 = 1;
                    }
                    break;
                case 8:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg8 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg8 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg8 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg8 = 1;
                    }
                    break;
                case 9:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg9 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg9 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg9 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg9 = 1;
                    }
                    break;
                case 10:
                    if (in_array($logged_user_actype, $add_pr_arr))
                    {
                        $add_pr_pg10 = 1;
                    }
                    if (in_array($logged_user_actype, $edit_pr_arr))
                    {
                        $edit_pr_pg10 = 1;
                    }
                    if (in_array($logged_user_actype, $view_pr_arr))
                    {
                        $view_pr_pg10 = 1;
                    }
                    if (in_array($logged_user_actype, $del_pr_arr))
                    {
                        $delete_pr_pg10 = 1;
                    }
                    break;
                default:
                    echo "No permissions given";
            }
        }
        
    }
    else
    {
        header("location: pages-login.php");
    }



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Macro Global - Best immigration consultant in punjab</title>
    <!-- This page CSS -->
    <link href="assets/node_modules/datatables/media/css/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- This page CSS -->
    <link href="assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    
    <link href="dist/css/pages/file-upload.css" rel="stylesheet">

    <!-- Dashboard 1 Page CSS -->
    <link href="dist/css/pages/dashboard4.css" rel="stylesheet">
    
    <!-- Page CSS -->
    <link href="dist/css/pages/contact-app-page.css" rel="stylesheet">
    
    <!-- wysihtml5 CSS -->
    <link rel="stylesheet" href="assets/node_modules/html5-editor/bootstrap-wysihtml5.css" />

    <!-- Dropzone css -->
    <link href="assets/node_modules/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
        
    <!-- page css -->
    <link href="dist/css/pages/inbox.css" rel="stylesheet">
    
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    
    <!-- Footable CSS -->
    <link href="assets/node_modules/footable/css/footable.core.html" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <!-- Page CSS -->
    <link href="dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="dist/css/pages/footable-page.css" rel="stylesheet">

    <!-- Footable CSS -->
    <link href="assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
    <!-- page css -->
    <link href="dist/css/pages/footable-page.css" rel="stylesheet">
    <link href="dist/css/pages/other-pages.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/node_modules/dropify/dist/css/dropify.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-default fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Macro Global</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                </b>
                        <!--End Logo icon -->
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <li class="d-none d-md-block d-lg-block">
                            <a href="javascript:void(0)" class="p-l-15">
                                <!--This is logo text-->
                                <img src="assets/images/logo-light-text.png" alt="home" class="light-logo" alt="home" />
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                       
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo $logged_user_img;?>" alt="user" class=""/> 
                                <span class="hidden-md-down"><?php echo $logged_username;?> &nbsp;<i class="fa fa-angle-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                <a href="pages-profile.php" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="account-setting.php" class="dropdown-item"><i class="ti-settings"></i> Change Password</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="" class="dropdown-item logout_btn"><i class="fa fa-power-off"></i> Logout</a>
                                <!-- text-->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-arrow-right ti-arrow-left"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="side-mini-panel">
            <ul class="mini-nav">
                <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>

                <!-- .Dashboard -->
                <li class="selected">
                    <a href="javascript:void(0)"><i class="icon-speedometer"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Dashboard</h3>
                        <ul class="sidebar-menu">
                            <li><a href="index.php">Home </a></li>

                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <!-- /.Dashboard -->
                <!-- .Apps -->
                <?php
                if($view_pr_pg1 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0)"><i class="ti-clipboard"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> Reception Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="reception-list.php"> <i class="ti-angle-double-right"></i> Reception Form List</a></li>
                            <?php
                            if($add_pr_pg1 == 1)
                            {
                            ?>
                            <li><a href="reception-add.php"> <i class="ti-angle-double-right"></i> Add Reception Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>
                
                <?php
                if($view_pr_pg2 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0)"><i class="ti-map-alt"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> Tourist/Vistor Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="visitor_visa_list.php"> <i class="ti-angle-double-right"></i> Tourist/Vistor Visa List</a></li>
                            <?php
                            if($add_pr_pg2 == 1)
                            {
                            ?>
                            <li><a href="visitor-visa-form.php"> <i class="ti-angle-double-right"></i> Add Tourist/Vistor Visa Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>

<!--li class=""><a href="javascript:void(0)"><i class="ti-world"></i></a>
                    <div class="sidebarmenu"-->
                        <!-- Left navbar-header -->
                        <!--h3 class="menu-title"> Tourist Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="tourist_visa_list.php"> <i class="ti-angle-double-right"></i> Tourist Visa Form List</a></li>
                            <li><a href="tourist-visa-form.php"> <i class="ti-angle-double-right"></i> Add Tourist Visa Form</a></li>
                        </ul-->
                        <!-- Left navbar-header end -->
                    <!--/div>
                </li-->


                <?php
                if($view_pr_pg3 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0)"><i class="ti-book"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> Study Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="study_visa_list.php"> <i class="ti-angle-double-right"></i> Study Visa Form List</a></li>
                            <?php
                            if($add_pr_pg3 == 1)
                            {
                            ?>
                            <li><a href="study-visa-form.php"> <i class="ti-angle-double-right"></i> Add Study Visa Form</a></li>
                            <?php
                            }
                            ?>
                            
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>

                <?php
                if($view_pr_pg4 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0)"><i class="ti-truck"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> Open Work Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="work-visa-list.php"> <i class="ti-angle-double-right"></i> Open Work Permit List</a></li>
                            <?php
                            if($add_pr_pg4 == 1)
                            {
                            ?>
                            <li><a href="work-visa-form.php"> <i class="ti-angle-double-right"></i> Add Open Work Permit Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>

                <?php
                if($view_pr_pg5 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0)"><i class="ti-briefcase"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> Dependant Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="business-visa-list.php"> <i class="ti-angle-double-right"></i> Dependant Visa Form List</a></li>
                            <?php
                            if($add_pr_pg5 == 1)
                            {
                            ?>
                            <li><a href="business-visa-form.php"> <i class="ti-angle-double-right"></i> Add Dependant Visa Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>
                
                <?php
                if($view_pr_pg6 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0)"><i class="ti-file"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> Super Visa Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="family-visa-list.php"> <i class="ti-angle-double-right"></i> Super Visa Form List</a></li>
                            <?php
                            if($add_pr_pg6 == 1)
                            {
                            ?>
                            <li><a href="family-visa-form.php"> <i class="ti-angle-double-right"></i> Add Super Visa Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>

                <?php
                if($view_pr_pg7 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0);"><i class="ti-announcement"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> IELTS Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="ielts-exam-list.php"> <i class="ti-angle-double-right"></i> IELTS Form List</a></li>
                            <?php
                            if($add_pr_pg7 == 1)
                            {
                            ?>
                            <li><a href="ielts-exam-add.php"> <i class="ti-angle-double-right"></i> Add IELTS Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>
                
                <?php
                if($view_pr_pg8 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0);"><i class="ti-blackboard"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title"> PTE Form</h3>
                        <ul class="sidebar-menu">
                            <li><a href="pte-exam-list.php"> <i class="ti-angle-double-right"></i> PTE Form List</a></li>
                            <?php
                            if($add_pr_pg8 == 1)
                            {
                            ?>
                            <li><a href="pte-exam-add.php"> <i class="ti-angle-double-right"></i> Add PTE Form</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>
                <!-- /.Apps -->
                <!-- .Inbox -->
<!--li class=""><a href="javascript:void(0)"><i class="ti-email"></i></a>
    <div class="sidebarmenu">
        <!-- Left navbar-header -->
        <!--h3 class="menu-title">Inbox</h3>
        <ul class="sidebar-menu">
            <li><a href="app-email.php">Mailbox</a></li>
            <li><a href="app-email-detail.php">Mailbox Detail</a></li>
            <li><a href="app-compose.php">Compose Mail</a></li>
        </ul>
        <!-- Left navbar-header end -->
    <!--/div>
</li-->
                <!-- /.Inbox -->
                <!-- .Ui Elemtns -->
                <?php
                if($view_pr_pg9 == 1)
                {
                ?>
                <li><a href="javascript:void(0)"><i class="ti-user"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Staff's</h3>
                        <ul class="sidebar-menu">
                            <li><a href="user-list.php"> <i class="ti-angle-double-right"></i> User List</a></li>
                            <?php
                            if($add_pr_pg9 == 1)
                            {
                            ?>
                            <li><a href="add-user.php"><i class="ti-angle-double-right"></i> Add New User</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>
                <!-- /.Ui Elemtns -->
                <!-- .Forms -->
                <!--li class=""><a href="javascript:void(0)"><i class="ti-comment"></i></a>
                    <div class="sidebarmenu">
                        <h3 class="menu-title">Form Feedback </h3>
                        <ul class="sidebar-menu">
                            <li><a href="feedback-form.php">Form Feedback List</a></li>
                            <li> <a href="#">Comments</a> </li> 

                        </ul>
                    </div>
                </li-->
                <!-- /.Forms -->
                <!-- .Tables -->
                <?php
                if($view_pr_pg10 == 1)
                {
                ?>
                <li class=""><a href="javascript:void(0);"><i class="ti-agenda"></i></a>
                    <div class="sidebarmenu">
                        <!-- Left navbar-header -->
                        <h3 class="menu-title">Contact List</h3>
                        <ul class="sidebar-menu">
                            <!-- <li><a href="pages-profile.php">Profile</a></li> -->
                            <!-- <li><a href="feedback-form.php"><i class="ti-angle-double-right"></i> Add Form Feedback</a></li> -->
                            <li><a href="pages-contact.php"> <i class="ti-angle-double-right"></i> Contact Us</a></li>

                        </ul>
                        <!-- Left navbar-header end -->
                    </div>
                </li>
                <?php
                }
                ?>
                <!-- /.Tables -->
               
                
                <!-- <li class="">
                    <a href="javascript:void(0)"><i class="ti-wallet"></i></a>
                    <div class="sidebarmenu">
                    
                        <h3 class="menu-title">Payment</h3>
                        <ul class="sidebar-menu">
                            <li><a href="payment-list.php"> <i class="ti-angle-double-right"></i> Payment List</a></li>
                        </ul>
                        
                    </div>
                </li> -->
                <!-- /.Widgets -->
                
                 <!-- .Widgets -->
                <li class=""><a href="" class="logout_btn"><i class="ti-power-off"></i></a>
                    <!--div class="sidebarmenu"-->
                        <!-- Left navbar-header -->
                        <!--h3 class="menu-title"><a href="#"> Logout</a></h3-->
                        <!-- Left navbar-header end -->
                    <!--/div-->
                </li>
                <!-- /.Widgets11 -->

            </ul>
        </div>