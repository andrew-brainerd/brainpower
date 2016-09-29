/**
 * Created by abrainerd on 4/14/2016.
 */

//JUST AN EXAMPLE, PLEASE USE YOUR OWN PICTURE!
var imageAddr = "//notmuchhappening.com/umcu/img/lizard.jpg";
var downloadSize = 2965000; //bytes

$(document).ready(function () {
    var startTime, endTime;
    var download = new Image();
    download.onload = function () {
        endTime = (new Date()).getTime();
        var duration = (endTime - startTime) / 1000;
        var bitsLoaded = downloadSize * 8;
        var speedBps = (bitsLoaded / duration).toFixed(2);
        var speedKbps = (speedBps / 1024).toFixed(2);
        var speedMbps = (speedKbps / 1024).toFixed(2);
        console.log("It took " + duration + " seconds to download the image");
        console.log("Your connection speed is: " + speedMbps + " Mbps");
    };

    startTime = (new Date()).getTime();
    var cacheBuster = "?nnn=" + startTime;
    download.src = imageAddr + cacheBuster;
});
