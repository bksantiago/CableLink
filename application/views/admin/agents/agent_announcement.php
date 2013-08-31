<script>
$(document).ready(function(){
    saveValidatedForm("Agents/announcement_save", "announcement-form");
});
</script>
<form class="form-horizontal" id="announcement-form" data-title="Announcement Updated!">
    <fieldset>
        <legend>Announcement</legend>
        <div class="control-group">
            <div class="control-label">Header</div>
            <div class="controls">
                <input type="text" class="span3" placeholder="Announcement header"
                       name="header" value="" required/>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Content</div>
            <div class="controls">
                <textarea class="span7" rows="10" placeholder="Announcement Contents" name="information" required></textarea>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"></div>
            <div class="controls">
                <button type="submit" class="btn btn-primary" id="btn-submit">Post Announcement</button>
            </div>
        </div>
    </fieldset>
</form>
<h3>PREVIOUS ANNOUNCEMENT</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Posted By : <?php echo $announcement->createdBy->firstName; ?></th>
            <th>Date Posted : <?php echo date("F d, Y h:i A", strtotime($announcement->createdDate)); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2"><?php echo $announcement->header; ?></td>
        </tr>
        <tr>
            <td colspan="2"><div class="expand announce"><?php echo $announcement->information; ?></div></td>
        </tr>
    </tbody>
</table>