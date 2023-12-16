<?php
    require '../db_connection.php';
    session_start();    

    if(empty($_SESSION['user_id'])){
        header("location: ../login.php?error=user_not_authenticated");   
    }

    if($_SESSION['user_type'] == 'U'){
        header("location: ../user/index.php");   
    }

    if(empty($_GET['id'])){
        header("location: ./index.php?error=Please enter a keyword");
    }

    $sql = "UPDATE `orders` SET `order_status` = 'O' WHERE `order_id` = ".$_GET['id'].";";

    
    if(mysqli_query($conn, $sql)){
        header("location: ./otw.php?success=Order cancelled successfully");
    }else{
        header("location: ./ship.php?error=Something went wrong");
    }

?>