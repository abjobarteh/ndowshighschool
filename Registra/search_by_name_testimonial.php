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
    <h2>Search Name For Transcript</h2>
    <form action="search_by_name_testimonial.php" method="post" style="min-height: 250px;">
      <div class="input-box">
      <input type="text" placeholder="Enter Name" name="name" required type="text" pattern="[A-z ]+" >
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
        $name = strtoupper($_POST['name']);
        $_SESSION['student_name']=$name;
        ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "SEARCH NAME IS $name";
                header("refresh:2;url=testimonial.php"); ?>
              </div> <?php
                }
                    ?>
      </div>
    </form>
  </div>
</body>

</html>