
{load_presentation_object filename="partner" assign="objPartner"}
{assign var="partners" value=$objPartner->getPartnerWhiteLabel()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">مشتریان داری وایت لیبل</li>
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
                <h3 class="box-title m-b-0">لیست مشتریان دارای وایت لیبل</h3>
                <p class="text-muted m-b-30">کلیه مشتریان دارای وایت لیبل را در این لیست میتوانید مشاهده کنید

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
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach $partners as $item}
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
                                <a href="partner-accountant-white-label&id={$item.id}" class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1e fa fa-money tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title=""></i></a>
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

<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>

