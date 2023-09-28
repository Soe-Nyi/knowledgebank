<?php
$con = mysqli_connect("localhost:3306", "root", "root", "knowledgebank"); 
if (isset($_POST["submit"])) { 
    //name
    $name = $_POST['name'];
    //des
    $des = $_POST['des'];
    //img
    $target_dirimg = "../images/";
    $target_img = $target_dirimg . basename($_FILES["imgUpload"]["name"]);
    $image = 'images/' . $_FILES["imgUpload"]["name"];
    $allowd_img_ext = array("jpg", "jpeg", "png");
    $imageExt = strtolower(pathinfo($target_img, PATHINFO_EXTENSION));
    //file
    $target_dirfiles = "../files/";
    $target_file = $target_dirfiles . basename($_FILES["fileUpload"]["name"]);
    $file = 'files/' . $_FILES["fileUpload"]["name"];
    $allowd_file_ext = array("pdf");
    $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    //type
    $type = $_POST['type'];
    //DATE
    $date = date("d.m.Y");
    //post data
    if (!file_exists($_FILES["imgUpload"]["tmp_name"]) || !file_exists($_FILES["fileUpload"]["tmp_name"])) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "Select image or file to upload."
        );
    } else if (!in_array($imageExt, $allowd_img_ext) || !in_array($fileExt, $allowd_file_ext)) {
        $resMessage = array(
            "status" => "alert-danger",
            "message" => "Allowed file formats."
        );
    
    } else {
        if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_img) & move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO post (name,des,img,file,type,date,download)
                VALUES ('$name', '$des', '$image', '$file', '$type', '$date' , 0)";
            if (mysqli_query($con, $sql)) {
                $stmt = $con->prepare($sql);
                if ($stmt->execute()) {
                    $resMessage = array(
                        "status" => "alert-success",
                        "message" => "Uploaded successfully."
                    );
                } else {
                    $resMessage = array(
                        "status" => "alert-danger",
                        "message" => "Coudn't be uploaded."
                    );
                }
                    include('../php/config.php');
                    $sql = "SELECT * FROM admin";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $change = $row['upload']+1;
                        }
                    }
                    $sql = "UPDATE admin SET upload='$change' WHERE id=1";
                    mysqli_query($con, $sql);
                }
            }
        }
    }

    ?>