<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    header('Location:admin.php');
}elseif ($_SESSION['admin_type'] != 'super' && $_SESSION['admin_type'] != 'admin') {
    header('Location: ../index.php');
}

// If user has previously selected "remember me option":
if(isset($_POST['submit'])){

    $username = mysqli_real_escape_string($dbcon, $_POST["username"]);
    $username = trim(strtolower($username));
    $username = str_replace(" ", "", $username);
    $password = md5(mysqli_real_escape_string($dbcon, $_POST["password"]));
    $sql = "SELECT * FROM users WHERE phone = '$username' && password = '$password' || email = '$username' && password = '$password' || id = '$username' && password = '$password'";
    $result = mysqli_query($dbcon, $sql);
    $user = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    if ($user > 0) {
        if (isset($_POST["remember"])) {
            setcookie ("id", $id, time()+ (1000 * 365 * 24 * 600 * 600));
            setcookie ("username", $username, time()+ (1000 * 365 * 24 * 600 * 600));
            setcookie ("password", $password, time()+ (1000 * 365 * 24 * 600 * 600));
            setcookie ("user_type", $row['type'], time()+ (1000 * 365 * 24 * 600 * 600));
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['admin_type'] = $row['type'];
        } else {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['admin_type'] = $row['type'];
        }

        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['admin_type'] = $row['type'];
        header('Location:admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Administrator</title>

        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="assets/css/bootstrap.min.css"/>

        <!-- MetisMenu CSS -->
        <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <script src="assets/js/jquery.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.19.1/ui/trumbowyg.min.css">
    </head>

    <body>
 
<div id="page-" class="col-md-4 col-md-offset-4">
    <form class="form loginform" method="POST" action="">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                Please Sign in
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">username</label>
                    <input type="text" name="username" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label class="control-label">password</label>
                    <input type="password" name="password" class="form-control" required="required">
                </div>
                <div class="checkbox">
                    <label>
                        <input name="remember" type="checkbox" value="1">Remember Me
                    </label>
                </div>
                <button type="submit" name="submit" class="btn btn-success loginField">Login</button>
            </div>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>