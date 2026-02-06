function loadArticles(serviceGroup, position) {
    let articlesList = $('.articles-list ul');
    let stickyArticle = $('.sticky-article');
    if (articlesList.length > 0 && stickyArticle.length > 0) {
        $.ajax({
            url: amadeusPath + 'user_ajax.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                flag: 'articlesList',
                lang: lang,
                service_group: serviceGroup,
                position: position,
            },
            success: function (response) {
                // console.log(response);
                if (response.data != null) {
                    let articles = response.data.articles;
                    if (typeof articles !== 'undefined' && articles.length > 0) {
                        $('.articles-list').removeClass('d-none');
                        $.each(articles, function (index, article) {

                            html = `<li class="article-item">
                <a href="${article.permalink}">
                <img src="${article.feature_image}" alt="${article.title}">
                    <span>${article.title}</span>
                      <i>${article.date}</i>
                    </a>
                </li>`;
                            articlesList.append(html);
                        });
                    }

                    if (typeof response.data.sticky !== 'undefined') {

                        singleHtml = `<div class="single-article">
            <h5 class="single-article-title">${response.data.sticky.title}</h5>
            <img src="${response.data.sticky.feature_image}" alt="${response.data.sticky.title}" />
            <div class="single-article-content">${response.data.sticky.content}</div>
            <a class="morebtn mt1 site-bg-main-color  site-main-button-color-hover" href="${response.data.sticky.permalink}">${useXmltag('ReadMore')}</a>
            </div>`;
                        stickyArticle.append(singleHtml).removeClass('d-none');
                    }else{
                        stickyArticle.addClass('d-none');

                    }
                }
            }
        })
    }
}

function noBack() {
    window.history.forward();
}

/*
function LoginOfPanel2() {

    let $form = ;

    $form.find('input').first().focus();
    console.log($form);
*/


function SubmitSearchTourResult(CityId, CountryId, Date, Name) {
    $('#OnlineTourResultSearchBox').val(Name);
    var domain = $("#OnlineTourResultBase").attr('data-action');
    var url = domain + "/resultTourLocal/1-1/" + CountryId + "-" + CityId + "/" + Date + "/all";
    // window.open = (url);
    window.open(url, '_blank');
}




function loadingToggle(_this,status=true) {
    console.log(_this);
    let loading_target=_this;

    let loading_title=useXmltag(loading_target.attr('data-loading-title'));
    let loading_inner_html=loading_target.html();

    if(status){
        loading_target.addClass("skeleton").prop("disabled",true);
        if(loading_target.is('[data-loading-title]')){
            loading_target.attr('data-last-loading-title',loading_inner_html)
            loading_target.html(loading_title)
        }
    }else{
        loading_target.removeClass("skeleton").prop("disabled",false)
        if(loading_target.is('[data-last-loading-title]')){
            loading_target.html(loading_target.attr('data-last-loading-title'))
        }
    }

    // $(document).ajaxStart(function() {
    //     console.log('ajaxStart')
    //     $(document).bind();
    //     console.log('bind')
    //     loading_target.addClass("skeleton").attr("disabled", true)
    //     console.log('added Class')
    //     if(loading_target.is('[data-loading-title]')){
    //         loading_target.html(loading_title)
    //     }
    // }).ajaxStop(function() {
    //     $(document).unbind();
    //     loading_target.removeClass("skeleton").removeAttr("disabled").html(loading_inner_html)
    // });


}
function validateMobileOrEmail(inputValue) {
    const mobileRegex = /^09\d{9}$/;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Check if the input matches either the mobile regex or email regex
    return mobileRegex.test(inputValue) || emailRegex.test(inputValue);
}
function validateEmail(inputValue) {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(inputValue);
}
function validateMobile(inputValue) {
    const mobileRegex = /^[0-9]{11}$/;
    return mobileRegex.test(inputValue);
}


$(document).ready(function () {
    checkMemberCredit();
    $('body').on('keyup', '.UniqPassportNumber', function(e) {
        let check_iranian = $(this).parent().parent().parent().find('.nationalityChange:checked').val();
        if (check_iranian === '0') {
            let input_value = $(this).val(); // Get the current value of the input field
            let char_count = input_value.length;
            let first_char = input_value.charAt(0);
            // Get the count of characters

            // if(!/[a-zA-Z]/.test(first_char)){
            //     $(this).parent().parent('.panel-body-change').find('.alert_msg').html(useXmltag("IranianPassportIncorrectFormat"));
            //     $(this).css('border','1px solid #B20202')
            // }
            // else
            if(char_count > 10 ){
                $(this).parent().parent('.panel-body-change').find('.alert_msg').html(useXmltag("IranianPassportIncorrectFormat"));
                $(this).css('border','1px solid #B20202')
            }else{
                $(this).parent().parent('.panel-body-change').find('.alert_msg').html('');
                $(this).css('border','1px solid #ccc')
            }
        }



    });


    $('body').on('click','.loading_on_click',function(e){
        loadingToggle($(this))
    })

    $('.show-box-login-js').on('click',function(e) {
        e.stopPropagation()
        $('.show-content-box-login-js').toggle();
    })
    $('body').click(function () {
        $('.main-navigation__sub-menu2').hide();
    });

    $('.owl-pages-search').owlCarousel({
        nav:false,
        dots:false,
        rtl:true,
        loop:true,
        margin:10,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed:3000,
        responsive:{
            0:{
                items:1,
                nav:false,
            },
            600:{
                items:2,
                nav:false,
            },
            1000:{
                items:3,
                nav:false,
            }
        }
    });
    // /**@class init-loading  */
    /*$('body').on('click','.init-loading',function(e){
        $(this).bind();

        console.log('clicked')

        let loading_target=$(this);

        let loading_title=useXmltag(loading_target.attr('data-loading-title'));
        let loading_inner_html=loading_target.html();


        console.log(loading_target)



        $(document).ajaxStart(function() {

            console.log('ajaxStart')
            // console.log('bind')
            // loading_target.addClass("skeleton").attr("disabled", true)
            // console.log('added Class')
            // if(loading_target.is('[data-loading-title]')){
            //     loading_target.html(loading_title)
            // }
        })
          .ajaxSend(function() {

              console.log('ajaxSend')
              // console.log('bind')
              // loading_target.addClass("skeleton").attr("disabled", true)
              // console.log('added Class')
              // if(loading_target.is('[data-loading-title]')){
              //     loading_target.html(loading_title)
              // }
          }).ajaxStop(function() {
            $(this).unbind();

            console.log('ajaxStop')
            // loading_target.removeClass("skeleton").removeAttr("disabled").html(loading_inner_html)
        });


    });*/






    if(getCookie('pwa-app')){
        let sum_heights=0;
        let key=0;
        $($('.main-fixed-bottom-js').get().reverse()).each(function () {
            sum_heights = sum_heights + $(this).height()
            if($($('.main-fixed-bottom-js').get().reverse()[key+1]).length){
                $($('.main-fixed-bottom-js').get().reverse()[key+1])
                   .css({"margin-bottom":sum_heights+'px'})
            }
            key=key+1;
        })
        // $('body').css({"margin-bottom":sum_heights+20+'px'})
    }

    ChangePriceStepFinalInput = $('#ChangePriceStepFinal');
    if(ChangePriceStepFinalInput.length > 0){
        ChangePriceStepFinalInput.on('keyup',function(){

            let input_val = $(this).val().replace(/,/g, '');
            $(this).val(number_format(input_val));

        })
    }

    $('.select2_sex').select2();
    $('body').on('click', '.research_Hotel ', function () {
        $('.filtertip_hotel_researh').fadeToggle();
        $('.filterBox_external_hotel').fadeToggle();
        $('.research_Hotel').toggleClass('close-hotel-research');


    })


    $('body').delegate("#OnlineTourResultSearchBox", 'keyup', function (e) {
        var thiss = $(this);
        var Code = thiss.val();
        $('#ListOnlineTourResult').html('');
        $('#ListOnlineTourResult').addClass('d-none');
        if (Code.length >= 3) {
            thiss.addClass('running');
            thiss.parent().find('.LoadingInputStyle').removeClass('d-none');
            $("#loaderSearch").show();
            $.post(amadeusPath + 'user_ajax.php',
               {
                   Code: Code,
                   Type: 'origin',
                   flag: 'OnlineSearchTourCity',
               },
               function (response) {
                   setTimeout(function () {

                       $('#ListOnlineTourResult').removeClass('d-none');
                       $('#ListOnlineTourResult').html('');
                       if (response != "") {
                           $('#ListOnlineTourResult').append(response);

                       } else {
                           $('#ListOnlineTourResult').append('<li>موردی یافت نشد</li>');
                       }
                       thiss.parent().find('.LoadingInputStyle').addClass('d-none');
                   }, 1000);
               });
        } else {
            $('#ListOnlineTourResult').append('<li>حداقل سه حرف وارد کنید</li>');
        }

    });


    $('body').click(function () {
        $('#ListOnlineTourResult').addClass('d-none');
    });


    if ($(window).width() < 990) {
        $('body').on('click', '.filter_search_mobile', function (e) {
            e.stopPropagation();

        });
        $('body').on('click', '.s-u-close-filter', function () {

            $('#s-u-filter-wrapper-ul').css('left', '-500px').css('opacity', '0');
            $('.hotels_filter_search').css('left', '-500px').css('opacity', '0');
            $('.filterBox_external_hotel').css('left', '-500px').css('opacity', '0');

        });
        $('body').on('click', '.filter_search_mobile_res', function (e) {

            $('#s-u-filter-wrapper-ul').css('left', '0').css('opacity', '1');
            e.stopPropagation();
        });
        $('body').on('click', '.filter_search_holel', function (e) {

            $('.hotels_filter_search').css('left', '0').css('opacity', '1');
            $('.filterBox_external_hotel').css('left', '0').css('opacity', '1');
            e.stopPropagation();

        });

        $('body').on('click', '.filter_search_train', function (e) {

            $('#s-u-filter-wrapper-ul').css('left', '0').css('opacity', '1');
            e.stopPropagation();

        });
        $('body').on('click', '#s-u-filter-wrapper-ul', function (e) {

            e.stopPropagation();

        });


        $('body').on('click', function () {
            $('#s-u-filter-wrapper-ul').css('left', '-500px').css('opacity', '0');
            $('.filterBox_external_hotel').css('left', '-500px').css('opacity', '0');
        })
    }

    $('.bank-logo1 input').on('click', function () {

        $('.tick_bank').css('display', 'none');
        $('.bank-logo1').removeClass('active_bank');

        $(this).parents('.bank_logo_c').find('.tick_bank').css('display', 'block');
        $(this).parents('.bank-logo1').addClass('active_bank');


    });
    $('.bank-logo1:first-child').addClass('active_bank');

    var wiwindow = $(window).width();

    $('.more_di_n').click(function () {

        $('.more_di_n i').toggleClass('mdi-arrow-up-thick')

        $('.detial_res_mos').toggle();
        $('.detial_res_mos_parent').toggleClass('mos_parent_min_440');
    });

    $.validator.methods.email = function (value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }
    $.validator.methods.phone = function (value, element) {
        return this.optional(element) || /^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,6}$/.test(value);
    }

    $('#login-gds-page').validate({
        rules: {
            'signin-email2': {
                required: true,
                validateMobileOrEmail: true
            },
            'signin-password2': {
                required: true,
                //   minlength: 4,
                maxlength: 50
            },
            'signin-captcha2': {
                required: true,
                minlength: 1,
                maxlength: 5
            }
        },
        messages: {
            'signin-email2': {
                'required': useXmltag("PleaseEnterMobileOrEmail"),
            },
            'signin-password2': {
                'required': useXmltag("Enterpassword"),
                //     'minlength' : 'رمز عبور باید بیش از ۶ حرف یا عدد باشد',
                'maxlength': useXmltag("Passwordenteredlong")
            },
            'signin-captcha2': {
                'required': useXmltag("Entersecuritycode"),
                'minlength': useXmltag("Enteredsecuritycodeshort"),
                'maxlength': useXmltag("Securitycodeenteredlong")
            }
        },
        submitHandler: function (form) {
            $("#error-signin-captcha2").html('');
            var email = $("#signin-email2").val();
            var pass = $("#signin-password2").val();
            var remember = $("#remember-me2:checked").val();
            var is_app = $("#is_app").val();
            var captcha = $("#signin-captcha2").val();
            if (remember == 'checked' || remember == 'on' || remember == 'true') {
                remember = 'on';
            } else {
                remember = 'off';
            }
            var organization = '';
            if ($('#signin-organization2').length > 0) {
                organization = $('#signin-organization2').val();
            }
            $.post(amadeusPath + 'captcha/securimage_check.php',

               {captchaAjax: $('#signin-captcha2').val()},

               function (response) {
                   if (response) {
                       reloadCaptcha();
                       $.post(amadeusPath + 'user_ajax.php',
                          {
                              entry: email,
                              remember: remember,
                              password: pass,
                              organization: organization,
                              setcoockie: "yes",
                              App: is_app,
                              flag: 'memberLogin'
                          },
                          function (data) {

                              if (data == 'limitCount') {
                                  $.alert({
                                      title: useXmltag("Login"),
                                      icon: 'fa fa-sign-in',
                                      content: useXmltag("limitCountRequest"),
                                      rtl: true,
                                      type: 'red'
                                  });
                              }
                              if (data == 'optExpired') {
                                  $.alert({
                                      title: useXmltag("Login"),
                                      icon: 'fa fa-sign-in',
                                      content: useXmltag("optExpired"),
                                      rtl: true,
                                      type: 'red'
                                  });
                              }else {
                                  var result = data.split(':');

                                  if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                                      $.alert({
                                          title: useXmltag("Userlogin"),
                                          icon: 'fa fa-sign-in',
                                          content: useXmltag("Loginsuccessfully"),
                                          rtl: true,
                                          type: 'green'
                                      });
                                      $(".cd-user-modal").trigger("click");
                                      $('.full-width').css('opacity', '0.5').text(useXmltag("Sendinginformation"));
                                      setTimeout(function () {
                                          console.log(rootMainPath)
                                          const urlParams = new URLSearchParams(window.location.search);
                                          const referrer = urlParams.get('referrer');
                                          if(referrer){
                                              window.location.href = amadeusPathByLang + referrer;
                                          }else{
                                              console.log('1')
                                              if(lang == 'fa'){

                                                  window.location.href = clientMainDomain;
                                              }else {
                                                  console.log('2')
                                                  // if(default_lang == 'en'){
                                                  window.location.href = rootMainPath + '/' + lang ;
                                                  // }else {
                                                  //     window.location.href = clientMainDomain + '/' + lang;
                                                  // }

                                              }
                                              // console.log('clientIndexDomain',clientIndexDomain)


                                              /*  switch (result[1]) {

                                                    case 'reservationTourAuth':
                                                        window.location.href = amadeusPathByLang + 'tourList';
                                                        break;
                                                    case 'AccessTourWithOutCounter':
                                                        window.location.href = amadeusPathByLang + 'userProfile';
                                                        break;
                                                    case 'ticketAccess':
                                                        window.location.href = amadeusPathByLang + 'topRouteFlight';
                                                    default:
                                                        window.location.href = amadeusPathByLang + 'userProfile';
                                                        break;
                                                }*/
                                          }
                                      }, 1000);
                                  } else {

                                      $("#signin-email2").attr("data-login", "1");
                                      $(".gds-login-error-box").removeClass('gds-login-error-none');
                                      $(".message-login").html(useXmltag("Emailenteredpasswordincorrect"));
                                      $('html, body').animate({
                                          scrollTop: ($('#signin-email2').offset().top - 150)
                                      }, 500);
                                      $("#signin-email2").focus();
                                      $("#signin-captcha2").val('');
                                      $("#signin-password2").val('');

                                  }
                              }
                          })
                   } else {
                       $("#register_submit").val(useXmltag("SetAccount"));
                       $(".gds-login-error-box").removeClass('gds-login-error-none');
                       $("#register_submit").removeClass('waiting_register');
                       reloadCaptcha();
                       $("#signin-captcha2").focus();
                       $("#signin-captcha2").val('');
                       $(".message-login").html('');

                       $("#error-signin-captcha2").html(useXmltag("WrongSecurityCode"));
                       $("#error-signin-captcha2").css("opacity", "1");
                       $("#error-signin-captcha2").css("visibility", "visible");
                       return false;
                   }


               });
        }
    });

    $.validator.addMethod("validateMobileOrEmail", function(value, element) {
        return this.optional(element) || validateMobileOrEmail(value);
        // Return true if the value is valid, false otherwise
    },useXmltag("PleaseEnterMobileOrEmail"));

    $.validator.addMethod("validateMobileForFaAndEmailForEn", function(value, element) {
        if(lang==='fa'){
            return this.optional(element) || validateMobile(value);
        }
        return this.optional(element) || validateEmail(value);
        // Return true if the value is valid, false otherwise
    },useXmltag("PleaseEnterUserEntry"));

    $('#registers-gds-form').validate({
        rules: {
            'signup-name2': {
                required: true,
                maxlength: 255
            },
            'signup-family2': {
                required: true,
                maxlength: 255
            },
            'signup-mobile2': {
                required: true,
                validateMobileForFaAndEmailForEn: true
            },
            'signup-password2': {
                required: true,
                minlength: 8,
                maxlength: 255
            },
            /*            'signin-password2' : {
                            required : true,
                            //   minlength: 4,
                            maxlength : 50
                        },*/
            'signup-captcha2': {
                required: true,
                //   minlength: 4,
                maxlength: 5
            }
        },
        messages: {
            'signup-name2': {
                'required': useXmltag("PleaseenterName"),
                'maxlength': useXmltag("LongNameError")
            },
            'signup-family2': {
                'required': useXmltag("PleaseenterLastName"),
                'maxlength': useXmltag("LongLastNameError")
            },
            'signup-mobile2': {
                'required': useXmltag("PleaseEnterUserEntry"),
                'phone': useXmltag("PhoneNumberError"),
                'maxlength': useXmltag("LongPhoneNumberError")
            },
            'signup-email2': {
                'required': useXmltag("PleaseEnterMobileOrEmail"),
            },
            /*            'signin-password2' : {
                            'required' : useXmltag("Enterpassword"),
                            //     'minlength' : 'رمز عبور باید بیش از ۶ حرف یا عدد باشد',
                            'maxlength' : 'رمز عبور وارد شده طولانی است'
                        },*/
            'signup-captcha2': {
                'required': useXmltag("Entersecuritycode"),
                //     'minlength' : 'رمز عبور باید بیش از ۶ حرف یا عدد باشد',
                'maxlength': useXmltag('WrongSecurityCode')
            }
        },
        submitHandler: function (form) {
            loadingToggle($('#register_submit'));
            $('.gds-login-error-box').addClass('gds-login-error-none');

            $("#error-signin-captcha2").html('').css("opacity", "0").css("visibility", "hidden");

            var name = $("#signup-name2").val();
            var family = $("#signup-family2").val();
            var mobile = $("#signup-mobile2").val();
            var password = $("#signup-password2").val();
            // var email = $("#signup-email2").val();
            var reagentCode = $("#reagent-code2").val();

            $.post(amadeusPath + 'captcha/securimage_check.php',
               {captchaAjax: $('#signup-captcha2').val()},
               function (data) {
                   loadingToggle($('#register_submit'),false);
                   if (data == true) {
                       reloadCaptcha();
                       $.post(amadeusPath + 'user_ajax.php',
                          {
                              name: name,
                              family: family,
                              entry: mobile,
                              password: password,
                              reagentCode: reagentCode,
                              setcoockie: "yes",
                              flag: 'memberRegister'
                          },
                          function (response) {
                              // console.log(response);
                              jsonResponse = JSON.parse(response);
                              // console.log(jsonResponse);
                              // result = JSON.stringify(response);
                              if(jsonResponse.success){
                                  let redirect_url = jsonResponse.redirect_url ? jsonResponse.redirect_url :  amadeusPathByLang + "userProfile";
                                  $.alert({
                                      title: useXmltag("Userlogin"),
                                      icon: 'fa fa-cart-plus',
                                      content: jsonResponse.message,
                                      rtl: true,
                                      type: 'green'
                                  });
                                  $(".cd-user-modal").trigger("click");
                                  $('.full-width').css('opacity', '0.5').text(useXmltag("Sendinginformation"));
                                  setTimeout(function () {
                                      // اگر عملیات معلق تور اختصاصی وجود دارد، صفحه فعلی را reload کن
                                      if(localStorage.getItem('pendingExclusiveTourAction')){
                                          window.location.reload();
                                          return;
                                      }

                                      if(redirect_url != ''){
                                          // console.log(redirect_url);
                                          window.location.href = redirect_url;
                                          // window.location.href = amadeusPathByLang + "userProfile";
                                      }else{
                                          window.location.href = amadeusPathByLang + "userProfile";
                                      }
                                  }, 1000);
                              }else {
                                  $.alert({
                                      title: useXmltag("SetAccount"),
                                      icon: 'fa fa-user',
                                      content: jsonResponse.message,
                                      rtl: true,
                                      type: 'red'
                                  });
                                  $(".message-register").html(jsonResponse.message);
                              }

                          })
                   } else {
                       reloadCaptcha();
                       $(".gds-login-error-box").removeClass('gds-login-error-none');
                       $("#signup-captcha2").focus();
                       $("#signup-captcha2").val('');
                       $("#error-signin-captcha2").html(useXmltag("WrongSecurityCode")).css("opacity", "1").css("visibility", "visible");
                       return false;
                   }
               });
        }
    });


    $('#login-gds-popup').validate({
        rules: {
            'signin-email2': {
                required: true,
                validateMobileOrEmail: true
            },
            'signin-password2': {
                required: true,
                maxlength: 50
            }
        },
        messages: {
            'signin-email2': {
                'required': useXmltag("Enteremail"),
                'email': useXmltag("Invalidemail"),
                'maxlength': useXmltag("Emaillong")
            },
            'signin-password2': {
                'required': useXmltag("Enterpassword"),
                'maxlength': useXmltag("Passwordenteredlong")
            }
        },
        submitHandler: function (form) {
            loadingToggle($('#login-submit-btn'));
            $("#error-signin-captcha2").html('');

            var useType = $("#useType").val();
            var email = $("#signin-email2").val();
            var pass = $("#signin-password2").val();
            var remember = $("#remember-me2:checked").val();
            if (remember == 'checked' || remember == 'on' || remember == 'true') {
                remember = 'on';
            } else {
                remember = 'off';
            }
            var organization = '';
            if ($('#signin-organization2').length > 0) {
                organization = $('#signin-organization2').val();
            }
            var EntertainmentId = '';
            if ($('#EntertainmentId').length > 0) {
                EntertainmentId = $('#EntertainmentId').val();
            }


            $.post(amadeusPath + 'user_ajax.php',
               {
                   entry: email,
                   remember: remember,
                   password: pass,
                   organization: organization,
                   setcoockie: "yes",
                   flag: 'memberLogin'
               },
               function (data) {

                   if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                       // $(".cd-user-modal").trigger("click");

                       popupLogin(useType, EntertainmentId);

                   } else {
                       loadingToggle($('#login-submit-btn') , false);


                       /* $.post(amadeusPath + 'user_ajax.php',
                           {
                               email: email,
                               remember: remember,
                               password: pass,
                               flag: 'agencyLogin'
                           },
                           function (res) {
                               if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
                                   // $(".cd-user-modal").trigger("click");

                                   popupLogin(useType, EntertainmentId);

                               } else {
                                   $("#signin-email2").attr("data-login", "1");
                                   $(".gds-login-error-box").removeClass('gds-login-error-none');
                                   $(".message-login").html(useXmltag("Emailenteredpasswordincorrect"));
                                   $('html, body').animate({
                                       scrollTop: ($('#signin-email2').offset().top - 150)
                                   }, 500);
                               }
                           })*/
                       $("#signin-email2").attr("data-login", "1");
                       $(".gds-login-error-box").removeClass('gds-login-error-none');
                       $(".message-login").html(useXmltag("Emailenteredpasswordincorrect"));
                       $('html, body').animate({
                           scrollTop: ($('#signin-email2').offset().top - 150)
                       }, 500);
                   }
               })

        }
    });

    $('#loginAgencyForm').validate({
        rules: {
            'signin-email2': {
                required: true,
                // email: true,
                maxlength: 255
            },
            'signin-password2': {
                required: true,
                //   minlength: 4,
                maxlength: 50
            },
            'signin-captcha2': {
                required: true,
                minlength: 1,
                maxlength: 5
            }
        },
        messages: {
            'signin-email2': {
                'required': useXmltag("Enteremail"),
                'email': useXmltag("Invalidemail"),
                'maxlength': useXmltag("Emaillong")
            },
            'signin-password2': {
                'required': useXmltag("Enterpassword"),
                //     'minlength' : 'رمز عبور باید بیش از ۶ حرف یا عدد باشد',
                'maxlength': useXmltag("Passwordenteredlong")
            },
            'signin-captcha2': {
                'required': useXmltag("Entersecuritycode"),
                'minlength': useXmltag("Enteredsecuritycodeshort"),
                'maxlength': useXmltag("Securitycodeenteredlong")
            }
        },
        submitHandler: function (form) {
            $("#error-signin-captcha2").html('');
            var email = $("#signin-email2").val();
            var pass = $("#signin-password2").val();
            var remember = $("#remember-me2:checked").val();
            var captcha = $("#signin-captcha2").val();
            if (remember == 'checked' || remember == 'on' || remember == 'true') {
                remember = 'on';
            } else {
                remember = 'off';
            }

            $.post(amadeusPath + 'captcha/securimage_check.php',

               {captchaAjax: $('#signin-captcha2').val()},

               function (response) {
                   if (response) {
                       reloadCaptcha();
                       $.post(amadeusPath + 'user_ajax.php',
                          {
                              email: email,
                              remember: remember,
                              password: pass,
                              flag: 'loginAgency'
                          },
                          function (data) {

                              var result = data.split(':');

                              if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                                  $.alert({
                                      title: useXmltag("agencyLogin"),
                                      icon: 'fa fa-sign-in',
                                      content: useXmltag("Loginsuccessfully"),
                                      rtl: true,
                                      type: 'green'
                                  });
                                  $(".cd-user-modal").trigger("click");
                                  $('.full-width').css('opacity', '0.5').text(useXmltag("Sendinginformation"));
                                  setTimeout(function () {
                                      window.location.href = amadeusPathByLang + 'welcomeAgency';
                                  }, 1000);
                              } else {

                                  $.alert({
                                      title: useXmltag("agencyLogin"),
                                      icon: 'fa fa-sign-in',
                                      content: useXmltag("Emailenteredpasswordincorrect"),
                                      rtl: true,
                                      type: 'red'
                                  });
                                  $("#signin-email2").attr("data-login", "1");
                                  $(".gds-login-error-box").removeClass('gds-login-error-none');
                                  // $(".message-login").html(useXmltag("Emailenteredpasswordincorrect"));
                                  $('html, body').animate({
                                      scrollTop: ($('#signin-email2').offset().top - 150)
                                  }, 500);
                                  $("#signin-email2").focus();
                                  $("#signin-captcha2").val('');
                                  $("#signin-password2").val('');

                              }
                          })
                   } else {
                       $("#register_submit").val(useXmltag("SetAccount"));
                       $(".gds-login-error-box").removeClass('gds-login-error-none');
                       $("#register_submit").removeClass('waiting_register');
                       reloadCaptcha();
                       $("#signin-captcha2").focus();
                       $("#signin-captcha2").val('');
                       $(".message-login").html('');

                       $.alert({
                           title: useXmltag("agencyLogin"),
                           icon: 'fa fa-sign-in',
                           content: useXmltag("WrongSecurityCode"),
                           rtl: true,
                           type: 'red'
                       });
                       // $("#error-signin-captcha2").html(useXmltag("WrongSecurityCode"));
                       $("#error-signin-captcha2").css("opacity", "1");
                       $("#error-signin-captcha2").css("visibility", "visible");
                       return false;
                   }


               });
        }
    });

    $(".gds-login-reagent-code > div").click(function () {
        if ($(".gds-login-reagent-code > div input").prop('checked')) {
            $(".gds-login-reagent-code > span").css('display', 'inline-block');
        } else {
            $(".gds-login-reagent-code > span").css('display', 'none');
        }
    });
    $("#room-image-modal").click(function () {
        $(".room-image-modal").css("display", "none");
    });


    if (gdsSwitch == 'factorLocal' || gdsSwitch == 'passengersDetailLocal' || gdsSwitch == 'factorBusTicket' || gdsSwitch == 'passengersDetailBusTicket') {
        noBack();

        if (gdsSwitch == 'passengersDetailLocal') {

            $.ajax({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                data:
                   {
                       flag: 'checkExistSessionHistoryPassenger',
                       checkExist: 'yes'
                   },
                success: function (data) {

                    if (data == true) {
                        $.confirm({
                            title: useXmltag('Formertravelers'),
                            content: useXmltag('FormerTravelersDescription'),
                            type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                tryAgain: {
                                    text: useXmltag('Yess'),
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $.ajax({
                                            type: 'POST',
                                            url: amadeusPath + 'user_ajax.php',
                                            dataType: 'JSON',
                                            data:
                                               {
                                                   flag: 'checkExistSessionHistoryPassenger',
                                               },
                                            success: function (dataPassenger) {


                                                for (var key in dataPassenger) {
                                                    $("#gender" + key + " option[value=" + dataPassenger[key].gender + "]").prop('selected', true);
                                                    $("#nameEn" + key).attr('value', dataPassenger[key].name_en);
                                                    $("#familyEn" + key).attr('value', dataPassenger[key].family_en);
                                                    $("#nameFa" + key).attr('value', dataPassenger[key].name);
                                                    $("#familyFa" + key).attr('value', dataPassenger[key].family);
                                                    $("#birthdayEn" + key).attr('value', dataPassenger[key].birthday);
                                                    $("#birthday" + key).attr('value', dataPassenger[key].birthday_fa);
                                                    $("#NationalCode" + key).attr('value', dataPassenger[key].NationalCode);
                                                    $("#passportCountry" + key).attr('value', dataPassenger[key].passportCountry);
                                                    $("#select2-passportCountry" + key + "-container").html($("#passportCountry" + key + " option:selected").text());
                                                    $("#passportNumber" + key).attr('value', dataPassenger[key].passportNumber);
                                                    $("#passportExpire" + key).attr('value', dataPassenger[key].passportExpire);
                                                }
                                            }
                                        });
                                    }
                                },
                                close: {
                                    text: useXmltag('Nnoo'),
                                    btnClass: 'btn-red',
                                }
                            }
                        });
                    }

                }
            });

        }
    }
    if (gdsSwitch == 'userProfile' || gdsSwitch == 'tourList') {

        SendDataToClub();
    }
    //discount code display
    if ($('input#discount_code').length > 0) {
        $('input#discount_code').change(function () {
            if ($(this).is(":checked")) {
                $(".parent-discount").removeClass("displayiN");
            } else {
                $(".parent-discount").addClass("displayiN");
            }
        });
    }



    $("body").delegate("#priceSortSelectForeign, #timeSortSelectForeign", 'click', function (e) {
        var typeSort = $(this).attr('typeSort');

        var currentPriceSort = $('#currentPriceSort').val();
        var currentTimeSort = $('#currentTimeSort').val();

        var orderSort = '';
        if (typeSort == 'price') {
            $('#currentSort').val('price');

            if (currentPriceSort == 'asc') {
                $('#currentPriceSort').val('desc')

                orderSort = 'desc'
            } else if (currentPriceSort == 'desc') {
                $('#currentPriceSort').val('asc')

                orderSort = 'asc'
            }
        } else if (typeSort == 'time') {
            $('#currentSort').val('time');
            if (currentTimeSort == 'asc') {
                $('#currentTimeSort').val('desc')

                orderSort = 'desc'
            } else if (currentTimeSort == 'desc') {
                $('#currentTimeSort').val('asc')

                orderSort = 'asc'
            }
        }


        var newValueFilterForeign = new Array();
        $.each($("span.tzCBPart"), function (index, element) {
            if ($(this).hasClass('checked')) {
                newValueFilterForeign.push($(this).attr('filtered'));
            }
        });


        var uniqueCodeTicket = $('.detailShow').parents().siblings('div.international-available-item').find('input.uniqueCode').val();

        if ($('#uniqueCode').val() == "") {
            $('#uniqueCode').val(uniqueCodeTicket);
        }


        if (typeof uniqueCodeTicket === 'undefined') {
            uniqueCodeTicket = $('#uniqueCode').val()
        }

        var adult = $('#adult_qty').val();
        var child = $('#child_qty').val();
        var infant = $('#infant_qty').val();
        var lang = $('#lang').val();
        var dept_date = $('#dept_date').val();
        var return_date = $('#return_date').val();
        var origin = $('#origin_local').val();
        var destination = $('#destination_local').val();

        var optionPage = {
            'uniqueCodeTicket': uniqueCodeTicket,
            'FlagFilter': 'filterForeign',
            'adult': adult,
            'child': child,
            'infant': infant,
            'dept_date': dept_date,
            'return_date': return_date,
            'lang': lang,
            'origin': origin,
            'destination': destination,
            'typeSort': typeSort,
            'orderSort': orderSort
        }

        $('.lightboxContainerOpacity').css('display','flex')
        $('#result').html('');
        // selectPage = selectPage+'-'+count;
        $.post(amadeusPath + 'user_ajax.php',
           {
               nameFile: newValueFilterForeign,
               optionPage: optionPage,
               flag: 'nextPageTicketForeign'
           },
           function (data) {
               $('.lightboxContainerOpacity').hide();
               $('#result').html(data);

               if ($('#currentSort').val() == 'price') {
                   $('#priceSortSelectForeign').addClass('sorting-active-color-main');
                   if (orderSort == 'asc') {
                       $('#priceSortSelectForeign').addClass('rotated-icon');
                   }
                   $('#timeSortSelectForeign').removeClass('sorting-active-color-main').removeClass('rotated-icon');
               } else if ($('#currentSort').val() == 'time') {
                   $('#timeSortSelectForeign').addClass('sorting-active-color-main');
                   if (orderSort == 'asc') {
                       $('#timeSortSelectForeign').addClass('rotated-icon');
                   }
                   $('#priceSortSelectForeign').removeClass('sorting-active-color-main').removeClass('rotated-icon');
               }
           });
    });


    //click reserve to revalidate flight and show login popup
    $('body').delegate('.nextStepclass', 'click', function () {

        var adt = $('#adult_qty').val();
        var chd = $('#child_qty').val();
        var inf = $('#infant_qty').val();
        var TypeZoneFlight = $('#TypeZoneFlight').val();
        var Flight = $(this).siblings('.FlightID').val();
        var ReturnFlightID = $(this).siblings('.ReturnFlightID').val();
        var AirlineCode = $(this).siblings('.Airline_Code').val();
        var SourceId = $(this).siblings('.SourceId').val();
        var FlightType = $(this).siblings('.FlightType').val();
        var Capacity = $(this).siblings('#Capacity').val();
        var PrivateM4 = $(this).siblings('.PrivateM4').val();
        var UniqueCode = $(this).siblings('.uniqueCode').val();
        var CurrencyCode = $(this).siblings('.CurrencyCode').val();
        var priceWithoutDiscount = $(this).siblings('.priceWithoutDiscount').val().replace(/,/g, '');
        var userCapacity = (parseInt(adt) + parseInt(chd));
        var MultiWay = $('#MultiWayTicket').val();
        var FlightDirection = $(this).siblings('.FlightDirection').val();
        var CapacityCalculate = userCapacity + 1;
        var FlightReplaced = Flight.replace(/#/g, '');
        var TxtBottun = '';


        var dataArray = [
            {'userCapacity': userCapacity},
            {'Capacity': Capacity},
            {'this': $(this).siblings('.Capacity')}
        ];

// Log the array of objects using console.table
        console.table(dataArray);
        console.log('SourceId ' , SourceId , ' Capacity ' , Capacity)
        if(userCapacity <= Capacity || (SourceId=='14' && Capacity < 1)|| (SourceId=='15' && Capacity < 1)){
            $('#FlightIdSelect').val(Flight);

            if (TypeZoneFlight == 'Local') {
                if (MultiWay != 'TwoWay') {

                    TxtBottun = useXmltag("Selectionflight");
                } else {
                    if (FlightDirection == 'return') {
                        TxtBottun = useXmltag('PickBackFlight');
                    } else {
                        TxtBottun = useXmltag('PickWentFlight');
                    }
                }
            } else {
                TxtBottun = useXmltag("Selectionflight");
            }


            /*        if (MultiWay == 'TwoWay' && FlightDirection == 'return' && SourceId == '8' && $('#selectedDeptSourceId').val() == '8') {

                        $.alert({
                            title: useXmltag("SearchFlight"),
                            icon: 'fa fa-refresh',
                            content: useXmltag("UCantReserveFlightError"),
                            rtl: true,
                            type: 'red'
                        });
                        return false;

                    } else {
                     }*/
            $.ajax({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                data: {
                    flag: 'checkTicketDiscountPrice',
                    AirlineCode: AirlineCode,
                    FlightType: FlightType,
                    Price: priceWithoutDiscount,
                    TypeZoneFlight: TypeZoneFlight,
                    SourceId : SourceId
                },
                success: function (data) {

                    var res = data.split(':');

                    if ((MultiWay == 'OneWay' && res[1] == 'YES') || (MultiWay == 'TwoWay' && (res[1] == 'YES' || $(".selectedTicket .priceSortAdt span").length > 0))) {

                        var payablePrice = parseInt(res[0]);

                        if (MultiWay == 'TwoWay' && FlightDirection == 'return' && TypeZoneFlight == 'Local') {
                            if ($(".selectedTicket .priceSortAdt span").length > 0) {
                                payablePrice = payablePrice + parseInt($(".selectedTicket .priceSortAdt span").html().replace(/,/g, ''));
                            } else {
                                payablePrice = payablePrice + parseInt($(".selectedTicket .priceSortAdt i").html().replace(/,/g, ''));
                            }
                        }

                        // var text = "مایلم بلیط را بدون ثبت نام با قیمت " + number_format(payablePrice) + " خریداری کنم";
                        var text = useXmltag("Purchasewithoutregistration");
                        $('#noLoginBuy').val(text);

                    } else {
                        var text = useXmltag("Purchasewithoutregistration");
                        $('#noLoginBuy').val(text);
                    }
                    FlightReplaced = FlightReplaced.replace('==', '');
                    FlightReplaced = FlightReplaced.replace('=', '');
                    FlightReplaced = FlightReplaced.replace('#', '');
                    console.log('#nextStep_' + FlightReplaced)
                    escapedId = FlightReplaced.replace(/([ !"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~])/g, '\\$1');

                    $('#nextStep_' + escapedId).attr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("Pending"));
                    // $('#nextStep_' + FlightReplaced).attr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("Pending"));
                    console.log('#nextStep_1' )
                    $('#loader_check_' + escapedId).css('opacity', '1').show();
                    console.log('#nextStep_2' )
                    $.ajax({
                        type: 'POST',
                        url: amadeusPath + 'user_ajax.php',
                        dataType: 'JSON',
                        data:
                           {
                               flag: 'revalidate_Fight',
                               adt: adt,
                               chd: chd,
                               inf: inf,
                               Flight: Flight,
                               ReturnFlightID: ReturnFlightID,
                               AirlineCode: AirlineCode,
                               UniqueCode: UniqueCode,
                               SourceId: SourceId,
                               MultiWay: MultiWay,
                               FlightDirection: FlightDirection,
                               CurrencyCode: CurrencyCode,
                               uniq_id: $('.selected_session_filght_Id').val()
                           },
                        success: function (data) {
                            console.log('iiinja-0')
                            console.log(data)

                            if (data.result_status == 'SuccessLogged' || data.result_status == 'SuccessNotLoggedIn') {
                                console.log('iiinja-1')
                                $('#session_filght_Id').val(data.result_uniq_id);
                                $("#ZoneFlight").val(TypeZoneFlight);
                                $('#loader_check_' + escapedId).hide();


                                $('#nextStep_' + escapedId).removeAttr('disabled', true).css('opacity', '1').text(TxtBottun);

                                if (MultiWay == 'TwoWay' && FlightDirection == 'dept' && TypeZoneFlight == 'Local') {
                                    $('.international-available-box.deptFlight').fadeOut(1500);
                                    $('.selectedTicket').addClass('marb10').append(data.result_selected_ticket);
                                    $('html, body').animate({scrollTop: $('.selectedTicket').offset().top}, 3000);

                                    $('.international-available-box.returnFlight').filter(function (index) {
                                        //if dept and return date is the same, return flights filter by dept choose
                                        if ($('#dept_date_local').val() == $('#dept_date_local_return').val()) {
                                            var returnFlightTime = $(this).find('.timeSortDep').html();
                                            return (returnFlightTime.substr(0, 2) > data.result_selected_time && $(this).find('.source').html() != 'reservation');
                                        } else {
                                            return $(this).find('.source').html() != 'reservation';
                                        }
                                    }).fadeIn(1500);

                                } else {
                                    if (data.result_status == 'SuccessLogged') {
                                        if (SmsAllow == '1' || TelAllow == '1') {
                                            var isShowLoginPopup = $('#isShowLoginPopup').val();
                                            var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                            if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                                $("#login-popup").trigger("click");
                                            } else {
                                                console.log('iiinja1')
                                                popupBuyNoLogin(useTypeLoginPopup);
                                            }

                                        } else {
                                            send_info_passengers();
                                        }

                                    } else if (data.result_status == 'SuccessNotLoggedIn') {
                                        var isShowLoginPopup = $('#isShowLoginPopup').val();
                                        var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                        if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                            $("#login-popup").trigger("click");
                                        } else {
                                            console.log('inja12');
                                            popupBuyNoLogin(useTypeLoginPopup);
                                        }
                                    }
                                }
                            } else if (data.result_status == 'Error') {
                                $('#loader_check_' + escapedId).hide();
                                $('#nextStep_' + escapedId).removeAttr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("NonBookable")).css('background', '#A40127');
                                $.alert({
                                    title: useXmltag("SearchFlight"),
                                    icon: 'fa fa-refresh',
                                    content: data.result_message,
                                    rtl: true,
                                    type: 'red'
                                });
                                return false;
                            } else {
                                $('#loader_check_' + escapedId).hide();
                                $('#nextStep_' + escapedId).removeAttr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("NonBookable")).css('background', '#A40127');
                                $.alert({
                                    title: useXmltag("SearchFlight"),
                                    icon: 'fa fa-refresh',
                                    content: useXmltag("CanNotBookedTryLater"),
                                    rtl: true,
                                    type: 'red'
                                });
                                return false;
                            }
                        }
                    });


                }
            });
        }else{
            Swal.fire({
                icon: "error",
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 60000,
                width:600,
                iconColor:"#FFFFFF",
                background:"#2f2f2f",
                title: `<span style="color:#FFFFFF">${useXmltag('lowCapacityPassenger')}</span>`,
            });
        }

    });

    $('body').delegate('.smsRequestTicket', 'click', function () {


        var InfoRequest = $(this).attr('InfoRequest');
        console.log(InfoRequest);

        $("#ModalPublic").fadeIn(900);
        $.post(libraryPath + 'ModalCreator.php',
           {
               Controller: 'RequestTicketOffline',
               Method: 'RequestOffline',
               Param: InfoRequest
           },
           function (data) {

               $('#ModalPublicContent').html(data);

           });

    });

    //sort flights by price
    $("body").delegate("#timeSortSelect, #priceSortSelect", 'click', function (e) {

        $('#timeSortSelect, #priceSortSelect').removeClass('sorting-active-color-main');
        $(this).addClass('sorting-active-color-main');
        if ($(this).hasClass('rotated-icon')) {
            $(this).removeClass('rotated-icon');
        } else {
            $(this).addClass('rotated-icon');
        }

        var selectID = $(this).attr('id');
        var selected = '';
        var currentSelect = '';

        if (selectID == 'timeSortSelect') {
            currentSelect = $('#currentTimeSort').val();
            if (currentSelect == 'asc') {
                $('#currentTimeSort').val('desc');
            } else {
                $('#currentTimeSort').val('asc');
            }
        } else if (selectID == 'priceSortSelect') {
            currentSelect = $('#currentPriceSort').val();
            if (currentSelect == 'asc') {
                $('#currentPriceSort').val('desc');
            } else {
                $('#currentPriceSort').val('asc');
            }
        }

        if (currentSelect == 'asc') {
            selected = 'desc';
        } else {
            selected = 'asc';
        }

        var reservation = 'no';
        var current_flight = '';
        var all_tickets = [];
        var temp = [];
        var current_sort_index = '';
        var key = '';
        var SearchResult = $("#s-u-result-wrapper-ul div.items").find(".showListSort .international-available-box:visible");
        var returnFlights = $("#s-u-result-wrapper-ul div.items").find(".showListSort .international-available-box.returnFlight");
        $("#s-u-result-wrapper-ul div.items").html('');

        SearchResult.each(function (index) {
            current_flight = $(this).parents();

            if (selectID == 'timeSortSelect') {
                current_sort_index = current_flight.find(".timeSortDep").html();
            } else if (selectID == 'priceSortSelect') {
                current_sort_index = current_flight.find(".priceSortAdt i").html();
                current_sort_index = parseInt(current_sort_index.replace(/,/g, ''));
            }

            if (current_flight.find('#typeAppTicket').val() == 'reservation') {
                reservation = 'yes';
            } else {
                reservation = 'no';
            }

            all_tickets.push({
                'content': current_flight.html(),
                'sortIndex': current_sort_index,
                'reservation': reservation
            });


        });

        if ($(".selectedTicket").html() == '') {
            returnFlights.each(function (index) {
                current_flight = $(this).parent();
                all_tickets.push({
                    'content': current_flight.html()
                });
            });
        }

        if (selected == 'asc') {
            for (var i = 0; i < parseInt(all_tickets.length); i++) {
                key = i;
                for (var j = i; j < parseInt(all_tickets.length); j++) {
                    if (all_tickets[j]['sortIndex'] <= all_tickets[key]['sortIndex']) {
                        temp = all_tickets[i];
                        all_tickets[i] = all_tickets[j];
                        all_tickets[j] = temp;
                    }
                }
            }
        }//end if
        else if (selected == 'desc') {
            for (var i = 0; i < parseInt(all_tickets.length); i++) {
                min = all_tickets[i];
                key = i;
                for (var j = i; j < parseInt(all_tickets.length); j++) {
                    if (all_tickets[j]['sortIndex'] >= all_tickets[key]['sortIndex']) {
                        temp = all_tickets[i];
                        all_tickets[i] = all_tickets[j];
                        all_tickets[j] = temp;
                    }
                }
            }
        }//end else if


        //  hamishe aval reservation namayesh bede
        for (var i = 0; i < parseInt(all_tickets.length); i++) {
            min = all_tickets[i];
            key = i;
            for (var j = i; j < parseInt(all_tickets.length); j++) {
                if (all_tickets[j]['reservation'] == 'yes') {
                    temp = all_tickets[i];
                    all_tickets[i] = all_tickets[j];
                    all_tickets[j] = temp;
                }
            }
        }

        setTimeout(function () {
            for (i = 0; i < parseInt(all_tickets.length); i++) {
                //console.log(i + '======' + all_tickets[i]['content']);
                $("#s-u-result-wrapper-ul div.items").append('<div class="showListSort">' + all_tickets[i]['content'] + '</div>');
            }
        }, 100);
    });


    $("body").delegate("#DestinationPortal, #OriginPortal", 'click', function (e) {
        e.stopPropagation();
        $(this).val('');
    });


    $("body").delegate("#OriginPortal", 'keyup', function (e) {

        var Code = $(this).val();
        if($(this).attr('lang') != ''){
            var lang = $(this).attr('lang');
        }else{
            var lang = 'fa';
        }
        $('#LoaderForeignDep').show();
        if (Code.length >= 3) {
            $(".SelectDeparture").show();
            $.post(amadeusPath + 'user_ajax.php',
               {
                   Code: Code,
                   lang:lang,
                   Type: 'origin',
                   flag: 'liveSearchDestination'
               },
               function (response) {
                   setTimeout(function () {
                       $(".SelectDeparture").hide();
                       $('#LoaderForeignDep').hide();
                       if (response != "") {
                           $('#ListAirPort').html(response);
                       } else {
                           $('#ListAirPort').html('<li>' + useXmltag("NothingFound") + '</li>');
                       }
                       $('#ListAirPort').show();

                   }, 10);
               });
        } else {
            $('#ListAirPort').html('<li>' + useXmltag("EnterThreeLetters") + '</li>');
            $('#ListAirPort').show();
        }

    });


    $("body").delegate("#DestinationPortal", 'keyup', function (e) {

        var Code = $(this).val();
        if($(this).attr('lang') != ''){
            var lang = $(this).attr('lang');
        }else{
            var lang = 'fa';
        }
        $('#LoaderForeignReturn').show();
        if (Code.length >= 3) {
            $(".SelectDeparture").fadeIn('slow');
            $.post(amadeusPath + 'user_ajax.php',
               {
                   Code: Code,
                   lang:lang,
                   Type: 'destination',
                   flag: 'liveSearchDestination'
               },
               function (response) {
                   setTimeout(function () {
                       $(".SelectDeparture").fadeOut('slow');
                       $('#LoaderForeignReturn').hide();
                       if (response != "") {
                           $('#ListAirPortRetrun').html(response);
                       } else {
                           $('#ListAirPortRetrun').html('<li>' + useXmltag("NothingFound") + '</li>');
                       }
                       $('#ListAirPortRetrun').show();
                   }, 10);
               });
        } else {
            $('#ListAirPortRetrun').html('<li>' + useXmltag("EnterThreeLetters") + '</li>');
            $('#ListAirPortRetrun').show();
        }

    });



    $('body').click(function(){
        $('#ListAirPort').hide();
        $('#LoaderForeignDep').hide();
        $('#listSearchCity').addClass('displayiN')

        $('#ListAirPortRetrun').hide();
        $('#LoaderForeignReturn').hide();
    })
    //user dashboard menu on top heaer site when user login
    var Dropdown = (function ($) {

        var $body = $('body'),
           $dropdown = $body.find('.dashboard_menu'),
           $trigger = $dropdown.find('button'),
           $list = $dropdown.find('ul'),
           $firstLink = $list.find('li:first a'),
           $lastLink = $list.find('li:last a');

        var init = function () {
            ariaSetup();
            bindEvents();
        }

        var ariaSetup = function () {
            var listId = $list.attr('id');

            $trigger.attr({
                'aria-expanded': 'false',
                'aria-controls': listId
            });

            $list.attr({
                'aria-hidden': true
            });
        }

        var bindEvents = function () {
            $trigger.on('click', toggleDropdown);

            $firstLink.on('keydown', function () {
                if (event.which === 9 && event.shiftKey === false) {
                    return;
                } else if (event.which === 9 && event.shiftKey === true) {
                    toggleDropdown();
                }
            });

            $lastLink.on('keydown', function () {
                if (event.shiftKey)
                    return;
                toggleDropdown();
            });
        }

        var toggleDropdown = function () {
            var hidden = $list.attr('aria-hidden') === 'true' ? false : true,
               expanded = !hidden;

            $trigger.attr('aria-expanded', expanded);
            $list.attr('aria-hidden', hidden);
        }

        return {
            init: init
        }

    })(jQuery);
    Dropdown.init();


    //change nationality of passengers
    $(".nationalityChange").change(function () {
        var nationality = $(this).val();


        if (nationality == '1') {
            //foriegn
            if ($('.box_every_passenger').length > 0) {
                $(this).parents('.box_every_passenger').find('.noneIranian').removeClass('d-none').addClass('d-block');
                $(this).parents('.box_every_passenger').find('.justIranian').removeClass('d-block').addClass('d-none');
                $(this).parents('.box_every_passenger').find('.justIranian').find('input').attr("disabled","disabled");
                $(this).parents('.box_every_passenger').find('.noneIranian').find('input').attr("disabled",false);

            } else {
                $(this).parents('.s-u-passenger-wrapper-change').find('.noneIranian').removeClass('d-none').addClass('d-block');
                $(this).parents('.s-u-passenger-wrapper-change').find('.justIranian').removeClass('d-block').addClass('d-none');
                $(this).parents('.s-u-passenger-wrapper-change').find('.justIranian').find('input').attr("disabled","disabled");
                $(this).parents('.s-u-passenger-wrapper-change').find('.noneIranian').find('input').attr("disabled",false);

            }

        }else {
            //iranian
            if ($('.box_every_passenger').length > 0) {
                $(this).parents('.box_every_passenger').find('.justIranian').removeClass('d-none').addClass('d-block');
                $(this).parents('.box_every_passenger').find('.noneIranian').removeClass('d-block').addClass('d-none');
                $(this).parents('.box_every_passenger').find('.noneIranian').find('input').attr("disabled","disabled");
                $(this).parents('.box_every_passenger').find('.justIranian').find('input').attr("disabled",false);
            } else {
                $(this).parents('.s-u-passenger-wrapper-change').find('.justIranian').removeClass('d-none').addClass('d-block');
                $(this).parents('.s-u-passenger-wrapper-change').find('.noneIranian').removeClass('d-block').addClass('d-none');
                $(this).parents('.s-u-passenger-wrapper-change').find('.noneIranian').find('input').attr("disabled","disabled");
                $(this).parents('.s-u-passenger-wrapper-change').find('.justIranian').find('input').attr("disabled",false);

            }

        }
    });

    $.validator.addMethod(
       'CheckNationalCode',

       function (value, element, requiredValue) {
           return checkCodeMeli(value);
       },
       'Please check National Code input.'
    );

    //add passenger
    $("#PassengersAdd").validate({
        rules: {
            passengerGender: 'required',
            passengerName: 'required',
            passengerFamily: 'required',
            passengerNameEn: 'required',
            passengerFamilyEn: 'required',
            passengerBirthday: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '0';
                    }
                }
            },
            passengerNationalCode: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '0';

                    }

                },
                CheckNationalCode: true

            },
            passengerPassportNumber: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '1';
                    }
                }
            },
            passengerPassportCountry: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '1';
                    }
                }
            },
            passengerPassportExpire: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '1';
                    }
                }
            },
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            /*   if (element.prop("type") === "checkbox") {
                   error.insertAfter(element.parent("label"));
               } else {
                   error.insertAfter(element);
               }*/
        },
        submitHandler: function (form) {
            console.log('sss');
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function (data) {

                    if (data.result_status == 'success') {

                        $.alert({
                            title: useXmltag("NewPassengerRegistration"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'green',
                        });

                        setTimeout(function () {
                            window.location = 'userProfile';
                        }, 1000);

                    } else {

                        $.alert({
                            title: useXmltag("NewPassengerRegistration"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'red',
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


//Update User
    $("#UpdateUserProfile").validate({
        rules: {
            name: 'required',
            family: 'required',
            // name_en: 'required',
            // family_en: 'required',
            telephone: {
                required: true,
                number: true,
                phone: true,
                maxlength: 12
            },
            mobile: {
                required: true,
                number: true,
                phone: true,
                maxlength: 11
            },
            // email: {
            //     email: true,
            //     required: true
            // },
        },
        messages: {
            'name': {
                'required': useXmltag("PleaseEnterNameFa")
            },
            'family': {
                'required': useXmltag("PleaseEnterFamilyFa")
            },
            // 'name_en': {
            //     'required': useXmltag("PleaseEnterNameEn")
            // },
            // 'family_en': {
            //     'required': useXmltag("PleaseEnterFamilyEn")
            // },
            'telephone': {
                'required': useXmltag("PhoneNumbersError"),
                'number': useXmltag("Thefixedtelephonenumberonlycontainsnumber"),
                'phone': useXmltag("cellPhoneNumbersError"),
                'maxlength': useXmltag("LongCellPhoneNumbersError")
            },
            'mobile': {
                'required': useXmltag("PleaseenterPhoneNumber"),
                'number': useXmltag("PhoneNumberError"),
                'phone': useXmltag("PhoneNumberError"),
                'maxlength': useXmltag("PleaseEnterMobile"),

            },
            // 'email': {
            //     'email': useXmltag("Invalidemail")
            // },
        },
        // errorElement: "em",
        // errorPlacement: function (error, element) {
        //     // Add the `help-block` class to the error element
        //     error.addClass("help-block");
        // }

        submitHandler: function (form) {
            // var National_Code = $('#national_code').val();

            // var birth_day_miladi = $('#birth_day_miladi').val();
            // var birth_month_miladi = $('#birth_month_miladi').val();
            // var birth_year_miladi = $('#birth_year_miladi').val();
            // if ((birth_day_miladi != 0 && (birth_month_miladi == 0 || birth_year_miladi == 0))
            // || (birth_month_miladi != 0 && (birth_day_miladi == 0 || birth_year_miladi == 0))
            // || (birth_year_miladi != 0 && (birth_month_miladi == 0 || birth_day_miladi == 0))
            // ) {
            //     $.alert({
            //         title: useXmltag("UpdateProfile"),
            //         icon: 'fa fa-refresh',
            //         content: useXmltag("DateBirthMiladiIsNotValid"),
            //         rtl: true,
            //         type: 'red',
            //     });
            //     error_birth_miladi = 1;
            // }else{
            //     error_birth_miladi = 0;
            // }

            // var birth_day_ir = $('#birth_day_ir').val();
            // var birth_month_ir = $('#birth_month_ir').val();
            // var birth_year_ir = $('#birth_year_ir').val();
            // if ((birth_day_ir != 0 && (birth_month_ir == 0 || birth_year_ir == 0))
            //   || (birth_month_ir != 0 && (birth_day_ir == 0 || birth_year_ir== 0))
            //   || (birth_year_ir != 0 && (birth_month_ir == 0 || birth_day_ir == 0))
            // ) {
            //     $.alert({
            //         title: useXmltag("UpdateProfile"),
            //         icon: 'fa fa-refresh',
            //         content: useXmltag("DateBirthIrIsNotValid"),
            //         rtl: true,
            //         type: 'red',
            //     });
            //     error_birth_ir = 1;
            // }else{
            //     error_birth_ir = 0;
            // }

            // var expire_day_ir = $('#expire_day_ir').val();
            // var expire_month_ir = $('#expire_month_ir').val();
            // var expire_year_ir = $('#expire_year_ir').val();
            // if ((expire_day_ir != 0 && (expire_month_ir == 0 || expire_year_ir == 0))
            //   || (expire_month_ir != 0 && (expire_day_ir == 0 || expire_year_ir== 0))
            //   || (expire_year_ir != 0 && (expire_month_ir == 0 || expire_day_ir == 0))
            // ) {
            //     $.alert({
            //         title: useXmltag("UpdateProfile"),
            //         icon: 'fa fa-refresh',
            //         content: useXmltag("DateExpirationPassportNotValid"),
            //         rtl: true,
            //         type: 'red',
            //     });
            //     error_expire_ir = 1;
            // }else{
            //     error_expire_ir = 0;
            // }

            // var expire_day_miladi = $('#expire_day_miladi').val();
            // var expire_month_miladi = $('#expire_month_miladi').val();
            // var expire_year_miladi = $('#expire_year_miladi').val();
            // if ((expire_day_miladi != 0 && (expire_month_miladi == 0 || expire_year_miladi == 0))
            //   || (expire_month_miladi != 0 && (expire_day_miladi == 0 || expire_year_miladi== 0))
            //   || (expire_year_miladi != 0 && (expire_month_miladi == 0 || expire_day_miladi == 0))
            // ) {
            //     $.alert({
            //         title: useXmltag("UpdateProfile"),
            //         icon: 'fa fa-refresh',
            //         content: useXmltag("DateExpirationPassportNotValid"),
            //         rtl: true,
            //         type: 'red',
            //     });
            //     error_expire_miladi = 1;
            // }else{
            //     error_expire_miladi = 0;
            // }

            // if (National_Code != "") {
            //     if (National_Code.toString().length != 10) {
            //         $.alert({
            //             title: useXmltag("UpdateProfile"),
            //             icon: 'fa fa-refresh',
            //             content: useXmltag("EnteredCationalCodeNotValid"),
            //             rtl: true,
            //             type: 'red',
            //         });
            //         error = 1;
            //     }else {
            //         var NCode = checkCodeMeli(convertNumber(National_Code));
            //         if (!NCode) {
            //             $.alert({
            //                 title: useXmltag("UpdateProfile"),
            //                 icon: 'fa fa-refresh',
            //                 content: useXmltag("EnteredCationalCodeNotValid"),
            //                 rtl: true,
            //                 type: 'red',
            //             });
            //             error = 1;
            //         }else{
            //             var error = '0';
            //         }
            //     }
            // }else{
            //     var error = '0';
            // }
            // if (error == 0 && error_birth_miladi == 0 && error_birth_ir == 0 && error_expire_ir == 0 && error_expire_miladi == 0) {
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function(data) {
                    if (data.result_status == 'success') {
                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'green',
                        });
                        setTimeout(function () {
                            window.location = 'profile';
                        }, 1000);
                    } else {
                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'red',
                        });
                    }
                }
            });
            // }
        },
    });
    //Update User
    $("#UpdateUser").validate({
        rules: {
            name: 'required',
            family: 'required',
            mobile: {
                required: true,
                number: true,
                minlength: 11,
            },
            email: {
                email: true,
                required: true,
            }
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function (data) {

                    if (data.result_status == 'success') {

                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'green',
                        });

                        setTimeout(function () {
                            window.location = 'userProfile';
                        }, 1000);

                    } else {

                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'red',
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
    $("#PassengersAdd").validate({
        rules: {
            passengerGender: 'required',
            passengerName: 'required',
            passengerFamily: 'required',
            passengerNameEn: 'required',
            passengerFamilyEn: 'required',
            passengerBirthday: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '0';
                    }
                }
            },
            passengerNationalCode: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '0';
                    }
                },
                CheckNationalCode: true
            },
            passengerPassportNumber: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '1';
                    }
                }
            },
            passengerPassportCountry: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '1';
                    }
                }
            },
            passengerPassportExpire: {
                required: {
                    depends: function () {
                        return $('input[name=passengerNationality]:checked').val() == '1';
                    }
                }
            },
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            console.log('sss');
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function (data) {

                    if (data.result_status == 'success') {

                        $.alert({
                            title: useXmltag("NewPassengerRegistration"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'green',
                        });

                        setTimeout(function () {
                            window.location = 'userProfile';
                        }, 1000);

                    } else {

                        $.alert({
                            title: useXmltag("NewPassengerRegistration"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'red',
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


    //add agency
    $("#agencyAdd").validate({
        rules: {
            name_fa: 'required',
            managerName: 'required',
            managerFamily: 'required',
            phone: {
                required: true,
                number: true ,
                phone : true
            },
            mobile: {
                required: true,
                number: true,
                minlength: 11
            },
            email: {
                email: true,
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            confirmPass: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            city_iata: 'required',
            address_fa: 'required',
            logoText: 'required',
            licenseText: 'required'
        },
        messages: {
            'name_fa': {
                'required': useXmltag("PleaseenterName")
            },
            'managerName': {
                'required': useXmltag("PleaseenterManagerName")
            },
            'managerFamily': {
                'required': useXmltag("PleaseenterManagerFamily")
            },
            'city_iata': {
                'required': useXmltag("PleaseenterCity")
            },
            'address_fa': {
                'required': useXmltag("PleaseenterAddress")
            },
            'phone': {
                'phone': useXmltag("PhoneNumberError"),
                'number': useXmltag("Thefixedtelephonenumberonlycontainsnumber")
            },
            'mobile': {
                'maxlength': useXmltag("Emaillong"),
                'number': useXmltag("PhoneNumberError")
            },
            'email': {
                'email': useXmltag("Invalidemail")
            }
        },


        submitHandler: function (form) {
            if (!$('#RulsCheck').is(':checked')) {
                $.alert({
                    title: useXmltag("Join"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ConfirmTermsFirst"),
                    rtl: true,
                    type: 'red'
                });
                return false;
            }

            $.post(amadeusPath + 'captcha/securimage_check.php',
               {
                   captchaAjax: $('#signup-captcha2').val()
               },
               function (data) {
                   console.log(data)
                   if (data == true) {
                       reloadCaptcha();

                       $(form).ajaxSubmit({
                           type: 'POST',
                           url: amadeusPath + 'user_ajax.php',
                           success: function (response) {

                               var res = response.split(':');

                               if (response.indexOf('success') > -1) {
                                   var statusType = 'green';
                               } else {
                                   var statusType = 'red';
                               }

                               $.alert({
                                   title: useXmltag("AgencyRegistration"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: statusType
                               });

                               if (response.indexOf('success') > -1) {
                                   setTimeout(function () {
                                       window.location = 'agencyProfile';
                                   }, 1000);
                               }

                           }
                       });

                   } else {
                       reloadCaptcha();
                       $.alert({
                           title: useXmltag("AgencyRegistration"),
                           icon: 'fa fa-refresh',
                           content: useXmltag("WrongSecurityCode"),
                           rtl: true,
                           type: 'red'
                       });
                       return false;
                   }
               });


        },

    });



    $("#UpdateAgency").validate({
        rules: {
            nameFa: 'required',
            nameen: 'required',
            managerName: 'required',
            accountant: 'required',
            phone: {
                required: true,
                number: true
            },
            mobile: {
                required: true,
                number: true,
                minlength: 11
            },
            email: {
                email: true,
                required: true
            },
            addressFa: 'required',
            addressEn: 'required',
        },
        messages: {
            'name_fa': {
                'required': useXmltag("PleaseenterName")
            },
            'managerName': {
                'required': useXmltag("PleaseenterManagerName")
            },
            'managerFamily': {
                'required': useXmltag("PleaseenterManagerFamily")
            },
            'city_iata': {
                'required': useXmltag("PleaseenterCity")
            },
            'address_fa': {
                'required': useXmltag("PleaseenterAddress")
            },
            'phone': {
                'phone': useXmltag("PhoneNumberError"),
                'number': useXmltag("Thefixedtelephonenumberonlycontainsnumber")
            },
            'mobile': {
                'maxlength': useXmltag("Emaillong"),
                'number': useXmltag("PhoneNumberError")
            },
            'email': {
                'email': useXmltag("Invalidemail")
            }
        },
        submitHandler: function (form) {

            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        var statusType = 'green';
                    } else {
                        var statusType = 'red';
                    }

                    $.alert({
                        title: useXmltag("AgencyRegistration"),
                        icon: 'fa fa-refresh',
                        content: res[1],
                        rtl: true,
                        type: statusType
                    });

                    if (response.indexOf('success') > -1) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }

                }
            });
        },

    });

    $("#CounterAgencyAdd").validate({
        rules: {
            name: 'required',
            family: 'required',
            fk_counter_type_id: 'required',
            password: {
                required: true,
                minlength: 6
            },
            Confirm: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            phone: {
                required: true,
                number: true
            },
            mobile: {
                required: true,
                number: true,
                minlength: 11
            },
            email: {
                email: true,
                required: true
            },
        },
        messages: {
            'name': {
                'required': useXmltag("PleaseenterName")
            },
            'family': {
                'required': useXmltag("PleaseenterLastName")
            },
            'phone': {
                'phone': useXmltag("PhoneNumberError"),
                'number': useXmltag("Thefixedtelephonenumberonlycontainsnumber")
            },
            'mobile': {
                'maxlength': useXmltag("Emaillong"),
                'number': useXmltag("PhoneNumberError")
            },
            'email': {
                'email': useXmltag("Invalidemail")
            },
            password: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "رمز عبور نمی تواند از 6 کارکتر کمتر باشد"
            },
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
            },
        },
        submitHandler: function (form) {

            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        var statusType = 'green';
                    } else {
                        var statusType = 'red';
                    }

                    $.alert({
                        title: useXmltag("AgencyRegistration"),
                        icon: 'fa fa-refresh',
                        content: res[1],
                        rtl: true,
                        type: statusType
                    });

                    if (response.indexOf('success') > -1) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }

                }
            });
        },

    });


    if (gdsSwitch == 'local' || gdsSwitch == 'international' || gdsSwitch == 'resultTrainApi' || gdsSwitch == 'resultTrain') {

        // shoro function azimi loader


        /*var elem = document.getElementById("myBar");
        var elementInternal = document.getElementById("myBarSpan");

        var width = 0;

        if (gdsSwitch == 'international') {
            var id = setInterval(frame1, 1000);
        } else {
            var id = setInterval(frame1, 300);
        }


        function frame1() {

            if (width == 100) {
                clearInterval(id);
            } else if (width < 30) {
                width++;
                elem.style.width = width + '%';
                if (elementInternal) {
                    elementInternal.innerHTML = '% ' + width * 1;
                }


            } else if (width >= 30 && width < 50) {
                setInterval(frame2, 2500);
            } else if (width >= 50 && width < 80) {
                setInterval(frame3, 3000);
            } else if (width >= 80 && width < 100) {
                setInterval(frame4, 4000);
            }
        }

        function frame2() {
            if (width >= 30 && width < 50) {
                width++;
                elem.style.width = width + '%';
                if (elementInternal) {
                    elementInternal.innerHTML = '% ' + width * 1;
                }

            }
        }

        function frame3() {
            if (width >= 50 && width < 80) {
                width++;
                elem.style.width = width + '%';
                if (elementInternal) {
                    elementInternal.innerHTML = '% ' + width * 1;
                }

            }
        }

        function frame4() {
            if (width >= 80 && width < 100) {
                width++;
                elem.style.width = width + '%';
                if (elementInternal) {
                    elementInternal.innerHTML = '% ' + width * 1;
                }

            }
        }

        $('.images-circle').owlCarousel({
            items: 1,
            rtl: true,
            loop: true,
            mouseDrag: false,
            touchDrag: false,
            autoplay: true,
            smartSpeed: 2000,
            pullDrag: false,
            margin: 0,
            autoplayTimeout: 300,
            autoplaySpeed: 200,
            dots: false,
            autoplayHoverPause: true,
        });

*/
// etmam function azimi loader

    }


    //sort bus by price
    $("body").delegate("#dateSortSelectForBus, #priceSortSelectForBus", 'click', function (e) {

        console.log('dateSortSelectForBus || priceSortSelectForBus');

        $('#dateSortSelectForBus, #priceSortSelectForBus').removeClass('sorting-active-color-main');
        $(this).addClass('sorting-active-color-main');
        if ($(this).hasClass('rotated-icon')) {
            $(this).removeClass('rotated-icon');
        } else {
            $(this).addClass('rotated-icon');
        }

        var selectID = $(this).attr('id');
        var selected = '';
        var currentSelect = '';

        if (selectID == 'dateSortSelectForBus') {
            currentSelect = $('#currentDateSort').val();
            if (currentSelect == 'asc') {
                $('#currentDateSort').val('desc');
                selected = 'desc';
            } else {
                $('#currentDateSort').val('asc');
                selected = 'asc';
            }
        } else if (selectID == 'priceSortSelectForBus') {
            currentSelect = $('#currentPriceSort').val();
            if (currentSelect == 'asc') {
                $('#currentPriceSort').val('desc');
                selected = 'desc';
            } else {
                $('#currentPriceSort').val('asc');
                selected = 'asc';
            }
        }

        var currentBus = '';
        var allBus = [];
        var allBusSpecial = [];
        var temp = [];
        var currentSortSpecial = '';
        var currentSortIndex = '';
        var key = '';
        var SearchResult = $("#s-u-result-wrapper-ul div.items").find(".showListSort .international-available-box:visible");
        var returnBus = $("#s-u-result-wrapper-ul div.items").find(".showListSort .international-available-box.returnFlight");
        $("#s-u-result-wrapper-ul div.items").html('');

        SearchResult.each(function (index) {
            currentBus = $(this).parent();

            if (selectID == 'dateSortSelectForBus') {
                currentSortIndex = currentBus.find("#dateSort").val();
            } else if (selectID == 'priceSortSelectForBus') {
                currentSortIndex = currentBus.find(".priceSortAdt i").html();
                currentSortIndex = parseInt(currentSortIndex.replace(/,/g, ''));
            }
            currentSortSpecial = currentBus.find("#specialSort").val();
            if (currentSortSpecial == 'yes') {
                allBusSpecial.push({
                    'content': currentBus.html(),
                    'sortIndex': currentSortIndex
                });
            } else {
                allBus.push({
                    'content': currentBus.html(),
                    'sortIndex': currentSortIndex
                });
            }

            /*allBus.push({
                'content': currentBus.html(),
                'sortIndex': currentSortIndex,
                'sortSpecial': currentSortSpecial
            });*/
        });


        if ($(".selectedTicket").html() == '') {
            returnBus.each(function (index) {
                currentBus = $(this).parent();
                allBus.push({
                    'content': currentBus.html()
                });
            });
        }

        if (selected == 'asc') {
            for (var i = 0; i < parseInt(allBus.length); i++) {
                key = i;
                for (var j = i; j < parseInt(allBus.length); j++) {
                    if (allBus[j]['sortIndex'] <= allBus[key]['sortIndex']) {
                        temp = allBus[i];
                        allBus[i] = allBus[j];
                        allBus[j] = temp;
                    }
                }
            }
            for (var i = 0; i < parseInt(allBusSpecial.length); i++) {
                key = i;
                for (var j = i; j < parseInt(allBusSpecial.length); j++) {
                    if (allBusSpecial[j]['sortIndex'] <= allBusSpecial[key]['sortIndex']) {
                        temp = allBusSpecial[i];
                        allBusSpecial[i] = allBusSpecial[j];
                        allBusSpecial[j] = temp;
                    }
                }
            }
        }//end if
        else if (selected == 'desc') {
            for (var i = 0; i < parseInt(allBus.length); i++) {
                min = allBus[i];
                key = i;
                for (var j = i; j < parseInt(allBus.length); j++) {
                    if (allBus[j]['sortIndex'] >= allBus[key]['sortIndex']) {
                        temp = allBus[i];
                        allBus[i] = allBus[j];
                        allBus[j] = temp;
                    }
                }
            }
            for (var i = 0; i < parseInt(allBusSpecial.length); i++) {
                min = allBusSpecial[i];
                key = i;
                for (var j = i; j < parseInt(allBusSpecial.length); j++) {
                    if (allBusSpecial[j]['sortIndex'] >= allBusSpecial[key]['sortIndex']) {
                        temp = allBusSpecial[i];
                        allBusSpecial[i] = allBusSpecial[j];
                        allBusSpecial[j] = temp;
                    }
                }
            }
        }//end else if


        /*for (var i = 0; i < parseInt(allBus.length); i++) {
            key = i;
            for (var j = i; j < parseInt(allBus.length); j++) {
                if (allBus[j]['sortSpecial'] == 'yes') {
                    temp = allBus[i];
                    allBus[i] = allBus[j];
                    allBus[j] = temp;
                }
            }
        }*/

        setTimeout(function () {
            for (i = 0; i < parseInt(allBusSpecial.length); i++) {
                //console.log(i + '======' + allBusSpecial[i]['sortSpecial']);
                $("#s-u-result-wrapper-ul div.items").append('<div class="showListSort special-tour-items">' + allBusSpecial[i]['content'] + '</div>');
            }

            for (i = 0; i < parseInt(allBus.length); i++) {
                $("#s-u-result-wrapper-ul div.items").append('<div class="showListSort">' + allBus[i]['content'] + '</div>');
            }

        }, 100);
    });

    var GdsSwitchCheck = [
        'passengersDetailLocal',
        'passengersDetailReservationTicket',
        'userProfile',
        'detailPassengersPackage'
    ];
    nationalityChangeLang(GdsSwitchCheck);


    //region bahrami
    // $('body').click('.')
    $('#TourDatesList').owlCarousel({
        items: 2,
        navigation: true,
        rtl: true,
        nav: true,
        margin: 7,

        responsive: {
            // 300: {
            //     margin: 5,
            //     items: 3,
            // },
        }
    });

    $('.TourTravelProgramGallery1').owlCarousel({
        items: 1,
        navigation: true,
        rtl: true,
        dots: false,
        loop: true,
        nav: false,
        autoplay: true,
        margin: 7
    });


    $('.train_filter_ label').click(function () {
        $('.train_filter_ label').removeClass('active');
        $(this).addClass('active');

    });
    $('body').delegate('.btn-number-js', 'click', function (e) {
        e.preventDefault();


        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    $(".btn-number-js[data-type='plus'][data-field='" + fieldName + "']").prop("disabled", false);
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).prop("disabled", true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    $(".btn-number-js[data-type='minus'][data-field='" + fieldName + "']").prop("disabled", false);
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).prop("disabled", true);
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(".btn-number-js[data-type='minus'][data-field='" + fieldName + "']").prop("disabled", false);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number-js').focusin(function () {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number-js').change(function () {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name1 = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number-js[data-type='minus'][data-field='" + name1 + "']").prop("disabled", false)
        } else {
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number-js[data-type='plus'][data-field='" + name1 + "']").prop("disabled", false)
        } else {
            $(this).val($(this).data('oldValue'));
        }

    });
    //endregion

});


function showSearchBoxTicket() {
    $(".open-sidebar-parvaz").toggleClass('clos-sidebar-parvaz');

    $(".s-u-update-popup-change").toggleClass('open-search-box');
}
function showSearchBoxTour() {
    $(".filtertip_searchbox_35_").toggle();

}
function showSearchBoxInsurance() {
    $('.open-sidebar-insurance').toggleClass('close-sidebar-insurance');

    $(".filtertip-searchbox").toggle();

}

function showSearchBoxTicketTrain() {
    $(".open-sidebar-train").toggleClass('close-train-research');

    $(".s-u-update-popup-change-train").toggleClass('open-search-box-train');
}

function filterFlight(obj) {

    $(obj).toggleClass('checked');
    var Filter = $(obj).parent('li').find('input');
    var FilterVal = $(obj).parent('li').find('input').val();
    var liTarget = $('li.' + FilterVal);


    if ($(".selectedTicket").html() == '') {
        var allTarget = $('.international-available-box.deptFlight');
    } else {
        var allTarget = $('.international-available-box.returnFlight');
    }


    $(".tzCBPart").parent('li').find('input');

    if ($(obj).parents('ul').hasClass('filter-type-ul')) {
        if ($(obj).parents('ul.filter-type-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'all') {
                $(obj).parents('ul.filter-type-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-type').removeAttr('checked');
                $('#filter-type').siblings('.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-type').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-seat-ul')) {
        if ($(obj).parents('ul.filter-seat-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'all') {
                $(obj).parents('ul.filter-seat-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-seat').removeAttr('checked');
                $('#filter-seat').siblings('.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-seat').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-airline-ul')) {
        if ($(obj).parents('ul.filter-airline-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'all') {
                $(obj).parents('ul.filter-airline-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-airline').removeAttr('checked');
                $('#filter-airline').siblings('.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-airline').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-time-ul')) {
        if ($(obj).parents('ul.filter-time-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'all') {
                $(obj).parents('ul.filter-time-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-time').removeAttr('checked');
                $('#filter-time').siblings('.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-time').siblings('.tzCBPart').addClass('checked');
        }
    }


    var filter_type = new Array();
    $.each($('ul.filter-type-ul li'), function (index, value) {
        if ($(this).find('span').hasClass('checked')) {
            filter_type.push($(this).find('span.checked').siblings('input').val());
        }
    });

    var filter_seat = new Array();
    $.each($('ul.filter-seat-ul li'), function (index, value) {
        if ($(this).find('span').hasClass('checked')) {
            filter_seat.push($(this).find('span.checked').siblings('input').val());
        }
    });

    var filter_airline = new Array();
    $.each($('ul.filter-airline-ul li'), function (index, value) {
        if ($(this).find('span').hasClass('checked')) {
            filter_airline.push($(this).find('span.checked').siblings('input').val());
        }
    });

    var filter_time = new Array();
    $.each($('ul.filter-time-ul li'), function (index, value) {
        if ($(this).find('span').hasClass('checked')) {
            filter_time.push($(this).find('span.checked').siblings('input').val());
        }
    });

    $.each(allTarget, function (index) {
        allTarget.hide().filter(function () {
            return (
               ($.inArray($(this).data('time'), filter_time) >= 0 || $.inArray('all', filter_time) >= 0) &&
               ($.inArray($(this).data('type'), filter_type) >= 0 || $.inArray('all', filter_type) >= 0) &&
               ($.inArray($(this).data('seat'), filter_seat) >= 0 || $.inArray('all', filter_seat) >= 0) &&
               ($.inArray($(this).data('airline'), filter_airline) >= 0 || $.inArray('all', filter_airline) >= 0)
            ) || ($(this).data('typeappticket') == 'reservation');
        }).show();
    });
}

function filterFlightForeign(obj) {

    $(obj).toggleClass('checked');
    var Filter = $(obj).parent('li').find('input');
    var FilterVal = $(obj).attr('filtered');
    //  if(!$(FilterValId).is(':checked'))
    //  {
    //      FilterValElement.attr('checked',true)
    //  }else if($(FilterValId).is(':checked')){
    //      FilterValElement.attr('checked',false)
    //  }
    //
    //

    if ($(obj).parents('ul').hasClass('filter-interrupt-ul')) {
        if ($(obj).parents('ul.filter-interrupt-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'allStop') {
                $(obj).parents('ul.filter-interrupt-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-interrupt').parent('li').find('label').find('span.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-interrupt').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-type-ul')) {
        if ($(obj).parents('ul.filter-type-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'allFlightType') {
                $(obj).parents('ul.filter-type-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');

            } else {
                $('#filter-type').parent('li').find('label').find('span.tzCBPart').removeClass('checked');

            }
        } else {
            $('#filter-type').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-seat-ul')) {
        if ($(obj).parents('ul.filter-seat-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'allSeatClass') {
                $(obj).parents('ul.filter-seat-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-seat').parent('li').find('label').find('span.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-seat').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-airline-ul')) {
        if ($(obj).parents('ul.filter-airline-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'allAirline') {
                $(obj).parents('ul.filter-airline-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-airline').parent('li').find('label').find('span.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-airline').siblings('.tzCBPart').addClass('checked');
        }
    }
    if ($(obj).parents('ul').hasClass('filter-time-ul')) {
        if ($(obj).parents('ul.filter-time-ul').find('.tzCBPart').hasClass('checked')) {
            if (FilterVal == 'allTime') {
                $(obj).parents('ul.filter-time-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked');
            } else {
                $('#filter-time').parent('li').find('label').find('span.tzCBPart').removeClass('checked');
            }
        } else {
            $('#filter-time').siblings('.tzCBPart').addClass('checked');
        }
    }


    //
    //
    //
    var newValueFilterForeign = new Array();
    $.each($("span.tzCBPart"), function (index, element) {
        if ($(this).hasClass('checked')) {
            newValueFilterForeign.push($(this).attr('filtered'));
        }
    });

    var uniqueCodeTicket = $('.detailShow').parents().siblings('div.international-available-item').find('input.uniqueCode').val();


    if ($('#uniqueCode').val() == "") {
        $('#uniqueCode').val(uniqueCodeTicket);
    }


    if (typeof uniqueCodeTicket === 'undefined') {
        uniqueCodeTicket = $('#uniqueCode').val()
    }

    var adult = $('#adult_qty').val();
    var child = $('#child_qty').val();
    var infant = $('#infant_qty').val();
    var lang = $('#lang').val();
    var dept_date = $('#dept_date').val();
    var return_date = $('#return_date').val();
    var origin = $('#origin_local').val();
    var destination = $('#destination_local').val();

    var optionPage = {
        'uniqueCodeTicket': uniqueCodeTicket,
        'FlagFilter': 'filterForeign',
        'adult': adult,
        'child': child,
        'infant': infant,
        'dept_date': dept_date,
        'return_date': return_date,
        'lang': lang,
        'origin': origin,
        'destination': destination
    }
    $('.lightboxContainerOpacity').show();
    $('#result').html('');
    // selectPage = selectPage+'-'+count;
    $.post(amadeusPath + 'user_ajax.php',
       {
           nameFile: newValueFilterForeign,
           optionPage: optionPage,
           flag: 'nextPageTicketForeign'
       },
       function (data) {
           $('.lightboxContainerOpacity').hide();
           $('#result').html(data);
       });
}

function filterCheckboxes(elem) {
    var $filter_lists = $(".s-u-filter-item > div > ul");
    var $elem = $(elem),
       passAllFilters = true;
    $filter_lists.each(function () {
        var classes = $(this).find(':checkbox:checked').map(function () {
            return $(this).val();
        }).get();
        var passThisFilter = false;
        $.each(classes, function (index, item) {
            if ($elem.hasClass(item)) {
                passThisFilter = true;
                return false; //stop inner loop
            }
        });
        if (!passThisFilter) {
            passAllFilters = false;
            return false; //stop outer loop
        }
    });
    return passAllFilters;
}

function filterflight() {
    var $tickets = $(".s-u-result-item");
    $tickets.hide().filter(function () {
        return filterCheckboxes(this);
    }).show();
}

function filterflightForeign() {
    var $tickets = $(".s-u-result-item");
    $tickets.hide().filter(function () {
        return filterCheckboxes(this);
    }).show();
}

function reloadCaptcha() {
    var capcha = amadeusPath + 'captcha/securimage_show.php?sid=' + Math.random();
    $("#captchaImage").attr("src", capcha);
}

function reloadCaptchaSignin2() {
    var capcha = amadeusPath + 'captcha/securimage_show.php?sid=' + Math.random();
    $("#captchaImage-signin2").attr("src", capcha);
}


/*ارسال لینک فراموشی کلمه عبود*/
function forgetPass() {
    var email = $('#resetEmail2').val();
    if (email != '') {
        $.post(amadeusPath + 'user_ajax.php',
           {email: email, flag: 'forgetPass'},
           function (data) {
               $("#error-resetEmail2").html(data);
           });
    }
}

/*تغییر کلمه عبور فراموش شده*/
function recoverPass() {
    $('#panel-message').html('');
    var pass = $("#password").val();
    var repeatPass = $("#repeatePassword").val();
    var capcha = $("#signin-captcha2").val();
    if (pass == '' || repeatPass == '' || capcha == '') {
        $('#panel-message').html(useXmltag('CompletingFieldsRequired'));
    } else {
        if (pass != repeatPass) {
            $('#panel-message').html(useXmltag("NewPasswordNotSameRepeating"));
        } else {
            $.post(amadeusPath + 'captcha/securimage_check.php',
               {captchaAjax: capcha},
               function (data) {
                   if (data == true) {
                       reloadCaptchaSignin2();
                       $("#recoverForm").submit();
                   } else {
                       reloadCaptchaSignin2();
                       $("#panel-message").html(useXmltag("WrongSecurityCode"));
                       return false;
                   }
               })

        }

    }
}


/**
 * بررسی لاگین کردن یا نکردن مسافر در صفحه نتایج خارجی
 */
function checkLogin(rel_id, rec_id, com_id, price_id, dept_airport, arr_airport, origin_loc_code, desti_loc_code, dept_elaps, dept_booking_class, dept_airline_name, dept_flight_no, dept_airline_abb, dept_iata_code, dept_date, dept_time, arr_date, dept_time_part, arr_time, dept_date_j, arr_date_j, dept_con, ret_booking_class, ret_airline_name, ret_flight_no, ret_airline_abb, ret_iata_code, ret_dept_date, ret_dept_time, ret_arr_date, ret_time_part, ret_arr_time, ret_dept_date_j, ret_arr_date_j, ret_elaps, ret_con, main_adt, final_adt, tax_adt, soto_adt, quantity_adt, main_chd, final_chd, tax_chd, soto_chd, quantity_chd, main_inf, final_inf, tax_inf, soto_inf, quantity_inf, office_name, sub_system, address, index, CF, retDate, flight) {

    $.post(amadeusPath + 'user_ajax.php',
       {
           rel_id: rel_id,
           rec_id: rec_id,
           com_id: com_id,
           price_id: price_id,
           dept_airport: dept_airport,
           arr_airport: arr_airport,
           origin_loc_code: origin_loc_code,
           desti_loc_code: desti_loc_code,
           dept_elaps: dept_elaps,
           dept_booking_class: dept_booking_class,
           dept_airline_name: dept_airline_name,
           dept_flight_no: dept_flight_no,
           dept_airline_abb: dept_airline_abb,
           dept_iata_code: dept_iata_code,
           dept_date: dept_date,
           dept_time: dept_time,
           arr_date: arr_date,
           dept_time_part: dept_time_part,
           arr_time: arr_time,
           dept_date_j: dept_date_j,
           arr_date_j: arr_date_j,
           dept_con: dept_con,
           ret_booking_class: ret_booking_class,
           ret_airline_name: ret_airline_name,
           ret_flight_no: ret_flight_no,
           ret_airline_abb: ret_airline_abb,
           ret_iata_code: ret_iata_code,
           ret_dept_date: ret_dept_date,
           ret_dept_time: ret_dept_time,
           ret_arr_date: ret_arr_date,
           ret_time_part: ret_time_part,
           ret_arr_time: ret_arr_time,
           ret_dept_date_j: ret_dept_date_j,
           ret_arr_date_j: ret_arr_date_j,
           ret_elaps: ret_elaps,
           ret_con: ret_con,
           main_adt: main_adt,
           final_adt: final_adt,
           tax_adt: tax_adt,
           soto_adt: soto_adt,
           quantity_adt: quantity_adt,
           main_chd: main_chd,
           final_chd: final_chd,
           tax_chd: tax_chd,
           soto_chd: soto_chd,
           quantity_chd: quantity_chd,
           main_inf: main_inf,
           final_inf: final_inf,
           tax_inf: tax_inf,
           soto_inf: soto_inf,
           quantity_inf: quantity_inf,
           office_name: office_name,
           sub_system: sub_system,
           address: address,
           index: index,
           CF: CF,
           flag: 'checkLogin'
       },
       function (data) {
           if (data) {
               if (flight == 'local') {
                   href = amadeusPathByLang + "passengersDetail";
                   $("#flight").val(flight);
               } else {
                   href = amadeusPathByLang + "passengersDetail";
                   $("#flight").val(flight);
               }
               $("#formAjax").attr("action", href);
               $("#temporary").val(data);
               $("#formAjax").submit();
           } else {

               $('#rel_id').val(rel_id);
               $('#rec_id').val(rec_id);
               $('#com_id').val(com_id);
               $('#price_id').val(price_id);
               $('#dept_airport').val(dept_airport);
               $('#arr_airport').val(arr_airport);
               $('#origin_loc_code').val(origin_loc_code);
               $('#desti_loc_code').val(desti_loc_code);
               $('#dept_elaps').val(dept_elaps);
               $('#dept_booking_class').val(dept_booking_class);
               $('#dept_airline_name').val(dept_airline_name);
               $('#dept_airline_id').val(dept_airline_id);
               $('#dept_flight_no').val(dept_flight_no);
               $('#dept_airline_abb').val(dept_airline_abb);
               $('#dept_iata_code').val(dept_iata_code);
               $('#dept_date').val(dept_date);
               $('#dept_time').val(dept_time);
               $('#arr_date').val(arr_date);
               $('#dept_time_part').val(dept_time_part);
               $('#arr_time').val(arr_time);
               $('#dept_date_j').val(dept_date_j);
               $('#arr_date_j').val(arr_date_j);
               $('#dept_con').val(dept_con);
               $('#ret_booking_class').val(ret_booking_class);
               $('#ret_airline_name').val(ret_airline_name);
               $('#ret_flight_no').val(ret_flight_no);
               $('#ret_airline_abb').val(ret_airline_abb);
               $('#ret_iata_code').val(ret_iata_code);
               $('#ret_dept_date').val(ret_dept_date);
               $('#ret_dept_time').val(ret_dept_time);
               $('#ret_arr_date').val(ret_arr_date);
               $('#ret_time_part').val(ret_time_part);
               $('#ret_arr_time').val(ret_arr_time);
               $('#ret_dept_date_j').val(ret_dept_date_j);
               $('#ret_arr_date_j').val(ret_arr_date_j);
               $('#ret_elaps').val(ret_elaps);
               $('#ret_con').val(ret_con);
               $('#main_adt').val(main_adt);
               $('#final_adt').val(final_adt);
               $('#tax_adt').val(tax_adt);
               $('#soto_adt').val(soto_adt);
               $('#quantity_adt').val(quantity_adt);
               $('#main_chd').val(main_chd);
               $('#final_chd').val(final_chd);
               $('#tax_chd').val(tax_chd);
               $('#soto_chd').val(soto_chd);
               $('#quantity_chd').val(quantity_chd);
               $('#main_inf').val(main_inf);
               $('#final_inf').val(final_inf);
               $('#tax_inf').val(tax_inf);
               $('#soto_inf').val(soto_inf);
               $('#quantity_inf').val(quantity_inf);
               $('#office_name').val(office_name);
               $('#sub_system').val(sub_system);
               $('#address').val(address);
               $('#index').val(index);
               $('#CF').val(CF);
               $('#retDate').val(retDate);
               $('#flight').val(flight);
               $("#login-popup").trigger("click");
           }
       })
}


/**
 * ذخیر ه اطلاعات پرواز به صورت موقت
 */
//function temprory_local(adt, chd, inf, Flight) {
//    $.post('ajax.php',
//            {
//                adt: adt,
//                chd: chd,
//                inf: inf,
//                Flight: Flight,
//                usage: "revalidate_Fight",
//            },
//            function (data) {
//                alert(data)
//                exit();
//                var res = data.split(':');
//                if (res[0] == "Revalidate")
//                {
//                    $('#loader_check_' + Flight).show();
//
//                    $('#session_filght_Id').val(res[1]);
//                    var token_session =  $('#session_filght_Id').val();
//
//
//                    setTimeout(function ()
//                    {
//                        $('#loader_check_' + Flight).hide();
//
//                        $.post(amadeusPath + 'user_ajax.php',
//                                {
//                                    DepartureCode: DepartureCode,
//                                    DepartureParentRegionName: DepartureParentRegionName,
//                                    ArrivalCode: ArrivalCode,
//                                    ArrivalParentRegionName: ArrivalParentRegionName,
//                                    AirlineCode: AirlineCode,
//                                    AirlineName: AirlineName,
//                                    PersianDepartureDate: PersianDepartureDate,
//                                    DepartureTime: DepartureTime,
//                                    AdtPrice: AdtPrice,
//                                    ChdPrice: ChdPrice,
//                                    InfPrice: InfPrice,
//                                    SupplierID: SupplierID,
//                                    SupplierName: SupplierName,
//                                    Description: Description,
//                                    SeatClass: SeatClass,
//                                    FlightNo: FlightNo,
//                                    FlightType: FlightType,
//                                    SubSystem: SubSystem,
//                                    Capacity: Capacity,
//                                    AircraftCode: AircraftCode,
//                                    Adt_qty: Adt_qty,
//                                    Chd_qty: Chd_qty,
//                                    Inf_qty: Inf_qty,
//                                    token_session: token_session,
//                                    flag: 'temprory_local'},
//                                function (data) {
//                                    if (data) {
//                                        href = amadeusPath + "passengersDetailLocal";
//                                        $("#formAjax").attr("action", href);
//                                        $("#temporary").val(data);
//                                        $("#formAjax").submit();
//                                    }
//                                });
//                    }, 3000);
//                } else
//                {
//                    $('#loader_check_' + Flight).hide();
//                    $('#nextStep_' + Flight).css("background", "red").html(data);
//                }
//
//            })

//}

function send_info_passengers() {
    var href = amadeusPathByLang + "passengersDetailLocal";
    $("#formAjax").attr("action", href);
    $("#temporary").val($('#session_filght_Id').val());
    $("#formAjax").submit();
}


/**
 * پر کردن فیلدهای مسافر در صفحه  [رزرو] بعد از انتخاب از صفحه  [مسافران قبلی] ا
 */
function selectPassengerLocal(idPass, moduleType,_this=null) {
    var found;
    if(_this && _this.length){
        loadingToggle(_this)
    }
    $.post(amadeusPath + 'user_ajax.php',
       {
           idPass: idPass,
           flag: 'selectPassengerLocal'
       },
       function (data) {
           if(_this && _this.length){
               loadingToggle(_this,false)
           }
           if (data) {
               var obj = jQuery.parseJSON(data);
               if (obj.NationalCode) {
                   $(".UniqNationalCode").each(function (index) {
                       if ($(this).val() == obj.NationalCode) {
                           found = 1;
                       }
                   });
               } else {
                   $(".UniqPassportNumber").each(function (index) {
                       if ($(this).val() == obj.passportNumber) {
                           found = 1;
                       }
                   });
               }
               if (!found) {
                   var numberRow = $("#numberRow").attr('value');

                   if (moduleType == 'insurance' && obj.birthday_fa != $("#birthday" + numberRow).val()) {
                       $.alert({
                           title: useXmltag("Passengerlist"),
                           icon: 'fa fa-refresh',
                           content: useXmltag("DateBirthDoesNotMatch"),
                           rtl: true,
                           type: 'red',
                       });


                   } else {
                       $("#gender" + numberRow + " option[value=" + obj.gender + "]").prop('selected', true);
                       $("#nameEn" + numberRow).attr('value', obj.name_en);
                       $("#familyEn" + numberRow).attr('value', obj.family_en);
                       // $("#nameFa" + numberRow).attr('value', obj.name);
                       // $("#familyFa" + numberRow).attr('value', obj.family);
                       $("#birthdayEn" + numberRow).attr('value', obj.birthday);
                       $("#birthday" + numberRow).attr('value', obj.birthday_fa);
                       $("#NationalCode" + numberRow).attr('value', obj.NationalCode);
                       $("#passportCountry" + numberRow).attr('value', obj.passportCountry);
                       $("#select2-passportCountry" + numberRow + "-container").html($("#passportCountry" + numberRow + " option:selected").text());
                       $("#passportNumber" + numberRow).attr('value', obj.passportNumber);
                       $("#passportExpire" + numberRow).attr('value', obj.passportExpire);

                   }

                   $(".s-u-close-last-p").trigger("click");

               } else {
                   $.alert({
                       title: useXmltag("Passengerlist"),
                       icon: 'fa fa-refresh',
                       content: useXmltag("NoPermissionDuplicateNationalCode"),
                       rtl: true,
                       type: 'red',
                   });
                   $(".s-u-close-last-p").trigger("click");
               }
           }
       })
}

/**
 * ست کردن مقدار فیلد numberRow برای مشخص شدن این که کدام دکمه [مسلافران سابق] زده شده
 * @param $id
 */
function setHidenFildnumberRow(id) {

    $("#numberRow").attr('value', id);
    $("#lightboxContainer").addClass("displayBlock");
}

function setHidenFildnumberRowBus(id) {

    $("#numberRow").attr('value', id);
    $("#lightboxContainer").addClass("displayBlock");

    $('.s-u-black-container').fadeIn();
    $('.last-p-popup').fadeIn();
}

function setHidenCloseLastP() {
    $("#lightboxContainer").removeClass("displayBlock");
}

function creditBuy(Obj, link, inputs) {

    if(inputs['typeApplication'] == "externalApi"){

        $(document).off('click', '#creditpay').one('click', '#creditpay', function(e) {
            e.preventDefault();
            // ساخت مودال با JS
            // ساخت مودال
            var modal = document.createElement('div');
            modal.id = 'customModal';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.background = 'rgba(0,0,0,0.5)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.zIndex = '9999';
            modal.style.opacity = '0';
            modal.style.transition = 'opacity 0.3s ease';

            // محتوا
            var content = document.createElement('div');
            content.style.background = '#fff';
            content.style.padding = '25px 30px';
            content.style.borderRadius = '12px';
            content.style.maxWidth = '450px';
            content.style.textAlign = 'center';
            content.style.position = 'relative';
            content.style.boxShadow = '0 5px 15px rgba(0,0,0,0.3)';

            // آیکون موفقیت با SVG
            var icon = document.createElement('div');
            icon.innerHTML = `
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="12" fill="#2e7d32"/>
            <path d="M6 12.5L10 16L18 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    `;
            icon.style.marginBottom = '15px';
            content.appendChild(icon);

            // پیام
            var message = document.createElement('p');
            message.innerText = 'درخواست رزرو شما ثبت شد.\nبرای نهایی کردن آن با آژانس تماس بگیرید.';
            message.style.fontSize = '16px';
            message.style.color = '#2e7d32';
            message.style.margin = '0 0 20px 0';
            content.appendChild(message);

            // دکمه بستن
            var closeBtn = document.createElement('button');
            closeBtn.innerText = 'باشه';
            closeBtn.style.padding = '10px 20px';
            closeBtn.style.border = 'none';
            closeBtn.style.background = '#2e7d32';
            closeBtn.style.color = '#fff';
            closeBtn.style.borderRadius = '6px';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.fontSize = '14px';
            closeBtn.onmouseover = function(){ closeBtn.style.background = '#1b5e20'; }
            closeBtn.onmouseout = function(){ closeBtn.style.background = '#2e7d32'; }

            closeBtn.onclick = function() {
                modal.style.opacity = '0';
                setTimeout(function(){
                    $('#creditpay').css({
                        'pointer-events': 'none',
                        'cursor': 'not-allowed',
                        'opacity': '0.6'   // حس غیرفعال بودن
                    });

                    document.body.removeChild(modal); }, 300);
            };

            content.appendChild(closeBtn);
            modal.appendChild(content);
            document.body.appendChild(modal);

            // انیمیشن نمایش
            setTimeout(function(){ modal.style.opacity = '1'; }, 10);

        })

    }
    else{
        $('.creditPaymentLoader').addClass("skeleton").attr("disabled", "disabled").css('cursor', 'default').removeAttr('onclick',true);
        $.alert({
            title: useXmltag("CreditShoping"),
            icon: 'fa fa-shopping-cart',
            content: useXmltag("SurePurchaseCreditShoping"),
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: useXmltag("Approve"),
                    btnClass: 'btn-green',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: amadeusPath + 'user_ajax.php',
                            data: inputs,
                            success: function (data) {

                                var res = data.split(':');
                                if (data.indexOf('success') > -1) {

                                    $('#creditpay').attr("disabled", "disabled");

                                    var form = document.getElementById('formcredit');
                                    form.setAttribute("action", link);

                                    $.each(inputs,
                                       function (i, item) {
                                           if (typeof item === 'object' && item !== null) {
                                               $.each(item, function (j, item2) {
                                                   var hiddenField = document.createElement("input");
                                                   hiddenField.setAttribute("type", "hidden");
                                                   hiddenField.setAttribute("name", i + '[' + j + ']');
                                                   hiddenField.setAttribute("value", item2);
                                                   form.appendChild(hiddenField);
                                               });
                                           } else {
                                               var hiddenField = document.createElement("input");
                                               hiddenField.setAttribute("type", "hidden");
                                               hiddenField.setAttribute("name", i);
                                               hiddenField.setAttribute("value", item);
                                               form.appendChild(hiddenField);
                                           }
                                       });

                                    var hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", "amount");
                                    hiddenField.setAttribute("value", res[1]);
                                    form.appendChild(hiddenField);

                                    var hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", "flag");
                                    hiddenField.setAttribute("value", "credit");
                                    form.appendChild(hiddenField);

                                    form.submit();
                                    document.body.removeChild(form);

                                } else {

                                    $.alert({
                                        title: useXmltag("CreditShoping"),
                                        icon: 'fa fa-refresh',
                                        content: res[1],
                                        rtl: true,
                                        type: 'red',
                                    });

                                }
                            }
                        });
                    },
                },
                cancel: {
                    text: useXmltag("Optout"),
                    btnClass: 'btn-orange',
                }
            }
        });
    }

}


/**
 *  گرفتن نتایح سرچ بلیط داخلی
 * page : resultLocal.html
 * */
function getResultTicketLocal(origin, destination, dept_date, return_date, classf, adult, child, infant, foreign, flightNumber) {
    // $('#result').hide();


    if (flightNumber != '') {
        $('#sortFlightInternal').remove();
        $('#s-u-filter-wrapper-ul').remove();
    }

    // goToResultFakeFlight(origin, destination, dept_date, 'local', flightNumber);

    $('.ticket-loader').fadeIn("slow");
    $.post(amadeusPath + 'user_ajax.php',
       {
           flag: 'getResultTicketLocal',
           origin: origin,
           destination: destination,
           dept_date: dept_date,
           return_date: return_date,
           classf: classf,
           adult: adult,
           child: child,
           infant: infant,
           foreign: foreign,
           lang: lang,
           searchFlightNumber: flightNumber
       },
       function (data) {
           if (data) {
               $('#resultFake').remove();
               $('#result').html(data);
               $('#result').fadeIn();

               if($('.showListSort').length  > 0)
               {
                   $('.silence_span').removeClass('ph-item2').html($('.showListSort').length + ' ' + useXmltag("NumberFlightFound"));
               }


               if (flightNumber != '') {
                   flightNumber = flightNumber.toString();
                   //$('div.international-available-box').hide();
                   //$('div.' + flightNumber).show();
                   $('#sortFlightInternal').remove();
                   $('#s-u-filter-wrapper-ul').remove();

                   var allTicket = [];
                   $("div.international-available-box").each(function (index) {
                       var flightNo = $(this).data('flightno').toString();
                       var flight_type = $(this).data('type');
                       var flight_airline = $(this).data('airline');

                       var replaceFlightNumber = flightNumber.toString().replace(flight_airline, '');


                       // console.log('flightNumber=>'+flightNumber);
                       // console.log('flightNo=>'+flightNo);
                       // console.log('replace=>'+replaceFlightNumber);
                       // console.log('*********************');


                       if (((flightNumber === flightNo) || (flightNo === replaceFlightNumber)) && flight_type == 'system') {

                           var price = parseInt($(this).data('price'));
                           var current = $(this).parent();
                           allTicket.push({
                               'content': current.html(),
                               'price': price
                           });
                       }
                   });
                   for (var i = 0; i < parseInt(allTicket.length); i++) {
                       key = i;
                       for (var j = i; j < parseInt(allTicket.length); j++) {
                           if (allTicket[j]['price'] <= allTicket[key]['price']) {
                               var temp = allTicket[i];
                               allTicket[i] = allTicket[j];
                               allTicket[j] = temp;
                           }
                       }
                   }
               }

               setTimeout(function () {
                   if (flightNumber != '') {
                       // console.log(allTicket);
                       $('#sortFlightInternal').remove();
                       $('#s-u-filter-wrapper-ul').remove();
                       $('div.international-available-box').hide();
                       $(".items").append('<div class="showListSort">' + allTicket[0]['content'] + '</div>');
                   }

                   // $('#priceSortSelect').trigger("click");
                   $('.f-loader-check').fadeOut("slow");
                   // $('.ticket-loader').fadeOut("slow");

               }, 100);


           }


       });
}


function goToResultFakeFlight(origin, destination, depDate, Type, flightNumber) {

    $.post(amadeusPath + 'user_ajax.php',
       {
           flag: 'getResultTicketFake',
           origin: origin,
           destination: destination,
           dept_date: depDate,
           Type: Type,
           flightNumber: flightNumber
       },
       function (data) {
           if (data) {
               $("#resultFake").html(data);
           }

       })
}

/**
 *  گرفتن نتایح سرچ بلیط خارجی
 * page : internationalFlight.html
 * */
function getResultTicketPortal(origin, destination, dept_date, return_date, classf, adult, child, infant, foreign, page, count) {
    // goToResultFakeFlight(origin, destination, dept_date, 'foreign', '');

    $('.ticket-loader').fadeIn("slow");
    $("html, body").animate({scrollTop: 50}, 300);

    $('.ticket-loader').fadeIn("slow");

    $.post(amadeusPath + 'user_ajax.php',
       {
           flag: 'getResultTicketPortal',
           origin: origin,
           destination: destination,
           dept_date: dept_date,
           return_date: return_date,
           classf: classf,
           adult: adult,
           child: child,
           infant: infant,
           page: page,
           count: count,
           foreign: foreign,
           lang: lang
       },
       function (data) {
           if (data) {
               $('#resultFake').remove();

               //  $('#priceSortSelect').trigger("click");
               setTimeout(function () {
                   $("#result").html(data);
                   $('.f-loader-check').hide();
                   $('#result').fadeIn();

                   $('.silence_span').removeClass('ph-item2').html($('.international-available-box').length + ' ' + useXmltag("NumberFlightFound"));


               }, 10);

               setTimeout(function () {
                   loadArticles('Flight', destination)
               }, 1000);
           }

       })

}

function isAlfabetKeyFields(evt, Input) {

    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode == 8 || charCode == 32 || charCode == 20) {
        return true;
    } else if (65 <= charCode && charCode <= 90) {
        return true;
    } else if (97 <= charCode && charCode <= 122) {
        return true;
    } else {

        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("LatinLettersOnly"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red'

                }
            }
        });

        return false;
    }
}


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

function gregorian_to_jalali(gy, gm, gd) {
    g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    jy = (gy <= 1600) ? 0 : 979;
    gy -= (gy <= 1600) ? 621 : 1600;
    gy2 = (gm > 2) ? (gy + 1) : gy;
    days = (365 * gy) + (parseInt((gy2 + 3) / 4)) - (parseInt((gy2 + 99) / 100))
       + (parseInt((gy2 + 399) / 400)) - 80 + gd + g_d_m[gm - 1];
    jy += 33 * (parseInt(days / 12053));
    days %= 12053;
    jy += 4 * (parseInt(days / 1461));
    days %= 1461;
    jy += parseInt((days - 1) / 365);
    if (days > 365)
        days = (days - 1) % 365;
    jm = (days < 186) ? 1 + parseInt(days / 31) : 7 + parseInt((days - 186) / 30);
    jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
    return [jy, jm, jd];
}


function goPreviousDay(one_way, origin, destination, dept_date, return_date, classf, adult, child, infant, flight) {
    var arr = dept_date.split('-');
    firstYear = arr[0];
    curentDate = new Date(dept_date);
    curentDay = curentDate.getDate();
    curentMounth = curentDate.getMonth() + 1;
    curentYear = curentDate.getFullYear();
    d = new Date();
    d.setMonth(curentDate.getMonth());
    d.setFullYear(curentDate.getFullYear());
    d.setDate(curentDate.getDate() - 1);
    newDay = d.getDate();
    newMounth = d.getMonth() + 1;
    newYear = d.getFullYear();
    if (firstYear > 1500) {
        dateString = gregorian_to_jalali(newYear, newMounth, newDay);
        newYear = dateString[0];
        newMounth = dateString[1];
        newDay = dateString[2];
    }

    if (newDay < 10) {
        newDay = '0' + newDay;
    }
    if (newMounth < 10) {
        newMounth = '0' + newMounth;
    }

    dept_date = newYear + '-' + newMounth + '-' + newDay;
    var url = "1/" + origin + "-" + destination + "/" + dept_date + "/" + classf + "/" + adult + "-" + child + "-" + infant;
    if (flight == 'local') {
        window.location.href = 'local/' + url;
    } else {
        window.location.href = 'gds/' + url;
    }
}

function goNextDay(one_way, origin, destination, dept_date, return_date, classf, adult, child, infant, flight) {
    var arr = dept_date.split('-');
    firstYear = arr[0];
    curentDate = new Date(dept_date);
    curentDay = curentDate.getDate();
    curentMounth = curentDate.getMonth() + 1;
    curentYear = curentDate.getFullYear();
    d = new Date();
    d.setMonth(curentDate.getMonth());
    d.setFullYear(curentDate.getFullYear());
    d.setDate(curentDate.getDate() + 1);
    newDay = d.getDate();
    newMounth = d.getMonth() + 1;
    newYear = d.getFullYear();
    if (firstYear > 1500) {
        dateString = gregorian_to_jalali(newYear, newMounth, newDay);
        newYear = dateString[0];
        newMounth = dateString[1];
        newDay = dateString[2];
    }

    if (newDay < 10) {
        newDay = '0' + newDay;
    }
    if (newMounth < 10) {
        newMounth = '0' + newMounth;
    }

    dept_date = newYear + '-' + newMounth + '-' + newDay;
    var url = "1/" + origin + "-" + destination + "/" + dept_date + "/" + classf + "/" + adult + "-" + child + "-" + infant;
    if (flight == 'local') {
        window.location.href = 'local/' + url;
    } else {
        window.location.href = 'gds/' + url;
    }

}


function select_Airport(language='fa') {
    var Departure = $('#origin_local').val();
    $.post(amadeusPath + 'user_ajax.php',
       {
           Departure: Departure,
           flag: "select_Airport",
           language: language,
       },
       function (data) {
           $('#destination_local').html(data);
           $('#destination_local').select2('open');
       })
}

/**
 * بررسی  مسافران وارد شده قبل از ارسال به صفحه فاکتور
 * page : PassengerDetail.html
 */
function checkfildLocal(currentDate, numAdult, numChild, numInfant, uniq_id,_this=null) { //flight=  local



    var error1 = 0;
    var error2 = 0;
    var error3 = 0;
    var error4 = 0;
    var error5 = 0;
    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();
    // Mr Afshar's phone
    var sample_number = '09123493154';

    var FlightType = $('#FlightType').val();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);
//
//    if (retDate != '') { //اگر دوطرفه بود
//        //تاریخ برگشت
//        var retDate = new Date(retDate);
//        retDate = Math.round(retDate.getTime() / 1000);
//    }


    $('#loader_check').removeClass('d-none');
    $('#loader_check').show();
    $('#send_data').attr('disabled', 'disabled').css('opacity', '0.4').css('padding-right', '2rem').css('cursor', 'progress').val(useXmltag("Pending"));


    var NumberPassenger = parseInt(numAdult) + parseInt(numChild) + parseInt(numInfant);

    if (numAdult > 0) {
        var adt = Adult_members(currentDate, numAdult);
        if (adt == 'true') {
            error1 = 0;
        } else {
            error1 = 1
        }
    }

    if (numChild > 0) {
        var chd = Chd_memebrs(currentDate, numChild);
        if (chd == 'true') {
            error2 = 0;
        } else {
            error2 = 1
        }
    }


    if (numInfant > 0) {
        var inf = Inf_members(currentDate, numInfant);
        if (inf === 'true') {
            error3 = 0;
        } else {
            error3 = 1
        }
    }

    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#Mobile').val();
        var tel = $('#Telephone').val();
        var mobregqx = /^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,6}$/;
        if (!mobregqx.test(mob) && lang == 'fa') {
            $("#messageInfo").html('<br>' + useXmltag("MobileNumberIncorrect"));
            error4 = 1;
        } else {
            error4 = 0
        }
    }

    if ($("#Mobile_buyer").length > 0) {
        var mobile_buyer = $('#Mobile_buyer').val();
        var mobile_buyer_input = $('#Mobile_buyer');
    } else {
        var mobile_buyer = $('#Mobile').val();
        var mobile_buyer_input = $('#Mobile');

        if (mobile_buyer == '') {
            // $('#Mobile').val('simple' + mobile_buyer + '@info.com');
            if (lang == 'fa') {
                error5 = 1;
                $("#errorInfo").html('<br>' + useXmltag("EnterRequiredInformation")).css('color', '#ce4235');
            } else {
                mobile_buyer_input.val(sample_number);
            }
        }
    }

    if (mobile_buyer != '') {
        var mobregqx =/^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,6}$/;

        if (!mobregqx.test(mobile_buyer)) {
            $("#errorInfo").html('<br>' + useXmltag("MobileNumberIncorrect")).css('color', '#ce4235');
            error5 = 1;
        }
    }

    var email_buyer ='';
    if ($("#Email_buyer").length > 0) {
        email_buyer = $('#Email_buyer').val()
    } else {
        email_buyer = $('#Email').val();

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

        if(_this && _this.length){
            loadingToggle(_this);
        }

        var IdMember = '';
        var SourceIdFlight = $('#SourceIdFlight').val();
        setTimeout(
           function () {
               $.post(amadeusPath + 'user_ajax.php',
                  {
                      mobile: mob,
                      telephone: tel,
                      Email: email_buyer,
                      flag: "register_memeber"
                  },
                  function (reponse) {

                      var res = reponse.split(':');
                      if (reponse.indexOf('success') > -1) {
                          $('#IdMember').val(res[1]);
                          IdMember = $('#IdMember').val();
                          var dataForm = $('#formPassengerDetailLocal').serialize();
                          setTimeout(function () {
                              $.ajax({
                                  type: 'POST',
                                  url: amadeusPath + 'user_ajax.php',
                                  dataType: 'JSON',
                                  data:
                                     {
                                         flag: 'PreReserve',
                                         uniq_id: uniq_id,
                                         NumCount: NumberPassenger,
                                         dataForm: dataForm
                                     },
                                  success: function (data) {
                                      var RequestNumber = {};
                                      if (data.total_status == 'success') {
                                          if (typeof data.dept !== 'undefined') {
                                              $('#RequestNumber_dept').val(data.dept.result_request_number);
                                              $('#factor_number_Flight').val(data.dept.result_factor_number);
                                              RequestNumber['dept'] = $('#RequestNumber_dept').val();
                                          }
                                          if (typeof data.return !== 'undefined') {
                                              $('#RequestNumber_return').val(data.return.result_request_number);
                                              RequestNumber['return'] = $('#RequestNumber_return').val();
                                          }
                                          if (typeof data.TwoWay !== 'undefined') {
                                              $('#RequestNumber_TwoWay').val(data.TwoWay.result_request_number);
                                              RequestNumber['TwoWay'] = $('#RequestNumber_TwoWay').val();
                                              $('#factor_number_Flight').val(data.TwoWay.result_factor_number);
                                          }

                                          if (typeof data.multi_destination !== 'undefined') {
                                              $('#RequestNumber_multi_destination').val(data.multi_destination.result_request_number);
                                              RequestNumber['multi_destination'] = $('#RequestNumber_multi_destination').val();
                                              $('#factor_number_Flight').val(data.multi_destination.result_factor_number);
                                          }
                                          var RequestNumberJsonEncoded = JSON.stringify(RequestNumber);


                                          bookFlight(RequestNumberJsonEncoded, IdMember, SourceIdFlight);


                                          /*setTimeout(
                                              function () {
                                                  $('#loader_check').hide();
                                                  $('#formPassengerDetailLocal').submit();
                                              }, 2000);*/

                                      } else {
                                          if(_this && _this.length){
                                              loadingToggle(_this,false);
                                          }
                                          if (typeof data.dept !== 'undefined') {
                                              var message = data.dept.result_message;
                                          }
                                          if (typeof data.return !== 'undefined') {
                                              var message = data.return.result_message;
                                          }
                                          if (typeof data.TwoWay !== 'undefined') {
                                              var message = data.TwoWay.result_message;
                                          }
                                          if (typeof data.multi_destination !== 'undefined') {
                                              var message = data.multi_destination.result_message;
                                          }
                                          $.confirm({
                                              title: useXmltag('BuyTicket'),
                                              content: message,
                                              type: 'blue',
                                              typeAnimated: true,
                                              buttons: {
                                                  tryAgain: {
                                                      text: useXmltag('Repeatsearch'),
                                                      btnClass: 'btn-green',
                                                      action: function () {

                                                          let url_research = $('.cancel-passenger').attr('data-url');
                                                          window.location.href = url_research;
                                                      }
                                                  },
                                                  close: {
                                                      text: useXmltag('searchReturnToMainPage'),
                                                      btnClass: 'btn-red',
                                                      action: function () {

                                                          window.location.href = rootMainPath ;
                                                      }
                                                  }
                                              }
                                          });
                                          $('#loader_check').hide();
                                          $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

                                          return false;
                                      }
                                  }
                              });
                          }, 100);
                      } else {
                          if(_this && _this.length){
                              loadingToggle(_this,false);
                          }
                          $('#loader_check').addClass('d-none');
                          $('#send_data').removeAttr('disabled').css('padding-right', '3px').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));
                          $.confirm({
                              title: useXmltag('BuyTicket'),
                              content: res[1],
                              type: 'red',
                              typeAnimated: true,
                              buttons: {
                                  tryAgain: {
                                      text: useXmltag('Repeatsearch'),
                                      btnClass: 'btn-green',
                                      action: function () {

                                          let url_research = $('.cancel-passenger').attr('data-url');
                                          window.location.href = url_research;
                                      }
                                  },
                                  close: {
                                      text: useXmltag('searchReturnToMainPage'),
                                      btnClass: 'btn-red',
                                      action: function () {

                                          window.location.href = rootMainPath ;
                                      }
                                  }
                              }
                          });

                          return false;
                      }
                  });
           }, 1000);
    } else {
        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("alertFillingInfo"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red'

                }
            }
        });
        setTimeout(
           function () {
               $('#loader_check').addClass('d-none');
               $('#send_data').removeAttr('disabled').css('opacity', '1').css('padding-right', '3px').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

           }, 2000);

    }

}

function RunPreReserveEntertainment(EntertainmentId , thiss) {

    let $btn = $('#send_data');

    if (!$btn.length) {
        console.error('send_data not found');
        return;
    }

    loadingToggle($btn);

    busy = 1;
    var mob = $('#Mobile').val();
    var Email_Address = $('#Email').val();
    var tel = $('#Telephone').val();
    var IdMember = '';

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
               $('#IdMember').val(res[1]);
               IdMember = $('#IdMember').val();
               var dataForm = $('#formPassengerDetailEntertainment').serialize();
               setTimeout(function () {
                   $.ajax({
                       type: 'POST',
                       url: amadeusPath + 'entertainment_ajax.php',
                       dataType: 'JSON',
                       data:
                          {
                              flag: 'PreReserve',
                              EntertainmentId: EntertainmentId,
                              NumCount: $('#CountPeople').val(),
                              dataForm: dataForm
                          },
                       success: function (data) {

                           busy = 0;

                           $('[name="EntertainmentFactorNumber"]').val(data.factor_number);
                           $("#formPassengerDetailEntertainment").attr("action", amadeusPathByLang + 'passengerDetailReservationEntertainment');
                           $("#formPassengerDetailEntertainment").submit();
                       }
                   });
               }, 100);
           } else {
               busy = 0;
               loadingToggle(thiss,false)
               $('#loader_check').hide();
               $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));
               $.alert({
                   title: useXmltag("BuyTicket"),
                   icon: 'fa shopping-cart',
                   content: res[1],
                   rtl: true,
                   type: 'red'
               });
               return false;
           }
       });
}

function PreReserveEntertainment(EntertainmentId, thiss) {

    var busy = false;

    var tf = true;
    var emptyFilds = '';
    $('#formPassengerDetailEntertainment').find('input[required="required"]').each(function () {
        if ($(this).val() == '') {
            emptyFilds = emptyFilds + '<spam style="font-size:14px;" class="badge badge-warning ml-2">' + $(this).attr('placeholder') + '</spam>';
        }
    });
    if(emptyFilds){

        $.alert({
            title: useXmltag("FillNullBelowData"),
            rtl: true,
            type: 'warning',
            icon: 'fa fa-warning',
            content: emptyFilds,
        });
        return false;
    }
    // ===== ONLY 6 MONTHS CHECK (Jalali, string-based, correct) =====

    var startDate = $('#StartDate').val();   // مثال: 1411-09-10
    var today = dateNow('-');                // مثال: 1404-03-01

    if (startDate) {

        var parts = today.split('-');

        var y = parseInt(parts[0], 10);
        var m = parseInt(parts[1], 10);
        var d = parts[2];

        // +6 ماه شمسی
        m += 6;
        if (m > 12) {
            m -= 12;
            y += 1;
        }

        var maxDate =
           y + '-' +
           (m < 10 ? '0' + m : m) + '-' +
           d;

        // فقط چک سقف ۶ ماه
        if (startDate > maxDate) {
            $.alert({
                title: useXmltag("Error"),
                rtl: true,
                type: 'warning',
                content: 'تاریخ انتخاب‌شده فقط تا ۶ ماه آینده مجاز است'
            });
            return false;
        }
    }


    if (tf == false) {
        return false;
    }

    var error4 = 0;
    var error5 = 0;


    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#Mobile').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
        if (!mobregqx.test(mob) && lang == 'fa') {
            $("#messageInfo").html('<br>' + useXmltag("MobileNumberIncorrect"));
            error4 = 1;
        } else {
            error4 = 0
        }
    }

    if ($("#Mobile_buyer").length > 0) {
        var mobile_buyer = $('#Mobile_buyer').val();
        var mobile_buyer_input = $('#Mobile_buyer');
    } else {
        var mobile_buyer = $('#Mobile').val();
        var mobile_buyer_input = $('#Mobile');

        if (mobile_buyer == '') {
            // $('#Mobile').val('simple' + mobile_buyer + '@info.com');
            if (lang == 'fa') {
                error5 = 1;
                $("#errorInfo").html('<br>' + useXmltag("EnterRequiredInformation")).css('color', '#ce4235');
            } else {
                mobile_buyer_input.val(sample_number);
            }
        }
    }

    if (mobile_buyer != '') {
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;

        if (!mobregqx.test(mobile_buyer)) {
            $("#errorInfo").html('<br>' + useXmltag("MobileNumberIncorrect")).css('color', '#ce4235');
            error5 = 1;
        }
    }


    if ($("#Email_buyer").length > 0) {
        var email_buyer = $('#Email_buyer').val()
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

    if (error4 == 0 && error5 == 0 && busy == 0) {
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'entertainment_ajax.php',
            dataType: 'JSON',
            data:
               {
                   flag: 'checkUserLogin',

               },
            success: function (data) {


                if (data.result_status == 'success') {

                    RunPreReserveEntertainment(EntertainmentId, thiss);

                } else {
                    var isShowLoginPopup = $('#isShowLoginPopup').val();
                    var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                    if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                        $("#login-popup").trigger("click");
                        $("#noLoginBuy").attr('onclick', "popupBuyNoLogin('entertainment','" + EntertainmentId + "','')");
                    } else {
                        popupBuyNoLogin(useTypeLoginPopup, EntertainmentId, thiss);
                    }


                }

            }
        });

    } else {
        busy = 0;

        loadingToggle(thiss,false)
        setTimeout(
           function () {
               $('#loader_check').hide();
               $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));
           }, 2000);

    }

}
function PreRquestEntertainment(EntertainmentId, thiss) {
    var busy = false;

    var tf = true;
    var emptyFilds = '';
    $('#formPassengerDetailEntertainmentForRequest').find('input[required="required"]').each(function () {
        if ($(this).val() == '') {
            emptyFilds = emptyFilds + '<spam style="font-size:14px;" class="badge badge-warning ml-2">' + $(this).attr('placeholder') + '</spam>';
        }
    });


    if (tf == false) {
        return false;
    }

    var error4 = 0;
    var error5 = 0;


    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {

        var mob = $('#Mobile').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
        if (!mobregqx.test(mob) && lang == 'fa') {
            $("#messageInfo").html('<br>' + useXmltag("MobileNumberIncorrect"));
            error4 = 1;
        } else {
            error4 = 0
        }
    }

    if ($("#Mobile_buyer").length > 0) {
        var mobile_buyer = $('#Mobile_buyer').val();
        var mobile_buyer_input = $('#Mobile_buyer');
    } else {
        var mobile_buyer = $('#Mobile').val();
        var mobile_buyer_input = $('#Mobile');

        if (mobile_buyer == '') {
            // $('#Mobile').val('simple' + mobile_buyer + '@info.com');
            if (lang == 'fa') {
                error5 = 1;
                $("#errorInfo").html('<br>' + useXmltag("EnterRequiredInformation")).css('color', '#ce4235');
            } else {
                mobile_buyer_input.val(sample_number);
            }
        }
    }

    if (mobile_buyer != '') {
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;

        if (!mobregqx.test(mobile_buyer)) {
            $("#errorInfo").html('<br>' + useXmltag("MobileNumberIncorrect")).css('color', '#ce4235');
            error5 = 1;
        }
    }


    if ($("#Email_buyer").length > 0) {
        var email_buyer = $('#Email_buyer').val()
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

    if (error4 == 0 && error5 == 0 && busy == 0) {

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'entertainment_ajax.php',
            dataType: 'JSON',
            data:
               {
                   flag: 'checkUserLogin',

               },
            success: function (data) {

                if (data.result_status == 'success') {

                    RunPreRequestEntertainment(EntertainmentId, thiss);

                } else {
                    var isShowLoginPopup = $('#isShowLoginPopup').val();
                    var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                    if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                        $("#login-popup").trigger("click");
                        $("#noLoginBuy").attr('onclick', "popupBuyNoLogin('entertainment','" + EntertainmentId + "','')");
                    } else {
                        popupBuyNoLogin(useTypeLoginPopup, EntertainmentId, thiss);
                    }


                }

            }
        });

    } else {
        busy = 0;

        loadingToggle(thiss,false)
        setTimeout(
           function () {
               $('#loader_check').hide();
               $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));
           }, 2000);

    }

}



function validatePersianInput(variableId) {
    var inputValue = $("#" + variableId).val();
    var persianLettersRegex = /[\u0600-\u06FF]/;

    if (!persianLettersRegex.test(inputValue)) {
        $("#" + variableId).val("");
        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("OnlyPersianLetters"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red',

                }
            }
        });
        return false
    } else {
        return true;

    }
    return true;
}
function validateEnglishInput(variableId) {
    var inputValue = $("#" + variableId).val();
    var persianLettersRegex = /^[a-zA-Z\s]+$/;

    if (!persianLettersRegex.test(inputValue)) {
        $("#" + variableId).val("");
        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("OnlyEnglishLetters"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red',

                }
            }
        });
        return false
    } else {
        return true;

    }
    return true;
}
function persianLetters(evt) {

    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode < 1570 || charCode > 1740) {
        if (charCode == 8 || charCode == 32 || charCode == 9) {
            $("#errorContainer").text("");
            return true;
        } else {
            $("#errorContainer").text("Error: Only Persian letters are allowed.");
            $.confirm({
                title: useXmltag("ErrorEnteringInformation"),
                content: useXmltag("OnlyPersianLetters"),
                autoClose: 'cancelAction|4000',
                escapeKey: 'cancelAction',
                type: 'red',
                buttons: {
                    cancelAction: {
                        text: useXmltag("Closing"),
                        btnClass: 'btn-red',

                    }
                }
            });
            return false;
        }

    }
    return true;
}

function RunPreRequestEntertainment(EntertainmentId, thiss) {

    loadingToggle(thiss)
    busy = 1;
    var mob = $('#Mobile_buyer').val();
    var Email_Address = $('#Email_buyer').val();
    var IdMember = '';

    $.post(amadeusPath + 'user_ajax.php',
       {
           mobile: mob,
           Email: Email_Address,
           flag: "register_memeber"
       },
       function (reponse) {
           var res = reponse.split(':');
           if (reponse.indexOf('success') > -1) {
               $('#IdMember').val(res[1]);
               IdMember = $('#IdMember').val();
               var dataForm = $('#formPassengerDetailEntertainmentForRequest').serialize();

               setTimeout(function () {
                   $.ajax({
                       type: 'POST',
                       url: amadeusPath + 'entertainment_ajax.php',
                       dataType: 'JSON',
                       data:
                          {
                              flag: 'PreRequest',
                              EntertainmentId: EntertainmentId,
                              dataForm: dataForm
                          },
                       success: function (data) {

                           busy = 0;

                           $('[name="factorNumber"]').val(data.factor_number);
                           $('[name="serviceName"]').val(data.service_name);
                           $("#formPassengerDetailEntertainmentForRequest").attr("action", amadeusPathByLang + 'factorRequest');
                           $("#formPassengerDetailEntertainmentForRequest").submit();




                       }
                   });
               }, 100);
           } else {
               busy = 0;
               loadingToggle(thiss,false)
               $('#loader_check').hide();
               $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));
               $.alert({
                   title: useXmltag("BuyTicket"),
                   icon: 'fa shopping-cart',
                   content: res[1],
                   rtl: true,
                   type: 'red'
               });
               return false;
           }
       });
}



function checkCodeMeli(code) {

    var L = code.length;
    if (L < 8 || parseInt(code, 10) == 0)
        return false;
    code = ('0000' + code).substr(L + 4 - 10);
    if (parseInt(code.substr(3, 6), 10) == 0)
        return false;
    var c = parseInt(code.substr(9, 1), 10);
    var s = 0;
    for (var i = 0; i < 9; i++)
        s += parseInt(code.substr(i, 1), 10) * (10 - i);
    s = s % 11;
    return (s < 2 && c == s) || (s >= 2 && c == (11 - s));
    /*return true;*/
}


function bookFlight(RequestNumber, IdMember, SourceId) {

    var SourceIdCheck = JSON.parse(SourceId);


    if (SourceIdCheck.dept == '8' || SourceIdCheck.dept == '12' || SourceIdCheck.TwoWay == '16') {
        var CaptchaCode = $('#LinkCaptcha').val();
    }

    if (SourceIdCheck.return !== '' && (SourceIdCheck.return == '8'  || SourceIdCheck.return == '12' || SourceIdCheck.TwoWay == '16')) {
        var CaptchaCodeReturn = $('#LinkCaptchaReturn').val();
    }


    if (CaptchaCode != '' && (SourceIdCheck.dept == '8' || SourceIdCheck.ToWay == '8' || SourceIdCheck.dept == '12' || SourceIdCheck.ToWay == '12' || SourceIdCheck.TwoWay == '16')) {
        var CaptchaCodeToEnglishNumber = '';
        CaptchaCodeToEnglishNumber = CaptchaCode.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function (d) {
            return d.charCodeAt(0) - 1632;
        })
           .replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function (d) {
               return d.charCodeAt(0) - 1776;
           });

    } else {
        var CaptchaCodeToEnglishNumber = '';
    }

    if (CaptchaCodeReturn != '' && (SourceIdCheck.return == '8' || SourceIdCheck.return == '12' || SourceIdCheck.TwoWay == '16')) {

        var CaptchaCodeReturnToEnglishNumber = '';
        CaptchaCodeReturnToEnglishNumber = CaptchaCodeReturn.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function (d) {
            return d.charCodeAt(0) - 1632;
        })
           .replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function (d) {
               return d.charCodeAt(0) - 1776;
           });

    } else {
        var CaptchaCodeReturnToEnglishNumber = '';
    }

    /* if (!$('#RulsCheck').is(':checked')) {
         $.alert({
             title: useXmltag("Note"),
             icon: 'fa fa-cart-plus',
             content: useXmltag("ConfirmTermsFirst"),
             rtl: true,
             type: 'red'
         });
         $('#loader_check').hide();
         $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

         return false;
     }*/
    if ((CaptchaCode == "" || CaptchaCodeReturn == "") && (SourceIdCheck.dept == '8' || SourceIdCheck.return == '8' || SourceIdCheck.ToWay == '8' || SourceIdCheck.dept == '12' || SourceIdCheck.return == '12' || SourceIdCheck.ToWay == '12' ||  SourceIdCheck.ToWay == '16')) {
        $.alert({
            title: useXmltag("Note"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseentersecuritycode"),
            rtl: true,
            type: 'red'
        });

        return false;
    }



    /*   $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').attr('onclick', 'return false').css('opacity', '0.5').css('cursor', 'progress');

       $('#loader_check').css("display", "block");*/

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'JSON',
        data:
           {
               flag: 'bookFlight',
               RequestNumber: RequestNumber,
               IdMember: IdMember,
               SourceId: SourceId,
               CaptchaCode: CaptchaCodeToEnglishNumber,
               CaptchaReturnCode: CaptchaCodeReturnToEnglishNumber
           },
        success: function (data) {

            if (data.total_status == 'success') {

                setTimeout(
                   function () {
                       $('#loader_check').hide();
                       $('#formPassengerDetailLocal').submit();
                   }, 2000);

            }
            else {
                setTimeout(function () {
                    $('#loader_check').hide();
                    $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

                    var error_message = '';
                    var error_code = '';
                    if (data.dept.result_status == 'error') {



                        if (typeof data.dept.result_message == 'object') {
                            error_message = Object.values(data.dept.result_message)
                        } else {
                            error_message = data.dept.result_message;

                        }

                        error_code = data.dept.result_code;

                        if (error_code == '-402' || error_code == '-458' || error_code == '-411') {


                            var src = btoa($("#LinkCaptchaOriginal").val());

                            $.confirm({
                                title: useXmltag('BuyTicket'),
                                content: error_message,
                                type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    tryAgain: {
                                        text: useXmltag('Repeatsearch'),
                                        btnClass: 'btn-green',
                                        action: function () {

                                            let url_research = $('.cancel-passenger').attr('data-url');
                                            window.location.href = url_research;
                                        }
                                    },
                                    close: {
                                        text: useXmltag('searchReturnToMainPage'),
                                        btnClass: 'btn-red',
                                        action: function () {

                                            window.location.href = rootMainPath ;
                                        }
                                    }
                                }
                            });
                            $('#loader_check').hide();
                            $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

                            var ssrc = 'data:image/png;base64,' + src + '&temp=12112';

                            $("#LinkCaptchaImg").attr('src', ssrc);
                        }
                    }
                    else if (typeof data.return !== 'undefined' && data.return.result_status == 'error') {

                        if (typeof data.return.result_message == 'object') {
                            error_message = Object.values(data.return.result_message)
                            error_code = Object.values(data.return.result_code)
                        } else {
                            error_message = data.return.result_message;
                            error_code = data.return.result_code;
                        }

                        if (error_code == '-402' || error_code == '-458' || error_code == '-411') {

                            var src = btoa($("#LinkCaptchaOriginal").val());
                            var src_return = btoa($("#LinkCaptchaReturnOriginal").val());

                            $('#loader_check').hide();
                            $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

                            var ssrc = 'data:image/png;base64,' + src + '&temp=12112';
                            var ssrc_return = 'data:image/png;base64,'+src_return + '&temp=121556';

                            $("#LinkCaptchaImg").attr('src', ssrc);
                            $("#LinkCaptchaReturnImg").attr('src', ssrc_return);

                        }

                    }
                    else if(data.multi_destination.result_status == 'error'){
                        if (typeof data.multi_destination.result_message == 'object') {
                            error_message = Object.values(data.multi_destination.result_message)
                            error_code = Object.values(data.multi_destination.result_code)
                        } else {
                            error_message = data.multi_destination.result_message;
                            error_code = data.multi_destination.result_code;
                        }
                    }

                    $.confirm({
                        title: useXmltag('Errorbookingticket'),
                        content: error_message,
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: useXmltag('Repeatsearch'),
                                btnClass: 'btn-green',
                                action: function () {

                                    let url_research = $('.cancel-passenger').attr('data-url');
                                    window.location.href = url_research;
                                }
                            },
                            close: {
                                text: useXmltag('searchReturnToMainPage'),
                                btnClass: 'btn-red',
                                action: function () {

                                    window.location.href = rootMainPath ;
                                }
                            }
                        }
                    });
                    $('#loader_check').hide();
                    $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

                }, 1000);
            }

        }
    });



}

function members(mob, Email_Address) {
    var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
    var patt = new RegExp("[0-9]");
    // var res = patt.test(tel);
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var error_member = 0;
    if (mob == "" || Email_Address == "") {
        $("#messageInfo").html(useXmltag("Fillingallfieldsrequired"));
        error_member = 1;
    } else if (!mobregqx.test(mob)) {
        $("#messageInfo").html('<br>' + useXmltag("MobileNumberIncorrect"));
        error_member = 1;
    } else if (!emailReg.test(Email_Address)) {
        $("#messageInfo").html('<br>' + useXmltag("Pleaseenteremailcorrectformat"));
        error_member = 1;
    }
    /*else if (res == false) {
     $("#messageInfo").html('<br>شماره تلفن ثابت  فقط شامل عدد می باشد');
     error_member = 1;
     }*/

    if (error_member == 0) {
        return 'true';
    } else {
        return 'false';
    }


}


function convertNumber(arg) {
    return arg.replace(/[\u06F0-\u06F9]+/g, function (digit) {
        var ret = '';
        for (var i = 0, len = digit.length; i < len; i++) {
            ret += String.fromCharCode(digit.charCodeAt(i) - 1728);
        }

        return ret;
    });
}

function checkNumber(evt, Input) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ($.inArray(charCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
       // Allow: Ctrl/cmd+A
       charCode == 65 ||
       // Allow: Ctrl/cmd+C
       charCode == 67 ||
       // Allow: Ctrl/cmd+X
       charCode == 88 ||
       // Allow: home, end, left, right
       (charCode >= 35 && charCode <= 39)) {
        // let it happen, don't do anything
        return true;
    }
    // Ensure that it is a number and stop the keypress
    if ((charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105) && charCode != 229 && charCode != 67 && charCode != 65 && charCode != 88) {

        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("NumberOnly"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red'

                }
            }
        });


        return false
    }

}

function getNationalCode(Code, Input) {

    var National = $('.UniqNationalCode').map(function () {
        return $(this).val();
    });

    var NationalCodes = National.get();
    var NationalCodesArray = [];
    var NationalCodesArray = NationalCodes.toString().split(',');
    var flag = 0;

    $.each(NationalCodesArray, function (index, element) {

        if (element != "" && Code == element) {
            // alert(element);
            flag = parseInt(flag) + 1;
        }

    });

    if (flag != 0 && flag != 1) {
        return false;
    }
}


function Adult_members(currentDate, numAdult) {


    //  بررسی فیلدهای بزرگسالان
    var error = 0;
    for (i = 1; i <= numAdult; i++) {
        var gender = '';
        var messageElement = $("#messageA" + i);
        var nameFa = $("#nameFaA" + i);
        var familyFa = $("#familyFaA" + i);
        var nameEn = $("#nameEnA" + i);
        var familyEn = $("#familyEnA" + i);
        var GenderSelector = $("#genderA" + i);
        var nationalInput = $("#NationalCodeA" + i);
        var birthdayInput = $("#birthdayA" + i);
        var passportCountry = $("#passportCountryA" + i);
        var passportCountrySelect2Element =  $('#select2-passportCountryA'+i+'-container');
        var passportNumber = $("#passportNumberA" + i);
        var passportExpire = $("#passportExpireA" + i);
        var birthdayEn = $("#birthdayEnA" + i);

        var scrollToElement = function (elementId) {
            console.log('scroll started');
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#" + elementId).offset().top - 120
            }, 1000);
            console.log('scroll ended');
        };

        GenderSelector.removeClass('border-danger');
        nameFa.removeClass('border-danger');
        familyFa.removeClass('border-danger');
        nameEn.removeClass('border-danger');
        familyEn.removeClass('border-danger');
        nationalInput.removeClass('border-danger');
        birthdayInput.removeClass('border-danger');
        birthdayEn.removeClass('border-danger');
        passportCountrySelect2Element.removeClass('border-danger');
        passportExpire.removeClass('border-danger');
        passportNumber.removeClass('border-danger');

        gender = $("#genderA" + i + " option:selected").val();

        if(lang !='fa'){
            if (/*nameEn.val() == "" || familyEn.val() == "" ||*/ gender == "") {
                /* nameFa.addClass('border-danger');
                 familyFa.addClass('border-danger');*/
                nameEn.addClass('border-danger');
                familyEn.addClass('border-danger');
                GenderSelector.addClass('border-danger');
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }else{
            if (/*nameFa.val() == "" || familyFa.val() == "" ||*/ nameEn.val() == "" || familyEn.val() == "" || gender == "") {
                /*nameFa.addClass('border-danger');
                familyFa.addClass('border-danger');*/
                nameEn.addClass('border-danger');
                familyEn.addClass('border-danger');
                GenderSelector.addClass('border-danger');
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }


        //بررسی پر کردن فیلد ##Sex##
        if (gender != 'Male' && gender != 'Female') {
            GenderSelector.addClass('border-danger');
            messageElement.html('<br>' + useXmltag("SpecifyGender"));

            error = 1;
        }

        if ($('#ZoneFlight').val() != 'Local' && $('#typeReserve').val() !='package'  && $('#ZoneFlight').val() !='TestParto') {
            if ($("#passportNumberA" + i).val() == "" || $("#passportExpireA" + i).val() == "") {

                messageElement.html(useXmltag("FillingPassportRequired"));

                error = 1;
            }

            let passport_number_value = passportNumber.val() ;
            let first_letter = passport_number_value.charAt(0) ;
            let remain_number_remain = passport_number_value.slice(1) ;
            let check_letter= /^[a-zA-Z]+$/;
            let check_number = /^[0-9]+$/;


            console.log('sssss=>'+passport_number_value)
            console.log('country=>'+$('input[name=passengerNationalityA' + i + ']:checked').val())
            console.log('check_letter=>'+ [first_letter,check_letter.test(first_letter)])
            console.log('check_number=>'+ [remain_number_remain,check_number.test(remain_number_remain)])
            console.log('passport_number_value.length=>'+passport_number_value.length)
            // (!check_letter.test(first_letter) || !check_number.test(remain_number_remain) ||
            if(( passport_number_value.length > 10)  && ($('input[name=passengerNationalityA' + i + ']:checked').val() == '0')){
                messageElement.html(useXmltag("IranianPassportIncorrectFormat"));
                error = 1;
            }else if(error != 1){

                messageElement.html('')
            }

            //بررسی تاریخ انقضای پاسپورت
            var t = passportExpire.val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);


            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                messageElement.html(useXmltag("ExpirationPassportValidSevenMonths"));

                error = 1;
            }
        }

        if ($('input[name=passengerNationalityA' + i + ']:checked').val() == '1' || lang !="fa") {
            if (birthdayEn.val() == "" || passportCountry.val() == "" || passportNumber.val() == "" || passportExpire.val() == "") {
                if(birthdayEn.val() == "")
                {
                    birthdayEn.addClass('border-danger');
                }
                if(passportCountry.val() == ""){
                    passportCountrySelect2Element.css('border','1px solid #dc3545');

                }

                if(passportNumber.val() == ""){
                    passportNumber.addClass('border-danger');

                }


                if(passportExpire.val() == ""){
                    passportExpire.addClass('border-danger');

                }

                console.log($("#birthdayEnA" + i).val());
                console.log($("#passportCountryA" + i).val());
                console.log($("#passportNumberA" + i).val());
                console.log($("#passportExpireA" + i).val());

                messageElement.html(useXmltag("CompletingFieldsRequired"));

                error = 1;
            }


            //بررسی تاریخ انقضای پاسپورت
            var t = passportExpire.val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                messageElement.html(useXmltag("ExpirationPassportValidSevenMonths"));
                passportExpire.addClass('border-danger');

                error = 1;
            }

        }
        else{
            var National_Code = nationalInput.val();
            if (birthdayInput.val() == "" || National_Code == "") {
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                birthdayInput.addClass('border-danger');
                nationalInput.addClass('border-danger');
                error = 1;
            }


            var CheckEqualNationalCode = getNationalCode(National_Code, nationalInput);
            if (CheckEqualNationalCode == false) {
                messageElement.html('<br>' + useXmltag("NationalCodeDuplicate"));
                nationalInput.addClass('border-danger');

                error = 1;
            }

            var z1 = /^[0-9]*\d$/;
            var convertedCode = convertNumber(National_Code);

            if (National_Code != "") {
                if (!z1.test(convertedCode)) {
                    messageElement.html('<br>' + useXmltag("NationalCodeNumberOnly"));
                    $([document.documentElement, document.body]).animate({
                        scrollTop: messageElement.offset().top + 100
                    }, 1000);
                    error = 1;
                } else if ((National_Code.toString().length != 10)) {
                    $([document.documentElement, document.body]).animate({
                        scrollTop: messageElement.offset().top + 100
                    }, 1000);
                    messageElement.html('<br>' + useXmltag("OnlyTenDigitsNationalCode"));
                    error = 1;
                } else {
                    var NCode = checkCodeMeli(convertNumber(National_Code));
                    if (!NCode) {
                        $([document.documentElement, document.body]).animate({
                            scrollTop: messageElement.offset().top + 100
                        }, 1000);
                        messageElement.html('<br>' + useXmltag("EnteredCationalCodeNotValid"));
                        error = 1;
                    }
                }
            }

            //بررسی تاریخ تولد
            var t = birthdayInput.val();
            var splitit = t.split('-');
            var JDate = require('jdate');
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
            var array = $.map(jdate2, function (value, index) {
                return [value];
            });
            var d = new Date(array[0]);
            var n = Math.round(d.getTime() / 1000);

            console.assert(((currentDate- n) > 378691200),'error in birthday');
            if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
                $([document.documentElement, document.body]).animate({
                    scrollTop: messageElement.offset().top + 100
                }, 1000);
                messageElement.html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }
    }

    if (error == 1) {
        scrollToElement("messageA1");
    }
    addIconErrorMsg();

    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }


}

function Chd_memebrs(currentDate, numChild) {
    var error = 0;
    for (i = 1; i <= numChild; i++) {
        var gender = '';
        var messageElement = $("#messageC" + i);
        var nameFa = $("#nameFaC" + i);
        var familyFa = $("#familyFaC" + i);
        var nameEn = $("#nameEnC" + i);
        var familyEn = $("#familyEnC" + i);
        var GenderSelector = $("#genderC" + i);
        var nationalInput = $("#NationalCodeC" + i);
        var birthdayInput = $("#birthdayC" + i);
        var passportCountry = $("#passportCountryC" + i);
        var passportCountrySelect2Element =  $('#select2-passportCountryC'+i+'-container');
        var passportNumber = $("#passportNumberC" + i);
        var passportExpire = $("#passportExpireC" + i);
        var birthdayEn = $("#birthdayEnC" + i);

        var scrollToElement = function (elementId) {
            console.log('scroll started');
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#" + elementId).offset().top - 120
            }, 1000);
            console.log('scroll ended');
        };

        GenderSelector.removeClass('border-danger');
        nameFa.removeClass('border-danger');
        familyFa.removeClass('border-danger');
        nameEn.removeClass('border-danger');
        familyEn.removeClass('border-danger');
        nationalInput.removeClass('border-danger');
        birthdayInput.removeClass('border-danger');
        birthdayEn.removeClass('border-danger');
        passportCountrySelect2Element.removeClass('border-danger');
        passportExpire.removeClass('border-danger');
        passportNumber.removeClass('border-danger');

        gender = $("#genderC" + i + " option:selected").val();

        if(lang !='fa'){
            if (/*nameEn.val() == "" || familyEn.val() == "" ||*/ gender == "") {
                /*nameFa.addClass('border-danger');
                familyFa.addClass('border-danger');*/
                nameEn.addClass('border-danger');
                familyEn.addClass('border-danger');
                GenderSelector.addClass('border-danger');
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }else{
            if (/*nameFa.val() == "" || familyFa.val() == "" ||*/ nameEn.val() == "" || familyEn.val() == "" || gender == "") {
                /*nameFa.addClass('border-danger');
                familyFa.addClass('border-danger');*/
                nameEn.addClass('border-danger');
                familyEn.addClass('border-danger');
                GenderSelector.addClass('border-danger');
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }


        //بررسی پر کردن فیلد ##Sex##
        if (gender != 'Male' && gender != 'Female') {
            GenderSelector.addClass('border-danger');
            messageElement.html('<br>' + useXmltag("SpecifyGender"));

            error = 1;
        }

        if ($('#ZoneFlight').val() != 'Local' && $('#typeReserve').val() !='package'  && $('#typeReserve').val() !='TestParto') {
            if ($("#passportNumberC" + i).val() == "" || $("#passportExpireC" + i).val() == "") {
                messageElement.html(useXmltag("FillingPassportRequired"));

                error = 1;
            }

            let passport_number_value = passportNumber.val() ;
            let first_letter = passport_number_value.charAt(0) ;
            let remain_number_remain = passport_number_value.slice(1) ;
            let check_letter= /^[a-zA-Z]+$/;
            let check_number = /^[0-9]+$/;


            // !check_letter.test(first_letter) || !check_number.test(remain_number_remain) ||
            if(( passport_number_value.length > 10 )  && ($('input[name=passengerNationalityA' + i + ']:checked').val() == '0')){
                messageElement.html(useXmltag("IranianPassportIncorrectFormat"));
                error = 1;
            }else{
                messageElement.html('')
            }
            //بررسی تاریخ انقضای پاسپورت
            var t = passportExpire.val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);

            console.assert(((n - currentDate) > 18662400),'childasda');
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                messageElement.html(useXmltag("ExpirationPassportValidSevenMonths"));

                error = 1;
            }
        }

        if ($('input[name=passengerNationalityC' + i + ']:checked').val() == '1' || lang !="fa") {
            if (birthdayEn.val() == "" || passportCountry.val() == "" || passportNumber.val() == "" || passportExpire.val() == "") {


                if(birthdayEn.val() == "")
                {
                    birthdayEn.addClass('border-danger');
                }
                if(passportCountry.val() == ""){
                    passportCountrySelect2Element.css('border','1px solid #dc3545');;

                }

                if(passportNumber.val() == ""){
                    passportNumber.addClass('border-danger');

                }


                if(passportExpire.val() == ""){
                    passportExpire.addClass('border-danger');

                }

                console.log($("#birthdayEnC" + i).val());
                console.log($("#passportCountryC" + i).val());
                console.log($("#passportNumberC" + i).val());
                console.log($("#passportExpireC" + i).val());

                messageElement.html(useXmltag("CompletingFieldsRequired"));

                error = 1;
            }

            //بررسی تاریخ انقضای پاسپورت
            var t = passportExpire.val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                messageElement.html(useXmltag("ExpirationPassportValidSevenMonths"));
                passportExpire.addClass('border-danger');

                error = 1;
            }

        } else{
            var National_Code = nationalInput.val();
            if (birthdayInput.val() == "" || National_Code == "") {
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                birthdayInput.addClass('border-danger');
                nationalInput.addClass('border-danger');
                error = 1;
            }


            var CheckEqualNationalCode = getNationalCode(National_Code, nationalInput);
            if (CheckEqualNationalCode == false) {
                messageElement.html('<br>' + useXmltag("NationalCodeDuplicate"));
                nationalInput.addClass('border-danger');

                error = 1;
            }

            var z1 = /^[0-9]*\d$/;
            var convertedCode = convertNumber(National_Code);
            if (National_Code != "") {
                if (!z1.test(convertedCode)) {
                    messageElement.html('<br>' + useXmltag("NationalCodeNumberOnly"));
                    $([document.documentElement, document.body]).animate({
                        scrollTop: messageElement.offset().top + 100
                    }, 1000);
                    error = 1;
                } else if ((National_Code.toString().length != 10)) {
                    $([document.documentElement, document.body]).animate({
                        scrollTop: messageElement.offset().top + 100
                    }, 1000);
                    messageElement.html('<br>' + useXmltag("OnlyTenDigitsNationalCode"));
                    error = 1;
                } else {
                    var NCode = checkCodeMeli(convertNumber(National_Code));
                    if (!NCode) {
                        $([document.documentElement, document.body]).animate({
                            scrollTop: messageElement.offset().top + 100
                        }, 1000);
                        messageElement.html('<br>' + useXmltag("EnteredCationalCodeNotValid"));
                        error = 1;
                    }
                }
            }

            //بررسی تاریخ تولد
            var t = birthdayInput.val();
            var splitit = t.split('-');
            var JDate = require('jdate');
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
            var array = $.map(jdate2, function (value, index) {
                return [value];
            });


            var d = new Date(array[0]);
            var n = Math.round(d.getTime() / 1000);

            if ((currentDate - n) < 63072000 || 378691200 < (currentDate - n)) {// 2سال = 2*365*24*60*60  , 12سال =(12*365+3)*24*60*60
                $([document.documentElement, document.body]).animate({
                    scrollTop: messageElement.offset().top + 100
                }, 1000);
                messageElement.html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }
    }
    addIconErrorMsg();
    if (error == 1) {
        scrollToElement("messageC1");
    }

    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function Inf_members(currentDate, numInfant) {
    var error = 0;
    for (i = 1; i <= numInfant; i++) {
        var gender = '';
        var messageElement = $("#messageI" + i);
        var nameFa = $("#nameFaI" + i);
        var familyFa = $("#familyFaI" + i);
        var nameEn = $("#nameEnI" + i);
        var familyEn = $("#familyEnI" + i);
        var GenderSelector = $("#genderI" + i);
        var nationalInput = $("#NationalCodeI" + i);
        var birthdayInput = $("#birthdayI" + i);
        var passportCountry = $("#passportCountryI" + i);
        var passportCountrySelect2Element = $('#select2-passportCountryI'+i+'-container')
        var passportNumber = $("#passportNumberI" + i);
        var passportExpire = $("#passportExpireI" + i);
        var birthdayEn = $("#birthdayEnI" + i);

        var scrollToElement = function (elementId) {
            console.log('scroll started');
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#" + elementId).offset().top - 120
            }, 1000);
            console.log('scroll ended');
        };

        GenderSelector.removeClass('border-danger');
        nameFa.removeClass('border-danger');
        familyFa.removeClass('border-danger');
        nameEn.removeClass('border-danger');
        familyEn.removeClass('border-danger');
        nationalInput.removeClass('border-danger');
        birthdayInput.removeClass('border-danger');
        birthdayEn.removeClass('border-danger');
        passportCountrySelect2Element.removeClass('border-danger');
        passportExpire.removeClass('border-danger');
        passportNumber.removeClass('border-danger');

        gender = $("#genderI" + i + " option:selected").val();

        if(lang !='fa'){
            if (/*nameEn.val() == "" || familyEn.val() == "" ||*/ gender == "") {
                /*          nameFa.addClass('border-danger');
                          familyFa.addClass('border-danger');*/
                nameEn.addClass('border-danger');
                familyEn.addClass('border-danger');
                GenderSelector.addClass('border-danger');
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }else{
            if (/*nameFa.val() == "" || familyFa.val() == ""||*/ nameEn.val() == "" || familyEn.val() == "" || gender == "") {
                /* nameFa.addClass('border-danger');
                 familyFa.addClass('border-danger');*/
                nameEn.addClass('border-danger');
                familyEn.addClass('border-danger');
                GenderSelector.addClass('border-danger');
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                error = 1;
            }
        }


        //بررسی پر کردن فیلد ##Sex##
        if (gender != 'Male' && gender != 'Female') {
            GenderSelector.addClass('border-danger');
            messageElement.html('<br>' + useXmltag("SpecifyGender"));

            error = 1;
        }

        if ($('#ZoneFlight').val() != 'Local' && $('#typeReserve').val() !='package'  && $('#typeReserve').val() !='TestParto') {
            if ($("#passportNumberI" + i).val() == "" || $("#passportExpireI" + i).val() == "") {
                messageElement.html(useXmltag("FillingPassportRequired"));

                error = 1;
            }
            let passport_number_value = passportNumber.val() ;
            let first_letter = passport_number_value.charAt(0) ;
            let remain_number_remain = passport_number_value.slice(1) ;
            let check_letter= /^[a-zA-Z]+$/;
            let check_number = /^[0-9]+$/;


            // !check_letter.test(first_letter) || !check_number.test(remain_number_remain) ||
            if((passport_number_value.length > 10 )  && ($('input[name=passengerNationalityA' + i + ']:checked').val() == '0')){
                messageElement.html(useXmltag("IranianPassportIncorrectFormat"));
                error = 1;
            }else{
                messageElement.html('')
            }
            //بررسی تاریخ انقضای پاسپورت
            var t = passportExpire.val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);

            console.assert(((n - currentDate) > 18662400),'childasda');
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                messageElement.html(useXmltag("ExpirationPassportValidSevenMonths"));

                error = 1;
            }
        }

        if ($('input[name=passengerNationalityI' + i + ']:checked').val() == '1' || lang !="fa") {
            if (birthdayEn.val() == "" || passportCountry.val() == "" || passportNumber.val() == "" || passportExpire.val() == "") {
                if(birthdayEn.val() == "")
                {
                    birthdayEn.addClass('border-danger');
                }
                if(passportCountry.val() == ""){
                    passportCountrySelect2Element.css('border','1px solid #dc3545');

                }

                if(passportNumber.val() == ""){
                    passportNumber.addClass('border-danger');

                }


                if(passportExpire.val() == ""){
                    passportExpire.addClass('border-danger');

                }



                console.log($("#birthdayEnI" + i).val());
                console.log($("#passportCountryI" + i).val());
                console.log($("#passportNumberI" + i).val());
                console.log($("#passportExpireI" + i).val());

                messageElement.html(useXmltag("CompletingFieldsRequired"));

                error = 1;
            }

            //بررسی تاریخ انقضای پاسپورت
            var t = passportExpire.val();
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((n - currentDate) < 18662400) { // 7 ماه =(7*30+6)*24*60*60
                messageElement.html(useXmltag("ExpirationPassportValidSevenMonths"));
                passportExpire.addClass('border-danger');

                error = 1;
            }

        } else{
            var National_Code = nationalInput.val();
            if (birthdayInput.val() == "" || National_Code == "") {
                messageElement.html(useXmltag("CompletingFieldsRequired"));
                birthdayInput.addClass('border-danger');
                nationalInput.addClass('border-danger');
                error = 1;
            }


            var CheckEqualNationalCode = getNationalCode(National_Code, nationalInput);
            if (CheckEqualNationalCode == false) {
                messageElement.html('<br>' + useXmltag("NationalCodeDuplicate"));
                nationalInput.addClass('border-danger');

                error = 1;
            }

            var z1 = /^[0-9]*\d$/;
            var convertedCode = convertNumber(National_Code);
            if (National_Code != "") {
                if (!z1.test(convertedCode)) {
                    messageElement.html('<br>' + useXmltag("NationalCodeNumberOnly"));
                    $([document.documentElement, document.body]).animate({
                        scrollTop: messageElement.offset().top + 100
                    }, 1000);
                    error = 1;
                } else if ((National_Code.toString().length != 10)) {
                    $([document.documentElement, document.body]).animate({
                        scrollTop: messageElement.offset().top + 100
                    }, 1000);
                    messageElement.html('<br>' + useXmltag("OnlyTenDigitsNationalCode"));
                    error = 1;
                } else {
                    var NCode = checkCodeMeli(convertNumber(National_Code));
                    if (!NCode) {
                        $([document.documentElement, document.body]).animate({
                            scrollTop: messageElement.offset().top + 100
                        }, 1000);
                        messageElement.html('<br>' + useXmltag("EnteredCationalCodeNotValid"));
                        error = 1;
                    }
                }
            }

            //بررسی تاریخ تولد
            var t = birthdayInput.val();
            var splitit = t.split('-');
            var JDate = require('jdate');
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
            var array = $.map(jdate2, function (value, index) {
                return [value];
            });


            var d = new Date(array[0]);
            var n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) > 63072000) { // 2سال = 2*365*24*60*60
                $([document.documentElement, document.body]).animate({
                    scrollTop: messageElement.offset().top + 100
                }, 1000);
                messageElement.html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }
    }
    addIconErrorMsg();
    if (error == 1) {
        scrollToElement("messageI1");
    }

    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function goToBank(Obj, link, inputs) {

    $('.cashPaymentLoader').addClass("skeleton").attr("disabled", "disabled").css('cursor', 'default').removeAttr('onclick',true);
    var credit_status = '';
    var price_to_pay = '';
    if ($(".price-after-discount-code").length > 0) {
        price_to_pay = parseInt($(".price-after-discount-code").html().replace(/,/g, ''));
    }

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'JSON',
        data:
           {
               flag: 'checkMemberCredit',
               priceToPay: price_to_pay,
               creditUse: $("input[name='chkCreditUse']:checked").val()
           },
        success: function (data) {

            credit_status = data.result_status;

            if ($("input[name='bank']").is(':checked') || credit_status == 'full_credit') {

                var discountCode = '';
                if ($('#discount-code').length > 0) {
                    discountCode = $('#discount-code').val();
                }
                inputs['discountCode'] = discountCode;
                inputs['selectedBank'] = $("input[type='radio'][name='bank']:checked").val();

                if ($("input[name='chkCreditUse']").length > 0 && $("input[name='chkCreditUse']:checked").val() == 'member_credit') {
                    inputs['memberCreditUse'] = true;
                }
                if ($("input[name='bank']").length > 0 && $("input[name='bank']:checked").val() == 'privateGetWayCharter724') {
                    inputs['privateGetWayCharter724'] = true;
                    link = amadeusPath + 'goToBankCharter724Private';
                }
                if ($("input[name='bank']").length > 0 && $("input[name='bank']:checked").val() == 'PaymentSamanInsurance') {
                    inputs['PaymentSamanInsurance'] = true;
                    inputs['redirectUrl'] = $('#redirectUrl').val();
                    link = amadeusPath + 'goToBankSamanInsurance';
                }

                $.ajax({
                    type: 'POST',
                    url: amadeusPath + 'user_ajax.php',
                    data: inputs,
                    success: function (data) {
                        if (data.indexOf('TRUE') > -1) {
                            var form = document.createElement("form");
                            form.setAttribute("method", "POST");
                            form.setAttribute("action", link);
                            $.each(inputs, function (i, item) {
                                if (typeof item === 'object' && item !== null) {
                                    $.each(item, function (j, item2) {
                                        var hiddenField = document.createElement("input");
                                        hiddenField.setAttribute("type", "hidden");
                                        hiddenField.setAttribute("name", i + '[' + j + ']');
                                        hiddenField.setAttribute("value", item2);
                                        form.appendChild(hiddenField);
                                    });
                                } else {
                                    var hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", i);
                                    hiddenField.setAttribute("value", item);
                                    form.appendChild(hiddenField);
                                }
                            });

                            var bank = document.createElement("input");
                            bank.setAttribute("type", "hidden");
                            bank.setAttribute("name", "bankType");
                            // alert('aaaaaa');
                            if (credit_status == 'full_credit') {
                                // alert('4545454545');
                                bank.setAttribute("value", "credit");
                            } else {
                                // alert('696969');
                                var radioValue = $("input[name='bank']:checked").val();
                                bank.setAttribute("value", radioValue);
                            }

                            form.appendChild(bank);
                            document.body.appendChild(form);
                            console.dir(form);
                            form.submit();
                            document.body.removeChild(form);
                        } else {
                            if(data.indexOf('FalseGetWay') > -1)
                            {
                                $(Obj).removeAttr('onclick').attr("disabled", "disabled").css("opacity", "0.5");
                                $(Obj).parent('div').append('<span id="onlinemessages" style="color:#FF0000;">' + useXmltag("PreventPayForNoCredit") + '</span>');

                            }else {
                                $(Obj).removeAttr('onclick').attr("disabled", "disabled").css("opacity", "0.5");
                                $(Obj).parent('div').append('<span id="onlinemessages" style="color:#664d03;">' + useXmltag("SystemUpdatedTryLater") + '</span>');

                            }
                        }
                    }
                });

            } else {
                $.alert({
                    title: useXmltag("SelectBankPort"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("PleaseSelectBank"),
                    rtl: true,
                    type: 'red'
                });
            }
        }
    });


}


function currencyPayment(Obj, link, inputs) {

    if ($('#cardNumber').val() != '' && $('#cardExpireMonth').val() != '' && $('#cardExpireYear').val() != '' && $('#cardCVC').val() != '') {

        $.alert({
            title: useXmltag("Payment"),
            icon: 'fa fa-shopping-cart',
            content: useXmltag("SureOfYurPurchase"),
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: useXmltag("Approve"),
                    btnClass: 'btn-green',
                    action: function () {

                        var discountCode = '';
                        if ($('#discount-code').length > 0) {
                            discountCode = $('#discount-code').val();
                        }
                        inputs['discountCode'] = discountCode;

                        $.ajax({
                            type: 'POST',
                            url: amadeusPath + 'user_ajax.php',
                            data: inputs,
                            success: function (response) {

                                if (response.indexOf('TRUE') > -1) {

                                    inputs['flag'] = 'currencyPayment';
                                    inputs['cardNumber'] = $('#cardNumber').val();
                                    inputs['cardExpireMonth'] = $('#cardExpireMonth').val();
                                    inputs['cardExpireYear'] = $('#cardExpireYear').val();
                                    inputs['cardCVC'] = $('#cardCVC').val();

                                    $.ajax({
                                        type: 'POST',
                                        url: amadeusPath + 'user_ajax.php',
                                        dataType: 'JSON',
                                        data: inputs,
                                        success: function (response) {

                                            if (response.result_status == 'success') {
                                                var form = document.createElement("form");
                                                form.setAttribute("method", "POST");
                                                form.setAttribute("action", link);

                                                $.each(inputs, function (i, item) {
                                                    if (typeof item === 'object' && item !== null) {
                                                        $.each(item, function (j, item2) {
                                                            var hiddenField = document.createElement("input");
                                                            hiddenField.setAttribute("type", "hidden");
                                                            hiddenField.setAttribute("name", i + '[' + j + ']');
                                                            hiddenField.setAttribute("value", item2);
                                                            form.appendChild(hiddenField);

                                                        });
                                                    } else {
                                                        var hiddenField = document.createElement("input");
                                                        hiddenField.setAttribute("type", "hidden");
                                                        hiddenField.setAttribute("name", i);
                                                        hiddenField.setAttribute("value", item);
                                                        form.appendChild(hiddenField);
                                                    }
                                                });

                                                var hiddenField = document.createElement("input");
                                                hiddenField.setAttribute("type", "hidden");
                                                hiddenField.setAttribute("name", "trackingCode");
                                                hiddenField.setAttribute("value", response.result_message);
                                                form.appendChild(hiddenField);

                                                document.body.appendChild(form);
                                                form.submit();
                                                document.body.removeChild(form);
                                            } else {
                                                $(Obj).removeAttr('onclick').attr("disabled", "disabled").css("opacity", "0.5");
                                                $(Obj).parent('div').append('<span id="onlinemessages" style="color:#FF0000;">' + response.result_message + '</span>');
                                            }
                                        }
                                    });

                                } else {

                                    $(Obj).removeAttr('onclick').attr("disabled", "disabled").css("opacity", "0.5");
                                    $(Obj).parent('div').append('<span id="onlinemessages" style="color:#FF0000;">' + useXmltag("SystemUpdatedTryLater") + '</span>');
                                }
                            }
                        });
                    }
                },
                cancel: {
                    text: useXmltag("Optout"),
                    btnClass: 'btn-orange',
                }
            }
        });

    } else {
        $.alert({
            title: useXmltag("CardInformationPayment"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("PleaseEnterCardInformationPayment"),
            rtl: true,
            type: 'red'
        });
    }
}


/**
 * Login form
 * @returns {Boolean}
 */
function memberLocalLogin() {

    var PrivateCharter = $('#PrivateCharter').val();
    var IdPrivate = $('#IdPrivate').val();

    if (PrivateCharter == 'privateCharter') {
        SendInfoLoginToPrivate(IdPrivate);
    } else {
        send_info_passengers();
    }

    /*var error = 0;
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
    if ($('#signin-organization2').length > 0) {
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

    // send  for logon
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
                    var PrivateCharter = $('#PrivateCharter').val();
                    var IdPrivate = $('#IdPrivate').val();

                    if (PrivateCharter == 'privateCharter') {
                        SendInfoLoginToPrivate(IdPrivate);
                    } else {
                        send_info_passengers();
                    }
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
                                var PrivateCharter = $('#PrivateCharter').val();
                                var IdPrivate = $('#IdPrivate').val();

                                if (PrivateCharter == 'privateCharter') {
                                    SendInfoLoginToPrivate(IdPrivate);
                                } else {
                                    send_info_passengers();
                                }

                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        })

                }
            })
    } else {
        return false;
    }*/
}


/*function memberLocalRegister() {

    // Rid Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    $(".message-register").html('');

    // Get values
    var name = $("#signup-name2").val();
    var family = $("#signup-family2").val();
    var mobile = $("#signup-mobile2").val();
    var email = $("#signup-email2").val();
    var reagentCode = $("#reagent-code2").val();

    //check values
    if (!name) {
        $("#error-signup-name2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signup-name2").css("opacity", "1");
        $("#error-signup-name2").css("visibility", "visible");
        error = 1;
    }

    if (!family) {
        $("#error-signup-family2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signup-family2").css("opacity", "1");
        $("#error-signup-family2").css("visibility", "visible");
        error = 1;
    }

    if (!mobile) {
        $("#error-signup-mobile2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signup-mobile2").css("opacity", "1");
        $("#error-signup-mobile2").css("visibility", "visible");
        error = 1;
    }

    if (!email) {
        $("#error-signup-email2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signup-email2").css("opacity", "1");
        $("#error-signup-email2").css("visibility", "visible");
        error = 1;
    }

    var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;

    if (!mobregqx.test(mobile)) {
        $("#error-signup-mobile2").css("opacity", "1").css("visibility", "visible").html('فرمت شماره همراه اشتباه است');
        error = 1;
        setTimeout(function () {
            $("#error-signup-mobile2").css("opacity", "0").css("visibility", "none");
        }, 2000);
    } else if (mobile.length > 13) {
        $("#error-signup-mobile2").css("opacity", "1").css("visibility", "visible").html('همراه حداکثر 13 شماره میباشد');
        error = 1;
        setTimeout(function () {
            $("#error-signup-mobile2").css("opacity", "0").css("visibility", "none");
        }, 2000);
    }

    if (!document.getElementById('accept-terms2').checked) {
        $("#error-accept-terms2").html('لطفا قوانین و مقررات را بپذیرید');
        $("#error-accept-terms2").css("opacity", "1");
        $("#error-accept-terms2").css("visibility", "visible");
        error = 1;
    }

    // send  for insert in DB
    if (error == 0) {
        $.post(amadeusPath + 'captcha/securimage_check.php',
            {captchaAjax: $('#signup-captcha2').val()},
            function (data) {
                if (data == true) {
                    reloadCaptcha();
                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            name: name,
                            family: family,
                            mobile: mobile,
                            email: email,
                            reagentCode: reagentCode,
                            flag: 'memberRegister'
                        },
                        function (data) {
                            var res = data.split(':');
                            if (data.indexOf('success') > -1) {
                                $(".cd-user-modal").trigger("click");
                                send_info_passengers();
                            } else {
                                $.alert({
                                    title: 'ثبت نام',
                                    icon: 'fa fa-user',
                                    content: res[1],
                                    rtl: true,
                                    type: 'red'
                                });
                                // $(".message-register").html(res[1]);
                            }
                        })
                } else {
                    reloadCaptcha();
                    $("#error-signup-captcha2").html('عبارت وارد شده صحیح نمی باشد');
                    $("#error-signup-captcha2").css("opacity", "1");
                    $("#error-signup-captcha2").css("visibility", "visible");
                    return false;
                }
            })
    } else {
        return false;
    }

}*/


/*این برای لاگین قبل از سرچ میباشد*/
/**
 * Login form
 * @returns {Boolean}
 */
function LoginOfPanel() {
    if ($("#signin-email2").attr('data-login') == 0) {

        // Rid Errors

        var error = 0;
        $(".cd-error-message").html('');
        $(".cd-error-message").css("opacity", "0");
        $(".cd-error-message").css("visibility", "hidden");

        // Get values
        var email = $("#signin-email2").val();
        var pass = $("#signin-password2").val();
        var remember = $("#remember-me2:checked").val();
        var captcha = $("#signup-captcha2").val();
        if (remember == 'checked' || remember == 'on' || remember == 'true') {
            remember = 'on';
        } else {
            remember = 'off';
        }
        var organization = '';
        if ($('#signin-organization2').length > 0) {
            organization = $('#signin-organization2').val();
        }

        //check values
        if (!email) {
            $("#error-signin-email2").html(useXmltag("PleaseCompleteEmail"));
            if ($("#error-signin-email2").hasClass('error-none')) {
                $("#error-signin-email2").removeClass('error-none');
            }
            /*        $("#error-signin-email2").css("opacity", "1");
                    $("#error-signin-email2").css("visibility", "visible");
                    $("#error-signin-email2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');*/
            error = 1;
            // setTimeout(function () {
            //     $("#error-signin-email2").css("opacity", "0").css("visibility", "none");
            //  }, 2000);
        } else {
            $("#error-signin-email2").removeClass('error-show');
        }

        if (!pass) {
            $("#error-signin-password2").html(useXmltag("PleaseCompletePassword"));
            if ($("#error-signin-password2").hasClass('error-none')) {
                $("#error-signin-password2").removeClass('error-none');
            }
            /*        $("#error-signin-password2").css("opacity", "1");
                    $("#error-signin-password2").css("visibility", "visible");
                    $("#error-signin-password2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');*/

            error = 1;
            // setTimeout(function () {
            //     $("#error-signin-password2").css("opacity", "0").css("visibility", "none");
            // }, 2000);
        } else {
            $("#error-signin-password2").addClass('error-none');
        }

        if (!captcha) {
            $("#error-signup-captcha2").html(useXmltag("Enteringfieldrequired"));
            if ($("#error-signin-captcha2").hasClass('error-none')) {
                $("#error-signin-captcha2").removeClass('error-none');
            }
            /*        $("#error-signup-captcha2").css("opacity", "1");
                    $("#error-signup-captcha2").css("visibility", "visible");
                    $("#error-signup-captcha2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');*/

            error = 1;
            // setTimeout(function () {
            //     $("#error-signup-captcha2").css("opacity", "0").css("visibility", "none");
            // }, 2000);
        } else {
            $("#error-signin-captcha2").addClass('error-none');
        }

        // send  for logon
        if (error == 0) {
            $.post(amadeusPath + 'captcha/securimage_check.php',
               {captchaAjax: $('#signup-captcha2').val()},
               function (response) {
                   if (response == true) {
                       reloadCaptcha();
                       $.post(amadeusPath + 'user_ajax.php',
                          {
                              email: email,
                              remember: remember,
                              password: pass,
                              organization: organization,
                              setcoockie: "yes",
                              flag: 'memberLogin'
                          },
                          function (data) {

                              var result = data.split(':');

                              if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                                  $.alert({
                                      title: useXmltag("Userlogin"),
                                      icon: 'fa fa-cart-plus',
                                      content: useXmltag("Loginsuccessfully"),
                                      rtl: true,
                                      type: 'green'
                                  });
                                  $(".cd-user-modal").trigger("click");
                                  $('.full-width').css('opacity', '0.5').text(useXmltag("Sendinginformation"))
                                  // setTimeout(function () {
                                  //     if (result[1] == 'ticketAccess') {
                                  //         window.location.href = amadeusPathByLang + 'topRouteFlight';
                                  //     } else {
                                  //         window.location.href = amadeusPathByLang + 'userProfile';
                                  //     }
                                  // }, 1000);
                              } else {
                                  $("#signin-email2").attr("data-login", "1");
                                  $(".message-login").html(useXmltag("Sendinginformation"));
                              }
                          })
                   } else {
                       reloadCaptcha();
                       $("#error-signup-captcha2").html(useXmltag("EnteredPhraseNotCorrect"));
                       $("#error-signup-captcha2").css("opacity", "1");
                       $("#error-signup-captcha2").css("visibility", "visible");
                       return false;
                   }
               });
        } else {
            return false;
        }
    }
}


function RegisterOfPanel() {

    // Rid Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    $(".message-register").html('');

    // Get values
    var name = $("#signup-name2").val();
    var family = $("#signup-family2").val();
    var mobile = $("#signup-mobile2").val();
    var email = $("#signup-email2").val();
    var reagentCode = $("#reagent-code2").val();

    //check values
    if (!name) {
        $("#error-signup-name2").html(useXmltag("Enteringfieldrequired"));
        $("#error-signup-name2").css("opacity", "1");
        $("#error-signup-name2").css("visibility", "visible");
        $("#error-signup-name2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-name2").css("opacity", "0").css("visibility", "none");
        // }, 1000);
    }

    if (!family) {
        $("#error-signup-family2").html(useXmltag("Enteringfieldrequired"));
        $("#error-signup-family2").css("opacity", "1");
        $("#error-signup-family2").css("visibility", "visible");
        $("#error-signup-family2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-family2").css("opacity", "0").css("visibility", "none");
        // }, 1000);
    }

    if (!mobile) {
        $("#error-signup-mobile2").html(useXmltag("Enteringfieldrequired"));
        $("#error-signup-mobile2").css("opacity", "1");
        $("#error-signup-mobile2").css("visibility", "visible");
        $("#error-signup-mobile2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-mobile2").css("opacity", "0").css("visibility", "none");
        // }, 2000);
    }

    if (!email) {
        $("#error-signup-email2").html(useXmltag("Enteringfieldrequired"));
        $("#error-signup-email2").css("opacity", "1");
        $("#error-signup-email2").css("visibility", "visible");
        $("#error-signup-email2").siblings("input.has-padding").css("background", "#EA6363").css('box-shadow', '1px 1px 1px #CCC');
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-email2").css("opacity", "0").css("visibility", "none");
        // }, 2000);
    }

    if (!document.getElementById('accept-terms2').checked) {
        $("#error-accept-terms2").html(useXmltag("ConfirmTermsFirst"));
        $("#error-accept-terms2").css("opacity", "1");
        $("#error-accept-terms2").css("visibility", "visible");
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-terms2").css("opacity", "0").css("visibility", "none");
        // }, 2000);
    }

    var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;

    if (!mobregqx.test(mobile)) {
        $("#error-signup-mobile2").css("opacity", "1").css("visibility", "visible").html(useXmltag("MobileNumberIncorrect"));
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-mobile2").css("opacity", "0").css("visibility", "none");
        // }, 2000);
    } else if (mobile.length > 13) {
        $("#error-signup-mobile2").css("opacity", "1").css("visibility", "visible").html(useXmltag("MobileNumberMaxNumber"));
        error = 1;
        // setTimeout(function () {
        //     $("#error-signup-mobile2").css("opacity", "0").css("visibility", "none");
        // }, 2000);
    }

    // send  for insert in DB
    if (error == 0) {
        $.post(amadeusPath + 'captcha/securimage_check.php',
           {captchaAjax: $('#signup-captcha2').val()},
           function (data) {
               if (data == true) {
                   reloadCaptcha();
                   $.post(amadeusPath + 'user_ajax.php',
                      {
                          name: name,
                          family: family,
                          mobile: mobile,
                          email: email,
                          reagentCode: reagentCode,
                          setcoockie: "yes",
                          flag: 'memberRegister'
                      },
                      function (response) {
                          // console.log(response);
                          jsonResponse = JSON.parse(response);

                          // result = JSON.stringify(response);
                          if(jsonResponse.success){
                              let redirect_url = jsonResponse.redirect_url ? jsonResponse.redirect_url :  amadeusPathByLang + "userProfile";
                              $.alert({
                                  title: useXmltag("Userlogin"),
                                  icon: 'fa fa-cart-plus',
                                  content: useXmltag("Loginsuccessfully"),
                                  rtl: true,
                                  type: 'green'
                              });
                              $(".cd-user-modal").trigger("click");
                              $('.full-width').css('opacity', '0.5').text(useXmltag("Sendinginformation"));
                              setTimeout(function () {

                                  if(redirect_url != ''){
                                      // console.log(redirect_url);
                                      window.location.href = redirect_url;
                                      // window.location.href = amadeusPathByLang + "userProfile";
                                  }else{
                                      window.location.href = amadeusPathByLang + "userProfile";
                                  }
                              }, 1000);
                          }else {
                              var res = response.split(':');
                              if (response.indexOf('success') > -1) {
                                  $.alert({
                                      title: useXmltag("Userlogin"),
                                      icon: 'fa fa-cart-plus',
                                      content: useXmltag("Loginsuccessfully"),
                                      rtl: true,
                                      type: 'green'
                                  });
                                  $(".cd-user-modal").trigger("click");
                                  $('.full-width').css('opacity', '0.5').text(useXmltag("Sendinginformation"));
                                  setTimeout(function () {
                                      window.location.href = amadeusPathByLang + "userProfile";
                                  }, 1000);
                              } else {
                                  $.alert({
                                      title: useXmltag("SetAccount"),
                                      icon: 'fa fa-user',
                                      content: res[1],
                                      rtl: true,
                                      type: 'red'
                                  });
                                  $(".message-register").html(res[1]);
                                  $("#register_submit").val(useXmltag("SetAccount"));
                                  $("#register_submit").removeClass('waiting_register');
                              }
                          }
                      })
               } else {
                   $("#register_submit").val(useXmltag("SetAccount"));
                   $("#register_submit").removeClass('waiting_register');
                   reloadCaptcha();
                   $(".gds-login-error-box").removeClass('gds-login-error-none');
                   $("#signup-captcha2").focus();
                   $("#signup-captcha2").val('');
                   $("#error-signin-captcha2").html(useXmltag("WrongSecurityCode"));
                   $("#error-signup-captcha2").css("opacity", "1");
                   $("#error-signup-captcha2").css("visibility", "visible");
                   return false;
               }
           })
    } else {
        return false;
    }

}

function BuyWithoutRegister() {
    console.log('inja3')
    let flight_id_private = $('#flight_id_private').val();
    console.log(flight_id_private)

    if (flight_id_private != undefined && flight_id_private.length >0) {
        SendInfoLoginToPrivate(flight_id_private);
    } else {
        send_info_passengers();
    }

}

/**
 * generate URL for local flight search in sidebar
 * insert slash character between parametrs
 */
function submitLocalSide(type) {
    let today = dateNow('-');

    if(type =='local' || type=="local-flight" || type=="domestic-flight"){
        var dept_date = $("#dept_date_local").val();
        var origin = $("#origin_local").val();
        var destination = $("#destination_local").val();
        var adult = Number($("#qty1").val());
        var child = Number($("#qty2").val());
        var infant = Number($("#qty3").val());
        var flightNumber = $("#searchFlightNumber").val();
        var is_multi = 'false';
        if($('#is_multi_destination').length){

            is_multi = $('#is_multi_destination').val() ;
        }

    }
    else if(type =='international' || type =='internationalSearch' || type =='international-flight'){
        var is_multi = 'false';
        if($('#is_multi_destination').length){

            is_multi = $('#is_multi_destination').val() ;
        }

        console.log(typeof is_multi)
        if(is_multi==='true'){
            let count_path = $('#count_path').val();
            var dept_date = [] ;
            var origin = [] ;
            var destination = [] ;

            var error_multi = false
            var path_multi = ''
            for(var i=0; i < count_path; i++){
                dept_date[i] = $("#dept_date_foreign"+i).val();
                origin[i] = $("#origin_foreign"+i).val();
                destination[i] = $("#destination_foreign"+i).val();
                if( dept_date[i] =="" || origin[i]=="" || destination[i]==""){
                    error_multi  = true
                }else{
                    if(i==0){
                        path_multi = `&mroute=yes`
                    }
                    path_multi += `&departure[${i}]=${origin[i]}&arrival[${i}]=${destination[i]}&departuredate[${i}]=${dept_date[i]}` ;

                }
            }

            if(error_multi){
                $.alert({
                    title: useXmltag("BookTicket"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("Pleaseenterrequiredfields"),
                    rtl: true,
                    type: 'red'
                });
                $('#loader_check_submit').css('display', 'none');
                $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');

                return false ;
            }
        }
        else{
            var dept_date = $("#dept_date_foreign0").val();
            var origin = $("#origin_foreign0").val();
            var destination = $("#destination_foreign0").val();

        }

    }

    if (type != "" && type == 'international' ) {
        console.log(type)
        var adult = Number($("#qtyf1").val());
        var child = Number($("#qtyf2").val());
        var infant = Number($("#qtyf3").val());
        var typeSearch = 'international';
    }else if(type == 'international-flight') {
        var adult = Number($("#qtyf1").val());
        var child = Number($("#qtyf2").val());
        var infant = Number($("#qtyf3").val());
        var typeSearch = 'international-flight';
    }
    else if (type != "" && type == 'local') {
        var typeSearch = 'searchFlight'
    } else if (type != "" && type == 'local-flight') {
        var typeSearch = 'search-flight'
    }else if (type == 'domestic-flight') {
        var typeSearch = 'domestic-flight'
    }

    if (parseInt(adult) <= 0) {
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("LeastOneAdult"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
        return false ;
    }
    if (parseInt(infant) > parseInt(adult)){
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("SumAdultsChildrenNoGreaterThanAdult"),
            rtl: true,
            type: 'red'
        });
        return false ;
    }
    if (parseInt(adult + child) > 9 ) {
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ErrorAdultCount"),
            rtl: true,
            type: 'red'
        });
        return false ;
    }
    if(is_multi==='false') {
        var return_date = '';
        var num = adult + "-" + child + "-" + infant;

        $('#loader_check_submit').css('display', 'block');
        $('#sendFlight').css('opacity', '0.4').attr('onclick', false);

        var multiWay = '1';
        console.log($('.multiWays').hasClass('checked'))
        if ($('.multiWays').hasClass('checked')) {
            multiWay = '2';
            if ($("#dept_date_local_return").parents('.s-u-form-block').hasClass('showHidden')) {
                return_date = $("#dept_date_local_return").val();
            }else if((type =='local' || type=='local-flight' || type=='domestic-flight') && $("#dept_date_local_return").val() !=""){
                return_date = $("#dept_date_local_return").val();
            }else if((type =='international' || type =='international-flight' )&& $("#dept_date_foreign_return").val() !=""){
                return_date = $("#dept_date_foreign_return").val() ;
            }
        }

        console.log('today==>'+ today);
        console.log('origin==>'+ origin);
        console.log('destination==>'+ destination);
        console.log('dept_date==>'+ dept_date);
        console.log('multiWay==>'+ multiWay);
        console.log('return_date==>'+ return_date);
        if (origin == "" || destination == ""  || (multiWay == '2' && return_date == '')) {
            $.alert({
                title: useXmltag("BookTicket"),
                icon: 'fa fa-cart-plus',
                content: useXmltag("Pleaseenterrequiredfields"),
                rtl: true,
                type: 'red'
            });
            $('#loader_check_submit').css('display', 'none');
            $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');

            return false ;
        }
        if (dept_date < today) {
            $.alert({
                title: useXmltag("BookTicket"),
                icon: 'fa fa-cart-plus',
                content: useXmltag("DateWrong"),
                rtl: true,
                type: 'red'
            });
            $('#loader_check_submit').css('display', 'none');
            $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
            return false ;
        }

        if (multiWay == '2' && (return_date < dept_date)) {
            $.alert({
                title: useXmltag("BookTicket"),
                icon: 'fa fa-cart-plus',
                content: useXmltag("DateWrongReturn"),
                rtl: true,
                type: 'red'
            });
            $('#loader_check_submit').css('display', 'none');
            $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
            return false ;
        }
        if (dept_date.indexOf('/') > -1) {
            var dept_date_aa = dept_date.replace('/', '-');
            var date_final = dept_date_aa.replace('/', '-');
        } else {
            var date_final = dept_date;
        }

        if (return_date.indexOf('/') > -1) {
            var return_date_aa = return_date.replace('/', '-');
            var return_date_final = return_date_aa.replace('/', '-');
        } else {
            var return_date_final = return_date;
        }

        if (return_date_final != '') {
            date_final = date_final + "&" + return_date;
        }
        var ori_dep = origin + "-" + destination;
        console.log('****************************');
        console.log('today==>'+ today);
        console.log('origin==>'+ origin);
        console.log('destination==>'+ destination);
        console.log('dept_date==>'+ dept_date);
        console.log('multiWay==>'+ multiWay);
        console.log('return_date==>'+ return_date);

        var flightNumberSearch = "";
        if (flightNumber != '' && typeof flightNumber !== 'undefined') {
            /*   alert(flightNumber);
               var urlNow = window.location.href;
               var urlExp = urlNow.split('/');
               if (urlExp[6].indexOf('-')) {
                   var urlCity = urlExp[6].split('-');
               } else {
                   var urlCity = urlExp[7].split('-');
               }
               if (urlCity[0] == origin && urlCity[1] == destination) {

               }*/
            var flightNumberSearch = "/" + flightNumber;
        }
        var url = amadeusPathByLang + typeSearch + "/" + multiWay + "/" + ori_dep + "/" + date_final + "/Y/" + num + flightNumberSearch;

    }
    else{
        var num = `&adult=${adult}&child=${child}&infant=${infant}`;
        var url =   amadeusPathByLang + typeSearch + path_multi + num ;
    }
    if(type !== undefined){
        console.log(url);
        window.location.href = url;
    }else{
        return false;
    }



}

////deleteInfuture
function submitLocalSideInsurance() {

    $('#loader_check_submit').css('display', 'block');
    $('#sendInsurance').css('opacity', '0.4').attr('onclick', false);

    var destination = $("#InsuranceCountrySelect").val();
    var duration = $("#InsuranceTravelTimeSelect").val();
    var count = parseInt($("#InsurancePassengersSelect").val());
    var birthdates = '';

    if (destination == "" || destination == "انتخاب مقصد" || duration == "" || count == "") {
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendInsurance').css('opacity', '1').attr('onclick', 'submitLocalSideInsurance()');
    }

    for (var i = 1; i <= count; i++) {
        if ($('#txt_birth_insurance' + i).val() == "") {
            $.alert({
                title: useXmltag("BookTicket"),
                icon: 'fa fa-cart-plus',
                content: useXmltag("Pleaseenterrequiredfields"),
                rtl: true,
                type: 'red'
            });
            $('#loader_check_submit').css('display', 'none');
            $('#sendInsurance').css('opacity', '1').attr('onclick', 'submitLocalSideInsurance()');
        }
        birthdates += $('#txt_birth_insurance' + i).val().toString().replace(/\//g, '-') + '/';
    }

    var url = amadeusPathByLang + 'resultInsurance' + "/2/" + destination + "/" + duration + "/" + count + "/" + birthdates;

    window.location.href = url;
}

function submitLocalSideLocalHotel() {

    $('#loader_check_submit').css('display', 'block');
    $('#sendLocalHotel').css('opacity', '0.4').attr('onclick', false);

    var city = $("#CityHotelLocalSelect").val();
    var StartDate = $("#SDateHotelLocalSelect").val();
    var EndDate = $("#EDateHotelLocalSelect").val();
    var Nights = $("#nights").val();

    if (city == "" || StartDate == "" || EndDate == "") {
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendLocalHotel').css('opacity', '1').attr('onclick', 'submitLocalSideLocalHotel()');

    } else {


        var url = amadeusPathByLang + 'resultHotelLocal' + "/" + city + "/" + StartDate + "/" + Nights;

        window.location.href = url;
    }
}

function cancel_user_buy(id) {

    $.alert({
        title: useXmltag("CancelPurchase"),
        icon: 'fa fa-trash',
        content: useXmltag("SureCancelPurchase"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'user_ajax.php',
                       {
                           id: id,
                           flag: 'cancel_user_buy'
                       },
                       function (data) {
                           var res = data.split(':');
                           if (data.indexOf('success') > -1) {

                               $.alert({
                                   title: useXmltag("CancelPurchase"),
                                   icon: 'fa fa-trash',
                                   content: res[1],
                                   rtl: true,
                                   type: 'green',
                               });
                               setTimeout(function () {
                                   $('#cancelbyuser-' + id).removeClass('btn-danger').addClass('btn-warning').removeClass('fa-times').addClass('fa-refresh').removeAttr('onclick').attr('onclick', ' return false ').attr('title', useXmltag("CancellationRequestSubmitted"));
                               }, 1000);
                           } else {
                               $.alert({
                                   title: useXmltag("CancelPurchase"),
                                   icon: 'fa fa-trash',
                                   content: res[1],
                                   rtl: true,
                                   type: 'red',
                               });
                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange',
            }
        }
    });
}


function ChangePassword() {
    var oldpass = $('#old_pass').val();
    var newpass = $('#new_pass').val();
    var confpass = $('#con_pass').val();
    var captchaCode = $('#signup-captcha2').val();
    if (oldpass == "" || newpass == "" || confpass == "") {

        $.alert({
            title: useXmltag("Changpassword"),
            icon: 'fa fa-trash',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red',
        });
    } else if (newpass.length < 8 || confpass.length < 8) {
        $.alert({
            title: useXmltag("Changpassword"),
            icon: 'fa fa-trash',
            content: useXmltag("NumberCharactersPasswordNoLessEight"),
            rtl: true,
            type: 'red'
        });
    } else {
        /*    $.post(amadeusPath + 'captcha/securimage_check.php',
                {captchaAjax: $('#signup-captcha2').val()},
                function (response) {
                    if (response == true) {*/
        $.post(amadeusPath + 'user_ajax.php',
           {
               old_pass: oldpass,
               new_pass: newpass,
               conf_pass: confpass,
               flag: 'ChangePass'
           },
           function (data) {
               var res = data.split(':');
               if (data.indexOf('success') > -1) {

                   $.alert({
                       title: useXmltag("Changpassword"),
                       icon: 'fa fa-trash',
                       content: res[1],
                       rtl: true,
                       type: 'green',
                   });
                   setTimeout(function () {
                       $('#ChangePass')[0].reset();
                   }, 1000);
               } else {
                   $.alert({
                       title: useXmltag("Changpassword"),
                       icon: 'fa fa-trash',
                       content: res[1],
                       rtl: true,
                       type: 'red',
                   });
               }

           });
        /*} else {
            $.alert({
                title: useXmltag("Changpassword"),
                icon: 'fa fa-trash',
                content: useXmltag("EnterCorrectSecurityCode"),
                rtl: true,
                type: 'red',
            });
        }
    });*/
    }
}


function recovery_pass() {
    var email = $('#ResetEmailLocal').val();
    var emailReg = /^[0-9]{11}$/;
    $('#ResetEmailLocal').focus(function () {
        $('#ResetEmailLocal').css("background", "white");
    });

    if (email == "") {
        $('#ResetEmailLocal').css("background", "red");

        $.alert({
            title: useXmltag("ForgetPassword"),
            icon: 'fa fa-times',
            content: useXmltag("PleaseEnterValidMobile"),
            rtl: true,
            type: 'red',
        });
        $('.user-form-style_js').attr('disabled', 'disabled');
        $('.user-form-style_js input').prop("disabled", true);
    } else if (!validateMobileOrEmail(email)) {
        $('#ResetEmailLocal').css("background", "red");

        $.alert({
            title: useXmltag("ForgetPassword"),
            icon: 'fa fa-times',
            content: useXmltag("PleaseEnterValidMobileOrEmail"),
            rtl: true,
            type: 'red',
        });
        $('.user-form-style_js').attr('disabled', 'disabled');
        $('.user-form-style_js input').prop("disabled", true);
    } else {

        $.post(amadeusPath + 'captcha/securimage_check.php',

           {captchaAjax: $('#signin-captcha2').val()},

           function (response) {
               if (response == true) {
                   $('#loaderTracking').fadeIn(700);
                   $.post(amadeusPath + 'user_ajax.php',
                      {
                          email: email,
                          flag: 'RecoveryPass'
                      },
                      function (data) {
                          var res = data.split(':');
                          if (data.indexOf("success") > -1) {
                              $.alert({
                                  title: useXmltag("ForgetPassword"),
                                  icon: 'fa fa-check',
                                  content: res[1],
                                  rtl: true,
                                  type: 'green',
                              });

                              $('.user-form-style_js').removeAttr('disabled');
                              $('.user-form-style_js input').removeAttr('disabled');

                              $('#loaderTracking').fadeOut(700);

                          } else {
                              $.alert({
                                  title: useXmltag("ForgetPassword"),
                                  icon: 'fa fa-times',
                                  content: res[1],
                                  rtl: true,
                                  type: 'red',
                              });

                              $('.user-form-style_js').attr('disabled', 'disabled');
                              $('.user-form-style_js input').prop("disabled", true);

                              $('#loaderTracking').fadeOut(700);
                          }

                      });
               } else {
                   reloadCaptcha();
                   $.alert({
                       title: useXmltag("ForgetPassword"),
                       icon: 'fa fa-dismiss',
                       content: useXmltag("WrongSecurityCode"),
                       rtl: true,
                       type: 'red',
                   });

               }
           });
    }
}

function recovery_pass_check_number() {
    var code = $('#ResetEmailLocalCheckCode').val();

    $('#ResetEmailLocalCheckCode').focus(function () {
        $('#ResetEmailLocalCheckCode').css("background", "white");
    });

    if (code == "") {
        $('#ResetEmailLocalCheckCode').css("background", "red");

        $.alert({
            title: useXmltag("ForgetPassword"),
            icon: 'fa fa-times',
            content: 'لطفا کد را وارد کنید',
            rtl: true,
            type: 'red',
        });

    } else {
        $('#loaderTracking').fadeIn(700);
        $.post(amadeusPath + 'user_ajax.php',
           {
               code: code,
               flag: 'RecoveryPassCheckCode'
           },
           function (data) {
               var res = data.split(':');
               if (data.indexOf("success") > -1) {
                   $.alert({
                       title: useXmltag("ForgetPassword"),
                       // title: 'کد ، مطابقت داشت',
                       icon: 'fa fa-check',
                       content: res[1],
                       rtl: true,
                       type: 'green',
                   });

                   $('#loaderTracking').fadeOut(700);

               } else {
                   $.alert({
                       title: useXmltag("ForgetPassword"),
                       icon: 'fa fa-times',
                       content: res[1],
                       rtl: true,
                       type: 'red',
                   });

                   $('#loaderTracking').fadeOut(700);
               }

           });
    }
}

function ChangePassForRecovery() {
    var newpass = $('#new_pass').val();
    var confpass = $('#con_pass').val();
    var member_id = $('#member_id').val();

    $('#new_pass').focus(function () {
        $('#new_pass').css("background", "white");
    });
    $('#con_pass').focus(function () {
        $('#con_pass').css("background", "white");
    });
    if (newpass == "" || confpass == "") {

        if (newpass == "") {
            $('#new_pass').css("background", "red");
        }
        if (confpass == "") {
            $('#con_pass').css("background", "red");
        }

        $.alert({
            title: useXmltag("Changpassword"),
            icon: 'fa fa-trash',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red',
        });
    } else if (newpass != confpass) {
        $.alert({
            title: useXmltag("Changpassword"),
            icon: 'fa fa-trash',
            content: useXmltag("NewPasswordNotSameRepeating"),
            rtl: true,
            type: 'red',
        });
    } else {
        $.post(amadeusPath + 'user_ajax.php',
           {
               new_pass: newpass,
               key: member_id,
               flag: 'ChangePassRecovery'
           },
           function (data) {
               var res = data.split(':');
               if (data.indexOf('success') > -1) {

                   $.alert({
                       title: useXmltag("Changpassword"),
                       icon: 'fa fa-trash',
                       content: res[1],
                       rtl: true,
                       type: 'green',
                   });
                   setTimeout(function () {
                       $("#RecoverPassword").trigger('reset');
                   }, 1000);
               } else {
                   $.alert({
                       title: useXmltag("Changpassword"),
                       icon: 'fa fa-trash',
                       content: res[1],
                       rtl: true,
                       type: 'red',
                   });
               }

           });
    }

}

function SendTrackingInfo() {

    var request_number = $('#request_number').val();
    var typeSearch = $('input[name=typeSearch]:checked').val();

    $('#request_number').focus(function () {
        $('#request_number').css("background", "white");
    });

    if (request_number == "") {

        $.alert({
            title: useXmltag("TrackOrder"),
            icon: 'fa fa-times',
            content: useXmltag("EnterRequiredInformation"),
            rtl: true,
            type: 'red'
        });
        $('#request_number').css("background", "red");

    } else {
        $('#loaderTracking').show(500);

        $.post(amadeusPath + 'user_ajax.php',
           {
               request_number: request_number,
               typeSearch: typeSearch,
               flag: 'trackingInfo'
           },
           function (data) {
               console.log(typeof data);
               console.log(data)
               console.log(data.length)
               if (data.length > 2 ) {
                   $('#submitInfoTracking').attr('onclick', 'return false');
                   $('#submitInfoTracking').attr('disabled', 'disabled');
                   setTimeout(function () {
                       $('#loaderTracking').hide();
                       $('#trListReserve').fadeIn(500).css('margin-top', '20px').html(data);
                   }, 2500);
               } else {
                   $.alert({
                       title: useXmltag("TrackOrder"),
                       icon: 'fa fa-times',
                       content: useXmltag("NoInformationFound"),
                       rtl: true,
                       type: 'red'
                   });
                   $('#loaderTracking').hide(1500);
               }

           });
    }

}

function SendTrackingRequestInfo() {
    var request_service_number = $('#request_service_number').val();
    var typeSearchRequest = $('input[name=typeSearchRequest]:checked').val();
    $('#request_service_number').focus(function () {
        $('#request_service_number').css("background", "white");
    });

    if (request_service_number == "") {

        $.alert({
            title: useXmltag("TrackRequestService"),
            icon: 'fa fa-times',
            content: useXmltag("EnterRequiredInformationRequest"),
            rtl: true,
            type: 'red'
        });
        $('#request_service_number').css("background", "red");

    } else {
        $('#loaderTrackingRequest').show(500);

        $.post(amadeusPath + 'user_ajax.php',
           {
               request_service_number: request_service_number,
               typeSearchRequest: typeSearchRequest,
               flag: 'trackingRequestInfo'
           },
           function (data) {

               if (data.length > 2) {
                   $('#submitInfoTrackingRequest').attr('onclick', 'return false');
                   $('#submitInfoTrackingRequest').attr('disabled', 'disabled');
                   setTimeout(function () {
                       $('#FormTrackingRequest').fadeOut(100);
                       $('#loaderTrackingRequest').hide();
                       $('#trListRequestService').fadeIn(500).css('margin-top', '20px').html(data);
                   }, 2500);
               } else {
                   $.alert({
                       title: useXmltag("TrackRequestService"),
                       icon: 'fa fa-times',
                       content: useXmltag("NoInformationRequestFound"),
                       rtl: true,
                       type: 'red'
                   });
                   $('#loaderTrackingRequest').hide(1500);
               }

           });
    }

}


function SendEmploymentInfo($requestId) {
    var requestId = $requestId;
    $('#modalRequestService').fadeIn();
    if (requestId) {
        $('#ModalPublicContentRrequest').show(500);
        $.post(amadeusPath + 'user_ajax.php',
           {
               request_service_number: requestId,
               flag: 'trackingRequestAllInfo'
           },
           function (data) {
               $('#ModalPublicContentRrequest').html(data);
           });
    }
}

function modalList(RequestNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'user',
           Method: 'ModalShow',
           Param: RequestNumber
       },
       function (data) {

           $('#ModalPublicContent').html(data);


       });
//
//    $('.loaderPublic').fadeIn(700);
//
//    // Get the modal
//    $('#myModal-' + request_number).fadeIn(500);
}

function modalClose(request_number) {
//    var btnClose = $("#myModal-" + request_number);
    var btnPublicClose = $("#ModalPublic");
//    var btnCancelModal = $("#ModalCancelUser-" + request_number);
//    btnClose.fadeOut(700);
//    btnCancelModal.fadeOut(700);
    btnPublicClose.fadeOut(700);
}

function modalEmail(request_number) {
    // Get the modal
    $('#ModalSendEmail').fadeIn(500);
    $('#request_number').val(request_number);

}

function modalEmailClose() {
    var btnClose = $("#ModalSendEmail");
    btnClose.fadeOut(700);
}

function SendEmailForOther() {
    $('#loaderTracking').fadeIn(500);
    $('#SendEmailForOther').attr("disabled", "disabled");
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
               flag: 'SendEmailForOther'
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
                       $('#SendEmailForOther').attr("disabled", false);
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
                   $('#SendEmailForOther').attr("disabled", false);
                   $('#loaderTracking').fadeOut(500);


               }

           });
    }
}

function ModalCancelUser(type, RequestNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 1500);

    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'user',
           Method: 'ModalCancel',
           Param: RequestNumber,
           ParamId: type
       },
       function (data) {
           $('#ModalPublicContent').html(data);
       });
}

function ModalCancelBus(RequestNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 1500);

    $.post(libraryPath + 'ModalCreatorBus.php',
       {
           Controller: 'user',
           Method: 'ModalCancel',
           Param: RequestNumber
       },
       function (data) {

           $('#ModalPublicContent').html(data);

       });
}

function SelectReason(Obj) {
    /*var valueReason = $(Obj).val();*/

    return true;

    /*if (valueReason == 'PersonalReason') {
        Lobibox.notify('info', {
            icon: true,
            size: 'mini',
            rounded: true,
            delay: false,
            position: 'center bottom', //or 'center bottom'
            msg: useXmltag("CancellationPersonAccordanceConsellerLaw"),
            iconSource: "fontAwesome"
        });
    } else if (valueReason == 'DelayTwoHours') {
        var text = useXmltag("FlightsHaveCanceledAirlineChartererOrDelayed");
        Lobibox.notify('info', {
            icon: true,
            title: '',
            rounded: true,
            delay: false,
            position: 'center bottom', //or 'center top'
            msg: text,
            iconSource: "fontAwesome"
        });


    } else if (valueReason == 'CancelByAirline') {
        var text = useXmltag("AirfreightCanceled");
        Lobibox.notify('info', {
            icon: true,
            size: 'mini',
            title: '',
            rounded: true,
            delay: false,
            position: 'center bottom', //or 'center top'
            msg: text,
            iconSource: "fontAwesome"
        });

    }*/
}

function SelectUser(RequestNumber,_this=null) {
    // let btnClick = $(".btn-send-information");
    // $('.donut').css("display", "block");
    // $(btnClick).attr('disabled', true).css("cursor", "default");

    // loadingToggle(_this)

// alert('ffffffffff')
// alert(RequestNumber)
    const loading = document.getElementById('btn-send-information-load');

    var National = [];
    var Reasons = $('#ReasonUser').val();
    var FactorNumber = $('#FactorNumber').val();
    var MemberId = $('#MemberId').val();
    var AccountOwner = $('#AccountOwner').val();
    var CardNumber = $('#CardNumber').val();
    var NameBank = $('#NameBank').val();
    var backCredit = $('#backCredit').val();
    var typeService = $('#typeService').val();
    if ($('#PercentNoMatter').is(':checked')) {
        var PercentNoMatter = 'Yes';
    } else {
        var PercentNoMatter = 'No';
    }

//    var passenger_age = $('#passenger_age').val();

    National = $('.SelectUser:checked').map(function () {


        return $(this).val();

    });

    var NationalCodes = National.get();

    if ($('#Ruls').is(':checked')) {
        if (NationalCodes != "" && Reasons != "") {
            loading.style.display = 'inline-block';
            $.post(amadeusPath + 'user_ajax.php',
               {
                   NationalCodes: NationalCodes,
                   Reasons: Reasons,
                   FactorNumber: FactorNumber,
                   RequestNumber: RequestNumber,
                   MemberId: MemberId,
                   AccountOwner: AccountOwner,
                   CardNumber: CardNumber,
                   NameBank: NameBank,
                   backCredit: backCredit,
                   PercentNoMatter: PercentNoMatter,
                   typeService: typeService,
                   flag: 'RequestCancelUser'
               },
               function (data) {
                   var res = data.split(':');
                   if (data.indexOf('success') > -1) {
                       $.alert({
                           title: useXmltag("SendCancellationRequest"),
                           icon: 'fa fa-check',
                           content: res[1],
                           rtl: true,
                           type: 'green',
                       });
                       // $('#btn-information').addClass('displayN');
                       // $('#btn-information').attr("disabled", false);
                       $("#btn-information ").attr('disabled', 'disabled');
                       setTimeout(function () {

                           $('#cancelbyuser-' + RequestNumber).removeClass('btn btn-danger fa fa-times').addClass('btn btn-warning fa fa-refresh').removeAttr('onclick').attr("title", useXmltag("InvestigatingRequest"));
                           $("#ModalPublic").fadeOut(700);

                       }, 1000);

                   }
                   else {
                       $.alert({
                           title: useXmltag("SendCancellationRequest"),
                           icon: 'fa fa-times',
                           content: res[1],
                           rtl: true,
                           type: 'red',
                       });
                       $('#SendEmailForOther').attr("disabled", false);
                       $('#loaderTracking').fadeOut(500);
                   }
               }
            )
               .always(function () {
                   loading.style.display = 'none';
                   console.log("تست سلام")
               });
        }
        else {
            $.alert({
                title: useXmltag("SendCancellationRequest"),
                icon: 'fa fa-times',
                content: useXmltag("PleasePersonOrCancellationReason"),
                rtl: true,
                type: 'red'
            });
        }
    }
    else {
        $.alert({
            title: useXmltag("SendCancellationRequest"),
            icon: 'fa fa-times',
            content: useXmltag("ReadRulesSelectRules"),
            rtl: true,
            type: 'red'
        });

    }

}

function ModalTrackingCancelTicket(RequestNumber, id) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 1500);

    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'user',
           Method: 'ModalTrackingCancelTicket',
           Param: RequestNumber,
           ParamId: id
       },
       function (data) {

           $('#ModalPublicContent').html(data);

       });
}


function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function isAlfabetNumberKeyFields(evt, Input) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode == 8 || charCode == 32 || charCode == 20) {
        return true;
    } else if (48 <= charCode && charCode <= 57) {
        return true;
    } else if (65 <= charCode && charCode <= 90) {
        return true;
    } else if (97 <= charCode && charCode <= 122) {
        return true;
    } else {
        $.alert({
            title: useXmltag("ErrorEnteringInformation"),
            icon: 'fa shopping-cart',
            content: useXmltag("LatinLettersNumberOnly"),
            rtl: true,
            type: 'red',
        });
        return false;

    }

}

function reversOriginDestination() {

    var origin = $("select#origin_local option:selected").val();
    var desti = $("select#destination_local option:selected").val();
    var originTxt = $("select#origin_local option:selected").text();
    var destiTxt = $("select#destination_local option:selected").text();
    // alert(origin + '' + desti);
    if (desti !== "") {

        $.post(amadeusPath + 'user_ajax.php',
           {
               Departure: desti,
               flag: "select_Airport",
           },
           function (data) {
               $('#destination_local').html(data);
               setTimeout(function () {
                   $("select#origin_local option:selected").val(desti);
                   $("select#destination_local option:selected").val(origin);
                   $("select#origin_local option:selected").text(destiTxt);
                   $("select#destination_local option:selected").text(originTxt);
                   $("span#select2-origin_local-container").text(destiTxt);
                   $("span#select2-destination_local-container").text(originTxt);
               }, 10);
           })

    } else {
        alert(useXmltag("SpecifyDestination"));
    }
}


function reversOriginDestinationForeign() {

    var origin = $("#OriginPortal").val();
    var originText = $("#OriginPortal").text();
    var originFiledHidden = $("#origin_local").val();
    var destination = $("#DestinationPortal").val();
    var destinationText = $("#DestinationPortal").text();
    var destinationFiledHidden = $("#destination_local").val();
    // alert(origin + '' + desti);
    if (destination !== "") {


        setTimeout(function () {
            $("#OriginPortal").val(destination);
            $("#OriginPortal").text(destinationText);
            $("#origin_local").val(destinationFiledHidden);
            $("#DestinationPortal").val(origin);
            $("#DestinationPortal").text(originText);
            $("#destination_local").val(originFiledHidden);
        }, 10);

    } else {
        $.alert({
            title: useXmltag("BuyTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("SpecifyDestination"),
            rtl: true,
            type: 'red',
        });
    }
}


function LowestPriceFlight(dateRequest, Departure_Code, Arrival_Code, adult, child, infant, typeSelect) {

    $('#TextLight').fadeIn();
    $.post(amadeusPath + 'user_ajax.php',
       {
           dateRequest: dateRequest,
           Departure_Code: Departure_Code,
           Arrival_Code: Arrival_Code,
           adult: adult,
           child: child,
           infant: infant,
           typeSelect: typeSelect,
           flag: "MinimumPriceFlight"
       },
       function (data) {
           $('#MinimumPriceCallApi').html(data);
           setTimeout(function () {
               $('#TextLight').fadeOut();
           }, 2000);
       })

}


function InfoShowOneFlight(CabinType, AdtPrice, ChdPrice, InfPrice, Airline, FlightType, CounterId) {


    var dataInfo = {
        'CabinType': CabinType,
        'AdtPrice': AdtPrice,
        'ChdPrice': ChdPrice,
        'InfPrice': InfPrice,
        'Airline': Airline,
        'FlightType': FlightType,
        'CounterId': CounterId
    };


    $(".LoadLightbox").show();
    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'resultLocal',
           Method: 'infoFlight',
           Param: dataInfo
       },
       function (data) {
           setTimeout(function () {
               $(".LoadLightbox").hide();
               $(".price-Box").addClass("displayBlock");
               $("#lightboxContainer").addClass("displayBlock");
               $('#ShowInfoFlightCabinType').html(data);
           }, 1000);

       });
}


function BackToHome(url) {
    if (url != '') {
        window.location = url;
    } else {
        window.location = clientMainDomain;
    }

}


// function showModal(Dep, Desti, startDate) {
//
//     $(".arzan-flight-btn").addClass("displayBlock");
//     $("#lightboxContainer").addClass("lightboxContainerweek");
//
//     $('#ShowCalenderFlight').html('');
//     $('#loadbox').show();
//     $('#flight_Day_Next').hide();
//
//     $.post(amadeusPath + 'user_ajax.php',
//         {
//             code: Dep,
//             arrivalCode: Desti,
//             startDate: startDate,
//             flag: "FlightOfTwoWeek",
//         },
//         function (data) {
//
//             $('#loadbox').hide();
//             $('#flight_Day_Next').show();
//             $('#ShowCalenderFlight').html(data);
//
//         });
// }

function selectDeparture(AirportFa, DepartureCityFa, CountryFa, DepartureCode) {
    $('#OriginPortal').val(AirportFa + '-' + DepartureCityFa + '-' + CountryFa + '-' + DepartureCode);
    $('#origin_foreign').val(DepartureCode);
    $('#origin_external').val(DepartureCode);//deleteInfuture
    $('#ListAirPort').hide();
}

function selectDestination(AirportFa, DepartureCityFa, CountryFa, DepartureCode) {
    $('#DestinationPortal').val(AirportFa + '-' + DepartureCityFa + '-' + CountryFa + '-' + DepartureCode);
    $('#destination_foreign').val(DepartureCode);
    $('#destination_external').val(DepartureCode);//deleteInfuture
    $('#ListAirPortRetrun').hide();
}


function setDiscountCode(serviceType, currencyCode) {

    var discountCode = $('#discount-code').val();
    $(".discount-code-error").html('');
    var price_before_discount = $('#priceWithoutDiscountCode').val();

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'JSON',
        data:
           {
               flag: 'checkDiscountCode',
               discountCode: discountCode,
               serviceType: serviceType,
               currencyCode: currencyCode
           },
        success: function (data) {
            if (data.result_status == 'success') {

                var price_after_discount = price_before_discount - data.discountAmount;
                if (price_after_discount % 1 !== 0) {
                    price_after_discount = price_after_discount.toFixed(2); //float
                }
                $(".discount-code-error").html(data.result_message);
                $(".discountAmount").html(number_format(data.discountAmount));
                // $(".item-discount__label").html(useXmltag("AmountPayableAfterApplyingDiscountCode"));
                $(".price-after-discount-code").html(number_format(price_after_discount));

            } else {
                $(".discount-code-error").html(data.result_message);
                $(".item-discount__label").html(useXmltag("Amountpayable") + ':');
                $(".price-after-discount-code").html(number_format(price_before_discount));
            }

            if ($('#factor_bank').css('display') == 'block') {
                checkMemberCredit();
            }
        }
    });

}


function number_format(num) {
    if(num == null){
        num = 0;
    }
    num = num.toString();
    return num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function checkReagentCode(reagentCode) {
    $("#error-reagent-code2").css("opacity", "0");
    $("#error-reagent-code2").css("visibility", "invisible");

    if (reagentCode.length != 10) {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'checkReagentCode',
            reagentCode: reagentCode
        },
        success: function (data) {
            if (data.result_status == 'success') {
                $("#error-reagent-code2").html(data.result_message);
                $("#error-reagent-code2").css('background', 'rgba(68, 150, 97, 0.9)');
                $("#error-reagent-code2:after").css('border-color', 'rgba(68, 150, 97, 0.9)');
                $("#error-reagent-code2").css("opacity", "1");
                $("#error-reagent-code2").css("visibility", "visible");

            } else {
                $("#error-reagent-code2").html(data.result_message);
                $("#error-reagent-code2").css('background', 'rgba(215, 102, 102, 0.9)');
                $("#error-reagent-code2:after").css('border-bottom-color', 'rgba(215, 102, 102, 0.9)');
                $("#error-reagent-code2").css("opacity", "1");
                $("#error-reagent-code2").css("visibility", "visible");
            }

            setTimeout(function () {
                $("#error-reagent-code2").css("opacity", "0").css("visibility", "none");
            }, 5000);
        }
    });
}

function sendToFactorVisa() {
    var href = amadeusPathByLang + "factorVisa";
    console.log('href' , href)
    $("#formPassengerDetailVisaa").attr("action", href);
    $("#formPassengerDetailVisaa").submit();
}
function sendFromResultToVisaPassengers(){
    var href = amadeusPathByLang + "passengersDetailVisa";

    $("#visaResultForm").attr("action", href);
    $("#visaResultForm").submit();
}

function popupLogin(useType, param1 = null) {
    if (useType == 'ticket') {
        memberLocalLogin();
    } else if (useType == 'newApiHotel') {
        BuyHotelWithoutRegisterApiNew();
    } else if (useType == 'hotel') {
        //memberHotelLocalLogin();
        BuyHotelWithoutRegister();
    } else if (useType == 'insurance') {
        memberInsuranceLogin();
    } else if (useType == 'externalHotel') {
        //memberExternalHotel();
        buyExternalHotelWithoutRegister();
    } else if (useType == 'tour') {
        //memberTourLogin();

        let is_request=false
        if($('#is_request').val() == '1'){
            is_request=true
        }

        BuyTourWithoutRegister(is_request);
    } else if (useType == 'gasht') {
        //memberGashtLogin();
        BuyGashtWithoutRegister();
    } else if (useType == 'europcar') {
        //memberEuropcarLogin();
        viewCar();
    } else if (useType == 'visa') {
        //memberVisaLogin();
        // sendToVisaPassengers();
        sendToFactorVisa()
    } else if (useType == 'visa2') {
        //memberVisaLogin();
        // sendToVisaPassengers();
        sendFromResultToVisaPassengers()
    }
    else if (useType == 'bus') {
        reserveBusTicketWithoutRegister();
    } else if (useType == 'train') {
        BuyTrainWithoutRegister();
    } else if (useType == 'showTourB2BAccess') {
        showTourB2BAccess();
    }else if (useType == 'entertainment') {

        var param2 = $('#send_data');

        RunPreReserveEntertainment(param1, param2);
    }else if (useType == 'exclusiveTour') {
        // بعد از لاگین در صفحه تور اختصاصی، صفحه را reload کن
        if(localStorage.getItem('pendingExclusiveTourAction')){
            window.location.reload();
        }
    }

}

function popupBuyNoLogin(useType, param1 = null, param2 = null,_this=null) {
    //پارام ها برای متغیری است که توی فانشنی که قراره کار کنه نیاز میشه .  اگه نداشت دیفالت رو نال گذاشتم که به مشکل نخوره

    if(_this && _this.length){
        loadingToggle(_this);
    }
    // $('#noLoginBuy').addClass('skeleton');
    if (useType == 'ticket') {
        console.log('inja2')
        BuyWithoutRegister();
    } else if (useType == 'hotel') {
        BuyHotelWithoutRegister();
    } else if (useType == 'newApiHotel') {
        BuyHotelWithoutRegisterApiNew();
    } else if (useType == 'newApiHotelExternal') {
        BuyHotelWithoutInputsApiNew(param1);
    } else if (useType == 'insurance') {
        BuyInsuranceWithoutRegister();
    } else if (useType == 'externalHotel') {
        buyExternalHotelWithoutRegister();
    } else if (useType == 'tour') {
        let is_request=false
        if($('#is_request').val() === '1'){
            is_request=true
        }
        BuyTourWithoutRegister(is_request);
    } else if (useType == 'gasht') {
        BuyGashtWithoutRegister();
    } else if (useType == 'europcar') {
        viewCar();
    } else if (useType == 'visa') {
        sendToFactorVisa()
    } else if (useType == 'visa2') {
        //memberVisaLogin();
        // sendToVisaPassengers();
        sendFromResultToVisaPassengers()
    }
    else if (useType == 'bus') {
        reserveBusTicketWithoutRegister();
    } else if (useType == 'train') {
        BuyTrainWithoutRegister();
    } else if (useType == 'newTrain') {
        BuyTrainWithoutRegister(true);
    } else if (useType == 'showTourB2BAccess') {
        showTourB2BAccess();
    } else if (useType == 'entertainment') {
        if (param2 == '' ||  param2 == null) {
            param2 = $('#send_data');
        }
        RunPreReserveEntertainment(param1, param2);
    } else if (useType == 'exclusiveTour') {
        // بعد از لاگین در صفحه تور اختصاصی، صفحه را reload کن
        if(localStorage.getItem('pendingExclusiveTourAction')){
            window.location.reload();
        }
    }

}

function checkMemberCredit() {

    if ($("input[name='chkCreditUse']:checked").val() == 'member_credit') {
        var price_to_pay = parseInt($(".price-after-discount-code").html().replace(/,/g, ''));
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data:
               {
                   flag: 'checkMemberCredit',
                   priceToPay: price_to_pay,
                   creditUse: $("input[name='chkCreditUse']:checked").val()
               },
            success: function (data) {

                if (data.result_status === 'none_credit') {
                    $('.creditText').addClass('none_credit');
                } else if(data.result_status === 'full_credit') {
                    $('.creditText').addClass('full_credit');
                }
                $(".creditText").html(data.result_message[0]);
                $('.onlinePaymentBox').addClass('hidden');
                $('.creditText').removeClass('hidden');
            }
        });
    } else if ($("input[name='chkCreditUse']:checked").val() == 'online_payment') {
        $('.onlinePaymentBox').removeClass('hidden');
        $('.creditText').addClass('hidden');
    }
}

function changeWays(obj) {

    if ($(obj).hasClass('checked')) {
        $('#dept_date_local_return').parents('.s-u-form-block').removeClass('showHidden').addClass('hidden');
    } else {
        $('#dept_date_local_return').parents('.s-u-form-block').removeClass('hidden').addClass('showHidden');
    }

    $(obj).toggleClass('checked');
}



function changeWays_(obj) {

    if (obj == 'Oneway') {
        $('#dewey').removeClass('checked');
        $('#dept_date_local_return').parents('.s-u-form-block').removeClass('showHidden').addClass('hidden');
    } else {
        $('#dewey').addClass('checked');
        $('#dept_date_local_return').parents('.s-u-form-block').removeClass('hidden').addClass('showHidden');
    }

    $(obj).toggleClass('checked');
}



//deleteInfuture
function changeWaysForeignSearchFake(obj) {

    if ($(obj).hasClass('checked')) {
        $('#date_external_return').parents('.s-u-form-block').removeClass('showHidden').addClass('hidden');
    } else {
        $('#date_external_return').parents('.s-u-form-block').removeClass('hidden').addClass('showHidden');
    }

    $(obj).toggleClass('checked');
}

function undoFlightSelect() {

    $('.selectedTicket').html('');
    $('.international-available-box.returnFlight').fadeOut(1500);
    $('.international-available-box.deptFlight').fadeIn(1500);

}

function ConvertCurrency(Code, Icon, Title) {

    var ValCurrency = Code;

    $('#IconDefaultCurrency').attr('src', rootMainPath + '/gds/pic/flagCurrency/' + Icon);
    $('.TitleDefaultCurrency').html(Title);


    if (ValCurrency > 0) {

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data:
               {
                   flag: 'CurrencyEquivalent',
                   ValCurrency: ValCurrency
               },
            success: function (response) {

                $(".CurrencyCal").each(function (index) {
                    var str = $(this).data('amount');

                    var calculateCurrency = (str / response.EqAmount);

                    if (calculateCurrency % 1 !== 0) {
                        calculateCurrency = calculateCurrency.toFixed(2); //float
                        console.log(calculateCurrency)
                    }
                    $(this).text(calculateCurrency);
                });
                $('.CurrencyCode').val(ValCurrency);
                $('.CurrencyText').html(response.CurrencyTitleEn);

            }
        });

    } else {

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data:
               {
                   flag: 'CurrencyEquivalent',
                   ValCurrency: '0'
               },
            success: function (response) {

                $(".CurrencyCal").each(function (index) {
                    var str = parseInt($(this).data('amount'));
                    var calculateCurrency = (str / response.EqAmount);
                    $(this).text(addCommas(str));
                });

                $('.CurrencyCode').val('0');
                $('.CurrencyText').html(useXmltag("Rial"));

            }
        });

    }

}


function ChangePriceStepFinal() {

    var ValuePrice = $('#ChangePriceStepFinal').val();
    ValuePrice = ValuePrice.replace(/,/g, '');
    var factorNumber = $('#ChangePriceStepFinal').attr('data-factorNumber');

    $.post(amadeusPath + 'user_ajax.php',
       {
           AmountAdded: ValuePrice,
           factorNumber: factorNumber,
           flag: 'AmountAdded'
       },
       function (data) {

           var Res = data.split(':');
           if (data.indexOf('SuccessToAmountAdded') > -1) {
               $.alert({
                   title: useXmltag("AddPrice"),
                   icon: 'fa fa-refresh',
                   content: Res[1],
                   rtl: true,
                   type: 'green'
               });
           } else {
               $.alert({
                   title: useXmltag("AddPrice"),
                   icon: 'fa fa-refresh',
                   content: Res[1],
                   rtl: true,
                   type: 'red'
               });
           }

       });
}


function showListAgencyByCity() {

    var city = $('#city').val();
    var url = amadeusPathByLang + "agencyListByCity/" + city;
    window.location.href = url;

}

/*zomorod*/
$(document).ready(function () {
    $('.btn_more_t').click(function (){
        $(this).parents('.timeline-type2-content').find('.bodyDiv').toggleClass('activetxt')
        let txtthis = $(this).html();

        if(txtthis == 'نمایش بیشتر') {
            $(this).text('نمایش کمتر')
        }
        else{
            $(this).text('نمایش بیشتر')
        }

    })
    $('body').on('click', '.more_package',function (){
        $(this).parent('.slideDownpackageDescription').hide();
        $(this).parents('.international-available-details').find('.slideUppackageDescription').removeClass('displayiN');
        $(this).parents('.international-available-details').addClass('show');


    })
    $('body').on('click', '.slideUppackageDescription',function (){
        $(this).parents('.international-available-details').removeClass('show');
        $(this).parent().find('.slideDownpackageDescription').show();
        $(this).addClass('displayiN');


    })
    if (gdsSwitch !== 'buses' && gdsSwitch !=='resultInsurance' ) {
        $('body').on('click', '.my-more-info', function () {
            $(this).parents('.international-available-details').addClass('show');
            $(this).parent().addClass('displayiN');
            $(this).parents().find('.slideUpHotelDescription').removeClass('displayiN');
        })
        $('body').on('click', '.slideUpHotelDescription', function () {
            $(this).parent('.international-available-details').removeClass('show');
            $(this).parents().find('.slideDownHotelDescription').removeClass('displayiN');
            $(this).addClass('displayiN');
        })
    }
    $('#Emerald-pay').click(function () {
        if ($('.s-u-passenger-wrapper-change.Emerald').hasClass('disabled')) {
            $('.s-u-passenger-wrapper-change.Emerald').removeClass('disabled');


        } else {
            $('.s-u-passenger-wrapper-change.Emerald').addClass('disabled');

        }
    });
    $('.s-u-passenger-wrapper-change.Emerald .close-box').click(function () {
        $('.s-u-passenger-wrapper-change.Emerald').addClass('disabled');
    });

    $("#UpdateCounterDetail").validate({
        rules: {
            name: 'required',
            sheba: {
                required: true,
                minlength: 26,
            },
            bankHesab: {
                required: true,
            },
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function (data) {
                    var res = data.split(':');
                    if (data.indexOf('success') > -1) {
                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: res[1],
                            rtl: true,
                            type: 'green',
                        });

                        setTimeout(function () {
                            window.location = 'userProfile';
                        }, 1000);

                    } else {

                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: res[1],
                            rtl: true,
                            type: 'red',
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


    $("#RequestZomorod").validate({
        rules: {
            payRial: {
                required: true
            }
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            if ($('input[name=cond2]').val() == '') {
                $.alert({
                    title: useXmltag("Emerald"),
                    icon: 'fa fa-refresh',
                    content: useXmltag("InsertAccountInformationInProfile"),
                    rtl: true,
                    type: 'red',
                });
                return false;
            } else if ($('#payRial').val() >= ($('input[name=remain]').val() - $('input[name=cond]').val())) {
                $.alert({
                    title: useXmltag("Emerald"),
                    icon: 'fa fa-refresh',
                    content: useXmltag("AmountAskGreaterEmeraldRequest"),
                    rtl: true,
                    type: 'red',
                });
                return false;
            }
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function (data) {

                    if (data.indexOf('success') > -1) {

                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: useXmltag("ApplicationSuccessfullyRegistered"),
                            rtl: true,
                            type: 'green',
                        });

                        setTimeout(function () {
                            window.location = 'Emerald';
                        }, 1000);

                    } else {

                        $.alert({
                            title: useXmltag("UpdateProfile"),
                            icon: 'fa fa-refresh',
                            content: useXmltag("RequestWasNotRegistered"),
                            rtl: true,
                            type: 'red',
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

    $(".SubmitNewComment").validate({
        rules: {
            text: 'required',
            name: 'required',
            family: 'required',
            email: 'required',
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            $('.SubmitNewComment button[type="submit"]').prop('disabled', true).addClass('ph-item-transparent btn-secondary').removeClass('btn-primary');

            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType: 'JSON',
                success: function (data) {
                    $('.SubmitNewComment button[type="submit"]').prop('disabled', false).addClass('btn-primary').removeClass('ph-item-transparent btn-secondary');
                    if (data.result_status == 'success') {
                        $.alert({
                            title: useXmltag("YourcommenthasbeenregisteredThankyou"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'green',
                        });

                    } else {

                        $.alert({
                            title: useXmltag("NewRequestError"),
                            icon: 'fa fa-refresh',
                            content: data.result_message,
                            rtl: true,
                            type: 'red',
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

    $("body").delegate(".CommendReplyBtn", "click", function () {
        $('.InfoCommentBox').remove();
        var thiss = $(this);
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            data: {
                flag: 'GetOneComment',
                commentId: thiss.attr('data-parent')
            },
            success: function (data) {

                data = JSON.parse(data);
                if (data.id != '0') {

                    $('.SubmitNewComment').before('<div class="card w-100 InfoCommentBox mb-3" >\n' +
                       '  <div class="card-header">' + useXmltag("SubmitNewReplyFor") + ' <span class="close CloseInfoCommentBox">&times;</span></div>\n' +
                       '  <div class="card-body">\n' +
                       '    <h5 class="card-title">' + data.name + '</h5>\n' +
                       '    <p class="card-text">' + data.text + '</p>\n' +
                       '  </div>\n' +
                       '</div>').find('input[name="parent_id"]').val(data.id);
                    $('.SubmitNewComment').find('.btnSubmitCommentBox').find('button').html(useXmltag("SubmitNewCommentReply"));

                    $.smoothScroll({
                        scrollTarget: '.InfoCommentBox',
                        offset: -75
                    });

                } else {
                    $.alert({
                        title: useXmltag("RequestSMSFlightBooking"),
                        icon: 'fa fa-refresh',
                        content: '',
                        rtl: true,
                        type: 'red',
                    });
                }
            }
        });


    });
    $("body").delegate(".CloseInfoCommentBox", "click", function () {
        $('.InfoCommentBox').remove();
        $('.SubmitNewComment').find('input[name="parent_id"]').val('0');
        $('.SubmitNewComment').find('.btnSubmitCommentBox button').html(useXmltag("SubmitNewComment"));
    });
    $("body").delegate(".btnSubmitCommentBox.col-3", "click", function () {
        $('.InfoCommentBox').remove();
        $('.SubmitNewComment').find('input[name="parent_id"]').val('0');
        $('.SubmitNewComment').find('.btnSubmitCommentBox button').html(useXmltag("SubmitNewComment"));
    });

});

//add counter details hesab

function SendSmsRequestOffline() {

    var InfoFlight = $('#InfoFlightRequest').val();
    var fullName = $('#fullName').val();
    var mobile = $('#mobile').val();

    if (fullName == '' || mobile == '') {
        $.alert({
            title: useXmltag("RequestSMSFlightBooking"),
            icon: 'fa fa-refresh',
            content: useXmltag("PleaseEnterItems"),
            rtl: true,
            type: 'red',
        });

        return false;
    } else {
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            data: {
                flag: 'RequestTicketOffline',
                InfoFlight: InfoFlight,
                fullName: fullName,
                mobile: mobile
            },
            success: function (data) {

                data = JSON.parse(data);
                if (data.messageStatus == 'Success') {
                    $.alert({
                        title: useXmltag("RequestSMSFlightBooking"),
                        icon: 'fa fa-refresh',
                        content: data.messageRequest,
                        rtl: true,
                        type: 'green',
                    });
                } else {
                    $.alert({
                        title: useXmltag("RequestSMSFlightBooking"),
                        icon: 'fa fa-refresh',
                        content: data.messageRequest,
                        rtl: true,
                        type: 'red',
                    });
                }
            }
        });
    }
}

function requestSms() {
    var FlightIdSelect = $('#FlightIdSelect').val();

    $(".cd-user-modal").removeClass('is-visible');
    $('#smsRequestTicket-' + FlightIdSelect).trigger('click');

}

function get_routs() {
    var departure = $('#origin_local').val();
    $.post(amadeusPath + 'user_ajax.php',
       {
           flag: 'get_routs',
           departure: departure,
       },
       function (data) {

           $('#destination_local').html(data);
           setTimeout(function () {

               $('#destination_local').removeAttr('disabled');
               $('#destination_local').select2('open');
           }, 10);
       });
}

function Email123(str, NameDiv) {
    if ($('#signin-email2').attr('data-login') == 1) {
        var at = "@";
        var dot = ".";
        var lat = str.indexOf(at);
        var lstr = str.length;
        var ldot = str.indexOf(dot);

        $('#alert_email').html('');
        if (str.indexOf(at) == -1) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        } else if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        } else if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        } else if (str.indexOf(at, (lat + 1)) != -1) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        } else if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        } else if (str.indexOf(dot, (lat + 2)) == -1) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        } else if (str.indexOf(" ") != -1) {
            if (NameDiv != "") {
                $('#' + NameDiv).html('yes');
            } else {
                $('#error-signin-email2').html(useXmltag("Invalidemail"));
            }
            return false
        }

        if (NameDiv != "") {
            $('#' + NameDiv).html('');
        } else {
            $('#error-signin-email2').html('');
        }
        $("#signin-email2").attr("data-login", "0");
        return true;
    }
}// end fun
function Email1234(str, NameDiv) {
    var at = "@";
    var dot = ".";
    var lat = str.indexOf(at);
    var lstr = str.length;
    var ldot = str.indexOf(dot);

    $('#alert_email').html('');
    if (str.indexOf(at) == -1) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    } else if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    } else if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    } else if (str.indexOf(at, (lat + 1)) != -1) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    } else if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    } else if (str.indexOf(dot, (lat + 2)) == -1) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    } else if (str.indexOf(" ") != -1) {
        if (NameDiv != "") {
            $('#' + NameDiv).html('yes');
        } else {
            $('#error-signup-email2').html(useXmltag("Invalidemail"));
        }
        return false
    }

    if (NameDiv != "") {
        $('#' + NameDiv).html('');
    } else {
        $('#error-signup-email2').html('');
    }

    return true;
}// end fun


function goToPage(nameFile, selectPage, count, origin, destination, adult, child, infant, date_dept, page, lang, return_date) {
    $('.lightboxContainerOpacity').show();
    $('#result').html('');
    $('html, body').animate({
        scrollTop: $('#sendFlight').offset().top
    }, 'slow');

    var optionPage = {
        'numberPage': selectPage,
        'countTicket': count,
        'adult': adult,
        'child': child,
        'infant': infant,
        'date_dept': date_dept,
        'lang': lang,
        'return_date': return_date,
        'origin': origin,
        'destination': destination,
    }
    $.post(amadeusPath + 'user_ajax.php',
       {
           nameFile: nameFile,
           optionPage: optionPage,
           flag: 'nextPageTicketForeign'
       },
       function (data) {
           $('.lightboxContainerOpacity').fadeOut("slow");
           $('#result').html(data);
       });
}

function pricePay(factorNumber,type) {
    var checkDuplicate = 'no' ;
    if((typeof factorNumber !== 'undefined') && type == 'flight'){
        $.post(amadeusPath + 'user_ajax.php',
           {
               factorNumber: factorNumber,
               flag: 'checkDuplicate724'
           },
           function (data) {
               if(data=='yes')
               {
                   checkDuplicate = 'yes';
               }
           });
    }

    setTimeout(function () {
        if(checkDuplicate == 'no'){
            if ($('#RulsCheck').length == '1' && !$('#RulsCheck').is(':checked')) {
                $.alert({
                    title: useXmltag("Note"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ConfirmTermsFirst"),
                    rtl: true,
                    type: 'red'
                });
                return false;
            }
            if ($('#CovidRulsCheck').length == '1' && !$('#CovidRulsCheck').is(':checked')) {
                $.alert({
                    title: useXmltag("Note"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ConfirmCovidTermsFirst"),
                    rtl: true,
                    type: 'red'
                });
                return false;
            }
            $('.main-pay-content').css('display' , 'flex');
            $('.s-u-passenger-wrapper-change').show();
            $('#loader_check').css("display", "none");
            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');

            // $('.s-u-p-factor-bank-change').show();
            // $('.s-u-passenger-wrapper-change').show();
            // $('#loader_check').css("display", "none");
            // $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');

        }else{

            $('.lazy-loader-parent').remove();
            $.confirm({
                title: useXmltag('duplicateFlight'),
                content: useXmltag('descriptionDuplicateFlight'),
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: useXmltag('countinueBuy'),
                        btnClass: 'btn-green',
                        action: function () {
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
                            if ($('#CovidRulsCheck').length == '1' && !$('#CovidRulsCheck').is(':checked')) {
                                $.alert({
                                    title: useXmltag("Note"),
                                    icon: 'fa fa-cart-plus',
                                    content: useXmltag("ConfirmCovidTermsFirst"),
                                    rtl: true,
                                    type: 'red'
                                });
                                return false;
                            }
                            $('.main-pay-content').css('display' , 'flex');
                            $('.s-u-passenger-wrapper-change').show();
                            $('#loader_check').css("display", "none");
                            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                        }
                    },
                    close: {
                        text: useXmltag('Repeatsearch'),
                        btnClass: 'btn-red',
                        action: function () {

                            $('button.cancel-passenger').trigger('click')
                        }
                    }
                }
            });
        }
    },1000)

}

function nationalityChangeLang(thisGdsSwitch) {

    if (lang !== 'fa') {
        $.each(thisGdsSwitch, function (index, value) {
            if (value === gdsSwitch) {
                $('.justIranian').css({"display": "none"});
                $('.noneIranian').css({"display": "block"});
            }
        });

        if (jQuery.inArray(gdsSwitch, thisGdsSwitch) != -1) {
            $('.nationalityChange').each(function () {
                if ($(this).val() == 1) {
                    $(this).prop('checked', true);
                }
            });
        }

    } else {
        if (jQuery.inArray(gdsSwitch, thisGdsSwitch) != -1) {
            $('.nationalityChange').each(function () {
                if ($(this).val() == 0) {
                    $(this).prop('checked', true);
                }
            });
        }
    }

}

//deleteInfuture
function submitLocalSideExternalFake() {

    $('#loader_check_submit').css('display', 'block');
    $('#sendFlight').css('opacity', '0.4').attr('onclick', false);

    var multiWay = '1';
    if ($('.multiWays').hasClass('checked')) {
        multiWay = '2';
    }
    var origin = $("#origin_external").val();
    var destination = $("#destination_external").val();
    var dept_date = $("#dept_date_external").val();
    var return_date = '';
    var flightNumber = $("#searchFlightNumber").val();

    if ($("#date_external_return").parents('.s-u-form-block').hasClass('showHidden')) {
        return_date = $("#date_external_return").val();
    }
    // var classf = $("#classf_local").val();
    var adult = Number($("#qtyExternal1").val());
    var child = Number($("#qtyExternal2").val());
    var infant = Number($("#qtyExternal3").val());
    if (origin == "" || destination == "" || dept_date == "" || adult == "" || (multiWay == '2' && return_date == '')) {
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
    } else if (adult == 0) {
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("LeastOneAdult"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
    } else if (parseInt(infant) > parseInt(adult)){

        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("SumAdultsChildrenNoGreaterThanAdult"),
            rtl: true,
            type: 'red'
        });
    }else if (parseInt(adult + child) > 9 ) {
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()');
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ErrorAdultCount"),
            rtl: true,
            type: 'red'
        });
    } else {
        if (dept_date.indexOf('/') > -1) {
            var dept_date_aa = dept_date.replace('/', '-');
            var date_final = dept_date_aa.replace('/', '-');
        } else {
            var date_final = dept_date;
        }

        if (return_date.indexOf('/') > -1) {
            var return_date_aa = return_date.replace('/', '-');
            var return_date_final = return_date_aa.replace('/', '-');
        } else {
            var return_date_final = return_date;
        }

        if (return_date_final != '') {
            date_final = date_final + "&" + return_date;
        }

        var ori_dep = origin + "-" + destination;
        var num = adult + "-" + child + "-" + infant;

        var typeSearch = 'international';


        var flightNumberSearch = "";
        if (flightNumber != '' && typeof flightNumber !== 'undefined') {
            var urlNow = window.location.href;
            var urlExp = urlNow.split('/');
            if (urlExp[6].indexOf('-')) {
                var urlCity = urlExp[6].split('-');
            } else {
                var urlCity = urlExp[7].split('-');
            }
            if (urlCity[0] == origin && urlCity[1] == destination) {
                var flightNumberSearch = "/" + flightNumber;
            }
        }
        var url = amadeusPathByLang + typeSearch + "/" + multiWay + "/" + ori_dep + "/" + date_final + "/Y/" + num + flightNumberSearch;

        window.location.href = url;

    }


}


function modalCancelBuy(typeApplication, factorNumber) {
    $('.loaderPublic').fadeIn();

    $.post(libraryPath + 'modalCancelBuy.php',
       {
           typeApplication: typeApplication,
           factorNumber: factorNumber,
           methodName: 'showModalCancelBuy'
       },
       function (data) {
           $('.loaderPublic').fadeOut(150);
           $("#ModalPublic").fadeIn(150);
           $('#ModalPublicContent').html(data);
       });
}


function requestCancelBuy(typeApplication, factorNumber) {

    if ($('#Ruls').is(':checked')) {

        $("form#cancelBuyForm").find('#typeApplication').val(typeApplication);
        $("form#cancelBuyForm").find('#factorNumber').val(factorNumber);
        alert('drdr')
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
                        $("#ModalPublic").fadeOut(700);
                    }, 1000);

                } else {
                    $.alert({
                        title: useXmltag("SendCancellationRequest"),
                        icon: 'fa fa-times',
                        content: res[1],
                        rtl: true,
                        type: 'red',
                    });
                    setTimeout(function () {
                        $("#ModalPublic").fadeOut(700);
                    }, 1000);
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


function registerCancelBuy(factor_number, typeApp) {

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        data:
           {
               factor_number: factor_number,
               typeApp: typeApp,
               flag: "flagRegisterCancelBuy"
           },
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

            } else {
                $.alert({
                    title: useXmltag("SendCancellationRequest"),
                    icon: 'fa fa-times',
                    content: res[1],
                    rtl: true,
                    type: 'red',
                });
            }


        }
    });

}

function getUserAccount() {
    var checkVisible = $('.lowest').is(':visible');
    var origin = $('#originFlight').val();
    var destination = $('#destinationFlight').val();
    var checkOpenFifteenFlight = $('#checkOpenFifteenFlight').val();
    var typePage;
    if ($("#lowerSortSelect").hasClass('lowerSortSelectVue')) {
        typePage = 'searchFlight';
    } else {
        typePage = 'Local';
    }
    console.log(checkOpenFifteenFlight);
    if (checkOpenFifteenFlight == "") {
        $('.flightFifteen').fadeIn();
        $('#showDataFlight ').html('');
        $('#checkOpenFifteenFlight').val('buys');
        if (!checkVisible) {
            $.ajax({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                data:
                   {
                       Origin: origin,
                       Destination: destination,
                       type: typePage,
                       flag: "fifteenFlight"
                   },
                success: function (data) {
                    $('#showDataFlight ').html(data);
                    $('.flightFifteen').fadeOut("slow");
                    $('#showDataFlight').owlCarousel({
                        items: 6,
                        navigation: true,
                        rtl: true,
                        dots:false,
                        nav: true,
                        margin: 7,
                        responsive: {
                            300: {
                                margin: 5,
                                items: 2,
                            },
                            400: {
                                margin: 7.5,
                                items: 3,
                            },

                            576: {
                                margin: 7,
                                items: 4,
                            },
                            768: {
                                margin: 7,
                                items: 5,
                            },
                            1000: {}
                        }
                    });


                }

            });
        }
    }

}

function ShowModalOfFlights(origin, destination, searchType) {

    var modal_data1 = '<div class="modal-header"><h5 class="_100 text-right modal-title void-space mr-0 ph-item" id="exampleModalScrollableTitle"></h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div><div class="modal-body flight-prices"><div id="loadbox" style="display: block;"></div><div class="row">';
    var modal_data2 = '';

    for (i = 0; i < 15; i++) {
        modal_data2 += '<div class="flight-modal-items"><a href="javascript:;" class="flight-price-item flight-price-item-tag-a ph-item"><div class="flitght-price-price"><span class="pt-0 pb-2"><div class="void-space col-6 ph-item"></div></span><span class="void-space flitght-price-price-info"></span><div class="flitght-price-date void-space flitght-price-price-info"></div></div></a></div>';
    }
    var modal_data3 = '</div></div><div class="modal-footer"><button type="button" aria-hidden="true" class="btn btn-primary" data-dismiss="modal" aria-label="Close">بستن</button></div></div>';

    $('.modal-content').html(modal_data1 + modal_data2 + modal_data3);

    $('#ModalOfFifteenFlights').modal('show');

    $('.flitght-price-price-info').each(function () {
        $(this).addClass('void-space');
        $(this).html('');
        $('.flight-price-item-tag-a').attr('href', '').addClass('ph-item');
        $('.flight-price-item-disable').removeClass('flight-price-item-disable');
    });

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        data:
           {
               Origin: origin,
               Destination: destination,
               searchType: searchType,
               flag: "fifteenFlightModalView"
           },
        success: function (data) {

            $('#ModalOfFifteenFlights .modal-content').html(data);
            // $(".modal-backdrop").remove();

        }

    });


}

function reserveEntertainmentTemprory(factorNumber) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("Tourreservation"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress');
    $('#loader_check').css("display", "block");

    $.post(amadeusPath + 'entertainment_ajax.php',
       {
           factorNumber: factorNumber,
           flag: "preReserveEntertainment"
       },
       function (data) {

           var result = data.split(":");
           if (data.indexOf('error') > -1) {

               $('#messageBook').html(result[1]);

           } else if (data.indexOf('success') > -1) {

               setTimeout(function () {
                   $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));

                   $('.main-pay-content').css('display','flex');
                   $('#loader_check').css("display", "none");
                   $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
               }, 2000);

           }


       });


}


function SendDataToClub() {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        data:
           {
               flag: 'sendDataToClub',
           },
        success: function (dataPassenger) {
            console.log(dataPassenger);
        }
    });
}


function  sendDataToPrereservePackage(currentDate, numAdult, numChild, numInfant, uniq_id){
    var error1 = 0;
    var error2 = 0;
    var error3 = 0;
    var error4 = 0;
    var error5 = 0;
    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();
    // Mr Afshar's phone
    var sample_number = '09123493154';

    var FlightType = $('#FlightType').val();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);


    $('#loader_check').show();
    $('#send_data').attr('disabled','disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));
    var NumberPassenger = parseInt(numAdult) + parseInt(numChild) + parseInt(numInfant);

    if (numAdult > 0) {
        var adt = Adult_members(currentDate, numAdult);
        if (adt == 'true') {
            error1 = 0;
        } else {
            error1 = 1
        }
    }


    if (numChild > 0) {
        var chd = Chd_memebrs(currentDate, numChild);
        if (chd == 'true') {
            error2 = 0;
        } else {
            error2 = 1
        }
    }


    if (numInfant > 0) {
        var inf = Inf_members(currentDate, numInfant);
        if (inf === 'true') {
            error3 = 0;
        } else {
            error3 = 1
        }
    }

    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#Mobile').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
        if (!mobregqx.test(mob) && lang == 'fa') {
            $("#messageInfo").html('<br>' + useXmltag("MobileNumberIncorrect"));
            error4 = 1;
        } else {
            error4 = 0
        }
    }

    if ($("#Mobile_buyer").length > 0) {
        var mobile_buyer = $('#Mobile_buyer').val();
        var mobile_buyer_input = $('#Mobile_buyer');
    } else {
        var mobile_buyer = $('#Mobile').val();
        var mobile_buyer_input = $('#Mobile');

        if (mobile_buyer == '') {
            if (lang == 'fa') {
                error5 = 1;
                $("#errorInfo").html('<br>' + useXmltag("EnterRequiredInformation")).css('color', '#ce4235');
            } else {
                mobile_buyer_input.val(sample_number);
            }
        }
    }

    if (mobile_buyer != '') {
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;

        if (!mobregqx.test(mobile_buyer)) {
            $("#errorInfo").html('<br>' + useXmltag("MobileNumberIncorrect")).css('color', '#ce4235');
            error5 = 1;
        }
    }


    if ($("#Email_buyer").length > 0) {
        var email_buyer = $('#Email_buyer').val()
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
        var IdMember = '';
        var SourceIdFlight = $('#SourceIdFlight').val();
        setTimeout(
           function () {
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
                          $('#IdMember').val(res[1]);
                          IdMember = $('#IdMember').val();
                          var typeReserve = $('#typeReserve').val();
                          var factorNumberHotel = $('#factorNumber').val();
                          console.log('factor_number=>'+factorNumberHotel);
                          var dataForm = $('#formPassengerDetailPackage').serialize();
                          setTimeout(function () {
                              $.ajax({
                                  type: 'POST',
                                  url: amadeusPath + 'user_ajax.php',
                                  dataType: 'JSON',
                                  data:
                                     {
                                         flag: 'PreReservePackage',
                                         uniq_id: uniq_id,
                                         NumCount: NumberPassenger,
                                         dataForm: dataForm,
                                         factorNumber :factorNumberHotel
                                     },
                                  success: function (data) {
                                      console.log(data);
                                      var RequestNumber = {};

                                      if (data.total_status == 'success') {
                                          if (typeof data.TwoWay !== 'undefined') {
                                              $('#RequestNumber_TwoWay').val(data.TwoWay.result_request_number);
                                              var requestNumberFlight = $('#RequestNumber_TwoWay').val();
                                              RequestNumber['TwoWay'] = requestNumberFlight;
                                              $('#factor_number_Flight').val(data.TwoWay.result_factor_number);
                                          }

                                          var RequestNumber = JSON.stringify(RequestNumber) ;
                                          var SourceId = JSON.stringify(SourceIdFlight) ;
                                          $.ajax({
                                              type: 'POST',
                                              url: amadeusPath + 'user_ajax.php',
                                              dataType: 'JSON',
                                              data:
                                                 {
                                                     flag: 'bookFlight',
                                                     RequestNumber: RequestNumber,
                                                     IdMember: IdMember,
                                                     SourceId: SourceId,
                                                 },
                                              success: function (data) {
                                                  if (data.total_status == 'success') {
                                                      $.ajax({
                                                          type: 'POST',
                                                          url: amadeusPath + 'user_ajax.php',
                                                          dataType: 'JSON',
                                                          data:
                                                             {
                                                                 flag: 'prereserveHotel',
                                                                 formData: dataForm,
                                                             },
                                                          success: function (data) {
                                                              console.log(data)
                                                              if(data.status == 'success')
                                                              {
                                                                  var factorNumber = $('#factorNumber').val();
                                                                  var typeApplication = $('#typeApplication').val();
                                                                  var RequestNumberHotel = $('#RequestNumberHotel').val();
                                                                  var temporary = $('#temporary').val();
                                                                  $.ajax({
                                                                      type: 'POST',
                                                                      url: amadeusPath + 'user_ajax.php',
                                                                      dataType: 'JSON',
                                                                      data:
                                                                         {
                                                                             flag: 'bookHotel',
                                                                             factorNumber: factorNumber,
                                                                             typeApplication: typeApplication,
                                                                             requestNumber: RequestNumberHotel
                                                                         },
                                                                      success: function (data) {
                                                                          console.log(data);
                                                                          if(data.book == 'yes')
                                                                          {
                                                                              var form = document.getElementById('SendDataToPackageFactor');
                                                                              form.setAttribute('method',"post");
                                                                              form.setAttribute('action',amadeusPathByLang + 'factorPackage');

                                                                              //input 1
                                                                              var hiddenField = document.createElement("input");
                                                                              hiddenField.setAttribute("type", "hidden");
                                                                              hiddenField.setAttribute("name", "RequestNumberFlight");
                                                                              hiddenField.setAttribute("value", requestNumberFlight);
                                                                              form.appendChild(hiddenField);
                                                                              //input 2
                                                                              var hiddenField = document.createElement("input");
                                                                              hiddenField.setAttribute("type", "hidden");
                                                                              hiddenField.setAttribute("name", "factorNumberHotel");
                                                                              hiddenField.setAttribute("value", factorNumber);
                                                                              form.appendChild(hiddenField);

                                                                              //input 3
                                                                              var hiddenField = document.createElement("input");
                                                                              hiddenField.setAttribute("type", "hidden");
                                                                              hiddenField.setAttribute("name", "temporary");
                                                                              hiddenField.setAttribute("value", temporary);
                                                                              form.appendChild(hiddenField);

                                                                              //input 4
                                                                              var hiddenField = document.createElement("input");
                                                                              hiddenField.setAttribute("type", "hidden");
                                                                              hiddenField.setAttribute("name", "type");
                                                                              hiddenField.setAttribute("value", 'package');
                                                                              form.appendChild(hiddenField);
                                                                              console.log(form);

                                                                              form.submit();
                                                                              document.body.removeChild(form);
                                                                          }
                                                                      }
                                                                  });
                                                              }
                                                          }
                                                      });
                                                  }else {
                                                      setTimeout(function () {
                                                          var error_message = '';
                                                          var error_code = '';
                                                          if (data.TwoWay.result_status == 'error') {

                                                              if (typeof data.TwoWay.result_message == 'object') {
                                                                  error_message = Object.values(data.TwoWay.result_message)
                                                              } else {
                                                                  error_message = data.TwoWay.result_message;

                                                              }

                                                              error_code = data.TwoWay.result_code;


                                                          }
                                                          $.alert({
                                                              title: useXmltag("Note"),
                                                              icon: 'fa fa-cart-plus',
                                                              content: error_message + '<br />' + useXmltag("RedSearchBtnReSearchPath"),
                                                              rtl: true,
                                                              type: 'red'
                                                          })
                                                      }, 1000);
                                                  }

                                              }
                                          });

                                      } else {
                                          if (typeof data.TwoWay !== 'undefined') {
                                              var message = data.TwoWay.result_message;
                                          }

                                          $.alert({
                                              title: useXmltag("BuyTicket"),
                                              icon: 'fa shopping-cart',
                                              content: message,
                                              rtl: true,
                                              type: 'red'
                                          });
                                          return false;
                                      }
                                  }
                              });
                          }, 100);
                      } else {
                          $('#loader_check').hide();
                          $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));
                          $.alert({
                              title: useXmltag("BuyTicket"),
                              icon: 'fa shopping-cart',
                              content: res[1],
                              rtl: true,
                              type: 'red'
                          });
                          return false;
                      }
                  });
           }, 500);
    } else {
        setTimeout(
           function () {
               $('#loader_check').hide();
               $('#send_data').removeAttr('disabled').css('opacity', '1').css('cursor', 'pointer').val(useXmltag("NextStepInvoice"));

           }, 2000);

    }
}

jQuery.fn.extend({
    masterRater: function (table_name, record_id) {
        var thiss = this;
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            data:
               {
                   flag: 'get_master_rate',
                   record_id: record_id,
                   table_name: table_name
               },
            success: function (data) {
                var obj = jQuery.parseJSON(data);


                var i;
                var btns = '';
                var className = 'btn-default';
                for (i = 1; i <= 5; i++) {
                    if (obj.average < i) {
                        className = ''
                    } else {
                        className = 'ratingActive'
                    }
                    btns = '<input class="btnrating" data-attr="' + i + '" type="radio" name="rating" id="rating-' + i + '">\n' +
                       '<label for="rating-' + i + '" class="' + className + '"></label>' + btns;

                }


                var html = '<div class="rating">\n' +
                   '<input type="hidden" id="selected_rating_' + table_name + '" name="selected_rating" value="' + obj.average + '" required="required">\n' +
                   btns +
                   '\n' +
                   '</div>\n' +
                   '<span class="d-block mt-2 text-center text-info raterDetail"></span>';
                thiss.html(html);
                $('.raterDetail').html(obj.average + '/' + '5')
                $(".btnrating").on('click', (function (e) {

                    var previous_value = $("#selected_rating").val();

                    var selected_value = $(this).attr("data-attr");

                    $(".btnrating").removeClass('ratingActive');
                    for (i = 1; i <= selected_value; ++i) {
                        $("#rating-star-" + i).addClass('ratingActive');
                        // $("#rating-star-"+i).toggleClass('btn-default');
                    }
                    $(".btnrating").prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: amadeusPath + 'user_ajax.php',
                        data:
                           {
                               flag: 'new_master_rate',
                               value: selected_value,
                               record_id: record_id,
                               table_name: table_name
                           },
                        success: function (data) {
                            var obj2 = jQuery.parseJSON(data);
                            $('.raterDetail').html(useXmltag('ThanksVote') + '</br>' +
                               obj2.average + '/' + '5')
                        }
                    });


                }));


            }
        });


    }
});

function searchPackage(){

    console.log(typeof ($('#isInternal').val()));
    console.log($('#isInternal').val());
    var typInternal = $('#isInternal').val() ;
    var departureCode = $('#departureSelected').val();
    var destinationCode = $('#arrivalSelected').val();
    var DepartureDate = $('#dept_date_local').val();
    var ArrivalDate = $('#dept_date_local_return').val();
    var countRoom = $('#countRoom').val();
    var isInternal = ((typInternal == 'false') ? '0' : '1');
    var i;
    var j;
    var searchRooms = '';
    for (i = 1; i <= countRoom; i++) {
        var adult = parseInt($('#adult' + i).val());
        var child = parseInt($('#child' + i).val());
        if (adult > 0) {
            searchRooms +=  adult;
            if (child > 0) {
                searchRooms += '-' + child;
                for (j = 1; j <= child; j++) {
                    var childAge = $('#childAge' + i + j).val();
                    if(childAge.length > 0)
                    {
                        console.log('i===>'+i+'j====>'+ j + 'childAge===>'+childAge);
                        if (j == 1 && (childAge != undefined)) {
                            searchRooms += '-' + childAge ;
                        } else if (childAge != undefined) {
                            searchRooms += ','+ childAge ;
                        }

                        if(j==child && i != countRoom){
                            searchRooms += '&';
                        }

                    }
                }
            } else {
                if(i >= countRoom)
                {
                    searchRooms +='-0-0';
                }else{
                    searchRooms +='-0-0&'
                }

            }
        }
    }

    if (departureCode == "" || destinationCode == "" || DepartureDate == "" || ArrivalDate=="" ) {

        $.alert({
            title: useXmltag('Reservationhotel'),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
    } else if (adult == 0) {
        $.alert({
            title: useXmltag('Reservationhotel'),
            icon: 'fa fa-cart-plus',
            content: useXmltag("LeastOneAdult"),
            rtl: true,
            type: 'red'
        });
    } else {
        var url = amadeusPathByLang + "searchPackage/1/" + departureCode +'-'+ destinationCode + "/" + DepartureDate +'&' + ArrivalDate + "/Y/" + searchRooms + "/" + isInternal ;
        window.location.href = url;
    }
}

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

function createMultiple(id) {

    $('#'+id).addClass('checked');
}

function removeMultiple(id) {

    $('#'+id).removeClass('checked');
}

function showTourB2BAccess(){

    console.log('showTourB2BAccess');
    validateShowListTour();
    // location.reload();
};

const removeAgencyAttachment = function(attachment_id,parent_selector = false){
    $.ajax({
        type: 'post',
        url: amadeusPath + "user_ajax.php",
        data: {
            attachment_id: attachment_id,
            flag: 'agencyRemoveAttachments'
        },
        success: function (data) {
            let response = JSON.parse(data);
            if (response.status == 'success') {
                if (parent_selector != false) {
                    console.log(parent_selector);
                    console.log(attachment_id);
                    console.log(parent_selector.find('.attachment-'+attachment_id));
                    parent_selector.find(`.attachment-${attachment_id}`).remove();
                    console.log('removed');
                }
            } else {
                $.toast({
                    heading: 'حذف فایل',
                    text: response.message,
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
};



$(document).ready(function(){
    $('body').on('click','.remove-attachment',function (e) {
        e.preventDefault();
        let attachment_id = $(this).data('id');
        let selector = $('.attachments');
        removeAgencyAttachment(attachment_id,selector);
    });
});

function checkFileType(thiss,showError=false) {
    const validExtensions = ["jpg", "pdf", "jpeg", "gif", "png"];
    const file = thiss.val().split('.').pop();
    if (validExtensions.indexOf(file) == -1) {
        if (showError) {

            $.alert({
                title: 'Format error',
                icon: 'fa fa-warning',
                content: "Only formats are allowed : " + validExtensions.join(', '),
                rtl: true,
                type: 'red'
            });
        }
        return false;
    }
    return true;
}


jalaliObject = {
    g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
    j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
};
jalaliObject.jalaliToGregorian = function(j_y, j_m, j_d) {
    j_y = parseInt(j_y);
    j_m = parseInt(j_m);
    j_d = parseInt(j_d);
    var jy = j_y - 979;
    var jm = j_m - 1;
    var jd = j_d - 1;

    var j_day_no = 365 * jy + parseInt(jy / 33) * 8 + parseInt((jy % 33 + 3) / 4);
    for (var i = 0; i < jm; ++i) j_day_no += jalaliObject.j_days_in_month[i];

    j_day_no += jd;

    var g_day_no = j_day_no + 79;

    var gy = 1600 + 400 * parseInt(g_day_no / 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
    g_day_no = g_day_no % 146097;

    var leap = true;
    if (g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
    {
        g_day_no--;
        gy += 100 * parseInt(g_day_no / 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
        g_day_no = g_day_no % 36524;

        if (g_day_no >= 365) g_day_no++;
        else leap = false;
    }

    gy += 4 * parseInt(g_day_no / 1461); /* 1461 = 365*4 + 4/4 */
    g_day_no %= 1461;

    if (g_day_no >= 366) {
        leap = false;

        g_day_no--;
        gy += parseInt(g_day_no / 365);
        g_day_no = g_day_no % 365;
    }

    for (var i = 0; g_day_no >= jalaliObject.g_days_in_month[i] + (i == 1 && leap); i++)
        g_day_no -= jalaliObject.g_days_in_month[i] + (i == 1 && leap);
    var gm = i + 1;
    var gd = g_day_no + 1;

    gm = gm < 10 ? "0" + gm : gm;
    gd = gd < 10 ? "0" + gd : gd;

    return [gy, gm, gd];
}
function jalaliToGreg(jDate,delimiter){
    if(typeof delimiter === 'undefided'){
        delimiter = '-';
    }
    dateSplitted = jDate.split(delimiter)
    gD = jalaliObject.jalaliToGregorian(dateSplitted[0], dateSplitted[1], dateSplitted[2]);
    gResult = gD[0] + "-" + gD[1] + "-" + gD[2];
    // console.log(gResult);
    return gResult;
}
function convertJalaliToGregorian(jDate,elem) {
    var date1 = elem;
    var date2 = jDate;
    // var jqXHR1 = date1
    // var jqXHR2 = date2
    // var res1 = jqXHR1.replaceAll("-", "/");
    // var res2 = jqXHR2.replaceAll("-", "/");
    // var startDate = new Date(res1);
    // var endDate = new Date(res2);
    var res1 = jalaliToGreg(date1,'-');
    var res2 = jalaliToGreg(date2,'-');
    var startDate = new Date(res1);
    var endDate = new Date(res2);

    var fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
    var fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

    var diffTime = Math.abs(endDate - startDate);
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    var result = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;

    return result;

}
////////////// reservation ticket ///////////////
function sendInfoReservationFlightForeign(flight_id) {

    $('#btnReservationFlight_' + flight_id).css('opacity', '0.5').text(useXmltag("Pending"));

    $.post(amadeusPath + 'user_ajax.php',
       {
           flag: "CheckLogged"
       },
       function (data) {
           if (data.indexOf('SuccessLogging') > -1) {

               setTimeout(function () {
                   SendInfoLoginToPrivate(flight_id);
               }, 1000);


           } else {
               $('#noLoginBuy').val(useXmltag("Purchasewithoutregistration"));
               setTimeout(function () {
                   var isShowLoginPopup = $('#isShowLoginPopup').val();
                   var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                   if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                       $('#flight_id_private').val(flight_id);
                       $("#login-popup").trigger("click");
                   } else {
                       SendInfoLoginToPrivate(flight_id);

                   }
                   $(this).removeAttr('disabled', true).css('opacity', '1').text(useXmltag("Selection"));
               }, 1000);
           }

       });

    $('#btnReservationFlight_' + flight_id).removeAttr('disabled', true).css('opacity', '1').text(useXmltag("Selection"));

}

function SendInfoLoginToPrivate(flight_id) {

    let detected_flight = $('#btnReservationFlight_'+flight_id);
    var id = flight_id;

    var CountAdult = detected_flight.siblings('.CountAdult').val();
    var CountChild =  detected_flight.siblings('.CountChild').val();
    var CountInfo =  detected_flight.siblings('.CountInfant').val();
    var typeApplication =  detected_flight.siblings('.typeApplication').val();
    var flight_id_return =  detected_flight.siblings('.flight_id_return').val();

    var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", amadeusPathByLang + "passengersDetailReservationTicket");
    form.setAttribute("target", "_self");

    var hiddenField1 = document.createElement("input");
    hiddenField1.setAttribute("name", "IdFlight");
    hiddenField1.setAttribute("value", id);
    var hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("name", "CountAdult");
    hiddenField2.setAttribute("value", CountAdult);
    var hiddenField3 = document.createElement("input");
    hiddenField3.setAttribute("name", "CountChild");
    hiddenField3.setAttribute("value", CountChild);
    var hiddenField4 = document.createElement("input");
    hiddenField4.setAttribute("name", "CountInfo");
    hiddenField4.setAttribute("value", CountInfo);
    var hiddenField5 = document.createElement("input");
    hiddenField5.setAttribute("name", "typeApplication");
    hiddenField5.setAttribute("value", typeApplication);
    if(flight_id_return.length > 0){
        var hiddenField6 = document.createElement("input");
        hiddenField6.setAttribute("name", "flight_id_return");
        hiddenField6.setAttribute("value", flight_id_return);
    }


    form.appendChild(hiddenField1);
    form.appendChild(hiddenField2);
    form.appendChild(hiddenField3);
    form.appendChild(hiddenField4);
    form.appendChild(hiddenField5);
    if(flight_id_return.length > 0) {
        form.appendChild(hiddenField6);
    }

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

}

////////////// reservation ticket ///////////////////

function showTicketInformation() {

    var CabinType = $('#CabinType').val();
    var AdtPrice = $('#AdtPrice').val();
    var PriceWithDiscount = $('#PriceWithDiscount').val();
    var ChdPrice = $('#ChdPrice').val();
    var ChdPriceWithDiscount = $('#ChdPriceWithDiscount').val();
    var InfPrice = $('#InfPrice').val();
    var InfPriceWithDiscount = $('#InfPriceWithDiscount').val();

    $.post(amadeusPath + 'hotel_ajax.php',
       {
           CabinType: CabinType,
           AdtPrice: AdtPrice,
           PriceWithDiscount: PriceWithDiscount,
           ChdPrice: ChdPrice,
           ChdPriceWithDiscount: ChdPriceWithDiscount,
           InfPrice: InfPrice,
           InfPriceWithDiscount: InfPriceWithDiscount,
           flag: 'showTicketInformation'
       },
       function (data) {

           setTimeout(function () {
               $(".LoadLightbox").hide();
               $(".price-Box").addClass("displayBlock");
               $("#lightboxContainer").addClass("displayBlock");
               $('#ShowInfoFlightCabinType').html(data);
           }, 1000);

       });

}


function checkTicketReservation(currentDate, numAdult, numChild, numInfant) {

    var error1 = 0;
    var error2 = 0;
    var error3 = 0;
    var error4 = 0;
    var error5 = 0;

    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);

    if (numAdult > 0) {
        var adt = Adult_members(currentDate, numAdult);
        if (adt == 'true') {
            error1 = 0;
        } else {
            error1 = 1
        }
    }

    if (numChild > 0) {
        var chd = Chd_memebrs(currentDate, numChild);
        if (chd == 'true') {
            error2 = 0;
        } else {
            error2 = 1
        }
    }

    if (numInfant > 0) {
        var inf = Inf_members(currentDate, numInfant);
        if (inf === 'true') {
            error3 = 0;
        } else {
            error3 = 1
        }
    }

    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#Mobile').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();
        var mm = members(mob, Email_Address);
        if (mm == 'true') {
            error4 = 0;
        } else {
            error4 = 1
        }
    }


    if (error1 == 0 && error2 == 0 && error3 == 0 && error4 == 0 && error5 == 0) {
// alert('ssss')
        $.post(amadeusPath + 'hotel_ajax.php',
           {
               mobile: mob,
               telephone: tel,
               Email: Email_Address,
               flag: "register_memeberHotel"
           },
           function (data) {

               if (data != "") {

                   $('#IdMember').val(data);

                   $('#loader_check').show();
                   $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));

                   setTimeout(
                      function () {
                          $('#loader_check').hide();
                          $('#formPassengerDetailTicketReservation').submit();
                      }, 3000);

               } else {
                   $.alert({
                       title: useXmltag("BuyTicket"),
                       icon: 'fa shopping-cart',
                       content: useXmltag('ErrorWhenReserve'),
                       rtl: true,
                       type: 'red'
                   });
                   return false;
               }
           });
    }

}


function reserveTicket(FactorNumber, IdMember) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("BuyTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress');

    $('#loader_check').css("display", "block");

    $.post(amadeusPath + 'user_ajax.php',
       {
           FactorNumber: FactorNumber,
           IdMember: IdMember,
           flag: "TicketReserve"
       },
       function (data) {

           if (data.indexOf('SuccessBookTicket') > -1) {

               setTimeout(function () {
                   $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));

                   $('.main-pay-content').show();
                   $('.s-u-passenger-wrapper-change').show();
                   $('#loader_check').css("display", "none");
                   $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
               }, 2000);

           } else {

               setTimeout(function () {
                   $('#final_ok_and_insert_passenger').css('background-color', 'red').text(useXmltag("Errorconfirmation"));
                   // $('#messageBook').html(data);
                   $.alert({
                       title: useXmltag("BuyTicket"),
                       icon: 'fa fa-cart-plus',
                       content: data,
                       rtl: true,
                       type: 'red'
                   })
               }, 1000);
           }


       });


}


function modalListForReservationTicket(requestNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreatorForReservationTicket.php',
       {
           Controller: 'user',
           Method: 'ModalShow',
           Param: requestNumber
       },
       function (data) {
           $('#ModalPublicContent').html(data);

       });
}


function modalCancelReservationTicket(requestNumber) {
    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 1500);

    $.post(libraryPath + 'ModalCreatorForReservationTicket.php',
       {
           Controller: 'user',
           Method: 'setCancelReservationTicket',
           Param: requestNumber
       },
       function (data) {

           $('#ModalPublicContent').html(data);

       });
}

function requestCancelReservationTicket(requestNumber, percentCancel) {


    let national = $('.SelectUser:checked').map(function () {
        return $(this).val();
    });
    let nationalCodes = national.get();
    let reasons = $('#ReasonUser').val();
    let accountOwner = $('#AccountOwner').val();
    let cardNumber = $('#CardNumber').val();
    let nameBank = $('#NameBank').val();
    if ($('#PercentNoMatter').is(':checked')) {
        let percentNoMatter = 'Yes';
    } else {
        let percentNoMatter = 'No';
    }
    if ($('#Ruls').is(':checked')) {
        if (nationalCodes != "" && reasons != "") {

            $.post(amadeusPath + 'hotel_ajax.php',
               {
                   nationalCodes: nationalCodes,
                   requestNumber: requestNumber,
                   percentCancel: percentCancel,
                   percentNoMatter: percentNoMatter,
                   accountOwner: accountOwner,
                   cardNumber: cardNumber,
                   nameBank: nameBank,
                   reasons: reasons,
                   flag: 'requestCancelReservationTicket'
               },
               function (data) {
                   let res = data.split(':');
                   if (data.indexOf('success') > -1) {

                       $.alert({
                           title: useXmltag("SendCancellationRequest"),
                           icon: 'fa fa-check',
                           content: res[1],
                           rtl: true,
                           type: 'green',
                       });
                       setTimeout(function () {
                           $('#cancelbyuser-' + requestNumber).removeClass('btn btn-danger fa fa-times').addClass('btn btn-warning fa fa-refresh').removeAttr('onclick').attr("title", useXmltag("InvestigatingRequest"));
                           $("#ModalPublic").fadeOut(700);
                       }, 1000);

                   } else {
                       $.alert({
                           title: useXmltag("SendCancellationRequest"),
                           icon: 'fa fa-times',
                           content: res[1],
                           rtl: true,
                           type: 'red',
                       });
                       $('#SendEmailForOther').attr("disabled", false);
                       $('#loaderTracking').fadeOut(500);
                   }

               });

        } else {
            $.alert({
                title: useXmltag("SendCancellationRequest"),
                icon: 'fa fa-times',
                content: useXmltag("PleasePersonOrCancellationReason"),
                rtl: true,
                type: 'red'
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

function fireToast(status,title,text,time=4000){
    if(status === true){
        status='success'
    }
    if(status === false){
        status='error'
    }
    Swal.fire({
        icon: status,
        title: title,
        text: text,
        position: 'bottom',
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        toast:true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
}
function goto(id) {
    const top =
       document.getElementById(id).offsetTop - 40
    window.scrollTo({
        top: top,
        left: 0,
        behavior: 'smooth',
    })
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


function flightGoToBankApp(inputs) {
    let get_params = ''


    console.log(inputs)


    let bankType = $('input[name=\'bank\']').is(':checked')

    console.log('bankType==>' + bankType)

    get_params += `type_service=${inputs.type_service}&`
    if (bankType) {
        let bank_type_value = $('input[name=\'bank\']').val()
        console.log('bankType==>' + bank_type_value)

        get_params += `bankType=${bank_type_value}`
    }

    if (inputs.RequestNumber.dept != undefined && inputs.RequestNumber.dept.length > 0) {
        get_params += `&request_number_dept=${inputs.RequestNumber.dept}`
    }

    if (inputs.RequestNumber.return != undefined && inputs.RequestNumber.return.length > 0) {
        get_params += `&request_number_dept=${inputs.RequestNumber.return}`
    }

    if (inputs.RequestNumber.TwoWay != undefined && inputs.RequestNumber.TwoWay.length > 0) {
        get_params += `&request_number_two_way=${inputs.RequestNumber.TwoWay}`
    }

    if (inputs.serviceType.dept != undefined || inputs.serviceType.TwoWay != undefined || inputs.serviceType.return != undefined) {
        if (inputs.serviceType.dept != undefined && inputs.serviceType.dept.length > 0) {
            get_params += `&serviceType[0]=${inputs.serviceType.dept}`
        } else if (inputs.serviceType.TwoWay != undefined && inputs.serviceType.TwoWay.length > 0) {
            get_params += `&serviceType[0]=${inputs.serviceType.TwoWay}`
        }

        if (inputs.serviceType.return != undefined && inputs.serviceType.return.length > 0) {
            get_params += `&serviceType[1]=${inputs.serviceType.return}`
        }
    }

    if (inputs.discountCode != undefined && inputs.discountCode.length > 0) {
        get_params += `&discountCode=${inputs.discountCode}`
    }
    return get_params
}

function hotelGoToBankApp(inputs) {
    let get_params = ''

    let bankType = $('input[name=\'bank\']').is(':checked')
    get_params += `type_service=${inputs.type_service}&`
    if (bankType) {
        let bank_type_value = $('input[name=\'bank\']').val()
        console.log('bankType==>' + bank_type_value)

        get_params += `bankType=${bank_type_value}`
    }

    if (inputs.factorNumber != undefined && inputs.factorNumber.length > 0) {
        get_params += `&factorNumber=${inputs.factorNumber}`
    }

    if (inputs.paymentPrice != undefined && inputs.paymentPrice.toString().length > 0) {
        get_params += `&paymentPrice=${inputs.paymentPrice}`
    }





    return get_params
}

function busGoToBankApp(inputs) {
    let get_params = ''

    let bankType = $('input[name=\'bank\']').is(':checked')

    get_params += `type_service=${inputs.type_service}&`
    if (bankType) {
        let bank_type_value = $('input[name=\'bank\']').val()
        console.log('bankType==>' + bank_type_value)

        get_params += `bankType=${bank_type_value}`
    }

    if (inputs.factorNumber != undefined && inputs.factorNumber.length > 0) {
        get_params += `&factorNumber=${inputs.factorNumber}`
    }


    return get_params
}

function tourGoToBankApp(inputs) {
    let get_params = ''

    let bankType = $('input[name=\'bank\']').is(':checked')
    get_params += `type_service=${inputs.type_service}&`
    if (bankType) {
        let bank_type_value = $('input[name=\'bank\']').val()
        console.log('bankType==>' + bank_type_value)

        get_params += `bankType=${bank_type_value}`
    }
    if (inputs.factorNumber != undefined && inputs.factorNumber.length > 0) {
        get_params += `&factorNumber=${inputs.factorNumber}`
    }

    if (inputs.paymentPrice != undefined && inputs.paymentPrice.length > 0) {
        get_params += `&factorNumber=${inputs.paymentPrice}`
    }

    return get_params
}

function trainGoToBankApp(inputs) {
    let get_params = ''

    let bankType = $('input[name=\'bank\']').is(':checked')
    get_params += `type_service=${inputs.type_service}&`
    if (bankType) {
        let bank_type_value = $('input[name=\'bank\']').val()
        console.log('bankType==>' + bank_type_value)

        get_params += `bankType=${bank_type_value}`
    }

    if (inputs.factorNumber != undefined && inputs.factorNumber.length > 0) {
        get_params += `&factorNumber=${inputs.factorNumber}`
    }

    if (inputs.paymentPrice != undefined && inputs.paymentPrice.toString().length > 0) {
        get_params += `&factorNumber=${inputs.paymentPrice}`
    }

    return get_params
}

function insuranceGoToBankApp(inputs) {
    let get_params = ''

    let bankType = $('input[name=\'bank\']').is(':checked')
    get_params += `type_service=${inputs.type_service}&`
    if (bankType) {
        let bank_type_value = $('input[name=\'bank\']').val()
        console.log('bankType==>' + bank_type_value)

        get_params += `bankType=${bank_type_value}`
    }
    if (inputs.factorNumber != undefined && inputs.factorNumber.length > 0) {
        get_params += `&factorNumber=${inputs.factorNumber}`
    }

    if (inputs.paymentPrice != undefined && inputs.paymentPrice.toString().length > 0) {
        get_params += `&factorNumber=${inputs.paymentPrice}`
    }






    return get_params
}
function goToBankApp() {


    $('.cashPaymentLoader').addClass("skeleton").attr("disabled", "disabled").css('cursor', 'default').removeAttr('onclick',true);
    var credit_status = '';
    var price_to_pay = '';
    if ($(".price-after-discount-code").length > 0) {
        price_to_pay = parseInt($(".price-after-discount-code").html().replace(/,/g, ''));
    }
    let inputs = JSON.parse($('#go_bank_app').val());
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'JSON',
        data:
           {
               flag: 'checkMemberCredit',
               priceToPay: price_to_pay,
               creditUse: $("input[name='chkCreditUse']:checked").val()
           },
        success: function (data) {

            credit_status = data.result_status;

            if ($("input[name='bank']").is(':checked') || credit_status == 'full_credit') {

                var discountCode = '';
                if ($('#discount-code').length > 0) {
                    discountCode = $('#discount-code').val();
                }
                inputs['discountCode'] = discountCode;

                if ($("input[name='chkCreditUse']").length > 0 && $("input[name='chkCreditUse']:checked").val() == 'member_credit') {
                    inputs['memberCreditUse'] = true;
                }
                if ($("input[name='bank']").length > 0 && $("input[name='bank']:checked").val() == 'privateGetWayCharter724') {
                    inputs['privateGetWayCharter724'] = true;
                    link = amadeusPath + 'goToBankCharter724Private';
                }
                if ($("input[name='bank']").length > 0 && $("input[name='bank']:checked").val() == 'PaymentSamanInsurance') {
                    inputs['PaymentSamanInsurance'] = true;
                    inputs['redirectUrl'] = $('#redirectUrl').val();
                    link = amadeusPath + 'goToBankSamanInsurance';

                }

                $.ajax({
                    type: 'POST',
                    url: amadeusPath + 'user_ajax.php',
                    data: inputs,
                    success: function (data) {
                        if (data.indexOf('TRUE') > -1) {
                            let get_params ='';


                            get_params = window[inputs.type_service + 'GoToBankApp'](inputs)

                            window.location.href = `${amadeusPathByLang}ChooseBank?${get_params}` ;
                        } else {
                            if(data.indexOf('FalseGetWay') > -1)
                            {
                                $(Obj).removeAttr('onclick').attr("disabled", "disabled").css("opacity", "0.5");
                                $(Obj).parent('div').append('<span id="onlinemessages" style="color:#FF0000;">' + useXmltag("PreventPayForNoCredit") + '</span>');

                            }else {
                                $(Obj).removeAttr('onclick').attr("disabled", "disabled").css("opacity", "0.5");
                                $(Obj).parent('div').append('<span id="onlinemessages" style="color:#FF0000;">' + useXmltag("SystemUpdatedTryLater") + '</span>');

                            }
                        }
                    }
                });

            } else {
                $.alert({
                    title: useXmltag("SelectBankPort"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("PleaseSelectBank"),
                    rtl: true,
                    type: 'red'
                });
            }
        }
    });
}

function modalForReservationProof(requestNumber , type) {
    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'reservationProof',
           Method: 'ModalShowProof',
           Param: {
               requestNumber : requestNumber,
               type : type
           }
       },
       function (data) {

           $('#ModalPublicContent').html(data);


       });
//
//    $('.loaderPublic').fadeIn(700);
//
//    // Get the modal
//    $('#myModal-' + request_number).fadeIn(500);
}
function otpLogin(_this,entryInput){

    loadingToggle(_this,true)
    $.post(amadeusPath + 'captcha/securimage_check.php',
       {captchaAjax: $('#signin-captcha2').val()},
       function (data) {

           if (data == true) {
               reloadCaptcha();


               $.ajax({
                   type: 'POST',
                   url: amadeusPath + 'ajax',
                   dataType: 'json',
                   data: JSON.stringify({
                       method: 'callCreate',
                       className: 'verificationCode',
                       is_json: true,
                       entry: entryInput.val()
                   }),
                   success: function(response) {
                       loadingToggle(_this,false)
                       // console.log('response', response)
                       $.alert({
                           title: useXmltag("Login"),
                           icon: 'fa fa-sign-in',
                           content: useXmltag("optSent"),
                           rtl: true,
                           type: 'green'
                       });
                   },
                   error: function(error) {
                       loadingToggle(_this,false)
                       console.log('error', error)
                       $.alert({
                           title: useXmltag("Login"),
                           icon: 'fa fa-sign-in',
                           content: useXmltag("ErrorDetectingUser"),
                           rtl: true,
                           type: 'red'
                       });
                   },
               })

           } else {
               reloadCaptcha();
               loadingToggle(_this,false)
               $.alert({
                   title: useXmltag("Login"),
                   icon: 'fa fa-sign-in',
                   content: useXmltag("WrongSecurityCode"),
                   rtl: true,
                   type: 'red'
               });


               return false;
           }
       });



}
function shareBtn(title){
    if (navigator.share) {
        const currentUrl = window.location.href;
        navigator.share({
            title: title,
            url: currentUrl
        }).then(() => {
            console.log('Thanks for sharing!');
        })
           .catch(console.error);
    }
}


function goBankCreditAgency(link,inputs) {
    $('.cashPaymentLoader').addClass('skeleton').attr('disabled', 'disabled').css('cursor', 'default');

    let price_to_pay = parseInt($('#amount_to_pay').val().replace(/,/g, ''), 10);
    let bank_selected =$("input[name='bank_to_pay']:checked").val()
    let additionalData =  inputs.additionalData;
    let factor_number =  (Math.floor(Math.random() * 888888) + 100000).toString();
    if (price_to_pay === "" || bank_selected === false || bank_selected === undefined ) {
        $('.cashPaymentLoader').removeClass('skeleton').removeAttr('disabled').css('cursor', 'default')
        $.alert({
            title: useXmltag("ChargeAccount"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("MessageEmpty"),
            rtl: true,
            type: 'red'
        });
        return false;
    }
    if (price_to_pay > 2500000000 ) {
        $('.cashPaymentLoader').removeClass('skeleton').removeAttr('disabled').css('cursor', 'default')
        $.alert({
            title: useXmltag("ChargeAccount"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("upperThanTwoHundredAndFifty"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", link);

    $.each(inputs, function (i, item) {
        if (typeof item === 'object' && item !== null) {
            $.each(item, function (j, item2) {
                let hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", i + '[' + j + ']');
                hiddenField.setAttribute("value", item2);
                form.appendChild(hiddenField);

            });
        } else {
            let hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", i);
            hiddenField.setAttribute("value", item);
            form.appendChild(hiddenField);

        }
    });

    let bank = document.createElement("input");
    bank.setAttribute("type", "hidden");
    bank.setAttribute("name", "bankType");
    bank.setAttribute("value", bank_selected);
    form.appendChild(bank);

    let hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("type", "hidden");
    hiddenField2.setAttribute("name",'price');
    hiddenField2.setAttribute("value", price_to_pay);

    form.appendChild(hiddenField2);


    let hiddenField3 = document.createElement("input");
    hiddenField3.setAttribute("type", "hidden");
    hiddenField3.setAttribute("name",'factorNumber');
    hiddenField3.setAttribute("value", factor_number);
    form.appendChild(hiddenField3);

    let hiddenField4 = document.createElement("input");
    hiddenField4.setAttribute("type", "hidden");
    hiddenField4.setAttribute("name",'additionalData');
    hiddenField4.setAttribute("value", additionalData);
    form.appendChild(hiddenField4);



    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

}



function RequestServiceOffline() {
    $("input.button_SMSReservationRequest").show();
    $("input.button_SMSReservationRequest").css("filter","blur(2px)");
    $("input.button_SMSReservationRequest").attr('disabled', 'disabled');
    var infoRequestOffline = $('#infoRequestOffline').val();
    var fullName = $('#fullName').val();
    var mobile = $('#mobile').val();
    var description = $('#description').val();

    if (fullName == '' || mobile == '') {
        $("input.button_SMSReservationRequest").prop('disabled', false);
        $("input.button_SMSReservationRequest").show();
        $("input.button_SMSReservationRequest").css("filter","blur(0)");
        $.alert({
            title: useXmltag("RequestOfflineService"),
            icon: 'fa fa-refresh',
            content: useXmltag("PleaseEnterItems"),
            rtl: true,
            type: 'red',
        });
        return false;
    }else if(!validateMobile(mobile)){
        $("input.button_SMSReservationRequest").prop('disabled', false);
        $("input.button_SMSReservationRequest").show();
        $("input.button_SMSReservationRequest").css("filter","blur(0)");
        $.alert({
            title: useXmltag("RequestOfflineService"),
            icon: 'fa fa-refresh',
            content: useXmltag("PleaseEnterValidMobile"),
            rtl: true,
            type: 'red',
        });
        return false;
    } else {
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                method: 'create',
                className: 'requestOffline',
                infoRequestOffline: infoRequestOffline,
                fullName: fullName,
                mobile: mobile ,
                description: description ,
            }),
            success: function (data) {
                $("input.button_SMSReservationRequest").prop('disabled', false);
                $("input.button_SMSReservationRequest").show();
                $("input.button_SMSReservationRequest").css("filter","blur(0)");
                if (data.messageStatus == 'Success') {
                    $('#fullName').val("");
                    $('#mobile').val("");
                    $("#ModalPublic").modal('hide')
                    $.alert({
                        title: useXmltag("RequestOfflineService"),
                        icon: 'fa fa-refresh',
                        content: data.messageRequest,
                        rtl: true,
                        type: 'green',
                    });
                } else {
                    $.alert({
                        title: useXmltag("RequestOfflineService"),
                        icon: 'fa fa-refresh',
                        content: data.messageRequest,
                        rtl: true,
                        type: 'red',
                    });
                }
            }
        });
    }
}


function successAlert(title , message) {
    $.alert({
        title: title,
        icon: 'fa fa-refresh',
        content: message,
        rtl: true,
        type: 'green',
    });

}

function errorAlert(title , message) {
    $.alert({
        title: title,
        icon: 'fa fa-refresh',
        content: message,
        rtl: true,
        type: 'red',
    });
}

function ModalUserList(type, RequestNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 1500);

    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'user',
           Method: 'ModalUserList',
           Param: RequestNumber,
           ParamId: type
       },
       function (data) {
           $('#ModalPublicContent').html(data);
       });
}

document.addEventListener('DOMContentLoaded', () => {

    const labels = document.querySelectorAll('.label-tracking');

    labels.forEach(label => {
        label.addEventListener('click', () => {

            labels.forEach(lbl => lbl.classList.remove('active'));

            label.classList.add('active');
        });
    });
    if (labels.length > 0) {
        labels[0].classList.add('active');
    }
});
function addIconErrorMsg() {

    $('.alert_msg').each(function () {

        const $msg = $(this);

        if ($.trim($msg.text()) !== '' && $msg.find('.alert-icon').length === 0) {
            $msg.prepend('<i class="fa fa-exclamation-triangle alert-icon" style="margin-left:6px;"></i>');
        }

        if ($.trim($msg.text()) === '' && $msg.find('.alert-icon').length) {
            $msg.find('.alert-icon').remove();
        }

    });
}


