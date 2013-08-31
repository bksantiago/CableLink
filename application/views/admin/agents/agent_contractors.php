<h2>CONTRACTOR LIST</h2>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact No</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($contractors as $row) {
            echo "<tr>";
            echo "<td>" . $row->id . "</td>";
            echo "<td>" . $row->firstName . "</td>";
            echo "<td>" . $row->email . "</td>";
            echo "<td>" . $row->contactNo . "</td>";
            echo "<td class='table-center'><a class='open-modal' title='View Available Schedule' data-header='Contractor Details'
                        href='Tickets/view_contractor/" . $row->id . "'>
                            <i class='icon-search icon-white'></i></a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>