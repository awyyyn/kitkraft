

<?php 

    include_once "../db_connection.php";
    session_start();
    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }
    if($_SESSION['user_type'] != 'A'){
        header("location: ../user/index.php");   
    }


    // get the id of the user in the url
    $id = $_GET['id'];  

    // check if id is not empty
    if(!empty($id)){

        // check if the material exist
        $sql = "SELECT * FROM materials WHERE material_id = $id;";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) == 0){
            header('Location: ./index.php?error=Material not found');
        }else{

            // check if the material exist
    
    
            // proceed to activation if material exist 
    
            // SQL TO UPDATE THE STATUS OF MATERIAL
            $sql = "UPDATE materials SET status = 'I' WHERE material_id = $id;";
            // execute the query
            $query = mysqli_query($conn, $sql);
    
            // check if query is successful
            if($query){
                // redirect to admin panel with success message
                header("Location: ./index.php?success=Material deactivated");
            }else{
                // redirect to admin panel with error message
                header("Location: ./index.php?error=Failed to activate");
            }
        }

    }else{
        /* else statement */
        /* redirect to admin with error message */
        header('Location: ./index.php?error=Material not found');
    }


?>