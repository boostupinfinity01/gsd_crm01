<?php
include ('connection.php');
if(!(getSession('log_userid')>0))
{
    header("location: pages-login.php");
}

$logged_user_id  = getSession('log_userid');
$logged_user_actype = getSession('log_usertype');
$logged_username = getSession('log_username');

$user_query = "SELECT u.`full_name`, u.`email`, u.`phone`, u.`joining_date`, u.`user_pimage`, 
                b.`branch_name`, b.`address` AS branch_addr, a.`name` AS account_type FROM `users` u 
                JOIN `branch` b ON u.`branch_name`=b.`id`
                JOIN `account_type` a ON u.`account_type`=a.`id`
                WHERE u.`user_id`=$logged_user_id AND u.`username`='$logged_username' AND u.`account_type`=$logged_user_actype;";
                
                
$user_query_result = $conn->query($user_query);
if($user_query_result->num_rows>0)
{
    $user_query_data = $user_query_result->fetch_assoc();  
    
    $full_name = $user_query_data['full_name'];
    $email = $user_query_data['email'];
    $phone = $user_query_data['phone'];
    $joining_date = date_create($user_query_data['joining_date']);
    $profile_img = $user_query_data['user_pimage'];
    $branch_name = $user_query_data['branch_name'];
    $branch_addr = $user_query_data['branch_addr'];
    $acc_type = $user_query_data['account_type'];
}


?>



<?php
include ("inc/header.php");
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
                        <h4 class="text-white">Profile Details</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Profile Info</li>
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
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card"> <img class="card-img" src="assets/images/macro-global-logo.png" height="456" alt="Card image">
                            <div class="card-img-overlay card-inverse text-white social-profile d-flex justify-content-center">
                                <div class="align-self-center"> <img src="<?php echo $profile_img;?>" class="img-circle" width="100">
                                    <h4 class="card-title"><?php echo $full_name;?></h4>
                                    <h6 class="card-subtitle">@<?php echo $logged_username;?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted db">Branch Address:</h6>
                                <h6><?php echo $branch_addr;?></h6>
                                <div class="map-box">
                                  <?php 
                                    $address= "macro Global Moga, ".$branch_addr;
                                    echo '<iframe frameborder="0" src="https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . str_replace(",", "", str_replace(" ", "+", $address)) . '&z=14&output=embed" width="100%" height="180" frameborder="0" style="border:0" allowfullscreen></iframe>';  
                                  ?>  
                                </div> 
                                <!-- <small class="text-muted p-t-30 db">Social Profile</small> -->
                                <!-- <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-twitter"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-youtube"></i></button> -->
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab"> Profile Info</a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings" role="tabpanel">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material">
                                            <div class="form-group">
                                                <label class="col-md-12">Full Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line" value="<?php echo $full_name;?>" disabled="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="email" placeholder="johnathan@admin.com" value="<?php echo $email;?>" class="form-control form-control-line" name="example-email" id="example-email" disabled="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Phone No</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="123 456 7890" value="<?php echo $phone;?>" class="form-control form-control-line" value="123 456 7890" disabled="">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-12">Joining Date</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="20/05/2019" value="<?php echo date_format($joining_date,"d/M/Y");?>" class="form-control form-control-line" value="20/05/2019" disabled="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12">Branch Name (Office)</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="Ludhiana" class="form-control form-control-line" value="<?php  echo $branch_name;?>" disabled="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12">Account Type</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="Manager" class="form-control form-control-line" readonly="" value="<?php echo $acc_type;?>" disabled="">
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
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
        <?php include ("inc/footer.php") ?>
</body>

</html>