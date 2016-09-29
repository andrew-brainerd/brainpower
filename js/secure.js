/**
 * Created by abrainerd on 7/1/2016.
 */

if (location.protocol == "http:") {
    location.href = location.href.replace("http", "https");
}