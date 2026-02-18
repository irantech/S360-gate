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
                <li class="active">مدیریت تلگرام  </li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        </div>


    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">



                <h3 class="box-title m-b-0">مسیر جدید  </h3>
                <p class="text-muted m-b-30">
                    اگر مسیری غیر از مسیر های بالا را میخواهید لطفا انتخاب کنید
                </p>

                <form data-toggle="validator" id="insertRouteRobot" method="post">
                    <input type="hidden" name="flag" value="insertRouteRobot">
                    <div class="col-sm-6">
                        <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                            <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                <select class="form-control select2 option1 " name="origin" id="origin_local" style="width:100%;"
                                        tabindex="2" onchange="select_Airport()"> }
                                    <option value="0" >انتخاب کنید</option>
                                    {foreach $objResult->dep_airport as $Dep}
                                        <option value="{$Dep.Departure_Code}"
                                                {if $Dep.Departure_Code == $smarty.const.SEARCH_ORIGIN}selected="selected"{/if}>{$Dep.Departure_City}
                                            ({$Dep.Departure_Code})
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                            <div class="s-u-in-out-wrapper ">
                                <select class="form-control select2 option1 " name="destination" id="destination_local" style="width:100%;"
                                        tabindex="2">
                                    <option value="0" >انتخاب کنید</option>
                                    {foreach $objResult->dep_airport_arival as $Arr}
                                        <option value="{$Arr.Arrival_Code}"
                                                {if $Arr.Arrival_Code == $smarty.const.SEARCH_DESTINATION}{/if}>{$Arr.Arrival_City}
                                            ({$Arr.Arrival_Code})
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                            <button type="submit" class="btn btn-primary" style="margin-left: 5px;">ایجاد مسیر جدید   </button>

                        </div>
                    </div>
                </form>


            </div>






        </div>

        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0"> لیست مسیر ها </h3>



                    <div style="text-align: left;padding: 15px;">
                    <span class="btn btn-primary" onclick="ModalShowindexActiveRobot('{$item.id}');return false"
                          data-toggle="modal"
                          data-target="#ModalPublic">
       ارسال اطلاعات
  </span>
                        </div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped ">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>مبدا</th>
                                <th>مقصد</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$objTelegram->listTicketALL()}


                                {$number=$number+1}
                                <tr>
                                    <td class="align-middle">
                                        {$number}
                                    </td>
                                    <td class="align-middle">
                                        {{functions::NameCity($item.DepartureCode)}}
                                    </td>
                                    <td class="align-middle">
                                        {{functions::NameCity($item.ArrivalCode)}}
                                    </td>
                                    <td class="align-middle">

                                        <a data-value="{$item.id}" href="#"
                                           onclick="StatuslistTelegram('{$smarty.get.id}', '{$item.abbreviation}', 'charter',$(this)); return false">
                                            {if $item.status eq '1'}
                                                <input id="status" data-value="0" type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" name="active-{$item.id}" checked/>




                                            {else}

                                                <input id="status" data-value="1" type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262"  data-size="small"/>


                                            {/if}
                                        </a>
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

        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">

                    <h3 class="box-title m-b-0"> بررسی کاربران عضو شده   </h3>
                    <p class="text-muted m-b-30">
                       با وارد کردن اطلاعات بررسی کنید که کاربر در گروهی که ربات وجود دارد عضو شده است یا نه
                    </p>

                    <form data-toggle="validator" id="checkUser" method="post">
                        <input type="hidden" name="flag" value="checkUser">


                        <div class="row">





                            <div class="col-sm-6">
                                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                                    <div class="s-u-in-out-wrapper ">

                                            <select  style="width:100%;" id="item" name="item" class="form-control select2 option1 " tabindex="-1" title=" گروه ها / کانال ها "  >

                                                <option value="0" > گروه مورد نظر را انتخاب کنید</option>
                                                {foreach key=key item=item from=$objTelegram->listRobotALL()}


                                                    <option value="{$item.id}">{$item.username}</option>

                                                {/foreach}



                                            </select>
                                    </div>
                                </div>

                            </div>
                            <div class=" col-sm-6 ">

                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="  آیدی کاربر را وارد نمائید" value="">
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                                <button type="submit" class="btn btn-primary" style="margin-left: 5px;"> بررسی کردن    </button>

                            </div>
                        </div>
                    </form>


                </div>

            </div>


        </div>


    </div>

    <script type="text/javascript" src="assets/JsFiles/telegram.js"></script>


    <div class="i-section">
        <div class="i-info">
            <span> ویدیو آموزشی بخش مدیریت تلگرام</span>
        </div>

        <a href="https://www.iran-tech.com/whmcs/knowledgebase/400/--.html" target="_blank" class="i-btn"></a>
    </div>