<script>
$(document).ready(function(){
    $("#all").change(function(){
        if($(this).is(":checked")){
            $(".checks").prop("checked", true);
            $("#btnConfirm").attr("href", "Agents/generate_multiple/2-3-4");
        } else {
            $(".checks").prop("checked", false);
            $("#btnConfirm").attr("href", "Agents/generate_multiple/2-3-4");
        }
    });

    $(".checks").change(function(){
        var val = "";
        $(".checks").each(function(){
            if($(this).is(":checked")){
                val += $(this).val() + "-";
            }
        });        
        val = val.slice(0, -1);
        $("#btnConfirm").attr("href", "Agents/generate_multiple/" + val);
        
    });
});
</script>
<form class="form-horizontal">
    <fieldset>
        <legend>MULTIPLE AGENT REPORTS
        </legend>
        <div class="control-group">
            <div class="control-label"></div>
            <div class="controls">              
                <input type="checkbox" class="span1"
                       id="all"/>CHECK ALL
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">CSR 1</div>
            <div class="controls">              
                <input type="checkbox" class="span1 checks" value="2"
                       id="two" />Customer Service Representative (Tier 1)
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">CSR 2</div>
            <div class="controls">              
                <input type="checkbox" class="span1 checks" value="3"
                       id="three"/>Customer Service Representative (Tier 2)
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">NOC</div>
            <div class="controls">              
                <input type="checkbox" class="span1 checks" value="4"
                       id="four"/>Network Operation Center
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"></div>
            <div class="controls">
                <a href="Agents/generate_multiple/2-3-4" class="open-modal btn btn-primary btn-medium" data-header="Generate Agents Report"
                    id="btnConfirm">Send Filtered Agents</a>
            </div>
        </div>
    </fieldset>
</form>