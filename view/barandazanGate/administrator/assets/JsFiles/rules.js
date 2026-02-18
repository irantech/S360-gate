
const categories = {
    newCategory : function(){
        let formElement = $('#newRulesCategory');
        formElement.validate({
            rules:{
                title : 'required',
                slug : 'required'
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
            },

            submitHandler :function(form){
                $(form).ajaxSubmit({
                    url: amadeusPath + 'user_ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (response) {
                            $.toast({
                                heading: 'افزودن دسته بندی',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon:  response.status,
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6
                            });
                            if (response.success === true) {
                            // console.log(`${amadeusPath}itadmin/configurations/listContent?config=${form.configuration_id.value}`);
                            setTimeout(function () {
                                window.location = `${amadeusPath}itadmin/rules/listCategory`;
                            }, 500);
                        }
                    },
                    error: function(response) {
                        console.log(response.responseJSON.data)
                        if (response.responseJSON.data == 'slug_used') {
                            $.toast({
                                heading: 'نام لاتین تکراری است.',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon:  response.status,
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6,
                            });
                        } else {
                            $.toast({
                                heading: 'مشکلی پیش آمد.',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon:  response.status,
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6,
                            });
                        }
                    },
                });
            }
        })
    },
    editCategory : function(){
        let formElement = $('#editCategory');
        formElement.validate({
            rules:{
                title : 'required',
                slug : 'required'
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
            },

            submitHandler :function(form){
                $(form).ajaxSubmit({
                    url: amadeusPath + 'user_ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (response) {

                            $.toast({
                                heading: 'افزودن دسته بندی',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon: response.status,
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6
                            });

                        if (response.status=='success') {
                            // console.log(`${amadeusPath}itadmin/configurations/listContent?config=${form.configuration_id.value}`);

                            setTimeout(function () {
                                window.location = `${amadeusPath}itadmin/rules/listCategory`;
                            }, 500);
                        }
                    },
                });
            }
        })
    },
};
var url = new URL(window.location.href);

function rulesLanguage(lang) {
    var langsName = {
        'fa': 'فارسی',
        'en': 'انگلیسی',
        'ar': 'عربی',

    }

    $.toast({
        heading: 'تغییر زبان ',
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
    });

    setTimeout(function() {
        url.searchParams.set('lang', lang);
        window.location.href = url.href;
    }, 1000);
}


function selectCategoryIcon(_this, value) {
    $('div[data-target="IconBoxSelector"] .border').each(function () {
        $(this).removeClass("active")
    })
    _this.addClass("active")
    $('input#edited_icon_category').val(value)
}
function modalEditCategoryRule (id) {
    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: 'rules',
          Method: 'modalEditCategoryRule',
          Param: id
      },
      function (data) {
          $('#ModalPublic').html(data);
      });
}

function modalAddRules (id) {
    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'rules',
            Method: 'modalAddRules',
            Param: id
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}
function modalEditRule (id) {
    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'rules',
            Method: 'modalEditRules',
            Param: id
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}


function deleteRule (id) {
    if (confirm('آیا مطمئن هستید ؟')) {
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                className: 'rules',
                method: 'deleteRule',
                Param: id

            }),
            success:function(response) {
                console.log(response)
                if (response.data = true) {
                    window.location = url;
                }
            },
            error: function(error) {
                $.toast({
                    heading: 'مشکلی پیش آمد.',
                    text: '',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                });
            },

        });

    }
}
function deleteCategory (id) {
    if (confirm('آیا مطمئن هستید ؟')) {

          $.ajax({
              type: 'POST',
              url: amadeusPath + 'ajax',
              dataType: 'json',
              data: JSON.stringify({
                  className: 'rulesCategory',
                  method: 'deleteCategory',
                  Param: id

              }),
          success:function(response) {
              console.log(response)
              if (response.data = true) {
                  window.location = url;
              }
          },
          error: function(error) {
              $.toast({
                  heading: 'مشکلی پیش آمد.',
                  text: '',
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'error',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6,
              });
          },

          });

    }
}
function sendDataForEditRuleCategory(id){

    let btn_toggle = $('#btn_edit_rule_category');
    let title = $('#edited_rule_category').val();
    let slug = $('#edited_slug_category').val();
    let icon = $('#edited_icon_category').val();

    if (title == "" || slug == "") {

        $.alert({
            title: 'ویرایش دسته بندی',
            icon: 'fa fa-trash',
            content: 'فیلد عنوان و عنوان انگلیسی نمی تواند خالی باشد',
            rtl: true,
            type: 'red',
        });
    } else {
        btn_toggle.prop('disabled', true)
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data: {
                flag: 'editRuleCategory',
                title: title,
                slug: slug,
                icon: icon,
                category_id: id
            },
            success: function(response) {
                btn_toggle.prop('disabled', false)
                if (response.status == 'success') {
                    $('#ModalPublic').modal('hide');
                    $.toast({
                        heading: 'دسته بندی ویرایش شد',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: response.status,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }else{
                    btn_toggle.prop('disabled', false)
                    $.toast({
                        heading: 'دسته بندی ویرایش شد',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: response.status,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }

                // window.location = url;

            },
        });
    }
}
function sendDataForInsertRules(id) {

    let btn_toggle = $('#btn_create_new_rule_category');
    let title = $('#rule').val();
    CKEDITOR.instances.contentRules.updateElement()
    var contentRules = $('#contentRules').val();
    if (title == "" || contentRules == "") {
      $.alert({
        title: 'افزودن قانون',
        icon: 'fa fa-trash',
        content: 'فیلد عنوان یا متن نمی تواند خالی باشد',
        rtl: true,
        type: 'red',
      });
    } else {
        CKEDITOR.instances.contentRules.updateElement();
        let content = $('#contentRules').val();
        btn_toggle.prop('disabled', true)
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data: {
                flag: 'addRule',
                title: title,
                content: content,
                category_id: id
            },
            success: function(response) {
                btn_toggle.prop('disabled', false)
                if (response.status == 'success') {
                    $('#ModalPublic').modal('hide');
                }
                $.toast({
                    heading: 'افزودن قانون جدید',
                    text: response.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: response.status,
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                window.location = `${amadeusPath}itadmin/rules/listCategory`;

            }
        });
    }
}
function sendDataForEditRules(id){

    let title = $('#rule').val();
    CKEDITOR.instances.contentRules.updateElement();
    let content = $('#contentRules').val();
    let rulesCategory = $('#rulesCategory').val()
    if (title == "" || content == "") {
        $.alert({
            title: 'ویرایش قانون',
            icon: 'fa fa-trash',
            content: 'فیلد عنوان یا متن نمی تواند خالی باشد',
            rtl: true,
            type: 'red',
        });
    } else {

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data: {
                flag: 'editRule',
                title: title,
                id: id,
                content: content,
                category_id: rulesCategory
            },
            success: function(response) {
                if (response.status == 'success') {
                    // $('#ModalPublic').modal('hide');
                    window.location = `${amadeusPath}itadmin/rules/listCategory`;
                }
                $.toast({
                    heading: 'ویرایش قانون جدید',
                    text: response.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: response.status,
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            }
        });
    }
}
categories.newCategory();
categories.editCategory();


