<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New User</title>
    <link rel="stylesheet" href="//umculobby.com/css/reset.css"/>
    <link rel="stylesheet" href="//umculobby.com/css/font.css"/>
    <link rel="stylesheet" href="../css/video.css"/>
    <!--<style>
        body { background: #000444; color: gold; font-family: sans-serif; }
        input, select { display: block; }
    </style>-->
</head>
<body>
<header>
    <?php include "../header.php" ?>
</header>
<div id="view">
    <div id="createNew">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" autocomplete="off"/>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="off"/>
        <label for="authlv">Access Level:</label>
        <select id="authLv" name="authLv" title="Authotrization Level"></select>
        <div class="button" id="createUser">Create</div>
        <div id="message"></div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="../js/auth.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // if auth
        var page = $("body");
        var create = $("#createUser");
        var message = $("#message");
        getLevels();
        page.fadeIn();

        create.click(function () {
            var username = $("#username").val();
            var password = $("#password").val();
            var authlvl = $("#authLv").val();
            if (username != "" && password != "" && authlvl != 0) {
                $.ajax({
                    type: "POST",
                    url: "createUser.php",
                    data: "un=" + username +
                    "&pw=" + password +
                    "&al=" + authlvl,
                    success: function (m) {
                        message.html(m);
                        message.fadeIn(function () {
                            setTimeout(function () {
                                message.fadeOut();
                                $("#username").val("");
                                $("#password").val("");
                                $("#authlvl").val("0");
                            }, 2000);
                        });
                    }
                });
            }
            else alert("Please complete form before summitting");
        });

        page.bind('keypress', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                create.click();
            }
        });
    });

    function getLevels() {
        $.ajax({
            type: "POST",
            url: "getLevels.php",
            success: function (m) {
                $("#authLv").html(m);
            }
        });
    }
</script>
</body>
</html>