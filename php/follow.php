<?php
session_start();
include('config.php');

if (isset($_POST['action']) && isset($_POST['action_id'])) {
    $usr_id = $_SESSION['id'];
    $action = $_POST['action'];
    $action_id = $_POST['action_id'];
    if ($action == 'Follow') {
        $sql = "INSERT INTO `follow_action` (`usr_id`, `action_id`) VALUES ($usr_id, $action_id)";
    } else {
        $sql = "DELETE FROM `follow_action` WHERE `follow_action`.`usr_id` = $usr_id && `action_id` = $action_id";
    }
   if (mysqli_query($conn,$sql)) {
       $data=1;
   }
   echo($data);
}
?>