<?php

    /* INCLUDE DB CONNECTION */
    include_once("./db_connection.php");

    /* IS CREATE BUTTON CLICKED */
    if(isset($_POST['create_button'])){
        
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        $checkUsername = "SELECT * FROM `users` WHERE username = ''; ";

        /* EXECUTE QUERY */
        $checkUsernameResult = mysqli_query($conn, $checkUsername);

        /* CHECK QUERY IF THE RESULT IS GREATER THAN 0 */
        if(mysqli_num_rows($checkUsernameResult) > 0){ 
            /* REDIRECT TO CREATE ACCOUNT PAGE */
            return header("Location: ./create-account.php?error=username_already_exists"); 
        }else{ 
            /* CREATE NEW ACCOUNT QUERY */
            $sql = "INSERT INTO users (fullname, username, user_address, password, user_type, status) VALUES ('$fullname', '$username', '$address', '$password', 'U', 'A')";
            /* EXECUTE QUERY */
            $query = mysqli_query($conn, $sql);
            /* SELECT NEW CREATED ACCOUNT TO GET THE ID QUERY */
            $getUser = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
            /* EXECUTE QUERY */
            $getUserResult = mysqli_query($conn, $getUser);
            /* FETCH THE RESULT */
            $row = mysqli_fetch_assoc($getUserResult);
            /* CREATE A SESSION NAMED USER_ID AND PASS THE ID OF NEW ACCOUNT */
            $_SESSION['user_id'] = $row['user_id'];
            /* REDIRECT OR STUDENT PANEL */
            header("Location: ./user/index.php");
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Create Account</title>
    
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="./styles.css" />
</head>
<body > 
        <!-- <image src="./assets/logo.png" class="h-40 w-60 mix-blend-darken absolute top-5 md:left-10 -translate-x-[50%] md:translate-x-0 left-[50%] " /> -->

    
    <div class="position-relative container-fluid justify-content-center d-flex margin-top w-full">
        <div class="border p-5 bg-white  margin-top min-width">
            <!-- <h1 class="brand">KITKRAFT</h1> --> 
            <form method="POST">
                <div class="gap-y-5 flex flex-col py-3">


                    <h1 class="text-3xl font-bold text-center ">Register</h1>

                    
                    <div class="form-group  mt-4">
                        <label for="fullname">Fullname</label>
                        <input 
                            id="password"
                            required  
                            type="text" 
                            name="fullname" 
                            placeholder="Enter your fullname" 
                            class="form-control form-control-lg" >
                    </div>

                    <div class="form-group  mt-4">
                        <label for="fullname">Username</label>
                        <input 
                            id="username"
                            required  
                            type="text" 
                            name="username" 
                            placeholder="Enter your username" 
                            class="form-control form-control-lg" >
                    </div>

                    <div class="form-group  mt-4">
                        <label for="address">Address</label>
                        <input 
                            id="address"
                            required  
                            type="text" 
                            name="address" 
                            placeholder="Enter your address" 
                            class="form-control form-control-lg" >
                    </div>


                    <div class="form-group  mt-4">
                        <label for="address">Password</label>
                        <input 
                            id="password"
                            required  
                            type="text" 
                            name="password" 
                            placeholder="Enter your password" 
                            class="form-control form-control-lg" >
                    </div>
                        
                        

                    
                    <input type="submit"  value="Register" name="create_button"
                        class="btn btn-danger w-100 mt-3"
                    />
                    
                    <div class="w-100 d-block mt-3 text-center ">
                        <a href="./login.php" class="text-secondary" >Log in</a>
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