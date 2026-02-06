
{load_presentation_object filename="rentCar" assign="objRentCar"}
{assign var="list_rent_car" value=$objRentCar->listReserveRentCar()}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/iranVisa/listReserve">لیست درخواست خودرو</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست درخواست رزرو خودرو</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست درخواست های رزرو خودرو را مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>شماره همراه</th>
                            <th>کد پیگیری</th>
                            <th>وضعیت درخواست</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_rent_car != ''}
                        {foreach key=key item=item from=$list_rent_car}
                        {$number=$number+1}
                        <tr id="del-{$item.rId}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>

                            <td class="align-middle">{$item.name}</td>
                            <td class="align-middle">{if $item.mobile}{$item.mobile}{else}---{/if}</td>

                            <td class="align-middle">{$item.tracking_code}</td>
                            <td class="align-middle">
                                {if $item.status}
                                    {foreach $objStatus->getRequestServiceStatusList() as $status}
                                        {if $item.status=={$status['value']}}
                                            <a class='{$status['btn']}' style='color:#fff;'>{$status['title']}</a>
                                        {/if}
                                    {/foreach}
                                {/if}

                            </td>
                            <td class="align-middle">
                                <a href="editReserve&id={$item.rId}" class="btn btn-sm btn-outline gap-4 btn-primary">جزییات درخواست</a>
                                <button class="btn btn-sm btn-outline btn-danger deleteReserveRentCar"
                                         data-id="{$item.rId}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                            </td>
                </div>
                </td>
                </tr>
                {/foreach}
                {/if}
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>


<script type="text/javascript" src="assets/JsFiles/rentCar.js"></script>

