<?php
session_start();
include('php/config.php');
$id = mb_strimwidth("$id", 0, 20, "");
$id = strtolower((INT)$_GET['id']);
$id = str_replace(
    array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'order', 'by', 'group', 'and', 'union', 'select', 'null',
        ' ', '-', "'", '"', '+', '(', ')', '@', '!', '#', '$', '%', '^', '&', '*', '.', ':', '/', '=', '”', '~', '±', '×', '÷', '[', ']', '{', '}', '|', '`', '_', '<', '>', ',', '„', '”'), '', $id);
$id = htmlspecialchars(htmlspecialchars(htmlspecialchars($id)));
$id = urlencode(urlencode(urlencode(($id))));
$user = $_SESSION['id'];
$time = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Following</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="css/follow-state.css" rel="stylesheet">
</head>
<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">


        <div class="row row-space-2">
            <?php
            if (empty($user) && empty($id)) {
                $url = base64_encode("profile.php");
                header("location: login.php?url=$url");
            } elseif ($id == $_SESSION['id'] || empty($id)) {
                if (is_numeric($id) || empty($id)) {
                    $sql = "SELECT * FROM `follow_action` WHERE `usr_id`=$user";
                    $result = mysqli_query($conn, $sql);
                    $numRow = mysqli_num_rows($result); ?>
                    <h4 class="m-t-0 m-b-20" style="width:100%"><?=$numRow ?> Following</h4>

                    <?php $sql = "SELECT * FROM `follow_action` WHERE `usr_id`=$user";
                    $result = mysqli_query($conn, $sql);
                    if ($numRow > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $user2 = $row['action_id'];
                            $sql2 = "SELECT * FROM `users` WHERE `id`=$user2";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            ?>

                            <div class="col-md-6 m-b-2">
                                <div class="p-10 bg-white">
                                    <div class="media media-xs overflow-visible">
                                        <a class="media-left" href="profile.php?id=<?=$user2 ?>">
                                            <img src="<?=$row2['profile'] ?>" alt="" class="media-object rounded-circle">
                                        </a>
                                        <a class="media-left" href="profile.php?id=<?=$user2 ?>" style="color:black;text-decoration: none;">
                                            <div class="media-body valign-middle">
                                                <b class="text-inverse"><?=$row2['name'] ?></b>
                                            </div>
                                        </a>
                                        <div class="media-body valign-middle text-right overflow-visible">
                                            <?php
                                            $sql3 = "SELECT * FROM `follow_action` WHERE `action_id`=$user2 && `usr_id`=$user";
                                            $result3 = mysqli_query($conn, $sql3);
                                            $state = mysqli_num_rows($result3); ?>
                                            <input type="button" class="btn btn-primary" id="follow<?=$user2 ?>" value="<?php if ($state > 0) { echo('Unfollow'); } else { echo('Follow'); } ?>" onclick="follow<?=$user2 ?>()">
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript" charset="utf-8">
                                    function follow<?=$user2 ?>() {
                                        var action_id = <?=$user2 ?>;
                                        var action = $('#follow<?=$user2 ?>').val();
                                        $.ajax({
                                            url: 'php/follow.php',
                                            method: "POST",
                                            data: {
                                                action_id: action_id, action: action
                                            },
                                            cache: false,
                                            success: function() {
                                                if (action == 'Follow') {
                                                    $('#follow<?=$user2 ?>').val("Unfollow");
                                                } else {
                                                    $('#follow<?=$user2 ?>').val("Follow");
                                                }
                                            }
                                        });
                                    }
                                </script>
                            </div>

                            <?php
                        }}
                }} elseif (is_numeric($id)) {
                $query = "SELECT * FROM `users` WHERE `id`=$id";
                $res = mysqli_query($conn, $query);
                $data = mysqli_num_rows($res);

                if (!empty($data)) {
                    $sql = "SELECT * FROM `follow_action` WHERE `usr_id`=$id";
                    $result = mysqli_query($conn, $sql);
                    $numRow = mysqli_num_rows($result); ?>

                    <h4 class="m-t-0 m-b-20" style="width:100%"><?=$numRow ?> Following</h4>
                    <?php $sql = "SELECT * FROM `follow_action` WHERE `usr_id`=$id";
                    $result = mysqli_query($conn, $sql);
                    if ($numRow > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $user2 = $row['action_id'];
                            $sql2 = "SELECT * FROM `users` WHERE `id`=$user2";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            ?>
                            <div class="col-md-6 m-b-2">
                                <div class="p-10 bg-white">
                                    <div class="media media-xs overflow-visible">
                                        <a class="media-left" href="profile.php?id=<?=$user2 ?>">
                                            <img src="<?=$row2['profile'] ?>" alt="" class="media-object rounded-circle">
                                        </a>
                                        <a class="media-left" href="profile.php?id=<?=$user2 ?>" style="color:black;text-decoration: none;">
                                            <div class="media-body valign-middle">
                                                <b class="text-inverse"><?=$row2['name'] ?></b>
                                            </div>
                                        </a>
                                        <div class="media-body valign-middle text-right overflow-visible">
                                            <?php
                                            if (!empty($user)) {
                                                $sql3 = "SELECT * FROM `follow_action` WHERE `action_id`=$user2 && `usr_id`=$user";
                                                $result3 = mysqli_query($conn, $sql3);
                                                $state = mysqli_num_rows($result3);
                                            }
                                            if ($user != $user2) {
                                                ?>
                                                <input type="button" class="btn btn-primary" id="follow<?=$user2 ?>" value="<?php if ($state > 0) { echo('Unfollow'); } else { echo('Follow'); } ?>" onclick="follow<?=$user2 ?>()">
                                                <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript" charset="utf-8">
                                    function follow<?=$user2 ?>() {
                                        var action_id = <?=$user2 ?>;
                                        var action = $('#follow<?=$user2 ?>').val();
                                        $.ajax({
                                            url: 'php/follow.php',
                                            method: "POST",
                                            data: {
                                                action_id: action_id, action: action
                                            },
                                            cache: false,
                                            success: function() {
                                                <?php if (!empty($user)) {
                                                    ?>
                                                    if (action == 'Follow') {
                                                        $('#follow<?=$user2 ?>').val("Unfollow");
                                                    } else {
                                                        $('#follow<?=$user2 ?>').val("Follow");
                                                    }
                                                    <?php
                                                } else {
                                                    $url = base64_encode("following.php?id=$id");
                                                    ?>
                                                    location = 'login.php?url=<?=$url ?>'
                                                    <?php
                                                } ?>
                                            }
                                        });
                                    }
                                </script>
                            </div>
                            <?php
                        }}}} ?>
        </div>

    </div>

    <script>
        function updateUserStatus() {
            jQuery.ajax({
                url: 'update.php',
                success: function() {}
            });
        }

        updateUserStatus();
        setInterval(function() {
            updateUserStatus();
        }, 1000);
    </script>
    <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</body>
</html>