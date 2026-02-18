{load_presentation_object filename="busPanel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href='main'>
                        مدیریت بلیط رزرواسیون اتوبوس
                    </a>
                </li>
                <li class="active">لیست پایانه ها</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box d-flex w-100 flex-wrap">
                <h3 class="box-title m-b-0"></h3>

                     <input type="hidden" name="flag" value="insert_ticket">

                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر</label><span class="star">*</span>
                        <select name="origin_city" id="origin_city" class="select2 form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->getCities(['*']) as $city}
                                <option value="{$city['id']}">{$city['name_fa']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="terminal_name" class="control-label">نام پایانه </label>
                        <span class="star">*</span>
                        <input type='text' name='terminal_name' id='terminal_name' class='form-control'>
                    </div>


                    <div class="form-group col-sm-4">
                        <label for="origin_terminal" class="control-label">ذخیره</label>

                        <button onclick="adminAddStation($(this),$('#origin_city').val(),$('#terminal_name').val())" class='form-control text-white btn btn-primary'>
                            ثبت
                        </button>
                    </div>


            </div>

        </div>
    </div>

</div>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">لیست دسته بندی</h3>


            <div class="table-responsive">
                <table id="myTable" class="table table-striped ">
                    <thead>
                    <tr>

                        <th>ردیف</th>
                        <th>نام شهر</th>
                        <th>نام پایانه</th>
                        <th>ویرایش</th>
                        <th>حذف</th>


                    </tr>
                    </thead>
                    <tbody>
                    {assign var="data" value=$objResult->getStations()}

                    {assign var="number" value="0"}


                    {if $data != ''}
                        {foreach key=key item=item from=$data}
                            {$number=$number+1}

                            <tr id="del-{$item.id}">

                                <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                <td class="align-middle" >{$item.city_name}</td>
                                <td class="align-middle" data-name='station_name'>{$item.station_name}</td>


                                <td class="align-middle">
                                    <button   class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                              data-toggle="tooltip" data-placement="top" title=""
                                              data-original-title="ویرایش"
                                              onclick="adminEditStation($(this),'{$item.id}')" >
                                    </button>
                                </td>

                                <td class="align-middle" >
                                    <button class="fcbtn btn btn-outline btn-danger btn-1e fa fa-trash tooltip-danger"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="حذف"
                                            onclick="adminDeleteStation($(this),'{$item.id}')" >
                                    </button>
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

<script type="text/javascript" src="assets/JsFiles/reservationBus.js"></script>