<script>
$(document).ready(function(){
    $(".table").tableNav({
        itemsPerPage: 10
    });
});
</script>
<h2>ANNOUNCEMENT ARCHIVE
</h2>
<table class="table">
    <thead>
        <tr>
            <th>Header</th>
            <th>Posted Date</th>
            <th>Posted By</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($announcements)){
                foreach($announcements as $row){
                    echo "<tr>";
                    echo "<td>" . $row->header . "</td>";
                    echo "<td>" . date('F d, Y h:i A' ,strtotime($row->createdDate)) . "</td>";
                    echo "<td>" . $row->createdBy->firstName . "</td>";                   
                    echo "<td class='table-center'>
                    	<a href='Archive/announcement_view/" . $row->id ."' 
                    		class='open-modal' data-header='Announcement' title='View Complete ANNOUNCEMENT'>
                            <i class='icon-search icon-white'></i></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'><div class='text-center'>NO ANNOUNCEMENT FOUND!</div></td></tr>";
            }
        ?>
    </tbody>
</table>
<div class="pagination"></div>