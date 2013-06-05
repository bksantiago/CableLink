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
                    <form method="POST" id="profile-upload" action="profile/upload" enctype="multipart/form-data" style="margin: 0;">
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
        <div class="span4">

        </div>
    </div>
</div>