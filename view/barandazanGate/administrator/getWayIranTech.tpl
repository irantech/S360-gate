{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bankList" assign="ObjBank"}
{assign var="bank" value=$ObjBank->bank360()}
<input type="hidden" name="userNameGateWayIranTech" id="userNameGateWayIranTech" value="{$userNameGetWayIranTech['userName']}">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">تنظیم درگاه سفر 360</li>
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
                <h3 class="box-title m-b-0">لیست درگاه های سفر360</h3>
                <p class="text-muted m-b-30">کلیه درگاه های بانکی را در این لیست میتوانید مشاهده کنید و نسبت به فعال و
                    غیر فعال نمودن آن ها اقدام نمائید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>نام بانک</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$bank}

                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.name}</td>
                                <td>

                                        <a href="#" onclick="bank360_active('{$item.userName}'); return false;" >
                                            {if $item.is_enable eq '1'}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" checked />

                                            {else}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" />
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

<script type="text/javascript" src="assets/JsFiles/bankList.js"></script>
{/if}