/**
 * Created by abrainerd on 3/1/2016.
 */

var mousetimeout;
var screensaver_active = false;
var idletime = 900;
var counter = 0;
var tapAnywhere;

function show_screensaver() {
    $("title").text("UMCU Screensaver");
    $("#decoy").focus();
    $("#decoy").blur();
    $('#screensaver').fadeIn();
    screensaver_active = true;
    counter = 0;

    if (screensaver_active) {
        $('#screensaver').html(
            "<h1 id='tap-anywhere'>UMCU Lobby Check-In</h1>" +
            "<h2 id='tap-anywhere2'>Tap Anywhere to Get Started</h2>"
        );
    }
}

function stop_screensaver() {
    $("title").text("UMCU Parking App");
    console.log("Screensaver ran for " + counter + " seconds");
    if (counter > 30) {
        $("body").fadeOut(function () {
            $('#screensaver').fadeOut();
            location.reload();
        });
    }
    else {
        $('#screensaver').fadeOut();
    }
    screensaver_active = false;
    counter = 0;
    clearInterval(tapAnywhere);
    if ($("#closeReport").css("display") == "block" && counter > 15) {
        $("body").fadeOut(function () {
            location.reload();
        });
    }
}

function reset_screensaver() {
    clearTimeout(mousetimeout);

    if (screensaver_active) {
        stop_screensaver();
    }

    mousetimeout = setTimeout(function () {
        show_screensaver();
    }, 1000 * idletime);
    counter = 0;
}

$(document).ready(function () {
    mousetimeout = setTimeout(function () {
        show_screensaver();
    }, 1000 * idletime);
    var myTimer = setInterval(function () {
        counter++;
    }, 1000);

});

$(document).click(function () {
    reset_screensaver();
});

$("#screensaver").click(function () {
    reset_screensaver();
});

$(document).keyup(function () {
    reset_screensaver();
});

$(document).mousemove(function () {
    reset_screensaver();
});