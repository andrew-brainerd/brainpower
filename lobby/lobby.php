<form autocomplete="off" spellcheck="false">
    <div>
        <label for="fname">First Name</label>
        <input type="text" id="fname"/>
        <label for="lname">Last Name</label>
        <input type="text" id="lname"/>
        <select id="reason" name="reason" title="Reason for Visit"></select>
        <input type="text" id="addInfo" placeholder=""/>
        <?php
        if ($_GET["branch"] == "William") {
            echo "<h3>Probably something extra here...</h3>";
        }
        ?>
        <div id="submitForm">Check-In</div>
    </div>
</form>