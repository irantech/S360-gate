{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}
<div class="main-Content-top s-u-passenger-wrapper-change" >
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
        <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i>   اضافه کردن عکس برای {$objFunction->ShowName('reservation_hotel_tb', {$smarty.get.id})}
    </span>
    <div class="panel-default-change site-border-main-color">
        <form class="s-u-result-item-change" data-toggle="validator" id="hotelGallery" method="post">
            <input type="hidden" name="flag" id="flag" value="insert_Gallery" />
            <input type="hidden" name="id_hotel" id="id_hotel" value="{$smarty.get.id}">
            <input type="hidden" name="table_name" id="table_name" value="reservation_hotel_gallery_tb">
            <input type="hidden" name="foreign_key_constraint" id="foreign_key_constraint" value="id_hotel">

            <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                <label for="picTitle" class="flr"> ##Titleimg##:</label>
                <input type="text" name="name" id="name" placeholder=" ##Titleimg##">
            </div>

            <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                <label for="pic" class="flr">##Gallery##:</label>
                <input type="file" name="pic" id="pic"
                       accept="image/x-png, image/gif, image/jpeg, image/jpg"/>
            </div>

            <div class="userProfileInfo-btn userProfileInfo-btn-change">
                <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color" type="submit" value="##Register##">
            </div>
        </form>
    </div>
</div>




<div class="main-Content-bottom Dash-ContentL-B">
    <div class="main-Content-bottom-table Dash-ContentL-B-Table">
        <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
            <i class="icon-table"></i><h3> ##Gallerytour##</h3>
        </div>
        <div class="table-responsive" style="width: 100%;">
            <table id="myTable" class="table table-striped text-center" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th >ردیف</th>
                    <th>  نام</th>
                    <th >عکس</th>
                    <th>حذف</th>
                </tr>
            </thead>

            <tbody>
            {assign var="number" value="0"}
            {foreach key=key item=item from=$objResult->SelectAll('reservation_hotel_gallery_tb', 'id_hotel', {$smarty.get.id})}
                {$number=$number+1}
                <tr>
                    <td>{$number}</td>
                    <td>{$item.name}</td>
                    <td>
                        {if $item.pic neq ''}
                            <img src="..\..\gds\pic\{$item.pic}" style='width:500px' class="all landscape width30" alt="gallery"/>
                        {else}
                            <img src="..\..\gds\pic\NoPhotoHotel.png" style='width:500px' class="all landscape width30" alt="gallery"/>
                        {/if}
                    </td>
                    <td>
                        <a onclick="logical_deletion('{$item.id}' , 'reservation_hotel_gallery_tb'); return false;" class="btn btn-danger fa fa-times"></a>
                    </td>
                </tr>
            {/foreach}
            </tbody>


        </table>
        </div>
    </div>
</div>

