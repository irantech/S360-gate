{load_presentation_object filename="repeatStepSourceFour" assign="repeat"}
{assign var="Ticket" value=$repeat->Search($smarty.get.RequestNumber,$smarty.get.ClientID,$smarty.get.SourceId)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">تکرار مرحله سرچ بلیط </li>
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
                            <th>شماره پرواز</th>
                            <th>نام منبع</th>
                            <th>نام ایرلاین</th>
                            <th>قیمت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach key=key item=item from=$Ticket}
                            {foreach key=number item=Rout from=$item.OutputRoutes}

                                {assign var="bgColor" value=""}
                                {if $Rout.FlightNo eq $smarty.get.FlightNumber && $Rout.Airline.Code eq $smarty.get.AirLinIata && $Rout.CabinType eq $smarty.get.CabinType}
                                    {$bgColor = '#98f698'}
                                {elseif $Rout.FlightNo eq $smarty.get.FlightNumber && $Rout.Airline.Code eq $smarty.get.AirLinIata}
                                    {$bgColor = '#e6f8e6'}
                                {/if}

                                <tr id="ّflight-{$Rout.FlightNo}" {if $bgColor neq ''}style="background-color: {$bgColor}"{/if}>
                                    <td class="align-middle font20">{$Rout.FlightNo}</td>
                                    <td class="align-middle font20">{$item.SourceName}</td>
                                    <td class="align-middle font20">{$Rout.Airline.Name}</td>
                                    <td class="align-middle font20">{$Rout.CabinType}</td>
                                    <td class="align-middle font20">{(($item.PassengerDatas[0].BasePrice) * 10)|number_format}ریال </td>
                                    <td class="align-middle font20">
                                        <a class="fcbtn btn btn-outline btn-info btn-1c cursor-pointer popoverBox  popover-info mdi mdi-check"
                                             data-toggle="popover" title="تاییدو ادامه" data-placement="top"
                                             data-content="برای ادامه فرایند رزرو دکمه را فشار دهید" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepRevalidateAndPreReserveSourceFour?UniqueCode={$repeat->StepUniqueCode}&ClientID={$smarty.get.ClientID}&FlightID={$item.FlightID}&RequestNumber={$smarty.get.RequestNumber}&SourceId={$item.SourceId}">
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
