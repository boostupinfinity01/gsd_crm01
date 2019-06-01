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
                        <h4 class="text-white">PTE Form List</h4>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">PTE Form List</li>
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
                                <h4 class="card-title">PTE Form List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> ID</th>
                                                <th> Counselor Name </th>
                                                <th> Applicant Name </th>
                                                <th> Contact No.1 </th>
                                                
                                                <!--th> Admission Date</th>
                                                <th> Last Exam Date</th-->
                                                
                                                <th> Amount Received </th>
                                                <th> Get Overall Band</th>
                                                
                                                <th> Assign To</th>
                                                <th> Created By</th>
                                                <th> Action </th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th> ID</th>
                                                <th> Counselor Name </th>
                                                <th> Applicant Name </th>
                                                <th> Contact No.1 </th>
                                                
                                                <!--th> Admission Date</th>
                                                <th> Last Exam Date</th-->
                                                
                                                <th> Amount Received </th>
                                                <th> Get Overall Band</th>
                                                
                                                <th> Assign To</th>
                                                <th> Created By</th>
                                                <th> Action </th>
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php 
                                            
                                                // $rec_sql = "SELECT pte*, u.`username` from pte_exam pte 
                                                //             JOIN users u ON u.user_id = pte.assign_to 
                                                //             order by id asc";

                                                $rec_sql = "SELECT pte . * , u.`username` as assign_to_user, u1.`username` as created_by_user
                                                            FROM pte_exam pte 
                                                            
                                                            INNER JOIN users u ON u.user_id = pte.assign_to 
                                                            INNER JOIN users u1 ON u1.user_id = pte.created_by
                                                            WHERE pte.`action` = 1 
                                                            ORDER BY pte_id ASC";
                                                
                                                $rec_query = $conn->query($rec_sql);

                                                if($rec_query->num_rows > 0){
                                                while($rec_result = $rec_query-> fetch_assoc()){
                                            ?>
                                            <tr>
                                                <td><?php echo $rec_result['pte_id']; ?></td>
                                                <td><?php echo $rec_result['counselor_name']; ?></td>
                                                <td><?php echo $rec_result['applicant_name']; ?></td>
                                                <!--td><?php //echo $rec_result['email_address']; ?></td-->
                                                <!--td><?php //echo $rec_result['full_address']; ?></td-->
                                                <td><?php echo $rec_result['contact_number_1']; ?></td>
                                                <!--td><?php //echo $rec_result['admission_date']; ?></td-->
                                                <!--td><?php //echo $rec_result['exam_date']; ?></td-->
                                                <!--td><?php //echo $rec_result['contact_number_2']; ?></td--> 
                                                
                                                <!--td><?php //echo $rec_result['academy_name']; ?></td-->
                                                <td><?php echo $rec_result['amount_received']; ?></td>
                                                <!--td><?php // echo $rec_result['amount_pending']; ?></td-->
                                                <!--<td><?php //echo $rec_result['admission_date']; ?></td>--> 
                                                
                                                <!--td><?php //echo $rec_result['exam_date']; ?></td-->
                                                <td><?php echo $rec_result['total_band']; ?></td>
                                                <!--td><?php //echo $rec_result['admission_date']; ?></td-->  
                                                                                              
                                                <td><?php echo $rec_result['assign_to_user']; ?></td>
                                                <td><?php echo $rec_result['created_by_user']; ?></td>
                                                <td>
                                                    <a href="print_view.php?pte_id=<?php echo $rec_result['pte_id']; ?>" class="btn btn-dark" id="pte_del_btn" data-id="<?php echo $rec_result['pte_id']; ?>"> <i class="fa fa-search"></i> View</a>
                                                    <a href="pte-exam-edit.php?pte_id=<?php echo $rec_result['pte_id']; ?>" class="btn btn-success" id="pte_edit_btn" > <i class="fa fa-edit"></i> Edit</a>
                                                    <a href="print_view.php?pte_id=<?php echo $rec_result['pte_id']; ?>" class="btn btn-danger" id="pte_del_btn" data-id="<?php echo $rec_result['pte_id']; ?>"> <i class="fa fa-trash"></i> Delete</a> 
                                                	 
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