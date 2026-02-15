
$('#storePersonnel').validate({
  rules: {
    name: 'required',
    position: 'required',
    education: 'required',
    experience: 'required'
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
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type: 'POST',
      success: function(response) {
        console.log(response);
        let displayIcon
        if (response.success === true) {
          displayIcon = 'success'
        } else {
          displayIcon = 'error'
        }

        $.toast({
          heading: 'پرسنل',
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
            // window.location = `${amadeusPath}itadmin/personnel/list`;
          }, 1000)
        }
      },
      error: function(response) {
        console.log(response)

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

$('#editPersonnel').validate({
  rules: {
    name: 'required',
    position: 'required',
    education: 'required',
    experience: 'required'
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
      type: 'POST',
      success: function(response) {
        // console.log(response);
        let displayIcon
        if (response.success === true) {
          displayIcon = 'success'
        } else {
          displayIcon = 'error'
        }

        $.toast({
          heading: 'پرسنل',
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
            // window.location = `${amadeusPath}itadmin/personnel/list`;
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

function removePersonnel(personnel_id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "personnel",
        method: "DeletePersonnel",
        personnel_id: personnel_id,

      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {

          $.toast({
            heading: "حذف پرسنل",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: "حذف پرسنل",
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

          // window.location = `${amadeusPath}itadmin/personnel/list`;
        }, 1000)
      },
    })
  }
}

function AddSocialLinks() {

  var CountDiv = $('div[data-target="BaseSocialLinksDiv"]').length;
  // var BaseDiv = $('div[data-target="BaseSocialLinksDiv"]:last-child');
  var CloneBaseDiv = $('div[data-target="BaseSocialLinksDiv"]:last-child').clone();
  var CountDivInEach = 0

  CloneBaseDiv.find("input").val("");

  $('div[data-target="BaseSocialLinksDiv"]:last-child').after(CloneBaseDiv)

  $('.DynamicSocialLinks select[data-parent="SocialLinksValues"]').each(function () {
    console.log(CountDivInEach)
    $(this).attr(
      "name",
      "socialLinks[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
    )
    CountDivInEach = CountDivInEach + 1
  });

  var CountDivInEach = 0
  $('.DynamicSocialLinks input[data-parent="SocialLinksValues"]').each(function () {
    $(this).attr(
      "name",
      "socialLinks[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
    )
    CountDivInEach = CountDivInEach + 1
  });


}
function RemoveSocialLinks(thiss) {
  if (
    thiss.parent().parent().parent().parent().find('div[data-target="BaseSocialLinksDiv"]').length > 1
  ) {
    thiss.parent().parent().parent().remove()

    var CountDivInEach = 0
    $('.DynamicSocialLinks select[data-parent="SocialLinksValues"]').each(
      function () {
        $(this).attr(
          "name",
          "socialLinks[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
        )
        CountDivInEach = CountDivInEach + 1
      }
    )
    var CountDivInEach = 0
    $('.DynamicSocialLinks input[data-parent="SocialLinksValues"]').each(
      function () {
        $(this).attr("name", "socialLinks[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
        )
        CountDivInEach = CountDivInEach + 1
      }
    )
  }
}