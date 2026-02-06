{load_presentation_object filename="weather" assign="objWeather"}
{assign var="cityAll" value=$objWeather->getCityAll()}
{assign var="getFirstCity" value=$objWeather->mainWeather(['cityId'=>1])|json_decode:true}


<section class="weather py-5">
    <div class="container">
        <div class="weather_main d-flex flex-wrap">
            <div class="col-lg-3 col-md-12 col-12">
                <div class="form-group m-0 w-100 h-100 d-flex flex-wrap justify-content-between flex-column pb-4">
                    <h5 class="title_weather">یک شهر یا کشور را انتخاب کنید</h5>
                    <select class="select2" id="changeCityWeather" >
                        {foreach $cityAll as $city}
                            <option value='{$city.id}'>
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    {$city['title']}
                                {else}
                                    {if $city['title_en'] }
                                        {$city['title_en']}
                                    {else}
                                        {$city['title']}
                                    {/if}
                                {/if}
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="m-0 w-100 h-100 d-flex flex-wrap justify-content-between flex-column pb-4">
                    <h5 class="title_weather">نام</h5>
                    <h6 class="title2_weather" id="results-title">{$getFirstCity['title']}</h6>
                    <h6 id='results'></h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="m-0 w-100 h-100 d-flex flex-wrap justify-content-between flex-column pb-4">
                    <h5 class="title_weather">وضعیت</h5>
                    <div class="img_weather" id="results-pic">
                        <img  src='{$getFirstCity['image_url']}' alt='{$getFirstCity['title']}' style='width:50px'>
                    </div>
                    <div class="img_weather" id='description-weather'>
                    <span >{$getFirstCity['description_title']}</span>
                    </div>

                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <div class="m-0 w-100 h-100 d-flex flex-wrap justify-content-between flex-column pb-4">
                    <h5 class="title_weather">درجه حرارت</h5>
                    <div class="d-flex temperature_main justify-content-around align-items-center">
                        <div class="high_temperature">
                            <h6 id='max-temp'>{$getFirstCity['temp_max']}</h6>
                            <i class="fa-duotone fa-caret-up"></i>
                        </div>
                        <div class="low_temperature">
                            <h6 id='min-temp'>{$getFirstCity['temp_min']} </h6>
                            <i class="fa-duotone fa-caret-down"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-6 col-6">
                <div class=" m-0 w-100 h-100 d-flex flex-wrap align-items-center justify-content-center flex-column">
                    <a href="{$smarty.const.ROOT_ADDRESS}/weather" class="angle_right_weather far fa-angle-right my-auto"></a>
                </div>
            </div>
        </div>
    </div>
</section>
{literal}
    <script>
      $(document).ready(function(){
        $('#changeCityWeather').change(function(){
          //Selected value
          var cityId = $(this).val();
          //Ajax for calling php function
          $.ajax({
            url: amadeusPath + 'ajax',
            data: JSON.stringify({
              className: 'weather',
              method: 'mainWeather',
              cityId: cityId,
            }),
            type: 'POST',
            dataType: 'JSON',
            success: function (response) {
              // data = jQuery.parseJSON(response);
              // console.log(response);
              $("#results").html('');
              $("#results-title").html('');
              $("#results-pic").html('');
              $("#max-temp").html('');
              $("#min-temp").html('');
              $("#description-weather").html('');
              $("#results-title").append(response.title);
              $("#results-pic").append(response.pic);
              $("#max-temp").append(response.temp_max);
              $("#min-temp").append(response.temp_min);
              $("#description-weather").append(response.description_title);

            },
          });
        });
      });
    </script>
{/literal}