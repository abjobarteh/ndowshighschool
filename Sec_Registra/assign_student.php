<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<?php
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
include 'connect.php'; ?>
<style>
    .field select:focus {
        padding-left: 47px;
        border: 2px solid #909290;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #909290;
    }
</style>

<body>
    <form class="container" enctype="multipart/form-data" action="assign_student.php" method="post">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <h2 class="title" style="justify-content:center; text-align:center; color:#909290; 	font-size: 18px;"><?php echo $school ?>
            </h2>
            <?php
            $stmt = oci_parse($conn, "select * from school where school = :name");
            oci_bind_by_name($stmt, ':name', $school);
            oci_execute($stmt);
            if ($rowS = oci_fetch_array($stmt)) {
                $imageData = $rowS['LOGO']->load(); // Load OCILob data

                // Encode the image data as base64
                $base64Image = base64_encode($imageData);
            ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px;"><?php

                                                                            echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">'; ?></td> <?php
                                                                                                                                                                                                }
                                                                                                                                                                                                    ?>
        </div>
        <header>Enroll Student</header>
        <?php
        include 'connect.php';
        $region = " ";
        $stuid = 'stuid';
        $sc = '0';
        $cc = '0';
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Grade To Enroll</option>
                <?php

                $get_hos = "select * from SUB_CLASS WHERE S_ID= $sid order by class";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
            FILTER
            <i class="uil uil-filter"></i>
        </button>
        </div>
        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $c_n = $_POST['reg'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n'  and s_id = $sid ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $class_code  = $r['CLASS'];
                    $sub_code = $r['SUB_CODE'];
                    $cc = $class_code;
                    $sc = $sub_code;
                }
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT GRADE";
                    header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <div>
        </div>
        <?php

        include 'connect.php';
        if ($conn) {
            $sql = "select * from student A JOIN student_document B ON (A.STUD_ID=B.STUD_ID) JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'REGISTERED' AND C.CLASS= $cc";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Student Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #909290;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Photo ID</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Status</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Registration Date</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ACCEPT</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <?php
                        $imageData = $row['PASS_PHOTO']->load();
                        $base64Image = base64_encode($imageData);
                        ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px;"><?php
                                                                                        echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 50px; height: 50px;">'; ?></td> <?php
                                                                                                                                                                                                                ?>
                        <td><?php echo $row['NAME']; ?></td>
                        <td><?php echo $row['STATUS']; ?></td>
                        <td><?php echo $row['CREATE_DT']; ?></td>
                        <td><input type="checkbox" name="enroll[]" value="<?php echo $row['STUD_ID']; ?>"></td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="enroll_student" type="submit">
                ENROLL
                <i class="uil uil-user-check"></i>
            </button>

        </div>
        <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #000000;">Assign Elective To Student</Label>
        <div class="input-field">
            <select required name="ele_reg">
                <option disabled selected>Select Student</option>
                <?php
                $get_hos = "select * from student WHERE S_ID= $sid and status = 'SEMI-ENROLLED' ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["STUD_ID"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter_ele" type="submit">
                FILTER
                <i class="uil uil-filter"></i>
            </button>
        </div>
        <?php
        $s_c = 0;
        if (isset($_POST['filter_ele'])) {
            if (isset($_POST['ele_reg'])) {
                $id = $_POST['ele_reg'];
                $sql = oci_parse($conn, "select * from class_student where stud_id = '$id' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $s_c = $r['SUB_CODE'];
                }
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "NO STUDENT SELECTED";
                    header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <div class="input-field">
            <select required name="ele_sub">
                <option disabled selected>Select Subject</option>
                <?php
                $get_hos = "select * from subject where sub_type = 'ELECTIVE' and subs = $s_c order by subject";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["SUBJECT"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="add_elective" type="submit">
                ASSIGN ELECTIVE
                <i class="uil uil-plus"></i>
            </button>

        </div>
        <?php
        if (isset($_POST['add_elective'])) {
            
            if (isset($_POST['ele_reg'])) {
                $stu = $_POST['ele_reg'];
                $sql = oci_parse($conn,"select * from class_student where stud_id = '$stu' ");
                oci_execute($sql);
                while($a=oci_fetch_array($sql)){
                    $subs= $a['SUB_CODE'];
                    $class=$a['CLASS'];
                }
                if (isset($_POST['ele_sub'])) {
                    $ele = $_POST['ele_sub'];
                    $sql = oci_parse($conn, "select * from subject where subject = '$ele' ");
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $sub_code = $r['SUB_CODE'];
                    }
                    $check_numofsub = oci_parse($conn, "select * from student_subject where stud_id = '$stu' ");
                    oci_execute($check_numofsub);
                    if (oci_fetch_all($check_numofsub, $a) <= 9) {
                        $check_dup = oci_parse($conn,"select * from student_subject where stud_id = '$stu' and sub_code = '$sub_code' ");
                        oci_execute($check_dup);
                        if(oci_fetch_all($check_dup,$b)==0){
                            $sql = oci_parse($conn,"insert into student_subject (stud_id,sub_code,class,s_id) values ('$stu','$sub_code','$class',$sid) ");
                            if(oci_execute($sql)){
                                ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "COURSE ASSIGNED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?>
                                    </div> <?php
                            }else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR ASSIGNING COURSE TO STUDENT";
                                        header("refresh:2;");
                                        ?>
                                    </div> <?php
                            }
                        }else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "STUDENT ALREADY TAKING SUBJECT";
                                    header("refresh:2;");
                                    ?>
                                </div> <?php
                        }
                    } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "NUMBER OF SUBJECTS EXCEEDED";
                            header("refresh:2;");
                            ?>
                        </div> <?php
                            }
                        }else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SELECT SUBJECT";
                                    header("refresh:2;");
                                ?>
                            </div> <?php
                        }
                    } else {
                                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT STUDENT";
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['enroll_student'])) {
            if (isset($_POST['reg'])) {
                $c_n = $_POST['reg'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $cc  = $r['CLASS'];
                    $sub_code = $r['SUB_CODE'];
                }
                if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                    $selectedStudentIds = $_POST['enroll'];
                    foreach ($selectedStudentIds as $studentId) {
                        $sql = oci_parse($conn, "select * from CLASS_STUDENT WHERE STUD_ID = '$studentId' ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "insert into class_student (S_ID,SUB_CODE,CLASS,STUD_ID) VALUES ($sid,$sub_code,$cc,'$studentId') ");
                            $get_subj = oci_parse($conn, "select * from subject where subs = $sub_code and sub_type = 'CORE' ");
                            oci_execute($get_subj);
                            oci_execute($sql);
                            while ($r = oci_fetch_array($get_subj)) {
                                $s_code = $r['SUB_CODE'];
                                $insert_subj = oci_parse($conn, "insert into student_subject (S_ID,SUB_CODE,CLASS,STUD_ID) values ($sid,$s_code,$cc,'$studentId')");
                                oci_execute($insert_subj);
                            }


                            $get_fee = oci_parse($conn, "select sum(cost) from tuition where s_id= $sid and sub_code = $sub_code ");
                            oci_execute($get_fee);
                            while ($r = oci_fetch_array($get_fee)) {
                                $fee = $r['SUM(COST)'];
                            }


                            $check = oci_parse($conn, "select * from student_finance where stud_id = '$studentId' ");
                            oci_execute($check);

                            if (oci_fetch_all($check, $a) == 0) {
                                $sql = oci_parse($conn, "insert into student_finance (s_id,class,stud_id,fee,balance,SUB_CODE)  values ($sid,$cc,'$studentId',$fee,$fee,$sub_code)");
                                oci_execute($sql);
                            }

                            $upd =  oci_parse($conn, "update student set status = 'SEMI-ENROLLED' WHERE  STUD_ID = '$studentId' ");
                            oci_execute($upd);
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SELECTED STUDENT ENROLLED AND ASSIGNED SUBJECTS";
                                header("refresh:2;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "STUDENT ALREADY ENROLLED";
                                    header("refresh:2;");
                                ?>
                            </div> <?php
                                }
                            }
                        } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "NO STUDENT SELECTED";
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT GRADE";
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }

                        ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="registra.php">
                    BACK
                </a>
            </button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>