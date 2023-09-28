<?php
require_once 'config/config.php';
require_once 'includes/header.php';
require_once 'security.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <h2 class="w3-container w3-blue w3-center">Admin Dashboard</h2>
    <div class="w3-container">
        <p>Welcome <?php echo $_SESSION['username']; ?>,</p>
        
    </div>
    <h5 class="w3-center">Pending Posts</h5>
<?php
$sql = "SELECT COUNT(*) FROM `posts` WHERE `state`='pending'";
$result = mysqli_query($dbcon, $sql);
$r = mysqli_fetch_row($result);

$numrows = $r[0];
$rowsperpage = 50;
$totalpages = ceil($numrows / $rowsperpage);
$page = 1;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (INT)$_GET['page'];
}
if ($page > $totalpages) {
    $page = $totalpages;
}
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $rowsperpage;

$sql = "SELECT * FROM `posts` WHERE `state`='pending' ORDER BY id DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($dbcon, $sql);

if (mysqli_num_rows($result) < 1) {
    echo "No post found";
}
?>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="10%">Image</th>
                <th width="40%">Title</th>
                <th width="20%">Date</th>
                <th width="30%">Action</th>
            </tr>
        </thead>
<?php
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $image = $row['image'];
    $title = $row['title'];
    $about = $row['about'];
    $author = $row['usr_id'];
    $time = $row['date'];

    $permalink = "../more.php?id=".$id;
    ?>

        <tbody>
            <tr>
                <a href="../more.php?id=<?=$id?>" target="_blank">
                <td><?php echo $id ?></td>
                <td><img src="../<?php echo $image; ?>" style="width:100%;border-radius:10px" ></td>
                <td><?php echo htmlspecialchars(substr($title, 0, 50)); ?></td>
                <td><?php echo $time; ?></td>
                </a>
                <td>
                    <a href="approved.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a>
                    <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $id; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="del.php?id=<?php echo $id?>" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this row?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
        </tbody>
    <?php }?>
    </table>
<?php
// pagination
echo "<p><div class='w3-bar w3-center'>";
if ($page > 1) {
    echo "<a href='?page=1' class='w3-btn'><<</a>";
    $prevpage = $page - 1;
    echo "<a href='?page=$prevpage' class='w3-btn'><</a>";
}
$range = 3;
for ($i = ($page - $range); $i < ($page + $range) + 1; $i++) {
    if (($i > 0) && ($i <= $totalpages)) {
        if ($i == $page) {
            echo "<div class='w3-btn w3-blue w3-hover-green'> $i</div>";
        } else {
            echo "<a href='?page=$i' class='w3-btn w3-border'>$i</a>";
        }
    }
}
if ($page != $totalpages) {
    $nextpage = $page + 1;
    echo "<a href='?page=$nextpage' class='w3-btn'>></a>";
    echo "<a href='?page=$totalpages' class='w3-btn'>>></a>";
}
echo "</div></p></div>";

include("includes/footer.php");
