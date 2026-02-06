{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{$objServicesDiscount->getAll()} {*گرفتن لیست تخفیف ها*}

{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

{$objServicesDiscount->getAllServices()} {*گرفتن لیست خدمات*}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
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
                <h3 class="box-title m-b-0">لیست تخفیف ها</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید درصد تخفیف را اعمال کنید
                </p>

                <form id="servicesDiscountAll" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="servicesDiscountAll">

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="serviceDiscountAll" class="control-label">اعمال تخفیف بر روی تمامی خدمات</label>
                            <div class="input-group">
                                <span class="input-group-addon">%</span>
                                <input type="text" class="form-control text-right" name="serviceDiscountAll" id="serviceDiscountAll" />
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                            <button type="submit" class="btn btn-primary" style="margin-left: 5px;">اعمال تغییر روی همه</button>
                            <button type="button" class="btn btn-danger resetForm">ریست</button>
                        </div>
                    </div>
                </form>

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
                            {foreach key=keyService item=itemService from=$objServicesDiscount->services}
{*                                {if $itemService.TitleEn neq 'PrivateLocalHotel' && $itemService.TitleEn neq 'PrivatePortalHotel'*}
{*                                && $itemService.TitleEn neq 'PrivateLocalCharter'}*}
                                    <tr>
                                        <td>{$itemService.TitleFa}</td>
                                        {foreach key=keyCounter item=itemCounter from=$objCounterType->list}
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">%</span>
                                                <input type="text" value="{$objServicesDiscount->list[$itemService.TitleEn][$itemCounter.id]['off_percent']}"
                                                       class="form-control text-right serviceDiscount"
                                                       data-toggle="tooltip" data-placement="top" data-original-title="{$itemCounter.name}"/>
                                                <input type="hidden" value="{$itemCounter.id}" class="counterID" />
                                                <input type="hidden" value="{$itemService.TitleEn}" class="serviceTitle" name="serviceTitle[]" />
                                            </div>
                                        </td>
                                        {/foreach}
                                    </tr>
{*                                {/if}*}
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
        <span> ویدیو آموزشی بخش تنظیمات تخفیف</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/396/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/servicesDiscount.js"></script>