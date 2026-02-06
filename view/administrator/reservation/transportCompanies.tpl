{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="general" assign="objGeneral"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="typeOfVehicle">نوع وسیله نقلیه</a></li>
                <li class="active">شرکت های حمل و نقل</li>
            </ol>
        </div>
    </div>


    {if $objPublic->nameAirline($smarty.get.id) neq 'هواپیما'}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="FormTransportCompanies" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insertTransportCompanies">
                    <input type="hidden" name="id_type_of_vehicle" value="{$smarty.get.id}">

                    <div class="form-group col-sm-4">
                        <label for="name" class="control-label">نام</label>
                        <input type="text" class="form-control" name="name" value=""
                               id="name" placeholder=" نام شرکت حمل و نقل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="name_en" class="control-label">نام انگلیسی</label>
                        <input type="text" class="form-control" name="name_en" value=""
                               id="name_en" placeholder=" نام انگلیسی شرکت حمل و نقل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="abbreviation" class="control-label">کد یاتا</label>
                        <input type="text" class="form-control" name="abbreviation" value=""
                               id="abbreviation" placeholder="کد یاتا را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="../../pic/NoPhotoHotel.png"/>
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
    {/if}

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">شرکت های حمل و نقل</h3>
                <p class="text-muted m-b-30">تمامی شرکت های حمل و نقل وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>کد یاتا</th>
                            <th>عکس</th>
                            {if $objPublic->nameAirline($smarty.get.id) neq 'هواپیما'}
                                <th>ویرایش</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $objPublic->nameAirline($smarty.get.id) neq 'هواپیما'}
                            {assign var="list_transport_companies" value=$objResult->SelectAll('reservation_transport_companies_tb', 'fk_id_type_of_vehicle', {$smarty.get.id})}
                        {else}
                            {assign var="list_transport_companies" value=$objPublic->ListAirline()}
                        {/if}

                        {foreach key=key item=item from=$list_transport_companies}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>
                                {if $objPublic->nameAirline($smarty.get.id) neq 'هواپیما'}
                                    {$item.name}
                                {else}
                                    {$item.name_fa}
                                {/if}
                            </td>

                            <td>{$item.name_en}</td>

                            <td>{$item.abbreviation}</td>

                            <td>
                                {if $objPublic->nameAirline($smarty.get.id) neq 'هواپیما'}
                                    {if $item.pic neq ''}
                                        <img src="..\..\pic\{$item.pic}" class="all landscape width30" alt="gallery"/>
                                    {else}
                                        <img src="..\..\pic\NoPhotoHotel.png" class="all landscape width30" alt="gallery"/>
                                    {/if}
                                {else}
                                    <img src="{$objGeneral->getAirlinePhoto($item.abbreviation)}" class="all landscape width30" alt="gallery"/>
                                {/if}
                            </td>

                            {if $objPublic->nameAirline($smarty.get.id) neq 'هواپیما'}
                                <td>
                                    <a href="transportCompaniesEdit&id={$item.id}&idTypeVehicle={$smarty.get.id}">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش">
                                        </i>
                                    </a>
                                </td>
                            {/if}

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