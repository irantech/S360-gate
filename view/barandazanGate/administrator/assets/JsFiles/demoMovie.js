if (client_id == 149){
  $(document).ready(function() {
    let modal_video = $('.modal_video')
    let close_modal_video = $('.close_modal_video')
    let myCookie = getCookie('modal_video')
    let btn_show_modal = $(".btn_show_modal")
    let modal_video_main_button = $(".modal_video_main > button")

    modal_video.hide()
    btn_show_modal.addClass("d-none")
    btn_show_modal.removeClass("d-flex")
    $('.modal_video_after').hide()
    setTimeout(function() {
      modal_video.show()
      $('.modal_video_after').fadeIn(2000)
    }, 1000)




    if (myCookie == null) {
      btn_show_modal.addClass("d-none")
      btn_show_modal.removeClass("d-flex")
      setCookie('modal_video', true, 1)
      modal_video.removeClass('modal_video_active')
      modal_video_main_button.attr("disabled" , "disabled")
      setTimeout(function() {
        modal_video_main_button.addClass("modal_video_main_button_anim")
      }, 500)
      setTimeout(function() {
        modal_video_main_button.removeClass("modal_video_main_button_anim")
        modal_video_main_button.removeAttr("disabled")
      }, 5000)

    } else {
      modal_video.addClass('modal_video_active')
      btn_show_modal.addClass("d-flex")
      btn_show_modal.removeClass("d-none")
    }
    close_modal_video.on('click', function() {
      modal_video.addClass('modal_video_active')
      btn_show_modal.addClass("d-flex")
      btn_show_modal.removeClass("d-none")
      btn_show_modal.addClass("animation_btn_show_modal")
      setTimeout(function() {
        btn_show_modal.removeClass("animation_btn_show_modal")
      }, 1000)
      $.cookie('test', 1, {expires: 10})
      })
    btn_show_modal.on('click', function(){
      btn_show_modal.addClass("d-none")
      btn_show_modal.removeClass("d-flex")
      setCookie('modal_video', true, 1)
      modal_video.removeClass('modal_video_active')
    })


    function setCookie(name, value, days) {
      var expires = ''
      if (days) {
        var now = new Date()
        var time = now.getTime()
        time += 3600 * 1000
        now.setTime(time)
        expires = '; expires=' + now.toUTCString()
      }
      document.cookie = name + '=' + (value || '') + expires + '; path=/'
    }
    function getCookie(name) {
      var nameEQ = name + '='
      var ca = document.cookie.split(';')
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i]
        while (c.charAt(0) == ' ') c = c.substring(1, c.length)
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length)
      }
      return null
    }


  })

}