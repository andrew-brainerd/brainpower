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
        p { font-size: 10px; }
        h1, h3, h5 { text-align: center; }
        h5 { font-size: 10px; }
        form { border: 3px dashed grey; margin: auto; padding: 25px; width: 500px; }
        label { font-size: 20px; }
        input[type=button] { font-size: 20px; }
        .message {
        }
    </style>
</head>
<body>
<h1>Welcome Friend!</h1>
<h3>This is the eventual resting place of the<br/> UMCU Lobby Management Application</h3>
<form autocomplete="off">
    <label for="username">Username</label>
    <input type="text" id="username" value="Andrew Brainerd"/><br/>
    <label for="password">Password</label>
    <input type="password" id="password" value="b0ggl3sth3m!nd"/><br/>
    <input type="button" id="submit" value="Submit" onclick="runTest()"/>
</form>
<div id="anonmessage"></div>
<div id="message"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
    var counter = 1;
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
        console.log("running...");
        $.ajax({
            type: "GET",
            url: "testADLogin.php",
            data: "username=" + $("#username").val() +
            "&password=" + $("#password").val(),
            success: function (msg) {
                console.log("done running");
                $("#message").html(msg);
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
</script>
</body>
</html>