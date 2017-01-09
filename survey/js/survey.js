/**
 * Created by abrainerd on 1/9/2017.
 */

var positive = $("#positive");
var neutral = $("#neutral");
var negative = $("#negative");
var satisfaction = $("#container").find("img");
var visitReason = $("#reason");
var additionalComments = $("#memberComments");
var submit = $("#surveySubmit");
var selectedLevel;

satisfaction.click(function () {
    selectedLevel = $(this).attr("id");
    satisfaction.each(function () {
        $(this).css("opacity", "0.7");
    });
    $(this).css("opacity", "1");
    //setView(2);
});
submit.click(function () {
    switch (selectedLevel) {
        case "positive": selectedLevel = 3; break;
        case "neutral": selectedLevel = 2; break;
        case "negative": selectedLevel = 1; break;
        default: console.log("mucked it up");
    }
    $.ajax({
        type: "POST",
        url: "util/survey.php",
        data: "satisfaction=" + selectedLevel +
            "&reason=" + visitReason.val() +
            "&comments=" + additionalComments.val(),
        success: function (message) {
            alert(message);
            //clearForm();
            //setView(1);
        }
    });
});