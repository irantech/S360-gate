function clickNext() {
  let a = $(".parent-js-question>div.active")
  $(".parent-js-question>div.active").removeClass("active")
  a.next().addClass('active')
  if (a.attr('id') == $(".parent-js-question>div").length -1){
    $(".btn-form-next").hide()
    $(".btn-form-submit").show()
    $(".voteCapcha").show()
  }
  $(".btn-form-back").show()
}
function clickBack(){
  let a = $(".parent-js-question>div.active")
  $(".parent-js-question>div.active").removeClass("active")
  a.prev().addClass('active')
  $(".btn-form-next").show()
  $(".btn-form-submit").hide()
  $(".voteCapcha").hide()
  if (a.attr('id') == 2){
    $(".btn-form-next").show()
    $(".btn-form-back").hide()
  }
}




function onclick(event) {
  reloadCaptcha();
  return false
}

$("#insert_answer_vote").validate({
  rules: {
    'vote-captcha': {
      required: true,
      //   minlength: 4,
      maxlength: 5
    }
  },
  messages:{
    'vote-captcha': {
      'required': useXmltag("Entersecuritycode"),
      'maxlength': useXmltag('WrongSecurityCode')
    }
  },


  submitHandler: function (form) {
    $("#voteButton").html(useXmltag('Pleasewait'));
    $('#voteButton').prop('disabled', true);
    $.post(amadeusPath + 'captcha/securimage_check.php',
      {
        captchaAjax: $('#vote-captcha').val()
      },
      function (data) {
        // console.log(data)
        if (data == true) {
          reloadCaptcha();

    $(form).ajaxSubmit({
      type: 'POST',
      url: amadeusPath + 'user_ajax.php',
      success: function (response) {

        var res = response.split(':');

        if (response.indexOf('success') > -1) {
          var statusType = 'green';
        } else {
          var statusType = 'red';
        }

        $.alert({
          title: useXmltag("SendVoteAnswer"),
          icon: 'fa fa-check',
          content: res[1],
          rtl: true,
          type: statusType
        });

        if (response.indexOf('success') > -1) {
          $('.reason').val('');
          $('.capchaFara').val('');
          setTimeout(function () {
            window.location = 'vote';
          }, 3000);
        }

      }
    });
        } else {
          reloadCaptcha();
          $.alert({
            title: useXmltag("SendVoteAnswer"),
            icon: 'fa fa-warning',
            content: useXmltag("WrongSecurityCode"),
            rtl: true,
            type: 'red'
          });
          return false;
        }
      });

  },

});