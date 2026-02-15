
{load_presentation_object filename="agency" assign="objAgency"}

<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopad ">

    <div class="filterBox">
        <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">
            <p class="txt14"> ##Cities## <span class="hotel-city-name"></span></p>
        </div>

        <div class="filtertip-searchbox site-main-text-color-drck">
            <span class="filter-title"></span>
            <div class="filter-content padb10 padt10">

                {*assign var="allCities" value=$objFunctions->cityIataList()*}
                {assign var="allCities" value=$objAgency->cityIataList()}
                <div class="form-hotel-item form-hotel-item-searchBox margin5auto">
                    <div class="select">
                        <select name="city" id="city" class="select2" onchange="showListAgencyByCity()">
                            <option value="" selected="selected"> ##Selection##</option>
                            <option value="all" {if $smarty.const.SEARCH_CITY eq 'all'}selected="selected"{/if}>##All##</option>
                            {foreach $allCities as $city}
                                {if $city.city_iata eq $smarty.const.SEARCH_CITY}{assign var="cityName" value=$city.city_name}{/if}

                                <option value="{$city.city_iata}" {if $smarty.const.SEARCH_CITY eq $city.city_iata}selected="selected"{/if}>{$city.city_name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="col-lg-9 col-md-12  col-sm-12 col-xs-12 padl0" >

    {assign var="agencyList" value=$objAgency->getAgencyListByCity($smarty.const.SEARCH_CITY)}
    {foreach key=key item=item from=$agencyList}

        {assign var='agencyRate' value=functions::getAgencyRate($item['id'])}

    <div class="hotelResultItem carItem">
        <div class="hotel-result-item">

            <div class="col-md-4 nopad">
                <div class="hotel-result-item-image site-bg-main-color-hover">
                    <a>
                        <img style="width: auto;height: 100%;" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['logo']}" alt="{$item['name_fa']}">
                    </a>
                </div>
            </div>

            <div class="col-md-8 nopad">
                <div class="hotel-result-item-content">
                    <div class="hotel-result-item-text"  style="width: 100% !important;">

                        <a>
                            <b class="hotel-result-item-name"> {$item['name_fa']} </b>
                            <b class="hotel-result-item-name hotel-nameEn">{$item['name_en']}</b>
                        </a>

                        <span class="hotel-result-item-content-location fa fa-map-marker height40">
                            <span>{$item['address_fa']}</span>
                        </span>

                        <span class="car-result-item fa fa-check">
                            <span>##Telephone##: {$item['phone']}</span>
                        </span>
                        <span class="car-result-item fa fa-check">
                            <span>##Fax##: {$item['fax']}</span>
                        </span>
                        <span class="car-result-item fa fa-check">
                            <span>##Email##: {$item['email']}</span>
                        </span>
                        <span class="car-result-item fa fa-check">
                            <span>##Management##: {$item['manager']}</span>
                        </span>
                        <span class="car-result-item fa fa-check">
                            <span>##Site##: {$item['domain']}</span>
                        </span>
                        {if $agencyRate['average'] gt 0}
                            <span class="car-result-item fa fa-check">
                                <span>##Pointagency##  {$agencyRate['average']} ##From## 5 </span>
                            </span>
                        {/if}


                    </div>

                </div>
            </div>

        </div>
    </div>
    {/foreach}


</div>
