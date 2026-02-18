{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

<div class="main-Content-bottom-table Dash-ContentL-B-Table ">
    <div class=" site-bg-main-color title_table">
        <i class="icon-table"></i>
        <h3>##ListHotelsRegisteredYou## :</h3>
        {if $hotel_list['type'] == 'admin'}
        <a class="archive-tour" href="{$smarty.const.ROOT_ADDRESS}/newHotel"> ##NewHotel##</a>
        <a class="archive-tour" href="{$smarty.const.ROOT_ADDRESS}/hotelRole"> ##HotelUsersList## </a>
        {/if}
    </div>

    <div class="content-table">

        <table id="hotelList" class="display" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th>##Row##</th>
                <th> ##Namehotel##</th>
                <th> ##Star## </th>
                <th> ##City## </th>
                <th> ##Status## </th>

                {if $hotel_list['type'] == 'admin'}

                {if !isset($smarty.get.id) }

                    <th> ##Typeroom##</th>
                    <th>##HotelFacilities##</th>
                    <th>##Gallery##</th>
                    <th>##Edit##</th>
                    <th>##Delete##</th>

                {/if}
                {/if}

            </tr>
            </thead>

            <tbody>
            {assign var="number" value="0"}

            {assign var="reportHotel" value=$objResult->SelectAll('reservation_hotel_tb' , 'user_id'  , $smarty.session.userId)}



            {foreach key=key item=item from=$hotel_list['hotel_list']}
                {$number=$number+1}
                <tr>
                    <td data-content="##Row##">{$number}</td>
                    {if $item['is_accept'] eq 'yes'}
                        <td data-content="##Createdate##">
                            <a href="hotel/{$item.id}">{$item.name}</a>
                        </td>
                    {else}
                        <td data-content="##Createdate##">{$item.name}</td>
                    {/if}

                    <td data-content="##Nametour##">{$item.star_code}</td>
                    <td data-content="##Datestarthold##">{$objFunction->ShowName(reservation_country_tb,$item.country)} - {$objFunction->ShowName(reservation_city_tb,$item.city)}</td>
                    <td data-content="##Status##">

                        {if $item['is_show'] eq ''}
                            <div><i class="fcbtn btn btn-outline btn-warning btn-1c fa fa-bread-slice"></i></div>
                        {elseif $item['is_show'] eq 'yes'}
                            <div>
                                <i  class="fcbtn btn btn-outline btn-success btn-1c fa fa-check"></i>
                            </div>
                        {elseif $item['is_show'] eq 'no'}
                            <div>
                                <i  data-toggle="tooltip" data-placement="top" title="{$item['comment_cancel']}"
                                    class="fcbtn btn btn-outline btn-danger btn-1c fa fa-times"></i>
                            </div>
                        {/if}
                    </td>
                    {if $hotel_list['type'] == 'admin'}
                    <td data-content="##Countnight##">
                        <a href="hotelRoomList&id={$item.id}" class="waves-effect waves-light" type="button">
                            <i class="fcbtn btn btn-outline btn-all-public  btn-1c fa fa-bed "></i>
                        </a>
                    </td>
                    <td data-content="##Countnight##">
                        <a href="hotelFacilities&id={$item.id}" class="waves-effect waves-light" type="button">
                            <i class="fcbtn btn btn-outline btn-all-public  btn-1c fa fa-bread-slice"></i>
                        </a>
                    </td>
                    <td data-content="##Countnight##">
                        <a href="hotelGallery&id={$item.id}" class="waves-effect waves-light" type="button">
                            <i class="fcbtn btn btn-outline btn-all-public btn-1c fa fa-camera"></i>
                        </a>
                    </td>
                    <td data-content="##Countnight##">
                        <a href="editHotel&id={$item.id}">
                            <i  class="fcbtn btn btn-outline btn-all-public btn-1e fa fa-pencil tooltip-primary"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="##Edit##">

                            </i>
                        </a>
                    </td>
                    <td data-content="##Countnight##">
                        <a id="DelChangePrice-2" onclick="logical_deletion('{$item.id}', 'reservation_hotel_tb'); return false"
                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                           data-placement="right" data-content="##Delete##" data-original-title="##Removechanges##">
                            <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                        </a>
                    </td>
                {/if}
                </tr>
            {/foreach}

        </table>
    </div>
</div>

{literal}
    <script src="assets/marketPlace/js/hotel.js"></script>
{/literal}
