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
    <?php include('connect.php');
    ob_start();  ?>
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
        <header>Customer</header>
        <form method="POST" action="customer" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Add Customer</span>
                    <div class="fields">
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                            <label>Customer</label>
                            <select name="select_cust_type" required>
                                <option disabled selected>Select Customer Type</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM CUSTOMER_TYPE ORDER BY TYPE_ID");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["TYPE_ID"] . '">' . strtoupper($row["TYPE"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Customer Name</label>
                            <input type="text" placeholder="Enter Customer Name" pattern="[A-z ]+" title="Only Letters" name="c_name">
                        </div>

                        <div class="input-field">
                            <label>Customer Address</label>
                            <input type="text" placeholder="Enter Customer Address" name="c_address" pattern="[A-z0-9 ]+">
                        </div>
                        <div class="input-field">
                            <label>Town</label>
                            <select name="select_town" required>
                                <option disabled selected>Select Town</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM TOWN ORDER BY TOWN_CODE");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["TOWN_CODE"] . '">' . strtoupper($row["TOWN"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 3 - 10px);">
                            <label>Customer Primary Number</label>
                            <input type="number" placeholder="Enter Customer Primary Number" name="c_pri_no" pattern="[0-9]+" maxlength="7">
                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 3 - 10px);">
                            <label>Customer Secondary Number</label>
                            <input type="number" placeholder="Enter Customer Secondary Number" name="c_sec_no" pattern="[0-9]+" maxlength="7">
                        </div>
                        <div class="input-field">
                            <label>Customer Email</label>
                            <input type="email" placeholder="Enter Customer Email" name="c_email">
                        </div>

                        <div class="input-field">
                            <label>Customer ID Number</label>
                            <input type="text" placeholder="Enter Customer ID Number" name="c_id_no" pattern="[A-z0-9.]+" maxlength="7">
                        </div>

                        <div class="input-field">
                            <label>Customer VAT/TIN Number</label>
                            <input type="number" placeholder="Enter Customer VAT/TIN Number" title="Enter VAT Rate" name="c_vat_tin_no" pattern="[0-9.]+" maxlength="7">
                        </div>
                        <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 4 - 10px);">
                            <label>Customer Credit Rating</label>
                            <select name="select_customer_rating" required>
                                <option disabled selected>Select Customer Rating</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM CUSTOMER_CREDIT_RATING ORDER BY RATING_CODE");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["RATING_CODE"] . '">' . strtoupper($row["RATING"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button class="nextBtn" name="save_btn">
                            <span class="btnText">SAVE</span>
                            <i class="uil uil-save"></i>
                        </button>
                    </div>
                </div>



                <div class="details personal">
                    <span class="title">Edit Customer</span>
                    <div class="fields">
                        <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 3 - 10px);">
                            <label>Customer </label>
                            <select name="select_customer" required>
                                <option disabled selected>Select Customer </option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM CUSTOMER ORDER BY CUST_ID");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["CUST_ID"] . '">' . strtoupper($row["NAME"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-field" style="display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 3 - 10px);">
                            <label>Field To Update</label>
                            <select name="field" required>
                                <option disabled selected>Select Field</option>
                                <option>TYPE</option>
                                <option>NAME</option>
                                <option>ADDRESS</option>
                                <option>TOWN</option>
                                <option>PRIMARY LINE</option>
                                <option>SECONDARY LINE</option>
                                <option>EMAIL</option>
                                <option>VAT/TIN NUMBER</option>
                                <option>ID NUMBER</option>
                                <option>CREDIT RATING</option>
                            </select>
                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                            <label>Customer Type</label>
                            <select name="edit_select_cust_type" required>
                                <option disabled selected>Select Customer Type</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM CUSTOMER_TYPE ORDER BY TYPE_ID");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["TYPE_ID"] . '">' . strtoupper($row["TYPE"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Customer Name</label>
                            <input type="text" placeholder="Enter Customer Name" pattern="[A-z ]+" title="Only Letters" name="edit_c_name">
                        </div>
                        <div class="input-field">
                            <label>Customer Address</label>
                            <input type="text" placeholder="Enter Customer Address" name="edit_c_address" pattern="[A-z0-9 ]+">
                        </div>
                        <div class="input-field">
                            <label>Town</label>
                            <select name="edit_select_town" required>
                                <option disabled selected>Select Town</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM TOWN ORDER BY TOWN_CODE");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["TOWN_CODE"] . '">' . strtoupper($row["TOWN"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 3 - 10px);">
                            <label>Customer Primary Number</label>
                            <input type="number" placeholder="Enter Customer Primary Number" name="edit_c_pri_no" pattern="[0-9]+" maxlength="7">
                        </div>
                        <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 3 - 10px);">
                            <label>Customer Secondary Number</label>
                            <input type="number" placeholder="Enter Customer Secondary Number" name="edit_c_sec_no" pattern="[0-9]+" maxlength="7">
                        </div>
                        <div class="input-field">
                            <label>Customer Email</label>
                            <input type="email" placeholder="Enter Customer Email" name="edit_c_email">
                        </div>

                        <div class="input-field">
                            <label>Customer ID Number</label>
                            <input type="text" placeholder="Enter Customer ID Number" name="edit_c_id_no" pattern="[A-z0-9.]+" maxlength="7">
                        </div>

                        <div class="input-field">
                            <label>Customer VAT/TIN Number</label>
                            <input type="number" placeholder="Enter Customer VAT/TIN Number" name="edit_c_vat_tin_no" pattern="[0-9.]+" maxlength="7">
                        </div>
                        <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 4 - 10px);">
                            <label>Customer Credit Rating</label>
                            <select name="edit_select_customer_rating" required>
                                <option disabled selected>Select Customer Rating</option>
                                <?php
                                $sql = oci_parse($conn, "SELECT * FROM CUSTOMER_CREDIT_RATING ORDER BY RATING_CODE");
                                oci_execute($sql);
                                while ($row = oci_fetch_array($sql)) {
                                    echo '<option value="' . $row["RATING_CODE"] . '">' . strtoupper($row["RATING"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button class="nextBtn" name="edit_btn">
                            <span class="btnText">EDIT</span>
                            <i class="uil uil-edit"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="buttons" style="display: flex; align-items: center;">
                <button id="showcompanyBtn" type="button" class="backBtn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 250px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #909290; transition: all 0.3s linear; cursor: pointer;">
                    <span class="btnText" style="font-size: 15px; color: white; text-decoration: none;">
                        VIEW CUSTOMER DETAILS
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
    <script src="js/input.js"></script>

    <div id="regionsModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Customer</h2>
            <table id="regionsTable">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Type</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Customer Town</th>
                        <th>Customer Email</th>
                        <th>Customer VAT/TIN Number</th>
                        <th>Customer Identification Number</th>
                        <th>Customer Credit Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = oci_parse($conn, "SELECT * FROM CUSTOMER A JOIN CUSTOMER_TYPE B ON (A.TYPE_ID=B.TYPE_ID) JOIN CUSTOMER_CREDIT_RATING C ON (A.RATING_CODE=C.RATING_CODE) JOIN TOWN D ON (A.TOWN_CODE=D.TOWN_CODE) ORDER BY A.CUST_ID");
                    oci_execute($sql);
                    while ($row = oci_fetch_array($sql)) {
                        echo '<tr>';
                        echo '<td>' . $row["CUST_ID"] . '</td>';
                        echo '<td>' . $row["TYPE"] . '</td>';
                        echo '<td>' . $row["NAME"] . '</td>';
                        echo '<td>' . $row["ADDRESS"] . '</td>';
                        echo '<td>' . $row["TOWN"] . '</td>';
                        echo '<td>' . $row["EMAIL"] . '</td>';
                        echo '<td>' . $row["VAT_TIN_NO"] . '</td>';
                        echo '<td>' . $row["ID_NO"] . '</td>';
                        echo '<td>' . $row["RATING"] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById("regionsModal");

        // Get the button that opens the modal
        var btn = document.getElementById("showcompanyBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function(event) {
            event.preventDefault(); // Prevent form submission
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <?php
    if (isset($_POST['save_btn'])) {
        if (isset($_POST['select_cust_type'])) {
            if ($_POST['c_name'] != '') {
                if(isset($_POST['select_town'])){
                    if ($_POST['c_address'] != '') {
                        if ($_POST['c_pri_no'] != '') {
                            if ($_POST['c_sec_no'] != '') {
    
                                if (isset($_POST['select_customer_rating'])) {
    
                                    $sql = oci_parse($conn, "INSERT INTO CUSTOMER (NAME,ADDRESS,PRIMARY_LINE,SECONDARY_LINE,EMAIL,VAT_TIN_NO,ID_NO,TYPE_ID,RATING_CODE,TOWN_CODE) 
                                                VALUES (:NAME,:ADDRESS,:P_LINE,:S_LINE,:EMAIL,:VAT_TIN,:ID,:TYPE_ID,:R_CODE,:T_CODE)");
    
                                    oci_bind_by_name($sql, ":NAME", strtoupper($_POST['c_name']));
                                    oci_bind_by_name($sql, ":ADDRESS", strtoupper($_POST['c_address']));
                                    oci_bind_by_name($sql, ":P_LINE", $_POST['c_pri_no']);
                                    oci_bind_by_name($sql, ":S_LINE", $_POST['c_sec_no']);
                                    oci_bind_by_name($sql, ":EMAIL", strtoupper($_POST['c_email']));
                                    oci_bind_by_name($sql, ":VAT_TIN", $_POST['c_vat_tin_no']);
                                    oci_bind_by_name($sql, ":ID", strtoupper($_POST['c_id_no']));
                                    oci_bind_by_name($sql, ":TYPE_ID", strtoupper($_POST['select_cust_type']));
                                    oci_bind_by_name($sql, ":R_CODE", $_POST['select_customer_rating']);
                                    oci_bind_by_name($sql, ":T_CODE", $_POST['select_town']);
    
                                    if (oci_execute($sql)) {
                                        echo "<script> Swal.fire({
                            title: '" . strtoupper($_POST['c_name']) . " ADDED AS CUSTOMER SUCCESSFULLY',
                            icon: 'success',
                            showConfirmButton: true
                        });</script>";
                                        header("refresh:2;");
                                    } else {
                                        echo "<script> Swal.fire({
                                                title: 'ERROR ADDING CUSTOMER',
                                                icon: 'error',
                                                showConxo9i sirmButton: true
                                            });</script>";
                                    }
                                } else {
                                    echo "<script> Swal.fire({
                                                title: 'SELECT CUSTOMER CREDIT RATING',
                                                icon: 'warning',
                                                showConfirmButton: true
                                            });</script>";
                                }
                            }
                        } else {
                            echo "<script> Swal.fire({
                                                title: 'ENTER CUSTOMER SECONDARY NUMBER',
                                                icon: 'warning',
                                                showConfirmButton: true
                                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                                            title: 'ENTER CUSTOMER PRIMARY NUMBER',
                                            icon: 'warning',
                                            showConfirmButton: true
                                        });</script>";
                    }
                }else {
                    echo "<script> Swal.fire({
                        title: 'SELECT TOWN',
                        icon: 'warning',
                        showConfirmButton: true
                    });</script>";
                }
              
            } else {
                echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER ADDRESS',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                    title: 'ENTER CUSTOMER NAME',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
        }
    }


    if (isset($_POST['edit_btn'])) {
        if (isset($_POST['select_customer'])) {
            if (isset($_POST['field'])) {
                if ($_POST['field'] == 'TYPE') {
                    if (isset($_POST['edit_select_cust_type'])) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET TYPE_ID=:TYPE_ID WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":TYPE_ID", $_POST['edit_select_cust_type']);
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER TYPE EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER TYPE',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'SELECT CUSTOMER TYPE',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                } else
                    if ($_POST['field'] == 'NAME') {
                    if ($_POST['edit_c_name']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET NAME=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_name']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                    title: 'CUSTOMER NAME EDITED SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: true
                                });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                    title: 'ERROR UPDATING CUSTOMER NAME',
                                    icon: 'error',
                                    showConfirmButton: true
                                });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                                title: 'ENTER CUSTOMER FIRST NAME',
                                icon: 'warning',
                                showConfirmButton: true
                            });</script>";
                    }
                } else
                    if ($_POST['field'] == 'ADDRESS') {
                    if ($_POST['edit_c_address']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET ADDRESS=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_address']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                    title: 'CUSTOMER ADDRESS EDITED SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: true
                                });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                    title: 'ERROR UPDATING CUSTOMER ADDRESS',
                                    icon: 'error',
                                    showConfirmButton: true
                                });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                                title: 'ENTER CUSTOMER ADDRESS',
                                icon: 'warning',
                                showConfirmButton: true
                            });</script>";
                    }
                } else
                    if ($_POST['field'] == 'ADDRESS') {
                    if ($_POST['edit_c_address']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET ADDRESS=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_address']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                    title: 'CUSTOMER ADDRESS EDITED SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: true
                                });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                    title: 'ERROR UPDATING CUSTOMER ADDRESS',
                                    icon: 'error',
                                    showConfirmButton: true
                                });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                                title: 'ENTER CUSTOMER ADDRESS',
                                icon: 'warning',
                                showConfirmButton: true
                            });</script>";
                    }
                } else
                if ($_POST['field'] == 'PRIMARY LINE') {
                    if ($_POST['edit_c_pri_no']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET PRIMARY_LINE=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_pri_no']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER PRIMARY LINE EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER PRIMARY LINE',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER PRIMARY LINE',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                } else
                if ($_POST['field'] == 'SECONDARY LINE') {
                    if ($_POST['edit_c_sec_no']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET SECONDARY_LINE=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_sec_no']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER SECONDARY LINE EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER SECONDARY LINE',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER SECONDARY LINE',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                } else
                if ($_POST['field'] == 'EMAIL') {
                    if ($_POST['edit_c_email']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET EMAIL=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_email']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER EMAIL EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER EMAIL',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER EMAIL',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                } else
                if ($_POST['field'] == 'VAT/TIN NUMBER') {
                    if ($_POST['edit_c_vat_tin_no']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET VAT_TIN_NO=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_vat_tin_no']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER VAT/TIN NUMBER EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER EMAIL',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER EMAIL',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                } else
                if ($_POST['field'] == 'ID NUMBER') {
                    if ($_POST['edit_c_id_no']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET ID_NO=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_c_id_no']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER ID NUMBER EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER ID NUMBER',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER ID NUMBER',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                } else
                if ($_POST['field'] == 'CREDIT RATING') {
                    if ($_POST['edit_select_customer_rating']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET RATING_CODE=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_select_customer_rating']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER CREDIT RATING EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER CREDIT RATING',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER CUSTOMER CREDIT RATING',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                }
                else
                if ($_POST['field'] == 'TOWN') {
                    if ($_POST['edit_select_town']) {
                        $sql = oci_parse($conn, "UPDATE CUSTOMER SET TOWN_CODE=:NAME WHERE CUST_ID=:CUST_ID");
                        oci_bind_by_name($sql, ":NAME", strtoupper($_POST['edit_select_town']));
                        oci_bind_by_name($sql, ":CUST_ID", strtoupper($_POST['select_customer']));
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                title: 'CUSTOMER TOWN EDITED SUCCESSFULLY',
                                icon: 'success',
                                showConfirmButton: true
                            });</script>";
                            header("refresh:2;");
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR UPDATING CUSTOMER TOWN',
                                icon: 'error',
                                showConfirmButton: true
                            });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                            title: 'ENTER TOWN',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                    }
                }
            } else {
                echo "<script> Swal.fire({
                    title: 'SELECT FIELD',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                title: 'SELECT CUSTOMER',
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