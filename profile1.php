<?php
session_start();
include('php/config.php');
$id = htmlspecialchars(htmlspecialchars(htmlspecialchars($_GET['id'])));
$id = urlencode(urlencode(urlencode(($id))));
$user = $_SESSION['id'];
if (empty($user) && empty($id)) {
    header('location: login.php');
} elseif ($id === $_SESSION['id']) {
    if (is_numeric($id)) {
        $sql = "SELECT * FROM users WHERE id=$user";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            <meta name="description" content="<?php echo($row['bio']) ?>">
            <title><?php echo($row['username']) ?></title>
            <link rel="shortcut icon" href="<?php echo($row['profile']) ?>" type="image/x-icon" />
            <link rel="icon" href="<?php echo($row['profile']) ?>" type="image/x-icon" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <div class="profile-card">
                <div class="float-right mr-3 mt-3">
                    <a href="logout.php">logout<i class="ml-1 fas fa-sign-out-alt"></i></a>
                </div>
                <div class="card-header">
                    <div class="pic">
                        <img src="<?php echo($row['profile']) ?>" alt="">
                    </div>
                    <div class="name">
                        <?php echo($row['username']) ?>
                    </div>
                    <div class="bio">
                        <?php
                        $str = $row['bio'];
                        $bio = iconv('UTF-8', 'UTF-8//IGNORE', $str);
                        echo($bio);
                        ?>
                    </div>
                    <div class="sm">
                        <a href="#" class="fab fa-facebook-f"></a>
                        <a href="#" class="fab fa-facebook-messenger"></a>
                    </div>
                    <a href="#" class="contact-btn">Edit</a>
                </div>
                <div class="card-footer">
                    <div class="numbers">
                        <div class="border"></div>
                        <div class="item">
                            <span><?php echo($row['following']) ?></span>
                            Following
                        </div>
                        <div class="border2"></div>
                        <div class="item">
                            <span><?php echo($row['follower']) ?></span>
                            Followers
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
}} elseif (is_numeric($id)) {
$sql = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?php echo($row['bio']) ?>">
    <title><?php echo($row['username']) ?></title>
    <link rel="shortcut icon" href="<?php echo($row['profile']) ?>" type="image/x-icon" />
    <link rel="icon" href="<?php echo($row['profile']) ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="profile-card">
        <div class="card-header">
            <div class="pic">
                <img src="<?php echo($row['profile']) ?>" alt="">
            </div>
            <div class="name">
                <?php echo($row['username']) ?>
            </div>
            <div class="bio">
                <?php
                echo($row['bio']);
                ?>
            </div>
            <div class="sm">
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-facebook-messenger"></a>
            </div>
            <a href="" class="contact-btn">Follow</a>
        </div>
        <div class="card-footer">
            <div class="numbers">
                <div class="border"></div>
                <div class="item">
                    <span><?php echo($row['following']) ?></span>
                    Following
                </div>
                <div class="border2"></div>
                <div class="item">
                    <span><?php echo($row['follower']) ?></span>
                    Followers
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} elseif (empty($id)) {
$sql = "SELECT * FROM users WHERE id=$user";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo($row['bio']) ?>">
<title><?php echo($row['username']) ?></title>
<link rel="shortcut icon" href="<?php echo($row['profile']) ?>" type="image/x-icon" />
<link rel="icon" href="<?php echo($row['profile']) ?>" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="profile-card">
<div class="float-right mr-3 mt-3">
<a href="logout.php">logout<i class="ml-1 fas fa-sign-out-alt"></i></a>
</div>
<div class="card-header">
<div class="pic">
<img src="<?php echo($row['profile']) ?>" alt="">
</div>
<div class="name">
<?php echo($row['username']) ?>
</div>
<div class="bio">
<?php
echo($row['bio']);
?>
</div>
<div class="sm">
<a href="#" class="fab fa-facebook-f"></a>
<a href="#" class="fab fa-facebook-messenger"></a>
</div>
<a href="#" class="contact-btn">Edit</a>
</div>
<div class="card-footer">
<div class="numbers">
<div class="border"></div>
<div class="item">
<span><?php echo($row['following']) ?></span>
Following
</div>
<div class="border2"></div>
<div class="item">
<span><?php echo($row['follower']) ?></span>
Followers
</div>
</div>
</div>
</div>
</body>
</html>
<?php
}
?>