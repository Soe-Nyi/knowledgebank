<?php
session_start();
include('php/config.php');
$url = base64_encode('post.php');
if (empty($_SESSION['id'])) {
    header("location: login.php?url=$url");
}
if (isset($_POST['submit'])) {
    $sql = "SELECT * FROM `posts`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'] + 1;
        }
    } else {
        $id = 1;
    }

    // name of the uploaded file
    $filename = $_FILES['logo']['name'];

    // destination of the file on the server
    $destination = 'images/' . $filename;

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
        $usr_id = $_SESSION['id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST ['description']);
        $category = "Science";
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `posts` (`id`, `usr_id`, `image`, `title`, `category`, `date`) VALUES ($id, $usr_id, '$destination', '$title', 'Science', '$date')";
        $sql2 = "INSERT INTO `about` (`id`, `about`) VALUES($id,'$description')";
        if(mysqli_query($conn, $sql2) && mysqli_query($conn, $sql)){
            header('location: index.php');
        }

        printf("Posted successfully. <meta http-equiv='refresh' content='2; url=%s'/>",
            $permalink);
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Knowledge Bank</title>

        <!-- Bootstrap Core CSS -->

        <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- MetisMenu CSS -->
    <link href="js/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="js/jquery.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="css/post.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.19.1/ui/trumbowyg.min.css">
    <style type="text/css" media="all">
        #Logo{
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="w3-container">
        <div class="w3-card-4">
            <div class="w3-container w3-blue">
                <h2>New Post</h2>
            </div>

            <form action="" class="w3-container" method="POST" enctype="multipart/form-data">

                <p>
                    <label>Title</label>
                    <input type="text" class="w3-input w3-border" name="title" required>
                </p>

                <p>
                    <label>Description</label>
                    <textarea id="description" row="30" cols="50" class="w3-input w3-border" name="description" required /></textarea>
            </p>
            <p>
                <img class="photo" id="Logo" src="" />
            </p>
            <p>
                <input type="file" name="logo" id="logo"  accept="image/png, image/jp, image/jpeg">
            </p>
        <p>
            <input type="submit" class="w3-btn w3-blue w3-round" name="submit" value="Post">
        </p>
    </form>

</div>
</div>
<?php
} ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/trumbowyg.min.js"></script>
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

</body>