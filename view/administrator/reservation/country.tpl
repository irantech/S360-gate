
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="country" assign="objCountry"}
{assign var="Contries" value=$objCountry->countriesByContinentID($smarty.get.id,true)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li class="active">تعریف کشور</li>
            </ol>
        </div>
    </div>

    <style>
        #country_code {
            position: relative;
        }

        #country_code + .dropdown-menu {
            top: 100% !important;
            bottom: auto !important;
            transform: none !important;
        }
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 6px 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            background: #fff !important;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <form id="FormCountry" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_country">
                    <input type="hidden" name="id_continent" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="country_code" class="control-label">نام کشور</label>
                        <select name="country_code" id="country_code" class="form-control ">
                            <option value="">انتخاب کنید</option>
                            {foreach $Contries as $each}
                                <option value="{$each.code}">{$each.titleFa}</option>
                            {/foreach}
                        </select>
                    </div>

                    {*<div class="form-group col-sm-6">
                        <label for="country_name" class="control-label">نام کشور</label>
                        <input type="text" class="form-control" name="country_name" value="{$smarty.post.country_name}"
                               id="country_name" placeholder=" نام کشور را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="country_name_en" class="control-label">نام انگلیسی کشور</label>
                        <input type="text" class="form-control" name="country_name_en" value="{$smarty.post.country_name_en}"
                               id="country_name_en" placeholder=" نام انگلیسی کشور را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="country_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="country_abbreviation" value="{$smarty.post.country_abbreviation}"
                               id="country_abbreviation" placeholder="نام اختصار را وارد نمائید">
                    </div>*}

                    <div class="form-group col-sm-3">
                        <label for="type_arz" class="control-label">قیمت برای ویزا، هر</label>
                        <select name="type_arz" id="type_arz" class="form-control ">
                            <option value="">انتخاب کنید</option>
                            <option value="1">دلار</option>
                            <option value="2">درهم</option>
                            <option value="3">یورو</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="cost_arz" class="control-label">مبلغ</label>
                        <input type="text" class="form-control" name="cost_arz" value=""
                               id="cost_arz" placeholder="ریال می باشد">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="comments_visa" class="control-label">توضیحات برای ویزا</label>
                        <textarea type="text" class="form-control" name="comments_visa" id="comments_visa" value=""></textarea>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="pic" class="control-label">عکس</label>
                            <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                                   data-default-file=""/>
                        </div>
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
                <h3 class="box-title m-b-0">تعریف کشور</h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کشور</th>
                            <th>نام اختصار</th>
                            <th>برگزیده</th>
                            <th>اولویت</th>
                            <th>تعریف شهر</th>
                            <th>عکس</th>
                            <th>ویرایش</th>
                            <th>جزئیات ویزا</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_country_tb', 'id_continent', {$smarty.get.id})}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>{$item.abbreviation}</td>

                            <td>
                                    <a href="#" onclick="toggleFavoriteCountry('{$item.id}'); return false;">
                                        {if $item.sort_order > 0}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                            </td>

                            <td>
                                <input type="number"
                                       value="{$item.sort_order|default:0}"
                                       min="0"
                                       max="999"
                                       style="width: 60px; text-align: center;"
                                       onchange="setSortOrder('country', {$item.id}, this.value)"
                                       class="form-control" />
                            </td>

                            <td>
                                <a href="city&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    اضافه کردن شهر
                                </a>
                            </td>

                            <td>
                                {if $item.is_del neq 'yes'}
                                <a href="countryEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                                {/if}
                            </td>
                            <td>
                                <img src="/gds/pic/country/{$smarty.const.CLIENT_ID}/{$item.pic}" class="w-25"/>
                            </td>
                            <td>
                                {if $item.is_del neq 'yes'}
                                    <a href="countryEditVisaType&id={$item.id}">
                                        <i  class="fcbtn btn btn-outline btn-warning btn-1e fa fa-table tooltip-warning"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="جزئیات ویزا">

                                        </i>
                                    </a>
                                {/if}
                            </td>

                            <td>
                                {if $objResult->permissionToDelete('reservation_city_tb', 'id_country', $item.id) eq 'yes'}
                                <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="امکان حذف کشور وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                {elseif $item.is_del eq 'yes'}
                                <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="کشور را قبلا حذف کرده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                {else}
                                <a id="DelCountry-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_country_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف کشور"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script>
   // در فایل reservationBasicInformation.js اضافه کنید
   $(document).ready(function() {
      // جلوگیری از باز شدن سلکت باکس به سمت بالا
      $('select.form-control').on('click', function() {
         var $this = $(this);
         var $dropdown = $this.next('.dropdown-menu');
         if ($dropdown.length) {
            $dropdown.removeClass('dropup').addClass('dropdown');
            $dropdown.css({
               'top': '100%',
               'bottom': 'auto'
            });
         }
      });
   });
</script>