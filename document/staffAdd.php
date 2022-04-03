<?php

session_start();
if(!isset($_SESSION['loggined'])){
    header('Location: login.php');
}

require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะเพิ่ม
if ($_POST){
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];
    $username = $_POST['username'];
    $passwd = md5($_POST['passwd']);
    $sql = "INSERT 
            INTO staff (stf_code,stf_name,username,passwd) 
            VALUES (?, ?,?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $stf_code,$stf_name,$username,$passwd);
    $stmt->execute();

    // redirect ไปยัง actor.php
    header("location: staff.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>เพิ่มสมาชิก</h1>
        <form action="staffAdd.php" method="post">
            <div class="form-group">
                <label for="stf_code">เลขที่คำสั่ง</label>
                <input type="text" class="form-control" name="stf_code" id="stf_code" placeholder="ex. s0001">
            </div>
            <div class="form-group">
                <label for="stf_name">ชื่อ - นามสกุล</label>
                <input type="text" class="form-control" name="stf_name" id="stf_name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="passwd">Password</label>
                <input type="password" class="form-control" name="passwd" id="passwd">
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>