<form autocomplete="off" spellcheck="false">
    <div id="nameInfo">
        <div>
            <label for="fname" title="First Name" data-alt="First"></label>
            <input type="text" id="fname"/>
        </div>
        <div>
            <label for="lname" title="Last Name" data-alt="Last"></label>
            <input type="text" id="lname"/>
        </div>
        <div>
            <select id="reason" name="reason" title="Reason for Visit"></select>
            <label for="addInfo">Empty</label>
        </div>
        <div>
            <input type="text" id="addInfo"/>
            <div class="toggle-label">Have an Appointment?</div>
        </div>
        <div class="switch" id="appointmentSwitch">
            <input id="toggle1" class="toggle toggle-round" type="checkbox">
            <label for="toggle1" data-on="Yes" data-off="No"></label>
        </div>
        <!--<div class="button" id="next">Continue</div>-->
        <div id="submitForm">Check-In</div>
    </div>
</form>
