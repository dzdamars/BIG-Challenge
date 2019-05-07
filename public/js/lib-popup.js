jQuery.displayConfirm = function(message,okfunc,nofunc){
    $("#confirmMsg").html(message);
    $("#confirmPanel").fadeIn(function(){
        $("#confirmContent").css("left",(($(window).width()-$("#confirmContent").outerWidth(true))/2));
        $("#confirmContent").css("top",(($(window).height()-$("#confirmContent").outerHeight(true))/2)-50);
        $("#confirmContent").show();
        $("#btnYesConfirm").focus();
        $("#btnYesConfirm").prop('disabled',false);
        $("#btnYesConfirm").unbind( "click");
        $("#btnYesConfirm").click(function(){
            $("#confirmPanel").fadeOut(okfunc);
            $("#btnYesConfirm").prop('disabled',true);
        });
        $("#btnNoConfirm").unbind( "click" );
        $("#btnNoConfirm").click(function(){
            $("#confirmPanel").fadeOut(nofunc);
        });
    });
}

jQuery.displayInfo = function(message, okfunc){
    $("#infoMsg").html(message);
    $("#infoPanel").fadeIn(function(){
        $("#infoContent").css("left",(($(window).width()-$("#infoContent").outerWidth(true))/2));
        $("#infoContent").css("top",(($(window).height()-$("#infoContent").outerHeight(true))/2)-50);
        $("#infoContent").show();
        $("#btnOkInfo").focus();
        $("#btnOkInfo").unbind("click" );
        $("#btnOkInfo").click(function(){
            if(okfunc != undefined)
                $("#infoPanel").fadeOut(okfunc);
            else
                $("#infoPanel").fadeOut();
        });
    });
};


jQuery.displayError = function(message, okfunc){
    $("#errorMsg").html(message);
    $("#errorPanel").fadeIn(function(){
        $("#errorContent").css("left",(($(window).width()-$("#errorContent").outerWidth(true))/2));
        $("#errorContent").css("top",(($(window).height()-$("#errorContent").outerHeight(true))/2)-50);
        $("#errorContent").show();
        $("#btnOkError").unbind( "click" );
        $("#btnOkError").focus();
        
        $("#btnOkError").click(function(){
            $("#errorContent").hide();
            if(okfunc != undefined)
                $("#errorPanel").fadeOut(okfunc);
            else
                $("#errorPanel").fadeOut();
        });        
    });
};