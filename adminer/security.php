<?php
if (!isset($_SESSION['admin_type'])) {
    header("location: index.php");
    exit();
}