/**
 * Created by andrew on 8/17/15.
 */
var branch;
var branches = $("#branches");
branches.hide();
var branchList = $("#branchList");
var locations = {
    "Huron": {
        "latitude": 42.280808,
        "longitude": -83.744353
    },
    "William": {
        "latitude": 42.278058,
        "longitude": -83.744963
    },
    "Plymouth": {
        "latitude": 42.303166,
        "longitude": -83.709331
    },
    "Pierpont": {
        "latitude": 42.291303,
        "longitude": -83.717435
    },
    "State": {
        "latitude": 42.247602,
        "longitude": -83.738531
    },
    "Jackson": {
        "latitude": 42.286642,
        "longitude": -83.817939
    },
    "Union": {
        "latitude": 42.275196,
        "longitude": -83.741515
    },
    "Dearborn": {
        "latitude": 42.321687,
        "longitude": -83.232411
    },
    "Bristol": {
        "latitude": 42.974510,
        "longitude": -83.687144
    },
    "Genesys": {
        "latitude": 42.892772,
        "longitude": -83.636418
    },
    "County": {
        "latitude": 43.009918,
        "longitude": -83.686364
    },
    "Eastern": {
        "latitude": 42.251045,
        "longitude": -83.618649
    }
};
var distances = [];
var page = $("body");
buildBranchList();
var branchButtons = branchList.find("[data-role=button]");
//branchButtons.hide();

branchButtons.click(function () {
    console.log("Branch Clicked: " + $(this).attr("id"));
    sessionStorage.setItem("branch", $(this).attr("id"));
    page.fadeOut(function () {
        location.href = "/manage/?team";
    });
});

if (typeof(Number.prototype.toRadians) === "undefined") {
    Number.prototype.toRadians = function () {
        return this * Math.PI / 180;
    }
}
function buildBranchList() {
    $.each(locations, function (l) {
        branchList.append("<div><div id='" + l + "' data-role='button'>" + l + "</div></div>");
    });
}
function getLocation(mobile) {
    console.log("Mobile: " + mobile);
    if (mobile != undefined) {
        if (navigator.geolocation) {
            //navigator.geolocation.getCurrentPosition(calcDistance, showError);
            //page.fadeIn();
        }
        else {
            // if (isTeamMember) branchButton.fadeIn();
            alert("Geolocation is not supported by this browser");
        }
    }
    else {
        //branchButtons.fadeIn();
        page.fadeIn();
    }
}
function calcDistance(p) {
    console.log("Calculating Distance");
    var userLat = p.coords.latitude;
    var userLon = p.coords.longitude;

    $.each(locations, function (l) {
        branches.append("<option value='" + l + "'>" + l + "</option>");
        var R = 6371000; // metres
        var lat1R = userLat.toRadians();
        var lat2R = this.latitude.toRadians();
        var latDR = (this.latitude - userLat).toRadians();
        var lonDR = (this.longitude - userLon).toRadians();

        var a = Math.sin(latDR / 2) * Math.sin(latDR / 2) +
            Math.cos(lat1R) * Math.cos(lat2R) *
            Math.sin(lonDR / 2) * Math.sin(lonDR / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        distances.push([l, d]);
    });

    var closest = "";
    var min = 6371000 * 2; // circumference of the earth
    for (var j = 0; j < distances.length; j++) {
        var branchName = "<td class='" + distances[j][0] + "'>" + distances[j][0] + "</td>";
        var branchDistance = "<td class='" + distances[j][0] + "'>" + Math.round(distances[j][1]) + "</td>";
        $("#distances").append("<tr>" + branchName + branchDistance + "</tr>");

        if (distances[j][1] < min) {
            min = distances[j][1];
            closest = j;
        }
    }
    branch = distances[closest][0];
    $("." + branch).css({
        "color": "#ffcb05",
        "font-size": "1.5em"
    });
    //$("#" + branch).trigger("click");
}
function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            console.log("User denied the request for Geolocation.");
            page.append("<h3>Location request denied by user</h3>");
            break;
        case error.POSITION_UNAVAILABLE:
            console.log("Location information is unavailable.");
            page.append("<h3>Location information unavailable</h3>");
            break;
        case error.TIMEOUT:
            console.log("The request to get user location timed out.");
            page.append("<h3>Location information timed out</h3>");
            break;
        default:
            console.log("An unknown error occurred.");
            break;
    }
}
function getURLParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}