    {load_presentation_object filename="entertainment" assign="objEntertainment"}
{assign var="CorrectLevel" value=$smarty.get.level}
{if $CorrectLevel == ''}
    {assign var="CorrectLevel" value='0'}
{/if}
{assign var="CorrectDeep" value=$smarty.get.deep}
{if $CorrectDeep == ''}
    {assign var="CorrectDeep" value='0'}
{/if}
{assign var="EntertainmentGetSingleDataByLevel" value=$objEntertainment->GetData('',$CorrectLevel)}
{assign var="EntertainmentGetSubDataByLevel" value=$objEntertainment->GetData($CorrectLevel)}
{assign var="EntertainmentGetBaseDataByLevel" value=$objEntertainment->GetParentData('',$CorrectLevel)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li {if $CorrectLevel == '0'} class="active" {/if} ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main">تفریحات</a></li>
                {if $CorrectLevel != '0' && $EntertainmentGetSingleDataByLevel.CategoryParentId != '0'}
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$EntertainmentGetBaseDataByLevel.CategoryId}&deep=1">{$EntertainmentGetBaseDataByLevel.CategoryTitle}</a></li>

                {/if}

                {if $CorrectDeep !='0' }

                    <li class="active"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$CorrectLevel}&deep=2">{$EntertainmentGetSingleDataByLevel.CategoryTitle}</a></li>

                {/if}

            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <div class="row bg-title">
            <div class="col-lg-12">
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/EntertainmentList"
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

        <!-- /.col-lg-12 -->
    </div>
    {if $CorrectDeep < 2}
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form id="FormSubmitNewEntertainmentCategory" method="post">
                        <p class="text-muted m-b-30">اضافه کردن زیر مجموعه دسته بندی</p>

                        <div class="form-group col-sm-6">
                            <label for="EntertainmentCategoryTitle" class="control-label">عنوان زیر مجموعه دسته بندی</label>
                            <input type="text" class="form-control" name="EntertainmentCategoryTitle"
                                   id="EntertainmentCategoryTitle" placeholder="عنوان را وارد نمائید">
                        </div>


                        <div class="form-group  col-sm-6">
                            <label class="control-label" id="RadioParent">ثبت در </label>
                            <select name="RadioParent" id="RadioParent" class="form-control">
                                <option value="{$CorrectLevel}">سردسته</option>
                                {if $CorrectDeep < 1}
                                    {foreach key=key item=item from=$EntertainmentGetSubDataByLevel}
                                        <option value="{$item.CategoryId}">{$item.CategoryTitle}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>


                        <input type="hidden" name="FormStatus" value="new">

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group  pull-right">
                                    <button onclick="SubmitNewEntertainmentCategory()" type="button" class="btn btn-primary">ارسال اطلاعات</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    {/if}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست دسته بندی</h3>
                {if $smarty.session.AgencyPartner neq 'AgencyHasLogin'}
                    <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همکاران زیر مجموعه خود را مشاهده نمائید


                        <span class="pull-right">
                           <a  onclick="AddEntertainmentType({$item.CategoryId})"  data-toggle="modal" data-target="#ModalPublic" class="btn btn-info waves-effect waves-light " type="button">
                        <span class="btn-label"><i class="fa fa-star"></i></span>لیست ویژگی ها
                    </a>
                </span>
                    </p>
                {/if}
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>

                            <th>کد</th>
                            <th>نام دسته</th>
                            {if $CorrectDeep >= 1}
                            <th>تفریحات</th>
                            {else}
                            <th>زیردسته</th>
                            {/if}
                            <th>ویرایش</th>
                            <th>حذف</th>


                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$EntertainmentGetSubDataByLevel}
                            {$number=$number+1}

                            <tr id="del-{$item.id}">

                                <td class="align-middle"><span class="badge badge-info">{$item.CategoryId}</span></td>
                                <td class="align-middle">{$item.CategoryTitle}</td>
                                {if $CorrectDeep >= 1}
                                    <td class="align-middle">
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$item.CategoryId}&deep={$CorrectDeep+1}">لیست تفریحات</a>
                                    </td>
                                {else}
                                    <td class="align-middle">
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$item.CategoryId}&deep={$CorrectDeep+1}"> اضافه کردن</a>
                                    </td>
                                {/if}
                                <td class="align-middle">
                                    <a onclick="EntertainmentEditCategory({$item.CategoryId})" data-toggle="modal" data-target="#ModalPublic" >
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش">

                                        </i>
                                    </a>
                                </td>

                                <td class="align-middle">
                                    {if  $objEntertainment->GetData($item.CategoryId) != ''}
                                        <a class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف سردسته" data-placement="right"
                                           data-content="امکان حذف وجود ندارد زیرا هنوز زیر دسته دارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                        </a>
                                    {else}
                                        <a id="DelChangePrice-{$item.CategoryId}" onclick="SubmitRemoveEntertainmentCategory('{$item.CategoryId}'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف سردسته" data-placement="right"
                                           data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                        </a>
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

<script type="text/javascript" src="assets/JsFiles/entertainment.js"></script>