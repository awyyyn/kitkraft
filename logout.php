<?php 

    include_once("./db_connection.php");

    session_start();

    $id = $_GET['id'];
    if(empty($id)){
        header('location: ./index.php?error=Not Authenticated'); 
    }

    $sql = "UPDATE users SET status = 'I' WHERE user_id = $id;";
    
    if(mysqli_query($conn, $sql)){
        session_destroy();
        header('location: ./login.php');
    }else{
        header('location: ./index.php?error=Internal Server Error');
    }
    



?>