/**
 * Created by abrainerd on 4/1/2016.
 */

var cp = location.href.toString();
$.ajax({
    type: "GET",
    url: "/video/util/auth.php",
    data: "cp=" + cp,
    success: function (message) {
        if (message.indexOf("authorized") >= 0) {
            if (cp.indexOf("?") > 0) {
                cp = cp.substring(0, cp.indexOf("?"));
                location.href = cp;
            }
            else $("body").fadeIn();
        }
        else {
            $("body").fadeOut();
            location.href = "/video/";
        }
    }
});

$("header #title").click(function () {
    $("body").fadeOut();
    location.href = "/video/";
});
$("header #logout").click(function () {
    $.ajax({
        type: "POST",
        url: "/video/util/logout.php",
        success: function (message) {
            if (message == "logged out") {
                $("body").fadeOut();
                location.href = "/video/";
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
});
$("header #new").click(function () {
    $("body").fadeOut();
    location.href = "/video/util/newUser.php";
});