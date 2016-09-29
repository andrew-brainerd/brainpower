/**
 * Created by abrainerd on 2/24/2016.
 */

//<editor-fold desc="Page Element Declarations">
var $page = $("body");
var $header = $("header");
var $logo = $("header > img");
var $devDisplay = $("#timer");

var $branch = $("#branch");
var $view = $("#goTo");
var $nameInfo = $("#initialForm");
var $prompt = $("#prompt");
var $visitorSearch = $("#search");
var $visitorID = $("#vid");
var $fname = $("#fname");
var $lname = $("#lname");
var $vehicleMake = $("#make");
var $vehicleModel = $("#model");
var $lastVisit = $("#last-visit");
var $visitorConfirm = $("#confirmation");
var $welcomeMessage = $("#welcome");
var $parkingSpot = $("#spotNum");
var $reason = $("#reason");
var $otherSpot = $("#other");
var $otherReason = $("#otherR");
var $additionalInfo = $("#moreInfo");
var $parkingSelection = $("#parkingSelection");
var $parkingMap = $("#parking-map");
var $showMap = $("#showMap");
var $closeMap = $("#closeMap");
var $map = $("#mapPopup");
var $spotTaken = $("#spotTaken");
var $teamMemberEmail = $("#tmEmail");
var $vehicleDescription = $("#vehicleDesc");
var $teamMemberSpot = $("#tmSpot");
var $checkIn = $("#checkIn");
var $cancel = $("#cancel");

var $showReport = $("#report");
var $hideReport = $("#closeReport");

var $visitorList = $("#viewVisitors");

var currentVisitorInfo = [];
var mapVisible = false;
var queryID = 0;          // IE caching fix
var availableSpots;
var promptShown = false;
var spotTaken = false;
var environment = "";

//</editor-fold>

/*var parking_lots = {
 "Huron" : {
 "1": "Visitor",
 "2": "Visitor",
 "3": "Visitor",
 "4": "Visitor",
 "5": "Visitor",
 "25": "Real Estate",
 "26": "Real Estate",
 "29": "Visitor",
 "90": "Loading Dock",
 "97": "Handicap 1",
 "98": "Handicap 2",
 "99": "New Team Member Area"
 },
 "William" : {
 "1": "",
 "2": "",
 "3": "",
 "4": "",
 "5": "",
 "6": "",
 "7": "",
 "8": "",
 "9": "",
 "10": "",
 "11": "",
 "12": "",
 "13": "",
 "14": ""
 }
 };*/

$(document).ready(function () {
    $additionalInfo.hide();
    $parkingSelection.hide();
    $visitorList.hide();
    $hideReport.hide();
    $otherSpot.hide();
    $otherReason.hide();
    $spotTaken.hide();
    $map.hide();

    $fname.val("");
    $lname.val("");
    $vehicleMake.val("");
    $vehicleModel.val("");
    $parkingSpot.val("-1");
    $reason.val("-1");

    checkEnvironment();
    checkRedirect();
    buildMap();

    // Bindings
    $(document).bind('keypress.key13', function (e) {
        if (e.which == 13) {
            $("#new").click();
            $(document).unbind("keypress.key13");
            $(document).bind('keypress.key13', function (e) {
                if (e.which == 13) {
                    $("#next").click();
                }
            });
        }
    });
    $page.fadeIn(function () {
        $page.scroll();
        $lname.focus();
    });
    $fname.keyup(runQuery);
    $lname.keyup(runQuery);
    $logo.click(function () {
        if (mapVisible) {
            $map.hide();
            mapVisible = false;
        }
        else {
            if ($branch.val() == "") {
                location.href = "/?d=instant";
                console.log("No branch");
            }
            else {
                console.log("Branch: [" + $branch.val() + "}");
                if (location.href.indexOf("goto") >= 0) {
                    location.href = "/parking/?branch=" + $branch.val();
                }
                else location.reload();
            }
        }
    });
    $cancel.click(function () {
        location.reload();
    });
    $parkingSpot.change(function () {
        if ($parkingSpot.val() == 0) {
            $otherSpot.show();
        }
        else $otherSpot.hide();
    });
    $reason.change(function () {
        var r = $reason.val();
        if (r == 0) {
            $otherReason.show();
        }
        else {
            $otherReason.hide();
            if (r == "Assigned Spot Taken") {
                //var vid = $("#vid").val();
                //console.log("VID: " + vid);
                $.ajax({
                    type: "POST",
                    url: "checkTeamMember.php",
                    data: "vid=" + $visitorID.val(),
                    success: function (data) {
                        $spotTaken.html(data);
                        $spotTaken.show();
                        spotTaken = true;
                    }
                });
            }
            else {
                $spotTaken.hide();
            }
        }
    });
    $showReport.click(fetchVisitors);
    $hideReport.click(function () {
        $visitorList.fadeOut(function () {
            $hideReport.fadeOut(function () {
                $header.css({"position": "static", "border-bottom": "none"});
                $nameInfo.fadeIn();
                $showReport.fadeIn();
            })
        });
    });
});

function runQuery() {
    var fn = $fname.val();
    var ln = $lname.val();
    if (promptShown == true) {
        if (fn.length > 2 || ln.length > 2) {
            $prompt.hide();
        }
    }

    $.ajax({
        type: "POST",
        url: "checkVisitor.php",
        data: "fname=" + fn +
        "&lname=" + ln,
        success: function (msg) {
            $visitorSearch.html(msg);
            if (fn == "" && ln == "") {
                promptShown = false;
                $prompt.hide();
            }
            else {
                if (!promptShown) {
                    showPrompt();
                    promptShown = true;
                }
            }
        }
    });
}
function showPrompt() {
    var results = $("#results");
    var sw = results.width() + 20;
    var offset = results.offset();
    var sx = offset.left - 10;
    var sy = offset.top;

    var prompt = $("#prompt");
    prompt.css({
        "position": "absolute",
        "width": sw,
        "left": sx,
        "top": sy
    });
    if (prompt.html() == "") {
        var promptOverlay = $("<div id='promptOverlay'></div>");
        var promptArrows = $("<div class='arrow-down'></div><div class='arrow-down'></div>");
        prompt.append(promptOverlay);
        prompt.append(promptArrows);
        var promptText = $("<div id='promptText'></div>");
        var poh = promptOverlay.height();
        promptText.text("Been here before? Select your info here");
        promptOverlay.append(promptText);
        promptText.css("line-height", poh + "px");
        promptShown = true;
    }
    prompt.fadeIn("slow", function () {
        setTimeout(function () {
            prompt.fadeOut("slow");
        }, 1500);
    });
}
function fetchVisitorInfo(vid) {
    var fields = [];
    $visitorID.val(vid);
    $.ajax({
        type: "POST",
        datatype: "html",
        url: "getVisitor.php",
        data: "vid=" + vid,
        success: function (data) {
            var str = $(data).text();
            var start = 0;
            for (var end = 0; end < str.length; end++) {
                if (str[end] == ",") {
                    fields.push(str.substring(start, end));
                    start = end + 1;
                }
            }

            $lname.val(fields[0]);
            $fname.val(fields[1]);
            $vehicleMake.val(fields[2]);
            $vehicleModel.val(fields[3]);
            $lastVisit.val(fields[4]);
            currentVisitorInfo = fields;
            $showReport.fadeOut("fast");
            $visitorSearch.fadeOut("fast", function () {
                $additionalInfo.fadeIn("fast", function () {
                    showConfirmation(true);
                });
            });
        }
    });
}
function fetchVisitors() {
    var sd = "";
    $.ajax({
        type: "POST",
        url: "viewVisitors.php",
        data: "searchDate=" + sd +
        "&branch=" + $branch.val() +
        "&queryID=" + queryID,
        success: function (msg) {
            $visitorList.html(msg);
            $nameInfo.fadeOut();
            $showReport.fadeOut(function () {
                $header.css("position", "fixed");
                $header.css("border-bottom", "3px solid white");
                $visitorList.fadeIn();
                $hideReport.fadeIn();
            });
            queryID++;
        }
    });
}
function showMoreInfo() {
    $showReport.fadeOut("fast");
    $visitorSearch.fadeOut("fast", function () {
        $("#lv-cell").css("display", "none");
        $additionalInfo.fadeIn("fast", function () {
            $vehicleMake.focus();
            showConfirmation(false);
        });
    });
}
function showConfirmation(existingVisitor) {
    if (existingVisitor) {
        $visitorConfirm.html(
            "<h1>PLEASE CONFIRM YOUR INFO</h1>" +
            "<div id='deny' onclick='clearForm()'>NOT ME</div>" +
            "<div id='confirm' onclick='checkUpdate()'>CONFIRM</div>"
        );
    }
    else {
        $visitorConfirm.html(
            "<div id='next' onclick='createNewVisitor()'>NEXT</div>"
        );
    }
    $visitorConfirm.fadeIn("fast");
}
function checkOut(pid) {
    if (pid != -1) {
        var yay = confirm("Checkout Visitor?");
        if (yay) {
            $.ajax({
                type: "POST",
                datatype: "html",
                url: "checkOut.php",
                data: "pid=" + pid,
                success: function (message) {
                    //fetchVisitors();
                    $("#closeReport").click();
                }
            });
        }
    }
    else alert("Visitor already checked out");
}
function clearForm() {
    $additionalInfo.fadeOut("fast");
    //$("#vid").val("");
    $lname.val("");
    $fname.val("");
    $vehicleMake.val("");
    $vehicleModel.val("");
    $lastVisit.val("");
    $visitorConfirm.fadeOut("fast", function () {
        $visitorSearch.empty();
        $visitorSearch.show();
        $showReport.fadeIn();
    });
}
function checkUpdate() {
    var vid = $visitorID.val();
    console.log("Visitor ID is " + vid);
    var fn = $fname.val();
    var ln = $lname.val();
    var mk = $vehicleMake.val();
    var md = $vehicleModel.val();
    if (ln != currentVisitorInfo[0] ||
        fn != currentVisitorInfo[1] ||
        mk != currentVisitorInfo[2] ||
        md != currentVisitorInfo[3]) {
        console.log("Visitor Updated Information");
        $.ajax({
            type: "POST",
            url: "updateVisitor.php",
            data: "vid=" + vid +
            "&fn=" + fn +
            "&ln=" + ln +
            "&mk=" + mk +
            "&md=" + md,
            success: function (data) {
                console.log(data);
                if (data.indexOf("error") > 0)
                    alert(data);
            }
        });
    }
    $welcomeMessage.html("<h1>Welcome Back " + capitalize($fname.val()) + "!</h1>");
    $nameInfo.fadeOut("fast", function () {
        fetchReasons();
        $(document).bind('keypress.key13', function (e) {
            //console.log("key: " + e.which);
            if (e.which == 13) {
                $("#checkIn").click();
            }
        });
        $("#parkingSelection").fadeIn("slow");
    });
}
function createNewVisitor() {
    var fn = $.trim($fname.val());
    var ln = $.trim($lname.val());
    var mk = $.trim($vehicleMake.val());
    var md = $.trim($vehicleModel.val());
    if (fn != "" && ln != "" && mk != "" && md != "") {
        $.ajax({
            type: "POST",
            url: "setVisitor.php",
            data: "&fn=" + fn +
            "&ln=" + ln +
            "&mk=" + mk +
            "&md=" + md,
            success: function (data) {
                $visitorID.val(data);
                $welcomeMessage.html("<h1>Welcome " + capitalize(fn) + "!</h1>");
                $nameInfo.fadeOut("fast", function () {
                    fetchReasons();
                    $parkingSelection.fadeIn("slow");
                });
                $(document).unbind("keypress.key13");
                $(document).bind('keypress.key13', function (e) {
                    console.log("key: " + e.which);
                    if (e.which == 13) {
                        $checkIn.click();
                    }
                });
            }
        });
    }
    else {
        console.log("First Name: " + fn);
        console.log("Last Name: " + ln);
        console.log("Make: " + mk);
        console.log("Model: " + md);
        if (fn == "") console.log("First Name is blank");
        if (ln == "") console.log("Last Name is blank");
        if (mk == "") console.log("Make is blank");
        if (md == "") console.log("Model is blank");
        alert("Please fill all fields");
    }
}
function fetchReasons() {
    $.ajax({
        type: "POST",
        url: "getReasons.php",
        success: function (data) {
            $reason.html(data);
        }
    });
}
function validateCheckIn() {
    var s = $parkingSpot.val();
    var r = $reason.val();
    if (spotTaken) {
        var e = $teamMemberEmail.val();
        var a = $teamMemberSpot.val();
        var v = $vehicleDescription.val();
        if (e == "") {
            alert("Please enter your UMCU username");
            return false;
        }
        if (a == 0) {
            alert("Please enter your spot nubmer");
            return false;
        }
        if (v == "") {
            alert("Please enter vehicle description");
            return false;
        }
    }
    if (s == -1) {
        alert("Please select a parking spot");
        return false;
    }
    else if (s == 0) {
        var o = $.trim($otherSpot.val());
        if (o == "" || o < 1) {
            alert("Please choose other spot number");
            return false;
        }
        if (availableSpots.indexOf(parseInt(o)) > 0) {
            alert("Special Spot chosen. Try again");
            return false;
        }
    }
    if (r == -1) {
        alert("Please provide a reason for your visit");
        return false;
    }
    if (r == 0) {
        var or = $.trim($otherReason.val());
        if (or == "") {
            alert("Please provide a reason for you visit");
            return false;
        }
    }
    $checkIn.prop("disabled", true).css("cursor", "default");
    return true;
}
function checkEnvironment() {
    var loc = window.location.toString();
    if (loc.indexOf("notmuchhappening") > 0) {
        $devDisplay.html("Dev Server");
        environment = "DEV";
    }
    else {
        environment = "LIVE";
    }
}
function checkRedirect() {
    var v = $view.val();
    if (v != "") {
        if (v == "view") {
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
function buildMap() {
    var branch = $branch.val();
    $parkingMap.addClass(branch.toLowerCase());
    if (branch == "Huron") {
        availableSpots = ParkingLots.Huron;
        buildSpotDropdown();
        $parkingMap.append(
            "<div class='left-arrow'></div>" +
            "<label for='area99'>New Team Member Area</label>"
        );
    }
    else if (branch == "William") {
        availableSpots = ParkingLots.William;
        buildSpotDropdown();
    }
    else {
        buildDefaultDropdown();
    }
    $showMap.click(function () {
        mapVisible = true;
        $map.fadeIn("fast");
        buildMap();
    });
    $closeMap.click(function () {
        if (mapVisible) {
            $map.fadeOut();
            mapVisible = false;
        }
    });
    $(".area").click(function () {
        $parkingSpot.val($(this).attr("data-spot"));
        $otherSpot.hide(function () {
            $map.fadeOut();
        });
    });
}
function buildSpotDropdown() {
    $parkingSpot.empty();
    $parkingMap.empty();
    $parkingSpot.append("<option value='-1'>-- Select A Spot --</option>");
    var option;
    $.each(availableSpots, function (spot, designation) {
        //console.log(spot + ": " + designation);
        if (spot < 90 && (spot != "" && designation != "")) {
            option = spot + " - " + designation;
        } else {
            option = designation;
        }
        $parkingSpot.append(
            "<option value='" + spot + "'>" + option + "</option>"
        );
        $parkingMap.append(
            "<div class='area' id='area" + spot + "' data-spot='" + spot + "'></div>"
        );
    });
    $parkingSpot.append("<option value='0'>Other</option>");
}
function buildDefaultDropdown() {
    console.log("Using Default Options");
    $parkingSpot.empty();
    $parkingSpot.append('<option value="-1">-- Select A Spot --</option>');
    $parkingSpot.append('<option value="1">1 - Visitor</option>');
    $parkingSpot.append('<option value="2">2 - Visitor</option>');
    $parkingSpot.append('<option value="3">3 - Visitor</option>');
    $parkingSpot.append('<option value="4">4 - Visitor</option>');
    $parkingSpot.append('<option value="5">5 - Visitor</option>');
    $parkingSpot.append('<option value="25">25 - Real Estate</option>');
    $parkingSpot.append('<option value="26">26 - Real Estate</option>');
    $parkingSpot.append('<option value="29">29 - Visitor</option>');
    $parkingSpot.append('<option value="97">Handicap 1</option>');
    $parkingSpot.append('<option value="98">Handicap 2</option>');
    $parkingSpot.append('<option value="99">New Team Member Area</option>');
    $parkingSpot.append('<option value="90">Loading Dock</option>');
    $parkingSpot.append('<option value="0">Other</option>');

    $parkingMap.append(
        "<div class='left-arrow'></div>" +
        "<label for='area99'>New Team Member Area</label>"
    );
    $parkingMap.addClass("huron");
    availableSpots = [1, 2, 3, 4, 5, 25, 26, 29, 90, 97, 98, 99];
    for (var cs in availableSpots) {
        $parkingMap.append(
            "<div class='area' id='area" + availableSpots[cs] + "' data-spot='" + availableSpots[cs] + "'></div>"
        );
    }
}