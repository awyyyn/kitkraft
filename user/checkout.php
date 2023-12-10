<?php 
    require '../db_connection.php';
    session_start();

    if(empty($_SESSION['user_id'])){
        header("location: ../login.php");   
    }

    if($_SESSION['user_type'] == 'A'){ 
        header("location: ../admin/index.php");   
    }

    $id = $_SESSION['user_id'];
    $step1 = $_POST['step_1'] ? $_POST['step_1'] : "";
    $step2 = $_POST['step_2'] ? $_POST['step_2'] : "";
    $step3 = $_POST['step_3'] ? $_POST['step_3'] : "";
    $step4 = $_POST['step_4'] ? $_POST['step_4'] : "";
    $quantity = $_POST['quantity'];

    if(isset($_POST['checkout'])){

        $sql = "INSERT INTO `orders`(`user_id`, `step1`, `step2`, `step3`, `step4`, `order_qty`, `order_status`) VALUES ('$id','$step1','$step2','$step3','$step4','$quantity','P');";

        $result = mysqli_query($conn, $sql);
         
        if($result){
            header("location: ./index.php?success=Order placed successfully");
        }else{
            header("location: ./index.php?error=Something went wrong");
        }
    }

?>