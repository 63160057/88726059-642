<?php
session_start();
if(!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>คำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    <div class="page-header">
        <h1 style="text-align: center;">ค้นหารายชื่อกรรมการ</h1>
    </div>
    <form class="form-horizontal container" action="#" methode="post">
        <div class="input-group col-sm-12">
          <input type="text" class="form-control" name="kw" placeholder="ค้นหาจาก เลขที่คำสั่ง หรือ ชื่อคำสั่ง">
          <div class="input-group-btn ">
            <button class="btn btn-primary" type="submit">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
    </form>
    <div>
        <?php
        require_once("dbconfig.php");

       
        @$kw = "%{$_POST['kw']}%";

       
        $sql = "SELECT DISTINCT documents.* 
        FROM documents LEFT JOIN doc_staff ON documents.id=doc_staff.doc_id
                       LEFT JOIN staff ON doc_staff.stf_id=staff.id 
        WHERE concat(doc_num, doc_title,stf_name) LIKE ?
        ORDER BY doc_num;";


       
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
      
        $result = $stmt->get_result();
        
    
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>เลขที่คำสั่ง</th>
                                <th scope='col'>ชื่อคำสั่ง</th>
                                <th scope='col'>วันที่เริ่มต้นคำสั่ง</th>
                                <th scope='col'>วันที่สิ้นสุด</th>
                                <th scope='col'>สถานะ</th>
                                <th scope='col'>ชื่อไฟล์เอกสาร</th>
                                
                            </tr>
                        </thead>
                        <tbody>";
                        
            // 
            $i = 1; 

            // ดึงข้อมูลออกมาทีละแถว และกำหนดให้ตัวแปร row 
            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->doc_num</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td><a href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
              
               
                $table.= "<td>";
                $table.= "<a href='addstafftodocument.php?id=$row->id'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a>";
               
                $table.= "</td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
</body>

</html>