<?php 
    session_start();
    include "../db_connection.php"; 


    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    } 

    if($_SESSION['user_type'] == 'A'){ 
        header("location: ../admin/index.php");   
    }

    $sql = "SELECT * FROM orders WHERE user_id=".$_SESSION['user_id']. " AND order_status='P';";
    $orders = mysqli_query($conn, $sql); 

   

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
                <li  class="nav-item ">
                    <a class="nav-link"  href="./to-receive.php">To receive</a>
                </li>  
            </ul>
            <form class="form-inline my-lg-0 mr-3" action="./search.php" method="get">
                <input class="form-control form-control-sm mr-sm-2 " type="text" name="search" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item btn btn-sm btn-outline-danger d-block shadow-sm"> Log out </a> 
            
        </div>


    </nav>

    
    <div class="container-fluid padding-x pb-5 mt-5 pt-5"> 
        <div class="row  py-4  pl-2">  
            <div class="col mb-4"  > 
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
                            // if($past_result[0] > 0){
                            //     echo "<span class='badge badge-danger  badge-pill position-absolute' style='top: -8px;right:-5px'>" . $pending_result[0] .  "</span>";
                            // }
                        ?>
                        Past Orders 
                    </button>
                </a>
            </div>   
        </div>
        
        <?php
            if(mysqli_num_rows($orders) > 0){
        ?>

        <div class="row"> 
            <div class="card-columns col ">
                <?php
                    $order_count = 0;
                    while($order = mysqli_fetch_assoc($orders)){
                        $order_count++;
                        $orders_id = [];
                        $total_price = 0;
                        for($i = 1; $i <= 4; $i++){
                            $s_id = "step$i";
                            if($order[$s_id] != 0){
                                array_push($orders_id, $order[$s_id]);
                            }
                        }

                ?>
                    <div class="card m-2 ">  
                        <div class="card-header">
                            <h3 class="card-text">Order #<?php echo $order_count; ?></h3>
                            <div class="d-flex flex-wrap gap-sm-y justify-content-between align-items-center">
                                <span class="badge badge-dark mb-2 text-white"><?php echo $order['date_ordered']; ?></span>
                                <span class='badge badge-info  px-2 py-1'>Pending</span> 
                            </div>
                        </div>
                        <div class="card-body">
                            <?php 
                                for($i = 0; $i < count($orders_id); $i++){  
                                    $material_sql = "SELECT * FROM materials WHERE material_id='".$orders_id[$i] ."' LIMIT 1;";
                                    $exe_sql = mysqli_query($conn, $material_sql); 
                                    $fetch_material = mysqli_fetch_assoc($exe_sql);
                                    $total_price +=  $fetch_material['material_price'];
                            ?>
                                <div class="d-flex w-full justify-content-between align-items-center">
                                    <p class="card-text"><?php  echo $fetch_material['material_name']; ?> </p>
                                    <p class="card-text"><?php  echo $fetch_material['material_price']; ?> </p>
                                </div>
                            <?php  
                                }
                            ?>
                            <div class="d-flex w-full justify-content-between align-items-center">
                                <p class="card-text">Quantity</p>
                                <p class="card-text"><?php echo $order['order_qty']; ?></p>
                            </div>
                            <div class="d-flex w-full justify-content-between align-items-center">
                                <p class="card-text">Total  Price</p>
                                <p class="card-text"><?php echo $total_price * $order['order_qty']; ?></p>
                            </div>
                            <a href="cancel-order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-danger w-100">Cancel order</a>
                        </div>
                    </div> 
                <?php 
                    }
                ?>
            </div>
        </div>
        <?php 
            }else{
        ?>
        
            <div class="row d-flex justify-content-center"> 
                <div class="col col-md-8 py-3 bg-info rounded-lg shadow-lg">
                    <h1 class="text-center text-white">No orders yet</h1>
                </div>    
            </div>

        <?php } ?>
    </div>

        
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>