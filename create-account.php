<?php

    /* INCLUDE DB CONNECTION */
    include_once("./db_connection.php");

    /* IS CREATE BUTTON IS EXIST */
    if(isset($_POST['create_button'])){
        
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        $checkUsername = "SELECT * FROM users WHERE username='$username';";

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
            header("Location: ./student/index.php");
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Create Account</title>
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./styles/index.css">

    <!-- TAILWIND CSS -->
    <script src="./scripts/tailwindcss.js"></script> 
</head>
<body>
    <main class="h-screen w-screen min-h-[500px] min-w-[375px] bg-[#FF92E855] grid place-content-center relative">
        <!-- <image src="./assets/logo.png" class="h-40 w-60 mix-blend-darken absolute top-5 md:left-10 -translate-x-[50%] md:translate-x-0 left-[50%] " /> -->
        <section class="rounded-lg shadow-lg p-5 max-w-[400px] min-w-[375px]  bg-white">
            <!-- <h1 class="brand">KITKRAFT</h1> --> 
            <form method="POST">
                <div class="gap-y-5 flex flex-col py-3">
                    <h1 class="text-3xl font-bold text-center ">Register</h1>
    
                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Fullname:</label>
                        <input required class="p-2 focus:outline-none border-2 rounded-md  " type="text" name="fullname" placeholder="Enter your fullname" />  
                    </div>

                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Username:</label>
                        <input required class="p-2 focus:outline-none border-2 rounded-md  " type="text" name="username" placeholder="Enter your username" />  
                    </div>
    
                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Address:</label>
                        <input required class="p-2 focus:outline-none border-2 rounded-md  " type="text" name="address" placeholder="Enter your address" />  
                    </div>

                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Password</label>
                        <input required minlength="6" class="p-2  focus:outline-none border-2 rounded-md  " type="password" name="password" placeholder="Enter your password" />
                    </div> 
                     
                    <input type="submit" class="hover:shadow-xl cursor-pointer transition-shadow bg-[#A93545] w-full py-2 mt-2 rounded-lg text-white text-center" value="Register" name="create_button" />
                    
                    <a href="./login.php" class="text-center hover:underline text-sm">Log in</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>