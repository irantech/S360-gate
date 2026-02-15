$(document).ready(function () {
  // ثبت / ویرایش صفحه
  $("#pageForm").validate({
    rules: {
      title: "required",
      address: "required"
    },
    messages: {
      title: "لطفاً عنوان صفحه را وارد کنید",
      address: "لطفاً آدرس صفحه را وارد کنید"
    },
    submitHandler: function (form) {
      $.ajax({
        url: amadeusPath + 'ajax',
        type: "POST",
        data: JSON.stringify({
          className: 'adminPages',
          method: 'savePage',
          id: $('#page_id').val(),
          title: $('#title').val().trim(),
          address: $('#address').val().trim(),
          to_json: true
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
          if (response.status === "success" || response.status === true) {
            $.toast({
              heading: 'مدیریت صفحات',
              text: response.message || 'صفحه با موفقیت ذخیره شد.',
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
              heading: 'مدیریت صفحات',
              text: response.message || 'خطا در ذخیره صفحه.',
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
            heading: 'مدیریت صفحات',
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
// تعریف تابع در سطح global
function editPage(id) {
  $.ajax({
    url: amadeusPath + 'ajax',
    type: "POST",
    data: JSON.stringify({
      className: 'adminPages',
      method: 'getPageById',
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
      $('#page_id').val(d.id);
      $('#title').val(d.title);
      $('#address').val(d.address);

      $('html, body').animate({ scrollTop: 0 }, 'slow');

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
function deletePage(id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "adminPages",
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
