<?php
session_start();
if (!empty($_SESSION['id'])) {
    header('location:index.php');
}
$url = $_GET['url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Knowleadge Bank - Login </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/botstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.1.1.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body class="bg-gradient-primary">

    <div id="box" class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Please LogIn To Your Account</h1>
                                    </div>
                                    <form method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                            id="username" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address or Phone Number">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                            id="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                                <label class="custom-control-label" for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        <input type="button" name="login" value="Login" id="login" class="btn btn-primary btn-user btn-block">
                                    </form>
                                    <div id="error"></div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php if(empty($url)){echo"register.php";}else{echo 'register.php?url=' . $url;}?>">Create an Account</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#login').click(function() {
                var username = $('#username').val();
                var password = $('#password').val();
                var remember = $('#remember').val();
                if ($.trim(username).length > 0 && $.trim(password).length > 0) {
                    $.ajax({
                        url: "php/login.php",
                        method: "POST",
                        data: { username: username, password: password, remember: remember },
                        cache: false,
                        beforeSend: function() {
                            $('#login').val("connecting...");
                        },
                        success: function(data) {
                            if (data) {
                                location = '<?php $url= base64_decode($url);if(empty($url)){echo"index.php";}else{echo $url;}?>';
                            } else{
                                var options = {
                                    distance: '40',
                                    direction: 'left',
                                    times: '3'
                                }
                                $("#box").effect("shake", options, 800);
                                $('#login').val("Login");
                                $('#error').html("<span class='text-danger'>Invalid username or Password</span>");
                            }
                        }
                    });
                } else {}
            });
        });
    </script>
</body>
</html>