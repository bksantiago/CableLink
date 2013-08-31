<div id="report-tab">
    <script>
    $(document).ready(function(){
    	$(".datepicker").datepicker({
    		dateFormat: 'mm/dd/yy',
            changeMonth: true,
    		maxDate: '-0d',
            onClose: function(dateText, inst) {
                $(this).datepicker('option', 'dateFormat', 'mm/dd/yy');                
            }
    	});

        $(".datepicker").change(function(){
            var dFrom = $("#dateFrom").val();
            var dTo = $("#dateTo").val();
            if(dFrom != "" && dTo != ""){
                if(dFrom > dTo) {
                    alert("Invalid Dates");
                } else {
                    var url = $("#dynamic-modal-body").attr("title") + "?dateFrom=" + dFrom  + "&dateTo=" + dTo;
                    loadContent(url, "report-tab");
                }            
            }
        });
    });
    </script>
    <form class="form-horizontal">
    <fieldset>
    	<legend>Report for Agent <?php echo $agent->getCompleteName(); ?></legend>
        <div class="control-group">
            <label class="control-label">Agent ID</label>
            <div class="controls">
                <input class="span4" size="16" type="text" readonly="true"
                    value="<?php echo $agent->id; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Position</label>
            <div class="controls">
                <input class="span4" size="16" type="text" readonly="true"
                    value="<?php echo $agent->positionTb->position; ?>" />
            </div>
        </div>
    	<div class="control-group">
            <label class="control-label">Date From</label>
            <div class="controls">
                <input class="span2 datepicker" size="16" type="text" id="dateFrom" 
                        value="<?php echo isset($dateFrom) ? $dateFrom : ''; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Date To</label>
            <div class="controls">
                <input class="span2 datepicker" size="16" type="text" id="dateTo"
                        value="<?php echo isset($dateTo) ? $dateTo : ''; ?>" />
            </div>
        </div>
        <br />
        <?php if(isset($dateFrom)) { ?>
            <div class="control-group">
                <label class="control-label">Total Tickets Handled</label>
                <div class="controls">
                    <input class="span2" size="16" type="text"  readonly="true"
                        value="<?php echo $totalHandled; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Tickets Resolve</label>
                <div class="controls">
                    <input class="span2" size="16" type="text" readonly="true"
                        value="<?php echo $totalResolve; ?>" />
                </div>
            </div>
            <br />
            <div class="control-group">
                <label class="control-label">Minimum Handled Time</label>
                <div class="controls">
                    <input class="span2" size="16" type="text" readonly="true"
                        value="<?php echo $minHandledTime; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Maximum Handled Time</label>
                <div class="controls">
                    <input class="span2" size="16" type="text" readonly="true"
                        value="<?php echo $maxHandledTime; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Average Handled Time</label>
                <div class="controls">
                    <input class="span2" size="16" type="text" readonly="true"
                        value="<?php echo $averageHandledTime; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <a href="" class="btn btn-primary btn-large"> Print </a>
                </div>
            </div>
        <?php } ?>
    </fieldset>
    </form>
</div>