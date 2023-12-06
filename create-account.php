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
        <image src="./assets/logo.png" class="h-40 w-60 mix-blend-darken absolute top-5 md:left-10 -translate-x-[50%] md:translate-x-0 left-[50%] " />
        <section class="rounded-lg shadow-lg p-5 max-w-[400px] min-w-[375px]  bg-white">
            <!-- <h1 class="brand">KITKRAFT</h1> --> 
            <form >
                <div class="gap-y-5 flex flex-col py-3">
                    <h1 class="text-3xl font-bold text-center ">Create Account</h1>
    
                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Username:</label>
                        <input class="p-2 focus:outline-none border-2 rounded-md  " type="text" name="username" placeholder="Enter your username" />  
                    </div>
    
                    <div class="group flex flex-col w-full relative space-y-2 ">
                        <label>Password</label>
                        <input class="p-2  focus:outline-none border-2 rounded-md  " type="password" name="password" placeholder="Enter your password" />
                        
                    </div> 
    
                    <input type="submit" class="hover:shadow-xl cursor-pointer transition-shadow bg-[#A93545] w-full py-2 mt-2 rounded-lg text-white text-center" value="Create Account" name="create_button" />
                    
                    <a href="./login.php" class="text-center hover:underline text-sm">Log in</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>