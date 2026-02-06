{load_presentation_object filename="partner" assign="objPartner"}
{*{assign var="objPartner" value=$objPartner->archivedClients()}*}

{if $smarty.const.TYPE_ADMIN eq '1'}

    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class="active">مشتریان آرشیو شده نرم افزار پرواز</li>
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
                    <h3 class="box-title m-b-0">لیست مشتریان آرشیو شده نرم افزار پرواز</h3>
                    <p class="text-muted m-b-30">کلیه مشتریان آرشیو شده نرم افزار پرواز را در این لیست میتوانید مشاهده کنید
                    </p>
                    <p id="Source7Credit" style="color:red;" class="float-left"></p>
                    <div class="table-responsive table-responsive-custom">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام همکار</th>
                                <th>نام مدیر</th>
                                <th>تعداد خرید موفق</th>
                                <th>تعداد نفرات</th>
                                <th>میزان شارژ حساب</th>
                                <th>نوع تسویه</th>
                                <th>آیدی تیکت مشتری</th>
                                <th>آرشیو شده در</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach $objPartner->archivedClients() as $item}
                                {assign var="amount" value=$objFunctions->calculateChargeUserPrice({$item.id})}

                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td>{$number}</td>
                                    <td>{$item.AgencyName}--{$item.MainDomain}</td>
                                    <td>{$item.Manager}</td>
                                    <td>{$objPartner->countBuy($item.id)}</td>
                                    <td>{$objPartner->countPeople($item.id)}</td>
                                    <td>
                                        {$amount|number_format}
                                    </td>
                                    <td>
                                        {$objFunctions->generateChargeUserString($amount)}
                                    </td>
                                    <td>
                                        {if !$item.hash_id_whmcs}کد ندارد{/if}
                                    </td>
                                    <td>
                                        {dateTimeSetting::jdate("j F Y", functions::ConvertToDateJalaliInt($item.archived_at))}
                                    </td>
                                    <td>
                                        <div class="btn-group m-r-10">

                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu dropdown-menu-left animated flipInY">
                                                <li class="li-list-operator unarchive-{$item.id}">
                                                    <a onclick='unarchive($(this),"{$item.id}")' class=""><i
                                                                class="fcbtn btn btn-outline btn-error btn-1e fa fa-pencil tooltip-primary"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="لغو آرشیو مشتری"></i></a>
                                                </li>
                                            </ul>
                                        </div>
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
{else}
    <script>
      window.location = 'admin';
    </script>
{/if}
<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>

