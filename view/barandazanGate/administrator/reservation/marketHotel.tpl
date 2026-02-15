{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}
{load_presentation_object filename="reservationHotel" assign="objHotel"}
{load_presentation_object filename="mainCity" assign="objCity"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">هتل ها</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <form id="marketHotelFilter" action="{$smarty.const.rootAddress}marketHotel" method="post" style="overflow: auto;">
                    <div class="form-group col-sm-4">
                        <label for="search_city" class="control-label">لیست شهرها</label>
                        <select name="search_city"
                                id="search_city"
                                class="form-control select2 select2-hidden-accessible"
                            <option value="">انتخاب کنید</option>
                            <option value="">انتخاب کنید</option>
                            {foreach $objCity->getCityAll() as $key => $city}
                                <option value="{$city['id']}" {if $smarty.post.search_city eq $city['id'] }selected{/if}>
                                     {$city['name']}
                                </option>
                            {/foreach}

                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="search_star" class="control-label">ستاره</label>
                        <select name="search_star" id="search_star" class="form-control select2 select2-hidden-accessible">
                            <option value="">انتخاب کنید....</option>
                            <option value="1" {if $smarty.post.search_star eq '1' }selected{/if}>1*</option>
                            <option value="2" {if $smarty.post.search_star eq '2' }selected{/if}>2*</option>
                            <option value="3" {if $smarty.post.successfull eq '3' }selected{/if}>3*</option>
                            <option value="4" {if $smarty.post.successfull eq '4' }selected{/if}>4*</option>
                            <option value="5" {if $smarty.post.successfull eq '4' }selected{/if}>5*</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="search_hotel" class="control-label">نام هتل</label>
                        <input type="text" class="form-control " name="search_hotel"
                               id="search_hotel" value='{$smarty.post.search_hotel}'
                               autocomplete="off"
                               placeholder="نام هتل را وارد نمائید">
                    </div>

                    <div class="form-group w-100 mb-3 float-left">
                        <button type="submit"
                                class="btn btn-info float-left">اعمال فیلتر
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">هتل</h3>

                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام هتل</th>
                            <th>ستاره</th>
                            <th>شهر</th>
                            <th>نام آژانس</th>
                            <th>نمایش در سایت</th>
                            <th>اولویت</th>
                            <th>وضعیت</th>
                            <th>هتل ویژه</th>
                            <th>نمایش در صفحه اول</th>
                            <th>نوع اتاق</th>
                            <th>امکانات هتل</th>
                            <th>گالری</th>
                            <th>تنظیمات قیمت</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objHotel->getHotelList($smarty.post)}
                            {assign var="agency" value=$objFunction->getAgency($item.user_id)}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td id="borderFlyNumber-{$item.id}">{$number}</td>

                                <td>{$item.name}</td>

                                <td>{$item.star_code}</td>

                                <td>{$objFunction->ShowName(reservation_country_tb,$item.country)} - {$objFunction->ShowName(reservation_city_tb,$item.city)}</td>

                                <td>
                                    {$agency['name']} {$agency['family']}
                                </td>
                                <td class="text-align-center" onclick="EditInPlace('{$item.id}','{$item.priority}')" id="{$item.id}{$item.priority}">
                                    {$item.priority}
                                </td>
                                <td>
                                    {if $item.is_show eq ''}
                                        <span title='ثبت جدید هتل' class='fa fa-info-circle bg-warning p-2 text-white rounded'></span>
                                    {elseif $item.is_show eq 'yes'}
                                        <span title='نمایش در سایت' class='fa fa-check bg-success p-2 text-white rounded'></span>
                                    {elseif $item.is_show eq 'no'}
                                        <span title='عدم نمایش در سایت' class='fa fa-trash bg-danger p-2 text-white rounded'></span>
                                    {/if}
                                    {*                                {if (isset($item['changeTourPrices']) && $item['changeTourPrices'] neq '')}*}
                                    {*                                    <a href='changeTourPricesLogs&id={$item['id_same']}' class='btn btn-primary rounded'>*}
                                    {*                                        مشاهده تغییرات قیمت*}
                                    {*                                    </a>*}

                                    {*                                {/if}*}

                                </td>
                                <td>
                                    <a onclick="isAcceptHotel('{$item['id']}'); return false;">
                                        {if $item['is_accept'] eq 'yes'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>
                                    <a onclick="isSpecialHotel('{$item['id']}'); return false;">
                                        {if $item['flag_special'] eq 'yes'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>
                                    <a onclick="showInHome('{$item['id']}'); return false;">
                                        {if $item['show_in_home'] eq 1}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>
                                    <a href="addHotelRoom&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-check"></i></span>                                    اتاق
                                    </a>
                                </td>

                                <td>
                                    <a href="hotelFacilities&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-check"></i></span>                                    امکانات هتل
                                    </a>
                                </td>

                                <td>
                                    <a href="addHotelGallery&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-check"></i></span>                                    عکس
                                    </a>
                                </td>



                                <td>
                                    <a href="marketChangePrice&id={$item.id}&type=hotel">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-dollar tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="مارک اپ">

                                        </i>
                                    </a>
                                    <a href="marketDiscount&type=hotel&id={$item.id}">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-percent tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="تخفیف">

                                        </i>
                                    </a>
                                    <a href="marketCommission&id={$item.id}&type=hotel">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-flash tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="کمیسیون">

                                        </i>
                                    </a>
                                </td>
                                <td>
                                    <a href="hotelEdit&id={$item.id}">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش">

                                        </i>
                                    </a>
                                </td>
                                <td>
                                    <a id="DelChangePrice-2" onclick="logical_deletion('{$item.id}', 'reservation_hotel_tb'); return false"
                                       class="popoverBox  popover-danger" data-toggle="popover" title=""
                                       data-placement="right" data-content="حذف" data-original-title="حذف تغییرات">
                                        <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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
        <span> ویدیو آموزشی بخش هتل   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/386/-.html" target="_blank" class="i-btn"></a>

</div>


<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>