<?php
$ip = $_SERVER['REMOTE_ADDR'];
$white_ip_list = array('127.0.0.1');
$black_ip_list = array('192.168.37.1');
if(in_array($ip,$black_ip_list) || !in_array($ip,$white_ip_list))
    exit('403 forbidden');
?>
