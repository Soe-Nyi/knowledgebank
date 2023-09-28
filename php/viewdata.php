<?php
include('config.php');
$id=strtolower((INT)$_GET['id']);
$id = str_replace(
    array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','order','by','group','and','union','select','null',
        ' ','-',"'",'"','+','(',')','@','!','#','$','%','^','&','*','.',':','/','=','”','~','±','×','÷','[',']','{','}','|','`','_','<','>')
    ,'',$id);
$id = mb_strimwidth("$id", 0, 20, "");
$id = htmlspecialchars(htmlspecialchars(htmlspecialchars($id)));
$id = urlencode(urlencode(urlencode(($id))));

if (empty($id)) {
    header('location: index.php');
}

if (is_numeric($id)) {
    $sql = "SELECT * FROM book WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    http_response_code(400);
    header('location: index.php');
}