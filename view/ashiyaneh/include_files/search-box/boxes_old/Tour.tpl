<div class="__box__ tab-pane active {if $active} active {/if}" id="Tour">
    <div class="_internal internal-tour-js" id="internal_tour">
        <div class="col-12">
            <div class="row">
                <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsTourLocal" method="post"
                      name="gdsTourLocal" target="_blank">
                    {include file="./sections/Tour/internal/origin_city_tour.tpl"}
                    {include file="./sections/Tour/internal/destination_city_tour.tpl"}
                    {include file="./sections/Tour/internal/date_teravel.tpl"}
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                        <button class="btn theme-btn seub-btn b-0" onclick="searchInternalTour()" type="button">
                            <span>
                            <i class="fa-solid fa-magnifying-glass">
                            </i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
