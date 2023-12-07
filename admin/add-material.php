<?php 

    include_once "../db_connection.php";
    session_start();
    
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    }

    if($_SESSION['user_type'] != 'A'){
        session_destroy();
        header("location: ../login.php?error=invalid_user_type");   
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
    <nav class="navbar  navbar-expand-lg   navbar-light bg-light">
    
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="navbar-collapse collapse " id="navbarTogglerDemo02" style="">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item active">
                    <a class="nav-link " href="./index.php">Manage Materials </a>
                </li>  
                <li class="nav-item ">
                    <a class="nav-link" href="./users.php">Users </a>
                </li>  
            </ul>
            
            
            
            
            <a href="../logout.php" class="nav-item mx-4"> Log out </a> 
            
        </div> 
    </nav>
    
    
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h1>Materials</h1>
            </div>
        </div>
        
        <!-- <h1 class="brand">KITKRAFT</h1> --> 
        <form method="post"> 
            <div class="container">
                <div class="row mt-4">
                    <div class="col-sm-12 col-md-6"> 
                        <div class="form-group ">
                            <label for="material_name">Material Name</label>
                            <input 
                                id="material_name"
                                required  
                                type="text" 
                                name="material_name" 
                                placeholder="Enter your material name" 
                                class="form-control form-control-lg" >
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6"> 
                        <div class="form-group ">
                            <label for="material_price">Material Price</label>
                            <input 
                                id="material_price"
                                required  
                                type="number" 
                                name="material_price" 
                                min="1"
                                placeholder="Enter your material price" 
                                class="form-control form-control-lg" />
                        </div>
                    </div>
                </div>

                 <div class="row mt-4">
                    <div class="col-sm-12 col-md-6"> 
                        <div class="form-group ">
                            <label for="material_name">Material Name</label>
                            <input 
                                id="material_name"
                                required  
                                type="text" 
                                name="material_name" 
                                placeholder="Enter your material name" 
                                class="form-control form-control-lg" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6"> 
                        <div class="form-group ">
                            <label for="step_id">Step ID</label>
                            <select class="form-control form-control-lg">
                                <option selected disabled>Select step ID</option>
                                <option value="1"></option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                
 
                <input 
                    type="submit" 
                    class="py-2  mt-4 btn btn-danger" 
                    value="Log in" 
                    name="login_button" 
                />
                    
                <div class="w-100 d-block mt-3 text-center ">                   
                    <a href="./create-account.php" class="text-secondary">Create Account</a>
                </div> 
        </form> 
    </div>
    </div>


    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>