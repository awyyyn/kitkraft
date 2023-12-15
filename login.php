<?php 

    include_once "./db_connection.php";
    session_start();
    
    /* check if user/admin is already logged in */
    /* if session user_id is not empty -----  */
    if(!empty($_SESSION['user_id'])){
        
        /* ---- check if the logged in account is user or admin  */
        if($_SESSION['user_type'] == 'A'){
            /* if admin, redirect to admin panel */
            header("location: ./admin/index.php");
        }else{
            /* if user, redirect to user panel */
            header("location: ./user/index.php");
        }
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
                

                /* strtoupper converts string to uppercase */
                /* if user_type equals to A then redirect to admin panel */
                /* else redirect to to student */
                if(strtoupper($row['user_type']) == 'A'){
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_type'] = $row['user_type'];
                    header("Location: ./admin/index.php");
                }else{ 
                    $updateStatus = "UPDATE users SET status = 'A' WHERE user_id = ".$row['user_id'].";";
                    if(mysqli_query($conn, $updateStatus)){ 
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_type'] = $row['user_type'];
                        header("Location: ./user/index.php");
                    }else{
                        session_destroy();  
                        header("Location: ./login.php?error=Internal server error");
                    }
                }
            }else{
                 
                header("Location: ./login.php?error=Invalid Credentials");
            }

        }else{  
            header("Location: ./login.php?error=Username not found");
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
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="./styles.css" />
    
</head>
<body > 
        <!-- <image src="./assets/logo.png" class="h-40 w-60 mix-blend-darken absolute top-5 md:left-10 -translate-x-[50%] md:translate-x-0 left-[50%] " /> -->
    <div class="position-relative container-fluid justify-content-center d-flex margin-top w-full ">
       
        <div class="border p-5 bg-white  margin-top min-width">
            <!-- <h1 class="brand">KITKRAFT</h1> --> 
            <form method="post">
                <div class="d-flex flex-column py-2 position-relative"> 
                    <?php
                        if(isset($_GET['error'])){  
                            echo "<div class='px-3 py-1 rounded small position-absolute text-white bg-danger ' style='top:-20px;right:-20px'>". $_GET['error']."</div>"; 
                        }
                    ?>
                    <h1 class=" text-center ">Log in </h1> 
                    <div class="form-group  mt-4">
                        <label for="username">Username</label>
                        <input 
                            id="username"
                            required  
                            type="text" 
                            name="username" 
                            placeholder="Enter your username" 
                            class="form-control form-control-lg" >
                    </div>

                    <div class="form-group  mt-4">
                        <label for="password">Password</label>
                        <input 
                            id="password"
                            required  
                            type="password" 
                            name="password" 
                            placeholder="Enter your password" 
                            class="form-control form-control-lg" /z>
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
                </div>
            </form>
        </div> 
    </div>
    
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="./bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="./bootstrap/popper.min.js"></script>
    <script src="./bootstrap/bootstrap.bundle .min.js"></script>
</body>
</html>