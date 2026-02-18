
{load_presentation_object filename="resultHotelLocal" assign="objResult"}

{assign var="hotelId" value=$smarty.post.idHotel_select}
{$objResult->getHotelRoom($hotelId)}
{$objResult->getInfoRoom($hotelId)}
<!-- room table -->


<section class='hotelRoomInfo'>
    {foreach $objResult->reservationHotelRoom as $room}
        {assign var="all_gallery" value = $objResult->roomGallery[$room.id_room]}
        {assign var="iii" value = 1}
        {foreach $all_gallery as $gallery}
            {if $iii eq 1}
                {assign var="first_img_gallery" value=$gallery}
{*                {$first_img_gallery|var_dump}*}
                {$iii = $iii + 1}
            {/if}
        {/foreach}


        {*    {assign var="roomName" value="-"|explode:$room['room_name']}*}
        <div class='hotelRoomInfo_parent'>
            <div class='hotelRoomInfo_box'>
                {if $objResult->infoRoomGallery[$room.id_room] eq 'true'}
                    <div class='hotelRoomInfo_images col-lg-5 col-12'>
                        <a class='hotelRoomInfo_main_images' data-fancybox="images15" href='{$first_img_gallery['pic_url']}'>
                            <img src='{$first_img_gallery['pic_url']}' alt='{$first_img_gallery['pic_name']}'>
                        </a>
                        <div class='hotelRoomInfo_box_images'>
                        {foreach $all_gallery as $gallery}
                            <a data-fancybox="images{$room.id_room}" href="{$gallery['pic_url']}"><img  src="{$gallery['pic_url']}" alt="{$gallery['pic_name']}"></a>
                        {/foreach}
                        </div>
                    </div>
                {/if}
                <div class='col-lg-7 col-12'>
                    <div class="hotelRoomInfo_text">
                        <h2 class='hotelRoomInfo_text_h2'>{$room['room_name']}</h2>
                        <span class='hotelRoomInfo_text_span'>ظرفیت اتاق: {$room['room_capacity']} نفر</span>
                    </div>
                    <h3 class='hotelRoomInfo_text_h3'>{$room['room_comment']}</h3>
                    <h4 class='hotelRoomInfo_text_h4'>امکانات اتاق:</h4>
                    <div class='hotelRoomInfo_text_div'>

                        {if $objResult->infoRoomFacilities[$room.id_room] eq 'true'}
                            {foreach $objResult->roomFacilities[$room.id_room] as $facilities}
                                <span>
                                    <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M441 103c9.4 9.4 9.4 24.6 0 33.9L177 401c-9.4 9.4-24.6 9.4-33.9 0L7 265c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l119 119L407 103c9.4-9.4 24.6-9.4 33.9 0z"/></svg></i>
                                    {$facilities['title']}
                                </span>
                            {/foreach}
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
</section>

<div id="room-image-modal" class="room-image-modal">
    <div class="modal-content">
        <span class="room-image-close"><i class="fa fa-window-close"></i></span>
        <img class="modal-image" id="img01">
    </div>
</div>
<!--end room table -->
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $("body").delegate(".DetailRoom", "click", function () {
                $(this).parent().parent().next(".RoomDescription").toggleClass("trShowHideHotelDetail");
                $(this).parent().parent().next(".RoomDescription").find(".DetailRoomView").toggleClass("displayiN");
                $(this).children(".DetailRoom .fa").toggleClass(" fa-caret-down  fa-caret-up");
            });
        })
    </script>
<script src="assets/js/jquery.fancybox.min.js"></script>
{/literal}