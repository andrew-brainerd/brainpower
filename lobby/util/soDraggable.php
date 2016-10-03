<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 10/3/2016
 * Time: 12:29 PM
 */

?>
<!DOCTYPE html>
<html>
<head>
    <title>jQuery Drag/Drop Test</title>
</head>
<body>
<div id="dragMe"></div>
<? include "jquery.php"; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#dragMe").draggable();
    });
</script>
</body>
</html>
