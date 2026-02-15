{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="services" assign="objServices"}

{assign var='checkAccessService' value=$objAgency->checkAccessSubAgency()}
{assign var="allServices" value=$objServices->getAllGroups()}

{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    <div class="client-head-content w-100">

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
        <div class="row mx-0">

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 half_padding_l pr-0">
                <div class="filterBox">
                    <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom padt10 padb10">
                        <p class="txt14">
                            <span class="txt15 iranM ">##Service##</span>
                        </p>
                    </div>

                    <div class="filtertip-searchbox site-main-text-color-drck ">
                        <div class="filter-content padb10 padt10">

                            {assign var="arrayServices" value=Functions::getServicesAgency()}
                            {assign var="checkedForFirst" value=0}
                            {assign var="hasAccessServices" value=[]}
                            {assign var="noAccessServices" value=[]}

                            {foreach from=$allServices item=item}
                                {assign var="mainServiceLower" value=$item.MainService|lower}

                                {if isset($arrayServices[$mainServiceLower])}
                                    {append var="hasAccessServices" value=$item}
                                {else}
                                    {append var="noAccessServices" value=$item}
                                {/if}
                            {/foreach}

                            {assign var="sortedServices" value=$hasAccessServices|@array_merge:$noAccessServices}

                            {foreach from=$sortedServices item=item}
                                {assign var="mainServiceLower" value=$item.MainService|lower}
                                {assign var="servicesByLanguage" value=Functions::ConvertArrayByLanguage($mainServiceLower)}

                                {if $mainServiceLower eq 'gashttransfer'}
                                    {assign var="mainServiceLower" value='GashtTransfer'|lower}
                                {/if}

                                {assign var="upperService" value=$mainServiceLower|ucfirst}
                                {assign var="hasAccess" value=false}
                                {if isset($arrayServices[$mainServiceLower])}
                                    {assign var="hasAccess" value=true}
                                {/if}

                                {$checkedForFirst = $checkedForFirst + 1}

                                <div class="UserBuy-tab-link current parent-box-services"
                                     data-tab="tab-{$mainServiceLower}"
                                        {if !$hasAccess}style="opacity: 0.6;" {/if}
                                >

                                    <input id="radio-{$mainServiceLower}" class="radio-custom"
                                           name="radio-group" type="radio"
                                           value="{$mainServiceLower}"
                                           {if $checkAccessService[0]|lower == $upperService|lower}checked{/if}
                                            {if !$hasAccess}disabled{/if}
                                           onchange="getCategoryData('#historyBuyAgency')">

                                    <label for="radio-{$mainServiceLower}" class="radio-custom-label"
                                           {if !$hasAccess}style="cursor: default;" {/if}
                                    >
                                        {$servicesByLanguage}
                                    </label>

                                    <input type="hidden" id="defaultService"
                                           value="{$checkAccessService[0]}"
                                           class="{if !$hasAccess}disable{/if}">
                                </div>
                            {/foreach}


                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-9 p-0">
                <table onclick="" id="historyBuyAgency" class="table table-sm">

                </table>
            </div>
            <div id="ModalResultProfile"></div>

        </div>
    </div>
{literal}
    <script src="assets/js/userBook/bookUserShow.js"></script>
    <script>
        $(document).ready(function () {
            getCategoryData('#historyBuyAgency');
        });

        function refreshData(targetTable) {
            targetTable.DataTable().clear().destroy();
            targetTable.children('tr').remove();
            targetTable.children('tbody').remove();
            targetTable.children('thead').remove();

        }

        function getCategoryData(targetTable) {
            let appType = $('input[name=radio-group]:checked').val();
            if(appType == 'GashtTransfer') {
                appType = 'gashttransfer' ;
            }
            targetTable = $(targetTable);

            console.log(targetTable.children('thead').length);
            if (targetTable.children('thead').length > 0) {
                refreshData(targetTable);
            }
            var columns = columnsType(appType);

            targetTable.DataTable({
                dom: "Bfrtip",
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': amadeusPath + "user_ajax.php",
                    'data': {
                        flag: 'agencyReport',
                        typeService: appType,
                        dataTable: true,
                    },
                },
                columns: columns

            });

        }


        function defaultColumns() {
            let defaultColumns = $('#defaultService').val();

            if(defaultColumns == 'GashtTransfer') {
                defaultColumns = 'gashttransfer' ;
            }
            switch (defaultColumns) {
                case 'flight':
                    return flightColumns();
                    break;

                case 'hotel':
                    return hotelColumns();
                    break;

                case 'insurance':
                    return insuranceColumns();
                    break;

                case 'gashttransfer':
                    return gashtTransferColumns();
                    break;

                case 'tour':
                    return tourColumns();
                    break;

                case 'visa':
                    return visaColumns();
                    break;

                case 'bus':
                    return busColumns();
                    break;

                case 'train':
                    return trainColumns();
                    break;
            }
        }



        function columnsType(appType) {
            if(appType == 'GashtTransfer') {
                appType = 'gashttransfer' ;
            }
            switch (appType) {
                case 'flight':
                    return flightColumns();
                    break;

                case 'hotel':
                    return hotelColumns();
                    break;

                case 'insurance':
                    return insuranceColumns();
                    break;

                case 'gashttransfer':
                    return gashtTransferColumns();
                    break;

                case 'tour':
                    return tourColumns();
                    break;

                case 'visa':
                    return visaColumns();
                    break;

                case 'bus':
                    return busColumns();
                    break;

                case 'train':
                    return trainColumns();
                    break;

                case 'entertainment':
                    return entertainmentColumns();
                    break;
                default:
                    return defaultColumns();


            }
        }

        function flightColumns() {
            return [

                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "مبدا/مقصد",
                    "data": "originOrDestination"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "شماره رزرو/شماره فاکتور",
                    "data": "requestNumberAndFactorNumber"
                }, {
                    "title": "شمارهpnr/شماره بلیط",
                    "data": "pnrAndETicketNumber"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }


        function hotelColumns() {
            return [

                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "نام هتل",
                    "data": "hotelName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "شماره رزرو/شماره فاکتور",
                    "data": "requestNumberAndFactorNumber"
                }, {
                    "title": "شماره واچر",
                    "data": "voucherNumber"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }


        function insuranceColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "مقصد",
                    "data": "destination"
                }, {
                    "title": "عنوان طرح",
                    "data": "namePlane"
                }, {
                    "title": "شماره فاکتور",
                    "data": "factorNumber"
                }, {
                    "title": "نام بیمه",
                    "data": "SourceName"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "جزییات",
                    "data": "linkPdfTicket"
                }
            ];
        }


        function gashtTransferColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "مقصد",
                    "data": "cityName"
                }, {
                    "title": "نوع گشت",
                    "data": "requestType"
                }, {
                    "title": "عنوان گشت",
                    "data": "serviceName"
                }, {
                    "title": "شماره فاکتور",
                    "data": "factorNumber"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }

        function tourColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "نام تور",
                    "data": "tourName"
                }, {
                    "title": "تاریخ رفت/برگشت",
                    "data": "DateDepartureOrReturned"
                }, {
                    "title": "شماره فاکتور",
                    "data": "factorNumber"
                }, {
                    "title": "قیمت کل",
                    "data": "priceTotal"
                }, {
                    "title": "قیمت پرداختی",
                    "data": "pricePayment"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }

        function visaColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "مقصد",
                    "data": "arrival"
                }, {
                    "title": "عنوان ویزا",
                    "data": "visaTitle"
                }, {
                    "title": "شماره فاکتور",
                    "data": "factorNumber"
                }, {
                    "title": "قیمت کل",
                    "data": "priceTotal"
                }, {
                    "title": "قیمت پرداختی",
                    "data": "pricePayment"
                }, {
                  "title": "جزییات",
                  "data": "linkPdfTicket"
               }
            ];
        }

        function busColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "مبدا/مقصد",
                    "data": "originOrDestination"
                }, {
                    "title": "تاریخ و زمان  حرکت",
                    "data": "moveDateAndTime"
                }, {
                    "title": "شماره بلیط/صندلی",
                    "data": "eTicketNumberAndChairs"
                }, {
                    "title": "شماره فاکتور",
                    "data": "factorNumber"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }


        function trainColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "مبدا/مقصد",
                    "data": "originOrDestination"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "شماره رزرو/شماره فاکتور",
                    "data": "requestNumberAndFactorNumber"
                }, {
                    "title": "شماره بلیط/شماره سریال",
                    "data": "ticketNumberAndSecurityNumber"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }

        function entertainmentColumns() {
            return [
                {
                    "title": "نام و نام خانوادگی",
                    "data": "passengerName"
                }, {
                    "title": "نام تفریح",
                    "data": "entertainmentTitleName"
                }, {
                    "title": "تاریخ خرید",
                    "data": "dateBuy"
                }, {
                    "title": "شماره فاکتور/شماره بلیط",
                    "data": "requestNumberAndFactorNumber"
                }, {
                    "title": "تعداد نفرات",
                    "data": "countPeople"
                }, {
                    "title": "قیمت",
                    "data": "price"
                }, {
                    "title": "دریافت بلیط",
                    "data": "linkPdfTicket"
                }
            ];
        }

    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}