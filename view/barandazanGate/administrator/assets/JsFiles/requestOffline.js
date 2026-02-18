$(document).ready(function() {
  let deleteRequestOffline = function(id) {
    $.ajax({
      url: `${amadeusPath}user_ajax.php`,
      data: {
        flag: 'deleteRequestOffline',
        id: id,
      },
      type: 'POST',
      dataType: 'JSON',
      success: function(response) {
        if (response.success === true) {
          $.toast({
            heading: 'حذف مطلب',
            text: response.message,
            position: 'top-right',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
        } else {
          $.toast({
            heading: 'حذف مطلب',
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
  $(document).on('click', '.deleteRequestOffline', function(e) {
    e.preventDefault()
    if (confirm('آیا مطمئن هستید ؟')) {
      let id = $(this).data('id')
      deleteRequestOffline(id)
    }
  })
})

function requestOfflineSelectedToggle(_this, request_id) {
  $.ajax({
    url: `${amadeusPath}ajax`,
    data: JSON.stringify({
      method: 'requestOfflineSelectedToggle',
      className: 'requestOffline',
      request_id: request_id,
    }),
    type: 'POST',
    dataType: 'JSON',
    success: function(response) {
      if (response.success === true) {
        $.toast({
          heading: 'ویرایش درخواست',
          text: response.message,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
        _this.find('span').html('خوانده شده')

      } else {
        $.toast({
          heading: 'ویرایش درخواست',
          text: response.message,
          position: 'top-right',
          icon: 'error',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
      }
    },
    complete: function() {
      setTimeout(function() {
        location.reload()
      }, 1000)
    },
  })
}

function ModalRequestOffline(request_data , full_name , mobile , description ) {
  let request_info = '' ;
  let info = '' ;
  $.each( request_data, function(key, value){
    request_info += '<div class="col-md-4 py-4">'+
    '<span>'+ value['key'][0] + ': </span><span>'+value['value']+'</span>'+
    '</div>'
  })

  if(description) {
    info += '<div class="col-md-12 py-4">'+
      '<span>توضیحات: </span><span>'+description+'</span></div>'
  }

  $('#ModalPublic').html(
'<div class="modal-dialog modal-lg">'+
    '<div class="modal-content">'+
        '<div class="modal-header site-bg-main-color">' +
            '<button type="button" class="close" data-dismiss="modal">×</button>'+
            '<h4 class="modal-title"> مشاهده اطلاعات درخواست شده </h4>'+
      '</div>'+
        '<div class="modal-body">'+
            '<div class="row margin-both-vertical-20">'+
    '<div class="col-md-6 py-4">'+
    '<span>نام و نام خانوادگی: </span><span>'+full_name+'</span>'+
    '</div>'+
    '<div class="col-md-6 py-4">'+
    '<span>موبایل: </span><span>'+mobile+'</span>'+
    '</div>'+
    '' + info + '' +
    '<hr style="border : 1px solid #eee;">'+
    '' + request_info + '' +
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>');
}


function useXmltag(tagname) {

  // let get_translate = localStorage.getItem('translate_'+lang) ;
  xmlDoc=loadXMLDoc(rootMainPath+"/gds/langs/"+lang+"_frontMaster.xml");
  result=xmlDoc.getElementsByTagName(tagname)[0];

  return result!=undefined ? result.childNodes[0].nodeValue : " ";

}

function loadXMLDoc(filename) {

  xhttp=new XMLHttpRequest();
  xhttp.open("GET",filename,false);
  xhttp.send();
  return xhttp.responseXML;
}