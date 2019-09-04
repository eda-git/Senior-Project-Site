        $("div#cards a").on("click", function(){
    var val = $(this).data("value");
    var loadUrl = "ajaxhome.php?home=" + val;
    $("#ajax_delivery").load(loadUrl);
    $('#ajax_delivery').addClass('active');
    console.log("success");
})