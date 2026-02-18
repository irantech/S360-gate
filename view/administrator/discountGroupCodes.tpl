{load_presentation_object filename="discountCodes" assign="ObjCode"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li><a href="discountCodes">کد تخفیف</a></li>
                <li class="active">لیست کدهای تخفیف تولید شده</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست کدهای تخفیف تولید شده</h3>
                <p class="text-muted m-b-30">شما میتوانید فایل اکسل مربوط به این کدهای تخفیف را از اینجا دریافت کنید</p>
                <div class="table-responsive">
                    <table id="discountCodesExcel" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد تخفیف</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjCode->groupCodesList($smarty.get.id)}
                        {$number = $number + 1}
                        <tr>
                            <td>{$number}</td>
                            <td>{$item.code}</td>
                            <td>
                                {if $item.used eq 0}
                                    <a id="Del-{$item.id}" href="#" onclick="deleteCode({$item.id}); return false">
                                        <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash tooltip-danger"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="حذف"></i>
                                    </a>
                                {else}
                                    <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-trash tooltip-default"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="این کد تخفیف استفاده شده و امکان حذف آن وجود ندارد"></i>
                                {/if}
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

<script type="text/javascript" src="assets/JsFiles/discountCodes.js"></script>