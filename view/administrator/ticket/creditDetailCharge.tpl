{load_presentation_object filename="agency" assign="objAgency"}
{*load_presentation_object filename="credit" assign="objCredit"*}
{load_presentation_object filename="creditDetail" assign="objCreditDetail"}

{$objAgency->get($smarty.get.id)} {*گرفتن مشخصات آژانس*}
{$objCreditDetail->getAll($smarty.get.id)} {*گرفتن لیست اعتبارات*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li>جزئیات اعتبار</li>
                <li class="active">{$objAgency->list['name_fa']}({$objAgency->list['manager']})</li>
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
                <h3 class="box-title m-b-0">جزئیات اعتبار</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید جزئیات افزایش زیر مجموعه خود را مشاهده
                    نمائید


                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>اعتبار</th>
                            <th>تاریخ ثبت</th>
                            <td>توضیحات</td>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCreditDetail->getAllCharge($smarty.get.id)}
                        {$number=$number+1}
                        <tr>
                            <td>{$number}</td>
                            <td>{$item.credit|number_format} ریال</td>
                            <td>{$objCreditDetail->DateJalali($item.register_date)}</td>
                            <td>{$item.comment}</td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>