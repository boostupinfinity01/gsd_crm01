        <?php  
            include ('connection.php');

            $page_id = 1;
            $logged_user_id = "";
            $logged_user_actype = 0;
            $logged_username = "";
            
            if(getSession('log_userid') > 0)
            {
                $logged_user_id  = getSession('log_userid');
                $logged_user_actype = getSession('log_usertype');
                $logged_username = getSession('log_username');
                
                $get_permissions_sql = "SELECT `pr_add` FROM `user_permission_tb` WHERE `form_page` = $page_id;";
                $get_permissions_query = $conn->query($get_permissions_sql);
                $get_permissions_result = $get_permissions_query->fetch_assoc();

                $add_array = explode(",", $get_permissions_result['pr_add']);

                if (!(in_array($logged_user_actype, $add_array)))
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
                        <h4 class="text-white">Reception Form</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Reception Form</li>
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
                                <h4 class="card-title">Reception Form</h4>
                                <h6 class="card-subtitle">Fill all required fields </h6>
                                <form class="m-t-40" novalidate="" name="reception_form" id="form_reception">
                                    <div class="form-group">
                                        <h5>Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="name" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false"> 
                                            <div class="help-block"></div>
                                        </div>
                                            <!-- <div class="form-control-feedback"><small>Add <code>required</code> attribute to field for required validation.</small></div> -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Father Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="fathername" class="form-control" required="" data-validation-required-message="This field is required" aria-invalid="false"> 
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
                                        <h5>Contact Number 1 <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="cnt1" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10">
                                        <div class="help-block"></div></div>
                                        <div class="form-control-feedback"><small>Add <code>maxlength='10'</code> attribute for maximum number of characters to accept. </small></div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Contact Number 2</h5>
                                        <div class="controls">
                                            <input type="text" name="cnt2" class="form-control" required="" data-validation-required-message="This field is required" maxlength="10">
                                        <div class="help-block"></div></div>
                                        <div class="form-control-feedback"><small>Add <code>maxlength='10'</code> attribute for maximum number of characters to accept. </small></div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Email Address Info </h5>
                                                <div class="controls">
                                                    <input type="email" name="emaill_addrs" class="form-control" data-validation-required-message="This field is required" />
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Residence Address Info <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <textarea name="full_addrs" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"></textarea>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Enquiry Type <span class="text-danger">*</span></h5>
                                                <fieldset class="controls">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="IELTS" name="enquiry_type" required="" id="enquiry_type1" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type1">IELTS</label>
                                                    </div>
                                                <div class="help-block"></div></fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="PTE" name="enquiry_type" id="enquiry_type2" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type2">PTE</label>
                                                    </div>
                                                </fieldset>

                                               
                                                
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="STUDY_VISA" name="enquiry_type" id="enquiry_type6" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type6">STUDY VISA</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="VISITOR/TOURIST_VISA" name="enquiry_type" id="enquiry_type7" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type7">VISITOR/TOURIST VISA</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="OPEN_WORK_VISA" name="enquiry_type" id="enquiry_type8" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type8">OPEN WORK VISA FOR CANADA </span></label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="DEPENDENT_VISA" name="enquiry_type" id="enquiry_type9" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type9">DEPENDENT VISA FOR AUSTRALIA</label>
                                                    </div>
                                                </fieldset>
                                                
                                                
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="SUPER_VISA" name="enquiry_type" id="enquiry_type14" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type14">SUPER VISA</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="OTHER" name="enquiry_type" id="enquiry_type15" class="custom-control-input"> 
                                                        <label class="custom-control-label" for="enquiry_type15">OTHER</label>
                                                    </div>
                                                </fieldset>
                                                
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>How They Know About Macro Global <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="SOCIAL_NETWORK_SITES" name="how_know" required="" id="enquiry_type_inline1" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline1">Social Network Sites</label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="REFERENCE" name="how_know" id="enquiry_type_inline2" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline2">Reference </label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="NEWSPAPER" name="how_know" id="enquiry_type_inline3" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline3">News Paper </label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="TV_ADS" name="how_know" id="enquiry_type_inline4" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline4">TV Ads </label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="WALL_PAINTS_POSTERS" name="how_know" id="enquiry_type_inline5" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline5">Wall Paints/Posters  </label>
                                                        </div>
                                                    </fieldset>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5> AssignTo <span>*</span> </h5>
                                    <div class="controls">
                                        
                                      <select class="form-control" name="assign_to">
                                        <option> -- Select --</option>
                                        <?php 
                                                $rec_sql = "select user_id,username from users where account_type = 4";
                                            $rec_query = $conn->query($rec_sql);
                                            if($rec_query->num_rows > 0){
                                               
                                               while($rec_result = $rec_query-> fetch_assoc()){
                                        ?>
                                            <option value="<?php echo $rec_result['user_id'];?>"> <?php echo $rec_result['username']; ?> </option>
                                        <?php 
                                            }
                                            }
                                            else{
                                                 echo "No recode avilable";   
                                                } 
                                        ?>
                                    </select>  


                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <h5>Message <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <textarea name="reception_message" id="textarea" class="form-control" required="" placeholder="Textarea text" rows="9"></textarea>
                                    <div class="help-block"></div></div>
                                </div>
                                <div class="form-group">
                                    <div class="card">
                                        <div class="card-body" style="padding-left: 0;padding-right: 0;">
                                            <h4 class="card-title">File Upload</h4>
                                            <label for="input-file-max-fs">You can add minimum 3mb max file size</label>
                                            <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="3M" name="recp_upld" />
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info recep_sbmt_btn" id="recep_btn">Submit</button>
                                    <button type="reset" class="btn btn-inverse recep_sbmt_btn">Cancel</button>
                                </div>
                            </form>
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
        <!--stickey kit -->
        
        
        
        <?php  include ('inc/footer.php'); ?>
        <script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="dist/js/pages/jasny-bootstrap.js"></script>
    
        <!-- ============================================================== -->
    <!-- Plugins for this page -->
    <!-- ============================================================== -->
    <!-- jQuery file upload -->
    <script src="assets/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>