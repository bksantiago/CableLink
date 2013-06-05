<script>
    $(document).ready(function(){
        saveValidatedForm("Agents/save", "agent-registration")
        $("#username").rules("add", {remote:{
                url: "Ajax/validateUsername?username=" + $("#username").val()}});
        $("#password").rules("add", {minlength: 4 });
        $("#cpassword").rules("add", {equalTo: "#password" });
    });
</script>
<form class="form-horizontal" id="agent-registration" method="POST" title="Registration Successful!">
    <fieldset>
        <legend>AGENT REGISTRATION</legend>
        <h5>Account Information</h5>
        <div class="control-group">
            <label class="control-label">Username</label>
            <div class="controls">
                <input type="text" class="span3" name="username" id="username"
                       required placeholder="Enter desired username" autofocus/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Password</label>
            <div class="controls">
                <input type="password" class="span3" name="password" id="password"
                       required placeholder="Enter desired password"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Confirm Password</label>
            <div class="controls">
                <input type="password" class="span3" name="cpassword" id="cpassword"
                       required placeholder="Re-enter your password"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Agent Position</label>
            <div class="controls">
                <select class="span3" required name="position" id="position">
                    <option selected disabled>--Select One--</option>
                    <?php
                    foreach ($positions as $pos) {
                        echo "<option value='" . $pos->id . "'>" . $pos->position . "</option>";
                    }
                    ?>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
        <hr />
        <h5>Personal Information</h5>
        <div class="control-group">
            <label class="control-label">First Name</label>
            <div class="controls">
                <input type="text" class="span3" name="firstname" id="firstname"
                       required placeholder="Enter your first name"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Middle Name</label>
            <div class="controls">
                <input type="text" class="span3" name="middlename" id="middlename"
                       required placeholder="Enter your middle name"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" class="span3" name="lastname" id="lastname"
                       required placeholder="Enter your last name"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Email Address</label>
            <div class="controls">
                <input type="email" class="span3" name="email" id="email"
                       required placeholder="example@domain.com"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contact No</label>
            <div class="controls">
                <input type="text" class="span3" name="contact" id="contact"
                       required placeholder="Enter your contact no"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <button type="submit" class="btn btn-primary" id="btn-submit">Complete Registration</button>
                <button type="reset" class="btn">Reset</button>
            </div>
        </div>
    </fieldset>
</form>