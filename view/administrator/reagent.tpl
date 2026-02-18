{load_presentation_object filename="reagentPoint" assign="objReagentPoint"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">اعتبار معرف</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">فرم تعیین اعتبار کد معرف </h3>

                <p class="text-muted m-b-30 ">به ازای هر معرفی، این میزان به اعتبار معرف و معرفی شده، تخصیص می یابد</p>

                <form id="ReagentPointAdd" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="ReagentPointAdd">


                    <div class="form-group col-sm-6 ">
                        <label for="Amount" class="control-label"> میزان اعتبار</label>
                        <input type="text" class="form-control " name="Amount"
                               value="{$smarty.post.request_number}" id="Amount"
                               placeholder="مبلغ را (به ریال) وارد نمائید">

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست اعتبار کد معرف</h3>
                <p class="text-muted m-b-30">همیشه تنها آخرین اعتبار کد معرف فعال بوده و بقیه، آرشیوی از اعتبارات گذشته هستند
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>میزان اعتبار</th>
                            <th>تاریخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objReagentPoint->ListAll()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td {if $item.isActive eq 'no'} class="border-right-change-price" {/if}>{$number}</td>
                            <td>
                                {$item.amount|number_format} ریال
                            </td>
                            <td dir="ltr" class="text-left">
                                {$objDate->jdate('Y-m-d (H:i:s)', $item.creationDateInt)}
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
<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی تعیین اعتبار کد معروف</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/393/---.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/reagent.js"></script>