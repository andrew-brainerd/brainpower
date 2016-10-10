<form autocomplete="off" spellcheck="false">
    <div>
        <label for="fname" title="First Name" data-alt="First"></label>
        <input type="text" id="fname"/>
        <label for="lname" title="Last Name" data-alt="Last">Last Name</label>
        <input type="text" id="lname"/>
        <select id="reason" name="reason" title="Reason for Visit"></select>
        <label for="addInfo"></label>
        <input type="text" id="addInfo"/>
        <?php
        if ($_GET["branch"] == "William") {
            echo "<h3>Probably something extra here...</h3>";
        }
        ?>
        <div id="submitForm">Check-In</div>
    </div>
</form>