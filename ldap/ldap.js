/**
 * Created by abrainerd on 11/10/2016.
 */

var counter = 1;
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
function findLocked() {
    console.log("Running findLocked...");
    $.ajax({
        type: "GET",
        url: "getLockedUsers.php",
        data: "q=" + counter,
        success: function (msg) {
            console.log("done running");
            $("#message").html(msg);
            $(".unlock").click(function () {
                console.log($(this).attr("data-dn"));
                counter += counter;
                var args = "dn=" + $.trim($(this).attr("data-dn")) + "&cntplzwrk=" + counter;
                $.ajax({
                    type: "POST",
                    url: "unlock.php",
                    data: args,
                    success: function (data, status) {
                        console.log(data);
                        location.reload();
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
            counter++;
        },
        error: function (err) {
            console.log("Failed");
            console.log(err);
        }
    });
}