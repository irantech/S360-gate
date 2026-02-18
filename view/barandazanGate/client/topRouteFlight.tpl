{load_presentation_object filename="resultLocal" assign="objResult"}
{load_presentation_object filename="members" assign="objMembers"}
{$objResult->getAirportDeparture()}
<div id="lightboxContainer"></div>

<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 padt20 padr0 padl0">
    <!-- Result search -->


    <div class="filtertip site-bg-main-color site-bg-color-border-bottom ">
        <div class="tip-content padt25">
            <p class="counthotel txt16 iranM">##Date## :<a>{$objResult->DayOfWeek}، {$objResult->ToDay}</a></p>
        </div>
    </div>

    <!-- search box -->
    <div class=" s-u-update-popup-change">
        <form class="search-wrapper" action="" method="post">

            <div class="displayib padr20 padl20">
                <span class="fltr iranM lh35 txt666">##Oneway##</span>
                <span class="tzCBPart site-bg-filter-color multiWays marl20 marr20" onclick="changeWays(this)"></span>
                <span class="fltr iranM lh35 txt666">##Twoway##</span>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                    <select class="select2 option1" name="origin" id="origin_local" style="width:100%;" tabindex="2" onchange="select_Airport()">
                        <option value="">##Selection## ...</option>
                        {foreach $objResult->dep_airport as $Dep}
                            <option value="{$Dep.Departure_Code}"
                                    {if $Dep.Departure_Code==$smarty.const.SEARCH_ORIGIN}selected="selected" {/if}>{$Dep.Departure_City}
                                ({$Dep.Departure_Code})
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="swap-flight-box" onclick="reversOriginDestination()">
                <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                <div class="s-u-in-out-wrapper ">
                    <select class="select2 option1 " name="destination" id="destination_local" style="width:100%;"
                            tabindex="2">
                        <option value="0">##Selection## </option>
                    </select>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                <div class="s-u-form-date-wrapper">
                    <div class="s-u-date-pick">
                        <div class="s-u-jalali s-u-jalali-change">
                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                            <input class="deptCalendar" type="text" name="dept_date" id="dept_date_local"
                                   placeholder="##Wentdate##" readonly="readonly" value=""/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 hidden">
                <div class="s-u-form-date-wrapper">
                    <div class="s-u-date-pick">
                        <div class="s-u-jalali s-u-jalali-change">
                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                            <input class="returnCalendar" type="text" name="dept_date_return" id="dept_date_local_return"
                                   placeholder=" ##Returndate##" readonly="readonly" value="" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-input-wrapper">
                    <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                        <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add1"></i>
                        <input id="qty1" type="number" value="0" name="adult" min="0"
                               max="9">
                        <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus1"></i>
                    </p>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-input-wrapper">
                    <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                        <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add2"></i>
                        <input id="qty2" type="number" value="0" name="child" min="0"
                               max="9">
                        <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus2"></i>
                    </p>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-input-wrapper">
                    <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                        <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add3"></i>
                        <input id="qty3" type="number" value="0" name="infant" min="0"
                               max="9">
                        <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus3"></i>
                    </p>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-date-wrapper">
                    <div class="s-u-class-pick s-u-class-pick-change">
                        <i class="zmdi zmdi-airline-seat-recline-extra site-main-text-color"></i>
                        <select data-placeholder=" ##Classflight##" class="select2" name="classf" id="classf_local"
                                style="width:100%;" tabindex="2">
                            {if {$smarty.const.SEARCH_CLASSF} eq 'Y'}
                                <option value="Y" selected>##Economics##</option>
                                <option value="C">##Business##</option>
                            {else}
                                <option value="Y" selected>##Economics##</option>
                                <option value="C">##Business##</option>
                            {/if}
                        </select>
                    </div>
                </div>
            </div>

            <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                <a href="" onclick="return false" class="f-loader-check f-loader-check-bar" id="loader_check_submit"
                   style="display:none"></a>

                <button type="button" onclick="submitLocalSide()" id="sendFlight"
                        class="site-main-button-color s-u-jalali-color site-secondary-text-color">##Search##
                </button>
            </div>
        </form>

        <div class="message_error_portal"></div>
    </div>
</div>

<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 d-flex flex-wrap">
    {foreach $objFunctions->CodeCityDep() as $Dep}
        <div class="col-md-4 col-sm-6 col-xs-12 padt20 padb20">
            <div class="rote-Box site-bg-color-dock-border site-bg-color-dock-border-right-a site-bg-color-dock-border-left-a site-bg-color-dock-border-left-b site-bg-color-dock-border-right-b">
                <div class="rote-Box-inner">
                    <div class="rote-Box-tittle">##Flight##</div>
                    <div class="rote-Box-image site-bg-main-color site-bg-color-dock-border-right-b site-bg-color-dock-border-top">
                        <div class="rote-Box-image-border ">
                            <span class="currency ">##From##</span>
                            <span class="value ">{$Dep.Departure_City}</span>
                            <span class="duration">##To##</span>
                        </div>
                    </div>
                    <div class="rote-Box-body ">
                        {foreach $objFunctions->SelectArrival($Dep.Departure_Code) as $arrival}
                            <div class="one-rote-box">
                                <p> {$arrival['Arrival_City']} </p>
                                <span><a onclick="showModal('{$Dep.Departure_Code}','{$arrival.Arrival_Code}')">##Show##</a> </span>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    {/foreach}

    <div class="arzan-flight-15 arzan-flight-btn">
        <span class="close-flight-15"></span>
        <img src="assets/images/load.gif" id="loadbox" style="display: none;">
        <div id="ShowCalenderFlight">


        </div>
    </div>
</div>
{*
{if $objSession->IsLogin()}
    {if $objFunctions->popZomorod() eq 'NoCookie' && $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
        {load_presentation_object filename="Emerald" assign="objEmerald"}
        {load_presentation_object filename="members" assign="objMembers"}
        {assign var="infoZomorod" value=$objMembers->infoZomorod($objSession->getUserId())}
        {assign var="sumrequest" value=$objEmerald->sumRequestVerified({$objSession->getUserId()})}
        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
        <div id="ModalZomorod" class="modal">

            <div class="modal-content  zomorodModal" id="ModalZomorodContent ">
                <div class="">##Dearfriend## {$objSession->getNameUser()}<br/></div>
                <div class="modal-text-center">
                    <span>

                        {assign var="InfoZomoord" value=$infoZomorod}
                        {assign var="leaguePoints" value=$objFunctions->leaguePoints($infoZomorod)|number_format}
                        {assign var="sumrequest" value=$sumrequest}
                        {assign var="br" value="</br>"}
                        {assign var="Remind" value=($objFunctions->leaguePoints($infoZomorod))-($sumrequest)}
                        {functions::StrReplaceInXml(["@@infoZomorod@@"=>$InfoZomoord,"@@leaguePoints@@"=>$leaguePoints,"@@sumrequest@@"=>$sumrequest,"@@br@@"=>$br,"@@Remind@@"=>$Remind],"MessageInfoZomorod")}
</span>
                </div>
                <a href="https://www.iran-tech.com/league" target="_blank">
                    <div class="modal-text-center"><img src="assets/images/award.jpg" style="width: 90%;"><br/></div>
                    <div class="modal-text-center textNewsZomorod"> ##Showinrate## ...</div>
                </a>
            </div>

        </div>
    {/if}
{/if}
{/if}
*}
<script src="assets/js/script.js"></script>
<script type="text/javascript">

    $(document).click(function (event) {

        $("body").find("#ModalZomorod").fadeOut(300);
    });
    $(document).ready(function () {

        $("#ModalZomorod").fadeIn(500);


        $("#lightboxContainer").on("click", function () {
            $("#lightboxContainer").removeClass("lightboxContainerweek");
            $(".arzan-flight-btn").removeClass("displayBlock");
        });

        $('body').delegate(".close-flight-15", "click", function () {
            $("#lightboxContainer").removeClass("lightboxContainerweek");
            $(".arzan-flight-btn").removeClass("displayBlock");
        });


    });

</script>
