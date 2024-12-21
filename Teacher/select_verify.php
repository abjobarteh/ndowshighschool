<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
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
?>
<?php
// Include the auto_logout.php file
include('auto_logout.php');
?>

<body>
  <div class="wrapper">
    <div class="com">
      <h3 class="title" style="justify-content:center; text-align:center; color:#909290; 	font-size: 18px;">Welcome To Academix
      </h3>
      <h3 class="title" style="justify-content:center; text-align:center; color:#909290; 	font-size: 18px;"><?php echo $school ?>
      </h3>
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
    <h2>Subject</h2>
    <form action="select_verify.php" method="post" style="min-height: 250px;">
      <div class="input-box">
        <select required name="subject">
          <option disabled selected>Select Subject</option>
          <?php
          $get_hos = "select a.subject,a.sub_code,c.CLASS_NAME from waec_subject a join teacher_subject b on (a.sub_code=b.sub_code) join sub_class c on (b.s_code=c.sub_code) where b.emp_id= $emp_id order by a.subject,c.class_name";
          $conn = oci_connect($username, $password, $connection);
          $get = oci_parse($conn, $get_hos);
          oci_execute($get);
          while ($row = oci_fetch_array($get, OCI_ASSOC)) {
          ?>
            <option >
              <?php  echo $row["SUBJECT"] . " (" . $row['CLASS_NAME'] . ")";; ?>
            </option>
          <?php
          }
         
          ?>
        </select>
      </div>

      <div class="input-box">
        <select required name="term">
          <option disabled selected>Select Term</option>
          <?php
          $get_hos = "select DISTINCT(C.TERM) from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) JOIN STUDENT_EVALUATION C ON (B.TERM=C.TERM) ORDER BY C.TERM";
          $conn = oci_connect($username, $password, $connection);
          $get = oci_parse($conn, $get_hos);
          oci_execute($get);
          while ($row = oci_fetch_array($get, OCI_ASSOC)) {
          ?>
            <option >
              <?php echo $row["TERM"]; ?>
            </option>
          <?php
          }
      
          ?>
        </select>
      </div>

      <button class="input-box button">
        <input type="Submit" value="Continue" name="change" required>
      </button>
      <div class="text">
        <h3><a href="teacher.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
      </div>
      <div class="message">
        <?php
        include 'connect.php';
        if (isset($_POST['change'])) {
          if (isset($_POST['subject'])) {
            if (isset($_POST['term'])) {
              $term = $_POST['term'];
              $classValue = $_POST['subject'];

              // If $row['CLASS_NAME'] is in the format "ClassName (AdditionalInfo)"
              // You can use the following code to extract the value within parentheses
              // If $classValue is in the format "Subject (ClassName)"
              if (strpos($classValue, '(') !== false && strpos($classValue, ')') !== false) {
                $startPos = strpos($classValue, '(') + 1;
                $endPos = strpos($classValue, ')', $startPos);
                $className = substr($classValue, $startPos, $endPos - $startPos);
                $subject = rtrim(substr($classValue, 0, $startPos - 1)); // Remove trailing space from subject
              } else {
                // If there are no parentheses, use the entire value as subject
                $subject = $classValue;
                $className = ''; // No class name
              }
              //echo  "select a.SUB_CODE,c.S_CODE from waec_subject a join teacher_subject c on (a.sub_code=c.sub_code) join sub_class d on (c.s_code=d.sub_code) where c.emp_id= $emp_id and a.subject = '$subject' and d.class_name = '$className' ";
              $sql = oci_parse($conn, "select a.SUB_CODE,c.S_CODE from waec_subject a join teacher_subject c on (a.sub_code=c.sub_code) join sub_class d on (c.s_code=d.sub_code) where c.emp_id= $emp_id and a.subject = '$subject' and d.class_name = '$className' ");
              oci_execute($sql);
              while ($r = oci_fetch_array($sql)) {
                $s_code  = $r["S_CODE"];
                $sub_code = $r['SUB_CODE'];
              }
              $sql = oci_parse($conn, "select class_name from sub_class where sub_code = $s_code ");
              oci_execute($sql);
              while ($r = oci_fetch_array($sql)) {
                $class_name = $r["CLASS_NAME"];
              }
              $_SESSION['s_code'] = $s_code;
              $_SESSION['sub_code'] = $sub_code;
              $_SESSION['class_name'] = $class_name;
              $_SESSION['subject'] = $subject;
              $_SESSION['term']=$term ;
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
                       title: "VERIFY STUDENT MARKS FOR ' . $class_name . ' TAKING ' . $subject . ' FOR ' . $term .'",
                       showConfirmButton: false,
                       timer: 1500
                       });
                     </script>';
              //  echo "VERIFY STUDENT MARKS FOR $class_name TAKING $subject";
              header("refresh:2;url=verify_grade.php");
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
                          title: "SELECT TERM",
                          showConfirmButton: false,
                          timer: 1500
                          });
                        </script>';
                  header("refresh:2;"); ?>
                </div> <?php
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
																title: "SELECT CLASS",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                      header("refresh:2;"); ?>
              </div> <?php
                    }
                  }
                      ?>
              </div>
    </form>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>