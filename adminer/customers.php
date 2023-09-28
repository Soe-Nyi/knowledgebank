<?php
session_start();
require_once 'config/config.php';
require_once 'includes/auth_validate.php';

$sql = "SELECT * FROM `users` ORDER BY id DESC";
$result = mysqli_query($dbcon, $sql);

include 'includes/header.php';
?>

<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Customers</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_customer.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
            </div>
        </div>
    </div>



    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to Excle <i class="glyphicon glyphicon-export"></i></button></a>
    </div>

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="45%">Name</th>
                <th width="20%">Gender</th>
                <th width="20%">Phone</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row=mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <a href="edit_customer.php?customer_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_customer.php?id=<?php echo $row['id']?>" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>
                                    Are you sure you want to delete this row?
                                </p>
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
            <?php }?>
        </tbody>
    </table>
    <!-- //Table -->

</div>
<!-- //Main container -->
<?php include 'includes/footer.php' ?>