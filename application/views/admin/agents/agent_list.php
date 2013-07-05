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
            <th>Email</th>
            <th>Contact No</th>
            <th>Position</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($agents as $row){
                echo "<tr>";
                echo "<td>" . $row->id . "</td>";
                echo "<td>" . $row->getCompleteName() . "</td>";
                echo "<td>" . $row->email . "</td>";
                echo "<td>" . $row->contactNo . "</td>";
                echo "<td>" . $row->positionTb->position . "</td>";
                echo "<td><a href='Profile?id=$row->id' title='View Complete Profile'>
                        <i class='icon-search icon-white'></i></a></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
<div class="pagination"></div>