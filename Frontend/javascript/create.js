$(document).ready(function(){
    $("#title").on("input", function(){
        $("#resTitle").text($(this).val());
    });
});
$(document).ready(function(){
    $("#ingress").on("input", function(){
        $("#resIngress").text($(this).val());
    });
});