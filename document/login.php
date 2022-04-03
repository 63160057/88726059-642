<?php



$error="";
session_start();

if($_POST){
    require_once("dbconfig.php");

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT *
            FROM staff
            WHERE username = ? AND passwd = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if( $result->num_rows > 0){
        $row = $result->fetch_assoc();
        //$_SESSION['user_id'] = $row['id'];
        $_SESSION['stf_name'] = $row['stf_name'];
        $_SESSION['loggined'] = true;
        header('location: document.php');
    }else{
        $error = 'Username or Password is incorrect';
    } 
}else{
    if(isset($_SESSION['loggined'])){
        header("location: document.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body style="background-color:blue">
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label  for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br><br>
        <label  for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br><br>
        <input type="submit" value="Login" name="submit">
</form>
<div style="">
    <?php echo $error; ?>
</div>
</body>

</html>
