<?php
    $time=date('m_d_H_').(int)(date('i')/10);
    define('LOG_HTTP',true);
        if (!function_exists('getallheaders')) {
            function getallheaders() {
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_')
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
                return $headers;
            }
        }
        $get = $_GET;
        $post = $_POST;
        $cookie = $_COOKIE;
        $header = getallheaders();
        $files = $_FILES;
        $ip = $_SERVER["REMOTE_ADDR"];
        
        define('LOG_FILENAME','/yjdata/www/cap_log/caplog-'.str_replace('.','_',$ip).'-'.$time.'.txt');
        
        $method = $_SERVER['REQUEST_METHOD'];
        $filepath = $_SERVER["SCRIPT_NAME"];
        //rewirte shell which uploaded by others, you can do more
        foreach ($_FILES as $key => $value) {
            $files[$key]['content'] = file_get_contents($_FILES[$key]['tmp_name']);
            file_put_contents($_FILES[$key]['tmp_name'], "virink");
        }
        unset($header['Accept']);//fix a bug
        $input = array("Get"=>$get, "Post"=>$post, "Cookie"=>$cookie, "File"=>$files, "Header"=>$header);    
    file_put_contents(LOG_FILENAME, "\n#start#\n",  FILE_APPEND);
    file_put_contents(LOG_FILENAME, "\n".date("m-d H:i:s")."  ".$_SERVER['REMOTE_ADDR']."\n".print_r($input, true), FILE_APPEND);
    //http_response_code(404);
    $http_log = "\nPOST ".$_SERVER['REQUEST_URI']." HTTP/1.1\n";
    foreach(getallheaders() as $key => $value){
       $http_log .=   $key.": ".$value."\n";
    }
    $is_first = true;
    $http_log .= "\n";
    foreach($_POST as $key => $value){
       if(!$is_first){ $http_log .= '&';}
       $http_log .= $key."=".$value;
       $is_first = false;
    }
    //echo $http_log;
    if(LOG_HTTP){file_put_contents(LOG_FILENAME, $http_log,  FILE_APPEND);}

?>
