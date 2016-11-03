<?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Upload Complete</title>
        <link rel="icon" href="/favicon.ico">
        <link rel="stylesheet" href="//css/reset.css"/>
        <link rel="stylesheet" href="/css/font.css"/>
        <link rel="stylesheet" href="../css/video.css"/>
    </head>
    <body>
    <?php
    /**
     * Created by PhpStorm.
     * User: abrainerd
     * Date: 3/29/2016
     * Time: 5:06 PM
     */

    if (isset($_POST["videoTitle"])) {
        $title = $_POST["videoTitle"];
        $authlv = $_POST["authLevel"];
        $releaseDate = $_POST["releaseDate"];

        $time = date("Y/m/d H:i:s a");

        $dir = "media/";
        $file = basename($_FILES["videoUpload"]["name"]);
        $path = "../" . $dir . $file;
        $upFlag = true;
        $upDone = false;
        if (file_exists($path)) {
            if ($file == "")
                echo wrap("No file name");
            else
                echo wrap("Sorry, file already exists.");
            $upFlag = false;
        }
        if (!$upFlag) {
            echo wrap("Sorry, your file was not uploaded.");
        } else {
            if (move_uploaded_file($_FILES["videoUpload"]["tmp_name"], $path)) {
                $upDone = true;
                $upMessage = wrap(basename($_FILES["videoUpload"]["name"]) . " has been uploaded to /" . $dir);
                include "dbconnect.php";
                $path = $dir . $file;
                $ins = "INSERT INTO Videos(title, location, required_auth, upload_time, release_date)";
                $val = "VALUES ('$title', '$path', '$authlv', '$time', '$releaseDate')";
                $sql = $ins . " " . $val;
                $success = $conn->query($sql);
                if ($success === true) {
                    echo wrap("Inserted Table Row for " . $title);
                } else echo wrap("Row insert failed");
                $conn->close();
            } else {
                echo wrap("Sorry, there was an error uploading your file.");
            }
        }
    }

    ?>
    <?php if ($upDone) { ?>
        <div id="options">
            <?php echo $upMessage; ?>
            <div id="viewManage" class="button">Manage Videos</div>
            <div id="viewBack" class="button">Back to Upload</div>
            <div id="viewLibrary" class="button">Go To Library</div>
        </div>
    <?php } else {
        if ($_FILES["videoUpload"]["error"] !== UPLOAD_ERR_OK) {
            echo "Upload failed with error code [" . $_FILES['videoUpload']['error'] . "]<br><br><br>";
            phpinfo();
        } else echo "No noticable error";
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="../js/auth.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var manage = $("#viewManage");
            var back = $("#viewBack");
            var library = $("#viewLibrary");
            var path = "";
            manage.click(function () {
                navigate("/video/manage.php");
            });
            back.click(function () {
                navigate("/video/uploadVideo.php");
            });
            library.click(function () {
                navigate("/video");
            });
            function navigate(url) {
                console.log("Navigate: " + url);
                url = path + url;
                $("body").fadeOut();
                location.href = url;
            }
        });
    </script>
    </body>
    </html>
<?php
function wrap($m)
{
    return "<h3>" . $m . "</h3>";
}

function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

?>