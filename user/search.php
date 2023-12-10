<?php 

    include_once "../db_connection.php";
    session_start();
    
        
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }

    if($_SESSION['user_type'] == 'U'){
        header("location: ../user/index.php");   
    } 


  
    if(isset($_POST['login_button'])){
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        /* QUERY */
        $checkUsername = "SELECT * FROM users WHERE username='$username' LIMIT 1;";
        
        /* EXECUTE */
        $checkUsernameResult = mysqli_query($conn, $checkUsername);
        
        /* FETCH */
        $isExist = mysqli_fetch_assoc($checkUsernameResult); 
        

        if($isExist){ 
            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1;";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($query);

            if($row){
                
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_type'] = $row['user_type'];

                /* strtoupper converts string to uppercase */
                /* if user_type equals to A then redirect to admin panel */
                /* else redirect to to student */
                if(strtoupper($row['user_type']) == 'A')
                    header("Location: ./admin/index.php");
                else{ 
                    header("Location: ./student/index.php");
                }
            }else{
                 
                header("Location: ./login.php?error=invalid_credentials");
            }

        }else{  
            header("Location: ./login.php?error=username_not_found");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Log in</title>
    
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="../styles.css" />
    
    
</head>
<body> 
    <nav class="navbar  navbar-expand-lg  navbar fixed-top  navbar-light bg-light">
    
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="navbar-collapse collapse " id="navbarTogglerDemo02"  >
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
            
            
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item mx-4"> Log out </a> 
            
        </div> 
    </nav>
    
    
    <div class="container mt-5 py-5">
        <div class="row ">
            <div class="col d-flex justify-content-between align-items-end">
                <h1>Materials</h1>
                <h2>
                    <a href="./add-material.php" class="btn btn-primary d-flex">
                        Add <span class="d-none d-sm-block">&nbsp;Material</span>
                    </a>
                </h2>
            </div>
        </div>
        
        <div class="row ">
            <?php 

                $sql_material = "SELECT * FROM materials;";
                $query_material = mysqli_query($conn, $sql_material);
                /*  */
                if(mysqli_num_rows($query_material) > 0){
                    echo "<div class='card-columns col'>";
 
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
                                    echo "<div class='card-footer bg-white'>"; 
                                        echo "<div class='d-flex flex-wrap gap-y align-self-end'> "; 
                                            echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal-".$material['material_id']."'>Update</button>";
                                            echo "&nbsp;&nbsp;";
                                            if($material['status'] == 'I'){ 
                                                echo "<a href='activate.php?id=" . $material['material_id'] ."' class='btn btn-outline-danger'>Activate</a>";
                                            }else{ 
                                                echo "<a href='deactivate.php?id=" . $material['material_id'] ."' class='btn btn-outline-danger'>Deactivate</a>";
                                            }
                                        echo "</div> "; 
                                    echo "</div>";  
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