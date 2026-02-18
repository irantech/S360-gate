function more_info_train(_this, obj) {

    var trainnumber = obj;
    // var serviceSessionid = '';
    // if ($("#search_multi_way").val() == 'TwoWay') {
    //     serviceSessionid = $("#serviceSessionId_return" + obj).val();
    // } else {
    //     serviceSessionid = $("#serviceSessionId" + obj).val();
    // }

    $("#extera_service_" + trainnumber).html('');
    $('#loaderSearch' + trainnumber).show();

    $.post(amadeusPath + 'train_ajax.php',
        {
            RequestNumber: $('#code').val(),
            UniqueId: _this.data('unique-id'),
            IsExclusiveCompartment: $('#coupe').is(':checked') ? 1 : 0,
            flag: "services"
        },
        function (data) {
            $('#loaderSearch' + trainnumber).hide();
            $("#extera_service_" + trainnumber).html(data);
        });
}
function display_more_info_train(_this, obj) {

    var trainnumber = obj;
    // var serviceSessionid = '';
    // if ($("#search_multi_way").val() == 'TwoWay') {
    //     serviceSessionid = $("#serviceSessionId_return" + obj).val();
    // } else {
    //     serviceSessionid = $("#serviceSessionId" + obj).val();
    // }

    $("#extera_service_" + trainnumber).html('');
    $('#loaderSearch' + trainnumber).show();

    $.post(amadeusPath + 'train_ajax.php',
        {
            RequestNumber: $('#code').val(),
            UniqueId: _this.data('unique-id'),
            IsExclusiveCompartment: $('#coupe').is(':checked') ? 1 : 0,
            flag: "trainServices"
        },
        function (data) {
            $('#loaderSearch' + trainnumber).hide();
            $("#extera_service_" + trainnumber).html(data);
        });
}
function more_info_train_return(obj) {
    var trainnumber = obj;
    $('#loaderSearchReturn' + trainnumber).css("display", "block");
    $.post(amadeusPath + 'train_ajax.php',
        {
            SCP: $("#SCP" + obj).val(),
            TrainNO: $("#TrainNO" + obj).val(),
            Scps: $("#Scps" + obj).val(),
            WagonTypeCode: $("#WagonTypeCode_return" + obj).val(),
            MovDateTrain: $("#MovDateTrain_return" + obj).val(),
            MovTimeTrain: $("#MovTimeTrain_return" + obj).val(),
            serviceSessionId: $("#serviceSessionId_return" + obj).val(),
            flag: "services"
        },
        function (data) {
            $('#loaderSearchReturn' + trainnumber).css("display", "none");
            $("#extera_service_return_" + trainnumber).html(data);
        });
}

$(document).ready(function () {

    //click reserve to revalidate train and show login popup
    $('body').delegate('.nextStepclassTrain', 'click', function () {
        console.log('n1')
        let keyId = $(this).attr('keyId');

        if ($(this) && $(this).length) {
            var _this=$(this)
            loadingToggle(_this)

        }

        let ticket_detail = $(this).parents('.SelectTicket').data('ticket-detail');
        let direction = $(this).parent().attr('direction');
        let PassengerNum = $(this).siblings('#passengerNum').val();
        let ServiceCode = (direction == "dept") ? $(this).siblings('.ServiceCode').val() : $('#servicecodeselected').val();
        let CompanyName = $(this).siblings('.CompanyName').val();
        let soldcounting = $(this).siblings('.soldcounting').val();
        let Departure_City = $(this).siblings('.Departure_City').val();
        let Arrival_City = $(this).siblings('.Arrival_City').val();
        let Dep_Code = $(this).siblings('.Dep_Code').val();
        let Arr_Code = $(this).siblings('.Arr_Code').val();
        let ADULT = $(this).siblings('#adult').val();
        let CHILD = $(this).siblings('#child').val();
        let INFANT = $(this).siblings('#infant').val();
        let serviceSessionId = $(this).siblings('#serviceSessionId').val();
        let idservice = ServiceCode;
        let IsCoupe = $(this).siblings('#isCoupe').val();
        let PassengerCount = $(this).siblings('#passengerCount').val();
        let specific = $(this).siblings('#specific').val();
        let RequestNumber = $(this).siblings('#code').val();

        let detailObj = ticket_detail;

        detailObj.flag = 'revalidate_train';
        detailObj.PassengerNum = PassengerNum;
        detailObj.ServiceCode = ServiceCode;
        detailObj.CompanyName = CompanyName;
        detailObj.soldcounting = soldcounting;
        detailObj.Departure_City = Departure_City;
        detailObj.Arrival_City = Arrival_City;
        detailObj.Dep_Code = Dep_Code;
        detailObj.Arr_Code = Arr_Code;
        detailObj.ADULT = ADULT;
        detailObj.CHILD = CHILD;
        detailObj.INFANT = INFANT;
        detailObj.ServiceSessionId = serviceSessionId;
        detailObj.is_specifice = specific;
        detailObj.RequestNumber = RequestNumber;
        detailObj.Route_type = (direction == "dept") ? '1' : '2';

        console.log(detailObj);
        // return false;
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'train_ajax.php',
            dataType: 'JSON',
            data: detailObj,
            success: function (data) {
                // console.log(data);
                if (data != '') {
                    if ($("#search_multi_way").val() == 'TwoWay' && direction == "dept") {
                        $.post(amadeusPath + 'train_ajax.php',
                            {
                                flag: "getRouteSelected",
                                id: data
                            },
                            function (response) {
                                console.log(response);
                                if (response != '') {

                                    loadingToggle(_this,false)

                                    let json_obj = $.parseJSON(response);//
                                    $(".international-available-box.deptTrain").fadeOut('slow');
                                    $("#ticketselected").html(json_obj[0]);
                                    $(".international-available-box.returnTrain").fadeIn('slow');
                                    $([document.documentElement, document.body]).animate({
                                        scrollTop: 200
                                    }, 1000);
                                }
                            });

                    } else {
                        $.post(amadeusPath + 'train_ajax.php',
                            {
                                flag: 'CheckedLogin'
                            },

                            function (data) {

                                if (data.indexOf('successLoginTrain') > -1) {

                                    $('#serviceIdBib').val(idservice);
                                    $('#code').val(code);

                                    let link = amadeusPathByLang + "passengersDetailTrainApi";

                                    let form = document.createElement("form");
                                    form.setAttribute("method", "POST");
                                    form.setAttribute("action", link);

                                    let hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", 'serviceIdBib');
                                    hiddenField.setAttribute("value", idservice);
                                    form.appendChild(hiddenField);
                                    let hiddenField2 = document.createElement("input");
                                    hiddenField2.setAttribute("type", "hidden");
                                    hiddenField2.setAttribute("name", 'IsCoupe');
                                    hiddenField2.setAttribute("value", IsCoupe);
                                    form.appendChild(hiddenField2);

                                    let hiddenField3 = document.createElement("input");
                                    hiddenField3.setAttribute("type", "hidden");
                                    hiddenField3.setAttribute("name", 'PassengerCount');
                                    hiddenField3.setAttribute("value", PassengerCount);
                                    form.appendChild(hiddenField3);

                                    let hiddenField4 = document.createElement("input");
                                    hiddenField4.setAttribute("type", "hidden");
                                    hiddenField4.setAttribute("name", 'code');
                                    hiddenField4.setAttribute("value", code);
                                    form.appendChild(hiddenField4);

                                    console.log(form);
                                    document.body.appendChild(form);
                                    form.submit();
                                    document.body.removeChild(form);

                                } else if (data.indexOf('errorLoginTrain') > -1) {
                                    // loadingToggle(_this,false)
                                    let isShowLoginPopup = $('#isShowLoginPopup').val();
                                    let useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                    $('#serviceIdBib').val(idservice);
                                    let text = useXmltag("Bookingwithoutregistration");
                                    $('#noLoginBuy').val(text);

                                    if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                        $("#login-popup").trigger("click");
                                    } else {
                                        popupBuyNoLogin(useTypeLoginPopup);
                                    }

                                }
                            });
                    }
                }
            }
        });
    });

    $("body").delegate('.nextStepclassTrainReturn', 'click', function () {
        console.log('n2');
        let ticket_detail = $(this).parents('.SelectTicket').data('ticket-detail');
        let direction = $(this).parent().attr('direction');
        let PassengerNum = $(this).siblings('#passengerNumreturn').val();
        let ServiceCode = $('#servicecodeselected').val();
        let CompanyName = $(this).siblings('.CompanyNamereturn').val();
        let soldcounting = $(this).siblings('.soldcountingreturn').val();
        let Departure_City = $(this).siblings('.Departure_Cityreturn').val();
        let Arrival_City = $(this).siblings('.Arrival_Cityreturn').val();
        let Dep_Code = $(this).siblings('.Dep_Codereturn').val();
        let Arr_Code = $(this).siblings('.Arr_Codereturn').val();
        let ADULT = $(this).siblings('#adultreturn').val();
        let CHILD = $(this).siblings('#childreturn').val();
        let INFANT = $(this).siblings('#infantreturn').val();
        let serviceSessionId = $(this).siblings('#serviceSessionId').val();
        let RequestNumber = $(this).siblings('#code').val();

        let detailObj = ticket_detail;
        detailObj.flag = 'revalidate_train';
        detailObj.PassengerNum = PassengerNum;
        detailObj.ServiceCode = ServiceCode;
        detailObj.CompanyName = CompanyName;
        detailObj.soldcounting = soldcounting;
        detailObj.Departure_City = Departure_City;
        detailObj.Arrival_City = Arrival_City;
        detailObj.Dep_Code = Dep_Code;
        detailObj.Arr_Code = Arr_Code;
        detailObj.ADULT = ADULT;
        detailObj.CHILD = CHILD;
        detailObj.INFANT = INFANT;
        detailObj.ServiceSessionId = serviceSessionId;
        detailObj.is_specifice = specific;
        detailObj.RequestNumber = RequestNumber;
        detailObj.Route_type = (direction == "dept") ? '1' : '2';

        // console.log(detailObj);
        // return false;
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'train_ajax.php',
            dataType: 'JSON',
            data:detailObj,
            success: function (data) {
                if (data != '') {
                    $.post(amadeusPath + 'train_ajax.php',
                        {
                            flag: 'CheckedLogin'
                        },
                        function (data) {

                            if (data.indexOf('successLoginTrain') > -1) {
                                $('#serviceIdBib').val(idservice);
                                let href = amadeusPathByLang + "passengersDetailTrainApi";
                                $("#TrainFormHidden").attr("action", href);
                                $("#TrainFormHidden").submit();

                            } else if (data.indexOf('errorLoginTrain') > -1) {
                                $('#serviceIdBib').val(idservice);
                                let text = useXmltag("Bookingwithoutregistration");
                                $('#noLoginBuy').val(text);
                                let isShowLoginPopup = $('#isShowLoginPopup').val();
                                let useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                    $("#login-popup").trigger("click");
                                } else {
                                    popupBuyNoLogin(useTypeLoginPopup);
                                }

                            }
                        });
                }
            }
        });

    });

    //click reserve to revalidate train and show login popup
    $('body').delegate('.nextStepclassApiTrain', 'click', function () {

        if ($(this) && $(this).length) {
            var _this=$(this)
            loadingToggle(_this)
            console.log('_this',_this)
        }

        console.log('n3');
        let keyId = $(this).attr('keyId');



        let ticket_detail = $(this).parents('.SelectTicket').data('ticket-detail');
        let direction = $(this).parent().attr('direction');
        let PassengerNum = $(this).siblings('#passengerNum').val();
        let ServiceCode = (direction == "dept") ? $(this).siblings('.ServiceCode').val() : $('#servicecodeselected').val();
        let CompanyName = $(this).siblings('.CompanyName').val();
        let soldcounting = $(this).siblings('.soldcounting').val();
        let Departure_City = $(this).siblings('.Departure_City').val();
        let Arrival_City = $(this).siblings('.Arrival_City').val();
        let Dep_Code = $(this).siblings('.Dep_Code').val();
        let Arr_Code = $(this).siblings('.Arr_Code').val();
        let ADULT = $(this).siblings('#adult').val();
        let CHILD = $(this).siblings('#child').val();
        let INFANT = $(this).siblings('#infant').val();
        let serviceSessionId = $(this).siblings('#serviceSessionId').val();
        let idservice = ServiceCode;
        let IsCoupe = $(this).siblings('#isCoupe').val();
        let PassengerCount = $(this).siblings('#passengerCount').val();
        let specific = $(this).siblings('#specific').val();
        let RequestNumber = $(this).siblings('#code').val();

        let detailObj = ticket_detail;

        detailObj.flag = 'revalidate_train2';
        detailObj.PassengerNum = PassengerNum;
        detailObj.ServiceCode = ServiceCode;
        detailObj.CompanyName = CompanyName;
        detailObj.soldcounting = soldcounting;
        detailObj.Departure_City = Departure_City;
        detailObj.Arrival_City = Arrival_City;
        detailObj.Dep_Code = Dep_Code;
        detailObj.Arr_Code = Arr_Code;
        detailObj.ADULT = ADULT;
        detailObj.CHILD = CHILD;
        detailObj.INFANT = INFANT;
        detailObj.ServiceSessionId = serviceSessionId;
        detailObj.is_specifice = specific;
        detailObj.RequestNumber = RequestNumber;
        detailObj.Route_type = (direction == "dept") ? '1' : '2';

        console.log('psc=>'+PassengerCount);
        console.log(detailObj);
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'train_ajax.php',
            dataType: 'JSON',
            data: detailObj,
            success: function (data) {
                console.log('before if data');
                if (data != '') {
                    if ($("#search_multi_way").val() == 'TwoWay' && direction == "dept") {
                        $.post(amadeusPath + 'train_ajax.php',
                            {
                                flag: "getRouteSelected",
                                id: data
                            },
                            function (response) {
                                console.log('_this',_this)
                                console.log('rgrs=>'+response);
                                if (response != '') {

                                    loadingToggle(_this,false)

                                    let json_obj = $.parseJSON(response);//
                                    $(".international-available-box.deptTrain").fadeOut('slow');
                                    $("#ticketselected").html(json_obj[0]);
                                    $(".international-available-box.returnTrain").fadeIn('slow');
                                    $([document.documentElement, document.body]).animate({
                                        scrollTop: 200
                                    }, 1000);
                                }
                            });

                    } else {
                        $.post(amadeusPath + 'train_ajax.php',
                            {
                                flag: 'CheckedLogin'
                            },
                            function (data) {
                                console.log('befor if success login')
                                if (data.indexOf('successLoginTrain') > -1) {
                                    $.ajax({
                                        type: 'POST',
                                        url: amadeusPath + 'ajax',
                                        dataType: 'json',
                                        data: JSON.stringify({
                                            method: 'getLockSeat',
                                            className: 'trainPassengersDetail',
                                            service_code: ServiceCode,
                                            is_coupe: IsCoupe,
                                            is_json: true
                                        }),
                                        success: function(response) {

                                            console.log(typeof response.data[0].Result)
                                            console.log(response);

                                            if(typeof response.data[0].Result !='object'){
                                                response.data[0].Result = JSON.parse(response.data[0].Result)
                                            }
                                            let link = amadeusPathByLang + "trainPassengersDetail";

                                            let form = document.createElement("form");
                                            form.setAttribute("method", "POST");
                                            form.setAttribute("action", link);

                                            let hiddenField = document.createElement("input");
                                            hiddenField.setAttribute("type", "hidden");
                                            hiddenField.setAttribute("name", 'serviceIdBib');
                                            hiddenField.setAttribute("value", idservice);
                                            form.appendChild(hiddenField);

                                            let hiddenField2 = document.createElement("input");
                                            hiddenField2.setAttribute("type", "hidden");
                                            hiddenField2.setAttribute("name", 'IsCoupe');
                                            hiddenField2.setAttribute("value", IsCoupe);
                                            form.appendChild(hiddenField2);

                                            let hiddenField3 = document.createElement("input");
                                            hiddenField3.setAttribute("type", "hidden");
                                            hiddenField3.setAttribute("name", 'PassengerCount');
                                            hiddenField3.setAttribute("value", PassengerCount);
                                            form.appendChild(hiddenField3);

                                            let hiddenField4 = document.createElement("input");
                                            hiddenField4.setAttribute("type", "hidden");
                                            hiddenField4.setAttribute("name", 'code');
                                            hiddenField4.setAttribute("value", RequestNumber);
                                            form.appendChild(hiddenField4);

                                            if(response.data[0] !== undefined && response.data[0].Result.SaleId > 0){
                                                let hiddenField5 = document.createElement("input");
                                                hiddenField5.setAttribute("type", "hidden");
                                                hiddenField5.setAttribute("name", 'SellSerial_dept');
                                                hiddenField5.setAttribute("value", response.data[0].Result.SellSerial);
                                                form.appendChild(hiddenField5);

                                                let hiddenField6 = document.createElement("input");
                                                hiddenField6.setAttribute("type", "hidden");
                                                hiddenField6.setAttribute("name", 'SellStatus_dept');
                                                hiddenField6.setAttribute("value", response.data[0].Result.SellStatus);
                                                form.appendChild(hiddenField6);

                                                let hiddenField7 = document.createElement("input");
                                                hiddenField7.setAttribute("type", "hidden");
                                                hiddenField7.setAttribute("name", 'SellMasterId_dept');
                                                hiddenField7.setAttribute("value", response.data[0].Result.SellMasterId);
                                                form.appendChild(hiddenField7);

                                                let hiddenField8 = document.createElement("input");
                                                hiddenField8.setAttribute("type", "hidden");
                                                hiddenField8.setAttribute("name", 'WagonNumbers_dept');
                                                hiddenField8.setAttribute("value", response.data[0].Result.WagonNumbers);
                                                form.appendChild(hiddenField8);

                                                let hiddenField9 = document.createElement("input");
                                                hiddenField9.setAttribute("type", "hidden");
                                                hiddenField9.setAttribute("name", 'CompartmentNumbers_dept');
                                                hiddenField9.setAttribute("value", response.data[0].Result.CompartmentNumbers);
                                                form.appendChild(hiddenField9);

                                                let hiddenField10 = document.createElement("input");
                                                hiddenField10.setAttribute("type", "hidden");
                                                hiddenField10.setAttribute("name", 'SaleId_dept');
                                                hiddenField10.setAttribute("value", response.data[0].Result.SaleId);
                                                form.appendChild(hiddenField10);

                                                let hiddenField11 = document.createElement("input");
                                                hiddenField11.setAttribute("type", "hidden");
                                                hiddenField11.setAttribute("name", 'request_number_dept');
                                                hiddenField11.setAttribute("value", response.data[0].RequestNumber);
                                                form.appendChild(hiddenField11);



                                                if(response.data[1] !== undefined){

                                                    if(response.data[1].Result.SellSerial > 0 && response.data[1].Result.SaleId > 0){
                                                        let hiddenField12 = document.createElement("input");
                                                        hiddenField12.setAttribute("type", "hidden");
                                                        hiddenField12.setAttribute("name", 'SellSerial_return');
                                                        hiddenField12.setAttribute("value", response.data[1].Result.SellSerial);
                                                        form.appendChild(hiddenField12);

                                                        let hiddenField6 = document.createElement("input");
                                                        hiddenField6.setAttribute("type", "hidden");
                                                        hiddenField6.setAttribute("name", 'SellStatus_return');
                                                        hiddenField6.setAttribute("value", response.data[1].Result.SellStatus);
                                                        form.appendChild(hiddenField6);

                                                        let hiddenField7 = document.createElement("input");
                                                        hiddenField7.setAttribute("type", "hidden");
                                                        hiddenField7.setAttribute("name", 'SellMasterId_return');
                                                        hiddenField7.setAttribute("value", response.data[1].Result.SellMasterId);
                                                        form.appendChild(hiddenField7);

                                                        let hiddenField8 = document.createElement("input");
                                                        hiddenField8.setAttribute("type", "hidden");
                                                        hiddenField8.setAttribute("name", 'WagonNumbers_return');
                                                        hiddenField8.setAttribute("value", response.data[1].Result.WagonNumbers);
                                                        form.appendChild(hiddenField8);

                                                        let hiddenField9 = document.createElement("input");
                                                        hiddenField9.setAttribute("type", "hidden");
                                                        hiddenField9.setAttribute("name", 'CompartmentNumbers_return');
                                                        hiddenField9.setAttribute("value", response.data[1].Result.CompartmentNumbers);
                                                        form.appendChild(hiddenField9);

                                                        let hiddenField10 = document.createElement("input");
                                                        hiddenField10.setAttribute("type", "hidden");
                                                        hiddenField10.setAttribute("name", 'SaleId_return');
                                                        hiddenField10.setAttribute("value", response.data[1].Result.SaleId);
                                                        form.appendChild(hiddenField10);

                                                        let hiddenField11 = document.createElement("input");
                                                        hiddenField11.setAttribute("type", "hidden");
                                                        hiddenField11.setAttribute("name", 'request_number_return');
                                                        hiddenField11.setAttribute("value", response.data[1].RequestNumber);
                                                        form.appendChild(hiddenField11);
                                                    }else{
                                                        $.alert({
                                                            title: useXmltag('BuyTicket'),
                                                            icon: 'fa shopping-cart',
                                                            content: 'امکان رزرو قطار  وجود ندارد لطفا مجددا جستجو نمایید ',
                                                            rtl: true,
                                                            type: 'red',
                                                        })
                                                        setTimeout(
                                                          function() {
                                                              $('#loader_check').fadeOut('slow')
                                                              $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                                                          }, 2000)
                                                        return false;
                                                    }

                                                }
                                                $('#serviceIdBib').val(idservice);
                                                $('#code').val(code);



                                                console.log(hiddenField4);
                                                document.body.appendChild(form);
                                                console.log(form);
                                                // return false;
                                                form.submit();
                                                document.body.removeChild(form);
                                            }else{
                                                $.alert({
                                                    title: useXmltag('BuyTicket'),
                                                    icon: 'fa shopping-cart',
                                                    content: 'امکان رزرو قطار  وجود ندارد لطفا مجددا جستجو نمایید ',
                                                    rtl: true,
                                                    type: 'red',
                                                })
                                                setTimeout(
                                                  function() {
                                                      $('#loader_check').fadeOut('slow')
                                                      $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                                                  }, 2000)
                                                return false;
                                            }
                                        },
                                        error: function(error) {
                                            console.log(error)
                                            $.alert({
                                                title: useXmltag('BuyTicket'),
                                                icon: 'fa shopping-cart',
                                                content: error,
                                                rtl: true,
                                                type: 'red',
                                            })
                                            setTimeout(
                                              function() {
                                                  $('#loader_check').fadeOut('slow')
                                                  $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                                              }, 2000)
                                            return false;
                                        }

                                    });

                                } else if (data.indexOf('errorLoginTrain') > -1) {
                                    console.log('after error login train')
                                    // loadingToggle(_this,false)
                                    let isShowLoginPopup = $('#isShowLoginPopup').val();
                                    let useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                    $('#serviceIdBib').val(idservice);
                                    let text = useXmltag("Bookingwithoutregistration");
                                    $('#noLoginBuy').val(text);

                                   /* if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                        $("#login-popup").trigger("click");
                                    } else {
                                        popupBuyNoLogin(useTypeLoginPopup);
                                    }*/

                                    $.ajax({
                                        type: 'POST',
                                        url: amadeusPath + 'ajax',
                                        dataType: 'json',
                                        data: JSON.stringify({
                                            method: 'getLockSeat',
                                            className: 'trainPassengersDetail',
                                            service_code: ServiceCode,
                                            is_coupe: IsCoupe,
                                            is_json: true
                                        }),
                                        success: function(response) {

                                            console.log(typeof response.data[0].Result)
                                            console.log(response);

                                            if(typeof response.data[0].Result !='object'){
                                                response.data[0].Result = JSON.parse(response.data[0].Result)
                                            }
                                            let link = amadeusPathByLang + "trainPassengersDetail";

                                            let form = document.createElement("form");
                                            form.setAttribute("method", "POST");
                                            form.setAttribute("action", link);

                                            let hiddenField = document.createElement("input");
                                            hiddenField.setAttribute("type", "hidden");
                                            hiddenField.setAttribute("name", 'serviceIdBib');
                                            hiddenField.setAttribute("value", idservice);
                                            form.appendChild(hiddenField);

                                            let hiddenField2 = document.createElement("input");
                                            hiddenField2.setAttribute("type", "hidden");
                                            hiddenField2.setAttribute("name", 'IsCoupe');
                                            hiddenField2.setAttribute("value", IsCoupe);
                                            form.appendChild(hiddenField2);

                                            let hiddenField3 = document.createElement("input");
                                            hiddenField3.setAttribute("type", "hidden");
                                            hiddenField3.setAttribute("name", 'PassengerCount');
                                            hiddenField3.setAttribute("value", PassengerCount);
                                            form.appendChild(hiddenField3);

                                            let hiddenField4 = document.createElement("input");
                                            hiddenField4.setAttribute("type", "hidden");
                                            hiddenField4.setAttribute("name", 'code');
                                            hiddenField4.setAttribute("value", RequestNumber);
                                            form.appendChild(hiddenField4);

                                            if(response.data[0] !== undefined && response.data[0].Result.SaleId > 0){
                                                let hiddenField5 = document.createElement("input");
                                                hiddenField5.setAttribute("type", "hidden");
                                                hiddenField5.setAttribute("name", 'SellSerial_dept');
                                                hiddenField5.setAttribute("value", response.data[0].Result.SellSerial);
                                                form.appendChild(hiddenField5);

                                                let hiddenField6 = document.createElement("input");
                                                hiddenField6.setAttribute("type", "hidden");
                                                hiddenField6.setAttribute("name", 'SellStatus_dept');
                                                hiddenField6.setAttribute("value", response.data[0].Result.SellStatus);
                                                form.appendChild(hiddenField6);

                                                let hiddenField7 = document.createElement("input");
                                                hiddenField7.setAttribute("type", "hidden");
                                                hiddenField7.setAttribute("name", 'SellMasterId_dept');
                                                hiddenField7.setAttribute("value", response.data[0].Result.SellMasterId);
                                                form.appendChild(hiddenField7);

                                                let hiddenField8 = document.createElement("input");
                                                hiddenField8.setAttribute("type", "hidden");
                                                hiddenField8.setAttribute("name", 'WagonNumbers_dept');
                                                hiddenField8.setAttribute("value", response.data[0].Result.WagonNumbers);
                                                form.appendChild(hiddenField8);

                                                let hiddenField9 = document.createElement("input");
                                                hiddenField9.setAttribute("type", "hidden");
                                                hiddenField9.setAttribute("name", 'CompartmentNumbers_dept');
                                                hiddenField9.setAttribute("value", response.data[0].Result.CompartmentNumbers);
                                                form.appendChild(hiddenField9);

                                                let hiddenField10 = document.createElement("input");
                                                hiddenField10.setAttribute("type", "hidden");
                                                hiddenField10.setAttribute("name", 'SaleId_dept');
                                                hiddenField10.setAttribute("value", response.data[0].Result.SaleId);
                                                form.appendChild(hiddenField10);

                                                let hiddenField11 = document.createElement("input");
                                                hiddenField11.setAttribute("type", "hidden");
                                                hiddenField11.setAttribute("name", 'request_number_dept');
                                                hiddenField11.setAttribute("value", response.data[0].RequestNumber);
                                                form.appendChild(hiddenField11);



                                                if(response.data[1] !== undefined){

                                                    if(response.data[1].Result.SellSerial > 0 && response.data[1].Result.SaleId > 0){
                                                        let hiddenField12 = document.createElement("input");
                                                        hiddenField12.setAttribute("type", "hidden");
                                                        hiddenField12.setAttribute("name", 'SellSerial_return');
                                                        hiddenField12.setAttribute("value", response.data[1].Result.SellSerial);
                                                        form.appendChild(hiddenField12);

                                                        let hiddenField6 = document.createElement("input");
                                                        hiddenField6.setAttribute("type", "hidden");
                                                        hiddenField6.setAttribute("name", 'SellStatus_return');
                                                        hiddenField6.setAttribute("value", response.data[1].Result.SellStatus);
                                                        form.appendChild(hiddenField6);

                                                        let hiddenField7 = document.createElement("input");
                                                        hiddenField7.setAttribute("type", "hidden");
                                                        hiddenField7.setAttribute("name", 'SellMasterId_return');
                                                        hiddenField7.setAttribute("value", response.data[1].Result.SellMasterId);
                                                        form.appendChild(hiddenField7);

                                                        let hiddenField8 = document.createElement("input");
                                                        hiddenField8.setAttribute("type", "hidden");
                                                        hiddenField8.setAttribute("name", 'WagonNumbers_return');
                                                        hiddenField8.setAttribute("value", response.data[1].Result.WagonNumbers);
                                                        form.appendChild(hiddenField8);

                                                        let hiddenField9 = document.createElement("input");
                                                        hiddenField9.setAttribute("type", "hidden");
                                                        hiddenField9.setAttribute("name", 'CompartmentNumbers_return');
                                                        hiddenField9.setAttribute("value", response.data[1].Result.CompartmentNumbers);
                                                        form.appendChild(hiddenField9);

                                                        let hiddenField10 = document.createElement("input");
                                                        hiddenField10.setAttribute("type", "hidden");
                                                        hiddenField10.setAttribute("name", 'SaleId_return');
                                                        hiddenField10.setAttribute("value", response.data[1].Result.SaleId);
                                                        form.appendChild(hiddenField10);

                                                        let hiddenField11 = document.createElement("input");
                                                        hiddenField11.setAttribute("type", "hidden");
                                                        hiddenField11.setAttribute("name", 'request_number_return');
                                                        hiddenField11.setAttribute("value", response.data[1].RequestNumber);
                                                        form.appendChild(hiddenField11);
                                                    }else{
                                                        $.alert({
                                                            title: useXmltag('BuyTicket'),
                                                            icon: 'fa shopping-cart',
                                                            content: 'امکان رزرو قطار  وجود ندارد لطفا مجددا جستجو نمایید ',
                                                            rtl: true,
                                                            type: 'red',
                                                        })
                                                        setTimeout(
                                                          function() {
                                                              $('#loader_check').fadeOut('slow')
                                                              $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                                                          }, 2000)
                                                        return false;
                                                    }

                                                }
                                                $('#serviceIdBib').val(idservice);
                                                $('#code').val(code);



                                                console.log(hiddenField4);
                                                document.body.appendChild(form);
                                                console.log(form);
                                                // return false;
                                                form.submit();
                                                document.body.removeChild(form);
                                            }else{
                                                $.alert({
                                                    title: useXmltag('BuyTicket'),
                                                    icon: 'fa shopping-cart',
                                                    content: 'امکان رزرو قطار  وجود ندارد لطفا مجددا جستجو نمایید ',
                                                    rtl: true,
                                                    type: 'red',
                                                })
                                                setTimeout(
                                                  function() {
                                                      $('#loader_check').fadeOut('slow')
                                                      $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                                                  }, 2000)
                                                return false;
                                            }
                                        },
                                        error: function(error) {
                                            console.log(error)
                                            $.alert({
                                                title: useXmltag('BuyTicket'),
                                                icon: 'fa shopping-cart',
                                                content: error,
                                                rtl: true,
                                                type: 'red',
                                            })
                                            setTimeout(
                                              function() {
                                                  $('#loader_check').fadeOut('slow')
                                                  $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                                              }, 2000)
                                            return false;
                                        }

                                    });

                                }
                            });
                    }
                }
            }
        });
    });

    $("body").delegate('.nextStepclassApiTrainReturn', 'click', function () {
        console.log('n4');
        let ticket_detail = $(this).parents('.SelectTicket').data('ticket-detail');
        let direction = $(this).parent().attr('direction');
        let PassengerNum = $(this).siblings('#passengerNumreturn').val();
        let ServiceCode = $('#servicecodeselected').val();
        let CompanyName = $(this).siblings('.CompanyNamereturn').val();
        let RetStatus = $(this).siblings('.RetStatusreturn').val();
        let Remain = $(this).siblings('.Remainreturn').val();
        let TrainNumber = $(this).siblings('.TrainNumberreturn').val();
        let WagonType = $(this).siblings('.WagonTypereturn').val();
        let WagonName = $(this).siblings('.WagonNamereturn').val();
        let PathCode = $(this).siblings('.PathCodereturn').val();
        let CircularPeriod = $(this).siblings('.CircularPeriodreturn').val();
        let MoveDate = $(this).siblings('.MoveDatereturn').val();
        let ExitDate = $(this).siblings('.ExitDatereturn').val();
        let ExitTime = $(this).siblings('.ExitTimereturn').val();
        let Counting = $(this).siblings('.Countingreturn').val();
        let SoldCount = $(this).siblings('.SoldCountreturn').val();
        let degree = $(this).siblings('.degreereturn').val();
        let AvaliableSellCount = $(this).siblings('.AvaliableSellCountreturn').val();
        let Cost = $(this).siblings('.Costreturn').val();
        let FullPrice = $(this).siblings('.FullPricereturn').val();
        let CompartmentCapicity = $(this).siblings('.CompartmentCapicityreturn').val();
        let IsCompartment = $(this).siblings('.IsCompartmentreturn').val();
        let CircularNumberSerial = $(this).siblings('.CircularNumberSerialreturn').val();
        let CountingAll = $(this).siblings('.CountingAllreturn').val();
        let RateCode = $(this).siblings('.RateCodereturn').val();
        let AirConditioning = $(this).siblings('.AirConditioningreturn').val();
        let Media = $(this).siblings('.Mediareturn').val();
        let TimeOfArrival = $(this).siblings('.TimeOfArrivalreturn').val();
        let RationCode = $(this).siblings('.RationCodereturn').val();
        let soldcounting = $(this).siblings('.soldcountingreturn').val();
        let SeatType = $(this).siblings('.SeatTypereturn').val();
        let Owner = $(this).siblings('.Ownerreturn').val();
        let AxleCode = $(this).siblings('.AxleCodereturn').val();
        let Departure_City = $(this).siblings('.Departure_Cityreturn').val();
        let Arrival_City = $(this).siblings('.Arrival_Cityreturn').val();
        let Dep_Code = $(this).siblings('.Dep_Codereturn').val();
        let Arr_Code = $(this).siblings('.Arr_Codereturn').val();
        let ADULT = $(this).siblings('#adultreturn').val();
        let CHILD = $(this).siblings('#childreturn').val();
        let INFANT = $(this).siblings('#infantreturn').val();
        let serviceSessionId = $(this).siblings('#serviceSessionId').val();
        let specific = $(this).siblings('#specific').val();
        let RequestNumber = $(this).siblings('#code').val();

        let detailObj = ticket_detail;
        detailObj.flag = 'revalidate_train2';
        detailObj.PassengerNum = PassengerNum;
        detailObj.ServiceCode = ServiceCode;
        detailObj.CompanyName = CompanyName;
        detailObj.soldcounting = soldcounting;
        detailObj.Departure_City = Departure_City;
        detailObj.Arrival_City = Arrival_City;
        detailObj.Dep_Code = Dep_Code;
        detailObj.Arr_Code = Arr_Code;
        detailObj.ADULT = detailObj.AdultCount;
        detailObj.CHILD = detailObj.ChildCount;
        detailObj.INFANT = detailObj.InfantsCount;
        detailObj.ServiceSessionId = serviceSessionId;
        detailObj.is_specifice = specific;
        detailObj.RequestNumber = RequestNumber;
        detailObj.Route_type = (direction == "dept") ? '1' : '2';

        console.log(detailObj);
        // return false;
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'train_ajax.php',
            dataType: 'JSON',
            data:detailObj,
            success: function (data) {
                if (data != '') {
                    $.post(amadeusPath + 'train_ajax.php',
                        {
                            flag: 'CheckedLogin'
                        },
                        function (data) {

                            if (data.indexOf('successLoginTrain') > -1) {
                                $('#serviceIdBib').val(ServiceCode);
                                let href = amadeusPathByLang + "trainPassengersDetail";
                                $("#TrainFormHidden").attr("action", href);
                                $("#TrainFormHidden").submit();

                            } else if (data.indexOf('errorLoginTrain') > -1) {
                                $('#serviceIdBib').val(ServiceCode);
                                let text = useXmltag("Bookingwithoutregistration");
                                $('#noLoginBuy').val(text);
                                let isShowLoginPopup = $('#isShowLoginPopup').val();
                                let useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                    $("#login-popup").trigger("click");
                                } else {
                                    popupBuyNoLogin(useTypeLoginPopup);
                                }

                            }
                        });
                }
            }
        });

    });

    $("body").delegate("#dateSortSelectForTrain, #priceSortSelectForTrain", 'click', function (e) {

        $('#dateSortSelectForTrain, #priceSortSelectForTrain').removeClass('sorting-active-color-main');
        $(this).addClass('sorting-active-color-main');
        if ($(this).hasClass('rotated-icon')) {
            $(this).removeClass('rotated-icon');
        } else {
            $(this).addClass('rotated-icon');
        }

        var selectID = $(this).attr('id');
        var selected = '';
        var currentSelect = '';

        if (selectID == 'dateSortSelectForTrain') {
            currentSelect = $('#currentTimeSortTrain').val();
            if (currentSelect == 'asc') {
                $('#currentTimeSortTrain').val('desc');
                selected = 'desc';
            } else {
                $('#currentTimeSortTrain').val('asc');
                selected = 'asc';
            }
        } else if (selectID == 'priceSortSelectForTrain') {
            currentSelect = $('#currentPriceSortTrain').val();
            if (currentSelect == 'asc') {
                $('#currentPriceSortTrain').val('desc');
                selected = 'desc';
            } else {
                $('#currentPriceSortTrain').val('asc');
                selected = 'asc';
            }
        }

        var currentTrain = '';
        var allTrain = [];
        var allTrainSpecial = [];
        var temp = [];
        var currentSortSpecial = '';
        var currentSortIndex = '';
        var key = '';
        var SearchResult = $("#s-u-result-wrapper-ul div.items").find(".showListSort .international-available-box:visible");
        var returnTrain = $("#s-u-result-wrapper-ul div.items").find(".showListSort .international-available-box.returnTrain ");
        $("#s-u-result-wrapper-ul div.items").html('');

        SearchResult.each(function (index) {
            currentTrain = $(this).parent();
            console.log('selectID=>' + selectID);
            if (selectID == 'dateSortSelectForTrain') {
                currentSortIndex = currentTrain.find(".timeSortTrain").html();
                console.log('date=>' + currentSortIndex);
            } else if (selectID == 'priceSortSelectForTrain') {
                currentSortIndex = currentTrain.find(".priceSortAdtTrain i.CurrencyCal ").html();
                currentSortIndex = parseInt(currentSortIndex.replace(/,/g, ''));
            }
            allTrain.push({
                'content': currentTrain.html(),
                'sortIndex': currentSortIndex
            });

        });


        console.log(currentTrain.find(".timeSortTrain").val());

        if ($("#ticketselected").html() == '') {
            returnTrain.each(function (index) {
                currentTrain = $(this).parent();
                allTrain.push({
                    'content': currentTrain.html()
                });
            });
        }


        if (selected == 'asc') {

            for (var i = 0; i < parseInt(allTrain.length); i++) {
                key = i;
                for (var j = i; j < parseInt(allTrain.length); j++) {
                    if (allTrain[j]['sortIndex'] <= allTrain[key]['sortIndex']) {
                        console.log('key=>' + allTrain[key]['sortIndex']);
                        console.log('i=>' + allTrain[i]['sortIndex']);
                        console.log('j=>' + allTrain[j]['sortIndex']);
                        temp = allTrain[i];
                        allTrain[i] = allTrain[j];
                        allTrain[j] = temp;
                    }
                }
            }
            /*  for (var i = 0; i < parseInt(allTrainSpecial.length); i++) {
                  key = i;
                  for (var j = i; j < parseInt(allTrainSpecial.length); j++) {
                      if (allTrainSpecial[j]['sortIndex'] <= allTrainSpecial[key]['sortIndex']) {
                          temp = allTrainSpecial[i];
                          allTrainSpecial[i] = allTrainSpecial[j];
                          allTrainSpecial[j] = temp;
                      }
                  }
              }*/
        }//end if
        else if (selected == 'desc') {
            for (var i = 0; i < parseInt(allTrain.length); i++) {
                min = allTrain[i];
                key = i;
                for (var j = i; j < parseInt(allTrain.length); j++) {
                    if (allTrain[j]['sortIndex'] >= allTrain[key]['sortIndex']) {
                        temp = allTrain[i];
                        allTrain[i] = allTrain[j];
                        allTrain[j] = temp;
                    }
                }
            }
            /*for (var i = 0; i < parseInt(allTrainSpecial.length); i++) {
                min = allTrainSpecial[i];
                key = i;
                for (var j = i; j < parseInt(allTrainSpecial.length); j++) {
                    if (allTrainSpecial[j]['sortIndex'] >= allTrainSpecial[key]['sortIndex']) {
                        temp = allTrainSpecial[i];
                        allTrainSpecial[i] = allTrainSpecial[j];
                        allTrainSpecial[j] = temp;
                    }
                }
            }*/
        }//end else if


        setTimeout(function () {
            for (i = 0; i < parseInt(allTrain.length); i++) {
                $("#s-u-result-wrapper-ul div.items").append('<div class="showListSort">' + allTrain[i]['content'] + '</div>');
            }
        }, 100);
    });

});

function BuyTrainWithoutRegister(is_new) {
    console.log('ssinu')
    href = amadeusPathByLang + 'trainPassengersDetail';
    $("#TrainFormHidden").attr("action", href);
    $("#TrainFormHidden").submit();
}

// let recaptchaVerified = false;
// function onReCaptchaSuccess(token) {
//     recaptchaVerified = true;
// }


/**
 * بررسی  مسافران وارد شده قبل از ارسال به صفحه فاکتور
 * page : PassengerDetail.html
 */
function checkfildtrain(currentDate, numAdult, numChild, numInfant, uniq_id) { //flight=  local

    // if (!recaptchaVerified) {
    //
    //     $.alert({
    //         title: useXmltag('Securitycode'),
    //         icon: 'fa shopping-cart',
    //         content: 'لطفا کپچا را وارد کنید',
    //         rtl: true,
    //         type: 'red',
    //     })
    //     return false; // Prevent form submission
    // }

    var error1 = 0;
    var error2 = 0;
    var error3 = 0;
    var error4 = 0;
    var error5 = 0;
    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();

    var FlightType = $('#FlightType').val();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);
//
//    if (retDate != '') { //اگر دوطرفه بود
//        //تاریخ برگشت
//        var retDate = new Date(retDate);
//        retDate = Math.round(retDate.getTime() / 1000);
//    }


    $('#loader_check').show();
    $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));


    var NumberPassenger = parseInt(numAdult) + parseInt(numChild) + parseInt(numInfant);

    if (numAdult > 0) {
        var adt = Adult_members_train(currentDate, numAdult);
        if (adt == 'true') {
            error1 = 0;
        } else {
            error1 = 1
        }
    }


    if (numChild > 0) {
        var chd = Chd_memebrs_train(currentDate, numChild);
        if (chd == 'true') {
            error2 = 0;
        } else {
            error2 = 1
        }
    }


    if (numInfant > 0) {
        var inf = Inf_members_train(currentDate, numInfant);
        if (inf === 'true') {
            error3 = 0;
        } else {
            error3 = 1
        }
    }

    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#Mobile_buyer').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();
        var mm = members(mob, Email_Address);
        if (mm == 'true') {
            error4 = 0;
        } else {
            error4 = 1
        }
    }

    if ($("#Mobile_buyer").length > 0) {
        var mobile_buyer = $('#Mobile_buyer').val();
    } else {
        var mobile_buyer = $('#Mobile').val();
    }

    if (mobile_buyer == '') {
        console.log('fghjkl;fghjk')
        error5 = 1;
        $("#messageInfo").html('<br>' + useXmltag("EnterRequiredInformation")).css('color', '#ce4235');
    }

    if (mobile_buyer != '') {
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;

        if (!mobregqx.test(mobile_buyer)) {
            $("#errorInfo").html('<br>' + useXmltag("MobileNumberIncorrect")).css('color', '#ce4235');
            error5 = 1;
        }
    }


    if ($("#Email_buyer").length > 0) {
        var email_buyer = $('#Email_buyer').val();
    } else {
        var email_buyer = $('#Email').val();



        if (email_buyer == '') {
            if (lang != 'fa') {
                error5 = 1;
                $("#errorInfo").html('<br>' + useXmltag("EnterRequiredInformation")).css('color', '#ce4235');
                $("#messageInfo").html(useXmltag("Invalidemail"));
            } else {
                error5 = 0;
                $('#Email').val('simple' + mobile_buyer + '@info.com');
                email_buyer = $('#Email').val();
            }

        } else {
            error5 = 0;
        }

    }


    if (email_buyer != '') {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        if (!emailReg.test(email_buyer)) {
            $("#errorInfo").html('<br>' + useXmltag("Pleaseenteremailcorrectformat")).css('color', '#ce4235');
            error5 = 1;
        }
    }

    if (error1 == 0 && error2 == 0 && error3 == 0 && error4 == 0 && error5 == 0) {

        var dataForm = $('#formPassengerDetailTrain').serialize();
        var formData = {};
        $('#formPassengerDetailTrain').find("input[name]").each(function (index, node) {
            formData[node.name] = node.value;
        });

        $.post(amadeusPath + 'user_ajax.php',
            {
                mobile: mob,
                telephone: tel,
                Email: Email_Address,
                flag: "register_memeber"
            },
          function(reponse) {
              var res = reponse.split(':')
              let loader = $('#success_load').val();
              if(!loader) {
                  setInterval(function() {
                       loader = $('#success_load').val();
                      console.log('type of' + typeof loader)
                      console.log('loader is==>' +  loader)
                      if(loader) {
                          return ;
                      }
                  }, 1000);
              }

              if (reponse.indexOf('success') > -1) {
                  $('#IdMember').val(res[1])
                  setTimeout(
                    function() {
                        $('#loader_check').delay('9000').fadeOut('slow')
                        console.log('formPassengerDetailTrain')
                        // return false;
                        $('#formPassengerDetailTrain').submit()
                    }, 1000)


              } else {
                  $.alert({
                      title: useXmltag('BuyTicket'),
                      icon: 'fa shopping-cart',
                      content: res[1],
                      rtl: true,
                      type: 'red',
                  })
                  setTimeout(
                    function() {
                        $('#loader_check').fadeOut('slow')
                        $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))
                    }, 2000)
                  return false
              }
          })
    } else {
        $.alert({
            title: useXmltag('BuyTicket'),
            icon: 'fa shopping-cart',
            content: useXmltag('accordingError'),
            rtl: true,
            type: 'red',
        })
        setTimeout(
          function() {
              $('#loader_check').fadeOut('slow')
              $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag('NextStepInvoice'))

          }, 2000)

    }

}


function bookTrain(factor_number) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("Note"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }
    let captcha = $("#signup-captcha2").val();
    if (captcha) {
        $.post(amadeusPath + 'captcha/securimage_check.php',
            {
                captchaAjax: captcha
            },
            function (data) {
            console.log(data)
                if (data == true ) {

                    reloadCaptchaSignin2();


                    $.post(amadeusPath + 'train_ajax.php',
                        {
                            factor_number: factor_number,
                            type: 'preReserve',
                            flag: "preReserveTrain"
                        },
                        function (reponse) {
                            if (reponse.indexOf('success') > -1) {
                                setTimeout(
                                    function () {
                                        $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));

                                        $('.main-pay-content').css('display', 'flex');
                                        $('.s-u-passenger-wrapper-change').show();
                                        $('#loader_check').css("display", "none");
                                        $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                                    }, 1000);
                            } else {
                                $.alert({
                                    title: useXmltag("BuyTicket"),
                                    icon: 'fa shopping-cart',
                                    content: useXmltag("Errorconfirmation"),
                                    rtl: true,
                                    type: 'red'
                                });
                            }
                        });



                }else {
                    reloadCaptchaSignin2();
                    $.alert({
                        title: useXmltag("Note"),
                        icon: 'fa fa-cart-plus',
                        content: 'کد امنیتی وارد شده اشتباه است.',
                        rtl: true,
                        type: 'red'
                    });
                    return false
                }
            })

    }else{
        $.alert({
            title: useXmltag("Note"),
            icon: 'fa fa-cart-plus',
            content: 'لطفا کد امنیتی را  وارد نمائید',
            rtl: true,
            type: 'red'
        });
        return false;
    }

}

function newBookTrain(factor_number,unique_id) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("Note"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }
    $.post(amadeusPath + 'train_ajax.php',
        {
            factor_number: factor_number,
            unique_id: unique_id,
            type: 'preReserve',
            flag: "preReserveTrain"
        },
        function (reponse) {
            if (reponse.indexOf('success') > -1) {
                setTimeout(
                    function () {
                        $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));

                        $('.main-pay-content').css('display', 'flex');
                        $('.s-u-passenger-wrapper-change').show();
                        $('#loader_check').css("display", "none");
                        $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                    }, 1000);
            } else {
                $.alert({
                    title: useXmltag("BuyTicket"),
                    icon: 'fa shopping-cart',
                    content: useXmltag("Errorconfirmation"),
                    rtl: true,
                    type: 'red'
                });
            }
        });


}


function modalListTrain(FactorNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreatorTrain.php',
        {
            Controller: 'user',
            Method: 'ModalShowTrain',
            Param: FactorNumber
        },
        function (data) {

            $('#ModalPublicContent').html(data);

        });
}

function undoFlightSelectTrain(aleman) {
    $.post(amadeusPath + 'train_ajax.php',
        {
            id: aleman,
            flag: "undoFlightSelectTrain"
        },
        function (reponse) {
            if (reponse == 'ok') {
                $("#ticketselected").html('');
                $("#returnwaytrain").fadeOut('slow');
                $("#route_went").fadeIn('slow');
            }
        });
}


function submitSearchTrain() {
    var thisForm = $('form[name="gds_train"]');
    var origincode = thisForm.find("#origin_train").val();
    var DestCode = thisForm.find("#destination_train").val();
    var DateMove = thisForm.find("#dept_date_train").val();
    var TypeWagon = thisForm.find("input[name='Type_seat_train']:checked").val();
    var Adult = 1;
    var Child = 0;
    var Infant = 0;
    if (thisForm.find("#qty1").val() != '') {
        Adult = thisForm.find("#qty1").val();
    }
    if (thisForm.find("#qty2").val() != '') {
        Child = thisForm.find("#qty2").val();
    }
    // if (thisForm.find("#qty3") && thisForm.find("#qty3").val() != '') {
    //     Infant = thisForm.find("#qty3").val();
    // }

    if (thisForm.find("#coupe").is(':checked')) {
        var coupe = 1;
    } else {
        var coupe = 0;
    }
    if (thisForm.find('#dept_date_train_return').val() != "" && $(".TwowayTrain").hasClass("checked")) {
        var returndate = "&" + thisForm.find('#dept_date_train_return').val();
    } else {
        var returndate = '';
    }

    var DRdate = DateMove + returndate;

    if ($(".TwowayTrain").hasClass("checked") && thisForm.find('#dept_date_train_return').val() == "") {
        $.alert({
            title: useXmltag("Bookingbusticket"),
            icon: 'fa fa-cart-plus',
            content: "لطفا تاریخ برگشت را انتخاب کنید",
            rtl: true,
            type: 'red'
        });
    }

    if (origincode == "" || DestCode == "" || DateMove == "") {
        //alert("لطفا فیلدهای مورد نیاز را وارد نمایید");
        $.alert({
            title: useXmltag("Bookingbusticket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
    } else {

        console.log(gdsSwitch);

        let address = amadeusPathByLang + gdsSwitch +'/'+ origincode + '-' + DestCode + '/' + DRdate + '/' + TypeWagon + '/' + Adult + '-' + Child + '-' + Infant + '/' + coupe + '/';
        console.log(address);
        window.location.href = address;
    }


}

function selectedcoupe() {
    var totalpricecoupe = $("#totalpricecoupe").val();
    var PriceExtraPersonCoupe = $("#PriceExtraPersonCoupe").val();
    if ($("#CheckCoupe").val() == 1) {
        $("#loadercheckcoupe").css('display', 'block');
        $(".totalpricecoupe").css('opacity', '.4');
        var result = (parseInt(totalpricecoupe) - parseInt(PriceExtraPersonCoupe));
        setTimeout(
            function () {
                $(".totalpricecoupe").html(addCommas(result) + ' ریال ');
                $("#totalpricecoupe").val(result);
                $("#CheckCoupe").val(0);
                $("#loadercheckcoupe").css('display', 'none');
                $(".totalpricecoupe").css('opacity', '1');
            }, 1000);

    } else {
        $("#loadercheckcoupe").css('display', 'block');
        $(".totalpricecoupe").css('opacity', '.4');
        var result = (parseInt(totalpricecoupe) + parseInt(PriceExtraPersonCoupe));
        setTimeout(
            function () {
                $(".totalpricecoupe").html(addCommas(result) + ' ریال ');
                $("#totalpricecoupe").val(result);
                $("#CheckCoupe").val(1);
                $("#loadercheckcoupe").css('display', 'none');
                $(".totalpricecoupe").css('opacity', '1');
            }, 1000);

    }
    if ($('#avalibelCoupe').val() == 0 && !$("#CheckCoupe").is(':checked') && $('#avalibelCoupeReturn').val() == 1) {
        $('#send_data').css('display', 'block');
        $('#alertCupe').css('display', 'none');
    } else if ($('#avalibelCoupe').val() == 0 && !$("#CheckCoupe").is(':checked') && $('#avalibelCoupeReturn').val() == 0 && !$("#CheckCoupeReturn").is(':checked')) {
        $('#send_data').css('display', 'block');
        $('#alertCupe').css('display', 'none');
    } else {
        $('#send_data').css('display', 'none');
        $('#alertCupe').css('display', 'flex');
    }


}

function selectedcoupereturn() {

    var totalpricecoupe = $("#totalpricecoupe").val();
    var PriceExtraPersonCoupeReturn = $("#PriceExtraPersonCoupeReturn").val();

    if ($("#CheckCoupeReturn").val() == 1) {
        $("#loadercheckcoupe").css('display', 'block');
        $(".totalpricecoupe").css('opacity', '.4');

        var result = (parseInt(totalpricecoupe) - parseInt(PriceExtraPersonCoupeReturn));
        setTimeout(
            function () {
                $(".totalpricecoupe").html(addCommas(result) + ' ریال ');
                $("#totalpricecoupe").val(result);
                $("#CheckCoupeReturn").val(0);
                $("#loadercheckcoupe").css('display', 'none');
                $(".totalpricecoupe").css('opacity', '1');

            }, 1000);

    } else {
        $("#loadercheckcoupe").css('display', 'block');
        $(".totalpricecoupe").css('opacity', '.4');
        var result = (parseInt(totalpricecoupe) + parseInt(PriceExtraPersonCoupeReturn));
        setTimeout(
            function () {
                $(".totalpricecoupe").html(addCommas(result) + ' ریال ');
                $("#totalpricecoupe").val(result);
                $("#CheckCoupeReturn").val(1);
                $("#loadercheckcoupe").css('display', 'none');
                $(".totalpricecoupe").css('opacity', '1');
            }, 1000);

    }

    if ($('#avalibelCoupeReturn').val() == 0 && !$("#CheckCoupeReturn").is(':checked') && $('#avalibelCoupe').val() == 1) {
        $('#send_data').css('display', 'block');
        $('#alertCupeReturn').css('display', 'none');
    } else if ($('#avalibelCoupe').val() == 0 && !$("#CheckCoupe").is(':checked') && $('#avalibelCoupeReturn').val() == 0 && !$("#CheckCoupeReturn").is(':checked')) {
        $('#send_data').css('display', 'block');
        $('#alertCupeReturn').css('display', 'none');
    } else {
        $('#send_data').css('display', 'none');
        $('#alertCupeReturn').css('display', 'flex');
    }
}

function CancleCoupe() {
    $("#CheckCoupe").trigger("click");
    $("#send_data").show();
}


function CancleCoupeReturn() {
    $("#CheckCoupeReturn").trigger("click");

}


function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


function filterTrainByCompany(obj) {
    $(obj).toggleClass('checked');
    var Filter = $(obj).parent('li').find('input');
    var FilterVal = $(obj).parent('li').find('input').val();
    var liTarget = $('li.' + FilterVal);

    var allTarget = $('.international-available-box');


    $(".tzCBPart").parent('li').find('input');


    if ($(obj).parents('ul').hasClass('filter-airline-ul')) {
        if ($(obj).parents('ul.filter-airline-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 0) {
                $(obj).parents('ul.filter-airline-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-companyBus').removeAttr('checked');
                $('#filter-companyBus').siblings('.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-companyBus').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-time-ul')) {

        if ($(obj).parents('ul.filter-time-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 0) {
                $(obj).parents('ul.filter-time-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-time').removeAttr('checked');
                $('#filter-time').siblings('.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-time').siblings('.tzCBPart').addClass('checked');
        }
    }


    var filter_companytrian = [];
    $.each($('ul.filter-airline-ul li'), function (index, value) {
        if ($(this).find('span').hasClass('checked')) {
            filter_companytrian.push(parseInt($(this).find('span.checked').siblings('input').val()));
        }
    });

    var filter_time = [];
    $.each($('ul.filter-time-ul li'), function (index, value) {
        if ($(this).find('span').hasClass('checked')) {
            filter_time.push($(this).find('span.checked').siblings('input').val());
        }
    });

    $.each(allTarget, function (index) {
        allTarget.hide().filter(function () {

            return (
                ($.inArray($(this).data('time'), filter_time) !== -1 || $.inArray('all', filter_time) !== -1) &&
                ($.inArray(parseInt($(this).data('companytrain')), filter_companytrian) !== -1 || $.inArray(0, filter_companytrian) !== -1)
            );
        }).show();

    });
}

function changeWaysTrain(obj) {

    if ($(obj).hasClass('checked')) {
        $('#dept_date_train_return').parents('.s-u-form-block').removeClass('showHidden').addClass('hidden');
    } else {
        $('#dept_date_train_return').parents('.s-u-form-block').removeClass('hidden').addClass('showHidden');
    }

    $(obj).toggleClass('checked');
}

function filterTrainByCapcity(obj) {
    $(obj).toggleClass('checked');
    var allTarget = $('.international-available-box');
    $.each(allTarget, function (index) {
        if ($(obj).hasClass('checked') && $(this).data('capacity') == 0) {
            $(this).hide();
        } else {
            $(this).show();
        }

    });
}


function Adult_members_train(currentDate, numAdult) {
    //  بررسی فیلدهای بزرگسالان
    var error = 0;
    for (i = 1; i <= numAdult; i++) {


        var gender = '';
        gender = $("#genderA" + i + " option:selected").val();
        if ($('input[name=passengerNationalityA' + i + ']:checked').val() == '0') {
            if ($("#nameFaA" + i).val() == "" || $("#familyFaA" + i).val() == "" || gender == "") {

                $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        } else {
            if ($("#nameEnA" + i).val() == "" || $("#familyEnA" + i).val() == "" || gender == "") {

                $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }

        //بررسی پر کردن فیلد ##Sex##
        if (gender != 'Male' && gender != 'Female') {
            $("#messageA" + i).html('<br>' + useXmltag("SpecifyGender"));
            error = 1;
        }

        if ($('input[name=passengerNationalityA' + i + ']:checked').val() == '1') {
            if ($("#passportNumberA" + i).val() == "" || $("#passportExpireA" + i).val() == "") {
                $("#messageA" + i).html(useXmltag("FillingPassportRequired"));
                error = 1;
            }

            //بررسی تاریخ انقضای پاسپورت
            var t = $("#passportExpireA" + i).val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                $("#messageA" + i).html(useXmltag("ExpirationPassportValidSevenMonths"));
                error = 1;
            }


            if ($("#birthdayEnA" + i).val() == "" || $("#passportCountryA" + i).val() == "" || $("#passportNumberA" + i).val() == "" || $("#passportExpireA" + i).val() == "") {
                console.log($("#birthdayEnA" + i).val());
                console.log($("#passportCountryA" + i).val());
                console.log($("#passportNumberA" + i).val());
                console.log($("#passportExpireA" + i).val());
                $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }

            //بررسی تاریخ انقضای پاسپورت
            var t = $("#passportExpireA" + i).val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                $("#messageA" + i).html(useXmltag("ExpirationPassportValidSevenMonths"));
                error = 1;
            }

        } else {
            if ($("#birthdayA" + i).val() == "" || $('#NationalCodeA' + i).val() == "") {
                $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }

            var National_Code = $('#NationalCodeA' + i).val();

            var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeA' + i));
            if (CheckEqualNationalCode == false) {
                $("#messageA" + i).html('<br>' + useXmltag("NationalCodeDuplicate"));
                error = 1;
            }

            var z1 = /^[0-9]*\d$/;
            var convertedCode = convertNumber(National_Code);
            if (National_Code != "") {
                if (!z1.test(convertedCode)) {
                    $("#messageA" + i).html('<br>' + useXmltag("NationalCodeNumberOnly"));
                    error = 1;
                } else if ((National_Code.toString().length != 10)) {

                    $("#messageA" + i).html('<br>' + useXmltag("OnlyTenDigitsNationalCode"));
                    error = 1;
                } else {
                    var NCode = checkCodeMeli(convertNumber(National_Code));
                    if (!NCode) {
                        $("#messageA" + i).html('<br>' + useXmltag("EnteredCationalCodeNotValid"));
                        error = 1;
                    }
                }
            }

            //بررسی تاریخ تولد
            var t = $("#birthdayA" + i).val();
            var splitit = t.split('-');
            var JDate = require('jdate');
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
            var array = $.map(jdate2, function (value, index) {
                return [value];
            });
            var d = new Date(array[0]);
            var n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
                $("#messageA" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }
    }

    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function Chd_memebrs_train(currentDate, numChild) {
    var error = 0;
    for (i = 1; i <= numChild; i++) {
        $("#messageC" + i).html('');
        if ($('input[name=passengerNationalityC' + i + ']:checked').val() == '0') {
            if ($("#nameFaC" + i).val() == "" || $("#familyFaC" + i).val() == "") {
                $("#messageC" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }
        } else {
            if ($("#nameEnC" + i).val() == "" || $("#familyEnC" + i).val() == "") {
                $("#messageC" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }
        }

        //بررسی پر کردن فیلد جنسیت
        var gender = '';
        gender = $("#genderC" + i + " option:selected").val();
        if (gender != 'Male' && gender != 'Female') {
            $("#messageC" + i).html('<br>' + useXmltag("SpecifyGender"));
            error = 1;
        }

        if ($('input[name=passengerNationalityC' + i + ']:checked').val() == '1') {
            if ($("#passportNumberC" + i).val() == "" || $("#passportExpireC" + i).val() == "") {
                $("#messageC" + i).html(useXmltag("FillingPassportRequired"));
                error = 1;
            }

            //بررسی تاریخ انقضای پاسپورت
            var t = $("#passportExpireA" + i).val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60

                $("#messageA" + i).html(useXmltag("ExpirationPassportValidSevenMonths"));
                error = 1;
            }

            if ($("#birthdayEnC" + i).val() == "" || $("#passportCountryC" + i).val() == "" || $("#passportNumberC" + i).val() == "" || $("#passportExpireC" + i).val() == "") {
                $("#messageC" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }

            //بررسی تاریخ تولد
            var t = $("#birthdayEnC" + i).val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) < 63072000 || 378691200 < (currentDate - n)) {// 2سال = 2*365*24*60*60  , 12سال =(12*365+3)*24*60*60
                $("#messageC" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }

        } else {
            if ($("#birthdayC" + i).val() == "" || $('#NationalCodeC' + i).val() == "") {
                $("#messageC" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }

            var National_Code = $('#NationalCodeC' + i).val();
            var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeC' + i));
            if (CheckEqualNationalCode == false) {
                $("#messageC" + i).html('<br>' + useXmltag("NationalCodeDuplicate"));
                error = 1;
            }
            var z1 = /^[0-9]*\d$/;
            var convertedCode = convertNumber(National_Code);
            if (!z1.test(convertedCode)) {

                $("#messageC" + i).html('<br>' + useXmltag("NationalCodeNumberOnly"));
                error = 1;
            } else if ((convertedCode.toString().length != 10)) {

                $("#messageC" + i).html('<br>' + useXmltag("OnlyTenDigitsNationalCode"));
                error = 1;
            } else {
                var NCode = checkCodeMeli(convertedCode);
                if (!NCode) {
                    $("#messageC" + i).html('<br>' + useXmltag("EnteredCationalCodeNotValid"));
                    error = 1;
                }
            }

            //بررسی تاریخ تولد
            var t = $("#birthdayC" + i).val();
            var splitit = t.split('-');
            var JDate = require('jdate');
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
            var array = $.map(jdate2, function (value, index) {
                return [value];
            });
            var d = new Date(array[0]);
            var n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) < 63072000 || 378691200 < (currentDate - n)) { // 2سال = 2*365*24*60*60  , 12سال =(12*365+3)*24*60*60
                $("#messageC" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }
    }

    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function Inf_members_train(currentDate, numInfant) {
    var error = 0;
    for (i = 1; i <= numInfant; i++) {
        $("#messageI" + i).html('');
        if ($('input[name=passengerNationalityI' + i + ']:checked').val() == '0') {
            if ($("#nameFaI" + i).val() == "" || $("#familyFaI" + i).val() == "") {
                $("#messageI" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }
        } else {
            if ($("#nameEnI" + i).val() == "" || $("#familyEnI" + i).val() == "") {
                $("#messageI" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }
        }

        //بررسی پر کردن فیلد جنسیت
        var gender = '';
        gender = $("#genderI" + i + " option:selected").val();
        if (gender != 'Male' && gender != 'Female') {
            $("#messageI" + i).html('<br>' + useXmltag("SpecifyGender"));
            error = 1;
        }

        if ($('input[name=passengerNationalityI' + i + ']:checked').val() == '1') {
            if ($("#passportNumberI" + i).val() == "" || $("#passportExpireI" + i).val() == "") {
                $("#messageI" + i).html(useXmltag("FillingPassportRequired"));
                error = 1;
            }

            if ($("#birthdayEnI" + i).val() == "" || $("#passportCountryI" + i).val() == "" || $("#passportNumberI" + i).val() == "" || $("#passportExpireI" + i).val() == "") {
                $("#messageI" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }

            //بررسی تاریخ تولد
            var t = $("#birthdayEnI" + i).val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) > 63072000) { // 2سال = 2*365*24*60*60

                $("#messageI" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
            if (t === '0000-00-00') {
                $("#messageI" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }

        } else {
            if ($("#birthdayI" + i).val() == "" || $('#NationalCodeI' + i).val() == "") {
                $("#messageI" + i).html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }

            var National_Code = $('#NationalCodeI' + i).val();
            var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeI' + i));
            if (CheckEqualNationalCode == false) {
                $("#messageI" + i).html('<br>' + useXmltag("NationalCodeDuplicate"));
                error = 1;
            }

            var z1 = /^[0-9]*\d$/;
            var convertedCode = convertNumber(National_Code);

            if (!z1.test(convertedCode)) {
                $("#messageI" + i).html('<br>' + useXmltag("NationalCodeNumberOnly"));
                error = 1;
            } else if ((convertedCode.toString().length != 10)) {

                $("#messageI" + i).html('<br>' + useXmltag("OnlyTenDigitsNationalCode"));
                error = 1;
            } else {
                var NCode = checkCodeMeli(convertedCode);
                if (NCode == false) {
                    $("#messageI" + i).html('<br>' + useXmltag("EnteredCationalCodeNotValid"));
                    error = 1;
                }
            }

            //بررسی تاریخ تولد
            var t = $("#birthdayI" + i).val();
            var splitit = t.split('-');
            var JDate = require('jdate');
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
            var array = $.map(jdate2, function (value, index) {
                return [value];
            });
            var d = new Date(array[0]);
            var n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) > 63072000) { // 2سال = 2*365*24*60*60
                $("#messageI" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }
    }

    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}


function reversOriginDestinationTrain() {

    var origin = $("select#origin_train option:selected").val();
    var desti = $("select#destination_train option:selected").val();
    var originTxt = $("select#origin_train option:selected").text();
    var destiTxt = $("select#destination_train option:selected").text();
    // alert(origin + '' + desti);
    if (desti !== "") {


        setTimeout(function () {
            $("select#origin_train option:selected").val(desti);
            $("select#destination_train option:selected").val(origin);
            $("select#origin_train option:selected").text(destiTxt);
            $("select#destination_train option:selected").text(originTxt);
            $("span#select2-origin_train-container").text(destiTxt);
            $("span#select2-destination_train-container").text(originTxt);
        }, 10);


    } else {
        alert(useXmltag("SpecifyDestination"));
    }
}

function getResultTrain(dataSearch) {

    // var text = `
    //     <div class="userProfileInfo-messge ">
    //         <div class="messge-login BoxErrorSearch">
    //             <div style="float: right;"><i
    //                         class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
    //             </div>
    //             <div class="TextBoxErrorSearch">
    //               مسافر گرامی قسمت خرید بلیط قطار وب سایت در حال بروز رسانی است
    //               <br/>
    //               از صبوری شما متشکریم
    //             </div>
    //         </div>
    //     </div>
    // `;
    // $('#result').html(text);
    // return false;

    return $.ajax({
        type: "POST",
        url: amadeusPath + 'train_ajax.php',
        data: {
            flag: 'resultTrainApi',
            dataSearch: dataSearch,
        },
        success: function (data) {
            $('body').find('#result').html(data).append('<div class="sticky-article d-none"></div>');

            let parse = JSON.parse(dataSearch);
            let ArrivalCity = parse.ArrivalCity;
            setTimeout(function () {
                loadArticles('Train', ArrivalCity);
            }, 1000);

        }
    });

}

function trainResult(dataSearch) {
    console.log('******')
    console.log(dataSearch)
    console.log('******')

    // var text = `
    //     <div class="userProfileInfo-messge ">
    //         <div class="messge-login BoxErrorSearch">
    //             <div style="float: right;"><i
    //                         class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
    //             </div>
    //             <div class="TextBoxErrorSearch">
    //               مسافر گرامی قسمت خرید بلیط قطار وب سایت در حال بروز رسانی است
    //               <br/>
    //               از صبوری شما متشکریم
    //             </div>
    //         </div>
    //     </div>
    // `;
    // $('#result').html(text);
    // return false;

    return $.ajax({
        type: "POST",
        url: amadeusPath + 'train_ajax.php',
        data: {
            flag: 'resultTrain',
            dataSearch: dataSearch,
        },
        success: function (data) {
            var parse = JSON.parse(dataSearch);
            // var result =  typeof data === "string" ? JSON.parse(data) : data;
            var result = JSON.parse(data);
            // console.log(parse ,result )
            var ArrivalCity = parse.ArrivalCity;
            $(document).find('#result').html(result.data).append('<div class="sticky-article d-none"></div>')
            
            var company_list = result.company_list


            if(company_list) {
                var  company_result = ''
                company_list.forEach(function (company) {
                    company_result +=  `<li class="filter-row" id="${company.code_company_raja}-filter" style="display: flex;">
                    <label>${company.name_fa}</label>
                    <input class="check-switch" type="checkbox" id="filter-${company.code_company_raja}" value="${company.code_company_raja}">
                      <span data-inactive="غیر فعال" data-active="فعال" class="tzCBPart site-bg-filter-color" onclick="filterTrainByCompany(this)"></span>
                  </li>`
                })
                $('.filter-airline-ul').append(company_result)
                $('.filter-company').on('click', function() {
                    filterTrainByCompany(this);
                });
            }

        }
    });
}

function SendTrainEmailForOther() {
    $('#loaderTracking').fadeIn(500);
    $('#SendBusEmailForOther').attr("disabled", "disabled");
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


        return false;
    } else {
        $.post(amadeusPath + 'user_ajax.php',
          {
              email: Email,
              request_number: request_number,
              flag: 'SendTrainEmailForOther'
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
                      $('#SendBusEmailForOther').attr("disabled", false);
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
                  $('#SendBusEmailForOther').attr("disabled", false);
                  $('#loaderTracking').fadeOut(500);
              }

          });
    }
}


function reloadCaptchaSignin2() {
    var capcha = amadeusPath + 'captcha/securimage_show.php?sid=' + Math.random();
    $("#captchaImage").attr("src", capcha);
}