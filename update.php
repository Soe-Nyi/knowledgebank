<?php
session_start();
include('php/config.php');
$uid=$_SESSION['id'];
$time=date('Y-m-d H:i:s');

//ip address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//location
 $location  = $_SERVER['REMOTE_ADDR'];
 $ip_val = curl_init('http://ipwhois.app/json/'.$location);
    curl_setopt($ip_val, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ip_val);
    curl_close($ip_val);

    // Decode JSON response
    $ip_result = json_decode($json, true);

$ip = get_client_ip();
$city = $ip_result['city'];
$res=mysqli_query($conn,"UPDATE `users` SET `location` = '$city', `ip` = '$ip', `last_login` = '$time' WHERE `users`.`id` = $uid;");
?>