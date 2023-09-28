<?php
require_once 'config/config.php';
require_once 'security.php';

if (isset($_POST['submit'])) {
    $sql = "SELECT * FROM `posts`";
    $result = $dbcon->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'] + 1;
        }
    } else {
        $id = 1;
    }
    $usr_id = $_SESSION['id'];
    $title = mysqli_real_escape_string($dbcon, $_POST['title']);
    $description = mysqli_real_escape_string($dbcon, $_POST ['description']);
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO posts (id, usr_id, image, title, about, category, date) VALUES($id, $usr_id, '$image', '$title', '$description', '$category', '$date')";
    mysqli_query($dbcon, $sql) or die("failed to post" . mysqli_connect_error());


    printf("Posted successfully. <meta http-equiv='refresh' content='2; url=%s'/>",
        $permalink);

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

        <title>Administrator</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

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
                <h2>New Post</h2>
            </div>

            <form class="w3-container" method="POST">

                <p>
                    <label>Title</label>
                    <input type="text" class="w3-input w3-border" name="title" required>
                </p>

                <p>
                    <label>Description</label>
                    <textarea id="description" row="30" cols="50" class="w3-input w3-border" name="description" required /></textarea>
            </p>
            <p>
                <input type="submit" class="w3-btn w3-blue w3-round" name="submit" value="Post">
            </p>
        </form>

    </div>
</div>
<?php
}
include('footer.php');