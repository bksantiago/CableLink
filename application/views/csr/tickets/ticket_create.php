<?php if(!empty($customer)) { $new = false; } else { $new = true; } ?>
<form class="form-horizontal"
      <?php if(!empty($ticket)) echo "method='POST' action='Tickets/resolve/$ticket->id' id='confirm-form'";
            else if(!$new) echo "method='POST' action='Tickets/submit' id='ajaxSubmit'"; 
            else echo "id='search-form'"; ?>>
    <fieldset>
        <legend>
            <?php if(!empty($ticket)) echo "JOB TICKET # " . $ticket->id; else echo "NEW JOB TICKET"; ?>
        </legend>
        <?php if(isset($error)){
           echo "<div class='alert alert-error'>No Record Found!</div>"; 
        }?>
        <div class="control-group">
            <div class="control-label">Account #</div>
            <div class="controls">
                <?php if($new) {?>
                <input type="text" class="span2" placeholder="Enter an Account No." autofocus
                       id="txt-search"/> 
                <a href="Customers/customer_list?f=1" class="open-modal btn btn-medium btn-primary" id="Customer List">
                    <i class="icon-search icon-white"></i></a>
                <?php } else {?>
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo $customer->id; ?>" />
                <a href="Customers/view/<?php echo $customer->id;?>" class="open-modal btn btn-small btn-primary"
                   id="Customer Information">
                    Full Details <i class="icon-search icon-white"></i></a>
                <?php }?>
            </div>
        </div>
        <?php if(!$new) {?>
        <div class="control-group">
            <div class="control-label">Account Name</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo $customer->lastName . ", " . $customer->firstName . " "
                               . $customer->middleName; ?>" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Franchise</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo $customer->franchiseTb->city; ?>"/>
            </div>
        </div>
       <div class="control-group">
            <div class="control-label">Application Type</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php 
                       switch($customer->applicationType){
                           case 0: echo "Cable"; break;
                           case 1: echo "Internet"; break;
                           case 2: echo "Both"; break;
                           default : echo ""; break;
                       }  ?>"/>
            </div>
        </div>
        <?php if(empty($ticket)) { ?>
            <div class="control-group">
                <div class="control-label"></div>
                <div class="controls">
                    <input type="hidden" value="<?php echo $customer->id; ?>" name="accountno" />
                    <button class="btn btn-primary btn-medium" type="submit">Confirm Account Details</button>
                </div>
            </div>
        <?php } ?>
        <?php } else { echo "<i>Input Account No. then press enter or you can search using search button</i>";}?>
        <?php if(!empty($ticket)){ ?>
        <hr />
        <h5>TICKET INFORMATION</h5>
        <div class="control-group">
            <div class="control-label">Date Started</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo date('F d, Y h:i A', strtotime($ticket->dateStart));?>"/>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Date Ended</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php if(!empty($ticket->dateEnd))
                               echo date('F d, Y h:i A', strtotime($ticket->dateEnd));
                                else echo "--"?>"/>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Currently Assigned To:</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo $ticket->assignedTb->getCompleteName() . " ( " . 
                               $ticket->assignedTb->positionTb->code . " )"; ?>"/>
                <?php if(empty($ticket->dateEnd) && !isset($view))
                        echo "<a href='Tickets/reassign/$ticket->id' id='List of Available Agents'
                            class='btn btn-primary open-modal'>Assign to Others &raquo;</a>";
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Agent Notes</div>
            <div class="controls">
                <textarea rows="5" required id="<?php echo $ticket->id; ?>"
                      placeholder="Enter Information about the problem..."
                      <?php if(isset($view) || !empty($ticket->dateEnd)) echo "readonly='readonly' class='span5'";
                            else echo "class='span5 auto-save'";?>><?php 
                      echo $ticket->singleAssignedTb->remarks; ?></textarea>
            </div>
        </div>
        <h5>TICKET HISTORY</h5>
        <table class="table table-bordered">
            <thead>
                <th>Date Assigned</th>
                <th>Date Ended</th>
                <th>Agent Notes</th>
            </thead>
            <tbody>
                <?php 
                    foreach($ticket->ticketsAssignedTb as $row){
                        echo "<tr>";
                        echo "<td>" . date("F d, Y h:i A", strtotime($row->dateStart)) . "</td>";
                        if(empty($row->dateEnd)) echo "<td>--</td>";
                        else echo "<td>" . date("F d, Y h:i A", strtotime($row->dateEnd)) . "</td>";
                        echo "<td>" . $row->remarks . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <div class="control-group">
            <div class="control-label"></div>
            <div class="controls">
                <?php if(empty($ticket->dateEnd) && !isset($view))
                    echo "<button type='submit' class='btn btn-primary btn-large'>Mark as Resolve</button>";
                ?>
            </div>
        </div>
        <?php } ?>
    </fieldset>
</form>