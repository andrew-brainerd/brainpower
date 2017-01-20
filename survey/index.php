<?php include "../manage/util/dbconnect.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="UMCU Satisfaction Survey"/>
    <title>Member Satisfaction Survey</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed">
    <link rel="stylesheet" href="/css/reset.css"/>
    <link rel="stylesheet" href="/css/font.css"/>
    <link rel="stylesheet" href="css/survey.css">
</head>
<body id="<?php echo rand(); ?>">
<div id="container">
    <h1>How Was Your Visit Today?</h1>
    <div id="satisfactionImages">
        <img src="img/1-Smiley-Star.png" id="positive" alt="aMAIZEing!"/>
        <img src="img/2-Indifferent-emoji.png" id="neutral" alt="Ok"/>
        <img src="img/3-Sad-emoji.png" id="negative" alt="Not So Good"/>
    </div>
    <div class="transparentText" id="selectedLabel">Label</div>
    <div id="surveySubmit">Submit</div>
    <div id="additionalInformation">
        <div id="comments">
            <label for="memberComments">Additional Comments</label>
            <textarea id="memberComments"></textarea>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="/js/secure.js"></script>
<script src="js/survey.js"></script>
</body>
</html>
