{load_presentation_object filename="entertainment" assign="objEntertainment"}
{assign var="CorrectLevel" value=$smarty.get.level}
{if  $CorrectLevel == ''}
    {assign var="CorrectLevel" value='0'}
{/if}
{assign var="EntertainmentData" value=$objEntertainment->GetEntertainmentGdsData($CorrectLevel,null,false,true)}
{assign var="EntertainmentGetSingleDataByLevel" value=$objEntertainment->GetData('',$CorrectLevel)}
{assign var="EntertainmentGetSubDataByLevel" value=$objEntertainment->GetData($CorrectLevel)}
{assign var="EntertainmentGetBaseDataByLevel" value=$objEntertainment->GetParentData('',$CorrectLevel)}

<div class="container-fluid">
    <div class="row bg-title mb-0">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $CorrectLevel == 0}
                    <li class="active"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/ManageEntertainmentList">لیست تفریحات</a></li>
                {else}
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main">تفریحات</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$EntertainmentGetBaseDataByLevel['CategoryId']}&deep=1">{$EntertainmentGetBaseDataByLevel['CategoryTitle']}</a></li>
                <li class="active"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/ManageEntertainmentList&level={$CorrectLevel}">{$EntertainmentGetSingleDataByLevel['CategoryTitle']}</a></li>
                {/if}

            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row bg-title">
        <div class="col-lg-12">
            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/ManageEntertainmentList"
               class="btn btn-danger btn-outline waves-effect waves-light btn-xs">
                <span class="btn-label ml-1 pl-2"><i class="fa fa-tags"></i></span>
                لیست تفریحات</a>
            <a onclick="AddEntertainmentType(3)" data-toggle="modal" data-target="#ModalPublic"
               class="btn btn-danger btn-outline waves-effect waves-light btn-xs">
                <span class="btn-label ml-1 pl-2"><i class="fa fa-star"></i></span>
                لیست ویژگی ها</a>
            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main"
               class="btn btn-danger btn-outline waves-effect waves-light btn-xs">
                <span class="btn-label ml-1 pl-2"><i class="fa fa-table"></i></span>
                لیست دسته بندی</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {if $CorrectDeep < 2}
                    <div class="row">
                        <div class="col-sm-12" style="text-align: left">
                                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/AddEntertainment&level={$CorrectLevel}" class="btn btn-primary">اضافه کردن تفریح جدید</a>
                            <hr>
                        </div>
                    </div>
                {/if}
                <h3 class="box-title m-b-0">لیست دسته بندی</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>

                            <th>کد</th>
                            <th>نام بخش</th>
                            <th>نام</th>
                            <th>قیمت ریالی</th>
                            <th>قیمت ارزی</th>
                            <th>گالری</th>
                            <th>ویرایش</th>
                            <th>تایید</th>
                            <th>حذف</th>


                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$EntertainmentData}
                            {$number=$number+1}

                            <tr id="del-{$item.id}">

                                <td class="align-middle"><span class="badge badge-info">{$item.id}</span></td>
                                <td class="align-middle">{$item.CategoryTitle}</td>
                                <td class="align-middle">{$item.title}</td>
                                <td class="align-middle">{$item.price}</td>
                                <td class="align-middle">
                                    {if $item.currency_price!=''}
                                    {$item.currency_price}
                                        <br>
                                    {load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
                                    {foreach key=key item=value from=$objCurrencyEquivalent->ListCurrencyEquivalent()}
                                        {if $value.CurrencyCode == $item['currency_type']}
                                            <span style='font-weight: bold'>{$value.CurrencyTitle}</span>
                                        {/if}
                                    {/foreach}
                                    {else}
                                        ---
                                    {/if}
                                </td>
                                <td class="align-middle">
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/AddEntertainmentGallery&level={$item.id}"">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle ="tooltip" data-placement="top" title=""
                                        data-original-title="گالری">

                                    </i>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/EditEntertainment&level={$item.id}"">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle ="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش">

                                        </i>
                                    </a>
                                </td>

                                {if $item.accepted_at eq 0 }
                                    <td class="align-middle">
                                        <a onclick="ManageAcceptEntertainment($(this),'{$item.id}')" data-action="accept">
                                            <i  class="fcbtn btn btn-danger btn-1e fa fa-ban tooltip-primary"
                                                data-toggle ="tooltip" data-placement="top" title=""
                                                data-original-title="پنهان">

                                            </i>
                                        </a>
                                    </td>
                                {else}
                                    <td class="align-middle">
                                        <a onclick="ManageAcceptEntertainment($(this),'{$item.id}')" data-action="reject">
                                            <i  class="fcbtn btn btn-success btn-1e fa fa-check tooltip-primary"
                                                data-toggle ="tooltip" data-placement="top" title=""
                                                data-original-title="تایید شده">

                                            </i>
                                        </a>
                                    </td>
                                {/if}


                                <td class="align-middle">
                                    <a id="DelChangePrice-{$item.CategoryId}" onclick="SubmitRemoveEntertainment('{$item.id}'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف سردسته" data-placement="right"
                                       data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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

<script type="text/javascript" src="assets/JsFiles/entertainment.js"></script>