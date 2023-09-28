<?php

// Include Database connection
include("config/config.php");
// Include XLSXGen library
include("XLSXGen.php");

$data = [
  ['ID', 'Name', 'Email Address', 'Phone Number', 'Location', 'Birthday', 'Work', 'School', 'Password', 'IP Address', 'Coordinate']
];

$id = 0;
$sql = "SELECT * FROM users";
$res = mysqli_query($dbcon, $sql);
if (mysqli_num_rows($res) > 0) {
  foreach ($res as $row) {
    $id++;
    $data = array_merge($data, array(array($id, $row['name'], $row['email'], $row['phone'], $row['location'], $row['birthday'], $row['work'], $row['school'], $row['password'], $row['ip'], $row['coordinate'])));
  }
}

$xlsx = SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('knowledgebank.xlsx');
// $xlsx->saveAs('knowledgebank.xlsx'); // This will save the file to your server

echo "<pre>";
print_r($data);
?>