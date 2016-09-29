<?php
// Date, Name, Make, Model, Spot Number, Time In, Time Out, Reason
//$host_name = "db614514643.db.1and1.com";
//$database = "db614514643";
//$user_name = "dbo614514643";
//$password = "B0ggl3sth3m!nd";   Outdated info

$connect = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else
    echo "<h3>Successfully connected to Database :D</h3>";


$tbl_parkTest = "CREATE TABLE IF NOT EXISTS parkingTest (
            park_id   int(11)       NOT NULL AUTO_INCREMENT,
            park_date date          NOT NULL,
            fname     varchar(99)   NOT NULL,
            lname     varchar(99)   NOT NULL,
            make      varchar(99)   DEFAULT NULL,
            model     varchar(99)   DEFAULT NULL,
            spot_num  int(99)       DEFAULT NULL,
            time_in   time          NOT NULL,
            time_out  time          DEFAULT NULL,
            reason    varchar(255)  DEFAULT NULL,
        PRIMARY KEY (park_id)
        )";


$query = mysqli_query($connect, $tbl_parkTest);
if ($query === TRUE) {
    echo "<h3>Table created successfully</h3>";
} else {
    echo "<h3>Table not created</h3>";
}

$sql = "INSERT INTO parkingTest (fname, lname, make, model, spot_num, reason)
        VALUES ('Andrew','Brainerd','Chryler','Sebring','5','Interview')";

if ($connect->query($sql) === TRUE) {
    echo "<h3>New record created successfully! WOOOO!</h3>";
} else {
    echo "<h3 style='color: red'>Error: " . $sql . "</h3><br>" . $connect->error;
}
$connect->close();
?>