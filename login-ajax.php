<?php
	require_once('libs/class.validations.php');
    require_once('libs/string_func.php');
    require_once('connection.php');

  	if(getPost('action') == "chk_login_form"){

        $validator = new validations();
        $validator->add_rule("user_logname","Username","required|max_length[100]");
        $validator->add_rule("user_pw","Password","required|max_length[100]");
        $error = $validator->run();

       
        	$log_username = getPost('user_logname');
          	$log_password = getPost('user_pw');

        	$login_sql = "SELECT `user_id`, `action`, `account_type` FROM users WHERE `username` = '$log_username' && `password` = '$log_password'";
        	$login_query = $conn->query($login_sql);
        	
        	if ($login_query)
        	{
        		if ($login_query->num_rows > 0)
        		{
        			$login_result = $login_query-> fetch_assoc();
        			$user_id = $login_result['user_id'];
        			$user_acc_type = $login_result['account_type'];
        			$user_action = $login_result['action'];
        			
        			
        			if($user_action == 1)
    				{
    					saveSession('log_userid',$user_id);
                    	saveSession('log_username',$log_username);
                    	saveSession('log_usertype',$user_acc_type);
    					
    					$msg = "<div class='alert alert-success' style='padding:10px;'>Logged in successfully</div>";
						$json_array = array("status"=>"success", "message"=>$msg);
						echo json_encode($json_array);
						exit();	
    				}
    				else
					{
						$msg = "<div class='alert alert-danger' style='padding:10px;'>Your account has been suspended.</div>";
						$json_array = array("status"=>"failed", "message"=>$msg);
						echo json_encode($json_array);
						exit();
					}
        		}
        		else
    			{
    				$msg = "<div class='alert alert-danger' style='padding:10px;'>Invalid username or password.</div>";
					$json_array = array("status"=>"failed", "message"=>$msg);
					echo json_encode($json_array);
					exit();
    			}
        	}
        	else
    		{
				$msg = "<div class='alert alert-danger' style='padding:10px;'>Some error occurred, try again later.</div>";
				$json_array = array("status"=>"failed", "message"=>$msg);
				echo json_encode($json_array);
				exit();
    		}
        
	}
?>