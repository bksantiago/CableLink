<?php
if(isset($ticket)){
  $action = "Tickets/finish_dispatch_submit";
} else {
  $action = "Tickets/finish_dispatch_view";
}
?>
<form class="form-horizontal" method='POST' action="<?php echo $action; ?>" id='ajaxSubmit'>
    <fieldset>
        <legend>UPDATE DISPATCHES</legend>
        <?php if(isset($error)){
           echo "<div class='alert alert-error'>" . $error . "</div>";
        }?>
    </fieldset>
    <?php if(!isset($ticket)) { ?>
    <div class="control-group">
        <div class="control-label">Ticket #</div>
        <div class="controls">            
            <input type="text" class="span2" placeholder="Enter Ticket No." autofocus name="ticketId"
                   id="txt-search"/>
            <button type="submit" class="btn btn-medium btn-primary" id="search-submit">
            <i class="icon-search icon-white"></i></a></button>
        </div>
    </div>
    <?php } else { ?>
    <div class="control-group">
        <div class="control-label">Ticket #</div>
        <div class="controls">
            <input type="text" class="span3 uneditable-input" readonly="readonly"
                   value="<?php echo $ticket->id; ?>" />
        </div>
    </div>
    <div class="control-group">
            <div class="control-label">Franchise</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo $ticket->accountTb->franchiseTb->city; ?>"/>
            </div>
        </div>
       <div class="control-group">
            <div class="control-label">Application Type</div>
            <div class="controls">
                <?php 
                  switch ($ticket->applicationType) {
                      case 0: $at = "Cable";
                          break;
                      case 1: $at = "Internet";
                          break;                        
                      default: $at = "";
                          break;
                  }
                  echo "<input type='text' class='span3 uneditable-input' readonly='readonly' value='$at' />";                  
                  ?>
            </div>
        </div>
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
                        echo "<a href='Tickets/reassign/$ticket->id' data-header='List of Available Agents'
                            class='btn btn-primary open-modal'>Assign to Others &raquo;</a>";
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Agent Notes</div>
            <div class="controls">
                <textarea rows="5" required id="<?php echo $ticket->id; ?>" readonly='readonly' class='span5'><?php 
                      echo $ticket->singleAssignedTb->remarks; ?></textarea>
            </div>
        </div>
        <h5>TICKET HISTORY</h5>
        <table class="table table-bordered">
            <thead>
                <th>Agent</th>
                <th>Date Assigned</th>
                <th>Date Ended</th>
                <th>Agent Notes</th>
            </thead>
            <tbody>
                <?php 
                    foreach($ticket->ticketsAssignedTb as $row){
                        echo "<tr>";
                        echo "<td><a href='profile?id=" . $row->assignedTo->id . "' class='short-link'>" . 
                                $row->assignedTo->firstName . 
                                " (" . $row->assignedTo->positionTb->code . ")</a></td>";
                        echo "<td>" . date("F d, Y h:i A", strtotime($row->dateStart)) . "</td>";
                        if(empty($row->dateEnd)) echo "<td>--</td>";
                        else echo "<td>" . date("F d, Y h:i A", strtotime($row->dateEnd)) . "</td>";
                        echo "<td>" . $row->remarks . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

        <?php 
            $dispatches = $ticket->getDispatches();
            $isDispatch = 0;
            
            if(!empty($dispatches)){
                echo "<h5>DISPATCHES HISTORY</h5>";
                ?>
                <table class="table table-bordered">
                    <thead>
                        <th>Contractor</th>
                        <th>Date of Start</th>
                        <th>Date Ended</th>
                    </thead>
                    <tbody>
                        <?php                             
                            foreach($dispatches as $row){
                                $isDispatch = 1;
                                $status = "";

                                echo "<tr>";
                                echo "<td><a href='profile?id=" . $row->userTb->id . "' class='short-link'>" . 
                                        $row->userTb->firstName . 
                                        " (" . $row->userTb->positionTb->code . ")</a></td>";
                                echo "<td>" . date("F d, Y h:i A", strtotime($row->date)) . "</td>";
                                if($row->timeFinish == ""){
                                    echo "<td>--</td>";
                                } else {
                                    echo "<td>" . date("F d, Y h:i A", strtotime($row->timeFinish)) . "</td>";
                                }
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        ?>
        <div class="control-group">
            <div class="control-label"></div>
            <div class="controls">
                <?php 
                      echo "<input type='hidden' value='" . $ticket->id . "' name='ticketId'>";
                      echo "<button type='submit' class='btn btn-primary btn-large'>Resolve Current Dispatch</button>";
                      echo "&nbsp;";
                      echo "<a href='Tickets/reschedule/" . $ticket->id . "' data-header='Reschedule Dispatch'
                            class='open-modal btn btn-primary btn-large'>Reschedule Current Dispatch</a>";
                ?>
            </div>
        </div>
    <?php } ?>
</form>