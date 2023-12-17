<?php 

    include_once "../db_connection.php";
    session_start();
    
        
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }

    if($_SESSION['user_type'] == 'U'){
        header("location: ../user/index.php");   
    } 


    $sql = "SELECT date_ordered, order_id, order_status FROM `orders` WHERE order_status = 'D' GROUP BY `date_ordered`";
    $exe_sql = mysqli_query($conn, $sql);
  
    $total_all = 0;
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
    <nav style="z-index:10" class=" navbar fixed-top  shadow-lg navbar-expand-lg   navbar-light bg-light">
        
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
 
        <div class="navbar-collapse collapse " id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li  class="nav-item  ">
                    <a class="nav-link"  href="./index.php">Home</a>
                </li>  
                <li  class="nav-item  ">
                    <a class="nav-link"  href="./manage.php">Manage Material</a>
                </li>    
                <li  class="nav-item  ">
                    <a class="nav-link"  href="./orders.php">Manage Orders</a>
                </li>   
                
                <li  class="nav-item  active">
                    <a class="nav-link"  href="./reports.php">Reports</a>
                </li>   
            </ul>
            <form class="form-inline my-lg-0 mr-3" action="./search.php" method="get">
                <input class="form-control form-control-sm mr-sm-2 " type="text" name="search" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item btn btn-sm btn-outline-danger d-block shadow-sm"> Log out </a> 
            
        </div>


    </nav>   
    
    
    <div class="container mt-5 py-5">
        <div class="row ">
            <div class="col d-flex justify-content-between align-items-end">
                <h1>Daily Reports</h1>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col col-12"> 
                <div id="accordion" role="tablist">
                    <?php 
                        while($row = mysqli_fetch_assoc($exe_sql)){
                            $query_by_day = "SELECT * FROM `orders` WHERE `date_ordered` = '".$row['date_ordered']."' AND `order_status` = 'D'";
                            // $query_by_day = "SELECT * FROM `orders` WHERE `date_ordered` = '".$row['date_ordered']."' AND `order_status` != 'C' AND `order_status` != 'P'";
                            $exe_by_day = mysqli_query($conn, $query_by_day);
                            
                            // if($row['order_status'] == 'D'){

                    ?>
                        <div class="card">
                            <div class="card-header  pointer" role="tab" id="headingOne" data-toggle="collapse" href="#collapse-<?php echo $row['order_id'] ?>" aria-expanded="true" aria-controls="collapseOne">
                                <h5><?php echo $row['date_ordered'];  ?>  Report</h5>
                                 
                            </div>

                            <div id="collapse-<?php echo $row['order_id'] ?>" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body d-flex justify-content-between">
                                    <?php 
                                        $total = 0;
                                        while($row2 = mysqli_fetch_assoc($exe_by_day)){
                                            $total += $row2['price']; 
                                        }
                                    ?>
                                    <h3>
                                        <?php echo $row['date_ordered'];  ?> Total Sale : 
                                    </h3>
                                    <h3 class="font-weight-bold">₱ <?php echo $total; ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php
                            // }

                            $total_all += $total;
                        }
                    ?>
                    <div class="d-flex mt-3 justify-content-end">
                        
                        <h3 class="font-weight-bold">TOTAL SALE: ₱ <?php echo $total_all; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>