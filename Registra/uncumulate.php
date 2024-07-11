<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_users.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$class = '';
$s_code = $_SESSION['s_code'];
$school =  $_SESSION['school'];
$sid = $_SESSION['sid']; ?>
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
    <form class="container" enctype="multipart/form-data" action="uncumulate.php" method="post">
        <div class="com">
            <h3 style="color:#909290;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color:#909290; 	font-size: 18px;"><?php echo $school ?>
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
        <header>Uncumulated Marks</header>
        <div class="input-field">
            <?php
            $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where status = 'ACCEPTED' order by term");
            oci_execute($sql);
            if ($row = oci_fetch_array($sql)) {
                $a_y = $row['ACADEMIC_YEAR'];
                $t = $row['TERM'];
            }
            $sql = oci_parse($conn, "SELECT * FROM SUB_CLASS WHERE sub_code = $s_code and s_id = $sid ");
            oci_execute($sql);
            if ($rowS = oci_fetch_array($sql)) {
                $s_code = $rowS["SUB_CODE"];
                $class_name = $rowS["CLASS_NAME"];
            }
            ?>
            <?php
            include 'connect.php';

            if ($conn) {
                $status = 'PENDING';
                $sql = "SELECT A.NAME,C.SUBJECT,D.CLASS_NAME,E.NAME AS TEACHER,B.ENTRY_DT,B.MARK_STATUS
                FROM STUDENT A
                JOIN STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID JOIN WAEC_SUBJECT C ON (B.SUB_CODE=C.SUB_CODE) JOIN SUB_CLASS D ON (B.CLASS_CODE=D.SUB_CODE) JOIN EMPLOYEE E ON (B.EMP_ID=E.EMP_ID)
                WHERE B.S_ID = $sid AND B.CLASS_CODE =$s_code
                  AND MARK_STATUS = 'ACCEPTED'
                  and  b.term = '$t'
             and b.academic_year = '$a_y'
                  AND NOT EXISTS (
                    SELECT 1 FROM STUDENT_CUMULATIVE SC WHERE SC.stud_id = A.stud_id AND SC.sub_code = B.CLASS_code AND SC.SUBJ_CODE = B.SUB_CODE and sc.academic_year ='$a_y' and sc.term = '$t'
                  )";
                //echo $sql;
                $stidd = oci_parse($conn, $sql);
                oci_execute($stidd);
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
                    <label>Grade</label>
                    <input type="text" placeholder="<?php echo $class_name ?>" style="width:300px;" readonly>
                </div>
            </div>
            <div style="overflow-x:auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                    <thead>
                        <tr style="background-color: #909290; color: #ffffff; text-align: left; font-weight: bold;">
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student Name</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Entry Date </th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Mark Entry By</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Mark Status</th>
                        </tr>
                    </thead>
                </table>
                <div style="max-height: 200px; overflow-y: auto;">
                    <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                        <tbody>
                            <?php
                            while ($row = oci_fetch_array($stidd)) {
                                $class_name = $row['CLASS_NAME'];
                            ?>
                                <tr style="border-bottom: 1px solid #dddddd;">
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUBJECT']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['ENTRY_DT']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['TEACHER']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['MARK_STATUS']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                    GENERATE AND DOWNLOAD UNCUMULATED MARKS REPORT
                    <i class="bi bi-box-arrow-down"></i>
                </button>
            </div>

            </button>
            <?php
            require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            if (isset($_POST['generate'])) {
                $status = 'PENDING';
                $query = "SELECT A.NAME,C.SUBJECT,D.CLASS_NAME,E.NAME AS TEACHER,B.ENTRY_DT,B.MARK_STATUS
                FROM STUDENT A
                JOIN STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID JOIN WAEC_SUBJECT C ON (B.SUB_CODE=C.SUB_CODE) JOIN SUB_CLASS D ON (B.CLASS_CODE=D.SUB_CODE) JOIN EMPLOYEE E ON (B.EMP_ID=E.EMP_ID)
                WHERE B.S_ID = $sid AND B.CLASS_CODE =$s_code
                  AND MARK_STATUS = 'ACCEPTED'
                  and  b.term = '$t'
             and b.academic_year = '$a_y'
                  AND NOT EXISTS (
                    SELECT 1 FROM STUDENT_CUMULATIVE SC WHERE SC.stud_id = A.stud_id AND SC.sub_code = B.CLASS_code AND SC.SUBJ_CODE = B.SUB_CODE and sc.academic_year ='$a_y' and sc.term = '$t'
                  )";
                // Prepare and execute the query
                $statement = oci_parse($conn, $query);
                oci_execute($statement);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'NAME');
                $sheet->setCellValue('B1', 'SUBJECT');
                $sheet->setCellValue('C1', 'CLASS');
                $sheet->setCellValue('D1', 'ENTRY DATE');
                $sheet->setCellValue('E1', 'ENTRY BY');
                $sheet->setCellValue('F1', 'STATUS');

                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\unprocessed\\';
                if (!is_dir($directoryPath)) {
                    if (!mkdir($directoryPath, 0777, true)) {
                        die('Failed to create directories.');
                    }
                }
                $filePath = $directoryPath . $class_name . '.xlsx';
                $row = 2;
                while ($row_data = oci_fetch_assoc($statement)) {
                    $sheet->setCellValue('A' . $row, $row_data['NAME']);
                    $sheet->setCellValue('B' . $row, $row_data['SUBJECT']);
                    $sheet->setCellValue('C' . $row, $row_data['CLASS_NAME']);
                    $sheet->setCellValue('D' . $row, $row_data['ENTRY_DT']);
                    $sheet->setCellValue('E' . $row, $row_data['TEACHER']);
                    $sheet->setCellValue('F' . $row, $row_data['MARK_STATUS']);
                    $row++;
                }
                $writer = new Xlsx($spreadsheet);
                // Output the Excel file
                $writer->save($filePath)
            ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "FILE GENERATED TO $filePath";
                    $_SESSION['school'] = $school;
                    $_SESSION['class_name'] = $class_name;

                    $_SESSION['path'] = $filePath;
                    $_SESSION['file'] = $class_name . '.xlsx';
                    $_SESSION['redirect'] = 'uncumulate.php';
                    header('Location: download_excel.php');
                    //  header("refresh:2;"); 
                    ?>
                </div> <?php
                        // Close the Oracle connection
                        oci_free_statement($statement);
                        oci_close($conn);
                    }
                        ?>
            <div class="buttons">

                <button class="backBtn" type="submit">

                    <a class="btnText" href="select_uncumulate.php">
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