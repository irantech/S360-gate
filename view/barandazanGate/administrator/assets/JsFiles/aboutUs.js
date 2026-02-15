$("#aboutUsUpdate").validate({
  rules: {

  },
  messages: {},
  errorElement: "em",
  errorPlacement: function (error, element) {
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if (element.prop("type") === "checkbox") {
      error.insertAfter(element.parent("label"));
    } else {
      error.insertAfter(element);
    }
  },
  submitHandler: function (form) {
    CKEDITOR.instances.body.updateElement();
    CKEDITOR.instances.about_customer_club.updateElement();
    $('.submit-button').prop("disabled", true);
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type:"POST",
      dataType: "json",
      success: function (response) {
        $('.submit-button').prop("disabled", false);

        if (response) {
          $.toast({
            heading: 'اطلاعات درباره ی ما ویرایش شد',
            text: '',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });


        } else {

          $.toast({
            heading: 'تغییری نداده اید!',
            text: '',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'warning',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });

        }


      }
    });
  },
  highlight: function (element, errorClass, validClass) {
    $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
  }


});

function aboutUsLanguage(lang) {
  var langsName = {
    'fa': 'فارسی',
    'en': 'انگلیسی',
    'ar': 'عربی',

  }

  $.toast({
    heading: 'تغییر زبان درباره ما',
    position: 'top-right',
    loaderBg: '#fff',
    icon: 'success',
    hideAfter: 3500,
    textAlign: 'right',
    stack: 6
  });

  setTimeout(function() {
    const url = new URL(window.location.href);
    url.searchParams.set('lang', lang);
    window.location.href = url.href;
  }, 1000);
}


function AddSocialLinks() {


  var CountDiv = $('div[data-target="BaseSocialLinksDiv"]').length
  var BaseDiv = $('div[data-target="BaseSocialLinksDiv"]:last-child')
  var CloneBaseDiv = $('div[data-target="BaseSocialLinksDiv"]:last-child').clone()
  var CountDivInEach = 0

  CloneBaseDiv.find("input").val("")
  $('div[data-target="BaseSocialLinksDiv"]:last-child').after(CloneBaseDiv)

  $('.DynamicSocialLinks select[data-parent="SocialLinksValues"]').each(function () {
    console.log(CountDivInEach)
    $(this).attr(
      "name",
      "socialLinks[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
    )
    CountDivInEach = CountDivInEach + 1
  })
  var CountDivInEach = 0
  $('.DynamicSocialLinks input[data-parent="SocialLinksValues"]').each(function () {
    $(this).attr(
      "name",
      "socialLinks[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
    )
    CountDivInEach = CountDivInEach + 1
  })



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

$(document).on('click', '.deleteImage', function(e) {
  e.preventDefault()
  if (confirm('آیا از حذف تصویر مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteImageAbout(id)
  }
})

function deleteImageAbout(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'aboutUs',
      method: 'deleteImageAbout',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف تصویر درباره ما',
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
        heading: 'حذف تصویر درباره ما',
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

