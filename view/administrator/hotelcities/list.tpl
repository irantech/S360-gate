{if $smarty.const.TYPE_ADMIN eq 1 }
{load_presentation_object filename="hotelCities" assign="objHotelCities"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">لیست شهرهای هتل خارجی</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h3 class="box-title m-b-0">لیست شهر ها</h3>
                        <p class="text-muted m-b-30">لیست تمامی شهرهای هتل خارجی</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-primary FloatLeft" data-toggle="modal" data-target="#city-new">
                            افزودن شهر جدید
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="cities-table" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام شهر</th>
                            <th>نام فارسی</th>
                            <th>کشور</th>
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
<div class="modal fade" id="city-new" tabindex="-1" role="dialog" aria-labelledby="city-new-title"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='/' id='city-new-form' method='post'>
                <input type='hidden' name='method' value='newCity'>
                <input type='hidden' name='className' value='hotelCities'>
                <div class="modal-header">
                    <h5 class="modal-title">افزودن شهر جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-12 col-sm-4 bg-gray-100'>
                            <div class="form-group">
                                <label for="name_fa">نام شهر (فارسی) </label>
                                <input type="text" name="city_name_fa" id="name_fa" class="form-control">
                            </div>
                        </div>
                        <div class='col-12 col-sm-4 bg-gray-100'>
                            <div class="form-group">
                                <label for="name">انگلیسی</label>
                                <input type="text" name="city_name_en" id="name" class="form-control">
                            </div>
                        </div>
                        <div class='col-12 col-sm-4'>
                            <div class="form-group">
                                <label for="country_id">کشور </label>
                                <select class="select2 form-control" name="country_id" id="country_id">
                                    {foreach $objHotelCities->allCountries() as $country}
                                        <option value="{$country.id}">{$country.titleFa} {$country.titleEn}</option>
                                    {/foreach}
                                </select>
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

<!-- Modal -->
<div class="modal fade" id="city-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='/' id='city-edit-form' method='post'>
                <input type='hidden' name='method' value='updateCity'>
                <input type='hidden' name='className' value='hotelCities'>
                <input type='hidden' name='city_id' id='city_id' value=''>
                <div class="modal-header">
                    <h5 class="modal-title">ویرایش شهر </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-12 col-sm-4 bg-gray-100'>
                            <div class="form-group">
                                <label for="name_fa">نام شهر (فارسی) </label>
                                <input type="text" name="city_name_fa" id="name_fa" class="form-control">
                            </div>
                        </div>
                        <div class='col-12 col-sm-4 bg-gray-100'>
                            <div class="form-group">
                                <label for="name">انگلیسی</label>
                                <input type="text" name="city_name_en" id="name" class="form-control">
                            </div>
                        </div>
                        <div class='col-12 col-sm-4'>
                            <div class="form-group">
                                <label for="country_id">کشور </label>
                                <select class="select2 form-control" name="country_id" id="country_id">
                                    {foreach $objHotelCities->allCountries() as $country}
                                        <option value="{$country.id}">{$country.titleFa} {$country.titleEn}</option>
                                    {/foreach}
                                </select>
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
<script type="text/javascript" src="assets/JsFiles/hotelCities.js"></script>
{/if}
