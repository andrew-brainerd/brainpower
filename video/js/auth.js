/**
 * Created by abrainerd on 4/1/2016.
 */

$(document).ready(function () {
    console.log("Authenticating User...");
    var cp = location.href.toString();
    $.ajax({
        type: "GET",
        url: "/video/util/auth.php",
        data: "cp=" + cp,
        success: function (message) {
            if (message.indexOf("authorized") >= 0) {
                console.log("User is Authorized");
                if (cp.indexOf("?") > 0) {
                    cp = cp.substring(0, cp.indexOf("?"));
                    console.log("Stripped cp: " + cp);
                    location.href = cp;
                }
                else $("body").fadeIn();
            }
            else {
                console.log("Please log in to view this page");
                $("body").fadeOut();
                location.href = "/video/login.html";
            }
            console.log("auth.php: " + message);
        }
    });

    $("header #title").click(function () {
        $("body").fadeOut();
        location.href = "/video/";
    });
    $("header #logout").click(function () {
        console.log("Logging out...");
        $.ajax({
            type: "POST",
            url: "/video/util/logout.php",
            success: function (message) {
                console.log("Message: " + message);
                if (message == "logged out") {
                    $("body").fadeOut();
                    location.href = "/video/login.html";
                }
            }
        });
    });
    $("header #upload").click(function () {
        $("body").fadeOut();
        location.href = "/video/uploadVideo.php";
    });
    $("header #manage").click(function () {
        console.log("This will eventually make video settings editable");
        /// /$("body").fadeOut();
        //location.href = path + "/video/uploadVideo.php";
    });
    $("header #new").click(function () {
        $("body").fadeOut();
        location.href = "/video/util/newUser.php";
    });
});