<?php
session_start();
include('config.php');
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $sql = "SELECT * FROM `comment_info` WHERE `comment_info`.`post_id` = $post_id";
    $result = mysqli_query($conn, $sql);
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