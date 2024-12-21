<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css" />
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$emp_id = $_SESSION['emp_id'];
$s_code = $_SESSION['s_code'];
$sub_code = $_SESSION['sub_code'];
$class_name =  $_SESSION['class_name'];
$subject = $_SESSION['subject']; ?>
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
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="verify_grade.php" method="post" style="width: 1500px;">
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
        <div class="buttons">
            <button class="backBtn" type="submit" style="width: 150px;">

                <a class="btnText" href="registra.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Verify Student Mark</header>
        <?php
        include 'connect.php';
        ?>
        <?php

        $sql = oci_parse($conn, "select * from employee where emp_id = '$emp_id' ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $name = $rowS["NAME"];
        }
        // echo "SELECT * FROM SUB_CLASS WHERE SUB_CODE =  $s_code ";
        //   echo "select * from waec_subject where sub_code = $sub_code ";
        $sql = oci_parse($conn, "SELECT * FROM SUB_CLASS WHERE SUB_CODE =  $s_code ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $s_code = $rowS["SUB_CODE"];
            $class_name = $rowS["CLASS_NAME"];
        }

        $sql = oci_parse($conn, "select * from waec_subject where sub_code = $sub_code ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $subj = $rowS["SUBJECT"];
        }
        ?>
        <div class="input-field">
            <?php


            $term = $_SESSION['term'];
            $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.term='$term'");
            oci_execute($sql);
            if ($row = oci_fetch_array($sql)) {
                $a_y = $row['ACADEMIC_YEAR'];
                $t = $row['TERM'];
            }
            ?>
        </div>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year</label>
                <input type="text" placeholder="<?php echo $a_y ?>" style="width:300px;" readonly>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Term</label>
                <input type="text" placeholder="<?php echo $t ?>" style="width:300px;" readonly>
            </div>
            <div class="input-field" style="margin-right: 10px;">

            </div>
        </div>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Grade</label>
                <input type="text" placeholder="<?php echo $class_name ?>" style="width:300px;" readonly>
                <label>Subject</label>
                <input type="text" placeholder="<?php echo  $subj ?>" style="width:300px;" readonly>
            </div>
        </div>
        </div>
        <div>
        </div>
        <?php
        include 'connect.php';

        $sql = "SELECT * FROM STUDENT A JOIN STUDENT_CUMULATIVE B ON (A.STUD_ID=B.STUD_ID) JOIN GRADE C ON (B.G_CODE=C.G_CODE) JOIN STUDENT_EVALUATION D ON (A.STUD_ID=D.STUD_ID) WHERE B.S_ID = $sid and B.sub_code = $s_code and B.subj_code = $sub_code and  B.term = '$t' AND D.term = '$t'
        and B.academic_year  = '$a_y' AND D.academic_year  = '$a_y' and MARK_APPROVAL_PRINCIPAL IS NULL AND MARK_APPROVAL_REG ='APPROVED' order by a.name";
        //   echo $sql ;
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Student Marks</Label>
        </div>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #909290; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Continuous Assessment</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">EXAM</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Total</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Grade</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Entry Date</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">SELECT STUDENT</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td><?php echo $row['STUD_ID']; ?></td>
                            <td><?php echo $row['NAME']; ?></td>
                            <td><?php echo $row['CONST_ASS']; ?></td>
                            <td><?php echo $row['EXAM']; ?></td>
                            <td><?php echo $row['EXAM'] + $row['CONST_ASS']; ?></td>
                            <td><?php echo $row['GRADE']; ?></td>
                            <td><?php echo $row['ENTRY_DT']; ?></td>
                            <td><input type="checkbox" name="enroll[]" value="<?php echo $row['STUD_ID']; ?>"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="accept" type="submit">
                APPROVE
                <i class="uil uil-check-circle"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="accept_all" type="submit">
                APPROVE ALL
                <i class="uil uil-check-circle"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="reject" type="submit">
                REJECT
                <i class="uil uil-multiply"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="reject_all" type="submit">
                REJECT ALL
                <i class="uil uil-multiply"></i>
            </button>
        </div>
        <?php

        require('tcpdf/tcpdf.php');
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['accept_all'])) {

            $sql = oci_parse($conn, "SELECT * FROM STUDENT A JOIN STUDENT_CUMULATIVE B ON (A.STUD_ID=B.STUD_ID) JOIN GRADE C ON (B.G_CODE=C.G_CODE) JOIN STUDENT_EVALUATION D ON (A.STUD_ID=D.STUD_ID) WHERE B.S_ID = $sid and B.sub_code = $s_code and B.subj_code = $sub_code and  B.term = '$t' AND D.term = '$t'
        and B.academic_year  = '$a_y' AND D.academic_year  = '$a_y' and MARK_APPROVAL_PRINCIPAL IS NULL AND MARK_APPROVAL_REG ='APPROVED' order by a.name");

            oci_execute($sql);
            while ($r = oci_fetch_array($sql)) {
                $id = $r['STUD_ID'];
                $t = $r['TERM'];
                $ay = $r['ACADEMIC_YEAR'];
                $classcode = $r['CLASS_CODE'];
                $subcode = $r['SUB_CODE'];

                $sql = oci_parse($conn, "UPDATE STUDENT_CUMULATIVE SET MARK_APPROVAL_PRINCIPAL='APPROVED' WHERE 
                STUD_ID ='$id'AND term ='$t'AND ACADEMIC_YEAR = '$ay' AND SUB_CODE = $classcode AND SUBJ_CODE = $subcode ");

                if (oci_execute($sql)) {

        ?><div style="font-size:15px;
            color: green;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                        <?php
                        echo '<script>
             Swal.fire({
                 position: "center",
                 icon: "success",
                 title: "MARK APPROVED",
                 showConfirmButton: false,
                 timer: 1500
               });
             </script>';
                        //    echo "STUDENT MARK ACCEPTED";
                        header("refresh:2;");
                        ?>
                    </div> <?php
                        } else {

                            ?><div style="font-size:15px;
            color: green;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                        <?php
                            echo '<script>
             Swal.fire({
                 position: "center",
                 icon: "error",
                 title: "ERROR APPROVING MARK",
                 showConfirmButton: false,
                 timer: 1500
               });
             </script>';

                            // echo "ERROR ACCEPTING STUDENT MARK";
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    }
                }
                if (isset($_POST['accept'])) {
                    if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                        $selectedStudentIds = $_POST['enroll'];
                        foreach ($selectedStudentIds as $studentId) {

                            $stud_id = $studentId;
                            $getdetails = oci_parse($conn, "SELECT * FROM STUDENT A JOIN STUDENT_CUMULATIVE B ON (A.STUD_ID=B.STUD_ID) JOIN GRADE C ON (B.G_CODE=C.G_CODE) JOIN STUDENT_EVALUATION D ON (A.STUD_ID=D.STUD_ID) WHERE B.S_ID = $sid and B.sub_code = $s_code and B.subj_code = $sub_code and  B.term = '$t' AND D.term = '$t'
        and B.academic_year  = '$a_y' AND D.academic_year  = '$a_y' and MARK_APPROVAL_PRINCIPAL IS NULL AND MARK_APPROVAL_REG ='APPROVED'  order by a.name");

                            oci_execute($getdetails);

                            while ($r = oci_fetch_array($getdetails)) {
                                $id = $r['STUD_ID'];
                                $t = $r['TERM'];
                                $ay = $r['ACADEMIC_YEAR'];
                                $classcode = $r['CLASS_CODE'];
                                $subcode = $r['SUB_CODE'];

                                $sql = oci_parse($conn, "UPDATE STUDENT_CUMULATIVE SET MARK_APPROVAL_PRINCIPAL='APPROVED' WHERE 
                STUD_ID ='$id'AND term ='$t'AND ACADEMIC_YEAR = '$ay' AND SUB_CODE = $classcode AND SUBJ_CODE = $subcode ");

                                if (oci_execute($sql)) {

                            ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                <?php
                                    echo '<script>
                         Swal.fire({
                             position: "center",
                             icon: "success",
                             title: "MARK APPROVED",
                             showConfirmButton: false,
                             timer: 1500
                           });
                         </script>';
                                    //    echo "STUDENT MARK ACCEPTED";
                                    header("refresh:2;");
                                ?>
                            </div> <?php
                                } else {

                                    ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                <?php
                                    echo '<script>
                         Swal.fire({
                             position: "center",
                             icon: "error",
                             title: "ERROR APPROVING MARK",
                             showConfirmButton: false,
                             timer: 1500
                           });
                         </script>';

                                    // echo "ERROR ACCEPTING STUDENT MARK";
                                    header("refresh:2;");
                                ?>
                            </div> <?php
                                }
                            }
                        }
                    } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                    <?php echo '<script>
                     Swal.fire({
                         position: "center",
                         icon: "warning",
                         title: "NO STUDENT SELECTED",
                         showConfirmButton: false,
                         timer: 1500
                       });
                     </script>';
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }

                if (isset($_POST['reject_all'])) {
                    $sql = oci_parse($conn, "SELECT * FROM STUDENT A JOIN STUDENT_CUMULATIVE B ON (A.STUD_ID=B.STUD_ID) JOIN GRADE C ON (B.G_CODE=C.G_CODE) JOIN STUDENT_EVALUATION D ON (A.STUD_ID=D.STUD_ID) WHERE B.S_ID = $sid and B.sub_code = $s_code and B.subj_code = $sub_code and  B.term = '$t' AND D.term = '$t'
        and B.academic_year  = '$a_y' AND D.academic_year  = '$a_y' and MARK_APPROVAL_PRINCIPAL IS NULL AND MARK_APPROVAL_REG ='APPROVED'  order by a.name");

                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $id = $r['STUD_ID'];
                        $t = $r['TERM'];
                        $ay = $r['ACADEMIC_YEAR'];
                        $classcode = $r['CLASS_CODE'];
                        $subcode = $r['SUB_CODE'];

                        $del = oci_parse($conn, "DELETE FROM STUDENT_CUMULATIVE WHERE S_ID = $sid AND  SUB_CODE = $s_code AND SUBJ_CODE = $sub_code AND STUD_ID = '$studentId' AND MARK_APP ");

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_EVALUATION WHERE S_ID = $sid  and CLASS_CODE = $s_code AND SUB_CODE = $sub_code  AND STUD_ID = '$studentId' ");

                        if (oci_execute($sql)) {

                        ?><div style="font-size:15px;
        color: green;
        position: relative;
         display:flex;
        animation:button .3s linear;text-align: center;">
                        <?php
                            echo '<script>
         Swal.fire({
             position: "center",
             icon: "success",
             title: "MARK APPROVED",
             showConfirmButton: false,
             timer: 1500
           });
         </script>';
                            //    echo "STUDENT MARK ACCEPTED";
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        } else {

                            ?><div style="font-size:15px;
        color: green;
        position: relative;
         display:flex;
        animation:button .3s linear;text-align: center;">
                        <?php
                            echo '<script>
         Swal.fire({
             position: "center",
             icon: "error",
             title: "ERROR APPROVING MARK",
             showConfirmButton: false,
             timer: 1500
           });
         </script>';

                            // echo "ERROR ACCEPTING STUDENT MARK";
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    }
                }
                if (isset($_POST['reject'])) {
                    if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                        $selectedStudentIds = $_POST['enroll'];
                        foreach ($selectedStudentIds as $studentId) {
                            $del = oci_parse($conn, "DELETE FROM STUDENT_CUMULATIVE WHERE S_ID = $sid AND  SUB_CODE = $s_code AND SUBJ_CODE = $sub_code AND STUD_ID = '$studentId'  ");

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_EVALUATION WHERE S_ID = $sid  and CLASS_CODE = $s_code AND SUB_CODE = $sub_code  AND STUD_ID = '$studentId' ");
                            if (oci_execute($sql) && oci_execute($del)) {
                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "success",
                                 title: "STUDENT MARK REJECTED",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
                                header("refresh:2;");
                            ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "error",
                                 title: "ERROR REJECTING STUDENT MARK",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
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
                    <?php
                        echo '<script>
                     Swal.fire({
                         position: "center",
                         icon: "warning",
                         title: "NO STUDENT SELECTED",
                         showConfirmButton: false,
                         timer: 1500
                       });
                     </script>';



                        //  echo "NO STUDENT SELECTED";
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="select_mark_approval.php">
                    BACK
                </a>
            </button>
        </div>
        <?php
        require 'D:\Junior\Registra\PHPMailer.php';
        require 'D:\Junior\Registra\Exception.php';
        require 'D:\Junior\Registra\SMTP.php';



        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;


        ?>

    </form>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>