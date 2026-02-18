$(document).ready(function () {

  $('#insertAgencyDepart').validate({
    rules: {
      language: 'required',
      title: 'required',
      content: 'required',
    },
    messages: {},
    errorElement: 'em',
    errorPlacement: function (error, element) {
      error.addClass('help-block');
    },
    submitHandler: function (form, event) {
      event.preventDefault(); // جلوگیری از رفرش شدن فرم
      let formData = new FormData(form);

      $.ajax({
        url: amadeusPath + 'ajax',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
          let displayIcon = response.success ? 'success' : 'error';

          $.toast({
            heading: 'مطالب',
            text: response.message || 'پاسخی دریافت نشد',
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 5,
          });

          // اگر خواستی بعد از موفقیت صفحه reload شه:
           if (response.success) {
            setTimeout(function () {
              window.location = `${amadeusPath}itadmin/agencyDepartments/list`;
             }, 1000);
           }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', xhr.responseText);
          alert('خطا در ارتباط با سرور: ' + xhr.status);
        },
      });

    },
    highlight: function (element, errorClass, validClass) {
      $(element)
        .parents('.form-group ')
        .addClass('has-error')
        .removeClass('has-success');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element)
        .parents('.form-group ')
        .addClass('has-success')
        .removeClass('has-error');
    },
  });
  $('#editAgencyDepart').validate({
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
    },
    submitHandler: function(form) {

        $(form).ajaxSubmit({
          url: amadeusPath + 'ajax',
          type: 'POST',
          success: function(response) {
            let displayIcon
            if (response.success === true) {
              displayIcon = 'success'
            } else {
              displayIcon = 'error'
            }

            $.toast({
              heading: 'مطالب',
              text: response.message || 'پاسخی دریافت نشد',
              position: 'top-right',
              icon: displayIcon,
              hideAfter: 3500,
              textAlign: 'right',
              stack: 5,
            });

            if (response.success) {
              setTimeout(function () {
                window.location = `${amadeusPath}itadmin/agencyDepartments/list`;
              }, 1000);
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
});
function deleteAgencyDepart(depart_id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "agencyDepartments",
        method: "deleteAgencyDepart",
        id: depart_id,
      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {
          $.toast({
            heading: "حذف واحد اداری",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: " حذف واحد اداری",
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
//end fun deleteAgencyDepart