<?php
session_start();
if (!empty($_SESSION['id'])) {
    header('location: index.php');
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
    <link rel="shortcut icon" href="image/logo.png" type="image/x-icon" />
    <link rel="icon" href="image/logo.png" type="image/x-icon" />

    <title> Knowleadge Bank - Register</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

    <link href="css/botstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.1.1.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>

<body class="bg-gradient-primary">

    <div id="box" class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form method="post" class="user">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user" id="username"
                                    placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control form-control-user" id="email"
                                    placeholder="Email Address or Phone Number">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                        id="password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="repassword" class="form-control form-control-user"
                                        id="repassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                        <label class="custom-control-label" for="remember">Remember Me</label>
                                    </div>
                                </div>
                                <input type="button" name="register" id="register" value="Register Account" class="btn btn-primary btn-user btn-block">
    
                            </form>
                            <div class="p-2 mt-3" id="error">
                            </div>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?php if(empty($url)){echo"login.php";}else{echo 'login.php?url=' . $url;}?>">You have an account ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#register').click(function() {
                var username = $('#username').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var repassword = $('#repassword').val();
                var remember = $('#remember').val();
                if ($.trim(username).length > 0 && $.trim(password).length > 0) {
                    $.ajax({
                        url: "php/register.php",
                        method: "POST",
                        data: { username: username, email: email, password: password, repassword: repassword, remember: remember },
                        cache: false,
                        beforeSend: function() {
                            $('#register').val("connecting...");
                        },

                        success: function(data) {
                            if (data) {
                                location = '<?php $url = base64_decode($url); if(empty($url)){echo"index.php";}else{echo $url;}?>';
                            } else{
                                var options = {
                                    distance: '40',
                                    direction: 'left',
                                    times: '3'
                                }
                                $("#box").effect("shake", options, 800);
                                $('#register').val("Register Account");
                                $('#error').html("<span class='text-danger'> Something Wrong. </span>");
                            }
                        }
                    });
                } else {
                    $('#error').html("<span class='text-danger'> Filling request. </span>");
                    
                }
            });
        });
    </script>
</body>
</html>