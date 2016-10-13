/**
 * Created by abrainerd on 2/24/2016.
 */

var queryID = 0;          // IE caching fix
var environment = "";
var page = $("body");
var header = $("header");
var logo = header.find("img");
var inputs = page.find("input");
var form = $("#initialForm");
var viewVisitors = $("#viewVisitors");
var visitorRows = viewVisitors.find(".row");
var showReport = $("#report");
var closeReport = $("#closeReport");
var branch = $("#branch");
var vid = $("#vid").val();
var fname = $("#fname");
var lname = $("#lname");
var reason = $("#reason");
var addInfo = $("#addInfo");
var submit = $("#submitForm");
var cancel = $("#cancel");
var draggedVID;

checkRedirect();
inputs.addClass("textIndent");
page.find("#closingNote").remove();
viewVisitors.hide();
closeReport.hide();
hideAdditionalInfo();
fetchReasons();
clearForm();
checkEnvironment();

$(document).bind('keypress.key13', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        submit.click();
    }
});

page.fadeIn(function () {
    page.scroll();
});
logo.click(function () {
    var loc = location.href;
    if (loc.indexOf("goto") >= 0) {
        window.location.href = "index.php";
    }
    else {
        location.reload();
    }
});
inputs.on("focus", function () {
    //console.log("You focused an input!");
    var inputLabel = $(this).prev("label");
    inputLabel.css("right", "80px");
    var altText = inputLabel.data("alt");
    //if (altText != "" && altText != undefined) altText = altText + ":"; else altText = "|";
    if (inputLabel.text().indexOf(" ") > 0) inputLabel.text(altText + ": ");
    //showReport.hide();
});
inputs.on("blur", function () {
    //console.log("You left an input!");
    $(this).val(capitalize($.trim($(this).val())));
    var inputLabel = $(this).prev("label");
    var elementType = inputLabel.prop("nodeName");
    if ($(this).val() == "") {
        inputLabel.css("right", "0").text(inputLabel.attr("title"));
    }
    showReport.show();
});
inputs.on("keyup", function () {
    var inputLabel = $(this).prev("label");
    if ($(this).val().length >= 12) {
        $(this).removeClass("textIndent");
        inputLabel.css({"color": "transparent", "right": "0"});
    } else {
        $(this).addClass("textIndent");
        //inputLabel.css({"color": "inherit", "right": ""});
    }
});
reason.focus(function () {
    var label = $(this).prev("label");
    $("#report").hide();
});
reason.blur(function () {
    showReport.show();
    $("html, body").animate({
        scrollTop: 0
    }, 0);
});
reason.change(function () {
    var r = reason.val();
    if (r == 0) {
        showAdditionalInfo("Other Reason", "");
    }
    else if (r == "Appointment") {
        showAdditionalInfo("Meeting With", "With");
    }
    else {
        hideAdditionalInfo();
    }
});
cancel.click(function () {
    clearForm();
});
submit.click(function () {
    if (!submit.hasClass("disabled")) {
        var r = reason.val() == 0 ? addInfo.val() : reason.val();
        if (reason.val() == "Appointment") {
            r = "Appt w/" + addInfo.val();
        }
        if (validateCheckIn()) {
            $.ajax({
                type: "POST",
                url: "util/setVisitor.php",
                data: "fname=" + fname.val() +
                "&lname=" + lname.val() +
                "&reason=" + r +
                "&branch=" + $("#branch").val(),
                success: function () {
                    showPopupMessage();
                }
            });
        }
    }
});
showReport.click(fetchVisitors);
closeReport.click(function () {
    page.find("#closingNote").remove();
    viewVisitors.fadeOut(function () {
        closeReport.fadeOut(function () {
            header.css({"position": "static", "border-bottom": "none"});
            form.fadeIn();
            showReport.fadeIn();
        });
    });
});

function showPopupMessage() {
    page.fadeOut("slow", function () {
        clearForm();
        showReport.show();
        page.fadeIn("slow");
    });
    /*var popup = $("#thankYou");
    popup.fadeIn("slow", function () {
        clearForm();
    });
    setTimeout(function () {
        popup.fadeOut("slow", function () {
     showReport.fadeIn();
        });
     }, 3000);*/
}
function fetchVisitors() {
    var sd = "", noteText = "";
    $.ajax({
        type: "POST",
        url: "util/viewVisitors.php",
        data: "searchDate=" + sd +
        "&queryID=" + queryID +
        "&branch=" + branch.val(),
        success: function (msg) {
            viewVisitors.html(msg);
            form.fadeOut();
            showReport.fadeOut(function () {
                header.css({"position": "fixed", "border-bottom": "3px solid white"});
                $(".tableContainer").droppable({
                    activate: function (event, ui) {
                        $(this).addClass("pickMe");
                    },
                    deactivate: function () {
                        $(this).removeClass("pickMe");
                    },
                    drop: function (event, ui) {
                        $(this).removeClass("almostHaveIt");
                        var dragID = ui.helper.attr("data-vid");
                        var dropID = $(this).attr("id");
                        console.log("drag: " + dragID + "    drop: " + dropID);
                        var status, statusText;
                        switch (dropID) {
                            case "status0":
                                status = 0;
                                statusText = "Waiting";
                                break;
                            case "status1":
                                status = 1;
                                statusText = "With MSR";
                                break;
                            case "status2":
                                status = 2;
                                statusText = "Done";
                                addCheckoutNote();
                                break;
                            default:
                                console.log("Mucked it up. Nice Job");
                        }
                        $(this).removeClass("almostHaveIt").addClass("droppedTheMic");
                        $.ajax({
                            type: "POST",
                            url: "util/updateStatus.php",
                            data: "vid=" + dragID +
                            "&status=" + status +
                            "&noteText=" + noteText,
                            success: function (msg) {
                                console.log("vid=" + dragID + "&status=" + status);
                                fetchVisitors();
                            }
                        });
                    },
                    greedy: true,
                    out: function () {
                        $(this).removeClass("almostHaveIt");
                    },
                    over: function () {
                        $(this).addClass("almostHaveIt")
                    }
                });
                $(".row").draggable({
                    helper: "clone",
                    start: function (event, ui) {
                        $(ui.helper).attr("class", $(this).attr("id"));
                        //console.log("Helper ID: " + $(ui.helper).attr("class"));
                    }
                }).click(function () {
                    if ($(this).hasClass(("ui-draggable-dragging"))) return;
                    console.log("I was clicked on");
                });
                viewVisitors.fadeIn();
                closeReport.fadeIn();
            });
            queryID++;
        }
    });
}
function helpMember(vid) {
    if (vid != -1) {
        if (confirm("Assist This Member?")) {
            $.ajax({
                type: "POST",
                url: "util/updateStatus.php",
                data: "vid=" + vid + "&status=1",
                success: function (msg) {
                    fetchVisitors();
                }
            });
        }
    }
}
function finalNote(vid, row) {
    if (vid != -1) {
        console.log("Class: " + row.attr("class"));
        page.find("#closingNote").remove();
        viewVisitors.find(".row").removeClass("selected");
        row.addClass("selected");
        console.log("Row onClick: " + row.attr("onclick"));
        row.on("click.selected", function () {
            row.removeClass("selected");
            page.find("#closingNote").remove();
            row.off("click.selected");
        });
        var finalNote = $("<div id='closingNote'></div>");
        finalNote.append("<label for='note'>How did we aMAIZE this member today?</label>");
        finalNote.append("<textarea id='note'></textarea>");
        finalNote.css({
            "width": row.width(),
            "height": row.height(),
            "left": row.offset().left,
            "top": row.offset().top + row.height()
        });
        var dasButton = $("<input id='addNote' type='button' value='Done' onclick='checkout(" + vid + ")'/>");
        dasButton.css({
            "height": finalNote.height(),
            "left": finalNote.width(),
            "top": -20 //finalNote.offset().top
        });
        finalNote.append(dasButton);
        page.append(finalNote);
    }
    else alert("Visitor already checked out");
}
function checkout(vid) {
    if (vid != -1) {
        var noteText = $("#note").val();
        $.ajax({
            type: "POST",
            url: "util/updateStatus.php",
            data: "vid=" + vid +
            "&noteText=" + noteText +
            "&status=2",
            success: function (msg) {
                page.find("#closingNote").remove();
                fetchVisitors();
            }
        });
    }
}
function clearForm() {
    fname.val("");
    fname.prev("label").css("right", "0").text("First Name");
    lname.val("");
    lname.prev("label").css("right", "0").text("Last Name");
    reason.val("-1");
    addInfo.hide();
    addInfo.val("");
    submit.removeClass("disabled");
}
function fetchReasons() {
    $.ajax({
        type: "POST",
        url: "util/getReasons.php",
        success: function (data) {
            reason.html(data);
        }
    });
}
function validateCheckIn() {
    if (fname.val() == "") {
        alert("Please enter your first name");
        return false;
    }
    if (lname.val() == "") {
        alert("Please enter your last name");
        return false;
    }
    if (reason.val() == -1) {
        alert("Please provide a reason for your visit");
        return false;
    }
    else if (reason.val() == 0) {
        if ($.trim(addInfo.val()) == "") {
            alert("Please provide a reason for you visit");
            return false;
        }
    }
    submit.addClass("disabled");
    return true;
}
function checkEnvironment() {
    var loc = window.location.toString();
    if (loc.indexOf("notmuchhappening") > 0) {
        $("#timer").html("Dev Server");
        environment = "DEV";
    }
    else {
        environment = "LIVE";
    }
}
function checkRedirect() {
    branch = $("#branch");
    if (branch.val() == "") location.href = "https://umculobby.com?d=instant";
    //else if (branch.val() == "William") location.href = "https://umculobby.com/parking/?branch=William";
    else if (branch.val() == "Huron") location.href = "https://umculobby.com/parking/?branch=Huron";
    var g = $("#goTo").val();
    if (g != "") {
        if (g == "view") {
            fetchVisitors();
        }
        else {
            console.log("Invalid redirect");
        }
    }
}
function capitalize(s) {
    return s.charAt(0).toUpperCase() + s.slice(1);
}
function showAdditionalInfo(labelText, altText) {
    addInfo.prev("label").attr("title", labelText).text(labelText).data("alt", altText).show();
    addInfo.show();
}
function hideAdditionalInfo() {
    addInfo.prev("label").hide();
    addInfo.hide();
}
function addCheckoutNote() {
    var popup = $("<div id='checkoutNote'></div>");
    popup.position(header.position());
    page.prepend(popup);
}