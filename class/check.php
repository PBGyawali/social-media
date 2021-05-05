
<?php
class check{
        function is_login()
        {	
            if(isset($_SESSION['loggedin']))
            {
                if(($_SESSION["loggedin"] == "true")||($_SESSION["loggedin"] == true))
                {
                    return true;
                }
                return false;
            }
            return false;
        }

        function is_user()
        {
            if(isset($_SESSION['id'])&& !empty($_SESSION['id']))
            {			
                return true;	
            }
            return false;
        }

        function is_same_user($data){
            if($this->is_user())
            {			
                if($_SESSION['id'] ==$data)
                {
                    return true;
                }
                return false;	
            }
            return false;

        }

        function is_admin()
        {
            if(isset($_SESSION['user_type']))
            {
                if(($_SESSION["user_type"] == 'admin')||($_SESSION["user_type"] == 'editor')||($_SESSION["user_type"] == 'owner'))
                {
                    return true;
                }
                return false;
            }
            return false;
        }

        function is_master_admin()
        {
            if(isset($_SESSION['user_type']))
            {
                if(($_SESSION["user_type"] == 'admin')||($_SESSION["user_type"] == 'owner'))
                {
                    return true;
                }
                return false;
            }
            return false;
        }
        function is_owner()
        {
            if(isset($_SESSION['user_type']))
            {
                if($_SESSION["user_type"] == 'owner')
                {
                    return true;
                }
                return false;
            }
            return false;
        }

        function verifypassword($md5,$bcrypt,$hash)
        {
            if ($md5== $hash){
            return true;
            }
            elseif (password_verify($bcrypt, $hash)){
            return true;
            }
            return false;
        }
        function validate_password($password)
        {       global $errors;
             if (strlen($password) < 6)array_push($errors,'Password must be minimum 6 characters long ');            
             if (!preg_match('@[A-Z]@', $password))array_push($errors,'Password does not have upper case letter. ');            
             if(!preg_match('@[0-9]@', $password))array_push($errors,'Password does not have number ');
             if(!preg_match('@[^\w]@', $password))array_push($errors,'Password does not have special character. ');
            
        }

        function is_empty($required)
        {  
            $fielderrors =array();    
            foreach($required as $key => $value) 
            {
                if (empty($value))
                {	
                    array_push($fielderrors,$key.' field is empty <br>');				
                }			
            }
            if ($fielderrors)
                return implode('',$fielderrors);
            return false;
        }



        function session($required=null)
        {   
            if(isset($_SESSION[$required]))
            {
                if(!empty($_SESSION[$required]))
                {
                    return $_SESSION[$required];
                }
                return NULL;
            }
            return NULL;            
        }

        

        function check_array($value,$key=null)	{
            if ($value===null)
            return array();
            elseif (is_array($value))						
                return $value;		
            elseif($key)
                return array($key=>$value); 
            return array($value);		
        }


}
?>




