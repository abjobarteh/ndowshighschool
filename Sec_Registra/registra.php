<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Registra Dashboard</title>
    <!-- update css path -->
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<?php
ob_start();
session_start();
$school =  $_SESSION['school'];

include 'connect.php'; ?>

<body>

    <nav class="sidebar">
        <a href="#" class="logo"> <?php

                                    ?>
        </a>
        <div class="menu-content">
            <ul class="menu-items">
                <div class="menu-title">Registra</div>

                <li class="item">
                    <div class="submenu-item">
                        <span>Class</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Class
                        </div>
                        <li class="item">
                            <a href="show_class.php">Show Class</a>
                        </li>
                        <li class="item">
                            <a href="class.php">Class Management</a>
                        </li>
                    </ul>
                </li>
                
                <li class="item">
                    <div class="submenu-item">
                        <span>Subject And Department Management</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Subject And Department Management
                        </div>
                        <li class="item">
                            <a href="#">Show Subject And Department</a>
                        </li>
                        <li class="item">
                            <a href="manage_dept.php">Department Management</a>
                        </li>
                        <li class="item">
                            <a href="subject.php">Subject Management</a>
                        </li>
                    </ul>
                </li>

                 
                <li class="item">
                    <div class="submenu-item">
                        <span>Teacher</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Teacher
                        </div>
                        <li class="item">
                            <a href="show_teacher.php">Show Teacher</a>
                        </li>
                        <li class="item">
                            <a href="edit_teacher.php">Edit Teacher</a>
                        </li>
                        <li class="item">
                            <a href="manage_teacher.php">Add Teacher</a>
                        </li>
                        <li class="item">
                            <a href="#">Teacher/Subject Management</a>
                        </li>
                    </ul>
                </li>
                      
                <li class="item">
                    <div class="submenu-item">
                        <span>Student Management</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Student Management
                        </div>
                        <li class="item">
                            <a href="show_student.php">Show Student</a>
                        </li>
                        <li class="item">
                            <a href="add_student.php">Add Student</a>
                        </li>
                        <li class="item">
                            <a href="edit_student.php">Edit Student</a>
                        </li>
                        <li class="item">
                            <a href="assign_student.php">Enroll Student</a>
                        </li>
                        <li class="item">
                            <a href="#">Student Finance</a>
                        </li>
                      
                    </ul>
                </li>
                <li class="item">
                    <a href="../Landing/login.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <nav class="navbar">
        <span class="fas fa-bars" id="sidebar-close"></span>
    </nav>
    <!-- End of Sidebar -->

    <!-- Content -->
    <main class="main">
        <h1>Academix:School Management System</h1>
        <h1><?php echo $school; ?></h1>
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
    </main>

    <!-- update path -->
    <script src="js/script.js"></script>
</body>

</html>