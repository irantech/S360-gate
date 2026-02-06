$(document).ready(function () {
   $("#chargeAccountForm").validate({
      rules: {
         amount: {
            required: true,
            min: 50000000
            // min: 20000
         }
      },
      messages: {
         amount: {
            required: "وارد کردن این فیلد الزامیست",
            min: "  میزان افزایش اعتبار نمی تواند از 50,000,000 ریال کمتر باشد",
         },
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
         $('#btnbank').attr("disabled", "disabled");
         $('#loadingbank').show();

         let transaction_increase_amount=$('#transaction_increase_amount').val()

         let type_gate_way = $('#type_gate_way').val();

         if(type_gate_way)
         {
            $.ajax({
               type: 'POST',
               url: amadeusPath + 'ajax',
               dataType: 'JSON',
               data:  JSON.stringify({
                  className: 'apiGateWayCharter724',
                  method: 'getToken',
                  'price':transaction_increase_amount
               }),
               success: function (data) {

                  let back_url = `${amadeusPath}itadmin/transactionUser`;

                  console.log(data.data);

                  let form = document.createElement('form');
                  form.setAttribute('method', 'post'); // Set the form method
                  form.setAttribute('action', data.data.url); // Set the form action

                  let input1 = document.createElement('input');
                  input1.setAttribute('type', 'text');
                  input1.setAttribute('name', 'token');
                  input1.value = data.data.token; // Set a default value
                  form.appendChild(input1);

                  let input2 = document.createElement('input');
                  input2.setAttribute('type', 'text');
                  input2.setAttribute('name', 'backUrl');
                  input2.value = back_url ; // Set a default value
                  form.appendChild(input2);

                  let input3 = document.createElement('input');
                  input3.setAttribute('type', 'text');
                  input3.setAttribute('name', 'mobile');
                  input3.value = "09383493154" ; // Set a default value
                  form.appendChild(input3);

                  let input4 = document.createElement('input');
                  input4.setAttribute('type', 'text');
                  input4.setAttribute('name', 'ResNum');
                  input4.value = data.data.factor_number ; // Set a default value
                  form.appendChild(input4);

                  document.body.appendChild(form);
                  console.log(form)
                  form.submit();
                  document.body.removeChild(form);
               },
               error:function(error) {
                  $('#btnbank').attr("disabled", false);
                  $('#loadingbank').hide();
                  $.toast({
                     heading: 'افزودن شارژ حساب',
                     text: error.responseJSON.message,
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
         else{
            $.ajax({
               type: 'POST',
               url: amadeusPath + 'ajax',
               dataType: 'JSON',
               data:  JSON.stringify({
                  className: 'transaction',
                  method: 'createTransactionRequestToBank',
                  transaction_increase_amount,
               })
               ,
               success: function (data) {
                  window.location=data.data.link

               },
               error:function(error) {
                  $('#btnbank').attr("disabled", false);
                  $('#loadingbank').hide();
                  $.toast({
                     heading: 'افزودن شارژ حساب',
                     text: error.responseJSON.message,
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



         /* */


      },
      highlight: function (element, errorClass, validClass) {
         $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
      }


   });
   $("#SearchTransaction").validate({
      rules: {
         date_of: "required",
         to_date: "required"

      },
      messages: {},
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

      highlight: function (element, errorClass, validClass) {
         $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
      }


   });

   $("#AddTransaction").validate({
      rules: {
         Price: "required",
         Reason: "required",
         Comment: "required"
      },
      messages: {},
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
            url: amadeusPath + 'user_ajax.php',
            type: "post",
            success: function (response) {
               var res = response.split(':');

               var id = $('#ClientId').val();

               if (response.indexOf('success') > -1) {
                  $.toast({
                     heading: 'افزودن تراکنش جدید',
                     text: res[1],
                     position: 'top-right',
                     loaderBg: '#fff',
                     icon: 'success',
                     hideAfter: 3500,
                     textAlign: 'right',
                     stack: 6
                  });

                  let is_partner = $('#is_partner').val();

                  // let page_goal =  is_partner.length > 0 ? 'add-partner-transaction' : 'transactionUser';

                  setTimeout(function(){
                     window.location.reload();
                  },1000)


               } else {

                  $.toast({
                     heading: 'افزودن تراکنش جدید',
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

   $("#increaseCreditAgency").validate({
      rules: {
         amount: "required",
         typeCredit: "required"
      },
      messages: {},
      errorElement: "em",
      errorPlacement: function (error, element) {
         // Add the `help-block` class to the error element
         error.addClass("help-block");
         if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
         } else {
            error.insertAfter(element);
         }
         if (element.tagName === 'SELECT') {
            error.insertAfter(element.parent("label"));
         } else {
            error.insertAfter(element);
         }
      },
      submitHandler: function (form) {
         var typeCredit = $('#typeCredit').val();
         if (typeCredit == 'fast') {
            $(form).ajaxSubmit({
               url: amadeusPath + 'user_ajax.php',
               type: "post",
               success: function (response) {


                  $('#btnbank').attr("disabled", "disabled");
                  $('#loadingbank').show();

                  var res = response.split('##@@');
                  if (response.indexOf('SuccessAmountPayment') > -1) {
                     $("body").append(res[1]);
                     $("#payment").submit();
                  } else {
                     $.toast({
                        heading: 'افزودن اعتبار جدید',
                        text: 'خطا در ارسال به درگاه',
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
         }
      },
      highlight: function (element, errorClass, validClass) {
         $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
      }
   });
   //data tables Option
   $('#newTransaction').DataTable();

   // var table = $('#newTransaction').DataTable({
   //     "columnDefs": [{
   //         "visible": false,
   //         "targets": 2
   //     }],
   //     "order": [
   //         [2, 'asc']
   //     ],
   //     "displayLength": 25,
   //     "drawCallback": function(settings) {
   //         var api = this.api();
   //         var rows = api.rows({
   //             page: 'current'
   //         }).nodes();
   //         var last = null;
   //         api.column(2, {
   //             page: 'current'
   //         }).data().each(function(group, i) {
   //             if (last !== group) {
   //                 $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
   //                 last = group;
   //             }
   //         });
   //     }
   // });
   // // Order by the grouping
   // $('#newTransaction tbody').on('click', 'tr.group', function() {
   //     var currentOrder = table.order()[0];
   //     if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
   //         table.order([2, 'desc']).draw();
   //     } else {
   //         table.order([2, 'asc']).draw();
   //     }
   // });

   $("#add_partner_white_label").validate({
      rules: {
         Price: "required",
         Reason: "required",
         Comment: "required"
      },
      messages: {},
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
         let Price = $('#Price').val();
         let Reason = $('#Reason').val();
         let Comment = $('#Comment').val();
         let Client_id = $('#Client_id').val();
         $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'JSON',
            data:  JSON.stringify({
               className: 'accountcharge',
               method: 'addTransactionToPartnerWhiteLabel',
               Price,
               Reason,
               Comment,
               Client_id
            })
            ,
            success: function (data) {
               $.toast({
                  heading: 'افزودن تراکنش',
                  text: data.message,
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
            },
            error:function(error) {
               $.toast({
                  heading: 'افزودن تراکنش',
                  text: error.responseJSON.message,
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'error',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
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

$('#newTransaction').DataTable({
   dom: 'lBfrtip',
   // buttons: [
   //     'copy', 'excel', 'print'
   // ]

   /* buttons: [
        {
            extend: 'excel',
            text: 'دریافت فایل اکسل',
            exportOptions: {}
        },
        {
            extend: 'print',
            text: 'چاپ سطر های لیست',
            exportOptions: {}
        },
        {
            extend: 'copy',
            text: 'کپی لیست',
            exportOptions: {}
        }

    ]*/
});


function ModalShowBook(RequestNumber) {
   $.post(libraryPath + 'ModalCreator.php',
      {
         Controller: 'bookshow',
         Method: 'ModalShowBook',
         Param: RequestNumber
      },
      function (data) {
         $('#ModalPublic').html(data);
      });
}


function changeStatusPaymentManual(type, ClientId, factorNumber) {
   $.post(amadeusPath + 'user_ajax.php',
      {
         ClientId: ClientId,
         type: type,
         factorNumber: factorNumber,
         flag: 'changeStatusPaymentManual'
      },
      function (data) {
         var res = data.split(':');

         if (data.indexOf('success') > -1) {

            $.toast({
               heading: 'تغییر وضعیت درخواست',
               text: res[1],
               position: 'top-right',
               loaderBg: '#fff',
               icon: 'success',
               hideAfter: 3500,
               textAlign: 'right',
               stack: 6
            });

         } else {
            $.toast({
               heading: 'تغییر وضعیت درخواست',
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


function createExcelForTransactionUser() {

   $('#btn-excel').css('opacity', '0.5');
   $('#loader-excel').removeClass('displayN');

   setTimeout(function () {
      $.ajax({
         type: 'post',
         url: amadeusPath + 'user_ajax.php',
         data: $('#SearchTransaction').serialize(),
         success: function (data) {

            $('#btn-excel').css('opacity', '1');
            $('#loader-excel').addClass('displayN');

            var res = data.split('|');
            if (data.indexOf('success') > -1) {

               var url = amadeusPath + 'pic/excelFile/' + res[1];
               var isFileExists = fileExists(url);
               if (isFileExists) {
                  window.open(url, 'Download');
               } else {
                  $.toast({
                     heading: 'دریافت فایل اکسل',
                     text: 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید.',
                     position: 'top-right',
                     loaderBg: '#fff',
                     icon: 'error',
                     hideAfter: 3500,
                     textAlign: 'right',
                     stack: 6
                  });
               }


            } else {

               $.toast({
                  heading: 'دریافت فایل اکسل',
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
   }, 5000);


}

function newCreateExcelFileForTransactionUser() {

   $('#btn-excel').css('opacity', '0.5');
   $('#loader-excel').removeClass('displayN');

   setTimeout(function () {
      $.ajax({
         type: 'post',
         url: amadeusPath + 'user_ajax.php',
         data: $('#SearchTransaction').serialize(),
         success: function (data) {

            $('#btn-excel').css('opacity', '1');
            $('#loader-excel').addClass('displayN');

            var res = data.split('|');
            if (data.indexOf('success') > -1) {

               var url = amadeusPath + 'pic/excelFile/' + res[1];
               var isFileExists = fileExists(url);
               if (isFileExists) {
                  window.open(url, 'Download');
               } else {
                  $.toast({
                     heading: 'دریافت فایل اکسل',
                     text: 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید.',
                     position: 'top-right',
                     loaderBg: '#fff',
                     icon: 'error',
                     hideAfter: 3500,
                     textAlign: 'right',
                     stack: 6
                  });
               }


            } else {

               $.toast({
                  heading: 'دریافت فایل اکسل',
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
   }, 5000);


}
function fileExists(url) {
   if (url) {
      var req = new XMLHttpRequest();
      req.open('GET', url, false);
      req.send();
      return req.status == 200;
   } else {
      return false;
   }
}

function selectBank(obj) {
   if ($(obj).val() == 'slow') {
      $('#selectBankAgency').show();
      $('.input_bank').attr('disabled', false);
   } else {
      $('#selectBankAgency').hide();
      $('.input_bank').attr('disabled', true);
   }
}

function filterRepeated() {


   $('#Repeated').val('yes');
   $('#date_of').val($('#start_repeated_date').val());
   $('#to_date').val($('#end_repeated_date').val());
   $('#SearchTransaction').submit();
}

function separator(txt){
   var iDistance = 3;
   var strChar = ",";
   var strValue = txt.value;

   if(strValue != 'undefined' &&  strValue.length>3){
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