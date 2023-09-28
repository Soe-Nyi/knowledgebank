<?php
session_start();
include('php/config.php');
include('php/edit.php');
$user = $_SESSION['id'];
if (empty($user)) {
    $url = base64_encode("edit.php");
    header("location: login.php?url=$url");
}
$time=time();
if ($_SESSION['admin_type'] == 'super') {
    $id = (INT)$_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$id";
    if (empty($id)) {
        $sql = "SELECT * FROM users WHERE id=$user";
    }
}else{
    $sql = "SELECT * FROM users WHERE id=$user";
}
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="Description" content="<?php echo($row['work'])?>">
    <meta name="keywords" content="<?php echo($row['name'])?>">
    <meta name="robot" content="index,follow">
    <meta name="creator" content="Creator &#SoeNyiNyiAung">
    <meta content="<?php echo($row['profile'])?>" property="og:image"/>
    
    <title><?php echo($row['name'])?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel='stylesheet prefetch' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/edit.css">
    <link rel="icon" href="<?php echo($row['profile'])?>" type="icon"/>
    <style>
        header {
            background: #e5e4e4;
            background-image: url("<?php echo($row['cover'])?>");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 250px;
        }
    </style>
</head>
    <body>
        <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="container">
                <header>
                    
                </header>
                <main>
                    <div class="row">
                        <div class="left col-sm-5">
                            <div class="photo-left">
                                <input type="file" name="profileImg" id="ProfilechooseFile"  accept="image/png, image/jpg, image/jpeg">
                                <img class="photo" id="profile" src="<?php echo($row['profile'])?>"/>
                            </div>
                                
                                <h4 class="name"><input type="text" name="name" value="<?php echo($row['name'])?>" placeholder="Name"></h4>
                                <p class="info"><?php echo($row['work'])?></p>
                                <p class="info"><?php echo($row['email'])?></p>
                                
                                <div class="stats row">
                                    <div class="stat col-sm-4" style="padding-right: 50px;">
                                        <p class="number-stat"><?php echo($row['follower'])?></p>
                                        <p class="desc-stat">Followers</p>
                                    </div>
                                    <div class="stat col-sm-4">
                                        <p class="number-stat"><?php echo($row['following'])?></p>
                                        <p class="desc-stat">Following</p>
                                    </div>
                                    <div class="stat col-sm-4" style="padding-left: 50px;">
                                        <p class="number-stat"><?php echo($row['upload'])?></p>
                                        <p class="desc-stat">Uploads</p>
                                    </div>
                                </div>
                                
                                <p class="desc">
                                    <textarea name="bio" rows="4" cols="25" placeholder="Bio"><?php echo($row['bio'])?></textarea>
                                </p>
                        </div>
                        
                        <div class="right col-sm-7">
                            

                            <div id="about">
                                
                                <div id="work" class="ab">
                                    Work at <input type="text" name="work" value="<?php echo($row['work'])?>" placeholder="Digital Creator">
                                </div>
                
                                <div id="liveIn" class="ab">
                                    Live in <input type="text" name="location" value="<?php echo($row['location'])?>" placeholder="United State">
                                </div>
                
                                <div id="birth" class="ab">
                                    Birthday <input name="birthday" class="birthday" value="<?php echo $row['birthday'] ?>"  placeholder="Birth date" class="form-control" min="1999-01-01" max="<?=date('Y-m-d')?>" type="date">
                                </div>
            
            
                                <div id="ph" class="ab">
                                    Phone <input type="text" name="phone" value="<?php echo($row['phone'])?>" placeholder="09123456789">
                                </div>
                                
                                <div id="email" class="ab">
                                    Email <input type="email" name="email" value="<?php echo($row['email'])?>" placeholder="you@gmail.com">
                                </div></a>
                                
                                <div id="school" class="ab">
                                    Studied at <input type="text" name="school" value="<?php echo($row['school'])?>" placeholder="Harvest">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($_SESSION['admin_type'] == 'super') {
                        $id = (INT)$_GET['id'];
                        if (!empty($id)) {?>
                            <input type="hidden" name="id" value="<?=$id?>">
                       <? }
                    }
                    ?>
                </main>
                <button type="submit" name="submit" class="save ml-auto"> Save </button>
                </form>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script>
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                
                        reader.onload = function (e) {
                        $('#profile').attr('src', e.target.result);
                    }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                
                $("#ProfilechooseFile").change(function () {
                    readURL(this);
                });
        
    		function updateUserStatus(){
    			jQuery.ajax({
    				url:'update.php',
    				success:function(){}
    			});
    		}

			updateUserStatus();
    		setInterval(function(){
    			updateUserStatus();
    		},3000);
    	  </script>
    </body>
</html>