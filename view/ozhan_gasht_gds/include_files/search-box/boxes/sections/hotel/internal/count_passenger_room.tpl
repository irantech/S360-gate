<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <div class="hotel_passenger_picker internal-hotel-passenger-picker-js">
            <ul onclick="openCountPassenger('internal')">
                <li><em class="number_adult internal-number-adult-js">2</em> ##Adult## ،</li>
                <li class="li_number_baby"><em class="number_baby internal-number-child-js">0</em> ##Child## ،</li>
                <li><em class="number_room_po internal-number-room-js">1</em>##Room##</li>
            </ul>
            <div class="myhotels-rooms internal-my-hotels-rooms-js">
                <div class="hotel_select_room internal-hotel-select-room-js">
                    <div class="myroom-hotel-item internal-my-room-hotel-item-js" data-roomnumber="1" >
                        <div class="myroom-hotel-item-title internal-my-room-hotel-item-title-js">
                            <span class="close d-none" onclick="itemsRoom($(this),'internal')">
                                <i class='fal fa-trash-alt'>
                                </i>
                            </span>
                            ##Room## ##First##
                        </div>
                        <div class="myroom-hotel-item-info internal-my-room-hotel-item-info-js">
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

                                <h6>##Adult##</h6>
                                ##OlderThanTwelve##
                                <div>
                                    <i class="addParent internal-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus" onclick="addNumberAdult('internal',this)">
                                    </i>
                                    <input readonly="" autocomplete="off" class="countParent internal-count-parent-js" min="0" value="2" max="5" type="number" name="adult1" id="adult1">
                                    <i class="minusParent internal-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus" onclick="minusNumberAdult('internal',this)">
                                    </i>
                                </div>
                            </div>
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                <h6> ##Child##</h6>
                                ##BetweenTwoAndTwelve##

                                <div>
                                    <i class="addChild internal-add-number-child-js hotelroom-minus plus-hotelroom-koodak fas fa-plus" onclick="addNumberChild('internal',this)">
                                    </i>
                                    <input readonly="" class="countChild internal-count-child-js" autocomplete="off" min="0" value="0" max="5" type="number" name="child1" id="child1">
                                    <i class="minusChild internal-minus-number-child-js hotelroom-minus minus-hotelroom-koodak fas fa-minus" onclick="minusNumberChild('internal',this)">
                                    </i>
                                </div>
                            </div>
                            <div class="tarikh-tavalods internal-birth-days-js"></div>
                        </div>
                    </div>
                </div>
                <div class="btn_group">
                    <div class="btn_add_room internal-btn-add-room-js" onclick="addRoom('internal')">
                        <i class="fal fa-plus"></i>
                        ##AddNew## ##Room##
                    </div>
                    <div class=" btn_close_box internal-close-room-js">
                        <i class="fal fa-check"></i>
                        ##Approve##
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>