/**
 * Created by abrainerd on 11/23/2016.
 */

var appName = "UMCU Lobby Management";
var isRegistered = false;
//appName = "Javascript Example App";

window.onload = function(){
    var config = {};
    //config.scope = "Growl"; //optional
    //config.containerID = null; //optional
    //config.password = "secret";
    //config.passwordHashAlgorithm = Growl.PasswordHashAlgorithm.SHA1;
    //config.passwordHashAlgorithm = Growl.PasswordHashAlgorithm.SHA256;
    //config.encryptionAlgorithm = Growl.EncryptionAlgorithm.PlainText;
    //config.encryptionAlgorithm = Growl.EncryptionAlgorithm.DES;
    //config.encryptionAlgorithm = Growl.EncryptionAlgorithm.TripleDES;
    //config.encryptionAlgorithm = Growl.EncryptionAlgorithm.AES;
    // Notification Callback Parameters
    //notification.callback.context = "my context";
    //notification.callback.type = "string";

    config.oncallback = cb;
    config.onerror = onerror;
    Growl.init(config);
};

function register(){
    var application = new Growl.Application();
    //application.name = "Javascript Example App";
    application.name = appName;
    application.icon = "http://www.growlforwindows.com/gfw/examples/js/growl.png";

    var notificationTypes = [];
    var nt1 = new Growl.NotificationType();
    nt1.name = "NT1";
    nt1.displayName = "Example Notification One";
    nt1.enabled = true;
    notificationTypes.push(nt1);

    Growl.register(application, notificationTypes);

    document.getElementById("notifyarea").style.display = "block";
    isRegistered = true;
}
function notify(){
    console.log("notify()");
    if (!isRegistered) register();
    var notification = new Growl.Notification();
    notification.name = "NT1";
    notification.title = "NEW Visitor";
    notification.text = "A Visitor has just checked in";
    notification.icon = "http://jobs.herosports.com/wp-content/uploads/2016/04/michigan-logo.png";
    notification.priority = "normal";

    Growl.notify(appName, notification);
}
function cb(notificationID, action, context, type, timestamp){
    //if(action == Growl.CallbackAction.Click) alert("the notification was clicked");

    var s = "";
    s += "id: " + notificationID + "\r\n";
    s += "action: " + action + "\r\n";
    s += "context: " + context + "\r\n";
    s += "type: " + type + "\r\n";
    s += "timestamp: " + timestamp + "\r\n";
    alert(s);
}
function onerror(errorCode, errorDescription){
    alert("ERROR:\r\n\r\n" + errorCode + " - " + errorDescription);
}