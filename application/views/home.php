<div class="hero-unit transparent-box">
    <?php $none = false; if($announce->header == "" && $announce->information == "") { $none = true; }?>
    <?php if($none){ ?>
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
</div>