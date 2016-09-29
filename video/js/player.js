/**
 * Created by abrainerd on 3/15/2016.
 */

var playing = false;
var video;
var fadeSpeed = "slow";

$(document).ready(function () {
    /*var loc = window.location.toString();*/
    var libraryTitle = "UMCU Video Library";
    /*if (loc.indexOf("itonly") > 0)
     libraryTitle = "IT Video Library";*/
    var playerView = $("#player");
    var libraryView = $("#library");
    var pageTitle = $("#title");
    $(".video").click(function () {
        var vidURL = $(this).attr("data-path");
        var vidTitle = $(this).text();
        var vid = $(this).attr("data-vid");
        //console.log(vidURL);
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
});

function loadVideo(path, vid) {
    var counter = 0;
    video = $("#video");
    //var source = $("#vid source");
    //$("#title").text(title);
    video.prop("src", path);
    /*var backdrop = $("<div id='backdrop'></div>");
     backdrop.css("background", "black");
     backdrop.css("width", video.prop("width"));
     backdrop.css("height", video.prop("height"));
     backdrop.css("position", "relative");
     backdrop.css("top", $("#player").position().top);
     backdrop.css("left", video.position().left);
     $("body").append(backdrop);*/
    //console.log("Video width: " + video.prop("width"));
    //console.log("Video height: " + video.prop("height"));

    var loadTime = setInterval(function () {
        counter++;
        $("#timer").html(counter);
    }, 1000);
    var counted = false;
    video.on("canplaythrough", function () {
        //console.log("Ready to play " + path + " after " + counter + " seconds");
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