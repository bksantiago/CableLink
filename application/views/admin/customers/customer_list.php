<h2>CUSTOMERS LIST
    <form class="navbar-search pull-right" id="search-form">
        <input type="text" class="search-query" placeholder="Search" id="txt-search"
               autofocus value="<?php if(isset($search)) { echo $search; } ?>"/>
    </form>
</h2>
<table class="table">
    <thead>
        <tr>
            <th>Account #</th>
            <th>Franchise</th>
            <th>Name</th>
            <th>Application Type</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($customers)){
                foreach($customers as $row){
                    echo "<tr>";
                    echo "<td>" . $row->id . "</td>";
                    echo "<td>" . $row->franchiseTb->city . "</td>";
                    echo "<td>" . $row->getCompleteName() . "</td>";
                    echo "<td>" . $row->getApplicationType() . "</td>";
                    echo "<td class='table-center'>";
                    if($user->positionTb->id == 1){
                        echo "<a href='Customers/edit/" . $row->id . "' class='open-modal'
                                    title='Edit Customer Details' id='Customer Information'>
                                    <i class='icon-edit icon-white'></i>
                                </a>";
                    }
                    echo "<a href='Customers/view/" . $row->id . "' class='open-modal'
                                title='View Complete Details' id='Customer Information'>
                                <i class='icon-search icon-white'></i>
                            </a>
                        </td>";
                    
                    if(isset($forTicket) && $forTicket == 1) {
                        echo "<td><a href='javascript: void(0);' class='select-c' id='" . $row->id . "'
                            title='Select' ><i class='icon-ok icon-white'></i></a></td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'><div class='text-center'>NO RECORDS FOUND!</div></td></tr>";
            }
        ?>
    </tbody>
</table>