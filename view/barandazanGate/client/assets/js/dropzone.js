function dragOverHandler(ev) {
  // Prevent default behavior (Prevent file from being opened)
  ev.preventDefault();
}

async function dropHandler(ev,selected=false , hasAlt = false) {
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

      if (item.kind === 'file') {
        const file = item.getAsFile();
        if(file.size > 1000000){
          $.alert({
            title: 'غیر قابل آپلود',
            icon: 'fa fa-cancle',
            content: 'حجم عکس نباید بیشتر از 1 مگابایت باشد.',
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
            if( ext == 'jpg' || ext == 'gif' || ext == 'png' || ext == 'tif' || ext == 'jpeg') {
              var img_url = reader.result ;
            }else {
              var img_url = `${amadeusPath}/pic/ext-icons/${ext}.png` ;

            }


            let tags="<div class=\"align-items-center flex-wrap  d-flex justify-content-between p-3 pip rounded-xl w-100 drop_zone-new-item-gallery \" xmlns='http://www.w3.org/1999/html'>" +
              "<img class=\"border d-flex imageThumb rounded-xl w-100 drop_zone-new-item-gallery-img\" src=\"" + img_url + "\" title=\"" + file.name + "\"/>" +
              "<span onclick='removeFromGallery($(this))' data-index='" + i + "' class=\"remove text-danger drop_zone-new-item-gallery-remove\">حذف</span>" ;
            if(hasAlt) {
              tags=tags+
                "<div class='d-flex w-100 flex-wrap mt-3'>" +
                "<label for='gallery_file_alts[" + i + "]'>" +
                "alt" +
                "</label>" +
                "<input placeholder='alt' name='gallery_file_alts[" + i + "]' value='" + file.name + "' class='pb-2 small text-center form-control text-muted w-100 rounded'/>";

            }else{
              tags=tags+
                "<div class=''>" +
                "<p>'" + file.name + "'</p>"
            }

            if(selected){
              tags=tags+
                "<label for='gallery_selected" + i + "'>" +
                "شاخص" +
                "</label>" +
                "<input onchange='setAsSelectedGallery(\"" + reader.result + "\")' name='gallery_selected' id='gallery_selected" + i + "' value='" + i + "' type='radio'/>";
            }
            tags=tags+
              "</div>" +
              "</div>";
          return $("#preview-gallery").append(tags);
        }

      }
    }
    [...fileInput.files].forEach(item => {
      dt.items.add(item)
    })
    fileInput.files = dt.files;
    temporaryFileInput.files = dt.files;


    })

  } else {
    let dt = new DataTransfer();
    let files=[...fileInput.files];

    if(files.length>0){
    [...temporaryFileInput.files].forEach(item => {
      dt.items.add(item)
    })
    }






    [...fileInput.files].forEach(async (file, i) => {
      if(file.size > 1000000){
        $.alert({
          title: 'غیر قابل آپلود',
          icon: 'fa fa-cancle',
          content: 'حجم عکس نباید بیشتر از 1 مگابایت باشد.',
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
        let tags="<div class=\"align-items-center flex-wrap  d-flex justify-content-between p-3 pip rounded-xl w-100 drop_zone-new-item-gallery \" xmlns='http://www.w3.org/1999/html'>" +
          "<img class=\"border d-flex imageThumb rounded-xl w-100 drop_zone-new-item-gallery-img\" src=\"" + img_url + "\" title=\"" + file.name + "\"/>" +
          "<span onclick='removeFromGallery($(this))' data-index='" + i + "' class=\"remove text-danger drop_zone-new-item-gallery-remove\">حذف</span>" ;
        if(hasAlt) {
          tags=tags+
          "<div class='d-flex w-100 flex-wrap mt-3'>" +
          "<label for='gallery_file_alts[" + i + "]'>" +
          "alt" +
          "</label>" +
          "<input placeholder='alt' name='gallery_file_alts[" + i + "]' value='" + file.name + "' class='pb-2 small text-center form-control text-muted w-100 rounded'/>";

        }else{
          tags=tags+
            "<div class=''>" +
            "<p>'" + file.name + "'</p>"
        }

        if(selected){
          tags=tags+
            "<label for='gallery_selected" + i + "'>" +
            "شاخص" +
            "</label>" +
            "<input onchange='setAsSelectedGallery(\"" + reader.result + "\")' name='gallery_selected' id='gallery_selected" + i + "' value='" + i + "' type='radio'/>";
        }
        tags=tags+
          "</div>" +
          "</div>";

        return $("#preview-gallery").append(tags);

        }
      }
    })
    fileInput.files = dt.files;
    temporaryFileInput.files = dt.files;

  }

}
function setAsSelectedGallery(src) {
  $('.selected_image').find('.dropify-render img')
    .attr('src', src)
}
async function removeFromGallery(_this) {
  _this.parent(".pip").remove();
  const index_image=_this.data('index')
  let fileInput = document.getElementById('gallery_files');
  let temporaryFileInput = document.getElementById('gallery_files_temporary');

  let html_tags = []
  const dt = new DataTransfer();
  [...fileInput.files].forEach( async (file,i)=>{
    console.log('index_image',index_image)
    console.log('i',i)
    if (index_image !== i) {

      console.log('file',file)

      var reader = new FileReader();
      await reader.readAsDataURL(file);
      // $('#preview-gallery').html('');
      reader.onload = function(){



        let counter=0;
        var testimonials = document.querySelectorAll("div.pip")
        Array.prototype.forEach.call(testimonials, function (element, index) {
          var div1 = element.querySelectorAll("span")
          if (div1.length) {
            div1[0].setAttribute("data-index", counter)
          }
          counter=counter+1;
        })


        dt.items.add(file)
      }

    }
  })

  fileInput.files = dt.files;
  temporaryFileInput.files = dt.files;

}