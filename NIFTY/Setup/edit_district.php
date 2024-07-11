<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    <div class="wrapper">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <img src="img/logo.png">
        </div>
        <h2>Edit Region</h2>
        <form action="edit_district.php" id="form" method="post">
            <div class="input-box username">
                <select name="region">
                    <option disabled selected>Select District</option>
                    <?php
                    include 'connect.php';
                    $check = oci_parse($conn, "select * from district ORDER BY DIS_CODE");
                    oci_execute($check);
                    while ($row = oci_fetch_array($check)) {
                    ?><option><?php echo $row["DISTRICT"] ?></option><?php
                                                                }
                                                                    ?>
                </select>
            </div>
            <div class="input-box username">
                <input type="text" placeholder="Update District" required pattern="[A-z0-9 ]+" title="Only Letters And Numbers" name="upd_reg">
            </div>

            <button class="input-box button">
                <input type="Submit" value="Update" title="login successfully" id="redirect" href="login.html" name="Save">
                </a>
            </button>

            <div class="text">
                <h3><a href="setup_menu.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
            </div>

            <div class="message">
                <?php
                if (isset($_POST['Save'])) {
                    include 'connect.php';
                    if ($conn) {
                ?><div style="font-size:13px;
            color: green;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                            <?php ?>
                        </div> <?php
                                $r = $_POST['region'];
                                $up_reg = strtoupper($_POST['upd_reg']);
                                $getregcode = oci_parse($conn, "select * from district where district ='$r'");
                                oci_execute($getregcode);

                                while ($row = oci_fetch_array($getregcode)) {
                                    $reg_code = $row['DIS_CODE'];
                                }

                                $check = oci_parse($conn, "select * from DISTRICT where DISTRICT='$up_reg'");
                                oci_execute($check);
                                if (oci_fetch_all($check, $a) > 0) {
                                ?><div style="font-size:13px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                                <?php echo "DISTRICT ALREADY EXIST";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                } else {
                                  
                                    $sql = oci_parse($conn, "update DISTRICT set district = '$up_reg' where DIS_code = '$reg_code'");
                                    oci_execute($sql);
                                    $check = oci_parse($conn, "select * from DISTRICT where district='$up_reg'");
                                    oci_execute($check);
                                    if (oci_fetch_all($check, $a) > 0) {
                                    ?><div style="font-size:13px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "$up_reg UPDATED";
                                        header("refresh:3;"); ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:13px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR SAVING $r";
                                        header("refresh:3;"); ?>
                                </div> <?php
                                    }
                                }
                            } else {
                                        ?><div style="font-size:13px;
            color: red;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR CONNECTING TO DATABASE";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        }
                                ?>
            </div>
        </form>
    </div>
</body>

</html>