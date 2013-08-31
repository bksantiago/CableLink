<script>
    $(document).ready(function(){        

        saveValidatedForm("Agents/save", "agent-registration")
        $("#username").rules("add", {remote:{
                url: "Ajax/validateUsername?username=" + $("#username").val()}});
        $("#password").rules("add", {minlength: 4 });
        $("#cpassword").rules("add", {equalTo: "#password" });
        $("#firstname").rules("add", {alphanumeric: "Enter a valid name"});
        $("#middlename").rules("add", {alphanumeric: "Enter a valid name"});
        $("#lastname").rules("add", {alphanumeric: "Enter a valid name"});

        $("#position").change(function(){
            if($(this).val() == 5){
                $("input[type=checkbox]").prop("disabled", false);
                $(".contractor-group").show();
            } else {
                $("input[type=checkbox]").prop("disabled", true);
                $(".contractor-group").hide();
            }
        });
    });
</script>
<form class="form-horizontal" id="agent-registration" method="POST" data-title="Registration Successful!">
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

        <div class="contractor-group">
            <h5>Contractor Details</h5>
            <div class="control-group">
                <label class="control-label">Available Cities</label>
                <div class="controls">
                    <?php
                    echo "<table class='table'>";
                    for($i = 0; $i < count($cities); $i++) {
                        echo "<tr>";
                        echo "<td>" . $cities[$i]->city . "</td>";
                        echo "<td><input type='checkbox' name='cities[]' value='" . $cities[$i]->id .  "' disabled></td>";
                        $i++;

                        if($i < count($cities)){
                            echo "<td>" . $cities[$i]->city . "</td>";
                            echo "<td><input type='checkbox' name='cities[]' value='" . $cities[$i]->id .  "' disabled></td>";
                        }

                        echo "</tr>";
                    }
                    echo "</table>"
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Schedule</label>
                <div class="controls">
                    <?php
                    echo "<table class='table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Day</th>";
                    echo "<th colspan='4'>Time</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    for($i = 0; $i < count($schedDay); $i++) {
                        echo "<tr>";
                        echo "<td>" . $schedDay[$i]->day . "</td>";

                        for($j = 0; $j < count($schedTime); $j++){
                            echo "<td><label class='checkbox'>
                            <input type='checkbox' name='schedule[]' value='" . $schedDay[$i]->id . ";" . $schedTime[$j]->id . "' disabled> ";
                            echo $schedTime[$j]->schedule . "</label></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    ?>
                </div>
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