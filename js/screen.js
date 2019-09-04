$(window).on('resize', function() {
    if($(window).height() > 990) {
        $('#menu').addClass('desktop');
        $('#menu').removeClass('mobile');
    }
    else{
        $('#menu').addClass('mobile');
        $('#menu').removeClass('desktop');
    }
})


$(window).on('resize', function() {
    if($(window).height() < 990) {
        $('#menu').addClass('mobile');
        $('#menu').removeClass('desktop');
       
    }
    else{
        $('#menu').addClass('desktop');
        $('#menu').removeClass('mobile');
    }
})