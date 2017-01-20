/**
 * Created by abrainerd on 1/9/2017.
 */

var page = $("body");
var positive = $("#positive");
var neutral = $("#neutral");
var negative = $("#negative");
var satisfaction = $("#container").find("img");
var visitReason = $("#reason");
var additionalInfo = $("#additionalInformation");
var additionalComments = $("#memberComments");
var selectedLabel = $("#selectedLabel");
var submit = $("#surveySubmit");
var heading = $("h1");
var selectedLevel;

page.hide();
additionalInfo.hide();

heading.click(function () {
    location.reload();
});
satisfaction.click(function () {
    selectedLevel = $(this).attr("id");
    satisfaction.each(function () {
        $(this).removeClass("selected");
    });
    $(this).addClass("selected");
    selectedLabel.text($(this).attr("alt"));
    selectedLabel.removeClass("transparentText");
});
submit.click(function () {
    if (!selectedLevel) return alert("Please Select A Feeling");
    submit.prop("disabled", true);
    switch (selectedLevel) {
        case "positive": selectedLevel = 3; break;
        case "neutral": selectedLevel = 2; break;
        case "negative": selectedLevel = 1; break;
        default: console.log("mucked it up");
    }
    $.ajax({
        type: "POST",
        url: "util/survey.php",
        data: "satisfaction=" + selectedLevel,
        /*+ "&reason=" + visitReason.val() +
            "&comments=" + additionalComments.val(),*/
        success: function (message) {
            //alert(message);
            page.fadeOut("slow", function () {
                page.html(
                    "<div id='feedbackMessage'>" +
                        "<h1>Thank you for your feedback</h1>" +
                        "<h1>Have an <div>a</div><span>MAIZE</span><div>ing</div> Day!</h1>" +
                    "</div>"
                );
                page.fadeIn("slow");
            });
            setTimeout(function () {
                page.fadeOut("slow", function () {
                    location.reload();
                });
            }, 5000);
        }
    });
});
page.fadeIn("slow");