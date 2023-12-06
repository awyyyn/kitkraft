<?php 

    include_once "./db_connection.php";
    session_start();


    $error = "";

    if(isset($_POST['login_button'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$email' AND password='$password' LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if($result){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            // $_SESSION['user_info'] = $row;
            header("location: ./index.php");
        }else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Log in</title>
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./styles/index.css">

    <!-- TAILWIND CSS -->
    <script src="./scripts/tailwindcss.js"></script> 
</head>
<body>
    <main class="h-screen w-screen min-h-[500px] min-w-[375px] bg-[#FF92E855] grid place-content-center relative">
        <image src="./assets/logo.png" class="h-40 w-60 mix-blend-darken absolute top-5 md:left-10 -translate-x-[50%] md:translate-x-0 left-[50%] " />
        <section class="rounded-lg shadow-lg p-5 max-w-[400px] min-w-[375px]  bg-white">
            <!-- <h1 class="brand">KITKRAFT</h1> --> 
            <form method="post">
                <div class="gap-y-5 flex flex-col py-3">
                    <?php 
                        if($error){
                            echo "<h1>$error</h1>";
                        }
                    ?>
                    <h1 class="text-3xl font-bold text-center ">Log in </h1>
    
                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Username:</label>
                        <input class="p-2 focus:outline-none border-2 rounded-md  " type="text" name="username" placeholder="Enter your username" />  
                    </div>
    
                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Password</label>
                        <input class="p-2  focus:outline-none border-2 rounded-md  " type="password" name="password" placeholder="Enter your password" />
                        
                    </div> 
    
                    <input type="submit" class="hover:shadow-xl cursor-pointer transition-shadow bg-[#A93545] w-full py-2 mt-2 rounded-lg text-white text-center" value="Log in" name="login_button" />
                    
                    <a href="./create-account.php" class="text-center hover:underline text-sm">Create Account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>