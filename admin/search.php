<?php 

    include_once "../db_connection.php";
    session_start();
    
        
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }

    if($_SESSION['user_type'] == 'U'){
        header("location: ../user/index.php");   
    } 
    if(empty($_GET['search'])){
        header("location: ./index.php?error=Please enter a keyword");
    }
   
    $search = $_GET['search'];

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
    <nav class="navbar  navbar-expand-lg   navbar-light bg-light">
    
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="navbar-collapse collapse " id="navbarTogglerDemo02" style="">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Manage Materials </a>
                </li>  
                <li class="nav-item ">
                    <a class="nav-link" href="./users.php">Users </a>
                </li>  
                <li class="nav-item ">
                    <a class="nav-link" href="./orders.php">Orders </a>
                </li>  
            </ul>
            
            
            
            <form class="form-inline my-lg-0 mr-3" action="./search.php" method="get">
                <input class="form-control form-control-sm mr-sm-2 " type="text" name="search" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php" class="nav-item mx-4"> Log out </a> 
            
        </div> 
    </nav>
    
    
    <div class="container-fluid padding-x pb-5 mt-5 pt-5"> 
        
        <h1 class="mb-2">Results</h1>
        <div class="row ">
            <?php 

                $sql_material = "SELECT * FROM `materials` WHERE `material_name` LIKE '%$search%' AND STATUS = 'A';";
                $query_material = mysqli_query($conn, $sql_material);
                /*  */
                if(mysqli_num_rows($query_material) > 0){
                    echo "<div class='card-columns col col-md-12'>";
 
                        while($material = mysqli_fetch_assoc($query_material)){ 
                                echo "<div class='card'>";
                                    echo "<img class='card-img-top img-fluid' style='max-height:200px; height:200px;object-fit:contain;border-bottom:1px solid #c5c6c4' 
                                        src='".$material['material_img']."' alt='" . $material['material_name'] . "'>";
                                    echo "<div class='card-body'>";
                                            echo "<div class='w-100 d-flex justify-content-between '>";
                                                echo "<h5 class='card-title font-weight-bold mb-0 w-50'>" . $material['material_name'] . " </h5>";
                                                echo "<div class='d-flex-column'>";
                                                    echo "<span class='d-block'>Price: " . $material['material_price'] . "</span>";
                                                    echo "<span>Stock: ".$material['stock']. "</span>";
                                                echo "</div>";
                                            echo "</div>";
                                            echo "<p class='card-text small mt-3'>Description:" . /* substr($material['material_description'], 0, 75)  */ $material['material_description'] . "</p>";  
                                    echo "</div>"; 
                                    // echo "<div class='card-footer bg-white'>"; 
                                    //     echo "<div class='d-flex flex-wrap gap-y align-self-end'> "; 
                                    //         echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal-".$material['material_id']."'>Update</button>";
                                    //         echo "&nbsp;&nbsp;";
                                    //         if($material['status'] == 'I'){ 
                                    //             echo "<a href='activate.php?id=" . $material['material_id'] ."' class='btn btn-outline-danger'>Activate</a>";
                                    //         }else{ 
                                    //             echo "<a href='deactivate.php?id=" . $material['material_id'] ."' class='btn btn-outline-danger'>Deactivate</a>";
                                    //         }
                                    //     echo "</div> "; 
                                    // echo "</div>";  
                                echo "</div>";   
                        } 
                    echo "</div>";

                }else{
                    echo "<div class='col mt-3'>";
                        echo "<div class='alert bg-info text-white text-center'>No materials found.</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>


    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>