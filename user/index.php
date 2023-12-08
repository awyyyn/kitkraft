<?php 
    session_start();
    include "../db_connection.php"; 


    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    } 

    if($_SESSION['user_type'] == 'A'){ 
        header("location: ../admin/index.php");   
    }

    $sql = "SELECT * FROM users WHERE user_id=".$_SESSION['user_id']. " LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    

    if(isset($_POST['order-now'])){ 
        // explode() function breaks a string into an array.
        // explode() first parameter is the delimiter you want to break the string by.
        // explode() second parameter is the string you want1 to break.
        // $_POST['gift-container'] is the value of the selected radio button.
        // sample value = "Gift Box,100"
        // pass to variable $step1 the converted array
        $step1 = explode(',', $_POST['gift-container']);
        // converted to array ['Gift Box', '100']

        // $step1[0] is the first index of the array which is the gift container name (Gift Box).
        // and pass to variable $gift_container
        $gift_container = $step1[0];
        // $step1[1] is the second index of the array which is the gift container price (100).
        // and pass to variable $gift_container_price
        $gift_container_price = $step1[1];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Student</title>
    
    
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">  
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="../styles.css" />
    
</head>
<body> 
    <nav class=" navbar   navbar-expand-lg   navbar-light bg-light">
        
        <a class="navbar-brand" href="./index.php">KitKraft</a>

        <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
 
        <div class="navbar-collapse collapse " id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li  class="nav-item active ">
                    <a class="nav-link"  href="./index.php">Customize your own gift </a>
                </li>  
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item mx-4"> Log out </a> 
            
        </div>


    </nav>

    <div class="container-fluid pb-5"> 
        <div class="row  py-4 margin-x"> 
            <div class="col mb-4" > 
                <a href="" class="text-white">
                    <button class="btn btn-info">
                        Pending Orders
                    </button>
                </a>
                <a href="" class="text-white">
                    <button class="btn btn-secondary ml-4">
                        Past Orders 
                    </button>
                </a>
            </div>  
        </div> 
        <form method="post">

            <div class="row mb-4 margin-x" >   
                <div class="col-sm-12 d-flex justify-content-center">  
                    <input required class="form-control form-control-lg full-width-sm" type="number" min="1" placeholder="Quantity">
                </div> 
            </div>

            <div class="row margin-x gap-y"> 
                <!-- STEP 1 -->
                <div class="col-sm-12 col-md-6">
                    <h3 class="badge bg-color-1 text-white p-2">Step 1: Pick your gift container</h3>
                    <div class="row mt-2">   
                        <?php
                            /* query materials that step id is equal to 1 */
                            $step_1 = "SELECT * FROM `materials` WHERE `step_id` = '1';";
                            /* execute step_1 query */
                            $result_step_1 = mysqli_query($conn, $step_1);  
                            /* get query row resutl */
                            if(mysqli_num_rows($result_step_1) > 0 ){
                                while($step1 = mysqli_fetch_assoc($result_step_1)){
                        ?>  
                                    <div class="col-sm-12 col-md-6 " >  
                                        <input hidden class="btn-check-step-1" type="radio" id="<?php echo $step1['material_id']; ?>" value='<?php echo $step1['material_id']; ?>' name="gift-container" />
                                        <label for="<?php echo $step1['material_id']; ?>"  class="px-3 pt-3 w-100 rounded-lg hover-item btn  d-flex-column text-left">
                                            <h1 class="title"><?php echo $step1['material_name']; ?> </h1>  
                                            <div class=""> 
                                                <h4 class="sub-title">Price: <?php echo $step1['material_price']; ?></h4>
                                                <h4 class="sub-title">Detail: <?php echo $step1['material_description']; ?></h4>
                                            </div>
                                        </label>
                                    </div>
                        <?php
                                }
                            }else{
                        ?>
                                <div class="col " >   
                                    <h1 style="cursor:not-allowed"  class="text-center py-5 h-100 w-100 rounded-lg hover-item">
                                        There is no available gift container
                                    </h1>
                                </div>
                        <?php
                            }
                        ?> 
                    </div>
                     
                </div>


                <!-- STEP 2 -->
                <div class="col-sm-12 col-md-6">
                    <h3 class="badge badge-info p-2">Step 2: Pick your preferred  flower</h3>
                    <div class="row mt-2"> 
                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" value="75" name="flower-price" />
                            <input hidden type="radio" id="flower-1" name="flower" />
                            <label for="flower-1"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Tulips </h1>  
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Pink Tulip </h4>
                                    <h4 class="sub-title">Price: Php 75</h4>
                                </div>
                            </label>
                        </div>
    

                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" value="75" name="flower-price" />
                            <input hidden type="radio" id="flower-2" name="flower" />
                            <label for="flower-2"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Roses </h1>  
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Red Roses  </h4>
                                    <h4 class="sub-title">Price: Php 75</h4>
                                </div>
                            </label>
                        </div>
                        
                    </div>
                    <div class="row  ">
                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" value="75" name="flower-price" />
                            <input hidden type="radio" id="flower-3" name="flower" />
                            <label for="flower-3"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Sunflower</h1>
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Yellow Sunflower </h4>
                                    <h4 class="sub-title">Price: Php 75</h4>
                                </div>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" value="75" name="flower-price" />
                            <input hidden type="radio" id="flower-4" name="flower" />
                            <label for="flower-4"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Sunflower</h1>
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Yellow Sunflower</h4>
                                    <h4 class="sub-title">Price: Php 75</h4>
                                </div>
                            </label>
                        </div>
                        
                    </div>
                </div>
            </div>
    
            <div class="row margin-x gap-y mt-4"> 
                <!-- STEP 3 -->
                <div class="col-sm-12 col-md-6">
                    <h3 class="badge badge-danger p-2">Step 3: Pick your decoration</h3>
                    <div class="row mt-2"> 
                        
                        <div class="col-sm-12 " > 
                            <input hidden type="radio" name="ribbon-price" value="10" />
                            <input hidden type="radio" id="ribbon-1" name="ribbon" />
                            <label for="ribbon-1"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Ribbon </h1>  
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Velvet Ribbon </h4>
                                    <h4 class="sub-title">Price: Php 10</h4>
                                </div>
                            </label>
                        </div>    
                        <div class="col-sm-12   " > 
                            <input hidden type="radio" name="ribbon-price" value="50" />
                            <input hidden type="radio" id="ribbon-2" name="ribbon" />
                            <label for="ribbon-2"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Light</h1>
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: String Lights</h4>
                                    <h4 class="sub-title">Price: Php 50</h4>
                                </div>
                            </label>
                        </div>
                        
                    </div>
                </div>


                <!-- STEP 4 -->
                <div class="col-sm-12 col-md-6">
                    <h3 class="badge badge-danger p-2">Step 4: Add ons</h3>
                    <div class="row mt-2"> 
                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" name="add-ons-price" value="50" />
                            <input hidden type="radio" id="add-ons-1" name="add-ons" />
                            <label for="add-ons-1"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Letter </h1>  
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Linen envelope letter paper </h4>
                                    <h4 class="sub-title">Price: Php 50</h4>
                                </div>
                            </label>
                        </div>
    

                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" name="add-ons-price" value="60" />
                            <input hidden type="radio" id="add-ons-2" name="add-ons" />
                            <label for="add-ons-2"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Transparent Box </h1>  
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Bukowski bear (Bukowski design)  </h4>
                                    <h4 class="sub-title">Price: Php 60</h4>
                                </div>
                            </label>
                        </div>
                        
                    </div>
                    <div class="row  ">
                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" name="add-ons-price" value="90" />
                            <input hidden type="radio" id="add-ons-3" name="add-ons" />
                            <label for="add-ons-3"  class="px-3 pt-3 w-100 rounded-lg hover-item">
                                <h1 class="title">Polaroid</h1>
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Handmade polaroid </h4>
                                    <h4 class="sub-title">Price: Php 90</h4>
                                </div>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 " > 
                            <input hidden type="radio" name="add-ons-price" value="50" />
                            <input hidden type="radio" id="add-ons-4" name="add-ons" />
                            <label for="add-ons-4"  class="px-3 pt-3  w-100 rounded-lg hover-item">
                                <h1 class="title">Chocolate</h1>
                                <div class="d-flex w-100 justify-content-between flex-wrap"> 
                                    <h4 class="sub-title">Detail: Assorted (imported/local) chocolates</h4>
                                    <h4 class="sub-title">Price: Php 50</h4>
                                </div>
                            </label>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- SUBMIT BUTTON -->
            <div class="row mt-4  ">
                <div class="d-flex col-12 justify-content-center">
                    
                    <button type="submit" name="order-now" class="btn btn-info " style="font-size:24px;padding: 5px 16px">
                        Order now 
                    </button>
                </div>
            </div> 
        </form>
    </div> 
        
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../bootstrap/jquery-3.2.1.slim.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>