{assign var="internal_hotel_params" value=['Count'=> '4', 'type' =>'internal']}  {* فقط ۴ تا می‌خوایم مثل وبلاگ *}
{assign var="internal_hotels" value=$obj_main_page->getHotelWebservice($internal_hotel_params)}

{if $internal_hotels && $internal_hotels[0]}
    <section class="i_modular_hotels hotels-demo">
        <div class="bg-absolute4"></div>
        <div class="container">
            <div class="section-title">
                <h2>هتل های داخلی</h2>
            </div>

            <div class="hotels-grid">  {* همون کلاس blog-grid رو نگه داشتم تا css قبلی کار کنه *}

                {if $internal_hotels[0]}
                    <div class="__i_modular_c_item_class_0 div1">  {* پست ویژه / بزرگ‌تر *}
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$internal_hotels[0]['HotelIndex']}">
                            <img alt="{$internal_hotels[0]['Name']}" class="__image_class__" src="{$internal_hotels[0]['Picture']}" loading="lazy" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$internal_hotels[0]['Name']}</h4>
                                    <span class="__heading_class__">
                                    {$internal_hotels[0]['City']} • {$internal_hotels[0]['StarCode']} ستاره
                                </span>
                                </div>
                                <i>
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}

                {if $internal_hotels[1]}
                    <div class="__i_modular_c_item_class_1 div2">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$internal_hotels[1]['HotelIndex']}">
                            <img alt="{$internal_hotels[1]['Name']}" class="__image_class__" src="{$internal_hotels[1]['Picture']}" loading="lazy" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$internal_hotels[1]['Name']}</h4>
                                    <span class="__heading_class__">
                                    {$internal_hotels[1]['City']} • {$internal_hotels[1]['StarCode']} ستاره
                                </span>
                                </div>
                                <i>
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}

                {if $internal_hotels[2]}
                    <div class="__i_modular_c_item_class_2 div3">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$internal_hotels[2]['HotelIndex']}">
                            <img alt="{$internal_hotels[2]['Name']}" class="__image_class__" src="{$internal_hotels[2]['Picture']}" loading="lazy" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$internal_hotels[2]['Name']}</h4>
                                    <span class="__heading_class__">
                                    {$internal_hotels[2]['City']} • {$internal_hotels[2]['StarCode']} ستاره
                                </span>
                                </div>
                                <i>
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}

                {if $internal_hotels[3]}
                    <div class="__i_modular_c_item_class_3 div4">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$internal_hotels[3]['HotelIndex']}">
                            <img alt="{$internal_hotels[3]['Name']}" class="__image_class__" src="{$internal_hotels[3]['Picture']}" loading="lazy" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$internal_hotels[3]['Name']}</h4>
                                    <span class="__heading_class__">
                                    {$internal_hotels[3]['City']} • {$internal_hotels[3]['StarCode']} ستاره
                                </span>
                                </div>
                                <i>
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}

            </div>
        </div>
    </section>
{/if}