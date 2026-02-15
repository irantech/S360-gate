{load_presentation_object filename="bankList" assign="ObjBank"}
{if $smarty.get.id neq ''}
    {assign var='client_id'  value=$smarty.get.id}
    {else}
    {assign var='client_id'  value=$smarty.const.CLIENT_ID}
{/if}
{assign var="userNameGetWayIranTech" value=$objFunctions->DataIranTechGetWay()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $smarty.get.id neq ''}
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                {/if}
                <li class="active">اطلاعات بانک</li>
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
                <h3 class="box-title m-b-0">لیست درگاه های بانکی</h3>
                <p class="text-muted m-b-30">کلیه درگاه های بانکی را در این لیست میتوانید مشاهده کنید و نسبت به فعال و
                    غیر فعال نمودن آن ها اقدام نمائید
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    <span class="pull-right">
                         <a href="bankAdd{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="fa fa-bank"></i></span>افزودن بانک جدید
                </a>
                </span>
                    {/if}
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>نام بانک</th>
                            <th>وضعیت</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                            <th>ویرایش</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjBank->index()}

                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>{$item.title}{if in_array($item.param1,$userNameGetWayIranTech)}(ایران تکنولوژی){/if}</td>

                            <td>
                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                       {assign var="checkGetWayIrantech" value=$objFunctions->CheckGetWayIranTech($smarty.get.id)}
                                    {else}
                                      {assign var="checkGetWayIrantech" value=$objFunctions->CheckGetWayIranTech($smarty.const.CLIENT_ID)}
                                {/if}
                                {if $checkGetWayIrantech eq  true}
                                    {assign var="checkGetWayFinal" value='true'}
                                {else}
                                    {assign var="checkGetWayFinal" value='false'}
                                {/if}
                                {if !in_array($item.param1,$userNameGetWayIranTech) || $smarty.const.TYPE_ADMIN eq '1'}
                                    <a href="#" onclick="bank_active('{$item.id}','{$client_id}','{$checkGetWayFinal}','{$item.param1}'); return false;" >
                                        {if $item.enable eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked  {*{if ($checkGetWayFinal eq 'false') && ($smarty.const.TYPE_ADMIN neq '1')}disabled="disabled"{/if}*}/>

                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"  {*{if ($checkGetWayFinal eq 'false') && ($smarty.const.TYPE_ADMIN neq '1')}disabled="disabled"{/if}*}/>
                                        {/if}
                                    </a>
                                {/if}
                            </td>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                            <td>

                                <a href="bankEdit&bankId={$item.id}{if $smarty.get.id neq ''}&ClientId={$smarty.get.id}{/if}"
                                   class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش بانک"></i></a>

                            </td>
                            {/if}
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
        <span> ویدیو آموزشی بخش درگاه بانک   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/364/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/bankList.js"></script>