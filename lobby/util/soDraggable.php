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
    <style>
        body {
            background: #00274c;
            font-family: "Lucida Sans", sans-serif;
        }

        #visitor {
            position: absolute;
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
        <div>Andrew Brainerd</div>
        <div>Appointment</div>
        <div>Linda Kaddouh</div>
    </div>
</div>
<div class="finnaDrop" id="dropItLikeItsHot"></div>
<div class="finnaDrop" id="dropItLikeItsHotter"></div>
<div class="finnaDrop" id="dropItLikeItsBlazin"></div>
<? include "jquery.php"; ?>
<script type="text/javascript">
    $(document).ready(function () {
        var visitor = $("#visitor");
        var dropAreas = $(".finnaDrop");
        visitor.draggable({
            revert: "invalid"
        }).css({
            "left": "350px"
        });
        dropAreas.droppable({
            activate: function (event, ui) {
                console.log("Activated " + $(this).attr("id"));
                $(this).addClass("pickMe").html("<p>PICK ME! :D</p>");
            },
            deactivate: function () {
                $(this).removeClass("pickMe");
            },
            drop: function (event, ui) {
                console.log("Dropped in the AREA");
                dropAreas.removeClass("droppedTheMic").empty();
                var dropID = $(this).attr("id");
                var status;
                switch (dropID) {
                    case "dropItLikeItsHot":
                        status = "Waiting";
                        break;
                    case "dropItLikeItsHotter":
                        status = "With MSR";
                        break;
                    case "dropItLikeItsBlazin":
                        status = "Done";
                        break;
                    default:
                        console.log("Mucked it up. Nice Job");
                }
                $(this)
                    .html("<p>Changed status to " + status + "</p>")
                    .removeClass("almostHaveIt")
                    .addClass("droppedTheMic");
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
                console.log("Dropped on the BODY");
                $(dropAreas)
                    .removeClass("droppedTheMic")
                    .html("<p>Nothing going on over here</p>");
            }
        });
    });
</script>
</body>
</html>
