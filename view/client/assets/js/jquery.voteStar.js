

(function($){

  $.fn.extend({

    voteStar: function(options){

        var star = this;

        var defaults = {
            moveStar: false,                            
            starLength: 5,                              
            precise: false,                             
            starAnimate: true,                         
            callback: null                            
        }

        var o = $.extend(defaults, options || {});    

        if(o.moveStar){
            star.on('mousemove', function(event) {
              setStarWidth(event, $(this));
            });
            star.on('mouseleave', function(event) {
              var that = $(this);
                  rateValObj = that.siblings('input[type=text]'),
                  aStar_width = that.width() / o.starLength;
              if(!that.data('isSave')){
                that.find('i').width(0);
              }else{
                that.find('i').width(that.data('isSave') * aStar_width);
              }
            });
        }

        star.on('click', function(event) {

          if(o.starAnimate){
              $.each(star, function(index, ele) {
                  $(ele).addClass('star_animate');
              });
          }
          setStarWidth(event, $(this), true);
        });

        function setStarWidth(event, starObj, saveStar){
            var lightStar_width = event.pageX - starObj.offset().left,
                aStar_width = starObj.width() / o.starLength,
                starNum = o.precise ? lightStar_width/aStar_width : Math.ceil(lightStar_width/aStar_width);

            starObj.find('i').width(aStar_width * starNum);   
            if(saveStar){
              starObj.data('isSave', starNum);
              if(o.callback && typeof o.callback === 'function'){
                  o.callback(starObj, starNum);
              }
            }    
        }
    }    
  })


})(jQuery);

