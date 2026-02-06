// Dom7
var $$ = Dom7;
// Framework7 App main instance
var app = new Framework7({
    root: '#app', // App root element
    id: 'io.framework7.testapp', // App bundle ID
    name: 'Framework7', // App name
    pushState: false,
    cache: false,
    restoreScrollTopOnBack: false,
    cacheDuration: 0,

    theme: 'ios', // Automatic theme detection
    // App root data
    data: function () {
        return {
            user: {
                firstName: 'John',
                lastName: 'Doe'
            }
        };
    },
    on: {

        pageInit: function (e, page) {
            var app = this;
            var $ = app.$;

            // filter for hotel price //
            $$('#price-filter-hotel').on('range:change', function (e, range) {
                Number.prototype.format = function (n, x) {
                    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
                    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
                };
                var minPrice = range.value[0].format();
                var maxPrice = range.value[1].format();
                var minPriceWithoutComma = minPrice.replace(/,/g, '');
                var maxPriceWithoutComma = maxPrice.replace(/,/g, '');
                $$('#minPriceWithoutComma').val(minPriceWithoutComma);
                $$('#maxPriceWithoutComma').val(maxPriceWithoutComma);
                $$('#checkPrice').val('false');

                $$('.price-value .min-price-value').text((minPrice) + ' ریال');
                $$('.price-value .max-price-value').text((maxPrice) + ' ریال');
            });
            // end filter for hotel price //


            $$('#price-filter').on('range:change', function (e, range) {
                Number.prototype.format = function (n, x) {
                    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
                    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
                };
                var value1 = range.value[0].format();
                var value2 = range.value[1].format();

                $$('.price-value .min-price-value').text((value1) + ' تومان');
                $$('.price-value .max-price-value').text((value2) + ' تومان');
            });

            function jalali_to_gregorian(jy, jm, jd) {
                if (jy > 979) {
                    gy = 1600;
                    jy -= 979;
                } else {
                    gy = 621;
                }
                days = (365 * jy) + ((parseInt(jy / 33)) * 8) + (parseInt(((jy % 33) + 3) / 4)) + 78 + jd + ((jm < 7) ? (jm - 1) * 31 : ((jm - 7) * 30) + 186);
                gy += 400 * (parseInt(days / 146097));
                days %= 146097;
                if (days > 36524) {
                    gy += 100 * (parseInt(--days / 36524));
                    days %= 36524;
                    if (days >= 365)
                        days++;
                }
                gy += 4 * (parseInt(days / 1461));
                days %= 1461;
                if (days > 365) {
                    gy += parseInt((days - 1) / 365);
                    days = (days - 1) % 365;
                }
                gd = days + 1;
                sal_a = [0, 31, ((gy % 4 == 0 && gy % 100 != 0) || (gy % 400 == 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                for (gm = 0; gm < 13; gm++) {
                    v = sal_a[gm];
                    if (gd <= v)
                        break;
                    gd -= v;
                }
                var cars = [gy, gm, gd];
                return cars;
            }


            var today = new Date();
            var weekLater = new Date().setDate(today.getDate() - 1);
            today3 = new Date().setDate(today.getDate() - 1);
            var calendarDefault = app.calendar.create({
                calendarType: 'jalali',
                weekendDays: [1],
                firstDay: 7,
                monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                dayNames: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                dayNamesShort: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                inputEl: '#demo-calendar-default',
                disabled: {
                    to: weekLater
                },
                minDate: weekLater,
                closeOnSelect: true,
                on: {
                    dayClick: function (a, b, c, d, e) {
                        $$("#demo-calendar-default2").val('');
                        if ($$(".hidden-bargasht-input").val() == 0) {
                            $$(".hidden-bargasht-input").val("1");
                        } else {
                            calendarDefault2.destroy();
                        }
                        dd = d + 1;
                        var salam = jalali_to_gregorian(c, dd, e);
                        salamm = salam[1] - 1;
                        salamm2 = salam[2] - 1;
                        today3 = new Date(salam[0], salamm, salamm2);

                        calendarDefault2 = app.calendar.create({
                            calendarType: 'jalali',
                            inputEl: '#demo-calendar-default2',

                            disabled: {
                                to: today3
                            },
                            monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                            monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                            dayNames: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                            dayNamesShort: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                            firstDay: 7, // Saturday
                            weekendDays: [1], // Friday
                            closeOnSelect: true,
                        });

                    }
                }

            });
            var todayb1 = new Date();
            var birthdayb1 = new Date().setFullYear(todayb1.getFullYear() - 12);
            var bozorgsal1 = app.calendar.create({
                calendarType: 'jalali',
                weekendDays: [1],
                firstDay: 7,
                maxDate: birthdayb1,
                monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                dayNames: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                dayNamesShort: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                inputEl: '#bozorgsal1bd',

            });
            var toggleDate = app.toggle.create({
                el: '.miladi-shamsi',
                on: {
                    change: function () {

                        $$('.miladi-calender').toggleClass('enable');
                        $$('.shamsi-calender').toggleClass('desable');
                }
                }
            });

            var toggle = app.toggle.create({
                el: '.raft-o-bargasht',
                on: {
                    change: function () {
                        $$('.bargasht-date').toggleClass('enable');
                        $$('.raft-date').toggleClass('has-bargasht');
                    }
                }
            });


            if ($$(".hidden-raft-input").val() == 0) {
                $$(".hidden-raft-input").val("1");
            } else {
                calendarDefault.destroy();
            }



        }
    },
    view: {
        restoreScrollTopOnBack: false
    },
    // App root methods
    methods: {
        helloWorld: function () {
            app.dialog.alert('Hello World!');
        }
    },
    // App routes
    routes: routes
});


// Init/Create main view
var mainView = app.views.create('.view-main', {
    url: '/',
    restoreScrollTopOnBack: false
});
$$('.first-preloader').show(); //var app is initialized by now

$$(document).on('DOMContentLoaded', function () {
    setTimeout(function () {
        $$('.first-preloader').addClass("hide");
    }, 1000);

});
$$(document).on("click", "#sendCode", function () {
    console.log('ss');
    $$('#sendCode').find('span').text('در حال بررسی');
    $$('#sendCode').css('opacity', '0.5');
    $$('#sendCode').find('i').removeClass('myhidden');


    var email = $$('#email').val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    if (!emailReg.test(email)) {
        var toastLargeMessage = app.toast.create({
            text: 'فرمت پست الکترونیک نا صحیح میباشد',
            closeTimeout: 2000,
            position: 'top'
        });
        if (toastLargeMessage) {
            toastLargeMessage.open();
        }
        return false;
    } else {
        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            data: {

                flag: 'RecoveryPass',
                type: 'App',
                email: email
            },
            success: function (Response) {
                setTimeout(function () {
                    $$('#sendCode').find('span').text('ارسال کد');
                    $$('#sendCode').css('opacity', '1');
                    $$('#sendCode').find('i').addClass('myhidden');

                }, 2500);


                if (Response.status == 'success') {

                    var toastLargeMessage = app.toast.create({
                        text: Response.message,
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    app.router.navigate("/getCode/");

                } else {

                    var toastLargeMessage = app.toast.create({
                        text: Response.message,
                        closeTimeout: 2000,
                        position: 'top'
                    });
                }
                if (toastLargeMessage) {
                    toastLargeMessage.open();
                }
            }

        });
    }
});

$$(document).on("click", "#getCode", function () {
    console.log('ss11');
    $$('#sendCode').find('span').text('در حال بررسی');
    $$('#sendCode').css('opacity', '0.5');
    $$('#sendCode').find('i').removeClass('myhidden');


    var code = $$('#code').val();

        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            data: {

                flag: 'RecoveryPassCheckCode',
                type: 'App',
                code: code
            },
            success: function (Response) {
                setTimeout(function () {
                    $$('#sendCode').find('span').text('بازیابی کلمه عبور');
                    $$('#sendCode').css('opacity', '1');
                    $$('#sendCode').find('i').addClass('myhidden');

                }, 2500);


                if (Response.status == 'success') {

                    var toastLargeMessage = app.toast.create({
                        text: Response.message,
                        closeTimeout: 4000,
                        position: 'top'
                    });
                    app.router.navigate("/login/");
                } else {

                    var toastLargeMessage = app.toast.create({
                        text: Response.message,
                        closeTimeout: 2000,
                        position: 'top'
                    });
                }
                if (toastLargeMessage) {
                    toastLargeMessage.open();
                }
            }

        });

});
function jalali_to_gregorian(jy, jm, jd) {
    if (jy > 979) {
        gy = 1600;
        jy -= 979;
    } else {
        gy = 621;
    }
    days = (365 * jy) + ((parseInt(jy / 33)) * 8) + (parseInt(((jy % 33) + 3) / 4)) + 78 + jd + ((jm < 7) ? (jm - 1) * 31 : ((jm - 7) * 30) + 186);
    gy += 400 * (parseInt(days / 146097));
    days %= 146097;
    if (days > 36524) {
        gy += 100 * (parseInt(--days / 36524));
        days %= 36524;
        if (days >= 365)
            days++;
    }
    gy += 4 * (parseInt(days / 1461));
    days %= 1461;
    if (days > 365) {
        gy += parseInt((days - 1) / 365);
        days = (days - 1) % 365;
    }
    gd = days + 1;
    sal_a = [0, 31, ((gy % 4 == 0 && gy % 100 != 0) || (gy % 400 == 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    for (gm = 0; gm < 13; gm++) {
        v = sal_a[gm];
        if (gd <= v)
            break;
        gd -= v;
    }
    var cars = [gy, gm, gd];
    return cars;
}


function GoToTicketDetail() {
    var Uniq_id = $$('#Uniq_id').val();
    var SourceId = $$('#SourceIdInLogin').val();
    var TypeZoneFlight = $$('#TypeZoneFlight').val();


    app.router.navigate("/TicketDetailApp/?Uniq_id=" + Uniq_id +
        "&TypeZoneFlight=" + TypeZoneFlight + "&SourceId=" + SourceId
    );
}

//رفتن به صفحه جزئیات از صفحه لاگین
function Login(useType) {
    $$('.login-button').find('i').removeClass('myhidden');
    $$('.login-button').find('span').text('در حال بررسی');
    $$('.login-button').css('opacity', '0.5');

    var UserName = $$('#username').val();
    var password = $$('#password').val();
    var Type = $$('#Type').val();


    if (UserName != '' && password != '') {
        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            //send "query" to server. Useful in case you generate response dynamically
            data: {
                flag: 'memberLogin',
                email: UserName,
                password: password,
                remember: '',
                setcoockie: '',
                App: 'Yes'
            },
            success: function (data) {


                if (data.Status == 'success') {
                    if (Type == 'login') {
                        // app.router.navigate("/home/", {ignoreCache:true,reloadAll:true,reloadCurrent:true,animate:false});
                        document.location.reload(true);
                    } else {
                        if(useType == 'ticket')
                        {
                            GoToTicketDetail();
                        } else if (useType == 'hotel'){
                            reserveHotel();
                        }
                    }
                    setTimeout(function () {
                        $$('.login-button').find('span').text('ورود');
                        $$('.login-button').css('opacity', '1');
                        $$('.login-button').find('i').addClass('myhidden');

                    }, 2500);

                } else {

                    setTimeout(function () {
                        $$('.login-button').find('span').text('ورود');
                        $$('.login-button').css('opacity', '1');
                        $$('.login-button').find('i').addClass('myhidden');

                    }, 2500);

                    var toastLargeMessage = app.toast.create({
                        text: 'نام کاربری یا کلمه عبور صحیح نمی باشد',
                        closeTimeout: 4000,
                        position: 'top'
                    });

                    toastLargeMessage.open();
                }
            }

        });
    } else {
        setTimeout(function () {

            var toastLargeMessage = app.toast.create({
                text: 'لطفا نام کاربری و کلمه عبور را وارد نمائید',
                closeTimeout: 4000,
                position: 'top'
            });
            $$('.GoFromLoginToTicketDetail').find('span').text('ورود');
            $$('.GoFromLoginToTicketDetail').css('opacity', '1');
            $$('.GoFromLoginToTicketDetail').find('i').addClass('myhidden');

        }, 2500);
    }
}




$$(document).on("click", "#CheckDiscountCode", function () {
    if ($$(this).is(':checked')) {
        $$('.off-code').removeClass('myhidden');
    } else {
        $$('.off-code').addClass('myhidden');
    }
});

function setDiscountCode(serviceType, currencyCode) {
    var discountCode = $$('#discount-code').val();
    // var currencyCode = $$('#currencyCode').val();
    var price_before_discount = $$('#priceWithoutDiscountCode').val();

    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        //send "query" to server. Useful in case you generate response dynamically
        data: {
            flag: 'checkDiscountCode',
            discountCode: discountCode,
            serviceType: serviceType,
            currencyCode: currencyCode,
            Type:'App'
        },
        success: function (response) {

            if (response.result_status == 'success') {

                var price_after_discount = price_before_discount - response.discountAmount;
                if (price_after_discount % 1 !== 0) {
                    price_after_discount = price_after_discount.toFixed(2); //float
                }

                $$('.discountDiv').removeClass('myhidden');
                $$(".total-price-off").html(response.result_message);
                $$(".total-price-pay span.discountText").html('مبلغ قابل پرداخت پس از اعمال کد تخفیف :');
                $$(".total-price-pay span.discountPrice").html(number_format(price_after_discount));


            } else {

                $$(".total-price-pay span.discountText").html('مبلغ قابل پرداخت :');
                $$(".total-price-pay span.discountPrice").html(number_format(price_before_discount));
                var toastLargeMessage = app.toast.create({
                    text: response.result_message,
                    closeTimeout: 2000,
                    position: 'top'
                });

                if (toastLargeMessage) {
                    toastLargeMessage.open();
                }
            }

        }
    });

}

function number_format(num) {
    num = num.toString();
    return num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}



$$(document).on("click change", ".BankRadioButton", function () {
    $$('#ChooseBank').val($$(this).val());
});


/**** bk 1398-02-29 ****/
/*$$(document).on("click", ".GoToBank", function () {
    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال بررسی');
    $$(this).css('opacity', '0.5');

    var link = $$('#bankAction').val();
    var inputs = $$('#bankInput').val();
    inputs = JSON.parse(inputs);
    var RequestNumber = $$('#RequestNumber').val();
    var ServiceType = $$('#ServiceType').val();
    var discountCode = $$('#discount-code').val();
    var bankChoose = $$('#ChooseBank').val();


    if (bankChoose != '') {

        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            //send "query" to server. Useful in case you generate response dynamically
            data:
                {
                    flag: 'check_credit',
                    RequestNumber: RequestNumber,
                    Type: 'App'
                },
            success: function (response) {
                setTimeout(function () {
                    $$('.GoToBank').find('i').addClass('myhidden');
                    $$('.GoToBank').find('span').text('پرداخت');
                    $$('.GoToBank').css('opacity', '1');

                }, 2500);
                if (response.creditStatus == 'TRUE') {
                    var form = document.createElement("form");
                    form.setAttribute("method", "POST");
                    form.setAttribute("action", link);
                    form.setAttribute("id", "FormBankApp");
                    Object.keys(inputs).forEach(function (key) {

                        if (typeof inputs[key] === 'object' && inputs[key] !== null) {
                            Object.keys(inputs[key]).forEach(function (key2) {
                                var hiddenField = document.createElement("input");
                                hiddenField.setAttribute("type", "hidden");
                                hiddenField.setAttribute("name", key + '[' + key2 + ']');
                                hiddenField.setAttribute("value", inputs[key][key2]);
                                form.appendChild(hiddenField);
                            });
                        } else {
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", key);
                            hiddenField.setAttribute("value", inputs[key]);
                            form.appendChild(hiddenField);
                        }
                    });
                    var bank = document.createElement("input");
                    bank.setAttribute("type", "hidden");
                    bank.setAttribute("name", "bankType");
                    bank.setAttribute("value", bankChoose);

                    form.appendChild(bank);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                } else {
                    setTimeout(function () {
                        $$('.GoToBank').find('i').addClass('myhidden');
                        $$('.GoToBank').find('span').text('پرداخت');
                        $$('.GoToBank').css('opacity', '1');

                    }, 2500);

                    var toastLargeMessage = app.toast.create({
                        text: 'اشکال در اتصال به بانک',
                        closeTimeout: 2000,
                        position: 'bottom'
                    });
                }

            }
        });

    } else {
        var toastLargeMessage = app.toast.create({
            text: 'لطفا یک بانک را انتخاب نمائید',
            closeTimeout: 2000,
            position: 'top'
        });


    }
    if (toastLargeMessage) {
        toastLargeMessage.open();
    }


});*/



function goBankForApp(obj) {

    $$(obj).find('i').removeClass('myhidden');
    $$(obj).find('span').text('در حال بررسی');
    $$(obj).css('opacity', '0.5');

    var bankInput =  $$(obj).attr('bankInputs');
    var link =  $$(obj).attr('bankAction');
    var inputs = JSON.parse(bankInput);
    inputs['type'] = 'App'; // for flight

    var bankChoose = $$('#ChooseBank').val();
    var credit_status = '';
    var price_to_pay = '';
    if ($$(".price-after-discount-code").length > 0) {
        price_to_pay = $$(".price-after-discount-code").html().replace(/,/g, '');
    }

    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        //send "query" to server. Useful in case you generate response dynamically
        data:
            {
                flag: 'checkMemberCredit',
                price_to_pay: price_to_pay,
                creditUse: $$("input[name='chkCreditUse']:checked").val()
            },
        success: function (data) {

            credit_status = data.result_status;
            if (bankChoose != '' || credit_status == 'full_credit') {

                var discountCode = '';
                if ($$('#discount-code').length > 0) {
                    discountCode = $$('#discount-code').val();
                }
                inputs['discountCode'] = discountCode;

                if ($$("input[name='chkCreditUse']").length > 0 && $$("input[name='chkCreditUse']:checked").val() == 'member_credit') {
                    inputs['memberCreditUse'] = true;
                }

                app.request({
                    url: '../user_ajax.php',
                    method: 'post',
                    dataType: 'json',
                    //send "query" to server. Useful in case you generate response dynamically
                    data: inputs,
                    success: function (response) {

                        setTimeout(function () {
                            $$(obj).find('i').addClass('myhidden');
                            $$(obj).find('span').text('پرداخت');
                            $$(obj).css('opacity', '1');

                        }, 2500);
                        if (response.creditStatus == 'TRUE') {

                            var form = document.createElement("form");
                            form.setAttribute("method", "POST");
                            form.setAttribute("action", link);
                            form.setAttribute("id", "FormBankApp");
                            Object.keys(inputs).forEach(function (key) {

                                if (typeof inputs[key] === 'object' && inputs[key] !== null) {
                                    Object.keys(inputs[key]).forEach(function (key2) {
                                        var hiddenField = document.createElement("input");
                                        hiddenField.setAttribute("type", "hidden");
                                        hiddenField.setAttribute("name", key + '[' + key2 + ']');
                                        hiddenField.setAttribute("value", inputs[key][key2]);
                                        form.appendChild(hiddenField);
                                    });
                                } else {
                                    var hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", key);
                                    hiddenField.setAttribute("value", inputs[key]);
                                    form.appendChild(hiddenField);
                                }
                            });
                            var bank = document.createElement("input");
                            bank.setAttribute("type", "hidden");
                            bank.setAttribute("name", "bankType");
                            bank.setAttribute("value", bankChoose);

                            form.appendChild(bank);
                            document.body.appendChild(form);
                            form.submit();
                            document.body.removeChild(form);

                        } else {

                            setTimeout(function () {
                                $$(obj).find('i').addClass('myhidden');
                                $$(obj).find('span').text('پرداخت');
                                $$(obj).css('opacity', '1');

                            }, 2500);

                            var toastLargeMessage = app.toast.create({
                                text: 'اشکال در اتصال به بانک',
                                closeTimeout: 2000,
                                position: 'bottom'
                            });
                            toastLargeMessage.open();
                        }

                    }
                });






            } else {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا یک بانک را انتخاب نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                toastLargeMessage.open();
            }


        }
    });


}





function GoToLoginPage() {

    app.router.navigate("/login/?Type=login"
    );
}

function GoToRegisterPage(TypeRegister) {

    if (TypeRegister == 'OfLoginPage') {
        var Uniq_id = $$('#Uniq_id').val();
        var SourceId = $$('#SourceIdInLogin').val();
        var TypeZoneFlight = $$('#TypeZoneFlight').val();
        app.router.navigate("/Register/?Type=" + TypeRegister + "&Uniq_id=" + Uniq_id +
            "&TypeZoneFlight=" + TypeZoneFlight + "&SourceId=" + SourceId
        );
    } else if (TypeRegister == 'Home') {
        app.router.navigate("/Register/?Type=" + TypeRegister
        );
    }


}

function LogOutFromApp() {

    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {
            flag: 'signout',
            Type: 'App'
        },
        success: function (Response) {
            if (Response.LogOut == 'Yes') {
                // app.router.navigate({url:"/home/", ignoreCache:true,reloadAll:true,animate:false});
                document.location.reload();

            }
        }

    });

}

function Register() {

    $$('.RegisterButtonFunc').find('span').text('در حال بررسی');
    $$('.RegisterButtonFunc').css('opacity', '0.5');
    $$('.RegisterButtonFunc').find('i').removeClass('myhidden');


    var Uniq_id = $$('#Uniq_idRegister').val();
    var SourceId = $$('#SourceId').val();
    var Type = $$('#TypeRegister').val();

    var FormData = app.form.convertToData('#RegisterApp');
    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {

            flag: 'memberRegister',
            FormData: FormData
        },
        success: function (Response) {
            setTimeout(function () {
                $$('.RegisterButtonFunc').find('span').text('ثبت نام');
                $$('.RegisterButtonFunc').css('opacity', '1');
                $$('.RegisterButtonFunc').find('i').addClass('myhidden');

            }, 2500);


            if (Response.ResultRegister == 'success') {

                if (Type == 'Home') {
                    console.log('home');
                    var toastLargeMessage = app.toast.create({
                        text: Response.MessageRegister,
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    document.location.reload();
                } else if (Type == 'OfLoginPage') {

                    app.router.navigate("/TicketDetailApp/?Uniq_id=" + Uniq_id +
                        "&TypeZoneFlight=" + TypeZoneFlight + "&SourceId=" + SourceId
                    );
                }

            } else {

                var toastLargeMessage = app.toast.create({
                    text: Response.MessageRegister,
                    closeTimeout: 2000,
                    position: 'top'
                });
            }
            if (toastLargeMessage) {
                toastLargeMessage.open();
            }
        }

    });
}



function SelectReason(Obj) {

    var valueReason = $$(Obj).val();

    if (valueReason == 'PersonalReason') {

        var toastLargeMessage = app.toast.create({
            text: 'کنسلی به دلیل شخصی طبق قوانین کنسلی',
            closeTimeout: 4000,
            position: 'top'
        });

    } else if (valueReason == 'DelayTwoHours') {
        var text = "پروازهایی که توسط ایرلاین یا چارتر کننده لغو گردیده است 	و یا پروازی که بیش از  2ساعت تاخیر دارند،ارائه بلیط مهر شده توسط کانتر ایرلاین در فرودگاه الزامی می باشد ";
        var toastLargeMessage = app.toast.create({
            text: text,
            closeTimeout: 4000,
            position: 'top'
        });


    } else if (valueReason == 'CancelByAirline') {
        var text = "پرواز توسط ایرلاین لغو شده است";

        var toastLargeMessage = app.toast.create({
            text: text,
            closeTimeout: 4000,
            position: 'top'
        });


    }


    if (toastLargeMessage) {
        toastLargeMessage.open();
    }
}



function SelectOldPassenger(TypeNumber) {

    $$('#SelectPassenger').val(TypeNumber);

    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {
            flag: 'PassengerOld'
        },
        success: function (Response) {

            var items = [];
            for (var i = 0; i < Response.length; i++) {
                items.push({
                    Type: $$('#SelectPassenger').val(),
                    Name: Response[i].name,
                    Family: Response[i].family,
                    NameEn: Response[i].name_en,
                    FamilyEN: Response[i].family_en,
                    IsForeign: Response[i].is_foreign,
                    Gender: Response[i].gender,
                    PassportNumber: Response[i].passportNumber,
                    PassportExpire: Response[i].passportExpire,
                    PassportCountry: Response[i].passportCountry,
                    NationalCode: (Response[i].passportCountry == 'IRN' && Response[i].is_foreign == '0') ? Response[i].NationalCode : Response[i].passportNumber,
                    Birthday: (Response[i].passportCountry == 'IRN' && Response[i].is_foreign == '0') ? Response[i].birthday_fa : Response[i].birthday,
                });
            }


            var virtualList = app.virtualList.create({
                // List Element
                el: '.virtual-list',
                autoFocus: false,
                // Pass array with items
                items: items,

                // Custom search function for searchbar
                searchAll: function (query, items) {
                    var found = [];

                    for (var i = 0; i < items.length; i++) {
                        if (items[i].Name.indexOf(query) >= 0 || query.trim() === '') found.push(i);
                        if (items[i].Family.indexOf(query) >= 0 || query.trim() === '') found.push(i);
                        if (items[i].NationalCode.indexOf(query) >= 0 || query.trim() === '') found.push(i);
                        if (items[i].Birthday.indexOf(query) >= 0 || query.trim() === '') found.push(i);
                    }
                    return found; //return array with mathced indexes
                },
                // List item Template7 template
                itemTemplate:
                '<li>' +
                '<a href="#" class="item-link item-content" name="{{Name}}" family="{{Family}}" NameEn="{{NameEn}}" FamilyEN="{{FamilyEN}}"' +
                'IsForeign="{{IsForeign}}" Gender="{{Gender}}" PassportNumber="{{PassportNumber}}" ' +
                'PassportExpire="{{PassportExpire}}" PassportCountry="{{PassportCountry}}" NationalCode="{{NationalCode}}"' +
                'Birthday="{{Birthday}}" TypePassenger="{{Type}}" onclick="PassengerOldSelected(this); return false ; ">' +
                '<div class="item-inner">' +
                '<div class="item-title-row">' +
                '<div class="item-title">{{Name}} {{Family}}</div>' +
                '</div>' +
                '<div class="item-codemelli"><span>شماره ملی/پاسپورت</span><span>{{NationalCode}}</span></div>' +
                '<div class="item-tell"><span>تاریخ تولد</span><span>{{Birthday}}</span></div>' +
                '</div>' +
                '</a>' +
                '</li>',
                // Item height
                height: app.theme === 'ios' ? 63 : (app.theme === 'md' ? 73 : 46),
            });
        }
    });


}

function PassengerOldSelected(Obj) {

    var TypePassenger = $$(Obj).attr('TypePassenger');
    var Name = $$(Obj).attr('Name');
    var Family = $$(Obj).attr('Family');
    var NameEn = $$(Obj).attr('NameEn');
    var FamilyEN = $$(Obj).attr('FamilyEN');
    var IsForeign = $$(Obj).attr('IsForeign');
    var Gender = $$(Obj).attr('Gender');
    var PassportNumber = $$(Obj).attr('PassportNumber');
    var PassportCountry = $$(Obj).attr('PassportCountry');
    var PassportExpire = $$(Obj).attr('PassportExpire');
    var NationalCode = $$(Obj).attr('NationalCode');
    var Birthday = $$(Obj).attr('Birthday');
    var TypeFlight = $$('#TypeZoneFlightDetail').val();


    $$('#nameFa' + TypePassenger).val(Name);
    $$('#familyFa' + TypePassenger).val(Family);
    $$('#nameEn' + TypePassenger).val(NameEn);
    $$('#familyEn' + TypePassenger).val(FamilyEN);

    var birthdayPassenger = Birthday.split('-');

    console.log(IsForeign);
    console.log(Gender);

    if (Gender == 'Male') {
        $$('.Male' + TypePassenger).attr('checked', true);
    } else if (Gender == 'Female') {
        $$('.Female' + TypePassenger).attr('checked', true);
    }

    if (IsForeign == '1' || TypeFlight=='Foreign' ) {
        $$('#passportNumber' + TypePassenger).val(PassportNumber);
        $$('#passportCountry' + TypePassenger).val(PassportCountry);
        $$('#passportExpire' + TypePassenger).val(PassportExpire);

        $$('#YearMiladi' + TypePassenger).val(birthdayPassenger[0]);
        $$('#MonthMiladi' + TypePassenger).val(birthdayPassenger[1]);
        $$('#DayMiladi' + TypePassenger).val(birthdayPassenger[2]);


        $$('.Foreign' + TypePassenger).attr('checked', true);

        if (!$$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.shamsi-bd').hasClass('myhidden')) {
            $$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.shamsi-bd').addClass('myhidden');
        }
        if (!$$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.code-melli').hasClass('myhidden')) {
            $$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.code-melli').addClass('myhidden');
        }
        if ($$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.miladi-bd').hasClass('myhidden')) {
            $$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.miladi-bd').removeClass('myhidden');
        }
        if ($$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.country-passport').hasClass('myhidden')) {
            $$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.country-passport').removeClass('myhidden');
        }
        if ($$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.passportNumber').hasClass('myhidden')) {
            $$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.passportNumber').removeClass('myhidden');
        }
        if ($$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.passportExpire').hasClass('myhidden')) {
            $$('.Foreign' + TypePassenger).parents('.list-passenger ul').find('.passportExpire').removeClass('myhidden');
        }

    } else {
        $$('#NationalCode' + TypePassenger).val(NationalCode);

        $$('#YearJalali' + TypePassenger).val(birthdayPassenger[0]);
        $$('#MonthJalali' + TypePassenger).val(birthdayPassenger[1]);
        $$('#DayJalali' + TypePassenger).val(birthdayPassenger[2]);


        $$('.Local' + TypePassenger).attr('checked', true);

        if ($$('.Local' + TypePassenger).parents('.list-passenge ul').find('.shamsi-bd').hasClass('myhidden')) {
            $$('.Local' + TypePassenger).parents('.list-passenger ul').find('.shamsi-bd').removeClass('myhidden');
        }
        if ($$('.Local' + TypePassenger).parents('.list-passenger ul').find('.code-melli').hasClass('myhidden')) {
            $$('.Local' + TypePassenger).parents('.list-passenger ul').find('.code-melli').removeClass('myhidden');
        }
        if (!$$('.Local' + TypePassenger).parents('.list-passenger ul').find('.miladi-bd').hasClass('myhidden')) {
            $$('.Local' + TypePassenger).parents('.list-passenger ul').find('.miladi-bd').addClass('myhidden');
        }
        if (!$$('.Local' + TypePassenger).parents('.list-passenger ul').find('.country-passport').hasClass('myhidden')) {
            $$('.Local' + TypePassenger).parents('.list-passenger ul').find('.country-passport').addClass('myhidden');
        }
        if (!$$('.Local' + TypePassenger).parents('.list-passenger ul').find('.passportNumber').hasClass('myhidden')) {
            $$('.Local' + TypePassenger).parents('.list-passenger ul').find('.passportNumber').addClass('myhidden');
        }
        if (!$$('.Local' + TypePassenger).parents('.list-passenger ul').find('.passportExpire').hasClass('myhidden')) {
            $$('.Local' + TypePassenger).parents('.list-passenger ul').find('.passportExpire').addClass('myhidden');
        }

    }
    $$('.popup-close').trigger('click');
}
