{load_presentation_object filename="PriceChange" assign="objPrice"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تغییرات قیمت بلیط</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">فرم تغییرات قیمت </h3>

                <p class="text-muted m-b-30 textPriceChange">تغییرات قیمت برا اساس تاریخ پرواز می باشد و فقط در پرواز های چارتری اعمال میگردد
                </p>

                <form id="FormChangePrice" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="insert_change_price">

                    <div class="form-group col-sm-6 ">
                        <label for="start_date" class="control-label">تاریخ شروع پرواز</label>
                        <input type="text" class="form-control datepicker" name="start_date" value="{$smarty.post.start_date}"
                               id="start_date" placeholder="تاریخ شروع پرواز  را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="end_date" class="control-label">تاریخ پایان پرواز</label>
                        <input type="text" class="form-control datepicker" name="end_date"
                               value="{$smarty.post.end_date}" id="end_date"
                               placeholder="تاریخ پایان پرواز را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="abbreviation" class="control-label">نام ایرلاین</label>
                        <select name="abbreviation" id="abbreviation" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه ایرلاین ها</option>
                            {foreach $objPrice->airlineList()  as $client }

                            <option value="{$client.abbreviation}-{$client.name_fa}" {if $smarty.post.abbreviation eq $client.abbreviation}selected{/if}>{$client.name_fa}</option>

                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="change_type" class="control-label">نوع </label>
                        <select name="change_type" id="change_type" class="form-control ">
                            <option value="">انتخاب کنید....</option>

                            <option value="increase" {if $smarty.post.abbreviation eq 'increase'}selected{/if}>افزایش</option>
                            <option value="decrease" {if $smarty.post.abbreviation eq 'decrease'}selected{/if}>کاهش</option>

                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="price" class="control-label"> مبلغ </label>
                        <input type="text" class="form-control " name="price"
                               value="{$smarty.post.request_number}" id="price"
                               placeholder="مبلغ( به ریال  )را وارد نمائید">

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
                <h3 class="box-title m-b-0">سوابق تغییرات قیمت</h3>
                <p class="text-muted m-b-30">کلیه سوابق تغییر قیمت را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام ایرلاین</th>
                            <th>کد یاتای ایرلاین</th>
                            <th>تغییر قیمت</th>
                            <th>نوع تغییر قیمت</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            {*<th>وضعیت</th>*}
                            <th>عملیات</th>

                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objPrice->PriceChangeList()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderPrice-{$item.id}" {if $item.is_del eq 'yes'} class="border-right-change-price" {/if}>{$number}</td>
                            <td>
                                {$item.airline_name}
                            </td>
                            <td>

                                {$item.airline_iata}

                            </td>
                            <td>

                                {$item.price}
                            </td>
                            <td>
                                {if $item.change_type eq 'increase'} افزایش{else}کاهش{/if}
                            </td>
                            <td style="direction :ltr">
                                {$item.start_date}
                            </td>
                            <td style="direction :ltr">
                                {$item.end_date}
                            </td>
                            {*<td>

                            {if $item.is_enable eq 'yes'}
                            <a href="#"  onclick="StatusChangePrice('{$item.id}'); return false;">
                                <i class="btn btn-success fa fa-check-square-o" title="فعال"></i>
                            </a>
                            {else}
                            <i class="btn btn-danger fa fa-ban" title="غیر فعال"></i>
                            {/if}
                        </td>*}

                            <td>
                                {if $item.is_del eq yes}
                                <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="شما قبلا این بازه زمانی را حذف نموده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i></a>
                                {else}
                                <a id="DelChangePrice-{$item.id}" href="#" onclick="delete_change_price('{$item.id}'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="برای حذف بازه زمانی کلیک کنید"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i></a>


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

<script type="text/javascript" src="assets/JsFiles/changePrice.js"></script>