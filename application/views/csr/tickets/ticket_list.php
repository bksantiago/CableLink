<h2>TICKETS LIST
    <form class="navbar-search pull-right" id="search-form">
        <input type="text" class="search-query" placeholder="Search" id="txt-search"
               autofocus value="<?php if(isset($search)) { echo $search; } ?>"/>
    </form>
</h2>
<table class="table">
    <thead>
        <tr>
            <th>Ticket #</th>
            <th>Account #</th>
            <th>Assigned To</th>
            <th>Date Started</th>
            <th>Date Ended</th>
            <th><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($tickets)){
                foreach($tickets as $row){
                    echo "<tr>";
                    echo "<td>" . $row->id . "</td>";
                    echo "<td>" . $row->accountTb->id . "</td>";
                    echo "<td><a href='profile?id=" . $row->assignedTb->id . "' class='short-link'>" . 
                            $row->assignedTb->firstName . 
                            " ( " . $row->assignedTb->positionTb->code . " )</a></td>";
                    echo "<td>" . date('F d, Y h:i A' ,strtotime($row->dateStart)) . "</td>";
                    
                    if(empty($row->dateEnd))
                        echo "<td>--</td>";
                    else
                        echo "<td>" . date('F d, Y h:i A' ,strtotime($row->dateEnd)) . "</td>";
                    
                    echo "<td><a href='Tickets/view/" . $row->id . "' class='open-modal'
                                title='View Complete Details' id='Ticket Information'>
                                <i class='icon-search icon-white'></i>
                            </a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'><div class='text-center'>NO RECORDS FOUND!</div></td></tr>";
            }
        ?>
    </tbody>
</table>