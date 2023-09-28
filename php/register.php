<?php
session_start();
include("config.php");

if (isset($_POST["username"]) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword'])) {

    $username = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["username"]));
    $email = trim($_POST["email"]);
    $email = htmlspecialchars(strtolower($email));
    $email = str_replace(" ", "", $email);
    $email = htmlspecialchars(mysqli_real_escape_string($conn, $email));
    $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
    $repassword = md5(mysqli_real_escape_string($conn, $_POST["repassword"]));

    if ($password == $repassword) {

        $sql = "SELECT * FROM users WHERE phone = '$email' && password = '$password' || email = '$email' && password = '$password' || id = '$email' && password = '$password' || username = '$email' && password = '$password' ";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_num_rows($result);
        $row = $result->fetch_assoc();
        $data = $row['id'];
        if ($user > 0) {
            if (isset($_POST["remember"])) {
                setcookie ("id", $id, time()+ (100 * 365 * 24 * 60 * 60));
                setcookie ("username", $name, time()+ (100 * 365 * 24 * 60 * 60));
                setcookie ("password", $password, time()+ (100 * 365 * 24 * 60 * 60));
                $_SESSION['id'] = $data;
                echo($data);
            } else {
                $_SESSION['id'] = $data;
                echo($data);
            }

        } else {

            $sql = "SELECT * FROM `users`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data = $row['id'] + 1;
                }
            } else {
                $data = 1;
            }


            if (is_numeric($email)) {
                $sql = "INSERT INTO `users` (`id`, `name`, `username`, `profile`, `bio`, `upload`, `email`, `phone`, `location`, `work`, `school`, `password`, `last_login`)
                VALUES ($data, '$username', '', 'profiles/profile.png', '', 0, '', '$email', '', '', '', '$password', 0)";
            } else {
                $sql = "INSERT INTO `users` (`id`, `name`, `username`, `profile`, `bio`, `upload`, `email`, `phone`, `location`, `work`, `school`, `password`, `last_login`)
                VALUES ($data, '$username', '', 'profiles/profile.png', '', 0, '$email', '', '', '', '', '$password', 0)";
            }
            $result = $conn->query($sql);
            if ($result) {
                if (isset($_POST["remember"])) {
                    setcookie ("id", $id, time()+ (100 * 365 * 24 * 60 * 60));
                    setcookie ("username", $email, time()+ (100 * 365 * 24 * 60 * 60));
                    setcookie ("password", $password, time()+ (100 * 365 * 24 * 60 * 60));
                    $_SESSION['id'] = $data;
                    echo($data);
                } else {
                    $_SESSION['id'] = $data;
                    echo($data);
                }
            }
        }
    } else {
        $html.= "<span class='text-danger'> Password are not same.</span>";
        echo($html);
    }
}
?>