$(document).ready(function () {


    if (gdsSwitch == 'factorVisa' || gdsSwitch == 'passengersDetailVisa') {
        noBack();
    }
    //initialize country select by changing continent

    $("#visaAdd, #visaEdit").validate({
        rules: {
            title: 'required',
            countryCode: 'required',
            visaTypeID: 'required',
            mainCost: {
                required: '#OnlinePayment:checked',
                number: true,
            },
            prePaymentCost: {
                required: '#OnlinePayment:checked',
                number: true,
            },
            deadline: 'required',
            validityDuration: 'required',
            allowedUseNo: 'required'
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
            loadingBtn($('button[data-name="submitVisaForm"]'));
            $(form).ajaxSubmit({
                url: amadeusPath + 'visa_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {


                    let displayIcon;


                    if (response.result_status === 'success') {
                        displayIcon = 'green';
                    } else{
                        displayIcon = 'danger';
                    }
                    $.alert({
                        title: useXmltag("SuccessfullyRecorded"),
                        icon: 'fa fa-check',
                        content:response.result_message,
                        rtl: true,
                        type: displayIcon
                    });
                    loadingBtn($('button[data-name="submitVisaForm"]'),false);
                    window.location = 'visaList';

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



    $('#continent').on('change', function () {

        countryCities();

    });
    $('#visaAdd, #visaEdit .submitForEditor').click(function(){
        if (tinyMCE){ tinyMCE.triggerSave(); }
    });
    $('[data-name="addVisaItem"]').find('input').each(function (){
        if($(this).attr('type') === 'checkbox'){
            $(this).rules("add", {
                required:false
            });
        }else{
            $(this).rules("add", {
                required:true
            });
        }
    })
    // $("#visaAdd, #visaEdit").validate({
    //     rules: {
    //         title: 'required',
    //         mainCost: {
    //             required: '#OnlinePayment:checked',
    //             number: true,
    //         },
    //         prePaymentCost: {
    //             required: '#OnlinePayment:checked',
    //             number: true,
    //         },
    //         deadline: 'required',
    //         validityDuration: 'required',
    //         allowedUseNo: {
    //             required: true,
    //             number: true,
    //         }
    //     },
    //     messages: {
    //     },
    //     errorElement: "em",
    //     errorPlacement: function (error, element) {
    //         // Add the `help-block` class to the error element
    //         error.addClass("help-block");
    //
    //         if (element.prop("type") === "checkbox") {
    //             error.insertAfter(element.parent("label"));
    //         } else {
    //             error.insertAfter(element);
    //         }
    //     },
    //     submitHandler: function (form) {
    //         $(form).ajaxSubmit({
    //             url: amadeusPath + 'visa_ajax.php',
    //             type: 'POST',
    //             dataType: 'JSON',
    //             success: function (response) {
    //
    //                 if (response.result_status == 'success') {
    //                     var displayIcon = 'success';
    //                 } else{
    //                     var displayIcon = 'error';
    //                 }
    //
    //                 $.toast({
    //                     heading: 'ویزا',
    //                     text: response.result_message,
    //                     position: 'top-right',
    //                     icon: displayIcon,
    //                     hideAfter: 3500,
    //                     textAlign: 'right',
    //                     stack: 6
    //                 });
    //
    //                 if (response.result_status == 'success') {
    //                     setTimeout(function(){
    //                         window.location = 'visaList';
    //                     }, 1000);
    //                 }
    //
    //             }
    //         });
    //     },
    //     highlight: function (element, errorClass, validClass) {
    //         $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    //     },
    //     unhighlight: function (element, errorClass, validClass) {
    //         $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    //     }
    // });
});

function addComma (thiss) {
    thiss.val(function (index, value) {
        return value
           .replace(/\D/g, "")
           .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
           ;
    });
}

function countryCities(correctCountry=null) {
    loadingBtn($('#countryCode'));
    var continentID = $('#continent').val();
    $('#countryCode').html('');

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        data: {
            flag: 'initAllCountries',
            correctCountry:correctCountry,
            continentID: continentID
        },
        success: function (response) {
            loadingBtn($('#countryCode'),false);
            $('#countryCode').html(response);

        }
    });
}
function deleteVisaStatus(thiss,recover=false){
    var deleteStatus;
    loadingBtn(thiss);
    if(recover){
        deleteStatus='no';
    }else{
        deleteStatus='yes';
    }
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        data: {
            flag: 'deleteVisaStatus',
            status: deleteStatus,
            id: thiss.data('id')
        },
        success: function (response) {
            loadingBtn(thiss,false);
            if(!recover){
                thiss.removeClass('btn-outline-danger').addClass('btn-outline-secondary').html('<span class="fa fa-refresh"></span> بازگردانی ');
                thiss.attr('onclick','deleteVisaStatus($(this),true)');
            }else{
                thiss.removeClass('btn-outline-secondary').addClass('btn-outline-danger').html('<span class="fa fa-remove"></span> حذف ');
                thiss.attr('onclick','deleteVisaStatus($(this))');
            }
        }
    });
}
function spanLoop(title,value,divClass='col-md-4'){
    if(value == null){
        value = '';
    }
    return '<div class="mb-3 '+divClass+'"><span class="border col-md-12 rounded p-1">'+title+' : '+value+'</span></div>';
}
function isJSON (something) {
    if (typeof something != 'string')
        something = JSON.stringify(something);

    try {
        JSON.parse(something);
        return true;
    } catch (e) {
        return false;
    }
}
function inputLoop(title,idName,value,disabled=false,options=null){

    let col_size='col-md-3';

    // const fullData = JSON.parse(options);
    if(options != null){

        if(options.size != null){
            col_size = options.size;
        }
    }



    if(disabled){
        disabled='d-none';
    }else{
        disabled='d-flex flex-wrap';
    }


    return '<div class="'+col_size+' '+disabled+' mb-4">\n' +
       '<label for="'+idName+'" class="control-label mb-2">'+title+'</label>\n' +
       '<input type="text" class="form-control"\n' +
       'value="'+value+'"\n' +
       'data-id="'+idName+'"\n' +
       'id="'+idName+'" name="'+idName+'[]"\n' +
       'required="required"\n' +
       'placeholder="'+title+'">\n' +
       '</div>';

}
function addModalSubmit(modal){
    modal.find
}
function showVisaModal(thiss){
    loadingBtn(thiss);
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        data: {
            flag: 'visaDetailData',
            id: thiss.data('id')
        },
        success: function (response) {
            console.log(response);

            loadingBtn(thiss,false);
            var fullData=JSON.parse(response);
            console.log(fullData);
            console.log(isJSON(fullData));
            $(thiss.data('target')).modal('show');
            var modalBody= $(thiss.data('target')).find('.modal-body');
            var newHtml='';
            newHtml='<div class="col-md-12 d-flex flex-wrap">';
            newHtml+=spanLoop('کد ویزا',fullData.data.visa.id);
            newHtml+=spanLoop('نام ویزا',fullData.data.visa.title);
            newHtml+=spanLoop('نوع ویزا',fullData.data.visa.visaTypeName);
            newHtml+=spanLoop('مدت اعتبار',fullData.data.visa.validityDuration);
            newHtml+=spanLoop('زمان تحویل',fullData.data.visa.deadline);
            newHtml+=spanLoop('تعداد دفعات مجاز به استفاده',fullData.data.visa.allowedUseNo);
            newHtml+=spanLoop('نوع ارز',fullData.data.visa.currencyTypeName);
            newHtml+=spanLoop('قیمت ویزا',fullData.data.visa.mainCost);
            newHtml+=spanLoop('پیش پرداخت',fullData.data.visa.prePaymentCost);
            newHtml+=spanLoop('نمایش تا',fullData.data.visa.expired_at);
            newHtml+=spanLoop('توضیحات',fullData.data.visa.descriptions,'col-md-8');
            newHtml+=spanLoop('یادداشت مدیر',fullData.data.visa.adminReview,'col-md-12');
            newHtml+='</div>';

            modalBody.html(newHtml);

        }
    });
}

function editVisaModal(thiss){
    loadingBtn(thiss);
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        data: {
            flag: 'visaDetailData',
            id: thiss.data('id')
        },
        success: function (response) {
            loadingBtn(thiss,false);
            var fullData=JSON.parse(response);
            $(thiss.data('target')).modal('show');
            var modalBody= $(thiss.data('target')).find('.modal-body');
            var modalHeader= $(thiss.data('target')).find('.modal-header').find('h5');
            var newHtml='';
            newHtml='<div class="col-md-12">';
            newHtml+=inputLoop('کد ویزا','id',fullData.data.visa.id,true);
            newHtml+=inputLoop('نام ویزا','title',fullData.data.visa.title);
            newHtml+=inputLoop('زمان تحویل','deadline',fullData.data.visa.deadline);
            newHtml+=inputLoop('مدت اعتبار','validityDuration',fullData.data.visa.validityDuration);
            newHtml+=inputLoop('تعداد دفعات مجاز به استفاده','allowedUseNo',fullData.data.visa.allowedUseNo);
            newHtml+=inputLoop('نوع ویزا','visaTypeID',fullData.data.visa.visaTypeName);
            newHtml+=inputLoop('نوع ارز','currencyType',fullData.data.visa.CurrencyTitle);
            newHtml+=inputLoop('قیمت ویزا','mainCost',fullData.data.visa.mainCost);
            newHtml+=inputLoop('پیش پرداخت','prePaymentCost',fullData.data.visa.prePaymentCost);
            newHtml+=inputLoop('نمایش تا','visaExpiration',fullData.data.visa.expired_at);
            newHtml+=inputLoop('توضیحات','descriptionsTextarea',fullData.data.visa.descriptions,'col-md-8');
            newHtml+='</div>';

            modalBody.html(newHtml);
            modalHeader.html('ویرایش ویزا');

        }
    });
}
function closeNewVisaForm(code){
    $('[data-name="addVisaItem"][data-count="'+code+'"]').remove();
    $('[data-name="visaPlanItem"][data-count="'+code+'"]').remove();
    $('input[name="visaCount"]').val(Number($('input[name="visaCount"]').val()-1));
}
function addPlanName(thiss){
    var dataCount=thiss.parent()
       .parent()
       .parent()
       .find('[data-name="planBox"] label')
       .html(' پلن تبلیغات ویزای '+'<span data-name="planName" class="text-primary">'+thiss.val()+'</span>');
}

function loadingBtn(thiss,status=true) {
    thiss.prop('disabled',status);
    if(status){
        thiss.append('<div class="ld ld-ring ld-spin"></div>').addClass('ld-ext-left running');
    }else{
        thiss.removeClass('ld-ext-left running').find('.ld-ring').remove();
    }
}

function submitNewVisa(thiss,submitForm){
    loadingBtn(thiss);

    submitForm.validate({
        rules: {
            title: 'required',
            countryCode: 'required',
            visaTypeID: 'required',
            mainCost: {
                required: '#OnlinePayment:checked',
                number: true,
            },
            prePaymentCost: {
                required: '#OnlinePayment:checked',
                number: true,
            },
            deadline: 'required',
            validityDuration: 'required',
            allowedUseNo: 'required'
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
                url: amadeusPath + 'visa_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {

                    let displayIcon;
                    console.log(response);
                    console.log(response);

                    if (response.status === 'success') {
                        displayIcon = 'green';
                    } else{
                        displayIcon = 'danger';
                    }
                    $.alert({
                        title: useXmltag("SuccessfullyRecorded"),
                        icon: 'fa fa-check',
                        content:response.message,
                        rtl: true,
                        type: displayIcon
                    });
                    loadingBtn(thiss,false);

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

}
function visaPlanChanges(thiss){
    if(thiss.val() === '0'){
        thiss.next('small')
           .find('span.fa')
           .removeClass('text-success fa-check-circle')
           .addClass('text-danger fa-warning');

        thiss.next('small')
           .find('span[data-name="status"]')
           .removeClass('text-success')
           .addClass('text-danger')
           .html('ویزا بدون پلن تبلیغاتی در سایت نمایش داده نمی شود');
    }else{
        thiss.next('small')
           .find('span.fa')
           .removeClass('text-danger fa-warning')
           .addClass('text-success fa-check-circle');

        thiss.next('small')
           .find('span[data-name="status"]')
           .removeClass('text-danger')
           .addClass('text-success')
           .html('این ویزا در سایت نمایش داده می شود');
    }
    var countNumbers=0;
    $('[data-name="planBox"]').each(function (){
        countNumbers += Number($(this).find('[data-id="visaExpiration"]').val());
    });

    if(countNumbers == '0'){
        $('[data-name="lastDiv"] [data-name="value"]').html(number_format('0'));

    }
    if(countNumbers == '1'){
        $('[data-name="lastDiv"] [data-name="value"]').html(number_format('2000000'));
    }
    if(countNumbers == '2'){
        $('[data-name="lastDiv"] [data-name="value"]').html(number_format('3700000'));

    }
    if(countNumbers == '3'){
        $('[data-name="lastDiv"] [data-name="value"]').html(number_format('5500000'));

    }


}
function newVisaForm(thiss){
    var baseAddVisa = $('div[data-name="baseAddVisa"]:first');
    var visaPlanItem = $('div[data-name="visaPlanItem"]:first');
    var clone = baseAddVisa.find('div[data-name="addVisaItem"]:last').clone();
    var cloneNumber=Number(clone.attr('data-count'))+1;
    $('input[name="visaCount"]').val(cloneNumber);
    clone.addClass('newVisaFormDiv');
    clone.find('label').addClass('newVisaLabel').removeAttr('for');
    clone.attr('data-count',cloneNumber);
    clone.find('input').each(function (){
        $(this).attr('id',$(this).attr('data-id')+'_'+cloneNumber);
        $(this).attr('data-target',$(this).attr('data-static-target')+'_'+cloneNumber);
        $(this).val('');
        $(this).prop('checked',false);
    });
    clone.find('label').each(function (){
        $(this).attr('for',$(this).attr('data-for')+'_'+cloneNumber);
        $(this).val('');
    });
    clone.find('textarea').each(function (){
        $(this).attr('id',$(this).attr('data-id')+'_'+cloneNumber);
        $(this).val('');
    });
    clone.find('[data-name="planName"]').html('');
    clone.find('input[name="redirectUrl[]"]').prop('disabled',true);
    clone.find('.mce-tinymce').remove();


    var descriptionsDiv=clone.find('[data-name="descriptions"]');
    descriptionsDiv.find('button[data-toggle="collapse"]')
       .attr('data-target','#'+descriptionsDiv.attr('data-href')+'_'+cloneNumber)
       .attr('aria-controls',descriptionsDiv.attr('data-href')+'_'+cloneNumber);



    descriptionsDiv.find('.collapse').attr('id',descriptionsDiv.attr('data-href')+'_'+cloneNumber);
    descriptionsDiv.find('textarea').attr('id',descriptionsDiv.find('textarea').attr('id')+'_'+cloneNumber);


    $('#'+descriptionsDiv.attr('data-href')+'_'+cloneNumber).collapse({
        toggle: false
    })


    clone.find('.visaCloseBtn').removeClass('d-none');

    $('div[data-name="addVisaItem"]:last').removeClass('newVisaFormDiv').after(clone);
    tinyMCE.remove(".setToEditor");
    tinymce.init({
        selector: ".setToEditor"
    });
    clone.find('.mce-tinymce').css({"display":"block"});
}
function initCountriesOfContinent() {

    var continentID = $('#visa_continent').val();
    $('#visa_destination').html('');

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        data: {
            flag: 'initCountries',
            continentID: continentID
        },
        success: function (response) {
            $('#visa_destination').html(response);
        }
    });
}
function initTypeOfCountry() {

    var countryID = $('#visa_destination').val();
    $('#visa_type').html('');

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        data: {
            flag: 'initTypes',
            countryID: countryID
        },
        success: function (response) {
            $('#visa_type').append('<option value="all">همه</option>');
            $('#visa_type').append(response);
        }
    });
}
function inputPropToggle(thiss){
    var propName=thiss.data('prop');
    var target=thiss.data('target');

    if($(target).prop('disabled')){
        $(target).prop(propName,false)
    }else{
        $(target).prop(propName,true)
    }

}
function submitSearchVisa(pageName='resultVisa') {

    var destination = $("#visa_destination").val();
    var visa_type = $("#visa_type").val();
    // var visa_adt = $("#qty1").val();
    // var visa_chd = $("#qty2").val();
    // var visa_inf = $("#qty3").val();

    if(destination == '' || visa_type == ''){
        alert(useXmltag("Pleaseenterfields"));
        return false;
    }

    var url = amadeusPathByLang +pageName+'/' + destination + '/' + visa_type;
    window.location.href = url;
}

function sendToVisaPassengers(id) {
    var href = amadeusPathByLang + "passengersDetailVisa";

    $("#visaForm-"+id).attr("action", href);
    $("#visaForm-"+id).submit();
}



// function chooseVisa(visaID) {
//
//         $('#formPassengerDetailVisaa').on('submit' , (e) => {
//             e.preventDefault();
//         })
//             $.ajax({
//                 type: 'POST',
//                 url: amadeusPath + 'visa_ajax.php',
//                 dataType: 'JSON',
//                 data:
//                    {
//                        flag: 'checkUserLogin',
//
//                    },
//                 success: function(data) {
//                     $('#visaID').val(visaID);
//                     if (data.result_status == 'success') {
//                         $('#formPassengerDetailVisaa').off('submit'); // remove handler
//                         sendToFactorVisa();
//                     } else {
//                         var isShowLoginPopup = $('#isShowLoginPopup').val();
//                         var useTypeLoginPopup = $('#useTypeLoginPopup').val();
//                         if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
//                             $("#login-popup").trigger("click");
//                         } else {
//                             popupBuyNoLogin(useTypeLoginPopup);
//                         }
//
//                     }
//
//                 }
//             });
//
// }+

function sendToFactorVisa() {
    var href = amadeusPathByLang + "factorVisa";
    console.log('href' , href)
    $("#formPassengerDetailVisaa").attr("action", href);
    $("#formPassengerDetailVisaa").submit();
}
function chooseVisa(visaID) {

    $('#formPassengerDetailVisaa').on('submit' , (e) => {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'visa_ajax.php',
            dataType: 'JSON',
            data:
               {
                   flag: 'checkUserLogin',

               }
        })
           .then(data => {
               $('#visaID').val(visaID);
               if (data.result_status == 'success') {
                   $('#formPassengerDetailVisaa').off('submit'); // remove handler
                   sendToFactorVisa();

               } else {

                   var isShowLoginPopup = $('#isShowLoginPopup').val();
                   var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                   if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                       $("#login-popup").trigger("click");
                   } else {
                       popupBuyNoLogin(useTypeLoginPopup);
                   }

               }
           })
           .catch(error => {
               console.error("Error:", error);
           });
    })
}

function chooseVisa2(visaID) {
    console.log($('#visaResultForm'))
    // $('#visaResultForm').on('submit' , (e) => {
    //     console.log('asd')
    // e.preventDefault();
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data:
           {
               flag: 'checkUserLogin',

           }
    })
       .then(data => {
           $('#visaID').val(visaID);
           if (data.result_status == 'success') {
               $('#visaResultForm').off('submit'); // remove handler
               sendFromResultToVisaPassengers();

           } else {

               var isShowLoginPopup = $('#isShowLoginPopup').val();
               var useTypeLoginPopup = $('#useTypeLoginPopup').val();
               if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                   $("#login-popup").trigger("click");
               } else {
                   popupBuyNoLogin(useTypeLoginPopup);
               }

           }
       })
       .catch(error => {
           console.error("Error:", error);
       });
    // })
}



// function memberVisaLogin() {
//     // Rid Errors
//     var error = 0;
//     $(".cd-error-message").html('');
//     $(".cd-error-message").css("opacity", "0");
//     $(".cd-error-message").css("visibility", "hidden");
//     // Get values
//     var email = $("#signin-email2").val();
//     var pass = $("#signin-password2").val();
//     var remember = $("#remember-me2:checked").val();
//     if (remember == 'checked' || remember == 'on' || remember == 'true') {
//         remember = 'on';
//     } else {
//         remember = 'off';
//     }
//     var organization = '';
//     if($('#signin-organization2').length > 0){
//         organization = $('#signin-organization2').val();
//     }
//
//     //check values
//     if (!email) {
//         $("#error-signin-email2").html('لطفا این فیلد را تکمیل نمایید');
//         $("#error-signin-email2").css("opacity", "1");
//         $("#error-signin-email2").css("visibility", "visible");
//         error = 1;
//     }
//
//     if (!pass) {
//         $("#error-signin-password2").html('لطفا این فیلد را تکمیل نمایید');
//         $("#error-signin-password2").css("opacity", "1");
//         $("#error-signin-password2").css("visibility", "visible");
//         error = 1;
//     }
//
//     // send  for logon
//     if (error == 0) {
//
//         $.post(amadeusPath + 'user_ajax.php',
//             {
//                 email: email,
//                 remember: remember,
//                 password: pass,
//                 organization: organization,
//                 setcoockie: "yes",
//                 flag: 'memberLogin'
//             },
//             function (data) {
//                 if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
//                     $(".cd-user-modal").trigger("click");
//                     sendToFactorVisa();
//                 } else {
//
//                     $.post(amadeusPath + 'user_ajax.php',
//                         {
//                             email: email,
//                             remember: remember,
//                             password: pass,
//                             flag: 'agencyLogin'
//                         },
//                         function (res) {
//                             if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
//                                 $(".cd-user-modal").trigger("click");
//                                 sendToFactorVisa();
//                             } else {
//                                 $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
//                             }
//                         })
//
//                 }
//             })
//     } else {
//         return false;
//     }
// }




function adtMembersVisa(currentDate, numAdult) {
    //  بررسی فیلدهای بزرگسالان
    var error = 0;
    for (i = 1; i <= numAdult; i++) {

        // var gender = '';
        // gender = $("#genderA" + i + " option:selected").val();
        // if ($("#nameFaA" + i).val() == "" || $("#familyFaA" + i).val() == "" || $("#nameEnA" + i).val() == "" || $("#familyEnA" + i).val() == "" || gender == "") {
        //
        //     $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
        //     error = 1;
        // }
        //
        // //بررسی پر کردن فیلد جنسیت
        // if (gender != 'Male' && gender != 'Female') {
        //     $("#messageA" + i).html('<br>'+useXmltag("SpecifyGender"));
        //     error = 1;
        // }

        if ($("#passportNumberA" + i).val() == "" || $("#passportExpireA" + i).val() == "") {
            $("#messageA" + i).html(useXmltag("FillingPassportRequired"));
            error = 1;
        }

        if ($('input[name=passengerNationalityA' + i + ']:checked').val() == '1') {
            if ($("#birthdayEnA" + i).val() == "" || $("#passportCountryA" + i).val() == "" || $("#passportNumberA" + i).val() == "" || $("#passportExpireA" + i).val() == "") {
                $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }

            //بررسی تاریخ تولد
            var t = $("#birthdayEnA" + i).val();
            var d = new Date(t);
//            alert(d.getTime());
            n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
                $("#messageA" + i).html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }

        } else {
            if ($("#birthdayA" + i).val() == "" || $('#NationalCodeA' + i).val() == "") {
                $("#messageA" + i).html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }

            // var National_Code = $('#NationalCodeA' + i).val();
            // var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeA' + i));
            // if (CheckEqualNationalCode == false) {
            //     $("#messageA" + i).html('<br>'+useXmltag("NationalCodeDuplicate"));
            //     error = 1;
            // }

            var z1 = /^[0-9]*\d$/;
            // var convertedCode = convertNumber(National_Code);
            // if (National_Code != "") {
            //     if (!z1.test(convertedCode)) {
            //         $("#messageA" + i).html('<br>'+useXmltag("NationalCodeNumberOnly"));
            //         error = 1;
            //     } else if ((National_Code.toString().length != 10)) {
            //
            //         $("#messageA" + i).html('<br>'+useXmltag("OnlyTenDigitsNationalCode"));
            //         error = 1;
            //     } else {
            //         var NCode = checkCodeMeli(convertNumber(National_Code));
            //         if (!NCode) {
            //             $("#messageA" + i).html('<br>'+useXmltag("EnteredCationalCodeNotValid"));
            //             error = 1;
            //         }
            //     }
            // }

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

function chdMemebrsVisa(currentDate, numChild) {
    var error = 0;
    for (i = 1; i <= numChild; i++) {
        $("#messageC" + i).html('');
        // if ($("#nameFaC" + i).val() == "" || $("#familyFaC" + i).val() == "" || $("#nameEnC" + i).val() == "" || $("#familyEnC" + i).val() == "") {
        //     $("#messageC" + i).html(useXmltag("Fillingallfieldsrequired"));
        //     error = 1;
        // }

        //بررسی پر کردن فیلد جنسیت
        // var gender = '';
        // gender = $("#genderC" + i + " option:selected").val();
        // if (gender != 'Male' && gender != 'Female') {
        //     $("#messageC" + i).html('<br>'+useXmltag("SpecifyGender"));
        //     error = 1;
        // }

        if ($("#passportNumberC" + i).val() == "" || $("#passportExpireC" + i).val() == "") {
            $("#messageC" + i).html(useXmltag("FillingPassportRequired"));
            error = 1;
        }

        if ($('input[name=passengerNationalityC' + i + ']:checked').val() == '1') {
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
                $("#messageC" + i).html('<br>'+useXmltag("NationalCodeDuplicate"));
                error = 1;
            }
            var z1 = /^[0-9]*\d$/;
            // var convertedCode = convertNumber(National_Code);
            // if (!z1.test(convertedCode)) {
            //
            //     $("#messageC" + i).html('<br>'+useXmltag("NationalCodeNumberOnly"));
            //     error = 1;
            // } else if ((convertedCode.toString().length != 10)) {
            //
            //     $("#messageC" + i).html('<br>'+useXmltag("OnlyTenDigitsNationalCode"));
            //     error = 1;
            // } else {
            //     var NCode = checkCodeMeli(convertedCode);
            //     if (!NCode) {
            //         $("#messageC" + i).html('<br>'+useXmltag("EnteredCationalCodeNotValid"));
            //         error = 1;
            //     }
            // }

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

function infMembersVisa(currentDate, numInfant) {
    var error = 0;
    for (i = 1; i <= numInfant; i++) {
        $("#messageI" + i).html('');
        if ($("#nameFaI" + i).val() == "" || $("#familyFaI" + i).val() == "" || $("#nameEnI" + i).val() == "" || $("#familyEnI" + i).val() == "") {
            $("#messageI" + i).html(useXmltag("Fillingallfieldsrequired"));
            error = 1;
        }

        //بررسی پر کردن فیلد جنسیت
        var gender = '';
        gender = $("#genderI" + i + " option:selected").val();
        if (gender != 'Male' && gender != 'Female') {
            $("#messageI" + i).html('<br>'+useXmltag("SpecifyGender"));
            error = 1;
        }

        if ($('input[name=passengerNationalityI' + i + ']:checked').val() == '1') {
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
                $("#messageI" + i).html('<br>'+useXmltag("NationalCodeDuplicate"));
                error = 1;
            }

            var z1 = /^[0-9]*\d$/;
            // var convertedCode = convertNumber(National_Code);

            // if (!z1.test(convertedCode)) {
            //     $("#messageI" + i).html('<br>'+useXmltag("NationalCodeNumberOnly"));
            //     error = 1;
            // } else if ((convertedCode.toString().length != 10)) {
            //
            //     $("#messageI" + i).html('<br>'+useXmltag("OnlyTenDigitsNationalCode"));
            //     error = 1;
            // } else {
            //     var NCode = checkCodeMeli(convertedCode);
            //     if (NCode == false) {
            //         $("#messageI" + i).html(
            //            "<br>" + useXmltag("EnteredCationalCodeNotValid")
            //         )
            //         error = 1;
            //     }
            // }

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

// function checkPassengerVisa(currentDate , visaId) {
//
//     $('#formPassengerDetailVisa').on('submit' , (e) => {
//         e.preventDefault();
//     })
//
//     $('.btn-visa').on('click' , () =>{
//
//         chooseVisa(visaId)
//
//
//     })
//
//
//
//     // $("#formPassengerDetailVisa").submit();
//
// }




function preReserveVisa(factorNumber , currentDate, numAdult, numChild , thiss) {
    let ff =thiss.form;


    var errors = []
    var form_result = 0

    if ($("#Mobile_buyer").length > 0) {
        var mobile_buyer = $("#Mobile_buyer").val()
    } else {
        var mobile_buyer = $("#Mobile").val()
    }

    if ($("#Email_buyer").length > 0) {
        var email_buyer = $("#Email_buyer").val()
    } else {
        var email_buyer = $("#Email").val()
    }


    if (numAdult > 0) {
        var adt = adtMembersVisa(currentDate, numAdult)
        if (adt !== "true") {
            // errors.push(useXmltag("NoUserFoundWithThisProfile"))
            form_result = 1
        }
    }

    if (numChild > 0) {
        var chd = chdMemebrsVisa(currentDate, numChild)
        if (chd !== "true") {
            // errors.push(useXmltag("NoUserFoundWithThisProfile"))
            form_result = 1
        }
    }

    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $("#Mobile").val()
        var Email_Address = $("#Email").val()
        var tel = $("#Telephone").val()
        var mm = members(mob, Email_Address)
        if (mm !== "true") {
            errors.push(useXmltag("MobileNumberIncorrect"))
            form_result = 1
        }
    }

    if (mobile_buyer == "" || email_buyer == "") {
        errors.push(useXmltag("EnterRequiredInformation"))
        form_result = 1
    }
    else {
        var mobregqx =
           /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
        var error_info = 0
        if (!mobregqx.test(mobile_buyer)) {
            errors.push(useXmltag("MobileNumberIncorrect"))
            form_result = 1
        } else if (!emailReg.test(email_buyer)) {
            errors.push(useXmltag("Pleaseenteremailcorrectformat"))
            form_result = 1
        }
    }

    if (form_result == 1) {
        var all_errors = ""
        var error_counter = 0
        for (var eachError in errors) {
            all_errors =
               all_errors +
               '<div class="warning_text_box">' +
               errors[error_counter] +
               "</div>"
            error_counter = error_counter + 1
        }
        $.alert({
            title: useXmltag("PleaseEnterItems"),
            icon: "fa fa-warning",
            content: all_errors,
            rtl: true,
            type: "red",
        })

        $("#messageA1").html(all_errors)


    }
    else {
        if (!$('#RulsCheck').is(':checked')) {
            $.alert({
                title: useXmltag("Reservationvisa"),
                icon: 'fa fa-cart-plus',
                content: useXmltag("ConfirmTermsFirst"),
                rtl: true,
                type: 'red'
            });
            return false;
        }

        let formData = new FormData(); // ایجاد یک شیء FormData جدید
        let inputs = $(ff).serializeArray();
// اضافه کردن فیلدهای معمولی
        formData.append('flag', 'visaInsertPassenger');
        formData.append('numAdult', numAdult);
        formData.append('numChild', numChild);
        formData.append("factorNumber", factorNumber)

        let fileInputs = $("input[type='file']");

        fileInputs.each(function(index, item) {
            formData.append($(item).attr("name"), item.files[0]); // اضافه کردن فایل به FormData
        });

        inputs.forEach(function(item, index) {
            formData.append(item.name , item.value)
        })

        $.ajax({
            type: "POST",
            url: amadeusPath + "visa_ajax.php",
            data: formData, // ارسال FormData
            contentType: false, // غیرفعال کردن تعیین contentType به صورت خودکار
            processData: false, // غیرفعال کردن پردازش داده‌ها
            success: function(res) {
                console.log(res);
            }
        });




        $.post(
           amadeusPath + "user_ajax.php",
           {
               mobile: mob,
               telephone: tel,
               Email: Email_Address,
               flag: "register_memeber",
           },
           function (reponse) {
               var res = reponse.split(":")

               if (reponse.indexOf("success") > -1) {

                   $("#final_ok_and_insert_passenger")
                      .text(useXmltag("Pending"))
                      .attr("disabled", "disabled")
                      .css("opacity", "0.5")
                      .css("cursor", "progress")
                   $("#loader_check").css("display", "block")

                   $.ajax({
                       type: "POST",
                       url: amadeusPath + "visa_ajax.php",
                       dataType: "JSON",
                       data: {
                           flag: "visaPreReserve",
                           factorNumber: factorNumber,
                       },
                       success: function (response) {
                           if (response.result_status == "success") {
                               setTimeout(function () {
                                   $("#final_ok_and_insert_passenger")
                                      .removeAttr("onclick")
                                      .attr("disabled", true)
                                      .css("cursor", "not-allowed")
                                      .text(useXmltag("Accepted"))

                                   $(".main-pay-content").css("display", "flex")
                                   $("#loader_check").css("display", "none")
                                   // $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                               }, 2000)
                           } else {
                               $("#messageBook").html(response.result_message)
                           }
                       },
                   })

               } else {
                   $.alert({
                       title: useXmltag("Reservationvisa"),
                       icon: "fa shopping-cart",
                       content: res[1],
                       rtl: true,
                       type: "red",
                   })
                   return false
               }
           }
        )
    }


}

function ReserveVisaNoPayment(factorNumber) {
    var form = $("#formPassengerDetailVisa").serialize();
    var mob = $('#Mobile').val();
    var Email_Address = $('#Email').val();
    var tel = $('#Telephone').val();
    var mm = members(mob, Email_Address);


    $.post(amadeusPath + 'user_ajax.php',
       {
           mobile: mob,
           telephone: tel,
           Email: Email_Address,
           flag: "register_memeber"
       },
       function (reponse) {
           var res = reponse.split(':');

           if (reponse.indexOf('success') > -1) {
               $('#idMember').val(res[1]);

               $('#loader_check').show();
               $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));

               $.ajax({
                   type: 'POST',
                   url: amadeusPath + 'visa_ajax.php',
                   dataType: 'JSON',
                   data: {
                       flag: 'ReserveVisaNoPayment',
                       factorNumber: factorNumber
                   },
                   success: function (response) {

                       setTimeout(
                          function () {
                              $('#loader_check').hide();
                              $('#formPassengerDetailVisa').submit();
                          }, 2000);

                   }
               });

           } else {

               $.alert({
                   title: useXmltag("Reservationvisa"),
                   icon: 'fa shopping-cart',
                   content: res[1],
                   rtl: true,
                   type: 'red'
               });
               return false;
           }
       });



}

function modalListVisa(FactorNumber) {

    $('.loaderPublic').fadeIn();

    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'user',
           Method: 'ModalShowVisa',
           Param: FactorNumber
       },
       function (data) {
           $('.loaderPublic').fadeOut(150);
           $("#ModalPublic").fadeIn(150);
           $('#ModalPublicContent').html(data);

       });
}

function SendVisaEmailForOther() {
    $('#loaderTracking').fadeIn(500);
    $('#SendVisaEmailForOther').attr("disabled", "disabled");
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
               flag: 'SendVisaEmailForOther'
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
                       $('#SendVisaEmailForOther').attr("disabled", false);
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
                   $('#SendVisaEmailForOther').attr("disabled", false);
                   $('#loaderTracking').fadeOut(500);


               }

           });
    }
}




function registerPassengersFileVisa()
{

    var form = $('#registerPassengersFileVisaForm')[0];
    var formData = new FormData(form);

    $.ajax({
        type: 'post',
        url: amadeusPath + 'visa_ajax.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            $('#registerPassengersFileVisaForm')[0].reset();
            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.alert({
                    title: useXmltag("Reservationvisa"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'green'
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else
            {
                $.alert({
                    title: useXmltag("Reservationvisa"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'red'
                });

            }

        }
    });
}
