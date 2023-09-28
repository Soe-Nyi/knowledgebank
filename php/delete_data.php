<?php
session_start();

include('config.php');

$id = $_POST['com_id'];

$sql = "DELETE FROM `comment_info` WHERE `comment_info`.`id` = $id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo 1;
} else {
    echo 0;
}
?>