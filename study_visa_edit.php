        <?php  
            include ('connection.php');
            
                $page_id = 4;
                $logged_user_actype = 0;
                $add_permission = $view_permission = $edit_permission = $delete_permission = 0;
                
                if(getSession('log_userid') > 0)
                {
                    $logged_user_actype = getSession('log_usertype');
                    $get_permissions_sql = "SELECT `pr_edit` FROM `user_permission_tb` WHERE `form_page` = $page_id;";
                    $get_permissions_query = $conn->query($get_permissions_sql);
                    $get_permissions_result = $get_permissions_query->fetch_assoc();

                    $edit_array = explode(",", $get_permissions_result['pr_edit']);

                    if (!(in_array($logged_user_actype, $edit_array)))
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
            $s_id = $_GET['s_id'];
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
                        <h4 class="text-white">Study Visa Form</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Study visa form</li>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Study Visa Form</h4>
                                <h6 class="card-subtitle">Fill all required fields </h6>

                                    <?php 
                                        
                                        $study_visa_sql = "SELECT * from study_visa WHERE study_id=$s_id;";
                                        $study_visa_query = $conn->query($study_visa_sql);
                                        
                                        if($study_visa_query->num_rows > 0){

                                            $study_visa_result = $study_visa_query-> fetch_assoc(); 
                                    ?>
                                <form class="m-t-40" novalidate="" id="edit_study_form" data-id="<?php echo $study_visa_result['study_id'];?>">
                                    <div class="form-group">
                                        <h5>Counselor Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="counselor_name" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false" value="<?php echo $study_visa_result['counselor_name'];?>"> 
                                            <div class="help-block"></div>
                                        </div>
                                            <!-- <div class="form-control-feedback"><small>Add <code>required</code> attribute to field for required validation.</small></div> -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>No. of Applicant <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="no_applicant" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false" value="<?php echo $study_visa_result['no_of_applicant'];?>"> 
                                            <div class="help-block"></div>
                                        </div>
                                            <!-- <div class="form-control-feedback"><small>Add <code>required</code> attribute to field for required validation.</small></div> -->
                                    </div>

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
                                            <input type="text" name="main_applicant_name" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10" value="<?php echo $study_visa_result['main_applicant']; ?>">
                                        <div class="help-block"></div></div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Date of Birth <span class="text-danger">*</span></h5>
                                        <input type="text" class="form-control" id="mdate" placeholder="" name="cdob" value="<?php echo $study_visa_result['date_of_birth']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <h5>Passport No. <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="passport_no" class="form-control" required="" data-validation-required-message="This field is required" maxlength="7" value="<?php echo $study_visa_result['passport_no']; ?>">
                                        <div class="help-block"></div></div>
                                    </div>


                                    <!--<div class="form-group">
                                        <h5>Event Date <span class="text-danger">*</span></h5>
                                        <input type="text" class="form-control" id="mdate1" placeholder="" name="event_date" value="<?php //echo $study_visa_result['event_date']; ?>">
                                    </div>-->
                                    
                                    <?php
                                        $selected_dest = $study_visa_result['destination']; 
                                        /*echo $selected_dest;*/
                                    ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Destination <span class="text-danger">*</span></h5>
                                                <fieldset class="controls">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="CANADA" name="styled_destin" required="" id="styled_desti1" class="custom-control-input" <?php if($selected_dest == "CANADA"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti1">CANADA </label>
                                                    </div>
                                                <div class="help-block"></div></fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="AUSTRALIA" name="styled_destin" id="styled_desti2" class="custom-control-input" <?php if($selected_dest == "AUSTRALIA"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti2">AUSTRALIA </label>
                                                    </div>
                                                </fieldset>

                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="NEWZEALAND" name="styled_destin" id="styled_desti3" class="custom-control-input" <?php if($selected_dest == "NEWZEALAND"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti3">NEW ZEALAND</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="USA" name="styled_destin" id="styled_desti4" class="custom-control-input" <?php if($selected_dest == "USA"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti4">USA </label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="DUBAI" name="styled_destin" id="styled_desti5" class="custom-control-input" <?php if($selected_dest == "DUBAI"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti5">DUBAI </label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="SINGAPORE" name="styled_destin" id="styled_desti6" class="custom-control-input" <?php if($selected_dest == "SINGAPORE"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti6">SINGAPORE </label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="MALAYSIA" name="styled_destin" id="styled_desti7" class="custom-control-input" <?php if($selected_dest == "MALAYSIA"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti7">MALAYSIA </label>
                                                    </div>
                                                </fieldset>


                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="THAILAND" name="styled_destin" id="styled_desti8" class="custom-control-input" <?php if($selected_dest == "THAILAND"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti8">THAILAND </label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="EUROPE" name="styled_destin" id="styled_desti9" class="custom-control-input" <?php if($selected_dest == "EUROPE"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti9">EUROPE </label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="SHENEGAN" name="styled_destin" id="styled_desti10" class="custom-control-input" <?php if($selected_dest == "SHENEGAN"){echo "checked=''";} ?>>
                                                        <label class="custom-control-label" for="styled_desti10">SHENEGAN ETC.</label>
                                                    </div>
                                                </fieldset> 
                                                
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Contact Number 1 <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="cnt1" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10" value="<?php echo $study_visa_result['contact_number_1']; ?>">
                                                <div class="help-block"></div></div>
                                                <div class="form-control-feedback"><small>Only Allow <code>maxlength='10'</code> Digit Contact maximum number. </small></div>
                                            </div>

                                            <div class="form-group">
                                                <h5>Contact Number 2</h5>
                                                <div class="controls">
                                                    <input type="text" name="cnt2" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10" value="<?php echo $study_visa_result['contact_number_2']; ?>">
                                                <div class="help-block"></div></div>
                                                <div class="form-control-feedback"><small>Only Allow <code>maxlength='10'</code> Digit Contact maximum number. </small></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Last Qualification <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="qualif" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['qualification']; ?>">
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">     
                                            <div class="form-group">
                                                <h5> Education Board <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="exam_board" class="form-control" required="" data-validation-required-message="This field is required"  value="<?php echo $study_visa_result['board_of_exam']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12">     
                                            <div class="form-group">
                                                <h5> Study Subjects <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="study_subj" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['study_subject']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12">     
                                            <div class="form-group">
                                                <h5> Last Passing Year <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="pass_year" class="form-control" required="" id="passing_date" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['passing_year']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12">     
                                            <div class="form-group">
                                                <h5> Passing Percent (%)<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="pass_percent" class="form-control" required="" data-validation-required-message="This field is required"value="<?php echo $study_visa_result['pass_percent']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12">     
                                            <div class="form-group">
                                                <h5> Total Study Gap<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="total_gap" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['total_study_gap']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12">     
                                            <div class="form-group">
                                                <h5> During Study Gap Any Job or Course Experience<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="gap_experience" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['gap_experience']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Amount Received <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="amnt_recv" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['amount_received']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>

                                            <div class="form-group">
                                                <h5>Amount Pending <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="amnt_pend" class="form-control" required="" data-validation-required-message="This field is required" value="<?php echo $study_visa_result['amount_pending']; ?>">
                                                <div class="help-block"></div></div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Anything We Need To Done From MGM Side <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="mgm_side" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"> <?php echo $study_visa_result['any_mgm_side']; ?> 
                                                    </textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Any Refusal <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="any_refusal" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"> <?php echo $study_visa_result['any_refusal']; ?>
                                                    </textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Any Travel History <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="travel_history" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"> <?php echo $study_visa_result['any_travel_history']; ?>
                                                    </textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Any Person Included in This File is a GOVT. Servant?<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="govt_servant" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"> <?php echo $study_visa_result['any_govt_servant']; ?>
                                                    </textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Any Remarks<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="any_remark" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"> <?php echo $study_visa_result['any_remarks']; ?>
                                                    </textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    
                                    <?php //$assigned_to = $study_visa_result['assign_to']; ?>

                                    <!--<div class="form-group">
                                        <h5> AssignTo <span>*</span> </h5>
                                        <div class="controls">
                                            
                                          <select class="form-control" name="assign_to">
                                            <option> -- Select --</option>
                                            <?php 
                                                /*$rec_sql = "select user_id,username from users where account_type = 4";
                                                $rec_query = $conn->query($rec_sql);
                                                if($rec_query->num_rows > 0){
                                                   
                                                   while($rec_result = $rec_query-> fetch_assoc()){*/
                                            ?>
                                                <option value="<?php /*echo $rec_result['user_id']; */?>" <?php /*if($assigned_to == $rec_result['user_id']){echo "selected='selected'";} */?>> <?php /*echo $rec_result['username'];*/ ?> 
                                                </option>
                                            <?php 
                                                /*}
                                                }
                                                else{
                                                     echo "No recode avilable";   
                                                    }*/ 
                                            ?>
                                        </select>  

                                        </div>
                                    </div>-->
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info edit_study_btn" id="study_edit_btn">Submit</button>
                                        <button type="reset" class="btn btn-dark cncl_study_btn" id="study_cncl_btn">Cancel</button>
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
        $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $('#mdate1').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $('#passing_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false });

        $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
        $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

        $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });
    </script>
</body>
</html>