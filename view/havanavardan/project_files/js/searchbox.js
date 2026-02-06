$(document).ready(function () {
    $(".select2 , .select-route-bus-js , .default-select2 , .gasht-type-js , .select2_in").select2();
    $('.switch-input-js').on('change', function() {
        if (this.checked && this.value === '1') {
            $('.international-flight-js').css('display', 'flex')
            $('.internal-flight-js').hide()
            $('.flight-multi-way-js').hide()
            $(this).attr('select_type','yes')
        } else {
            $('.internal-flight-js').css('display', 'flex')
            $('.international-flight-js').hide()
            $('.flight-multi-way-js').hide()
            $('.switch-input-js').removeAttr('select_type')
        }
    })
    $('.select-type-way-js').on('click', function () {
        let type = $(this).data('type');
        let class_element = $(`.${type}-one-way-js`);
        let arrival_date =  $(`.${type}-arrival-date-js`)
        if (class_element.is(':checked')) {
            arrival_date.attr("disabled", "disabled");
        } else {
            arrival_date.removeAttr("disabled");
        }
    });
    $('.click_flight_multi_way').on('click', function() {
        $('.flight-multi-way-js').css('display', 'flex')
        $('.internal-flight-js').hide()
        $('.international-flight-js').hide()
    })
    $('.click_flight_oneWay').on('click', function() {
        $('.international-flight-js').css('display', 'flex')
        $('.internal-flight-js').hide()
        $('.flight-multi-way-js').hide()
    })
    $('.click_flight_twoWay').on('click', function() {
        $('.international-flight-js').css('display', 'flex')
        $('.internal-flight-js').hide()
        $('.flight-multi-way-js').hide()
    })
    $(".switch-input-hotel-js").on("change", function () {
        $(".init-shamsi-datepicker").val("")
        $(".init-shamsi-return-datepicker").val("")
        $(".nights-hotel-js").val("")
        if (this.checked && this.value === "1") {
            $(".internal-hotel-js").css("display", "flex")
            $(".international-hotel-js").hide()
            $(".type-section-js").val("internal")
        } else {
            $(".internal-hotel-js").hide()
            $(".international-hotel-js").css("display", "flex")
            $(".type-section-js").val("international")
        }
    })

});