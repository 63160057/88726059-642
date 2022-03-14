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
        <h1 style="text-align: center;">บุคลากร</h1>
        <h3 style="text-align: center;">รายชื่อบุคลากรที่แต่งตั้งทั้งหมด</h3>
        <h3 style="text-align: center;">เพิ่มบุคลากร | <a href='staffAdd.php'><span class='glyphicon glyphicon-plus'></span></a></h3>
    </div>
    <form class="form-horizontal container" action="#" methode="post">
        <div class="input-group col-sm-12">
          <input type="text" class="form-control" name="kw" placeholder="ค้นหาจาก รหัสพนักงาน หรือ ชื่อพนักงาน">
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
            FROM staff 
            WHERE concat(stf_code,stf_name) LIKE ? 
            ORDER BY stf_code";
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
                            <th scope='col'>รหัสพนักงาน</th>
                            <th scope='col'>ชื่อ - นามสกุล</th>
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
            $table.= "<td>$row->stf_code</td>";
            $table.= "<td>$row->stf_name</td>";
            $table.= "<td>";
            $table.= "<a href='staffEdit.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
            $table.= " | ";
            $table.= "<a href='staffDelete.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
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