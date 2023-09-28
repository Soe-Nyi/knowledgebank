<?php
session_start();
$session = $_SESSION['id'];
include("php/technology.php");
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
include('includes/header.php')
?>
    <!--navbar open-->
    <header class="bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="navbar navbar-expand-md navbar-dark bg-dark p-2">
                        <div href="" class="navbar-brand"> Technology </div>
                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbtn">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbtn">
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
                </div>
            </div>
        </div>
    </header>
    <!--navbar close-->

    <!-- Search Widget -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Search</button>
                </span>
            </div>
        </div>
    </div>

    <div class="image-container container mt-3">
    <?php foreach ($posts as $post): ?>
        <div class="row">
            <div class="col-lg-6 mt-2">
                <img src="<?php echo($post['image']) ?>" class="img-fluid rounded">
            </div>

            <div class="col-lg-6 mt-2">
                <h3> <?php echo($post['title']) ?> </h3>
                <?php
                $desc = $post['about'];
                $strCut = substr($desc, 0, 700);
                $desc = substr($strCut, 0, strrpos($strCut, ' ')) . '<a href="more.php?id=' .$post['id'] . '"> ....see more</a>';
                echo($desc);
                ?>
                <br>
                <footer class="blockquote-footer">
                    <?php
                    $user1 = $post['usr_id'];
                    $sql1 = "SELECT id,username FROM users WHERE id=$user1";
                    $resul1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_assoc($resul1);
                    ?>
                    Posted on  <time class="entry-date published updated" datetime=""><?php echo(getDateTimeDiff($post['date']))?> </time> by <a href="profile.php?id=<?php echo($row1['id']) ?>"><?php echo($row1['username']) ?></a> <b></b>
                </footer>
            </div>
            <div class="card my-0 col-sm-12">
                <div class="card-header">
                    <div class="">
                        <?php
                        if (!empty($_SESSION['id'])) {
                            ?>
                            <i <?php if (userLiked($post['id'])): ?> class="fa fa-thumbs-up like-btn" <?php else : ?> class="fa fa-thumbs-o-up like-btn" <?php endif ?> data-id="<?php echo $post['id'] ?>"></i>
                            <span class="likes"><?php echo getLikes($post['id']); ?></span>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <i <?php if (userDisliked($post['id'])): ?> class="fa fa-thumbs-down dislike-btn" <?php else : ?> class="fa fa-thumbs-o-down dislike-btn" <?php endif ?> data-id="<?php echo $post['id'] ?>"></i>
                            <span class="dislikes"><?php echo getDislikes($post['id']); ?></span>
                            <?
                        } else {
                            ?>
                            <a href="login.php"><i <?php if (userLiked($post['id'])): ?> class="fa fa-thumbs-up like-btn" <?php else : ?> class="fa fa-thumbs-o-up like-btn" <?php endif ?> data-id="<?php echo $post['id'] ?>"></i></a>
                            <span class="likes"><?php echo getLikes($post['id']); ?></span>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="login.php"><i <?php if (userDisliked($post['id'])): ?> class="fa fa-thumbs-down dislike-btn" <?php else : ?> class="fa fa-thumbs-o-down dislike-btn" <?php endif ?> data-id="<?php echo $post['id'] ?>"></i></a>
                            <span class="dislikes"><?php echo getDislikes($post['id']); ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="hidden" class="link" value="<?php echo($post['id']) ?>" />
                    <script src="js/share.js" type="text/javascript" charset="utf-8" defer></script>
                    <i id="shareBtn" class="ml-auto fa fa-share" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    <hr>
    <?php endforeach ?>
    </div>
<!--content container close-->

<!--pagination open-->
<div class="bg-secondary p-1 mt-3">
    <ul class="pagination pagination-md mt-3 justify-content-center">
        <?php 
                $pr_query = "select * from posts";
                $pr_result = mysqli_query($conn,$pr_query);
                $total_record = mysqli_num_rows($pr_result);
                
                $total_page = ceil($total_record/$num_per_page);
                if($page>1){
                echo "<li class='page-item'><a href='index.php?page=".($page-1)."' class='page-link'>Previous</a></li>";
                }
                if ($total_page>$page) {
                    $page_num= $page+5;
                }
                for($i=$page;$i<$page_num;$i++)
                { 
                if($i<$total_page){
                ?>
                    <a href='index.php?page=<?php echo $i?>' class='<?php if($page==$i){echo('btn btn-primary');}else{echo('page-link');}?>'><?php echo $i?></a>
                <?php }}
                if($total_page>$page)
                {
                    echo "<li class='page-item'><a href='index.php?page=".($page+1)."' class='page-link'>Next</a></li>";
                }
        ?>
    </ul>
</div>
<!--pagination close-->

<?php include 'includes/footer.php'?>