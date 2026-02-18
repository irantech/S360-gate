{load_presentation_object filename="searchHotel" assign="objHotel"}
{load_presentation_object filename="webserviceHotel" assign="objWebservice"}
{assign var="list_hotel" value=$objHotel->getHotelListByCityId(['name' => $smarty.get.name])}
{assign var="webservice_hotel" value=$objWebservice->getNotIncludeWebservice('13')}

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست هتل ها</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام هتل</th>
                            <th>نام انگلیسی</th>
                            <th>آدرس</th>
                            <th>اقامت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$list_hotel}
                            {$number=$number+1}
                            <tr>
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.name}</td>
                                <td class="align-middle">{$item.name_en}</td>
                                <td class="align-middle">{$item.address}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline btn-default"
                                            onclick='displayHotel($(this),"{$item.id}" , "13")'>
                                        {if  $item.id|in_array:$webservice_hotel}
                                            <span>
                                            عدم نمایش
                                            </span>
                                        {else}
                                            <span>
                                             نمایش
                                            </span>
                                        {/if}


                                    </button>
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

<script type="text/javascript" src="assets/JsFiles/hotelCities.js"></script>