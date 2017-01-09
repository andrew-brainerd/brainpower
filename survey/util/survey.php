<?php
include "../../manage/util/dbconnect.php";

$satisfaction = strip_tags($_POST["satisfaction"]);
$reason = strip_tags($_POST["reason"]);
$comments = strip_tags($_POST["comments"]);

$sql = "INSERT INTO Survey (satisfaction_level, visit_reason, details) VALUES ('$satisfaction', '$reason', '$comments')";

$success = $conn->query($sql);

if ($success) echo "<h2>Wrote to database</h2>";
else echo "<h2>" . $conn->error . "</h2>";

$conn->close();