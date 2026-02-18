{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="source" assign="objSource"}
{load_presentation_object filename="services" assign="objServices"}

{assign var="flightSource" value=$objSource->getFlightTrustSource()}
{assign var="services" value=$objServices->getServicesOfAGroup('Flight')}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"> تنظیم منابع پرواز</li>
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
                <h3 class="box-title m-b-0">لیست وضعیت منابع پرواز</h3>
                <p class="text-muted m-b-30"> شما میتوانید در لیست زیر منابع پرواز مورد نظر را فعال یا غیر فعال کنید</p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>خدمات</th>
                            {foreach key=key item=item from=$flightSource}
                                <th>{$item.Title}</th>
                            {/foreach}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$services}

                            <tr>
                                <td class="align-middle">{$item.TitleFa}</td>
                                    {foreach $flightSource as $source}
                                        <td class="align-middle">
                                            <a href="#"
                                               onclick="ChangeSourceStatus('{$item.id}', '{$source.id}'); return false">
                                                {if $objSource->hasFlightSourceService({$item.id}, {$source.id}) eq true}
                                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                                           data-secondary-color="#f96262" data-size="small" checked/>
                                                {else}
                                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                                           data-secondary-color="#f96262" data-size="small"/>
                                                {/if}
                                            </a>
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

<script type="text/javascript" src="assets/JsFiles/source.js"></script>
{/if}

