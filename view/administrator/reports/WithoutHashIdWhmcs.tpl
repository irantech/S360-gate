{load_presentation_object filename="clients" assign="objReport"}
{assign var="reports" value=$objReport->listWithoutHashIdWhmcsClients()}
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-heading TitleSectionsDashboard" style="cursor: pointer;" data-toggle="collapse" data-target="#ActiveBox">
                <h6 style="font-weight: 500; font-size: 17px; color: #3c3939; margin: 0;">
                     لیست مشتریانی که شماره تیکت ندارند و فعال هستند
                    <div class="pull-right"><i class="ti-minus"></i></div>
                </h6>
            </div>
                <div id="ActiveBox" class="panel-collapse collapse in" style="overflow: auto;">
                    <div class="panel-body clearfix">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">آژانس</th>
                                <th class="text-center">دامنه</th>
                                <th class="text-center"> عملیات </th>
                            </tr>
                            </thead>
                            <tbody>
                                {assign var="index" value=1}
                                {foreach from=$reports item=row name=reports}
                                        <tr>
                                            <td>{$index}</td>
                                            <td>{$row.AgencyName}</td>
                                            <td>{$row.MainDomain}</td>
                                            <td>
                                                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/flyAppClientEdit&id={$row.id}" target="_blank" >ویرایش کنید</a>
                                            </td>
                                        </tr>
                                        {assign var="index" value=$index+1}
                                {/foreach}
                            </tbody>
                         </table>
                     </div>
                </div>
            </div>
    </div>
</div>