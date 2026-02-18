$(document).ready(function() {




    let imageIndexCounter = 0;


    function addCheckboxes() {
        $('.dropzone-parent-trash-shakkhes').each(function () {
            // اگر قبلاً هر نوع checkbox اضافه شده، رد شو
            if ($(this).find('.prize-checkbox-wrapper').length) return;
            // گرفتن index منحصر به فرد
            const uniqueIndex = imageIndexCounter++;

            // ساخت checkbox با hidden input
            const checkboxWrapper = $(`
            <div class="prize-checkbox-wrapper">
                <span>جایزه</span>
                <input type="checkbox" class="initial-checkbox" data-image-index="${uniqueIndex}" style="margin-top:10px;">
                <input type="hidden" class="prize-value" name="is_prize[]" value="0">
            </div>
        `);

            $(this).append(checkboxWrapper);

            const checkbox = checkboxWrapper.find('.initial-checkbox');
            const hiddenInput = checkboxWrapper.find('.prize-value');

            checkbox.on('change', function() {
                hiddenInput.val($(this).is(':checked') ? '1' : '0');
            });
        });
    }
    setInterval(addCheckboxes, 50);

    // برای صفحه edit: مدیریت checkbox های تصاویر موجود
    function initExistingCheckboxes() {
        $('.existing-checkbox').each(function() {
            const checkbox = $(this);
            const hiddenInput = checkbox.siblings('.existing-prize-value');

            // وقتی checkbox تغییر کرد
            checkbox.on('change', function() {
                const newValue = $(this).is(':checked') ? '1' : '0';
                hiddenInput.val(newValue);
                console.log('Existing checkbox changed:', checkbox.data('gallery-id'), 'New value:', newValue);
            });
        });
    }

    // اجرای تابع برای تصاویر موجود
    initExistingCheckboxes();



    setTimeout(async function() {
        await rebuildPositionsIndex()
        await  initializeSelect2Search()

    }, 1000);
    $('#addFaq').validate({
        rules: {
            language: 'required',
            title: 'required',
            content: 'required',
        },
        messages: {},
        errorElement: 'em',
        errorPlacement: function(error, element) {
            // Add the `help-block` class to the error element
            error.addClass('help-block')

            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'))
            } else {
                error.insertAfter(element)
            }
        },
        submitHandler: function(form) {
            //tinyMCE.triggerSave();
            CKEDITOR.instances.content.updateElement()
            if($('#content').val() === '') {
                $.toast({
                    heading: 'خطا',
                    text: 'اضافه کردن پاسخ الزامی است',
                    position: 'top-right',
                    icon:  'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }else{
                $(form).ajaxSubmit({
                    url: amadeusPath + 'ajax',
                    type: 'POST',
                    // mimeType: "multipart/form-data",
                    // contentType: false,
                    // processData: false,
                    success: function(response) {
                        // console.log(response);
                        let displayIcon
                        if (response.success === true) {
                            displayIcon = 'success'
                        } else {
                            displayIcon = 'error'
                        }

                        $.toast({
                            heading: 'مطالب',
                            text: response.message,
                            position: 'top-right',
                            icon: displayIcon,
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6,
                        })

                        if (response.success === true) {
                            setTimeout(function() {
                                location.reload()
                                // window.location = `${amadeusPath}itadmin/articles/list`;
                            }, 1000)
                        }
                    },
                })
            }

        },
        highlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-error')
               .removeClass('has-success')
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-success')
               .removeClass('has-error')
        },
    })
    $('#editFaq').validate({
        rules: {
            language: 'required',
            title: 'required',
            content: 'required',
        },
        messages: {},
        errorElement: 'em',
        errorPlacement: function(error, element) {
            // Add the `help-block` class to the error element
            error.addClass('help-block')

            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'))
            } else {
                error.insertAfter(element)
            }
        },
        submitHandler: function(form) {
            //tinyMCE.triggerSave();
            CKEDITOR.instances.content.updateElement()
            if($('#content').val() === '') {
                $.toast({
                    heading: 'خطا',
                    text: 'اضافه کردن پاسخ الزامی است',
                    position: 'top-right',
                    icon:  'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }else{
                $(form).ajaxSubmit({
                    url: amadeusPath + 'ajax',
                    type: 'POST',
                    // mimeType: "multipart/form-data",
                    // contentType: false,
                    // processData: false,
                    success: function(response) {
                        // console.log(response);
                        let displayIcon
                        if (response.success === true) {
                            displayIcon = 'success'
                        } else {
                            displayIcon = 'error'
                        }

                        $.toast({
                            heading: 'مطالب',
                            text: response.message,
                            position: 'top-right',
                            icon: displayIcon,
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6,
                        })

                        if (response.success === true) {
                            setTimeout(function() {
                                location.reload()
                                // window.location = `${amadeusPath}itadmin/articles/list`;
                            }, 1000)
                        }
                    },
                })
            }

        },
        highlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-error')
               .removeClass('has-success')
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-success')
               .removeClass('has-error')
        },
    })
    $('#update_category').validate({
        rules: {
            title: 'required',
        },
        messages: {},
        errorElement: 'em',
        errorPlacement: function(error, element) {
            // Add the `help-block` class to the error element
            error.addClass('help-block')

            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'))
            } else {
                error.insertAfter(element)
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'ajax',
                type: 'post',
                success: function(response) {
                    // console.log(response);
                    let displayIcon
                    let displayTitle
                    if (response.success === true) {
                        displayIcon = 'success'
                        displayTitle = 'انجام شد'
                    } else {
                        displayIcon = 'error'
                        displayTitle = 'عملیات با خطا مواجه شد'
                    }

                    $.toast({
                        heading: displayTitle,
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                    if (response.success === true) {
                        setTimeout(function() {
                            location.reload()
                            // window.location = `${amadeusPath}itadmin/articles/list`;
                        }, 1000)
                    }
                },
            })
        },
        highlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-error')
               .removeClass('has-success')
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-success')
               .removeClass('has-error')
        },
    })
    $('#storeCategory').validate({
        rules: {
            title: 'required',
        },
        messages: {},
        errorElement: 'em',
        errorPlacement: function(error, element) {
            // Add the `help-block` class to the error element
            error.addClass('help-block')

            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'))
            } else {
                error.insertAfter(element)
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'ajax',
                type: 'post',
                success: function(response) {
                    // console.log(response);
                    let displayIcon
                    let displayTitle
                    if (response.success === true) {
                        displayIcon = 'success'
                        displayTitle = 'انجام شد'
                    } else {
                        displayIcon = 'error'
                        displayTitle = 'عملیات با خطا مواجه شد'
                    }

                    $.toast({
                        heading: displayTitle,
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                    if (response.success === true) {
                        setTimeout(function() {
                            location.reload()
                            // window.location = `${amadeusPath}itadmin/articles/list`;
                        }, 1000)
                    }
                },
            })
        },
        highlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-error')
               .removeClass('has-success')
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-success')
               .removeClass('has-error')
        },
    })

    $('.dropify').dropify()

    if ($('#description').length) {
        var config = {}
        config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;24/24px;48/48px;'
        CKEDITOR.replace('description', config)
    }

    $('#insertNewArticle').validate({
        rules: {
            title: 'required',
            description: 'required',

        },
        messages: {},
        errorElement: 'em',
        errorPlacement: function(error, element) {
            // Add the `help-block` class to the error element
            error.addClass('help-block')

            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'))
            } else {
                error.insertAfter(element)
            }
        },
        submitHandler: function(form) {
            //tinyMCE.triggerSave();
            CKEDITOR.instances.description.updateElement()

            // غیرفعال کردن دکمه قبل از ارسال
            var submitBtn = $('.insert-btn');
            submitBtn.prop('disabled', true);
            submitBtn.addClass('disabled');
            var originalText = submitBtn.text();
            submitBtn.text('در حال ارسال...');

            $(form).ajaxSubmit({
                url: amadeusPath + 'ajax',
                type: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    // console.log(response);
                    // console.log(response.success);
                    let displayIcon
                    if (response.success === true) {
                        displayIcon = 'success'
                    } else {
                        displayIcon = 'error'
                        // در صورت خطا، دکمه را دوباره فعال کن
                        submitBtn.prop('disabled', false);
                        submitBtn.removeClass('disabled');
                        submitBtn.text(originalText);
                    }

                    $.toast({
                        heading: 'مطالب',
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                    if (response.success === true) {
                        submitBtn.text('ثبت شد - در حال انتقال...');
                        setTimeout(function() {
                            window.location = `${amadeusPath}itadmin/lottery/list?section=lottery`;

                            // console.log(`${amadeusPath}itadmin/lottery/list`);
                        }, 1000)
                    }
                },
                error: function(xhr, status, error) {
                    // در صورت خطای AJAX، دکمه را دوباره فعال کن
                    submitBtn.prop('disabled', false);
                    submitBtn.removeClass('disabled');
                    submitBtn.text(originalText);

                    $.toast({
                        heading: 'خطا',
                        text: 'خطا در ارسال اطلاعات',
                        position: 'top-right',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                }

            })
        },
        highlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-error')
               .removeClass('has-success')
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-success')
               .removeClass('has-error')
        },
    })

    $('#editLottery').validate({
        rules: {
            lottery_id: 'required',
            title: 'required',
            description: 'required',
        },
        messages: {},
        errorElement: 'em',
        errorPlacement: function(error, element) {
            // Add the `help-block` class to the error element
            error.addClass('help-block')

            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'))
            } else {
                error.insertAfter(element)
            }
        },
        submitHandler: function(form) {
            CKEDITOR.instances.description.updateElement()
            //tinyMCE.triggerSave();

            // غیرفعال کردن دکمه قبل از ارسال
            var submitBtn = $(form).find('button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.addClass('disabled');
            var originalText = submitBtn.text();
            submitBtn.text('در حال ارسال...');

            $(form).ajaxSubmit({
                url: amadeusPath + 'ajax',
                type: 'POST',
                // mimeType: "multipart/form-data",
                // contentType: false,
                // processData: false,
                success: function(response) {
                    // console.log(response);
                    let displayIcon
                    if (response.success === true) {
                        displayIcon = 'success'
                    } else {
                        displayIcon = 'error'
                        // در صورت خطا، دکمه را دوباره فعال کن
                        submitBtn.prop('disabled', false);
                        submitBtn.removeClass('disabled');
                        submitBtn.text(originalText);
                    }

                    $.toast({
                        heading: 'قرعه کشی',
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                    if (response.success === true) {
                        submitBtn.text('ثبت شد - در حال انتقال...');
                        setTimeout(function() {
                            // location.reload()

                            window.location = `${amadeusPath}itadmin/lottery/list?section=lottery`;
                            // window.location = `${amadeusPath}itadmin/articles/list`;
                        }, 1000)
                    }
                },
                error: function(xhr, status, error) {
                    // در صورت خطای AJAX، دکمه را دوباره فعال کن
                    submitBtn.prop('disabled', false);
                    submitBtn.removeClass('disabled');
                    submitBtn.text(originalText);

                    $.toast({
                        heading: 'خطا',
                        text: 'خطا در ارسال اطلاعات',
                        position: 'top-right',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                }
            })
        },
        highlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-error')
               .removeClass('has-success')
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
               .parents('.form-group ')
               .addClass('has-success')
               .removeClass('has-error')
        },
    })

    let deleteLottery = function(id) {
        $.ajax({
            url: `${amadeusPath}user_ajax.php`,
            data: {
                flag: 'deleteLottery',
                id: id,
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {

                if (response.success === true) {
                    $.toast({
                        heading: 'حذف قرعه کشی',
                        text: response.message,
                        position: 'top-right',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                } else {
                    $.toast({
                        heading: 'حذف قرعه کشی',
                        text: response.message,
                        position: 'top-right',
                        icon: 'warning',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                }
            },
            complete: function() {
                setTimeout(function() {
                    location.reload()
                    // window.location = `${amadeusPath}itadmin/articles/list`;
                }, 1000)
            },
        })
    }
    let showOnResult = function(_this) {
        $.ajax({
            url: `${amadeusPath}user_ajax.php`,
            data: {
                flag: 'showOnResult',
                id: _this.data('id'),
                position: _this.data('position'),
                serviceGroup: _this.data('serviceGroup'),
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                console.log(response)
                if (response.success === true) {
                    $.toast({
                        heading: 'بروزرسانی',
                        text: response.message,
                        position: 'top-right',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                } else {
                    $.toast({
                        heading: 'بروزرسانی',
                        text: response.message,
                        position: 'top-right',
                        icon: 'warning',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                }
            },
            error: function(error) {
                console.log(error)
                $.toast({
                    heading: 'بروزرسانی',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            },
            complete: function() {
                setTimeout(function() {
                    location.reload()
                }, 3500)
            },
        })
    }

    $(document).on('click', '.showOnResult', function(e) {
        e.preventDefault()
        if (confirm('نمایش در لیست نتایج تغییر میکند. مطمئن هستید؟')) {
            // let id = $(this).data('id');
            // let sg = $(this).data('serviceGroup');
            showOnResult($(this))
        }
    })
    $(document).on('click', '.deleteArticle', function(e) {
        e.preventDefault()
        if (confirm('آیا مطمئن هستید ؟')) {
            let id = $(this).data('id')
            deleteLottery(id)
        }
    })
})

function initializeSelect2Search() {
    $('select.select2').select2()
    $('select.select2SearchHotel').select2({
        ajax: {
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return JSON.stringify({
                    q: params.term, // search term
                    className: 'articles',
                    method: 'searchHotel',

                })
            },
            cache: true,
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        },
        placeholder: 'جستجو بین شهر ها',
        minimumInputLength: 1,
        language: {
            inputTooShort: function() {
                return 'شما باید حداقل یک حرف وارد کنید'
            }, searching: function() {
                return 'در حال جستجو ... '
            },
        },


    })

}
async function removeSelect2(){
    if ($('.select2').data('select2')) {
        await $('.select2.select2-hidden-accessible').select2('destroy')
    }
    if ($('.select2SearchHotel').data('select2')) {
        await $('.select2SearchHotel.select2-hidden-accessible').select2('destroy')
    }
    await $('.select2-container--default').remove()
}
function removeCategoryItem(category_id) {
    if (confirm('آیا مطمئن هستید ؟')) {
        $.ajax({
            url:amadeusPath + 'ajax',
            data: JSON.stringify({
                className: "articles",
                method: "removeCategory",
                id: category_id,

            }),
            type: "POST",
            dataType: "JSON",
            success: function (response) {
                if (response.success === true) {

                    $.toast({
                        heading: "حذف قرعه کشی",
                        text: response.message,
                        position: "top-right",
                        icon: "success",
                        hideAfter: 3500,
                        textAlign: "right",
                        stack: 6,
                    })
                } else {
                    $.toast({
                        heading: "حذف قرعه کشی",
                        text: response.message,
                        position: "top-right",
                        icon: "warning",
                        hideAfter: 3500,
                        textAlign: "right",
                        stack: 6,
                    })
                }
            },
            complete: function () {
                setTimeout(function () {
                    location.reload()

                    // window.location = `${amadeusPath}itadmin/articles/list`;
                }, 1000)
            },
        })
    }
}
function openEditCategoryModal(category_id) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType: 'json',
        data: JSON.stringify({
            className: 'articles',
            method: 'getAdminCategory',
            to_json: true,
            id: category_id,
        }),
        success: function(data) {
            if (data.status == 'success') {
                const modal_div = $('#update_category')
                modal_div.find('[name="category_id"]').val(data.data.id)
                modal_div.find('[name="update_title"]').val(data.data.title)
                modal_div.find('[name="update_slug"]').val(data.data.slug)
                modal_div.find('[name="update_language"]').val(data.data.language)
                modal_div.find('[name="update_parent_id"]').val(data.data.parent_id)
                modal_div
                   .find('[name="update_image"]')
                   .attr(
                      'data-default-file',
                      data.data.image
                   )
                modal_div
                   .find('.dropify-render img')
                   .attr('src', data.data.image)
                $('#editCategoryModal').modal('show')
            } else {
                $.toast({
                    heading: 'خطا در دریافت اطلاعات',
                    text: data.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }
        },
    })
}

function updateCategory() {
    $('#update_category').submit()
}

function articleSelectedToggle(_this, article_id) {
    $.ajax({
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            method: 'articleSelectedToggle',
            className: 'articles',
            article_id: article_id,
        }),
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
            if (response.success === true) {
                $.toast({
                    heading: 'ویرایش مقاله',
                    text: response.message.message,
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
                if (response.message.data == '1') {
                    _this.find('i').removeClass('fa-star-o').addClass('fa-star')
                    _this.find('span').html('حذف از برگزیده')
                } else {
                    _this.find('i').removeClass('fa-star').addClass('fa-star-o')
                    _this.find('span').html('افزودن به برگزیده')
                }
            } else {
                $.toast({
                    heading: 'ویرایش مقاله',
                    text: response.message.message,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }
        },
        complete: function() {
            setTimeout(function() {
                // window.location = `${amadeusPath}itadmin/articles/list`;
            }, 1000)
        },
    })
}

function articleStateMain(_this, article_id) {
    $.ajax({
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            method: 'articleStateMain',
            className: 'articles',
            article_id: article_id,
        }),
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
            if (response.success === true) {
                $.toast({
                    heading: 'ویرایش مقاله',
                    text: response.message.message,
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
                if (response.message.data == '1') {
                    _this.find('i').removeClass('fa-star').addClass('fa-star-o')
                    _this.find('span').html('نمایش در سایت')
                } else {
                    _this.find('i').removeClass('fa-star-o').addClass('fa-star')
                    _this.find('span').html('عدم نمایش در سایت')
                }
            } else {
                $.toast({
                    heading: 'ویرایش مقاله',
                    text: response.message.message,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }
        },
        complete: function() {
            setTimeout(function() {
                // window.location = `${amadeusPath}itadmin/articles/list`;
            }, 1000)
        },
    })
}

async function getArticleServicePositions(_this) {
    let positions = _this
       .parent()
       .parent()
       .parent()
       .find("[data-name='positions']")
    let cloned_position = positions.find("[data-name='position']").clone();
    removeSelect2()
    positions.find('select[data-test-name="visa-type"]').remove()

    positions.find('select').each(function() {
        $(this)
           .attr('name', 'position[' + _this.val() + '][]')
    })

    if (_this.val() === 'Hotel') {


        positions.find('select').each(function() {


            $(this).html('')
            $(this).removeClass('select2')
            $(this).addClass('select2SearchHotel')

            initializeSelect2Search()
        })


    } else if (_this.val() === 'Visa') {

        // positions.append(newSelectOptions)

        // positions.remove()

        positions.find('select').each(async function() {


            $(this).removeClass('select2SearchHotel')
            $(this).addClass('select2')
            let cloned_select = $(this).clone()
            cloned_select.attr('data-test-name','visa-type')
            $(this).after(cloned_select)
            await rebuildPositionsIndex()
            const next_position = $(this).next()
            next_position.attr('name', 'position[Visa][Type][]')
            next_position.attr('id', next_position.attr('id') + '-type')
            initializeSelect2Search()
        })

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                method: 'listAllPositions',
                className: 'articles',
                to_json: true,
                service: _this.val(),
            }),
            success: function(response) {
                let countries = '<option value=\'all\'>همه کشور ها</option>'
                let types = '<option value=\'all\'>همه نوع ها</option>'
                if (response.data != '') {
                    console.log('response.data', response.data)
                    $.each(response.data.countries, function(index, item) {
                        countries +=
                           '<option value=\'' + index + '\'>' + item.name + '</option>'
                    })
                    $.each(response.data.types, function(index, item) {
                        types +=
                           '<option value=\'' + item.id + '\'>' + item.title + '</option>'
                    })
                }
                positions.find('select:not([data-test-name="visa-type"])').each(function() {
                    $(this)
                       .html(countries)
                       .change()

                })
                positions.find('select[data-test-name="visa-type"]').each(function() {
                    $(this)
                       .html(types)
                       .change()

                })
            },
            error: function(error) {
                console.log('error', error)
            },
        })


    }
    else {
        positions.find('select').each(function() {


            $(this).removeClass('select2SearchHotel')
            $(this).addClass('select2')

            initializeSelect2Search()
        })



        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                method: 'listAllPositions',
                className: 'articles',
                to_json: true,
                service: _this.val(),
            }),
            success: function(response) {
                let options = '<option value=\'all\'>همه مبداء/مقاصد</option>'
                if (response.data != '') {
                    console.log('response.data', response.data)
                    $.each(response.data, function(index, item) {
                        options +=
                           '<option value=\'' + index + '\'>' + item.name + '</option>'
                    })
                }
                positions.find('select').each(function() {
                    $(this)
                       .html(options)
                       .change()

                })
            },
            error: function(error) {
                console.log('error', error)
            },
        })


    }
    /* positions.find('select').each(function() {
       $(this)
         .attr('name', 'position[' + _this.val() + '][]')
     })*/

}

function getActionsHtml(type){
    let actions=''
    if(type==='both'){
        actions='' +
           '<div data-name="actions" class="align-self-end align-items-center col-md-1 p-0 d-flex flex-wrap justify-content-center actions-style">\n' +
           '    <button type="button" class="action-box-1 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="removePosition($(this))">\n' +
           '        <span class="fa fa-minus font-12"></span>\n' +
           '    </button>\n' +
           '    <button type="button" class="action-box-1 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="addMorePosition($(this))">\n' +
           '        <span class="fa fa-plus font-12"></span>\n' +
           '    </button>\n' +
           '</div>';
    }else if(type==='mines'){
        actions='' +
           '<div data-name="actions" class="align-self-end align-items-center col-md-1 p-0 action-box-1 d-flex flex-wrap justify-content-center">\n' +
           '    <button type="button" class="h-100 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="removePosition($(this))">\n' +
           '        <span class="fa fa-minus font-12"></span>\n' +
           '    </button>\n' +
           '</div>';
    }else if(type==='plus'){
        actions='' +
           '<div data-name="actions" class="align-self-end align-items-center col-md-1 p-0 action-box-1 d-flex flex-wrap justify-content-center">\n' +
           '    <button type="button" class="h-100 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="addMorePosition($(this))">\n' +
           '        <span class="fa fa-plus font-12"></span>\n' +
           '    </button>\n' +
           '</div>';
    }

    return actions

}
async function rebuildPositionsIndex() {




    $("[data-name='positions']").each(function(service_index) {

        let _positions=$(this);
        $(this).find(".each-position").each(function(index) {

            if(index===0){
                $(this).attr('data-name','position')
            }else{
                $(this).attr('data-name','added-position')
            }

            let index_number = index + 1



            $(this)
               .find('select[data-name="origin"]').each(function() {

                $(this).parent()
                   .find('label')
                   .attr('for', 'service' + service_index + 'position' + index_number)
                   .html(' مبداء ' + index_number)

                if ($(this).attr('name') === 'position[Visa][Type][]') {
                    $(this).attr('id', 'service' + service_index + 'position' + index_number + '-type')
                } else {
                    $(this).attr('id', 'service' + service_index + 'position' + index_number + '-origin')
                }
            })
            $(this)
               .find('select[data-name="destination"]').each(function() {

                $(this).parent()
                   .find('label')
                   .attr('for', 'service' + service_index + 'position' + index_number)
                   .html(' مقصد ' + index_number)

                $(this).attr('id', 'service' + service_index + 'position' + index_number + '-destination')

            })

            $(this).find('[data-name="actions"]').remove();
            if (index === 0 && _positions.find('.each-position').length === 1) {
                if($('#service'+index_number).val()  != 'Public') {
                    $(this).append(getActionsHtml('plus'));
                }
            } else if (index + 1 !== _positions.find('.each-position').length) {
                console.log('index > 1 && index+1 !== $(this).find(".each-position").length', index > 1 && index + 1 !== $(this).find('.each-position').length);
                $(this).append(getActionsHtml('mines'));
            } else if (index + 1 === _positions.find('.each-position').length && index !== 0) {
                console.log('index+1 === $(this).find(".each-position").length && index !== 0 ', index + 1 === _positions.find('.each-position').length && index !== 0);
                $(this).append(getActionsHtml('both'));
            }
        })

    })



}

async function rebuildServiceIndex() {
    const remove_btn =
       '<button onclick="removeService($(this))" type="button" class="btn btn-danger font-12 rounded p-1 gap-2">' +
       '<span class="fa fa-trash"> </span>' +
       ' حذف</button>'

    await $("[data-name='added-service']").each(function(index) {
        let index_number = index + 2
        $(this)
           .find('h4')
           .addClass('w-100 justify-content-between')
           .html('مکان نمایش  ' + index_number + remove_btn)
        $(this)
           .find('select[name="service[]"]')
           .attr('id', 'service' + index_number)
    })
}

async function rebuildCategoryIndex() {
    const remove_btn =
       '<button onclick="removeCategory($(this))" type="button" class="btn btn-danger font-12 rounded p-1 gap-2">' +
       '<span class="fa fa-trash"> </span>' +
       'حذف</button>'



    $('[data-name=\'added-category\']').each(function(index) {
        let index_number = index + 2
        $(this).find('.tooltip-info').remove()

        const title='<span>\n' +
           'دسته بندی ' +index_number+
           '<span class="fa "></span>' +
           '</span>'
        $(this)
           .find('h4')
           .addClass('w-100 justify-content-between')
           .html(title  + remove_btn)
    })
}

function removeCategory(_this) {
    _this.parent().parent().parent().remove()
    rebuildCategoryIndex()

    let firstCategory = $('[data-name="category"] > div > div > button')
    let newCategory = $('[data-name="added-category"] > div > h4 > button')
    if (newCategory.length === 0) {
        firstCategory.removeClass('d-block')
        firstCategory.addClass('d-none')
    }
}

async function removePosition(_this) {
    _this.parent().parent().remove()
    await rebuildPositionsIndex()
}

/*function removeCategories(_this) {
   _this.parent().remove()
   rebuildPositionsIndex()
}*/
async function removeService(_this) {
    _this.parent().parent().parent().remove()
    await rebuildServiceIndex()
    await rebuildPositionsIndex()
}

async function addMorePosition(_this) {
    await removeSelect2()

    let position = _this.parents('.each-position').clone()

    const added_position_count = _this.parents("[data-name='added-position']").length + 2
    await position.attr('data-name', 'added-position')
    await position.find('select').attr('id', 'position' + added_position_count)
    await position
       .find('label[for="position1"]')
       .attr('for', 'position' + added_position_count)
    console.log("_this.parents(\"[data-name='positions']\")",_this.parents("[data-name='positions']"))
    console.log('position',position)
    await _this.parents("[data-name='positions']").append(position)

    await rebuildPositionsIndex()
    await initializeSelect2Search()

}

async function addMoreService(_this) {
    await removeSelect2()

    let service = $('[data-name="service"]').clone()
    const added_service_count = $('[data-name=\'added-service\']').length + 2
    service.attr('data-name', 'added-service')
    service
       .find('select[name="service[]"]')
       .attr('id', 'service' + added_service_count)
    service
       .find('label[for="service1"]')
       .attr('for', 'service' + added_service_count)
    console.log('service',service)
    service.find("[data-name='positions']").find("[data-name='added-position']").remove()
    service.find("[data-name='position']").find('select').val('').change()
    service.find(".tooltip-info").remove()
    service.find("[data-test-name='visa-type']").remove()
    $("[data-name='add-more-service']").before(service)

    await rebuildServiceIndex()
    await rebuildPositionsIndex()
    await removeSelect2()
    await initializeSelect2Search()
}

async function selectCategory(_this, input_name, category, title, parent_id) {
    // _this.
    const input_name_div = _this.parent().parent().find('[data-name="' + input_name + '"]')
    const selected_category = _this.parent().parent().parent().find('[name="selected_category[]"]')
    let category_id = category
    if (category == 'new') {
        await $.ajax({
            type: 'post',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                className: 'articles',
                method: 'storeCategory',
                parent_id: parent_id,
                title: title,
            }),
            success: function(response) {
                console.log('response', response)
                let displayIcon
                let displayTitle
                if (response.success === true) {
                    displayIcon = 'success'
                    displayTitle = 'انجام شد'
                    category_id = response[0]
                } else {
                    displayIcon = 'error'
                    displayTitle = 'عملیات با خطا مواجه شد'
                }


                $.toast({
                    heading: displayTitle,
                    text: response.message,
                    position: 'top-right',
                    icon: displayIcon,
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            },
        })
    }
    console.log('category_id',category_id)
    selected_category.val(category_id)
    const result_box = $('[data-name=\'result-box\']')
    result_box.html('')
    result_box.removeClass('d-flex')
    result_box.addClass('d-none')
    input_name_div.val(title)
}

function searchCategory(_this, parent_id = 0) {
    const value = _this.val()
    const result_box = _this.parent().find('[data-name=\'result-box\']')
    if (value) {


        $.ajax({
            type: 'post',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                className: 'articles',
                method: 'searchCategory',
                to_json: true,
                parent_id: parent_id,
                title: value,
            }),
            success: function(data) {
                if (data.status == 'success') {


                    let add_option = ''
                    let options=''
                    let titles=[]
                    $.each(data.data, function(index, item) {

                        titles.push(item.title)
                        if (!titles.includes(value)) {
                            add_option = '<div class=\'align-items-center gap-4 item justify-content-between\' ' +
                               'onclick=\'selectCategory($(this),"' + _this.data('name') + '","new","' + value + '","' + parent_id + '")\'>'
                               + value + '<span class=\'text-primary\'>افزودن</span>' +
                               '</div>'

                        }

                        options += '<div class=\'align-items-center gap-4 item justify-content-between\' ' +
                           'onclick=\'selectCategory($(this),"' + _this.data('name') + '",' + item.id + ',"' + item.title + '","' + parent_id + '")\'>'
                           + item.title + '<span class=\'text-muted\'>انتخاب</span>' +
                           '</div>'


                    })

                    if(options){
                        result_box.html(add_option+options)

                    }else{

                        add_option = '<div class=\'align-items-center gap-4 item justify-content-between\' ' +
                           'onclick=\'selectCategory($(this),"' + _this.data('name') + '","new","' + value + '","' + parent_id + '")\'>'
                           + value + '<span class=\'text-primary\'>افزودن</span>' +
                           '</div>'

                        result_box.html(add_option)
                    }
                    result_box.addClass('d-flex')
                    result_box.removeClass('d-none')


                } else {
                    $.toast({
                        heading: 'خطا در دریافت اطلاعات',
                        text: data.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })
                }
            },
        })
    }

    result_box.removeClass('d-flex')
    result_box.addClass('d-none')
}

function addMoreCategories(_this) {
    let categories = _this.parent().parent().find('[data-name="categories"]').clone()
    const selected_category = _this.parent().parent().find('[name="selected_category[]"]')

    const added_category_count = _this.parent().parent().find('[data-name=\'added-categories\']').length + 2
    categories.attr('data-name', 'added-categories')
       .find('input[name="categories[]"]')
       .attr('data-name', 'categories' + added_category_count)
       .attr('oninput', 'searchCategory($(this),"' + selected_category.val() + '")')
       .val('')
       .change()

    _this.parent().parent().find('[data-name=\'add-more-categories\']').before(categories)
}

async function addMoreCategorySection(_this) {
    const added_category_count = $('[data-name="added-category"]').length + 2;

    const category = $(`
    <div data-name="added-category" class="bg-white d-flex flex-wrap rounded w-100">
      <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
        <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
          <span>دسته بندی</span>
          <button onclick="removeCategory($(this))" type="button"
                  class="btn btn-danger font-12 rounded p-1 gap-2 d-flex ml-3">
            <span class="fa fa-trash"></span> حذف
          </button>
        </h4>
        <div class="d-flex align-items-center">
          <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                data-toggle="tooltip" data-placement="top"
                title="دسته بندی مقاله ی خود را انتخاب یا ایجاد کنید"></span>
        </div>
      </div>

      <hr class='m-0 mb-4 w-100'>

      <div class="parent-input">
        <input type='hidden' value='' name='selected_category[]'>
        <div data-name='categories' class="form-group form-new">
          <input type='text'
                 data-name='category${added_category_count}'
                 oninput='searchCategory($(this))'
                 autocomplete='off'
                 value=''
                 name='categories[]' class='form-control'>
          <div data-name='result-box'
               class='select-categories d-none align-items-center border flex-wrap justify-content-center p-2 rounded'>
          </div>
        </div>

        <div data-name='add-more-categories'
             class="align-items-center border-primary d-flex flex-wrap font-bold gap-10 justify-content-center rounded w-100 h-160">
          <button onclick='addMoreCategories($(this))' type='button'
                  class='btn btn-default rounded d-flex flex-wrap gap-8 btn-new-style'>
            <span class='fa fa-plus-circle font20'></span>
            ثبت زیرمجموعه
          </button>
        </div>
      </div>

      <hr class='w-100'>
    </div>
  `);

    $('[data-name="add-more-category"]').before(category);

    await rebuildCategoryIndex();

    let firstCategory = $('[data-name="category"] > div > div > button');
    firstCategory.addClass('d-block').removeClass('d-none');
}

function GetLotteryGalleryData(lottery_id) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType: 'json',
        data: JSON.stringify({
            className: 'lottery',
            method: 'GetLotteryGalleryData',
            lottery_id: lottery_id,
        }),
        success: function(data) {

            if (data.success) {
                var tr = ''
                var counter = 1
                $.each(data.data, function(i, item) {

                    tr = tr + '<tr>' +
                       '<td>' + counter + '</td>' +
                       '<td><img src="..\\..\\pic\\' + item.image_path + '" alt=""></td>' +
                       '<td><button onclick="SubmitRemoveArticleGallery(' + item.id + ',$(this))" class="btn btn-danger"><span class="fa fa-remove"></span></button></td>' +
                       '</tr>'
                    counter = counter + 1
                })
                $('#AllArticleGallery').html(tr)
            }


        },
    })
}

function UpdateArticleGalleryData(id,_this,lottery_id){
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType: 'json',
        data: JSON.stringify({
            className: 'lottery',
            method: 'updateGallery',
            id: id,
            alt: _this.val(),
        }),
        success: function(data) {
            console.log(data)
            if (data.success) {

                GetArticleGalleryData(lottery_id)
                $.toast({
                    heading: 'ثبت تغییرات',
                    text: data.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }


        },
    })
}

async function SubmitRemoveArticleGallery(GalleryId, IsTable = false) {
    if (confirm('آیا مطمئن هستید ؟')) {
        await $.ajax({
            type: 'post',
            url: amadeusPath + 'ajax',
            data: JSON.stringify({
                className: 'lottery',
                method: 'RemoveSingleGallery',
                GalleryId: GalleryId,
            }),
            success: function(data) {
                if (data.success) {
                    $.toast({
                        heading: 'ثبت تغییرات',
                        text: data.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                    console.log('IsTable', IsTable)
                    if (IsTable) {
                        IsTable.parent().parent().remove()
                    }

                } else {

                    $.toast({
                        heading: 'ثبت تغییرات',
                        text: data.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                }


            },
        })
    }
}


$(document).on('click', '.deleteArticleImage', function(e) {
    e.preventDefault()
    if (confirm('آیا از حذف تصویر مطمئن هستید ؟')) {
        let id = $(this).data('id')
        deleteArticleImage(id)
    }
})

function deleteArticleImage(id){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType: 'JSON',
        data:  JSON.stringify({
            className: 'lottery',
            method: 'deleteArticleImage',
            id,
        }),
        success: function (data) {
            $.toast({
                heading: 'حذف تصویر شاخص',
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
                heading: 'حذف تصویر شاخص',
                text: error.responseJSON.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        },
        complete: function() {
            setTimeout(function() {
                location.reload()
            }, 1000)
        },
    });
}

function change_order_article(){
    if (confirm('آیا از تغییر ترتیب موارد مطمئن هستید ؟')) {
        var inputs = document.querySelectorAll('input[name^="order["]');
        var values = {};

        inputs.forEach(function(input) {
            var name = input.name;
            var value = input.value;
            var match = name.match(/\[(\d+)\]/);
            if (match) {
                var numberInsideBrackets = match[1];
                console.log(numberInsideBrackets); // Output: "60"
            }
            values[numberInsideBrackets] = value;
        });
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'JSON',
            data:  JSON.stringify({
                className: 'articles',
                method: 'change_order_article',
                data: values,
            }),
            success: function (data) {
                $.toast({
                    heading: 'تغییر ترتیب',
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
                    heading: 'تغییر ترتیب',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            },
            complete: function() {
                setTimeout(function() {
                    location.reload()
                    // window.location = `${amadeusPath}itadmin/articles/categories`;
                }, 1000)
            },
        });
    }
}


