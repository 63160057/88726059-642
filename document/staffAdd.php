<?php
require_once("dbconfig.php");

if ($_POST){
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];
    // insert a record by prepare and bind
    // The argument may be one of four types:
    //  i - integer
    //  d - double
    //  s - string
    //  b - BLOB
    
    // ในส่วนของ INTO ให้กำหนดให้ตรงกับชื่อคอลัมน์ในตาราง actor
    // ต้องแน่ใจว่าคำสั่ง INSERT ทำงานใด้ถูกต้อง - ให้ทดสอบก่อน
    $sql = "INSERT 
            INTO staff (stf_code,stf_name) 
            VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $stf_code, $stf_name);
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
            <button type="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>