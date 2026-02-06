{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane  active show" id="tour" role="tabpanel" aria-labelledby="tour-tab">
     {include file="./sections/tour/internal/btn_radio_internal_external.tpl"}
    <div id="tour_dakheli">
        <form data-action="https://s360online.iran-tech.com/" class="d_contents w-100" method="post"
              name="gdsPortalLocal" id="gdsPortalLocal" target="_blank">
            <div class="row w-100">
                {include file="./sections/tour/internal/origin_city_tour.tpl"}
                {include file="./sections/tour/internal/destination_city_tour.tpl"}
                {include file="./sections/tour/internal/date_teravel.tpl"}
                <div class="p-1 col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                    <button type="button"  onclick="searchInternalTour()" class="btn theme-btn seub-btn b-0">
                        جستجو
                        <i class="far fa-search mr-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div id="tour_khareji">
        <form data-action="https://s360online.iran-tech.com/" class="d_contents w-100" method="post"
              name="gdsPortalLocal" id="gdsPortalLocal" target="_blank">
            <div class="row w-100">
                {include file="./sections/tour/international/country_origin.tpl"}
                {include file="./sections/tour/international/city_origin.tpl"}
                {include file="./sections/tour/international/country_destination.tpl"}
                {include file="./sections/tour/international/city_destination.tpl"}
                {include file="./sections/tour/international/date_travel.tpl"}
                <div class="p-1 col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                    <button type="button" onclick="searchInternationalTour()" class="btn theme-btn seub-btn b-0">
                        جستجو
                        <i class="far fa-search mr-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
