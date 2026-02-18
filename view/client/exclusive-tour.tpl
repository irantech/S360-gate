
<link href="/gds/dist/css/exclusiveTour.css" rel='stylesheet' />
<div class="w-100 position-unset" id="vueApp">
    <exclusive-tour :const-data="{
            'is_internal':`{$smarty.const.TOUR_SEARCH_IS_INTERNAL}`,
            'dept_date':`{$smarty.const.TOUR_SEARCH_DEPT_DATE}`,
            'return_date':`{$smarty.const.TOUR_SEARCH_RETURN_DATE}`,
            'origin':`{$smarty.const.TOUR_SEARCH_ORIGIN}`,
            'destination':`{$smarty.const.TOUR_SEARCH_DESTINATION}`,
            'rooms':`{$smarty.const.TOUR_SEARCH_ROOMS}`,
            }"></exclusive-tour>
</div>

<script src="/gds/dist/js/exclusiveTour.js"></script>