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


// کد برای انتخاب نفر در بیمه
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggleBime = document.querySelector('.dropdown-toggle-insurance');
    console.log(dropdownToggleBime)
    const dropdownMenu = document.querySelector('.dropdown-menu-insurance');
    const increaseButtons = document.querySelectorAll('.increase');
    const decreaseButtons = document.querySelectorAll('.decrease');

    function updateTotalPassengers() {
        const counts = document.querySelectorAll('.counter-insurance span');
        let total = 0;
        counts.forEach((count ,index) => {
            const countValue = parseInt(count.textContent);
            total += countValue;
        });
        if(dropdownToggleBime != null) {
            if (total > 0 ) {
                dropdownToggleBime.textContent = total + ' مسافر';
            } else {
                dropdownToggleBime.textContent = 'تعداد مسافر';
            }
        }
        $('#passengers-count-js').val(total);
    }

    if (dropdownToggleBime != null) {
        // باز و بسته کردن منو با کلیک روی دکمه
        dropdownToggleBime.addEventListener('click', function(event) {
            event.stopPropagation(); // جلوگیری از انتشار رویداد به body
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        // بستن منو با کلیک خارج از آن
        document.addEventListener('click', function(event) {
            if (!dropdownMenu.contains(event.target) && !dropdownToggleBime.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }


    increaseButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const countSpan = this.parentElement.querySelector('span');
            let group = this.getAttribute('data-age')
            let count = parseInt(countSpan.textContent);
            countSpan.textContent = count + 1;
            updateTotalPassengers();
            const newInput = createAgeInput(index + '-' + count , group);
            this.parentElement.parentElement.appendChild(newInput);
        });
    });

    decreaseButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const countSpan = this.parentElement.querySelector('span');
            let count = parseInt(countSpan.textContent);
            if (count > 0) {
                countSpan.textContent = count - 1;
                updateTotalPassengers();
                const inputId = 'txt_birth_insurance' + index + '-' + (count - 1);
                const inputToRemove = document.getElementById(inputId);
                if (inputToRemove) {
                    inputToRemove.remove();
                }
            }
        });
    });

    updateTotalPassengers();
});
