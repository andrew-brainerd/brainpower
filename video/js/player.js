/**
 * Created by abrainerd on 3/15/2016.
 */

var playing = false;
var video;
var fadeSpeed = "slow";
var libraryTitle = "UMCU Video Library";
var playerView = $("#player");
var libraryView = $("#library");
var pageTitle = $("#title");

$(".video:not(.missingVideo)").click(function () {
    var vidURL = $(this).attr("data-path");
    var vidTitle = $(this).text();
    var vid = $(this).attr("data-vid");
    libraryView.fadeOut(fadeSpeed, function () {
        loadVideo(vidURL, vid);
        playerView.fadeIn(fadeSpeed);
    });
    pageTitle.fadeOut(fadeSpeed, function () {
        pageTitle.text(vidTitle);
        pageTitle.fadeIn(fadeSpeed);
    });
});
$("#back").click(function () {
    if (playing) {
        video.get(0).pause();
        playing = false;
        loadVideo("");
    }
    playerView.fadeOut(fadeSpeed, function () {
        libraryView.fadeIn(fadeSpeed);
    });
    pageTitle.fadeOut(fadeSpeed, function () {
        pageTitle.text(libraryTitle);
        pageTitle.fadeIn(fadeSpeed);
    });
});

function loadVideo(path, vid) {
    var counter = 0;
    video = $("#video");
    video.prop("src", path);

    var loadTime = setInterval(function () {
        counter++;
        $("#timer").html(counter);
    }, 1000);
    var counted = false;
    video.on("canplaythrough", function () {
        clearInterval(loadTime);
        video.get(0).play();
        var half = video.get(0).duration / 2;
        counter = 0;
        var ct = 0;
        var playTime = setInterval(function () {
            counter++;
            ct = video.get(0).currentTime;
            if ((ct > half || ct > 300) && !counted) {
                counted = true;
                $.ajax({
                    type: "GET",
                    url: "util/updatePlayCount.php",
                    data: "vid=" + vid,
                    success: function (message) {
                        console.log(message + "[" + (ct > half || ct > 300) + "][" + counted + "]");
                        clearInterval(playTime);
                    }
                });
            }
            $("#timer").html("Play time: [" + ct + "]");
        }, 1000);
        playing = true;
    });

    video.click(function () {
        if (playing) {
            video.get(0).pause();
            playing = false;
        }
        else {
            video.get(0).play();
            playing = true;
        }
    });
}

/*$(document).ready(function() {
 console.log("Document Ready :D");
 var counter = 0;
 var playing = false;
 var vid = $("#vid");
 vid.get(0).play();
 setTimeout(function() {
 vid.get(0).pause();
 checkVideoReady();
 }, 1000);
 vid.click(function() {
 if (playing) {
 vid.get(0).pause();
 playing = false;
 }
 else {
 vid.get(0).play();
 playing = true;
 }
 });

 function checkVideoReady() {
 var currBuffer = vid.get(0).buffered.end(0);
 var vidDuration = vid.get(0).duration;
 var myTimer = setInterval(function() {
 counter++;
 //$("#timer").html(counter);
 }, 1000);
 var loadAmt = vidDuration / 2;
 if (currBuffer >= vidDuration - loadAmt) {
 console.log("Video is mostly loaded");
 vid.fadeIn("slow");
 setTimeout(function() { vid.get(0).play(); }, 2000);
 playing = true;
 console.log("Video took " + counter + " seconds to load");
 }
 else {
 setTimeout(function() { checkVideoReady(); }, 1000);
 }
 console.log("Video buffered: " + vid.get(0).buffered.end(0));
 console.log("Video duration: " + vid.get(0).duration);
 }
 });*/