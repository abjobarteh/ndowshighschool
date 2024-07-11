<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showsss.css">
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
include('auto_logout.php');
?>
<?php
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$sub_cd =  $_SESSION['s_code'];
$a_y = $_SESSION['year'];
$user = $_SESSION['username'];
?>
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
    <form class="container" enctype="multipart/form-data" action="edit_student.php" method="post">
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
        <header>Student Management</header>
        </div>
        <?php
        include 'connect.php';
        $region = " ";
        $stuid = 'stuid';
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Student</option>
                <?php
                $get_hos = "select * from student a join CLASS_STUDENT b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                        <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
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

        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="remove_student" type="submit">
            REMOVE STUDENT
            <i class="uil uil-trash-alt"></i>
        </button>

        <div>
            <?php
            $stmt = oci_parse($conn, "select * from student_document where stud_id = '$stuid' ");
            oci_execute($stmt);

            while ($rowS = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                // Check if $rowS['PASS_PHOTO'] is not null before calling load()
                if (!empty($rowS['PASS_PHOTO'])) {
                    $imageData = $rowS['PASS_PHOTO']->load(); // Load OCILob data

                    // Encode the image data as base64
                    $base64Image = base64_encode($imageData);

                    // Display the image
                    echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">';
                } else {
                    // Handle the case where $rowS['PASS_PHOTO'] is null or empty
                    //echo 'No image available';
                }
            }
            ?>
        </div>
        <?php
        $rcode = 0;
        if (isset($_POST['filter'])) {
            echo '<script>
            Swal.fire({
                position: "center",
                icon: "info",
                title: "FILTERING STUDENT INFORMATION",
                showConfirmButton: false,
                timer: 1500
              });
            </script>';
            if (isset($_POST['reg'])) {

                $st = trim($_POST['reg']);
                $stuid = trim($_POST['reg']);
                $_SESSION['STID'] = $stuid;
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                    <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT STUDENT",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                    header("refresh:2;");
                    ?></div><?php
                        }
                    }

                    if (isset($_POST['remove_student'])) {
                        if (isset($_POST['reg'])) {
                            $st = trim($_POST['reg']);
                            $stuid = trim($_POST['reg']);
                            $stud_id = $stuid;
                            $_SESSION['STID'] = $stuid;
                            //    echo $stud_id;
                            $sql = oci_parse($conn, "DELETE FROM CLASS_STUDENT WHERE STUD_ID ='$stuid' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_MEDICAL WHERE STUD_ID ='$stuid' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_ACADEMIC WHERE STUD_ID ='$stuid' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_AUTHOURITY WHERE STUD_ID ='$stuid' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_CONTACT WHERE STUD_ID ='$stuid' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_PERSONAL WHERE STUD_ID ='$stuid' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_DOCUMENT WHERE STUD_ID ='$stud_id' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_PERSONAL WHERE STUD_ID ='$stud_id' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_EVALUATION WHERE STUD_ID ='$stud_id' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_FINANCE WHERE STUD_ID ='$stud_id' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT_SUBJECT WHERE STUD_ID ='$stud_id' ");
                            oci_execute($sql);

                            $sql = oci_parse($conn, "DELETE FROM STUDENT WHERE STUD_ID ='$stud_id' ");
                            oci_execute($sql);
                            echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "sucess",
                                title: "STUDENT RECORDS REMOVED SUCCESSFULLY",
                                showConfirmButton: false,
                                timer: 1500
                              });
                            </script>';
                        } else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                    <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT STUDENT",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                            header("refresh:2;");
                    ?></div><?php
                        }

                            ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                <?php echo "STUDENT REMOVED";
                        header("refresh:2;");
                ?></div><?php
                    }

                        ?>
        <div>
            <?php
            $stmt = oci_parse($conn, "select * from student_document where stud_id = '$stuid' ");
            oci_execute($stmt);

            while ($rowS = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                // Check if $rowS['PASS_PHOTO'] is not null before calling load()
                if (!empty($rowS['PASS_PHOTO'])) {
                    $imageData = $rowS['PASS_PHOTO']->load(); // Load OCILob data

                    // Encode the image data as base64
                    $base64Image = base64_encode($imageData);

                    // Display the image
                    echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">';
                } else {
                    // Handle the case where $rowS['PASS_PHOTO'] is null or empty
                    //echo 'No image available';
                }
            }
            ?>
        </div>
        <?php

        include 'connect.php';

        if ($conn) {
            ob_start();
            $sql = "select * from student where stud_id = '$stuid' ";

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
                        Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Status</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['STATUS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CREATE_DT']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div style="display:flex; margin-top:20px;">

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_stu" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>STATUS</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student ID</label>
                <select required name="id_stu">
                    <option disabled selected>Select Student</option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Status</label>
                <select name="stu_status" required>
                    <option disabled selected>Select Status</option>
                    <option>REGISTERED</option>
                    <option>ENROLLED</option>
                    <option>SUSPENDED</option>
                    <option>GRADUATED</option>
                    <option>TRANSFERED</option>
                </select>
            </div>
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
  text-decoration: none;" name="edit_student" type="submit">
                EDIT STUDENT STATUS
                <i class="uil uil-edit"></i>
            </button>

            <?php
            if (isset($_POST['edit_student'])) {
                if (isset($_POST['edit_stu'])) {
                    $field = $_POST['edit_stu'];
                    if (isset($_POST['id_stu'])) {
                        $name = trim($_POST['id_stu']);
                        $sql = oci_parse($conn, "SELECT * FROM student WHERE TRIM(BOTH ' ' FROM name) = :name");
                        oci_bind_by_name($sql, ':name', $name);
                        oci_execute($sql);
                        while ($row = oci_fetch_array($sql)) {
                            $stuid = $row["STUD_ID"];
                        }
                        $id = $stuid;
                        if ($field == 'STATUS') {
                            if (isset($_POST['stu_status'])) {
                                $status = $_POST['stu_status'];
                                $sql = oci_parse($conn, "update student set status = '$status' where stud_id = '$id' and s_id = $sid ");
                                oci_execute($sql);
                                $sql = oci_parse($conn, "select * from student where status = '$status' and  stud_id = '$id' and s_id = $sid  ");
                                oci_execute($sql);

                                if (oci_fetch_all($sql, $a) > 0) {
            ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "STATUS UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING STATUS";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT STATUS";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }
                                ?>
        </div>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_personal where stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
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
         font-weight: bold; color: #909290;">Personal Information</Label>
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
                        Firstname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Middlename</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Lastname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Date Of Birth</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Gender</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Tribe</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Nationality</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DOB']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['GENDER']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['TRIBE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NATION']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div style="display:flex; margin-top:20px;">

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_per" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>FIRSTNAME</option>
                    <option>MIDDLENAME</option>
                    <option>LASTNAME</option>
                    <option>DATE OF BIRTH</option>
                    <option>GENDER</option>
                    <option>NATIONALITY</option>
                    <option>TRIBE</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student</label>
                <select required name="id_per">
                    <option disabled selected>Select Student </option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Firstname</label>
                <input type="text" placeholder="Enter Firstname" title="Only Letters" pattern="[A-z ]+" name="stu_first">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Letters" pattern="[A-z ]+" name="stu_middle">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Lastname</label>
                <input type="text" placeholder="Enter Lastname" title="Only Letters" pattern="[A-z0-9]+" name="stu_last">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Date Of Birth</label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" pattern="[A-z]+" name="stu_dob" max="<?php echo date('Y-m-d'); ?>" title="SELECTED DATE NOT ALLOWED">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Gender</label>
                <select name="stu_gender">
                    <option disabled selected>Select Gender</option>
                    <option>MALE</option>
                    <option>FEMALE</option>
                    <option>OTHER</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label>Nationality</label>
                <select name="stu_nation">
                    <option disabled selected>Select Nationality</option>
                    <option value="afghan">Afghan</option>
                    <option value="albanian">Albanian</option>
                    <option value="algerian">Algerian</option>
                    <option value="american">American</option>
                    <option value="andorran">Andorran</option>
                    <option value="angolan">Angolan</option>
                    <option value="antiguans">Antiguans</option>
                    <option value="argentinean">Argentinean</option>
                    <option value="armenian">Armenian</option>
                    <option value="australian">Australian</option>
                    <option value="austrian">Austrian</option>
                    <option value="azerbaijani">Azerbaijani</option>
                    <option value="bahamian">Bahamian</option>
                    <option value="bahraini">Bahraini</option>
                    <option value="bangladeshi">Bangladeshi</option>
                    <option value="barbadian">Barbadian</option>
                    <option value="barbudans">Barbudans</option>
                    <option value="batswana">Batswana</option>
                    <option value="belarusian">Belarusian</option>
                    <option value="belgian">Belgian</option>
                    <option value="belizean">Belizean</option>
                    <option value="beninese">Beninese</option>
                    <option value="bhutanese">Bhutanese</option>
                    <option value="bolivian">Bolivian</option>
                    <option value="bosnian">Bosnian</option>
                    <option value="brazilian">Brazilian</option>
                    <option value="british">British</option>
                    <option value="bruneian">Bruneian</option>
                    <option value="bulgarian">Bulgarian</option>
                    <option value="burkinabe">Burkinabe</option>
                    <option value="burmese">Burmese</option>
                    <option value="burundian">Burundian</option>
                    <option value="cambodian">Cambodian</option>
                    <option value="cameroonian">Cameroonian</option>
                    <option value="canadian">Canadian</option>
                    <option value="cape verdean">Cape Verdean</option>
                    <option value="central african">Central African</option>
                    <option value="chadian">Chadian</option>
                    <option value="chilean">Chilean</option>
                    <option value="chinese">Chinese</option>
                    <option value="colombian">Colombian</option>
                    <option value="comoran">Comoran</option>
                    <option value="congolese">Congolese</option>
                    <option value="costa rican">Costa Rican</option>
                    <option value="croatian">Croatian</option>
                    <option value="cuban">Cuban</option>
                    <option value="cypriot">Cypriot</option>
                    <option value="czech">Czech</option>
                    <option value="danish">Danish</option>
                    <option value="djibouti">Djibouti</option>
                    <option value="dominican">Dominican</option>
                    <option value="dutch">Dutch</option>
                    <option value="east timorese">East Timorese</option>
                    <option value="ecuadorean">Ecuadorean</option>
                    <option value="egyptian">Egyptian</option>
                    <option value="emirian">Emirian</option>
                    <option value="equatorial guinean">Equatorial Guinean</option>
                    <option value="eritrean">Eritrean</option>
                    <option value="estonian">Estonian</option>
                    <option value="ethiopian">Ethiopian</option>
                    <option value="fijian">Fijian</option>
                    <option value="filipino">Filipino</option>
                    <option value="finnish">Finnish</option>
                    <option value="french">French</option>
                    <option value="gabonese">Gabonese</option>
                    <option value="gambian">Gambian</option>
                    <option value="georgian">Georgian</option>
                    <option value="german">German</option>
                    <option value="ghanaian">Ghanaian</option>
                    <option value="greek">Greek</option>
                    <option value="grenadian">Grenadian</option>
                    <option value="guatemalan">Guatemalan</option>
                    <option value="guinea-bissauan">Guinea-Bissauan</option>
                    <option value="guinean">Guinean</option>
                    <option value="guyanese">Guyanese</option>
                    <option value="haitian">Haitian</option>
                    <option value="herzegovinian">Herzegovinian</option>
                    <option value="honduran">Honduran</option>
                    <option value="hungarian">Hungarian</option>
                    <option value="icelander">Icelander</option>
                    <option value="indian">Indian</option>
                    <option value="indonesian">Indonesian</option>
                    <option value="iranian">Iranian</option>
                    <option value="iraqi">Iraqi</option>
                    <option value="irish">Irish</option>
                    <option value="israeli">Israeli</option>
                    <option value="italian">Italian</option>
                    <option value="ivorian">Ivorian</option>
                    <option value="jamaican">Jamaican</option>
                    <option value="japanese">Japanese</option>
                    <option value="jordanian">Jordanian</option>
                    <option value="kazakhstani">Kazakhstani</option>
                    <option value="kenyan">Kenyan</option>
                    <option value="kittian and nevisian">Kittian and Nevisian</option>
                    <option value="kuwaiti">Kuwaiti</option>
                    <option value="kyrgyz">Kyrgyz</option>
                    <option value="laotian">Laotian</option>
                    <option value="latvian">Latvian</option>
                    <option value="lebanese">Lebanese</option>
                    <option value="liberian">Liberian</option>
                    <option value="libyan">Libyan</option>
                    <option value="liechtensteiner">Liechtensteiner</option>
                    <option value="lithuanian">Lithuanian</option>
                    <option value="luxembourger">Luxembourger</option>
                    <option value="macedonian">Macedonian</option>
                    <option value="malagasy">Malagasy</option>
                    <option value="malawian">Malawian</option>
                    <option value="malaysian">Malaysian</option>
                    <option value="maldivan">Maldivan</option>
                    <option value="malian">Malian</option>
                    <option value="maltese">Maltese</option>
                    <option value="marshallese">Marshallese</option>
                    <option value="mauritanian">Mauritanian</option>
                    <option value="mauritian">Mauritian</option>
                    <option value="mexican">Mexican</option>
                    <option value="micronesian">Micronesian</option>
                    <option value="moldovan">Moldovan</option>
                    <option value="monacan">Monacan</option>
                    <option value="mongolian">Mongolian</option>
                    <option value="moroccan">Moroccan</option>
                    <option value="mosotho">Mosotho</option>
                    <option value="motswana">Motswana</option>
                    <option value="mozambican">Mozambican</option>
                    <option value="namibian">Namibian</option>
                    <option value="nauruan">Nauruan</option>
                    <option value="nepalese">Nepalese</option>
                    <option value="new zealander">New Zealander</option>
                    <option value="ni-vanuatu">Ni-Vanuatu</option>
                    <option value="nicaraguan">Nicaraguan</option>
                    <option value="nigerien">Nigerien</option>
                    <option value="north korean">North Korean</option>
                    <option value="northern irish">Northern Irish</option>
                    <option value="norwegian">Norwegian</option>
                    <option value="omani">Omani</option>
                    <option value="pakistani">Pakistani</option>
                    <option value="palauan">Palauan</option>
                    <option value="panamanian">Panamanian</option>
                    <option value="papua new guinean">Papua New Guinean</option>
                    <option value="paraguayan">Paraguayan</option>
                    <option value="peruvian">Peruvian</option>
                    <option value="polish">Polish</option>
                    <option value="portuguese">Portuguese</option>
                    <option value="qatari">Qatari</option>
                    <option value="romanian">Romanian</option>
                    <option value="russian">Russian</option>
                    <option value="rwandan">Rwandan</option>
                    <option value="saint lucian">Saint Lucian</option>
                    <option value="salvadoran">Salvadoran</option>
                    <option value="samoan">Samoan</option>
                    <option value="san marinese">San Marinese</option>
                    <option value="sao tomean">Sao Tomean</option>
                    <option value="saudi">Saudi</option>
                    <option value="scottish">Scottish</option>
                    <option value="senegalese">Senegalese</option>
                    <option value="serbian">Serbian</option>
                    <option value="seychellois">Seychellois</option>
                    <option value="sierra leonean">Sierra Leonean</option>
                    <option value="singaporean">Singaporean</option>
                    <option value="slovakian">Slovakian</option>
                    <option value="slovenian">Slovenian</option>
                    <option value="solomon islander">Solomon Islander</option>
                    <option value="somali">Somali</option>
                    <option value="south african">South African</option>
                    <option value="south korean">South Korean</option>
                    <option value="spanish">Spanish</option>
                    <option value="sri lankan">Sri Lankan</option>
                    <option value="sudanese">Sudanese</option>
                    <option value="surinamer">Surinamer</option>
                    <option value="swazi">Swazi</option>
                    <option value="swedish">Swedish</option>
                    <option value="swiss">Swiss</option>
                    <option value="syrian">Syrian</option>
                    <option value="taiwanese">Taiwanese</option>
                    <option value="tajik">Tajik</option>
                    <option value="tanzanian">Tanzanian</option>
                    <option value="thai">Thai</option>
                    <option value="togolese">Togolese</option>
                    <option value="tongan">Tongan</option>
                    <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                    <option value="tunisian">Tunisian</option>
                    <option value="turkish">Turkish</option>
                    <option value="tuvaluan">Tuvaluan</option>
                    <option value="ugandan">Ugandan</option>
                    <option value="ukrainian">Ukrainian</option>
                    <option value="uruguayan">Uruguayan</option>
                    <option value="uzbekistani">Uzbekistani</option>
                    <option value="venezuelan">Venezuelan</option>
                    <option value="vietnamese">Vietnamese</option>
                    <option value="welsh">Welsh</option>
                    <option value="yemenite">Yemenite</option>
                    <option value="zambian">Zambian</option>
                    <option value="zimbabwean">Zimbabwean</option>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Tribe/Ethnicity</label>
                <select name="stu_tribe" required>
                    <option disabled selected>Select Tribe/Ethnicity</option>
                    <option>Mandinka</option>
                    <option>Wolof</option>
                    <option>Fula</option>
                    <option>Jola</option>
                    <option>Serer</option>
                    <option>Aku</option>
                    <option>Manjago</option>
                    <option>Bambara</option>
                </select>
            </div>

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
  text-decoration: none;" name="edit_personal" type="submit">
                EDIT PERSONAL INFORMATION
                <i class="uil uil-edit"></i>
            </button>

            <?php
            if (isset($_POST['edit_personal'])) {
                if (isset($_POST['edit_per'])) {
                    $field = $_POST['edit_per'];
                    if (isset($_POST['id_per'])) {
                        $stuid = trim($_POST['id_per']);

                        $id = $stuid;
                        $id = $stuid;
                        if ($field == 'FIRSTNAME') {
                            $first = strtoupper($_POST['stu_first']);
                            if ($first != '') {
                                $sql = oci_parse($conn, "select * from student_personal where stud_id='$id' and s_id = $sid ");
                                oci_execute($sql);
                                while ($r = oci_fetch_array($sql)) {
                                    $middle = $r['MIDDLENAME'];
                                    $last = $r['LASTNAME'];
                                }
                                $sql = oci_parse($conn, "update student_personal set firstname = '$first' where stud_id='$id' and s_id = $sid  ");
                                oci_execute($sql);

                                $name = strtoupper($first . " " . $middle . " " . $last);

                                $sqll = oci_parse($conn, "update student set name = '$name' where stud_id='$id' and s_id = $sid  ");
                                oci_execute($sqll);

                                if (oci_execute($sql) && oci_execute($sqll)) {
            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "FIRSTNAME UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php
                                                //  $error = oci_error($sql); // Get the Oracle error information for $sql
                                                //  echo "Error: " . $error['message']; // Display the error message to the user

                                                echo "ERROR UPDATING FIRSTNAME ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER FIRSTNAME";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'MIDDLENAME') {
                                        $middle = strtoupper($_POST['stu_middle']);
                                        if ($middle != '') {
                                            $sql = oci_parse($conn, "select * from student_personal where stud_id='$id' and s_id = $sid ");
                                            oci_execute($sql);
                                            while ($r = oci_fetch_array($sql)) {
                                                $first = $r['FIRSTNAME'];
                                                $last = $r['LASTNAME'];
                                            }
                                            $sql = oci_parse($conn, "update student_personal set middlename = '$middle' where stud_id='$id' and s_id = $sid  ");
                                            oci_execute($sql);

                                            $name = strtoupper($first . " " . $middle . " " . $last);

                                            $sqll = oci_parse($conn, "update student set name = '$name' where stud_id='$id' and s_id = $sid  ");
                                            oci_execute($sqll);

                                            if (oci_execute($sql) && oci_execute($sqll)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "MIDDLENAME UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php
                                                //  $error = oci_error($sql); // Get the Oracle error information for $sql
                                                //  echo "Error: " . $error['message']; // Display the error message to the user

                                                echo "ERROR UPDATING MIDDLENAME ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER MIDDLENAME";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'LASTNAME') {
                                        $last = strtoupper($_POST['stu_last']);
                                        if ($last != '') {
                                            $sql = oci_parse($conn, "select * from student_personal where stud_id='$id' and s_id = $sid ");
                                            oci_execute($sql);
                                            while ($r = oci_fetch_array($sql)) {
                                                $first = $r['FIRSTNAME'];
                                                $middle = $r['MIDDLENAME'];
                                            }
                                            $sql = oci_parse($conn, "update student_personal set LASTname = '$last' where stud_id='$id' and s_id = $sid  ");
                                            oci_execute($sql);

                                            $name = strtoupper($first . " " . $middle . " " . $last);

                                            $sqll = oci_parse($conn, "update student set name = '$name' where stud_id='$id' and s_id = $sid  ");
                                            oci_execute($sqll);

                                            if (oci_execute($sql) && oci_execute($sqll)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "LASTNAME UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php
                                                //  $error = oci_error($sql); // Get the Oracle error information for $sql
                                                //  echo "Error: " . $error['message']; // Display the error message to the user

                                                echo "ERROR UPDATING LASTNAME ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER MIDDLENAME";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'DATE OF BIRTH') {
                                        $dob = $_POST['stu_dob'];
                                        if ($dob != '') {
                                            $sql = oci_parse($conn, "update student_personal set DOB = '$dob' where stud_id='$id' and s_id = $sid  ");

                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "DATE OF BIRTH UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING DATE OF BIRTH";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT DATE OF BIRTH";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'GENDER') {

                                        if (isset($_POST['stu_gender'])) {
                                            $dob = $_POST['stu_gender'];
                                            $sql = oci_parse($conn, "update student_personal set GENDER = '$dob' where stud_id='$id' and s_id = $sid  ");

                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "GENDER UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING GENDER";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT GENDER";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'NATIONALITY') {

                                        if (isset($_POST['stu_nation'])) {
                                            $nation = strtoupper($_POST['stu_nation']);
                                            $sql = oci_parse($conn, "update student_personal set NATION = '$nation' where stud_id='$id' and s_id = $sid  ");

                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "NATIONALITY UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING NATIONALITY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT NATIONALITY";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'TRIBE') {

                                        if (isset($_POST['stu_tribe'])) {
                                            $nation = strtoupper($_POST['stu_tribe']);
                                            $sql = oci_parse($conn, "update student_personal set tribe = '$nation' where stud_id='$id' and s_id = $sid  ");

                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "TRIBE UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING TRIBE";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT TRIBE";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }
                                ?>
        </div>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_contact where stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
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
         font-weight: bold; color: #909290;">Contact Information</Label>
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
                        Home Address</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Phone Contact</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Emergency Contact</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['HOME_ADD']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PHONE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMERGENCY']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div style="display:flex; margin-top:20px;">
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_con" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>HOME ADDRESS</option>
                    <option>EMAIL ADDRESS</option>
                    <option>PHONE NUMBER</option>
                    <option>EMERGENCY CONTACT</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student</label>
                <select required name="id_con">
                    <option disabled selected>Select Student</option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Home Address</label>
                <input type="text" placeholder="Enter Home Address" title="Only Letters" pattern="[A-z0-9 ]+" name="stu_add">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Email Address</label>
                <input type="email" placeholder="Enter Email Address" name="stu_email">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Phone Number</label>
                <input type="number" placeholder="Enter Phone Number" title="Only Numbers" name="stu_phone" maxlength="7" title="ONLY 7 CHARACTERS ALLOWED">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Emergency Contact</label>
                <input type="number" placeholder="Enter Emergency Contact" title="Only Numbers" name="stu_eme" maxlength="7" title="ONLY 7 CHARACTERS ALLOWED">
            </div>

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
  text-decoration: none;" name="edit_contact" type="submit">
                EDIT CONTACT INFORMATION
                <i class="uil uil-edit"></i>
            </button>
            <?php
            if (isset($_POST['edit_contact'])) {
                if (isset($_POST['edit_con'])) {
                    $field = $_POST['edit_con'];
                    if (isset($_POST['id_con'])) {
                        $stuid = trim($_POST['id_con']);

                        $id = $stuid;
                        if ($field == 'HOME ADDRESS') {
                            $stu_add = $_POST['stu_add'];
                            if ($stu_add != '') {
                                $stu_add = strtoupper($stu_add);
                                $sql = oci_parse($conn, "update student_contact set home_add = '$stu_add' where stud_id = '$id' and s_id = $sid ");
                                if (oci_execute($sql)) {
            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "HOME ADDRESS UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING HOME ADDRESS";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER HOME ADDRESS";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else  if ($field == 'EMAIL ADDRESS') {
                                        $stu_add = $_POST['stu_email'];
                                        if ($stu_add != '') {
                                            $stu_add = strtoupper($stu_add);
                                            $sql = oci_parse($conn, "update student_contact set email = '$stu_add' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "EMAIL UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING EMAIL";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER EMAIL";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else  if ($field == 'PHONE NUMBER') {
                                        $stu_add = $_POST['stu_phone'];
                                        if ($stu_add != '') {

                                            $sql = oci_parse($conn, "update student_contact set phone = $stu_add where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "PHONE NUMBER UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING PHONE NUMBER";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER PHONE NUMBER";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else  if ($field == 'EMERGENCY CONTACT') {
                                        $stu_add = $_POST['stu_eme'];
                                        if ($stu_add != '') {
                                            $sql = oci_parse($conn, "update student_contact set EMERGENCY = $stu_add where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "EMERGENCY CONTACT UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING EMERGENCY CONTACT";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER EMERGENCY CONTACT";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }
                                ?>
        </div>

        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_authourity where stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
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
         font-weight: bold; color: #909290;">Parent/Guardian Information</Label>
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
                        Firstname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Middlename</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Lastname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Address</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Phone</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Occupation</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Relationship</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ID Photo</th>

                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ADDRESS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PHONE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['OCCUPATION']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['RELATION']; ?>

                        </td>
                        <?php
                        // Check if $row['PHOTO'] is not null before calling load()
                        if (!empty($row['PHOTO'])) {
                            $imageData = $row['PHOTO']->load();
                            $base64Image = base64_encode($imageData);
                        ?>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;">
                                <?php echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 50px; height: 50px;">'; ?>
                            </td>
                        <?php
                        } else {
                            // Handle the case where $row['PHOTO'] is null or empty
                        ?>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;">
                                <?php //echo 'No image available'; 
                                ?>
                            </td>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_auth" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>FIRSTNAME</option>
                    <option>MIDDLENAME</option>
                    <option>LASTNAME</option>
                    <option>ADDRESS</option>
                    <option>PHONE</option>
                    <option>EMAIL</option>
                    <option>OCCUPATION</option>
                    <option>RELATIONSHIP</option>
                    <option>PASSPORT PHOTO SIZE</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student</label>
                <select required name="id_auth">
                    <option disabled selected>Select Student</option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Firstname</label>
                <input type="text" placeholder="Enter Firstname" title="Only Letters" pattern="[A-z]+" name="pg_first">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Letters" pattern="[A-z]+" name="pg_middle">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Lastname</label>
                <input type="text" placeholder="Enter Lastname" title="Only Letters" pattern="[A-z]+" name="pg_last">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Address</label>
                <input type="text" placeholder="Enter Address" title="Only Letters" pattern="[A-z0-9 ]+" name="pg_add">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Phone</label>
                <input type="number" placeholder="Enter Phone Number" title="Only Numbers" name="pg_phone" maxlength="7" title="ONLY 7 CHARACTERS ALLOWED">
            </div>

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Email</label>
                <input type="email" placeholder="Enter Email" title="Only Numbers" name="pg_email">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Occupation</label>
                <input type="text" placeholder="Enter Occupation" title="Only Numbers" name="pg_occu" pattern="[A-z ]+">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Relationship</label>
                <select name="pg_relation" required>
                    <option disabled selected>Select Relationship Type</option>
                    <option>PARENT</option>
                    <option>GUARDIAN</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Passport Size Photo</label>
                <input type="file" placeholder="Enter Occupation" title="Only Numbers" name="pg_pass" pattern="[A-z ]+">
            </div>
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
  text-decoration: none;" name="edit_authourity" type="submit">
                EDIT PARENT/GUARDIAN INFORMATION
                <i class="uil uil-edit"></i>
            </button>
            <?php
            if (isset($_POST['edit_authourity'])) {
                if (isset($_POST['edit_auth'])) {
                    $field = $_POST['edit_auth'];
                    if (isset($_POST['id_auth'])) {
                        $stuid = trim($_POST['id_auth']);

                        $id = $stuid;
                        if ($field == 'FIRSTNAME') {
                            $first = strtoupper($_POST['pg_first']);
                            if ($first != '') {
                                $sql = oci_parse($conn, "update student_authourity set firstname = '$first' where stud_id = '$id' and s_id = $sid ");
                                if (oci_execute($sql)) {
            ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "FIRSTNAME UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING FIRSTNAME ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER FIRSTNAME";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'MIDDLENAME') {
                                        $first = strtoupper($_POST['pg_middle']);
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "update student_authourity set middlename = '$first' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "MIDDLENAME UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING MIDDLENAME ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER MIDDLENAME";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'LASTNAME') {
                                        $first = strtoupper($_POST['pg_last']);
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "update student_authourity set LASTNAME = '$first' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "LASTNAME UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING LASTNAME ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER LASTNAME";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'ADDRESS') {
                                        $first = strtoupper($_POST['pg_add']);
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "update student_authourity set ADDRESS = '$first' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ADDRESS UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING ADDRESS ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER ADDRESS";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'PHONE') {
                                        $first = $_POST['pg_phone'];
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "update student_authourity set phone = $first where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "PHONE UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING PHONE ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER PHONE";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'EMAIL') {
                                        $first = strtoupper($_POST['pg_email']);
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "update student_authourity set EMAIL = '$first' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "EMAIL UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING EMAIL ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER EMAIL";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'OCCUPATION') {
                                        if ($_POST['pg_occu']) {
                                            $first = strtoupper($_POST['pg_occu']);
                                            $sql = oci_parse($conn, "update student_authourity set occupation = '$first' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "OCCUPATION UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING OCCUPATION ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER EMAIL";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'RELATIONSHIP') {
                                        if (isset($_POST['pg_relation'])) {
                                            $first = strtoupper($_POST['pg_relation']);
                                            $sql = oci_parse($conn, "update student_authourity set relation = '$first' where stud_id = '$id' and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "RELATIONSHIP UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING RELATIONSHIP";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER RELATIONSHIP";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'PASSPORT PHOTO SIZE') {
                                        if (isset($_FILES['pg_pass'])) {
                                            $pg_photo = $_FILES['pg_pass']['tmp_name'];
                                            $id_doc = file_get_contents($pg_photo);
                                            if (isjpeg_png($id_doc)) {
                                                $query = "UPDATE STUDENT_AUTHOURITY SET PHOTO = :photo where stud_id = :stuid and s_id=:sid  ";
                                                $statement = oci_parse($conn, $query);
                                                oci_bind_by_name($statement, ':sid', $sid);
                                                oci_bind_by_name($statement, ':stuid', $id);


                                                $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                                oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                                                $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);

                                                if (oci_execute($statement, OCI_DEFAULT)) {
                                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                            <?php echo "PASSPORT PHOTO SIZE UPDATED SUCCESSFULLY";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                } else {
                                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR UPDATING PASSPORT PHOTO SIZE ";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                }
                                            } else {
                                                    ?><div style="font-size:15px;
                                            color: red;
                                            position: relative;
                                             display:flex;
                                             margin-left:10px;
                                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ONLY ALLOWED FILE TYPES ARE PNG AND JPEG";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "UPLOAD PASSPORT PHOTO SIZE";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }

                                ?>
        </div>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_medical where stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
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
         font-weight: bold; color: #909290;">Medical Information</Label>
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
                        Allergy</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Medical Conditions</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Medications</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ALLERGY']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CONDITION']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MEDICATIONS']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_med" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>ALLERGY</option>
                    <option>MEDICAL CONDITION</option>
                    <option>MEDICATIONS</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student</label>
                <select required name="id_med">
                    <option disabled selected>Select Student</option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Allergies (If No type None)</label>
                <input type="text" placeholder="Enter Allergies" title="Only Letters" pattern="[A-z ]+" name="stu_aller">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Medical Conditions (If No type None)</label>
                <input type="text" placeholder="Enter Medical Conditions" name="stu_cond">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Medications (If No type None)</label>
                <input type="text" placeholder="Enter Medications" title="Only Letters" pattern="[A-z0-9 ]+" name="stu_med">
            </div>
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
  text-decoration: none;" name="edit_medical" type="submit">
                EDIT MEDICAL INFORMATION
                <i class="uil uil-edit"></i>
            </button>
            <?php
            if (isset($_POST['edit_medical'])) {
                if (isset($_POST['edit_med'])) {
                    $field = $_POST['edit_med'];
                    if (isset($_POST['id_med'])) {
                        $stuid = trim($_POST['id_med']);

                        $id = $stuid;
                        if ($field == 'ALLERGY') {
                            $allergy = strtoupper($_POST['stu_aller']);
                            $sql = oci_parse($conn, "update student_medical set allergy = '$allergy' where stud_id = '$id' and s_id = $sid");
                            if (oci_execute($sql)) {
            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ALLERGY UPDATED SUCCESSFULLY";
                                    header("refresh:2;");
                                    ?></div><?php
                                        } else {
                                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING ALLERGY";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else  if ($field == 'ALLERGY') {
                                        $allergy = strtoupper($_POST['stu_aller']);
                                        $sql = oci_parse($conn, "update student_medical set allergy = '$allergy' where stud_id = '$id' and s_id = $sid");
                                        if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                              color: green;
                              position: relative;
                               display:flex;
                               margin-left:10px;
                              animation:button .3s linear;text-align: center;">
                                    <?php echo "ALLERGY UPDATED SUCCESSFULLY";
                                            header("refresh:2;");
                                    ?></div><?php
                                        } else {
                                            ?><div style="font-size:15px;
                              color: red;
                              position: relative;
                               display:flex;
                               margin-left:10px;
                              animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING ALLERGY";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else  if ($field == 'MEDICAL CONDITION') {
                                        $allergy = strtoupper($_POST['stu_cond']);
                                        $sql = oci_parse($conn, "update student_medical set condition = '$allergy' where stud_id = '$id' and s_id = $sid");
                                        if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                              color: green;
                              position: relative;
                               display:flex;
                               margin-left:10px;
                              animation:button .3s linear;text-align: center;">
                                    <?php echo "MEDICAL CONDITION UPDATED SUCCESSFULLY";
                                            header("refresh:2;");
                                    ?></div><?php
                                        } else {
                                            ?><div style="font-size:15px;
                              color: red;
                              position: relative;
                               display:flex;
                               margin-left:10px;
                              animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING MEDICAL CONDITION";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else  if ($field == 'MEDICATIONS') {
                                        $allergy = strtoupper($_POST['stu_med']);
                                        $sql = oci_parse($conn, "update student_medical set MEDICATIONS = '$allergy' where stud_id = '$id' and s_id = $sid");
                                        if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                              color: green;
                              position: relative;
                               display:flex;
                               margin-left:10px;
                              animation:button .3s linear;text-align: center;">
                                    <?php echo "MEDICATIONS UPDATED SUCCESSFULLY";
                                            header("refresh:2;");
                                    ?></div><?php
                                        } else {
                                            ?><div style="font-size:15px;
                              color: red;
                              position: relative;
                               display:flex;
                               margin-left:10px;
                              animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING MEDICATIONS";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }
                                ?>
        </div>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_academic a join class b on (a.class=b.class) where a.stud_id = '$stuid' ";
            $per = oci_parse($conn, $p);
            oci_execute($per);
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
         font-weight: bold; color: #909290;">Academic Information</Label>
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
                        Previous School</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Enrolling Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PREV_SCHOOL']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_TITLE']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_acad" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>PREVIOUS SCHOOL</option>
                    <option>PREVIOUS AGGREGATE/GPA</option>
                    <option>ENROLLING CLASS</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student </label>
                <select required name="id_acad">
                    <option disabled selected>Select Student</option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Previous School</label>
                <input type="text" placeholder="Enter Previous School" title="Only Letters" pattern="[A-z ]+" name="stu_prev">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Aggregate/GPA</label>
                <input type="number" placeholder="Enter Previous Aggregate/GPA" title="Only Numbers" pattern="[0-9.]+" name="stu_score" style="width: 270px;">
            </div>

            <div class="input-field" style="margin-right: 10px;">
                <label>Enrolling Grade</label>
                <select name="stu_class">
                    <option disabled selected>Select Class</option>
                    <?php
                    $get_hos = "select * from sub_class WHERE S_ID= $sid  AND SUB_TITLE NOT LIKE 'AISHA' and SUB_CODE  != 286 AND SUB_CODE  != 290 AND  SUB_CODE  != 202 AND  SUB_CODE  != 291 AND  SUB_CODE  != 122 AND  SUB_CODE  != 242 AND  SUB_CODE  != 103  ORDER BY CLASS_NAME";
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
  text-decoration: none;" name="edit_academic" type="submit">
                EDIT ACADEMIC INFORMATION
                <i class="uil uil-edit"></i>
            </button>
            <?php
            if (isset($_POST['edit_academic'])) {
                if (isset($_POST['edit_acad'])) {
                    $field = $_POST['edit_acad'];
                    if (isset($_POST['id_acad'])) {
                        $stuid = trim($_POST['id_acad']);

                        $id = $stuid;
                        if ($field == 'PREVIOUS SCHOOL') {
                            $prev = strtoupper($_POST['stu_prev']);
                            if ($prev != '') {
                                $sql = oci_parse($conn, "update student_academic set PREV_SCHOOL = '$prev' where stud_id='$id'and s_id = $sid ");
                                if (oci_execute($sql)) {
            ?><div style="font-size:15px;
                                   color: green;
                                   position: relative;
                                    display:flex;
                                    margin-left:10px;
                                   animation:button .3s linear;text-align: center;">
                                        <?php echo "PREVIOUS SCHOOL UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                   color: red;
                                   position: relative;
                                    display:flex;
                                    margin-left:10px;
                                   animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING PREVIOUS SCHOOL";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER PREVIOUS SCHOOL";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                    if ($field == 'PREVIOUS AGGREGATE/GPA') {
                                        $prev = strtoupper($_POST['stu_score']);
                                        if ($prev != '') {
                                            $sql = oci_parse($conn, "update student_academic set score = '$prev' where stud_id='$id'and s_id = $sid ");
                                            if (oci_execute($sql)) {
                                            ?><div style="font-size:15px;
                                  color: green;
                                  position: relative;
                                   display:flex;
                                   margin-left:10px;
                                  animation:button .3s linear;text-align: center;">
                                        <?php echo "PREVIOUS AGGREGATE/GPA UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                  color: red;
                                  position: relative;
                                   display:flex;
                                   margin-left:10px;
                                  animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING PREVIOUS AGGREGATE/GPA";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                               color: red;
                               position: relative;
                                display:flex;
                                margin-left:10px;
                               animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER PREVIOUS SCHOOL";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'ENROLLING CLASS') {
                                        if (isset($_POST['stu_class'])) {
                                            $class = $_POST['stu_class'];
                                            $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
                                            oci_execute($sql);
                                            while ($r = oci_fetch_array($sql)) {
                                                $c = $r['CLASS'];
                                                $s_c = $r['SUB_CODE'];
                                            }
                                            $check  = oci_parse($conn, "select * from student_academic a join student b on (a.stud_id=b.stud_id)  where b.status = 'REGISTERED' OR B.STATUS ='ENROLLED' OR  B.STATUS = 'SEMI-ENROLLED' AND a.stud_id='$id' ");
                                            oci_execute($check);
                                            if (oci_fetch_all($check, $a) > 0) {
                                                $sql = oci_parse($conn, "update student_academic set sub_code = $s_c,class = $c where stud_id='$id'and s_id = $sid ");
                                                if (oci_execute($sql)) {
                                                    //   echo "update class_student set class_code = $s_c where stud_id='$id'and s_id = $sid ";
                                                    $sql = oci_parse($conn, "update class_student set sub_code = $s_c where stud_id='$id'and s_id = $sid ");
                                                    oci_execute($sql);

                                                    $sql = oci_parse($conn, "update student_evaluation set class_code = $s_c where stud_id='$id'and s_id = $sid ");
                                                    oci_execute($sql);

                                                    $sql = oci_parse($conn, "update student_cumulative set sub_code = $s_c where stud_id='$id'and s_id = $sid ");
                                                    oci_execute($sql);

                                                    $sql = oci_parse($conn, "update student_standings set class_code = $s_c where stud_id='$id'and s_id = $sid ");
                                                    oci_execute($sql);

                                            ?><div style="font-size:15px;
                                       color: green;
                                       position: relative;
                                        display:flex;
                                        margin-left:10px;
                                       animation:button .3s linear;text-align: center;">
                                            <?php echo "CLASS UPDATED SUCCESSFULLY";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                } else {
                                                    ?><div style="font-size:15px;
                                       color: red;
                                       position: relative;
                                        display:flex;
                                        margin-left:10px;
                                       animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR UPDATING ENROLLING CLASS";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                }
                                            } else {
                                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                        <?php echo "ONLY CLASS OF REGISTERED OR ENROLLED STUDENTS CAN BE UPDATED ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                               color: red;
                               position: relative;
                                display:flex;
                                margin-left:10px;
                               animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER ENROLLING CLASS";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }
                                ?>
        </div>

        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Student Documentation</Label>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="edit_doc" required>
                    <option disabled selected>Select Field To Upload</option>
                    <option>BIRTH CERTIFICATE</option>
                    <option>PASSPORT/NATIONAL ID</option>
                    <option>PASSPORT PHOTO SIZE</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Student</label>
                <select required name="id_doc">
                    <option disabled selected>Select Student</option>
                    <?php

                    $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) where a.s_id = $sid and a.status != 'GRADUATED' and a.name != 'ABUBACARR JOBARTEH' and b.sub_code = $sub_cd  order by name ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                            <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ") "; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Upload Birth Certificate</label>
                <input type="file" name="stu_birth">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Upload Passport/National ID</label>
                <input type="file" name="stu_natid">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Upload Passport Photo</label>
                <input type="file" name="stu_pass">
            </div>

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
  text-decoration: none;" name="edit_document" type="submit">
                EDIT STUDENT DOCUMENT
                <i class="uil uil-edit"></i>
            </button>
            <?php
            if (isset($_POST['edit_document'])) {
                if (isset($_POST['edit_doc'])) {
                    $field = $_POST['edit_doc'];
                    if (isset($_POST['id_doc'])) {
                        $stuid = trim($_POST['id_doc']);

                        $id = $stuid;
                        if ($field == 'BIRTH CERTIFICATE') {
                            if (isset($_FILES['stu_birth'])) {
                                $stu_birth = $_FILES['stu_birth']['tmp_name'];
                                if (isjpeg_png($stu_birth) || ispdf_word($stu_birth)) {
                                    $id_doc = file_get_contents($stu_birth);
                                    $query = "UPDATE STUDENT_DOCUMENT SET BIRTH = :photo where stud_id = :stuid and s_id=:sid  ";
                                    $statement = oci_parse($conn, $query);
                                    oci_bind_by_name($statement, ':sid', $sid);
                                    oci_bind_by_name($statement, ':stuid', $id);
                                    $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                    oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                                    $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);
                                    if (oci_execute($statement, OCI_DEFAULT)) {
            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                            <?php echo "BIRTH DOCUMENT UPDATED SUCCESSFULLY";
                                            header("refresh:2;");
                                            ?></div><?php
                                                } else {
                                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR UPDATING BIRTH DOCUMENTS";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                }
                                            } else {
                                                    ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ONLY ALLOWED FILES TYPES ARE PDF,JPEG AND PNG";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT FILE TO UPLOAD";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                        /*   $stu_natid = $_FILES['stu_natid']['tmp_name'];
                            $stu_pass = $_FILES['stu_pass']['tmp_name']; */
                                    } else  if ($field == 'PASSPORT/NATIONAL ID') {
                                        if (isset($_FILES['stu_natid'])) {
                                            $stu_birth =  $_FILES['stu_natid']['tmp_name'];;
                                            if (isjpeg_png($stu_birth) || ispdf_word($stu_birth)) {
                                                $id_doc = file_get_contents($stu_birth);
                                                $query = "UPDATE STUDENT_DOCUMENT SET PASSPORT = :photo where stud_id = :stuid and s_id=:sid  ";
                                                $statement = oci_parse($conn, $query);
                                                oci_bind_by_name($statement, ':sid', $sid);
                                                oci_bind_by_name($statement, ':stuid', $id);
                                                $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                                oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                                                $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);
                                                if (oci_execute($statement, OCI_DEFAULT)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                            <?php echo "PASSPORT/NATIONAL ID UPDATED SUCCESSFULLY";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                } else {
                                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR UPDATING PASSPORT/NATIONAL ID";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                }
                                            } else {
                                                    ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ONLY ALLOWED FILES TYPES ARE PDF,JPEG AND PNG";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT FILE TO UPLOAD";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                        /*   $stu_natid = $_FILES['stu_natid']['tmp_name'];
                            $stu_pass = $_FILES['stu_pass']['tmp_name']; */
                                    } else  if ($field == 'PASSPORT PHOTO SIZE') {
                                        if (isset($_FILES['stu_natid'])) {
                                            $stu_birth =  $_FILES['stu_pass']['tmp_name'];;
                                            if (isjpeg_png($stu_birth) || ispdf_word($stu_birth)) {
                                                $id_doc = file_get_contents($stu_birth);
                                                $query = "UPDATE STUDENT_DOCUMENT SET PASS_PHOTO = :photo where stud_id = :stuid and s_id=:sid  ";
                                                $statement = oci_parse($conn, $query);
                                                oci_bind_by_name($statement, ':sid', $sid);
                                                oci_bind_by_name($statement, ':stuid', $id);
                                                $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                                oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                                                $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);
                                                if (oci_execute($statement, OCI_DEFAULT)) {
                                            ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                            <?php echo "PASSPORT PHOTO SIZE UPDATED SUCCESSFULLY";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                } else {
                                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR UPDATING PASSPORT PHOTO SIZE";
                                                    header("refresh:2;");
                                            ?></div><?php
                                                }
                                            } else {
                                                    ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ONLY ALLOWED FILES TYPES ARE JPEG AND PNG";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT FILE TO UPLOAD";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                        /*   $stu_natid = $_FILES['stu_natid']['tmp_name'];
                            $stu_pass = $_FILES['stu_pass']['tmp_name']; */
                                    }
                                } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT STUDENT ID";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT FIELD TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        }
                                ?>

        </div>
    
                <?php
                if (isset($_POST['add_mark'])) {
                    $stuid = $_SESSION['STID'];
                    $sql = oci_parse($conn, "SELECT * FROM CLASS_STUDENT WHERE STUD_ID = '$stuid' ");
                    oci_execute($sql);
                    while ($row = oci_fetch_array($sql)) {
                        $class_code = $row['SUB_CODE'];
                    }
                    if (isset($_POST['add_stud_term'])) {
                        $t = $_POST['add_stud_term'];
                        if (isset($_POST['add_stud_subject'])) {
                            $sub_code = $_POST['add_stud_subject'];
                            $cass = $_POST['add_cas'];
                            if ($cass != '') {
                                $exam = $_POST['add_exam'];
                                  if($exam != ''){
                                 //    $sql = "SELECT * FROM STUDENT_EVALUATION WHERE TERM = '$t' AND CLASS_CODE = $class_code AND SUB_CODE = $sub_code and stud_id = '$stuid' ";
                                      $sql = oci_parse($conn,"SELECT * FROM STUDENT_EVALUATION WHERE TERM = '$t' AND CLASS_CODE = $class_code AND SUB_CODE = $sub_code and stud_id = '$stuid' ");
                                      oci_execute($sql);
                                      if(oci_fetch_all($sql,$a)==0){
                                        $cas_mark = 0.3*$cass;
                                        $exam_mark = 0.7*$exam;
                                        $emp_id = '202403291125';
                                    /*    echo "INSERT INTO STUDENT_EVALUATION (S_ID,SUB_CODE,STUD_ID,EMP_ID,ACADEMIC_YEAR,TERM,CONST_ASS,EXAM,ENTRY_DT,CLASS_CODE,MARK_STATUS)
                                        VALUES  ($sid,$sub_code,' $stuid','$emp_id','$a_y','$t',$cas_mark,$exam_mark,sysdate,$class_code,'ACCEPTED')";
                                        */
                                        $sql = oci_parse($conn, "INSERT INTO STUDENT_EVALUATION (S_ID,SUB_CODE,STUD_ID,EMP_ID,ACADEMIC_YEAR,TERM,CONST_ASS,EXAM,ENTRY_DT,CLASS_CODE,MARK_STATUS)
                                        VALUES  ($sid,$sub_code,'$stuid','$emp_id','$a_y','$t',$cas_mark,$exam_mark,sysdate,$class_code,'ACCEPTED')");
                                        
                                        
                                        

                                        if(oci_execute($sql)){
                                            $stud_id = $stuid;
                                        $s_code = $class_code;
                                        // Fetch total marks for the student
                                        $gettotal = "SELECT * FROM STUDENT A JOIN STUDENT_EVALUATION B ON (A.STUD_ID=B.STUD_ID) WHERE B.S_ID = $sid AND MARK_STATUS = 'ACCEPTED' and B.CLASS_CODE = $class_code AND B.SUB_CODE = $sub_code AND B.EMP_ID = '$emp_id' AND B.STUD_ID = '$stud_id' and b.term = '$t' ";
                                        $s = oci_parse($conn, $gettotal);
                                        oci_execute($s);
                
                                        while ($a = oci_fetch_array($s)) {
                                            $total = $a["CONST_ASS"] + $a["EXAM"];
                                        }
                
                                        // Fetch grade information based on total marks
                                        $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE AND B.S_ID  = $sid ORDER BY A.GRADE");
                                        oci_execute($getgrade);
                
                                        while ($b = oci_fetch_array($getgrade)) {
                                            $g_code = $b["G_CODE"];
                                            $grade = $b["GRADE"];
                                        }
                
                                        // Fetch GPA based on grade
                                        $getgpa = oci_parse($conn, "SELECT * FROM GPA WHERE g_code = $g_code");
                                        oci_execute($getgpa);
                
                                        while ($c = oci_fetch_array($getgpa)) {
                                            $gpa = $c['GPA'];
                                        }
                
                                        // Fetch subject credit hours
                                        $getgpa = oci_parse($conn, "SELECT * FROM SUBJECT WHERE SUB_CODE = $sub_code AND subs = $s_code AND s_id = $sid");
                                        oci_execute($getgpa);
                
                                        while ($d = oci_fetch_array($getgpa)) {
                                            $hrs = $d['SUBJECT_CREDIT_HRS'];
                                        }
                
                                        $currentDate = date('Y-m-d');
                                        $pro_gpa_hrs = $gpa * $hrs;
                
                                        // Check if a record already exists
                                        $check_cum = oci_parse($conn, "SELECT COUNT(*) AS RECORD_COUNT FROM STUDENT_CUMULATIVE WHERE S_ID = $sid AND sub_code = $sub_code AND subj_code = $s_code AND stud_id = '$stud_id'");
                                        oci_execute($check_cum);
                                        oci_fetch_all($check_cum, $result);
                
                                        if ($result['RECORD_COUNT'][0] == 0) {
                                            // Record exists, continue to the next iteration
                                            // Record doesn't exist, insert a new record
                                            $check_cum = oci_parse($conn, "SELECT COUNT(*) AS RECORD_COUNT FROM STUDENT_CUMULATIVE WHERE S_ID = $sid AND subj_code = $s_code AND stud_id = '$stud_id'");
                                            oci_execute($check_cum);
                                            oci_fetch_all($check_cum, $result);
                                            if ($result['RECORD_COUNT'][0] <= 9) {
                                                $cumulative = oci_parse($conn, "INSERT INTO STUDENT_CUMULATIVE (S_ID, STUD_ID, ACADEMIC_YEAR, TERM, ENTRY_DT, SUB_CODE, SUBJ_CODE, MARK, G_CODE, GPA, CREDIT_HRS, TOTAL_GPA_CREDIT) 
                                          VALUES ($sid, '$stud_id', '$a_y', '$t', '$currentDate', $s_code, $sub_code, $total, $g_code, $gpa, $hrs, $pro_gpa_hrs)");
                                                oci_execute($cumulative);
                                            }
                                        }
                                            ?><div style="font-size:15px;
                                            color: green;
                                            position: relative;
                                             display:flex;
                                             margin-left:10px;
                                            animation:button .3s linear;text-align: center;">
                                                        <?php echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "STUDENT MARK CUMULATED AND ENTERED SUCCESSFULLYx",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                                          header("refresh:2;");
                                                        ?></div><?php
                                        }


                                      }else {
                                        ?><div style="font-size:15px;
                                        color: red;
                                        position: relative;
                                         display:flex;
                                         margin-left:10px;
                                        animation:button .3s linear;text-align: center;">
                                                    <?php echo '<script>
															Swal.fire({
																position: "center",
																icon: "error",
																title: "STUDENT MARK ALREADY ENTERED",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                                        header("refresh:2;");
                                                    ?></div><?php
                                      }
                                  }else {
                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                                <?php echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "ENTER EXAM MARK",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                                    header("refresh:2;");
                                                ?></div><?php
                                  }
                            } else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                            <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "ENTER CASS MARK",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                                header("refresh:2;");
                                            ?></div><?php
                            }
                        } else {
                ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                                <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT SUBJECT",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                header("refresh:2;");
                                ?></div><?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT TERM",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                    header("refresh:2;");
                            ?></div><?php
                                    }
                                }

                                        ?>
         
                        <?php
                        if (isset($_POST['edit_mark'])) {
                            $stuid = $_SESSION['STID'];
                            $sql = oci_parse($conn, "SELECT * FROM CLASS_STUDENT WHERE STUD_ID = '$stuid' ");
                            oci_execute($sql);
                            while ($row = oci_fetch_array($sql)) {
                                $class_code = $row['SUB_CODE'];
                            }
                            if (isset($_POST['edit_stud_term'])) {
                                $t = $_POST['edit_stud_term'];
                                if (isset($_POST['edit_stud_subject'])) {
                                    $sub_code = $_POST['edit_stud_subject'];
                                    $cass = $_POST['cas'];

                                    if ($cass != '') {
                                        $cass = $cass * 0.3;
                                        $exam = $_POST['exam'];
                                        if ($exam != '') {
                                            $exam = $exam * 0.7;
                                            $tt = $cass + $exam;
                                            //   echo "UPDATE STUDENT_EVALUATION SET CONST_ASS = $cass , EXAM= $exam where term = '$t' and SUB_CODE = $sub_code and CLASS_CODE = $class_code ";
                                            $sql = oci_parse($conn, "UPDATE STUDENT_EVALUATION SET CONST_ASS = $cass , EXAM= $exam where term = '$t' and SUB_CODE = $sub_code and CLASS_CODE = $class_code and stud_id= '$stuid' ");
                                            if (oci_execute($sql)) {
                                                // Fetch grade information based on total marks
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($tt AS INT) AND CAST($tt AS INT) <= B.END_GRADE_RANGE AND B.S_ID  = $sid ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                // Fetch GPA based on grade
                                                $getgpa = oci_parse($conn, "SELECT * FROM GPA WHERE g_code = $g_code");
                                                oci_execute($getgpa);

                                                while ($c = oci_fetch_array($getgpa)) {
                                                    $gpa = $c['GPA'];
                                                }

                                                // Fetch subject credit hours
                                                $getgpa = oci_parse($conn, "SELECT * FROM SUBJECT WHERE SUB_CODE = $sub_code AND subs = $class_code AND s_id = $sid");
                                                oci_execute($getgpa);

                                                while ($d = oci_fetch_array($getgpa)) {
                                                    $hrs = $d['SUBJECT_CREDIT_HRS'];
                                                }
                                                $pro_gpa_hrs = $gpa * $hrs;
                                                $currentDate = date('Y-m-d');
                                                $sql = oci_parse($conn, "UPDATE STUDENT_CUMULATIVE SET MARK = $tt , G_CODE = $g_code , GPA = $gpa , TOTAL_GPA_CREDIT = $pro_gpa_hrs WHERE STUD_ID = '$stuid' AND SUBJ_CODE = $sub_code and SUB_CODE = $class_code and term = '$t' ");
                                                if (oci_execute($sql)) {
                                                    $sql = oci_parse($conn, "DELETE FROM STUDENT_STANDINGS WHERE STUD_ID = '$stuid' AND class_CODE = $class_code and term = '$t'");
                                                    oci_execute($sql);
                        ?><div style="font-size:15px;
                                                                color: green;
                                                                position: relative;
                                                                 display:flex;
                                                                 margin-left:10px;
                                                                animation:button .3s linear;text-align: center;">
                                                        <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "MARK EDITED SUCCESSFULY",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                        header("refresh:2;");
                                                        ?></div><?php
                                                                        }
                                                                        //echo "UPDATE STUDENT_CUMULATIVE SET MARK = $tt , G_CODE = $g_code , GPA = $gpa , TOTAL_GPA_CREDIT = $pro_gpa_hrs WHERE STUD_ID = '$stuid' AND SUBJ_CODE = $sub_code and SUB_CODE = $class_code and term = '$t' ";
                                                                    }
                                                                } else {
                                                                            ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                                <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "ENTER EXAM MARK",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                                    header("refresh:2;");
                                                ?></div><?php
                                                                }
                                                            } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                            <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "ENTER CASS MARK",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                                header("refresh:2;");
                                            ?></div><?php
                                                            }
                                                        } else {
                                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                        <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT SUBJECT",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                            header("refresh:2;");
                                        ?></div><?php
                                                        }
                                                    } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                                    <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT TERM",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                                        header("refresh:2;");
                                    ?></div><?php
                                                    }
                                                }

                                    ?>
                    </div>

                </div>

                <div style="display:flex; margin-top:20px;">
                    <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Remove Student Mark</Label>
                </div>
                <div class="input-container" style="display: flex;">


                    <?php $get_hos = "SELECT DISTINCT(C.TERM) FROM STUDENT A JOIN STUDENT_EVALUATION B ON (A.STUD_ID=B.STUD_ID) JOIN TERM_CALENDAR C ON (B.TERM = C.TERM) where b.stud_id = '$stuid' ORDER BY C.TERM ";
                    //echo  $get_hos;
                    ?>
                    <div class="input-field" style="margin-right: 10px; ">
                        <label for="subjectCode">Term</label>
                        <select required name="stud_term">
                            <option disabled selected>Select Term</option>
                            <?php
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option>
                                    <?php echo $row["TERM"]; ?>
                                </option> <?php
                                        }
                                            ?>
                        </select>
                        <?php // echo "SELECT DISTINCT(A.SUB_CODE),B.SUBJECT FROM STUDENT_SUBJECT A JOIN WAEC_SUBJECT B ON (A.Sub_code=B.sub_code)  where a.stud_id = '$stuid' ORDER BY B.SUBJECT "
                        ?>
                        <label for="subjectCode">Subject</label>
                        <select required name="stud_subject">
                            <option disabled selected>Select Subject</option>
                            <?php
                            $get_hos = "SELECT DISTINCT(A.SUB_CODE),B.SUBJECT FROM STUDENT_SUBJECT A JOIN WAEC_SUBJECT B ON (A.Sub_code=B.sub_code)  where a.stud_id = '$stuid' ORDER BY B.SUBJECT ";
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option value="<?php echo $row["SUB_CODE"]; ?> ">
                                    <?php echo $row["SUBJECT"]; ?>
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
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="remove_mark" type="submit">
                            REMOVE MARK
                            <i class="uil uil-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <?php
                if (isset($_POST['remove_mark'])) {
                    if (isset($_POST['stud_term'])) {
                        if (isset($_POST['stud_subject'])) {
                            $term = $_POST['stud_term'];
                            $subj = $_POST['stud_subject'];
                            $stuid = $_SESSION['STID'];

                            $sql = oci_parse($conn, "SELECT *  FROM STUDENT_EVALUATION WHERE TERM = '$term' AND SUB_CODE = $subj AND STUD_ID ='$stuid' ");
                            //   echo "SELECT *  FROM STUDENT_EVALUATION WHERE TERM = '$term' AND SUB_CODE = $subj AND STUD_ID ='$stuid' ";
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) > 0) {
                                //echo "DELETE  FROM STUDENT_EVALUATION WHERE TERM = '$term' AND SUB_CODE = $subj AND STUD_ID ='$stuid' ";
                                $sql = oci_parse($conn, "DELETE  FROM STUDENT_EVALUATION WHERE TERM = '$term' AND SUB_CODE = $subj AND STUD_ID ='$stuid' ");
                                oci_execute($sql);

                                $sql = oci_parse($conn, "DELETE  FROM STUDENT_CUMULATIVE  WHERE TERM = '$term' AND SUBJ_CODE = $subj AND STUD_ID ='$stuid'");
                                oci_execute($sql);

                                $sql = oci_parse($conn, "DELETE  FROM STUDENT_STANDINGS WHERE TERM = '$term' AND STUD_ID ='$stuid' ");
                                oci_execute($sql);

                                $sql =  oci_parse($conn, "INSERT INTO DELETE_MARK_LOG (USERNAME,CLASS_CODE,SUB_CODE,ENTRY_DT,TERM) VALUES ('$user',$sub_cd,$subj,SYSDATE,'$term' )");
                                if (oci_execute($sql)) {
                ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                                        <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "MARK REMOVED",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                        header("refresh:2;");
                                        ?></div><?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                                    <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "error",
																title: "MARK NOT ENTERED FOR STUDENT",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                    //         header("refresh:2;");
                                    ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                                <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT SUBJECT",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                                header("refresh:2;");
                                ?></div><?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                            <?php  echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT TERM",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                            header("refresh:2;");
                            ?></div><?php
                        }
                    }
                            ?>
                <div class="buttons">

                    <button class="backBtn" type="submit">
                        <a class="btnText" href="select_class_enroll.php">
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
function ispdf_word($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
        return true;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (in_array($mimetype, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
        return true;
    }

    return false;
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