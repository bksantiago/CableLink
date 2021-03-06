<script>
$(document).ready(function(){
    $(".table").tableNav({
        itemsPerPage: 10
    });
});
</script>
<h2>SELECT A CONTRACTOR
    <form class="navbar-search pull-right" id="search-form">
        <input type="text" class="search-query" placeholder="Search" id="txt-search"
               autofocus value="<?php if(isset($search)) { echo $search; } ?>"/>
    </form>
</h2>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact No</th>
            <th>Position</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($agents)){
                foreach($agents as $row){
                    echo "<tr>";
                    echo "<td>" . $row->id . "</td>";
                    echo "<td>" . $row->getCompleteName() . "</td>";
                    echo "<td>" . $row->email . "</td>";
                    echo "<td>" . $row->contactNo . "</td>";
                    echo "<td>" . $row->positionTb->position . "</td>";
                    echo "<td>";
                    echo "<a href='Agents/generate_contractor_single/" . $row->id . "' class='open-modal'
                                        title='Generate Report' data-header='Contractor Report'>
                                        <i class='icon-file icon-white'></i>
                                    </a>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'><div class='text-center'>NO RECORDS FOUND!</div></td></tr>";
            }
        ?>
    </tbody>
</table>
<div class="pagination"></div>