<?php 
    session_start();
    include "../db_connection.php";  
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    }  
    if($_SESSION['user_type'] == 'U'){ 
        header("location: ../user/index.php");   
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Home</title>
     
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="../styles.css" /> -->
    <style>
        .container-home {
            height: 95vh;
            width: 100vw;
            background: none;
            background-repeat: no-repeat;
            background-image: url("../assets/mobile-bg.png");
            background-size: 100vw 100vh ;  
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .welcome {
            justify-content: center;
            /* animation: forwards 1s sample ;  */
        }
        .container-home > div { 
            height: 100%;
            padding-inline: 1em;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }
 
        .title {
            font-size: 2rem;
            background: linear-gradient(to right, #008080, #800080, #DAA520);
            color: transparent;
            background-clip: text;
        }
        .blockquote {
            font-size: 1.2rem; 
            font-weight: 500;
        }
        blockquote { 
            line-height: 1.8; 
            padding-right: 10%;
            color: #e25d4e; 
            letter-spacing: 1.5px;
        } 
        
        .why-choose {
                /* background-color: #fff; */ 
                height: auto;
        } 
        @media only screen and (min-width: 768px){
            .title {
                font-size: 3rem; 
            }
            span {
                
                font-size: 2.5rem; 
            }
            .container-home > div {  
                /* height: 100vi; */
                padding-inline: 9em; 
            }
            .description { 
                /* max-width: 55%; */
                padding-right: 10%;
            } 
            blockquote { 
                line-height: 2;
                font-size: 1.5em;
                letter-spacing: 2px;
            } 
            .container-home {
                background-image: url("../assets/bg-2.jpg");
                background-size: cover; 
            }
            .about {
                text-align: center;
            }
            .card {
                max-width: 330px; 
            }
            .card-columns {
                column-gap: 5em;
                padding-inline: 3em1111111;
            }

        }
    </style>
</head>
<body> 
    <nav style="z-index:10" class=" navbar fixed-top  shadow-lg navbar-expand-lg   navbar-light bg-light">
        
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
 
        <div class="navbar-collapse collapse " id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li  class="nav-item active ">
                    <a class="nav-link"  href="./index.php">Home</a>
                </li>  
                <li  class="nav-item  ">
                    <a class="nav-link"  href="./manage.php">Manage Material</a>
                </li>    
                <li  class="nav-item  ">
                    <a class="nav-link"  href="./orders.php">Manage Orders</a>
                </li>   
                
                <li  class="nav-item  ">
                    <a class="nav-link"  href="./reports.php">Reports</a>
                </li>   
            </ul>
            <form class="form-inline my-lg-0 mr-3" action="./search.php" method="get">
                <input class="form-control form-control-sm mr-sm-2 " type="text" name="search" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item btn btn-sm btn-outline-danger d-block shadow-sm"> Log out </a> 
            
        </div>


    </nav>   
    <div class="container-home mt-5 pt-5 position-relative" > 
        <div class="welcome">
            <h1 class="title font-weight-bolder">Welcome to Kitkraft - <br  class="d-none  d-md-block" />Your Gateway to Personalized Delight! </h1>
            <blockquote class="description color-1">At KitKraft, we invite you to embark on a delightful journey into the world of bespoke floral creations. As a premier e-commerce destination, we specialize in bringing you the finest flower crafts that not only captivate your senses but also allow you to unleash your creativity.</blockquote>
        </div>
        <div class="justify-content-center ">
            <h1 class="title about font-weight-bolder">About Us </h1>
            <blockquote class="text-lg-center about-us-description color-1">At KitKraft, we Kitkraft appears to be a customizable product system that specializes in selling personalized items like flowers and gifts. Customers likely have the option to tailor these products according to their preferences, adding a unique touch to each item. This customization could involve in creating personalized moments, transforming ordinary gifts into extraordinary expressions of love and thoughtfulness. Discover the joy of giving with Kitkraft, where every item becomes a canvas for your emotions. Our commitment is to provide you with not just products but experiences that resonate with your emotions. </blockquote>
        </div>
        <div class="why-choose">
            <h1 class="title about font-weight-bolder">Why Choose Kitkraft?</h1>
            <?php 
                $cards = [
                    ['Customizable Elegance', 'Explore our curated selection, including clear box arrangements, floral bouquets, and wickerwork baskets, all waiting for your personal touch. '],
                    ["Bespoke Blooms", "Select from a garden of options – Tulips, Roses, Sunflowers, Buttercups – and craft the perfect bouquet to convey your sentiments. "],
                    ["Charming Decorations", "Elevate your gift with our premium add-ons like velvet ribbons and enchanting string lights, adding a touch of sophistication to your creation. "],
                    ["Heartfelt Add-ons", "Make your gift truly special with personalized letters, adorable mini bears, handmade polaroids, and delectable chocolates – the perfect complements to your thoughtful gesture."]
                ]

            ?>
            <div class="d-flex justify-content-center mt-3 flex-wrap gap-y card-columns">
                <?php 
                    for($i = 0; $i < count($cards); $i++){
                ?>
                    <div class="card my-5 mx-3 "> 
                        <h3 class="card-header"><?php echo $cards[$i][0]; ?></h3>
                        <div class="card-body">
                            <p class="card-text"><?php echo $cards[$i][1]; ?></p>
                        </div>
                    </div>
                <?php
                    }
                ?>
                
            </div>
            <div class="d-flex justify-content-center">
                <span>🎁</span>
                <h1 class="text-center title">Draft your unique expression with KitKraft</h1>
                <span>🌹</span>
            </div>
        </div>
    </div> 
        
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>