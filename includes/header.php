<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Knowleadge Bank </title>
    
    <link rel="shortcut icon" href="image/logo.png" type="image/x-icon" />
    <link rel="icon" href="image/logo.png" type="image/x-icon" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/index.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/popup.css" type="text/css" media="all" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
    <!--header open-->
    <div class="heading bg-primary">
        <?php
        if (!empty($session)) {
            $u = "SELECT * FROM users WHERE id =$session";
            $r = mysqli_query($conn, $u);
            $d = mysqli_num_rows($r);
            $row = $r->fetch_assoc();
            ?>
            <div class="float-right mt-1 mr-2">
                <a href="profile.php" class="text-light"><?php echo($row['name']) ?>
                    <img src="<?php echo($row['profile']) ?>" class="rounded-circle ml-1" width="20px">
                </a>
            </div>
            <?php
        }
        ?>
        <div class="container-fluid navbar navbar-expand-sm navbar-dark p-3">
            <!-- header and logo-->
            <h4 class="ml mt-2 mr-auto text-light siteName" style="font-family: times new roman"><img src="image/logo.png" width="60px" class="mr-3 rounded-circle">Knowleadge Bank</h4>
            <div class="ml-3 text-white">
                <span> Subscribe </span>
                <a href="https://youtube.com/channel/UClvEACPg0DuNUiwB4PUwnww" alt="YouTube"><img src="image/youtube.jpg" width="40px" class="rounded ml-2"></a>
            </div>
            <?php
            if (empty($_SESSION['id'])) {
                ?>
                <div class="ml-5">
                    <a href="register.php"><button type="button" class="register btn btn-light p-1" style="margin-bottom:13px;width:80px;">Sign up</button></a><br>
                    <a href="login.php"><button type="button" class="login btn btn-primary p-1" style="width:80px;">Login</button></a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<!-- header close -->