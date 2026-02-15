/**
 * Format time input automatically - adds colon after 2 digits
 * @param {HTMLInputElement} input - The input element
 * @param {string} value - The current value
 */
var isEditMode = false;
function formatTimeInput(input, value) {
    // Store cursor position before formatting
    const cursorPos = input.selectionStart;
    const oldValue = input.value;
    
    // Remove all non-digits
    let digits = value.replace(/\D/g, '');
    
    // Limit to 4 digits (HH:MM format)
    if (digits.length > 4) {
        digits = digits.substring(0, 4);
    }
    
    // Format with colon
    let formatted = '';
    if (digits.length >= 1) {
        formatted = digits.substring(0, 1);
    }
    if (digits.length >= 2) {
        formatted = digits.substring(0, 2) + ':';
    }
    if (digits.length >= 3) {
        formatted = digits.substring(0, 2) + ':' + digits.substring(2, 3);
    }
    if (digits.length >= 4) {
        formatted = digits.substring(0, 2) + ':' + digits.substring(2, 4);
    }
    
    // Update input value
    input.value = formatted;
    
    // Calculate new cursor position
    let newCursorPos = cursorPos;
    
    // If we're deleting and the old value had a colon but new value doesn't
    if (oldValue.length > formatted.length && oldValue.includes(':') && !formatted.includes(':')) {
        // User is backspacing through the colon, keep cursor at the end
        newCursorPos = formatted.length;
    }
    // If we're adding digits and crossing the colon position
    else if (formatted.length > oldValue.length && formatted.includes(':') && oldValue.length === 2) {
        // User just typed the second digit, position cursor after colon
        newCursorPos = 3;
    }
    // If we're deleting and the cursor is at the colon position
    else if (cursorPos === 3 && formatted.length >= 3 && formatted.charAt(2) === ':') {
        // User is backspacing at colon position, move cursor before colon
        newCursorPos = 2;
    }
    // If we're deleting and the cursor is after colon
    else if (cursorPos > 3 && formatted.length < oldValue.length) {
        // User is backspacing in minutes section, adjust cursor position
        newCursorPos = Math.min(cursorPos, formatted.length);
    }
    // Normal case - keep cursor at same relative position
    else {
        newCursorPos = Math.min(cursorPos, formatted.length);
    }
    
    // Set cursor position
    input.setSelectionRange(newCursorPos, newCursorPos);
}

/**
 * Initialize time input formatting for an element
 * @param {string} selector - CSS selector for the input element
 */
function initTimeInput(selector) {
    const input = document.querySelector(selector);
    if (!input) return;
    
    // Add event listeners
    input.addEventListener('input', function(e) {
        formatTimeInput(this, this.value);
    });
    
    input.addEventListener('keydown', function(e) {
        // Allow: backspace, delete, tab, escape, enter, and navigation keys
        if ([8, 9, 27, 13, 46, 37, 38, 39, 40].indexOf(e.keyCode) !== -1 ||
            // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true)) {
            return;
        }
        
        // Allow only digits
        if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) {
            return;
        }
        
        // Prevent other keys
        e.preventDefault();
    });
    
    input.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const digits = pastedText.replace(/\D/g, '').substring(0, 4);
        
        if (digits.length > 0) {
            formatTimeInput(this, digits);
        }
    });
}

/**
 * Initialize all time inputs on the page
 */
function initAllTimeInputs() {
    // Initialize existing time inputs
    const timeInputs = document.querySelectorAll('.time-input, input[data-time-format="true"]');
    timeInputs.forEach(function(input) {
        initTimeInput('#' + input.id);
    });
}

// Initialize time inputs when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initAllTimeInputs();
});

 
$(document).ready(function () {
    $('#quick_origin_airport, #quick_origin_region, #quick_destination_airport, #quick_destination_region, #quick_type_of_vehicle, #quick_airline').each(function() {
        var $select = $(this);

        // فعال سازی Select2
        $select.select2({
            width: '100%'
        });

        // وقتی باز می‌شود (focus)
        $select.on('select2:open', function() {
            $select.data('select2').$container.css({
                'border': '2px solid #007bff',
                'box-shadow': '0 0 5px rgba(0,123,255,0.5)'
            });
        });

        // وقتی بسته می‌شود (blur)
        $select.on('select2:close', function() {
            $select.data('select2').$container.css({
                'border': '',
                'box-shadow': ''
            });
        });
    });


    $('.select2').select2();
    $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
        $(this).closest("li").toggleClass("active", this.checked);
    });

    $(document).on('click', '.allow-focus', function (e) {
        e.stopPropagation();
    });

    ///////اضافه کردن شماره پرواز//
    $("#FormFlyNumber").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            destination_country: "required",
            destination_city: "required",
            origin_airport_name: "required",
            destination_airport_name: "required",
            fly_code: "required",
            type_of_plane: "required",
            free: "required",
            type_of_vehicle: "required",
            airline: "required",
            vehicle_grade_id: "required",
            minutes: "required",
            hours: "required",
            select_type_flight: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن شماره پرواز جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن شماره پرواز جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }
                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });



    ///////ویرایش شماره پرواز//
    $("#EditFlyNumber").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            destination_country: "required",
            destination_city: "required",
            origin_airport_name: "required",
            destination_airport_name: "required",
            fly_code: "required",
            type_of_plane: "required",
            free: "required",
            type_of_vehicle: "required",
            airline: "required",
            vehicle_grade_id: "required",
            ticket_type: "required",
            minutes: "required",
            hours: "required",
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات شماره پرواز',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات شماره پرواز',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });
    ///////اضافه کردن بلیط//
    $("#FormTicket2").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            destination_country: "required",
            destination_city: "required",
            fly_code: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            // Validate agency allocations before submission
            if (!validateAgencyAllocations()) {
                return false;
            }

            $(".loaderPublic").css("display","block");

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    $(".loaderPublic").css("display","none");

                    console.log(response);
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {

                        $.toast({
                            heading: 'افزودن بلیط جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                           window.location ='../manifest/results';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن بلیط جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });


    ///////ویرایش بلیط//
    $("#FormEditTicket").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            destination_country: "required",
            destination_city: "required",
            fly_code: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if (!confirm("شما دکمه ویرایش اطلاعات را زده اید. از این تغییرات مطمئن هستید؟")) {
                return false; // اگر لغو کرد، اصلاً ادامه نده
            }
            $(".loaderPublic").css("display","block");

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    $(".loaderPublic").css("display","none");

                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {

                        $.toast({
                            heading: 'ویرایش بلیط',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                           window.location ='../reservation/reportTicket';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش بلیط',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });



    ///////ویرایش بلیط//
    $("#FormEditOneTicket").validate({
        rules: {

        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {

                        $(".loaderPublic").css("display","none");

                        $.toast({
                            heading: 'ویرایش بلیط',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش بلیط',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });






    ///////درصد کنسلی بلیط//
    $("#formCancellationsPercentageTickets").validate({
        rules: {
            time_cancel_1: "required",
            percent_cancel_1: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    console.log(response);
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {

                        $.toast({
                            heading: 'ثبت درصد کنسلی',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ثبت درصد کنسلی',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });









});


///////نمایش اطلاعات مربوط به شماره پرواز انتخاب شده//
function InformationFlyNumber(){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            fly_code: $('#fly_code').val(),
            flag: "InformationFlyNumber"
        },
        function (data) {

            if (data=='error'){

                $('#vehicle_grade').val('');
                $('#flight_time').val('');
                $('#free').val('');

            }else {

                var arrStates = data.split(",");
                $('#vehicle_grade').val(arrStates[0]);
                $('#flight_time').val(arrStates[1]);
                $('#free').val(arrStates[2]);

            }

        })

}//end function


function isDigit(entry)
{
    var key = window.event.keyCode;
    if((key>=48 && key<=57) || key==122) {
        return true;
    } else {
        $.confirm({
            title: 'خطا در ورود اطلاعات',
            content: "لطفا در اين فيلد فقط عدد وارد کنید. ",
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: 'بستن',
                    btnClass: 'btn-red'

                }
            }
        });
        return false;
    }
}

function separator(txt){
    var iDistance = 3;
    var strChar = ",";
    var strValue = txt.value;

    if(strValue.length>3){
        var str="";
        for(var i=0;i<strValue.length;i++){
            if(strValue.charAt(i)!=strChar){
                if ((strValue.charAt(i) >= 0) && (strValue.charAt(i) <= 9)){
                    str=str+strValue.charAt(i);
                }
            }
        }

        strValue=str;
        var iPos = strValue.length;
        iPos -= iDistance;
        while(iPos>0){
            strValue = strValue.substr(0,iPos)+strChar+strValue.substr(iPos);
            iPos -= iDistance;
        }
    }
    txt.value=strValue;
}




//////////حذف منطقی///////
function logicalDeletionAllTicket(id_same, origin_city, destination_city, airline, fly_code)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'hotel_ajax.php',
                        {
                            id_same: id_same,
                            origin_city: origin_city,
                            destination_city: destination_city,
                            airline: airline,
                            fly_code: fly_code,
                            flag: 'logicalDeletionAllTicket'
                        },
                        function (data) {

                            var res = data.split(':');
                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            }else {
                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                            }

                        });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}



function logicalDeletionTicket(id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'hotel_ajax.php',
                        {
                            id: id,
                            flag: 'logicalDeletionTicket'
                        },
                        function (data) {

                            var res = data.split(':');
                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            }else {
                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                            }

                        });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}



function editCancellationsTickets(id, ticket_id_same)
{
    var time_cancel = $('#update_time_cancel_' + id).val();
    var percent_cancel = $('#update_percent_cancel_' + id).val();

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'hotel_ajax.php',
                        {
                            id: id,
                            ticket_id_same: ticket_id_same,
                            time_cancel: time_cancel,
                            percent_cancel: percent_cancel,
                            flag: 'editCancellationsTickets'
                        },
                        function (data) {

                        console.log(data);
                            var res = data.split(':');
                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                            }else {
                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                            }

                            setTimeout(function () {
                                location.reload();
                            }, 1000);

                        });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}


function selectTypFlight(obj) {
    let type = $(obj).val();
    if(type==='internal'){
        $('.internal_airport').show();
        $('.international_airport').hide();
    }else if(type==='international'){
        $('.internal_airport').hide();
        $('.international_airport').show();
    }
}


// Global variables to store selected days
let selectedDays = []
let selectedAgencies = {};
let dayCapacityLimits = {}; // Store capacity limits for each day and grade
let agencyAllocations = {}; // Store agency allocations by day and grade

// Function to handle day checkbox changes and update agency allocation
var firstFilledDay = null;
var firstDayValues = {
    time: '',
    vehicle: '',
    capacities: []
};

function toggleDayCardChange(dayIndex) {
    var checkbox = $('#sh' + dayIndex);
    var dayCard = $('#dayCard' + dayIndex);
    var dayNum = parseInt(dayIndex);

    if (checkbox.is(':checked')) {
        dayCard.addClass('active');
        if (!selectedDays.includes(dayNum)) selectedDays.push(dayNum);

        // 1️⃣ اول فیلدها رو بساز
        generateCapacityFields(dayNum);

        // 2️⃣ بعد از ساخت فیلدها (یک لحظه بعد)، مقادیر رو کپی کن
        setTimeout(function () {
            // ثبت روز اول اگر هنوز تعیین نشده
            if (firstFilledDay === null) {
                firstFilledDay = dayNum;
            }

            // کپی مقادیر روز اول به روز جدید (غیر از روز اول)
            if (firstFilledDay !== null && dayNum !== firstFilledDay) {
                // ساعت و وسیله نقلیه
                $('#day_departure_time_' + dayNum).val($('#day_departure_time_' + firstFilledDay).val());
                $('#day_type_of_vehicle_' + dayNum).val($('#day_type_of_vehicle_' + firstFilledDay).val());

                // ظرفیت‌ها و آپدیت limit-item
                $('#capacityFields' + firstFilledDay + ' input').each(function () {
                    var idParts = $(this).attr('id').split('_'); // ["day","capacity","6","2"]
                    var gradeId = idParts[3];
                    var val = $(this).val();

                    // مقدار input روز جدید
                    var newInput = $('#day_capacity_' + dayNum + '_' + gradeId);
                    newInput.val(val);

                    // مهم: صدا زدن updateCapacityForGrade برای بروزرسانی dayCapacityLimits و limit-value
                    updateCapacityForGrade(dayNum, gradeId, val);
                });
            }

            // === ساخت یا آپدیت div خلاصه ظرفیت در limitsGrid ===
            let limitDiv = $('#limit-item-' + dayNum);
            if (limitDiv.length === 0) {
                $('#limitsGrid').append(`
                    <div class="limit-item" id="limit-item-${dayNum}">
                        <div class="limit-day">${getDayName(dayNum)}</div>
                        <div class="limit-value" id="limit-value-${dayNum}">0</div>
                        <div class="limit-label">صندلی</div>
                    </div>
                `);
                limitDiv = $('#limit-item-' + dayNum);
            }

            // جمع ظرفیت‌ها بعد از کپی (در واقع updateCapacityForGrade خودش آپدیت می‌کنه، ولی اینجا هم می‌تونه اضافه باشه)
            let totalCapacity = 0;
            $('#capacityFields' + dayNum + ' input').each(function () {
                totalCapacity += parseInt($(this).val()) || 0;
            });
            $('#limit-value-' + dayNum).text(totalCapacity);

            updateCapacityLimits();
        }, 0);
    } else {
        dayCard.removeClass('active');
        selectedDays = selectedDays.filter(d => d !== dayNum);

        $('#capacityFields' + dayNum).html('');
        $('#day_departure_time_' + dayNum).val('');
        $('#day_type_of_vehicle_' + dayNum).val('');

        delete dayCapacityLimits[dayNum];

        Object.keys(selectedAgencies).forEach(function (agencyId) {
            if (selectedAgencies[agencyId].allocations && selectedAgencies[agencyId].allocations[dayNum]) {
                delete selectedAgencies[agencyId].allocations[dayNum];
            }
        });

        // حذف limit-item مربوط به روزی که تیکش برداشته شد
        $('#limit-item-' + dayNum).remove();

        if (firstFilledDay === dayNum) {
            firstFilledDay = null;
        }

        updateCapacityLimits();
    }

    updateAgencyAllocationGrid();
}

// تابع کمکی برای نام روز
function getDayName(dayIndex) {
    switch(dayIndex) {
        case 6: return "جمعه";
        case 5: return "پنج‌شنبه";
        case 4: return "چهارشنبه";
        case 3: return "سه‌شنبه";
        case 2: return "دوشنبه";
        case 1: return "یک‌شنبه";
        case 0: return "شنبه";
        default: return "روز";
    }
}

// Function to generate capacity fields for selected vehicle grades
// تاب‌ ایندکس شروع هر روز
var dayTabIndexStart = {
    0: 11, // شنبه
    1: 17, // یکشنبه
    2: 23, // دوشنبه
    3: 29, // سه‌شنبه
    4: 35, // چهارشنبه
    5: 41, // پنجشنبه
    6: 47  // جمعه
};

function generateCapacityFields(dayIndex) {
    console.log('generateCapacityFields called with dayIndex:', dayIndex);

    var container = $('#capacityFields' + dayIndex);
    console.log('Container selector:', '#capacityFields' + dayIndex, 'found=', container.length);

    // اگر کانتینر وجود نداشت، از کار بازگرد
    if (!container.length) {
        console.warn('Container not found for dayIndex:', dayIndex);
        return;
    }

    var selectedGrades = $('#vehicle_grades').val();
    console.log('Raw selectedGrades:', selectedGrades);

    // اگر فقط یک مقدار برگشته (string یا number) آن را به آرایه تبدیل کن
    if (selectedGrades && !Array.isArray(selectedGrades)) {
        selectedGrades = [selectedGrades];
        console.log('Normalized selectedGrades to array:', selectedGrades);
    }

    if (!selectedGrades || selectedGrades.length === 0) {
        console.log('No grades selected, showing message');
        container.html('<div class="capacity-field"><span style="color: #6c757d; font-size: 12px;">لطفاً ابتدا درجه وسیله نقلیه را انتخاب کنید</span></div>');
        return;
    }

    var startIndex = dayTabIndexStart[dayIndex];
    if (typeof startIndex === 'undefined') {
        console.warn('No start tabindex defined for dayIndex:', dayIndex, 'using 1 as fallback');
        startIndex = 1;
    }

    var fieldsHtml = '';

    // دقت: استفاده از (gradeId, i) تا اندیس i در دسترس باشد
    selectedGrades.forEach(function(gradeId, i) {
        // امن‌سازی gradeId به رشته یا عدد
        gradeId = String(gradeId);
        var gradeOption = $('#vehicle_grades option[value="' + gradeId + '"]');
        var gradeName = gradeOption.length ? gradeOption.text().trim() : ('کلاس ' + gradeId);

        var tabindex = startIndex + i; // درست: از i استفاده می‌کنیم

        console.log('Adding field dayIndex=', dayIndex, 'gradeId=', gradeId, 'gradeName=', gradeName, 'tabindex=', tabindex);

        fieldsHtml += `
            <div class="capacity-field">
                <label>کلاس ${gradeName}</label>
                <input type="number"
                       name="day_capacity_${dayIndex}_${gradeId}"
                       id="day_capacity_${dayIndex}_${gradeId}"
                       placeholder="ظرفیت"
                       min="0"
                       class="form-control"
                       tabindex="${tabindex}"
                       onchange="updateCapacityForGrade(${dayIndex}, ${gradeId}, this.value)">
            </div>
        `;
    });

    console.log('Generated HTML length:', fieldsHtml.length);
    container.html(fieldsHtml);
    console.log('HTML set to container for dayIndex:', dayIndex);
}

// Function to update capacity for a specific grade
function updateCapacityForGrade(dayIndex, gradeId, value) {
    console.log(`Day ${dayIndex}, Grade ${gradeId}, Capacity: ${value}`);
    
    // Store the capacity limit for this day and grade
    if (!dayCapacityLimits[dayIndex]) {
        dayCapacityLimits[dayIndex] = {};
    }
    dayCapacityLimits[dayIndex][gradeId] = parseInt(value) || 0;
    
    // Update capacity limits display
    updateCapacityLimits();
    
    // Update allocation grid to reflect new limits
    updateAgencyAllocationGrid();
}

// Function to handle agency selection for day-based allocation
function selectAgencyForDays(id, name, obj) {
    var isChecked = $(obj).is(":checked");
    
    if (isChecked) {
        selectedAgencies[id] = {
            id: id,
            name: name,
            allocations: {}
        };
    } else {
        delete selectedAgencies[id];
    }
    
    updateAgencyAllocationGrid();
}

// Function to update capacity limits display
function updateCapacityLimits() {
    console.log('updateCapacityLimits called');
    console.log('Day capacity limits:', dayCapacityLimits);
    
    var panel = $('#capacityLimitsPanel');
    var grid = $('#limitsGrid');
    
    if (selectedDays.length === 0 || Object.keys(dayCapacityLimits).length === 0) {
        panel.hide();
        return;
    }
    
    panel.show();
    
    var dayNames = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
    var gridHtml = '';
    
    selectedDays.sort().forEach(function(dayIndex) {
        var dayName = dayNames[dayIndex];
        var dayLimits = dayCapacityLimits[dayIndex] || {};
        var totalLimit = 0;
        
        // Calculate total limit for this day
        Object.values(dayLimits).forEach(function(limit) {
            totalLimit += parseInt(limit) || 0;
        });
        
        gridHtml += `
            <div class="limit-item">
                <div class="limit-day">${dayName}</div>
                <div class="limit-value">${totalLimit}</div>
                <div class="limit-label">صندلی</div>
            </div>
        `;
    });
    
    grid.html(gridHtml);
}

// Function to update the agency allocation grid
function updateAgencyAllocationGrid() {
    console.log('updateAgencyAllocationGrid called');
    
    var container = $('#agency-allocation-grid');
    var emptyState = $('#agency-empty-state');
    
    console.log('Container found:', container.length > 0);
    console.log('Empty state found:', emptyState.length > 0);

    
    console.log('Selected days:', selectedDays);
    console.log('Selected agencies:', Object.keys(selectedAgencies));
    
    // Check if we have selected days
    if (selectedDays.length === 0) {
        console.log('No days selected, showing empty state');
        container.hide();
        emptyState.show();
        return;
    }
    
    // If we have selected days but no agencies, show the grid with instructions
    if (Object.keys(selectedAgencies).length === 0) {
        console.log('Days selected but no agencies, showing instructions');
        emptyState.hide();
        container.show();
        
        var gridHtml = `
            <div class="allocation-grid-header">
                <i class="fa fa-calendar"></i>
                <h5>تخصیص صندلی</h5>
            </div>
            <div class="allocation-grid-body">
                <div style="text-align: center; padding: 20px; color: #6c757d;">
                    <i class="fa fa-building" style="font-size: 24px; color: #dee2e6; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 13px;">برای تخصیص صندلی، آژانس‌های مورد نظر را انتخاب کنید</p>
                </div>
            </div>
        `;
        
        container.html(gridHtml);
        return;
    }
    
    emptyState.hide();
    container.show();
    
    // Build the allocation grid
    var gridHtml = `
        <div class="allocation-grid-header">
            <i class="fa fa-calendar"></i>
            <h5>تخصیص صندلی</h5>
        </div>
        <div class="allocation-grid-body">
    `;
    
    // Get day names
    var dayNames = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
    
    Object.values(selectedAgencies).forEach(function(agency) {
        gridHtml += `
            <div class="agency-allocation-row">
                <div class="agency-row-header">
                    <span class="agency-name">${agency.name}</span>
                    <button type="button" class="agency-remove-btn2" onclick="removeAgencyFromAllocation('${agency.id}', '${agency.name}')">
                        <i class="fa fa-times"></i> حذف
                    </button>
                </div>
                <div class="days-allocation-grid">
        `;
        
        selectedDays.sort().forEach(function(dayIndex) {
            var dayName = dayNames[dayIndex];
            var dayLimits = dayCapacityLimits[dayIndex] || {};
            var hasCapacity = Object.keys(dayLimits).length > 0;
            
            if (hasCapacity) {
                // Show grade-based allocation for this day
                Object.keys(dayLimits).forEach(function(gradeId) {
                    var gradeOption = $('#vehicle_grades option[value="' + gradeId + '"]');
                    var gradeName = gradeOption.text().trim();
                    var gradeLimit = dayLimits[gradeId];
                    var currentValue = (agency.allocations && agency.allocations[dayIndex] && agency.allocations[dayIndex][gradeId]) || '';
                    
                    gridHtml += `
                        <div class="day-allocation-item active">
                            <span class="day-name">${dayName} - ${gradeName}</span>
                            <input type="number" 
                                   name="agency_selected[${agency.id}][${dayIndex}][${gradeId}]" 
                                   class="day-allocation-input" 
                                   placeholder="تعداد" 
                                   min="0"
                                   max="${gradeLimit}"
                                   value="${currentValue}"
                                   data-agency="${agency.id}"
                                   data-day="${dayIndex}"
                                   data-grade="${gradeId}"
                                   data-limit="${gradeLimit}"
                                   onchange="updateGradeAllocation('${agency.id}', ${dayIndex}, ${gradeId}, this.value)" >
                            <input type="hidden" 
                                   name="agency_day_grade_${agency.id}_${dayIndex}_${gradeId}" 
                                   value="${currentValue}"
                                   data-agency="${agency.id}"
                                   data-day="${dayIndex}"
                                   data-grade="${gradeId}">
                            ${gradeLimit > 0 ? `<div class="limit-info">حداکثر: ${gradeLimit}</div>` : ''}
                        </div>
                    `;
                });
            } else {
                // Show empty state for this day
                gridHtml += `
                    <div class="day-allocation-item">
                        <span class="day-name">${dayName}</span>
                        <div style="text-align: center; color: #6c757d; font-size: 11px; padding: 10px;">
                            ظرفیت تنظیم نشده
                        </div>
                    </div>
                `;
            }
        });
        
        gridHtml += `
                </div>
            </div>
        `;
    });
    
    gridHtml += '</div>';
    
    container.html(gridHtml);
    
    // Update summary
    updateAllocationSummary();
}

// Function to remove agency from allocation
function removeAgencyFromAllocation(agencyId, agencyName) {
    delete selectedAgencies[agencyId];
    
    // Uncheck the agency checkbox
    $(`input[onclick*="selectAgencyForDays('${agencyId}','${agencyName}']`).prop('checked', false);
    
    updateAgencyAllocationGrid();
}

// Function to update grade-based allocation
function updateGradeAllocation(agencyId, dayIndex, gradeId, value) {
    if (!selectedAgencies[agencyId]) {
        selectedAgencies[agencyId] = { allocations: {} };
    }
    if (!selectedAgencies[agencyId].allocations[dayIndex]) {
        selectedAgencies[agencyId].allocations[dayIndex] = {};
    }
    
    var numValue = parseInt(value) || 0;
    var gradeLimit = dayCapacityLimits[dayIndex] && dayCapacityLimits[dayIndex][gradeId] ? dayCapacityLimits[dayIndex][gradeId] : 0;
    
    // Calculate current total allocation for this grade across all agencies
    var totalAllocated = 0;
    Object.values(selectedAgencies).forEach(function(agency) {
        if (agency.allocations && agency.allocations[dayIndex] && agency.allocations[dayIndex][gradeId]) {
            totalAllocated += parseInt(agency.allocations[dayIndex][gradeId]) || 0;
        }
    });
    
    // Remove the current agency's allocation from total to get other agencies' total
    var otherAgenciesTotal = totalAllocated - (selectedAgencies[agencyId].allocations[dayIndex][gradeId] || 0);
    
    // Validate against capacity limit
    if (gradeLimit > 0 && (otherAgenciesTotal + numValue) > gradeLimit) {
        var availableCapacity = gradeLimit - otherAgenciesTotal;
        alert(`تعداد وارد شده بیشتر از ظرفیت مجاز است. حداکثر ظرفیت قابل تخصیص: ${availableCapacity}`);
        numValue = Math.max(0, availableCapacity);
        $(`input[data-agency="${agencyId}"][data-day="${dayIndex}"][data-grade="${gradeId}"]`).val(numValue);
    }
    
    selectedAgencies[agencyId].allocations[dayIndex][gradeId] = numValue;
    
    // Update corresponding hidden field
    $(`input[name="agency_day_grade_${agencyId}_${dayIndex}_${gradeId}"]`).val(numValue);
    
    // Update input styling based on limit
    var input = $(`input[data-agency="${agencyId}"][data-day="${dayIndex}"][data-grade="${gradeId}"]`);
    input.removeClass('limit-exceeded limit-warning');
    
    if (gradeLimit > 0) {
        var totalForThisGrade = otherAgenciesTotal + numValue;
        var percentage = (totalForThisGrade / gradeLimit) * 100;
        if (percentage >= 100) {
            input.addClass('limit-exceeded');
        } else if (percentage >= 80) {
            input.addClass('limit-warning');
        }
    }
    
    updateAllocationSummary();
}

// Function to update allocation summary
function updateAllocationSummary() {
    var container = $('#agency-allocation-grid');
    
    // Remove existing summary
    container.find('.allocation-summary-box').remove();
    
    var totalAllocated = 0;
    var dayGradeTotals = {};
    var totalLimit = 0;
    
    // Calculate totals and limits
    Object.values(selectedAgencies).forEach(function(agency) {
        Object.entries(agency.allocations || {}).forEach(function([dayIndex, gradeAllocations]) {
            if (!dayGradeTotals[dayIndex]) {
                dayGradeTotals[dayIndex] = {};
            }
            Object.entries(gradeAllocations || {}).forEach(function([gradeId, count]) {
                if (!dayGradeTotals[dayIndex][gradeId]) {
                    dayGradeTotals[dayIndex][gradeId] = 0;
                }
                dayGradeTotals[dayIndex][gradeId] += count;
                totalAllocated += count;
            });
        });
    });
    
    // Calculate total limit
    Object.values(dayCapacityLimits).forEach(function(dayLimits) {
        Object.values(dayLimits).forEach(function(limit) {
            totalLimit += parseInt(limit) || 0;
        });
    });
    
    if (totalAllocated > 0) {
        var dayNames = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
        var summaryHtml = `
            <div class="allocation-summary-box">
                <div class="allocation-summary-title">
                    <i class="fa fa-chart-bar"></i>
                    خلاصه تخصیص‌ها
                </div>
                <div class="allocation-summary-content">
        `;
        
        // Add total summary item
        var totalPercentage = totalLimit > 0 ? Math.round((totalAllocated / totalLimit) * 100) : 0;
        var totalStatusClass = totalPercentage >= 100 ? 'danger' : (totalPercentage >= 80 ? 'warning' : 'success');
        
        summaryHtml += `
            <div class="allocation-summary-item total-item">
                <div class="status-indicator ${totalStatusClass}"></div>
                <div class="label">کل تخصیص شده</div>
                <div class="value">${totalAllocated}${totalLimit > 0 ? ` / ${totalLimit}` : ''}</div>
                ${totalLimit > 0 ? `<div class="percentage">${totalPercentage}%</div>` : ''}
                <div class="progress-container">
                    <div class="progress-bar ${totalStatusClass}" style="width: ${Math.min(totalPercentage, 100)}%"></div>
                </div>
            </div>
        `;
        
        selectedDays.sort().forEach(function(dayIndex) {
            var dayName = dayNames[dayIndex];
            var dayLimits = dayCapacityLimits[dayIndex] || {};
            var dayTotal = 0;
            var dayLimit = 0;
            
            Object.keys(dayLimits).forEach(function(gradeId) {
                var gradeAllocated = dayGradeTotals[dayIndex] && dayGradeTotals[dayIndex][gradeId] ? dayGradeTotals[dayIndex][gradeId] : 0;
                var gradeLimit = dayLimits[gradeId];
                dayTotal += gradeAllocated;
                dayLimit += gradeLimit;
                
                var gradeOption = $('#vehicle_grades option[value="' + gradeId + '"]');
                var gradeName = gradeOption.text().trim();
                var limitText = gradeLimit > 0 ? ` / ${gradeLimit}` : '';
                var percentage = gradeLimit > 0 ? Math.round((gradeAllocated / gradeLimit) * 100) : 0;
                var statusClass = percentage >= 100 ? 'danger' : (percentage >= 80 ? 'warning' : 'success');
                
                summaryHtml += `
                    <div class="allocation-summary-item">
                        <div class="status-indicator ${statusClass}"></div>
                        <div class="label">${dayName} - ${gradeName}</div>
                        <div class="value">${gradeAllocated}${limitText}</div>
                        ${gradeLimit > 0 ? `<div class="percentage">${percentage}%</div>` : ''}
                        <div class="progress-container">
                            <div class="progress-bar ${statusClass}" style="width: ${Math.min(percentage, 100)}%"></div>
                        </div>
                    </div>
                `;
            });
            
            if (Object.keys(dayLimits).length > 1) {
                var limitText = dayLimit > 0 ? ` / ${dayLimit}` : '';
                var percentage = dayLimit > 0 ? Math.round((dayTotal / dayLimit) * 100) : 0;
                var statusClass = percentage >= 100 ? 'danger' : (percentage >= 80 ? 'warning' : 'success');
                
                summaryHtml += `
                    <div class="allocation-summary-item total-item">
                        <div class="status-indicator ${statusClass}"></div>
                        <div class="label">${dayName} - کل</div>
                        <div class="value">${dayTotal}${limitText}</div>
                        ${dayLimit > 0 ? `<div class="percentage">${percentage}%</div>` : ''}
                        <div class="progress-container">
                            <div class="progress-bar ${statusClass}" style="width: ${Math.min(percentage, 100)}%"></div>
                        </div>
                    </div>
                `;
            }
        });
        
        summaryHtml += `
                </div>
            </div>
        `;
        
        container.append(summaryHtml);
    }
    
    // Update status indicator
    updateAllocationStatus(totalAllocated, totalLimit);
}

// Function to update allocation status
function updateAllocationStatus(allocated, limit) {
    var statusDot = $('#allocationStatus .status-dot');
    var statusText = $('#allocationStatus .status-text');
    
    if (limit === 0) {
        statusDot.css('background', '#6c757d');
        statusText.text('آماده');
    } else if (allocated === 0) {
        statusDot.css('background', '#ffc107');
        statusText.text('انتظار');
    } else if (allocated >= limit) {
        statusDot.css('background', '#dc3545');
        statusText.text('تکمیل');
    } else if (allocated >= limit * 0.8) {
        statusDot.css('background', '#ffc107');
        statusText.text('نزدیک');
    } else {
        statusDot.css('background', '#28a745');
        statusText.text('در حال');
    }
}


// Initialize the new allocation system on page load
    $(document).ready(function() {
    console.log('Document ready - initializing allocation system');

    // Check if vehicle grades select exists
    var vehicleGradesSelect = $('#vehicle_grades');
    console.log('Vehicle grades select found:', vehicleGradesSelect.length > 0);

    // Check if day checkboxes exist
    var dayCheckboxes = $('.day-checkbox');
    console.log('Day checkboxes found:', dayCheckboxes.length);

    // Listen for vehicle grade changes
    vehicleGradesSelect.on('change', function() {
        console.log('Vehicle grades changed');

        // Clear capacity limits when grades change
        dayCapacityLimits = {};

        // Regenerate capacity fields for all selected days
        selectedDays.forEach(function(dayIndex) {
            generateCapacityFields(dayIndex);
        });
        updateCapacityLimits();
        updateAgencyAllocationGrid();
    });

    // Note: Day checkboxes already have onchange="toggleDayCardChange(X)" in HTML
    // So we don't need to add additional jQuery event handlers here
    console.log('Day checkboxes already have onchange attributes in HTML');

    // Initial check for already selected days on page load
    /*$('.day-checkbox:checked').each(function() {
        var dayIndex = parseInt($(this).val());
        console.log('Found pre-checked day:', dayIndex);
        if (!selectedDays.includes(dayIndex)) {
            alert(dayIndex);
            selectedDays.push(dayIndex);
            generateCapacityFields(dayIndex);
        }
    });*/

    $('.day-checkbox').on('change', function () {
        var dayIndex = parseInt($(this).val());

        if ($(this).is(':checked')) {
            if (!selectedDays.includes(dayIndex)) {
                selectedDays.push(dayIndex);
                generateCapacityFields(dayIndex);
            }
        } else {
            // اگر برداشت تیک نیاز به حذف فیلد دارد اینجا بنویس
            removeCapacityFields(dayIndex);
            selectedDays = selectedDays.filter(x => x !== dayIndex);
        }
    });
    // Initial update of agency allocation grid
    updateAgencyAllocationGrid();

    console.log('Initialization complete');

    // Add a test button for debugging (remove this later)
    // if ($('#agency-allocation-grid').length > 0) {
    //     $('<button type="button" onclick="testDaySelection()" style="margin: 10px; padding: 5px 10px; background: #007bff; color: white; border: none; border-radius: 3px;">Test Day Selection</button>').insertBefore('#agency-allocation-grid');
    // }
});

// Test function for debugging
function testDaySelection() {
    console.log('=== TEST FUNCTION ===');
    console.log('Selected days:', selectedDays);
    console.log('Selected agencies:', selectedAgencies);

    // Test selecting day 0
    console.log('Testing day 0 selection...');
    console.log('Checkbox sh0 exists:', $('#sh0').length > 0);
    console.log('Checkbox sh0 checked before:', $('#sh0').is(':checked'));

    $('#sh0').prop('checked', true);
    console.log('Checkbox sh0 checked after prop:', $('#sh0').is(':checked'));

    // Manually call toggleDayCardChange
    console.log('Manually calling toggleDayCardChange(0)');
    toggleDayCardChange(0);

    console.log('Selected days after manual call:', selectedDays);

    // Test vehicle grades
    var grades = $('#vehicle_grades').val();
    console.log('Current vehicle grades:', grades);

    // Test capacity fields generation
    if (selectedDays.length > 0) {
        console.log('Testing capacity fields generation for day:', selectedDays[0]);
        generateCapacityFields(selectedDays[0]);
    }
}

// Test function for grade-based agency allocation
function testGradeBasedAllocation() {
    // Test data
    var testDay = 0; // Sunday
    var testGrade1 = 1; // First grade
    var testGrade2 = 2; // Second grade
    var testAgency1 = 'agency1';
    var testAgency2 = 'agency2';
    
    // Set up test capacities
    dayCapacityLimits[testDay] = {
        [testGrade1]: 20,
        [testGrade2]: 10
    };
    
    // Set up test agencies
    selectedAgencies[testAgency1] = {
        id: testAgency1,
        name: 'Test Agency 1',
        allocations: {}
    };
    
    selectedAgencies[testAgency2] = {
        id: testAgency2,
        name: 'Test Agency 2',
        allocations: {}
    };
    
    // Test allocation
    console.log('Testing allocation: Agency 1 gets 15 seats for grade 1');
    updateGradeAllocation(testAgency1, testDay, testGrade1, 15);
    
    console.log('Testing allocation: Agency 2 gets 5 seats for grade 1');
    updateGradeAllocation(testAgency2, testDay, testGrade1, 5);
    
    console.log('Testing allocation: Agency 1 gets 8 seats for grade 2');
    updateGradeAllocation(testAgency1, testDay, testGrade2, 8);
    
    console.log('Testing allocation: Agency 2 gets 2 seats for grade 2');
    updateGradeAllocation(testAgency2, testDay, testGrade2, 2);
    
    // Test validation
    console.log('Testing validation: Try to allocate more than capacity');
    updateGradeAllocation(testAgency1, testDay, testGrade1, 10); // Should fail
    
    console.log('Current allocations:', selectedAgencies);
    console.log('Current capacity limits:', dayCapacityLimits);
    
    // Update display
    updateAgencyAllocationGrid();
    updateAllocationSummary();
}

// Function to validate agency allocations before form submission
function validateAgencyAllocations() {
    var isValid = true;
    var errors = [];
    
    // Check each day and grade
    selectedDays.forEach(function(dayIndex) {
        var dayLimits = dayCapacityLimits[dayIndex] || {};
        
        Object.keys(dayLimits).forEach(function(gradeId) {
            var gradeLimit = dayLimits[gradeId];
            var totalAllocated = 0;
            
            // Calculate total allocation for this grade across all agencies
            Object.values(selectedAgencies).forEach(function(agency) {
                if (agency.allocations && agency.allocations[dayIndex] && agency.allocations[dayIndex][gradeId]) {
                    totalAllocated += parseInt(agency.allocations[dayIndex][gradeId]) || 0;
                }
            });
            
            if (totalAllocated > gradeLimit) {
                var dayNames = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
                var gradeOption = $('#vehicle_grades option[value="' + gradeId + '"]');
                var gradeName = gradeOption.text().trim();
                var dayName = dayNames[dayIndex];
                
                errors.push(`تخصیص ${dayName} - ${gradeName}: ${totalAllocated} از ${gradeLimit} (${totalAllocated - gradeLimit} بیشتر از حد مجاز)`);
                isValid = false;
            }
        });
    });
    
    if (!isValid) {
        var errorMessage = 'خطا در تخصیص آژانس‌ها:\n' + errors.join('\n');
        alert(errorMessage);
    }
    
    return isValid;
}

// Fly Number Filter Functions
function loadFilteredFlyData() {
    const filters = {
        date_from: document.getElementById('dateFrom') ? document.getElementById('dateFrom').value : '',
        date_to: document.getElementById('dateTo') ? document.getElementById('dateTo').value : '',
        origin: document.getElementById('originFilter') ? document.getElementById('originFilter').value : '',
        destination: document.getElementById('destinationFilter') ? document.getElementById('destinationFilter').value : '',
        fly_code: getFlightCodeValue(),
        airline: document.getElementById('airlineFilter') ? document.getElementById('airlineFilter').value : '',
        vehicle_type: document.getElementById('vehicleTypeFilter') ? document.getElementById('vehicleTypeFilter').value : '',
        exit_hour: document.getElementById('exitHourFilter') ? document.getElementById('exitHourFilter').value : ''
    };

    // Show loading state
    const tableBody = document.getElementById('flyTableBody');
    if (tableBody) {
        const quickAddRow = document.getElementById('quick-add-row');
        tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="loading-state">
                    <i class="fa fa-spinner fa-spin"></i>
                    <p>در حال بارگذاری...</p>
                </td>
            </tr>
        `;
    }

    // Send AJAX request
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationBasicInformation',
            method: 'getFilteredListFly',
            filters: filters,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            const tableBody = document.getElementById('flyTableBody');
            if (!tableBody) return;

            // بررسی اینکه response.data رشته JSON هست یا نه
            let data = response.data;
            if (typeof data === 'string') {
                try {
                    data = JSON.parse(data);
                } catch (e) {
                    console.error('JSON parse error:', e);
                }
            }

            // الان data باید تبدیل به آبجکت شده باشه
            const html = data[0]?.html || data.html || '';

            if (html) {
                tableBody.innerHTML = html;

                $('[data-toggle="tooltip"]').tooltip();
            } else {
                tableBody.innerHTML = `
            <tr><td colspan="9" class="text-center text-danger">
                ${response.message || 'داده‌ای یافت نشد'}
            </td></tr>`;
            }
        },
        error: function() {
            showErrorMessage('خطا در ارتباط با سرور');
        }
    });
}

// Function to handle flight code selection
function handleFlightCodeChange() {
    const flightCodeSelect = document.getElementById('flyCodeFilter');
    const customInput = document.getElementById('flyCodeCustomInput');
    
    if (flightCodeSelect.value === 'custom') {
        customInput.style.display = 'block';
        customInput.focus();
    } else {
        customInput.style.display = 'none';
        customInput.value = '';
    }
}

// Function to get the actual flight code value (from select or custom input)
function getFlightCodeValue() {
    const flightCodeSelect = document.getElementById('flyCodeFilter');
    const customInput = document.getElementById('flyCodeCustomInput');
    
    if (flightCodeSelect.value === 'custom') {
        return customInput.value;
    } else {
        return flightCodeSelect.value;
    }
}

function renderFilteredFlyTable(flyData) {
    const tableBody = document.getElementById('flyTableBody');
    if (!tableBody) return;

    // Clear the table body completely since quick-add row is now outside
    tableBody.innerHTML = '';

    // Add filtered data rows
    if (flyData && flyData.length > 0) {
        let number = 0;
        flyData.forEach(function(item) {
            number++;
            const dataRow = document.createElement('tr');
            dataRow.id = `del-${item.id}`;
            dataRow.innerHTML = `
                <td id="borderFlyNumber-${item.id}">${number}</td>
                     <td>${item.fly_code || '-'}</td>
                     <td>${item.airline_name || '-'}</td>
                <td>${item.origin_country_name || '-'} - ${item.origin_city_name || '-'}</td>
                <td>${item.destination_country_name || '-'} - ${item.destination_city_name || '-'}</td>
           <td>${item.exit_hour || '-'}</td>
           <td>${item.vehicle_model || '-'}</td>
                
                <td>
                    <a href="flyNumberEdit&id=${item.id}">
                        <i class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                           data-toggle="tooltip" data-placement="top" title=""
                           data-original-title="ویرایش"></i>
                    </a>
                </td>
                <td>
                    <a href="ticketAdd?fly_id=${item.id}" title="افزودن برنامه پروازی" >
                        <i class="fcbtn btn btn-outline btn-success btn-1e fa fa-ticket tooltip-primary"
                           data-toggle="tooltip" data-placement="top" title=""
                           data-original-title="افزودن برنامه پروازی"></i>
                    </a>
                </td>
            `;
            tableBody.appendChild(dataRow);
        });
    } else {
        // Add "no results" row
        const noResultsRow = document.createElement('tr');
        noResultsRow.innerHTML = `
            <td colspan="9" style="text-align: center; padding: 2rem; color: #666;">
                <i class="fa fa-plane-slash" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>هیچ پروازی یافت نشد</p>
            </td>
        `;
        tableBody.appendChild(noResultsRow);
    }
    
    // Reinitialize tooltips and other plugins
    if (typeof $ !== 'undefined') {
        $('[data-toggle="tooltip"]').tooltip();
    }
}

function clearFlyFilters() {
    // Clear all filter inputs
    const filterInputs = [
        'dateFrom', 'dateTo', 'originFilter', 'destinationFilter', 
        'flyCodeFilter', 'airlineFilter', 'vehicleTypeFilter', 'exitHourFilter'
    ];
    
    filterInputs.forEach(inputId => {
        const element = document.getElementById(inputId);
        if (element) {
            if (element.tagName === 'SELECT') {
                element.selectedIndex = 0;
            } else {
                element.value = '';
            }
        }
    });
    
    // Clear custom flight code input
    const customInput = document.getElementById('flyCodeCustomInput');
    if (customInput) {
        customInput.value = '';
        customInput.style.display = 'none';
    }

    loadFilteredFlyData()
}

// Helper functions for rendering
function getCityName(cityId) {
    // For now, returning the ID as placeholder
    // In a real implementation, you would fetch the city name from the database
    return cityId || '-';
}

function getVehicleName(item) {
    // For now, returning a placeholder
    // In a real implementation, you would fetch the vehicle name from the database
    if (item.type_of_vehicle_id) {
        return item.airline || '-';
    }
    return '-';
}

// Function to fetch city names via AJAX (if needed)
function fetchCityName(cityId, callback) {
    if (!cityId) {
        callback('-');
        return;
    }
    
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationPublicFunctions',
            method: 'handleShowNameAjax',
            table: 'reservation_city_tb',
            id: cityId,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status && response.data) {
                callback(response.data);
            } else {
                callback(cityId);
            }
        },
        error: function() {
            callback(cityId);
        }
    });
}

// Function to fetch city names via AJAX (if needed)
function fetchCityName(cityId, callback) {
    if (!cityId) {
        callback('-');
        return;
    }
    
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationPublicFunctions',
            method: 'handleShowNameAjax',
            table: 'reservation_city_tb',
            id: cityId,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status && response.data) {
                callback(response.data);
            } else {
                callback(cityId);
            }
        },
        error: function() {
            callback(cityId);
        }
    });
}

// Show success message
function showSuccessMessage(message) {
    if (typeof $.toast !== 'undefined') {
        $.toast({
            heading: 'موفقیت',
            text: message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
    } else {
        alert(message);
    }
}

// Show error message
function showErrorMessage(message) {
    if (typeof $.toast !== 'undefined') {
        $.toast({
            heading: 'خطا',
            text: message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
    } else {
        alert(message);
    }
}

function quickEditFly(id) {
    $(".loaderPublic").css("display","block");
    $.ajax({
        url: amadeusPath + 'ajax',
        type: "POST",
        data: JSON.stringify({
            className: 'reservationBasicInformation',
            method: 'GetFlyForEdit',
            id: id,
            to_json: true
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            $(".loaderPublic").css("display","none");
            let d = response.data;
            if (!d) {
                alert('اطلاعات صفحه خالی است!');
                return;
            }
            // اگر d آرایه‌ای ساده است که رشته‌ها دارد
            $('#id').val(d.id);
            $('#idEditFlyNumber').val(d.id);
            $('#quick_origin_airport').val(d.origin_airport).trigger('change');
            $('#quick_destination_airport').val(d.destination_airport).trigger('change');
            $('#quick_type_of_vehicle').val(d.type_of_vehicle_id).trigger('change');
            setTimeout(function() {
                $('#type_of_plane').val(d.type_of_plane).trigger('change');
                $('#quick_origin_region').val(d.origin_region).trigger('change');

                // دوباره کمی تأخیر بده برای airline چون معمولاً بعد از type_of_plane لود میشه
                setTimeout(function() {
                    $('#quick_airline').val(d.airline).trigger('change');
                    $('#quick_destination_region').val(d.destination_region).trigger('change');
                    $('#quick_fly_code').val(d.fly_code);
                    $('#quick_departure_time').val(d.departure_time);
                    $('#quick_duration').val(d.time);
                    // ذخیره ID برای ویرایش
                    $('#quick-add-form').attr('data-edit-id', d.id);
                    $('#btnInsFlyNumber').hide();
                    $('#btnEditFlyNumber').show();
                }, 600);
            }, 800);

            $.toast({
                heading: 'اطلاعات پرواز',
                text: 'اطلاعات پرواز با موفقیت بارگذاری شد.',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'info',
                hideAfter: 3000,
                textAlign: 'right',
                stack: 6
            });
        },
        error: function () {
            alert('خطا در ارتباط با سرور.');
        }
    });
}

function quickUpdateFlyNumber() {
    const info = {
        type_id: $('#idEditFlyNumber').val() || "",
        origin_country: $('#quick_origin_country').val() || "",
        origin_city: $('#quick_origin_city').val() || "",
        origin_region: $('#quick_origin_region').val() || "",
        destination_country: $('#quick_destination_country').val() || "",
        destination_city: $('#quick_destination_city').val() || "",
        destination_region: $('#quick_destination_region').val() || "",
        origin_airport_name: $('#quick_origin_airport').val() || "",
        destination_airport_name: $('#quick_destination_airport').val() || "",
        select_type_flight: $('#quick_select_type_flight').val() || "",
        type_of_vehicle: $('#quick_type_of_vehicle').val() || "",
        type_of_plane: $('#type_of_plane').val() || "",
        airline: $('#quick_airline').val() || "",
        fly_code: $('#quick_fly_code').val() || "",
        free: 0,
        total_capacity: 0,
        vehicle_grade_id: '',
        day_onrequest: 0,
        hours: $('#quick_duration').val().split(':')[0],
        minutes: $('#quick_duration').val().split(':')[1],
        departure_hours: $('#quick_departure_time').val().split(':')[0],
        departure_minutes: $('#quick_departure_time').val().split(':')[1]
    };

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationTicket',
            method: 'updateFlyNumber',
            params: info,
            to_json: true
        }),
        contentType: "application/json",
        success: function (response) {
            console.log("RAW RESPONSE:", response);
            if (response.status === 'success') {
                $.toast({
                    heading: 'اطلاعات پرواز',
                    text: 'اطلاعات پرواز با موفقیت ویرایش شد.',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3000,
                    textAlign: 'right',
                    stack: 6
                });

                $('#btnInsFlyNumber').show();
                $('#btnEditFlyNumber').hide();
                $('#idEditFlyNumber').val('');
                setTimeout(function() {
                    loadFilteredFlyData(); // رفرش جدول بدون reload
                    quickResetForm();
                }, 800);
            } else {
                alert('خطا در ویرایش اطلاعات پرواز');
            }
        },
        error: function (xhr) {
            console.log("SERVER ERROR:", xhr.responseText);
            alert('خطا در ارتباط با سرور');
        }
    });
}
function waitForOption(selector, value, callback, tries = 0) {
    const $select = $(selector);
    // اگر گزینه مورد نظر پیدا شد، تنظیم کن و تابع callback را اجرا کن
    if ($select.find(`option[value="${value}"]`).length > 0) {
        callback();
    } else if (tries < 30) { // تا 30 بار تلاش کند (حدود 3 ثانیه اگر هر 100ms)
        setTimeout(() => waitForOption(selector, value, callback, tries + 1), 100);
    } else {
        console.warn(`گزینه ${value} در ${selector} پیدا نشد`);
    }
}
function showFlightStatusByIdSame(ticket_id) {
    // عنوان مودال
    $('#globalOperationTitle').text('وضعیت پرواز');
    // Show loading state
    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری وضعیت پرواز...</p>
        </div>
    `;
    $('#globalOperationContent').html(loadingContent);
    $('#globalOperationModal').modal('show');

    // Load flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationTicket',
            method: 'getFlightStatusByIdSame',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                const flightStatus = response.data.data; // مقدار فعلی از دیتابیس
                const idSame = response.data.idSame;
                const statusContent = `
                    <div class="form-group text-right ">
                        <select id="flightStatusSelect" class="form-control">
                            <option value="none" ${!flightStatus || flightStatus === 'none' ? 'selected' : ''}>-- انتخاب کنید --</option>
                            <option value="Cancelled" ${flightStatus === 'Cancelled' ? 'selected' : ''}>کنسلی</option>
                            <option value="Blocked" ${flightStatus === 'Blocked' ? 'selected' : ''}>مسدودی</option>
                            <option value="Actived" ${flightStatus === 'Actived' ? 'selected' : ''}>فعال</option>
                        </select>
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-success btn-block" onclick="saveFlightStatusByIdSame('${idSame}')">
                            <i class="fa fa-save"></i> ذخیره
                        </button>
                    </div>
                `;

                $('#globalOperationContent').html(statusContent);
            } else {
                showErrorModal('خطا در بارگذاری وضعیت پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function saveFlightStatusByIdSame(idSame) {
    const newStatus = $('#flightStatusSelect').val();

    if (!newStatus) {
        alert('لطفاً یک وضعیت انتخاب کنید.');
        return;
    }

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationTicket',
            method: 'setFlightStatusByIdSame',
            idSame: idSame,
            status: newStatus,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                // نمایش پیام موفقیت در مودال
                $('#globalOperationContent').html(`
                    <div class="text-center">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <p>${response.message || 'وضعیت پرواز با موفقیت ذخیره شد.'}</p>
                    </div>
                `);

                setTimeout(function() {
                    $('#globalOperationModal').modal('hide');
                    location.reload();
                }, 1000);
            } else {
                showErrorModal(response.message || 'خطا در ذخیره وضعیت پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}

$(window).on('load', function() {
    if (isEditMode) {
        $("#agency-allocation-grid").css("display", "");
        $("#agency-allocation-grid").removeAttr("style");
    }
});