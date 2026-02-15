





let btnDay = document.querySelectorAll(".btn-day");


btnDay.forEach(item =>{
  item.addEventListener("click", function (){
    item.classList.toggle("toggle-bg");
  })
})

$(document).ready(function(){

  $("body").delegate(".delete-item", "click", function () {
    $(this).closest('.parent-form-job,.parent-form-professional,.parent-form-education,.parent-form-language').remove();
  });


  $(document).on('click','.plus3',function(){
    clone =$(this).closest('.duplicate-form-item').find('.duplicate-lang3').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-lang3');
    $('.duplicate-form-item').append(clone);
    clone.find('div.drop_zone-new-parent-gallery'). attr('id', 'preview-gallery');
    clone.find(".minus3").last().after('<a class="min3" href="javascript:void(0)"> <i class="delete-item">\n' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></i></a>');
  });





  $('#addDocumentUser').validate({

    errorElement: 'em',
    submitHandler: function(form) {
      //tinyMCE.triggerSave();
      $.post(amadeusPath + 'captcha/securimage_check.php',
        {
          captchaAjax: $('#item-captcha').val()
        },
        function (data) {
          // console.log(data)

            reloadCaptcha();
            $(form).ajaxSubmit({
              url: amadeusPath + 'ajax',
              type: 'POST',
              success: function (response) {

                if (response.success === true) {
                  var statusType = 'green';
                } else {
                  var statusType = 'red';
                }

                $.alert({
                  title: useXmltag("Documents"),
                  icon: 'fa fa-refresh',
                  content: response.message,
                  rtl: true,
                  type: statusType
                });
                if (response.success === true) {

                  $('.form-empty').val('');
                  $('#preview-gallery').empty();;
                }
              }

            })
        });

    },

  })

});


