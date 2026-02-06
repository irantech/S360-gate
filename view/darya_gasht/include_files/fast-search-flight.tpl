{assign var="params" value=['limit'=>'7','is_group'=>true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
{assign var="foreign_cities" value=['IKA','DXBALL','ISTALL','KUL', 'MOWALL' , 'NJF' , 'TBS']}




<section class="search_flight d-flex py-5">
    <div class="container">
        <div class="title">
            <h2>جستجو سریع پرواز</h2>
            <div>
                <div class="dropdown_custom">
                    <button>
                        <span>پرواز داخلی</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M360.5 217.5l-152 143.1C203.9 365.8 197.9 368 192 368s-11.88-2.188-16.5-6.562L23.5 217.5C13.87 208.3 13.47 193.1 22.56 183.5C31.69 173.8 46.94 173.5 56.5 182.6L192 310.9l135.5-128.4c9.562-9.094 24.75-8.75 33.94 .9375C370.5 193.1 370.1 208.3 360.5 217.5z"/></svg>
                    </button>
                    <div>
                        <ul class="nav nav-pills mb-3" id="search_flight-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active"
                                        id="search_flight_internal-tab"
                                        data-toggle="pill"
                                        data-target="#search_flight_internal"
                                        type="button"
                                        role="tab"
                                        aria-controls="search_flight_internal"
                                        aria-selected="true">
                                    پرواز داخلی
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link"
                                        id="search_flight_internation-tab"
                                        data-toggle="pill"
                                        data-target="#search_flight_internation"
                                        type="button"
                                        role="tab"
                                        aria-controls="search_flight_internation"
                                        aria-selected="false">
                                    پرواز خارجی
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="search_flight-tabContent">
            <div class="tab-pane fade show active" id="search_flight_internal" role="tabpanel" aria-labelledby="search_flight_internal-tab">
                <ul class="nav nav-pills m-0 p-0" id="search_flight_internal-div-tab" role="tablist">
                    {assign var="i" value="1"}
                    {foreach $cities['cities_flight'] as $city}
                    {if $i < 4 }
                    <li class="nav-item" role="presentation">
                        <button class="nav-link  {if $i==1} active {/if}"
                                id="{$city['main']['Departure_CityEn']}55-tab"
                                data-toggle="pill"
                                data-target="#{$city['main']['Departure_CityEn']}55"
                                type="button"
                                role="tab"
                                aria-controls="{$city['main']['Departure_CityEn']}55"
                                aria-selected="true">{$city['main']['Departure_CityFa']}</button>
                    </li>
                    {/if}
                        {$i =  $i + 1}
                    {/foreach}

                </ul>
                <div class="tab-content" id="search_flight_internal-div-tabContent">
                    {assign var="j" value="1"}
                    {foreach $cities['cities_flight'] as $city}
                    <div class="tab-pane fade {if $j==1} show active {/if}"
                         id="{$city['main']['Departure_CityEn']}55"
                         role="tabpanel"
                         aria-labelledby="{$city['main']['Departure_CityEn']}55-tab">
                        <div class="search_flight_grid">
                            {foreach $city['sub_cities'] as $sub_city}
                            <div class="flightSearchBox" data-target="#calenderBox" data-toggle="modal"
                                 onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                <h5 class="col-4 text-right">{$city['main']['Departure_CityFa']}</h5>
                                <div class="col-4 d-flex justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"/></svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M576 256C576 305 502.1 336 464.2 336H382.2L282.4 496C276.4 506 266.4 512 254.4 512H189.5C179.5 512 169.5 508 163.5 500C157.6 492 155.6 480.1 158.6 471L201.5 336H152.5L113.6 388C107.6 396 98.61 400 88.62 400H31.7C22.72 400 12.73 396 6.74 388C.7485 380-1.248 370 1.747 360L31.7 256L.7488 152C-1.248 143 .7488 133 6.74 125C12.73 117 22.72 112 31.7 112H88.62C98.61 112 107.6 117 113.6 125L152.5 176H201.5L158.6 41C155.6 32 157.6 21 163.5 13C169.5 5 179.5 0 189.5 0H254.4C265.4 0 277.4 7 281.4 16L381.2 176H463.2C502.1 176 576 208 576 256H576zM527.1 256C525.1 246 489.1 224 463.2 224H355.3L245.4 48H211.5L266.4 224H128.6L80.63 160H53.67L81.63 256L53.67 352H80.63L128.6 288H266.4L211.5 464H245.4L355.3 288H463.2C490.1 288 526.1 267 527.1 256V256z"/></svg>
                                </div>
                                <h5 class="col-4">{$sub_city['Departure_CityFa']}</h5>
                            </div>
                            {/foreach}
                        </div>
                        <div class="moreBtnMobile justify-content-center mt-3"><a href="javascript:" class="button">بیشتر</a></div>
                    </div>
                        {$j =  $j + 1}
                    {/foreach}
                </div>
            </div>
            <div class="tab-pane fade" id="search_flight_internation" role="tabpanel" aria-labelledby="search_flight_internation-tab">
                <ul class="nav nav-pills m-0 p-0" id="search_flight_internation-div-tab" role="tablist">
                    {assign var="i" value="1"}
                    {foreach $foreign_cities as $city_code}
                    {assign var="params" value=['use_customer_db'=>true,'origin_city'=>$city_code,'destination_city'=>$foreign_cities]}
                    {assign var="cities" value=$obj_main_page->dataFastSearchInternationalFlight($params)}
                    {if $i < 4  and {$cities['main']['DepartureCityFa']}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {if $i==1} active {/if}"
                                id="{$cities['main']['DepartureCityEn']}66-tab"
                                data-toggle="pill"
                                data-target="#{$cities['main']['DepartureCityEn']}66"
                                type="button"
                                role="tab"
                                aria-controls="{$cities['main']['DepartureCityEn']}66"
                                aria-selected="true">{$cities['main']['DepartureCityFa']}</button>
                    </li>
                    {/if}
                        {$i =  $i + 1}
                    {/foreach}


                </ul>
                <div class="tab-content" id="search_flight_internation-div-tabContent">
                    {assign var="i" value="1"}
                    {foreach $foreign_cities as $city_code}
                        {assign var="params" value=['use_customer_db'=>true,'origin_city'=>$city_code,'destination_city'=>$foreign_cities]}
                        {assign var="cities" value=$obj_main_page->dataFastSearchInternationalFlight($params)}
                            <div class="tab-pane fade show {if $i==1} active {/if}"
                                 id="{$cities['main']['DepartureCityEn']}66"
                                 role="tabpanel"
                                 aria-labelledby="{$cities['main']['DepartureCityEn']}66-tab">
                                <div class="search_flight_grid">
                                    {foreach $cities['sub_cities'] as $sub_city}

                                    <div class="flightSearchBox" data-target="#calenderBox" data-toggle="modal"
                                         onclick="calenderFlightSearch('{$cities['main']['DepartureCode']}','{$sub_city['DepartureCode']}')">
                                        <h5 class="col-4 text-right">{$cities['main']['DepartureCityFa']}</h5>
                                        <div class="col-4 d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"/></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"/></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"/></svg>

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M576 256C576 305 502.1 336 464.2 336H382.2L282.4 496C276.4 506 266.4 512 254.4 512H189.5C179.5 512 169.5 508 163.5 500C157.6 492 155.6 480.1 158.6 471L201.5 336H152.5L113.6 388C107.6 396 98.61 400 88.62 400H31.7C22.72 400 12.73 396 6.74 388C.7485 380-1.248 370 1.747 360L31.7 256L.7488 152C-1.248 143 .7488 133 6.74 125C12.73 117 22.72 112 31.7 112H88.62C98.61 112 107.6 117 113.6 125L152.5 176H201.5L158.6 41C155.6 32 157.6 21 163.5 13C169.5 5 179.5 0 189.5 0H254.4C265.4 0 277.4 7 281.4 16L381.2 176H463.2C502.1 176 576 208 576 256H576zM527.1 256C525.1 246 489.1 224 463.2 224H355.3L245.4 48H211.5L266.4 224H128.6L80.63 160H53.67L81.63 256L53.67 352H80.63L128.6 288H266.4L211.5 464H245.4L355.3 288H463.2C490.1 288 526.1 267 527.1 256V256z"/></svg>
                                        </div>
                                        <h5 class="col-4">{$sub_city['DepartureCityFa']}</h5>
                                    </div>
                                    {/foreach}

                                </div>
                                <div class="moreBtnMobile justify-content-center mt-3"><a href="{$smarty.const.ROOT_ADDRESS}/page/flight" class="button">بیشتر</a></div>
                            </div>
                        {$i =  $i + 1}
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</section>
