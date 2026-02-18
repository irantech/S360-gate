function useXmltag(tagname) {

  // let get_translate = localStorage.getItem('translate_'+lang) ;

  result=xmlDoc.getElementsByTagName(tagname)[0];

  return result!=undefined ? result.childNodes[0].nodeValue : " ";

}
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });

  $('#add_uploads').validate({
    rules: {
      // file: 'required',
    },
    messages: {
      file: {
        required: "آپلود یک فایل الزامیست"
      },
    },
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
        // mimeType: "multipart/form-data",
        // contentType: false,
        // processData: false,
        success: function(response) {
          // console.log(response);
          let displayIcon
          if (response.success === true) {
            displayIcon = 'success'
          } else {
            displayIcon = 'error'
          }

          $.toast({
            heading: 'آپلود فایل',
            text: response.message,
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          if (response.success === true) {
            setTimeout(function() {
              // location.reload()
              $('#uploadButton').html('لطفا صبر کنید...');
              document.getElementById("uploadButton").disabled=true;
            }, 200)
            setTimeout(function() {
              // location.reload()
              window.location = `${amadeusPath}itadmin/uploadFiles/list`;
            }, 2000)
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


  $('#delete_uploads').validate({
    rules: {
      // file: 'required',
    },
    messages: {

    },
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
        // mimeType: "multipart/form-data",
        // contentType: false,
        // processData: false,
        success: function(response) {
          // console.log(response);
          let displayIcon
          if (response.success === true) {
            displayIcon = 'success'
          } else {
            displayIcon = 'error'
          }

          $.toast({
            heading: 'آپلود فایل',
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
              // window.location = `${amadeusPath}itadmin/articles/list`;
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
})


function deleteUpload(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'uploadFiles',
      method: 'deleteUpload',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف وضعیت فایل',
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
        heading: 'حذف وضعیت فایل',
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
        // window.location = `${amadeusPath}itadmin/uploadFiles/list`;
      }, 1000)
    },
  });
}

$(document).on('click', '.deleteUpload', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteUpload(id)
  }
})


function deleteItem() {
  if (confirm('آیا از حذف موارد انتخاب شده مطمئن هستید ؟')) {
    $('#delete_uploads').validate({
      rules: {},
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
          type: 'post',
          success: function(response) {
            // console.log(response);

            let displayIcon
            let displayTitle
            if (response.success === true) {
              displayIcon = 'success'
              displayTitle = 'انجام شد'
            } else {
              displayIcon = 'error'
              displayTitle = 'عملیات با خطا مواجه شد'
            }

            $.toast({
              heading: displayTitle,
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
                window.location = `${amadeusPath}itadmin/uploadFiles/list`;
              }, 500)
            }
          },
        })
      },
    });
  }

}

function dropHandlerUpload(ev,selected=false ,  hasAlt = false) {
  let fileInput = document.getElementById('gallery_files');
  if( !$('#gallery_files_temporary').length){
    $('#gallery_files').after('<input type="file" class="d-none" id="gallery_files_temporary"/>')
  }

  let temporaryFileInput = document.getElementById('gallery_files_temporary');

  ev.preventDefault();
  var html_tags = '';

  if (ev.dataTransfer && ev.dataTransfer.items) {

    const dt = new DataTransfer();
    [...ev.dataTransfer.items].forEach(async (item, i) => {
      console.log('i ',i )

      if (item.kind === 'file') {
        const file = item.getAsFile();
        if(file.size > 200000){
          $.alert({
            title: 'غیر قابل آپلود',
            icon: 'fa fa-cancle',
            content: 'حجم فایل نباید بیشتر از 2 مگابایت باشد.',
            rtl: true,
            type: 'red'
          });
        }else{


          dt.items.add(file)
          var reader = new FileReader();
          await reader.readAsDataURL(file);
          reader.onload = function() {

            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(file.name)[1];
            if( ext == 'jpg' || ext == 'gif' || ext == 'png' || ext == 'tif' || ext == 'jpeg' || ext == 'webp') {
              var img_url = reader.result ;
            }else {
              var img_url = `${amadeusPath}/pic/ext-icons/${ext}.png` ;

            }

            var tags="<div class=\"align-items-center flex-wrap dropzone-parent-box  d-flex justify-content-between p-3 pip rounded-xl w-100 \" xmlns='http://www.w3.org/1999/html'>" +
              "<img class=\"border d-flex imageThumb rounded-xl w-25\" src=\"" + img_url + "\" title=\"" + file.name + "\"/>" +
              "<div class='dropzone-parent-trash-shakkhes'>" +
              "<button type='button' class='dropzone-btn-trash' onclick='removeFromGallery($(this))' data-index='" + i + "' class=\"remove text-danger\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i> حذف</button>" +
              "<div class='dropzone-radio-shakhes'>";




            if(selected){
              tags=tags+
                "<label for='gallery_selected" + i + "'>" +
                "تنظیم بعنوان شاخص" +
                "</label>" +
                "<input onchange='setAsSelectedGallery(\"" + reader.result + "\")' name='gallery_selected' id='gallery_selected" + i + "' value='" + i + "' type='radio'/>";
            }

            tags=tags+"</div>"+
              "</div>";

            if(hasAlt) {
              tags=tags+
                "<div class='d-flex w-100 flex-wrap mt-3'>" +
                "<label for='gallery_file_alts[" + i + "]'>" +
                "alt" +
                "</label>" +
                "<input placeholder='alt' name='gallery_file_alts[" + i + "]' value='" + file.name + "' class='pb-2 small text-center form-control text-muted w-100 rounded'/>";
            }else{
              tags=tags+
                "<div class='d-flex w-100 flex-wrap mt-3'>" +
                "<p>" + file.name + "</p>"
            }
            tags=tags+
              "</div>" +
              "</div>";

            return $("#preview-gallery").append(tags);

          }
        }
      }
    });
    [...fileInput.files].forEach(item => {
      dt.items.add(item)
    })
    fileInput.files = dt.files;
    temporaryFileInput.files = dt.files;


  } else {
    let dt = new DataTransfer();
    let files=[...fileInput.files];


    if(files.length>0){
      [...temporaryFileInput.files].forEach(item => {
        dt.items.add(item)
      })
    }





    [...fileInput.files].forEach(async (file, i) => {
      var re = /(?:\.([^.]+))?$/;
      var ext = re.exec(file.name)[1];
      // alert(file.name)
      // alert(ext)
      if( ext == 'sql' || ext == 'zip' || ext == 'xlsx' || ext == 'xls') {
        $.alert({
          title: 'غیر قابل آپلود',
          icon: 'fa fa-cancle',
          content: 'پسوند فایل آپلود شده مجاز نمی باشد',
          rtl: true,
          type: 'red'
        });
      } else{
        if( ext == 'apk' ) {
          $sizeNew = '5000000';
        }else{
          $sizeNew = '2000000';
        }
        if(file.size > $sizeNew){
          $.alert({
            title: 'غیر قابل آپلود',
            icon: 'fa fa-cancle',
            content: 'حجم فایل نباید بیشتر از 2 مگابایت باشد.',
            rtl: true,
            type: 'red'
          });
        }else{
          dt.items.add(file)
          var reader = null;
          reader = new FileReader();
          await reader.readAsDataURL(file);
          reader.onload = function() {

            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(file.name)[1];
            if( ext == 'jpg' || ext == 'gif' || ext == 'png' || ext == 'tif' || ext == 'jpeg') {
              var img_url = reader.result ;
            }else {
              var img_url = `${amadeusPath}/pic/ext-icons/${ext}.png` ;

            }
            var tags="<div class=\"align-items-center flex-wrap dropzone-parent-box  d-flex justify-content-between p-3 pip rounded-xl w-100 \" xmlns='http://www.w3.org/1999/html'>" +
              "<img class=\"border d-flex imageThumb rounded-xl w-25\" src=\"" + img_url + "\" title=\"" + file.name + "\"/>" +
              "<div class='dropzone-parent-trash-shakkhes'>" +
              "<button type='button' class='dropzone-btn-trash' onclick='removeFromGallery($(this))' data-index='" + i + "' class=\"remove text-danger\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i> حذف</button>" +
              "<div class='dropzone-radio-shakhes'>";

            if(selected){
              tags=tags+
                "<label for='gallery_selected" + i + "'>" +
                "تنظیم بعنوان شاخص" +
                "</label>" +
                "<input onchange='setAsSelectedGallery(\"" + reader.result + "\")' name='gallery_selected' id='gallery_selected" + i + "' value='" + i + "' type='radio'/>";
            }

            if(hasAlt) {
              tags=tags+
                "<div class='d-flex w-100 flex-wrap mt-3'>" +
                "<label for='gallery_file_alts[" + i + "]'>" +
                "alt" +
                "</label>" +
                "<input placeholder='alt' name='gallery_file_alts[" + i + "]' value='" + file.name + "' class='pb-2 small text-center form-control text-muted w-100 rounded'/>";
            }else{
              tags=tags+
                "<div class='d-flex w-100 flex-wrap mt-3'>" +
                "<p>" + file.name + "</p>"
            }
            tags=tags+
              "</div>" +
              "</div>";
            return $("#preview-gallery").append(tags);

          }
        }
      }
    })
    fileInput.files = dt.files;
    temporaryFileInput.files = dt.files;

  }

}

function dragOverHandlerUpload(ev) {


  // Prevent default behavior (Prevent file from being opened)
  ev.preventDefault();
}
