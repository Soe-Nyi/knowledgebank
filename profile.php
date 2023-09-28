<?php
session_start();
include('php/config.php');
$id = mb_strimwidth("$id", 0, 20, "");
$id=strtolower((INT)$_GET['id']);
$id = str_replace(
    array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','order','by','group','and','union','select','null',
        ' ','-',"'",'"','+','(',')','@','!','#','$','%','^','&','*','.',':','/','=','”','~','±','×','÷','[',']','{','}','|','`','_','<','>',',','„','”')
    ,'',$id);
$id = htmlspecialchars(htmlspecialchars(htmlspecialchars($id)));
$id = urlencode(urlencode(urlencode(($id))));
$user = $_SESSION['id'];
$time=time();
if (empty($user) && empty($id)) {
    $url = base64_encode("profile.php");
    header("location: login.php?url=$url");
} elseif ($id == $_SESSION['id'] || empty($id)) {
    if (is_numeric($id) || empty($id)) {
        $sql = "SELECT * FROM `users` WHERE `id`=$user";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        $sql2 = "SELECT * FROM `posts` WHERE `usr_id`=$user ORDER BY Id DESC LIMIT 6";
        $result2 = mysqli_query($conn, $sql2);
        
        $sql3 = "SELECT * FROM `follow_action` WHERE `usr_id`=$user";
        $result3 = mysqli_query($conn, $sql3);
        $following = mysqli_num_rows($result3);
        
        $sql4 = "SELECT * FROM `follow_action` WHERE `action_id`=$user";
        $result4 = mysqli_query($conn, $sql4);
        $follower = mysqli_num_rows($result4);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel='stylesheet prefetch' href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/index.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="css/style.css">
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
            <div class="container">
                <div class="float-right mr-3 mt-3">
                    <a href="logout.php">logout<i class="ml-1 fas fa-sign-out-alt"></i></a>
                    <input type="hidden" name="id" id="id" value="<?php echo $user?>" />
                </div>
                <header>
                    
                </header>
                <main>
                    <div class="row">
                        <div class="left col-sm-5">
                            <div class="photo-left">
                                <img class="photo" src="<?php echo($row['profile'])?>"/>
                                <div id="active"></div>
                                </div>
                                
                                <h4 class="name"><?php echo($row['name'])?></h4>
                                <p class="info"><?php echo($row['work'])?></p>
                                <p class="info"><a href="mailto:<?php echo($row['email'])?>"><?php echo($row['email'])?></a></p>
                                
                                <div class="stats row">
                                    <div class="stat col-sm-4" style="padding-right: 50px;">
                                    <a href="follower.php">
                                        <p class="number-stat"><?php echo($follower)?></p>
                                        <p class="desc-stat">Followers</p>
                                    </a>
                                    </div>
                                    <div class="stat col-sm-4">
                                    <a href="following.php">
                                        <p class="number-stat ml-auto mr-auto"><?php echo($following)?></p>
                                        <p class="desc-stat">Following</p>
                                    </a>
                                    </div>
                                    <div class="stat col-sm-4" style="padding-left: 50px;">
                                        <p class="number-stat"><?php echo($row['upload'])?></p>
                                        <p class="desc-stat">Uploads</p>
                                    </div>
                                </div>
                                
                                <p class="desc">
                                    <?php echo($row['bio'])?>
                                </p>
                        </div>
                        
                        <div class="right col-sm-7">
                            <ul class="nav">
                                <li onclick="gallery()">Gallery</li>
                                <li onclick="about()">About</li>
                            </ul>
                            
                            <span class="follow ml-auto btn btn-primary" onclick="edit()">Edit</span>
                            
                            <div class="row gallery" id="gall">
                                <?php
                                if(mysqli_num_rows($result2) >0){
                                while($row2 = mysqli_fetch_assoc($result2)){
                                ?>
                                <div class="col-sm-4">
                                    <img src="<?php echo $row2['image']?>"/>
                                </div>
                                <?}}else{?>
                                <style>.blank{background: #e5e4e4;border-radius:5px}</style>
                                <div class="col-sm-4">
                                    <img class="blank">
                                </div>
                                <?php }?>
                            </div>

                            <div id="about">
                                <?php
                                if(!empty($row['work'])){
                                ?>
                                <div id="work" class="ab">
                                    Work at <b><?php echo($row['work'])?></b>
                                </div>
                                <?php }?>

                                <?php
                                if(!empty($row['location'])){
                                ?>
                                <div id="liveIn" class="ab">
                                    Live in <b><?php echo($row['location'])?></b>
                                </div>
                                <?php }?>

                                <?php 
                                if(!empty($row['birthday'])){
                                ?>
                                <div id="birth" class="ab">
                                    Birthday <b><?php echo($row['birthday'])?></b>
                                </div>
                                <?php }?>

                                <?php
                                if(!empty($row['phone'])){
                                ?>
                                <a href="tel:<?php echo($row['phone'])?>">
                                <div id="ph" class="ab">
                                    Phone <b><?php echo($row['phone'])?></b>
                                </div></a>
                                <?php }?>

                                <?php
                                if(!empty($row['email'])){
                                ?>
                                <a href="mailto:<?php echo($row['email'])?>">
                                <div id="email" class="ab">
                                    Email <b><?php echo($row['email'])?></b>
                                </div></a>
                                <?php }?>

                                <?php
                                if(!empty($row['school'])){
                                ?>
                                <div id="school" class="ab">
                                    Studied at <b><?php echo($row['school'])?></b>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
 		    <script>
    		function updateUserStatus(){
    			jQuery.ajax({
    				url:'update.php',
    				success:function(){}
    			});
    		}
    		
    		function getUserStatus(){
			    var id = $('#id').val();
    			$.ajax({
    				url:'get_status.php',
                        method: "POST",
                        data: { id: id },
                        cache: false,
    				success:function(result){
    				    jQuery('#active').html(result);
    				}
    			});
    		}
    		
			getUserStatus();
			updateUserStatus();
    		setInterval(function(){
    			updateUserStatus();
    		},3000);
    		
    		setInterval(function(){
    			getUserStatus();
    		},7000);
    	  </script>
        <script>gallery();</script>
    </body>
</html>
<?php
}}elseif (is_numeric($id)) {
    $query = "SELECT * FROM `users` WHERE `id`=$id";
    $res = mysqli_query($conn, $query);
    $data = mysqli_num_rows($res);
    
    if(!empty($data)){
        $sql = "SELECT * FROM `users` WHERE `id`=$id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        $sql2 = "SELECT * FROM `posts` WHERE `usr_id`=$id ORDER BY Id DESC LIMIT 6";
        $result2 = mysqli_query($conn, $sql2);
        
        $sql3 = "SELECT * FROM `follow_action` WHERE `usr_id`=$id";
        $result3 = mysqli_query($conn, $sql3);
        $following = mysqli_num_rows($result3);
        
        $sql4 = "SELECT * FROM `follow_action` WHERE `action_id`=$id";
        $result4 = mysqli_query($conn, $sql4);
        $follower = mysqli_num_rows($result4);
        if(!empty($user)){
        $sql5 = "SELECT * FROM `follow_action` WHERE `action_id`=$id && `usr_id`=$user";
        $result5 = mysqli_query($conn, $sql5);
        $numRow = mysqli_num_rows($result5);
        } ?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel='stylesheet prefetch' href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/index.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="css/style.css">
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
            <div class="container">
                <div class="float-right mr-3 mt-3">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>" />
                </div>
                <header>
                    
                </header>
                <main>
                    <div class="row">
                        <div class="left col-sm-5">
                            <div class="photo-left">
                                <img class="photo" src="<?php echo($row['profile'])?>"/>
                                <div id="active"></div>
                                </div>
                                
                                <h4 class="name"><?php echo($row['name'])?></h4>
                                <p class="info"><?php echo($row['work'])?></p>
                                <p class="info"><a href="mailto:<?php echo($row['email'])?>"><?php echo($row['email'])?></a></p>
                                
                                <div class="stats row">
                                    <div class="stat col-sm-4" style="padding-right: 50px;">
                                    <a href="follower.php?id=<?=$id?>">
                                        <p class="number-stat"><?php echo($follower)?></p>
                                        <p class="desc-stat">Followers</p>
                                    </a>
                                    </div>
                                    <div class="stat col-sm-4">
                                    <a href="following.php?id=<?=$id?>">
                                        <p class="number-stat"><?php echo($following)?></p>
                                        <p class="desc-stat">Following</p>
                                    </a>
                                    </div>
                                    <div class="stat col-sm-4" style="padding-left: 50px;">
                                        <p class="number-stat"><?php echo($row['upload'])?></p>
                                        <p class="desc-stat">Uploads</p>
                                    </div>
                                </div>
                                
                                <p class="desc">
                                    <?php echo($row['bio'])?>
                                </p>
                        </div>
                        
                        <div class="right col-sm-7">
                            <ul class="nav">
                                <li onclick="gallery()">Gallery</li>
                                <li onclick="about()">About</li>
                            </ul>
                            
                            <input type="button" class="follow ml-auto btn btn-primary" id="follow" value="<?php if($numRow >0){echo('Unfollow');}else{echo('Follow');}?>" onclick="follow()" >
                            
                            <div class="row gallery" id="gall">
                                <?php
                                if(mysqli_num_rows($result2) >0){
                                while($row2 = mysqli_fetch_assoc($result2)){
                                ?>
                                <div class="col-sm-4">
                                    <img src="<?php echo $row2['image']?>"/>
                                </div>
                                <?}}else{?>
                                <style>.blank{background: #e5e4e4;border-radius:5px}</style>
                                <div class="col-sm-4">
                                    <img class="blank">
                                </div>
                                <?php }?>
                            </div>

                            <div id="about">
                                <?php
                                if(!empty($row['work'])){
                                ?>
                                <div id="work" class="ab">
                                    Work at <b><?php echo($row['work'])?></b>
                                </div>
                                <?php }?>

                                <?php
                                if(!empty($row['location'])){
                                ?>
                                <div id="liveIn" class="ab">
                                    Live in <b><?php echo($row['location'])?></b>
                                </div>
                                <?php }?>

                                <?php 
                                if(!empty($row['birthday'])){
                                ?>
                                <div id="birth" class="ab">
                                    Birthday <b><?php echo($row['birthday'])?></b>
                                </div>
                                <?php }?>

                                <?php
                                if(!empty($row['phone'])){
                                ?>
                                <a href="tel:<?php echo($row['phone'])?>">
                                <div id="ph" class="ab">
                                    Phone <b><?php echo($row['phone'])?></b>
                                </div></a>
                                <?php }?>

                                <?php
                                if(!empty($row['email'])){
                                ?>
                                <a href="mailto:<?php echo($row['email'])?>">
                                <div id="email" class="ab">
                                    Email <b><?php echo($row['email'])?></b>
                                </div></a>
                                <?php }?>

                                <?php
                                if(!empty($row['school'])){
                                ?>
                                <div id="school" class="ab">
                                    Studied at <b><?php echo($row['school'])?></b>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
 		    <script>
 		 
			getUserStatus();
			updateUserStatus();
    		function updateUserStatus(){
    			jQuery.ajax({
    				url:'update.php',
    				success:function(){}
    			});
    		}
    		
    		function getUserStatus(){
			    var id = $('#id').val();
    			$.ajax({
    				url:'get_status.php',
                        method: "POST",
                        data: { id: id },
                        cache: false,
    				success:function(result){
    				    jQuery('#active').html(result);
    				}
    			});
    		}
    		
    		
    		setInterval(function(){
    			updateUserStatus();
    		},1000);
    		
    		setInterval(function(){
    			getUserStatus();
    		},7000);
    		
    		function follow(){
			    var action_id = $('#id').val();
			    var action = $('#follow').val();
    			$.ajax({
    				url:'php/follow.php',
                        method: "POST",
                        data: { action_id: action_id, action: action },
                        cache: false,
    				success:function(){
    				    <?php
    				    if(!empty($user)){ ?>
    				    if (action == 'Follow') {
    				        $('#follow').val("Unfollow");
    				    } else {
    				        $('#follow').val("Follow");
    				    }
    				    <?php }else{
    				        $url = base64_encode("profile.php?id=$id");
    				        ?>
    				        location = 'login.php?url=<?=$url?>'
    				<?php }?>
    				}
    			});
    		}
    	  </script>
    	<script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script>gallery();</script>
    </body>
</html>
<?php
}else {
    include("404.php");
}}else {
    include("404.php");
}
?>