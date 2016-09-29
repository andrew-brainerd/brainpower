<!DOCTYPE html>
<html>
<head>
    <title>View Auth Database</title>
    <link rel="stylesheet" href="//umculobby.com/css/reset.css"/>
    <link rel="stylesheet" href="//umculobby.com/css/font.css"/>
    <link rel="stylesheet" href="../css/default.css"/>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/1/2016
 * Time: 9:47 AM
 */

include "dbconnect.php";

$slct = "SELECT * FROM Users";
$result = $conn->query($slct);
if ($result->num_rows > 0) {
    echo "<div class='table'>";
    echo "<div class='row'>";
    echo "<div class='hcell'>Username</div>";
    echo "<div class='hcell'>Plain Password</div>";
    echo "<div class='hcell'>Auth Level</div>";
    echo "</div>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='row')'>";
        echo "<div class='cell'>" . $row["username"] . "</div>";
        echo "<div class='cell'>" . $row["plain_pw"] . "</div>";
        echo "<div class='cell'>" . $row["auth_level"] . "</div>";
        echo "</div>";
    }
    echo "</div>";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").fadeIn();
    });
</script>
</body>
</html>