<?php 

    include_once "../db_connection.php";
    session_start(); 
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    } 
    if($_SESSION['user_type'] == 'U'){
        header("location: ../user/index.php");   
    } 
    
    if(isset($_POST['update_button'])){
        
        /*  */
        $id = $_POST['material_id'];
        $material_name = $_POST['material_name'];
        $material_description = $_POST['material_description'];
        $material_price = $_POST['material_price']; 
        $stock = $_POST['material_stock']; 
        $step_id = $_POST['step_id']; 

        /* check if the image input is not empty */
        if(!empty($_FILES['material_img']['name'])){
            $dir = "../uploads/"; 
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


            // Check file size
            if ($_FILES["material_img"]["size"] > 500000) {
                // echo "Sorry, your file is too large.";
                header('location: ./add-material.php?error=Sorry, your file is too large.');
                $uploadOk = 0;
            }

            if($check !== false) { 
                $uploadOk = 1;
            }else { 
                header('location: ./add-material.php?error=File is not an image.');
                 
                $uploadOk = 0;
            }


            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) { 
                // header('location: ./add-material.php?error=Sorry, only JPG, JPEG, AND PNG files are allowed.');  
                echo $check;
                $uploadOk = 0;
                
            } 

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) { 
                // redirect to add-material with error message "Sorry, your file was not uploaded.";
                header('locati on: ./add-material.php?error=Sorry, your file was not uploaded.');
    

            // if everything is ok, try to upload file
            } else {



                $file_name_to_save_in_db = $dir . uniqid( ) . ".".  $imageFileType;

                if (move_uploaded_file($_FILES["material_img"]["tmp_name"], $file_name_to_save_in_db)) { 
                    // echo "The file ". $file_name . " has been uploaded."; 

                    $update_sql = "UPDATE materials SET `step_id`='$step_id', `material_name`='$material_name', `material_img` ='$file_name_to_save_in_db',`material_description`='$material_description',`material_price`='$material_price', `stock`='$stock' WHERE material_id = $id;";
                        

                    if(mysqli_query($conn, $update_sql)){ 
                        header('location: ./index.php?success=Material added successfully.');
                    }else{
                        header('location: ./add-material.php?error=Error adding material.');
                    }

                    

                } else { 
                    header('location: ./add-material.php?error=Sorry, there was an error uploading your file.');
                }
            }
        }else{
            

            $update_sql = "UPDATE materials SET `step_id`='$step_id', `material_name`='$material_name',`material_description`='$material_description',`material_price`='$material_price', `stock`='$stock' WHERE material_id = $id;";
                  
            if(mysqli_query($conn, $update_sql)){ 
                header('location: ./index.php?success=Material updated successfully.'); 
            }else{
                header('location: ./add-material.php?error=Error updating material.');
            } 
        } 
        

    }else{
        header('Location: ./index.php');
    }

   

?>  