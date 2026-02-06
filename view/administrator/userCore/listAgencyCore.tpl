{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="partner" assign="objPartner"}
{assign var="ListClient" value=$objPartner->ListClientActive()}

{load_presentation_object filename="settingCore" assign="objsettingCore"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>لیست آژانس فعال - سرور</li>
                <li class="active">لیست آژانس های فعال که حتما یک سرور برایش متصل کرده باشیم</li>
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
                {assign var="listCount" value="1"}
                {foreach key=key item=item from=$ListClient}
                    <div class="table-responsive">
                            <label class="btn btn-primary margin-10">{$item.id}- {$item.AgencyName} - {$item.MainDomain} - {$item.Username}</label>
                            <table class="table color-table primary-table color-bordered-table info-bordered-table">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام سرور</th>
                                    <th>داخلی</th>
                                    <th>خارجی</th>
                                    <th>ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                {assign var="recCounter" value="1"}
                                {assign var="list" value=$objsettingCore->getInfoAgencySourceByUserName($item.Username)}
                                {foreach key=keyList item=itemList from=$list}
                                        <tr>
                                            <td>{$recCounter}</td>
                                            <td>{$itemList.nameFa}</td>
                                            <td>
                                                <a href="#"
                                                   onclick="StatusActiveInternalAgencySource('{$itemList.idAgency}','{$itemList.SourceTbId}'); return false">
                                                    {if $itemList.isActiveInternal eq '1'}
                                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                                               data-secondary-color="#f96262" data-size="small" checked
                                                               id="SourceAgencyStatus{$itemList.idAgency}{$itemList.SourceTbId}"/>
                                                    {else}
                                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                                               data-secondary-color="#f96262" data-size="small"
                                                               id="SourceAgencyStatus{$itemList.idAgency}{$itemList.SourceTbId}"/>
                                                    {/if}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#"
                                                   onclick="StatusActiveExternalAgencySource('{$itemList.idAgency}','{$itemList.SourceTbId}'); return false">
                                                    {if $itemList.isActiveExternal eq '1'}
                                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                                               data-secondary-color="#f96262" data-size="small" checked
                                                               id="SourceAgencyStatusExternal{$itemList.idAgency}{$itemList.SourceTbId}"/>
                                                    {else}
                                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                                               data-secondary-color="#f96262" data-size="small"
                                                               id="SourceAgencyStatusExternal{$itemList.idAgency}{$itemList.SourceTbId}"/>
                                                    {/if}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="editAgencySourceCore&agencyId={$itemList.idAgency}&sourceId={$itemList.SourceTbId}"
                                                   class=""><i
                                                            class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="ویرایش "></i></a>

                                                {if $itemList.SourceTbId eq '30'}
                                                    <a href="addAirlineToAgency&agencyName={$item.name}&sourceAgencyId={$itemList.id}" target='_blank' class=""><i
                                                                class="fcbtn btn btn-outline btn-success btn-1e fa fa-pencil tooltip-primary"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="ثبت اطلاعات پید نیرا "></i></a>

                                                    <a href="listNirAgency&agencyName={$item.name}&sourceAgencyId={$itemList.id}" target='_blank' class=""><i
                                                                class="fcbtn btn btn-outline btn-warning btn-1e fa fa-list tooltip-primary"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="لیست اطلاعات پید نیرا "></i></a>
                                                {/if}
                                            </td>
                                        </tr>
                                        {$recCounter = $recCounter + 1}
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    {$listCount = $listCount + 1}
                    <hr/>
                {/foreach}
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="assets/JsFiles/core.js"></script>
{/if}


