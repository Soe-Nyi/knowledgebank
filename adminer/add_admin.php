<?php
session_start();
require_once 'config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page
if ($_SESSION['admin_type'] !== 'super') {
    // show permission denied message
    echo 'Permission Denied';
    exit();
}



if (isset($_POST["username"]) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['admin_type'])) {

    $username = htmlspecialchars(mysqli_real_escape_string($dbcon, $_POST["username"]));
    $email = trim($_POST["email"]);
    $email = htmlspecialchars(strtolower($email));
    $email = str_replace(" ", "", $email);
    $email = htmlspecialchars(mysqli_real_escape_string($dbcon, $email));
    $password = md5(mysqli_real_escape_string($dbcon, $_POST["password"]));
    $type  = md5(mysqli_real_escape_string($dbcon, $_POST["admin_type"]));

        $sql = "SELECT * FROM users WHERE phone = '$email' && password = '$password' || email = '$email' && password = '$password' || id = '$email' && password = '$password' || username = '$email' && password = '$password' ";
        $result = mysqli_query($dbcon, $sql);
        $user = mysqli_num_rows($result);
        $row = $result->fetch_assoc();
        $data = $row['id'];
        if ($user > 0) {
            
        } else {

            $sql = "SELECT * FROM `users`";
            $result = $dbcon->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data = $row['id'] + 1;
                }
            } else {
                $data = 1;
            }


            if (is_numeric($email)) {
                $sql = "INSERT INTO `users` (`id`, `name`, `username`, `profile`, `bio`, `upload`, `email`, `phone`, `location`, `work`, `school`, `following`, `follower`, `password`, `last_login`,`type`)
                VALUES ($data, '$username', '', 'profiles/profile.png', '', 0, '', '$email', '', '', '', 0, 0, '$password', 0, '$type')";
            } else {
                $sql = "INSERT INTO `users` (`id`, `name`, `username`, `profile`, `bio`, `upload`, `email`, `phone`, `location`, `work`, `school`, `following`, `follower`, `password`, `last_login`,`type`)
                VALUES ($data, '$username', '', 'profiles/profile.png', '', 0, '$email', '', '', '', '', 0, 0, '$password', 0, '$type')";
            }
            $result = $dbcon->query($sql);
            if ($result) {
                header('location : admin_users.php');
            }
        }
}

require_once 'includes/header.php';
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Add User</h2>
		</div>
	</div>
	 <?php 
    include_once('includes/flash_messages.php');
    ?>
	<form class="well form-horizontal" action=" " method="post"  id="contact_form" enctype="multipart/form-data">
		<?php include_once './forms/admin_users_form.php'; ?>
	</form>
</div>




<?php include_once 'includes/footer.php'; ?>