/**
 * Created by abrainerd on 4/6/2016.
 */

$(document).ready(function () {
    var select = $("#chooseVideo");
    var filein = $("#videoUpload");
    var upload = $("#uploadButton");
    $("#uploading").hide();

    select.click(function () {
        $("#videoUpload").click();
    });

    filein.change(function () {
        console.log("File input change");
        var path;
        var title;
        var w;
        var color;
        path = filein.val().toString().substring(4);
        path = path.substring(path.indexOf("\\") + 1);
        title = path; //.substring(0, path.indexOf("."));
        w = title.length * 11;
        color = "white";
        if (title == "") {
            title = "Select Video to Upload";
            w = 200;
            color = "#ffcb05";
        }
        console.log("Number of characters: " + title.length);
        console.log("Setting width to " + w);
        select.css("width", w + "px");
        select.css("background", color);
        select.text(title);
    });

    upload.click(function () {
        //upload.attr("disabled");
        $("#uploading").fadeIn("slow");
    });
});