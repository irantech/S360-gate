
function submitSearchGasht() {
    var requestType = $("#request-type").val();
    let typeSearch = requestType == 0 ? 'gasht' : 'transfer';

    var destination = $("#destination_"+ typeSearch).val();
   var date = $("#date_"+ typeSearch).val();
    if ($('#gasht-type').val() != "-" ){

        var gashtType = "/"+ $('#gasht-type').val();
    }else {
        var gashtType = '-';
    }
    if ($('#welcome-type').val() != "-" ){

        var welcomeType = "/"+ $('#welcome-type').val();
    }else {
        var welcomeType ="/"+ '0';
    }
    if ($('#vehicle-type').val() != "" ){

        var vehicleType = "-"+ $('#vehicle-type').val();
    }else {
        var vehicleType ="-"+ '0';
    }
    if ($('#transfer-place').val() != "-" ){

        var transferPlace = "-"+ $('#transfer-place').val();
    }else {
        var transferPlace ="-"+'0';
    }


    console.log(destination);
    console.log(date);


    if (destination == "" || date == "") {
        //alert("لطفا فیلدهای مورد نیاز را وارد نمایید");
        $.alert({
            title: useXmltag("Reservationpatroltransfer"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
    } else {
       if (requestType==0){
        window.location.href = amadeusPathByLang + 'resultGasht/' + requestType + '/' + destination + '/' + date + gashtType;}
        if(requestType==1){
            window.location.href = amadeusPathByLang + 'resultGasht/' + requestType + '/' + destination + '/' + date + welcomeType + vehicleType + transferPlace;
        }
    }
}

function changeGashtOrTransfer(obj) {

    let valInput = $(obj).val();

    valInput=='1' ? $('#request-type').val('0') :$('#request-type').val('1');
}
function viewGasht(i) {
    var dt = new Date().getTime();
    var n = dt.toString();
    var b = i.toString();
    var val1 = i.toString()+dt;

    var ServiceID = $('#ServiceID' + i).val();
    var ServiceName = $('#ServiceName' + i).val();
    var ServiceComment = $('#ServiceComment' + i).val();
    var Price = $('#Price' + i).val();
    var Discount = $('#Discount' + i).val();
    var PriceAfterOff = $('#PriceAfterOff' + i).val();
    var REQUEST_DATE = $('#REQUEST_DATE' + i).val();
    var cityName = $('#cityName' + i).val();
    var request_Type = $('#requestType' + i).val();
    var encryptData=$('#encryptData' + i).val();
    var CurrencyCode=$('#CurrencyCode' + i).val();



    $.ajax({
        type: "POST",
        url: amadeusPath + 'gasht_ajax.php',
        data: {
            "flag": 'gasht_info',
            "ServiceID": ServiceID,
            "ServiceName": ServiceName,
            "ServiceComment": ServiceComment,
            "Price": Price,
            "Discount": Discount,
            "PriceAfterOff": PriceAfterOff,
            "REQUEST_DATE": REQUEST_DATE,
            "cityName": cityName,
            "request_Type": request_Type,
            "encryptData":encryptData,
            "CurrencyCode":CurrencyCode,
            "serviceuniqueid":val1

        },

        success: function (data) {
            // alert("#GashtFormHidden" + ServiceID);

            if (data != '') {

                $.post(amadeusPath + 'gasht_ajax.php',
                    {
                        flag: 'CheckedLogin'
                    },

                    function (data) {

                        if (data.indexOf('successLoginGasht') > -1) {
                            $('#serviceIdBib').val(val1);
                            $("#GashtFormHidden").submit();

                        } else if (data.indexOf('errorLoginGasht') > -1) {
                            $('#serviceIdBib').val(val1);
                            var text = useXmltag("Bookingwithoutregistration");
                            $('#noLoginBuy').val(text);
                            var isShowLoginPopup = $('#isShowLoginPopup').val();
                            var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                            if (isShowLoginPopup == '' || isShowLoginPopup == '1'){
                                $("#login-popup").trigger("click");
                            } else {
                                popupBuyNoLogin(useTypeLoginPopup);
                            }

                        }
                    });
            }
        }
    });
}

/*function memberGashtLogin() {

    // Read Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    // Get values
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

    //check values
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

    // send  for login
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

                    $("#GashtFormHidden").submit();

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

                                // $('#serviceIdBib').val(i);
                                $("#GashtFormHidden").submit();

                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        });

                }
            });
    } else {
        return false;
    }
}*/

function BuyGashtWithoutRegister() {
    // $('#serviceIdBib').val();
    $("#GashtFormHidden").submit();
}


function vehicleVoucher(obj) {
    var voucher = $(obj).val();
    if (voucher == 'train' || voucher == 'airplane') {
        $('#trainOrAierplaneVoucher').addClass('voucherShow');
        if (voucher == 'train') {
            $("#trainOrAierplaneVoucher").attr("placeholder", useXmltag("TrainNumber"));
        }
        if (voucher == 'airplane') {
            $("#trainOrAierplaneVoucher").attr("placeholder", useXmltag("FlightNumber"));
        }
    } else if (voucher == 'bus') {
        $('#trainOrAierplaneVoucher').removeClass('voucherShow');

    }
}

function checkMobile(mob) {
    $("#messageInfo4").html('');
    var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
    var error_member = 0;
    if (mob == "") {
        $("#messageInfo4").html(useXmltag("Fillingallfieldsrequired"));
        error_member = 1;
    } else if (!mobregqx.test(mob)) {
        $("#messageInfo4").html('<br>'+useXmltag("MobileNumberIncorrect"));
        error_member = 1;
    }

    if (error_member == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function checkEmail(email) {
    $("#messageInfo4").html('');
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var error_member = 0;
    if (email == "") {
        $("#messageInfo4").html(useXmltag("Fillingallfieldsrequired"));
        error_member = 1;
    } else if (!emailReg.test(email)) {
        $("#messageInfo4").html('<br>'+useXmltag("Pleaseenteremailcorrectformat"));
        error_member = 1;
    }

    if (error_member == 0) {
        return 'true';
    } else {
        return 'false';
    }
}
function checkDate(date1,date2,date3,type) {
  
    $("#messageInfo2").html('');
var datet1=new Date(date1);
    var datet2=new Date(date2);
    var datet3=new Date(date3);
    $('#messageInfo2').css('color', '#f20');
    var error_member = 0;
    if ( datet3> datet2 ||  datet3<datet1) {
        if(type==0){
        $("#messageInfo2").html(useXmltag("ArrivalDateHotelEqualBeforeDateArrival"));}
        else{
            $("#messageInfo2").html(useXmltag("ArrivalDateHotelEqualBeforeDateTransfer"));
        }
        error_member = 1;

    }
    if (error_member == 0) {
        return 'true';
    } else {
        return 'false';
    }
}



function checkGashtLocal( currentDate) {


    var error1 = 0;
    var error2 = 0;
    var error3 = 0;
    var error4 = 0;
    var error5 = 0;
    var error6 = 0;
    var error7 = 0;

    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);

    var error1 = 0;
        var nameFa = $('#nameFaG1' ).val();
        var familyFa = $('#familyFaG1').val();
        var hotelName = $('#buyerHotelName').val();
        var entyDate = $('#entryDate').val();
        var departureDate = $('#departureDate').val();
        var number = $('#peoplesG1').val();
        var travelVehicle = $('#travelVehicle').val();
        var orginCity = $('#orginCity').val();
    var startTime = $('#startTime').val();
    var endTime = $('#endTime').val();
    var requestType= $('#serviceRequestType').val();

        if (nameFa == null || (familyFa == null) || (number == null) ) {

            $('#messageInfo1').html(useXmltag("Fillingstarredfieldsrequired"));
            $('#messageInfo1').css('color', '#f20');
            error1++;
        } else {
            $('#messageInfo1').html('');
            error1 = 0;

        }
    if ( hotelName == '' || entyDate.length == 0 || departureDate == '') {

        $('#messageInfo2').html('پر کردن فیلد های ستاره دار الزامی می باشد');
        $('#messageInfo2').css('color', '#f20');
        error6++;
    } else {
        $('#messageInfo2').html('');
        error6 = 0;

    }
    if (  travelVehicle == null || orginCity == '' ||startTime == '' ||endTime == '') {

        $('#messageInfo3').html('پر کردن فیلد های ستاره دار الزامی می باشد');
        $('#messageInfo3').css('color', '#f20');
        error7++;
    } else {
        $('#messageInfo3').html('');
        error7 = 0;

    }



    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#buyerCompanionCellPhone').val();
        var Email_Address = $('#Email').val();
var tel=$('#Telephone').val();
        var mm = members(mob, Email_Address);
        if (mm == 'true') {

            error4 = 0;
        } else {
            error4 = 1
        }
    }



    var mob1 = checkMobile($("#buyerCompanionCellPhone").val());
    if (mob1 == 'true') {

        error2 = 0;
    } else {
        error2 = 1;
    }
    var email = checkEmail($("#Email").val());
    if (email == 'true') {

        error3 = 0;
    } else {
        error3 = 1;
    }
    if ( entyDate.length > 0 || departureDate.length > 0) {
        var date = checkDate(entyDate, departureDate, $("#serviceRequestDate").val(),requestType);
        if (date == 'true') {

            error5 = 0;
        } else {
            error5 = 1;
        }
    }



    if (error1 == 0 && error2 == 0 && error3 == 0 && error4 == 0 && error5==0&& error6==0&& error7==0 ) {

        $.post(amadeusPath + 'user_ajax.php',
            {
                mobile: mob,
                telephone: tel,
                Email: Email_Address,
                flag: "register_memeber"
            },
            function (data) {
                if (data != "") {

                    $('#IdMember').val(data);

                    $('#loader_check').show();
                    $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));

                    setTimeout(
                        function () {
                            $('#loader_check').hide();
                            $('#formPassengerDetailGasht').submit();
                        }, 3000);

                } else {

                    $.alert({
                        title: useXmltag("Reservationpatroltransfer"),
                        icon: 'fa fa-cart-plus',
                        content: useXmltag("Errorrecordinginformation"),
                        rtl: true,
                        type: 'red'
                    });
                    return false;
                }
            });
    }
}
function preReserveGasht(factorNumber) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("PatrolTransfer"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress');
    $('#loader_check').css("display", "block");

    $.ajax({
        type: "POST",
        url: amadeusPath + 'gasht_ajax.php',
        data: {
            "flag": 'GashtReserve',
            "factorNumber": factorNumber
        },
        success: function (data) {

            if (data == 'TRUE') {

                setTimeout(function () {
                    $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));
                    $('.main-pay-content').css('display','flex');
                    $('.s-u-passenger-wrapper-change').show();
                    $('#loader_check').css("display", "none");
                    $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                }, 2000);

            } else {

                setTimeout(function () {
                    $('#final_ok_and_insert_passenger').css('background-color', 'red').text(useXmltag("Errorconfirmation"));
                    $.alert({
                        title: useXmltag("Reservationpatroltransfer"),
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
function modalListGasht(FactorNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'user',
            Method: 'ModalShowGasht',
            Param: FactorNumber
        },
        function (data) {

            $('#ModalPublicContent').html(data);

        });
}
function SendGashtEmailForOther() {
    $('#loaderTracking').fadeIn(500);
    $('#SendGashtEmailForOther').attr("disabled", "disabled");
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
                flag: 'SendGashtEmailForOther'
            },
            function (data) {
                console.log(data);
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
                        $('#SendGashtEmailForOther').attr("disabled", false);
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
                    $('#SendGashtEmailForOther').attr("disabled", false);
                    $('#loaderTracking').fadeOut(500);
                }

            });
    }
}