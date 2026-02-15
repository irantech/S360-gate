$(document).ready(function () {
  $("#addEmbassy").validate({
    rules: {
      embassyName: 'required',
      embassyAddress: 'required',
      embassyDescription: 'required',
      embassyNumberTitle: 'required',
      embassyNumber: 'required',
      lat: 'required',
      lng: 'required'
    },
    messages: {},
    errorElement: "em",
    errorPlacement: function(error, element) {
      error.addClass("help-block");
      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: "post",
        success: function(response) {
          let displayIcon;
          let displayTitle;
          if (response.success === true) {
            displayIcon = 'success';
            displayTitle = 'انجام شد';
          } else {
            displayIcon = 'error';
            displayTitle = 'عملیات با خطا مواجه شد';
          }
          $.toast({
            heading: displayTitle,
            text: response.message,
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });
          if (response.success === true) {
            setTimeout(function() {
              location.reload();
            }, 1000);
          }
        }
      });
    },
    highlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }
  });
  $("#editEmbassy").validate({
    rules: {
      embassyName: 'required',
      embassyAddress: 'required',
      embassyDescription: 'required',
      embassyNumberTitle: 'required',
      embassyNumber: 'required',
      lat: 'required',
      lng: 'required'
    },
    messages: {},
    errorElement: "em",
    errorPlacement: function(error, element) {
      error.addClass("help-block");
      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: "post",
        success: function(response) {
          let displayIcon;
          let displayTitle;
          if (response.success === true) {
            displayIcon = 'success';
            displayTitle = 'انجام شد';
          } else {
            displayIcon = 'error';
            displayTitle = 'عملیات با خطا مواجه شد';
          }
          $.toast({
            heading: displayTitle,
            text: response.message,
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });
          if (response.success === true) {
            setTimeout(function() {
              location.reload();
            }, 1000);
          }
        }
      });
    },
    highlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }
  });
});
function addAdditionalNumber() {
  let countDiv = $('div[data-target="BaseAdditionalDataDiv"]').length
  let baseDiv = $('div[data-target="baseAdditionalNumber"]:last-child');
  let cloneBaseDiv = baseDiv.clone();
  let countDivInEach = 0;
  cloneBaseDiv.find("input").val("");
  baseDiv.after(cloneBaseDiv);
  $('.DynamicAdditionalData input[data-parent="additionalNumber"]').each(function () {
    $(this).attr(
      "name",
      "embassyNumber[" + countDivInEach + "][" + $(this).attr("data-target") + "]"
    );
    if ($(this).attr("data-target") == "number") {
      countDivInEach = countDivInEach + 1
    }
  });
}
function removeAdditionalNumber(_this) {
  if($(".baseAdditionalNumber").length > 1){
    _this.parent().parent().remove()
  }
}
function removeEmbassy(id) {
  // e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url: `${amadeusPath}ajax`,
      data:  JSON.stringify({
        className: 'embassies',
        method: 'removeEmbassy',
        id: id,
      }),
      type: 'POST',
      dataType: 'JSON',
      success: function(response) {
        if (response.success === true) {
          $.toast({
            heading: 'حذف سفارت خانه',
            text: response.message,
            position: 'top-right',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
        } else {
          $.toast({
            heading: 'حذف سفارت خانه',
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
}