    <?php 
        include ('connection.php'); 
        
        $page_id = 9;
        $logged_user_actype = 0;  
        $edit_permission = $delete_permission = 0;
        
        if(getSession('log_userid') > 0)
        {
            $logged_user_actype = getSession('log_usertype');
            
            $get_permissions_sql = "SELECT `pr_view`, `pr_edit`, `pr_delete` FROM `user_permission_tb` WHERE `form_page` = $page_id;";
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
            else
            {
                header("location: index.php");
            }

            $logged_username = getSession('log_username');
        }
        else
        {
            header("location: pages-login.php");
        }
    ?>
    
    <?php
    include ('inc/header.php'); 
    include('inc/alert_msg.php');
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
                        <h4 class="text-white">User list</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Contact User list</li>
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
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Contact User list</h4>
                                <h6 class="card-subtitle"></h6>
                                <button type="button" class="btn btn-info btn-rounded m-t-10 float-right hide" data-toggle="modal" data-target="#add-contact">Add New User</button>
                                <!-- Add Contact Popup Model -->        
                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Type name"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Email"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Phone"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Designation"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Age"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Date of joining"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" placeholder="Salary"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                                                <input type="file" class="upload"> </div>
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="table-responsive">
                                    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Branch</th>
                                                <th>Designation</th>
                                                <th>Account Type</th>
                                                <?php
                                                if($edit_permission == 1 || $delete_permission == 1)
                                                {
                                                ?>
                                                <th>Action</th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php

                                                $userlist_sql = "SELECT u.*,b.`branch_name` as branch, des.`name` as designation, acc.`name` as account_type from users u 
                                                                 JOIN branch b ON 
                                                                 u.branch_name = b.id
                                                                 JOIN designation des ON 
                                                                 u.designation = des.id
                                                                 JOIN account_type acc ON 
                                                                 u.account_type = acc.id";
                                                $userlist_query = $conn->query($userlist_sql);

                                                if($userlist_query->num_rows > 0){
                                                    
                                                    while($userlist_result= $userlist_query-> fetch_assoc()){
                                             ?>
                                            <tr role="row" id="row<?php echo $userlist_result['user_id']; ?>">
                                                <td> <?php echo $userlist_result['user_id']; ?> </td>
                                                <td>
                                                    <a  href="edit-user.php?u=<?php echo $userlist_result['user_id']; ?>"><img src="<?php echo $userlist_result['user_pimage']; ?>" alt="user" width="50" class="img-circle" /> 
                                                        <?php echo $userlist_result['username']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $userlist_result['email']; ?></td>
                                                <td><?php echo $userlist_result['phone']; ?></td>
                                                <td><span class="label label-info"><?php echo $userlist_result['branch']; ?></span> </td>
                                                <td><span class="label label-success"><?php echo $userlist_result['designation']; ?></span></td>
                                                <td><span class="label label-inverse"><?php echo $userlist_result['account_type']; ?></span></td>
                                                <?php
                                                if($edit_permission == 1 || $delete_permission == 1)
                                                {
                                                ?>
                                                <td>
                                                    <?php
                                                    if($delete_permission == 1)
                                                    {
                                                    ?>
                                                    <a href="#" class="btn btn-danger btn-sm delete_user_btn" data-id="<?php echo $userlist_result['user_id']; ?>"> <i class="fa fa-trash"></i> Delete</a> 
                                                    <?php
                                                    }
                                                    if($edit_permission == 1)
                                                    {
                                                        if($userlist_result['action'] == 0)
                                                        {
                                                    ?>
                                                    <a href="#" class="btn btn-success btn-sm activeuser_btn" id="activate-user<?php echo $userlist_result['user_id']; ?>" data-id="<?php echo $userlist_result['user_id']; ?>"> <i class="fa fa-check"></i> Activate</a>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                        <a href="#" class="btn btn-dark btn-sm deactiveuser_btn" id="deactive-user<?php echo $userlist_result['user_id']; ?>" data-id="<?php echo $userlist_result['user_id']; ?>"> <i class="fa fa-close"></i> Deactivate</a>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                }
                                                ?>
                                            </tr>

                                            <?php 
                                                }
                                                    }else{
                                                    echo "0 result avilable";
                                                }
                                            ?>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        
                        <div class="rpanel-title">Task</div>
                        <div class="r-panel-body">
                            <div class="header-part">
                                <div class="btn-group">
                                    <button aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle daydrop" type="button"> This week <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="#">Todays</a></li>
                                        <li><a href="#">Monthly</a></li>
                                        <li><a href="#">Yearly</a></li>
                                    </ul>
                                </div>
                                <div class="pull-right">
                                    <a href="javascript:void(0)" class="text-inverse m-r-5" data-toggle="tooltip" title="Delete"><i class="ti-trash"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Add New" data-placement="left" class="text-inverse"><i class="ti-plus"></i></a>
                                </div>
                            </div>
                            <ul class="list-task list-group">
                                <li class="list-group-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck10">
                                        <label class="custom-control-label" for="customCheck10">Schedule Meeting</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck20">
                                        <label class="custom-control-label" for="customCheck20">Give Purchase Report</label>
                                    </div>
                                </li>
                                <li class="list-group-item" data-role="task">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck30">
                                        <label class="custom-control-label" for="customCheck30">Book Flight</label>
                                    </div>
                                </li>
                                <li class="list-group-item" data-role="task">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck40">
                                        <label class="custom-control-label" for="customCheck40">Forward Tasks</label>
                                    </div>
                                </li>
                                <li class="list-group-item" data-role="task">
                                    <div class="checkbox checkbox-success">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck50">
                                            <label class="custom-control-label" for="customCheck50">Receive Shipment</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item" data-role="task">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck60">
                                        <label class="custom-control-label" for="customCheck60">Important Tasks</label>
                                    </div>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center">
                                <a class="text-muted text-center" href="javascript:void(0)">View all notes</a>
                            </div>
                        </div>
                        <div class="rpanel-title">Notifications <span class="label label-rouded label-megna pull-right">3</span></div>
                        <div class="r-panel-body">
                            <div class="message-box">
                                <div class="message-widget">
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has been.</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span>
                                        </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5> <span class="mail-desc">Simply dummy text of the printing and typesetting industry.</span> <span class="time">9:08 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="rpanel-title">Chat <span class="label label-rouded label-megna pull-right">5</span></div>
                        <div class="r-panel-body">
                            <ul class="m-t-20 chatonline">
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
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
        
        <?php include ('inc/footer.php');?>
        <!-- Footable -->
       <!--  <script src="assets/node_modules/moment/moment.js"></script>
        <script src="assets/node_modules/footable/js/footable.min.js"></script>
        <!--FooTable init-->
        <!-- <script src="dist/js/pages/footable-init.js"></script> -->
        <!-- Sweet-Alert  -->
    <script src="assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script src="assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>
    