<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
?>

<body>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

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
    <h2>Class</h2>
    <form action="select_class_compile.php" method="post" style="min-height: 250px;">
      <div class="input-box">
      <select required name="teacher">
                <option disabled selected>Select Class</option>
                <?php
                $get_hos = "select distinct(a.class_name) from sub_class a join student_academic b on (a.sub_code=b.sub_code) where a.s_id = $sid order by a.class_name";
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
    
      <button class="input-box button">
        <input type="Submit" value="Continue" name="change" required>
      </button>
      <div class="text">
        <h3><a href="registra.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
      </div>
      <div class="message">
        <?php
        include 'connect.php';
        if (isset($_POST['change'])) {
                if(isset($_POST['teacher'])) {
                    $class_name = $_POST['teacher'];
                    $sql = oci_parse($conn,"select * from sub_class where class_name = '$class_name' and s_id = $sid  ");
                    oci_execute($sql);
                    while($r= oci_fetch_array($sql)) {
                     $s_code = $r['SUB_CODE'];
                     $_SESSION['s_code'] = $s_code;
                   //  $_SESSION['year'] = $a_y;
                     ?><div style="font-size:15px;
                     color: green;
                     position: relative;
                      display:flex;
                     animation:button .3s linear;text-align: center;">
                                     <?php echo "SELECTED CLASS: $class_name ";
                                         header("refresh:2;url=compile_gpa.php"); ?>
                                 </div> <?php
                    }
                }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT CLASS";
                                        header("refresh:2;"); ?>
                                </div> <?php
                }
            }
                    ?>
      </div>
    </form>
  </div>
</body>

</html>