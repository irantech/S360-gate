{load_presentation_object filename="interactiveOffCodes" assign="objCode"}
{assign var="codeList" value=$objCode->offCodesByInteractiveID($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li><a href="interactiveOffCodes">لیست کدهای ترانسفر</a></li>
                <li class="active">کدهای تخفیف</li>
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
                <h3 class="box-title m-b-0">کد تخفیف</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید کدهای تخفیف افزوده شده از طریق فایل اکسل را مشاهده نمائید </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد تخفیف</th>
                            <th>تخصیص داده شده</th>
                            <th>نام کاربر</th>
                            <th>تاریخ تخصیص به کاربر</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$codeList}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.offCode}</td>
                                <td class="align-middle"><i class="fa {if $item.used eq 1}fa-check text-success{else}fa-remove text-danger{/if}"></i></td>
                                <td class="align-middle">{if $item.used eq 1}{if $item.memberName neq ''}{$item.memberName}{else}کاربر مهمان{/if}{else}---------{/if}</td>
                                <td class="align-middle">{if $item.used eq 1}{$objDate->jdate('Y-m-d', $item.lastEditInt)}{else}---------{/if}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/interactiveOffCodes.js"></script>