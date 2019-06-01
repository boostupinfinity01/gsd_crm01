<?php
    include('connection.php');
    

    if(getPost('action') == "add_user_account")
    {
        $validator = new validations();
        
        $validator->add_rule("full_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("user_name"," Add User Name","required|max_length[100]");
        $validator->add_rule("user_email","Add User Email Address ","required|max_length[80]");
        $validator->add_rule("user_phone","User Contact number","required|numeric|max_length[15]");
        $error = $validator->run();

        if(trim($error) == ''){

            $add_fullname = getPost('full_name');
            $add_username = getPost('user_name');
            $add_email =    getPost('user_email');
            $add_phone =    getNPost('user_phone');
            $add_joining_date = gmdate("Y-m-d G-i-s");
            $add_password = getPost('user_pass');
            $add_confirm_password = getPost('user_confirm_pass');
            $add_branch_name = getPost('branch_name');
            $add_designation = getPost('designation');
            $add_account_type = getPost('account_type');
            $user_action = getNPost('account_action');
            
           // $user_img1 = $_FILES['user_img']['name'];//

            
            $add_user_sql = "INSERT INTO `users` (`username`, `email`, `full_name`, `phone`, `joining_date`, `password`, `branch_name`, `designation`, `account_type`, `action`) 
                                         VALUES 
                                               (  '$add_username',
                                                  '$add_email', 
                                                  '$add_fullname', 
                                                  $add_phone, 
                                                  '$add_joining_date', 
                                                  '$add_password', 
                                                  $add_branch_name,
                                                  $add_designation,$add_account_type, $user_action)";


            $add_user_query = $conn->query($add_user_sql);
            // $json_array = array('status'=>'success','message'=>$add_user_sql);
            // echo json_encode($json_array);
            // exit();
            

            if($add_user_query)
            {
                $msg = "<div class='alert alert-success' style='padding:10px;'>Request for quotation submitted</div>";
                $json_array = array('status'=>'success','message'=>$msg);
                echo json_encode($json_array);
                exit();       
            }
            else{
                $msg = "<div class='alert alert-warning' style='padding:10px;'></div>";
                $json_array = array('status'=>'failed', 'message'=>$msg);
                echo json_encode($json_array);
                exit();
            }
                                            
        }
        else
        {
          $msg = "<div class='alert alert-warning'> Query Not Working </div>";
          $json_array = array('status'=>'failed', 'message'=>$msg);
          echo json_encode($json_array);
          exit();
        }

    }
?>


