 
<?php 
    session_start();
    include "../db_connection.php"; 


    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    } 

    if($_SESSION['user_type'] == 'A'){ 
        header("location: ../admin/index.php");   
    }

    if(empty($_GET['step_1']) && empty($_GET['step_2']) && empty($_GET['step_3']) && empty($_GET['step_4'])){
        header("location: ./index.php?error=Please select a product");   
    }
     

    $products_to_checkout = []; 

    if(!empty($_GET['step_1'])){
        $sql_step_1 = "SELECT material_name, material_price FROM materials WHERE material_id=".$_GET['step_1']." LIMIT 1;";
        $exe_step_1 = mysqli_query($conn, $sql_step_1);
        $fetch_step_1 = mysqli_fetch_assoc($exe_step_1);
        $products_to_checkout[] = "" . $fetch_step_1['material_name'] . "," . $fetch_step_1['material_price'] . "";
    }

    if(!empty($_GET['step_2'])){
        $sql_step_2 = "SELECT material_name, material_price FROM materials WHERE material_id=".$_GET['step_2']." LIMIT 1;";
        $exe_step_2 = mysqli_query($conn, $sql_step_2);
        $fetch_step_2 = mysqli_fetch_assoc($exe_step_2);
        $products_to_checkout[] = "" . $fetch_step_2['material_name'] . "," . $fetch_step_2['material_price'] . "";
    }

    if(!empty($_GET['step_3'])){
        $sql_step_3 = "SELECT material_name, material_price FROM materials WHERE material_id=".$_GET['step_3']." LIMIT 1;";
        $exe_step_3 = mysqli_query($conn, $sql_step_3);
        $fetch_step_3 = mysqli_fetch_assoc($exe_step_3);
        $products_to_checkout[] = "" . $fetch_step_3['material_name'] . "," . $fetch_step_3['material_price'] . "";
    }

    if(!empty($_GET['step_4'])){
        $sql_step_4 = "SELECT material_name, material_price FROM materials WHERE material_id=".$_GET['step_4']." LIMIT 1;";
        $exe_step_4 = mysqli_query($conn, $sql_step_4);
        $fetch_step_4 = mysqli_fetch_assoc($exe_step_4);
        $products_to_checkout[] = "" . $fetch_step_4['material_name'] . "," . $fetch_step_4['material_price'] . "";
    }
 
 
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
        <div class="row  py-4  ">  
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
      
        <div class="row justify-content-around   ">
            <div class="col-12 col-lg-3 bg-white shadow-lg rounded-lg"> 
                <h3 class="mt-1 py-2 color-1">Order Summary</h3>  
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th class="text-center">Name</th>
                            <th class="text-right">Price</th>  
                        </tr>
                    </thead> 
                        <?php 
                            $total_price = 0; 
                            for($i = 0; $i < count($products_to_checkout); $i++){
                                $product = explode(",", $products_to_checkout[$i]);
                                $total_price += $product[1];
                                echo "<tr>";
                                    echo "<td>" . $i + 1 . "</td>";
                                    echo "<td class='text-center'>" . $product[0] . "</td>";
                                    echo "<td class='text-right'>" . $product[1] . "</td>";
                                echo "</tr>";
                            }
                        ?> 
                        <tr class="bg-light">
                            <td colspan="2">Quantity</td>
                            <td class="text-right">
                                <?php 
                                    echo $_GET['quantity'];
                                ?>
                            </td>
                        </tr>
                        <tr class="bg-color-1 text-white">
                            <td colspan="2">Total</td>
                            <td class="text-right">
                                <?php 
                                    echo $total_price * $_GET['quantity'];
                                ?>
                            </td>
                        </tr> 
                </table>
                <form method="post" action="checkout.php">
                    <?php 
                        if(!empty($_GET['step_1'])){
                            echo "<input type=\"hidden\" name=\"step_1\" value='" . $_GET['step_1'] . "' />";
                        } 
                        if(!empty($_GET['step_2'])){
                            echo "<input type=\"hidden\" name=\"step_2\" value='" . $_GET['step_2'] . "' />";
                        }
                        if(!empty($_GET['step_3'])){
                            echo "<input type=\"hidden\" name=\"step_3\" value='" . $_GET['step_3'] . "' />";
                        }
                        if(!empty($_GET['step_4'])){
                            echo "<input type=\"hidden\" name=\"step_4\" value='" . $_GET['step_4'] . "' />";
                        } 
                    ?>
                    <input hidden value="<?php echo $_GET['quantity']; ?>" name="quantity" />
                    <input href="#" type="submit" class="btn btn-outline-info w-100 mb-4" name="checkout" value="Checkout" />  
                </form>
            </div>
             
        </div>

        
    </div> 
        
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>