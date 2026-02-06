{load_presentation_object filename="settingCore" assign="objsettingCore"}
{assign var="listSourceAgency" value=$objsettingCore->ListAgency()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userCore/listAgencyCore">لیست آژانس - سرور</a></li>
                <li class="active">لیست آژانس های متصل به سرور</li>

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
                <h3 class="box-title m-b-0">لیست آژانس های متصل به سرور</h3>


                {*<ul class="nav tabs-vertical">
                    {assign var="listCount" value="1"}
                    {foreach key=key item=item from=$listSourceAgency}
                        <li class="tab {if $listCount eq 1}active{/if}">
                            <a data-toggle="tab" href="#{$item.id}" aria-expanded="true"> {$item.name} </a>
                        </li>
                        {$listCount = $listCount + 1}
                    {/foreach}
                </ul>*}

                {assign var="listCount" value="1"}
                {foreach key=key item=item from=$listSourceAgency}

                        <div class="table-responsive">
                            <label class="btn btn-primary margin-10">{$item.id}-{$item.name}</label>
                            <table class="table color-table primary-table color-bordered-table info-bordered-table">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام سرور</th>
                                    {*<th>فعال بودن</th>*}
                                    <th>داخلی</th>
                                    <th>خارجی</th>
                                    <th>ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                {assign var="recCounter" value="1"}
                                {assign var="list" value=$objsettingCore->getInfoAgencySource($item.id)} {*گرفتن لیست سوابق تغییرات قیمت*}
                                {foreach key=keyList item=itemList from=$list}
                                    <tr>
                                        <td>{$recCounter}</td>
                                        <td>{$itemList.nameFa}</td>
                                        {*<td>*}

                                        {*<a href="#"*}
                                        {*onclick="StatusActiveSource('{$item.id}','{$itemList.SourceTbId}'); return false">*}
                                        {*{if $itemList.ActiveSource eq '1'}*}
                                        {*<input type="checkbox" class="js-switch" data-color="#99d683"*}
                                        {*data-secondary-color="#f96262" data-size="small" checked id="SourceStatus{$item.id}{$itemList.SourceTbId}"/>*}
                                        {*{else}*}
                                        {*<input type="checkbox" class="js-switch" data-color="#99d683"*}
                                        {*data-secondary-color="#f96262" data-size="small" id="SourceStatus{$item.id}{$itemList.SourceTbId}"/>*}
                                        {*{/if}*}
                                        {*</a>*}
                                        {*</td>*}
                                        <td>
                                            <a href="#"
                                               onclick="StatusActiveInternalAgencySource('{$item.id}','{$itemList.SourceTbId}'); return false">
                                                {if $itemList.isActiveInternal eq '1'}
                                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                                           data-secondary-color="#f96262" data-size="small" checked
                                                           id="SourceAgencyStatus{$item.id}{$itemList.SourceTbId}"/>
                                                {else}
                                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                                           data-secondary-color="#f96262" data-size="small"
                                                           id="SourceAgencyStatus{$item.id}{$itemList.SourceTbId}"/>
                                                {/if}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#"
                                               onclick="StatusActiveExternalAgencySource('{$item.id}','{$itemList.SourceTbId}'); return false">
                                                {if $itemList.isActiveExternal eq '1'}
                                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                                           data-secondary-color="#f96262" data-size="small" checked
                                                           id="SourceAgencyStatusExternal{$item.id}{$itemList.SourceTbId}"/>
                                                {else}
                                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                                           data-secondary-color="#f96262" data-size="small"
                                                           id="SourceAgencyStatusExternal{$item.id}{$itemList.SourceTbId}"/>
                                                {/if}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="editAgencySourceCore&agencyId={$item.id}&sourceId={$itemList.SourceTbId}"
                                               class=""><i
                                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="ویرایش "></i></a>

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


