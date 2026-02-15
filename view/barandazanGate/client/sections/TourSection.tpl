<div class="section_tour sections">


    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                {assign var='tours' value=$objSearch->getTour('internal','2',$base_language)}

                <span class="hotel-section-title">##Populartours##</span>

            </div>
            <div class="owl-carousel owl_tour">
                {foreach $tours as $key=>$tour}
                    {assign var='tour_year' value=$tour['start_date']|substr:0:4}
                    {assign var='tour_month' value=$tour['start_date']|substr:4:2}
                    {assign var='tour_day' value=$tour['start_date']|substr:6:2}

                    <div class="list-grid-layout classical-layout">
                        <a title="تور" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}">
                            <div class="grid-layout-header">

                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" class="img-fluid mx-auto" alt="{$tour['tour_name']}">


                                <div class="grid-layout-info site-bg-main-color">
                                    <ul>
                                        <li><i class="fa fa-clock"></i> ##Tourduration## : {$tour['night']} ##Night##</li>
                                        <li><i class="fa fa-calendar-alt"></i>##dateMove##: {$tour_year}/{$tour_month}/{$tour_day}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="grid-layout-body">
                                <div class="gl-list-author">

                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" class="img-fluid mx-auto" alt="{$tour['translated_tour_name']}">

                                    <span class="verified-badge site-bg-main-color"><i class="fa fa-check"></i></span>
                                </div>
                                <div class="gl-list-caption">
                                    <h4><span href="listing-detail.html" class="list-title">{$tour['translated_tour_name']}</span></h4>
{*                                    <p class="gl-tagline">تور تفریحی قشم</p>*}
                                </div>
                            </div>
                            <div class="grid-layout-footer">

                                <div class="cat-icon-box rounded-circle cbg-5">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="icon-box-text">##Startprice##</div>

                                <div class="ft-loke">
                                    <span class="list-status ls-close">{$tour['tour_price']} <em>##Rial##</em></span>
                                </div>
                            </div>
                        </a>
                    </div>
                {/foreach}



            </div>

        </div>
    </div>

</div>