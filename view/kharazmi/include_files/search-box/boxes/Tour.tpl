<div class=" __box__ tab-pane active show" id="tour" role="tabpanel" aria-labelledby="tour-tab">
    <div id="tour_dakheli" class="_internal  row">
          <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                  name="gdsTourLocal" id="gdsTourLocal" target="_blank">
            {include file="./sections/tour/internal/origin_city_tour.tpl"}
            {include file="./sections/tour/internal/destination_city_tour.tpl"}
            {include file="./sections/tour/internal/date_teravel.tpl"}

            <div class="col-lg-3 p-1 col-md-6 col-sm-6 col-12 btn_s col_search margin-center">
                <button type="button" onclick="searchInternalTour()" class="btn theme-btn seub-btn b-0">
                    <span>جستجو</span>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="__box__ tab-pane" id="tour-kh" role="tabpanel" aria-labelledby="tour-kh-tab">
    <div id="tour_khareji" class="_external ">
        <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                  name="gdsPortalLocal" id="gdsPortalLocal" target="_blank">
            {include file="./sections/tour/international/country_origin.tpl"}
            {include file="./sections/tour/international/city_origin.tpl"}
            {include file="./sections/tour/international/country_destination.tpl"}
            {include file="./sections/tour/international/city_destination.tpl"}
            {include file="./sections/tour/international/date_travel.tpl"}

            <div class="col-lg-2 p-1 col-md-6 col-sm-6 col-12 btn_s col_search margin-center">
                <button type="button" onclick="searchInternationalTour()" class="btn theme-btn seub-btn b-0">
                    <span>جستجو</span>
                </button>
            </div>
        </form>
    </div>
</div>
