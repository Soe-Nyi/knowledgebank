<?php
    include 'config.php';

    $usr_id = htmlspecialchars($_POST['usr_id']);
    $post_id = htmlspecialchars($_POST['post_id']);
    $msg = htmlspecialchars($_POST['comment']);
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO comment_info (usr_id, post_id, comment, createdOn) VALUES ('$usr_id', '$post_id', '$msg', '$date')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 1;
    }else {
        echo 0;
    }
?>