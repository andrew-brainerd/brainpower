/**
 * Created by abrainerd on 2/24/2016.
 */

var queryID = 0;          // IE caching fix
var environment = "";
var page = $("body");
var pageTitle = $("title");
var header = $("header");
var logo = header.find("img");
var menuIcon = header.find("#menuIcon");
var inputs = page.find("input:not([type=hidden], [type=date], [type=submit])");
var form = $("#initialForm");
var viewVisitors = $("#viewVisitors");
var visitorRows = viewVisitors.find(".row");
var showReport = $("#report");
var closeReport = $("#closeReport");
var checkIn = $("#checkIn");
var memberActivity = $("#checkOut");
var branch = sessionStorage.getItem("branch");
var vid = $("#vid").val();
var fname = $("#fname");
var lname = $("#lname");
var reason = $("#reason");
var addInfo = $("#addInfo");
var submit = $("#submitForm");
var cancel = $("#cancel");
var reporting = $("#reporting");
var logOut = $("#logOut");
var reportForm = $("#downloadReport");
var download = $("#download");
var branchList = $("#branchList");
var nameInfo = $("#nameInfo");
var visitInfo = $("#visitInfo");
var next = $("#next");
var isTeamMember = $("#team").val() == "true";
var draggedVID;
var updateElements;
var visitDetailElements;
var updateTimer = setInterval(fetchVisitors, 180000);
var isPageReload;
var prevID = 0;
var nav = [checkIn, memberActivity, reporting, logOut];

checkRedirect();
pageTitle.text("UMCU Lobby - " + branch);
updateSelected(sessionStorage.getItem("selected"));
inputs.addClass("textIndent");
page.find("#closingNote").remove();
if (isTeamMember) {
    //console.log("Team Member: " + isTeamMember);
    //form.hide();
    //setView(memberActivity);
    fetchVisitors();
    fetchBranches();
} else {
    form.css("margin-top", "160px");
}
visitInfo.hide();
viewVisitors.hide();
reportForm.hide();
hideAdditionalInfo();
fetchReasons();
clearForm();
checkEnvironment();
bindEnterKey(submit);

next.click(function () {
    var hasAppointment = $("#toggle1").val();
    if ($.trim(fname.val()) != "" && $.trim(lname.val()) != "") {
        nameInfo.fadeOut(function () {
            visitInfo.fadeIn();
            if (hasAppointment) {
                showAdditionalInfo("Meeting With", "With");
            }
        });
    }
});
logo.click(function () {
    location.reload();
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
checkIn.click(function () {
    updateSelected($(this).attr("id"));
    setView($(this));
});
memberActivity.click(function () {
    updateSelected($(this).attr("id"));
    setView($(this));
});
reporting.click(function () {
    updateSelected($(this).attr("id"));
    setView($(this));
});
logOut.click(function () {
    location.href = "/lobby/?branch=" + branch;
});
menuIcon.click(function () {
    console.log("Clicked Menu Icon");
    var navBar = $("#topNav");
    if (navBar.hasClass("responsive")) {
        navBar.removeClass("responsive");
    }
    else {
        navBar.addClass("responsive");
        $(".reponsive").find("li").click(function () {
            navBar.removeClass("responsive");
        });
    }
});
download.click(function () {
    var startDate = $("#reportStartDate").val();
    var endDate = $("#reportEndDate").val();
    if (startDate == "") return alert("Please Enter a Start Date");
    if (endDate == "") return alert("Please Enter an End Date");
    if (new Date(startDate).getTime() > new Date(endDate).getTime())
        return alert("Please enter a start date that is before the end date");
    reportForm.submit();
});
page.fadeIn(function () {
    page.scroll();
});

function showPopupMessage() {
    form.fadeOut("slow", function () {
        clearForm();
        form.fadeIn("slow");
    });
    /*var popup = $("#thankYou");
     popup.fadeIn("slow", function () { clearForm(); });
     setTimeout(function () { popup.fadeOut("slow"); }, 3000);*/
}
function fetchVisitors() {
    var sd = "", noteText = "";
    $.ajax({
        type: "POST",
        url: "util/viewVisitors.php",
        data: "searchDate=" + sd +
        "&queryID=" + queryID +
        "&branch=" + branch,
        success: function (msg) {
            viewVisitors.html(msg);
            $(".tableContainer").droppable({
                activate: function (event, ui) {
                    $(this).addClass("pickMe");
                },
                deactivate: function () {
                    $(this).removeClass("pickMe");
                },
                drop: function (event, ui) {
                    $(this).removeClass("almostHaveIt");
                    var visitorID = ui.helper.attr("data-vid");
                    var dragStatus = ui.helper.attr("data-status");
                    var dropStatus = parseInt($(this).attr("id").replace("status", ""));
                    //console.log("drag: " + visitorID + "    drag: " + dragStatus + "    drop: " + dropStatus);
                    if (dragStatus == dropStatus) return;
                    //var status, statusText;
                    switch (dropStatus) {
                        case 0:
                            updateStatus(visitorID, dropStatus);
                            break;
                        case 1:
                            updateInfoBox(visitorID, dropStatus);
                            break;
                        case 2:
                            updateInfoBox(visitorID, dropStatus);
                            break;
                        default:
                            console.log("Mucked it up. Nice Job");
                    }
                    $(this).removeClass("almostHaveIt").addClass("droppedTheMic");
                },
                greedy: true,
                out: function () {
                    $(this).removeClass("almostHaveIt");
                },
                over: function () {
                    $(this).addClass("almostHaveIt")
                }
            });
            $(".row:not(.noHover, .viewHeader)")
                .draggable({
                    helper: "clone"
                })
                .click(function () {
                    if ($(this).hasClass(("ui-draggable-dragging"))) return;
                    var visitorID = $(this).attr("data-vid");
                    var currentStatus = parseInt($(this).attr("data-status"));
                    updateInfoBox(visitorID, currentStatus + 1);
                });
            $(".detailsButton").click(function () {
                showDetailsBox($(this).attr("data-vid"));
            });
            var now = new Date().toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
            console.log("Query #" + queryID + " at " + now);
            queryID++;
            if (queryID > 500) location.reload();
        }
    });
}
function clearForm() {
    fname.val("");
    fname.prev("label").css("right", "0").text("First Name");
    lname.val("");
    lname.prev("label").css("right", "0").text("Last Name");
    reason.val("-1");
    addInfo.val("");
    hideAdditionalInfo();
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
function fetchBranches() {
    $.ajax({
        type: "POST",
        url: "util/getBranches.php",
        success: function (data) {
            branchList.html(data);
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
    if (branch == "") location.href = "?redirect=instant";
    else if (branch == "Huron") location.href = "/parking/?branch=Huron";
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
function updateStatus(visitorID, status, updateInfo) {
    $.ajax({
        type: "POST",
        url: "util/updateStatus.php",
        data: "vid=" + visitorID +
        "&status=" + status +
        "&updateInfo=" + updateInfo,
        success: function (msg) {
            if (msg.indexOf("Failed") > -1) console.log("Error: " + msg);
            else console.log("SQL: " + msg);
            //console.log("vid=" + dragID + "&status=" + status);
            if (updateInfo != "" && updateInfo != undefined)
                updateElements.fadeOut(function () {
                    updateElements.remove();
                });
            fetchVisitors();
        }
    });
}
function updateInfoBox(visitorID, status) {
    updateElements = $("<div class='popup' id='updateVisitor'></div>");
    var title = (status == 1) ? "Please Enter Your User Number" : "Check-Out Visitor";
    var submitText = (status == 1) ? "OK" : "Check Out";
    var popup = $("<div id='updateInfo'></div>");
    var wall = $("<div id='theWall'></div>");
    var noteInput = $("<textarea id='updateInfoText'></textarea>");
    var buttonContainer = $("<div id='buttonContainer'></div>");
    var confirm = $("<input type='button' id='confirmUpdate' value='" + submitText + "'/>");
    var cancel = $("<input type='button' id='cancelUpdate' value='Cancel'/>");
    buttonContainer.append(confirm);
    buttonContainer.append(cancel);
    popup.append("<h3>" + title + "</h3>");
    popup.append(noteInput);
    popup.append(buttonContainer);
    popup.css("top", header.height());
    wall.css("top", header.height());
    updateElements.append(popup);
    updateElements.append(wall);
    page.prepend(updateElements);
    bindEnterKey(confirm);
    noteInput.focus();
    confirm.click(function () {
        var noteText = $.trim($("#updateInfoText").val());
        if (noteText == "") {
            return alert((status == 1) ? "Please enter valid user number" : "Please enter a closing note");
        }
        updateStatus(visitorID, status, noteText);
        bindEnterKey(submit);
    });
    cancel.click(function () {
        updateElements.fadeOut(function () {
            updateElements.remove();
        });
        bindEnterKey(submit);
    });
    wall.click(function () {
        updateElements.fadeOut(function () {
            updateElements.remove();
        });
    });
}
function updateSelected(selectedItem) {
    $.each(nav, function () {
        $(this).removeClass("selected");
    });
    if (selectedItem == null || selectedItem == undefined) {
        selectedItem = checkIn;
        if (selectedItem == null) console.log("is null");
        if (selectedItem == undefined) console.log("is undefined");
    }
    else {
        isPageReload = true;
        selectedItem = $("#" + selectedItem);
    }
    sessionStorage.setItem("selected", selectedItem.attr("id"));
    selectedItem.addClass("selected");
    setView(selectedItem);
}
function bindEnterKey(button) {
    $(document).unbind("keypress.key13");
    $(document).bind("keypress.key13", function (e) {
        if (e.which == 13) {
            e.preventDefault();
            console.log("Hit enter: clicking " + button.attr("id"));
            button.click();
        }
    });
}
function showDetailsBox(vid) {
    console.log("Building Detail Box");
    $.ajax({
        type: "POST",
        url: "util/getVisitDetails.php",
        data: "branch=" + branch + "&vid=" + vid,
        success: function (msg) {
            visitDetailElements = $("<div class='popup' id='updateVisitor'></div>");
            var popup = $("<div id='visitDetails'></div>");
            var wall = $("<div id='theWall'></div>");
            popup.html(msg);
            popup.css("top", header.height());
            wall.css("top", header.height());
            visitDetailElements.append(popup);
            visitDetailElements.append(wall);
            page.prepend(visitDetailElements);
            wall.click(function () {
                visitDetailElements.fadeOut(function () {
                    visitDetailElements.remove();
                });
            });
        }
    });
}
function setView(view) {
    view = view.attr("id");
    page.find("#closingNote").remove();
    if (view == "checkIn") {
        viewVisitors.fadeOut(function () {
            reportForm.fadeOut(function () {
                visitInfo.fadeOut(function () {
                    bindEnterKey(submit);
                    form.fadeIn();
                });
            });
        });
    }
    else if (view == "checkOut") {
        form.fadeOut(function () {
            reportForm.fadeOut(function () {
                viewVisitors.fadeIn();
            });
        });
    }
    else if (view == "reporting") {
        form.fadeOut(function () {
            viewVisitors.fadeOut(function () {
                //clearTimeout(updateTimer);
                bindEnterKey(download);
                reportForm.fadeIn();
            });
        });
    }
    else {
        console.log("nothing matched");
    }
}