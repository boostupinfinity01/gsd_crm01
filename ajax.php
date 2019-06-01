<?php
    require_once('libs/class.validations.php');
    require_once('libs/string_func.php');
    require_once('connection.php');

    date_default_timezone_set("Asia/Kolkata");
    
    $logged_user_id = 0;
    
    if(getSession('log_userid') > 0)
    {
        $logged_user_id  = (int)(getSession('log_userid'));
    }
    
    

    if(getPost('action') == "logout_account")
    {
        removeSession("log_userid");
        removeSession("log_username");
        removeSession("log_usertype");
        session_destroy();
        $msg = "<div class='alert1 alert1-success' style='padding:10px;'>Logged out successfully.</div>";
        $json_array = array('status'=>'success','message'=>$msg);
        echo json_encode($json_array);
        exit();
    }
    
    if(getPost('action') == "add_user_account")
    {
        $validator = new validations();
        
        $validator->add_rule("full_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("user_name"," Add User Name","required|max_length[100]");
        $validator->add_rule("user_email","Add User Email Address ","max_length[100]");
        $validator->add_rule("user_phone","User Contact number","required|numeric|max_length[15]");
        $error = $validator->run();

        if(trim($error) == ''){

            $add_fullname = getPost('full_name');
            $add_username = getPost('user_name');
            $add_email =    getPost('user_email');
            $add_phone =    getNPost('user_phone');
            $add_joining_date = date("Y-m-d G-i-s");
            $add_password = getPost('user_pass');
            $add_confirm_password = getPost('user_confirm_pass');
            $add_branch_name = getPost('branch_name');
            $add_designation = getPost('designation');
            $add_account_type = getPost('account_type');
            $user_action = getNPost('account_action');
            
            $user_img1 = $_FILES['user_img']['name'];

              if(!empty($_FILES['user_img']['name']))
              {
                $testi_img = $_FILES["user_img"]["name"]; //stores the original filename from the client
                $tmp =      $_FILES["user_img"]["tmp_name"]; //stores the name of the designated temporary file
                $errorimg = $_FILES["user_img"]["error"]; //stores any error code resulting from the transfer
                
                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                $path = 'uploads/users/'; // upload directory
                
                // get uploaded file's extension
                $ext = strtolower(pathinfo($testi_img, PATHINFO_EXTENSION));
                
                // can upload same image size limit using function 
                $file_size = $_FILES['user_img']['size'];
               
                // can upload same image using rand function
                $final_image = rand(1000,1000000).$testi_img;

                // check's valid format
                  if(in_array($ext, $valid_extensions)) { 
                    $path = $path.strtolower($final_image); 
                    $uploadreport = move_uploaded_file($tmp,$path);

                  if($uploadreport) {
                    
                    $add_user_sql = "INSERT INTO `users` (`username`, `email`, `full_name`, `phone`, `joining_date`, `password`, `branch_name`, `designation`, `account_type`, `user_pimage`,`action`) VALUES ('$add_username', '$add_email', '$add_fullname', $add_phone,'$add_joining_date', '$add_password', $add_branch_name, $add_designation, $add_account_type, '$path', $user_action)";

                    $add_user_query = $conn->query($add_user_sql);
                    

                      // Your validation code.
                       if (empty($add_password)) {
                           $msg = "<div class='alert alert-warning' style='padding:10px;'>Password is required.</div>";
                          $json_array = array('status'=>'failed','message'=>$msg);
                          echo json_encode($json_array);
                          exit(); 
                      
                      } else if($add_password != $add_confirm_password) {
                           // error matching passwords
                          $msg = "<div class='alert alert-warning' style='padding:10px;'>Your passwords do not match. Please type carefully.</div>";
                          $json_array = array('status'=>'failed','message'=>$msg);
                          echo json_encode($json_array);
                          exit(); 
                      
                      } else {
                          if($add_user_query)
                          {
                              $msg = "<div class='alert alert-success' style='padding:10px;'>Request for quotation submitted</div>";
                              $json_array = array('status'=>'success','message'=>$msg);
                              echo json_encode($json_array);
                              exit();       
                      
                      } else{
                              $msg = "<div class='alert alert-warning' style='padding:10px;'> Data could not be saved or Double Entry. </div>";
                              $json_array = array('status'=>'failed', 'message'=>$msg);
                              echo json_encode($json_array);
                              exit();
                          }
                       }
                       // passwords match
                       
                  }//$uploadreport
                    else{
                      $msg = '<div class="alert alert-danger">Failed to upload image</div>';
                      $json_array = array("status"=>"failed", "message"=> $msg);
                      echo json_encode($json_array);
                      exit();
                    }
                  } // end check's valid format
                    else{
                      $msg = '<div class="alert alert-danger"> Invalid file path </div>';
                      $json_array = array("status"=>"failed", "message"=> $msg);
                      echo json_encode($json_array);
                      exit();
                    }

                } // !empty 
                  else if(empty($_FILES['user_img']['name'])){
                    $add_user_sql = "INSERT INTO `users` (`username`, `email`, `full_name`, `phone`, `joining_date`, `password`, `branch_name`, `designation`, `account_type`, `action`) 
                    VALUES ('$add_username', '$add_email', '$add_fullname', $add_phone, '$add_joining_date', '$add_password', $add_branch_name, $add_designation, $add_account_type, $user_action)";
                    $add_user_query = $conn->query($add_user_sql);

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
        } // trim
        else
        {
          $msg = "<div class='alert alert-warning'> ".$error."Query Not Working </div>";
          $json_array = array('status'=>'failed', 'message'=>$msg);
          echo json_encode($json_array);
          exit();
        }
    }


    // Edit User Account //
    
    if(getPost('action') == "edit_user_account")
    {
        $validator = new validations();
        
        $validator->add_rule("full_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("user_name"," Add User Name","required|max_length[100]");
        $validator->add_rule("user_email","Add User Email Address ","max_length[80]");
        $validator->add_rule("user_phone","User Contact number","required|numeric|max_length[15]");
        $error = $validator->run();
    
        if(trim($error) == '')
        {
            $u_id = getNPost('id');
            $edit_fullname = getPost('full_name');
            $edit_username = getPost('user_name');
            $edit_email =    getPost('user_email');
            $edit_phone =    getNPost('user_phone');
            /*$edit_joining_date = date("Y-m-d G-i-s");*/
            $edit_joining_date = getPost('join_date');
            $edit_branch_name = getPost('branch_name');
            $edit_designation = getPost('designation');
            $edit_account_type = getPost('account_type');
            $user_action = getNPost('account_action');
            
            $user_img1 = $_FILES['user_img']['name'];
            
            
            
            if(!empty($_FILES['user_img']['name']))
              {
                $testi_img = $_FILES["user_img"]["name"]; //stores the original filename from the client
                $tmp =      $_FILES["user_img"]["tmp_name"]; //stores the name of the designated temporary file
                $errorimg = $_FILES["user_img"]["error"]; //stores any error code resulting from the transfer
                
                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                $path = 'uploads/users/'; // upload directory
                
                // get uploaded file's extension
                $ext = strtolower(pathinfo($testi_img, PATHINFO_EXTENSION));
                
                // can upload same image size limit using function 
                $file_size = $_FILES['user_img']['size'];
               
                // can upload same image using rand function
                $final_image = rand(1000,1000000).$testi_img;

                // check's valid format
                  if(in_array($ext, $valid_extensions)) { 
                    $path = $path.strtolower($final_image); 
                    $uploadreport = move_uploaded_file($tmp,$path);

                        if($uploadreport) {
                    
                            $edit_user_sql = "UPDATE `users` SET `username`= '$edit_username', 
                                                                `email`='$edit_email', 
                                                                `full_name`='$edit_fullname',
                                                                `phone`=$edit_phone, 
                                                                `joining_date` = '$edit_joining_date',
                                                                `branch_name`=$edit_branch_name, 
                                                                `designation`=$edit_designation, 
                                                                `account_type`=$edit_account_type, 
                                                                `user_pimage`='$path',
                                                                `action`=$user_action where user_id=".$u_id;

                            $edit_user_query = $conn->query($edit_user_sql);
                    
                            if($edit_user_query) {
                                    
                                    $msg = "<div class='alert alert-success' style='padding:10px;'>User Profile Successfully Updated !</div>";
                                    $json_array = array('status'=>'success','message'=>$msg);
                                    echo json_encode($json_array);
                                    exit();       
                                } 
                            else{
                                    $msg = "<div class='alert alert-warning' style='padding:10px;'> Data could not be saved or Double Entry. </div>";
                                    $json_array = array('status'=>'failed', 'message'=>$msg);
                                    echo json_encode($json_array);
                                    exit();
                                }
                  
                        }//$uploadreport
                        else {
                              $msg = '<div class="alert alert-danger">Failed to upload image</div>';
                              $json_array = array("status"=>"failed", "message"=> $msg);
                              echo json_encode($json_array);
                              exit();
                            }
                    } // end check's valid format
                    else {
                          $msg = '<div class="alert alert-danger"> Invalid file path </div>';
                          $json_array = array("status"=>"failed", "message"=> $msg);
                          echo json_encode($json_array);
                          exit();
                        }

                  } /* !empty */ 
                else if(empty($_FILES['user_img']['name']))
                {
                              $edit_user_sql = "UPDATE `users` SET `username`= '$edit_username', 
                                                                    `email`='$edit_email', 
                                                                    `full_name`='$edit_fullname',
                                                                    `phone`=$edit_phone, 
                                                                    `joining_date` = '$edit_joining_date',
                                                                    `branch_name`=$edit_branch_name, 
                                                                    `designation`=$edit_designation, 
                                                                    `account_type`=$edit_account_type, 
                                                                    `action`=$user_action where user_id=".$u_id;
                    $edit_user_query = $conn->query($edit_user_sql);
                    
                      if($edit_user_query)
                      {
                              $msg = "<div class='alert alert-success' style='padding:10px;'>User Profile Successfully Updated !</div>";
                              $json_array = array('status'=>'success','message'=>$msg);
                              echo json_encode($json_array);
                              exit();       
                            }
                       else 
                       {
                              $msg = "<div class='alert alert-warning' style='padding:10px;'></div>";
                              $json_array = array('status'=>'failed', 'message'=>$msg);
                              echo json_encode($json_array);
                              exit();
                            }
                  } 

                } // end trim
                
                else {
                    $msg = "<div class='alert1 alert1-warning'> ".$error."Query Not Working </div>";
                    $json_array = array('status'=>'failed', 'message'=>$msg);
                    echo json_encode($json_array);
                    exit();
                }

            } // end edit_user_account
    

    // Delete user in table //
    
    if(getPost('action') == "delete_user"){
      $id = getNPost('id');
      
      $del = "DELETE FROM `users` WHERE `users`.`user_id` =".$id;
      $query_result = $conn->query($del);
      
          
        if($query_result){
          $msg = "<div class='alert alert-success'> Deleted Successfully </div>";
          $json_array = array("status"=>"success", "message"=> $msg);
          echo json_encode($json_array);
          exit();
        }else{
          $msg = "<div class='alert alert-success'> Not Delete </div>";
          $json_array = array("status"=>"failed", "message"=> $msg);
          echo json_encode($json_array);
          exit();
        }
    }

// ----------------------------------- //
  // Activate & Deactivate User //
    
    if(getPost('action') == "active_user"){
      $id = getNPost('id');

        $activeuser_sql = "UPDATE `users` SET `action` = 1 WHERE `users`.`user_id` =".$id;
        $activeuser_query = $conn->query($activeuser_sql);

        if($activeuser_query){
          $msg = "<div class='alert alert-success'> User Active Successfully Updated </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }else{
          $msg = "<div class='alert alert-success'> User Active Not Updated </div>";
          $json_array = array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
  }

  if(getPost('action') == "deactive_user"){
      $id = getPost('id');

        $activeuser_sql = "UPDATE `users` SET `action` = 0 WHERE `users`.`user_id` =".$id;
        $activeuser_query = $conn->query($activeuser_sql);

        if($activeuser_query){
          $msg = "<div class='alert alert-success'> User Deactivate Successfully Updated </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }else{
          $msg = "<div class='alert alert-danger'> User Deactivate  Not Updated </div>";
          $json_array = array("status"=>"failed","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
  }

 // ---------------------------------- //
  // ADD Reception Form  //

  if(getPost('action') == "add_form_reception")
  {
                  
            $validator = new validations();
            $validator->add_rule("name","Add Full Name","required|max_length[100]");
            $validator->add_rule("fathername"," Add Father Name","required|max_length[100]");
            $validator->add_rule("cnt1","User First Contact number ","required|numeric|max_length[10]");
            $validator->add_rule("cnt2","User Alternate Contact number","numeric|max_length[10]");
            $validator->add_rule("enquiry_type","User Enquiry Type","required|max_length[100]");
            $validator->add_rule("how_know","How Know About Company","required|max_length[100]");

            $validator->add_rule("emaill_addrs","Enter email address","max_length[300]");
            $validator->add_rule("full_addrs","Enter full address","required");

            $validator->add_rule("assign_to","Reception Form Assign to","required|max_length[100]");
            $validator->add_rule("reception_message","Reception Form Message","required");
    
            $error = $validator->run();
    
            if(trim($error) == ''){
              $recp_uname = getPost('name');
              $recp_fathername = getPost('fathername');
              $recp_ucnt1 = getNPost('cnt1');
              $recp_ucnt2 = getNPost('cnt2');
              $recp_email = getPost('emaill_addrs');
              $recp_full_addrs = getPost('full_addrs');

              $recp_enquiry_date = date("Y-m-d G-i-s");
              $recp_enquiry_type = getPost('enquiry_type');
              $recp_how_reach = getPost('how_know');
              $recp_assign = getNPost('assign_to');

              $recp_message = getPost('reception_message');
              $recp_upload = $_FILES['recp_upld']['name'];
              $recp_action = getPost('action');
              

                if(!empty($_FILES['recp_upld']['name']))
                {
                  $testi_img = $_FILES["recp_upld"]["name"]; //stores the original filename from the client
                  $tmp =      $_FILES["recp_upld"]["tmp_name"]; //stores the name of the designated temporary file
                  $errorimg = $_FILES["recp_upld"]["error"]; //stores any error code resulting from the transfer
                  
                  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                  $path = 'uploads/reception/'; // upload directory
                  
                  // get uploaded file's extension
                  $ext = strtolower(pathinfo($testi_img, PATHINFO_EXTENSION));
                  
                  // can upload same image size limit using function 
                  $file_size = $_FILES['recp_upld']['size'];
                 
                  // can upload same image using rand function
                  $final_image = rand(1000,1000000).$testi_img;

                  // check's valid format
                    if(in_array($ext, $valid_extensions)) { 
                      $path = $path.strtolower($final_image); 
                      $uploadreport = move_uploaded_file($tmp,$path);

                      if($uploadreport) {


                
                          $add_rform_sql = "INSERT INTO `reception_form` (`name`, `father_name`, `contact_no1`,";
                          if($recp_ucnt2 != 0)
                          {
                            $add_rform_sql .= "`contact_no2`, ";
                          }
                           $add_rform_sql .= "`email_address`, `full_address`, `enquiry_type`, `how_now_macro`, `message`, `file_upld`, `date` , `assign_to`,`created_by`) VALUES ('$recp_uname','$recp_fathername',$recp_ucnt1, ";
                           if($recp_ucnt2 != 0)
                          {
                            $add_rform_sql .= "$recp_ucnt2, ";
                          }
                           
                           $add_rform_sql  .= "'$recp_email', '$recp_full_addrs', '$recp_enquiry_type', '$recp_how_reach',  '$recp_message', '$path' ,'$recp_enquiry_date', $recp_assign, $logged_user_id);";
                        
                            $add_rform_query = $conn->query($add_rform_sql);

            
			            if($add_rform_query){
			              $msg = "<div class='alert alert-success' style='padding:10px;'>Reception Form Successfully Submitted</div>";
                  $json_array = array("status"=>"success", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();              
                }// if $add_rform_query
                else
                {
                  $msg = "<div class='alert alert-warning' style='padding:10px;'> Reception Form Not Submitted </div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
                } // else $add_rform_query
            

                }//$uploadreport
                else {
                      $msg = '<div class="alert alert-danger">Failed to upload image</div>';
                      $json_array = array("status"=>"failed", "message"=> $msg);
                      echo json_encode($json_array);
                      exit();
                    }

              }// end check's valid format
              else {
                    $msg = '<div class="alert alert-danger"> Invalid file path </div>';
                    $json_array = array("status"=>"failed", "message"=> $msg);
                    echo json_encode($json_array);
                    exit();
                  }


              } // empty
              else if(empty($_FILES['recp_upld']['name'])){
                              
                    $add_rform_sql = "INSERT INTO `reception_form` (`name`, `father_name`, `contact_no1`,";
                          if($recp_ucnt2 != 0)
                          {
                            $add_rform_sql .= "`contact_no2`, ";
                          }
                           $add_rform_sql .= "`email_address`, `full_address`, `enquiry_type`, `how_now_macro`, `message`, `file_upld`, `date` , `assign_to`,`created_by`) VALUES ('$recp_uname','$recp_fathername',$recp_ucnt1, ";
                           if($recp_ucnt2 != 0)
                          {
                            $add_rform_sql .= "$recp_ucnt2, ";
                          }
                           
                        $add_rform_sql  .= "'$recp_email', '$recp_full_addrs', '$recp_enquiry_type', '$recp_how_reach',  '$recp_message', '$path' ,'$recp_enquiry_date', $recp_assign, $logged_user_id);";
                        
                        $add_rform_query = $conn->query($add_rform_sql);

                    
                    
                      if($add_rform_query){
                              $msg = "<div class='alert alert-success' style='padding:10px;'>User Profile Successfully Updated !</div>";
                              $json_array = array('status'=>'success','message'=>$msg);
                              echo json_encode($json_array);
                              exit();       
                            }
                       else {
                              $msg = "<div class='alert alert-warning' style='padding:10px;'></div>";
                              $json_array = array('status'=>'failed', 'message'=>$msg);
                              echo json_encode($json_array);
                              exit();
                            }
                  }


            }// End else trim
            else
            {
			            $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
            }// Else end trim
        

  
  } // form *add_form_reception*



  // ---------------------------------- //
  // Edit Reception Form  //
  if(getPost('action')== "edit_reception_form"){

    $validator = new validations();
        
        $validator->add_rule("name","Add Full Name","required|max_length[100]");
        $validator->add_rule("fathername"," Add Father Name","required|max_length[100]");
        $validator->add_rule("cnt1","User First Contact number ","required|numeric|max_length[10]");
        $validator->add_rule("cnt2","User Alternate Contact number","numeric|max_length[10]");

        $validator->add_rule("emaill_addrs","Enter email address","max_length[300]");
        $validator->add_rule("full_addrs","Enter full address","required");

        $validator->add_rule("enquiry_type","User Enquiry Type","required");
        $validator->add_rule("how_know_us","How Know About Company","required");
        $validator->add_rule("assign_to","Reception Form Assign to","required");
        
        $error = $validator->run();


        if(trim($error) == ''){
          $recp = getNPost('id');
          $recp_uname1 = getPost('name');
          $recp_fathername1 = getPost('fathername');
          $recp_ucnt11 =    getNPost('cnt1');
          $recp_ucnt21 =    getNPost('cnt2');

          $recp_email = getPost('emaill_addrs');
          $recp_full_addrs = getPost('full_addrs');

          $recp_enquiry_date1 = date("Y-m-d G-i-s");
          $recp_enquiry_type1 = getPost('enquiry_type');
          $recp_how_reach1 = getPost('how_know_us');
          $recp_assign1 = getNPost('assign_to');
          $recp_message1 = getPost('reception_message');
          $recp_upload = $_FILES['recp_upld']['name'];

          if(!empty($_FILES['recp_upld']['name']))
                {
                  $testi_img = $_FILES["recp_upld"]["name"]; //stores the original filename from the client
                  $tmp =      $_FILES["recp_upld"]["tmp_name"]; //stores the name of the designated temporary file
                  $errorimg = $_FILES["recp_upld"]["error"]; //stores any error code resulting from the transfer
                  
                  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                  $path = 'uploads/reception/'; // upload directory
                  
                  // get uploaded file's extension
                  $ext = strtolower(pathinfo($testi_img, PATHINFO_EXTENSION));
                  
                  // can upload same image size limit using function 
                  $file_size = $_FILES['recp_upld']['size'];
                 
                  // can upload same image using rand function
                  $final_image = rand(1000,1000000).$testi_img;


          // check's valid format
          if(in_array($ext, $valid_extensions)) { 
            $path = $path.strtolower($final_image); 
            $uploadreport = move_uploaded_file($tmp,$path);

          if($uploadreport) {
          
              $edit_recpf_sql = "UPDATE `reception_form` SET `name`='$recp_uname1',`father_name`= '$recp_fathername1',`contact_no1`=$recp_ucnt11,`contact_no2`=$recp_ucnt21,`email_address`='$recp_email', `full_address`='$recp_full_addrs', `enquiry_type`= '$recp_enquiry_type1', `message`='$recp_message1', `file_upld`='$path',`how_now_macro`= '$recp_how_reach1', `date`='$recp_enquiry_date1', `assign_to`= $recp_assign1 WHERE `reception_form`.`id` =".$recp;
              
              $edit_recpf_query = $conn->query($edit_recpf_sql);
               
          if($edit_recpf_query)
            {
                  $msg = "<div class='alert alert-success' style='padding:10px;'>Reception Form Update Successfully</div>";
                $json_array = array("status"=>"success", "message"=>$msg);
                echo json_encode($json_array);
                exit();
            }
            else
            {
                  $msg = "<div class='alert alert-danger' style='padding:10px;'>Failed to Update, try again later</div>";
                $json_array = array("status"=>"failed", "message"=>$msg);
                echo json_encode($json_array);
                exit();
            }

          }// end uploadreport
          else{
                $msg = '<div class="alert1 alert1-danger">Failed to upload image</div>';
                $json_array = array("status"=>"failed", "message"=> $msg);
                echo json_encode($json_array);
                exit();
              }// end else uploadreport

          }// end check's valid format
          else{
                $msg = '<div class="alert1 alert1-danger"> Invalid file path </div>';
                $json_array = array("status"=>"failed", "message"=> $msg);
                echo json_encode($json_array);
                exit();
              }

          } // empty
        


          }// trim end
          else
          {
              $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
          } // trim else end 



  } //action - "edit_form_reception"


// ---------------------------------- //
 // Delete Deactivate Reception Form //
if(getPost('action') == "rec_del_form"){ 

      $rdid = getNPost('id');
      $rec_del_sql = "UPDATE `reception_form` SET `action` = 0 WHERE `reception_form`.`id`=".$rdid;
      $rec_del_query = $conn->query($rec_del_sql);


      if($rec_del_query){
        $msg = "<div class='alert alert-success'> Record Deleted Successfully</div>";
        $json_array = array("status"=>"success", "message"=>$msg);
        echo json_encode($json_array);
        exit();
      }else{
        $msg = "<div class='alert alert-warning'> Record Not Deleted</div>";
        $json_array = array("status"=>"success", "message"=>$msg);
        echo json_encode($json_array);
        exit();
      } 
}




    

//action - "Delete Deactivate Reception Form"
 
  if(getPost('action') == "add_visitor_visa_form"){
        
        $validator = new validations();
        
        $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("no_applicant"," Add User Name","required|numeric|max_length[100]");
        $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
        $validator->add_rule("passport_no","User Passport number","numeric|max_length[7]");

        $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");

        $validator->add_rule("cnt1","User Contact number 1","required|numeric|max_length[10]");
        $validator->add_rule("cnt2","User Contact number 2","numeric|max_length[10]");
        
        $validator->add_rule("emaill_addrs","Enter Email Address","required");
        $validator->add_rule("full_addrs","Enter Full Parmanant Address ","required");
        $validator->add_rule("event_det","Enter Event Detail Information","required");
    
        
        $validator->add_rule("amnt_recv","Amount Receive?","numeric|max_length[15]");
        $validator->add_rule("amnt_pend","Amount Pending?","numeric|max_length[15]");
        
        for($i = 1;$i<=5;$i++)
        {
            $field_name = "applicant_name".$i;
            if(isset($_POST[$field_name]))
            {
                $validator->add_rule("applicant_name".$i,"Applicant 1 Name","required|max_length[80]");
                $validator->add_rule("applicant_passprt_no".$i,"Applicant 1 Passport Number","required|max_length[7]");
                $validator->add_rule("applicant_name_dob".$i,"Applicant 1 DOB","required");
            }
        }
        
        
          

        $error = $validator->run();

        if(trim($error) == ''){
          $counselor_name = getPost('counselor_name');
          $no_applicant = getNPost('no_applicant');
          
          $applicant_name = getPost('main_applicant_name');
          $applicant_dob = date("Y-m-d G-i-s");
          $applicant_passportno = getNPost('passport_no');
          //$event_date = date("Y-m-d G-i-s");

          $destination = getPost('styled_destin');
          $ucnt1 = getNPost('cnt1');
          $ucnt2 = getNPost('cnt2');
          $amnt_recv = getNPost('amnt_recv');
          $amnt_pending = getNPost('amnt_pend');
          
          $email_address = getPost('email_address');
          $full_address = getPost('full_address');
          $event_detail = getPost('event_det');
          
          $mgm_side = getPost('mgm_side');
          $any_refusal = getPost('any_refusal');
          $travel_history = getPost('travel_history');
          $govt_servant = getPost('govt_servant');
          $any_remark = getPost('any_remark');
          
          /*$visitor_assign = getNPost('assign_to');*/

        
          $add_visitor_form_sql = "INSERT INTO `visitor_form` (`counselor_name`, `no_of_applicant`, `main_applicant`, `date_of_birth` , `passport_no`, `destination`, `contact_number_1`, `contact_number_2`, `email_address`, `full_address`, `amount_received`, `amount_pending`, `event_detail`, `any_mgm_side`, `any_refusal`, `any_travel_history`, `any_govt_servant`, `any_remarks`, `created_by`) VALUES ('$counselor_name', $no_applicant, '$applicant_name', '$applicant_dob', $applicant_passportno, '$destination' , $ucnt1, $ucnt2, '$email_address', '$full_address', $amnt_recv, $amnt_pending, '$event_detail', '$mgm_side', '$any_refusal', '$travel_history', '$govt_servant', '$any_remark',$logged_user_id)";
            $add_visitor_query = $conn->query($add_visitor_form_sql);

             
            if($add_visitor_query){
              $msg = "<div class='alert alert-success' style='padding:10px;'> Visitor Visa Form Successfully Submitted </div>";
              $json_array = array("status"=>"success", "message"=>$msg);
              echo json_encode($json_array);
              exit();              
            }
            else{
              $msg = "<div class='alert alert-warning' style='padding:10px;'> Visitor Visa Form Not Submitted </div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
            }
        }
        else
        {
          $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
        }

  }


  if(getPost('action') == "edit_visitor_visa_form")
      {

          $validator = new validations();
        
          $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
          $validator->add_rule("no_applicant"," Add User Name","required|numeric|max_length[15]");
          $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[100]");
          $validator->add_rule("passport_no","User Passport number","numeric|max_length[7]");

          $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
          
          $validator->add_rule("cnt1","User Contact number 1","required|numeric|max_length[10]");
          $validator->add_rule("cnt2","User Contact number 2","numeric|max_length[10]");
          
          $validator->add_rule("emaill_addrs","Enter Email Address","required");
          $validator->add_rule("full_addrs","Enter Full Parmanant Address ","required");
          
          $validator->add_rule("event_det","Enter Event Detail Information","required");
          
          $validator->add_rule("amnt_recv","Amount Receive?","numeric|max_length[7]");
          $validator->add_rule("amnt_pend","Amount Pending?","numeric|max_length[7]");
          

          $error = $validator->run();

          if(trim($error) == '')
          {
              $vv_id = getNPost('visitor_id');
              $counselor_name = getPost('counselor_name');
              $no_applicant = getNPost('no_applicant');
              
              $applicant_name = getPost('main_applicant_name');
              $applicant_dob = date("Y-m-d G-i-s");
              $applicant_passportno = getNPost('passport_no');
              $event_date = date("Y-m-d G-i-s");

              $destination = getPost('styled_destin');
              $ucnt1 = getNPost('cnt1');
              $ucnt2 = getNPost('cnt2');
              $amnt_recv = getNPost('amnt_recv');
              $amnt_pending = getNPost('amnt_pend');
              
              $email_address = getPost('emaill_addrs');
              $full_address = getPost('full_addrs');
              $event_detail = getPost('event_det');
              
              $mgm_side = getPost('mgm_side');
              $any_refusal = getPost('any_refusal');
              $travel_history = getPost('travel_history');
              $govt_servant = getPost('govt_servant');
              $any_remark = getPost('any_remark');
              
              $visitor_assign = getNPost('assign_to');


              
              $edit_visitorf_sql = "UPDATE `visitor_form` SET `counselor_name`='$counselor_name', `no_of_applicant`= $no_applicant, `main_applicant`='$applicant_name', `date_of_birth`='$applicant_dob', `passport_no`=$applicant_passportno, `event_date`='$event_date',`destination`='$destination',`contact_number_1`=$ucnt1, `contact_number_2`=$ucnt2, `email_address`='$email_address', `full_address`='$full_address', `amount_received`=$amnt_recv, `amount_pending`=$amnt_pending, `event_detail`= '$event_detail', `any_mgm_side`='$mgm_side', `any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark', `created_by`=$logged_user_id WHERE `visitor_form`.`visitor_id` =".$vv_id;
              
              $edit_visitorf_query = $conn->query($edit_visitorf_sql);
                
              
              if($edit_visitorf_query)
              {
                  $msg = "<div class='alert1 alert1-success' style='padding:10px;'>Edited Successfully</div>";
                  $json_array = array("status"=>"success", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
              else
              {
                  $msg = "<div class='alert1 alert1-danger' style='padding:10px;'>Failed to submit, try again later</div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
          }
          else
          {
              $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed","message"=>$msg);
              echo json_encode($json_array);
              exit();
          }
      }

      // ---------------------------------- //
      // Delete Deactivate Visitor Visa  Form // 

      if(getPost('action') == "visitor_visa_del"){
        
        $vv_id = getNPost('visitor_id');

        $active_visitor_sql = "UPDATE `visitor_form` SET `action` = 0 WHERE `visitor_id` =".$vv_id;
        $active_visitor_query = $conn->query($active_visitor_sql);

        if($active_visitor_query){
          $msg = "<div class='alert alert-success'> User Deactivate Successfully Updated </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();

        }else{
          $msg = "<div class='alert alert-success'> User Deactivate  Not Updated </div>";
          $json_array = array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
      }


// add Tourist visa form
  if(getPost('action') == "add_tourist_visa_form"){
         
        $validator = new validations();
        $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
        $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
        $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
        $validator->add_rule("cnt1","Contact number 1","numeric|max_length[10]");
        $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

        $validator->add_rule("amnt_recv","Amount Received","numeric");
        $validator->add_rule("amnt_pend","Amount Pending","numeric");
        $validator->add_rule("assign_to","Form assign to","required");

        $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
        $error = $validator->run();

        if(trim($error) == ''){
          $counselor_name = getPost('counselor_name');
          $no_applicant = getNPost('no_applicant');
          
          $applicant_name = getPost('main_applicant_name');
          $applicant_dob = date("Y-m-d G-i-s");
          $applicant_passportno = getNPost('passport_no');
          $event_date = date("Y-m-d G-i-s");

          $destination = getPost('styled_destin');
          $ucnt1 = getNPost('cnt1');
          $ucnt2 = getNPost('cnt2');
          $amnt_recv = getNPost('amnt_recv');
          $amnt_pending = getNPost('amnt_pend');
          
          $mgm_side = getPost('mgm_side');
          $any_refusal = getPost('any_refusal');
          $travel_history = getPost('travel_history');
          $govt_servant = getPost('govt_servant');
          $any_remark = getPost('any_remark');
          
          $visitor_assign = getNPost('assign_to');
          

          $add_visitor_form_sql = "INSERT INTO `tourist_form` (`counselor_name`, `no_of_applicant`, `main_applicant`, `date_of_birth` , `passport_no`, `event_date`, `destination`, `contact_number_1`, `contact_number_2`, `amount_received`, `amount_pending`, `any_mgm_side`, `any_refusal`, `any_travel_history`, `any_govt_servant`, `any_remarks`, `assign_to`) VALUES ('$counselor_name', $no_applicant, '$applicant_name', '$applicant_dob', $applicant_passportno, '$event_date', '$destination' , $ucnt1, $ucnt2, $amnt_recv, $amnt_pending, '$mgm_side', '$any_refusal', '$travel_history', '$govt_servant', '$any_remark', $visitor_assign)";
        
            $add_visitor_query = $conn->query($add_visitor_form_sql);

             
            if($add_visitor_query){
              $msg = "<div class='alert alert-success' style='padding:10px;'>Tourist Visa Form Successfully Submitted</div>";
              $json_array = array("status"=>"success", "message"=>$msg);
              echo json_encode($json_array);
              exit();              
            }
            else{
              $msg = "<div class='alert alert-warning' style='padding:10px;'> Tourist Visa Form Not Submitted </div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
            }
        }
        else
        {
          $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
          $json_array = array("status"=>"failed", "message"=>$msg);
          echo json_encode($json_array);
          exit();
        }

  }


// Edit Tourist visa form
  if(getPost('action') == "edit_tourist_visa_form")
  {

    $validator = new validations();
  
    $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
    $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
    $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
    $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
    $validator->add_rule("cnt1","Contact number 1","numeric|max_length[10]");
    $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

    $validator->add_rule("amnt_recv","Amount Received","numeric");
    $validator->add_rule("amnt_pend","Amount Pending","numeric");
    $validator->add_rule("assign_to","Form assign to","required");

    $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
    $error = $validator->run();

      if(trim($error) == '')
          {
            $tt_id = getNPost('tourist_id');
            $counselor_name = getPost('counselor_name');
            $no_applicant = getNPost('no_applicant');
            
            $applicant_name = getPost('main_applicant_name');
            $applicant_dob = date("Y-m-d G-i-s");
            $applicant_passportno = getNPost('passport_no');
            $event_date = date("Y-m-d G-i-s");

            $destination = getPost('styled_destin');
            $ucnt1 = getNPost('cnt1');
            $ucnt2 = getNPost('cnt2');
            $amnt_recv = getNPost('amnt_recv');
            $amnt_pending = getNPost('amnt_pend');
            
            $mgm_side = getPost('mgm_side');
            $any_refusal = getPost('any_refusal');
            $travel_history = getPost('travel_history');
            $govt_servant = getPost('govt_servant');
            $any_remark = getPost('any_remark');
            
            $tourist_assign = getNPost('assign_to');


            $edit_touristf_sql = "UPDATE `tourist_form` SET `counselor_name`='$counselor_name',`no_of_applicant`= $no_applicant,`main_applicant`='$applicant_name',`date_of_birth`='$applicant_dob',`passport_no`=$applicant_passportno,`event_date`='$event_date',`destination`='$destination',`contact_number_1`=$ucnt1,`contact_number_2`=$ucnt2,`amount_received`=$amnt_recv,`amount_pending`=$amnt_pending,`any_mgm_side`='$mgm_side',`any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark',`assign_to`=$tourist_assign WHERE `tourist_id`=".$tt_id;
            
            $edit_touristf_query = $conn->query($edit_touristf_sql);
              

      if($edit_touristf_query)
          {
                $msg = "<div class='alert alert-success' style='padding:10px;'>Tourist visa form update successfully</div>";
                $json_array = array("status"=>"success", "message"=>$msg);
                echo json_encode($json_array);
                exit();
          }
          else
            {
                $msg = "<div class='alert alert-danger' style='padding:10px;'>Tourist visa not update, try again later</div>";
                $json_array = array("status"=>"failed", "message"=>$msg);
                echo json_encode($json_array);
                exit();
            }
          }
          else
          {
                $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
                $json_array = array("status"=>"failed","message"=>$msg);
                echo json_encode($json_array);
                exit();
          }
  }



  /* Add Study Visa form */
  if(getPost('action') == "add_study_visa_form"){
        
        $validator = new validations();
        $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
        $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
        $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
        $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
        $validator->add_rule("cnt1","Contact number 1","numeric|max_length[10]");
        $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

        $validator->add_rule("qualif","Add Last Qualification","required");
        $validator->add_rule("exam_board","Add Examination Board (eg. CBSC,PSEB etc.) ","required");
        $validator->add_rule("study_subj","Add Study Subject","required");
        $validator->add_rule("pass_year","Add Your Passing Year","required");
        $validator->add_rule("pass_percent","Add Pass Percent","required");
        $validator->add_rule("total_gap","Add Total Study Gap","numeric|required|max_length[100]");
        $validator->add_rule("gap_experience","Add Gap Any Job/Work Experience","numeric|required|max_length[100]");
        
        $validator->add_rule("amnt_recv","Amount Received","numeric");
        $validator->add_rule("amnt_pend","Amount Pending","numeric");
        
        $error = $validator->run();

        if(trim($error) == ''){
          $counselor_name = getPost('counselor_name');
          $no_applicant = getNPost('no_applicant');
          
          $applicant_name = getPost('main_applicant_name');
          $applicant_dob = date("Y-m-d G-i-s");
          $applicant_passportno = getNPost('passport_no');
          //$event_date = date("Y-m-d G-i-s");

          $destination = getPost('styled_destin');
          $ucnt1 = getNPost('cnt1');
          $ucnt2 = getNPost('cnt2');
          $amnt_recv = getNPost('amnt_recv');
          $amnt_pending = getNPost('amnt_pend');
          
          $qualification = getPost('qualif');
          $exam_board = getPost('exam_board');
          $study_subj = getPost('study_subj');
          $passing_year = getPost('pass_year');
          $study_percent = getPost('pass_percent');
          $total_gap = getPost('total_gap');
          $gap_experience = getPost('gap_experience');
          
          
          $mgm_side = getPost('mgm_side');
          $any_refusal = getPost('any_refusal');
          $travel_history = getPost('travel_history');
          $govt_servant = getPost('govt_servant');
          $any_remark = getPost('any_remark');
          
          //$visitor_assign = getNPost('assign_to');
          

          $add_visitor_form_sql = "INSERT INTO `study_visa` (`counselor_name`, `no_of_applicant`, `main_applicant`, `date_of_birth` , `passport_no`, `destination`, `contact_number_1`, `contact_number_2`,`qualification`,`board_of_exam`, `study_subject`, `passing_year`, `pass_percent`,`total_study_gap`,`gap_experience`,`amount_received`, `amount_pending`, `any_mgm_side`, `any_refusal`, `any_travel_history`, `any_govt_servant`, `any_remarks`,`created_by`) VALUES ('$counselor_name', $no_applicant, '$applicant_name', '$applicant_dob', $applicant_passportno, '$destination' , $ucnt1, $ucnt2, '$qualification', '$exam_board', '$study_subj', 
          '$passing_year',$study_percent, $total_gap, $gap_experience,$amnt_recv, $amnt_pending, '$mgm_side', '$any_refusal', '$travel_history', '$govt_servant', '$any_remark', $logged_user_id)";
        
            $add_visitor_query = $conn->query($add_visitor_form_sql);
              

           if($add_visitor_query){
              $msg = "<div class='alert alert-success' style='padding:10px;'>Study Visa Form Successfully Submitted</div>";
              $json_array = array("status"=>"success", "message"=>$msg);
              echo json_encode($json_array);
              exit();              
            }
            else{
              $msg = "<div class='alert alert-warning' style='padding:10px;'> Study Visa Form Not Submitted OR Duplicate Entry ! </div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
            }
        }
        else
        {
          $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
          $json_array = array("status"=>"failed", "message"=>$msg);
          echo json_encode($json_array);
          exit();
        }

  }


  /* Edit Study Visa form */
  if(getPost('action') == "edit_study_visa_form")
      {

          
          $validator = new validations();
        
          $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
          $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
          $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
          $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
          $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
          $validator->add_rule("cnt1","Contact number 1","numeric|max_length[10]");
          $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

          $validator->add_rule("qualif","Add Destination","required");
          $validator->add_rule("exam_board","Add Destination","required");
          $validator->add_rule("study_subj","Add Destination","required");
          $validator->add_rule("pass_year","Add Destination","required|max_length[100]");
          $validator->add_rule("pass_percent","Add Destination","required|max_length[100]");
          $validator->add_rule("total_gap","Add Destination","numeric|required|max_length[100]");
          $validator->add_rule("gap_experience","Add Destination","numeric|required|max_length[100]");
          
          $validator->add_rule("amnt_recv","Amount Received","numeric");
          $validator->add_rule("amnt_pend","Amount Pending","numeric");
          

          $error = $validator->run();

          if(trim($error) == '')
          {
              $s_id = getNPost('study_id');
              $counselor_name = getPost('counselor_name');
              $no_applicant = getNPost('no_applicant');
              
              $applicant_name = getPost('main_applicant_name');
              $applicant_dob = date("Y-m-d G-i-s");
              $applicant_passportno = getNPost('passport_no');
              //$event_date = date("Y-m-d G-i-s");

              $destination = getPost('styled_destin');
              $ucnt1 = getNPost('cnt1');
              $ucnt2 = getNPost('cnt2');
              $amnt_recv = getNPost('amnt_recv');
              $amnt_pending = getNPost('amnt_pend');
              
              $qualification = getPost('qualif');
              $exam_board = getPost('exam_board');
              $study_subj = getPost('study_subj');
              $passing_year = getPost('pass_year');
              $study_percent = getPost('pass_percent');
              $total_gap = getPost('total_gap');
              $gap_experience = getPost('gap_experience');
              
              
              $mgm_side = getPost('mgm_side');
              $any_refusal = getPost('any_refusal');
              $travel_history = getPost('travel_history');
              $govt_servant = getPost('govt_servant');
              $any_remark = getPost('any_remark');


                /*
                $edit_studyf_sql = "UPDATE `study_visa` SET 
                                          `counselor_name`='$counselor_name',
                                          `no_of_applicant`= $no_applicant,
                                          `main_applicant`='$applicant_name',
                                          `date_of_birth`='$applicant_dob',
                                          `passport_no`=$applicant_passportno,
                                          `event_date`='$event_date',
                                          `destination`='$destination',
                                          `contact_number_1`=$ucnt1,
                                          `contact_number_2`=$ucnt2,
                                          `qualif` = '$qualification',
                                          `exam_board` = '$exam_board',
                                          `study_subj` = '$study_subj',
                                          `pass_year` = $passing_year 
                                          $study_percent = getPost('pass_percent');
                                          $total_gap = getPost('total_gap');
                                          $gap_experience = getPost('gap_experience');
                                                                      
                                          `amount_received`=$amnt_recv,`amount_pending`=$amnt_pending,`any_mgm_side`='$mgm_side',`any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark',`assign_to`= $study_assign WHERE `study_visa`.`study_id` =".$s_id;
              */

              
              $edit_studyf_sql = "UPDATE `study_visa` SET 
                                          `counselor_name`='$counselor_name',
                                          `no_of_applicant`= $no_applicant,
                                          `main_applicant`='$applicant_name',
                                          `date_of_birth`='$applicant_dob',
                                          `passport_no`=$applicant_passportno,
                                          `event_date`='$event_date',
                                          `destination`='$destination',
                                          `contact_number_1`=$ucnt1,
                                          `contact_number_2`=$ucnt2,
                                                                      
                                          `amount_received`=$amnt_recv,`amount_pending`=$amnt_pending,`any_mgm_side`='$mgm_side',`any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark' WHERE `study_visa`.`study_id` =".$s_id;
              
              $edit_studyf_query = $conn->query($edit_studyf_sql);
                
              
              if($edit_studyf_query)
              {
                  $msg = "<div class='alert alert-success' style='padding:10px;'>Updated Study Form Successfully</div>";
                  $json_array = array("status"=>"success", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
              else
              {
                  $msg = "<div class='alert alert-danger' style='padding:10px;'>Failed to Update, try again later</div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
          }
          else
          {
              $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed","message"=>$msg);
              echo json_encode($json_array);
              exit();
          }
      }


  /* Delete Study Visa form */   
   
      if(getPost('action') == "study_visa_del"){
        
        $s_id = getNPost('study_id');

        $active_study_sql = "UPDATE `study_visa` SET `action` = 0 WHERE `study_id` =".$s_id;
        $active_study_query = $conn->query($active_study_sql);

        if($active_study_query){
          $msg = "<div class='alert alert-success'> User Deactivate Successfully Updated </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();

        }else{
          $msg = "<div class='alert alert-success'> User Deactivate  Not Updated </div>";
          $json_array = array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
      }    




/* Add Work Visa form */
  if(getPost('action') == "add_work_visa_form"){
         
        $validator = new validations();
        $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
        $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
        $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
        $validator->add_rule("cnt1","Contact number 1","numeric|max_length[10]");
        $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

        $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
        $validator->add_rule("amnt_recv","Amount Received","numeric");
        $validator->add_rule("amnt_pend","Amount Pending","numeric");
        $validator->add_rule("assign_to","Form assign to","required");

        $error = $validator->run();

        
        if(trim($error) == ''){
          $counselor_name = getPost('counselor_name');
          $no_applicant = getNPost('no_applicant');
          
          $applicant_name = getPost('main_applicant_name');
          $applicant_dob = date("Y-m-d G-i-s");
          $applicant_passportno = getNPost('passport_no');
          $event_date = date("Y-m-d G-i-s");

          $destination = getPost('styled_destin');
          $ucnt1 = getNPost('cnt1');
          $ucnt2 = getNPost('cnt2');
          $amnt_recv = getNPost('amnt_recv');
          $amnt_pending = getNPost('amnt_pend');
          
          $mgm_side = getPost('mgm_side');
          $any_refusal = getPost('any_refusal');
          $travel_history = getPost('travel_history');
          $govt_servant = getPost('govt_servant');
          $any_remark = getPost('any_remark');
          
          $work_assign = getNPost('assign_to');
          

          $add_work_form_sql = "INSERT INTO `work_form` (`counselor_name`, `no_of_applicant`, `main_applicant`, `date_of_birth` , `passport_no`, `event_date`, `destination`, `contact_number_1`, `contact_number_2`, `amount_received`, `amount_pending`, `any_mgm_side`, `any_refusal`, `any_travel_history`, `any_govt_servant`, `any_remarks`, `assign_to`) VALUES ('$counselor_name', $no_applicant, '$applicant_name', '$applicant_dob', $applicant_passportno, '$event_date', '$destination' , $ucnt1, $ucnt2, $amnt_recv, $amnt_pending, '$mgm_side', '$any_refusal', '$travel_history', '$govt_servant', '$any_remark', $work_assign)";
        
            $add_work_query = $conn->query($add_work_form_sql);

             
            if($add_work_query){
              $msg = "<div class='alert alert-success' style='padding:10px;'>Study Visa Form Successfully Submitted</div>";
              $json_array = array("status"=>"success", "message"=>$msg);
              echo json_encode($json_array);
              exit();              
            }
            else{
              $msg = "<div class='alert alert-warning' style='padding:10px;'> Study Visa Form Not Submitted OR Duplicate Entry ! </div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
            }
        }
        else
        {
          $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
          $json_array = array("status"=>"failed", "message"=>$msg);
          echo json_encode($json_array);
          exit();
        }

  }


  /* Edit Work Visa form */
  if(getPost('action') == "edit_work_visa_form")
      {

          
          $validator = new validations();
        
          $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
          $validator->add_rule("no_applicant"," Add User Name","required|numeric|max_length[15]");
          $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[100]");
          $validator->add_rule("passport_no","User Passport number","numeric|max_length[7]");

          $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
          
          $validator->add_rule("cnt1","User Contact number 1","required|numeric|max_length[10]");
          $validator->add_rule("cnt2","User Contact number 2","numeric|max_length[10]");
          $validator->add_rule("amnt_recv","Amount Receive?","numeric|max_length[15]");
          $validator->add_rule("amnt_pend","Amount Pending?","numeric|max_length[15]");
          
          $validator->add_rule("assign_to","Form Enquiry Assign to","required");
          

          $error = $validator->run();

          if(trim($error) == '')
          {
              $w_id = getNPost('work_id');
              $counselor_name = getPost('counselor_name');
              $no_applicant = getNPost('no_applicant');
              
              $applicant_name = getPost('main_applicant_name');
              $applicant_dob = date("Y-m-d G-i-s");
              $applicant_passportno = getNPost('passport_no');
              $event_date = date("Y-m-d G-i-s");

              $destination = getPost('styled_destin');
              $ucnt1 = getNPost('cnt1');
              $ucnt2 = getNPost('cnt2');
              $amnt_recv = getNPost('amnt_recv');
              $amnt_pending = getNPost('amnt_pend');
              
              $mgm_side = getPost('mgm_side');
              $any_refusal = getPost('any_refusal');
              $travel_history = getPost('travel_history');
              $govt_servant = getPost('govt_servant');
              $any_remark = getPost('any_remark');
              
              $work_assign = getNPost('assign_to');


              
              $edit_workf_sql = "UPDATE `work_form` SET `counselor_name`='$counselor_name',`no_of_applicant`= $no_applicant,`main_applicant`='$applicant_name',`date_of_birth`='$applicant_dob',`passport_no`=$applicant_passportno,`event_date`='$event_date',`destination`='$destination',`contact_number_1`=$ucnt1,`contact_number_2`=$ucnt2,`amount_received`=$amnt_recv,`amount_pending`=$amnt_pending,`any_mgm_side`='$mgm_side',`any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark',`assign_to`= $work_assign WHERE `work_form`.`work_id` =".$w_id;
              
              $edit_workf_query = $conn->query($edit_workf_sql);
                
              
              if($edit_workf_query)
              {
                  $msg = "<div class='alert alert-success' style='padding:10px;'>Updated Study Form Successfully</div>";
                  $json_array = array("status"=>"success", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
              else
              {
                  $msg = "<div class='alert alert-danger' style='padding:10px;'>Failed to Update, try again later</div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
          }
          else
          {
              $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed","message"=>$msg);
              echo json_encode($json_array);
              exit();
          }
      }


      /* Delete Work Visa form */   
   
      if(getPost('action') == "work_visa_del"){
        
        $w_id = getNPost('work_id');

        $active_work_sql = "UPDATE `work_form` SET `action` = 0 WHERE `work_id` =".$w_id;
        $active_work_query = $conn->query($active_work_sql);

        if($active_work_query){
          $msg = "<div class='alert alert-success'> Work Visa Form Deleted Successfully </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();

        }else{
          $msg = "<div class='alert alert-success'> Work Visa Form Not Delete ! </div>";
          $json_array = array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
      }




      /* Add Business Visa form */
  if(getPost('action') == "add_bus_visa_form"){
         
        $validator = new validations();
        $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
        $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
        $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
        $validator->add_rule("cnt1","Contact number 1","numeric|max_length[10]");
        $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

        $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
        $validator->add_rule("amnt_recv","Amount Received","numeric");
        $validator->add_rule("amnt_pend","Amount Pending","numeric");
        $validator->add_rule("assign_to","Form assign to","required");

        $error = $validator->run();

        
        if(trim($error) == ''){
          $counselor_name = getPost('counselor_name');
          $no_applicant = getNPost('no_applicant');
          
          $applicant_name = getPost('main_applicant_name');
          $applicant_dob = date("Y-m-d G-i-s");
          $applicant_passportno = getNPost('passport_no');
          $event_date = date("Y-m-d G-i-s");

          $destination = getPost('styled_destin');
          $ucnt1 = getNPost('cnt1');
          $ucnt2 = getNPost('cnt2');
          $amnt_recv = getNPost('amnt_recv');
          $amnt_pending = getNPost('amnt_pend');
          
          $mgm_side = getPost('mgm_side');
          $any_refusal = getPost('any_refusal');
          $travel_history = getPost('travel_history');
          $govt_servant = getPost('govt_servant');
          $any_remark = getPost('any_remark');
          
          $bus_assign = getNPost('assign_to');
          

          $add_bus_form_sql = "INSERT INTO `business_form` (`counselor_name`, `no_of_applicant`, `main_applicant`, `date_of_birth` , `passport_no`, `event_date`, `destination`, `contact_number_1`, `contact_number_2`, `amount_received`, `amount_pending`, `any_mgm_side`, `any_refusal`, `any_travel_history`, `any_govt_servant`, `any_remarks`, `assign_to`) VALUES ('$counselor_name', $no_applicant, '$applicant_name', '$applicant_dob', $applicant_passportno, '$event_date', '$destination' , $ucnt1, $ucnt2, $amnt_recv, $amnt_pending, '$mgm_side', '$any_refusal', '$travel_history', '$govt_servant', '$any_remark', $bus_assign)";
        
            $add_bus_query = $conn->query($add_bus_form_sql);

             
            if($add_bus_query){
              $msg = "<div class='alert alert-success' style='padding:10px;'>Business Visa Form Successfully Submitted</div>";
              $json_array = array("status"=>"success", "message"=>$msg);
              echo json_encode($json_array);
              exit();              
            }
            else{
              $msg = "<div class='alert alert-warning' style='padding:10px;'> Business Visa Form Not Submitted OR Duplicate Entry ! </div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
            }
        }
        else
        {
          $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
          $json_array = array("status"=>"failed", "message"=>$msg);
          echo json_encode($json_array);
          exit();
        }

  }



  /* Edit Business Visa form */
  if(getPost('action') == "edit_bus_visa_form")
      {

          
          $validator = new validations();
        
          $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
          $validator->add_rule("no_applicant"," Add User Name","required|numeric|max_length[15]");
          $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[100]");
          $validator->add_rule("passport_no","User Passport number","numeric|max_length[7]");

          $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
          
          $validator->add_rule("cnt1","User Contact number 1","required|numeric|max_length[10]");
          $validator->add_rule("cnt2","User Contact number 2","numeric|max_length[10]");
          $validator->add_rule("amnt_recv","Amount Receive?","numeric|max_length[15]");
          $validator->add_rule("amnt_pend","Amount Pending?","numeric|max_length[15]");
          
          $validator->add_rule("assign_to","Form Enquiry Assign to","required");
          

          $error = $validator->run();

          if(trim($error) == '')
          {
              $bus_id = getNPost('business_id');
              $counselor_name = getPost('counselor_name');
              $no_applicant = getNPost('no_applicant');
              
              $applicant_name = getPost('main_applicant_name');
              $applicant_dob = date("Y-m-d G-i-s");
              $applicant_passportno = getNPost('passport_no');
              $event_date = date("Y-m-d G-i-s");

              $destination = getPost('styled_destin');
              $ucnt1 = getNPost('cnt1');
              $ucnt2 = getNPost('cnt2');
              $amnt_recv = getNPost('amnt_recv');
              $amnt_pending = getNPost('amnt_pend');
              
              $mgm_side = getPost('mgm_side');
              $any_refusal = getPost('any_refusal');
              $travel_history = getPost('travel_history');
              $govt_servant = getPost('govt_servant');
              $any_remark = getPost('any_remark');
              
              $bus_assign = getNPost('assign_to');


              
              $edit_businessf_sql = "UPDATE `business_form` SET `counselor_name`='$counselor_name',`no_of_applicant`= $no_applicant,`main_applicant`='$applicant_name',`date_of_birth`='$applicant_dob',`passport_no`=$applicant_passportno,`event_date`='$event_date',`destination`='$destination',`contact_number_1`=$ucnt1,`contact_number_2`=$ucnt2,`amount_received`=$amnt_recv,`amount_pending`=$amnt_pending,`any_mgm_side`='$mgm_side',`any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark',`assign_to`= $bus_assign WHERE `business_form`.`business_id` =".$bus_id;
              
              $edit_businessf_query = $conn->query($edit_businessf_sql);
                
              
              if($edit_businessf_query)
              {
                  $msg = "<div class='alert alert-success' style='padding:10px;'>Updated Study Form Successfully</div>";
                  $json_array = array("status"=>"success", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
              else
              {
                  $msg = "<div class='alert alert-danger' style='padding:10px;'>Failed to Update, try again later</div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
          }
          else
          {
              $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed","message"=>$msg);
              echo json_encode($json_array);
              exit();
          }
      }


      /* Delete Work Visa form */   
   
      if(getPost('action') == "bus_visa_del"){
        
        $bus_id = getNPost('business_id');

        $active_bus_sql = "UPDATE `business_form` SET `action` = 0 WHERE `business_id` =".$bus_id;
        $active_bus_query = $conn->query($active_bus_sql);

        if($active_bus_query){
          $msg = "<div class='alert alert-success'> Business Visa Form Deleted Successfully </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();

        }else{
          $msg = "<div class='alert alert-success'> Business Visa Form Not Delete ! </div>";
          $json_array = array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
      }





  /* Add Family Visa form */
  if(getPost('action') == "add_family_visa_form"){
         
        $validator = new validations();
        $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
        $validator->add_rule("no_applicant","total no. of applicants","required|numeric|max_length[100]");
        $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[15]");
        $validator->add_rule("passport_no","User Passport number","required|max_length[7]");
        $validator->add_rule("cnt1","Contact number 1","required|numeric|max_length[10]");
        $validator->add_rule("cnt2","Contact number 2","numeric|max_length[10]");

        $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
        $validator->add_rule("amnt_recv","Amount Received","numeric");
        $validator->add_rule("amnt_pend","Amount Pending","numeric");
        $validator->add_rule("assign_to","Form assign to","required");

        $error = $validator->run();

        
        if(trim($error) == ''){
          $counselor_name = getPost('counselor_name');
          $no_applicant = getNPost('no_applicant');
          
          $applicant_name = getPost('main_applicant_name');
          $applicant_dob = date("Y-m-d G-i-s");
          $applicant_passportno = getNPost('passport_no');
          $event_date = date("Y-m-d G-i-s");

          $destination = getPost('styled_destin');
          $ucnt1 = getNPost('cnt1');
          $ucnt2 = getNPost('cnt2');
          $amnt_recv = getNPost('amnt_recv');
          $amnt_pending = getNPost('amnt_pend');
          
          $mgm_side = getPost('mgm_side');
          $any_refusal = getPost('any_refusal');
          $travel_history = getPost('travel_history');
          $govt_servant = getPost('govt_servant');
          $any_remark = getPost('any_remark');
          
          $fmy_assign = getNPost('assign_to');
          

          $add_fmy_form_sql = "INSERT INTO `family_form` (`counselor_name`, `no_of_applicant`, `main_applicant`, `date_of_birth` , `passport_no`, `event_date`, `destination`, `contact_number_1`, `contact_number_2`, `amount_received`, `amount_pending`, `any_mgm_side`, `any_refusal`, `any_travel_history`, `any_govt_servant`, `any_remarks`, `assign_to`) VALUES ('$counselor_name', $no_applicant, '$applicant_name', '$applicant_dob', $applicant_passportno, '$event_date', '$destination' , $ucnt1, $ucnt2, $amnt_recv, $amnt_pending, '$mgm_side', '$any_refusal', '$travel_history', '$govt_servant', '$any_remark', $fmy_assign)";
        
            $add_fmy_query = $conn->query($add_fmy_form_sql);

            
            
            if($add_fmy_query){
              $msg = "<div class='alert alert-success' style='padding:10px;'>Family Visa Form Successfully Submitted</div>";
              $json_array = array("status"=>"success", "message"=>$msg);
              echo json_encode($json_array);
              exit();              
            }
            else{
              $msg = "<div class='alert alert-warning' style='padding:10px;'> Family Visa Form Not Submitted OR Duplicate Entry ! </div>";
              $json_array = array("status"=>"failed", "message"=>$msg);
              echo json_encode($json_array);
              exit();
            }
        }
        else
        {
          $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
          $json_array = array("status"=>"failed", "message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
    }


    /* Edit Family Visa form */
  if(getPost('action') == "edit_family_visa_form")
      {

          
          $validator = new validations();
        
          $validator->add_rule("counselor_name","Add Full Name","required|max_length[100]");
          $validator->add_rule("no_applicant"," Add User Name","required|numeric|max_length[15]");
          $validator->add_rule("main_applicant_name","Main Applicant Name ","required|max_length[100]");
          $validator->add_rule("passport_no","User Passport number","numeric|max_length[7]");

          $validator->add_rule("styled_destin","Add Destination","required|max_length[100]");
          
          $validator->add_rule("cnt1","User Contact number 1","required|numeric|max_length[10]");
          $validator->add_rule("cnt2","User Contact number 2","numeric|max_length[10]");
          $validator->add_rule("amnt_recv","Amount Receive?","numeric|max_length[15]");
          $validator->add_rule("amnt_pend","Amount Pending?","numeric|max_length[15]");
          
          $validator->add_rule("assign_to","Form Enquiry Assign to","required");
          

          $error = $validator->run();

          if(trim($error) == '')
          {
              $fmy_id = getNPost('family_id');
              $counselor_name = getPost('counselor_name');
              $no_applicant = getNPost('no_applicant');
              
              $applicant_name = getPost('main_applicant_name');
              $applicant_dob = date("Y-m-d G-i-s");
              $applicant_passportno = getNPost('passport_no');
              $event_date = date("Y-m-d G-i-s");

              $destination = getPost('styled_destin');
              $ucnt1 = getNPost('cnt1');
              $ucnt2 = getNPost('cnt2');
              $amnt_recv = getNPost('amnt_recv');
              $amnt_pending = getNPost('amnt_pend');
              
              $mgm_side = getPost('mgm_side');
              $any_refusal = getPost('any_refusal');
              $travel_history = getPost('travel_history');
              $govt_servant = getPost('govt_servant');
              $any_remark = getPost('any_remark');
              
              $fmy_assign = getNPost('assign_to');


              
              $edit_familyf_sql = "UPDATE `family_form` SET `counselor_name`='$counselor_name',`no_of_applicant`= $no_applicant,`main_applicant`='$applicant_name',`date_of_birth`='$applicant_dob',`passport_no`=$applicant_passportno,`event_date`='$event_date',`destination`='$destination',`contact_number_1`=$ucnt1,`contact_number_2`=$ucnt2,`amount_received`=$amnt_recv,`amount_pending`=$amnt_pending,`any_mgm_side`='$mgm_side',`any_refusal`='$any_refusal',`any_travel_history`= '$travel_history',`any_govt_servant`='$govt_servant',`any_remarks`='$any_remark',`assign_to`= $fmy_assign WHERE `family_form`.`family_id` =".$fmy_id;
              
              $edit_familyf_query = $conn->query($edit_familyf_sql);
                
              
              if($edit_familyf_query)
              {
                  $msg = "<div class='alert alert-success' style='padding:10px;'>Updated Study Form Successfully</div>";
                  $json_array = array("status"=>"success", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
              else
              {
                  $msg = "<div class='alert alert-danger' style='padding:10px;'>Failed to Update, try again later</div>";
                  $json_array = array("status"=>"failed", "message"=>$msg);
                  echo json_encode($json_array);
                  exit();
              }
          }
          else
          {
              $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
              $json_array = array("status"=>"failed","message"=>$msg);
              echo json_encode($json_array);
              exit();
          }
      }


      /* Delete Family Visa form */   
   
      if(getPost('action') == "family_visa_del"){
        
        $fmy_id = getNPost('family_id');

        $active_bus_sql = "UPDATE `family_form` SET `action` = 0 WHERE `family_id` =".$fmy_id;
        $active_bus_query = $conn->query($active_bus_sql);

        if($active_bus_query){
          $msg = "<div class='alert alert-success'> Business Visa Form Deleted Successfully </div>";
          $json_array= array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();

        }else{
          $msg = "<div class='alert alert-success'> Business Visa Form Not Delete ! </div>";
          $json_array = array("status"=>"success","message"=>$msg);
          echo json_encode($json_array);
          exit();
        }
      }

      
    
    
     // ---------------------------------- //
  // ADD PTE Form  //
  
  if(getPost('action') == "add_form_pte")
       		{
   			
	   			$validator = new validations();
		        $validator->add_rule("counselor_name","Add Counselor Name","required|max_length[250]");
		        $validator->add_rule("main_applicant_name"," Add Applicant Name","required|max_length[250]");
		        $validator->add_rule("cnt1","User First Contact number ","required|numeric|max_length[10]");
		        $validator->add_rule("cnt2","User Alternate Contact number","numeric|max_length[10]");
                //$validator->add_rule("why_join","Select Why Join Us?","required|max_length[100]");
                
                $validator->add_rule("last_admission_date","Last Admission Date","required|max_length[100]");
		        $validator->add_rule("email_addrs","Enter Email Address","required|max_length[100]");
		        $validator->add_rule("full_addrs","Enter Full Parmanent Address","required");
		        $validator->add_rule("academy_name","Enter Academy Name","required");
                
                $validator->add_rule("last_exam_det","Enter Your Last Exam Date","required");
                $validator->add_rule("last_ielts_score","Enter Your Previous IELTS Score","required");
                $validator->add_rule("amnt_recv","Enter Academy Name","required");
                $validator->add_rule("amnt_pend","Enter Academy Name","required");
                
		        $error = $validator->run();

		        	if(trim($error) == ''){
			          $pte_uname = getPost('counselor_name');
			          $pte_applicant_name = getPost('main_applicant_name');
			          $pte_ucnt1 =    getNPost('cnt1');
			          $pte_ucnt2 =    getNPost('cnt2');
                      $pte_email = getPost('email_addrs');
                      $pte_addrs = getPost('full_addrs');
                      
                      $pte_apply_training = getNPost('why_join1');
                      $pte_apply_exam = getNPost('why_join2');
                          
			          $pte_last_academy = getPost('academy_name');
			          $pte_last_admission_date = getPost("last_admission_date");
                      $pte_last_exam_date = getPost("last_exam_det");
                      
                      $pte_tband = getNPost("last_ielts_score");
                      $pte_amount_received = getNPost("amnt_recv");
                      $pte_amount_pending = getNPost("amnt_pend");
                      
                      
                      $pte_assign = getNPost('assign_to');
			          
			          $add_rform_sql = "INSERT INTO `pte_exam` (`counselor_name`, `applicant_name`, `contact_number_1`,";
						if($pte_ucnt2 != 0)
						{
							$add_rform_sql .= "`contact_number_2`, ";
						}
						$add_rform_sql .= "`email_address`, `full_address`, `apply_for_training`, `apply_for_exam` , `academy_name`,`admission_date`,`exam_date`,`total_band`,`amount_received`,`amount_pending`,`assign_to`,`created_by`) VALUES ('$pte_uname','$pte_applicant_name',$pte_ucnt1, ";
						if($pte_ucnt2 != 0)
		             	{
			               $add_rform_sql .= "$pte_ucnt2, ";
		             	}

		             	$add_rform_sql  .= "'$pte_email', 
                                            '$pte_addrs',  
                                            $pte_apply_training, 
                                            $pte_apply_exam, 
                                            '$pte_last_academy', 
                                            '$pte_last_admission_date', 
                                            '$pte_last_exam_date', 
                                            $pte_tband, 
                                            $pte_amount_received,
                                            $pte_amount_pending,
                                            $pte_assign,
                                            $logged_user_id);";

			            $add_rform_query = $conn->query($add_rform_sql);

			            if($add_rform_query){
			              $msg = "<div class='alert alert-success' style='padding:10px;'>Reception Form Successfully Submitted</div>";
			              $json_array = array("status"=>"success", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();              
			            }
			            else{
			              $msg = "<div class='alert alert-warning' style='padding:10px;'> Reception Form Not Submitted </div>";
			              $json_array = array("status"=>"failed", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();
			            }
			        }
			        else
			        {
			            $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
			              $json_array = array("status"=>"failed", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();
			        }
       		
	}  
    
    
    
    
        // ---------------------------------- //
  // ADD PTE Form  //
  
  if(getPost('action') == "edit_form_pte")
       		{
   			
	   			$validator = new validations();
		        $validator->add_rule("counselor_name","Add Counselor Name","required|max_length[250]");
		        $validator->add_rule("main_applicant_name"," Add Applicant Name","required|max_length[250]");
		        $validator->add_rule("cnt1","User First Contact number ","required|numeric|max_length[10]");
		        $validator->add_rule("cnt2","User Alternate Contact number","numeric|max_length[10]");
                //$validator->add_rule("why_join","Select Why Join Us?","required|max_length[100]");
                
                $validator->add_rule("last_admission_date","Last Admission Date","required|max_length[100]");
		        $validator->add_rule("email_addrs","Enter Email Address","required|max_length[100]");
		        $validator->add_rule("full_addrs","Enter Full Parmanent Address","required");
		        $validator->add_rule("academy_name","Enter Academy Name","required");
                
                $validator->add_rule("last_exam_det","Enter Your Last Exam Date","required");
                $validator->add_rule("last_ielts_score","Enter Your Previous IELTS Score","required");
                $validator->add_rule("amnt_recv","Enter Academy Name","required");
                $validator->add_rule("amnt_pend","Enter Academy Name","required");
                
		        $error = $validator->run();

		        	if(trim($error) == ''){
			          $pte_uname = getPost('counselor_name');
			          $pte_applicant_name = getPost('main_applicant_name');
			          $pte_ucnt1 =    getNPost('cnt1');
			          $pte_ucnt2 =    getNPost('cnt2');
                      $pte_email = getPost('email_addrs');
                      $pte_addrs = getPost('full_addrs');
                      
                      $pte_apply_training = getNPost('why_join1');
                      $pte_apply_exam = getNPost('why_join2');
                          
			          $pte_last_academy = getPost('academy_name');
			          $pte_last_admission_date = getPost("last_admission_date");
                      $pte_last_exam_date = getPost("last_exam_det");
                      
                      $pte_tband = getNPost("last_ielts_score");
                      $pte_amount_received = getNPost("amnt_recv");
                      $pte_amount_pending = getNPost("amnt_pend");
                      $message_feedback = getPost("staff_reply");
                      $created_by = getNPost("created_by");
                      $pte_assign = getNPost('assign_to');
			          
			          $edit_rform_sql = "UPDATE `pte_exam` SET (`counselor_name`='$pte_uname' , 
                                                                `applicant_name`='$pte_applicant_name', 
                                                                `contact_number_1`=$pte_ucnt1,
                                                                `contact_number_2` =$pte_ucnt2,
                                                                `email_address`= $pte_email,
                                                                `full_address`= $pte_addrs,
                                                                `apply_for_training`= $pte_apply_training,
                                                                `apply_for_exam`=$pte_apply_exam,
                                                                `academy_name`=$pte_last_academy,
                                                                `admission_date`=$pte_last_admission_date,
                                                                `exam_date`=$pte_last_exam_date,
                                                                `total_band`=$pte_tband,
                                                                `amount_received`=$pte_amount_received,
                                                                `amount_pending`=$pte_amount_pending,
                                                                `message`= '$message_feedback'";
						
			            $edit_rform_query = $conn->query($edit_rform_sql);
                        
                          $msg = $edit_rform_sql;
			              $json_array = array("status"=>"success", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();    
                            
                            
			            if($edit_rform_query){
			              $msg = "<div class='alert alert-success' style='padding:10px;'>Reception Form Successfully Submitted</div>";
			              $json_array = array("status"=>"success", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();              
			            }
			            else{
			              $msg = "<div class='alert alert-warning' style='padding:10px;'> Reception Form Not Submitted </div>";
			              $json_array = array("status"=>"failed", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();
			            }
			        }
			        else
			        {
			            $msg = "<div class='alert alert-danger' style='padding:10px;'>".$error."</div>";
			              $json_array = array("status"=>"failed", "message"=>$msg);
			              echo json_encode($json_array);
			              exit();
			        }
       	
	}  
  ?>