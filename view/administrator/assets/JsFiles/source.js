$(document).ready(function () {
    // Initialize DataTable
    $('#listSourcesTable').DataTable({
        "language": {
            "url": "/assets/global/plugins/datatables/Persian.json"
        }
    });

    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });

    // ارسال فرم با AJAX
    $('#sourceForm').on('submit', function (e) {
        e.preventDefault();

        let formData = {
            className: 'sources',
            method: 'saveSource',
            id: $('#id').val(),
            name: $('#name').val(),
            name_fa: $('#name_fa').val(),
            nickName: $('#nickName').val(),
            sourceType: $('#sourceType').val(),
            sourceCode: $('#sourceCode').val(),
            fareStatus: $('#fareStatus').val(),
            s_d_a_d: $('#s_d_a_d').val(),
            s_kh_a_kh: $('#s_kh_a_kh').val(),
            s_kh_a_d: $('#s_kh_a_d').val(),
            ch_d_a_d: $('#ch_d_a_d').val(),
            ch_kh_a_kh: $('#ch_kh_a_kh').val(),
            ch_kh_a_d: $('#ch_kh_a_d').val(),
            s_kh_a_kh_au: $('#s_kh_a_kh_au').val(),
            isActive: $('#isActive').is(':checked') ? 1 : 0,
            username: $('#username').val(),
            password: $('#password').val(),
            token: $('#token').val(),
            to_json: true
        };

        $.ajax({
            type: "POST",
            url: amadeusPath + "ajax",
            data: JSON.stringify(formData),
            contentType: "application/json",
            success: function (response) {
                if (response && response.status) {
                    $.toast({
                        heading: 'ثبت منبع',
                        text: 'تامین کننده با موفقیت ذخیره شد.',
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
                        heading: 'خطا در ثبت',
                        text: 'ثبت با خطا مواجه شد',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }
            },
            error: function () {
                $.toast({
                    heading: 'خطای سرور',
                    text: 'ارتباط با سرور برقرار نشد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    });
});
function FunSourceStatus(source_id){
    $.ajax({
        type: "post",
        url: amadeusPath + "ajax",
        data: JSON.stringify({
            className: 'sources',
            method: 'SourceStatus',
            source_id: source_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.data && response.data.success) {
                $.toast({
                    heading: 'وضعیت تامین کننده',
                    text: 'وضعیت با موفقیت تغییر کرد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                // Reload page to reflect changes
                setTimeout(function() {
                  location.reload();
                }, 1000);
            } else {
                $.toast({
                    heading: 'وضعیت تامین کننده',
                    text: response.data?.message || 'خطا در تغییر وضعیت',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },
        error: function() {
            $.toast({
                heading: 'وضعیت تامین کننده',
                text: 'خطا در ارتباط با سرور',
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
function editSource(id) {
    $.ajax({
        url: amadeusPath + 'ajax',
        type: "POST",
        data: JSON.stringify({
            className: 'sources',
            method: 'getSourceById',
            id: id,
            to_json: true
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            let d = response.data;
            if (!d) {
                alert('اطلاعات صفحه خالی است!');
                return;
            }

            // اگر d آرایه‌ای ساده است که رشته‌ها دارد
            $('#id').val(d.id);
            $('#name').val(d.name);
            $('#name_fa').val(d.name_fa);
            $('#nickName').val(d.nickName);
            $('#sourceType').val(d.sourceType);
            $('#sourceCode').val(d.sourceCode);
            $('#fareStatus').val(d.fareStatus || '');
            $('#s_d_a_d').val(d.s_d_a_d);
            $('#s_kh_a_kh').val(d.s_kh_a_kh);
            $('#s_kh_a_d').val(d.s_kh_a_d);
            $('#ch_d_a_d').val(d.ch_d_a_d);
            $('#ch_kh_a_kh').val(d.ch_kh_a_kh);
            $('#ch_kh_a_d').val(d.ch_kh_a_d);
            $('#s_kh_a_kh_au').val(d.s_kh_a_kh_au);
            $('#isActive').prop('checked', d.isActive == '1');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $('#username').val(d.username);
            $('#password').val(d.password);
            $('#token').val(d.token);

            $.toast({
                heading: 'مدیریت صفحات',
                text: 'اطلاعات صفحه با موفقیت بارگذاری شد.',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'info',
                hideAfter: 3000,
                textAlign: 'right',
                stack: 6
            });
        },
        error: function () {
            alert('خطا در ارتباط با سرور.');
        }
    });
}