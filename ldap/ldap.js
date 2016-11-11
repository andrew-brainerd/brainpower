/**
 * Created by abrainerd on 11/10/2016.
 */

var queryID = 1;
$(document).tooltip({
    //track: true,
    position: {
        my: "right",
        at: "right",
        of: "form"
    },
    content: function () {
        return "<img src='" + $(this).attr("data-img-src") + "' alt='User Photo'/>";
    }
});
$(document).bind("keypress.key13", function (e) {
    if (e.which == 13) {
        e.preventDefault();
        $("#submit").click();
    }
});
var page = $("body");
var updateTimer = setInterval(findLocked, 60000); // every 3 minutes = 180000
page.hide();
var message = $("#message");
function findLocked() {
    console.log("Updating...[" + queryID + "]");
    $.ajax({
        type: "GET",
        url: "getLockedUsers.php",
        data: "q=" + queryID,
        success: function (msg) {
            message.html(msg);
            page.fadeIn();
            queryID++;
            $(".unlock").click(function () {
                console.log($(this).attr("data-dn"));
                var args = "dn=" + $.trim($(this).attr("data-dn")) + "&cntplzwrk=" + queryID;
                if (queryID > 500) location.reload();
                $.ajax({
                    type: "POST",
                    url: "unlock.php",
                    data: args,
                    success: function (data, status) {
                        console.log(data);
                        page.fadeOut(function () {
                            findLocked();
                        });
                        //location.reload();
                    },
                    complete: function () {
                        console.log("URL: lobby.umcu.org/ldap/unlock.php/?" + args);
                    },
                    error: function (data, status) {
                        console.log("Data: %o", data);
                        console.log("Status: " + status);
                    }
                });
            });
        },
        error: function (err) {
            console.log("Failed");
            console.log(err);
        }
    });
}
function runTest() {
    if ($("#username").val() == "") return;
    console.log("Running runTest...");
    $.ajax({
        type: "GET",
        url: "testADLogin.php",
        data: "username=" + $("#username").val() +
        "&password=" + $("#password").val(),
        success: function (msg) {
            console.log("done running");
            $("#message").html(msg);
            var selected = $(".selected");
            $("html, body").animate({
                scrollTop: selected.offset().top - 200
            }, 1000);
            selected.click(function () {
                $("html, body").animate({
                    scrollTop: $("html").offset().top
                }, 1);
            });
            $(".row:not(:first-child)").attr("title", "Some Title");
            queryID++;
        },
        error: function (err) {
            console.log("Failed");
            console.log(err);
        }
    });
}