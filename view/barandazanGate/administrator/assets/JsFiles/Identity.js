

$(document).ready(function () {


//    

    $('#Identity').ajaxForm({

  
        beforeSubmit: function (arr, $form, options) {
            var check = false;
            var nameFilde = [
                "username",
                "password"
            ];

            for (var i = 0; i < nameFilde.length; i++)
            {
                if ($('#' + nameFilde[i]).val() == "" && nameFilde[i] != "")
                {
                    check = true;
                    $.alert({
                        title: ' اطلاعات شناسایی کاربر',
                        icon: 'fa fa-info-circle',
                        content: 'لطفا ' + $('#' + nameFilde[i]).parent('.input-group').parent('.form-group').find('label').text() + ' ' + 'را وارد نمائید',
                        rtl: true,
                        type: 'orange',
                    });
                }
            }

            if (check)
            {
                return false;
            }

        },
        success: function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.alert({
                    title: ' اطلاعات شناسایی کاربر',
                    icon: 'fa fa-info-circle',
                    content: res[1],
                    rtl: true,
                    type: 'green',
                });
                setTimeout(function () {
                    location.href = "administratorpartner";

                }, 1000);
            } else
            {
                $.alert({
                    title: ' اطلاعات شناسایی کاربر',
                    icon: 'fa fa-info-circle',
                    content: res[1],
                    rtl: true,
                    type: 'red',
                });
            }
        }
    });

});

