// if you have diffrent services use info_new_list instead of info_list
function bookUserHistoryFilter(target) {
  var filterData = $('#FormUserDataSearchFilter').serialize();
  var TableName = '#memberResultSearch';
  var TableDivision = $('div' + TableName);
  $("#Search_getUserBuy").attr('disabled' , true);
  let memberResultSearch = document.querySelector(".memberResultSearch")
  memberResultSearch.innerHTML = "";
  memberResultSearch.innerHTML +=`<div class="box-style"><div class="box-style-padding"><div class="loading_css"></div></div></div>`;
  $.ajax({
        url: amadeusPath + 'user_ajax.php',
        type: 'POST',
        data: {
          filter: filterData,
          target: $('#serviceType').val(),
          flag: 'memberResultSearch',
        },
     success: function (data) {
        TableDivision.html('');
        let JsonData = JSON.parse(data);
        let kind = $('#serviceType').val();
        $("#Search_getUserBuy").attr('disabled', false);
        memberResultSearch.innerHTML = "";

        if (data && JsonData.length > 0) {

           JsonData.forEach((i) => {

              // ==============================
              //   ساخت جزئیات ورژن قدیمی
              // ==============================
              let old_header = '';
              let old_main = '';
              let old_footer = '';

              if (i.info_list && i.info_list.length > 0) {
                 i.info_list.forEach(info => {
                    old_header += `<div>${info.title}</div>`;
                    old_main += `<div>${info.value}</div>`;
                 });
              }

              if (i.button_list && i.button_list.length > 0) {
                 i.button_list.forEach(btn => {
                    if (btn.type === "link") {
                       old_footer += `<a target="_blank" href="${btn.link}">${btn.title}</a>`;
                    } else {
                       old_footer += `
                            <button class="${btn.title === useXmltag("OsafarRefund") ? 'recovery-btn' : ''} position-relative" onclick="${btn.function}">
                                ${btn.title}
                                <div class="bouncing-loader bouncing-loader-none">
                                    <div></div><div></div><div></div>
                                </div>
                            </button>
                        `;
                    }
                 });
              }

              // ==============================
              //   ساخت جزئیات ورژن جدید
              // ==============================
              // ==============================
//   ساخت جزئیات ورژن جدید
// ==============================
              let new_info_html = '';

              if (i.info_new_list && i.info_new_list.length > 0) {

                 let new_buttons = '';
                 if (i.button_list && i.button_list.length > 0) {
                    new_buttons = `
           <div class="details_box_footer">
               ${
                       i.button_list.map(btn =>
                          btn.type === "link"
                             ? `<a target="_blank" href="${btn.link}">${btn.title}</a>`
                             : `
                           <button class="${btn.title === useXmltag("OsafarRefund") ? 'recovery-btn' : ''} position-relative" onclick="${btn.function}">
                               ${btn.title}
                               <div class="bouncing-loader bouncing-loader-none">
                                   <div></div><div></div><div></div>
                               </div>
                           </button>
                         `
                       ).join('')
                    }
           </div>
       `;
                 }

                 // ساخت باکس ها
                 new_info_html = `
       <div class="details_box h-0 details_box_new">
            <div class="info_new_wrapper">
                ${i.info_new_list.map(box => `
                    <div class="info_new_box">
                        <div class="info_new_box_title">${box.title}</div>

                        ${box.items.map(it => `
                            <div class="info_new_item">
                                <span>${it.title}</span>
                                <span>${it.value}</span>
                            </div>
                        `).join('')}
                    </div>
                `).join('')}
            </div>

            ${new_buttons}
       </div>
   `;
              }


              // ==============================
              //   کارت نهایی رزرو
              // ==============================
              memberResultSearch.innerHTML += `
                   <div class="box-style">
                       <div class="box-style-padding">
               
                           <div class="reserves_card">
                               <div class="reserves_header">
                                   <h2>
                                       <img src="${amadeusPath}view/client/assets/images/service/${i?.service ?? 'default'}.svg" alt="${i?.service ?? ''}">
                                       ${i?.title ?? ''}
                                       <span>${i?.passenger_name ?? ''}</span>
                                   </h2>
                                   <span class="mr-auto ml-2">${i?.time ?? ''} - ${i?.date ?? ''}</span>
                                   <span class="${i?.status?.title ?? ''}">${i?.status?.value ?? ''}</span>
                               </div>
               
                               <div class="reserves_footer">
                                   <div>
                                       <h2>${useXmltag("OrderNumber")}<span>${i?.factor_number ?? ''}</span></h2>
                                       <h2>${useXmltag("PriceAllOrder")}<span>${i?.price ?? ''}</span>${useXmltag("Rial")}</h2>
                                   </div>
               
                                   <button onclick="open_details_box($(event.currentTarget))">
                                       ${useXmltag("Detail")}
                                     <svg  class="down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                         <path d="M362.7 203.9c6.5 5.9 7.1 15.9 1.3 22.6l-159.1 144c-6.1 5.5-15.3 5.5-21.4 0L20 226.5c-5.8-6.6-5.2-16.7 1.3-22.6 6.6-5.9 16.7-5.4 22.6 1.3L192 314.5l149.3-134.4c5.9-6.7 16-7.2 22.4-1.2z"/>
                                     </svg>
                                     <svg style="display:none" class="up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                         <path d="M21.3 308.1c-6.5-5.9-7.1-15.9-1.3-22.6l159.1-144c6.1-5.5 15.3-5.5 21.4 0l159.1 144c5.8 6.6 5.2 16.7-1.3 22.6-6.6 5.9-16.7 5.4-22.6-1.3L192 197.5 42.7 330.7c-5.9 6.7-16 7.2-22.4 1.2z"/>
                                     </svg>
                                 </button>
                                  </div>
                           </div>
               
                           <!-- ورژن قدیمی -->
                           ${(i?.info_list?.length > 0) ? `
                               <div class="details_box h-0">
                                   <div class="details_box_header">${old_header ?? ''}</div>
                                   <div class="details_box_main">${old_main ?? ''}</div>
                                   ${(i?.button_list) ? `<div class="details_box_footer">${old_footer ?? ''}</div>` : ''}
                               </div>
                           ` : ''}
               
                           <!-- ورژن جدید -->
                           ${new_info_html ?? ''}
               
                       </div>
                   </div>
               `;


           });

        } else {

           memberResultSearch.innerHTML = `
            <div class="box-style">
                <div class="box-style-padding">
                    <div class="err404_style mt-4 d-flex justify-content-center align-items-center flex-column">
                        <div class='d-flex justify-content-center'>
                            <img src='${amadeusPath}view/client/assets/images/404-294px.jpg' alt='404'>
                        </div>
                        <h2 class="title">${useXmltag("Noresult")}!</h2>
                    </div>
                </div>
            </div>
        `;
        }
     }


  });
}


function modalPassengerDetails(currentTarget ,RequestNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'ModalPassengerDetails',
      Param: RequestNumber
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function ModalPassengerExclusiveTourDetails(currentTarget ,RequestNumber) {
   $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
   $.post(libraryPath + 'ModalCreator.php', {
         Controller: 'user',
         Method: 'ModalPassengerExclusiveTourDetails',
         Param: RequestNumber
      },
      function (data) {
         $("#ModalResultProfile").html(data);
         $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
      });
}


function ModalCancelUserProfile(currentTarget , type, RequestNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      requestNumber: RequestNumber,
      Method: 'ModalCancelItem',
      Param: RequestNumber,
      ParamId: type
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}


function modalTicketBusDetails(currentTarget , factorNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'modalTicketBusInfo',
      Param: factorNumber,
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function modalListGashtTransfer(currentTarget , RequestNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'ModalListGashtTransferDetails',
      Param: RequestNumber
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function ModalCancelItemProfile(currentTarget , typeApplication, factorNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php',
    {
      Controller: 'user',
      typeApplication: typeApplication,
      factorNumber: factorNumber,
      Param: factorNumber,
      Method: 'showModalCancelItem'
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function modalListForHotelDetails(currentTarget,factorNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'ModalShowHotel',
      Param: factorNumber,
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function modalListInsuranceProfile(currentTarget , FactorNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php',
    {
      Controller: 'user',
      Method: 'ModalShowInsuranceProfile',
      Param: FactorNumber
    },
    function (data) {
      $('#ModalResultProfile').html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function modalListForVisaDetails(currentTarget , factorNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'ModalShowVisaProfile',
      Param: factorNumber,
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}
function modalListForEuropcarDetails(currentTarget , factorNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'ModalShowEuropcar',
      Param: factorNumber,
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}
function modalTourDetails(currentTarget , RequestNumber) {
  $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'user',
      Method: 'ModalTourDetails',
      factorNumber: RequestNumber,
      Param: RequestNumber
    },
    function (data) {
      $("#ModalResultProfile").html(data);
      $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
    });
}

function modalForReservationProofVersa(currentTarget , requestNumber , type) {
  $.post(libraryPath + 'ModalCreator.php', {
      Controller: 'reservationProof',
      Method: 'ModalShowProofProfile',
      Param: {
        requestNumber : requestNumber,
        type : type
      }
    },
    function (data) {
      $("#ModalResultProfile").html(data);
    });
}


function requestCancelFinalBuy_old(typeApplication, factorNumber) {
  if ($('#Ruls').is(':checked')) {
    $("form#cancelBuyForm").find('#typeApplication').val(typeApplication);
    $("form#cancelBuyForm").find('#factorNumber').val(factorNumber);

    // alert($("#factorNumber").val());
    var formDate = $("form#cancelBuyForm").serialize();
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'user_ajax.php',
      data: formDate,
      success: function (data) {
        var res = data.split(':');
        if (data.indexOf('success') > -1) {
          $.alert({
            title: useXmltag("SendCancellationRequest"),
            icon: 'fa fa-check',
            content: res[1],
            rtl: true,
            type: 'green',
          });
          setTimeout(function () {
            $("#ModalResultProfile").fadeOut(700);
          }, 2000);

        } else {
          $.alert({
            title: useXmltag("SendCancellationRequest"),
            icon: 'fa fa-times',
            content: res[1],
            rtl: true,
            type: 'red',
          });
          setTimeout(function () {
            $("#ModalResultProfile").fadeOut(700);
          }, 2000);
        }
      }
    });

  } else {
    $.alert({
      title: useXmltag("SendCancellationRequest"),
      icon: 'fa fa-times',
      content: useXmltag("ReadRulesSelectRules"),
      rtl: true,
      type: 'red'
    });

  }


}


function requestCancelFinalBuy(typeApplication, factorNumber) {
  const loading = document.getElementById('btn-send-information-load');

  if ($('#Ruls').is(':checked')) {
    $("form#cancelBuyForm").find('#typeService').val(typeService);
    $("form#cancelBuyForm").find('#factorNumber').val(factorNumber);

    // alert($("#factorNumber").val());
    // var formDate = $("form#cancelBuyForm").serialize();
    // alert(formDate)
    // console.log(formDate)

    let currentTarget = $(event.currentTarget)
    // var thiss=$(this);
    // thiss.removeClass('submitChangePasswordProfile').addClass('disabled');
    // console.log('runing');
    var form = $("#cancelBuyForm");
    // var url = form.attr("action");
    var formData = $(form).serializeArray();
    var formArray = {};
    $.each(formData, function() {
      formArray[this.name] = this.value;
    });

    var typeService = typeApplication;
    var FactorNumber = formArray['FactorNumber'];
    var commentUser = formArray['comment'];
    var cardNumber = formArray['cardNumber'];
    var AccountOwner = formArray['accountOwner'];
    var backCredit = formArray['backCredit'];
    var Status = 'RequestMember';
    var NameBank = formArray['NameBank'];

// alert(typeService)
// alert(factorNumber)
     if (cardNumber == "" || AccountOwner == "" || NameBank == "" || commentUser == "") {
      $.alert({
        title: useXmltag("CancellationRequest"),
        icon: 'fa fa-trash',
        content: useXmltag("Pleaseenterrequiredfields"),
        rtl: true,
        type: 'red',
      });

  } else {
    currentTarget.children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.post(amadeusPath + 'user_ajax.php',
      {
        typeService: typeService,
        FactorNumber: FactorNumber,
        commentUser: commentUser,
        CardNumber: cardNumber,
        AccountOwner: AccountOwner,
        Status: Status,
        NameBank: NameBank,
        backCredit: backCredit,
        flag: 'flagRequestCancelUser'
      },
      function (data) {
        console.log(currentTarget.children('.bouncing-loader').addClass("bouncing-loader-none"))
        var res = data.split(':');
        if (data.indexOf('success') > -1) {
          $.alert({
            title: useXmltag("CancellationRequest"),
            icon: 'fa fa-trash',
            content: res[1],
            rtl: true,
            type: 'green',
          });
          setTimeout(function () {
            $('#memberChangePassword')[0].reset();
          }, 1000);
          setTimeout(function() {
            location.reload()
          }, 2000);
        } else {
          $.alert({
            title: useXmltag("CancellationRequest"),
            icon: 'fa fa-trash',
            content: res[1],
            rtl: true,
            type: 'red',
          });
        }
      })
     .always(function () {
         loading.style.display = 'none';
         console.log("تست سلام")
       });
  }



  } else {
    $.alert({
      title: useXmltag("SendCancellationRequest"),
      icon: 'fa fa-times',
      content: useXmltag("ReadRulesSelectRules"),
      rtl: true,
      type: 'red'
    });

  }


}



function inputDisabled (event){

  const inputDisabledJsItem = document.querySelectorAll('.input-disabled-js');
  if (event.target.checked){
    inputDisabledJsItem.forEach(input =>{
      input.disabled = true;
    })
  } else {
    inputDisabledJsItem.forEach(input =>{
      input.disabled = false;
    })
  }
}





// // زمانی که مدال نمایش داده شد، کد زیر اجرا می‌شود
// $('.modal_custom').on('shown.bs.modal', function () {
//   // حالا می‌توانیم به عناصر داخل مدال دسترسی داشته باشیم
//   const $parentLabelInput = $('#backCredit');
//   const $inputDisabledItems = $('.input-disabled-js');
//
//   // تابعی برای فعال یا غیرفعال کردن اینپوت‌ها
//   function inputDisabled() {
//     if ($parentLabelInput.is(':checked')) {
//       // اگر چک‌باکس تیک خورده باشد، اینپوت‌های دیگر غیرفعال می‌شوند
//       $inputDisabledItems.prop('disabled', true);
//     } else {
//       // اگر چک‌باکس تیک نخورده باشد، اینپوت‌های دیگر فعال می‌شوند
//       $inputDisabledItems.prop('disabled', false);
//     }
//   }
//
//   // اضافه کردن لیسنر برای تغییر وضعیت چک‌باکس
//   $parentLabelInput.on('change', inputDisabled);
//
//   // اجرای تابع برای اطمینان از وضعیت اولیه
//   inputDisabled();
// });



//
// // انتخاب چک‌باکس اصلی و دیگر اینپوت‌ها با استفاده از jQuery
// const $parentLabelInput = $('#backCredit');
// const $inputDisabledItems = $('.input-disabled-js');
//
// // تابع برای فعال یا غیرفعال کردن اینپوت‌ها
// function inputDisabled() {
//   if ($parentLabelInput.is(':checked')) {
//     // اگر چک‌باکس تیک خورده باشد، اینپوت‌های دیگر غیرفعال می‌شوند
//     $inputDisabledItems.prop('disabled', true);
//     console.log('true')
//   } else {
//     // اگر چک‌باکس تیک نخورده باشد، اینپوت‌های دیگر فعال می‌شوند
//     $inputDisabledItems.prop('disabled', false);
//     console.log('false')
//   }
// }
//
// // اضافه کردن لیسنر به چک‌باکس برای تغییرات
// $parentLabelInput.on('change', inputDisabled);













