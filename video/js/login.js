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
    var un = $("#username").val();
    var pw = $("#password").val();
    $.ajax({
        type: "POST",
        url: "util/login.php",
        data: "un=" + un +
        "&pw=" + pw,
        success: function (m) {
            console.log("login.php: " + m);
            if (m.indexOf("@") >= 0) {         /* from previous page*/
                url = m.substring(1);
                $("body").fadeOut("fast", function () {
                    location.href = "/video";
                });
            }
            else if (m.indexOf("!") >= 0) {    /* error */
                m = m.substring(1);
                message.fadeOut(function () {
                    message.css("color", "red");
                    message.fadeIn(function () {
                        setTimeout(function () {
                            message.fadeOut();
                        }, 2000);
                    });
                });
                $("#message").html(message);
            }
            else {
                $("#message").empty();
                $("body").fadeOut("fast", function () {
                    location.href = "/video";
                });
            }
            console.log("Login message: " + m);
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

