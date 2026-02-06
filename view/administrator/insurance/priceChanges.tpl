{load_presentation_object filename="insurancePriceChanges" assign="objPriceChanges"}
{$objPriceChanges->getAll()}

{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تغییرات قیمت بیمه</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست تغییرات قیمت بیمه مسافرتی</h3>
                <p class="text-muted m-b-30">با تعیین مقدار در این قسمت، تمام بیمه نامه ها به این مقدار افزایش قیمت خواهند داشت</p>

                <p>برای اعمال تغییرات، ابتدا نوع افزایش قیمت (ریال یا %) را انتخاب نموده، سپس مقدار را تغییر دهید</p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            {foreach key=key item=item from=$objCounterType->list}
                            <th class="text-center">{$item.name}</th>
                            {/foreach}
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            {foreach key=keyCounter item=itemCounter from=$objCounterType->list}

                            {if $objPriceChanges->list[$itemCounter.id]['changeType'] == 'percent'}
                                {assign var='priceVal' value=$objPriceChanges->list[$itemCounter.id]['price']}
                            {else}
                                {assign var='priceVal' value=$objPriceChanges->list[$itemCounter.id]['price']|number_format:0}
                            {/if}
                            <td>
                                <div class="input-group">
                                    <input type="text" value="{$priceVal}" class="form-control text-right insurancePriceChanges" />
                                    <span class="input-group-addon">
                                        <select class="changeType">
                                            <option value="cost" {if $objPriceChanges->list[$itemCounter.id]['changeType'] == 'cost'} selected="selected" {/if}>ریال</option>
                                            <option value="percent" {if $objPriceChanges->list[$itemCounter.id]['changeType'] == 'percent'} selected="selected" {/if}>%</option>
                                        </select>
                                    </span>
                                    <input type="hidden" value="{$itemCounter.id}" class="counterID" />
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
        <span> ویدیو آموزشی بخش  تغییر قیمت بیمه   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/361/-----.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/insurancePriceChanges.js"></script>