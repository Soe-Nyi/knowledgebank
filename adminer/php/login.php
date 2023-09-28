<?php
include('config.php');
$sql = "SELECT * FROM login";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $password = $row['password'];
    }
} else {
    $sql = "INSERT INTO login(id,username,password)
    VALUES ('1','admin','root')";
    $username = "admin";
    $password = "root";
}
// if (isset($_POST['submit'])) {
//     $usr = $_POST['usr'];
//     $pas = $_POST['pas'];
//     $sql = "UPDATE admin SET username='$usr' password='$pas' WHERE id=1";
//     if ($con->query($sql) === TRUE) {
//         echo "Record updated successfully";
//     } else {
//         echo "Error updating record: " . $con->error;
//     }
// }
?>