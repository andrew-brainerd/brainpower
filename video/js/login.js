/**
 * Created by abrainerd on 4/1/2016.
 */

var username = $("#username");
var loginButton = $("#loginButton");
var loginMessage = $("#message");

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
            if (isAuthorized) location.href = "/video";
            else loginMessage.text($(response).find("#"));
        }
    });
});
loginMessage.on("change", function () {
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
username.focus();
