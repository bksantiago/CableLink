<script>
    $(document).ready(function(){
        saveValidatedForm("Agents/update", "agent-edit")

        $("#position").change(function(){
            if($(this).val() == 5){
                $(".contractor-group").show();
            } else {
                $(".contractor-group").hide();
            }
        });
    });
</script>
<?php if($agent->positionTb->id == 5){
    echo "<script>$(document).ready(function(){
        $('.contractor-group').show();
    });
    </script>";
} ?>
<form class="form-horizontal" id="agent-edit" method="POST" data-title="Update Successful!">
    <fieldset>
        <legend>AGENT INFORMATION</legend>
        <h5>Account Information</h5>
        <div class="control-group">
            <label class="control-label">Username</label>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" name="username" id="username" 
                readonly="true" value="<?php echo $agent->username; ?>"/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Password</label>
            <div class="controls">
                <input type="password" class="span3 uneditable-input" name="password" id="password"
                       readonly="true" value="*****" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Agent Position</label>
            <div class="controls">
                <select class="span3" required name="position" id="position">
                    <option selected disabled>--Select One--</option>
                    <?php
                    foreach ($positions as $pos) {
                        if($agent->positionTb->id == $pos->id){
                            echo "<option value='" . $pos->id . "' selected>" . $pos->position . "</option>";
                        } else {
                            echo "<option value='" . $pos->id . "'>" . $pos->position . "</option>";
                        }
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
                    $cityCtr = 0;
                    echo "<table class='table'>";
                    for($i = 0; $i < count($cities); $i++) {
                        $check = "";
                        if($cityCtr < count($contractorCity)){
                            if($contractorCity[$cityCtr]->city->id == $cities[$i]->id){
                                $check = "checked";
                                $cityCtr++;
                            }
                        }
                        echo "<tr>";
                        echo "<td>" . $cities[$i]->city . "</td>";
                        echo "<td><input type='checkbox' name='cities[]' value='" . $cities[$i]->id .  "' " . $check . "></td>";
                        $i++;

                        $check = "";
                        if($cityCtr < count($contractorCity)){
                            if($contractorCity[$cityCtr]->city->id == $cities[$i]->id){
                                $check = "checked";
                                $cityCtr++;
                            }
                        }
                        if($i < count($cities)){
                            echo "<td>" . $cities[$i]->city . "</td>";
                            echo "<td><input type='checkbox' name='cities[]' value='" . $cities[$i]->id .  "' " . $check . "></td>";
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
                    $sCtr = 0;
                    for($i = 0; $i < count($schedDay); $i++) {
                        echo "<tr>";
                        echo "<td>" . $schedDay[$i]->day . "</td>";

                        for($j = 0; $j < count($schedTime); $j++){
                            $check = "";
                            if($agent->positionTb->id == "5"){
                                if($schedules[$sCtr] == "1"){
                                    $check = "checked";
                                }
                            }
                            echo "<td><label class='checkbox'>
                            <input type='checkbox' name='schedule[]'" . $check . "
                            value='" . $schedDay[$i]->id . ";" . $schedTime[$j]->id . "'> ";
                            echo $schedTime[$j]->schedule . "</label></td>";
                            $sCtr++;
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
                       required placeholder="Enter your first name" value="<?php echo $agent->firstName; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Middle Name</label>
            <div class="controls">
                <input type="text" class="span3" name="middlename" id="middlename"
                       required placeholder="Enter your middle name" value="<?php echo $agent->middleName; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" class="span3" name="lastname" id="lastname"
                       required placeholder="Enter your last name" value="<?php echo $agent->lastName; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Email Address</label>
            <div class="controls">
                <input type="email" class="span3" name="email" id="email"
                       required placeholder="example@domain.com" value="<?php echo $agent->email; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contact No</label>
            <div class="controls">
                <input type="text" class="span3" name="contact" id="contact"
                       required placeholder="Enter your contact no" value="<?php echo $agent->contactNo; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <input type='hidden' name='id' value='<?php echo $agent->id; ?>'/>
                <button type="submit" class="btn btn-primary" id="btn-submit">Update Information</button>
            </div>
        </div>
    </fieldset>
</form>