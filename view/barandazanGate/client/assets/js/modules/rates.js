function doRate(section,item_id,value){
  $.ajax({
    url: amadeusPath + 'ajax',
    type: 'POST',
    dataType: 'JSON',
    data: JSON.stringify({
      'className' : 'masterRate',
      'method' : 'newRate',
      'section' : section,
      'item_id' : item_id,
      'value' : value,
    }),

    success : function(data){

      if (data.success) {
        fireToast(true, data.message.message, data.message.title)
      } else {
        fireToast(false, data.message.message, data.message.title)
      }

    }

  })
}