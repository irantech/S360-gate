{load_presentation_object filename="weather" assign="objWeather"}
{assign var="weather" value=$objWeather->getWeatherSelect()}
{assign var="city_list" value=$objWeather->getCityAll()}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}
{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/weather-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/weather.css'>
{/if}

<section class="weather-city mt-3">
    <h6>شهر مورد نظر خود را انتخاب کنید</h6>
    <select id='city_list' onchange='getNewWeather()' class='select2'>
        {foreach $city_list as $city}
            <option value='{$city['title_en']}'>{$city['title']}</option>
        {/foreach}
    </select>
    <div>
        <div class="parent-weather-selected">
            <div class="day-weather-selected col-lg-5 col-md-6 col-sm-12 col-12 p-0">
                <div class="img-city-selected">
                    <div class="parent-name-city-selected">
                        <h2 id='title_show'>{$weather.title_show}</h2>
                        <div class="sub-city-name-weather-selected">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"></path></svg>
                            <span id='country_title'>{$weather.country},{$weather.title_en}</span>
                        </div>
                    </div>
                    <div class="parent-img-weather-selected">
                        <img src="{$weather.pic}" alt="{$weather.title_show}" >
                    </div>
                </div>
                <div class='parent-main-temperature-selected'>
                    <h2 class="main-temperature-selected"><span>{$weather.temp}</span>°C</h2>
                    <span>({$weather.description})</span>
                </div>
                <div class="parent-weather-option">
                    <div class="weather-option-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 336c0 79.5 64.5 144 144 144H512c70.7 0 128-57.3 128-128c0-61.9-44-113.6-102.4-125.4c4.1-10.7 6.4-22.4 6.4-34.6c0-53-43-96-96-96c-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32C167.6 32 96 103.6 96 192c0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336z"></path></svg>
                        <span>##AirPressure##</span>
                        <span class='pressure'>{$weather.pressure}</span>
                    </div>
                    <div class="weather-option-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 512C86 512 0 426 0 320C0 228.8 130.2 57.7 166.6 11.7C172.6 4.2 181.5 0 191.1 0h1.8c9.6 0 18.5 4.2 24.5 11.7C253.8 57.7 384 228.8 384 320c0 106-86 192-192 192zM96 336c0-8.8-7.2-16-16-16s-16 7.2-16 16c0 61.9 50.1 112 112 112c8.8 0 16-7.2 16-16s-7.2-16-16-16c-44.2 0-80-35.8-80-80z"></path></svg>
                        <span>##Humidity##</span>
                        <span class='humidity'>{$weather.humidity} %</span>
                    </div>
                    <div class="weather-option-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 24c0 13.3 10.7 24 24 24h44c24.3 0 44 19.7 44 44s-19.7 44-44 44H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H356c50.8 0 92-41.2 92-92s-41.2-92-92-92H312c-13.3 0-24 10.7-24 24zm64 368c0 13.3 10.7 24 24 24h44c50.8 0 92-41.2 92-92s-41.2-92-92-92H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H420c24.3 0 44 19.7 44 44s-19.7 44-44 44H376c-13.3 0-24 10.7-24 24zM120 512h44c50.8 0 92-41.2 92-92s-41.2-92-92-92H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H164c24.3 0 44 19.7 44 44s-19.7 44-44 44H120c-13.3 0-24 10.7-24 24s10.7 24 24 24z"></path></svg>
                        <span>##WindSpeed##</span>
                        <span class='speed'>{$weather.speed}  m/s</span>
                    </div>
                </div>
            </div>

            <div class="parent-day-future col-lg-7 col-md-6 col-sm-12 col-12 p-0">
                {assign var="number" value="0"}
                {foreach $weather.list as $key=>$item}
                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        {assign var="day" value=$objDateTimeSetting->jdate("l", $item['dt'], "", "", "fa")}
                        {assign var="date" value=$objDateTimeSetting->jdate("d", $item['dt'], "", "", "fa")}
                    {else}
                        {assign var="day" value=date("D", $item['dt'])}
                        {assign var="date" value=date("d", $item['dt'])}
                    {/if}
                    {if $key%7==1 && $number>1 && $number<30}
                        <div class="day-future-item each_{$number}">
                            <span>{$day} {$date}</span>
                            {*                            <span style='font-size: 12px'>({$objWeather->WeatherConditionCodesPersian( {$item['weather'][0]['description']})})</span>*}
                            <img src="{$objWeather->weatherPic( {$item['weather'][0]['description']})}" alt="{$objWeather->WeatherConditionCodesPersian( {$item['weather'][0]['description']})}">
                            <div class='parent-high-low'>
                                <div class='parent-high'>
                                    <h4 class='temp_max_{$number}'><span>{$item['main']['temp_max']}</span>°C</h4>
                                    <i class="fa-solid fa-sort-up"></i>
                                </div>
                                <div class='parent-low'>
                                    <h4 class='feels_like_{$number}'><span>{$item['main']['feels_like']}</span>°C </h4>
                                    <i class="fa-solid fa-sort-down"></i>
                                </div>
                            </div>
                        </div>

                    {/if}
                    {$number=$number+1}
                {/foreach}
            </div>
        </div>
        <div id="loading" style="display: none; text-align: center;">
            <div class="spinner"></div>
        </div>
    </div>
</section>
{literal}
    <script src="assets/modules/js/weather.js"></script>
{/literal}