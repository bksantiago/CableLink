<h2>UPCOMING DISPATCHES</h2>
<table class="table">
    <thead>
        <tr>
            <th>Ticket #</th>
            <th>Assigned To</th>
            <th>Date Assigned</th>
            <th><i class='icon-white icon-cog'></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(empty($dispatches)){
        	echo "<tr><td colspan='5' class='table-center'>No Records Found</td></tr>";
        } else {
	        foreach ($dispatches as $row) {
	            echo "<tr>";
	            echo "<td><a href='Tickets/view/" . $row->ticketTb->id . "' class='open-modal short-link' 
                                title='View Complete Details'
                                id='Ticket Information'>" . $row->ticketTb->id . "</a></td>";
	            echo "<td><a href='profile?id=" . $row->userTb->id . "' class='short-link'>" . 
                                $row->userTb->getCompleteName() . 
                                " (" . $row->userTb->positionTb->code . ")</a></td>";
	            echo "<td>" . date("F d, Y", strtotime($row->date)) . " " . date('h:i A', strtotime($row->timeStart)) . "</td>";
                echo "<td><a href='Tickets/finish_dispatch_view?ticketId=" . $row->ticketTb->id . "' class='open-modal'
                                        title='View/Update Dispatch' data-header='Ticket Information'>
                                        <i class='icon-search icon-white'></i>
                                    </a></td>";
	            echo "</tr>";
	        }
        }
        ?>
    </tbody>
</table>