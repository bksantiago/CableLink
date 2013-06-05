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
        <div class="span6">
            <textarea style="width: 100%;" maxlength="255" placeholder="Add your comment here..."></textarea>
        </div>
        <div class="span2"><input type="button" value="Add Comment" class="btn btn-primary btn-large"/></div>
    </div>
<div class="row-fluid comment-pic">
    <div class="span1" align="center"><img src="uploads/1.jpg" /></div>
    <div class="span4">Comments here... hahahha</div>
</div>
</div>