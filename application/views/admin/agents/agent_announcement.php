<script>
$(document).ready(function(){
    saveValidatedForm("Agents/announcement_save", "announcement-form");
});
</script>
<form class="form-horizontal" id="announcement-form" title="Announcement Updated!">
    <fieldset>
        <legend>Announcement</legend>
        <div class="control-group">
            <div class="control-label">Header</div>
            <div class="controls">
                <input type="text" class="span3" placeholder="Announcement header"
                       name="header" value="<?php echo $announcement->header; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Content</div>
            <div class="controls">
                <textarea class="span7" rows="10" placeholder="Announcement Contents" name="information"><?php
                    echo $announcement->information;
                ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"></div>
            <div class="controls">
                <button type="submit" class="btn btn-primary" id="btn-submit">Save Announcement</button>
            </div>
        </div>
    </fieldset>
</form>