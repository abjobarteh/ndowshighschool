<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$user = $_SESSION['user'];
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
?>

<body>
    <form class="container" enctype="multipart/form-data" action="arrears.php" method="post" style="width: 1500px;">
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
        <header>Student Finance</header>
        <?php
        include 'connect.php';
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Student</option>
                <?php
                $get_hos = "select DISTINCT(STUD_ID),NAME from student where s_id = '$sid' and status != 'GRADUATED' order by name";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['STUD_ID'] ?>">
                        <?php echo trim($row["NAME"]) . " " . $row['STUD_ID']; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <select required name="classname">
                <option disabled selected>Select Class</option>
                <?php
                $get_hos = "SELECT DISTINCt(B.CLASS_NAME),A.SUB_CODE FROM CLASS_STUDENT A JOIN SUB_CLASS B ON (A.SUB_CODE=B.SUB_CODE) ORDER BY B.CLASS_NAME ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['SUB_CODE'] ?>">
                        <?php echo trim($row["CLASS_NAME"]); ?>
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
        <?php

        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                echo  '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';

                $stuid = $_POST['reg'];
            } else if (isset($_POST['classname'])) {
                echo  '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';

                $sub_cd = $_POST['classname'];
            } else {
                echo  '<script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "SELECT STUDENT",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
            }
        }
        ?>
        <?php
        include 'connect.php';
        /* $username = "IOB";
         $password = "Iobadmin";
         $connection = "127.0.0.1:1522/testserver";
         $conn = oci_connect($username, $password, $connection); */
        $conn = $con;

        if (isset($_POST['reg'])) {
            $sql = "SELECT A.INVOICE_NO,A.TERM,B.NAME,C.CLASS_NAME,A.DESCRIPTION,A.AMOUNT,A.BALANCE,A.BILLING_DT,A.USERNAME FROM STUDENT_BILLING A JOIN STUDENT B ON (A.STUD_ID=B.STUD_ID) JOIN SUB_CLASS C ON (A.CLASS_CODE=C.SUB_CODE) JOIN SCHOOL_USERS D ON (A.USERNAME=D.USERNAME) WHERE A.BALANCE >0  AND A.STUD_ID = $stuid ORDER BY B.NAME";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
        } else if (isset($_POST['classname'])) {
            $sql = "SELECT A.INVOICE_NO,A.TERM,B.NAME,C.CLASS_NAME,A.DESCRIPTION,A.AMOUNT,A.BALANCE,A.BILLING_DT,A.USERNAME FROM STUDENT_BILLING A JOIN STUDENT B ON (A.STUD_ID=B.STUD_ID) JOIN SUB_CLASS C ON (A.CLASS_CODE=C.SUB_CODE) JOIN SCHOOL_USERS D ON (A.USERNAME=D.USERNAME) WHERE A.BALANCE >0  AND A.CLASS_CODE = $sub_cd ORDER BY B.NAME";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
        } else {
            $sql = "SELECT A.INVOICE_NO,A.TERM,B.NAME,C.CLASS_NAME,A.DESCRIPTION,A.AMOUNT,A.BALANCE,A.BILLING_DT,A.USERNAME FROM STUDENT_BILLING A JOIN STUDENT B ON (A.STUD_ID=B.STUD_ID) JOIN SUB_CLASS C ON (A.CLASS_CODE=C.SUB_CODE) JOIN SCHOOL_USERS D ON (A.USERNAME=D.USERNAME) WHERE A.BALANCE >0 ORDER BY B.NAME";
            //     echo $sql;
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
        }
        ?>

        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Student Arrears</Label>
        </div>

        <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #909290; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student ID</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Term</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Description</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Amount</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Balance</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Billing Date</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Billed By</th>
                    </tr>
                </thead>
            </table>
            <div style="max-height: 200px; overflow-y: auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                    <tbody>
                        <?php
                        while ($row = oci_fetch_array($stid)) {
                        ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['STUD_ID']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['TERM']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['DESCRIPTION']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['AMOUNT']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['BALANCE']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['BILLING_DT']; ?></td>
                                <td style="padding: 5px 8px; font-size: 13px; margin: 5px;"><?php echo $row['USERNAME']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


            <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Report Type</label>
                <select required name="type">
                    <option disabled selected>Select Report Type</option>
                    <option>PDF</option>
                    <option>EXCEL</option>
                </select>
            </div>
            <select required name="class_name">
                <option disabled selected>Select Class</option>
                <?php
                $get_hos = "SELECT DISTINCt(B.CLASS_NAME),A.SUB_CODE FROM CLASS_STUDENT A JOIN SUB_CLASS B ON (A.SUB_CODE=B.SUB_CODE) ORDER BY B.CLASS_NAME ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['SUB_CODE'] ?>">
                        <?php echo trim($row["CLASS_NAME"]); ?>
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
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate_arrearlist" type="submit">
            GENERATE STUDENT ARREARS LIST
            <i class="uil uil-file-export"></i>
        </button>
 
        <?php

        require('tcpdf/tcpdf.php');
        require '../vendor/autoload.php';

        require 'D:\Junior\Registra\PHPMailer.php';
        require 'D:\Junior\Registra\Exception.php';
        require 'D:\Junior\Registra\SMTP.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generate_arrearlist'])) {
            if (isset($_POST['type'])) {
                if(isset($_POST['class_name'])){
                    $sub_cd = $_POST['class_name'];
                    $type = $_POST['type'];
                    if ($type == 'EXCEL') {
    
                        $query = "SELECT A.INVOICE_NO,A.TERM,B.NAME,C.CLASS_NAME,A.DESCRIPTION,A.AMOUNT,A.BALANCE,A.BILLING_DT,A.USERNAME FROM STUDENT_BILLING A JOIN STUDENT B ON (A.STUD_ID=B.STUD_ID) JOIN SUB_CLASS C ON (A.CLASS_CODE=C.SUB_CODE) JOIN SCHOOL_USERS D ON (A.USERNAME=D.USERNAME) WHERE A.BALANCE >0  AND A.CLASS_CODE = $sub_cd ORDER BY B.NAME";
    
                        // Prepare and execute the query
                        $statement = oci_parse($conn, $query);
                        oci_execute($statement);
    
                        // Create a new Spreadsheet object
                        $spreadsheet = new Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();
    
                        // Set headers for the Excel file
                        $sheet->setCellValue('A1', 'INVOICE NO');
                        $sheet->setCellValue('B1', 'TERM');
                        $sheet->setCellValue('C1', 'STUDENT');
                        $sheet->setCellValue('D1', 'CLASS');
                        $sheet->setCellValue('E1', 'DESCRIPTION');
                        $sheet->setCellValue('F1', 'AMOUNT');
                        $sheet->setCellValue('G1', 'BALANCE');
                        $sheet->setCellValue('H1', 'BILLING DATE');
                        $sheet->setCellValue('I1', 'BILLING BY');
    
                        // Create the directory if it doesn't exist
                        $directory = 'C:\ACADEMIX\\' . $school . '\generated_reports\payments\\';
                        if (!is_dir($directory)) {
                            if (!mkdir($directory, 0777, true)) {
                                die('Failed to create directories.');
                            }
                        }
    
                        // Define the output file path
                        $outputFilePath = $directory . 'ARREARS.xlsx';
    
                        // Write data to the Excel file
                        $row = 2;
                        while ($row_data = oci_fetch_assoc($statement)) {
                            $sheet->setCellValue('A' . $row, $row_data['INVOICE_NO']);
                            $sheet->setCellValue('B' . $row, $row_data['TERM']);
                            $sheet->setCellValue('C' . $row, $row_data['NAME']);
                            $sheet->setCellValue('D' . $row, $row_data['CLASS_NAME']);
                            $sheet->setCellValue('E' . $row, $row_data['DESCRIPTION']);
                            $sheet->setCellValue('F' . $row, $row_data['AMOUNT']);
                            $sheet->setCellValue('G' . $row, $row_data['BALANCE']);
                            $sheet->setCellValue('H' . $row, $row_data['BILLING_DT']);
                            $sheet->setCellValue('I' . $row, $row_data['USERNAME']);
                            $row++;
                        }
    
                        // Save the Excel file
                        $writer = new Xlsx($spreadsheet);
                        $writer->save($outputFilePath);
    
                        // Set session variables
                        $_SESSION['path'] = $outputFilePath;
                        $_SESSION['filename'] = 'ARREARS.xlsx';
                        $_SESSION['redirect'] = 'student_pay.php';
    
                        // Redirect to download_excel.php
                        header("Location: download_excel.php");
                        header("refresh:2;"); ?>
                        </div> <?php
                                oci_free_statement($statement);
                                oci_close($conn);
                            } else if ($type == 'PDF') {
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
                                    $saveDirectory = 'C:/wamp64/www/Academix/Registra/img/';
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
                                $pdf->Cell(10, 60, 'STUDENT ARREAS LIST', 0, 1, 'L');
    
                                $pdf->Ln();
                                $logoPath  = 'img/school logo.png';
                                $pdf->Image($logoPath, 10, 15, 30, 20);
                                //            $pdf->Image($logoPath, 170, 15, 30, 35);
                                $pdf->SetTextColor(29, 91, 121);
                                $pdf->SetXY(60, 10);
                                $pdf->SetFont('helvetica', 'B', 12);
                                $pdf->Cell(0, 5, $school, 0, 1);
                                $companyInfo = "$address\n$district\nREGION\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                                $pdf->SetFont('dejavusans', 'B', 8); // Adjust font size for school information
                                $pdf->SetXY(130, 20);
                                $pdf->MultiCell(0, 5, $companyInfo, 0, 'R');
    
                                $pdf->SetY($pdf->GetY() + 5);
                                $pdf->SetFont('dejavusans', '', 7); // Adjust the Y position to leave space for the title
                                $pdf->Cell(10, 10, 'Date:  ', 0, 0);
                                $pdf->Cell(0, 10, date('d/m/Y'), 0, 1);
                                //   $pdf->SetX(170);
                                $pdf->SetFont('times', '', 8);
                                // ... Your previous code for setting up the PDF
    
                                // ... Your previous code for setting up the PDF
    
                                // Add Items and Prices
                                // ... Your previous code for setting up the PDF
    
                                $query = "SELECT A.INVOICE_NO,A.TERM,B.NAME,C.CLASS_NAME,A.DESCRIPTION,A.AMOUNT,A.BALANCE,A.BILLING_DT,A.USERNAME FROM STUDENT_BILLING A JOIN STUDENT B ON (A.STUD_ID=B.STUD_ID) JOIN SUB_CLASS C ON (A.CLASS_CODE=C.SUB_CODE) JOIN SCHOOL_USERS D ON (A.USERNAME=D.USERNAME) WHERE A.BALANCE >0  AND A.CLASS_CODE = $sub_cd ORDER BY B.NAME";;
                                // echo $query;
                                $stmt = oci_parse($conn, $query);
                                oci_execute($stmt);
                                // Set headers and font
                                // Set headers and font
                                $pdf->SetFont('courier', 'B', 7);
                                //  $pdf->SetFont('courier', 'B', 8);
                                $pdf->Cell(17, 10, 'INVOICE NO', 1, 0, 'C');
                                $pdf->Cell(100, 10, 'DESCRIPTION', 1, 0, 'C');
                                $pdf->Cell(25, 10, 'NAME', 1, 0, 'C');
                                $pdf->Cell(25, 10, 'CLASS', 1, 0, 'C');
                                $pdf->Cell(15, 10, 'AMOUNT', 1, 0, 'C');
                                $pdf->Cell(15, 10, 'BALANCE', 1, 0, 'C');
                            
                               
                                $pdf->Ln();
                                // Table content
                                $pdf->SetFont('courier', '', 6);
                                while ($row = oci_fetch_assoc($stmt)) {
                                    $name = $row['NAME'];
                                    $id = $row['STUD_ID'];
                                    $class = $row['CLASS_NAME'];
                                   
                                    $t = $row['TERM'];
                                    $des = $row['DESCRIPTION'];
                                    $amt = $row['AMOUNT'];
                                    $bal = $row['BALANCE'];
                                    //  $pdf->SetColor(255, 255, 255);
                                    $pdf->Cell(17, 10,$row['INVOICE_NO'], 1, 0, 'C');
                                    $pdf->Cell(100, 10, $row['DESCRIPTION'], 1, 0, 'C');
                                    $pdf->Cell(25, 10, $row['NAME'], 1, 0, 'C');
                                    $pdf->Cell(25, 10, $row['CLASS_NAME'], 1, 0, 'C');
                                    $pdf->Cell(15, 10, $row['AMOUNT'], 1, 0, 'C');
                                    $pdf->Cell(15, 10, $row['BALANCE'], 1, 1, 'C');
                                  //  $pdf->Cell(55, 10, $row['DESCRIPTION'], 1, 0, 'C');
                                }
    
                                // Add the disclaimer text
                                $pdf->SetY(5); // Set the Y-coordinate to the bottom of the page
    
                                // Add the disclaimer text
                                $pdf->SetFont('dejavusans', 'B', 6);
                                $disclaimer = "This Student Report Is Designed And Generated By NIFTY ICT SOLUTIONS";
    
                                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\payments\\';
                                if (!is_dir($directoryPath)) {
                                    if (!mkdir($directoryPath, 0777, true)) {
                                        die('Failed to create directories.');
                                    }
                                }
                                $name = 'ARREARS';
                                $filePath = $directoryPath . '\\' . 'ARREARS.pdf';
                                $pdf->Output($filePath, 'F');
    
                                // Set session variables
                                $_SESSION['path'] =  $filePath;
                                $_SESSION['filename'] = 'ARREARS.pdf';
                                $_SESSION['redirect'] = 'student_billing.php';
                                header("Location: download_pdfs.php");
                            }
                        } else {
                            echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "SELECT REPORT TYPE",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                            header("refresh:2;");
                        }
                    }
    
                   
                }

                                ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="finance.php">
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
<?php
function isPDF($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['pdf'])) {
        return true;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (in_array($mimetype, ['application/pdf'])) {
        return true;
    } else {
        return false;
    }
}




function isjpeg_png($file)
{
    $type = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
    $detect = exif_imagetype($file);
    if (in_array($detect, $type)) {
        return true;
    } else {
        return false;
    }
}

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>