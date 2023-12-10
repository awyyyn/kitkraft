<?php 
    session_start();
    include "../db_connection.php"; 


    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    } 

    if($_SESSION['user_type'] == 'A'){ 
        header("location: ../admin/index.php");   
    }

    $sql = "SELECT * FROM users WHERE user_id=".$_SESSION['user_id']. " LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Student</title>
    
    
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="../styles.css" />
    
</head>
<body> 

    <nav style="z-index:10" class=" navbar fixed-top  navbar-expand-lg   navbar-light bg-light">
        
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
 
        <div class="navbar-collapse collapse " id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li  class="nav-item active ">
                    <a class="nav-link"  href="./index.php">Customize your own gift </a>
                </li>  
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item mx-4"> Log out </a> 
            
        </div>


    </nav>

    <div class="container-fluid pb-5 mt-5 pt-5"> 

        <div class="row  py-4 margin-x">  
            <div class="col mb-4" > 
                <?php 
                    $get_pending_order_sql = "SELECT COUNT(*) FROM orders where user_id=".$_SESSION['user_id']." AND order_status='P' LIMIT 1;";
                    $get_pending_order_exec = mysqli_query($conn, $get_pending_order_sql);
                    $pending_result = mysqli_fetch_row($get_pending_order_exec);
                   
                    $get_past_order_sql = "SELECT COUNT(*) FROM orders where user_id=".$_SESSION['user_id']." AND order_status='D' LIMIT 1;";
                    $get_past_order_exec = mysqli_query($conn, $get_past_order_sql);
                    $past_result = mysqli_fetch_row($get_past_order_exec);
                   
                ?>
                <a href="pending-orders.php" class="text-white ">
                    <button class="btn btn-info position-relative">
                        <?php 
                            if($pending_result[0] > 0){
                                echo "<span class='badge badge-danger  badge-pill position-absolute' style='top: -8px;right:-5px'>" . $pending_result[0] .  "</span>";
                            }
                        ?>
                        Pending Orders  
                    </button>
                </a>
                <a href="past-orders.php" class="text-white">
                    <button class="btn btn-secondary ml-4 position-relative">
                        <?php 
                            if($past_result[0] > 0){
                                echo "<span class='badge badge-danger  badge-pill position-absolute' style='top: -8px;right:-5px'>" . $pending_result[0] .  "</span>";
                            }
                        ?>
                        Past Orders 
                    </button>
                </a>
            </div>   
        </div>  


    </div> 
        
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>