<?php
session_start();
include('php/config.php');
$uid=$_SESSION['id'];
$time=strtotime(date('Y-m-d H:i:s'));
$id = $_POST['id'];
if (empty($id)) {
    $sql = "SELECT * from `users` WHERE id = $uid";
} else {
    $sql = "SELECT * from `users` WHERE id = $id";
}
$res=mysqli_query($conn,$sql);
$html = '';
while($row = mysqli_fetch_assoc($res)){
	if(strtotime($row['last_login']) < $time-10){
		$style=".active{background-color: #f31414;}";
	}
	$html.="<style>$style</style>
	<div class='active'></div>";
}
echo($html)
?>