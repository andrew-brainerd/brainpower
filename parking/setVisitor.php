<?php

$fname = ucwords($_POST["fn"]);
$lname = ucwords($_POST["ln"]);
$make = ucwords($_POST["mk"]);
$model = ucwords($_POST["md"]);

include 'dbconnect.php';

$sql = "SELECT * FROM Visitors WHERE fname='$fname' and lname='$lname' and make='$make' and model='$model'";
$result = $conn->query($sql);
if ($result->num_rows === 0) {
    $sql = "INSERT INTO Visitors(fname, lname, make, model)
            VALUES ('$fname', '$lname', '$make', '$model')";
    $success2 = $conn->query($sql);
    $new_id = $conn->insert_id;
} else {
    $row = $result->fetch_assoc();
    $new_id = $row["vid"];
}

echo $new_id;

$conn->close();