<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <div class="hotel_passenger_picker international-hotel-passenger-picker-js">
            <ul onclick="openCountPassenger('international')">
                <li><em class="number_adult international-number-adult-js">2</em> بزرگسال ،</li>
                <li class="li_number_baby"><em class="number_baby international-number-child-js">0</em> کودک ،</li>
                <li><em class="number_room_po international-number-room-js">1</em>اتاق</li>
            </ul>
            <div class="myhotels-rooms international-my-hotels-rooms-js">
                <i class="close_room international-close-room-js"></i>
                <div class="hotel_select_room international-hotel-select-room-js">
                    <div class="myroom-hotel-item international-my-room-hotel-item-js" data-roomnumber="1" >
                        <div class="myroom-hotel-item-title international-my-room-hotel-item-title-js">
                                                <span class="close d-none" onclick="itemsRoom('international')">
                                                    <i class="fa fa-trash-alt"></i>
                                                </span>
                            اتاق اول

                        </div>
                        <div class="myroom-hotel-item-info international-my-room-hotel-item-info-js">
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

                                <h6>بزرگسال</h6>
                                (بزرگتر از ۱۲ سال)
                                <div>
                                    <i class="addParent international-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus" onclick="addNumberAdult('international',this)"></i>
                                    <input readonly="" autocomplete="off" class="countParent international-count-parent-js"
                                           min="0" value="2"
                                           max="5" type="number" name="adult1" id="adult1">
                                    <i
                                            class="minusParent international-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus" onclick="minusNumberAdult('international',this)"></i>
                                </div>
                            </div>
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                <h6>کودک</h6>
                                (کوچکتر از ۱۲ سال)

                                <div>
                                    <i class="addChild international-add-number-child-js hotelroom-minus plus-hotelroom-koodak fas fa-plus" onclick="addNumberChild('international',this)"></i>
                                    <input readonly="" class="countChild international-count-child-js" autocomplete="off"
                                           min="0" value="0" max="5"
                                           type="number" name="child1" id="child1"><i
                                            class="minusChild international-minus-number-child-js hotelroom-minus minus-hotelroom-koodak fas fa-minus" onclick="minusNumberChild('international',this)"></i>
                                </div>
                            </div>
                            <div class="tarikh-tavalods international-birth-days-js"></div>
                        </div>
                    </div>
                </div>
                <div class="btn_add_room international-btn-add-room-js" onclick="addRoom('international')">
                    <i class="fal fa-plus"></i>
                    افزودن اتاق
                </div>

            </div>


        </div>
    </div>

</div>