<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include 'dbconnect.php';
    include 'communication.php';

    $vid = $_POST["vid"];
    $spot = $_POST["spotNum"];
    $reason = $_POST["reason"];
    $timeIn = date("H:i:s a");
    $date = date("Y/m/d");
    $location = "Huron";
    if ($_POST["branch"] != "") $location = $_POST["branch"];

    if ($spot === "0") {
        $spot = $_POST["other"];;
    }
    if ($reason === "0") {
        $reason = $_POST["otherR"];
    }

    // Get Visitor Info
    $sql = "SELECT fname, lname, make, model, umcu_username, assigned_spot FROM Visitors WHERE vid='$vid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $fn = $row['fname'];
    $ln = $row['lname'];
    $mk = $row['make'];
    $md = $row['model'];
    $_un = $row['umcu_username'];
    $_ps = $row['assigned_spot'];

    // Create new Parking record
    $ins = "INSERT INTO Parking(vid, visit_date, reason, spot_num, time_in, location) ";
    $val = "VALUES ('$vid', '$date', '$reason', '$spot', '$timeIn', '$location')";
    $sql = $ins . $val;
    $s1 = $conn->query($sql);

    // Update or create Reason record
    $sql = "SELECT * FROM Reasons WHERE reason='$reason'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newCount = $row['used_count'] + 1;
        if ($newCount === 30) {
            sendReasonUpdate($reason);
        }
        $sql = "UPDATE Reasons SET used_count='$newCount' WHERE reason='$reason'";
    } else {
        $sql = "INSERT INTO Reasons(reason, used_count) VALUES ('$reason', 1)";
    }
    $s2 = $conn->query($sql);

    // Update Last Visit date in Visitor record
    $sql = "UPDATE Visitors SET last_visit='$date' WHERE vid='$vid'";
    //and last_visit<>'$date'";
    $s3 = $conn->query($sql);

    // Send Communication
    //sendLogText($fn, $ln, $mk, $md, $spot, $reason);
    sendLogEmail($fn, $ln, $mk, $md, $spot, $reason, $location);
    if ($reason === "Assigned Spot Taken") {
        $as = $_POST["tmAssSpot"];
        $vd = $_POST["vehicleDesc"];
        $un = strtolower($_POST["tmEmail"]);
        $s4 = false;
        if ($_un === NULL && $_ps === NULL) {
            $sql = "UPDATE Visitors SET umcu_username='$un', assigned_spot='$as' WHERE vid='$vid'";
            $s4 = $conn->query($sql);
        } else {
            $un = $_un;
            $as = $_ps;
        }
        $ea = $un . "@umcu.org";
        sendFacilitesEmail($fn, $ln, $spot, $as, $vd, $ea);
    }

    $conn->close();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You!</title>
    <link rel="stylesheet" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/font.css"/>
    <link rel="stylesheet" href="css/parking.css"/>
    <style>
        .padding {
            border-collapse: collapse;
            margin: auto;
        }

        .padding td {
            padding: 10px;
        }
    </style>
</head>
<body>
<header>
    <img src="img/umcu_logo.png"/>
</header>
<div id="thank-you">
    <h1>Thanks for Checking In!</h1>
    <h1>Enjoy your time at UMCU</h1>
    <div id="return" onclick="returnToCheckIn()">Return to Check-In</div>
</div>
<script src="/js/secure.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").fadeIn();
        setTimeout(function () {
            returnToCheckIn();
        }, 10000);
    });
    function returnToCheckIn() {
        console.log("returning to check-in");
        $("#thank-you").fadeOut("slow", function () {
            location.href = "/parking";
        });
    }
</script>
</body>
</html>