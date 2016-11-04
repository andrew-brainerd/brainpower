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