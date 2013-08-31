<?php if(!empty($customer)) { $new = false; } else { $new = true; } ?>
<form class="form-horizontal"
      <?php if(!empty($ticket)) echo "method='POST' action='Tickets/resolve/$ticket->id' id='confirm-form'";
            else if(!$new) echo "method='POST' action='Tickets/submit' id='ajaxSubmit'"; 
            else echo "id='search-form'"; ?>>
    <fieldset>
        <legend>
            <?php if(!empty($ticket)){
                    echo "JOB TICKET # " . $ticket->id;
                } else {
                    echo "NEW JOB TICKET"; 
                }

            ?>
        </legend>
        <?php if(isset($error)){
           echo "<div class='alert alert-error'>No Record Found!</div>";
        }?>
        <div class="control-group">
            <div class="control-label">Account #</div>
            <div class="controls">
                <?php if($new) {?>
                <script>
                $(document).ready(function(){

                    $("#txt-search").change(function(){
                        if($("#txt-search").val() == ""){
                            $("#search-submit").hide();
                            $(".search-enter").show();
                        } else {
                            $("#search-submit").show();
                            $(".search-enter").hide();
                        }
                    });
                });
                </script>                
                <input type="text" class="span2" placeholder="Enter an Account No." autofocus
                       id="txt-search"/>
                       <button type="submit" class="btn btn-medium btn-primary" id="search-submit" style="display: none;"><i class="icon-search icon-white"></i></a></button>
                <a href="Customers/customer_list/1" class="open-modal btn btn-medium btn-primary search-enter" data-header="Customer List">
                    <i class="icon-search icon-white"></i></a>      
                <?php } else {?>
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo $customer->id; ?>" />
                <a href="Customers/view/<?php echo $customer->id;?>" class="open-modal btn btn-small btn-primary"
                   data-header="Customer Information">
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
                <?php 
                if(empty($ticket)){
                    if($customer->applicationType == 0){
                        echo "<input type='text' class='span3 uneditable-input' readonly='readonly' value='Cable' />";
                        echo "<input type='hidden' value='0' name='applicationType' />";
                    } else if($customer->applicationType == 1){
                        echo "<input type='text' class='span3 uneditable-input' readonly='readonly' value='Internet' />";
                        echo "<input type='hidden' value='1' name='applicationType' />";
                    } else {
                        echo "<select class='span3' name='applicationType' required>";
                        echo "<option value='5'>--Select One--</option>";
                        echo "<option value='0'>Cable</option>";
                        echo "<option value='1'>Internet</option>";
                        echo "</select>";
                    }
                } else {
                    switch ($ticket->applicationType) {
                        case 0: $at = "Cable";
                            break;
                        case 1: $at = "Internet";
                            break;                        
                        default: $at = "";
                            break;
                    }
                    echo "<input type='text' class='span3 uneditable-input' readonly='readonly' value='$at' />";
                }
                ?>
            </div>
        </div>
        <?php if(empty($ticket)) { ?>
            <script>
                $(document).ready(function(){
                    $("#btnConfirm").click(function(e){
                        if($("[name='applicationType']").val() == "5"){
                            e.preventDefault();
                            alert("Select an application type");
                        }
                    });
                });
            </script>
            <div class="control-group">
                <div class="control-label"></div>
                <div class="controls">
                    <input type="hidden" value="<?php echo $customer->id; ?>" name="accountno" />
                    <button class="btn btn-primary btn-medium" type="submit" id="btnConfirm">Confirm Account Details</button>
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

        <?php if(!empty($ticket->dateEnd)) { ?>
        <div class="control-group">
            <div class="control-label">Date Ended</div>
            <div class="controls">
                <input type="text" class="span3 uneditable-input" readonly="readonly"
                       value="<?php echo date('F d, Y h:i A', strtotime($ticket->dateEnd)); ?>"/>
            </div>
        </div>
        <?php } ?>

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
                <?php if(empty($ticket->dateEnd) && !isset($view)){
                        echo "<input type='hidden' value='" . $ticket->id . "' id='ticketId'>";
                        echo "<button type='submit' class='btn btn-primary btn-large'>Mark as Resolve</button>";
                        echo "&nbsp;";
                        if($isDispatch == 0){
                            echo "<a href='Tickets/dispatch/" . $ticket->id . "' 
                                class='btn btn-primary btn-large open-modal'title='View Contractors' id='create-dispatch'
                                data-header='List of Available Contractors'>Create Dispatcher Order</a>";
                        } else {

                        }
                    }
                ?>
            </div>
        </div>
        <?php } ?>
    </fieldset>
</form>