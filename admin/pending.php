<?php 

    include_once "../db_connection.php";
    session_start();
    
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }

    if($_SESSION['user_type'] == 'U'){
        header("location: ../user/index.php");   
    } 


    /* users sql */
    $orders_sql = "SELECT * FROM orders WHERE order_status = 'P';";
    $exe_orders_sql = mysqli_query($conn, $orders_sql);
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Admin</title>
    
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="../styles.css" />
    
    
</head>
<body> 
    <nav class="navbar fixed-top navbar-expand-lg   navbar-light bg-light">
    
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="navbar-collapse collapse " id="navbarTogglerDemo02" style="">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item ">
                    <a class="nav-link " href="./index.php">Manage Materials </a>
                </li>  
                <li class="nav-item ">
                    <a class="nav-link" href="./users.php">Users </a>
                </li>  
                <li class="nav-item active"> 
                    <a class="nav-link" href="./orders.php">Orders </a>
                </li>  
            </ul>
            
            
            <form class="form-inline my-2 my-lg-0 mr-4">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
             
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item mx-4"> Log out </a> 
            
        </div> 
    </nav>
    
    
    <div class="container mt-5 pb-3 pt-5">
        <div class="row">
            <div class="col d-flex flex-wrap justify-content-between align-items-center ">
                <h1  >Orders</h1>
                <div class="d-flex flex-wrap justify-content-around gap-y mt-4">
                    <a href="orders.php" class="btn rounded-lg shadow-lg btn-outline-primary"> 
                        All
                    </a>
                    <a href="pending.php" class="btn rounded-lg shadow-lg btn-primary mx-4"> 
                        Pending
                    </a>
                    <a href="otw.php" class="btn rounded-lg shadow-lg btn-outline-primary"> 
                        On the way
                    </a>
                    <a href="cancelled.php" class="btn rounded-lg shadow-lg btn-outline-primary mx-4"> 
                        Cancelled
                    </a>
                    
                    <a href="delivered.php" class="btn rounded-lg shadow-lg btn-outline-primary"> 
                        Delivered
                    </a>
                </div>
            </div>
        </div>
         
        <?php
            if(mysqli_num_rows($exe_orders_sql) > 0){
        ?>

        <div class="row mt-4"> 
            <div class="card-columns col ">
                <?php
                    $order_count = 0;
                    while($order = mysqli_fetch_assoc($exe_orders_sql)){
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
                                <span class='badge badge-warning  px-2 py-1'>Pending</span>
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
                            <button data-toggle="modal" data-target="#modal-<?php echo $order['order_id']; ?>" href="cancel-order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-info w-100">Ship Order</button>
                            <!-- Modal -->
                            <div class="modal fade" id="modal-<?php echo $order['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModal3Label">Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Confirm Ship Order #<?php echo $order['order_id']; ?>?</h3>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                                            <a href="ship.php?id=<?php echo $order['order_id']; ?>"  class="btn btn-info">Confirm</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
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
        
            <div class="row d-flex mt-5 justify-content-center"> 
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