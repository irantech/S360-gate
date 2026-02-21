$(document).ready(function () {
    $('input:radio[name="btn_switch_tour"]').change(
        function(){
            if (this.checked && this.value == '1') {


                $('#international_tour').css('display','flex');
                $('#internal_tour').hide();


            }
            else {
                $('#international_tour').hide();
                $('#internal_tour').css('display','flex');
            }
        });



    $(".select2 , .select-route-bus-js , .default-select2 , .gasht-type-js , .select2_in").select2();

    // Helper function to update return date status based on one-way/round-trip selection
    function updateReturnDateStatus(type) {
        let class_element = $(`.${type}-one-way-js`);
        let arrival_date = $(`.${type}-arrival-date-js`);
        if (class_element.is(':checked')) {
            arrival_date.attr("disabled", "disabled");
        } else {
            arrival_date.removeAttr("disabled");
        }
    }

    $('.switch-input-js').on('change', function() {
        if (this.checked && this.value === '1') {
            $('.international-flight-js').css('display', 'flex')
            $('.internal-flight-js').hide()
            $('.flight-multi-way-js').hide()
            $(this).attr('select_type','yes')
            // Update return date status for international flights
            updateReturnDateStatus('international')
        } else {
            $('.internal-flight-js').css('display', 'flex')
            $('.international-flight-js').hide()
            $('.flight-multi-way-js').hide()
            $('.switch-input-js').removeAttr('select_type')
            // Update return date status for internal flights
            updateReturnDateStatus('internal')
        }
    })

    // Event handler for internal flight one-way/round-trip radio buttons
    $('input[name="select-rb2"]').on('change', function() {
        let arrival_date = $('.internal-arrival-date-js');
        if ($('.internal-one-way-js').is(':checked')) {
            arrival_date.attr("disabled", "disabled");
        } else {
            arrival_date.removeAttr("disabled");
        }
    });

    // Event handler for international flight one-way/round-trip radio buttons
    $('input[name="select-rb"]').on('change', function() {
        let arrival_date = $('.international-arrival-date-js');
        if ($('.international-one-way-js').is(':checked')) {
            arrival_date.attr("disabled", "disabled");
        } else {
            arrival_date.removeAttr("disabled");
        }
    });

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
