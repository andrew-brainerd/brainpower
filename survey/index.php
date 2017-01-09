<?php include "../manage/util/dbconnect.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Member Satisfaction Survey</title>
    <link rel="stylesheet" href="/css/reset.css"/>
    <link rel="stylesheet" href="/css/font.css"/>
    <link rel="stylesheet" href="css/survey.css">
</head>
<body>
<div id="container">
    <div id="satisfactionImages">
        <img src="img/sad.svg" id="negative" alt="Sad"/>
        <img src="img/meh.svg" id="neutral" alt="Meh"/>
        <img src="img/happy.svg" id="positive" alt="Happy"/>
    </div>
    <div id="additionalInformation">
        <div id="visitReason">
            <label for="reason">Reason for Visit Today</label>
            <input type="text" id="reason"/>
        </div>
        <div id="comments">
            <label for="memberComments">Additional Comments</label>
            <textarea id="memberComments"></textarea>
        </div>
        <div id="surveySubmit">Submit</div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="/js/secure.js"></script>
<script src="js/survey.js"></script>
</body>
</html>
