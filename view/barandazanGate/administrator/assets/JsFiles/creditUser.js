
function ModalShowRequestCredit(requestId , memberId) {
    $('#seenContact-'+requestId).addClass('btn-outline')
    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: 'memberCredit',
          Method: 'ModalShowRequestCredit',
          Param: requestId,
          ParamId: memberId
      },
      function (data) {

          $('#ModalPublic').html(data);

      }
    );
}


function ConfirmAdminRequestedUser(RequestId) {
    // alert(RequestId)
    console.log(RequestId);


    if (RequestId === "") {

        $.toast({
            heading: ` تایید پرداخت`,
            text: 'لطفا توضیحات خود را وارد نمائید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        $('#DescriptionClient').css('background-color', '#a94442');
    } else {
        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: `تایید پرداخت`,
            icon: 'fa fa-bon',
            content: 'آیا از تایید درخواست اطمینان دارید',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید',
                    btnClass: 'btn-green',
                    action: function () {
                        $.post(amadeusPath + 'user_ajax.php',
                          {
                              RequestId: RequestId,
                              flag: 'ConfirmRequestedMemberByAdmin'
                          },
                          function (data) {
                              var res = data.split(':');
                              if (data.indexOf('success') > -1) {
                                  $.toast({
                                      heading: `تایید پرداخت`,
                                      text: res[1],
                                      position: 'top-right',
                                      loaderBg: '#fff',
                                      icon: 'success',
                                      hideAfter: 3500,
                                      textAlign: 'right',
                                      stack: 6
                                  });

                                  setTimeout(function () {
                                              location.reload()
                                              // window.location = `${amadeusPath}itadmin/ticket/usersRequestCreditList`;
                                  }, 1000);
                              } else {
                                  $.alert({
                                      title: `تایید پرداخت`,
                                      icon: 'fa fa-times',
                                      content: res[1],
                                      rtl: true,
                                      type: 'red',
                                  });
                              }
                          });
                    }
                },
                cancel: {
                    text: 'انصراف',
                    btnClass: 'btn-orange',
                }
            }
        });
    }


}

function RejectAdminRequestedUser(RequestId) {
    // alert(RequestId)
    console.log(RequestId);


    if (RequestId === "") {

        $.toast({
            heading: ` عدم تایید `,
            text: 'لطفا توضیحات خود را وارد نمائید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        $('#DescriptionClient').css('background-color', '#a94442');
    } else {
        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: ` عدم تایید `,
            icon: 'fa fa-bon',
            content: 'آیا از رد این درخواست اطمینان دارید؟!',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'عدم تایید',
                    btnClass: 'btn-green',
                    action: function () {
                        $.post(amadeusPath + 'user_ajax.php',
                          {
                              RequestId: RequestId,
                              flag: 'RejectRequestedMemberByAdmin'
                          },
                          function (data) {
                              var res = data.split(':');
                              if (data.indexOf('success') > -1) {
                                  $.toast({
                                      heading: `عدم تایید`,
                                      text: res[1],
                                      position: 'top-right',
                                      loaderBg: '#fff',
                                      icon: 'success',
                                      hideAfter: 3500,
                                      textAlign: 'right',
                                      stack: 6
                                  });

                                  setTimeout(function () {
                                      // location.reload()
                                      window.location = `${amadeusPath}itadmin/ticket/usersRequestCreditList`;
                                  }, 1000);
                              } else {
                                  $.alert({
                                      title: `عدم تایید`,
                                      icon: 'fa fa-times',
                                      content: res[1],
                                      rtl: true,
                                      type: 'red',
                                  });
                              }
                          });
                    }
                },
                cancel: {
                    text: 'انصراف',
                    btnClass: 'btn-orange',
                }
            }
        });
    }


}




$(document).ready(function () {


    $("#AddCreditUser").validate({
        rules: {
            credit: "required",
            becauseOf: "required",
            comment: "required"

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

            $('#loadingbank').show();
            $('#SendFormCredit').text('در حال بررسی').css('opacity','0.5');
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');
                    var id = $('#memberID').val();


                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن(کسر) اعتبار',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            $('#loadingbank').hide();
                            $('#SendFormCredit').text('ارسال اطلاعات').css('opacity','1');
                            window.location ='usersWalletList&id=' +  id;
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن(کسر) اعتبار',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        $('#loadingbank').hide();
                        $('#SendFormCredit').text('ارسال اطلاعات').css('opacity','1');
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

