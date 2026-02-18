{load_presentation_object filename="cancellationFeeSetting" assign="ObjFee"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="airlines" value=$ObjFee->cancellationFeeByAirlineIataList()}
{assign var="Row" value=$objFunctions->Xmlinformation('Row')}
{assign var="RateiD" value=$objFunctions->Xmlinformation('RateiD')}
{assign var="Uptodavazdahnoonsedaysbeforeflight" value=$objFunctions->Xmlinformation('Uptodavazdahnoonsedaysbeforeflight')}
{assign var="Uptodavazdanoonyekdaybeforeflight" value=$objFunctions->Xmlinformation('Uptodavazdanoonyekdaybeforeflight')}
{assign var="Uptosehoursbeforeflight" value=$objFunctions->Xmlinformation('Uptosehoursbeforeflight')}
{assign var="Upciminutesbeforeflight" value=$objFunctions->Xmlinformation('Upciminutesbeforeflight')}
{assign var="Fromlastciminuteslater" value=$objFunctions->Xmlinformation('Fromlastciminuteslater')}

<div class="loaderPublic" style="display: none;">
    <div class="positioning-container">
        <div class="spinning-container">
            <div class="airplane-container">
                <span class="zmdi zmdi-airplane airplane-icon site-main-text-color"></span>
            </div>
        </div>
    </div>

    <div class='loader'>
        <div class='loader_overlay'></div>
        <div class='loader_cogs'>
            <i class="fa fa-globe site-main-text-color-drck"></i>
        </div>
    </div>
</div>
<div class="loaderPublicForHotel" style="display: none;"></div>

<div class="d-flex flex-wrap">
    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 no-padding">
        <div class="filterBox">
            <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom padt10 padb10">
                <p class="txt14">
                    <span class="txt15 iranM ">##Airline##</span>
                </p>
                <button class="button_filtertip_hotel btn btn-primary">نمایش بیشتر</button>
            </div>

            <div class="filtertip-searchbox site-main-text-color-drck p-0 border">
                <div class="filter-content padb10 padt10">

                    <table class="table table-striped m-0">
                        <tbody>
                        {foreach $airlines as $key => $eachAirline}
                                <tr class="UserBuy-tab-link {if $key eq 0}current{/if}" data-tab="tab-{$eachAirline.abbreviation}">
                                    <td class="p-0">
                                        <label for="radio-{$eachAirline.abbreviation}" class="radio-custom-label m-0 d-flex align-items-center px-3 py-2">
                                            <input id="radio-{$eachAirline.abbreviation}" class="radio-custom ml-1" name="radio-group" type="radio" {if $key eq 0}checked="checked"{/if}>
                                            {$eachAirline.name_fa}
                                        </label>
                                    </td>
                                </tr>
                        {/foreach}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12" id="result">

        <div class="main-Content-bottom-table Dash-ContentL-B-Table">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                <i class="icon-table"></i>
                <h3>##Percentageofconsoles## :</h3>
            </div>


            {foreach $airlines as $key => $eachAirline}
                <div id="tab-{$eachAirline.abbreviation}" class="content-table UserBuy-tab-content {if $key eq 0}current{/if}">
                    <table class="display doDataTable" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{$Row}</th>
                            <th>{$RateiD}</th>
                            <th>{$Uptodavazdahnoonsedaysbeforeflight}</th>
                            <th>{$Uptodavazdanoonyekdaybeforeflight}</th>
                            <th>{$Uptosehoursbeforeflight}</th>
                            <th>{$Upciminutesbeforeflight}</th>
                            <th>{$Fromlastciminuteslater}</th>
                        </tr>
                        </thead>

                        <tbody>
                        {assign var="number" value="1"}
                        {foreach key=key item=item from=$eachAirline.feeList}
                            <tr>
                                <td data-content="{$Row}">{$number++}</td>
                                <td data-content="{$RateiD}" class="align-middle">{$item.TypeClass}</td>
                                <td data-content="{$Uptodavazdahnoonsedaysbeforeflight}" class="align-middle">{$item.ThreeDaysBefore} {if (int)$item.ThreeDaysBefore} % {/if}</td>
                                <td data-content="{$Uptodavazdanoonyekdaybeforeflight}" class="align-middle">{$item.OneDaysBefore} {if (int)$item.OneDaysBefore} % {/if}</td>
                                <td data-content="{$Uptosehoursbeforeflight}" class="align-middle">{$item.ThreeHoursBefore} {if (int)$item.ThreeHoursBefore} % {/if}</td>
                                <td data-content="{$Upciminutesbeforeflight}" class="align-middle">{$item.ThirtyMinutesAgo} {if (int)$item.ThirtyMinutesAgo} % {/if}</td>
                                <td data-content="{$Fromlastciminuteslater}" class="align-middle">{$item.OfThirtyMinutesAgoToNext} {if (int)$item.OfThirtyMinutesAgoToNext} % {/if}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            {/foreach}

        </div>
    </div>
</div>

{literal}
    <script type="text/javascript">
        $('.doDataTable').DataTable({
            "aLengthMenu": [ 25, 50, 100, 200 ]
        });

        $(document).ready(function () {
            $('.UserBuy-tab-link').click(function () {
                var tab_id = $(this).attr('data-tab');
                $('.UserBuy-tab-link').removeClass('current');
                $('.UserBuy-tab-content').removeClass('current');
                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            });

            $(".UserBuy-tab-content").hide();
            $(".UserBuy-tab-content:first").show();


            $('input[name=radio-group]').change((e)=>{
                $(".UserBuy-tab-content").hide();
                let indexElemnt = e.target.id
                let indexElemntReplace = indexElemnt.replace("radio", "tab");
                let indexElemntReplaceSharp = "#"+indexElemntReplace
                $(indexElemntReplaceSharp).show()
            })

          function myFunction(x) {
            if (x.matches) { // If media query matches
              $(".button_filtertip_hotel").click(function() {
                $(this).text("نمایش کمتر")
                $(".filtertip-searchbox").toggleClass("filtertip-searchboxActive")
              })
            }
          }
          var x = window.matchMedia("(max-width: 992px)")
          myFunction(x) // Call listener function at run time
          x.addListener(myFunction) // Attach listener function on state changes

        });
    </script>
{/literal}