<script>
$(document).ready(function(){
    $("#datepicker").datepicker();
    saveValidatedForm("Customers/save", "customer-registration");
});
</script>
<?php if(isset($customer)){ $reg = false; } else { $reg = true; } ?>
<form class="form-horizontal" id="customer-registration" method="POST"
      title="<?php if($reg) {echo "Registration Successful!"; } else { echo "Update Successful!"; }?>">
    <fieldset>
        <legend>
            <?php if($reg) {?>
                CUSTOMER REGISTRATION <span class="req">required fields *</span>
            <?php } else {?>
                CUSTOMER ACCOUNT # <?php echo $customer->id; ?>
            <?php } ?>
        </legend>
        <h5>Account Information</h5>
        <?php if(!$reg) echo "<input type='hidden' name='id' value='" . $customer->id . "'/>";?>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Franchise Name</label>
            <div class="controls">
                <select class="span3" required autofocus name="franchise">
                    <option selected disabled>--Select One--</option>
                    <?php 
                        foreach($cities as $row){
                            if(!$reg && $customer->franchiseTb->id == $row->id){
                                echo "<option value='" . $row->id . "' selected>" . $row->city . "</option>";
                            } else {
                                echo "<option value='" . $row->id . "'>" . $row->city . "</option>";
                            }
                        }
                    ?>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Billing Cycle</label>
            <div class="controls">
                <select class="span3" required name="billing">
                    <option selected disabled>--Select One--</option>
                    <option value="1" <?php if(!$reg && $customer->billingCycle == 1){echo "selected";}?>>
                        Regular Cycle</option>
                    <option value="2" <?php if(!$reg && $customer->billingCycle == 2){echo "selected";}?>>
                        Quarterly Cycle</option>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Application Date</label>
            <div class="controls">
                <label class="inline">
                    <span class="span3 input-xlarge uneditable-input">
                    <?php
                        if($reg) echo $date;
                        else echo date("F d, Y", strtotime($customer->applicationDate));
                    ?></span> &nbsp;
                    <span class="req">*</span> Application Type &nbsp;
                    <select class="span2" required name="applicationtype">
                        <option value="0" <?php if(!$reg && $customer->applicationType == 0) echo "selected"; ?>>
                            Cable</option>
                        <option value="1" <?php if(!$reg && $customer->applicationType == 1) echo "selected"; ?>>
                            Internet</option>
                        <option value="2" <?php if(!$reg && $customer->applicationType == 2) echo "selected"; ?>>
                            Both</option>
                    </select>
                </label>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Subscribers Name</label>
            <div class="controls">
                <select class="span1" required name="prefix">
                    <option selected disabled>--</option>
                    <option value="Mr." <?php if(!$reg && $customer->prefix == "Mr.") echo "selected"; ?>>
                        Mr.</option>
                    <option value="Ms." <?php if(!$reg && $customer->prefix == "Ms.") echo "selected"; ?>>
                        Ms.</option>
                    <option value="Mrs." <?php if(!$reg && $customer->prefix == "Mrs.") echo "selected"; ?>>
                        Mrs.</option>
                </select>
                <input type="text" class="span2" required placeholder="First Name" name="firstname"
                       value="<?php if(!$reg) echo $customer->firstName; ?>"/>
                <input type="text" class="span2" required placeholder="Middle Name" name="middlename"
                       value="<?php if(!$reg) echo $customer->middleName; ?>"/>
                <input type="text" class="span2" required placeholder="Last Name" name="lastname"
                       value="<?php if(!$reg) echo $customer->lastName; ?>"/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Address</label>
            <div class="controls">
                <textarea class="span5" required name="address" placeholder="Enter Address"><?php 
                    if(!$reg) echo $customer->address; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Account Type</label>
            <div class="controls">
                <label class="radio">
                    <input type="radio" value="1" name="accounttype" required
                        <?php if(!$reg && $customer->accountType == 1) echo "checked"; ?>/>
                    <label for="parent">Parent</label>
                </label>
                <label class="radio">
                    <input type="radio" value="0" name="accounttype" required 
                        <?php if(!$reg && $customer->accountType == 0) echo "checked"; ?>/>
                    <label for="parent">Children</label>
                </label>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><span class="req">*</span> Birthdate</label>
            <div class="controls">
                <div class="input-append date" class="datepicker" id="datepicker" data-date-format="mm/dd/yyyy">
                    <input class="span2" size="16" type="text" name="birthdate" required
                        value="<?php if(!$reg) echo date('m/d/Y', strtotime($customer->birthdate)); ?>" />
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>   
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Email Address</label>
            <div class="controls">
                <input type="email" class="span3" name="email" placeholder="example@domain.com"
                       value="<?php if(!$reg) echo $customer->email; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Contact No</label>
            <div class="controls">
                <input type="text" class="span2" name="contact1" placeholder="Residence"
                       value="<?php if(!$reg) echo $customer->contact1; ?>"/>
                <input type="text" class="span2" name="contact2"placeholder="Office"
                       value="<?php if(!$reg) echo $customer->contact2; ?>"/>
                <input type="text" class="span2" name="contact3" placeholder="Mobile"
                       value="<?php if(!$reg) echo $customer->contact3; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Landmarks</label>
            <div class="controls">
                <textarea class="span5" name="landmarks" placeholder="Enter Landmarks near your place"><?php 
                    if(!$reg) echo $customer->landmarks;
                ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php if($reg) {?>
                    <button type="submit" class="btn btn-primary" id="btn-submit">
                        Complete Registration</button>
                    <button type="reset" class="btn">Reset</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-primary" id="btn-submit">Update Information</button> 
                <?php } ?>
            </div>
        </div>      
    </fieldset>
</form>