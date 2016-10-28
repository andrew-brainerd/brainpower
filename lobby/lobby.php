<form autocomplete="off" spellcheck="false">
    <div>
        <label for="fname" title="First Name" data-alt="First"></label>
        <input type="text" id="fname"/>
        <label for="lname" title="Last Name" data-alt="Last"></label>
        <input type="text" id="lname"/>
        <select id="reason" name="reason" title="Reason for Visit"></select>
        <label for="addInfo">Empty</label>
        <input type="text" id="addInfo"/>
        <?php
        if ($_GET["branch"] == "William") {
            echo "<h3>Probably something extra here...</h3>";
        } else { ?>
            <div class="switch" id="appointmentSwitch">
                <div>Have an Appointment?</div>
                <input id="toggle1" class="toggle toggle-yes-no" type="checkbox">
                <label for="toggle1" data-on="Yes" data-off="No"></label>
            </div>
        <?php
        }
        ?>
        <div id="submitForm">Check-In</div>
    </div>
</form>