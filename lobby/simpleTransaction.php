<!DOCTYPE html>
<html>
<head>
    <?php include "head.php" ?>
    <title>Teller Transaction</title>
    <style>
        #container {
            margin: 50px auto;
            width: 500px;
        }

        #container input[type=button] {
            margin: 10px 5px;
        }

        #container input[disabled] {
            opacity: 0.7;
        }

        .transactionRecord {
            margin: 50px auto;
        }

        .transactionRecord td, .transactionRecord th {
            padding: 5px 10px;
            text-align: center;
        }

        .transactionRecord th {
            border-bottom: 2px solid #ffcb05;
        }
    </style>
</head>
<body>
<div id="container">
    <input type="button" id="startTimer" value="Start"/>
    <input type="button" id="stopTimer" value="Stop" disabled/>
    <div id="output"></div>
</div>
<input type="hidden" id="tid" value=""/>
<?php include "util/jquery.php" ?>
<script type="text/javascript">
    $(document).ready(function () {
        var start = $("#startTimer");
        var stop = $("#stopTimer");
        var output = $("#output");
        var tid = $("#tid");
        $("body").fadeIn();
        start.click(function () {
            $.ajax({
                type: "GET",
                url: "util/updateTimestamp.php",
                data: "usernumber=313&f=start",
                success: function (message) {
                    if (message == "Failed on Insertion") {
                    }
                    else {
                        tid.val(message);
                        stop.prop("disabled", false);
                        console.log(message);
                    }
                }
            });
        });
        stop.click(function () {
            $.ajax({
                type: "GET",
                url: "util/updateTimestamp.php",
                data: "usernumber=313&f=stop&tid=" + tid.val(),
                success: function (message) {
                    output.empty();
                    output.append(message);
                }
            });
        });
    });
</script>
</body>
</html>