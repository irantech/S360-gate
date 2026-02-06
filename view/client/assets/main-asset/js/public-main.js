$('document').ready(function() {


  $("#searchBoxTabs .nav-link").click(() => {
    setTimeout(()=>{
      if($("#Insurance-tab").hasClass("active")){
        $(".passengers-age-js").click(() => {
          $('#ui-datepicker-div').addClass('insurance-costume-calender')
        })
      } else {
        $('#ui-datepicker-div').removeClass('insurance-costume-calender')
      }
    },100)
  })


  $(".insurance-costume-calender").click((e) => {
    e.stopPropagation();
  })



  if(gdsSwitch == 'mainPage'){
    $('.show-box-login-js').on('click',function(e) {
      $('.show-content-box-login-js').toggle();
      e.stopPropagation();
    })
    $('body').click(function () {
      $('.main-navigation__sub-menu2').hide();
    });
  }


  $(".select2_in").select2({
    templateResult: formatState
  });

  $(".default-select2").select2();

  $('.add-to-count-passenger-js').on('click', function() {
    getCountPassengers(this, 'add')
  })

  $('.minus-to-count-passenger-js').on('click', function() {
    getCountPassengers(this, 'minus')
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
});

function formatState (state) {
  if (!state.id) {
    return state.text;
  }
  var baseUrl = "/user/pages/images/flags";
  var $state = $(
    '<span class="city_start"><i class="fa fa-map-marker-alt"></i>' + state.text + '</span>'
  );
  return $state;
};

function signout(typeUser) {
  $.post(amadeusPath + 'user_ajax.php',
    {flag: 'signout'},
    function (data) {
      /*if(typeUser !=undefined && typeUser=='agency')
         {
             window.location.href = amadeusPathByLang + "loginAgency";
         }else{
             window.location.href = amadeusPathByLang + "loginUser";
         }*/
      window.location.href = clientMainDomain  ;

    }
  )
}

function getCountPassengers(obj, type) {

  let count_passengers = $(obj).siblings('.number-count-js').attr('data-number')
  let type_passengers = $(obj).siblings('.number-count-js').attr('data-type')
  let type_search = $(obj).siblings('.number-count-js').attr('data-search')
  if (count_passengers <= 9) {
    let new_passenger = count_passengers
    if (type === 'add' && count_passengers < 9) {
      new_passenger = ++count_passengers
    } else if (type !== 'add' && count_passengers > 1 && type_passengers === 'adult') {
      new_passenger = --count_passengers
    } else if ( type !== 'add' && count_passengers >= 1 && type_passengers !== 'adult') {
      new_passenger = --count_passengers
    }

    $(obj).siblings('.number-count-js').html(count_passengers)
    $(obj).siblings('.number-count-js').attr('data-number', count_passengers)
    $('.' + type_passengers).val(new_passenger)

  }

  if($(obj).data('visa') !== undefined && $(obj).data('visa') === 'yes'){
    let passenger_adult = Number($(obj).parents('.box-of-count-passenger-js').find('.adult-number-js .number-count-js').attr('data-number'))
    $(obj).parents('.box-of-count-passenger-js').find('.text-count-passenger-js').text(`${passenger_adult}  ${useXmltag("Passenger")}`)

  }
  else if($(obj).data('train') !== undefined && $(obj).data('train') === 'yes') {
    let passenger_adult = Number($(obj).parents('.box-of-count-passenger-js').find('.adult-number-js .number-count-js').attr('data-number'))
    let passenger_child = Number($(obj).parents('.box-of-count-passenger-js').find('.child-number-js .number-count-js').attr('data-number'))


    $('.' + type_search+'-adult-js').val(passenger_adult);
    $('.' + type_search+'-child-js').val(passenger_child);

    let total_passenger = passenger_adult + passenger_child

    $(obj).parents('.box-of-count-passenger-js').find('.text-count-passenger-js').text(`${total_passenger}  ${useXmltag("Passenger")}`)
  }else if($(obj).data('parvaz') !== undefined && $(obj).data('parvaz') === 'yes') {
    let passenger_adult = Number($(obj).parents('.box-of-count-passenger-js').find('.adult-number-js .number-count-js').attr('data-number'))
    let passenger_child = Number($(obj).parents('.box-of-count-passenger-js').find('.child-number-js .number-count-js').attr('data-number'))
    let passenger_infant = Number($(obj).parents('.box-of-count-passenger-js').find('.infant-number-js .number-count-js').attr('data-number'))

    $('.' + type_search+'-adult-js').val(passenger_adult);
    $('.' + type_search+'-child-js').val(passenger_child);
    $('.' + type_search+'-infant-js').val(passenger_infant);

    let total_passenger = passenger_adult + passenger_child + passenger_infant

    $(obj).parents('.box-of-count-passenger-js').find('.text-count-passenger-js').text(`${total_passenger}  ${useXmltag("Passenger")}`)
  }
  else{
    let passenger_adult = Number($(obj).parents('.box-of-count-passenger-js').find('.adult-number-js .number-count-js').attr('data-number'))
    let passenger_child = Number($(obj).parents('.box-of-count-passenger-js').find('.child-number-js .number-count-js').attr('data-number'))
    let passenger_infant = Number($(obj).parents('.box-of-count-passenger-js').find('.infant-number-js .number-count-js').attr('data-number'))

    $('.' + type_search+'-adult-js').val(passenger_adult);
    $('.' + type_search+'-child-js').val(passenger_child);
    $('.' + type_search+'-infant-js').val(passenger_infant);


    $(obj).parents('.box-of-count-passenger-js').find('.text-count-passenger-js').text(`${passenger_adult}   ${useXmltag("Adult")} ,  ${passenger_child}  ${useXmltag("Child")} ,  ${passenger_infant} ${useXmltag("Infant")}`)

  }

}

function loadXMLDoc(filename) {

  xhttp=new XMLHttpRequest();
  xhttp.open("GET",filename,false);
  xhttp.send();
  return xhttp.responseXML;
}

function useXmltag(tagname) {

  // let get_translate = localStorage.getItem('translate_'+lang) ;

  result=xmlDoc.getElementsByTagName(tagname)[0];

  return result!=undefined ? result.childNodes[0].nodeValue : " ";

}

function translateXmlByParams(tagname, params) {
  let val = useXmltag(tagname);
  let entries = Object.entries(params);
  entries.forEach((para) => {
    let find = '@@' + para[0] + '@@';
    let regExp = new RegExp(find, 'g');
    val = val.replace(regExp, para[1])
  });
  return val;
}

xmlDoc=loadXMLDoc(rootMainPath+"/gds/langs/"+lang+"_frontMaster.xml");

function dateNow(mode) {
  let dateNow = new Date().toLocaleDateString('fa-IR').replace(/([۰-۹])/g, token => String.fromCharCode(token.charCodeAt(0) - 1728));
  let dateNowSplit = [];
  let year = '';
  let month = '';
  let day = '';

  dateNowSplit = dateNow.split('/');

  year = dateNowSplit[0];
  month = (parseInt(dateNowSplit[1]) <= 9) ? '0' + dateNowSplit[1] : dateNowSplit[1];
  day = (parseInt(dateNowSplit[2]) <= 9) ? '0' + dateNowSplit[2] : dateNowSplit[2];
  return year + mode + month + mode + day

}

function checkSearchFields(...data) {
  let items_name = []

  data.forEach(item => {

    item.map(function(idx, elem){
      const each_item=$(elem)
      const item_value = each_item.val()

      if ((!item_value || item_value === "") && each_item.is(":not(:disabled)")) {
        let item_name = each_item.attr("placeholder")
        if (!item_name) {
          item_name = each_item.data("placeholder")
        }
        if (!item_name) {
          item_name = each_item.parent().find('label').text()
        }
        if (item_name) {
          items_name.push(item_name)
        }
      }
    })
  })
  if (items_name.length) {
    let html_tags = ""
    items_name.forEach(item => {
      html_tags +=
        '<spam style="font-size:14px;" class="badge badge-danger-2">' +
        item +
        "</spam>"
    })
    $.alert({
      title: useXmltag("Pleaseenterrequiredfields"),
      icon: "fa fa-cart-plus",
      content: html_tags,
      rtl: true,
      type: "red",
    })
    throw 'fix your entries.'
  }
}




function checkSearchFieldsWithRedBorder(...data) {
  let items_name = []
  data.forEach(item => {
    item.map(function(idx, elem){
      const each_item=$(elem)
      const item_value = each_item.val()
      if ((!item_value || item_value === "") && each_item.is(":not(:disabled)")) {
        items_name.push(each_item.attr("data-border-red"))
      }
    })
  })
  if (items_name.length) {
    items_name.forEach(item => {
      $(item).addClass("border-red")
    })
    $.alert({
      title: useXmltag("Pleaseenterrequiredfields"),
      icon: "fa fa-cart-plus",
      content: html_tags,
      rtl: true,
      type: "red",
    })
    throw 'fix your entries.'
  }else {
    items_name.forEach(item => {
      $(item).removeClass("border-red")
    })
  }
}




function openLink(url, is_new_tab=false) {
  if (is_new_tab) window.open(url, "_blank")
  else window.location.href = url
}

function templateFake(content_modal_fake,header) {

  let modal_fake = `
           ${header}
            <div class="modal-body flight-prices">
              <div id="loadbox">
            </div>
              <div class="row">
                ${content_modal_fake}
              </div>
            </div>
          <div class="modal-footer"><button type="button" aria-hidden="true" class="btn btn-primary site-bg-main-color site-bg-color-dock-border" data-dismiss="modal" aria-label="Close">بستن</button></div>
        
`
  return modal_fake
}

function item_template(data_calender) {
  let content_modal_main = '' ;
  console.log(!Object.is(data_calender[0].origin_name, null))
  let route_name = (data_calender[0].origin_name !== undefined && Object.is(data_calender[0].origin_name, null) ===  false) ? `${useXmltag("FlightsFromOrigin")}   ${data_calender[0].origin_name} ${useXmltag("On")} ${data_calender[0].destination_name} ` : ''
  let header = `
               <div class="modal-header">
                  <h5 class="_100 text-right modal-title" id="exampleModalScrollableTitle">${route_name} </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
               </div>
       `;
  data_calender.forEach(function(value, index) {
    console.table(value)
    let div_price = (value.price_final != "") ? ` <span class=" flitght-price-price-info"> ${useXmltag("Startprice")} </span><div class="flitght-price-date flitght-price-price-info">${value.price_final}</div> ` :
       `<div class="flitght-price-date flitght-price-price-info">جستجو کنید</div>`;
    content_modal_main += `
           <div class="flight-modal-items">
              <a href="${value.link}" class="flight-price-item flight-price-item-tag-a">
                <div class="flitght-price-price">
                    <span class=" ">${value.date_for_show}</span>
                    ${div_price}
                </div>
               </a>
           </div>
         `;
  })
  return {content_modal_main,header}
}

















// function item_template(data_calender) {
//   let content_modal_main = '' ;
//   console.log(!Object.is(data_calender[0].origin_name, null))
//   let route_name = (data_calender[0].origin_name !== undefined && Object.is(data_calender[0].origin_name, null) ===  false) ? `${useXmltag("FlightsFromOrigin")}   ${data_calender[0].origin_name} ${useXmltag("On")} ${data_calender[0].destination_name} ` : ''
//   let header = `
//                <div class="modal-header">
//                   <h5 class="_100 text-right modal-title" id="exampleModalScrollableTitle">${route_name} </h5>
//                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//                       <span aria-hidden="true">×</span>
//                   </button>
//                </div>
//        `;
//   data_calender.forEach(function(value, index) {
//     console.table(value)
//     let div_price = (value.price_final != "") ? ` <span class=" flitght-price-price-info"> ${useXmltag("Startprice")} </span><div class="flitght-price-date flitght-price-price-info">${value.price_final}</div> ` :
//       `<span class="void-space flitght-price-price-info"></span><div class="flitght-price-date flitght-price-price-info">${useXmltag("CompletionCapacity")}</div>`;
//     content_modal_main += `
//            <div class="flight-modal-items">
//               <a href="${value.url}" class="flight-price-item flight-price-item-tag-a">
//                 <div class="flitght-price-price">
//                     <span class=" ">${value.date_for_show}</span>
//                     ${div_price}
//                 </div>
//                </a>
//            </div>
//          `;
//   })
//   return {content_modal_main,header}
// }

function calenderFlightSearch(origin,destination) {

  $('.modal-calender-js').hide();
  $('.modal-calender-js').show();

  let content_modal_fake='' ;
  let header = `
  <div class="modal-header">
    <h5 class="_100 text-right modal-title void-space mr-0 ph-item modal-title-header-js" id="exampleModalScrollableTitle">
     </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div>`;
  for (let i = 0; i <= 14; i++) {
    content_modal_fake += `
              <div class="flight-modal-items">
                <a href="javascript:" class="flight-price-item flight-price-item-tag-a ph-item">
                  <div class="flitght-price-price">
                    <span class="pt-0 pb-2">
                      <div class="void-space col-6 ph-item"></div>
                    </span>
                    <span class="void-space flitght-price-price-info flitght-price-price-info-none"></span>
                    <div class="flitght-price-date void-space flitght-price-price-info"></div>
                  </div>
                </a>
              </div>
`;
  }
  let modal_fake = templateFake(content_modal_fake,header)

  $('.modal-content-js').html(modal_fake);

  let data_calender ;
  $.ajax({
    type: "POST",
    url: amadeusPathByLang + "ajax",
    dataType: "json",
    data: JSON.stringify({
      className: "newApiFlight",
      method: "getOfflinePriceFlight",
      origin,
      destination ,
      origin_name:true,
      is_json: true,
      limit: 15,
    }),
    success: function (response) {
      $('.modal-content-js').html(' ');

      data_calender = response.data
      data_calender = Object.values(data_calender)
      data_calender = data_calender.slice(0, 15);
      let modal_fake_item = item_template(data_calender)
      let modal_fake = templateFake(modal_fake_item.content_modal_main,modal_fake_item.header);
      $('.modal-content-js').html(modal_fake);
    },
    error: function (error) {
      console.log(error.responseJSON.data)

      data_calender = error.responseJSON.data ;
      let modal_fake_item = item_template(data_calender)
      let modal_fake = templateFake(modal_fake_item.content_modal_main,modal_fake_item.header);
      $('.modal-content-js').html(modal_fake);
    },
  })
}

function submitNewsLetter_old() {

  let full_name = $('.full-name-js').val();
  let email = $('.email-js').val();
  let mobile = $('.mobile-js').val();
  let has_capcha = $('.has-capcha').val();
  let capcha = $('.capcha-js').val();

  if (has_capcha=='1') {
    $.post(amadeusPath + 'captcha/securimage_check.php',
      {
        captchaAjax: $('#item-captcha').val()
      },
      function(data) {
        // console.log(data)
        if (data == true) {
          if (full_name === "" && (email === "" || mobile === "")) {

            $.alert({
              title: 'ثبت اطلاعات خبر نامه',
              icon: "fa fa-cart-plus",
              content: 'پر کردن همه فیلدها الزامی است',
              rtl: true,
              type: "red",
            })
            return false;
          }
          if (!validateEmail(email)) {

            $.alert({
              title: 'ثبت اطلاعات خبر نامه',
              icon: "fa fa-cart-plus",
              content: 'فرمت ایمیل نادرست است ',
              rtl: true,
              type: "red",
            })
            return false;
          }
          if (!validateMobile(mobile)) {

            $.alert({
              title: 'ثبت اطلاعات خبر نامه',
              icon: "fa fa-cart-plus",
              content: 'شماره موبایل معتبر نمی باشد',
              rtl: true,
              type: "red",
            })
            return false;
          }
          let data_send = {
            'full_name': full_name,
            'email': email,
            'mobile': mobile
          }
          $('.news-letter-js').prop("disabled", true);
          $.ajax({
            type: "POST",
            url: amadeusPath + "ajax",
            dataType: "json",
            data: JSON.stringify({
              method: "registerGuestUser",
              className: "members",
              full_name: data_send.full_name,
              email: data_send.email,
              mobile: data_send.mobile
            }),
            success: function(response) {
              $('.Newsletters-btn').prop("disabled", false);
              if (response) {
                $.alert({
                  title: 'ثبت اطلاعات خبر نامه',
                  icon: "fa fa-cart-plus",
                  content: 'اطلاعات شما با موفقیت ثبت شد.',
                  rtl: true,
                  type: "green",
                })
                $('.full-name-js').val("");
                $('.email-js').val("");
                $('.mobile-js').val("");
              } else {
                $.alert({
                  title: 'ثبت اطلاعات خبر نامه',
                  icon: "fa fa-cart-plus",
                  content: 'خطا، در ثبت اطلاعات شما خطایی رخ داد',
                  rtl: true,
                  type: "red",
                })
              }
            }
          });
        } else {
          reloadCaptcha();
          $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: 'fa fa-warning',
            content: useXmltag("WrongSecurityCode"),
            rtl: true,
            type: 'red'
          });
          return false;
        }
      });
  }else {



    if ( full_name === "" && (email === "" || mobile === "" )) {

      $.alert({
        title: 'ثبت اطلاعات خبر نامه',
        icon: "fa fa-cart-plus",
        content: 'پر کردن همه فیلدها الزامی است',
        rtl: true,
        type: "red",
      })
      return false;
    }

    if (!validateEmail(email)) {

      $.alert({
        title: 'ثبت اطلاعات خبر نامه',
        icon: "fa fa-cart-plus",
        content: 'فرمت ایمیل نادرست است ',
        rtl: true,
        type: "red",
      })
      return false;
    }
    if (!validateMobile(mobile)) {

      $.alert({
        title: 'ثبت اطلاعات خبر نامه',
        icon: "fa fa-cart-plus",
        content: 'شماره موبایل معتبر نمی باشد',
        rtl: true,
        type: "red",
      })
      return false;
    }
    let data_send ={
      'full_name': full_name,
      'email' : email,
      'mobile': mobile
    }
    $('.news-letter-js').prop("disabled", true);
    $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
        method: "registerGuestUser",
        className: "members",
        full_name: data_send.full_name,
        email: data_send.email,
        mobile:data_send.mobile
      }),
      success: function(response) {
        $('.Newsletters-btn').prop("disabled", false);
        if (response) {
          $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: "fa fa-cart-plus",
            content: 'اطلاعات شما با موفقیت ثبت شد.',
            rtl: true,
            type: "green",
          })
          $('.full-name-js').val("");
          $('.email-js').val("");
          $('.mobile-js').val("");
        } else {
          $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: "fa fa-cart-plus",
            content: 'خطا، در ثبت اطلاعات شما خطایی رخ داد',
            rtl: true,
            type: "red",
          })
        }
      }
    });



  }


}

function submitNewsLetter() {

  let full_name = $('.full-name-js').val();
  let email = $('.email-js').val();
  let mobile = $('.mobile-js').val();
  let has_capcha = $('.has-capcha').val();
  let capcha = $('.capcha-js').val();

  if (has_capcha=='1') {
    $.post(amadeusPath + 'captcha/securimage_check.php',
      {
        captchaAjax: $('#item-captcha').val()
      },
      function(data) {
        // console.log(data)
        if (data == true) {
          if (full_name === "" && (email === "" || mobile === "")) {

            $.alert({
              title: 'ثبت اطلاعات خبر نامه',
              icon: "fa fa-cart-plus",
              content: 'پر کردن همه فیلدها الزامی است',
              rtl: true,
              type: "red",
            })
            return false;
          }
          if (!validateEmail(email)) {

            $.alert({
              title: 'ثبت اطلاعات خبر نامه',
              icon: "fa fa-cart-plus",
              content: 'فرمت ایمیل نادرست است ',
              rtl: true,
              type: "red",
            })
            return false;
          }
          if (!validateMobile(mobile)) {

            $.alert({
              title: 'ثبت اطلاعات خبر نامه',
              icon: "fa fa-cart-plus",
              content: 'شماره موبایل معتبر نمی باشد',
              rtl: true,
              type: "red",
            })
            return false;
          }
          let data_send = {
            'full_name': full_name,
            'email': email,
            'mobile': mobile
          }
          $('.news-letter-js').prop("disabled", true);
          $.ajax({
            type: "POST",
            url: amadeusPath + "ajax",
            dataType: "json",
            data: JSON.stringify({
              method: "registerUserNewsLetter",
              className: "newsLetter",
              full_name: data_send.full_name,
              email: data_send.email,
              mobile: data_send.mobile
            }),
            success: function(response) {
              $('.Newsletters-btn').prop("disabled", false);
              if (response) {
                $.alert({
                  title: 'ثبت اطلاعات خبر نامه',
                  icon: "fa fa-cart-plus",
                  content: 'اطلاعات شما با موفقیت ثبت شد.',
                  rtl: true,
                  type: "green",
                })
                $('.full-name-js').val("");
                $('.email-js').val("");
                $('.mobile-js').val("");
              } else {
                $.alert({
                  title: 'ثبت اطلاعات خبر نامه',
                  icon: "fa fa-cart-plus",
                  content: 'خطا، در ثبت اطلاعات شما خطایی رخ داد',
                  rtl: true,
                  type: "red",
                })
              }
            }
          });
        } else {
          reloadCaptcha();
          $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: 'fa fa-warning',
            content: useXmltag("WrongSecurityCode"),
            rtl: true,
            type: 'red'
          });
          return false;
        }
      });
  }else {



    if ( full_name === "" && (email === "" || mobile === "" )) {

      $.alert({
        title: 'ثبت اطلاعات خبر نامه',
        icon: "fa fa-cart-plus",
        content: 'پر کردن همه فیلدها الزامی است',
        rtl: true,
        type: "red",
      })
      return false;
    }

    if (!validateEmail(email)) {

      $.alert({
        title: 'ثبت اطلاعات خبر نامه',
        icon: "fa fa-cart-plus",
        content: 'فرمت ایمیل نادرست است ',
        rtl: true,
        type: "red",
      })
      return false;
    }
    if (!validateMobile(mobile)) {

      $.alert({
        title: 'ثبت اطلاعات خبر نامه',
        icon: "fa fa-cart-plus",
        content: 'شماره موبایل معتبر نمی باشد',
        rtl: true,
        type: "red",
      })
      return false;
    }
    let data_send ={
      'full_name': full_name,
      'email' : email,
      'mobile': mobile
    }
    $('.news-letter-js').prop("disabled", true);
    $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
        method: "registerUserNewsLetter",
        className: "newsLetter",
        full_name: data_send.full_name,
        email: data_send.email,
        mobile:data_send.mobile
      }),
      success: function(response) {
        $('.Newsletters-btn').prop("disabled", false);
        if (response) {
          $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: "fa fa-cart-plus",
            content: 'اطلاعات شما با موفقیت ثبت شد.',
            rtl: true,
            type: "green",
          })
          $('.full-name-js').val("");
          $('.email-js').val("");
          $('.mobile-js').val("");
        } else {
          $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: "fa fa-cart-plus",
            content: 'خطا، در ثبت اطلاعات شما خطایی رخ داد',
            rtl: true,
            type: "red",
          })
        }
      }
    });



  }


}

function validateMobile(mob) {
  var mobReg = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
  var error = 0;
  if (mob == "") {
    return false;
  } else if (!mobReg.test(mob)) {
    return false;
  } else {
    return true;
  }
}

function validateEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  var error = 0;
  if (email == "") {
    return false;
  } else if (!emailReg.test(email)) {
    return false;
  } else {
    return true;
  }
}
function shamsiConvertButton() {
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "convertDateShamsi",
      className: "convertDate",
      is_json: true,
    }),
  })
}
function convertJalaliToMiladi() {
  let txtShamsiCalendar = $('#txtShamsiCalendar').val();

  if (txtShamsiCalendar) {

    $.post(amadeusPath + 'user_ajax.php',
      {
        date_jalali: txtShamsiCalendar,
        flag: 'convertDateJalali'
      },
      function (data) {
        $('#showJalaliResult').html(data);
      });
  }
}
function convertMiladiToJalali() {
  var txtMiladiCalendar = $('#txtMiladiCalendar').val();
  if (txtMiladiCalendar) {
    $.post(amadeusPath + 'user_ajax.php',
      {
        date_miladi: txtMiladiCalendar,
        flag: 'convertDateMiladi'
      },
      function (data) {
        $('#showMiladiResult').html(data);
      });
  }
}