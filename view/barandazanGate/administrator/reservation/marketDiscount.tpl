{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{load_presentation_object filename="reservationHotel" assign="objHotel"}
{assign var="hotel" value=$objHotel->getHotelById(['id' => $smarty.get.id])}
{$objServicesDiscount->getAll()} {*گرفتن لیست تخفیف ها*}

{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

{assign var="discount" value=$objServicesDiscount->getDiscountByServiceAndMarketId('marketplaceHotel' , $smarty.get.id)} {*گرفتن لیست خدمات*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/marketHotel">لیست هتل ها</a></li>
                <li class="active">تخفیف ها</li>
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
                <h3 class="box-title m-b-0">لیست تخفیف های {$hotel['name']}</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید درصد تخفیف را اعمال کنید
                </p>
                <p class="text-muted m-b-30">
                    در صورت اعمال مارک آپ تخفیف از مارک اپ حساب میشود. در غیر اینصورت تخفیف از قیمت اصلی حساب میشود.
                </p>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>خدمات</th>

                            {foreach key=key item=item from=$objCounterType->list}
                                <th class="text-center">{$item.name}</th>
                            {/foreach}

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>تخفیف هتل</td>
                            {foreach key=keyCounter item=itemCounter from=$objCounterType->list}
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="hidden" name="service_id" class="service_id" value="{$hotel['id']}">
                                        <input type="text" value="{$discount['marketplaceHotel'][$itemCounter.id]['off_percent']}"
                                               class="form-control text-right serviceDiscount"
                                               data-toggle="tooltip" data-placement="top" data-original-title="{$itemCounter.name}"/>
                                        <input type="hidden" value="{$itemCounter.id}" class="counterID" />
                                        <input type="hidden" value="marketplaceHotel" class="serviceTitle" name="serviceTitle[]" />
                                    </div>
                                </td>
                            {/foreach}
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش تنظیمات تخفیف</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/396/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/servicesDiscount.js"></script>