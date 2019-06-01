<?php 
    include ('connection.php'); 

        $page_id = 5;
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
                        <h4 class="text-white">Work Visa Form List</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Work Visa Form List</li>
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
                                <h4 class="card-title">Work Visa Form List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> ID</th>
                                                <th> Counselor Name </th>
                                                
                                                <!-- <th> No. of Applicant </th> -->
                                                <th> Main Applicant </th>
                                                <!-- <th> Date of Birth </th> -->
                                                <th> Passport No </th>
                                                <th> Event Date </th>
                                                <th> Destination </th>

                                                <!-- <th> Contact Number 1 </th> -->
                                                <th> Contact Number 2 </th>
                                                
                                                <!-- <th> Amount Received </th> -->
                                                <!-- <th> Amount Pending </th> -->
                                                
                                                <th> Assign To</th>
                                                <th> Created By</th>
                                                <th> Action </th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th> ID </th>
                                                <th> Counselor Name </th>
                                                <!-- <th> No. of Applicant </th> -->
                                                <th> Main Applicant </th>
                                                <!-- <th> Date of Birth </th> -->
                                                <th> Passport No </th>
                                                <th> Event Date </th>
                                                <th> Destination </th>

                                                <!-- <th> Contact Number 1 </th> -->
                                                <th> Contact Number 2 </th>
                                                
                                                <!-- <th> Amount Received </th> -->
                                                <!-- <th> Amount Pending </th> -->
                                                <th> Assign To </th>
                                                <th> Created By</th>
                                                <th> Action </th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php 
                                            
                                                // $rec_sql = "SELECT vv*, u.`username` from visitor_form vv 
                                                //             JOIN users u ON u.user_id = vv.assign_to 
                                                //             order by id asc";

                                                $rec_sql = "SELECT w.*, u.`username` as assign_by_user, u1.`username` as created_by_user
                                                            FROM work_form w 
                                                            JOIN users u ON u.user_id = w.assign_to 
                                                            JOIN users u1 ON u1.user_id = w.created_by
                                                            WHERE w.action = 1 ORDER BY work_id ASC";
                                                
                                                $rec_query = $conn->query($rec_sql);

                                                if($rec_query->num_rows > 0){
                                                while($rec_result = $rec_query-> fetch_assoc()){
                                            ?>
                                            <tr>
                                                <td><?php echo $rec_result['work_id']; ?></td>
                                                <td><?php echo $rec_result['counselor_name']; ?></td>
                                                <!-- <td><?php //echo $rec_result['no_of_applicant']; ?></td> -->
                                                <td><?php echo $rec_result['main_applicant']; ?></td>
                                                <!-- <td><?php //echo $rec_result['date_of_birth']; ?></td> -->
                                                <td><?php echo $rec_result['passport_no']; ?></td>
                                                <td><?php echo $rec_result['event_date']; ?></td>
                                                <td><?php echo $rec_result['destination']; ?></td>

                                                <td><?php echo $rec_result['contact_number_1']; ?></td>
                                                <!-- <td><?php //echo $rec_result['contact_number_2']; ?></td> -->
                                                <!-- <td><?php //echo $rec_result['amount_received']; ?></td> -->
                                                <!-- <td><?php //echo $rec_result['amount_pending']; ?></td> -->
                                                
                                                <td><?php echo $rec_result['assign_by_user']; ?></td>
                                                <td><?php echo $rec_result['created_by_user']; ?></td>
                                                <td>
                                                    <a href="work_visa_edit.php?w_id=<?php echo $rec_result['work_id']; ?>" class="btn btn-success" id="work_edit_btn" > <i class="fa fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-danger" id="work_del_btn" data-id="<?php echo $rec_result['work_id']; ?>"> <i class="fa fa-trash"></i> Delete</a> 
                                                </td>

                                            </tr>
                                            <?php 
                                                }
                                            }else{
                                                echo "0 Result Available";
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
        <?php include ('inc/footer.php') ?>
   <!-- This is data table -->
    <script src="assets/node_modules/datatables/datatables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="http://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
    $(function() {
        $('#myTable').DataTable();
        $(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
                "order": [
                    [0, 'desc']
                ],
    });
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    </script>
</body>



</html>