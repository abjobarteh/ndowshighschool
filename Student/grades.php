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
$sub_cd =  $_SESSION['s_code'];
$stuid = $_SESSION['username'];
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
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="grades.php" method="post" style="width: 2500px;">
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

                <a class="btnText" href="student.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>
            </button>
        </div>
        <header>Grades</header>
        <?php
        include 'connect.php';
        $region = " ";

        //  echo  "select * from student a  join class_student c on (a.stud_id=c.stud_id) where a.s_id = $sid and c.sub_code = $sub_cd and a.status != 'GRADUATED' ORDER BY NAME";
        ?>

        <?php

        include 'connect.php';

        $region = " ";
        $term = ""
        ?>
        <div class="input-field">
            <?php ///echo "SELECT DISTINCT(TERM) FROM STUDENT_EVALUATION WHERE STUD_ID = '$stuid' ORDER BY TERM"?>
            <select required name="reg">
                <option disabled selected>Select Term</option>
                <?php
                $get_hos = "SELECT DISTINCT(TERM) FROM STUDENT_EVALUATION WHERE STUD_ID = '$stuid' ORDER BY TERM";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["TERM"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>

        <?php // echo $get_hos; 

        ?>
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
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
            GENERATE STUDENT REPORT
            <i class="uil uil-file-export"></i>
        </button>

        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $term = $_POST['reg'];
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT TERM";
                    header("refresh:2;"); ?>
                </div> <?php
                    }
                }

                

                $s = "SELECT b.subject,a.const_ass,a.exam FROM STUDENT_EVALUATION A JOIN WAEC_SUBJECT B ON (A.SUB_CODE=B.SUB_CODE) WHERE A.STUD_ID = '$stuid' and a.term = '$term' ";
                //  echo $s;
                $subj = oci_parse($conn, $s);
                oci_execute($subj);

                        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Term Marks</Label>
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
                        Subject</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Continuous Assessment (30%)</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Exam (70%)</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($subj)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUBJECT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CONST_ASS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EXAM']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        ob_start();

        $a = "SELECT b.subject,a.MARK,C.GRADE FROM STUDENT_CUMULATIVE A JOIN WAEC_SUBJECT B ON (A.SUBJ_CODE=B.SUB_CODE) JOIN GRADE C ON (A.G_CODE=C.G_CODE) WHERE A.STUD_ID = '$stuid' and a.term = '$term' ";
        //  echo $s;
        $subss = oci_parse($conn, $a);
        oci_execute($subss);

        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Cumulated Marks</Label>
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
                        Subject</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Total</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($subss)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUBJECT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MARK']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['GRADE']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        $a = "SELECT * FROM STUDENT_standings where stud_id = '$stuid' and term = '$term' ";
        //  echo $s;
        $subss = oci_parse($conn, $a);
        oci_execute($subss);

        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">TERM GPA</Label>
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
                        GPA</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($subss)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['AVERAGE']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
      
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="student.php">
                    BACK
                </a>
            </button>
            <?php
             require('tcpdf/tcpdf.php');
             require '../vendor/autoload.php';
            
            if (isset($_POST['generate'])) {
                    if (isset($_POST['reg'])) {
                        $t = $_POST['reg'];
                        $sql = oci_parse($conn,"SELECT * FROM TERM_CALENDAR WHERE TERM = '$t' ");
                        oci_execute($sql);
                        while($row = oci_fetch_array($sql)){
                            $a_y = $row['ACADEMIC_YEAR'];
                        }
                        $stuid = $_SESSION['username'];
                        
                        $sql = oci_parse($conn, "select * from sub_class a join class_student b on (a.sub_code=b.sub_code) where  a.sub_code != 286 and a.sub_code != 290 and a.sub_code != 141 and b.stud_id ='$stuid' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $stud_ids[] = $r['STUD_ID'];
                            $sub_code = $r['SUB_CODE'];
                            $class_name=$r['CLASS_NAME'];
                        }
                        //   $s = "SELECT DISTINCT(A.SUBJECT),ROUND(c.CONST_ASS,0) AS CA,ROUND(c.EXAM,0) AS EXAM , ROUND(D.MARK,0) AS TOTAL,F.GRADE,D.CREDIT_HRS,D.GPA FROM WAEC_SUBJECT A JOIN STUDENT_SUBJECT B ON (A.SUB_CODE=B.SUB_CODE) JOIN STUDENT_EVALUATION C ON (B.SUB_CODE=C.SUB_CODE) JOIN STUDENT_CUMULATIVE D ON (A.SUB_CODE=D.SUBJ_CODE) JOIN STUDENT E ON (D.STUD_ID=E.STUD_ID) JOIN GRADE F ON (D.G_CODE=F.G_CODE)  WHERE C.STUD_ID = '$st' AND D.STUD_ID = '$st' and b.stud_id= '$st'  AND D.ACADEMIC_YEAR ='$a_y' and D.term = '$t' AND E.STATUS != 'GRADUATED' ORDER BY A.SUBJECT ";

                        //    echo  $s;

                        foreach ($stud_ids as $st) {
                            // echo $st;
                            $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) where c.s_id =:sid  ");
                            oci_bind_by_name($stmt, ':sid', $sid);
                            oci_execute($stmt);
                            while ($row = oci_fetch_array($stmt)) {
                                $region = 'REGION ONE';
                                $district = $row['DISTRICT'];
                                $school = $row['SCHOOL'];
                                $address = $row['ADDRESS'];
                                $phone_one = $row['PHONE_ONE'];
                                $phone_two = $row['PHONE_TWO'];
                                $email = $row['EMAIL'];
                                $imageData = $row['LOGO']->load(); // Load OCILob data
                                $decodedContent = base64_decode($imageData);
                                $saveDirectory = 'C:/wamp64/www/Academix/Sec_Registra/img/';
                                $fileName = "school logo.png";
                                if (!is_dir($saveDirectory)) {
                                    mkdir($saveDirectory, 0777, true); // Specify the appropriate permissions
                                }
                                $filePath = $saveDirectory . $fileName;
                                file_put_contents($filePath, $imageData);
                            }
                            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                            $pdf->AddPage();
                            $pdf->SetHeaderMargin(0); // Set the header margin to zero
                            $pdf->setPrintHeader(false);
                            $pdf->setPrintFooter(false);
                            $pdf->SetFont('helvetica', '', 10);
                            $pdf->SetTextColor(29, 91, 121);
                            $pdf->SetFont('helvetica', 'B', 13);
                            $pdf->Ln();
                            $pdf->Cell(10, 60, 'STUDENT TERM REPORT', 0, 1, 'L');

                            $pdf->Ln();
                            $logoPath  = 'img/school logo.png';
                            $pdf->Image($logoPath, 10, 15, 30, 20);
                            //            $pdf->Image($logoPath, 170, 15, 30, 35);
                            $pdf->SetTextColor(29, 91, 121);
                            $pdf->SetXY(60, 10);
                            $pdf->SetFont('helvetica', 'B', 15);
                            $pdf->Cell(0, 5, $school, 0, 1);
                            $companyInfo = "$address\n$district\nREGION\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                            $pdf->SetFont('dejavusans', 'B', 8); // Adjust font size for school information
                            $pdf->SetXY(130, 20);
                            $pdf->MultiCell(0, 5, $companyInfo, 0, 'R');

                            $pdf->SetY($pdf->GetY() + 5);
                            $pdf->SetFont('dejavusans', '', 7); // Adjust the Y position to leave space for the title
                            $pdf->Cell(10, 10, 'Date:  ', 0, 0);
                            $pdf->Cell(0, 10, date('d/m/Y'), 0, 1);
                            $pdf->SetX(170);
                            $pdf->SetFont('times', '', 8); // Adjust the font size as needed

                            $pdf->Cell(0, 5, $t, 0, 1, 'R'); // Replace $academicYear with the actual variable holding the value

                            $pdf->SetX(170);

                            $sql = "SELECT * FROM STUDENT A JOIN CLASS_STUDENT B ON (A.STUD_ID=B.STUD_ID) JOIN STUDENT_PERSONAL C ON (A.STUD_ID = C.STUD_ID) JOIN SUB_CLASS D ON (B.SUB_CODE=D.SUB_CODE) JOIN PROG_CLASS E ON (D.SUB_CODE=E.SUB_CODE) JOIN PROGRAMME F ON (E.PROG_ID=F.PROG_ID) WHERE A.S_ID = $sid AND B.SUB_CODE = $sub_code and a.stud_id = trim('$st')  AND A.STATUS != 'GRADUATED' ORDER BY A.NAME";

                            $stmts = oci_parse($conn, $sql);
                            oci_execute($stmts);
                            $pdf->SetFont('times', 'B', 9);
                            // Reset font style

                            if ($row = oci_fetch_assoc($stmts)) {

                                // Adjust the Y-coordinate after adding the cell
                                $pdf->SetY($pdf->GetY() + 5);

                                $name = $row['NAME'];
                                $st = $row['STUD_ID'];
                                $std = $row['STDNUMBER'];
                                $f = $row['FIRSTNAME'];
                                $m = $row['MIDDLENAME'];
                                $n = $row['LASTNAME'];
                                $cl = $row['CLASS_NAME'];
                                $subcode = $row['SUB_CODE'];
                                $prog = $row['PROG'];

                                $name = $f . " " . $m . " " . $n;
                                if ($std != '') {
                                    $pdf->Cell(40, 5, 'Student ID:', 0, 0, 'C');
                                    $pdf->Cell(50, 5, $std, 0, 1, 'C');
                                } else {
                                    $pdf->Cell(40, 5, 'Student ID:', 0, 0, 'C');
                                    $pdf->Cell(50, 5, $st, 0, 1, 'C');
                                }


                                $pdf->Cell(40, 5, 'Name:', 0, 0, 'C');
                                $pdf->Cell(50, 5, $name, 0, 1, 'C');

                                $pdf->Cell(40, 5, 'Class Name:', 0, 0, 'C');
                                $pdf->Cell(50, 5, $cl, 0, 1, 'C');

                                $pdf->Cell(40, 5, 'Programme:', 0, 0, 'C');
                                $pdf->Cell(50, 5, $prog, 0, 1, 'C');



                                $s = "SELECT DISTINCT(C.STUD_ID),A.SUBJECT,ROUND(c.CONST_ASS,0) AS CA,ROUND(c.EXAM,0) AS EXAM , ROUND(D.MARK,0) AS TOTAL,F.GRADE,F.GRADE,F.INTERPRETATION FROM WAEC_SUBJECT A JOIN STUDENT_SUBJECT B ON (A.SUB_CODE=B.SUB_CODE) JOIN STUDENT_EVALUATION C ON (B.SUB_CODE=C.SUB_CODE) JOIN STUDENT_CUMULATIVE D ON (A.SUB_CODE=D.SUBJ_CODE) JOIN STUDENT E ON (D.STUD_ID=E.STUD_ID) JOIN GRADE F ON (D.G_CODE=F.G_CODE)  WHERE C.STUD_ID = trim('$st') AND D.STUD_ID = trim('$st') and b.stud_id= trim('$st')  AND D.ACADEMIC_YEAR ='$a_y' and C.term = '$t'  AND C.ACADEMIC_YEAR ='$a_y' and D.term = '$t' AND C.MARK_STATUS ='ACCEPTED' AND C.CLASS_CODE=$sub_code AND D.SUB_CODE = $sub_code ORDER BY A.SUBJECT ";

                                //   echo  $s;
                                $stmts = oci_parse($conn, $s);
                                oci_execute($stmts);
                                // ... (your existing code)

                                // Output the subject grades in a table
                                $pdf->SetFont('times', 'B', 7.5);
                                // Set a slightly smaller font size for the headings
                                // Table header without background color
                                $pdf->Cell(50, 8, 'Subject', 1, 0, 'C');
                                $pdf->Cell(20, 8, 'CASS (30%)', 1, 0, 'C');
                                $pdf->Cell(25, 8, 'Exam (70%) ', 1, 0, 'C');
                                $pdf->Cell(25, 8, 'Total', 1, 0, 'C');
                                $pdf->Cell(20, 8, 'Grade', 1, 0, 'C');
                                $pdf->Cell(25, 8, 'Remark', 1, 0, 'C'); // Move to the next line after the last cell
                                //  $pdf->Cell(25, 8, 'Remark', 1, 0, 'C');
                                // Table content with borders
                                $pdf->SetFont('times', 'B', 8);

                                $pdf->Ln();
                                // Adjust the font size for the content
                                while ($row = oci_fetch_assoc($stmts)) {
                                    $subj = $row['SUBJECT'];

                                    $ca = $row['CA'];
                                    $e = $row['EXAM'];
                                    $tt = $row['TOTAL'];
                                    $g = $row['GRADE'];
                                    $rm = $row['INTERPRETATION'];

                                    $pdf->Cell(50, 8, $subj, 1, 0, 'C');
                                    $pdf->Cell(20, 8, $ca, 1, 0, 'C');
                                    $pdf->Cell(25, 8, $e, 1, 0, 'C');
                                    $pdf->Cell(25, 8, $tt, 1, 0, 'C');
                                    $pdf->Cell(20, 8, $g, 1, 0, 'C');
                                    $pdf->Cell(25, 8, $rm, 1, 0, 'C');
                                    $pdf->SetTextColor(29, 91, 121);

                                    $pdf->Ln();
                                    $get = "select ROUND(SUM(CONST_ASS),0) AS TOTAL_CASS,ROUND(SUM(EXAM),0) AS TOTAL_EXAM,ROUND(AVG(CONST_ASS),0) AS AVG_CASS,ROUND(AVG(EXAM),0) AS AVG_EXAM FROM STUDENT_EVALUATION  where stud_id = trim('$st')and academic_year = '$a_y' and term = '$t' and class_code = $sub_code ";
                                    $sql = oci_parse($conn, $get);
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        $total_cass = $row['TOTAL_CASS'];
                                        $total_exam = $row['TOTAL_EXAM'];
                                        $avg_cass = $row['AVG_CASS'];
                                        $avg_exam = $row['AVG_EXAM'];
                                    }
                                    $set = "select ROUND(SUM(MARK),2) AS TOTAL_TOTAL,ROUND(AVG(MARK),2) AS AVG_MARK FROM STUDENT_CUMULATIVE WHERE stud_id = trim('$st') and academic_year = '$a_y' and term = '$t' and sub_code = $sub_code";
                                    $sql = oci_parse($conn, $set);
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                    
                                        $total_total = $row['TOTAL_TOTAL'];
                                      
                                        $avg_total = $row['AVG_MARK'];
                                    }

                                    // Move to the next line

                                    //  $pdf->Cell(25, 8, $totalhrs, 1, 1, 'C');
                                    //   $pdf->Cell(25, 8, $total_cass, 1, 1, 'C');
                                    //  $pdf->Cell(25, 8, $total_exam, 1, 1, 'C');
                                    //  $pdf->Cell(25, 8, $total_total, 1, 1, 'C');
                                    //     $pdf->Cell(25, 8, 'Mean Score', 1, 1, 'C');
                                }
                                //     $pdf->Ln();

                                // Calculate and print "Total" information
                                //  $totalhrs = /* Calculate total hours based on your logic 
                                $pdf->Cell(50, 8, 'Total', 1, 0, 'C');
                                $pdf->Cell(20, 8, $total_cass, 1, 0, 'C');
                                $pdf->Cell(25, 8, $total_exam, 1, 0, 'C');
                                $pdf->Cell(25, 8, ' ', 1, 0, 'C');
                                $pdf->Cell(20, 8, ' ', 1, 0, 'C');
                                $pdf->Cell(25, 8, ' ', 1, 0, 'C');
                               
                                $pdf->Ln();
                                $pdf->Cell(50, 8, 'Mean Score', 1, 0, 'C');
                                $pdf->Cell(20, 8, $avg_cass, 1, 0, 'C');
                                $pdf->Cell(25, 8, $avg_exam, 1, 0, 'C');
                                $pdf->Cell(25, 8, $avg_total, 1, 0, 'C');
                                $pdf->Cell(20, 8, ' ', 1, 0, 'C');
                                $pdf->Cell(25, 8, ' ', 1, 0, 'C');
                              
                                $sql = "SELECT B.AVERAGE,ROWNUM AS POS FROM STUDENT A JOIN STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE A.STUD_ID = trim('$st') AND B.ACADEMIC_YEAR ='$a_y' and B.term = '$t' AND B.CLASS_CODE = $sub_code ORDER BY B.AVERAGE";
                                //     echo $sql;
                                $stmt = oci_parse($conn, $sql);
                                oci_execute($stmt);
                                while ($row = oci_fetch_array($stmt)) {
                                    $gpa = $row['AVERAGE'];
                                    //   $pos = $row['POS'];
                                }

                                $sql = "SELECT B.AVERAGE, COUNT(B.AVERAGE) AS TOTALSTU FROM STUDENT A JOIN STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE A.STUD_ID = trim('$st') AND B.ACADEMIC_YEAR ='$a_y' and B.term = '$t' AND B.class_code = $sub_code  GROUP BY B.AVERAGE 
                                ORDER BY B.AVERAGE";
                                //   echo $sql;
                                $stmt = oci_parse($conn, $sql);
                                oci_execute($stmt);
                                while ($row = oci_fetch_array($stmt)) {

                                    $gpa = $row['AVERAGE'];
                                }

                                $sql = "SELECT COUNT(B.AVERAGE) AS TOTALSTU FROM STUDENT A JOIN STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE  B.ACADEMIC_YEAR ='$a_y' and B.term = '$t' AND B.class_code = $sub_code  GROUP BY B.AVERAGE   ";
                                //   echo $sql;
                                $stmt = oci_parse($conn, $sql);
                                oci_execute($stmt);
                                while ($row = oci_fetch_array($stmt)) {
                                    $totalstu = $row['TOTALSTU'];
                                }

                                //  $sql = "SELECT COUNT(B.GPA) AS COUNT FROM STUDENT A JOIN STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE CLASS_CODE = $subcode";

                                $sql = "WITH Studentranks AS (
                                    SELECT
                                        Stud_id,
                                        ROW_NUMBER() OVER (ORDER BY gpa DESC) AS ClassPosition
                                    FROM
                                        student_standings
                                    WHERE
                                        academic_year = '$a_y'
                                        AND Term = '$t' AND CLASS_CODE = $subcode ORDER BY GPA
                                )
                                SELECT
                                    ClassPosition
                                FROM
                                    Studentranks
                                WHERE
                                    Stud_ID = trim('$st') ";
                                //   echo $sql;
                                $stmt =  oci_parse($conn, $sql);
                                oci_execute($stmt);
                                while ($rw = oci_fetch_array($stmt)) {
                                    $posi =  $rw["CLASSPOSITION"];
                                }


                                $getcpa = "SELECT ROUND(AVG(AVERAGE),2) AS CGPA  FROM STUDENT A JOIN STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE A.STUD_ID = '$st'";
                                $sql = oci_parse($conn, $getcpa);
                                oci_execute($sql);
                                while ($r = oci_fetch_array($sql)) {
                                    $cgpa = $r['CGPA'] / 1.00;
                                }
                            }
                            $pdf->SetY($pdf->GetY() + 5);
                            $pdf->SetFont('dejavusans', 'B', 8);
                            // Set the Y-coordinate below the table for the total
                            $pdf->SetY($pdf->GetY() + 5); // You may need to adjust the value based on your layout
                            $sql = "SELECT *  FROM STUDENT A JOIN STUDENT_CUMULATIVE B ON (A.STUD_ID=B.STUD_ID) WHERE A.STUD_ID = trim('$st') AND B.ACADEMIC_YEAR ='$a_y' and B.term = '$t' AND B.SUB_CODE = $sub_code ";
                            //     echo $sql;
                            $stmt = oci_parse($conn, $sql);
                            oci_execute($stmt);
                            $cnt = oci_fetch_all($stmt, $b);

                           if ($cnt < 8) {
                                $pdf->Ln();
                                $principalComments = "Class Teacher Comments:....INCOMPLETE..MARKS...........";
                            } else  {
                               
                                    $sql = "SELECT B.AVERAGE,COUNT(B.AVERAGE) AS COUNT FROM STUDENT A JOIN STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE A.STUD_ID = '$st' and B.term = '$t'  GROUP BY B.AVERAGE ORDER BY B.AVERAGE";
                                      echo $sql;
                                    $stmt = oci_parse($conn, $sql);
                                    oci_execute($stmt);
                                    $pdf->Ln();
                                    while ($row = oci_fetch_array($stmt)) {
                                        $rowcount = $row['COUNT'];
                                        $gpa = $row['AVERAGE'] / 1.00;
                                        $getin = oci_parse($conn,"SELECT * FROM GRADE A JOIN GRADE_SETTING B ON (A.G_CODE=B.G_CODE)  WHERE B.START_GRADE_RANGE <= CAST($gpa AS INT) AND CAST($gpa AS INT) <= B.END_GRADE_RANGE  ");
                                        oci_execute($getin);
                                        while($r=oci_fetch_array($getin)){
                                            $int= $r['INTERPRETATION'];
                                        }
                                        //  $cgpa = $gpa / $rowcount;
                                        $pdf->SetY($pdf->GetY() + 5);

                                        $pdf->SetFont('times', 'B', 9);
                                        $pdf->SetX(130);
                                        $pdf->Cell(40, 10, 'CLASS POSITION: ', 0, 0, 'C');
                                        $pdf->Cell(30, 10, $posi . " OUT OF " . $totalstu, 0, 1, 'C'); // Adjust font size for GPA
                                        $pdf->SetX(130);
                                        $pdf->Cell(40, 10, 'GPA:', 0, 0, 'C');
                                        $pdf->Cell(30, 10, $gpa . "/100", 0, 1, 'C');
                                        $pdf->SetX(130);
                                        $pdf->Cell(40, 10, 'CGPA:', 0, 0, 'C');
                                        $pdf->Cell(30, 10, $cgpa . "/100", 0, 1, 'C');
                                        $principalComments = "Class Teacher Comments:....$int...........";
                                    }
                            }

                            $pdf->SetY($pdf->GetY() - 8);
                            // Add a line break before the comments
                            $pdf->Cell(0, 10, $principalComments, 0, 1, 'L');
                            $principalComment = "Class Teacher Signature:....................................                                    Principal Signature:........................................";
                            // Add a line break before the comments
                            $pdf->Cell(0, 10, $principalComment, 0, 1, 'L');

                            //  $pdf->SetX(130);
                            //  $principalComments = "Principal Signature:...................";
                            //  $pdf->Cell(5, 0, $principalComments, 0, 1, 'L');

                            $principalComment = "School Stamp";
                            $pdf->Cell(0, 10, $principalComment, 0, 1, 'L');
                            $pdf->SetY(265);  // Adjust this value based on your page size and margin

                            $pdf->SetFont('dejavusans', 'B', 9);
                            $disclaimer1 = "The Document Is Only Valid With The Principal Official Stamp";

                            $pdf->SetFont('dejavusans', 'B', 6);
                            $disclaimer2 = "This Student Report Is Designed And Generated By NIFTY ICT SOLUTIONS";

                            $pdf->Cell(0, 5, $disclaimer1, 0, 1, 'C'); // Move to the next line after printing disclaimer1
                            $pdf->Cell(0, 5, $disclaimer2, 0, 1, 'C'); // Move to the next line after printing disclaimer2


                            $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\student_term_report\\' . $class_name . '\\';
                            if (!is_dir($directoryPath)) {
                                if (!mkdir($directoryPath, 0777, true)) {
                                    die('Failed to create directories.');
                                }
                            }
                            $filePath = $directoryPath . '\\' . $name . '.pdf';
                            $pdf->Output($filePath, 'F');
                            $pdf->Output($filePath, 'F');
                        }

                        // 'F' parameter saves to a file
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php echo "STUDENT REPORT GENERATED";
                          //  header("refresh:2");
                            $_SESSION['school'] = $school;
                            $_SESSION['class_name'] = $class_name;
                            $_SESSION['path']=$filePath;
         //   echo $filePath;
                            $_SESSION['name']=$name;
                      header('Location:download.php');
                    } else {
                        ?><div style="font-size:15px;
        color: red;
        position: relative;
         display:flex;
        animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT TERM";header("refresh:2;"); ?>
                </div> <?php
                    }
                }?>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>