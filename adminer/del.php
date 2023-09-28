<?php
require_once 'config/config.php';
require_once 'security.php';

$id = (INT)$_GET['id'];
if (is_numeric($id)) {
    $sql = "DELETE FROM posts WHERE id=$id";
    $sql2 = "DELETE FROM about WHERE id=$id";
    $sql3 = "DELETE FROM comment_info WHERE post_id=$id";
    $sql4 = "DELETE FROM rating_info WHERE post_id=$id";

    if (mysqli_query($dbcon, $sql) && mysqli_query($dbcon, $sql2) && mysqli_query($dbcon, $sql3) && mysqli_query($dbcon, $sql4)) {
        header("location:approve.php");
        exit();
    } else
    {
        echo "Error deleting record";
    }
}
mysqli_close($dbcon);