<!DOCTYPE html>
<html lang=en>
<head>
    <title>Document</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body >
    <div class="page-header">
        <h1 style="text-align: center;">คำสั่งแต่งตั้ง</h1>
        <h3 style="text-align: center;">รายการคำสั่งแต่งตั้งทั้งหมด</h3>
        <h3 style="text-align: center;">เพิ่มคำสั่งแต่งตั้ง | <a href='add.php'><span class='glyphicon glyphicon-plus'></span></a></h3>
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
    <br>
    <div class="container">
    <?php
    require_once("dbconfig.php");
    @$kw = "%{$_POST['kw']}%";
    $sql = "SELECT * 
            FROM documents 
            WHERE concat(doc_num,doc_title) LIKE ? 
            ORDER BY doc_num";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $kw);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo "Not found!";
    } else {
        echo "Found " . $result->num_rows . " record(s).";
        // สร้างตัวแปรเพื่อเก็บข้อความ html 
        $table = "<table class='table table-hover container'>
                    <thead>
                        <tr>
                            <th scope='col'>#</th>
                            <th scope='col'>เลขที่คำสั่ง</th>
                            <th scope='col'>ชื่อคำสั่ง</th>
                            <th scope='col'>วันที่เริ่มต้นคำสั่ง</th>
                            <th scope='col'>วันที่สิ้นสุด</th>
                            <th scope='col'>สถานะ</th>
                            <th scope='col'>ชื่อไฟล์เอกสาร</th>
                            <th scope='col'>จัดการข้อมูลคำสั่งแต่งตั้ง</th>
                            <th scope='col'>จัดการบุคลากร</th>
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
            $table.= "<td>$row->doc_file_name</td>";
            $table.= "<td>";
            $table.= "<a href='edit.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
            $table.= " | ";
            $table.= "<a href='delete.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
            $table.= "</td>";
            $table.= "<td>";
            $table.= "<a href='staff.php?id=$row->id'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
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