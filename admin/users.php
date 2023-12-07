<?php 

    include_once "../db_connection.php";
    session_start();
    
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }

    if($_SESSION['user_type'] != 'A'){
        header("location: ../user/login.php");   
    } 


    /* users sql */
    $users_sql = "SELECT * FROM users WHERE user_type = 'U';";
    $users_query = mysqli_query($conn, $users_sql);
   

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
    <nav class="navbar  navbar-expand-lg   navbar-light bg-light">
    
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="navbar-collapse collapse " id="navbarTogglerDemo02" style="">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item ">
                    <a class="nav-link " href="./index.php">Manage Materials </a>
                </li>  
                <li class="nav-item active">
                    <a class="nav-link" href="./users.php">Users </a>
                </li>  
                <li class="nav-item "> 
                    <a class="nav-link" href="./orders.php">Orders </a>
                </li>  
            </ul>
            
            
            <form class="form-inline my-2 my-lg-0 mr-4">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
             
            <a href="../logout.php" class="nav-item "> Log out </a>  
            
        </div> 
    </nav>
    
    
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h1>Users</h1>
            </div>
        </div>
         
        <?php
            if(mysqli_num_rows($users_query) > 0){
                while($user = mysqli_fetch_assoc($users_query)){
                    echo "<div class='row my-4'>";
                        echo "<div class='col'>";
                            echo "<div class='card'>";
                                echo "<div class='card-body'>";
                                    echo "<div class='w-100 d-flex justify-content-between align-items-center'>";
                                        echo "<h5 class='card-title'>Username : {$user['username']}</h5>";
                                        if($user['status'] == 'A')
                                            echo "<span class='badge badge-success p-2 ml-2'>Active</span>";
                                        else
                                            echo "<span class='badge badge-danger p-2 ml-2'>Inactive</span>";
                                    echo "</div>";
                                    echo "<p class='card-text'>Fullname : {$user['fullname']}</p>";
                                    echo "<p class='card-text'>Address : {$user['user_address']}</p>";
                                    // echo "<a href='./edit-user.php?user_id={$user['user_id']}' class='btn btn-primary'>Edit</a>";
                                    // echo "<a href='./delete-user.php?user_id={$user['user_id']}' class='btn btn-danger'>Delete</a>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            }else{
                
                echo "<div class='row mt-4'>";
                echo "<div class='col'>";
                    echo "<div class='card'>";
                        echo "<div class='card-body'>";
                            echo "<h5 class='card-title text-center'>No users found</h5>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
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