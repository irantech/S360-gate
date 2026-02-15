{load_presentation_object filename="reservationTour" assign="ObjResult"}
{load_presentation_object filename="reservationSetting" assign="ObjSetting"}
{assign var="settingList" value=$ObjSetting->getReservationSetting()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>رزرواسیون</li>
                <li>تنظیمات</li>
                <li class="active">تنظیمات کلی رزرواسیون</li>
            </ol>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تنظیم ویرایشگر برای ثبت تور</h3>
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>توضیحات</th>
                            <th>سرویس</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$settingList}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.description}</td>
                                <td>{$item.service}</td>
                                <td>
                                    <a onclick="isEditorActive('{$item.id}'); return false;">
                                        {if $item.enable eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
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
        <span> ویدیو آموزشی بخش ویرایشگر برای ثبت تور   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/378/---.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>