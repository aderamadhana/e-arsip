<?php 

function curUrl(){
    $CI =& get_instance();
    $url ='';
    if(strtolower($CI->router->fetch_method()) == 'index'){
        $url  = $CI->router->fetch_directory().$CI->router->fetch_class();
    } else{
        $url  = $CI->router->fetch_directory().$CI->router->fetch_class().'/'.$CI->router->fetch_method();
    }
    $url = strtolower($url);
    return $url;
}

function curCname(){
    $CI =& get_instance();
    $url ='';
    $url  = $CI->router->fetch_directory().$CI->router->fetch_class();
    $url = strtolower($url);
    return $url;
}

function dump_variable($data)
{
    echo '<pre>' . var_export($data, true) . '</pre>';
}

function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}


// public function direktori()
	// {
		// $ci = get_class_methods($this);
		// print_r($ci);
	// }
 ?>
