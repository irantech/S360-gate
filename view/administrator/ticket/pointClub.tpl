{load_presentation_object filename="PointClub" assign="objPointClub"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">امتیاز کاربر</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">فرم تعیین امتیاز خرید </h3>

                <p class="text-muted m-b-30 ">بر اساس هر مقدار خرید ،امتیاز را تعیین نمائید
                </p>

                <form id="AddPointClub" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="insert_point_club">


                    <div class="form-group col-sm-6 ">
                        <label for="limitPrice" class="control-label"> شاخص قیمت
                            <small>(به ازای هر مقدار خرید که در کادر زیر وارد می نمائید امتیاز تعیین شده محاسبه میشود)
                            </small>
                        </label>
                        <input type="text" class="form-control " name="limitPrice"
                               value="{$smarty.post.request_number}" id="limitPrice"
                               placeholder="مبلغ( به ریال  )را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="limitPoint" class="control-label "> میزان امتیاز </label>
                        <input type="text" class="form-control " name="limitPoint"
                               value="{$smarty.post.request_number}" id="limitPoint"
                               placeholder="میزان امتیاز را وارد نمائید" data-bts-button-down-class="btn btn-default btn-outline"
                               data-bts-button-up-class="btn btn-default btn-outline">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="is_foreign" class="control-label">نوع پرواز </label>
                        <select name="is_foreign" id="is_foreign" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            <option value="1">خارجی</option>
                            <option value="0">داخلی</option>
                        </select>
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
                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مقدار خرید</th>
                            <th>میزان امتیاز</th>
                            <th>تاریخ</th>
                            <th>نوع امتیاز</th>
                            <th>عملیات</th>

                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objPointClub->PointClubList()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderPrice-{$item.id}" {if $item.is_enable eq '0'} class="border-right-change-price" {/if}>{$number}</td>
                            <td>
                                {$item.limitPrice|number_format} ریال
                            </td>
                            <td>

                                {$item.limitPoint}

                            </td>
                            <td dir="ltr" class="text-left">
                                {$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}
                            </td>

                            <td>

                               {if $item.is_foreign eq '0'} داخلی{else if $item.is_foreign eq '1'} خارجی{/if}
                            </td>


                            <td>
                                {if $item.is_enable eq '0'}
                                <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"
                                   data-toggle="popover" title="حذف امتیاز" data-placement="top"
                                   data-content="شما قبلا این میزان امتیاز را حذف نموده اید"> <i
                                        class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban  "></i></a>
                                {else}
                                <a id="DelChangePrice-{$item.id}" href="#"
                                   onclick="delete_point_Club('{$item.id}'); return false"
                                   class="popoverBox  popover-danger" data-toggle="popover" title="حذف امتیاز"
                                   data-placement="top"
                                   data-content="برای حذف امتیاز کلیک کنید"> <i
                                        class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i></a>


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

<script type="text/javascript" src="assets/JsFiles/pointClub.js"></script>