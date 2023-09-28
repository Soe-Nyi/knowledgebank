<?php

include('php/config.php');
$time = time();

$sql = "SELECT * FROM users WHERE last_login > $time";
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);
echo($row);
?>