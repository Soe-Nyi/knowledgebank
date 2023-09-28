<?php
session_start();
include ('php/config.php');
$array = array();
$rows = array();
$user = $_SESSION['id'];
$follow = "SELECT * FROM `follow_action` WHERE `usr_id`=$user";
$fresult = mysqli_query($conn, $follow);
while ($frow = mysqli_fetch_assoc($fresult)) {
    $usr_id = $frow['action_id'];
    $sql = "SELECT * FROM `posts` WHERE `usr_id`=$usr_id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $about_id = $row['id'];

        $noti = "SELECT * FROM `noti` WHERE `usr_id`=$user && `post_id`=$about_id";
        $res = mysqli_query($conn, $noti);
        $numRow = mysqli_num_rows($res);

        if ($numRow <= 0) {
            $sql2 = "SELECT * FROM `about` WHERE `id`=$about_id";
            $result2 = mysqli_query($conn, $sql2);
            $about = mysqli_fetch_assoc($result2);
            $data['title'] = $row['title'];
            $msg = str_replace("<p>", "", $about['about']);
            $data['msg'] = mb_strimwidth("$msg", 0, 100, "");
            $data['icon'] = $row['image'];
            $data['url'] = 'more.php?id='.$row['id'];
            $rows[] = $data;
        }
    }
}
$array['notif'] = $rows;
$array['result'] = true;
echo json_encode($array);
?>