<?php
    $none = false;
    if ($announce->header == "" && $announce->information == "") {
        $none = true;
    }
    ?>
    <?php if ($none) { ?>
        <h1>No Announcement Yet!</h1>
        <p>since <?php echo date('F d, Y h A', strtotime($announce->createdDate)); ?></p>
    <?php } else { ?>
        <h1 style="word-wrap: break-word;"><?php echo $announce->header; ?></h1>
        <p><pre class="expand"><?php echo $announce->information; ?></pre></p>
    <small class="pull-right"><i>
            <?php echo date("F d, Y h A", strtotime($announce->createdDate)); ?> | 
            by <?php echo $announce->createdBy->firstName; ?></i>
    </small>
<?php } ?>
<div>&nbsp;</div>
<?php foreach ($announce->comments as $comment) { ?>
<div class="row-fluid comment-pic">
        <div class="span1" align="center">
            <?php echo "<a href='Profile?id=" . $comment->createdBy->id . "' class='short-link' />"; ?>
            <?php
            if (!file_exists('./uploads/' . $comment->createdBy->id . '.jpg')) {
                echo "<img src='images/profile/blank_male.gif' />";
            } else {
                echo "<img src='uploads/" . $comment->createdBy->id . ".jpg' />";
            }
            ?>
        <?php echo "</a>"; ?>
        </div>
        <div class="span7">
            <pre class="span12"><?php echo $comment->comment; ?></pre>
        </div>
        <div class="span4 details">
            <i><?php
        echo "<a href='Profile?id=" . $comment->createdBy->id . "' class='short-link' />" . 
                $comment->createdBy->firstName . " (" . $comment->createdBy->positionTb->code . ")</a>";
        echo " |<br/> ";
        echo date("F d, Y h:i A", strtotime($comment->createdDate));
            ?>
            </i>
        </div>
</div>
    <?php } ?>