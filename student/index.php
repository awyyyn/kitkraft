<?php 
    session_start();
    include "../db_connection.php";

    if(!isset($_SESSION['user_id'])){
        header("location: ../login.php");   
    }

    if($_SESSION['user_type'] == 'A'){
        session_destroy();
        header("location: ../login.php?error=invalid_user_type");   
    }

    $sql = "SELECT * FROM users WHERE user_id=".$_SESSION['user_id']. " LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo $row['username']; ?>
    <br />
    <?php echo $row['fullname']; ?>
    

    <a href="./logout.php">Logout</a>
</body>
</html>