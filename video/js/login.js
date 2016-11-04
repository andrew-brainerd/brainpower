/**
 * Created by abrainerd on 4/1/2016.
 */

$("#username").focus();
var url = location.href.toString();
var message = $("#message");
var loginButton = $("#loginButton");
if (url.indexOf("notmuch") > 0)
    url = url.substring(0, 32);
else url = url.substring(0, 21);

loginButton.click(function () {
    var username = $("#username").val();
    var password = $("#password").val();
    $.ajax({
        type: "GET",
        url: "util/auth.php",
        data: "func=setAuth" +
        "&username=" + username +
        "&password=" + password,
        success: function (response) {
            var isAuthorized = $(response).find("#authorization").text() == "authorized";
            if (isAuthorized) {
                console.log("User is now authorized :D");
                location.href = "/video";
            }
        }
    });
});
message.on("change", function () {
    message.fadeOut(function () {
        message.css("color", "red");
        message.fadeIn(function () {
            setTimeout(function () {
                message.fadeOut();
            }, 2000);
        });
    });
});
$("body").bind('keypress', function (e) {
    if (e.which == 13) {
        loginButton.click();
    }
}).fadeIn();

