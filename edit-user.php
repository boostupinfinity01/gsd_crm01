        <?php 
            include ('connection.php');
            
            $logged_user_actype = 0;
            
            if(getSession('log_userid') > 0)
            {
                $page_id = 9;
                $logged_user_actype = getSession('log_usertype');
                    
                $get_permissions_sql = "SELECT `pr_edit` FROM `user_permission_tb` WHERE `form_page` = $page_id;";
                $get_permissions_query = $conn->query($get_permissions_sql);
                $get_permissions_result = $get_permissions_query->fetch_assoc();

                $edit_array = explode(",", $get_permissions_result['pr_edit']);

                if(!(in_array($logged_user_actype, $edit_array)))
                {
                    header("location: index.php");
                }
            }   
            else
            {
                header("location: pages-login.php");
            } 
        ?>
        
        <?php
        include ('inc/header.php');
        include('inc/alert_msg.php');
        $usr_id = $_GET['u'];;
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
                        <h4 class="text-white"> Edit User</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"> Edit User Detail</li>
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

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <h3 class="box-title m-b-0">Edit User info</h3>
                            <p class="text-muted m-b-30 font-13"> Edit User </p>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">

                                    <?php 
                                    
                                        $user_visa_sql = "SELECT * from users WHERE user_id=".$usr_id;
                                        $user_visa_query = $conn->query($user_visa_sql);
                                        
                                        if($user_visa_query->num_rows > 0){

                                            $user_visa_result = $user_visa_query-> fetch_assoc(); 

                                            $date = date ($user_visa_result['joining_date']);
                                           

                                    ?>
                                    <form method="post" id="edit_user_account" data-id="<?php echo $user_visa_result['user_id']; ?>">
                                        
                                        <div class="form-group">
                                            <label for="exampleInputuser1">User Name</label>
                                            <input type="text" class="form-control" id="exampleInputuser1" placeholder="Enter username" name="user_name" value="<?php echo $user_visa_result['username'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="user_email" value="<?php echo $user_visa_result['email'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFullName">Full Name</label>
                                            <input type="text" class="form-control" id="exampleInputFullName" placeholder="Enter Full Name" name="full_name" value="<?php echo $user_visa_result['full_name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPhone">Phone</label>
                                            <input type="text" class="form-control" id="exampleInputPhone" placeholder="Enter phone" name="user_phone" value="<?php echo $user_visa_result['phone'] ?>">
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="mdate">Joining date</label>
                                            <input type="text" class="form-control" placeholder="<?php echo $user_visa_result['joining_date']; ?>" id="mdate" name="join_date" value="<?php date_format( $date, 'Y m d hh:ss');?>">
                                        </div>    

                                        

                                        <div class="form-group">
                                            <?php $user_branch_name = $user_visa_result['branch_name']; ?>
                                            <label>Branch Name (office)</label>
                                            <select class="custom-select col-12" id="inlineFormCustomSelect" name="branch_name">
                                                <option selected>Choose...</option>
                                                
                                                <?php 
                                                
                                                    $userlist_sql = "select * from branch";
                                                    $userlist_query = $conn->query($userlist_sql);

                                                    if($userlist_query->num_rows > 0){ 
                                                        while($userlist_result = $userlist_query-> fetch_assoc()){ 
                                                ?>
                                                 <option value="<?php echo $userlist_result['id'];?>" <?php if($user_branch_name == $userlist_result['id']){echo 'selected=""';} ?>> <?php echo $userlist_result['branch_name']; ?></option>  
                                                <?php 
                                                        }
                                                    }else{
                                                     echo "No recode avilable";   
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- <div class="form-group">
                                            <?php $user_position = $user_visa_result['designation'];  ?>
                                            <label>Designation (Role)</label>
                                            <select class="custom-select col-12" id="inlineFormCustomSelect" name="designation">
                                                <option selected>Choose...</option>
                                                <?php 
                                                    $userlist_sql2 = "select * from designation";
                                                    $userlist_query2 = $conn->query($userlist_sql2);

                                                    if($userlist_query2->num_rows > 0){ 
                                                        while($userlist_result2 = $userlist_query2-> fetch_assoc()){ 
                                                ?>
                                                 <option value="<?php echo $userlist_result2['id']; ?>" <?php if($user_position == $userlist_result2['id']){echo 'selected=""';} ?>> <?php echo $userlist_result2['name']; ?></option>  
                                                <?php 
                                                        }
                                                    }else{
                                                     echo "No recode avilable";   
                                                    }
                                                ?>
                                            </select>
                                        </div> -->
                                        
                                        <div class="form-group">
                                        <?php $user_acctype = $user_visa_result['account_type']; ?>
                                            <label for="exampleInputRole">Account Type</label>
                                            <select class="form-control" id="exampleInputRole" name="account_type">
                                                <option> --- Select User Permission ---</option>
                                                 <?php 
                                                    $userlist_sql3 = "select * from account_type";
                                                    $userlist_query3 = $conn->query($userlist_sql3);

                                                    if($userlist_query3->num_rows > 0){ 
                                                        while($userlist_result3 = $userlist_query3-> fetch_assoc()){ 
                                                ?>

                                                <option value="<?php echo $userlist_result3['id']; ?>" <?php if($user_acctype == $userlist_result3['id']){echo 'selected=""';} ?> ><?php echo $userlist_result3['name']; ?></option>

                                                <?php 
                                                    }
                                                        }else{
                                                            echo "No recode avilable";   
                                                    }
                                                ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Profile File Upload</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="user_img">
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                    <div class="col-md-12 hidden" id="msgbox"></div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="img-prev user-img-thumb m-t-10" style="max-width: 150px;max-height: 150px;overflow: hidden ;"> <img src="<?php echo $user_visa_result['user_pimage']; ?>" class="img-thumbnail" style="height:100%;"/></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label> Action</label>
                                            <div class="row">
                                                   <div class="col-md-9">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" 
                                                               id="customRadio1" 
                                                               name="account_action" 
                                                               class="custom-control-input" 
                                                               value="1" <?php if($user_visa_result['action']== '1'){echo 'checked=""';} ?>>
                                                        <label class="custom-control-label" for="customRadio1">Activate</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                       
                                                        <input type="radio" 
                                                               id="customRadio2" 
                                                               name="account_action" 
                                                               class="custom-control-input" 
                                                               value="0" <?php if($user_visa_result['action']== '0'){echo 'checked=""';} ?>>
                                                        <label class="custom-control-label" for="customRadio2">Deactivate</label>
                                                    </div>        
                                                </div>    
                                            </div>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label class="custom-control custom-checkbox m-b-0">
                                                <input type="checkbox" class="custom-control-input" name="remember_check">
                                                <span class="custom-control-label">Remember me</span>
                                            </label>
                                        </div> -->

                                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" id="edit_user" name="edit_user_btn">Submit</button>
                                        <button type="reset" class="btn btn-dark waves-effect waves-light">Cancel</button>
                                    </form>

                                    <?php 
                                        }
                                            else
                                            {
                                            echo "0 result found";
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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
        <?php include ('inc/footer.php'); ?>
    
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->

    
    <!-- Plugin JavaScript -->
    <script src="assets/node_modules/moment/moment.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Date Picker Plugin JavaScript -->
    <script src="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
        // MAterial Date picker    
        $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
        $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

        $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });
    </script>
</body>

</html> 