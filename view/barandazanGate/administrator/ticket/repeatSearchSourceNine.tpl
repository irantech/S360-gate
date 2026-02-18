{load_presentation_object filename="repeatSearchSourceNine" assign="repeat"}

{if $smarty.get.TypeLevel eq 'Final'}
    {assign var="Ticket" value=$repeat->ReserveFinal($smarty.get.RequestNumber)}
        <div class="row">
                <div class="col-sm-12">
                        <div class="white-box">

                                {if $Ticket eq 'success'}
                                        رزرو با موفقیت انجام شد
                                {else}
                                    خطا در مرحله رزرو،ابتدا از رزرو نشدن بلیط مطمئن شوید و بعد از آن در صورتی که خطا از سمت سرور نبود مجدداد، ادامه رزرو انجام شود
                                {/if}

                        </div>

                </div>
        </div>

{else}
   {* {assign var="Ticket" value=$repeat->Search($smarty.get.RequestNumber,$smarty.get.ClientID, $smarty.get.Type)}
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class="active">تکرار مرحله سرچ بلیط  سرور 9</li>
                </ol>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
            </div>

            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">لیست پروازهای موجود</h3>
                    <p class="text-muted m-b-30">
                        <span>مبدا:{$objFunctions->NameCity($smarty.get.OriginIata)}</span><br/>
                        <span>مقصد:{$objFunctions->NameCity($smarty.get.DestinationIata)}</span><br/>
                        <span>ناریخ:{$smarty.get.DateFlight}</span>
                    </p>
                    <div class="table-responsive">
                        <table id="" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>شماره پرواز</th>
                                <th>نام ایرلاین</th>
                                <th>ساعت حرکت</th>
                                <th>شناسه نرخی</th>
                                <th>قیمت</th>
                                <th>نام منبع</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>

                            {foreach key=key item=item from=$Ticket}

                                {assign var="bgColor" value=""}
                                {if $item.OutputRoutes[0].FlightNo eq $smarty.get.FlightNumber && $item.OutputRoutes[0].Airline.Code eq $smarty.get.AirLinIata && $item.OutputRoutes[0].CabinType eq $smarty.get.CabinType}
                                    {$bgColor = '#98f698'}
                                {elseif $item.OutputRoutes[0].FlightNo eq $smarty.get.FlightNumber && $item.OutputRoutes[0].Airline.Code eq $smarty.get.AirLinIata}
                                    {$bgColor = '#e6f8e6'}
                                {/if}

                                <tr id="flight-{$Rout.FlightNo}" {if $bgColor neq ''}style="background-color: {$bgColor}"{/if}>
                                    <td>{$key+1}</td>
                                    <td class="align-middle font20">{$item.OutputRoutes[0].FlightNo}</td>
                                    <td class="align-middle font20">{$objFunctions->AirlineName($item.OutputRoutes[0].Airline.Code)}</td>
                                    <td class="align-middle font20">{$item.OutputRoutes[0].DepartureTime}</td>
                                    <td class="align-middle font20">{$item.OutputRoutes[0].CabinType}</td>
                                    <td class="align-middle font20">{$objFunctions->numberFormat($item.PassengerDatas[0].TotalPrice)}</td>
                                    <td class="align-middle font20">{$item.SourceName}</td>
                                    <td class="align-middle font20">
                                        <a class="fcbtn btn btn-outline btn-info btn-1c cursor-pointer popoverBox  popover-info mdi mdi-check"
                                           data-toggle="popover" title="تاییدو ادامه" data-placement="top"
                                           data-content="برای ادامه فرایند رزرو دکمه را فشار دهید" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepRevalidateAndPreReserveSourceNine?UniqueCode={$repeat->StepUniqueCode}&ClientID={$smarty.get.ClientID}&FlightID={$item.FlightID}&RequestNumber={$smarty.get.RequestNumber}&SourceId={$item.SourceId}">
                                        </a>
                                    </td>
                                </tr>

                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>*}

{/if}

