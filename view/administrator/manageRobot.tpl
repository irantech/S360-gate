{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{$objServicesDiscount->getAll()} {*گرفتن لیست تخفیف ها*}
{load_presentation_object filename="airline" assign="objAirline"}
{$objAirline->getAll()}

{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

{$objServicesDiscount->getAllServices()} {*گرفتن لیست خدمات*}
{load_presentation_object filename="manageTelegram" assign="objTelegram"}
{load_presentation_object filename="resultLocal" assign="objResult"}
{$objResult->getAirportDeparture($smarty.const.ISFOREIGN)}
{$objResult->getAirportArrival($smarty.const.SEARCH_ORIGIN)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">مدیریت ربات  </li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        </div>


    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0"> مشخصات ربات  </h3>
                <p class="text-muted m-b-30">
                   اطلاعات اولیه برای ثبت ربات الزامیست
                </p>

                <form data-toggle="validator" id="createRobot" method="post">
                    <input type="hidden" name="flag" value="createListRobot">


                    <div class="form-group col-sm-6 ">
                        <label for="nameFa" class="control-label"> نام گروه یا کانال   </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder=" اسم گروه یا کانال را وارد کنید " value="">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="nameFa" class="control-label">توکن </label>
                        <input type="text" class="form-control" id="token" name="token" placeholder="توکن را وارد نمائید" value="">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="nameFa" class="control-label">برند </label>
                        <input type="text" class="form-control" id="brand" name="brand" placeholder="متن برند  را وارد نمائید" value="">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="nameFa" class="control-label">عنوان </label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="عنوان را وارد نمائید" value="">
                    </div>


                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                            <button type="submit" class="btn btn-primary" style="margin-left: 5px;"> ثبت ربات    </button>

                        </div>
                    </div>
                </form>


            </div>






        </div>

        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0"> لیست ربات </h3>



                    <div class="table-responsive">
                         <table id="myTable" class="table table-striped ">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام ربات</th>

                                <th>چت آیدی گروه / کانال</th>
                                <th>توکن ربات</th>
                                <th>عملیات</th>



                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$objTelegram->listRobotALL()}


                                {$number=$number+1}
                                <tr>
                                    <td class="align-middle">
                                        {$number}
                                    </td>
                                    <td class="align-middle">
                                        {$item.username}
                                    </td>
                                    <td class="align-middle">
                                        {$item.chat_id}
                                    </td>
                                    <td class="align-middle">
                                        {$item.api_token}
                                    </td>
                                    <td>

                                        <a onclick="removeRobot(window.event,{$item.id})"  href="#" ><i class="fcbtn btn btn-outline btn-success btn-1e fa fa-remove tooltip-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف"></i></a>

                                    </td>

                                </tr>

                            {/foreach}

                            </tbody>
                        </table>
                    </div>
                    </form>



                </div>
            </div>

        </div>




    </div>
    <script>

        function select_Airport() {
            var Departure = $('#origin_local').val();
            $.post(amadeusPath + 'user_ajax.php',
                {
                    Departure: Departure,
                    flag: "select_Airport",
                },
                function (data) {
                    $('#destination_local').html(data);
                    $('#destination_local').select2('open');
                })
        }
    </script>
    <script type="text/javascript" src="assets/JsFiles/telegram.js"></script>




    <div class="i-section">
        <div class="i-info">
            <span> ویدیو آموزشی بخش مدیریت ربات</span>
        </div>

        <a href="https://www.iran-tech.com/whmcs/knowledgebase/400/--.html" target="_blank" class="i-btn"></a>
    </div>