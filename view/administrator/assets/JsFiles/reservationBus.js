$(document).ready(function () {})
function submitUpdateReservationBus(_this, form_tag) {
   let has_error = false
   let has_error_content = ""
   form_tag.find('[data-action="required"]').each(function () {
      if ($(this).val() === "") {
         has_error = true
         has_error_content +=
           "<span class='badge badge-inverse p-3 m-2'>" +
           $(this).parent().find("label").html() +
           "</span>"
      }
   })

   if (has_error) {
      $.alert({
         title: "اطلاعات ناقص است",
         icon: "fa fa-field",
         content: has_error_content,
         rtl: true,
         closeIcon: true,
         type: "orange",
      })
      return false
   } else {
      let form_data = {}



      $.each(form_tag.serializeArray(), function() {
         form_data[this.name] = this.value
      })


      $.ajax({
         type: "POST",
         url: amadeusPath + "ajax",
         data: JSON.stringify({
            className: "busPanel",
            method: "updateReservationBus",
            params: form_data,
            to_json: true,
         }),
         success: function (data) {
            if (data) {


               $.toast({
                  heading: "ویرایش شد",
                  position: "top-right",
                  icon: "success",
                  hideAfter: 3500,
                  textAlign: "right",
                  stack: 6,
               })
            }
         },
      })
   }
}


function submitNewReservationBus(_this, form_tag) {
   let has_error = false
   let has_error_content = ""
   form_tag.find('[data-action="required"]').each(function () {
      if ($(this).val() === "") {
         has_error = true
         has_error_content +=
            "<span class='badge badge-inverse p-3 m-2'>" +
            $(this).parent().find("label").html() +
            "</span>"
      }
   })

   if (has_error) {
      $.alert({
         title: "اطلاعات ناقص است",
         icon: "fa fa-field",
         content: has_error_content,
         rtl: true,
         closeIcon: true,
         type: "orange",
      })
      return false
   } else {
      let form_data = {}



      $.each(form_tag.serializeArray(), function() {
         form_data[this.name] = this.value
      })


       $.ajax({
         type: "POST",
         url: amadeusPath + "ajax",
         data: JSON.stringify({
            className: "busPanel",
            method: "newReservationBus",
            params: form_data,
            to_json: true,
         }),
         success: function (data) {
            if (data) {


               $.toast({
                  heading: "ثبت شد",
                  position: "top-right",
                  icon: "success",
                  hideAfter: 3500,
                  textAlign: "right",
                  stack: 6,
               })
            }
         },
      })
   }
}

function loadingToggle(_this, status = true) {
   let loading_target = _this

   let loading_title = loading_target.attr("data-loading-title")
   let loading_inner_html = loading_target.html()

   if (status) {
      loading_target.addClass("skeleton").prop("disabled", true)
      if (loading_target.is("[data-loading-title]")) {
         loading_target.attr("data-last-loading-title", loading_inner_html)
         loading_target.html(loading_title)
      }
   } else {
      loading_target.removeClass("skeleton").prop("disabled", false)
      if (loading_target.is("[data-last-loading-title]")) {
         loading_target.html(loading_target.attr("data-last-loading-title"))
      }
   }
}

function adminEditStation(_this, id) {
   loadingToggle(_this)
   const target = _this.parent().parent().find('[data-name="station_name"]')
   target.html(
      "<input onfocusout='adminUpdateStation($(this),\"" +
         id +
         "\",$(this).val())' value='" +
         target.html() +
         "' />"
   )
}

function adminDeleteStation(_this, id) {
   loadingToggle(_this)

   $.alert({
      title: "حذف شود ؟",
      icon: "fa fa-shopping-cart",
      content: "با حذف این پایانه، اتوبوس های این پایانه نمایش داده نخواهد شد.",
      rtl: true,
      closeIcon: true,
      type: "red",
      buttons: {
         confirm: {
            text: "بله حذف شود",
            btnClass: "btn-red",
            action: function () {
               $.ajax({
                  type: "POST",
                  url: amadeusPath + "ajax",
                  data: JSON.stringify({
                     className: "busPanel",
                     method: "removeStation",
                     id: id,
                  }),
                  success: function (data) {
                     if (data) {
                        window.location.reload()

                        $.toast({
                           heading: "حذف شد",
                           position: "top-right",
                           icon: "success",
                           hideAfter: 3500,
                           textAlign: "right",
                           stack: 6,
                        })
                     }
                  },
               })
            },
         },
         cancel: {
            text: "انصراف",
            btnClass: "btn-dark",
            action: function () {
               loadingToggle(_this, false)
            },
         },
      },
   })
}

function adminDeleteReservationBus(_this, id) {
   loadingToggle(_this)

   $.alert({
      title: "حذف شود ؟",
      icon: "fa fa-shopping-cart",
      content: "آیا شما مطمئن هستید ؟",
      rtl: true,
      closeIcon: true,
      type: "red",
      buttons: {
         confirm: {
            text: "بله حذف شود",
            btnClass: "btn-red",
            action: function () {
               $.ajax({
                  type: "POST",
                  url: amadeusPath + "ajax",
                  data: JSON.stringify({
                     className: "busPanel",
                     method: "deleteReservationBus",
                     id: id,
                  }),
                  success: function (data) {
                     if (data) {
                        window.location.reload()

                        $.toast({
                           heading: "حذف شد",
                           position: "top-right",
                           icon: "success",
                           hideAfter: 3500,
                           textAlign: "right",
                           stack: 6,
                        })
                     }
                  },
               })
            },
         },
         cancel: {
            text: "انصراف",
            btnClass: "btn-dark",
            action: function () {
               loadingToggle(_this, false)
            },
         },
      },
   })
}

function adminUpdateStation(_this, id, name) {
   loadingToggle(_this)
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      data: JSON.stringify({
         className: "busPanel",
         method: "updateStation",
         id: id,
         name: name,
      }),
      success: function (data) {
         if (data) {
            window.location.reload()

            $.toast({
               heading: "ویرایش شد",
               position: "top-right",
               icon: "success",
               hideAfter: 3500,
               textAlign: "right",
               stack: 6,
            })
         }
      },
   })
}

function adminAddStation(_this, city_id, name) {
   loadingToggle(_this)
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      data: JSON.stringify({
         className: "busPanel",
         method: "createNewStation",
         city_id: city_id,
         name: name,
      }),
      success: function (data) {
         if (data) {
            window.location.reload()

            $.toast({
               heading: "خیره شد",
               position: "top-right",
               icon: "success",
               hideAfter: 3500,
               textAlign: "right",
               stack: 6,
            })
         }
      },
   })

   /*$.post(amadeusPath + 'ajax',
{
Controller: "busPanel",
Method: "createNewStation",
city_id: city_id,
name: name,
},
function (data) {



})
*/
}

function getStations(city_id, target_combobox) {
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      data: JSON.stringify({
         className: "busPanel",
         method: "getStations",
         city_id: city_id,
         to_json: true,
      }),
      success: function (data) {
         if (data.status === "success") {
            let options = '<option value="">انتخاب کنید....</option>'
            data.data.forEach(function (item) {
               options +=
                  '<option value="' +
                  item.id +
                  '">' +
                  item.station_name +
                  "</option>"
            })
            target_combobox.html(options)
            target_combobox.select2("destroy")
            target_combobox.select2()
         }
      },
   })
}

function AddExtraStationData() {
   var CountDiv = $('div[data-target="BaseExtraStationDataDiv"]').length
   var BaseDiv = $('div[data-target="BaseExtraStationDataDiv"]:last-child')
   var CloneBaseDiv = $(
      'div[data-target="BaseExtraStationDataDiv"]:last-child'
   ).clone()
   var CountDivInEach = 0

   CloneBaseDiv.find("input").val("")
   $('div[data-target="BaseExtraStationDataDiv"]:last-child').after(
      CloneBaseDiv
   )

   $(
      '.DynamicExtraStationData input[data-parent="ExtraStationDataValues"]'
   ).each(function () {
      $(this).attr(
         "name",
         "ExtraStationData[" +
            CountDivInEach +
            "][" +
            $(this).attr("data-target") +
            "]"
      )
      if ($(this).attr("data-target") == "body") {
         CountDivInEach = CountDivInEach + 1
      }
   })
}

function RemoveExtraStationData(thiss) {
   if (
      thiss
         .parent()
         .parent()
         .parent()
         .parent()
         .find('div[data-target="BaseExtraStationDataDiv"]').length > 1
   ) {
      thiss.parent().parent().parent().remove()

      var CountDivInEach = 0
      $(
         '.DynamicExtraStationData input[data-parent="ExtraStationDataValues"]'
      ).each(function () {
         $(this).attr(
            "name",
            "ExtraStationData[" +
               CountDivInEach +
               "][" +
               $(this).attr("data-target") +
               "]"
         )
         if ($(this).attr("data-target") == "body") {
            CountDivInEach = CountDivInEach + 1
         }
      })
   }
}
