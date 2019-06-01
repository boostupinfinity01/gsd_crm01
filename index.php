<?php 
    include('connection.php');
    date_default_timezone_set("Asia/Kolkata");
    
    $logged_user_id = "";
    $logged_user_actype = 0;
    $logged_username = "";
    if(getSession('log_userid') > 0)
    {
        $logged_user_id  = getSession('log_userid');
        $logged_user_actype = getSession('log_usertype');
        
        $get_permissions_sql = "SELECT `pr_view`, `pr_edit`, `pr_delete` FROM `user_permission_tb` WHERE `form_page` = 1;";
        $get_permissions_query = $conn->query($get_permissions_sql);
        $get_permissions_result = $get_permissions_query->fetch_assoc();

        $view_array = explode(",", $get_permissions_result['pr_view']);
        if (in_array($logged_user_actype, $view_array))
        {
            $edit_array = explode(",", $get_permissions_result['pr_edit']);
            $delete_array = explode(",", $get_permissions_result['pr_delete']);
            if (in_array($logged_user_actype, $edit_array))
            {
                $edit_permission = 1;
            }
            if (in_array($logged_user_actype, $delete_array))
            {
                $delete_permission = 1;
            }
        }

        $logged_username = getSession('log_username');
    }
    else
    {
        header("location: pages-login.php");
    }
    
    $today_date = date("Y-m-d")." 00-00-00";
    if($logged_user_actype == 1)
    {
        $stat_sql = "SELECT q1.total_receptions, q2.pending_receptions, q3.today_receptions, q4.total_users FROM
                    (SELECT COUNT(`id`) AS total_receptions FROM `reception_form` WHERE `action`=1) AS q1,
                    (SELECT COUNT(`id`) AS pending_receptions FROM `reception_form` WHERE `view`=0 AND `action`=1) AS q2,
                    (SELECT COUNT(`id`) AS today_receptions FROM `reception_form` WHERE `date`>='$today_date' AND `action`=1) AS q3,
                    (SELECT COUNT(`user_id`) AS total_users FROM `users` WHERE `action`=1) AS q4;";
    }
    else if($logged_user_actype == 2)
    {
        $stat_sql = "SELECT q1.total_receptions, q2.pending_receptions, q3.today_receptions, q4.total_users FROM
                    (SELECT COUNT(`id`) AS total_receptions FROM `reception_form`
                    WHERE`created_by` IN(SELECT `user_id` FROM `users` WHERE `branch_name` IN 
                    (SELECT `branch_name` FROM `users` WHERE `user_id`=$logged_user_id AND `action`=1)) AND `action`=1) as q1,
                    (SELECT COUNT(`id`) AS pending_receptions FROM `reception_form`
                    WHERE`created_by` IN(SELECT `user_id` FROM `users` WHERE `branch_name` IN 
                    (SELECT `branch_name` FROM `users` WHERE `user_id`=$logged_user_id AND `action`=1)) AND `action`=1 AND `view`=0) as q2,
                    (SELECT COUNT(`id`) AS today_receptions FROM `reception_form`
                    WHERE`created_by` IN(SELECT `user_id` FROM `users` WHERE `branch_name` IN 
                    (SELECT `branch_name` FROM `users` WHERE `user_id`=$logged_user_id AND `action`=1)) AND `date`>='$today_date' AND `action`=1) as q3,
                    (SELECT COUNT(`user_id`) AS total_users FROM `users`
                    WHERE`branch_name` IN(SELECT `branch_name` FROM `users` WHERE `user_id`=$logged_user_id AND `action`=1) AND `action`=1) as q4;";
    }
    else if($logged_user_actype == 3)
    {
        $stat_sql = "SELECT q1.total_receptions, q2.pending_receptions, q3.today_receptions FROM 
                    (SELECT COUNT(`id`) AS total_receptions FROM `reception_form` WHERE`created_by`=$logged_user_id AND `action`=1) as q1,
                    (SELECT COUNT(`id`) AS pending_receptions FROM `reception_form` WHERE`created_by`=$logged_user_id AND `view`=0 AND `action`=1) as q2,
                    (SELECT COUNT(`id`) AS today_receptions FROM `reception_form` WHERE`created_by`=$logged_user_id AND `date`>='$today_date' AND `action`=1) as q3;";
    }
    else if($logged_user_actype == 4)
    {
        $stat_sql = "SELECT q1.total_assigned_forms, q2.today_assigned_forms, q3.pending_assigned_forms FROM
                    (SELECT COUNT(`id`) AS total_assigned_forms FROM `reception_form` WHERE`assign_to`=$logged_user_id AND `action`=1) as q1,
                    (SELECT COUNT(`id`) AS today_assigned_forms FROM `reception_form` WHERE`assign_to`=$logged_user_id AND `date`>='$today_date' AND `action`=1) as q2,
                    (SELECT COUNT(`id`) AS pending_assigned_forms FROM `reception_form` WHERE`assign_to`=$logged_user_id AND `view`=0 AND `action`=1) as q3;";
    }
    
    $stat_query = $conn->query($stat_sql);


 ?>


 <?php
 include('inc/header.php');
 ?>
        
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-12">
                        <h4 class="text-white">Macro Global Dashboard</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">CRM Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-6 text-right">
                        <form class="app-search d-none d-md-block d-lg-block">
                            <input type="text" class="form-control" placeholder="Search &amp; enter">
                        </form>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                
                <?php
                if($stat_query->num_rows > 0)
                {
                    $stat_result = $stat_query->fetch_assoc();
                ?>
                <div class="row">
                    <?php
                    if($logged_user_actype == 1)
                    {
                        $total_receptions = $stat_result['total_receptions'];
                        $pending_receptions = $stat_result['pending_receptions'];
                        $today_receptions = $stat_result['today_receptions'];
                        $total_users = $stat_result['total_users'];
                    ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-success"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $total_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash4"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-danger"><i class="ti-arrow-down"></i> <span class="counter"><?php echo $pending_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Today Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash3"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-info"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $today_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash2"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-purple"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $total_users;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <?php
                    }
                    else if($logged_user_actype == 2)
                    {
                        $total_receptions = $stat_result['total_receptions'];
                        $pending_receptions = $stat_result['pending_receptions'];
                        $today_receptions = $stat_result['today_receptions'];
                        $total_users = $stat_result['total_users'];
                    ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-success"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $total_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash4"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-danger"><i class="ti-arrow-down"></i> <span class="counter"><?php echo $pending_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Today Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash3"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-info"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $today_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash2"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-purple"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $total_users;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <?php
                    }
                    else if($logged_user_actype == 3)
                    {
                        $total_receptions = $stat_result['total_receptions'];
                        $pending_receptions = $stat_result['pending_receptions'];
                        $today_receptions = $stat_result['today_receptions'];
                    ?>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-success"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $total_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash4"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-danger"><i class="ti-arrow-down"></i> <span class="counter"><?php echo $pending_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Today Reception Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash3"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-info"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $today_receptions;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <?php
                    }
                    else if($logged_user_actype == 4)
                    {
                        $total_assigned_forms = $stat_result['total_assigned_forms'];
                        $pending_assigned_forms = $stat_result['pending_assigned_forms'];
                        $today_assigned_forms = $stat_result['today_assigned_forms'];
                    ?>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Assigned Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-success"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $total_assigned_forms;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Assigned Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash4"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-danger"><i class="ti-arrow-down"></i> <span class="counter"><?php echo $pending_assigned_forms;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Today Assigned Forms</h5>
                                <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                    <div id="sparklinedash3"></div>
                                    <div class="ml-auto">
                                        <h2 class="text-info"><i class="ti-arrow-up"></i> <span class="counter"><?php echo $today_assigned_forms;?></span></h2>
                                    </div>
                                </div>
                            </div>
                            <div id="sparkline8" class="sparkchart"></div>
                        </div>
                    </div>
                    <!-- Column -->
                    <?php
                    }
                    ?>
                </div>
                <?php
                }
                else
                {
                ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Some error occurred</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <!-- ============================================================== -->
                <!-- End Info box -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Sales Chart and browser state-->
                <!-- ============================================================== -->
                <div class="row" style="display: none;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-0">WEATHER</h5>
                                        </div>
                                        <div class="card-body bg-light">
                                            <div class="d-flex no-block align-items-center">
                                                <span><h2 class="">Monday</h2><small>7th May 2017</small></span>
                                                <div class="ml-auto">
                                                    <canvas class="sleet" width="44" height="44"></canvas> <span class="display-6">32<sup>°F</sup></span> </div>
                                            </div>
                                        </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-4 col-4 text-center">
                                                        <h5>Tue</h5>
                                                        <div class="m-t-10 m-b-10">
                                                            <canvas class="sleet" width="30" height="30"></canvas>
                                                        </div>
                                                        <h5>32<sup>°F</sup></h5>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 col-4 text-center">
                                                        <h5>Wed</h5>
                                                        <div class="m-t-10 m-b-10">
                                                            <canvas class="clear-day" width="30" height="30"></canvas>
                                                        </div>
                                                        <h5>34<sup>°F</sup></h5>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 col-4 text-center">
                                                        <h5>Thu</h5>
                                                        <div class="m-t-10 m-b-10">
                                                            <canvas class="partly-cloudy-day" width="30" height="30"></canvas>
                                                        </div>
                                                        <h5>31<sup>°F</sup></h5>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 col-4 text-center">
                                                        <h5>Fri</h5>
                                                        <div class="m-t-10 m-b-10">
                                                            <canvas class="cloudy" width="30" height="30"></canvas>
                                                        </div>
                                                        <h5>32<sup>°F</sup></h5>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 col-4 text-center">
                                                        <h5>Sat</h5>
                                                        <div class="m-t-10 m-b-10">
                                                            <canvas class="snow" width="30" height="30"></canvas>
                                                        </div>
                                                        <h5>12<sup>°F</sup></h5>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 col-4 text-center">
                                                        <h5>Sun</h5>
                                                        <div class="m-t-10 m-b-10">
                                                            <canvas class="wind" width="30" height="30"></canvas>
                                                        </div>
                                                        <h5>32<sup>°F</sup></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <h5 class="card-title m-b-40">TOTAL EARNING IN 2018</h5>

                                        <div id="morris-area-chart" style="height:250px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Sales Chart -->
                <!-- ============================================================== -->
                
                
                <?php
                if($logged_user_actype == 1)
                {
                ?>
                <!-- ============================================================== -->
                <!-- Review -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Latest Forms</h5>
                            </div>
                            <?php
                            $recent_form_sql = "SELECT r . * , u.`username` as assign_to_user, u1.`username` as created_by_user
                                                        FROM reception_form r
                                                        JOIN users u ON u.user_id = r.assign_to
                                                        JOIN users u1 ON u1.user_id = r.created_by
                                                        WHERE r.`action` =1
                                                        ORDER BY id DESC LIMIT 10";
                            $recent_form_query = $conn->query($recent_form_sql);
                            if($recent_form_query->num_rows>0)
                            {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name </th>
                                            <th>Date </th>
                                            <th>Contact no</th>
                                            <th>Enquiry Type</th>
                                            <th>Created By</th>
                                            <th>Assigned By</th>
                                            <th class="text-center">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($recent_form_result = $recent_form_query->fetch_assoc())
                                        {
                                            $submit_date = date_create($recent_form_result['date']);
                                            $date = date_format($submit_date,"d/M/Y")
                                        ?>
                                        <tr>
                                            
                                            <td><?php echo $recent_form_result['id'];?></td>
                                            <td><?php echo $recent_form_result['name'];?></td>
                                            <td><span class="text-muted"><?php echo $date;?></span></td>
                                            <td><?php echo $recent_form_result['contact_no1'];?></td>
                                            <td><div class="label label-table label-success label-md"><?php echo str_replace("_"," ",$recent_form_result['enquiry_type']);?></div></td>
                                            <td><?php echo $recent_form_result['created_by_user'];?></td>
                                            <td><?php echo $recent_form_result['assign_to_user'];?></td>
                                            <td class="text-center">
                                            <?php
                                            if($recent_form_result['view'] == 0)
                                            {
                                                echo "<span style='color: red'>Pending</span>";
                                            }
                                            else
                                            {
                                                echo "<span style='color: green'>Viewed</span>";
                                            }
                                            ?>
                                            </td>

                                            <?php
                                                if($edit_permission == 1 || $delete_permission == 1)
                                                {
                                                ?>
                                                <td>
                                                    <?php
                                                    if($edit_permission == 1)
                                                    {
                                                    ?>
                                                    <a href="study_visa_edit.php?s_id=<?php echo $rec_result['study_id']; ?>" class="btn btn-success" id="study_edit_btn" > <i class="fa fa-edit"></i> Edit</a>
                                                    <?php
                                                    }
                                                    if($delete_permission == 1)
                                                    {
                                                    ?>
                                                    <a href="#" class="btn btn-danger" id="study_del_btn" data-id="<?php echo $rec_result['study_id']; ?>"> <i class="fa fa-trash"></i> Delete</a> 
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                }
                                                ?>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <div class="card-body" style="background-color: #242424; color: #f2f2f2;">
                                <h5 class="card-title" style="margin: 0;">No records found</h5>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- ============================================================== -->
                <!-- End Review -->
                <!-- ============================================================== -->
                <?php
                }
                ?>
                
                
                
                
                <?php
                if($logged_user_actype == 2)
                {
                ?>
                <!-- ============================================================== -->
                <!-- Review -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Latest Forms</h5>
                            </div>
                            <?php
                            $recent_form_sql = "SELECT r . * , u.`username` as assign_to_user, u1.`username` as created_by_user
                                                FROM reception_form r
                                                JOIN users u ON u.user_id = r.assign_to
                                                JOIN users u1 ON u1.user_id = r.created_by
                                                WHERE r.`action` =1 AND r.`created_by` IN 
                                                (SELECT `user_id` FROM `users` WHERE `branch_name` IN 
                                                (SELECT `branch_name` FROM `users` WHERE `user_id`=$logged_user_id AND `action`=1))
                                                
                                                ORDER BY r.id DESC LIMIT 10";
                            $recent_form_query = $conn->query($recent_form_sql);
                            if($recent_form_query->num_rows>0)
                            {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name </th>
                                            <th>Date </th>
                                            <th>Contact no</th>
                                            <th>Enquiry Type</th>
                                            <th>Created By</th>
                                            <th>Assigned By</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($recent_form_result = $recent_form_query->fetch_assoc())
                                        {
                                            $submit_date = date_create($recent_form_result['date']);
                                            $date = date_format($submit_date,"d/M/Y")
                                        ?>
                                        <tr>
                                            
                                            <td><?php echo $recent_form_result['id'];?></td>
                                            <td><?php echo $recent_form_result['name'];?></td>
                                            <td><span class="text-muted"><?php echo $date;?></span></td>
                                            <td><?php echo $recent_form_result['contact_no1'];?></td>
                                            <td><div class="label label-table label-success label-md"><?php echo str_replace("_"," ",$recent_form_result['enquiry_type']);?></div></td>
                                            <td><?php echo $recent_form_result['created_by_user'];?></td>
                                            <td><?php echo $recent_form_result['assign_to_user'];?></td>
                                            <td class="text-center">
                                            <?php
                                            if($recent_form_result['view'] == 0)
                                            {
                                                echo "<span style='color: red'>Pending</span>";
                                            }
                                            else
                                            {
                                                echo "<span style='color: green'>Viewed</span>";
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <div class="card-body" style="background-color: #242424; color: #f2f2f2;">
                                <h5 class="card-title" style="margin: 0;">No records found</h5>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- ============================================================== -->
                <!-- End Review -->
                <!-- ============================================================== -->
                <?php
                }
                ?>
                
                
                
                
                <?php
                if($logged_user_actype == 3)
                {
                ?>
                <div class="row">
                <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="margin: 0;">Your Latest Reception Forms</h5>
                            </div>
                            <?php
                            $latest_reception_form_sql = "SELECT r.*, u.`username` FROM `reception_form` r 
                                                            JOIN users u ON r.`assign_to`=u.`user_id`
                                                            WHERE r.`created_by`=$logged_user_id ORDER BY r.`id` DESC LIMIT 10;";
                            $latest_reception_form_query = $conn->query($latest_reception_form_sql);
                            if($latest_reception_form_query->num_rows>0)
                            {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Reception Form ID</th>
                                            <th>Applicant Name</th>
                                            <th>Date</th>
                                            <th class="text-center">Enquiry Type</th>
                                            <th>Contact no</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($latest_reception_form_result = $latest_reception_form_query->fetch_assoc())
                                        {
                                            $submit_date = date_create($latest_reception_form_result['date']);
                                            $date = date_format($submit_date,"d/M/Y")
                                        ?>
                                        <tr>
                                            <td><a href="javascript:void(0)" class="link"><?php echo $latest_reception_form_result['id'];?></a></td>
                                            <td><?php echo $latest_reception_form_result['name'];?></td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i><?php echo $date;?></span></td>
                                            <td class="text-center">
                                                <div class="label label-table label-success label-md"><?php echo str_replace("_"," ",$latest_reception_form_result['enquiry_type']);?></div>
                                            </td>
                                            <td><?php echo $latest_reception_form_result['contact_no1'];?></td>
                                            <td class="text-center">
                                            <?php
                                            if($latest_reception_form_result['view'] == 0)
                                            {
                                                echo "Pending";
                                            }
                                            else
                                            {
                                                echo "Viewed";
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <div class="card-body" style="background-color: #242424; color: #f2f2f2;">
                                <h5 class="card-title" style="margin: 0;">No records found</h5>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="margin: 0;">Your Pending Reception Forms</h5>
                            </div>
                            <?php
                            $pending_assign_form_sql = "SELECT r.*, u.`username` FROM `reception_form` r 
                                                        JOIN users u ON r.`assign_to`=u.`user_id`
                                                        WHERE r.`created_by`=$logged_user_id AND r.`view`=0 ORDER BY r.`id` DESC LIMIT 10;";
                            $pending_assign_form_query = $conn->query($pending_assign_form_sql);
                            if($pending_assign_form_query->num_rows>0)
                            {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Reception Form ID</th>
                                            <th>Applicant Name</th>
                                            <th>Date</th>
                                            <th class="text-center">Enquiry Type</th>
                                            <th>Contact no</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($pending_assign_form_result = $pending_assign_form_query->fetch_assoc())
                                        {
                                            $submit_date = date_create($pending_assign_form_result['date']);
                                            $date = date_format($submit_date,"d/M/Y")
                                        ?>
                                        <tr>
                                            <td><a href="javascript:void(0)" class="link"><?php echo $pending_assign_form_result['id'];?></a></td>
                                            <td><?php echo $pending_assign_form_result['name'];?></td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i><?php echo $date;?></span></td>
                                            <td class="text-center">
                                                <div class="label label-table label-success label-md"><?php echo str_replace("_"," ",$pending_assign_form_result['enquiry_type']);?></div>
                                            </td>
                                            <td><?php echo $pending_assign_form_result['contact_no1'];?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <div class="card-body" style="background-color: #242424; color: #f2f2f2;">
                                <h5 class="card-title" style="margin: 0;">No records found</h5>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <?php
                }
                ?>
                
                
                
                

                <?php
                if($logged_user_actype == 4)
                {
                ?>
                <div class="row">
                <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="margin: 0;">Latest Assigned Forms</h5>
                            </div>
                            <?php
                            $latest_assign_form_sql = "SELECT * FROM `reception_form` WHERE `assign_to`=$logged_user_id LIMIT 10;";
                            $latest_assign_form_query = $conn->query($latest_assign_form_sql);
                            if($latest_assign_form_query->num_rows>0)
                            {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Reception Form ID</th>
                                            <th>Applicant Name</th>
                                            <th>Date</th>
                                            <th class="text-center">Enquiry Type</th>
                                            <th>Contact no</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($latest_assign_form_result = $latest_assign_form_query->fetch_assoc())
                                        {
                                            $submit_date = date_create($latest_assign_form_result['date']);
                                            $date = date_format($submit_date,"d/M/Y")
                                        ?>
                                        <tr>
                                            <td><a href="javascript:void(0)" class="link"><?php echo $latest_assign_form_result['id'];?></a></td>
                                            <td><?php echo $latest_assign_form_result['name'];?></td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i><?php echo $date;?></span></td>
                                            <td class="text-center">
                                                <div class="label label-table label-success label-md"><?php echo str_replace("_"," ",$latest_assign_form_result['enquiry_type']);?></div>
                                            </td>
                                            <td><?php echo $latest_assign_form_result['contact_no1'];?></td>
                                            <td class="text-center">
                                            <?php
                                            if($latest_assign_form_result['view'] == 0)
                                            {
                                                echo "Pending";
                                            }
                                            else
                                            {
                                                echo "Viewed";
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <div class="card-body" style="background-color: #242424; color: #f2f2f2;">
                                <h5 class="card-title" style="margin: 0;">No records found</h5>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="margin: 0;">Pending Assigned Forms</h5>
                            </div>
                            <?php
                            $pending_assign_form_sql = "SELECT * FROM `reception_form` WHERE `assign_to`=$logged_user_id AND `view`=0 LIMIT 10;";
                            $pending_assign_form_query = $conn->query($pending_assign_form_sql);
                            if($pending_assign_form_query->num_rows>0)
                            {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Reception Form ID</th>
                                            <th>Applicant Name</th>
                                            <th>Date</th>
                                            <th class="text-center">Enquiry Type</th>
                                            <th>Contact no</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($pending_assign_form_result = $pending_assign_form_query->fetch_assoc())
                                        {
                                            $submit_date = date_create($pending_assign_form_result['date']);
                                            $date = date_format($submit_date,"d/M/Y")
                                        ?>
                                        <tr>
                                            <td><a href="javascript:void(0)" class="link"><?php echo $pending_assign_form_result['id'];?></a></td>
                                            <td><?php echo $pending_assign_form_result['name'];?></td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i><?php echo $date;?></span></td>
                                            <td class="text-center">
                                                <div class="label label-table label-success label-md"><?php echo str_replace("_"," ",$pending_assign_form_result['enquiry_type']);?></div>
                                            </td>
                                            <td><?php echo $pending_assign_form_result['contact_no1'];?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            }
                            else
                            {
                            ?>
                            <div class="card-body" style="background-color: #242424; color: #f2f2f2;">
                                <h5 class="card-title" style="margin: 0;">No records found</h5>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <?php
                }
                ?>
                
                
                
                <!-- ============================================================== -->
                <!-- Comment - chats -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Comment - chats -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        
                        <div class="rpanel-title">Notifications <span class="label label-rouded label-megna pull-right">3</span></div>
                        <div class="r-panel-body">
                            <div class="message-box">
                                <div class="message-widget">

                                    <a href="javascript:void(0)">
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has been.</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a>
                                    
                                    <a href="javascript:void(0)">
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span>
                                        </div>
                                    </a>
                                    
                                    <a href="javascript:void(0)">
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5> <span class="mail-desc">Simply dummy text of the printing and typesetting industry.</span> <span class="time">9:08 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        
        <?php include 'inc/footer.php'; ?>
        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <!--Sky Icons JavaScript -->
        <script src="assets/node_modules/skycons/skycons.js"></script>
        <!--morris JavaScript -->
        <script src="assets/node_modules/raphael/raphael-min.js"></script>
        <script src="assets/node_modules/morrisjs/morris.min.js"></script>
        <script src="assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
        <!-- Chart JS -->
        <script src="dist/js/dashboard4.js"></script>