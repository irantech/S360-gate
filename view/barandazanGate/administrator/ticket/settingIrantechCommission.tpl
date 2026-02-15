{load_presentation_object filename="irantechCommission" assign="objCommission"}
{load_presentation_object filename="services" assign="objServices"}
{load_presentation_object filename="source" assign="objSource"}

{$objCommission->getAll()} {*گرفتن لیست سهم ها*}
{assign var="services" value=$objServices->getAllServices()} {*گرفتن لیست خدمات*}
{assign var="flightSources" value=$objSource->getFlightSources()} {*گرفتن لیست منابع پرواز*}
{assign var="otherSources" value=$objSource->getServicesSrouces()} {*گرفتن لیست منابع دیگر*}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تنظیم سهم ایران تکنولوژی</li>
                {if $smarty.get.id neq ''}
                <li class="">{$objFunctions->ClientName($smarty.get.id)}</li>
                {/if}
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
                <h3 class="box-title m-b-0">تنظیم سهم ایران تکنولوژی</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید به ازای هر خدماتی سهم متفاوتی برای این آژانس در نظر بگیرید
                </p>
                <div class="table-responsive">
                    <input type="hidden" class="clientID" value="{$objCommission->ClientId}" />

                    {foreach $flightSources as $eachSource}
                        <div class="form-group col-sm-6">
                            <label for="Amount" class="control-label">{$eachSource.TitleFa} ({$eachSource.SourceName})</label>
                            <input type="text" value="{$objCommission->list[$eachSource.id][$eachSource.SourceId]['amount']}" class="form-control text-right commissionChange" />
                            <input type="hidden" value="{$eachSource.id}" class="serviceID" />
                            <input type="hidden" value="{$eachSource.SourceId}" class="sourceID" />
                        </div>
                    {/foreach}
                    
                    {foreach $otherSources as $eachSource}
                        <div class="form-group col-sm-6">
                            <label for="Amount" class="control-label">{$eachSource.ServiceTitle} ({$eachSource.Title})</label>
                            <input type="text" value="{$objCommission->list[$eachSource.ServiceId][$eachSource.id]['amount']}" class="form-control text-right commissionChange" />
                            <input type="hidden" value="{$eachSource.ServiceId}" class="serviceID" />
                            <input type="hidden" value="{$eachSource.id}" class="sourceID" />
                        </div>
                    {/foreach}
                    
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/irantechCommission.js"></script>