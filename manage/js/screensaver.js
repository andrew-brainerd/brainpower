/**
 * Created by abrainerd on 3/1/2016.
 */

var mousetimeout;
var screensaver_active = false;
var idletime = 900;
var counter = 0;
var tapAnywhere;
var screensaver = $("#screensaver");
var decoy = $("#decoy");

mousetimeout = setTimeout(function () {
    show_screensaver();
}, 1000 * idletime);
var myTimer = setInterval(function () {
    counter++;
}, 1000);

$(document).click(reset_screensaver);
$(document).keyup(reset_screensaver);
$(document).mousemove(reset_screensaver);
screensaver.click(reset_screensaver);

function show_screensaver() {
    $("title").text("UMCU Screensaver");
    decoy.focus().blur();
    screensaver.fadeIn();
    screensaver_active = true;
    counter = 0;

    if (screensaver_active) {
        screensaver.html(
            "<h1 id='tap-anywhere'>UMCU Lobby Check-In</h1>" +
            "<h2 id='tap-anywhere2'>Tap Anywhere to Get Started</h2>"
        );
    }
}
function stop_screensaver() {
    $("title").text("UMCU Lobby - " + sessionStorage.getItem("branch"));
    if (counter > 30) {
        $("body").fadeOut(function () {
            screensaver.fadeOut();
            location.reload();
        });
    }
    else {
        screensaver.fadeOut();
    }
    screensaver_active = false;
    counter = 0;
    clearInterval(tapAnywhere);
}
function reset_screensaver() {
    clearTimeout(mousetimeout);
    if (screensaver_active) stop_screensaver();
    mousetimeout = setTimeout(function () {
        show_screensaver();
    }, 1000 * idletime);
    counter = 0;
}