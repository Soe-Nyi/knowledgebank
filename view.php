<?php include('php/viewdata.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo($row['img']) ?>" type="image/x-icon">
    <meta content="<?php echo($row['img']) ?>" property="og:image" />
<link rel="icon" href="<?php echo($row['img']) ?>" type="image/x-icon">
<meta name="Description" content="<?php echo($row['des']) ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title><?php echo($row['name']) ?> </title>
<link rel="stylesheet" href="css/view.css">
<link rel="stylesheet" href="css/popup.css">
</head>
<body>
<div class="wrap">
<h1><?php echo($row['name']) ?></h1>
<div class="open">
📚
<a href="book.php" style="color: #666">
Other Book
</a>
</div>
<div class="image-container container">
<div class="cover">
<img src="<?php echo($row['img']) ?>">
</div>
<div class="form">
<div class="des" style="text-align: center">
<?php echo($row['des']) ?>
</div>
<div class="download">
<a href="download.php?id=<?php echo($row['id']) ?>" style="padding: 4px 20px; border: 1px solid #8111F9; border-radius: 4px; color: #8111F9; text-decoration: none">PDF Download ⬇</a>
</div>
<div class="det">
<ul class="fiz">
<li>File Size</li>
<?php
//$filesize = filesize($row['file']);
//$filesize = $filesize / (1000*1000);
?>
<li><?php echo(round($filesize, 2)) ?> Mb</li>
</ul>
<ul>
<li>Downloads</li>
<li><?php echo($row['download']) ?></li>
</ul>
</div>
</div>
</div>
</div>
<div class="popup-image">
    <span>&times;</span>
    <img src="" alt="">
</div>
<script src="js/popup.js"></script>
</body>
</html>