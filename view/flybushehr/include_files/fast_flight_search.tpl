{assign var="params" value=['limit'=>'7','is_group'=>true , 'use_customer_db' => true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
{assign 'foreign_cities' ['IST' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'BON' => functions::Xmlinformation('S360BON'),'SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL'), 'LONALL' => functions::Xmlinformation('S360YXUALL'), 'NJF' => functions::Xmlinformation('S360NJF')]}
{assign 'foreign_departure_cities' ['BUZ' => 'بوشهر','THR' => 'تهران','SYZ' => 'شیراز',
'MHD' => 'مشهد','IFN' => 'اصفهان']}

{assign var="__local_max_var__" value=6}

<section class="i_modular_fast_search_flight palnes container py-5 position-relative">
    <div class="d-flex justify-content-between align-items-center pb-4">
        <div class="text_title_plane">
            <div>جستجو سریع پرواز</div>
        </div>
        <ul class="d-and-k-plane nav nav-pills m-0 p-0" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a aria-controls="pills-home" aria-selected="true" class="nav-link active" data-toggle="pill" href="#pills-home" id="pills-home-tab" role="tab">داخلی</a>
            </li>
                            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                                   aria-controls="pills-profile" aria-selected="false">خارجی</a>
                            </li>
        </ul>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div aria-labelledby="pills-home-tab" class="__fast_flight_search__internal__multi_city__ tab-pane fade show active" id="pills-home" role="tabpanel">
            <ul class="__origin__cities__ nav_ab d-and-k-plane nav nav-pills m-0 p-0" role="tablist">
                {assign var="i" value="1"}
                {foreach $cities['cities_flight'] as $city}
                    {if $i < $__local_max_var__ }

                        <li class="__i_modular_nc_item_class_0 nav-item" role="presentation">
                            <a aria-controls="{$city['main']['Departure_CityEn']}" aria-selected="true" class="__button__ nav-link {if $i==1} show active {/if}" data-target="#{$city['main']['Departure_CityEn']}" data-toggle="tab" href="#home_1" id="{$city['main']['Departure_CityEn']}-tab" role="tab">{$city['main']['Departure_CityFa']}</a>
                        </li>

                    {/if}
                    {$i =  $i + 1}
                {/foreach}
            </ul>
            <div class="__destination__cities__ tab-content" id="myTabContent_1">
                {assign var="i" value="1"}
                {foreach $cities['cities_flight'] as $city}
                    {if $i < $__local_max_var__ }
                        <div aria-labelledby="{$city['main']['Departure_CityEn']}-tab" class="__i_modular_nc_item_class_0 tab-pane fade {if $i==1} show active {/if}" id="{$city['main']['Departure_CityEn']}" role="tabpanel">
                            <div class="box_palne">
                                {foreach $city['sub_cities'] as $sub_city}
                                    <div class="__final_destination_0 flightSearchBox flightSearchBox flightSearchBox flightSearchBox" data-target="#calenderBox" data-toggle="modal" onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                        <span class="__origin__">{$city['main']['Departure_CityFa']}</span>
                                        <span class="d-flex align-items-center justify-content-center"><i class="fa fa-ellipsis"></i><i class="transform_180 fa fa-plane"></i></span>
                                        <span class="__destination__">{$sub_city['Departure_CityFa']}</span>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    {/if}
                    {$i =  $i + 1}
                {/foreach}
            </div>
        </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <ul class="nav_ab d-and-k-plane nav nav-pills m-0 p-0" role="tablist">
                            {assign var="i" value="1"}
                            {foreach $foreign_departure_cities as $key=> $city}
                                {if $i < $__local_max_var__ }
                                    <li class="__i_modular_nc_item_class_0 nav-item" role="presentation">
                                        <a aria-controls="{$key}-1" aria-selected="true" class="__button__ nav-link {if $i==1} show active {/if}" data-target="#{$key}-1" data-toggle="tab" href="#home_1" id="{$key}-1-tab" role="tab">{$city}</a>
                                    </li>
                            {/if}
                            {$i =  $i + 1}
                            {/foreach}
                        </ul>
                        <div class="tab-content" id="myTabContent_2">
                            {assign var="i" value="1"}
                            {foreach $foreign_departure_cities as $key => $city}
                            {if $i < $__local_max_var__ }
                                {if $key== 'THR'}
                                    {assign var="Departure_Code" value='IKA'}
                                {else}
                                    {assign var="Departure_Code" value=$key}
                                {/if}
                            <div aria-labelledby="{$key}-1-tab" class="__i_modular_nc_item_class_0 tab-pane fade {if $i==1} show active {/if}" id="{$key}-1" role="tabpanel">
                                <div class="box_palne">
                                    {foreach $foreign_cities as $item}
                                        <div>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/international/1/{$Departure_Code}-{$item@key}/{$objDate->tomorrow()}/1-0-0">
                                                <span>{$city}</span>
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <i class="fa fa-ellipsis"></i><i
                                                        class="transform_180 fa fa-plane"></i></span>
                                                <span>{$item}</span>
                                            </a>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                            {/if}
                                {$i =  $i + 1}
                            {/foreach}
                        </div>
                    </div>
    </div>
</section>