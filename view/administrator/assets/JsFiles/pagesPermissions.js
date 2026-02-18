$(document).ready(function () {
  // ثبت / ویرایش صفحه
  $("#pageForm").validate({
    rules: {
      id_page: "required",
      id_member: "required"
    },
    messages: {
      id_page: "لطفاً عنوان صفحه را وارد کنید",
      id_member: "کانتر مشحص نیست"
    },
    submitHandler: function (form) {
      $.ajax({
        url: amadeusPath + 'ajax',
        type: "POST",
        data: JSON.stringify({
          className: 'pagesPermissions',
          method: 'savePage',
          id_member : $('#id_member').val(),
          id_page   : $('#id_page').val(),
          can_insert: $('#can_insert').is(':checked') ? 1 : 0,
          can_update: $('#can_update').is(':checked') ? 1 : 0,
          can_delete: $('#can_delete').is(':checked') ? 1 : 0,
          to_json: true
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
          if (response.status === "success" || response.status === true) {
            $.toast({
              heading: 'سطح دسترسی صفحات',
              text: response.message || 'دسترسی با موفقیت ذخیره شد.',
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

            $('#pageForm')[0].reset();
            $('#page_id').val('');
            setTimeout(function () {
              location.reload()
            }, 1000)
          } else {
            $.toast({
              heading: 'سطح دسترسی صفحات',
              text: response.message || 'خطا در ذخیره دسترسی.',
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
            heading: 'سطح دسترسی صفحات',
            text: 'خطا در ارتباط با سرور.',
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
  });
});
function deleteAccess(id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "pagesPermissions",
        method: "deletePage",
        id: id,
      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {
          $.toast({
            heading: "حذف درباره Gds",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: " حذف درباره Gds",
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
        }, 1000)
      },
    })
  }
}
