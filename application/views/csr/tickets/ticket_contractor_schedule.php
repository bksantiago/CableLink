<script>
$(document).ready(function(){
    <?php
        $d = "";
        for($i=0; $i < count($days); $i++) {
            $d .= "dt.getDay() == " . $days[$i]->schedDay->id;
            if($i < count($days) - 1){
                $d .= " || ";
            }
        } 
    ?>
    $(".datepicker").datepicker({
            dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            beforeShowDay: highlightDays,
            onSelect: selectDate,

        });

    function highlightDays(dt){
        var rr;
        /*$.ajax({
            type: "POST",
            url: "Tickets/view_calendar",
            async: false,
            data: {
                userId : <?php echo $user->id; ?>,
                date: $.datepicker.formatDate('mm/dd/yy', dt),
                day: dt.getDay()
            },
            success: function(response){
                if(response != null && response != ""){
                    rr = response;
                }
            }
        });*/
        if(rr == "f"){
            return <?php echo $d; ?> ? [true, "fullDay"] : [false, ""];
        } else {
            return [<?php echo $d; ?> ? true : false];
        }
    }

    function selectDate(date){
        var dd = new Date(date);
        $.ajax({
            type: "POST",
            url: "Tickets/view_date/",
            data: {
                userId : <?php echo $user->id; ?>,
                day: dd.getDay()
            },
            success: function(response){
                $("#schedules").empty();
                var time = JSON.parse(response);
                $.each(time, function(index, value){

                    //TODO ajax para makita yung schedule sa time.
                    var sched = "";
                    $.ajax({
                        type: "POST",
                        url: "Tickets/view_dispatch_time",
                        async: false,
                        data: {
                            userId: <?php echo $user->id; ?>,
                            date: $.datepicker.formatDate('mm/dd/yy', dd),
                            time: value.schedTime.id                
                        },
                        success: function(data){
                            sched = JSON.parse(data);
                        }
                    });

                    var today = new Date();
                    var ass = "";
                    var btn = "";
                    if(sched.id == ""){
                        ass = " | Unassigned ";
                    } else {
                        ass = " | Assigned";
                        btn = "<ul><li>Assigned on <a href='Tickets/view/" + sched.ticketTb.id + "' class=  'open-modal' " +
                            "title='View Ticket Summary' data-header='Ticket Information'>" +
                            "Ticket # " + sched.ticketTb.id + "</a></ul>";
                    }

                    if(dd > today && sched.id == ""){
                        btn = "<ul><li data-date='" + $.datepicker.formatDate('mm/dd/yy', dd) + "' data-time='" + value.schedTime.id + "'>" +
                        "<button type='button' class='save-schedule btn btn-primary btn-small'>Assign to this schedule</button></ul>";
                    }

                    $("#schedules").append("<li><h5>" + value.schedTime.schedule + ass + btn + "<h5>");
                    $("#sched-date").html($.datepicker.formatDate('MM dd, yy', dd));
                });
            }
        });
    }
    $("#schedules").delegate(".save-schedule", 'click', function(){
        $(this).prop("disabled", true);
        var date = $(this).parent("li").attr("data-date");
        var ticketId = $("#ticketId").val();
        var time = $(this).parent("li").attr("data-time");

        var me = $(this).parent("li");
        $.ajax({
            type: "POST",
            url: "Tickets/save_dispatch",
            async: false,
            data: {
                userId: <?php echo $user->id; ?>,
                ticketId: ticketId,
                time: time,
                date: date,
            },
            success: function(response){
                $("#contents").load("Tickets/assigned");            
                selectDate(new Date(date));
            },
            error: function(response){
                alert("An error has occur");
            }
        });
        $(this).prop("disabled", false);
    });
});
</script>
<h2><?php echo $user->getCompleteName() . "'s Schedule"; ?></h2>
<ul>
<?php
    foreach ($days as $day) {
        echo "<li>" . $day->schedDay->day . " ";
        foreach($schedules as $s){
            if($day->schedDay->id == $s->schedDay->id){
                echo " | " . $s->schedTime->schedule;
            }
        }
    }
?>
</ul>
<div class="datepicker"></div>
<div>
    <h2>Available Time for : <span id='sched-date'></span> </h2>
    <ul id="schedules">

    </ul>
</div>