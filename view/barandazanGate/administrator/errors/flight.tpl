{load_presentation_object filename="errors" assign="objErrors"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/errors/flight">خانه</a></li>
                <li class="active">لیست خطا های پرواز</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست خطا های پرواز </h3>
                 <div class="row">

                            <div class="form-group col-sm-12 DynamicAdditionalData">
                                
                                {assign var="listErrors" value=$objErrors->showAllErrors('flight')}

                                {assign var="counter" value='0'}
                                {foreach key=key item=item from=$listErrors}
                                    <div class="col-sm-12 p-0 form-group">
                                        <div class="col-md-3 pr-0">
                                            <pre style="background: #f8f9fa; padding: 0 5px; border-radius: 5px; direction: ltr;">
                                                {$item.providerError|strip_tags}
                                            </pre>
                                        </div>
                                        <div class="col-md-1">
                                            <p>{$item.creation_date_int}</p>
                                        </div>
                                        <div class="col-md-1">
                                            <p>{$item.sourceCode}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <input id="displayAdmin{$item.id}" placeholder="نمایش برای ادمین" class="form-control"
                                                   value="{$item.displayAdmin}" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input id="displayAgency{$item.id}" placeholder="نمایش برای آژانس" class="form-control"
                                                   value="{$item.displayAgency}" type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <input id="displayPassenger{$item.id}" placeholder="نمایش برای مسافر" class="form-control"
                                                   value="{$item.displayPassenger}" type="text">
                                        </div>
                                        <div class="col-md-1 pl-0">
                                            <div class="col-md-12 p-0">
                                                <button data-counter="{$item.id}" type="button" onclick='AddError($(this))' class="btn form-control btn-success">
                                                    <span class="fa fa-check"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {assign var="counter" value=$counter+1}
                                {/foreach}

                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>


{literal}
    <script type="text/javascript" src="assets/JsFiles/errors.js"></script>
{/literal}
