{load_presentation_object filename="priceChanges" assign="objPriceChanges"}
{$objPriceChanges->getAll()} {*گرفتن لیست تغییرات قیمت*}

{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

{load_presentation_object filename="airline" assign="objAirline"}
{$objAirline->getActiveCharterAirlines()} {*گرفتن لیست ایرلاین های فعال*}
{$objAirline->getAll()} {*گرفتن لیست ایرلاین های فعال*}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تغییرات قیمت بلیط</li>
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
                <h3 class="box-title m-b-0">لیست تغییرات قیمت پروازهای داخلی</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید تغییرات قیمت را اعمال کنید
                    <span class="pull-right m-l-10">
                        <a href="priceChangesHistory&type=international" class="btn btn-info waves-effect waves-light" type="button">
                            <span class="btn-label"><i class="fa fa-history"></i></span>سوابق تغییرات قیمت پروازهای خارجی
                        </a>
                    </span>
                    <span class="pull-right">
                        <a href="priceChangesHistory&type=local" class="btn btn-info waves-effect waves-light" type="button">
                            <span class="btn-label"><i class="fa fa-history"></i></span>سوابق تغییرات قیمت پروازهای داخلی
                        </a>
                    </span>
                </p>

                <form id="localFlightPriceChangesAll" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="localFlightPriceChangesAll">

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="localPriceChangesAll" class="control-label">اعمال تغییر قیمت بر روی تمامی ایرلاین ها</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" name="localPriceChangesAll" id="localPriceChangesAll" />
                                <span class="input-group-addon">
                                    <select name="localChangeTypeAll" id="localChangeTypeAll">
                                        <option value="cost">ریال</option>
                                        <option value="percent">%</option>
                                    </select>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                            <button type="submit" class="btn btn-primary" style="margin-left: 5px;">اعمال تغییر روی همه</button>
                            <button type="button" class="btn btn-danger localResetForm">ریست</button>
                        </div>
                    </div>
                </form>

                <p>برای اعمال تغییرات، ابتدا نوع افزایش قیمت (ریال یا %) را انتخاب نموده، سپس مقدار را تغییر دهید</p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ایرلاین</th>

                            {foreach key=key item=item from=$objCounterType->list}
                                <th class="text-center">{$item.name}</th>
                            {/foreach}

                        </tr>
                        </thead>
                        <tbody>
                            {foreach key=keyAirline item=itemAirline from=$objAirline->clientActiveCharter}
                                {assign var="airline" value=$objAirline->getByAbb($itemAirline.airline_iata)}
                                <tr>
                                    <td>{$airline.name_fa} ({$itemAirline.airline_iata})</td>

                                    {foreach key=keyCounter item=itemCounter from=$objCounterType->list}

                                        {if $objPriceChanges->list['local'][$itemAirline.airline_iata][$itemCounter.id]['changeType'] == 'percent'}
                                            {assign var='priceVal' value=$objPriceChanges->list['local'][$itemAirline.airline_iata][$itemCounter.id]['price']}
                                        {else}
                                            {assign var='priceVal' value=$objPriceChanges->list['local'][$itemAirline.airline_iata][$itemCounter.id]['price']|number_format:0}
                                        {/if}
                                        <td>
                                            <div class="input-group">
                                                <input type="text" value="{$priceVal}" class="form-control text-right changePrice"
                                                       data-toggle="tooltip" data-placement="top" data-original-title="{$itemCounter.name}" />
                                                <span class="input-group-addon">
                                                    <select class="changeType">
                                                        <option value="cost" {if $objPriceChanges->list['local'][$itemAirline.airline_iata][$itemCounter.id]['changeType'] == 'cost'} selected="selected" {/if}>ریال</option>
                                                        <option value="percent" {if $objPriceChanges->list['local'][$itemAirline.airline_iata][$itemCounter.id]['changeType'] == 'percent'} selected="selected" {/if}>%</option>
                                                    </select>
                                                </span>
                                                <input type="hidden" value="{$itemCounter.id}" class="counterID" />
                                                <input type="hidden" value="{$itemAirline.airline_iata}" class="airlineAbbr" />
                                                <input type="hidden" value="local" class="locality" />
                                            </div>
                                        </td>
                                    {/foreach}

                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست تغییرات قیمت پروازهای خارجی</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید تغییرات قیمت را اعمال کنید
                </p>

                <form id="internationalFlightPriceChangesAll" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="internationalFlightPriceChangesAll">

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="internationalPriceChangesAll" class="control-label">اعمال تغییر قیمت بر روی تمامی ایرلاین ها</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" name="internationalPriceChangesAll" id="internationalPriceChangesAll" />
                                <span class="input-group-addon">
                                    <select name="internationalChangeTypeAll" id="internationalChangeTypeAll">
                                        <option value="cost">ریال</option>
                                        <option value="percent">%</option>
                                    </select>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                            <button type="submit" class="btn btn-primary" style="margin-left: 5px;">اعمال تغییر روی همه</button>
                            <button type="button" class="btn btn-danger internationalResetForm">ریست</button>
                        </div>
                    </div>
                </form>

                <p>برای اعمال تغییرات، ابتدا نوع افزایش قیمت (ریال یا %) را انتخاب نموده، سپس مقدار را تغییر دهید</p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ایرلاین</th>

                            {foreach key=key item=item from=$objCounterType->list}
                            <th class="text-center">{$item.name}</th>
                            {/foreach}

                        </tr>
                        </thead>
                        <tbody>
                            {foreach key=keyAirline item=itemAirline from=$objAirline->list}
                                {assign var="airline" value=$objAirline->getByAbb($itemAirline.airline_iata)}
                                <tr>
                                    <td>{$itemAirline.name_fa} ({$itemAirline.abbreviation})</td>

                                    {foreach key=keyCounter item=itemCounter from=$objCounterType->list}

                                        {if $objPriceChanges->list['international'][$itemAirline.airline_iata][$itemCounter.id]['changeType'] == 'percent'}
                                            {assign var='priceVal' value=$objPriceChanges->list['international'][$itemAirline.abbreviation][$itemCounter.id]['price']}
                                        {else}
                                            {assign var='priceVal' value=$objPriceChanges->list['international'][$itemAirline.abbreviation][$itemCounter.id]['price']|number_format:0}
                                        {/if}
                                        <td>
                                            <div class="input-group">
                                                <input type="text" value="{$priceVal}" class="form-control text-right changePrice"
                                                       data-toggle="tooltip" data-placement="top" data-original-title="{$itemCounter.name}" />
                                                <span class="input-group-addon">
                                                    <select class="changeType">
                                                        <option value="cost" {if $objPriceChanges->list['international'][$itemAirline.abbreviation][$itemCounter.id]['changeType'] == 'cost'} selected="selected" {/if}>ریال</option>
                                                        <option value="percent" {if $objPriceChanges->list['international'][$itemAirline.abbreviation][$itemCounter.id]['changeType'] == 'percent'} selected="selected" {/if}>%</option>
                                                    </select>
                                                </span>
                                                <input type="hidden" value="{$itemCounter.id}" class="counterID" />
                                                <input type="hidden" value="{$itemAirline.abbreviation}" class="airlineAbbr" />
                                                <input type="hidden" value="international" class="locality" />
                                            </div>
                                        </td>
                                    {/foreach}

                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش تغییرات قیمت پرواز   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/360/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/priceChanges.js"></script>