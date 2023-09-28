<?php
ob_start();
session_start();

$dbhost 	= "localhost:3306";
$dbuser 	= "root";
$dbpass 	= "root";
$dbname 	= "knowledgebank";
$dbcon = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);