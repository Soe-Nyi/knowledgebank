<?php
session_start();
include('config/config.php');
if ($_SESSION['admin_type'] == 'super' || $_SESSION['admin_type'] == 'admin') {
    $id = (INT)$_GET['id'];
    if (!empty($id)) {
        $sql = "UPDATE `posts` SET `state` = 'approved' WHERE `posts`.`id` = $id";
        if (mysqli_query($dbcon, $sql)) {
            header('location: approve.php');
        }
    } else {
        header('location: approve.php');
    }
}else {
    header('location: approve.php');
}
?>