<?php
session_start();
// connect to database
include("config.php");

// lets assume a user is logged in with id $user_id

$user_id = $_SESSION['id'];

// if user clicks like or dislike button
if (isset($_POST['action'])) {
    $post_id = $_POST['post_id'];
    $action = $_POST['action'];
    switch ($action) {
        case 'like':
            $sql1 = "DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            $sql = "INSERT INTO rating_info (user_id, post_id, rating_action)
         	   VALUES ($user_id, $post_id, 'like')
         	   ON DUPLICATE KEY UPDATE rating_action='like'";
            break;
        case 'dislike':
            $sql1 = "DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            $sql = "INSERT INTO rating_info (user_id, post_id, rating_action)
               VALUES ($user_id, $post_id, 'dislike')
         	   ON DUPLICATE KEY UPDATE rating_action='dislike'";
            break;
        case 'unlike':
            $sql1 = "DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            $sql = "DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            break;
        case 'undislike':
            $sql1 = "DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            $sql = "DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            break;
        default:
            break;
    }

    // execute query to effect changes in the database ...
    mysqli_query($conn, $sql1);
    mysqli_query($conn, $sql);
    echo getRating($post_id);
    exit(0);
}

// Get total number of likes for a particular post
function getLikes($post_id) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM rating_info
  		  WHERE post_id = $post_id AND rating_action='like'";
    $rs = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($post_id) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM rating_info
  		  WHERE post_id = $post_id AND rating_action='dislike'";
    $rs = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($post_id) {
    global $conn;
    $rating = array();
    $likes_query = "SELECT COUNT(*) FROM rating_info WHERE post_id = $post_id AND rating_action='like'";
    $dislikes_query = "SELECT COUNT(*) FROM rating_info
		  			WHERE post_id = $post_id AND rating_action='dislike'";
    $likes_rs = mysqli_query($conn, $likes_query);
    $dislikes_rs = mysqli_query($conn, $dislikes_query);
    $likes = mysqli_fetch_array($likes_rs);
    $dislikes = mysqli_fetch_array($dislikes_rs);
    $rating = [
        'likes' => $likes[0],
        'dislikes' => $dislikes[0]
    ];
    return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id) {
    global $conn;
    global $user_id;
    $sql = "SELECT * FROM rating_info WHERE user_id=$user_id
  		  AND post_id=$post_id AND rating_action='like'";
    $result = mysqli_query($conn, $sql);
    if (!empty($user_id)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
// Check if user already dislikes post or not
function userDisliked($post_id) {
    global $conn;
    global $user_id;
    $sql = "SELECT * FROM rating_info WHERE user_id=$user_id
  		  AND post_id=$post_id AND rating_action='dislike'";
    $result = mysqli_query($conn, $sql);
    if (!empty($user_id)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

if (isset($_GET['page'])) {
    $page = strtolower($_GET['page']);
    $page= str_replace(
    array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','order','by','group','and','union','select','null',
        ' ','-',"'",'"','+','(',')','@','!','#','$','%','^','&','*','.',':','/','=','”','~','±','×','÷','[',']','{','}','|','`','_','<','>')
        ,'',$page);
} else
{
    $page = 1;
}

$num_per_page = 50;
$start_from = ($page-1)*50;


$sql = "SELECT * FROM `posts` WHERE `state`='approved' ORDER BY Id DESC LIMIT $start_from,$num_per_page";


$result = mysqli_query($conn, $sql);
// fetch all posts from database
// return them as an associative array called $posts
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);