{assign var="params" value=['use_customer_db'=>true,'origin_city'=>'IKA','destination_city'=>['IKA','DXBALL','ISL','AMS','PARALL','NJF','BIO']]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternationalFlight($params)}


<div class="masir-section sections">
    <div class="air_title">
        <h4>مقاصد پرطرفدار</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="owl-carousel owl_flight">
                {foreach $cities['sub_cities'] as $city}
                        <div class="item">
                            <div class="masir-item">
                                <div class="masir-head-text site-border-bottom-main-color   {$city['DepartureCode']}">
                                    پرواز از <i>{$city['DepartureCityFa']}</i> به
                                    <section class="masir-deses">
                                        {foreach $cities['sub_cities'] as $sub_city}
                                            {if $city['DepartureCode'] neq $sub_city['DepartureCode']}
                                                <div class="masir-des">
                                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/gds/fa/international/1/{$city['DepartureCode']}-{{$sub_city['DepartureCode']}}/{$objDate->tomorrow()}/1-0-0"class="flightSearchBox">
                                                        <div class="des-name site-color-main-color-before">
                                                            <span> {$city['DepartureCityFa']}</span>
                                                            <span> {$sub_city['DepartureCityFa']}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            {/if}
                                        {/foreach}

                                    </section>

                                </div>
                            </div>
                        </div>
                    {$i =  $i + 1}
                {/foreach}
            </div>
        </div>
    </div>
</div>
