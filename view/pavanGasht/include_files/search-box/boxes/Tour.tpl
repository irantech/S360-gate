
<div class="__box__ tab-pane" id="Tour">
    <div class="internal-tour-js" id="internal_tour">
        <div class="empty-div"></div>
        {*    mt-sm-0 mt-md-0 mt-lg-0 mt-xl-0 mt-xxl-0   mt-4 *}
        <div class="col-12  mt-0 mt-lg-4">
            <div class="row">
                <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsTourLocal" method="post" name="gdsTourLocal" target="_blank">
                    {include file="./sections/Tour/internal/origin_city_tour.tpl"}
                    {include file="./sections/Tour/internal/destination_city_tour.tpl"}
                    {include file="./sections/Tour/internal/date_teravel.tpl"}
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                        <button class="btn theme-btn seub-btn b-0" onclick="searchInternalTour()" type="button">
                            <span>
                            جستجو
                             </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="__box__ tab-pane" id="Tour-Foreign">
    <div class="international-tour-js" id="international_tour">
        <div class="empty-div"></div>
            {*   mt-sm-0 mt-md-0 mt-lg-0 mt-xl-0 mt-xxl-0     *}
        <div class="col-12 mt-0 mt-lg-4 ">
            <div class="row">
                <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsPortalLocal" method="post" name="gdsPortalLocal" target="_blank">
                    {include file="./sections/Tour/international/country_origin.tpl"}
                    {include file="./sections/Tour/international/city_origin.tpl"}
                    {include file="./sections/Tour/international/country_destination.tpl"}
                    {include file="./sections/Tour/international/city_destination.tpl"}
                    {include file="./sections/Tour/international/date_travel.tpl"}
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                        <button class="btn theme-btn seub-btn b-0" onclick="searchInternationalTour()" type="button">
<span>
جستجو
 </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


