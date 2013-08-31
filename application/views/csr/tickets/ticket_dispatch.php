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
        if(empty($contractors)){
        	echo "<tr><td colspan='5' class='table-center'>No Records Found</td></tr>";
        } else {
	        foreach ($contractors as $row) {
	            echo "<tr>";
	            echo "<td>" . $row->userTb->id . "</td>";
	            echo "<td>" . $row->userTb->firstName . "</td>";
	            echo "<td>" . $row->userTb->email . "</td>";
	            echo "<td>" . $row->userTb->contactNo . "</td>";
	            echo "<td class='table-center'><a class='open-modal' title='View Available Schedule' data-header='Contractor Details'
	                    href='Tickets/view_contractor/" . $row->userTb->id . "'>
	                        <i class='icon-search icon-white'></i></a></td>";
	            echo "</tr>";
	        }
        }
        ?>
    </tbody>
</table>