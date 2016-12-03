/**
 * Created by abrainerd on 4/1/2016.
 */

var username = $("#username");
var password = $("#password");
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
            var isAuthorized = response == "authorized";
            if (isAuthorized) location.href = "/video";
            else loginMessage.text(response);
        }
    });
});
loginMessage.on("change", function () {
    $(this).fadeOut(function () {
        $(this).css("color", "red").fadeIn(function () {
            setTimeout(function () {
                $(this).fadeOut();
            }, 2000);
        });
    });
});
$("body").bind('keypress', function (e) {
    if (e.which == 13) {
        loginButton.click();
    }
}).fadeIn();
username.val("");
username.val("");
username.focus();
