<?php
include('php/config.php');
$id = $_GET['id'];
if (is_numeric($id)) {
    $sql = "SELECT * FROM book WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $filepath = $row['file'];
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($row['file']));

        //This part of code prevents files from being corrupted after download
        ob_clean();
        flush();

        readfile($filepath);
        // Now update downloads count
        $newCount = $row['download'] + 1;
        $updateQuery = "UPDATE post SET download=$newCount WHERE id=$id";
        mysqli_query($con, $updateQuery);
        exit;
    }else{
        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Download : <?php echo($row['name'])?></title>
        <style>
            .state{
                font-size: 30px;
                text-align: center;
                margin: 20px 0 10px 0;
                text-shadow: 2px 2px 2px #777;
            }
            .report{
                font-size: 20px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="state">
            The file no longer exists.
        </div>
        <div class="report">
            <a href="">[ report ]</a>
        </div>
    </body>
</html>
        <?php
    }
} else {
    header("location: view.php?id=$id");
}
?>