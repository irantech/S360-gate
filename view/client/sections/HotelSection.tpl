<div class="hotel-section sections">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="hotel-section-title">##Populartours##</span>
            </div>

            <div class="owl-carousel owl_hotel">
                {foreach $hotels['Result'] as $key=>$hotel}
                    <div class="item">
                        <div class="modern-category">
                            <div class="modern-category-box-thumb">
                                <a href="javascript:;"><img src="{$hotel['Picture']}" class="img-fluid mx-auto"
                                                            alt=""></a>
                            </div>
                            <div class="modern-category-footer">
                                <div class="mc-footer-caption">
                                    <h4 class="category-title">
                                        <a href="javascript:;">##Hotel## {$hotel['Name']}</a>
                                    </h4>
                                    <div class="rating rating_5">
                                        {assign var='StarCode' value=$hotel['StarCode']-1}
                                        {for $foo=0 to $StarCode}
                                            <i class="fa fa-star"></i>
                                        {/for}
                                    </div>
                                </div>
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$hotel['HotelIndex']}" class="mc-footer-link">
                                    <i class="fa fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>

        </div>
    </div>
</div>