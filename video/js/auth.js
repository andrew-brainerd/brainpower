/**
 * Created by abrainerd on 4/1/2016.
 */

$.ajax({
    type: "GET",
    url: "/video/util/auth.php",
    data: "func=getAuth&internal=" + getURLParameter("maizenet"),
    success: function (response) {
        console.log("Response: " + response);
        var isAuthorized = response == "authorized";
        if (isAuthorized) {
            $("body").fadeIn();
        } else {
            $("body").fadeOut();
            location.href = "/video/login.html";
        }
    }
});
function getURLParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}