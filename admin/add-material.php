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

   /* image directory */
    $dir = "../uploads/"; 
    /* check if directory exists */
    if(!file_exists($dir)){
        /* create a new directory */
        mkdir('../uploads/');
        $dir = "../uploads/";
    }
 

    if(isset($_POST['add_material'])){
           
        /* get a temporary name for material image */
        $temp_name = $_FILES['material_img']['tmp_name'];
        /* get the base name of material image */
        $basename = basename( $_FILES["material_img"]["name"]); 
        $file_name = $_FILES["material_img"]["name"];
        $target_file = $dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $uploadOk = 1;

         // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["material_img"]["tmp_name"]);
 

        // Check file size in Kilobytes
        if ($_FILES["material_img"]["size"] > 500000) {
            // echo "Sorry, your file is too large.";
            header('location: ./add-material.php?error=Sorry, your file is too large.');
            $uploadOk = 0;
        }

        if($check !== false) { 
            $uploadOk = 1;
        }else {
            echo "File is not an image.";
            header('location: ./add-material.php?error=File is not an image.');
            echo $check;
            $uploadOk = 0;
        }

        /* CHECK IMAGE FILE TYPE */
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) { 
            header('location: ./add-material.php?error=Sorry, only JPG, JPEG, AND PNG files are allowed.');  
            echo $check;
            $uploadOk = 0;
        } 

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) { 
            // redirect to add-material with error message "Sorry, your file was not uploaded.";
            header('location: ./add-material.php?error=Sorry, your file was not uploaded.');
   

        // if everything is ok, try to upload file
        } else {

            $file_name_to_save_in_db = $dir . uniqid() . ".".  $imageFileType;
            if (move_uploaded_file($_FILES["material_img"]["tmp_name"], $file_name_to_save_in_db)) { 
                // echo "The file ". $file_name . " has been uploaded."; 

                $sql_insert = "INSERT INTO materials (material_name, material_price, stock, material_img, material_description, step_id, status) VALUES ('".$_POST['material_name']."', '".$_POST['material_price']."', '".$_POST['stock']."', '".$file_name_to_save_in_db."', '".$_POST['material_description']."', '".$_POST['step_id']."', 'A');";

                if(mysqli_query($conn, $sql_insert)){ 
                    header('location: ./index.php?success=Material added successfully.');
                }else{
                    header('location: ./add-material.php?error=Error adding material.');
                }

                

            } else { 
                header('location: ./add-material.php?error=Sorry, there was an error uploading your file.');
            }
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitKraft | Admin</title>
    
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
            
            
            <form class="form-inline my-lg-0 mr-3" action="./search.php" method="get">
                <input class="form-control form-control-sm mr-sm-2 " type="text" name="search" placeholder="Search" aria-label="Search">
                <button class="form-control btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            
            <a href="../logout.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item mx-4"> Log out </a> 
            
        </div> 
    </nav>
    
    
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h1>Materials</h1>
            </div>
        </div>
        
        <!-- <h1 class="brand">KITKRAFT</h1> --> 
        <form method="post" enctype="multipart/form-data"> 
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
                            <label for="stock">Stock</label>
                            <input 
                                id="stock"
                                required  
                                type="text" 
                                name="stock" 
                                placeholder="Enter stock" 
                                class="form-control form-control-lg" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6"> 
                        <div class="form-group ">
                            <label for="step_id">Step ID</label>
                            <select class="form-control form-control-lg" name="step_id" id="step_id" required>
                                <option value="" selected disabled>Select step ID</option>
                                <option value="1">Step 1</option>
                                <option value="2">Step 2</option>
                                <option value="3">Step 3</option>
                                <option value="4">Step 4</option>
                            </select>
                        </div>
                    </div>
                </div>

                
                <div class="row mt-4">
                    <div class="col"> 
                        <label for="material_img">Material Image</label>
                        <div class="input-group">
                            <input 
                                type="file" 
                                required class="form-control-file form-control" 
                                accept="image/jpg,image/jpeg,image/png" 
                                name="material_img" 
                                id="material_img "
                            />
                           
                            <div class="input-group-append"> 
                                <label class="input-group-text" for="material_img">Choose file</label>
                            </div>
                        </div>  
                    </div> 
                </div>
                
                <div class="row mt-4">
                    <div class="col"> 
                        <div class="form-group ">
                            <label for="material_description">Description</label>
                            <textarea 
                                id="material_description"
                                required  
                                type="text" 
                                name="material_description" 
                                placeholder="Enter your material description" 
                                class="form-control form-control-lg"></textarea>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col">
                        <input 
                            type="submit" 
                            class="py-2 w-100  mt-4 btn btn-danger" 
                            value="Add Material" 
                            name="add_material" 
                        />
                    </div>
                </div>
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