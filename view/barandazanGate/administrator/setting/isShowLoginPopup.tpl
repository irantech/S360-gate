{*{load_presentation_object filename="settings" assign="objResult"}*}

{*<div class="container-fluid">*}
{*    <div class="row bg-title">*}
{*        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">*}
{*            <ol class="breadcrumb FloatRight">*}
{*                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>*}
{*                <li>تنظیمات</li>*}
{*                <li class="active">تنظیم لغو/نمایش پاپ آپ (ورود/ثبت نام)</li>*}
{*            </ol>*}
{*        </div>*}
{*    </div>*}


{*    <div class="row">*}

{*        <div class="col-sm-12">*}
{*            <div class="white-box">*}
{*                <h3 class="box-title m-b-0">تنظیم لغو/نمایش پاپ آپ (ورود/ثبت نام)</h3>*}
{*                <p class="text-muted m-b-30"></p>*}
{*                <div class="table-responsive">*}
{*                    <table id="myTable" class="table table-striped">*}
{*                        <thead>*}
{*                        <tr>*}
{*                            <th> ردیف</th>*}
{*                            <th>عنوان</th>*}
{*                            <th>وضعیت</th>*}
{*                        </tr>*}
{*                        </thead>*}
{*                        <tbody>*}
{*                        {assign var="number" value="0"}*}
{*                        {foreach key=key item=item from=$objResult->isShowLoginPopup()}*}
{*                            {$number=$number+1}*}
{*                            <tr id="del-{$item.id}">*}
{*                                <td>{$number}</td>*}
{*                                <td>اگر میخواهید تمامی خرید ها از نرم افزار <u>بدون نمایش popup</u> ورود/ثبت نام باشد و خریدها به صورت پیش فرض کاربر مهمان درنظر گرفته شود، این قسمت را <u>غیرفعال</u> کنید.</td>*}
{*                                <td>*}
{*                                    <a onclick="isActive('{$item.id}'); return false;">*}
{*                                        {if $item.enable eq '1'}*}
{*                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>*}
{*                                        {else}*}
{*                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>*}
{*                                        {/if}*}
{*                                    </a>*}
{*                                </td>*}
{*                            </tr>*}
{*                        {/foreach}*}
{*                        </tbody>*}
{*                    </table>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}

{*    </div>*}
{*</div>*}

{*<script type="text/javascript" src="assets/JsFiles/isShowLoginPopup.js"></script>*}