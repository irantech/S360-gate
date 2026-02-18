{load_presentation_object filename="manifestTourController" assign="objResultManifest"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}
{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="correctDate" value=$objDateTimeSetting->jdate("Y-m-d", '', '', '', 'en') }
{else}
    {assign var="correctDate" value=date("Y-m-d") }
{/if}
{*{$smarty.session.AgencyId}*}
{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}

    <div class="client-head-content w-100">
        <div class="main-Content-bottom-table Dash-ContentL-B-Table">
            <div class="content-table">
                <table id="tourList" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>##Row##</th>
                        <th>##Createdate##<br>##Createhour##</th>
                        <th>##Nametour##<br>##Codetour##</th>
                        <th>##Datestarthold##<br>##Dateendhold##</th>
                        <th>##Countnight##<br>##Countday##</th>
                        <th>##counterName##</th>
                        <th>##countReserve##</th>
                        <th>##Status##</th>
                    </tr>
                    </thead>

                    <tbody>
                    {assign var="number" value="0"}
                    {assign var="reportTour" value=$objResultManifest->reportTourManifest($smarty.session.AgencyId)}

                    {foreach key=key item=item from=$reportTour}
                        {$number=$number+1}

                        {if 1|in_array:$item['tour_type_id']}
                            {assign var="isOneDayTour" value="yes"}
                        {else}
                            {assign var="isOneDayTour" value="no"}
                        {/if}

                        <tr>
                            <td data-content="##Row##">{$number}</td>

                            <td data-content="##Createdate##">{$item['create_date_in']}
                                <hr style="color: #f4fffe;">{$item['create_time_in']}
                            </td>
                            <td data-content="##Nametour##">{$item[$objFunctions->ChangeIndexNameByLanguage($item['language'],'tour_name')]}
                                <hr style="color: #f4fffe;">{$item['tour_code']}
                            </td>
                            <td data-content="##Datestarthold##">{$objFunctions->convertDate($item['minDate'])}
                                <hr style="color: #f4fffe;">{$objFunctions->convertDate($item['maxDate'])}
                            </td>
                            <td data-content="##Countnight##">
                                {$item['night']} ##Night##
                                <hr style="color: #f4fffe;">{$item['day']} ##Day##
                            </td>

                            <td data-content="##CounterName##">
                                <div class="counter-info">
                                    <div class="counter-name">{$item['counter_name']}</div>
                                    <div class="counter-mobile">Mobile: {$item['counter_mobile']}</div>
                                </div>
                            </td>

                            <td data-content="##countReserve##">
                                <div class="reserve-count-wrapper">
                                    <button class="reserve-count-btn" onclick="modalListForReserveTour('{$item.tour_code}');">
                                        <span class="reserve-icon">👥</span>
                                        <span class="reserve-number">{$objResultManifest->getTourBookingCount($item['tour_code'])}</span>
                                        <span class="reserve-text">رزرو</span>
                                    </button>
                                </div>
                            </td>

                            <td data-content="##Status##">
                                <div class="status-container">
                                    {if $objFunctions->convertDate($item['maxDate']) le $correctDate}
                                        <div class="status-badge status-expired">
                                            <i class="icon-clock"></i>
                                            <span>##Expired##</span>
                                        </div>
                                    {else}
                                        {if $item['is_show'] eq ''}
                                            <div class="status-badge status-pending">
                                                <i class="icon-hourglass"></i>
                                                <span>##Pending##</span>
                                            </div>
                                        {elseif $item['is_show'] eq 'yes'}
                                            <div class="status-badge status-active">
                                                <i class="icon-check"></i>
                                                <span>##Showinsite##</span>
                                            </div>
                                        {elseif $item['is_show'] eq 'no'}
                                            <div class="status-badge status-inactive">
                                                <i class="icon-block"></i>
                                                <span>##Disallowshowinssite##</span>
                                            </div>
                                        {/if}
                                    {/if}
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="ModalPublic" class="modal">
        <div class="modal-content" id="ModalPublicShowReserveList"></div>
    </div>



{literal}
    <script>
       $(document).ready(function() {
          $('#tourList').DataTable({
             "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json"
             },
             "pageLength": 10,
             "ordering": true,
             "searching": true
          });
       });
    </script>

    <script type="text/javascript">
       function modalListForReserveTour(tour_code) {
          setTimeout(function () {
             $('.loaderPublicForHotel').fadeOut(500);
             $("#ModalPublic").fadeIn(700);
          }, 1000);

          $.post(libraryPath + 'ModalCreatorForTour.php',
             {
                Controller: 'manifestTourController',
                Method: 'ModalShowForReserveTour',
                factorNumber: tour_code
             },
             function (data) {
                $('#ModalPublicShowReserveList').html(data);
             });
       }
    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}