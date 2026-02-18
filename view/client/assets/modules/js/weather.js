$('.owl-weather').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    navText: ["<span class='fas fa-chevron-right'></span>","<span class='fas fa-chevron-left'></span>"],
    nav:true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:6
        }
    }
});


function getNewWeather() {
    let city_name = $('#city_list').val();
    $("#loading").show();  // Show skeleton loader
    $(".parent-weather-selected").hide(); // Hide actual content
    $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
            method: "getCityWeather",
            className: "weather",
            city_name : city_name,
        }),
        success: function (response) {


            $("#loading").hide();
            $(".parent-weather-selected").fadeIn();
            let data_response = JSON.parse(JSON.stringify(response))
            let weather = data_response[0]
            let desc = weather.description.replace(/#/g, "");

            // console.log(weather.list)
            // // console.log(weather)
            //
            // let i = 0;
            // weather.list.forEach(function(day , key) {
            //     if (key % 7 === 1 && i > 1 && i < 30) {
            //         console.log(day.main.temp_max)
            //         console.log(i)
            //     }
            //     i++
            // })

            $('#title_show').html(weather.title_show)
            $('#country_title').html(weather.country + ',' + weather.title_en)
            $('.parent-img-weather-selected img').attr("src",amadeusPath + 'view/client/' +weather.pic)
            $('.parent-img-weather-selected img').attr("alt",weather.title_show)
            $('.title_show').html(weather.temp)
            $('.main-temperature-selected > span').html(weather.temp)
            $('.parent-main-temperature-selected > span').html('(' + useXmltag(desc) + ')')
            $('.pressure').html(weather.pressure)
            $('.humidity').html(weather.humidity)
            $('.speed').html(weather.speed)
            let counter = 0 ;
            $.each( weather.list, function (index, value) {
                if( index % 7 == 1 && counter>1 && counter<30) {
                    let pic_root = amadeusPath + 'view/client/' + weatherPic(value['weather'][0]['description'])
                    $('.temp_max_' + counter + ' span').html(value['main']['temp_max'] )
                    $('.feels_like_' + counter + ' span').html(value['main']['feels_like'])
                    $('.each_' + counter + ' img').attr("src", pic_root)
                }
                counter ++ ;
            });

        },
    })
}


function weatherPic(code) {
    let pic =  ''
    switch (code){
        case "clear sky":
            pic = 'assets/images/weather/brightness.png';
            break;

        case "few clouds":
            pic = 'assets/images/weather/cloud.png';
            break;

        case "scattered clouds":
            pic = 'assets/images/weather/fewcloud.png';
            break;

        case "broken clouds":
            pic = 'assets/images/weather/broken_cloud.png';
            break;

        case "shower rain":
            pic = 'assets/images/weather/rainy.png';
            break;

        case "rain":
            pic = 'assets/images/weather/storm.png';
            break;

        case "thunderstorm":
            pic = 'assets/images/weather/thunderstorm.png';
            break;

        case "snow":
            pic = 'assets/images/weather/snow.png';
            break;

        case "light snow":
            pic = 'assets/images/weather/snow.png';
            break;
        case "mist":
            pic = 'assets/images/weather/fog.png';
            break;

        case "light rain":
            pic = 'assets/images/weather/wind.png';
            break;

        case "overcast clouds":
            pic = 'assets/images/weather/clouds-and-sun.png';
            break;
        case "moderate rain":
            pic = 'assets/images/weather/storm.png';
            break;

        default:
            pic = '';
            break;
    }
    return pic;
}