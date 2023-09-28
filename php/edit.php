<?php
session_start();
include("config.php");
$id = $_SESSION['id'];

if (isset($_POST['submit'])) {

    if ($_SESSION['admin_type'] == 'super') {
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            $id = $_SESSION['id'];
        }
    } else {
        $id = $_SESSION['id'];
    }
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $name = htmlspecialchars(trim(mysqli_real_escape_string($conn, $_POST["name"])));
    $profile = htmlspecialchars($row['profile']);
    $cover = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["cover"]));
    $bio = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["bio"]));
    $bio = mb_strimwidth("$bio", 0, 120, "");
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $email = htmlspecialchars(strtolower($email));
    $email = str_replace(" ", "", $email);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $phone = htmlspecialchars(strtolower($phone));
    $phone = str_replace(" ", "", $phone);
    $location = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["location"]));
    $location = mb_strimwidth("$location", 0, 36, "");
    $birthday = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["birthday"]));
    $work = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["work"]));
    $work = mb_strimwidth("$work", 0, 36, "");
    $school = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["school"]));
    $school = mb_strimwidth("$school", 0, 36, "");

    if (!empty($_FILES['profileImg']['name'])) {

        $filename = $_FILES['profileImg']['name'];
        // destination of the file on the server
        $profile2 = 'profiles/' . $filename;

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $_FILES['profileImg']['tmp_name'];

        if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
            echo "You file extension must be .png, .jpg or .jpeg";
        } else {
            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $profile2)) {
                $sql = "UPDATE `users` SET `name` = '$name', `profile` = '$profile2', `cover` = '$cover', `bio` = '$bio', `email` = '$email', `phone` = '$phone', `location` = '$location', `birthday` = '$birthday', `work` = '$work', `school` = '$school' WHERE `users`.`id` = $id";
                if (mysqli_query($conn, $sql)) {
                    header("location: profile.php?id=$id");
                }
            }
        }
    } else {
        $sql = "UPDATE `users` SET `name` = '$name', `profile` = '$profile', `cover` = '$cover', `bio` = '$bio', `email` = '$email', `phone` = '$phone', `location` = '$location', `birthday` = '$birthday', `work` = '$work', `school` = '$school' WHERE `users`.`id` = $id";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            header("location: profile.php?id=$id");
        }
     }
}

?>