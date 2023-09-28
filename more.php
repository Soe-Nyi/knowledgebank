<?php
session_start();
include('php/detail.php');
//$id=$_GET['id'];
$id=strtolower((INT)$_GET['id']);
$id = mb_strimwidth("$id", 0, 20, "");

$user = $_SESSION['id'];
if (is_numeric($id)) {
    $query = "SELECT * FROM posts WHERE id=$id";
    $res = mysqli_query($conn, $query);
    $data = mysqli_num_rows($res);
    
    if(!empty($data)){
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $sql2 = "SELECT * FROM about WHERE id=$id";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    //author data
    $usr_id = $row['usr_id'];
    $author = "SELECT * FROM users WHERE id=$usr_id";
    $aut_result = mysqli_query($conn, $author);
    $aut_row = mysqli_fetch_assoc($aut_result);
    
    if(!empty($user)){
        $fsql = "SELECT * FROM `follow_action` WHERE `action_id`=$usr_id && `usr_id`=$user";
        $fresult = mysqli_query($conn, $fsql);
        $frow = mysqli_num_rows($fresult);
        
        if($frow>0){
            $viewed = "INSERT INTO `noti` (`usr_id`, `post_id`) VALUES ($user, $id)";
            mysqli_query($conn,$viewed);
        }
    }
    $url = base64_encode("more.php?id=$id");
    
function getDateTimeDiff($date){
 $now_timestamp = strtotime(date('Y-m-d H:i:s'));
 $diff_timestamp = $now_timestamp - strtotime($date);
 
 if($diff_timestamp < 60){
  return 'just now';
 }
 else if($diff_timestamp>=60 && $diff_timestamp<3600){
  return round($diff_timestamp/60).' mins ago';
 }
 else if($diff_timestamp>=3600 && $diff_timestamp<86400){
  return round($diff_timestamp/3600).' hours ago';
 }
 else if($diff_timestamp>=86400 && $diff_timestamp<(86400*30)){
  return round($diff_timestamp/(86400)).' days ago';
 }
 else if($diff_timestamp>=(86400*30) && $diff_timestamp<(86400*365)){
  return round($diff_timestamp/(86400*30)).' months ago';
 }
 else{
  return round($diff_timestamp/(86400*365)).' years ago';
 }
}
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?php
                $desc = $row['about'];
                $strCut = substr($desc, 0, 400);
                $desc = substr($strCut, 0, strrpos($strCut, ' ')) . ' ...see more';
                echo($desc); ?>">
        <meta property="og:description" content="<?php
                $desc = $row['about'];
                $strCut = substr($desc, 0, 400);
                $desc = substr($strCut, 0, strrpos($strCut, ' ')) . ' ...see more';
                echo($desc); ?>">
        <meta name="author" content="<?php echo($aut_row['username'])?>">

        <title><?php echo($row['title']) ?></title>
        <link rel="shortcut icon" href="<?php echo($row['image']) ?>" type="image/x-icon" />
        <link rel="icon" href="<?php echo($row['image']) ?>" type="image/x-icon" />
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- Custom styles for this template -->
        <link href="css/more.css" rel="stylesheet">
        <link href="css/popup.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container">
                <div class="navbar-brand"><?php echo($row['category'])?></div>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Category
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="science.php">Science</a>
                                <a class="dropdown-item" href="technology.php">Technology</a>
                                <a class="dropdown-item" href="book.php">Books</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="profile.php"> Profile </a></li>
                        <?php
                            if($_SESSION['admin_type'] == 'super' || $_SESSION['admin_type'] == 'admin'){
                            ?>
                            <li class="nav-item"><a class="nav-link" href="adminer/"> Admin </a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="image-container container">

            <!-- Page Heading/Breadcrumbs -->
            <h1 class="mt-4 mb-3"><?php echo($row['title']) ?>
            </h1>
            <small>by
                <a href="profile.php?id=<?php echo($aut_row['id']) ?>"><?php echo($aut_row['name']) ?></a>
            </small>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active"><?php echo($row['category'])?></li>
                <?php
                if($row['usr_id'] == $_SESSION['id']){
                ?>
                    <a href="editpost.php?id=<?=$id?>" class="ml-auto mr-3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="#" class="mr-3" data-toggle="modal" data-target="#confirm-delete-<?php echo $id;?>"><i class="fa fa-trash" aria-hidden="true" style="color:#ec2c2c;"></i></a>
                    <div class="modal fade" id="confirm-delete-<?php echo $id; ?>" role="dialog">
                    <div class="modal-dialog">
                    <form action="delete.php?id=<?=$id?>" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-body">
                                <p>Are you sure you want to delete?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                    <a href="#comment" class="mr-2"><i class="fa fa-comments-o" aria-hidden="true"></i></a>
                <?php }else{?>
                    <a href="#comment" class="mr-2 ml-auto"><i class="fa fa-comments-o" aria-hidden="true"></i></a>
                <?php }?>
            </ol>
            <div class="row">
                <!-- Post Content Column -->
                <div class="col-sm-12">
                    <!-- Preview Image -->
                    <img class="img-fluid rounded logo" src="<?php echo($row['image']) ?>" alt="Logo">
                    <hr>
                    <!-- Date/Time -->
                    <p>
                        Posted on <?php echo($row['date']) ?>
                    </p>
                    <hr>
                    <!-- Post Content -->
                    <p class="lead">
                        <?php echo($row2['about']) ?>
                    </p>
                    <hr>
                    <div class="card my-0 col-sm-12">
                        <div class="card-header">
                            <div class="like">

                        <?php
                        if (!empty($_SESSION['id'])) {
                            ?>
                            <i <?php if (userLiked($row['id'])): ?> class="fa fa-thumbs-up like-btn" <?php else : ?> class="fa fa-thumbs-o-up like-btn" <?php endif ?> data-id="<?php echo $row['id'] ?>"></i>
                            <span class="likes"><?php echo getLikes($row['id']); ?></span>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <i <?php if (userDisliked($row['id'])): ?> class="fa fa-thumbs-down dislike-btn" <?php else : ?> class="fa fa-thumbs-o-down dislike-btn" <?php endif ?> data-id="<?php echo $row['id'] ?>"></i>
                            <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
                            <?
                        } else {
                            ?>
                            <a href="login.php?url=<?=$url?>"><i <?php if (userLiked($row['id'])): ?> class="fa fa-thumbs-up like-btn" <?php else : ?> class="fa fa-thumbs-o-up like-btn" <?php endif ?> data-id="<?php echo $row['id'] ?>"></i></a>
                            <span class="likes"><?php echo getLikes($row['id']); ?></span>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="login.php?url=<?=$url?>"><i <?php if (userDisliked($row['id'])): ?> class="fa fa-thumbs-down dislike-btn" <?php else : ?> class="fa fa-thumbs-o-down dislike-btn" <?php endif ?> data-id="<?php echo $row['id'] ?>"></i></a>
                            <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
                            <?php
                        }
                        ?>
        
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
<div class="popup-image">
    <span>&times;</span>
    <img src="" alt="">
</div>
<script src="js/popup.js"></script>
    <style>
    .comment_form{
        padding: 0 20px 30px 20px;
    }
    .card{
        width: 100%;
    }
    .delete-com{
        text-align: right;
        margin-top: -10px;
    }
    .media a{
        color: black;
        text-decoration: none;
    }
    .media-body{
        background-color: #d8d9d9;
        margin: 0 0 10px 5px;
        padding: 0 10px 10px 15px;
        border-radius: 10px;
    }
    .media{
        margin: 20px 0 0 0;
    }
    .user {
            font-weight: bold;
            color: black;
        }

        .time {
            color: gray;
        }
    </style>


<!-- Comments Form -->

<div class="comment_form">
    <div class="card my-4">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
            <form id="form" method="post" accept-charset="utf-8">
                <div class="form-group">
                    <textarea class="form-control" id="msg" rows="3"></textarea>
                </div>
                <?php
                if(empty($_SESSION['id'])){
                ?>
                <a href="login.php?url=<?=$url?>"><button style="float:right" type="button" class="btn btn-primary">Submit</button></a>
                <?php }else{ ?>
                <button style="float:right" type="button" name="submit" id="btn" class="btn btn-primary">Submit</button>
                <?php }?>
            </form>
        </div>
    </div>
    
    
    <div id="comment">
    <?php
    if(empty($_SESSION['id'])){
        $sql = "SELECT * FROM `comment_info` WHERE `comment_info`.`post_id` = $id";
        $result = mysqli_query($conn, $sql);
    
        while ($com_row = mysqli_fetch_assoc($result)) {
            $usr_id = $com_row['usr_id'];
            $u = "SELECT * FROM users WHERE id =$usr_id";
            $r = mysqli_query($conn, $u);
            $comter = mysqli_fetch_assoc($r);
            ?>
            <div id="<?php echo($com_row['id']) ?>">
                <div class="media">
                    <a href="profile.php?id=<?php echo($usr_id) ?>">
                        <img class="d-flex mr-2 rounded-circle" src="<?php echo($comter['profile']) ?>" alt="<?php echo($comter['name']) ?>"></a>
                    <div class="media-body">
                        <a href="profile.php?id=<?php echo($usr_id) ?>">
                            <div class="user mt-1"><?php echo($comter['name']) ?> </a><span class="time timeago ml-1" data-date="<?php echo($com_row['createdOn']) ?>"><?php echo(getDateTimeDiff($com_row['createdOn']))?></span></div>
                        <?php echo($com_row['comment']) ?>
                    </div>
                </div>
    
                <?php
                if (!empty($_SESSION['id'])) {
                    if ($com_row['usr_id'] == $_SESSION['id']) {
                        ?>
                        <div onclick="del(<?php echo($com_row['id']) ?>)" class="delete-com text-danger mr-2">
                            Delete
                        </div>
                        <?php
                    }} ?>
            </div>
        <?php
    }} ?>
    </div>
</div>
        
    <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            function loadData(){
                $.ajax({
                    url: 'php/select-data.php',
                    type: 'POST',
                    data: {post_id:<?php echo($id) ?>},
                    success:function(data){
                        $("#comment").html(data);
                    }
                });
            }

            loadData();
            
            $("#btn").on("click", function(e){
                e.preventDefault();
                var msg = $("#msg").val();
                if ($.trim(msg).length > 0) {
                    $.ajax({
                        url: 'php/insert-data.php',
                        type: 'POST',
                        data: {usr_id: <?php echo $_SESSION['id']?>, post_id: <?php echo $id ?>, comment: msg},
                        success: function(data){
                            if (data == 1) {
                                loadData();
                                $("#form").trigger("reset");
                            }else {
                                alert("Comment Can't Submit.");
                            }
                        }
                    });
                }
            });
            
            
        });
    <?php if(!empty($_SESSION['id'])){
        ?>
         function del(com_id){
            $(document).ready(function(){
                $.ajax({
                    url: 'php/delete_data.php',
                    type: 'POST',
                    data: {com_id: com_id},
                    success:function(data){
                        if(data == 1){
                            document.getElementById(com_id).style.display = "none";
                        }
                    }
                });
            });
        }
<?php }?>
    </script>
        
        <!-- cookie -->
        
        <?php include("cookie.php")?>
        
        
        <!-- /.container -->
        <script src="js/script.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/active.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>
<?php
}else {
    include("404.php");
}}else{
    include("404.php");
}
?> 