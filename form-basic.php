        <?php  
            include ('connection.php');
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
                                                        <input type="radio" value="IELTS EXAM" name="enquiry_type" id="enquiry_type3" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type3">IELTS EXAM</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="PTE EXAM" name="enquiry_type" id="enquiry_type4" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type4">PTE EXAM</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="GRAMMER/BASIC" name="enquiry_type" id="enquiry_type5" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type5">GRAMMER/BASIC</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="STUDENT VISA" name="enquiry_type" id="enquiry_type6" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type6">STUDENT VISA</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="VISITOR VISA" name="enquiry_type" id="enquiry_type7" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type7">VISITOR VISA</label>
                                                    </div>
                                                </fieldset>


                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="OWP" name="enquiry_type" id="enquiry_type8" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type8">OWP</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="DEPENDENT VISA" name="enquiry_type" id="enquiry_type9" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type9">DEPENDENT VISA</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="PRTD" name="enquiry_type" id="enquiry_type10" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type10">PRTD</label>
                                                    </div>
                                                </fieldset> 



                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="TRV" name="enquiry_type" id="enquiry_type11" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type11">TRV</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="WORK PERMIT" name="enquiry_type" id="enquiry_type12" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type12">WORK PERMIT</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="PR" name="enquiry_type" id="enquiry_type13" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type13">PR</label>
                                                    </div>
                                                </fieldset>
                                                

                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="CAREER COUNSELLING" name="enquiry_type" id="enquiry_type14" class="custom-control-input">
                                                        <label class="custom-control-label" for="enquiry_type14">CAREER COUNSELLING</label>
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
                                                            <input type="radio" value="Social Network Sites" name="how_know" required="" id="enquiry_type_inline1" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline1">Social Network Sites</label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="Reference" name="how_know" id="enquiry_type_inline2" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline2">Reference </label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="News Paper" name="how_know" id="enquiry_type_inline3" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline3">News Paper </label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="TV Ads" name="how_know" id="enquiry_type_inline4" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline4">TV Ads </label>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="Wall Paints/Posters" name="how_know" id="enquiry_type_inline5" class="custom-control-input">
                                                            <label class="custom-control-label" for="enquiry_type_inline5">Wall Paints/Posters  </label>
                                                        </div>
                                                    </fieldset>
                                                <div class="help-block"></div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5> AssignTo <span>*</span> </h5>
                                        <div class="controls">
                                            
                                          <select class="form-control" name="assign_to">
                                            <option> -- Select --</option>
                                            <?php 
                                                $rec_sql = "select user_id,username from users";
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
        <!--stickey kit -->
        
        
        
        <?php  include ('inc/footer.php'); ?>
        <script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="dist/js/pages/jasny-bootstrap.js"></script>
    
