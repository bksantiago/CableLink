<h2>AGENTS LIST</h2>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact No</th>
            <th class="table-center">Position</th>
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
                echo "</tr>";
            }
        ?>
    </tbody>
</table>