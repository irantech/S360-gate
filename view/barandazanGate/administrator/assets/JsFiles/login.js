$(".select2").select2();

$('.select2-itadmin-login-register').select2({
    minimumResultsForSearch: Infinity
});

$(document).ready(function () {

    $('#ModalPublic').modal('show');

    let ClientId = $('#ClientId').val();

    if(ClientId !=="")
    {
        $('.LoginAuto').trigger('click');
    }

});

function LoginAdmin(){
    let username =$('#username').val();
    let password =$('#password').val();
    let member =$('#member').val();
    let captcha = $("#signup-captcha2").val();
    let type_manager = $('#typeManage').val();
    let client_id = $('#ClientId').val();


        if (captcha || client_id !== "") {
            $.post(amadeusPath + 'captcha/securimage_check.php',
                {
                    captchaAjax: captcha
                },
                function (data) {
                    if (data == true || client_id !== "") {

                        reloadCaptchaSignin2();
                        $.ajax({
                            type: 'POST',
                            url: amadeusPath + 'ajax',
                            dataType: 'JSON',
                            data:  JSON.stringify({
                                className: 'admin',
                                method: 'loginAdmin',
                                username,
                                password,
                                client_id,
                                type_manager,
                                member,
                            }),
                            success: function (response) {
                               console.log(response);
                                $.toast({
                                    heading: 'ورود به پنل مدیریت',
                                    text: response.message,
                                    position: 'bottom-right',
                                    loaderBg: '#53e69d ',
                                    icon: 'success',
                                    hideAfter: 2000,
                                    textAlign: 'right',
                                    stack: 6
                                });
                                setTimeout(function () {
                                    window.location = 'admin';
                                }, 2500);

                            },
                            error:function(error) {
                                console.log(error);
                                $.toast({
                                    heading: 'ورود به پنل مدیریت',
                                    text: error.responseJSON.message,
                                    position: 'bottom-right',
                                    loaderBg: '#ffcc00',
                                    icon: 'error',
                                    textAlign: 'right',
                                    hideAfter: 3000,
                                    stack: 6
                                });
                            }
                        });
                    } else {
                        reloadCaptchaSignin2();
                        $.toast({
                            heading: 'ورود به پنل مدیریت',
                            text: 'لطفا کد امنیتی را صحیح وارد نمائید',
                            position: 'bottom-right',
                            loaderBg: '#ffcc00',
                            icon: 'error',
                            textAlign: 'right',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                })
        } else {
            $.toast({
                heading: 'ورود به پنل مدیریت',
                text: 'لطفا کد امنیتی را  وارد نمائید',
                position: 'bottom-right',
                loaderBg: '#ffcc00',
                icon: 'error',
                textAlign: 'right',
                hideAfter: 3000,
                stack: 6
            });
        }

}


function reloadCaptchaSignin2() {
    var capcha = amadeusPath + 'captcha/securimage_show.php?sid=' + Math.random();
    $("#captchaImage").attr("src", capcha);
}
