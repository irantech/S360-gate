$(document).ready(function () {

    // $('.js-switch').each(function () {
    //     new Switchery($(this)[0], $(this).data());
    // });

});

function EditInPlaceTour(Code, Priority)
{
    $('#'+Code + Priority).html('');
    $('#'+Code + Priority).append('<input class="form-control" name="priority'+Code + Priority+'" value="'+ Priority +'" id="priority' + Code + Priority +'" onchange="SendPriorityTour('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')" onblur="hideInputTour('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')">');
    $('#'+Code + Priority).attr('onclick','return false');

}

function SendPriorityTour(Priority,Code) {

    var PriorityNew = $('#priority' + Code + Priority ).val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            PriorityOld: Priority,
            PriorityNew: PriorityNew,
            CodeDeparture: Code,
            flag: 'ChangePriorityTour'
        },
        function (data) {
            var res = data.split(':');
            if (data.indexOf('SuccessChangePriority') > -1)
            {

                $.toast({
                    heading: 'تغییر الویت',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                $('#'+Code + Priority).html(PriorityNew);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else
            {
                $.toast({
                    heading: 'تغییر الویت',
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

function showDiv(id) {
    $('#' + id).removeClass('displayN');
    $('html, body').animate({scrollTop: $('#' + id).offset().top}, 'slow');
}

function showOnSite(idTour, isShow) {
    if (isShow == 'yes') {
        var detail = $('#price').val();
    } else {
        var detail = $('#comment').val();
    }

    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تائید نمایش تور',
        icon: 'fa fa-trash',
        content: 'آیا از تائید نمایش تور اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                        {
                            idTour: idTour,
                            isShow: isShow,
                            detail: detail,
                            flag: 'isShowTour'
                        },
                        function (response) {

                            var res = response.split(':');
                            if (response.indexOf('success') > -1) {

                                $.toast({
                                    heading: 'نمایش تور',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);


                            } else {

                                $.toast({
                                    heading: 'نمایش تور',
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
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}


function showUserCommentsOnSite(id, isShow) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تائید نمایش تور',
        icon: 'fa fa-trash',
        content: 'آیا از تائید نمایش تور اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                        {
                            id: id,
                            isShow: isShow,
                            flag: 'isShowUserComments'
                        },
                        function (response) {

                            var res = response.split(':');
                            if (response.indexOf('success') > -1) {

                                $.toast({
                                    heading: 'نمایش نظر',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);


                            } else {

                                $.toast({
                                    heading: 'نمایش نظر',
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
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}


function isEditorActive(id) {

    $.post(amadeusPath + 'tour_ajax.php',
        {
            id: id,
            flag: 'isEditorActive'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'ویرایشگر',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                $.toast({
                    heading: 'ویرایشگر',
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


function isSpecialTour(idSame) {

    $.post(amadeusPath + 'tour_ajax.php',
        {
            idSame: idSame,
            flag: 'isSpecialTour'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'تور ویژه',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                $.toast({
                    heading: 'تور ویژه',
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

function changeSuggestedStatus(idSame) {

    $.post(amadeusPath + 'tour_ajax.php',
        {
            idSame: idSame,
            flag: 'changeSuggestedStatus'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'تور پیشنهادی',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                $.toast({
                    heading: 'تور پیشنهادی',
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

function isFirstTour(idSame) {

    $.post(amadeusPath + 'tour_ajax.php',
        {
            idSame: idSame,
            flag: 'isFirstTour'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'انتخاب تور زماندار',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                $.toast({
                    heading: 'انتخاب تور زماندار',
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

function setStartTimeLastMinuteTour(idSame) {

    var startTimeLastMinuteTour = $('#startTimeLastMinuteTour-' + idSame).val();

    $.post(amadeusPath + 'tour_ajax.php',
        {
            idSame: idSame,
            startTimeLastMinuteTour: startTimeLastMinuteTour,
            flag: 'setStartTimeLastMinuteTour'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'تور لحظه آخری',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else {
                $.toast({
                    heading: 'تور لحظه آخری',
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
function ModalShowInfoComment(CommentId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'comments',
            Method: 'ModalShowInfoComment',
            Param: CommentId
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function showCommentsOnSite(id, validate) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تغییر وضعیت نظر',
        icon: 'fa fa-trash',
        content: 'آیا از تغییر وضعیت نمایش نظر در سایت اطمینان دارید',
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
                            id: id,
                            validate: validate,
                            flag: 'EditCommentValidate'
                        },
                        function (response) {

                            var res = response.split(':');
                            if (response.indexOf('success') > -1) {

                                $.toast({
                                    heading: 'تغییر وضعیت نظر',
                                    text: 'انجام شد',
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                if(validate==1){
                                    $('.btnCommentStatus_'+id).removeClass().addClass('btnCommentStatus_'+id+' btn btn-success cursor-default').html('نمایش در سایت')
                                }
                                if(validate==2){
                                    $('.btnCommentStatus_'+id).removeClass().addClass('btnCommentStatus_'+id+' btn btn-danger cursor-default').html('عدم نمایش در سایت')
                                }


                            } else {

                                $.toast({
                                    heading: 'تغییر وضعیت نظر',
                                    text: 'مشکلی رخ داده است',
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                $('.btnCommentStatus').removeClass().addClass('btnCommentStatus btn btn-danger cursor-default').html('عدم نمایش در سایت')

                            }

                        });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}

function orderTourActive(id)
{

    $.post(amadeusPath + 'tour_ajax.php',
        {
            id: id,
            flag: 'orderTourActive'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'ترتیب نمایش هتل',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else
            {
                $.toast({
                    heading: 'ترتیب نمایش هتل',
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
function ModalShowSlugs(slug_id,self) {


    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: '',
          Method: 'ModalShowSlugs',
          Param: {
              slug_id:slug_id,
              self:self,
          }
      },
      function (data) {

          $('#ModalPublic').html(data);

      });
}
function updateSlug(_this){
    const lang=_this.data('lang')
    const self=_this.data('self')
    const new_slug=_this.val()
    const id=_this.data('id')
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
            method: 'callUpdate',
            className: 'tourSlugController',
            id: id,
            self: self,
            lang: lang,
            new_slug: new_slug,
        }),
        success: function (response) {
            $.toast({
                heading: 'ویرایش یافت',
                text: response.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            _this.attr('disabled','disabled')
            location.reload();
        },
        error : function (error) {
            $.toast({
                heading: 'عملیات ناموفق',
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
function modalListForReserveTour(tour_code) {
    setTimeout(function () {
        $('.loaderPublicForHotel').fadeOut(500);
        $("#ModalPublic").fadeIn(700);
    }, 1000);
    $.post(libraryPath + 'ModalCreatorForTour.php',
       {
           Controller: 'manifestTourController',
           Method: 'ModalShowForReserveTour',
           factorNumber: tour_code
       },
       function (data) {
           $('#ModalPublicShowReserveList').html(data);
       });
}