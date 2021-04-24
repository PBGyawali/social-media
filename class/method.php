<?php 
class method extends check{

    function get_datetime()
	{
		return date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
    }
    
    function parms($string,$data) {
		$indexed=$data==array_values($data);
		foreach($data as $k=>$v) {
			if(is_string($v)) $v="'$v'";
			if($indexed) $string=preg_replace('/\?/',$v,$string,1);
			else $string=str_replace(":$k",$v,$string);
		}
		return $string;
	}
    function Slug(String $string)
	{
		$string = strtolower($string);
		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
		return $slug;
	}

	function response($response=null,$status=null,$data=null,$element=null){
        $finalresponse = array(
			'response'  => $response,
			'status'    => $status,
            'data'      => $data, 
			'element' => $element
        );
        echo json_encode($finalresponse);
		exit;
	}
	
	function randomString($length=100){
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $strlen = strlen($chars);
        // string is an array of chars
        $random = "";
        for($i=0; $i<$length; $i++){
            $posn = rand(0, $strlen-1);
            $random .= $chars[$posn];
        }
        return $random;
    }

	function debug($data, $is_exit = false){
        echo "<pre style='background: #ffffff;'>";
        print_r($data);
        echo "</pre>";
        if($is_exit){
            exit;
        }
    }


    function redirect($path, $session_status = null, $session_msg = null){
        
        if($session_status != null && $session_msg != null){
            $this->setSession($session_status, $session_msg);
        }

        @header("location: ".$path);
        
    }

    function setSession($names, $values){
        if(!isset($_SESSION)){
            session_start();
        }
        $names=$this->check_array($names); 
        $values=$this->check_array($values);
        foreach($names as $key=>$name) 
        $_SESSION[$name] = $values[$key];
    }

    function create_placeholder($value)	{
		if (is_array($value))
		{	$marker=array();
			for ($x = 0; $x <count($value); $x++) {
				array_push($marker,'?');
			  }							
		  return $marker;
		}		
		return array('?');	
	}


}
?>