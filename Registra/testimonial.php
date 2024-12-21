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
    $stu_name = $_SESSION['student_name']
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
        <div class="com" style="
    vertical-align: middle;
    text-align: center;
    justify-content: center;
    align-items: center;">
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
            ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px; align-items: center;"><?php

                                                                                                    echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">'; ?></td> <?php
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                            ?>
        </div>
        <div class="buttons">
            <button class="backBtn" style="width: 150px;">
                <a class="btnText" href="registra" style="font-size: 15px; color: white; text-decoration: none;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px; color: white;"></i>
                </a>
            </button>
        </div>
        <header>Testimonial</header>
        <form method="POST" action="testimonial" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Create Testimonial</span>
                    <div class="fields">
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 5 - 10px);">
                            <label>Existing Student</label>

                            <select name="student" required style="width: 400px; max-width: 100%;">
                                <option value="" disabled selected>Select Student</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM STUDENT WHERE NAME LIKE '%$stu_name%' ORDER BY NAME");
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
                            <label>Date Of Leaving</label>

                            <input type="text" placeholder="Enter Date Of Leaving" name="date_of_leaving" style="width: 400px; max-width: 100%;" required>

                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 5 - 10px);">
                            <label>Attendance</label>

                            <input type="text" placeholder="Enter Attendance" name="attendance" style="width: 400px; max-width: 100%;" required>

                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                            <label>Conduct</label>

                            <input type="text" placeholder="Enter Conduct" required name="conduct" style="width: 400px; max-width: 100%;">

                        </div>

                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                            <label>Position Held</label>
                            <input type="text" placeholder="Enter Position Held" required name="position_held" style="width: 400px; max-width: 100%;">
                        </div>

                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 5 - 10px);">
                            <label>Iniative</label>
                            <input type="text" placeholder="Enter Iniative" name="iniative" required style="width: 400px; max-width: 100%;">
                        </div>

                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 5 - 10px);">
                            <label>Class Teacher</label>
                            <select name="teacher" required style="width: 400px; max-width: 100%;">
                                <option disabled selected>Select Last Class Teacher</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM EMPLOYEE ORDER BY FIRSTNAME");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option>' . strtoupper($row["FIRSTNAME"]) . ' ' . strtoupper($row['MIDDLENAME']) . ' ' . strtoupper($row['LASTNAME']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>


                    </div>
                </div>

                <div class="details-container" style="display: flex; justify-content: space-between; gap: 30px; margin-top: 20px;">
                    <!-- Academic Performance Section -->
                    <div class="details personal" style="flex: 1; max-width: 100%;">
                        <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <span class="title" style="font-size: 18px; font-weight: bold; color: #333;">Academic Performance And Attainment</span>
                            <div class="fields" style="margin-top: 15px;">
                                <textarea name="academic" required placeholder="Enter academic performance details here..." style="width: 100%; height: 200px; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; resize: none;"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Extracurricular Activities Section -->
                    <div class="details personal" style="flex: 1; max-width: 100%;">
                        <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <span class="title" style="font-size: 18px; font-weight: bold; color: #333;">Extracurricular Activities</span>
                            <div class="fields" style="margin-top: 15px;">
                                <textarea name="extra" placeholder="Enter extracurricular activities details here..." style="width: 100%; height: 200px; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons" style="display: flex; align-items: center; gap: 10px;">

                    <button class="nextBtn" name="gen_testimonial" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 450px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #909290;; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                        <span class="btnText">GENERATE TESTIMONIAL</span>
                        <i class="uil uil-save"></i>
                    </button>
                </div>


        </form>
        <div class="footer">
            <p style="font-size: 19px; color: #909290;; flex-basis: 100%; font-weight: bold">Developed and Powered By Nifty ICT Solutions Ltd</p>
            <p style="font-size: 19px; color: #909290;; flex-basis: 100%; font-weight: bold">Phone: +2209067411 | Website: www.niftyict.com | Email: enquiries@niftyict.com</p>
        </div>
    </div>

    <?php
    require '../vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    if (isset($_POST['gen_testimonial'])) {

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
            $saveDirectory = 'C:/wamp64/www/Academix/KSSS/Registra/img/';
            $fileName = "school logo.jpg";
        }
        $logoPath = 'img/school logo.png';
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = 'data:image/png;base64,' . $logoData;

        $companyInfo = "$address\n$district\nREGION\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";

        $schoolName = $school;
        $schoolAddress = $address . ',' .  $district . ' MUNICIPAL COUNCIL' . $region;
        $contactInfo = $phone_one . " | " . $phone_two . " | " . $email;
        $sql = "SELECT 
        A.NAME, A.STDNUMBER, A.STUD_ID, 
        B.DOB, 
        C.ACADEMIC_YEAR,
        D.CLASS_NAME,
        P.PROG, 
        B.RELIGION,
        A.CREATE_DT, 
        G.PASS_PHOTO, 
        F.FIRSTNAME, F.MIDDLENAME, F.LASTNAME, 
        B.NATION, B.TRIBE
    FROM STUDENT A
    JOIN STUDENT_PERSONAL B ON A.STUD_ID = B.STUD_ID
    JOIN STUDENT_ACADEMIC C ON A.STUD_ID = C.STUD_ID
    JOIN STUDENT_AUTHOURITY F ON A.STUD_ID = F.STUD_ID
    JOIN STUDENT_DOCUMENT G ON A.STUD_ID = G.STUD_ID
    JOIN SUB_CLASS D ON C.SUB_CODE = D.SUB_CODE
    JOIN PROG_CLASS E ON D.SUB_CODE = E.SUB_CODE
    JOIN PROGRAMME P ON E.PROG_ID = P.PROG_ID
    WHERE A.STUD_ID = :student_id";

        // Prepare and bind the variable
        $sql_student = oci_parse($conn, $sql);
        $student_id = $_POST['student'];
        oci_bind_by_name($sql_student, ':student_id', $student_id);

        oci_execute($sql_student);
        while ($row_data = oci_fetch_array($sql_student)) {
            $student_name = $row_data['NAME'];
            $nation = $row_data['NATION'];
            $admissionNo = $row_data['STUD_ID'];
            $admyr = $row_data['ACADEMIC_YEAR'];
            $admclass = $row_data['CLASS_NAME'];
            $religion = $row_data['RELIGION'];
            $tribe = $row_data['TRIBE'];
            $dob = $row_data['DOB'];
            $passPhotoBlob = $row_data['PASS_PHOTO']->load();
            $passPhotoBase64 = base64_encode($passPhotoBlob);
            $prog = $row_data['PROG'];
        }

        $dateleave = strtoupper($_POST['date_of_leaving']);
        $attendance = strtoupper($_POST['attendance']);
        $academic = strtoupper($_POST['academic']);
        $conduct = strtoupper($_POST['conduct']);
        $position = strtoupper($_POST['position_held']);
        $initiative = strtoupper($_POST['iniative']);
        $extra = strtoupper($_POST['extra']);
        $teacher = strtoupper($_POST['teacher']);

        $getlastclass = oci_parse($conn, "SELECT DISTINCT (B.CLASS_NAME)  FROM STUDENT_EVALUATION A JOIN SUB_CLASS B ON (A.CLASS_CODE=B.SUB_CODE) WHERE A.STUD_ID =:id ORDER BY B.CLASS_NAME DESC ");
        oci_bind_by_name($getlastclass, ':id', $student_id);
        oci_execute($getlastclass);
        if ($row_data = oci_fetch_array($getlastclass)) {
            $lastclass = $row_data['CLASS_NAME'];
        }
        $getsubjects = oci_parse($conn, "SELECT DISTINCT (SUBJECT) FROM STUDENT_EVALUATION A JOIN WAEC_SUBJECT B ON (A.SUB_CODE=B.SUB_CODE) WHERE A.STUD_ID = :id");
        oci_bind_by_name($getsubjects, ':id', $student_id);
        oci_execute($getsubjects);

        while ($subjectRow = oci_fetch_array($getsubjects)) {
            $subjectsHTML .= '' . htmlspecialchars($subjectRow['SUBJECT']) . ' ';
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);  // Enable HTML5 parsing
        $dompdf = new Dompdf($options);
        $dt = date('Y-m-d');
        // Register custom fonts
        //  $dompdf->getOptions()->setFont('AntonSC', 'path/to/lib/fonts/AntonSC-Regular.ttf');
        // $dompdf->getOptions()->setFont('DancingScript', 'path/to/lib/fonts/DancingScript-Regular.ttf');
        //$dompdf->getOptions()->setFont('Roboto', 'path/to/lib/fonts/Roboto-Regular.ttf');

        // Load HTML content
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Testimonial</title>
            <style>
                /* Importing the fonts */
                @font-face {
                    font-family: 'AntonSC';
                    src: url('D:/Senior/Registra/tcpdf/fonts/AntonSC-Regular.ttf');
                }
                @font-face {
                    font-family: 'DancingScript';
                    src: url('D:/Senior/Registra/tcpdf/fonts/DancingScript-Regular.ttf');
                }
                @font-face {
                    font-family: 'Roboto';
                    src: url('D:/Senior/Registra/tcpdf/fonts/Roboto-Regular.ttf');
                }
        
                /* General body styles */
                body {
                    font-family: 'Roboto', sans-serif;
                  
                    margin: 0;
                    padding: 0;
                    color: #333;
                    line-height: 1.6;
                }
        
                /* Container for the testimonial */
                .container {
                    width: 80%;
                    margin: 10px auto;
                    padding: 10px;
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }
        
                /* Header Section */
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
        
                .header h1 {
                    font-family: 'AntonSC', sans-serif;
                    color: #2c3e50;
                    font-size: 13px;
                    letter-spacing: 2px;
                }
        
                .header p {
                    font-size: 10px;
                    color: #7f8c8d;
                    margin-top: 5px;
                }
                .student-details {
            margin-top: 20px;
            padding: 10px;
            border: 2px solid #2980b9;
            border-radius: 3px;
            background-color: #ecf0f1;
        }
                .student-photo {
                width: 100px; /* Set photo width */
                height: 100px; /* Set photo height */
                border-radius: 50%; /* Make the photo circular */
                border: 2px solid #000; /* Optional: Add a border */
                margin-right: 15px; /* Add space between the photo and text */
                object-fit: cover; /* Ensure the image fits properly */
            }
        .student-details h3 {
            font-family: 'DancingScript', cursive;
            font-size: 13px;
            color: #2980b9;
            text-align: center;
            margin-bottom: 10px;
        }

        .student-details p {
            font-size: 10px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 10px;
        }

        .student-details .highlight {
            font-weight: bold;
            color: #2980b9;
        }

        .subject-list {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .subject-list h3 {
            margin-bottom: 10px;
            color: #2980b9;
            font-size: 14px;
            font-weight: bold;
        }
        .subject-list ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .subject-list li {
            font-size: 12px;
            color: #555;
            margin-bottom: 5px;
        }
                /* Title */
                .title {
                    text-align: center;
                    font-size: 21px;
                    font-family: 'DancingScript', cursive;
                    color: #2980b9;
                    margin-top: 10px;
                    text-decoration: underline;
                    letter-spacing: 1px;
                }
        
                /* Content Section */
                .content {
                    font-size: 15px;
                    margin-top: 15px;
                    line-height: 1.8;
                    color: #555;
                }
        
                .content p {
                    margin-bottom: 15px;
                }
        
                .highlight {
                    font-weight: bold;
                    color: #2980b9;
                }
        
                            .container {
                display: flex;
                justify-content: space-between;
                align-items: center; /* Aligns items vertically if heights differ */
            }

                /* Signature Section */
                .classteacher {
                    text-align: left;
                    font-family: 'DancingScript';
                    margin-top: 50px;
                    font-size: 10px;
                    color: #2c3e50;
                }
                .signature {
                    text-align: right;
                    font-family: 'DancingScript';
                    margin-top: 50px;
                    font-size: 10px;
                    color: #2c3e50;
                }
        
                .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #aaa;
                    margin-top: 30px;
                }
        
                .footer a {
                    color: #aaa;
                    text-decoration: none;
                }
        
                .footer a:hover {
                    text-decoration: underline;
                }
        
                /* Border Boxes for emphasis */
                .border-box {
                    padding: 15px;
                    border: 2px solid #2980b9;
                    border-radius: 8px;
                    background-color: #ecf0f1;
                    margin-bottom: 20px;
                }
        
                .border-box p {
                    margin: 0;
                    font-size: 16px;
                    color: #2c3e50;
                }
        
                /* Responsive media query (adjustments for smaller screens) */
                @media screen and (max-width: 768px) {
                    .container {
                        width: 95%;
                    }
                    .header h1 {
                        font-size: 30px;
                    }
                    .title {
                        font-size: 22px;
                    }
                }
            </style>
        </head>
        <body>
        
            <div class="container">
                <!-- Header -->
                <div class="header">
                    <h1>$schoolName</h1>
                    <img src="$logoBase64" alt="School Logo" style="width: 100px; height: 100px;">
                    <p>$schoolAddress</p>
                    <p>$contactInfo</p>
                </div>
        
                <!-- Title -->
                <div class="title">TESTIMONIAL</div>
                <div class="student-details">
                    <h3>GENERAL STUDENT INFORMATION</h3>
                    <img class="student-photo" src="data:image/jpg;base64,$passPhotoBase64" alt="Student Photo">
                    <p><strong>Name:</strong> <span class="highlight">$student_name</span></p>
                    <p><strong>Student ID:</strong> <span class="highlight">$admissionNo</span></p>
                    <p><strong>Date Of Birth:</strong> <span class="highlight">$dob</span></p>
                    <p><strong>Tribe:</strong> <span class="highlight">$tribe</span></p>
                    <p><strong>Nationality:</strong> <span class="highlight">$nation</span></p>
                    <p><strong>Religion:</strong> <span class="highlight">$religion</span></p>
                    <p><strong>Admission Year:</strong> <span class="highlight">$admyr</span></p>
                    <p><strong>Class Admitted:</strong> <span class="highlight">$admclass</span></p>
                    <p><strong>Class Attained:</strong> <span class="highlight">$lastclass</span></p>
                    <p><strong>Date Of Leaving:</strong> <span class="highlight">$dateleave</span></p>
                    <p><strong>Attendance:</strong> <span class="highlight">$attendance</span></p>
                    <p><strong>Subjects Attained In Final Year:  </strong> <span class="highlight"> $subjectsHTML </span></p>
                </div>

                <div style="page-break-before: always;"></div>
                
                <div class="student-details">
                    <h3>ACADEMIC PERFORMANCE AND ATTAINMENT</h3>
                    <p><span class="highlight">$academic</span></p>
                </div>

                <div class="student-details">
                    <h3>CHARACTER REFERENCE</h3>
                    <p><strong>CONDUCT: </strong> <span class="highlight">$conduct</span></p>
                    <p><strong>POSITION HELD:</strong> <span class="highlight">$position</span></p>
                    <p><strong>INITIATIVE :</strong> <span class="highlight">$initiative</span></p>
                </div>

                <div class="student-details">
                    <h3>EXTRA CURRICULAR ACTIVITES</h3>
                    <p><span class="highlight">$extra</span></p>
                </div>

                </div>
                <!-- Content with Highlights and Border Box
                 
                <div class="content">
                    <div class="border-box">
                        <p>This is to certify that <span class="highlight">John Doe</span>, Admission No. <span class="highlight">AD12345</span>,
                        was a student of <span class="highlight">Grade 12</span> at our institution from <span class="highlight">2015 to 2024</span>.
                        During this period, John has shown <span class="highlight">excellent performance</span> in academics and extracurricular activities. 
                        He is <span class="highlight">polite</span>, <span class="highlight">disciplined</span>, and <span class="highlight">hardworking</span>,
                        making him a role model for others.</p>
                    </div>
        
                    <div class="border-box">
                        <p>We are confident that <span class="highlight">John Doe</span> will achieve great success in future endeavors,
                        and we wish him all the best in his career and personal growth.</p>
                    </div>
                </div>
            -->
                
        
                            <div class="con">
                                <div class="classteacher">
                                    <strong>LAST CLASS TEACHER</strong><br>
                                    $teacher
                                </div>

                                <div class="signature">
                                    <strong>PRINCIPAL</strong><br>
                                    MR. JOHNSON O. OGUNJOBI
                                </div>
                </div>
                
             
        
                <!-- Footer -->
                <div class="footer">
                    Generated on: $dt
                </div>
            </div>
        
        </body>
        </html>
        HTML;


        // Load HTML into DOMPDF

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $filename = strtoupper(trim($student_id) . '_' . $student_name);
        $filePath = 'D:/Senior/Transcript/TRANSCRIPT.pdf';
        file_put_contents($filePath, $dompdf->output());
        $_SESSION['school'] = $school;
        $_SESSION['class_name'] = $class_name;

        $_SESSION['path'] = $filePath;
        $_SESSION['filename'] = $filename . ' TESTIMONIAL.pdf';

        $_SESSION['redirect'] = 'testimonial.php';
        header('Location: download_pdf.php');
    }
    if (isset($_POST['gen_transcript'])) {
        if (isset($_POST['student'])) {
            if ($_POST['comments'] != '') {

                $comments = strtoupper($_POST['comments']);
                $student_id = $_POST['student'];
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $dompdf = new Dompdf($options);
                $dompdf->setPaper('letter', 'landscape');

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
                    $saveDirectory = 'C:/wamp64/www/Academix/KSSS/Registra/img/';
                    $fileName = "school logo.jpg";
                }
                $logoPath = 'img/school logo.png';
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoBase64 = 'data:image/png;base64,' . $logoData;

                $companyInfo = "$address\n$district\nREGION\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                // Fetch student information=
                $sql_student = oci_parse($conn, "SELECT A.NAME,A.STDNUMBER,A.STUD_ID ,G.DOB, F.PROG, A.CREATE_DT,G.PASS_PHOTO,F.FIRSTNAME,F.MIDDLENAME,F.LASTNAME
                FROM STUDENT A
                JOIN STUDENT_PERSONAL G ON (A.STUD_ID=G.STUD_ID)
                JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID)
                JOIN STUDENT_AUTHOURITY F ON (A.STUD_ID=F.STUD_ID)
                JOIN STUDENT_DOCUMENT G ON (A.STUD_ID=G.STUD_ID)
                JOIN SUB_CLASS D ON (C.SUB_CODE=D.SUB_CODE)
                JOIN PROG_CLASS E ON (D.SUB_CODE=E.SUB_CODE)
                JOIN PROGRAMME F ON (E.PROG_ID=F.PROG_ID)
                WHERE A.STUD_ID = '$student_id'");

                oci_execute($sql_student);

                if ($row_student = oci_fetch_array($sql_student)) {
                    $student_name = $row_student['NAME'];
                    if ($row_student['STDNUMBER'] != '') {
                        $stid = $row_student['STDNUMBER'];
                    } else {
                        $stid = $row_student['STUD_ID'];
                    }
                    $passPhotoBlob = $row_student['PASS_PHOTO']->load();

                    $parent = $row_student['FIRSTNAME'] . '' . $row_student['MIDDLENAME'] . '' . $row_student['LASTNAME'];

                    $passPhotoBase64 = base64_encode($passPhotoBlob);
                    $dob = $row_student['DOB'];
                    $prog = $row_student['PROG'];
                    $create_dt = $row_student['CREATE_DT'];

                    // Fetch academic records
                    $sql_academic = oci_parse($conn, "SELECT DISTINCT TERM,CLASS_NAME FROM STUDENT_CUMULATIVE A JOIN SUB_CLASS B ON (A.SUB_CODE=B.SUB_CODE) WHERE STUD_ID = '$student_id' ORDER BY TERM");
                    $dt = date('d/m/Y');
                    oci_execute($sql_academic);

                    if (oci_fetch_all($sql_academic, $a) > 0) {
                        $terms = [];
                        oci_execute($sql_academic);
                        while ($row_academic = oci_fetch_array($sql_academic)) {
                            $terms[] = $row_academic['TERM'];
                            $class[] = $row_academic['CLASS_NAME'];
                        }
                        // Prepare HTML for transcript
                        $html = <<<HTML
                        <head>
                            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                            <link href="https://fonts.googleapis.com/css2?family=Anton+SC&display=swap" rel="stylesheet">
                            <link rel="preconnect" href="https://fonts.googleapis.com">
                            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
                            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
                        </head>
                        <style>
                             @page {
                            size: A4 portrait; /* Set page size to A4 landscape */
                            margin: 5px; /* Reduce page margin to fit more content */
                        }
                            body {
                                font-family: Arial, sans-serif;
                                font-size: 8px;
                            }
                            .transcript {
                                margin: 10px;
                                padding: 10px;
                                border: 3px solid #909290;;
                                box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); /* Blue shadow border */
                            }
                            .header {
                                text-align: center;
                                margin-bottom: 5px;
                            }
                            .roboto-bold-italic {
                                font-family: "Roboto", sans-serif;
                                font-weight: 300;
                                font-style: normal;
                            }
                            .oswald-uniquifier {
                                font-family: "Helvetica", sans-serif;
                                font-optical-sizing: auto;
                                font-weight: bold;
                                font-style: normal;
                                font-size: 8px;
                            }
                            .student-info {
                                font-size: 7px;
                                font-weight: bold;
                                font-family: "Anton SC", sans-serif;
                                font-weight: 400;
                                font-style: normal;
                                text-align: left; /* Align student info to the left */
                            }
                            .school-info {
                                font-size: 9px;
                                font-weight: bold;
                                font-family: "Anton SC", sans-serif;
                                font-weight: 400;
                                font-style: italic;
                                text-align: right; /* Align school info to the right */
                            }
                            .info-container {
                                display: flex;
                                justify-content: space-between;
                            }
                            .academic-record {
                                margin-bottom: 5px;
                            }
                            
                            table {
                                width: 100%;
                                margin-bottom: 5px;
                                box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); 
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                                /* Blue shadow border */
                            }
                        
                            .gpa-table {
                                width: 70%;
                                margin-bottom: 10px;
                                box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); 
                                margin: 0 auto 10px auto; 
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                                /* Blue shadow border */
                            }
                            th {
                                font-weight: bold;
                                border: 1px solid #909290;
                                padding: 5px;
                                font-size: 9px;
                                text-align: left;
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                            }
                            td {
                                font-family: Courier;
                                border: 1px solid #909290;
                                padding: 8px;
                                font-size: 9px;
                                text-align: left;
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                            }
                            .extra-curricular-list {
                                font-size: 7px;
                                list-style-type: disc;
                                margin-left: 20px;
                            }
                            .principal-comment-signature {
                                    margin-top: 20px;
                                    margin-bottom: 5px;
                                }
                                .principal-comment-signature .signature {
                                    margin-top: 20px;
                                    text-align: center;
                                }

                                .footer {
                                margin-top: 20px;
                                margin-bottom: 5px;
                            }
                            .principal-comment-signature .signature {
                                margin-top: 20px;
                                text-align: left;
                            }
                            .page-break {
                                page-break-before: always;
                                
                                height: 0;
                            }
                        </style>
                        
                        <div class="transcript">
                            <div class="header">
                                <h2 style="font-family: 'Baskerville', cursive; font-size: 15px; color: #909290">Transcript</h2>
                                <h3 style="font-family: 'Impact', cursive; font-size: 12px; color: #909290">$school</h3>
                                <img src="$logoBase64" alt="School Logo" style="width: 50px; height: 50px;">
                            </div>
                            <div class="info-container">
                                    <div class="student-info">
                                        <p class="school-info"><strong>$region</strong></p>
                                        <p class="school-info"><strong>$district</strong></p>
                                        <p class="school-info"><strong>$address</strong></p>
                                        <p class="school-info"><strong>$phone_one $phone_two</strong></p>
                                        <p class="school-info"><strong>$email</strong></p>
                                        <p class="school-info"><strong>Date:</strong> $dt</p>
                                        <p class="oswald-uniquifier">
                                        <img src="data:image/jpg;base64,$passPhotoBase64" alt="Student Photo" style="width: 100px; height: 100px; border: 2px solid #909290;"/>
                                        </p>
                                        <p class="oswald-uniquifier"><strong>Student ID:</strong> $stid</p>
                                        <p class="oswald-uniquifier"><strong>Student Name:</strong> $student_name</p>
                                        <p class="oswald-uniquifier"><strong>Date of Birth:</strong> $dob</p>
                                        <p class="oswald-uniquifier"><strong>Programme:</strong> $prog</p>
                                        <p class="oswald-uniquifier"><strong>Entry Date:</strong> $create_dt</p>
                                        <p class="oswald-uniquifier"><strong>Parent/Guardian Name:</strong>$parent</p>
                                    </div>
                                </div>
                            <div class="academic-record">
                                <h3 class="oswald-uniquifier">Academic Records</h3>
                        HTML;

                        // Iterate through academic records for each term
                        foreach ($terms as $index => $term) {
                            $html .= <<<HTML
                                <!-- Page break before each table -->
                                <table>
                                    <thead>
                                        <tr>
                                            <th colspan="7" style="color: #9B0906; font-size: 7px;">Term: $term</th>
                                        </tr>
                                        <tr>
                                            <th colspan="7" style="color: #9B0906; font-size: 7px;">Class: $class[$index]</th>
                                        </tr>
                                        <tr style="font-size: 7px;">
                                            <th>Subject</th>
                                            <th>Total</th>
                                            <th>Grade</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            HTML;

                            $query = "SELECT DISTINCT A.SUBJECT, 
                                                    ROUND(C.CONST_ASS, 0) AS CA, 
                                                    ROUND(C.EXAM, 0) AS EXAM, 
                                                    ROUND(D.MARK,0) AS MARK, 
                                                    F.GRADE, 
                                                    F.INTERPRETATION,
                                                    C.TERM
                                        FROM WAEC_SUBJECT A 
                                        JOIN STUDENT_SUBJECT B ON A.SUB_CODE = B.SUB_CODE 
                                        JOIN STUDENT_EVALUATION C ON B.SUB_CODE = C.SUB_CODE AND B.STUD_ID = C.STUD_ID 
                                        JOIN STUDENT_CUMULATIVE D ON A.SUB_CODE = D.SUBJ_CODE AND D.STUD_ID = C.STUD_ID 
                                        JOIN STUDENT E ON D.STUD_ID = E.STUD_ID 
                                        JOIN GRADE F ON D.G_CODE = F.G_CODE 
                                        WHERE TRIM(C.STUD_ID) = TRIM('$student_id') 
                                            AND TRIM(D.STUD_ID) = TRIM('$student_id') 
                                            AND TRIM(B.STUD_ID) = TRIM('$student_id') 
                                            AND C.TERM = '$term' 
                                            AND D.TERM = '$term' 
                                            AND C.CONST_ASS+C.EXAM=D.MARK
                                            AND C.MARK_STATUS = 'ACCEPTED' 
                                        ORDER BY C.TERM, A.SUBJECT";

                            $sql = oci_parse($conn, $query);
                            oci_execute($sql);

                            while ($row = oci_fetch_array($sql)) {
                                $subject = $row['SUBJECT'];
                                $ca = $row['CA'];
                                $exam = $row['EXAM'];
                                $mark = $row['MARK'];
                                $grade = $row['GRADE'];
                                $remark = $row['INTERPRETATION'];

                                $html .= <<<HTML
                                    <tr>
                                        <td>$subject</td>
                                        <td>$mark</td>
                                        <td>$grade</td>
                                        <td>$remark</td>
                                    </tr>
                            HTML;
                            }

                            $html .= <<<HTML
                                </tbody>
                            </table>
                            HTML;
                            $html .= <<<HTML
                            <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Term</th>
                                            <th>Average</th>
                                            <th>GPA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;
                            // Fetch and add GPA data
                            $getgpa = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE stud_id = '$student_id' and term = '$term' ");
                            oci_execute($getgpa);

                            while ($r = oci_fetch_array($getgpa)) {
                                $term = $r['TERM'];
                                $avg = $r['AVERAGE'];
                                $gpa = $r['GPA'] / 1.00;

                                $html .= <<<HTML
                                        <tr>
                                            <td>$term</td>
                                            <td>$avg</td>
                                            <td>$gpa</td>
                                        </tr>
                            HTML;
                            }

                            $html .= <<<HTML
                                    </tbody>
                                </table>
                            </div>
                            HTML;
                        }

                        $html .= <<<HTML
                        <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>CGPA</th>
                                            <th>AVERAGE</th>
                                            <th>REMARK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;

                        // Fetch and add GPA data
                        $getgpa = oci_parse($conn, "SELECT ROUND(AVG(GPA),2) AS CGPA, ROUND(AVG(AVERAGE),2) AS AVERAGE FROM STUDENT_STANDINGS  WHERE stud_id = '$student_id' ");
                        oci_execute($getgpa);

                        while ($r = oci_fetch_array($getgpa)) {
                            $term = $r['TERM'];
                            $cavg = $r['AVERAGE'];
                            $gpa = $r['CGPA'] / 1.00;

                            $getrm = oci_parse($conn, "SELECT * FROM GRADE A JOIN GPA B ON A.G_CODE = B.G_CODE WHERE B.GPA <= CAST($gpa AS INT) AND CAST($gpa AS INT) <= B.GPA");
                            oci_execute($getrm);
                            while ($r = oci_fetch_array($getrm)) {
                                $rm = $r['INTERPRETATION'];
                            }

                            $html .= <<<HTML
                                        <tr>
                                            <td>$gpa</td>
                                            <td>$cavg</td>
                                            <td>$rm</td>
                                        </tr>
                            HTML;
                        }
                        $html .= <<<HTML
                                            </tbody>
                                        </table>
                                    </div>
                           
                                   <div class="extra-curricular">
                                    <h3 class="oswald-uniquifier">Extra-Curricular Activities</h3>
                                    <p>
                                        <!-- Fetch and display extra-curricular activities -->
                                HTML;

                        // Query to fetch extracurricular activities
                        $activityQuery = "SELECT ACT FROM STUDENT_ACTIVITIES WHERE STUD_ID = '$student_id'";
                        $activitySql = oci_parse($conn, $activityQuery);
                        oci_execute($activitySql);

                        // Fetch activities and add to HTML
                        while ($activityRow = oci_fetch_array($activitySql)) {
                            $activity = $activityRow['ACT'];
                            $html .= "<p>$activity</p>";
                        }



                        $html .= <<<HTML
                                  
                                                </div>
                                                        <div class="student-responsibilities">
                                                            <h3 class="oswald-uniquifier">Student Responsibilities</h3>
                                                            <p>
                                            <!-- Fetch and display student responsibilities -->
                             HTML;

                        // Query to fetch student responsibilities
                        $responsibilityQuery = "SELECT A.RESPON, B.CLASS_TITLE FROM STUDENT_RESPON A JOIN CLASS B ON A.CLASS = B.CLASS WHERE A.STUD_ID = '$student_id' ";
                        $responsibilitySql = oci_parse($conn, $responsibilityQuery);
                        oci_execute($responsibilitySql);

                        // Fetch responsibilities and add to HTML
                        while ($responsibilityRow = oci_fetch_array($responsibilitySql)) {
                            $responsibility = $responsibilityRow['RESPON'];
                            $classTitle = $responsibilityRow['CLASS_TITLE'];
                            $html .= "<p><strong>$classTitle:</strong> $responsibility</p>";
                        }
                        $comments = strtoupper($_POST['comments']);
                        $html .= <<<HTML
                                        </p>
                                        <div class="principal-comment-signature">
                                        <h3>Principal's Comments:</h3>
                                        <p>$comments</p>

                                        <div class="principal-comment-signature">
                            <h3>Principal's Signature:</h3>
                            <p>___________________</p>
                            <h3>School Stamp</h3>
                        </div>
                        <div class="footer" style="font-size: 12px; color: #909290; text-align: center; width: 100%;">
                                <p style="font-size: 8px; color: #909290;">Thank You For Being Part Of $school</p>
                                <p style="font-size: 8px; color: #909290;">Developed and Powered By Nifty ICT Solutions Ltd</p>
                                <p style="font-size: 8px; color: #909290;">Phone: +2209067411 | +2203553291 Website: www.niftyict.com | Email: enquiries@niftyict.com</p>
                         </div>
                                    </div>
                                 
                                    <div class="header">
                                    <div class="page-break"></div>
                            <h2 style="font-family: 'Baskerville', cursive; font-size: 15px; color: #909290">Grading System</h2>
                            <h3 style="font-family: 'Impact', cursive; font-size: 12px; color: #909290">$school</h3>
                            <img src="$logoBase64" alt="School Logo" style="width: 50px; height: 50px;">
                        </div>
                         <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Letter Grade</th>
                                            <th>Grade Range</th>
                                            <th>Interpretation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;

                        // Fetch and add GPA data
                        $getgpa = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON (A.G_CODE = B.G_CODE) ORDER BY END_GRADE_RANGE DESC");
                        oci_execute($getgpa);
                        while ($r = oci_fetch_array($getgpa)) {
                            $lg = $r['GRADE'];
                            $gr = $r['START_GRADE_RANGE'] . '-' . $r['END_GRADE_RANGE'];
                            $in = $r['INTERPRETATION'];

                            $html .= <<<HTML
                                        <tr>
                                            <td>$lg</td>
                                            <td>$gr</td>
                                            <td>$in</td>
                                        </tr>
                            HTML;
                        }
                        $html .= <<<HTML
                                    </tbody>
                                </table>
                            </div>
                            <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Letter Grade</th>
                                            <th>GPA</th>
                                            <th>Interpretation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;

                        // Fetch and add GPA data
                        $getgpa = oci_parse($conn, "SELECT * FROM GRADE A JOIN GPA  B ON (A.G_CODE = B.G_CODE) ORDER BY GPA DESC");
                        oci_execute($getgpa);
                        while ($r = oci_fetch_array($getgpa)) {
                            $lg = $r['GRADE'];
                            $gr = $r['GPA'] / 1.00;
                            $in = $r['INTERPRETATION'];

                            $html .= <<<HTML
                                        <tr>
                                            <td>$lg</td>
                                            <td>$gr</td>
                                            <td>$in</td>
                                        </tr>
                            HTML;
                        }
                        $html .= <<<HTML
                                        </tbody>
                                    </table>
                      
                    
                        </div>
                        <div class="footer" style="font-size: 12px; color: #909290; text-align: center; width: 100%;">
                                <p style="font-size: 8px; color: #909290;">Thank You For Being Part Of $school</p>
                                <p style="font-size: 8px; color: #909290;">Developed and Powered By Nifty ICT Solutions Ltd</p>
                                <p style="font-size: 8px; color: #909290;">Phone: +2209067411 | +2203553291 Website: www.niftyict.com | Email: enquiries@niftyict.com</p>
                         </div>
                        HTML;

                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($html);

                        // (Optional) Setup the paper size and orientation
                        $dompdf->setPaper('A4', 'portrait');

                        // Render the HTML as PDF
                        $dompdf->render();

                        $filename = strtoupper(trim($stid) . '_' . $student_name);
                        $filePath = 'D:/Senior/Transcript/TRANSCRIPT_' . $filename . '.pdf';
                        file_put_contents($filePath, $dompdf->output());
                        $_SESSION['school'] = $school;
                        $_SESSION['class_name'] = $class_name;

                        $_SESSION['path'] = $filePath;
                        $_SESSION['filename'] = $filename . '.pdf';

                        $_SESSION['redirect'] = 'transcript.php';
                        header('Location: download_pdf.php');
                        // Success message
                        echo '<script>
    Swal.fire({
    position: "center",
    icon: "success",
    title: "TRANSCRIPT GENERATED SUCCESSFULLY",
    showConfirmButton: false,
    timer: 1500
    });
    </script>';
                        header("refresh:2;");
                    } else {
                        // No academic records found message
                        echo '<script>
    Swal.fire({
    position: "center",
    icon: "warning",
    title: "NO ACADEMIC RECORDS FOR THIS STUDENT",
    showConfirmButton: false,
    timer: 1500
    });
    </script>';
                        header("refresh:2;");
                    }
                } else {
                    // No student records found message
                    echo '<script>
    Swal.fire({
    position: "center",
    icon: "warning",
    title: "NO STUDENT RECORDS FOR STUDENT",
    showConfirmButton: false,
    timer: 1500
    });
    </script>';
                    header("refresh:2;");
                }
            } else {
                echo "<script> Swal.fire({
                        title: 'ENTER PRINCIPAL COMMENTS',
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