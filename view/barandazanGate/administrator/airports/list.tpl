{if $smarty.const.TYPE_ADMIN eq 1}
    {load_presentation_object filename="airports" assign="objAirports"}

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
                            <h3 class="box-title m-b-0">لیست فرودگاه ها</h3>
                            <p class="text-muted m-b-30">لیست تمامی فرودگاه های موجود برای سرچ باکس</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-primary FloatLeft" data-toggle="modal" data-target="#airport-new">
                                افزودن فرودگاه جدید
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="airports-table" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>فرودگاه</th>
                                <th>کد Iata</th>
                                <th>شهر</th>
                                <th>کشور</th>
                                <th>داخلی / خارجی</th>
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
    <div class="modal fade" id="airport-new" tabindex="-1" role="dialog" aria-labelledby="airport-new-title"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action='/' id='airport-new-form' method='post'>
                    <input type='hidden' name='method' value='newAirport'>
                    <input type='hidden' name='className' value='airports'>
                    <div class="modal-header">
                        <h5 class="modal-title">افزودن فرودگاه جدید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class='row'>
                            <div class='col-12 col-sm-4 bg-gray-100'>
                                <div class="form-group">
                                    <label for="AirportFa">نام فرودگاه </label>
                                    <input type="text" name="AirportFa" id="AirportFa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="AirportEn">انگلیسی</label>
                                    <input type="text" name="AirportEn" id="AirportEn" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="AirportAr">عربی</label>
                                    <input type="text" name="AirportAr" id="AirportAr" class="form-control">
                                </div>
                            </div>
                            <div class='col-12 col-sm-4'>
                                <div class="form-group">
                                    <label for="CountryFa">کشور </label>
                                    <input type="text" name="CountryFa" id="CountryFa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="CountryEn">انگلیسی </label>
                                    <input type="text" name="CountryEn" id="CountryEn" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="CountryAr">عربی </label>
                                    <input type="text" name="CountryAr" id="CountryAr" class="form-control">
                                </div>
                            </div>
                            <div class='col-12 col-sm-4'>
                                <div class="form-group">
                                    <label for="DepartureCityFa">نام شهر </label>
                                    <input type="text" name="DepartureCityFa" id="DepartureCityFa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="DepartureCityEn">انگلیسی</label>
                                    <input type="text" name="DepartureCityEn" id="DepartureCityEn" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="DepartureCityAr">عربی</label>
                                    <input type="text" name="DepartureCityAr" id="DepartureCityAr" class="form-control">
                                </div>
                            </div>
                            <hr class='clear'>
                            <div class='col-12 col-sm-6'>
                                <div class="form-group">
                                    <label for="DepartureCode">کد IATA</label>
                                    <input type="text" name="DepartureCode" id="DepartureCode" class="form-control">
                                </div>
                            </div>
                            <div class='col-12 col-sm-6'>
                                <div class="form-group">
                                    <label for="IsInternal">داخلی / خارجی</label>
                                    <select name='IsInternal' id='IsInternal' class='form-control'>
                                        <option value='1'>داخلی</option>
                                        <option value='0'>خارجی</option>
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
    <div class="modal fade" id="airport-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action='/' id='airport-edit-form' method='post'>
                    <input type='hidden' name='method' value='updateAirport'>
                    <input type='hidden' name='className' value='airports'>
                    <input type='hidden' name='airport_id' id='airport_id' value=''>
                    <div class="modal-header">
                        <h5 class="modal-title">ویرایش فرودگاه </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class='row'>
                            <div class='col-12 col-sm-4 bg-gray-100'>
                                <div class="form-group">
                                    <label for="AirportFa">نام فرودگاه </label>
                                    <input type="text" name="AirportFa" id="AirportFa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="AirportEn">انگلیسی</label>
                                    <input type="text" name="AirportEn" id="AirportEn" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="AirportAr">عربی</label>
                                    <input type="text" name="AirportAr" id="AirportAr" class="form-control">
                                </div>
                            </div>
                            <div class='col-12 col-sm-4'>
                                <div class="form-group">
                                    <label for="CountryFa">کشور </label>
                                    <input type="text" name="CountryFa" id="CountryFa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="CountryEn">انگلیسی </label>
                                    <input type="text" name="CountryEn" id="CountryEn" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="CountryAr">عربی </label>
                                    <input type="text" name="CountryAr" id="CountryAr" class="form-control">
                                </div>
                            </div>
                            <div class='col-12 col-sm-4'>
                                <div class="form-group">
                                    <label for="DepartureCityFa">نام شهر </label>
                                    <input type="text" name="DepartureCityFa" id="DepartureCityFa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="DepartureCityEn">انگلیسی</label>
                                    <input type="text" name="DepartureCityEn" id="DepartureCityEn" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="DepartureCityAr">عربی</label>
                                    <input type="text" name="DepartureCityAr" id="DepartureCityAr" class="form-control">
                                </div>
                            </div>
                            <hr class='clear'>
                            <div class='col-12 col-sm-6'>
                                <div class="form-group">
                                    <label for="DepartureCode">کد IATA</label>
                                    <input type="text" name="DepartureCode" id="DepartureCode" class="form-control">
                                </div>
                            </div>
                            <div class='col-12 col-sm-6'>
                                <div class="form-group">
                                    <label for="IsInternal">داخلی / خارجی</label>
                                    <select name='IsInternal' id='IsInternal' class='form-control'>
                                        <option value='1'>داخلی</option>
                                        <option value='0'>خارجی</option>
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
    <script type="text/javascript" src="assets/JsFiles/airports.js"></script>
{/if}