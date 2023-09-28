<?php
session_start();
include('php/config.php');
$session = $_SESSION['id'];
include('includes/header.php')?>

    <!--navbar open-->
    <header class="bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="navbar navbar-expand-md navbar-dark bg-dark p-2">
                        <div href="" class="navbar-brand"> Books </div>
                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbtn">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbtn">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Category
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="science.php">Science</a>
                                        <a class="dropdown-item" href="technology.php">Technology</a>
                                        <a class="dropdown-item" href="book.php">Books</a>
                                    </div>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="profile.php"> Profile </a></li>
                            <?php
                                if($_SESSION['admin_type'] == 'super' || $_SESSION['admin_type'] == 'admin'){
                                ?>
                                <li class="nav-item"><a class="nav-link" href="adminer/"> Admin </a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--navbar close-->

    <!-- Search Widget -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Search</button>
                </span>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <ul class="book-list">
            
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else
        {
            $page = 1;
        }
        
        $num_per_page = 50;
        $start_from = ($page-1)*50;
                
        $sql = "SELECT * FROM book ORDER BY Id DESC LIMIT $start_from,$num_per_page";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            
        while ($row = $result->fetch_assoc()) {
            
        ?>
            <li>
                <div class="type">
                    <?php echo($row['type']) ?>
                </div>
                <div class="book-thumb book-thumb-big">
                    <a href="view.php?id=<?php echo($row['id']) ?>" class="img-link">
                        <img src="<?php echo($row['img']) ?>">
                    </a>
                </div>
                <div class="book-des">
                    <a href="view.php?id=<?php echo($row['id']) ?>"><?php echo($row['name']) ?></a> - <?php echo($row['des']) ?><br>
            
                    <a href="download.php?id=<?php echo($row['id']) ?>">PDF Download ⬇</a>
                </div>
            </li>
        <?php
        }
        
        } ?>
        </ul>
    <hr>
</div>
<!--content container close-->

<!--pagination open-->
<div class="bg-secondary p-1 mt-3">
    <ul class="pagination pagination-md mt-3 justify-content-center">
        <?php 
                $pr_query = "select * from posts";
                $pr_result = mysqli_query($conn,$pr_query);
                $total_record = mysqli_num_rows($pr_result);
                
                $total_page = ceil($total_record/$num_per_page);
                if($page>1){
                echo "<li class='page-item'><a href='index.php?page=".($page-1)."' class='page-link'>Previous</a></li>";
                }
                if ($total_page>$page) {
                    $page_num= $page+5;
                }
                for($i=$page;$i<$page_num;$i++)
                { 
                if($i<$total_page){
                ?>
                    <a href='index.php?page=<?php echo $i?>' class='<?php if($page==$i){echo('btn btn-primary');}else{echo('page-link');}?>'><?php echo $i?></a>
                <?php }}
                if($total_page>$page)
                {
                    echo "<li class='page-item'><a href='index.php?page=".($page+1)."' class='page-link'>Next</a></li>";
                }
        ?>
    </ul>
</div>
<!--pagination close-->

<?php include 'includes/footer.php'?>