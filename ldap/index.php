<!DOCTYPE html>
<html>
<head>
    <title>Welcome Friend</title>
    <style>
        body {
            background-color: #302B27;
            color: #576CA8;
            font-family: sans-serif;
            font-size: 3vw;
        }
        h1, h3, h5 { text-align: center; }
        h5 { font-size: 12px; }
        form { border: 3px dashed grey; margin: 70px auto; padding: 25px; width: 500px; }
        label { font-size: 20px; }
        input[type=button] { font-size: 20px; }
        #message {
            font-size: 16px;
        }
        .table {
            display: table;
            margin: 50px auto;
            min-width: 50%;
        }
        .row {
            display: table-row;
        }
        .cell {
            display: table-cell;
            padding: 10px;
        }
        .hcell {
            display: table-cell;
            color: #576CA8;
            font-weight: bold;
            border-bottom: 2px solid #576CA8;
            margin-bottom: 10px;
            padding: 10px;
        }
        .cell {
            transition: background 0.3s, color 0.3s;
        }
        .cell label {
            margin-right: 10px;
        }
        .cell input, .cell select {
            border-radius: 5px;
            width: 200px;
        }
        .row.selected .cell {
            color: white;
        }
        .floatingHeader {
            position: fixed;
            top: 0;
            visibility: hidden;
        }
    </style>
</head>
<body>
<!--<h1>Welcome Friend!</h1>
<h3>This is the eventual resting place of the<br/> UMCU Lobby Management Application</h3>-->
<form autocomplete="off">
    <label for="username">Username</label>
    <input type="text" id="username" value="abrainerd"/><br/>
    <label for="password">Password</label>
    <input type="password" id="password" value="b0ggl3sth3m!nd7"/><br/>
    <input type="button" id="submit" value="Submit" onclick="runTest()"/>
</form>
<div id="anonmessage"></div>
<div id="message"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
    var counter = 1;
    $(function () {

        var clonedHeaderRow;

        $(".table").each(function () {
            clonedHeaderRow = $(".row .hcell", this);
            clonedHeaderRow
                .before(clonedHeaderRow.clone())
                .css("width", clonedHeaderRow.width())
                .addClass("floatingHeader");
        });

        $(window)
            .scroll(UpdateTableHeaders)
            .trigger("scroll");

    });
    $(document).bind("keypress.key13", function (e) {
        if (e.which == 13) {
            e.preventDefault();
            $("#submit").click();
        }
    });
    $.ajax({
        type: "POST",
        url: "testAnonLogin.php",
        success: function (msg) {
            $("#anonmessage").html(msg);
        }
    });
    function runTest() {
        if ($("#username").val() == "") return;
        console.log("running...");
        $.ajax({
            type: "GET",
            url: "testADLogin.php",
            data: "username=" + $("#username").val() +
            "&password=" + $("#password").val(),
            success: function (msg) {
                console.log("done running");
                $("#message").html(msg);
                var selected = $(".selected");
                $("html, body").animate({
                    scrollTop: selected.offset().top - 200
                }, 1000);
                selected.click(function () {
                    $("html, body").animate({
                        scrollTop: $("html").offset().top
                    }, 1);
                }).css("cursor", "pointer");
                counter++;
            },
            /*complete: function (msg) {
             console.log("Done running");
             console.log(msg);
             },*/
            error: function (err) {
                console.log("Failed");
                console.log(err);
            }
        });
    }
    function UpdateTableHeaders() {
        $(".persist-area").each(function () {

            var el = $(this),
                offset = el.offset(),
                scrollTop = $(window).scrollTop(),
                floatingHeader = $(".floatingHeader", this)

            if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
                floatingHeader.css({
                    "visibility": "visible"
                });
            } else {
                floatingHeader.css({
                    "visibility": "hidden"
                });
            }
            ;
        });
    }
</script>
</body>
</html>