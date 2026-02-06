{load_presentation_object filename="partner" assign="objPartner"}
<div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li >مشتریان نرم افزار پرواز</li>
                    <li class="active">کمیسیون مشتریان وایت لیبل</li>
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
                    <h3 class="box-title m-b-0">کمیسیون مشتریان وایت لیبل</h3>
                    <p class="text-muted m-b-30">کلیه  کمیسیون مشتری را در این لیست میتوانید مشاهده کنید
                        <span class="pull-right">
                         <a href="commissionClientWhiteLable&id={$smarty.get.id}" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن کمیسیون مشتری جدید
                        </a>
                </span>
                    </p>
                    <div class="table-responsive table-responsive-custom">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام همکار</th>
                                <th>نام بخش مربوطه </th>
                                <th>نام سرویس</th>
                                <th>نوع کمیسیون</th>
                                <th>میزان کمیسیون</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach $objPartner->listClientCommission($smarty.get.id) as $item}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td>{$number}</td>
                                    <td>{$item.AgencyName}</td>
                                    <td>{$item.title}</td>
                                    <td>{$item.TitleFa}</td>
                                    <td>{if $item.type_commission  eq 'price'}ریالی{else}درصدی{/if}</td>
                                    <td>{$item.amount_commission}</td>

                                    <td>
                                        <div class="btn-group m-r-10">

                                            <a href="#" class="" onclick="deletedCommission('{$item.id}'); return false"><i
                                                        class="fcbtn btn btn-outline btn-danger btn-1e fa fa-trash-o tooltip-danger"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="حذف کمیسیون"></i></a>
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

<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>

