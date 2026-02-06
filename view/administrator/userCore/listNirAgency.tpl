{load_presentation_object filename="settingCore" assign="objsettingCore"}
{assign var="listSource" value=$objsettingCore->listAirlineNira(['agency_source_id'=>$smarty.get.sourceAgencyId])}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">لیست سرور ها</li>

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
                <h3 class="box-title m-b-0">اطلاعات  پید نیرا برای آژانس  {$smarty.get.agencyName}</h3>
                <div class="table-responsive">




                    <table class="table color-table primary-table color-bordered-table info-bordered-table">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام پید</th>
                            <th>یوزر نیم</th>
                            <th>پسورد</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach key=key item=item from=$listSource}
                            <tr>
                                <td>{$key+ 1}</td>
                                <td>{$item.airline_name}</td>
                                <td>{$item.user_name}</td>
                                <td> {$item.password} </td>
                                <td>
                                    <a href="#"
                                       onclick="StatusActiveSourcePid('{$item.id}'); return false">
                                        {if $item.is_enable eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked id="SourceStatus{$item.id}"/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" id="SourceStatus{$item.id}"/>
                                        {/if}
                                    </a>
                                </td>
                            </tr>
                        {/foreach}

                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>

</div>

</div>

<script type="text/javascript" src="assets/JsFiles/core.js"></script>


