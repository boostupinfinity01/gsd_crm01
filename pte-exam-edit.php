        <?php  
            include ('connection.php');

                $page_id = 2;
                $logged_user_id = "";
                $logged_user_actype = 0;
                $logged_username = "";
                $add_permission = $view_permission = $edit_permission = $delete_permission = 0;
                
                if(getSession('log_userid') > 0)
                {
                    $logged_user_id  = getSession('log_userid');
                    $logged_user_actype = getSession('log_usertype');
                    $get_permissions_sql = "SELECT * FROM `user_permission_tb` WHERE `form_page` = $page_id;";
                    $get_permissions_query = $conn->query($get_permissions_sql);
                    $get_permissions_result = $get_permissions_query->fetch_assoc();

                    $add_array = explode(",", $get_permissions_result['pr_add']);
                    $view_array = explode(",", $get_permissions_result['pr_view']);
                    $edit_array = explode(",", $get_permissions_result['pr_edit']);
                    $delete_array = explode(",", $get_permissions_result['pr_delete']);

                    if (in_array($logged_user_actype, $view_array))
                    {
                        $view_permission = 1;
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
                        <h4 class="text-white">PTE Visa Form Edit</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Edit PTE visa form</li>
                        </ol>
                    </div>
                    <div class="col-md-6 text-right hide">
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit PTE Visa Form</h4>
                                <h6 class="card-subtitle">Fill all required fields </h6>
                                <?php 
                                    $pte_id = $_GET['pte_id'];
                                     $pte_sql = "SELECT * from pte_exam WHERE pte_id=".$pte_id;
                                        $pte_query = $conn->query($pte_sql);
                                        
                                        if($pte_query->num_rows > 0){

                                            $pte_result = $pte_query-> fetch_assoc();
                                            
                                ?>

                                <form class="m-t-40" novalidate="" id="edit_pte_form" data-id="<?php echo $pte_result['pte_id'];?>">
                                    <div class="form-group">
                                    
                                        <?php $assignTO = $pte_result['assign_to']; ?>
                                        <h5>Counselor Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                        <?php 
                                                $pte_assign_sql = "select user_id,username from users where user_id=".$assignTO;
                                                $pte_assign_query = $conn->query($pte_assign_sql);
                                                if($pte_assign_query->num_rows > 0){
                                                   
                                                   $pte_assign_result = $pte_assign_query-> fetch_assoc();
                                            ?>
                                            <input type="text" name="counselor_name" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false"
                                              value="<?php  echo $pte_assign_result['username'];?>" disabled="disabled"> 
                                            <div class="help-block"></div>
                                            <?php }else{ echo "0 Result Found";} ?>
                                        </div>
                                            <!-- <div class="form-control-feedback"><small>Add <code>required</code> attribute to field for required validation.</small></div> -->
                                    </div>
                                    
                                        <!--div class="form-group">
                                            <h5>No. of Applicant <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="no_applicant" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false"> 
                                                <div class="help-block"></div>
                                            </div>
                                                <div class="form-control-feedback"><small>Add <code>required</code> attribute to field for required validation.</small></div>
                                        </div-->

                                        <!-- <div class="form-group">
                                            <h5>Email Address <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="email" name="email" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <h5>File Input Field <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="file" name="file" class="form-control" required=""> <div class="help-block"></div>
                                            </div>
                                        </div> -->
                                    
                                    <div class="form-group">
                                        <h5>Name of Main Applicant <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="main_applicant_name" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $pte_result['applicant_name'];?>"/>
                                        <div class="help-block"></div></div>
                                    </div>

                                    
                                        <div class="form-group">
                                            <h5>Contact Number 1 <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="cnt1" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10" 
                                                value="<?php echo $pte_result['contact_number_1'];?>">
                                            <div class="help-block"></div></div>
                                            <div class="form-control-feedback"><small>Only Allow <code>maxlength='10'</code> Digit Contact maximum number. </small></div>
                                        </div>
                                    
                                    
                                        <div class="form-group">
                                            <h5>Contact Number 2 <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="cnt2" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10" value="<?php echo $pte_result['contact_number_2'];?>">
                                            <div class="help-block"></div></div>
                                            <div class="form-control-feedback"><small>Only Allow <code>maxlength='10'</code> Digit Contact maximum number. </small></div>
                                        </div>
                                    
                                    <?php 
                                            $pte_why_join = $pte_result['apply_for_training'];; 
                                        ?>
                                    <div class="form-group row p-t-20 p-b-10">
                                        <div class="col-sm-12 p-b-5"> 
                                            <h5>Select why join us? <span class="text-danger">*</span></h5>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1"  value="1" <?php if($pte_why_join == 1){echo "checked='checked'";}?>/>
                                                <label class="custom-control-label" for="customCheck1">Only PTE Coaching</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 p-t-5">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2" value="1" <?php if($pte_why_join == 1){echo "checked='checked'";}?>/>
                                                <label class="custom-control-label" for="customCheck2">Apply for PTE Examination</label>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="form-group">
                                            <h5>Last PTE Admission Date <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" id="mdate" placeholder="Last PTE Admission Date" name="last_admission_date" value="<?php echo $pte_result['admission_date'];?>">
                                        </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Email Address <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="email_addrs" class="form-control" required="" data-validation-required-message="This field is required" 
                                                    value="<?php echo $pte_result['email_address'];?>">
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Residence Address Info <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="full_addrs" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9" ><?php echo $pte_result['full_address'];?></textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Academy Name (Previous Academy Name )<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                <input type="text" name="academy_name" class="form-control" required="" data-validation-required-message="This field is required"  value="<?php echo $pte_result['academy_name'];?>"/>    
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Exam Detail (Your last exam date)<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                <input type="text" name="last_exam_det" class="form-control" id="last_exam" required="" data-validation-required-message="This field is required" value="<?php echo $pte_result['exam_date'];?>"/>    
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Total Band (Your last PTE Score)<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                <input type="text" name="last_ielts_score" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $pte_result['total_band'];?>"/>    
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Amount Received <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="amnt_recv" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $pte_result['amount_received'];?>">
                                                <div class="help-block"></div></div>
                                                <div class="form-control-feedback"><small>Only Allow <code>maxlength='10'</code> Digit Contact maximum number. </small></div>
                                            </div>

                                            <div class="form-group">
                                                <h5>Amount Pending <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="amnt_pend" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $pte_result['amount_pending'];?>">
                                                <div class="help-block"></div></div>
                                                <div class="form-control-feedback"><small>Only Allow <code>maxlength='10'</code> Digit Contact maximum number. </small></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Total Band<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                <input type="text" name="last_ielts_score" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $pte_result['total_band'];?>"/>    
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Message<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                <textarea name="staff_reply" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9" ><?php echo $pte_result['message'];?></textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                       
                                    </div>

                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info edit_pte_btn" id="pte_edit_btn">Submit</button>
                                        <button type="reset" class="btn btn-dark cncl_pte_btn" id="pte_cncl_btn">Cancel</button>
                                    </div>
                                </form>
                                <?php 
                                    }else{
                                        echo "0 result found";
                                    } 
                               ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
               
               
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
        <?php  include ('inc/footer.php'); ?>

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
        $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false, });
        $('#last_exam').bootstrapMaterialDatePicker({ weekStart: 0, time: false, });
        
        $('#mdate1').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
        $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

        $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });
    </script>
</body>

</html>