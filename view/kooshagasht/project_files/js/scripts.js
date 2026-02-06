$('.w-tabs-item').mouseenter(function () {

    $('.w-tabs-item').removeClass('active_t')
    $(this).addClass('active_t')

    var index = $(this).index();
    $('.w-tabs-section').hide()
    switch (index) {
        case 0:
            $('.w-tabs-section:first-child').fadeIn()
            break;
        case 1:
            $('.w-tabs-section:nth-child(2)').fadeIn()
            break;
        case 2:
            $('.w-tabs-section:nth-child(3)').fadeIn()
            break;
        case 3:
            $('.w-tabs-section:nth-child(4)').fadeIn()
            break;

    }

});
