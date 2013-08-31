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
    	<legend>Report for Agents with Position: </legend>
    	<?php foreach($positions as $pos){ ?>
    	<div class="control-group">
            <label class="control-label">Position</label>
            <div class="controls">
                <input class="span4" size="16" type="text" readonly="true"
                    value="<?php echo $pos->position; ?>" />
            </div>
        </div>
    	<?php } ?>
        
        
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
            <script>
			$(document).ready(function(){
			    $(".table").tableNav({
			        itemsPerPage: 10
			    });
			});
			</script>
			<h2>AGENTS LIST</h2>
			<table class="table">
			    <thead>
			        <tr>
			            <th>Id</th>
			            <th>Name</th>
			            <th>Position</th>
			            <th>Tickets Handled</th>
			            <th>Tickets Resolve</th>
			            <th>Average Handling Time</th>
			        </tr>
			    </thead>
			    <tbody>
			        <?php
			            if(!empty($agents)){
			                foreach($agents as $row){
			                	$assigned = $row->getReportByUserFromTo($row->assignedTo->id, $dateFrom, $dateTo);
			                    echo "<tr>";
			                    echo "<td>" . $row->assignedTo->id . "</td>";
			                    echo "<td>" . $row->assignedTo->getCompleteName() . "</td>";
			                    echo "<td>" . $row->assignedTo->positionTb->position . "</td>";
			                    echo "<td>" . count($assigned) . "</td>";
			                    echo "<td>" . $row->getTotalResolve($assigned) . "</td>";
			                    echo "<td>" . $row->getAverageHandletime($assigned) . " hours </td>";
			                    echo "</tr>";
			                }
			            } else {
			                echo "<tr><td colspan='6'><div class='text-center'>NO RECORDS FOUND!</div></td></tr>";
			            }
			        ?>
			    </tbody>
			</table>
			<div class="pagination"></div>
			<?php if(!empty($agents)) { ?>
	            <div class="control-group">
	                <label class="control-label"></label>
	                <div class="controls">
	                    <a href="" class="btn btn-primary btn-large"> Print </a>
	                </div>
	            </div>
            <?php } ?>
        <?php } ?>
    </fieldset>
    </form>
</div>