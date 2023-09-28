<?php
session_start();
include("config.php");
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $username = trim(strtolower($username));
        $username = str_replace(" ", "", $username);
        $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
        $sql = "SELECT * FROM users WHERE (phone = '$username' && password = '$password') || (email = '$username' && password = '$password') || (id = '$username' && password = '$password') ";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $data = $row['id'];
        if ($user > 0) {
            if (isset($_POST["remember"])) {
                setcookie ("username", $username, time()+ (100 * 365 * 24 * 600 * 600));
                setcookie ("id", $id, time()+ (100 * 365 * 24 * 600 * 600));
                setcookie ("password", $password, time()+ (100 * 365 * 24 * 600 * 600));
                setcookie ("admin_type", $row['type'], time()+ (100 * 365 * 24 * 600 * 600));
                $_SESSION['id'] = $data;
                $_SESSION['username'] = $row['name'];
                $_SESSION['admin_type'] = $row['type'];
                echo($data);
            } else {
                $_SESSION['id'] = $data;
                $_SESSION['username'] = $row['name'];
                $_SESSION['admin_type'] = $row['type'];
                echo($data);
            }
        }
    }
?>