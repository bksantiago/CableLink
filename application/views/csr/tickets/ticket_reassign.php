<h2>AGENTS LIST</h2>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Position</th>
            <th>Tickets Handled</th>
            <th><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($agents as $row){
                echo "<tr>";
                echo "<td>" . $row->id . "</td>";
                echo "<td>" . $row->getCompleteName() . "</td>";
                echo "<td>" . $row->positionTb->position . "</td>";
                echo "<td>" . $ticket->getAssignCount($row->id) . "</td>";
                echo "<td>
                        <form id='confirm-form' class='clearfix' method='POST' action='Tickets/doReassign'>
                            <input type='hidden' value='" . $ticketId . "' name='ticketId'/>
                            <input type='hidden' value='" . $row->id . "' name='agentId'/>
                            <button type='submit' class='btn-transparent' title='Reassign'>
                            <i class='icon-share icon-white'></i></button>
                        </form>
                     </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>