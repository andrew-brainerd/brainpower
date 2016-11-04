/**
 * Created by abrainerd on 11/4/2016.
 */

var header = $("header");
header.find("#title").click(function () {
    $("body").fadeOut();
    location.href = "/video/";
});
header.find("#new").click(function () {
    $("body").fadeOut();
    location.href = "/video/util/newUser.php";
});
header.find("#upload").click(function () {
    $("body").fadeOut();
    location.href = "/video/uploadVideo.php";
});
header.find("#manage").click(function () {
    console.log("This will eventually make video settings editable");
});
header.find("#logout").click(function () {
    $.ajax({
        type: "POST",
        url: "/video/util/logout.php",
        success: function (response) {
            if (response == "logged_out") {
                $("body").fadeOut();
                location.href = "/video/";
            }
        }
    });
});