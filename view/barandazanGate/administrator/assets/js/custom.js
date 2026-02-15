/*jslint browser: true*/
/*global $, jQuery, alert*/

$(document).ready(function () {


    $(".popoverBox").popover({trigger: "hover"});
    "use strict";

    var body = $("body");

    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });

    /* ===== Theme Settings ===== */

    $(".open-close").on("click", function () {
        body.toggleClass("show-sidebar");
    });

    /* ===== Open-Close Right Sidebar ===== */

    $(".right-side-toggle").on("click", function () {
        $(".right-sidebar").slideDown(50).toggleClass("shw-rside");
        $(".fxhdr").on("click", function () {
            body.toggleClass("fix-header");
            /* Fix Header JS */
        });
        $(".fxsdr").on("click", function () {
            body.toggleClass("fix-sidebar");
            /* Fix Sidebar JS */
        });

        /* ===== Service Panel JS ===== */

        var fxhdr = $('.fxhdr');
        if (body.hasClass("fix-header")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
    });

    /* ===========================================================
        Loads the correct sidebar on window load.
        collapses the sidebar on window resize.
        Sets the min-height of #page-wrapper to window size.
    =========================================================== */

    $(function () {
        var set = function () {
                var topOffset = 60,
                    width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
                    height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                if (width < 768) {
                    $('div.navbar-collapse').addClass('collapse');
                    topOffset = 100;
                    /* 2-row-menu */
                } else {
                    $('div.navbar-collapse').removeClass('collapse');
                }

                /* ===== This is for resizing window ===== */

                if (width < 1170) {
                    body.addClass('content-wrapper');
                    $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                } else {
                    body.removeClass('content-wrapper');
                }

                height = height - topOffset;
                if (height < 1) {
                    height = 1;
                }
                if (height > topOffset) {
                    $("#page-wrapper").css("min-height", (height) + "px");
                }
            },
            url = window.location,
            element = $('ul.nav a').filter(function () {
                return this.href === url || url.href.indexOf(this.href) === 0;
            }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
        $(window).ready(set);
        $(window).on("resize", set);
    });

    /* ===== Collapsible Panels JS ===== */

    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]',
            panelRemover = '[data-perform="panel-dismiss"]';
        $(panelSelector).each(function () {
            var collapseOpts = {
                    toggle: false
                },
                parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper'),
                child = $(this).children('i');
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
                child.removeClass('ti-minus').addClass('ti-plus');
            }).on('show.bs.collapse', function () {
                child.removeClass('ti-plus').addClass('ti-minus');
            });
        });

        /* ===== Collapse Panels ===== */

        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        });

        /* ===== Remove Panels ===== */

        $(document).on('click', panelRemover, function (e) {
            e.preventDefault();
            var removeParent = $(this).closest('.panel');

            function removeElement() {
                var col = removeParent.parent();
                removeParent.remove();
                col.filter(function () {
                    return ($(this).is('[class*="col-"]') && $(this).children('*').length === 0);
                }).remove();
            }

            removeElement();
        });
    }(jQuery, window, document));

    /* ===== Tooltip Initialization ===== */

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /* ===== Popover Initialization ===== */

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    /* ===== Task Initialization ===== */

    $(".list-task li label").on("click", function () {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").on("click", function () {
        $("ul.theme_color").toggleClass("theme_block");
    });

    /* ===== Collepsible Toggle ===== */

    $(".collapseble").on("click", function () {
        $(".collapseblebox").fadeToggle(350);
    });

    /* ===== Sidebar ===== */

    $('.slimscrollright').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    $('.slimscrollsidebar').slimScroll({
        height: '100%',
        position: 'left',
        size: "6px",
        color: 'rgba(0,0,0,0.5)'
    });
    $('.chat-list').slimScroll({
        height: '100%',
        position: 'right',
        size: "0px",
        color: '#dcdcdc'
    });

    /* ===== Resize all elements ===== */

    body.trigger("resize");

    /* ===== Visited ul li ===== */

    $('.visited li a').on("click", function (e) {
        $('.visited li').removeClass('active');
        var $parent = $(this).parent();
        if (!$parent.hasClass('active')) {
            $parent.addClass('active');
        }
        e.preventDefault();
    });

    /* ===== Login and Recover Password ===== */

    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });

    /* =================================================================
        Update 1.5
        this is for close icon when navigation open in mobile view
    ================================================================= */

    $(".navbar-toggle").on("click", function () {
        $(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
    });

    $(document).on('click', '.admin_checked', function (e) {
        let _this,factorNumber;
        _this = $(this);
        factorNumber = _this.data('factor');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data: {
                factor_number: factorNumber,
                flag: 'admin_checked',
            },
            success: function (response) {
                $.alert({
                    title: 'تغییر وضعیت انجام شد',
                    icon: 'fa fa-cart-plus',
                    content: 'وضعیت این رزرو تغییر کرد',
                    rtl: true,
                    type: 'green'
                });
            },
            error: function (error) {
                $.alert({
                    title: 'خطا در بروزرسانی',
                    icon: 'fa fa-cart-plus',
                    content: 'یک خطا در هنگام بروزرسانی رخ داد.',
                    rtl: true,
                    type: 'red'
                });
            },
            complete: function () {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }

        });
    });

    $('body').on('click', '.remove-attachment', function (e) {
        e.preventDefault();
        let attachment_id = $(this).data('id');
        let selector = $('.attachments');
        removeAgencyAttachment(attachment_id, selector);
    });

    $('body').on('click', '.ajax-user-list', function (e) {
        e.preventDefault();


    });

    $(document).on('click','.btn-force-reserve',function(e){

        ForceHotelReserve($(this));
    });
    $(document).on('click','.btn-cancel-force-reserve',function(e){

        ForceCancelHotelReserve($(this));
    });
    $(document).on('click','.hotel-change-status',function(e){
        let factor_number = $(this).data('factor-number');
        $.confirm({
            theme: 'bootstrap',//'supervan' ,// 'material', 'bootstrap'
            title: 'تغییر وضعیت به پیش رزرو',
            icon: 'fa fa-trash',
            content: 'آیا مطمئن هستید که میخواهید این رزرو به وضعیت پیش رزرو تغییر کند؟ با این کار اعتبار کاربر(در صورت پرداخت اعتباری) و تراکنش آن حذف خواهد شد',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید',
                    btnClass: 'btn-green',
                    action : function(){
                        $.ajax({
                            type: "post",
                            url: `${amadeusPath}ajax`,
                            data : JSON.stringify({
                                className : 'BookingHotelNew',
                                method: 'updateStatusPreReserve',
                                factor_number : factor_number,
                                as_json : true
                            }),
                            success:  function(response){
                                $.toast({
                                    heading: 'تغییر به پیش رزرو با موفقیت انجام شد',
                                    text: response.message,
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 2500,
                                    textAlign: 'right',
                                    stack: 6
                                })
                            },
                            error : function(error){
                                console.log(error)
                                $.toast({
                                    heading: 'خطا در تغییر وضعیت',
                                    text: 'خطایی در تغییر وضعیت رخ داده است. لطفا console را چک کنید',
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'warning',
                                    hideAfter: 2500,
                                    textAlign: 'right',
                                    stack: 6
                                })
                            },
                            complete: function(){
                                ExecuteHistoryFilter('hotel')
                            }
                        })

                    },
                    cancel: {
                        text: 'انصراف',
                        btnClass: 'btn-orange',
                    }
                },
            },
        })
    });
/*
    $(document).on('click','.set-transaction',function(e){
        let factor_number = $(this).data('factor-number');
        let service = $(this).data('service');
        $.confirm({
            theme: 'bootstrap',//'supervan' ,// 'material', 'bootstrap'
            title: 'ثبت تراکنش خرید11111',
            icon: 'fa fa-trash',
            content: 'با این کار تراکنش این خرید ثبت میشود. درصورتی که قبلا برای این خرید تراکنش ثبت شده است دکمه انصراف را بزنید.',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید',
                    btnClass: 'btn-green',
                    action : function(){
                        $.ajax({
                            type: "post",
                            url: `${amadeusPath}ajax`,
                            data : JSON.stringify({
                                className : 'transaction',
                                method: 'setBookTransaction',
                                factor_number : factor_number,
                                service : service
                            }),
                            success:  function(response){

                                $.toast({
                                    heading: 'تراکنش با موفقیت ثبت شد',
                                    text: response.message,
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 2500,
                                    textAlign: 'right',
                                    stack: 6
                                })
                            },
                            error : function(error){
                                console.log(error)
                                $.toast({
                                    heading: 'خطا در تغییر وضعیت',
                                    text: 'خطایی در ثبت تراکنش رخ داده است. لطفا console را چک کنید',
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'warning',
                                    hideAfter: 2500,
                                    textAlign: 'right',
                                    stack: 6
                                })
                            },
                            complete: function(){
                               ExecuteHistoryFilter(service)
                            }
                        })

                    },
                    cancel: {
                        text: 'انصراف',
                        btnClass: 'btn-orange',
                    }
                },
            },
        })
    });
*/
/*    $(document).on('click','.set-transaction',function(e){
        let factor_number = $(this).data('factor-number');
        let service = $(this).data('service');

        // نمایش باکس
        $('#customPricingModal').modal('show');

        // رویداد کلیک روی دکمه تایید
        $('#confirmCustomPrice').on('click', function(e) {
            let customPrice = $('#customPrice').val();

            // اعتبارسنجی (مثال)
            if (isNaN(customPrice) || customPrice < 0) {
                alert('لطفاً یک عدد مثبت معتبر وارد کنید.');
                return;
            }

            // ارسال داده از طریق AJAX
            $.ajax({
                type: "post",
                url: `${amadeusPath}ajax`,
                data : JSON.stringify({
                    className : 'transaction',
                    method: 'setBookTransaction',
                    factor_number : factor_number,
                    service : service,
                    custom_pricing: customPrice
                }),
                success:  function(response){
                    // نمایش پیام موفقیت (مثال)
                    $.toast({
                        heading: 'تراکنش با موفقیت ثبت شد',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 2500,
                        textAlign: 'right',
                        stack: 6
                    });
                },
                error : function(error){
                    // نمایش پیام خطا (مثال)
                    console.log(error);
                    $.toast({
                        heading: 'خطا در تغییر وضعیت',
                        text: 'خطایی در ثبت تراکنش رخ داده است. لطفا console را چک کنید',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'warning',
                        hideAfter: 2500,
                        textAlign: 'right',
                        stack: 6
                    });
                },
                complete: function(){
                    ExecuteHistoryFilter(service)
                }
            });

            // پنهان کردن باکس
            $('#customPricingModal').modal('hide');
        });
    });*/

    $(document).on('click', '.set-transaction', function (e) {
        e.preventDefault();

        let $btn = $(this);
        let $tr = $btn.closest('tr');

        let factor_number = $btn.data('factor-number');
        let service = $btn.data('service');

        //براساس نوع سرچ می گیم(پرواز هتل بیمه اتوبوس) کدون ستون قیمت را چک کند
        let currentService = $('.tabs_ticket-history a.btn-success').data('target');
        let priceCols = priceColumnMap[currentService] || [];
        let hasPrice = false;
        priceCols.forEach(function (colIndex) {
            let val = getTdNumber($tr.find('td:eq(' + colIndex + ')'));
            if (val > 0) {
                hasPrice = true;
            }
        });
        // اگر هیچ‌کدوم قیمت نداشت → باکس قیمت نمایش داده شود
        let needPrice = !hasPrice;

        // کنترل نمایش باکس قیمت
        if (needPrice) {
            $('.price-box').show();
        } else {
            $('.price-box').hide();
            $('#customPrice').val(0);
        }

        // نمایش مودال (همیشه)
        $('#customPricingModal').modal('show');

        // تایید
        $('#confirmCustomPrice').off('click').on('click', function () {

            let customPrice = 0;

            if (needPrice) {
                customPrice = $('#customPrice').val();

                if (isNaN(customPrice) || customPrice < 0) {
                    alert('لطفاً یک عدد مثبت معتبر وارد کنید.');
                    return;
                }
            }

            sendTransactionBot(factor_number, service, customPrice);
            $('#customPricingModal').modal('hide');
        });
    });


});

const priceColumnMap = {
    flight:     [4, 5], // total + fare
    hotel:      [5],
    bus:        [6],
    insurance:  [4]
};
function sendTransactionBot(factor_number, service, customPrice) {

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'transaction',
            method: 'setBookTransaction',
            factor_number: factor_number,
            service: service,
            custom_pricing: customPrice
        }),
        success: function (response) {
            $.toast({
                heading: 'تراکنش با موفقیت ثبت شد',
                text: response.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 2500,
                textAlign: 'right',
                stack: 6
            });
        },
        error: function (error) {
            console.log(error);
            $.toast({
                heading: 'خطا',
                text: 'خطا در ثبت تراکنش',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'warning',
                hideAfter: 2500,
                textAlign: 'right',
                stack: 6
            });
        },
        complete: function () {
            ExecuteHistoryFilter(service);
        }
    });
}

function getTdNumber($td) {
    let txt = $td.clone()      // کپی
       .children()            // حذف تگ‌های داخلی
       .remove()
       .end()
       .text()
       .replace(/,/g, '')
       .trim();

    return parseInt(txt) || 0;
}

const ForceHotelReserve = function (element) {

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'تایید رزرو هتل خارجی',
        icon: 'fa fa-trash',
        content: 'آیا مطمئن هستید؟ باید قبل از هرچیز از داشتن اعتبار در پنل منبع اطمینان حاصل کنید.',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action : function(){
                    let params = {
                        method: "ForceReserve",
                        className: "detailHotel",
                        RequestNumber: $(element).data('request_number'),
                        ForceReserve: true
                    };

                    $.ajax({
                        url: amadeusPath + 'ajax',
                        data: JSON.stringify(params),
                        dataType: "json",
                        type: "POST",

                        success : function(response){
                            $.toast({
                                heading: 'تایید رزرو هتل خارجی',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon: 'success',
                                hideAfter: 2500,
                                textAlign: 'right',
                                stack: 6
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error : function(xHR, error){
                            console.log(error);
                            console.log(xHR);
                        }
                    })
                }
            },

            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });

};
const ForceCancelHotelReserve = function (element) {

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'کنسل رزرو هتل خارجی',
        icon: 'fa fa-trash',
        content: 'آیا مطمئن هستید؟ در صورت کنسل کردن این رزرو امکان بازگردانی رزرو وجود ندارد.',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action : function(){
                    let params = {
                        method: "ForceCancelReserve",
                        className: "detailHotel",
                        factorNumber: $(element).data('factor_number'),
                        ForceReserve: true
                    };

                    $.ajax({
                        url: amadeusPath + 'ajax',
                        data: JSON.stringify(params),
                        dataType: "json",
                        type: "POST",

                        success : function(response){
                            $.toast({
                                heading: 'کنسل رزرو هتل خارجی',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon: 'success',
                                hideAfter: 2500,
                                textAlign: 'right',
                                stack: 6
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error : function(xHR, error){
                            console.log(error);
                            console.log(xHR);
                        }
                    })
                }
            },

            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });

};

const logoute = function () {
    $.post(amadeusPath + 'user_ajax.php',
        {
            flag: 'logoute'
        },
        function (data) {
            window.location = 'login';
        });
};

const removeAgencyAttachment = function (attachment_id, parent_selector = false) {
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
                    console.log(parent_selector.find('.attachment-' + attachment_id));
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
function updateVisaCustomFileFields(file_input,factor_number,field,passenger) {

    var property = document.getElementById(file_input).files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();

    if(jQuery.inArray(image_extension,['gif','jpg','png','jpeg','pdf','']) == -1){
        alert("Invalid image file");
    }

    var form_data = new FormData();
    form_data.append("file",property);
    form_data.append('flag', 'update_custom_file_field');
    form_data.append('field', field);
    form_data.append('factor_number', factor_number);
    form_data.append('passenger', passenger);
    $.ajax({
        type: 'post',
        url: amadeusPath + "visa_ajax.php",
        data: form_data,
        contentType: false,
        processData: false,
        success: function (data) {

            if(data){
                ModalShowBookForVisa(factor_number)
            }else{
                console.log(data)
            }


           /* let response = JSON.parse(data);
            if (response.status == 'success') {
                if (parent_selector != false) {
                    console.log(parent_selector.find('.attachment-' + attachment_id));
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
            }*/
        }
    });

}
function updateVisaFiles(file_input,factor_number,passenger) {

    var property = document.getElementById(file_input).files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();

    if(jQuery.inArray(image_extension,['gif','jpg','png','jpeg','pdf','']) == -1){
        alert("Invalid image file");
    }

    var form_data = new FormData();
    form_data.append("file",property);
    form_data.append('flag', 'update_visa_files');
    form_data.append('factor_number', factor_number);
    form_data.append('passenger', passenger);
    $.ajax({
        type: 'post',
        url: amadeusPath + "visa_ajax.php",
        data: form_data,
        contentType: false,
        processData: false,
        success: function (data) {

            if(data){
                ModalShowBookForVisa(factor_number)
            }else{
                console.log(data)
            }


            /* let response = JSON.parse(data);
             if (response.status == 'success') {
                 if (parent_selector != false) {
                     console.log(parent_selector.find('.attachment-' + attachment_id));
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
             }*/
        }
    });

}

function toggleDiv(_this, is_show = true) {
   if (is_show) {
      _this.addClass("d-flex").removeClass("d-none")
   } else {
      _this.removeClass("d-flex").addClass("d-none")
   }
}

function toggleable(_this) {
   const name = _this.attr("name")
   const values = $('input[name="' + name + '"]')
   const value = $('input[name="' + name + '"]:checked').val()
  console.log('value',value)
   let names = []
   values.each(function () {
      names.push($(this).val())
   })
   names.forEach(item => {
      toggleDiv($("." + item + "-toggleable"), false)
   })
   toggleDiv($("." + value + "-toggleable"))
}
function dragOverHandler(ev) {


    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();
}
async function dropHandler(ev,selected=false ,  hasAlt = false) {

    let fileInput = document.getElementById('gallery_files');
    if( !$('#gallery_files_temporary').length){
        $('#gallery_files').after('<input type="file" class="d-none" id="gallery_files_temporary"/>')
    }

    let temporaryFileInput = document.getElementById('gallery_files_temporary');

    ev.preventDefault();
    var html_tags = '';

    if (ev.dataTransfer && ev.dataTransfer.items) {

        const dt = new DataTransfer();
        [...ev.dataTransfer.items].forEach(async (item, i) => {
            console.log('i ',i )

            if (item.kind === 'file') {
                const file = item.getAsFile();
                 if(file.size > 1000000){
                    $.alert({
                        title: 'غیر قابل آپلود',
                        icon: 'fa fa-cancle',
                        content: 'حجم عکس نباید بیشتر از 1 مگابایت باشد.',
                        rtl: true,
                        type: 'red'
                    });
                }else{


                dt.items.add(file)
                var reader = new FileReader();
                await reader.readAsDataURL(file);
                reader.onload = function() {

                    var re = /(?:\.([^.]+))?$/;
                    var ext = re.exec(file.name)[1];
                    if( ext == 'jpg' || ext == 'gif' || ext == 'png' || ext == 'tif' || ext == 'jpeg') {
                        var img_url = reader.result ;
                    }else {
                        var img_url = `${amadeusPath}/pic/ext-icons/${ext}.png` ;

                    }

                    var tags="<div class=\"align-items-center flex-wrap dropzone-parent-box  d-flex justify-content-between p-3 pip rounded-xl w-100 \" xmlns='http://www.w3.org/1999/html'>" +
                      "<img class=\"border d-flex imageThumb rounded-xl w-25\" src=\"" + img_url + "\" title=\"" + file.name + "\"/>" +
                      "<div class='dropzone-parent-trash-shakkhes'>" +
                      "<button type='button' class='dropzone-btn-trash' onclick='removeFromGallery($(this))' data-index='" + i + "' class=\"remove text-danger\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i> حذف</button>" +
                      "<div class='dropzone-radio-shakhes'>";




                    if(selected){
                        tags=tags+
                          "<label for='gallery_selected" + i + "'>" +
                          "تنظیم بعنوان شاخص" +
                          "</label>" +
                          "<input onchange='setAsSelectedGallery(\"" + reader.result + "\")' name='gallery_selected' id='gallery_selected" + i + "' value='" + i + "' type='radio'/>";
                    }

                    tags=tags+"</div>"+
                      "</div>";

                    if(hasAlt) {
                        tags=tags+
                          "<div class='d-flex w-100 flex-wrap mt-3'>" +
                          "<label for='gallery_file_alts[" + i + "]'>" +
                          "alt" +
                          "</label>" +
                          "<input placeholder='alt' name='gallery_file_alts[" + i + "]' value='" + file.name + "' class='pb-2 small text-center form-control text-muted w-100 rounded'/>";
                    }else{
                        tags=tags+
                          "<div class='d-flex w-100 flex-wrap mt-3'>" +
                          "<p>" + file.name + "</p>"
                    }
                    tags=tags+
                      "</div>" +
                      "</div>";

                    return $("#preview-gallery").append(tags);

                }
                }
            }
        });
        [...fileInput.files].forEach(item => {
            dt.items.add(item)
        })
        fileInput.files = dt.files;
        temporaryFileInput.files = dt.files;


    } else {
        let dt = new DataTransfer();
        let files=[...fileInput.files];


        if(files.length>0){
            [...temporaryFileInput.files].forEach(item => {
                dt.items.add(item)
            })
        }





        [...fileInput.files].forEach(async (file, i) => {
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(file.name)[1];
            // alert(file.name)
            // alert(ext)
            if( ext == 'sql' || ext == 'zip' || ext == 'xlsx' || ext == 'xls') {
                $.alert({
                    title: 'غیر قابل آپلود',
                    icon: 'fa fa-cancle',
                    content: 'پسوند فایل آپلود شده مجاز نمی باشد',
                    rtl: true,
                    type: 'red'
                });
            } else{
            if(file.size > 1000000){
                $.alert({
                    title: 'غیر قابل آپلود',
                    icon: 'fa fa-cancle',
                    content: 'حجم عکس نباید بیشتر از 1 مگابایت باشد.',
                    rtl: true,
                    type: 'red'
                });
            }else{
            dt.items.add(file)
            var reader = null;
            reader = new FileReader();
            await reader.readAsDataURL(file);
            reader.onload = function() {

                var re = /(?:\.([^.]+))?$/;
                var ext = re.exec(file.name)[1];
                if( ext == 'jpg' || ext == 'gif' || ext == 'png' || ext == 'tif' || ext == 'jpeg') {
                    var img_url = reader.result ;
                }else {
                    var img_url = `${amadeusPath}/pic/ext-icons/${ext}.png` ;

                }
                var tags="<div class=\"align-items-center flex-wrap dropzone-parent-box  d-flex justify-content-between p-3 pip rounded-xl w-100 \" xmlns='http://www.w3.org/1999/html'>" +
                  "<img class=\"border d-flex imageThumb rounded-xl w-25\" src=\"" + img_url + "\" title=\"" + file.name + "\"/>" +
                  "<div class='dropzone-parent-trash-shakkhes'>" +
                  "<button type='button' class='dropzone-btn-trash' onclick='removeFromGallery($(this))' data-index='" + i + "' class=\"remove text-danger\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i> حذف</button>" +
                  "<div class='dropzone-radio-shakhes'>";

                if(selected){
                    tags=tags+
                      "<label for='gallery_selected" + i + "'>" +
                      "تنظیم بعنوان شاخص" +
                      "</label>" +
                      "<input onchange='setAsSelectedGallery(\"" + reader.result + "\")' name='gallery_selected' id='gallery_selected" + i + "' value='" + i + "' type='radio'/>";
                }

                if(hasAlt) {
                    tags=tags+
                      "<div class='d-flex w-100 flex-wrap mt-3'>" +
                      "<label for='gallery_file_alts[" + i + "]'>" +
                      "alt" +
                      "</label>" +
                      "<input placeholder='alt' name='gallery_file_alts[" + i + "]' value='" + file.name + "' class='pb-2 small text-center form-control text-muted w-100 rounded'/>";
                }else{
                    tags=tags+
                      "<div class='d-flex w-100 flex-wrap mt-3'>" +
                      "<p>" + file.name + "</p>"
                }
                tags=tags+
                  "</div>" +
                  "</div>";
                return $("#preview-gallery").append(tags);

            }
            }
            }
        })
        fileInput.files = dt.files;
        temporaryFileInput.files = dt.files;

    }

}
function setAsSelectedGallery(src) {
$('.selected_image').find('.dropify-render img')
      .attr('src', src)
}
function setAsSelectedNewGallery(src, id) {
    if(src && src.trim() !== '') {
        $('.selected_image').find('.dropify-render img').attr('src', src);
        $('#gallery_selected').val(id); // ID شاخص هم ذخیره می شود
    }
}


async function removeFromGallery(_this) {
    _this.parent().parent(".pip").remove();
    const index_image=_this.data('index')
    let fileInput = document.getElementById('gallery_files');
    let temporaryFileInput = document.getElementById('gallery_files_temporary');

    let html_tags = []
    const dt = new DataTransfer();
    [...fileInput.files].forEach( async (file,i)=>{
        console.log('index_image',index_image)
        console.log('i',i)
        if (index_image !== i) {

        console.log('file',file)

            var reader = new FileReader();
              await reader.readAsDataURL(file);
            // $('#preview-gallery').html('');
            reader.onload = function(){


                const elements = document.querySelectorAll('#preview-gallery .pip');

                let counter=0;
                var testimonials = document.querySelectorAll("div.pip")
                Array.prototype.forEach.call(testimonials, function (element, index) {
                    var div1 = element.querySelectorAll("div")
                    Array.prototype.forEach.call(div1, function (element1, index) {
                        var div2 = element1.querySelectorAll("button")
                        if (div2.length) {
                            div2[0].setAttribute("data-index", counter)
                        }
                    })
                    counter=counter+1;
                })

                dt.items.add(file)
            }

        }
    })


    fileInput.files = dt.files;
    temporaryFileInput.files = dt.files;

}