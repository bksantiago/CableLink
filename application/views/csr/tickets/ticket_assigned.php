<h2>ASSIGNED TICKETS LIST
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
            <th>Date Started</th>
            <th>Status</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($tickets)){
                foreach($tickets as $row){
                    echo "<tr>";
                    echo "<td>" . $row->id . "</td>";
                    echo "<td>" . $row->accountTb->id . "</td>";
                    echo "<td>" . date('F d, Y h A' ,strtotime($row->dateStart)) . "</td>";
                    echo "<td>" . $row->getStatus() . "</td>";
                    echo "<td class='table-center'><a href='Tickets/view/" . $row->id . "' class='open-content'
                                title='Process Ticket' id='Customer Information'>
                                <i class='icon-pencil icon-white'></i>
                            </a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'><div class='text-center'>NO RECORDS FOUND!</div></td></tr>";
            }
        ?>
    </tbody>
</table>