<?php
$con = mysqli_connect("sql100.epizy.com:3306", "epiz_32030729", "soenyi1482005", "epiz_32030729_data"); 
$id = $_GET['id'];
$sql = "DELETE FROM post WHERE id=$id";

if (mysqli_query($con, $sql)) {
    header("location:../admin.php");
    exit();
} else
{
    echo "Error deleting record";
}
?>