{load_presentation_object filename="hotelCities" assign="objHotelCity"}
{assign var="list_city" value=$objHotelCity->getAllHotelCities()}

<div class="container-fluid">
<div class="row">

    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">لیست شهرهای ایران</h3>

            <div class="table-responsive">
                <table id="myTable" class="table table-striped ">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام شهر</th>
                        <th>نام انگلیسی</th>
                        <th>یاتا</th>

                    </tr>
                    </thead>
                    <tbody>
                    {assign var="number" value="0"}
                    {foreach key=key item=item from=$list_city}
                        {$number=$number+1}
                        <tr>
                            <td class="align-middle">{$number}</td>
                            <td class="align-middle"><a href=webServiceHotelList?name={$item.city_name_en}>{$item.city_name}</a></td>
                            <td class="align-middle">{$item.city_name_en}</td>
                            <td class="align-middle">{$item.city_iata}</td>

                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>