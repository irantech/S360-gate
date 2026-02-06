{load_presentation_object filename="specialPages" assign="objSpecial"}
{assign var="special_pages" value=$objSpecial->findPageByIdList(['3','5','6','13'])}

{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="hotel_params_external" value=['Count'=> '3', 'type' =>'external']}
{assign var='hotel_external' value=$obj_main_page->getHotelWebservice($hotel_params_external)}
{if $hotel_external}
    {assign var='check_general' value=true}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=2}


<section class="hotel-ghods">
    <div class="container">
        <div class="title-safiran">
            <div class="text-title-safiran">
                <h2>هتل&#8204;های عراق</h2>
            </div>
        </div>
        <div class="parent-hotel">
            {foreach $special_pages as $page}
                <div class="item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/page/{$page['slug']}" class="link-parent">
                        <div class="img-hotel">
                            {if $page['files']['main_file']['src']}
                                <img src="{$page['files']['main_file']['src']}" alt="{$page['files']['main_file']['alt']}">
                                {else}
                                <img src="project_files/images/nophoto.png" alt="nophoto">
                            {/if}

                        </div>
                        <div class="text-hotel">
                            <h3>{$page['title']}</h3>
                        </div>
                    </a>
                </div>
            {/foreach}
{*            <div class="item">*}
{*                <a href="{$smarty.const.ROOT_ADDRESS}/page/karbala" class="link-parent">*}
{*                    <div class="img-hotel">*}
{*                        <img src="project_files/images/karbala.jpg" alt="img-hotel">*}
{*                    </div>*}
{*                    <div class="text-hotel">*}
{*                        <h3>رزرو هتل در کربلا</h3>*}
{*                    </div>*}
{*                </a>*}
{*            </div>*}
{*            <div class="item">*}
{*                <a href="{$smarty.const.ROOT_ADDRESS}/page/najaf" class="link-parent">*}
{*                    <div class="img-hotel">*}
{*                        <img src="project_files/images/najaf.jpg" alt="img-hotel">*}
{*                    </div>*}
{*                    <div class="text-hotel">*}
{*                        <h3>رزرو هتل در نجف</h3>*}
{*                    </div>*}
{*                </a>*}
{*            </div>*}
{*            <div class="item">*}
{*                <a href="{$smarty.const.ROOT_ADDRESS}/page/Kadhimiya" class="link-parent">*}
{*                    <div class="img-hotel">*}
{*                        <img src="project_files/images/kazemein.jpg" alt="img-hotel">*}
{*                    </div>*}
{*                    <div class="text-hotel">*}
{*                        <h3>رزرو هتل در کاظمین</h3>*}
{*                    </div>*}
{*                </a>*}
{*            </div>*}
{*            <div class="item">*}
{*                <a href="{$smarty.const.ROOT_ADDRESS}/page/sameraa" class="link-parent">*}
{*                    <div class="img-hotel">*}
{*                        <img src="project_files/images/samerra.jpg" alt="img-hotel">*}
{*                    </div>*}
{*                    <div class="text-hotel">*}
{*                        <h3>رزرو هتل در سامراء</h3>*}
{*                    </div>*}
{*                </a>*}
{*            </div>*}
        </div>
        {if $check_general}
        <div class="i_modular_hotels_webservice">
            <div class="__hotel__external__ parent-hotel-reservetion">
                {foreach $hotel_external as $item}
                {if $min_external <= $max_external}
                <div class="__i_modular_nc_item_class_0 item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="link-parent">
                        <div class="img-hotel">
                            <img class="__image_class__" src="{$item['Picture']}" alt="{$item['City']}">
                        </div>
                        <div class="text-hotel">
                            <div class="parent-hotel-reservetion-loq">
                                <h3 class="__title_class__">{$item['Name']}</h3>
                                <span class="__city_class__">{$item['City']}</span>
                            </div>
                            <div class="star-hotel">
                                {for $i = 0; $i < count($item['StarCode']); $i++}<i class="__star_class_light__1 fa-solid fa-star"></i>{/for}
                            </div>
                        </div>
                    </a>
                </div>
                 {$min_external = $min_external + 1}
                {/if}
                {/foreach}

            </div>
        </div>
        {/if}
        <div class=" owl-carousel owl-theme parent-hotel-owl">
            <div class="item">
                <a href="{$smarty.const.ROOT_ADDRESS}/page/najaf" class="link-parent">
                    <div class="img-hotel">
                        <img src="project_files/images/najaf.jpg" alt="img-hotel">
                    </div>
                    <div class="text-hotel">
                        <h3>رزرو هتل در نجف</h3>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{$smarty.const.ROOT_ADDRESS}/page/karbala" class="link-parent">
                    <div class="img-hotel">
                        <img src="project_files/images/karbala.jpg" alt="img-hotel">
                    </div>
                    <div class="text-hotel">
                        <h3>رزرو هتل در کربلا</h3>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{$smarty.const.ROOT_ADDRESS}/page/Kadhimiya" class="link-parent">
                    <div class="img-hotel">
                        <img src="project_files/images/kazemein.jpg" alt="img-hotel">
                    </div>
                    <div class="text-hotel">
                        <h3>رزرو هتل در کاظمین</h3>
                    </div>
                </a>
            </div>
            <div class="item">
                <a href="{$smarty.const.ROOT_ADDRESS}/page/sameraa" class="link-parent">
                    <div class="img-hotel">
                        <img src="project_files/images/samerra.jpg" alt="img-hotel">
                    </div>
                    <div class="text-hotel">
                        <h3>رزرو هتل در سامراء</h3>
                    </div>
                </a>
            </div>
        </div>
        {if $check_general}
        <div class="i_modular_hotels_webservice mt-3">
            <div class="__hotel__external__ owl-carousel owl-theme  parent-hotel-reservetion-owl">
                {foreach $hotel_external as $item}
                {if $min_external <= $max_external}
                <div class="__i_modular_nc_item_class_0 item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="link-parent">
                        <div class="img-hotel">
                            <img class="__image_class__" src="{$item['Picture']}" alt="{$item['Name']}">
                        </div>
                        <div class="text-hotel owl-text-hotel">
                            <div class="parent-hotel-reservetion-loq">
                                <h3 class="__title_class__">{$item['Name']}</h3>
                                <span class="__city_class__">{$item['City']}</span>
                            </div>
                            <div class="star-hotel">
                                {for $i = 0; $i < count($item['StarCode']); $i++}<i class="__star_class_light__1 fa-solid fa-star"></i>{/for}
                            </div>
                        </div>
                    </a>
                </div>
                {$min_external = $min_external + 1}
                {/if}
                {/foreach}
            </div>
        </div>
        {/if}
        <div class="bg-btn-karvan mx-auto mt-4">
            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel" class="btn-karvan">
                <span>بیشتر</span>
                <i class="fa-solid fa-arrow-left mr-3"></i>
            </a>
        </div>
    </div>
</section>

