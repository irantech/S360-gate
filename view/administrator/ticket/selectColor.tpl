{load_presentation_object filename="selectColor" assign="objSelectColor"}
{$objSelectColor->InfoColor($smarty.get.ClientId)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                {if $smarty.get.ClientId neq '' }
                <li class="">{$objFunctions->ClientName($smarty.get.ClientId)}</li>
                {/if}
                <li class="active">تعیین رنگ</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تعیین رنگ</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید رنگ دلخواه سایت خود در سمت کاربران را
                    در سیستم تعیین نمائید</p>

                <form id="SelectColor" method="post">
                    <input type="hidden" name="flag" value="selectColor">
                    <input type="hidden" name="ClientId" id="ClientId" value="{$smarty.get.ClientId}">
                    <div class="form-group col-sm-6 ">

                        <label for="colorMainBg" class="control-label">انتخاب رنگ اصلی</label>
                        <input type="text" class="gradient-colorpicker form-control" name="colorMainBg" id="colorMainBg"
                               value="{if $objSelectColor->Info['ColorMainBg'] neq ''}{$objSelectColor->Info['ColorMainBg']}{else}#006699{/if}"/>
                    </div>


                    <div class="col-sm-6 form-group">
                        <label for="colorMainBgHover" class="control-label">انتخاب رنگ اصلی پر رنگ تر</label>
                        <input type="text" class="gradient-colorpicker form-control" name="colorMainBgHover"
                               id="colorMainBgHover"
                               value="{if $objSelectColor->Info['ColorMainBgHover'] neq ''}{$objSelectColor->Info['ColorMainBgHover']}{else}#006699{/if}"/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="colorMainText" class="control-label">انتخاب رنگ متن</label>
                        <input type="text" class="gradient-colorpicker form-control" name="colorMainText"
                               id="colorMainText"
                               value="{if $objSelectColor->Info['ColorMainText'] neq ''}{$objSelectColor->Info['ColorMainText']}{else}#006699{/if}"/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="colorMainTextHover" class="control-label"> انتخاب رنگ متن در حالت انتخاب </label>
                        <input type="text" class="gradient-colorpicker form-control" name="colorMainTextHover"
                               id="colorMainTextHover"
                               value="{if $objSelectColor->Info['ColorMainTextHover'] neq ''}{$objSelectColor->Info['ColorMainTextHover']}{else}#006699{/if}"/>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش  تعیین رنگ سایت   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/357/--.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/selectColor.js"></script>