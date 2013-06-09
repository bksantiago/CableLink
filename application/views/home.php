<div class="hero-unit transparent-box">
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
        <h1><?php echo $announce->header; ?></h1>
        <p><pre class="expand"><?php echo $announce->information; ?></pre></p>
    <small class="pull-right"><i>
            <?php echo date("F d, Y h A", strtotime($announce->createdDate)); ?> | 
            by <?php echo $announce->createdBy->firstName; ?></i>
    </small>
<?php } ?>
<div class="row">
    <form method="POST" action="Comment/save">
        <div class="span6">
            <textarea style="width: 100%;" maxlength="255" name="comment" required placeholder="Add your comment here..."></textarea>
        </div>
        <div class="span2">
            <input type="hidden" name="announcementId" value="<?php echo $announce->id; ?>" />
            <input type="submit" value="Add Comment" class="btn btn-primary btn-large"/>
        </div>
    </form>
</div>

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

</div>