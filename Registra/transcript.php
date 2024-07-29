<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/transcript.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <?php
    ob_start();
    include('auto_logout.php');
    include('connect.php');
    $school =  $_SESSION['school'];
    $sid = $_SESSION['sid'];
    ?>
    <title>Transcript</title>
</head>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 2% auto;
        /* Reduced margin to increase vertical space */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        height: 80%;
        /* Set height to 80% of the viewport height */
        overflow-y: auto;
        /* Enable vertical scrolling if content overflows */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
        font-size: 12px;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <div class="container">

        <div class="buttons">
            <button class="backBtn" style="width: 150px;">
                <a class="btnText" href="registra" style="font-size: 15px; color: white; text-decoration: none;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px; color: white;"></i>
                </a>
            </button>
        </div>
        <header>Transcript</header>
        <form method="POST" action="transcript" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Create Transcript</span>


                    <div class="details personal">
                        <span class="title">Add Student Academic Records</span>

                        <div class="fields">
                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                                <label>Existing Student</label>
                                <select name="select_exist_student" required>
                                    <option disabled selected>Select Student</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM STUDENT ORDER BY NAME");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["STUD_ID"] . '">' . strtoupper($row["NAME"]) . ' ' . strtoupper($row['STUD_ID']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                                <label>Term</label>
                                <select name="select_term" required>
                                    <option disabled selected>Select Term</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM TERM_CALENDAR ORDER BY TERM");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["TERM"] . '">' . strtoupper($row["TERM"]) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                                <label>Class</label>
                                <select name="select_class" required>
                                    <option disabled selected>Select Class</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM SUB_CLASS ORDER BY CLASS_NAME");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["SUB_CODE"] . '">' . strtoupper($row["CLASS_NAME"]) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                                <label>Subject</label>
                                <select name="select_subject" required>
                                    <option disabled selected>Select Subject</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM WAEC_SUBJECT ORDER BY SUBJECT");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["SUB_CODE"] . '">' . strtoupper($row["SUBJECT"]) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(70% / 5 - 10px);">
                                <label>Student Mark</label>
                                <input type="number" placeholder="Enter Student Mark" name="mark" min=0 max=100>
                            </div>
                            <button class="nextBtn" name="save_btn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 350px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #909290; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                                <span class="btnText">SAVE STUDENT ACADEMIC RECORDS</span>
                                <i class="uil uil-save"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="details personal">
                    <div class="details personal">
                        <span class="title">Add Student Activities And Responsibilities</span>

                        <div class="fields">
                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                                <label>Existing Student</label>
                                <select name="select_existstudent" required>
                                    <option disabled selected>Select Student</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM STUDENT ORDER BY NAME");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["STUD_ID"] . '">' . strtoupper($row["NAME"]) . ' ' . strtoupper($row['STUD_ID']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 6 - 10px);">
                                <label>Class</label>
                                <select name="class" required>
                                    <option disabled selected>Select Class</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM CLASS ORDER BY CLASS");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["CLASS"] . '">' . strtoupper($row["CLASS_TITLE"])  . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 3 - 10px);">
                                <label>Activities</label>
                                <input type="text" placeholder="Enter Student Activities" name="stu_act">
                            </div>
                            <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 3 - 10px);">
                                <label>Responsibilities</label>
                                <input type="text" placeholder="Enter Student Responsibilities" name="stu_resp">
                            </div>
                            <button class="nextBtn" name="save_act_btn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 350px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #909290; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                                <span class="btnText">SAVE STUDENT ACTIVITIES RECORDS</span>
                                <i class="uil uil-save"></i>
                            </button>
                            <button class="nextBtn" name="save_resp_btn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 450px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #909290; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                                <span class="btnText">SAVE STUDENT  RESPONSIBILITIES RECORDS</span>
                                <i class="uil uil-save"></i>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="buttons" style="display: flex; align-items: center;">
                    <button id="showcompanyBtn" type="button" class="backBtn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 250px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #909290; transition: all 0.3s linear; cursor: pointer;">
                        <span class="btnText" style="font-size: 15px; color: white; text-decoration: none;">
                            GENERATE TRANSCRIPT
                        </span>
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
        </form>
        <div class="footer">
            <p style="font-size: 19px; color: #909290; flex-basis: 100%; font-weight: bold">Developed and Powered By Nifty ICT Solutions Ltd</p>
            <p style="font-size: 19px; color: #909290; flex-basis: 100%; font-weight: bold">Phone: +2209067411 | Website: www.niftyict.com | Email: enquiries@niftyict.com</p>
        </div>
    </div>

    <?php

    if (isset($_POST['save_act_btn'])) {
        if (isset($_POST['select_existstudent'])) {
            if (($_POST['stu_act']) != '') {
               $sql = oci_parse($conn,"SELECT * FROM STUDENT_ACTIVITIES WHERE STUD_ID = :ID ");
               oci_bind_by_name($sql,":ID",$_POST['select_existstudent']);
               oci_execute($sql);
               if(oci_fetch_all($sql,$a)>0){
                  $sql = oci_parse($conn,"UPDATE STUDENT_ACTIVITIES SET ACT =:ACT WHERE STUD_ID =:ID ");
                  oci_bind_by_name($sql,":ID",$_POST['select_existstudent']);
                  $act = strtoupper($_POST['stu_act']);
                  oci_bind_by_name($sql,":ACT",$act);
                if(oci_execute($sql)){
                    echo "<script> Swal.fire({
                        title: 'STUDENT ACTIVITIES RECORD SAVED SUCCESSFULLY',
                        icon: 'success',
                        showConfirmButton: true
                    });</script>";
                }else {
                    echo "<script> Swal.fire({
                        title: 'ERROR ADDING STUDENT ACTIVITIES RECORD',
                        icon: 'error',
                        showConfirmButton: true
                    });</script>";
                }
               }else {
                $sql = oci_parse($conn,"INSERT INTO STUDENT_ACTIVITIES (S_ID,STUD_ID,ACT) VALUES (:S_ID,:ID,:ACT) ");
                oci_bind_by_name($sql,":ID",$_POST['select_existstudent']);
                $act = strtoupper($_POST['stu_act']);
                oci_bind_by_name($sql,":ACT",$act);
                oci_bind_by_name($sql,":S_ID",$sid);
              if(oci_execute($sql)){
                  echo "<script> Swal.fire({
                      title: 'STUDENT ACTIVITIES RECORD SAVED SUCCESSFULLY',
                      icon: 'success',
                      showConfirmButton: true
                  });</script>";
              }else {
                  echo "<script> Swal.fire({
                      title: 'ERROR ADDING STUDENT ACTIVITIES RECORD',
                      icon: 'error',
                      showConfirmButton: true
                  });</script>";
              }
               }

            } else {
                echo "<script> Swal.fire({
                    title: 'ENTER STUDENT ACTIVITIES',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                title: 'SELECT STUDENT',
                icon: 'warning',
                showConfirmButton: true
            });</script>";
        }
    }

    if (isset($_POST['save_btn'])) {

        if (isset($_POST['select_exist_student'])) {
            $id = strtoupper(trim($_POST['select_exist_student']));
            if (isset($_POST['select_term'])) {
                if (isset($_POST['select_class'])) {
                    if (isset($_POST['select_subject'])) {
                        if ($_POST['mark'] != '') {
                            $mark = floatval($_POST['mark']);
                            $emp_id = 20240726221;
                            $ca = $mark * 0.3;
                            $exam = $mark * 0.7;
                            $total = $exam + $ca;

                            $sql = oci_parse($conn, "SELECT * FROM TERM_CALENDAR WHERE TERM =:TERM");
                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                            oci_execute($sql);

                            while ($get = oci_fetch_array($sql)) {
                                $acad_year = $get['ACADEMIC_YEAR'];
                            }

                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_EVALUATION WHERE SUB_CODE=:SUB_CODE AND CLASS_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM");
                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                            oci_bind_by_name($sql, ":ID", $id);
                            oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) > 0) {
                                $sql = oci_parse($conn, "UPDATE STUDENT_EVALUATION SET CONST_ASS = :CA,EXAM=:EXAM, ENTRY_DT = SYSDATE,EMP_ID=:EMP_ID WHERE SUB_CODE=:SUB_CODE AND CLASS_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM ");
                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                oci_bind_by_name($sql, ":ID", $id);
                                oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                oci_bind_by_name($sql, ":EMP_ID", $emp_id);
                                oci_bind_by_name($sql, ":CA", $ca);
                                oci_bind_by_name($sql, ":EXAM", $exam);
                                if (oci_execute($sql)) {

                                    $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                    oci_execute($getgrade);

                                    while ($b = oci_fetch_array($getgrade)) {
                                        $g_code = $b["G_CODE"];
                                        $grade = $b["GRADE"];
                                    }

                                    $sql = oci_parse($conn, "SELECT * FROM STUDENT_CUMULATIVE WHERE SUBJ_CODE=:SUB_CODE AND SUB_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM");
                                    oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                    oci_bind_by_name($sql, ":ID", $id);
                                    oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                    oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                    oci_execute($sql);

                                    if (oci_fetch_all($sql, $a) > 0) {
                                        $sql = oci_parse($conn, "UPDATE STUDENT_CUMULATIVE SET MARK =:MARK,ENTRY_DT = SYSDATE, G_CODE= :G_CODE WHERE SUBJ_CODE=:SUB_CODE AND SUB_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM");
                                        oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                        oci_bind_by_name($sql, ":ID", $id);
                                        oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                        oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                        oci_bind_by_name($sql, ":MARK", $total);
                                        oci_bind_by_name($sql, ":G_CODE", $g_code);

                                        if (oci_execute($sql)) {
                                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE TERM = :TERM AND STUD_ID = :ID AND CLASS_CODE =:CLASS_CODE");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);

                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) > 0) {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "UPDATE STUDENT_STANDINGS SET GPA = :GPA , AVERAGE=:AVERAGE WHERE STUD_ID=:ID AND TERM =:TERM AND CLASS_CODE =:CLASS_CODE ");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                                oci_bind_by_name($sql, ":AVERAGE", $avg);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            } else {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }

                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (CLASS_CODE,GPA,AVERAGE,STUD_ID,TERM,ACADEMIC_YEAR,S_ID,STATUS) VALUES (:CLASS_CODE,:GPA,:AVERAGE,:ID,:TERM,:A_Y,:S_ID,'COMPILED')");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                                oci_bind_by_name($sql, ":AVERAGE", $avg);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":S_ID", $sid);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":A_Y", $acad_year);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            }
                                        } else {
                                            echo "<script> Swal.fire({
                                                title: 'ERROR SAVING RECORD',
                                                icon: 'error',
                                                showConfirmButton: true
                                            });</script>";
                                        }
                                    } else {
                                        $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                        oci_execute($getgrade);

                                        while ($b = oci_fetch_array($getgrade)) {
                                            $g_code = $b["G_CODE"];
                                            $grade = $b["GRADE"];
                                        }
                                        $sql = oci_parse($conn, "INSERT INTO STUDENT_CUMULATIVE(S_ID,SUB_CODE,G_CODE,SUBJ_CODE,ACADEMIC_YEAR,TERM,STUD_ID,MARK,ENTRY_DT) VALUES (:S_ID,:CLASS_CODE,:G_CODE,:SUB_CODE,:A_Y,:TERM,:STUD_ID,:MARK,SYSDATE)");
                                        oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                        oci_bind_by_name($sql, ":STUD_ID", $id);
                                        oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                        oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                        oci_bind_by_name($sql, ":A_Y", $acad_year);
                                        oci_bind_by_name($sql, ":MARK", $total);
                                        oci_bind_by_name($sql, ":G_CODE", $g_code);
                                        oci_bind_by_name($sql, ":G_CODE", $g_code);
                                        oci_bind_by_name($sql, ":S_ID", $sid);
                                        if (oci_execute($sql)) {
                                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE TERM = :TERM AND STUD_ID = :ID AND CLASS_CODE =:CLASS_CODE");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);

                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) > 0) {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE ");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "UPDATE STUDENT_STANDINGS SET GPA = :GPA , AVERAGE=:AVERAGE WHERE STUD_ID=:ID AND TERM =:TERM AND CLASS_CODE =:CLASS_CODE ");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                                oci_bind_by_name($sql, ":AVERAGE", $avg);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            } else {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (CLASS_CODE,GPA,AVERAGE,STUD_ID,TERM,ACADEMIC_YEAR,S_ID,STATUS) VALUES (:CLASS_CODE,:GPA,:AVERAGE,:ID,:TERM,:A_Y,:S_ID,'COMPILED')");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                                oci_bind_by_name($sql, ":AVERAGE", $avg);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":S_ID", $sid);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":A_Y", $acad_year);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    echo "<script> Swal.fire({
                                                    title: 'ERROR SAVING RECORD',
                                                    icon: 'error',
                                                    showConfirmButton: true
                                                });</script>";
                                }
                            } else {
                                $sql = oci_parse($conn, "INSERT INTO STUDENT_EVALUATION (S_ID,SUB_CODE,STUD_ID,EMP_ID,ACADEMIC_YEAR,TERM,CONST_ASS,EXAM,ENTRY_DT,CLASS_CODE,MARK_STATUS) 
                                     VALUES (:S_ID,:SUB_CODE,:ID,:EMP_ID,:A_Y,:TERM,:CA,:EXAM,SYSDATE,:CLASS_CODE,'ACCEPTED')");
                                oci_bind_by_name($sql, ":ID", $id);
                                oci_bind_by_name($sql, ":S_ID", $sid);
                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                oci_bind_by_name($sql, ":A_Y", $acad_year);
                                oci_bind_by_name($sql, ":EMP_ID", $emp_id);
                                oci_bind_by_name($sql, ":CA", $ca);
                                oci_bind_by_name($sql, ":EXAM", $exam);
                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                if (oci_execute($sql)) {
                                    $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                    oci_execute($getgrade);

                                    while ($b = oci_fetch_array($getgrade)) {
                                        $g_code = $b["G_CODE"];
                                        $grade = $b["GRADE"];
                                    }
                                    $sql = oci_parse($conn, "INSERT INTO STUDENT_CUMULATIVE(S_ID,SUB_CODE,G_CODE,SUBJ_CODE,ACADEMIC_YEAR,TERM,STUD_ID,MARK,ENTRY_DT) VALUES (:S_ID,:CLASS_CODE,:G_CODE,:SUB_CODE,:A_Y,:TERM,:STUD_ID,:MARK,SYSDATE)");
                                    oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                    oci_bind_by_name($sql, ":STUD_ID", $id);
                                    oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                    oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                    oci_bind_by_name($sql, ":A_Y", $acad_year);
                                    oci_bind_by_name($sql, ":MARK", $total);
                                    oci_bind_by_name($sql, ":G_CODE", $g_code);
                                    oci_bind_by_name($sql, ":S_ID", $sid);
                                    if (oci_execute($sql)) {
                                        $sql = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE TERM = :TERM AND STUD_ID = :ID AND CLASS_CODE =:CLASS_CODE");
                                        oci_bind_by_name($sql, ":ID", $id);
                                        oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                        oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);

                                        oci_execute($sql);
                                        if (oci_fetch_all($sql, $a) > 0) {
                                            $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE ");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $avg = $get['AVERAGE'];
                                            }
                                            $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                            oci_execute($getgrade);

                                            while ($b = oci_fetch_array($getgrade)) {
                                                $g_code = $b["G_CODE"];
                                                $grade = $b["GRADE"];
                                            }

                                            $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                            oci_bind_by_name($sql, ":G_CODE", $g_code);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $gpa = $get['GPA'];
                                            }

                                            $sql = oci_parse($conn, "UPDATE STUDENT_STANDINGS SET GPA = :GPA , AVERAGE=:AVERAGE WHERE STUD_ID=:ID AND TERM =:TERM AND CLASS_CODE =:CLASS_CODE ");
                                            oci_bind_by_name($sql, ":GPA", $gpa);
                                            oci_bind_by_name($sql, ":AVERAGE", $avg);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            if (oci_execute($sql)) {
                                                echo "<script> Swal.fire({
                                                            title: 'RECORD SAVED SUCCESSFULLY',
                                                            icon: 'success',
                                                            showConfirmButton: true
                                                        });</script>";
                                            } else {
                                                echo "<script> Swal.fire({
                                                            title: 'ERROR SAVING RECORD',
                                                            icon: 'error',
                                                            showConfirmButton: true
                                                        });</script>";
                                            }
                                        } else {
                                            $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $avg = $get['AVERAGE'];
                                            }
                                            $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                            oci_execute($getgrade);

                                            while ($b = oci_fetch_array($getgrade)) {
                                                $g_code = $b["G_CODE"];
                                                $grade = $b["GRADE"];
                                            }

                                            $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                            oci_bind_by_name($sql, ":G_CODE", $g_code);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $gpa = $get['GPA'];
                                            }

                                            $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (CLASS_CODE,GPA,AVERAGE,STUD_ID,TERM,ACADEMIC_YEAR,S_ID,STATUS) VALUES (:CLASS_CODE,:GPA,:AVERAGE,:ID,:TERM,:A_Y,:S_ID,'COMPILED')");
                                            oci_bind_by_name($sql, ":GPA", $gpa);
                                            oci_bind_by_name($sql, ":AVERAGE", $avg);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":S_ID", $sid);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":A_Y", $acad_year);
                                            if (oci_execute($sql)) {
                                                echo "<script> Swal.fire({
                                                            title: 'RECORD SAVED SUCCESSFULLY',
                                                            icon: 'success',
                                                            showConfirmButton: true
                                                        });</script>";
                                            } else {
                                                echo "<script> Swal.fire({
                                                            title: 'ERROR SAVING RECORD',
                                                            icon: 'error',
                                                            showConfirmButton: true
                                                        });</script>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<script> Swal.fire({
                                                title: 'ERROR SAVING RECORD',
                                                icon: 'error',
                                                showConfirmButton: true
                                            });</script>";
                                }
                            }
                        } else {
                            echo "<script> Swal.fire({
                                                    title: 'ENTER MARK',
                                                    icon: 'warning',
                                                    showConfirmButton: true
                                                });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                                            title: 'SELECT SUBJECT',
                                            icon: 'warning',
                                            showConfirmButton: true
                                        });</script>";
                    }
                } else {
                    echo "<script> Swal.fire({
                                title: 'SELECT CLASS',
                                icon: 'warning',
                                showConfirmButton: true
                            });</script>";
                }
            } else {
                echo "<script> Swal.fire({
                            title: 'SELECT TERM',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                    title: 'SELECT STUDENT',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
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
</body>

</html>