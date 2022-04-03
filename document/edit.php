<?php
session_start();
if(!isset($_SESSION['loggined'])){
    header('Location: login.php');
}

require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะลบ
if ($_POST){
    $id = $_POST['id'];
    $doc_num = $_POST['doc_num'];
    $doc_title = $_POST['doc_title'];
    $doc_start_date = $_POST['doc_start_date'];
    $doc_to_date = $_POST['doc_to_date'];
    $doc_status = $_POST['doc_status'];
    $doc_file_name = $_FILES["doc_file_name"]["name"];

    if($_FILES['doc_file_name']['name']<>""){
        $sql = "UPDATE documents
            SET doc_num = ?, 
                doc_title = ?,
                doc_start_date = ?,
                doc_to_date = ?,
                doc_status =?,
                doc_file_name =?
                
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssssi", $doc_num, $doc_title, $doc_start_date, $doc_to_date, $doc_status, $doc_file_name,$id);
    $stmt->execute();
    } else{
        $sql = "UPDATE documents
            SET doc_num = ?, 
                doc_title = ?,
                doc_start_date = ?,
                doc_to_date = ?,
                doc_status =?,
               
                
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssi", $doc_num, $doc_title, $doc_start_date, $doc_to_date, $doc_status,$id);
    $stmt->execute();
    }
 
   
   
     
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['doc_file_name']["name"]);
    if (move_uploaded_file($_FILES['doc_file_name']["tmp_name"], $target_file)) {
      //echo "The file ". htmlspecialchars( basename( $_FILES["dfn"]["name"])). " has been uploaded.";
    } else {
      //echo "Sorry, there was an error uploading your file.";
    }

header("location: document.php");
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
        <h1>Edit</h1>
        <form action="edit.php" method="post">
            <div class="form-group">
                <label for="doc_num">เลขที่คำสั่ง</label>
                <input type="text" class="form-control" name="doc_num" id="doc_num" value="<?php echo $row->doc_num;?>">
            </div>
            <div class="form-group">
                <label for="doc_title">ชื่อคำสั่ง</label>
                <input type="text" class="form-control" name="doc_title" id="doc_title" value="<?php echo $row->doc_title;?>">
            </div>
            <div class="form-group">
                <label for="doc_start_date">วันที่เริ่มต้นคำสั่ง</label>
                <input type="date" class="form-control" name="doc_start_date" id="doc_start_date" value="<?php echo $row->doc_start_date;?>">
            </div>
            <div class="form-group">
                <label for="doc_to_date">วันที่สิ้นสุด</label>
                <input type="date" class="form-control" name="doc_to_date" id="doc_to_date" value="<?php echo $row->doc_to_date;?>">
            </div>
            <div class="form-group">
                <label for="doc_status">สถานะ</label><br>
                <input type="text" class="form-control" name="doc_status" id="doc_status" value="<?php echo $row->doc_status;?>">
            </div>
            <div class="form-group">
                <label for="doc_file_name">ชื่อไฟล์เอกสาร</label>
                <input type="file" class="form-control" name="doc_file_name" id="doc_file_name" >
            </div>
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <button type="submit" class="btn btn-success">Update</button>
        </form>
</body>

</html>