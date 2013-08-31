<script>
$(document).ready(function(){
    $("body").delegate(".confirm-inline", "click", function(e){
        e.preventDefault();
        var par = $(this).parent("button");

        par.removeClass();
        par.addClass("btn");
        par.addClass("btn-primary");
        par.addClass("btn-small");
        par.html("Confirm");

        par.after("<input type='button' class='btn btn-small btn-danger confirm-stop' value='Cancel' />");
    });

    $("body").delegate(".confirm-stop", 'click', function(){
        var par = $(this).prev("button");
        $(this).remove();
        
        par.removeClass();
        par.addClass("btn-transparent");
        par.html("<i class='icon-share icon-white confirm-inline'></i>");
    });

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
            <th>Position</th>
            <th>Tickets Handled</th>
            <th class="table-center"><i class="icon-cog icon-white"></i></th>
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
                echo "<td class='table-center'>
                        <form class='clearfix' method='POST' action='Tickets/doReassign/" . $ticketId . "'>
                            <input type='hidden' value='" . $row->id . "' name='agentId'/>
                            <button type='submit' class='btn-transparent' title='Reassign'>
                            <i class='icon-share icon-white confirm-inline'></i></button>
                        </form>
                     </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
<div class="pagination"></div>