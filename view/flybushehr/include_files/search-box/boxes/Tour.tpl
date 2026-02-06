{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Tour">
    {include file="./sections/tour/internal/btn_radio_internal_external.tpl"}
    <h5 class="title_searchBox">
        رزرو تور
    </h5>
    <div id="tour_dakheli" class="internal-tour-js">
        <div class="col-12">
            <div class='row'>
                <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                      name="gdsTourLocal" id="gdsTourLocal" target="_blank">
                    {include file="./sections/tour/internal/origin_city_tour.tpl"}
                    {include file="./sections/tour/internal/destination_city_tour.tpl"}
                    {include file="./sections/tour/internal/date_teravel.tpl"}
                    <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search">
                        <button onclick="searchInternalTour()" type="button" class="btn theme-btn seub-btn b-0">
                            <span class="fa fa-search"></span>
                            ##Search##
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="tour_khareji" class="international-tour-js">
        <div class="col-12">
            <div class='row'>
                <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                      name="gdsPortalLocal" id="gdsPortalLocal" target="_blank">
                    {include file="./sections/tour/international/country_origin.tpl"}
                    {include file="./sections/tour/international/city_origin.tpl"}
                    {include file="./sections/tour/international/country_destination.tpl"}
                    {include file="./sections/tour/international/city_destination.tpl"}
                    {include file="./sections/tour/international/date_travel.tpl"}

                    <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search">
                        <button onclick="searchInternationalTour()" type="button" class="btn theme-btn seub-btn b-0">
                            <span class="fa fa-search"></span>
                            ##Search##
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>