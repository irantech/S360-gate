{if $smarty.const.TYPE_ADMIN eq 1}
    {load_presentation_object filename="airline" assign="objAirline"}
    {$objAirline->getAll()} {*گرفتن لیست ایرلاینها*}
    {assign var=airLineiataCode value=$objAirline->getAllIataCodes()}

    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>تنظیمات</li>
                    <li class="active">اطلاعات خطوط پروازی</li>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
            </div>

            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">اطلاعات خطوط پروازی</h3>
                    <p class="text-muted m-b-30">شما میتوانید کلیه خطوط پروازی را در این لیست مشاهده و ویرایش نمائید
                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <span class="pull-right">
                         <a href="infoFlightRouteAdd"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="mdi mdi-airplane-takeoff"></i></span>افزودن خطوط پروازی جدید
                </a>
                </span>
                        {/if}
                    </p>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>تصویر ایرلاین</th>
                                <th>یاتا استاندارد ایرلاین</th>
                                <th>نام</th>
                                <th>آمادئوسی</th>
                                <th>ترمینال ورودی مهرآباد</th>
                                <th>ترمینال خروجی مهرآباد</th>
                                <th>ترمینال ورودی امام خمینی</th>
                                <th>ترمینال خروجی امام خمینی</th>
                                <th>کمیسیون پرواز داخلی</th>
                                <th>کمیسیون پرواز خارجی</th>
                                <th>ویرایش</th>
                                <!--                   <th>فعال</th>
                                                   <th>حذف</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$objAirline->list}
                                {$number=$number+1}
                                <tr>
                                    <td>{$number}</td>
                                    <td><img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/airline/{$item.photo}"
                                             style="width: 50px;"></td>
                                    <td>
                                        <select
                                                class="form-control"
                                                name="airLineiataCode"
                                                onchange="selectIata(this.value, this.getAttribute('data-airline-id'))"
                                                data-airline-id="{$item.id}">
                                            <option value="">کد یاتا</option>
                                            {foreach key=key item=iataCode from=$airLineiataCode}
                                                <option value="{$iataCode.id}" {if $item.airline_iata_id eq $iataCode.id}
                                                    selected="selected"{/if}>({$iataCode.airline_uniqe_iata})
                                                </option>
                                            {/foreach}
                                        </select>
                                    </td>
                                    <td>
                                        {$item.name_fa}
                                        <br>
                                        {$item.name_en} / {$item.abbreviation}
                                    </td>

                                    <td>
                                        <select
                                                class="form-control"
                                                name="amadeusStatus"
                                                onchange="selectAmadeusStatus(this)"
                                                data-Iata="{$item.abbreviation}">
                                            <option value=""> انتخاب کنید...</option>
                                            <option value="1" {if $item.amadeusStatus eq '1'}
                                                selected="selected"{/if}>آری
                                            </option>
                                            <option value="2" {if $item.amadeusStatus eq '0'}
                                                selected="selected"{/if}>خیر
                                            </option>
                                        </select>
                                    </td>

                                    <td>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{$item.enter_thr}"
                                                   name="enter_thr"
                                                   id="enter_thr"
                                                   data-Iata="{$item.abbreviation}"
                                                   onchange="UpdateTerminalAirline(this)" />
                                        </div>

                                    </td>
                                    <td>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{$item.out_thr}"
                                                   name="out_thr"
                                                   id="out_thr"
                                                   data-Iata="{$item.abbreviation}"
                                                   onchange="UpdateTerminalAirline(this)" />
                                        </div>

                                    </td>
                                    <td>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{$item.enter_ika}"
                                                   name="enter_ika"
                                                   id="enter_ika"
                                                   data-Iata="{$item.abbreviation}"
                                                   onchange="UpdateTerminalAirline(this)" />
                                        </div>

                                    </td>
                                    <td>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{$item.out_ika}"
                                                   name="out_ika"
                                                   id="out_ika"
                                                   data-Iata="{$item.abbreviation}"
                                                   onchange="UpdateTerminalAirline(this)" />
                                        </div>

                                    </td>


                                    <td>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{$item.Commission_internal * 100}"
                                                   name="Commission_internal"
                                                   id="Commission_internal"
                                                   data-Iata="{$item.abbreviation}"
                                                   onchange="UpdateCommissionAirline(this)" />
                                        </div>
                                        %
                                    </td>
                                    <td>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <input type="text"
                                                   class="form-control"
                                                   value="{$item.Commission_external * 100}"
                                                   name="Commission_external"
                                                   id="Commission_external"
                                                   data-Iata="{$item.abbreviation}"
                                                   onchange="UpdateCommissionAirline(this)" />
                                        </div>
                                        %
                                    </td>
                                    <td>
                                        <a href="infoFlightRouteEdit&id={$item.id}"><i data-toggle="tooltip"
                                                                                       data-placement="top"
                                                                                       data-original-title="ویرایش "
                                                                                       class=" tooltip-primary fcbtn btn btn-outline btn-primary btn-1f mdi mdi-pencil"></i></a>
                                    </td>
                                    <!--                   <td><a href="administratorairlineShow&active={$item.id}">
                                                            {if $item.active eq 'on'}
                                                                    <i class="btn btn-success fa fa-check-square-o"></i>
                                                            {else}
                                                                    <i class="btn btn-danger fa fa-ban"></i>
                                                            {/if}
                                               </a></td>
                                               <td><a href="administratorairlineShow&delete={$item.id}"><i class="btn btn-danger fa fa-trash-o"></i></a></td>-->
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
{/if}

<script type="text/javascript" src="assets/JsFiles/airline.js"></script>
