{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['Count'=> '6', 'type' =>'internal' , 'star_code' => ['5']]}


{assign var='internal_hotels' value=$obj_main_page->getHotelWebservice($internal_hotel_params)}
{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity()}

<section class="hotel">
    <div class="container">
        <div class="titel_special_tours">
            <h4 class="title01">هتل های ویژه آژانس خدمات مسافرت هوائی و جهانگردی</h4>
{*            <ul class="nav nav-pills mb-3 d-flex align-items-center justify-content-center" id="hotel-ul" role="tablist">*}

{*                <li class="nav-item" role="presentation">*}
{*                    <button class="nav-link text-white active" id="hotel-dakheli" data-toggle="pill" data-target="#hotel-dakheli-tab" type="button" role="tab" aria-controls="hotel-dakheli-tab" aria-selected="true">هتل داخلی</button>*}
{*                </li>*}

{*                <li class="nav-item" role="presentation">*}
{*                    <button class="nav-link text-white" id="hotel-khareji" data-toggle="pill" data-target="#hotel-khareji-tab" type="button" role="tab" aria-controls="hotel-khareji-tab" aria-selected="true">هتل خارجی</button>*}
{*                </li>*}

{*            </ul>*}
        </div>
        <div class="tab-content" id="hotel-items">
            <div class="tab-pane fade show active" id="hotel-dakheli-tab" role="tabpanel" aria-labelledby="hotel-dakheli-tab">
                <div class="grid01">
                    {foreach $internal_hotels as $item}

                        {if $item['HotelIndex'] neq '13588'}
                            <div class="" >
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="link-parent-hotel">
                                    <img src="{$item['Picture']}"
                                         alt="{$item['City']}">
                                    <div class="hotel-name">
                                        <h4>
                                            {$item['Name']}
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        {/if}
                    {/foreach}
                </div>

            </div>

{*            <div class="tab-pane fade" id="hotel-khareji-tab" role="tabpanel" aria-labelledby="hotel-khareji-tab">*}

{*                <div class="owl-carousel owl-theme owl-hotel-demo">*}
{*                    {foreach $internal_hotels as $item}*}

{*                        {if $item['HotelIndex'] neq '13588'}*}
{*                            <div class="item" >*}
{*                                <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="link-parent-hotel">*}
{*                                    <img src="{$item['Picture']}"*}
{*                                         alt="{$item['City']}">*}
{*                                    <div class="hotel-name">*}
{*                                        <h4>*}
{*                                            {$item['Name']}*}
{*                                        </h4>*}
{*                                    </div>*}
{*                                </a>*}
{*                            </div>*}
{*                        {/if}*}
{*                    {/foreach}*}
{*                </div>*}

{*            </div>*}
        </div>
        <div class="col-12 d-flex align-items-center justify-content-center ">
            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel" class="btn_link_more">
                مشاهده بیشتر
            </a>
        </div>
    </div>
</section>
