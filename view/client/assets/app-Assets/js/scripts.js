$('.select2').select2({
    language: "fa"
});

function openList(tabname) {
    switch(tabname) {
        case 'flight':
            $('.card_search.flight_list').addClass('opening');
            break;
        case 'hotel':
            $('.card_search.hotel_list').addClass('opening');
            break;
            case 'tour':
            $('.card_search.tour_list').addClass('opening');
            break;
            case 'train':
            $('.card_search.train_list').addClass('opening');
            break;
            case 'bus':
            $('.card_search.bus_list').addClass('opening');
            break;
            case 'insurance':
            $('.card_search.insurance_list').addClass('opening');
            break;

    }


}

function closeList(tabname) {

    $('.card_search').removeClass('opening')
}

$('.switch-label-off').click();
$('input:radio[name="DOM_TripMode8"]').change(
    function(){
        if (this.checked && this.value == '1') {
            $('#flight_khareji').css('display','flex');
            $('#flight_dakheli').hide();

        }
        else {
            $('#flight_khareji').hide();
            $('#flight_dakheli').css('display','flex');
        }
    });

$('input:radio[name="DOM_TripMode4"]').change(
    function(){
        if (this.checked && this.value == '1') {


            $('#hotel_khareji').css('display','flex');
            $('#hotel_dakheli').hide();


        }
        else {
            $('#hotel_khareji').hide();
            $('#hotel_dakheli').css('display','flex');
        }
    });
