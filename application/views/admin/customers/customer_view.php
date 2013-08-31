<fieldset class="form-horizontal">
    <legend>
        CUSTOMER ACCOUNT # <?php echo $customer->id; ?>
    </legend>
    <h5>Account Information</h5>
    <div class="control-group">
        <label class="control-label"> Franchise Name</label>
        <div class="controls">
            <input type="text" class="span3 uneditable-input" readonly="readonly"
                   value="<?php echo $customer->franchiseTb->city;?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Billing Cycle</label>
        <div class="controls">
            <input type="text" class="span3 uneditable-input" readonly="readonly"
                value="<?php if($customer->billingCycle == 1){echo "Regular Cycle";}
                    else if($customer->billingCycle == 2){echo "Quarterly Cycle";}?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Application Date</label>
        <div class="controls">
            <input type="text" class="span3 input-xlarge uneditable-input" readonly="readonly"
            value="<?php
                echo date("F d, Y", strtotime($customer->applicationDate));
            ?>" /> &nbsp;
             Application Type &nbsp;
           <input type="text" class="span2 uneditable-input" readonly="readonly"
                value="<?php if($customer->applicationType == 0){echo "Cable";}
                    else if($customer->applicationType == 1){echo "Internet";}
                    else if($customer->applicationType == 2){echo "Internet and Cable";}?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Subscribers Name</label>
        <div class="controls">
            <input type="text" class="span5 uneditable-input" readonly="readonly"
            value="<?php echo $customer->prefix . " " . $customer->firstName . " " . $customer->middleName
                    . " " . $customer->lastName; ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Address</label>
        <div class="controls">
            <textarea class="span5" readonly="readonly"><?php echo $customer->address; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Account Type</label>
        <div class="controls">
            <input type="text" class="span2 uneditable-input" readonly="readonly"
            value="<?php if($customer->accountType == 0){echo "Children";}
                    else if($customer->accountType == 1){echo "Parent";} ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Birthdate</label>
        <div class="controls">
            <div class="input-append date" data-date-format="mm/dd/yyyy">
                <input class="span2" size="16" type="text" readonly="readonly"
                    value="<?php echo date('m/d/Y', strtotime($customer->birthdate)); ?>" />
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>   
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Email Address</label>
        <div class="controls">
            <input type="text" readonly="readonly" class="span3 uneditable-input"
                    value="<?php echo $customer->email; ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Contact No</label>
        <div class="controls">
            <input type="text" class="span2" readonly="readonly" placeholder="Residence"
                   value="<?php echo $customer->contact1; ?>"/>
            <input type="text" class="span2" readonly="readonly" placeholder="Office"
                   value="<?php echo $customer->contact2; ?>"/>
            <input type="text" class="span2" readonly="readonly" placeholder="Mobile"
                   value="<?php echo $customer->contact3; ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Landmarks</label>
        <div class="controls">
            <textarea class="span5" readonly="readonly"><?php echo $customer->landmarks; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <h5>CALL LOGS HISTORY</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ticket #</th>
                    <th>Agent</th>
                    <th>Date Started</th>
                    <th>Date Ended</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $myTickets = $customer->getMyTickets();
                if(empty($myTickets)){ ?>
                <tr>
                    <td colspan="5" class="table-center">No Records Found</td>
                </tr>
                <?php } else { 
                    foreach($myTickets as $row){
                        echo "<tr>";
                        echo "<td><a href='Tickets/view/" . $row->id . "' class='open-modal short-link' 
                                title='View Complete Details'
                                data-header='Ticket Information'>" . $row->id . "</a></td>";
                        echo "<td><a href='Profile?id=" . $row->assignedTb->id . "' class='short-link'>" . 
                                $row->assignedTb->firstName . 
                                " ( " . $row->assignedTb->positionTb->code . " )</a></td>";
                        echo "<td>" . date("F d, Y h:i A", strtotime($row->dateStart)) . "</td>";
                        if(empty($row->dateEnd)){
                           echo "<td>--</td>";
                        } else {
                            echo "<td>" . date("F d, Y h:i A", strtotime($row->dateEnd)) . "</td>";
                        }
                        if(!empty($row->dateEnd)){
                            echo "<td>Resolved</td>";
                        } else {
                            echo "<td>Pending</td>";
                        }
                        echo "</tr>";
                    }
                 } 
                 ?>
            </tbody>
        </table>
    </div>
</fieldset>