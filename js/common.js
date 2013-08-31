/* 
    Document   : common
    Created on : Apr 30, 2013, 7:56:56 PM
    Author     : Bk Santiago 
    Description:
        Purpose of the stylesheet follows.
*/

$(document).ready(function(){
    //var page = window.location.pathname.split('/').pop();
    var page = window.location.href.split('/').pop();
    $('.nav li a[href$="' + page + '"]').parent().addClass('active');
    console.log(page);
    $(".nav-list li a").click(function(){
        $(".nav-list li").removeClass("active");
        $(this).parent("li").addClass("active");
        
        var url = $(this).attr("href"); 
        loadContent(url, "contents");
        $("#contents").removeAttr('title');
        $("#contents").attr('title', url);
        return false;
    });
    
    $(".nav-list li.active a").click();
    
    $("body").delegate('#search-form', 'submit', function(event){
        event.preventDefault();
        loadContent($(this).closest("div").attr("title") + "?search=" + $("#txt-search").val(), 
            $(this).closest("div").attr("id"));
    });

    var back = null;
    var oldLabel = "";
    /*
     *   .open-modal
     *   a href=AJAX CALL
     *   class=self explain
     *   id=Modal Header || change to data-header
     *   then modal-body title will be the url.
     *   
     */
    
    $("body").delegate('.open-modal', 'click', function(){
        oldLabel = $("#dynamicModalLabel").text();
        var url = $(this).attr("href");
        loadContent(url, "dynamic-modal .modal-body");
        $("#dynamicModalLabel").text($(this).attr("data-header"));
        if(back != null)
            $("#dynamicModalLabel").prepend("<a href='" + $("#dynamic-modal-body").attr("title") + "' " + 
                "class='back-modal' data-header='" + $(this).attr("data-header") + "'><img src='images/back.png' class='icon'></a> ");
            
        $("#dynamic-modal").modal("show");
        $("#dynamic-modal-body").attr("title", url);
        return false;
    });

    $("body").delegate(".back-modal", 'click', function(){
        var url = $(this).attr("href");
        $("#dynamic-modal .modal-body").html(back);
        $(".back-modal").remove();
        $("#dynamic-modal-body").attr("title", url);
        $("#dynamicModalLabel").text(oldLabel);
        return false;
    });
    
    $("#dynamic-modal").on("show", function(){
        $("body").css({overflow:"hidden"});
        $(this).find('.modal-body').css({height:'auto', 
                              'max-height':'100%'});
        back = $("#dynamic-modal-body").html();
    });

    $("#dynamic-modal").on("hide", function(e){
        if(e.target === this){
            back = null;
            console.log(back);
            $("#dynamic-modal-body").html("");
            $("body").css({overflow:"auto"});
            if($(".alert").length > 0)
                loadContent($("#contents").attr('title'), 'contents');
        }
    });
    
    $(".expand").readmore({
        substr_len: 300,
        more_link: "<p><a href='javascript: void(0);' class='readm-more btn btn-primary btn-large'>Read More &raquo;</a></p>"
    });
    
    $("body").delegate(".open-content", 'click', function(){
        var url = $(this).attr("href");
        loadContent(url, "contents");
        return false;
    });
    
    var isConfirmed = false;
    $("body").delegate("#confirm-form", 'submit', function(){
        $("#confirm-modal").modal("show");
        if(!isConfirmed)
            return false;
    });
    
    $("body").delegate("#btn-confirm", 'click', function(){
        isConfirmed = true;
        $("#confirm-form").submit();
    });
    
    //TICKETS
    $("body").delegate(".select-c", 'click', function(){
        $("#dynamic-modal").modal("hide");
        $("#txt-search").val($(this).attr("id"));
        $("#search-form").submit();
    });
    
    $("body").delegate("#ajaxSubmit", 'submit', function(event){
        event.preventDefault();
        $('body').animate({
                scrollTop: 0
            }, 'slow');
        url = $(this).attr("action") + "?" + $(this).serialize();
        loadContent(url, "contents");

    });
    
    var timer = null;
    $("body").delegate('.auto-save', 'keypress keydown', function(){
        var me = $(this);
        clearTimeout(timer);
        timer = setTimeout(function(){
            $.ajax({
                url: "Tickets/saveNotes",
                type: "POST",
                data: {
                    id : me.attr("id"),
                    notes: me.val()
                },
                success: function(response){
                    $(".alert").remove();
                    if(response == "ok"){
                        me.parent("div").append("<div class='push'><br />" +
                            "<div class='alert alert-success'>Notes Saved!</div></div>");
                        setTimeout(function(){
                            $(".push").fadeOut("slow", function(){$(this).remove();});
                        }, 1500);
                    }
                }
            });
        }, 500);
    });
    
    //Profile
    $("#upload_pic").change(function(){
        $(this).parent("form").submit();
    });

    //custom validator
    $.validator.addMethod("alphanumeric",function(value,element)
    {
    return this.optional(element) || /^[a-zA-Z '.\\s]{1,40}$/i.test(value); 
    },"Enter a valid name (No Special Characters)");
});

function loadContent(url, content){
    var h = $("#" + content).html();

    if(h == ""){
        $("#" + content).html("Loading...");
    }
    $("#" + content).css("opacity", .5);
    $("#" + content).load(url, function(){
        $("#" + content).css("opacity", 1);
    });
}

function saveValidatedForm(url, form){
    $("#" + form).validate({
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('success');
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        },
        submitHandler: function(myForm){
            if(confirm("Confirm Submission?")){
                
                $("#" + form).css("opacity", .5);
                $(".alert").remove();        
                var originalSubmit = $("#btn-submit").text();
                $("#btn-submit").prop("disabled", true);
                $("#btn-submit").text("Please wait...");
                $.ajax({
                url: url,
                type: "POST",
                async: false,
                data: $("#" + form).serialize(),
                success: function(response){
                    
                        var m = response.split(";");
                        var msg = $("#" + form).attr("data-title");
                        $('.control-group').removeClass('success');
                        if(m[0] == "save"){
                            $("#" + form)[0].reset();
                            $(".contractor-group").hide();
                            $("input[type=checkbox]").prop("checked", false);
                        }
                        if(m[1] == "top")
                            $("#" + form).prepend("<div class='alert alert-success' id='alerts'>"+msg+"</div>");
                        else if(m[1] == "bottom")
                            $("<div class='alert alert-success'>"+msg+"</div>").insertBefore("#" + form + " div:last");
                            //$("#" + form).append("<div class='alert alert-success'>"+msg+"</div>");
                   
                }, error: function(response){
                    $("#" + form).append("<div class='alert alert-error'>An error has occur, Please try again.</div>");
                }
            
                }).done(function(){
                    $("#" + form).css("opacity", 1);
                    $("#btn-submit").text(originalSubmit);
                    $("#btn-submit").prop("disabled", false);
                    $('body').animate({
                        scrollTop: 0
                    }, 'slow');
                });
            }
        }
    });
}