$(document).ready(function () {
    if (gdsSwitch == 'factorInsurance' || gdsSwitch == 'passengersDetailInsurance') {
        noBack();
    }
});

function BuyInsuranceWithoutRegister() {

    var index = $("#insurance_chosen").val();

    var type = $('#selected_insurance_type').val();
    var destination = $('#insurance_destination').val();
    var origin = $('#insurance_origin').val();
    var num_day = $('#insurance_num_day').val();
    var member = $('#insurance_member').val();
    var birth_dates = $('#insurance_birthdates').val();
    var CurrencyCode = $('.CurrencyCode').val();

    var price = $('.insurance_total_price' + index).val();
    var title = $('.insurance_title' + index).val();
    var zone_code = $('.insurance_zonecode' + index).val();
    var insurance_api = $('.insurance_api' + index).val();

    $.ajax({
        type: "POST",
        url: amadeusPath + 'user_ajax.php',
        data: {
            "flag": 'insurance_choose',
            "price": price,
            "title": title,
            "zone_code": zone_code,
            "insurance_api": insurance_api,
            "type": type,
            "destination": destination,
            "origin": origin,
            "num_day": num_day,
            "member": member,
            "birth_dates": birth_dates,
            "CurrencyCode": CurrencyCode
        },
        success: function (data) {
            if (data != '') {
                location.href = amadeusPathByLang + 'passengersDetailInsurance/' + data;
            }
        }
    });
}

function check_user_login(index) {

    $("#insurance_chosen").val(index);

    $.ajax({
        type: "POST",
        url: amadeusPath + 'user_ajax.php',
        data: {
            "flag": 'check_user_login'
        },
        success: function (data) {

            if (data == '' || data == false) {
                var isShowLoginPopup = $('#isShowLoginPopup').val();
                var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                if (isShowLoginPopup == '' || isShowLoginPopup == '1'){
                    $("#login-popup").trigger("click");
                } else {
                    popupBuyNoLogin(useTypeLoginPopup);
                }
            } else {
                var type = $('#selected_insurance_type').val();
                var destination = $('#insurance_destination').val();
                var origin = $('#insurance_origin').val();
                var num_day = $('#insurance_num_day').val();
                var member = $('#insurance_member').val();
                var birth_dates = $('#insurance_birthdates').val();
                var CurrencyCode = $('.CurrencyCode').val();

                var price = $('.insurance_total_price' + index).val();
                var title = $('.insurance_title' + index).val();
                var zone_code = $('.insurance_zonecode' + index).val();
                var insurance_api = $('.insurance_api' + index).val();

                $.ajax({
                    type: "POST",
                    url: amadeusPath + 'user_ajax.php',
                    data: {
                        "flag": 'insurance_choose',
                        "price": price,
                        "title": title,
                        "zone_code": zone_code,
                        "insurance_api": insurance_api,
                        "type": type,
                        "destination": destination,
                        "num_day": num_day,
                        "member": member,
                        "birth_dates": birth_dates,
                        "origin": origin,
                        "CurrencyCode": CurrencyCode
                    },
                    success: function (data) {
                        if (data != '') {
                            location.href = amadeusPathByLang + 'passengersDetailInsurance/' + data;
                        }
                    }
                });
            }
        }
    });


}

function checkfildInsurance(count) {

    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);

    var error = 0;
    for (var i = 1; i <= count; i++) {
        var gender = $('#gender' + i).val();
        var nameEn = $('#nameEn' + i).val();
        var familyEn = $('#familyEn' + i).val();
        var nameFa = $('#nameFa' + i).val();
        var familyFa = $('#familyFa' + i).val();
        var NationalCode = $('#NationalCode' + i).val();
        var passportNumber = $('#passportNumber' + i).val();
        // var passportExpire = $('#passportExpire' + i).val();
        var visaType = $('#visaType' + i).val();
        let passengerNationality = $(`input[name=passengerNationality${i}]:checked`).val();
        console.log(passportNumber , NationalCode)
        // if(passengerNationality == "0" ){
        //     console.log('sssssssssss')
        //     console.log(passengerNationality)
        //     if ((nameFa == "") || (nameFa == "") ) {
        //         $('#message' + i).html(useXmltag("Fillingallfieldsrequired"));
        //         $('#message' + i).css('color', '#f20');
        //         error++;
        //     }
        //
        //
        // }
         if (gender == null || (nameEn == null) || (familyEn == null)  ||   !passportNumber || (passportNumber == "") || (passportNumber == null) || (visaType == null) ) {
            $('#message' + i).html(useXmltag("Fillingallfieldsrequired"));
            $('#message' + i).css('color', '#f20');
            error++;
        }else if(passengerNationality == "0"  && (NationalCode == null || NationalCode == ""|| !NationalCode ) ){
            $('#message' + i).html(useXmltag("Fillingallfieldsrequired"));
            $('#message' + i).css('color', '#f20');
            error++;
        } else {
            $('#message' + i).html('');
            error = 0;

            /*     if (passportNumber.length < 9 || (passengerNationality=='1' && passportNumber.length < 8)) {
                     $('#message' + i).html(useXmltag("Passportnumberenterednotvalid"));
                     $('#message' + i).css('color', '#f20');
                     error++;
                 }*/
        }


        if(error !=  0 ) {
            $.alert({
                title: 'لطفا مشخصات را کامل وارد کنید',
                content: 'پر کردن تمامی فیلدها الزامی می باشد',
                icon: 'fa fa-warning',
                rtl: true,
                type: 'red'
            });
            error = 1;
            return false;
        }
        else{
            if (NationalCode != "") {
                if ((NationalCode.toString().length != 10)) {
                    console.log('awdawd')
                    $('#messageInfo').html('در کد ملی تنها از 10 رقم میتوانید استفاده کنید');

                    $.alert({
                        title: 'لطفا مشخصات را کامل وارد کنید',
                        content: 'در کد ملی تنها از 10 رقم میتوانید استفاده کنید',
                        icon: 'fa fa-warning',
                        rtl: true,
                        type: 'red'
                    });
                    error = 1;
                    return false;
                } else {
                    var NCode = checkCodeMeli(NationalCode);
                    console.log('NCode',NCode)
                    if (!NCode) {
                        $('#messageInfo').html('کد ملی وارد شده معتبر نمی باشد');


                        $.alert({
                            title: 'لطفا مشخصات را کامل وارد کنید',
                            content: 'کد ملی وارد شده معتبر نمی باشد',
                            icon: 'fa fa-warning',
                            rtl: true,
                            type: 'red'
                        });

                        error = 1;

                        return false;
                    }else{
                        error = 0;
                    }
                }
            }
            if (passportNumber != "") {
                if ((passportNumber.toString().length > 9)) {
                    console.log('awdawd')
                    $('#messageInfo').html('در شماره پاسپورت حداکثراز 9 رقم میتوانید استفاده کنید');

                    $.alert({
                        title: 'لطفا مشخصات را کامل وارد کنید',
                        content: 'در شماره پاسپورت حداکثراز 9 رقم میتوانید استفاده کنید',
                        icon: 'fa fa-warning',
                        rtl: true,
                        type: 'red'
                    });
                    error = 1;
                    return false;
                } else{
                    error = 0;
                }

            }

        }


    }

    var error2 = 0;
    var checkLogin = $("#UsageNotLogin").val();




    if (checkLogin == 'yes') {

        var mob = $('#Mobile').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();

        if (mob != '') {
            var mobregqx =/^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,6}$/;

            if (!mobregqx.test(mob)) {
                $('#messageInfo').html(useXmltag("MobileNumberIncorrect"));
                error2 = 1;
                return false;
            }
        }



        if (Email_Address == '' && mob != '') {
            $('#Email').val('simple' + mob + '@info.com');
            Email_Address = $('#Email').val();
        }

        if (mob == '' || Email_Address == '') {
            $('#messageInfo').html(useXmltag("Fillthebuyerinformationrequired"));
            error2++;
            return false;

        } else {
            $('#messageInfo').html('');
            error2 = 0;
        }


        var checkFormat = membersForInsurance(mob, Email_Address, tel);
        if (checkFormat == 'true') {
            $('#messageInfo').html('');
            error2 = 0;
        } else {
            error2++;
            return false;
        }

    } else
    {
       
        var mobile = $('#Mobile_buyer').val();
        var email = $('#Email_buyer').val();

        if (mobile != '') {
            var mobregqx =/^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,6}$/;

            if (!mobregqx.test(mobile)) {
                $('#messageInfo').html(useXmltag("MobileNumberIncorrect"));
                error2 = 1;
                return false;
            }
        }

        var checkFormat = members(mobile, email);
        if (checkFormat == 'true') {
            $('#messageInfo').html('');
            error2 = 0;
        } else {
            error2++;
            return false;
        }
    }

    if (error == 0 && error2 == 0) {
        $.post(amadeusPath + 'user_ajax.php',
          {
              mobile: mob,
              telephone: tel,
              Email: Email_Address,
              flag: "register_memeber_insurance",
          },
          function (reponse) {
              var res = reponse.split(':');

              if (reponse.indexOf('success') > -1) {
                  $('#IdMember').val(res[1]);

                  $('#loader_check').show();
                  $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));

                  setTimeout(
                    function () {
                        $('#loader_check').hide();
                        $('#formPassengerDetailInsurance').submit();
                    }, 3000);
              } else {
                  $.alert({
                      title:useXmltag('BuyInsurance'),
                      icon: 'fa shopping-cart',
                      content: res[1],
                      rtl: true,
                      type: 'red',
                  });
                  return false;
              }
          });
    }

}

function membersForInsurance(mob, Email_Address, tel) {
    var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
    var patt = new RegExp("[0-9]");
    var res = patt.test(tel);
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var error_member = 0;
    if (mob == "" || Email_Address == "") {
        $("#messageInfo").html(useXmltag("Fillingallfieldsrequired"));
        error_member = 1;
    } else if (!mobregqx.test(mob)) {
        $("#messageInfo").html('<br>'+useXmltag("MobileNumberIncorrect"));
        error_member = 1;
    } else if (!emailReg.test(Email_Address)) {
        $("#messageInfo").html('<br>'+useXmltag("Pleaseenteremailcorrectformat"));
        error_member = 1;
    } else if (tel != "" &&  res == false) {
        $("#messageInfo").html('<br>'+useXmltag("Thefixedtelephonenumberonlycontainsnumber"));
        error_member = 1;
    }

    if (error_member == 0) {
        return 'true';
    } else {
        return 'false';
    }


}

function memberInsuranceLogin() {
    var index = $("#insurance_chosen").val();
    var type = $('#selected_insurance_type').val();
    var destination = $('#insurance_destination').val();
    var origin = $('#insurance_origin').val();
    var num_day = $('#insurance_num_day').val();
    var member = $('#insurance_member').val();
    var birth_dates = $('#insurance_birthdates').val();
    var CurrencyCode = $('.CurrencyCode').val();

    var price = $('.insurance_total_price' + index).val();
    var title = $('.insurance_title' + index).val();
    var zone_code = $('.insurance_zonecode' + index).val();
    var insurance_api = $('.insurance_api' + index).val();

    $.ajax({
        type: "POST",
        url: amadeusPath + 'user_ajax.php',
        data: {
            "flag": 'insurance_choose',
            "price": price,
            "title": title,
            "zone_code": zone_code,
            "insurance_api": insurance_api,
            "type": type,
            "destination": destination,
            "origin": origin,
            "num_day": num_day,
            "member": member,
            "birth_dates": birth_dates,
            "CurrencyCode": CurrencyCode
        },
        success: function (data) {
            if (data != '') {
                location.href = amadeusPathByLang + 'passengersDetailInsurance/' + data;
            }
        }
    });

    /*var index = $("#insurance_chosen").val();

    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    var email = $("#signin-email2").val();
    var pass = $("#signin-password2").val();
    var remember = $("#remember-me2:checked").val();
    if (remember == 'checked' || remember == 'on' || remember == 'true') {
        remember = 'on';
    } else {
        remember = 'off';
    }
    var organization = '';
    if($('#signin-organization2').length > 0){
        organization = $('#signin-organization2').val();
    }

    if (!email) {
        $("#error-signin-email2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-email2").css("opacity", "1");
        $("#error-signin-email2").css("visibility", "visible");
        error = 1;
    }

    if (!pass) {
        $("#error-signin-password2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-password2").css("opacity", "1");
        $("#error-signin-password2").css("visibility", "visible");
        error = 1;
    }

    if (error == 0) {

        $.post(amadeusPath + 'user_ajax.php',
            {
                email: email,
                remember: remember,
                password: pass,
                organization: organization,
                flag: 'memberLogin'
            },
            function (data) {

                if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                    $(".cd-user-modal").trigger("click");

                    var type = $('#selected_insurance_type').val();
                    var destination = $('#insurance_destination').val();
                    var num_day = $('#insurance_num_day').val();
                    var member = $('#insurance_member').val();
                    var birth_dates = $('#insurance_birthdates').val();
                    var CurrencyCode = $('.CurrencyCode').val();

                    var price = $('.insurance_total_price' + index).val();
                    var title = $('.insurance_title' + index).val();
                    var zone_code = $('.insurance_zonecode' + index).val();
                    var insurance_api = $('.insurance_api' + index).val();

                    $.ajax({
                        type: "POST",
                        url: amadeusPath + 'user_ajax.php',
                        data: {
                            "flag": 'insurance_choose',
                            "price": price,
                            "title": title,
                            "zone_code": zone_code,
                            "insurance_api": insurance_api,
                            "type": type,
                            "destination": destination,
                            "num_day": num_day,
                            "member": member,
                            "birth_dates": birth_dates,
                            "CurrencyCode": CurrencyCode
                        },
                        success: function (data) {
                            if (data != '') {
                                location.href = amadeusPathByLang + 'passengersDetailInsurance/' + data;
                            }
                        }
                    });
                } else {
                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            email: email,
                            remember: remember,
                            password: pass,
                            flag: 'agencyLogin'
                        },
                        function (res) {
                            if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
                                $(".cd-user-modal").trigger("click");

                                var type = $('#selected_insurance_type').val();
                                var destination = $('#insurance_destination').val();
                                var num_day = $('#insurance_num_day').val();
                                var member = $('#insurance_member').val();
                                var birth_dates = $('#insurance_birthdates').val();
                                var CurrencyCode = $('.CurrencyCode').val();

                                var price = $('.insurance_total_price' + index).val();
                                var title = $('.insurance_title' + index).val();
                                var zone_code = $('.insurance_zonecode' + index).val();
                                var insurance_api = $('.insurance_api' + index).val();
                                $.ajax({
                                    type: "POST",
                                    url: amadeusPath + 'user_ajax.php',
                                    data: {
                                        "flag": 'insurance_choose',
                                        "price": price,
                                        "title": title,
                                        "zone_code": zone_code,
                                        "insurance_api": insurance_api,
                                        "type": type,
                                        "destination": destination,
                                        "num_day": num_day,
                                        "member": member,
                                        "birth_dates": birth_dates,
                                        "CurrencyCode": CurrencyCode
                                    },
                                    success: function (data) {
                                        if (data != '') {
                                            location.href = amadeusPathByLang + 'passengersDetailInsurance/' + data;
                                        }
                                    }
                                });
                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        });

                }
            });
    } else {
        return false;
    }*/
}

function submitSearchInsuranceLocal() {
    const thisForm = $('form[name="gds_insurance"]');
    let insurance_type = thisForm.find("#insurance_type").val();
    let destination = thisForm.find("#destination").val();
    let origin = thisForm.find("#origin").val();
    let num_day = thisForm.find("#num_day").val();
    let num_member = thisForm.find("#number_of_adults_insurance").val();
    if(insurance_type == '2') {
        if(destination == 'IRN' && origin == 'IRN'){
            $.alert({
                title : '',
                icon: 'fa fa-cart-plus',
                content: useXmltag("InsuranceError"),
                rtl: true,
                type: 'red'
            });
            return false;
        }
    }
// alert(insurance_type)
    const array_member = [];
    if(insurance_type == '1') {

        for (let index = 1; index <= num_member; index++) {
            array_member[index - 1] = thisForm.find('#txt_went_insuranceEn' + index).val();
        }
    }else {
        for (let index = 1; index <= num_member; index++) {
            array_member[index - 1] = thisForm.find('#txt_went_insurance' + index).val();
        }
    }


    let count_string = '';
    $(array_member).each(function(index,item){
        count_string += `/${item}`;
    });
    let pageUrl = ''

    if(insurance_type == '1'){
        pageUrl = `${amadeusPathByLang}resultInsurance/${insurance_type}/${origin}/${num_day}/${num_member}${count_string}`;

    }else if(insurance_type == '2'){
        pageUrl = `${amadeusPathByLang}resultInsurance/${insurance_type}/${destination}/${num_day}/${num_member}${count_string}`;
    }
    // console.log(pageUrl);
    window.location.href = pageUrl;
}

function preReserveInsurance(factorNumber) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("BuyInsurance"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').attr('onclick', 'return false').css('opacity', '0.5').css('cursor', 'progress');
    $('#loader_check').css("display", "block");

    $.ajax({
        type: "POST",
        url: amadeusPath + 'user_ajax.php',
        data: {
            "flag": 'insurancePreReserve',
            "factorNumber": factorNumber
        },
        success: function (data) {
            let result = JSON.parse(data)
            if (result['status'].trim() == 'TRUE') {

                if(result['redirectUrl']) {
                    $('#redirectUrl').val(result['redirectUrl']) ;
                }

                setTimeout(function () {
                    $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));
                    $('.main-pay-content').css('display','flex');
                    $('#loader_check').css("display", "none");
                    $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                }, 2000);

            } else {

                setTimeout(function () {
                    $('#final_ok_and_insert_passenger').css('background-color', 'red').text(useXmltag("Errorconfirmation"));
                    $.alert({
                        title: useXmltag("BuyTicket"),
                        icon: 'fa fa-cart-plus',
                        content: useXmltag("Erroradvancebookingpleaseagainbitlater"),
                        rtl: true,
                        type: 'red',

                    })
                }, 1000);

            }
        }
    });
}

function modalListInsurance(FactorNumber) {
    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: 'user',
          Method: 'ModalShowInsurance',
          Param: FactorNumber
      },
      function (data) {

          $('#ModalPublicContent').html(data);

      });
}

function SendInsuranceEmailForOther() {
    $('#loaderTracking').fadeIn(500);
    $('#SendInsuranceEmailForOther').attr("disabled", "disabled");
    var Email = $('#SendForOthers').val();
    var request_number = $('#request_number').val();
    var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/;
    $('#SendForOthers').focus(function () {
        $('#SendForOthers').css("background", "white");
    });

    if (Email == "") {
        $('#SendForOthers').css("background", "red");

        $.alert({
            title: useXmltag("Sendemail"),
            icon: 'fa fa-times',
            content: useXmltag("Pleaseenteremailaddress"),
            rtl: true,
            type: 'red',
        });

    } else if (!emailReg.test(Email)) {
        $('#SendForOthers').css("background", "red");

        $.alert({
            title: useXmltag("Sendemail"),
            icon: 'fa fa-times',
            content: useXmltag("Pleaseenteremailcorrectformat"),
            rtl: true,
            type: 'red',
        });
    } else {
        $.post(amadeusPath + 'user_ajax.php',
          {
              email: Email,
              request_number: request_number,
              flag: 'SendInsuranceEmailForOther'
          },
          function (data) {
              var res = data.split(':');
              if (data.indexOf('success') > -1) {
                  $.alert({
                      title: useXmltag("Sendemail"),
                      icon: 'fa fa-check',
                      content: res[1],
                      rtl: true,
                      type: 'green',
                  });
                  setTimeout(function () {
                      $("#ModalSendEmail").fadeOut(700);
                      $('#loaderTracking').fadeOut(500);
                      $('#SendInsuranceEmailForOther').attr("disabled", false);
                      $('#SendForOthers').val(' ');
                  }, 1000);

              } else {
                  $.alert({
                      title: useXmltag("Sendemail"),
                      icon: 'fa fa-times',
                      content: res[1],
                      rtl: true,
                      type: 'red',
                  });
                  $('#SendInsuranceEmailForOther').attr("disabled", false);
                  $('#loaderTracking').fadeOut(500);


              }

          });
    }
}

function changeTourType() {
    let type = $('#insurance_type').val() ;
    if(type == '1') {
        $('.change-date-type-external').attr('type', 'hidden');
        $('.change-date-type-internal').attr('type', 'text');
        $('.change-date-type-external').removeClass('shamsiBirthdayCalendar');
        $('.change-date-type-internal').addClass('gregorianBirthdayCalendar');
        $('#destination').prop('disabled', 'disabled');
        $("#destination").select2('destroy');
        $('#destination').val('IRN');
        $("#destination").select2();
        $('#origin').prop('disabled', false);
    }else if(type == '2'){
        $('.change-date-type-internal').attr('type', 'hidden');
        $('.change-date-type-external').attr('type', 'text');
        $('.change-date-type-internal').removeClass('gregorianBirthdayCalendar');
        $('.change-date-type-external').addClass('shamsiBirthdayCalendar');
        $('#origin').prop('disabled', 'disabled');
        $("#origin").select2('destroy');
        $('#origin').val('IRN');
        $("#origin").select2();
        console.log($('#origin').val())
        $('#destination').prop('disabled', false);
    }
}
