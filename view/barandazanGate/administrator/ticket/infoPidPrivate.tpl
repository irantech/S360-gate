{load_presentation_object filename="infoSourceTrust" assign="objInfoSource"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="../../../index.php">مشتریان نرم افزار پرواز</a></li>
                <li class="active"> لیست اطلاعات منابع</li>
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
                <h3 class="box-title m-b-0">لیست اطلاعات منابع اختصاصی</h3>
                <p class="text-muted m-b-30">
                    شما در لیست زیر میتوانید اطلاعات تمامی پید های اختصاصی مشتریان را مشاهده نمائید
                    <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/infoSourceTrustAdd"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="mdi mdi-trending-up"></i></span>افزودن اطلاعات منبع جدید
                </a>
                </span>

                </p>
                <div class="table-responsive">
                    <table  class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد</th>
                            <th>نام ایرلاین</th>
                            <th>وضعیت</th>
                            <th>اعتبار</th>
                            <th>نام نرم افزار</th>
                        </tr>
                        </thead>
                        <tbody>


                        {assign var="infoPid" value=$objInfoSource->InfoPid($smarty.const.CLIENT_ID)}
                        {if $infoPid['error'] eq ''}
                            {foreach key=key item=item from=$infoPid['data'][0]['sources']}
                                {assign var="Airline" value=$objFunctions->InfoAirline($item.label)}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td>{$number}</td>
                                    <td>{$item.source_agency_id}</td>
                                    <td>{$Airline['name_fa']}</td>
                                    <td>{$item.text} </td>
                                    <td>{if $item.credit|count_characters gt 3}{$item.credit|number_format}  ریال{else} {$item.credit}&nbsp; تیکت{/if}</td>
                                    <td>{$item.source_software_name}</td>
                                </tr>
                            {/foreach}
                        {else}

                            <tr id="del-{$item.id}">
                                <td></td>
                            </tr>
                        {/if}

                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript" src="../assets/JsFiles/accountcharge.js"></script>


