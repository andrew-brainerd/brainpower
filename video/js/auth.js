/**
 * Created by abrainerd on 4/1/2016.
 */

$.ajax({
    type: "GET",
    url: "/video/util/auth.php",
    data: "func=getAuth",
    success: function (response) {
        var isAuthorized = $(response).find("#authorization").text() == "authorized";
        if (isAuthorized) {
            $("body").fadeIn();
        } else {
            $("body").fadeOut();
            location.href = "/video/login.html";
        }
    }
});

/* Navigation, should probably move outta this file */
var header = $("header");
header.find("#title").click(function () {
    $("body").fadeOut();
    location.href = "/video/";
});
header.find("#logout").click(function () {
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
header.find("#upload").click(function () {
    $("body").fadeOut();
    location.href = "/video/uploadVideo.php";
});
header.find("#manage").click(function () {
    console.log("This will eventually make video settings editable");
});
header.find("#new").click(function () {
    $("body").fadeOut();
    location.href = "/video/util/newUser.php";
});