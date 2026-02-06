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


$(document).ready(function () {
    if($(window).width() > 576){
        $('#Flight-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/flight-bg-js.jpg")');
        });
        $('#Hotel-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/hotel-bg-js.jpg")');
        });
        $('#Bus-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/bus-bg-js.jpg")');
        });
        $('#Insurance-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/bimeh-bg-js.jpg")');
        });
        $('#Tour-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/tour-bg-js.jpg")');
        });
        $('#Entertainment-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/tafrihat-bg-js.jpg")');
        });
        $('#Visa-tab').click(function (){
            $('.banner-demo').css('background-image', 'url("images/visa-bg-js.jpg")');
        });
    }    $(".select2 , .select-route-bus-js , .default-select2 , .gasht-type-js , .select-route-bus-js , .select2_in").select2();
    $(".switch-input-tour-js").on("change", function () {
        if (this.checked && this.value === "1") {
            $(".international-tour-js").css("display", "flex")
            $(".internal-tour-js").hide()
        } else {
            $(".international-tour-js").hide()
            $(".internal-tour-js").css("display", "flex")
        }
    })
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

