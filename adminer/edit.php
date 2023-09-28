<?php
require_once 'config/config.php';
require_once 'security.php';
$id = (INT)$_GET['id'];
$sql = "SELECT * FROM `posts` WHERE `id` = $id";
$result = mysqli_query($dbcon, $sql);
if (mysqli_num_rows($result) == 0) {
    header("location: approve.php");
}
$row = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM `about` WHERE `id` = $id";
$result = mysqli_query($dbcon, $sql);
$row2 = mysqli_fetch_assoc($result);

$title = $row['title'];
$description = $row2['about'];
$image = $row['image'];
$permalink = "approve.php";


if (isset($_POST['upd'])) {
    $title = mysqli_real_escape_string($dbcon, $_POST['title']);
    $description = mysqli_real_escape_string($dbcon, $_POST ['description']);
    $image = mysqli_real_escape_string($dbcon, $_POST['image']);
    $category = "Science";

    if (!empty($_FILES['logo']['name'])) {
        // name of the uploaded file
        $filename = $_FILES['logo']['name'];

        // destination of the file on the server
        $destination = '../images/' . $filename;
        $image2 = 'images/' . $filename;

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $_FILES['logo']['tmp_name'];
        $size = $_FILES['logo']['size'];

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            echo "You file extension must be .jpg, .jpeg or .png";
        } elseif ($_FILES['logo']['size'] > 3000000) {
            // file shouldn't be larger than 3Megabyte
            echo "File too large!";
        } elseif (move_uploaded_file($file, $destination)) {
            $sql = "UPDATE `posts` SET `image` = '$image2', `title` = '$title', `category` = '$category' WHERE `posts`.`id` = $id";
            $sql2 = "UPDATE `about` SET `about` = '$description' WHERE `about`.`id` = $id";
            if(mysqli_query($dbcon, $sql) && mysqli_query($dbcon, $sql2)){
                header("location: $permalink");
            }
        }
    } else {
        $sql = "UPDATE `posts` SET `image` = '$image', `title` = '$title', `category` = '$category' WHERE `posts`.`id` = $id";
        $sql2 = "UPDATE `about` SET `about` = '$description' WHERE `about`.`id` = $id";
        if(mysqli_query($dbcon, $sql) && mysqli_query($dbcon, $sql2)){
            header("location: $permalink");
        }
    }
}else{
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Administrator</title>

        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="assets/css/bootstrap.min.css"/>

        <!-- MetisMenu CSS -->
        <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="assets/js/jquery.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.19.1/ui/trumbowyg.min.css">
    </head>

    <body>
    <div class="w3-container">
    <div class="w3-card-4">

        <div class="w3-container w3-blue">
            <h2>Edit Post - </h2>
        </div>
            <h4 class="w3-container"><a href="<?=$permalink?>">Goto post</a> </h4>

        <form action="" method="POST" class="w3-container" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <p>
                <label>Title</label>
                <input type="text" class="w3-input w3-border" name="title" value="<?php echo $title; ?>">
            <p>
            <p>
                <label>Description</label>
                <textarea class="w3-input w3-border" id="description" name="description"><?php echo $description; ?> </textarea>
            </p>
            <p>
                <img class="photo" id="Logo" src="<?php echo($image)?>" />
                <input type="hidden" name="image" value="<?php echo($image)?>">
            </p>
            <p>
                <input type="file" name="logo" id="logo">
            </p>
            <p>
                <input type="submit" class="w3-btn w3-blue w3-round" name="upd" value="Save post">
            </p>

            <p>
            <div class="w3-text-red">
                <a href="del.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this post?'); ">Delete Post</a></div>
            </p>
        </form>
    </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#Logo').attr('src', e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}

$("#logo").change(function () {
readURL(this);
});

$('#description').trumbowyg();
</script>
<?php
}
mysqli_close($dbcon);
include("footer.php");
