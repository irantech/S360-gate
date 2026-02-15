$(document).ready(function () {
   $("#submit_new_comment").validate({

      rules: {
         comment_body: "required",
         comment_name: "required",
         // comment_email: {
         //    required: true,
         //    email: true
         // },
         comment_mobile: {
            required: true,
            phone: true,
            maxlength: 11
         },
      },
      messages: {
         // 'comment_email': {
         //    'email': useXmltag("Invalidemail"),
         //    'maxlength': useXmltag("Emaillong")
         // },
         'comment_mobile': {
            'required': useXmltag("PleaseenterPhoneNumber"),
            'phone': useXmltag("PhoneNumberError"),
            'maxlength': useXmltag("LongPhoneNumberError")
         },
      },
      // errorElement: "em",
      // errorPlacement: function (error, element) {
      //    // Add the `help-block` class to the error element
      //    error.addClass("help-block")
      // },
      submitHandler: function (form) {
         loadingToggle($('#submit_new_comment button[type="submit"]'))
         $(form).ajaxSubmit({
            type: "POST",
            url: amadeusPath + "ajax",
            dataType: "JSON",
            success: function (data) {
               loadingToggle(
                  $('#submit_new_comment button[type="submit"]'),
                  false
               )
               if (data.success) {
                  fireToast(true, data.message.message, data.message.title)
                  $('#area').val('');
                  // $('#comment_name').val('');
                  // $('#comment_email').val('');
               } else {
                  fireToast(false, data.message.message, data.message.title)
               }
            },
         })
      },
      highlight: function (element, errorClass, validClass) {
         $(element)
            .parents(".form-group ")
            .addClass("has-error")
            .removeClass("has-success")
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element)
            .parents(".form-group ")
            .addClass("has-success")
            .removeClass("has-error")
      },
   })
})

function goto(elementId) {
   // Check if the element exists
   const element = $("#" + elementId);
   if (element.length) {
      // Animate scrolling to the element
      $('html, body').animate({
         scrollTop: element.offset().top
      }, 1000); // Duration of scrolling in milliseconds (1 second)
   }
}


function commentReplay(comment_id = 0) {
   const cancel_replay = $('[data-name="cancel_replay"]')
   const new_comment_parent = $("#submit_new_comment")
   const new_comment_parent_title = new_comment_parent.find(
      "[data-name='title']"
   )
   $('input[name="parent_id"]').val(comment_id)
   if (comment_id !== 0) {
      cancel_replay.removeClass("d-none")
      const parent_comment = $("[data-name='comment-" + comment_id + "']")
      new_comment_parent_title.html(
        useXmltag("SubmitNewReplyFor") + parent_comment.find("[data-name='name']").text()
      )
      goto("submit_new_comment")
   } else {
      cancel_replay.addClass("d-none")
      new_comment_parent_title.html(useXmltag("commentText"))
   }
}



