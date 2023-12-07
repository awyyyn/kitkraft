<?php 
 
    session_start();  

    

    /* if session is empty, redirect to login page */
    if(empty($_SESSION['user_id'])){
        header("location: ./login.php");   
    }
  
    /* ---- check if the logged in account is user or admin  */
    if($_SESSION['user_type'] == 'A'){
        /* if admin, redirect to admin panel */
        header("location: ./admin/index.php");
    }else{
        /* if user, redirect to user panel */
        header("location: ./user/index.php");
    } 
 
?>