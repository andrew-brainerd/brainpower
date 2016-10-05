<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 10/3/2016
 * Time: 12:29 PM
 */

?>
<!DOCTYPE html>
<html>
<head>
    <title>jQuery Drag/Drop Test</title>
    <link rel="stylesheet" href="/lobby/css/lobby.css"/>
    <style>
        body {
            background: #00274c;
            font-family: "Lucida Sans", sans-serif;
        }
        #visitor {
            position: absolute;
        }

        #container {
            display: inline-block;
            width: 500px;
        }

        #viewVisitors {
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            padding: 10px;
            vertical-align: top;
        }

        #viewVisitors .table {
            font-size: 12px;
            max-width: none;
        }
        .ui-draggable {
            background: #ffcb05;
            border: 2px solid black;
            cursor: move;
            width: 200px;
        }
        .ui-draggable div {
            padding: 10px;
        }
        .ui-draggable div div {
            text-align: center;
        }
        .ui-draggable-dragging {
            background: darkgreen;
            border-radius: 3px;
            color: white;
        }
        .ui-droppable:not(body) {
            background: #fae7b5;
            border: 6px outset #0f345e;
            /*display: inline-block;*/
            height: 300px;
            width: 300px;
        }
        .ui-droppable.droppedTheMic {
            background: purple;
            color: white;
        }
        .ui-droppable p {
            font-weight: bold;
            text-align: center;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .ui-droppable.pickMe {
            background: dodgerblue;
        }
        * {
            transition: background 0.5s ease-in-out;
        }
        .ui-droppable.almostHaveIt {
            background: orangered;
        }
    </style>
</head>
<body>
<div id="visitor">
    <div>
        <div>Visitor: Andrew Brainerd</div>
        <div>For: Appt w/Linda Kaddouh</div>
    </div>
    </div>
<div id="container">
    <div class="finnaDrop" id="dropItLikeItsHot"></div>
    <div class="finnaDrop" id="dropItLikeItsHotter"></div>
    <div class="finnaDrop" id="dropItLikeItsBlazin"></div>
</div>
<div id="viewVisitors"></div>
<? include "jquery.php"; ?>
<script type="text/javascript">
    $(document).ready(function () {
        fetchVisitors();
        $("body").fadeIn();
        var visitor = $("#visitor");
        var dropAreas = $(".finnaDrop");
        visitor.draggable({
            revert: "invalid"
        }).css({
            "left": "350px"
        });
        dropAreas.droppable({
            activate: function (event, ui) {
                $(this).addClass("pickMe").html("<p>PICK ME! :D</p>");
            },
            deactivate: function () {
                $(this).removeClass("pickMe");
            },
            drop: function (event, ui) {
                dropAreas.removeClass("droppedTheMic").empty();
                var dropID = $(this).attr("id");
                var status, statusText;
                switch (dropID) {
                    case "dropItLikeItsHot":
                        status = 0;
                        statusText = "Waiting";
                        break;
                    case "dropItLikeItsHotter":
                        status = 1;
                        statusText = "With MSR";
                        break;
                    case "dropItLikeItsBlazin":
                        status = 2;
                        statusText = "Done";
                        break;
                    default:
                        console.log("Mucked it up. Nice Job");
                }
                $(this)
                    .html("<p>Changed status to " + statusText + "</p>")
                    .removeClass("almostHaveIt")
                    .addClass("droppedTheMic");
                $.ajax({
                    type: "POST",
                    url: "updateStatus.php",
                    data: "vid=155&status=" + status,
                    success: function (msg) {
                        fetchVisitors();
                    }
                });
            },
            greedy: true,
            out: function () {
                $(this).removeClass("almostHaveIt");
            },
            over: function () {
                $(this).addClass("almostHaveIt")
            }
        });
        $("body").droppable({
            drop: function (event, ui) {
                $(dropAreas)
                    .removeClass("droppedTheMic")
                    .html("<p>Nothing going on over here</p>");
            }
        });
    });
    function fetchVisitors() {
        $.ajax({
            type: "POST",
            url: "viewVisitors.php",
            data: "branch=William",
            success: function (data) {
                $("#viewVisitors").html(data);
            }
        });
    }
</script>
</body>
</html>
