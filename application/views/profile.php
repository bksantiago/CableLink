<div class="wrapper">
    <div class="row">
        <div class="span4"><h2><?php echo $user->firstName . "'s Profile"; ?></h2></div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row-fluid">
        <div class="span3">
            <div class="profile-pic">
                <?php if(isset($myProfile)) { ?>
                <div class="upload">
                    <form method="POST" id="profile-upload" action="Profile/upload" enctype="multipart/form-data" style="margin: 0;">
                        <input type="file" id="upload_pic" accept="image/png, image/gif, image/jpeg" name="file" style="position: absolute; opacity: 0; cursor: pointer;" />
                    </form>
                    <img src="images/upload.png" width="25" height="25" />Upload new picture (2mb)</div>
                <?php } ?>
                <?php if(!file_exists('./uploads/' . $user->id . '.jpg')) { ?>
                    <img src="images/profile/blank_male.gif" id="pic"/>
                <?php } else { ?>
                    <img src="<?php echo "./uploads/" . $user->id . '.jpg' ?>" id="pic"/>
                <?php }?>
            </div>
        </div>
        <div class="span2">Full Name:</div>
        <div class="span7"><?php echo $user->firstName . " " . $user->middleName . " " . $user->lastName; ?></div>
        <div class="span2">E-mail Address:</div>
        <div class="span7"><?php echo $user->email; ?></div>
        <div class="span2">Contact No:</div>
        <div class="span7"><?php echo $user->contactNo; ?></div>
        <div class="span9">&nbsp;</div>
        <div class="span2">Position:</div>
        <div class="span7"><?php echo $user->positionTb->position; ?></div>
    </div>
    <div class="row-fluid">
        <div class="span12">&nbsp;</div>
    </div>
    <?php if($user->positionTb->id == 5){ ?>
    <h3>Cities Assigned: </h3>
    <h4 style='margin-left: 20px'>
        <?php 
            for($i = 0 ; $i < count($cities); $i++){
                echo $cities[$i]->city->city;
                if($i < count($cities) - 1)
                    echo ", ";
            }
        ?>
    </h4>

    <h3>Schedule</h3>
    <?php
        echo "<table class='table table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Day</th>";
        echo "<th colspan='4'>Time</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $day = "";
        $ctrTime = 0;
        for($i = 0; $i < count($schedules); $i++) {
            if($day != $schedules[$i]->schedDay->day){
                $ctrTime = 0;
                $day = $schedules[$i]->schedDay->day;
                echo "<tr>";
                echo "<td>" . $day . "</td>";
            }

            //if($schedules[$i]->schedTime->id == 1){
                echo "<td>" . $schedules[$i]->schedTime->schedule . "</td>";
            //}

            if($i == count($schedules) - 1){
                echo "</tr>";
            } else if($day != $schedules[$i+1]->schedDay->day){
                echo "</tr>";
            }
        }
        echo "</tbody>";
        echo "</table>";
    } ?>
    <?php if(!empty($assigned)) {?>
    <h4>TICKETS ASSIGNED</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ticket #</th>
                <th>Account #</th>
                <th>Date Started</th>
                <th>Date Ended</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($assigned as $row){
                    echo "<tr>";
                    echo "<td><a href='Tickets/view/" . $row->id . "' class='open-modal short-link' 
                            title='View Complete Details'
                            data-header='Ticket Information'>" . $row->id . "</a></td>";
                    echo "<td><a href='Customers/view/" . $row->accountTb->id . "' class='open-modal short-link'
                        data-header='Customer Information' title='View Customer Details'>" . 
                            $row->accountTb->id . "</a></td>";
                    echo "<td>" . date("F d, Y h:i A", strtotime($row->dateStart)) . "</td>";
                    if(empty($row->dateEnd)){
                       echo "<td>--</td>";
                    } else {
                        echo "<td>" . date("F d, Y h:i A", strtotime($row->dateEnd)) . "</td>";
                    }
                    if(!empty($row->dateEnd)){
                        echo "<td>Resolved</td>";
                    } else {
                        echo "<td>Pending</td>";
                    }
                    echo "</tr>";
                }
                 ?>
        </tbody>
    </table>
    <?php } ?>
</div>