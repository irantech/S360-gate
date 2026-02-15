{load_presentation_object filename="resultLocal" assign="objResult"}
{$objResult->getAirportArrival($smarty.const.SEARCH_ORIGIN_CITY)}
{$objResult->GetNameDeparture($smarty.const.SEARCH_ORIGIN_CITY)}
{$objResult->GetNameArrival($smarty.const.SEARCH_DESTINATION_CITY)}
{$objResult->DateJalali($smarty.const.SEARCH_DEPT_DATE)}

{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}

{load_presentation_object filename="resultReservationTicket" assign="objReservation"}

<div class="s-u-black-container"></div>
<div class="s-u-content-result">
    <!-- right menu filters -->
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 no-padding">
        <!-- Result search -->
        <div class="filtertip site-bg-main-color site-bg-color-border-bottom ">
            <a href="{$smarty.const.ROOT_ADDRESS}/resultBus/{$smarty.const.SEARCH_ORIGIN_CITY}-{$smarty.const.SEARCH_DESTINATION_CITY}/{$objResult->DatePrev($smarty.const.SEARCH_DEPT_DATE)}/{$smarty.const.SEARCH_ADULT}-{$smarty.const.SEARCH_CHILD}-{$smarty.const.SEARCH_INFANT}">
                <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                    <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color">
                        <span class="tooltiptextWeightDay"> ##Previousday##  </span>
                    </i>
                </span>
            </a>
            <div class="tip-content">
                <p class="">
                    <span class=" bold counthotel">{$objResult->dep_city['Departure_City']}</span>
                </p>
                <p class="counthotel txt12">##Date## :<a>{$objResult->day}، {$objResult->date_now}</a></p>
            </div>
            <a href="{$smarty.const.ROOT_ADDRESS}/resultBus/{$smarty.const.SEARCH_ORIGIN_CITY}-{$smarty.const.SEARCH_DESTINATION_CITY}/{$objResult->DateNext($smarty.const.SEARCH_DEPT_DATE)}/{$smarty.const.SEARCH_ADULT}-{$smarty.const.SEARCH_CHILD}-{$smarty.const.SEARCH_INFANT}">
                <span class=" chooseiconDay icons tooltipWeighDay left site-border-text-color">
                    <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                        <span class="tooltiptextWeightDay"> ##Nextday##  </span>
                    </i>
                </span>
            </a>
        </div>
        <!-- search box -->
        <div class=" s-u-update-popup-change">
            <form class="search-wrapper" action="" method="post">

                <input type="hidden" name="origin_city" id="origin_city" value="{$smarty.const.SEARCH_ORIGIN_CITY}">
                <input type="hidden" name="destination_city" id="destination_city"
                       value="{{$smarty.const.SEARCH_DESTINATION_CITY}}">

                {*<div class="displayib padr20 padl20">
                    <span class="fltr iranM lh35 txt666" style="width: 65%;">نمایش تورها تا +30 روز</span>
                    <span class="tzCBPart site-bg-filter-color {if $smarty.const.TIME_INTERVAL eq 'all'}checked{/if}"
                          onclick="viewAllBus(this)" id="isShowAll"></span>
                </div>*}

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-date-wrapper">
                        <div class="s-u-date-pick">
                            <div class="s-u-jalali s-u-jalali-change">
                                <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                <input class="shamsiDeptCalendar" type="text" name="dept_date" id="dept_date_local"
                                       placeholder="##Wentdate##" readonly="readonly"
                                       value="{$objResult->DateJalaliRequest}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-input-wrapper">
                        <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add1"></i>
                            <input id="qty1" type="number" value="{$smarty.const.SEARCH_ADULT}" name="adult" min="0"
                                   max="9">
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus1"></i>
                        </p>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-input-wrapper">
                        <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add2"></i>
                            <input id="qty2" type="number" value="{$smarty.const.SEARCH_CHILD}" name="child" min="0"
                                   max="9">
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus2"></i>
                        </p>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-input-wrapper">
                        <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add3"></i>
                            <input id="qty3" type="number" value="{$smarty.const.SEARCH_INFANT}" name="infant" min="0"
                                   max="9">
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus3"></i>
                        </p>
                    </div>
                </div>


                <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                    <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                       id="loader_check_submit_7"
                       style="display:none"></a>
                    <button type="button" onclick="searchReservationBus('7')" id="sendFlight_7"
                            class="site-bg-main-color">##Search##
                    </button>
                </div>
            </form>

            <div class="message_error_portal"></div>
        </div>

        <ul id="s-u-filter-wrapper-ul">
            <span class="s-u-close-filter"></span>


            <li class="s-u-filter-item" data-group="flight-price">
                <span class="s-u-filter-title site-main-text-color-drck"><i
                            class="site-main-text-color"></i>##Showtoursfifteendays##</span>
                <div class="s-u-update-popup-change">
                    <div class="search-wrapper">
                        <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                            <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                               id="loader_check_submit_15"
                               style="display:none"></a>
                            <button type="button" onclick="searchReservationBus('15')" id="sendFlight_7"
                                    class="site-bg-main-color" style="width: 80%;">##Search##
                            </button>
                        </div>
                    </div>
                </div>
            </li>

            <!-- time filter -->
            <li class="s-u-filter-item" data-group="flight-time">
                <span class="s-u-filter-title site-main-text-color-drck"><i
                            class="zmdi zmdi-time site-main-text-color"></i>  ##RunTime##</span>
                <div class="s-u-filter-content">
                    <ul class="s-u-filter-item-time filter-time-ul">
                        <li>
                            <label>##All##</label>
                            <input class="check-switch" type="checkbox" id="filter-time" value="all"/>
                            <span class="tzCBPart site-bg-filter-color checked filter-to-check"
                                  onclick="filterBus(this)"></span>
                        </li>

                        <li>
                            <label>##Timedawn## <i>(0-8)</i></label>
                            <input class="check-switch" type="checkbox" id="filter-early" value="early"/>
                            <span class="tzCBPart site-bg-filter-color " onclick="filterBus(this)"></span>
                        </li>

                        <li>
                            <label>##Timemorning## <i>(8-12)</i></label>
                            <input class="check-switch" type="checkbox" id="filter-morning" value="morning"/>
                            <span class="tzCBPart site-bg-filter-color" onclick="filterBus(this)"></span>
                        </li>

                        <li>
                            <label>##Timeevening## <i>(12-18)</i></label>
                            <input class="check-switch" type="checkbox" id="filter-afternoon" value="afternoon"/>
                            <span class="tzCBPart site-bg-filter-color" onclick="filterBus(this)"></span>
                        </li>

                        <li>
                            <label>##Timenight## <i>(18-24)</i></label>
                            <input class="check-switch" type="checkbox" id="filter-night" value="night"/>
                            <span class="tzCBPart site-bg-filter-color" onclick="filterBus(this)"></span>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>


    <div id="result" class="col-lg-9 col-md-12 col-sm-12 col-xs-12">

        <div class="ticket-loader">
            <div class="positioning-container">
                <div class="spinning-container">
                    <div class="airplane-container2">
                        <img src="assets/images/air-plane.png" class="airplane-icon site-main-text-color"
                             style="width: 50px;height: 50px;"></div>
                </div>

                <div class='time-loading'>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <span id="rotate">
					<div>25</div>
					<div>24</div>
					<div>23</div>
					<div>22</div>
					<div>21</div>
					<div>20</div>
					<div>19</div>
					<div>18</div>
					<div>17</div>
					<div>16</div>
					<div>15</div>
					<div>14</div>
					<div>13</div>
					<div>12</div>
					<div>11</div>
					<div>10</div>
					<div>9 </div>
					<div>8 </div>
					<div>7 </div>
					<div>6 </div>
					<div>5 </div>
					<div>4 </div>
					<div>3 </div>
					<div>2 </div>
					<div>1 </div>
				</span>

                    <div class="TextLoaderPage">
                       ##Systemreloadinformation##
                        </br>
                        ##Pleasewait##
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    getResultReservationBus('{$smarty.const.SEARCH_ORIGIN_CITY}', '{$smarty.const.SEARCH_DESTINATION_CITY}', '{$smarty.const.SEARCH_DEPT_DATE}', '{$smarty.const.SEARCH_ADULT}', '{$smarty.const.SEARCH_CHILD}', '{$smarty.const.SEARCH_INFANT}', '{$smarty.const.TIME_INTERVAL}');
</script>

</div>

</div>

<input type="hidden" value="{$smarty.const.SEARCH_MULTI_WAY}" name="MultiWayTicket" id="MultiWayTicket"/>
<input type="hidden" value="" name="PrivateCharter" id="PrivateCharter">
<input type="hidden" value="" name="IdPrivate" id="IdPrivate">

<!-- login and register popup -->
{assign var="useType" value="ticket"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


<form method="post" id="formAjax" action="">
    <input id="temporary" name="temporary" type="hidden" value="">
    <input id="ZoneFlight" name="ZoneFlight" type="hidden" value="">
    <input type="hidden" value='{$objResult->set_session_passenger()}' name="PostPassenger" id="PostPassenger">
</form>

<script src="assets/js/script.js"></script>

{literal}
    <!-- modal -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').delegate('.DetailSelectTicket', 'click', function () {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });
        });
    </script>
    <!-- loader -->
    <script type="text/javascript">
        (function ($) {
            $.fn.extend({
                rotaterator: function (options) {

                    var defaults = {
                        fadeSpeed: 100,
                        pauseSpeed: 200,
                        child: null
                    };

                    var options = $.extend(defaults, options);

                    return this.each(function () {
                        var o = options;
                        var obj = $(this);
                        var items = $(obj.children(), obj);
                        items.each(function () {
                            $(this).hide();
                        })
                        if (!o.child) {
                            var next = $(obj).children(':first');
                        } else {
                            var next = o.child;
                        }
                        $(next).fadeIn(o.fadeSpeed, function () {
                            $(next).delay(o.pauseSpeed).fadeOut(o.fadeSpeed, function () {
                                var next = $(this).next();
                                if (next.length == 0) {
                                    next = $(obj).children(':first');
                                }
                                $(obj).rotaterator({
                                    child: next,
                                    fadeSpeed: o.fadeSpeed,
                                    pauseSpeed: o.pauseSpeed
                                });
                            })
                        });
                    });
                }
            });
        })(jQuery);

        $(document).ready(function () {
            $('#rotate').rotaterator({
                fadeSpeed: 1000,
                pauseSpeed: 200,
            });

        });

    </script>
{/literal}

<script type="text/javascript" src="assets/js/addressxml.js"></script>
