<?php
session_start();
include('php/config.php');
$id = (INT)$_GET['id'];
if (is_numeric($id)) {
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['usr_id'] == $_SESSION['id']) {
        $sql = "DELETE FROM posts WHERE id=$id";
        $sql2 = "DELETE FROM about WHERE id=$id";
        $sql3 = "DELETE FROM comment_info WHERE post_id=$id";
        $sql4 = "DELETE FROM rating_info WHERE post_id=$id";

        if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3) && mysqli_query($conn, $sql4)) {
            header("location:index.php");
            exit();
        } else
        {
            echo "Error deleting record";
        }
    }
}
?>