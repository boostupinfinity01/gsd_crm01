<?php

class validations{
    
    var $_email_pattern             = "/^([a-z]+)([\.a-z\d_\-]+)*@([a-z\d\-]+)\.([a-z]{2,20})(\.([a-z]{2,6}))?$/i";
    var $_username_pattern          = "/^([a-z]+)([a-z\-\._]+)$/";
    var $_password_pattern          = "/(?=.*[a-z]+)(?=.*[A-Z]+)(?=.*[0-9]+)(?=.*[\(\)~!@#$%\^&\*\.\-_]+)/";
    var $_alpha_numeric_pattern     = "/^([a-z]+)([a-zA-Z\d]+)*$/"; 
    var $_onlyalpha_pattern         = "/^([a-zA-Z]+)$/";
    var $_numeric_pattern           = "/^([\d]+)$/";
    var $_ip_pattern                = "/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/";
    var $_url_pattern               = "/^((http[s]?)(:\/\/))?([a-z]*[\.]?)([a-z0-9]*)\.([a-z]+)([\/]?)([a-z0-9A-Z\/%-_]+)$/";
    var $_fullname_pattern          = "/^([aA-zZ]+)\s([aA-zZ']+)$/";
    var $_credit_card_pattern       = "/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11})$/";
    
    var $_rules                     = array("required","username","password","email","full_name","alpha","alphanum","numeric","url","ip","credit_card","min_length","max_length","exact_length");
    var $_base_rule                 = "required";
    
    var $validations_error          = array();    
    var $error_prefix               = "<div class='error_messages'>";    
    var $error_suffix               = "</div>";
    var $error_separator            = "<br />";    
    var $error_template             = array("required"      => "is required",
                                            "username"      => "only allowed alphabets and hyphen(-),dot(.),underscore(_)",
                                            "password"      => "must have 1 capital letter, 1 small letter, 1 number, 1 special character ~!@#$%^&*.-_",
                                            "email"         => "must be in valid email format",
                                            "full_name"     => "must be valid name format",
                                            "alpha"         => "only allowed alphabets",
                                            "alphanum"      => "only allowed alphabet and numbers",
                                            "numeric"       => "allows only digits",
                                            "url"           => "must be valid url",
                                            "ip"            => "must be valid ip address",
                                            "credit_card"   => "must be valid credit card format",
                                            "min_length"    => "must have minimum [length] character(s)",
                                            "max_length"    => "must have maximum [length] character(s)",
                                            //"exact_length"  => "must have exact [length] character(s)");
                                            "exact_length"  => "must have exact [length] digits");
            
    var $field_array                = array();
    
    var $required_field_array       = array();
    
    function __construct(){
        
    }
    
    function add_rule($field,$message,$rule){
        if($field != "" && $rule != ""){
            $this->field_array[] = array($field,$message,$rule);
        }        
    }       
    
    
    function run(){        
        if(count($this->field_array) > 0){            
            foreach($this->field_array as $_f_rules){
                $_f_rule = explode("|",$_f_rules[2]);   
                if(in_array($this->_base_rule,$_f_rule)){
                    $func = $this->_base_rule; 
                    if(!$this->$func($_REQUEST[$_f_rules[0]])){                        
                        //$this->validations_error[$_f_rules[0]] = ucwords($_f_rules[1])." ".$this->error_template[$this->_base_rule]; 
                        $this->validations_error['required'] = "Required fields are incomplete!";                       
                    }
                }
                foreach($_f_rule as $f_rule){
                    $f_length = 0;
                    if($this->_base_rule != $f_rule){
                        if($_REQUEST[$_f_rules[0]] != ""){
                            preg_match("/\[(.*?)\]/",$f_rule,$match_length);                        
                            if(count($match_length) > 0){
                                preg_match("/^(.*?)\[/",$f_rule,$match_func);                            
                                if(count($match_func) > 0){
                                    $f_length = $match_length[1];
                                    $f_rule = $match_func[1];
                                }
                            }                        
                            if(in_array($f_rule,$this->_rules)){
                                if(!$this->$f_rule($_REQUEST[$_f_rules[0]],$f_length)){
                                    if(!array_key_exists($_f_rules[0],$this->validations_error)){
                                        $error_msg = $this->error_template[$f_rule];
                                        if($f_length > 0){
                                            $error_msg = preg_replace("/\[length\]/",$f_length,$error_msg);
                                        }
                                        $this->validations_error[$_f_rules[0]] = ucwords($_f_rules[1])." ".$error_msg;
                                    }
                                }
                            }    
                        }                    
                    }
                }
                
            }
        }
        return $this->get_message();    
    }        
    
    function get_message(){        
        if(count($this->validations_error) > 0){            
            return $this->error_prefix.implode($this->error_separator,$this->validations_error).$this->error_suffix;
        }
        return FALSE;
    }
    
    function required($str){
		if ( ! is_array($str)){
			return (trim($str) == '') ? FALSE : TRUE;
		}else{
			return ( ! empty($str));
		}
	}
    
    function username($str){
        return (!preg_match($this->_username_pattern,$str)) ? FALSE : TRUE;
    }
    
    function password($str){
        return (!preg_match($this->_password_pattern,$str)) ? FALSE : TRUE;
    }
    
    function credit_card($str){
        return (!preg_match($this->_credit_card_pattern,$str)) ? FALSE : TRUE;
    }
    
	function min_length($str, $val){
	    if($val > 0){
    		if (function_exists('mb_strlen')){
    			return (mb_strlen($str) < $val) ? FALSE : TRUE;		
    		}	
    		return (strlen($str) < $val) ? FALSE : TRUE;
        }else
            return TRUE;
	}
		
	function max_length($str, $val){
	    if($val > 0){   
    		if (function_exists('mb_strlen')){
    			return (mb_strlen($str) > $val) ? FALSE : TRUE;		
    		}	
    		return (strlen($str) > $val) ? FALSE : TRUE;
        }else
            return TRUE;
	}
		
	function exact_length($str, $val) {
	    if($val > 0){
    		if (function_exists('mb_strlen')){
    			return (mb_strlen($str) != $val) ? FALSE : TRUE;		
    		}	
    		return (strlen($str) != $val) ? FALSE : TRUE;
        }else
            return TRUE;
	}
    
    function alpha($str){        
        return (!preg_match($this->_onlyalpha_pattern,$str)) ? FALSE : TRUE;
    }
    
    function full_name($str){
        return (!preg_match($this->_fullname_pattern,$str)) ? FALSE : TRUE;
    }
    
    function alphanum($str){        
        return (!preg_match($this->_alpha_numeric_pattern,$str)) ? FALSE : TRUE;
    }
    
    function numeric($str){        
        return (!preg_match($this->_numeric_pattern,$str)) ? FALSE : TRUE;
    }
    
    function email($str){
        return (!preg_match($this->_email_pattern,$str)) ? FALSE : TRUE;                          
    }
    
    function ip($str){
        //return (filter_var($str,FILTER_VALIDATE_IP)) ? FALSE : TRUE;
        return (!preg_match($this->_ip_pattern,$str)) ? FALSE : TRUE;        
    }
    
    function url($str){
        //return (filter_var($str,FILTER_VALIDATE_URL)) ? FALSE : TRUE;
        return (!preg_match($this->_url_pattern,$str)) ? FALSE : TRUE;
    }
    
}

/*$_REQUEST['username']       = "ere";
$_REQUEST['password']       = "2Ea@";
$_REQUEST['email_address']  = "ewrwerwerswsd@gmail.com";
$_REQUEST['first_name']     = "wewrwr";
$_REQUEST['ip_address']     = "192.168.1.122";
$_REQUEST['url']     = "https://www.google.com";

$validator = new validations();
$validator->add_rule("username","username","required|username|min_length[5]|max_length[15]");
$validator->add_rule("password","password","required|password");
$validator->add_rule("email_address","email address","required|email");
$validator->add_rule("first_name","first name","required|alpha");
$validator->add_rule("ip_address","IP Address","ip");
$validator->add_rule("url","URL","url");
*/

//echo $validator->run();


//$html = " this is <b>bold text</b> <a href='#'>click here</a> for reg";

//preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/([\w]+)>)/", $html, $matches,PREG_SET_ORDER);

//print_r($matches);
?>