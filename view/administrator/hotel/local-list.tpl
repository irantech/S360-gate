{if $smarty.const.TYPE_ADMIN eq 1 }
{load_presentation_object filename="coreHotelSettings" assign="coreHotelSettings"}
{assign var="cities" value=$coreHotelSettings->getDomesticCities()}
{assign var="types" value=$coreHotelSettings->getHotelTypes()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">لیست فرودگاه ها</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h3 class="box-title m-b-0">لیست هتل های داخلی</h3>
                        <p class="text-muted m-b-30">لیست تمام هتلهای داخلی برای ویرایش اطلاعات کامل</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-primary FloatLeft" data-toggle="modal" data-target="#hotel-new">
                            افزودن هتل جدید
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="hotels-table" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>ستاره</th>
                            <th>شهر</th>
                            <th>نوع </th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="hotel-new" tabindex="-1" role="dialog" aria-labelledby="hotel-new-title"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='/' id='new-form' method='post'>
                <input type='hidden' name='method' value='newHotel'>
                <input type='hidden' name='className' value='coreHotelSettings'>
                <div class="modal-header">
                    <h5 class="modal-title">افزودن هتل جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
{*                    New Hotel Form*}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="hotel-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='/' id='hotel-edit-form' method='post'>
                <input type='hidden' name='method' value='updateSingleHotelLocal'>
                <input type='hidden' name='className' value='coreHotelSettings'>
                <input type='hidden' name='hotel_id' id='hotel_id' value=''>
                <div class="modal-header">
                    <h5 class="modal-title">ویرایش هتل </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='row mb-5'>
                        <div class='col-xs-12 col-sm-4 bg-gray-100'>
                            <div class="form-group-sm">
                                <label for="type">نوع </label>
                                <select name="type" id="type" class="form-control select2">
                                    {foreach $types as $type}
                                        <option value="{$type.Code}">{$type.Name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-4 bg-gray-100'>
                            <div class="form-group-sm">
                                <label for="name">نام هتل </label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-4 bg-gray-100'>
                            <div class="form-group-sm">
                                <label for="name_en">نام انگلیسی</label>
                                <input type="text" name="name_en" id="name_en" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class='row mb-5'>
                        <div class='col-xs-12 col-sm-4 bg-gray-100'>
                            <div class="form-group-sm">
                                <label for="city_id">شهر </label>
                                <select name="city_id" id="city_id" class="form-control select2">
                                    {foreach $cities as $city}
                                        <option value="{$city.id}">{$city.name_fa} - {$city.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-2 bg-gray-100'>
                            <div class="form-group-sm">
                                <label for="star_code">تعداد ستاره</label>
                                <select name="star_code" id="star_code" class="form-control">
                                    {for $s= 1 to 5}
                                        <option value="{$s}">{$s}</option>
                                    {/for}
                                </select>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-3 bg-gray-100'>
                            <div class='form-group-sm'>
                                <label for='phone'>تلفن</label>
                                <input type='text' name='phone' id='phone' placeholder='شماره تلفن هتل' class='form-control'>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-3 bg-gray-100'>
                            <div class='form-group-sm'>
                                <label for='fax'>فکس</label>
                                <input type='text' name='fax' id='fax' placeholder='شماره فکس هتل' class='form-control'>
                            </div>
                        </div>
                    </div>
                    <div class='row mb-5'>
                        <div class='col-xs-12 col-sm-3 bg-gray-100'>
                            <div class='form-group-sm'>
                                <label for='latitude'>عرض Latitude</label>
                                <input type='text' name='latitude' id='latitude' placeholder='عرض جغرافیایی' class='form-control'>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-3 bg-gray-100'>
                            <div class='form-group-sm'>
                                <label for='longitude'>طول Longitude</label>
                                <input type='text' name='longitude' id='longitude' placeholder='طول جغرافیایی' class='form-control'>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-3 bg-gray-100'>
                            <div class='form-group-sm'>
                                <label for='check_time_in'>ساعت تحویل</label>
                                <input type='text' name='check_time_in' id='check_time_in' placeholder='ساعت تحویل اتاق' class='form-control'>
                            </div>
                        </div>
                        <div class='col-xs-12 col-sm-3 bg-gray-100'>
                            <div class='form-group-sm'>
                                <label for='check_time_out'>ساعت تخلیه</label>
                                <input type='text' name='check_time_out' id='check_time_out' placeholder='ساعت تخلیه هتل' class='form-control'>
                            </div>
                        </div>
                    </div>
                    <div class='row mb-5'>
                        <div class='col-xs-12 mb-5'>
                            <div class='form-group-sm'>
                                <label for='address'>آدرس </label>
                                <input type='text' class='form-control' id='address' name='address' placeholder='آدرس هتل'>
                            </div>
                        </div>
                        <div class='col-xs-12 mb-5'>
                            <div class='form-group-sm'>
                                <label for='address_en'>آدرس انگلیسی </label>
                                <input type='text' class='form-control' id='address_en' name='address_en' placeholder='آدرس هتل'>
                            </div>
                        </div>
                        <div class='col-xs-12 mb-5'>
                            <div class='form-group-sm'>
                                <label for='cancel_conditions'>قوانین کنسلی</label>
                                <textarea class='form-control' id='cancel_conditions' name='cancel_conditions' placeholder='قوانین کنسلی یا توضیحات بیشتر'></textarea>
                            </div>
                        </div>
                        <div class='col-xs-2 mb-2'>
                            <div class='form-group-sm'>
                                <label for='source_parto'><span>parto ID</span><span class='edit-parto fa fa-edit text-danger'></span></label>
                                <input id='source_parto' name='source_parto' type='text' disabled class='form-control disabled'>
                            </div>
                        </div>
                        <div class='col-xs-2 mb-2'>
                            <div class='form-group-sm'>
                                <label style='white-space: nowrap' for='source_eghamat'><span>Eghamat ID</span><span class='edit-eghamat fa fa-edit text-danger'></span></label>
                                <input id='source_eghamat' name='source_eghamat' type='text' class='form-control disabled' disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"
        src="assets/plugins/bower_components/datatables-plugins/editor/dataTables.editor.min.js"></script>
<script type="text/javascript" src="assets/JsFiles/hotel-local.js"></script>
{/if}