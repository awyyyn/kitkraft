<?php 

    include_once("./db_connection.php");

    session_start();


    session_destroy();

    header('location: ./login.php');


?>