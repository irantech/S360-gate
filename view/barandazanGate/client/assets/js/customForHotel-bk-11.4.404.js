/*
 * Custom functions added By Qorbani
 */

function internalHotelSearchDetails() {
  $.ajax({
    type: 'post',
    url: amadeusPath + 'ajax',
    data: JSON.stringify({
      className: 'searchHotel',
      method: 'getCityBYId',
      city_id: document.getElementById("cityId").value,
    }),
    success: function(response){

      if(lang === "fa"){
        $("#autoComplateSearchIN").val(response.name);
      } else {
        $("#autoComplateSearchIN").val(response.name_en);
      }
      response_valueInternal = response;
    },
    error: function(error){
    }
  })
  $("body , html").click(function(e) {
    var target = $(e.target);
    if(!target.is('#autoComplateSearchIN')) {
      if ($("#autoComplateSearchIN").val() == ""&&
        $("#autoComplateSearchIN_hidden").val() == ""){
        $("#autoComplateSearchIN").val(response_valueInternal.city_name)
        $("#autoComplateSearchIN_hidden").val(response_valueInternal.id)
      }
      if (
        $("#autoComplateSearchIN").val() != ""&&
        $("#autoComplateSearchIN_hidden").val() == ""){
        $("#autoComplateSearchIN").val(response_valueInternal.city_name)
        $("#autoComplateSearchIN_hidden").val(response_valueInternal.id)
      }
    }
  })
}
(function($) {
  jQuery(document).ready(function($) {
    let response_valueInternal;
    $(document).on('change', '#countRoom', function() {
      let roomCount = $('#countRoom').val()
      createRoomHotel(roomCount)
      $('.myroom-hotel').find('.myroom-hotel-item').remove()
      let code = createRoomHotel(roomCount)
      $('.myroom-hotel').append(code)
    })
    $(document).on('show.bs.modal', 'addChildren', function(e) {
      let inputToken = $(this).find('.modal-body input.room-token')
      let btnClicked = $(e.relatedTarget)
      let RoomToken = btnClicked.data('room-code')
      inputToken.val(RoomToken)
    })
    let childModal = function(RoomToken, ChildMinAge, ChildMaxAge) {
      let modalHtml = `
            <!-- Modal -->
        <div class='modal modal_addchild fade addChildren' id='addChildren-${RoomToken}' tabindex='-1' role='dialog' aria-labelledby='addChildrenTitle' aria-hidden='true'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                        <span class='modal-title'>${useXmltag('AddNew')} ${useXmltag('Chd')}</span>
                    </div>
                    <div class='modal-body'>
                        <input type='hidden' class='room-token' value=''>
                        <div class='childAgesContainer d-flex flex-wrap'>`
      modalHtml += `</div>
                        <!--<span class="btn btn-xs btn-warning d-none addNewChild" data-min="${ChildMinAge}" data-max="${ChildMaxAge}"><i class="fa fa-plus"></i>افزودن</span>-->
                        
                    </div>
        			<div class='modal-footer'>
        				<button type='button' class='btn btn-secondary' data-dismiss='modal'>${useXmltag('Closing')}</button>
        				<button type='button' class='btn btn-primary' onclick="approveChildAges('${RoomToken}')" >${useXmltag('Approve')}</button>
        			</div>
        		</div>
        	</div>
        </div>
        `
      return modalHtml
    }
    let eachRoomHtml = function(Room, value, IsInternal) {
      if ( value.Result.SourceId == '29') {
        return eachRoomHtmlFlightio(Room, value, IsInternal)
      }else if((IsInternal == true || IsInternal != false) && value.Result.SourceId != '17' ) {
        return eachRoomHtmlInternal(Room, value, IsInternal)
      } else {
        return eachRoomHtmlExternal(Room, value, IsInternal)
      }
    }
    let eachRoomHtmlInternal = function(Room, value, IsInternal) {
      let roomHtml = ''

      $.each(Room.Rates, function(index, Rate) {
        roomHtml += `<div class='hotel-detail-room-list hotel-detail-room-list-local'>
  <div class='hotel-rooms-name-container'>
                                        <span class='hotel-rooms-name'><span class='name'> <i class="fa fa-bed-empty"></i> ${Room.RoomName} ${Rate.Board.Name}</span>`
        if (Room.Rates[0].ReservationState.Status == 'Online') {
          roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-bolt site-main-text-color'></i>  ${useXmltag('Onlinereservation')}</span></span>`
        }
        if (Room.ExtraCapacity && Room.ExtraCapacity > 0 ) {
          roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-user site-main-text-color'></i>  ${translateXmlByParams('ExtraCapacity', {'number': Room.ExtraCapacity})} </span></span>`
        }else if(Room.ExtraCapacity ==  0){
          roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-user site-main-text-color'></i>  ${useXmltag('NoExtraCapacity')} </span></span>`

        }

        if (Room.Rates[0].CalculatedDiscount.off_percent && Room.Rates[0].CalculatedDiscount.off_percent > 0) {
          roomHtml += `  <div class='ribbon-hotel site-bg-color-dock-border-top'><span><i> %${parseInt(Room.Rates[0].CalculatedDiscount.off_percent)}   </i></span></div>`;
//todo: discount should be added here
        }

        roomHtml += `</span></div><div class='hotel-rooms-item'>`
        roomHtml += `<div class='rate-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-local-content-col'>
                                <div class='hotel-rooms-content-local w-100'>
                                    <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                    <input type='hidden' value='' id='tempExtraBed${Rate.RoomToken}'>

                                    <div class='divided-list divided-list-1'>
                                        <div class='divided-list-item'>
                                            <span  class='number_person'><i class='fa fa-user'></i>${Room.MaxCapacity} ${useXmltag('People')}</span>
                                        </div>
                                        <div class='divided-list-item detail_div_local '>
                                            <div class='DetailRoom DetailRoom_local showCancelRule' id='btnCancelRule-${Rate.RoomToken}' data-RoomCode='${Rate.RoomToken}' style='opacity: 1; cursor: pointer;'>
                                                
                                                <span>${useXmltag('Detailprice')}</span>
                                                <i class='fa fa-angle-down'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='divided-list'>
                                        <div class='divided-list-item text-center'>
                                            <span class='title_price'>
                                                ${useXmltag('Priceforanynight')} 
                                            </span>`
        if(Rate.Prices[0].afterChange != Rate.Prices[0].CalculatedOnline) {
          roomHtml += `<span class='currency priceOff'>${number_format(Rate.Prices[0].afterChange)}</span>`
        }

        roomHtml += `<span class='price_number'>  <i class='site-main-text-color'>${number_format(Rate.Prices[0].CalculatedOnline)}</i>${number_format(Rate.Prices[0].currency)}</span>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class='hotel-rooms-price-col'>
                            
                                <div class='Hotel-roomsHead' data-title='${useXmltag('Countroom')}'>
                                    <div class='selsect-room-reserve selsect-room-reserve-local'>${useXmltag('Countroom')}</div>
                                </div>
                                
                             <div class='number_room'>
                                    <i class='fa-solid fa-plus plus_room' data-type_application='api' data-room_token='${Rate.RoomToken}'></i>
                                    <input  min='1' max='9' type='text' class='val_number_room' value='0' 
                                    name='RoomCount-${Rate.RoomToken}' 
                                    data-room-code='${Rate.RoomToken}' 
                                    data-total-price='${Rate.TotalPrices.CalculatedOnline}' id='RoomCount${Rate.RoomToken}'
                                    onchange="CalculateNewRoomPrice('${Rate.RoomToken}',true,true)"/>
                                    <i class='fa-solid fa-minus minus_room' data-type_application='api' data-room_token='${Rate.RoomToken}'></i>
                                </div>
                                <div class='nuumbrtRoom d-none'>
                                    <input type='hidden' value='' id='FinalRoomCount${Rate.RoomToken}'>
                                    <input type='hidden' value='' id='FinalPriceRoom${Rate.RoomToken}'>
                                    <input id='remainingCapacity${Rate.RoomToken}' name='remainingCapacity${Rate.RoomToken}' type='hidden' value='1'>
                                   
                                    </div>`

        let Rules = value.Result.Rules
        let minChildAge = 0
        let maxChildAge = 0
        $.each(Rules, function(i, Rule) {
          if (Rule.Category == 'children' && Rule.Conditions !== null && typeof Rule.Conditions.max_infant_age !== 'undefined') {
            minChildAge = Rule.Conditions.max_infant_age
            maxChildAge = Rule.Conditions.max_child_age
          }
        })

        let availabilityBeds
        availabilityBeds = parseInt(Room.MaxCapacity) - parseInt(Room.ExtraCapacity)
        // console.log(availabilityBeds);
        if (Room.ExtraCapacity > 0 && availabilityBeds > 0 && typeof Rate.Prices[0].ExtraBed !== 'undefined' && Rate.Prices[0].ExtraBed > 0) {
          roomHtml += `<div class='nuumbrtRoom extraBed'>
            <select name='ExtraBed-${Rate.RoomToken}' disabled data-room-code='${Rate.RoomToken}' id='ExtraBed${Rate.RoomToken}' data-price='${Rate.TotalPrices.ExtraBed}' class='ExtraBed select2-num' onchange="CalculateNewRoomPrice('${Rate.RoomToken}',true)">
               <optgroup style='font-family:iransans'>
               <option>${useXmltag('Extrabed')}</option></optgroup>`
          for (c = 1; c <= availabilityBeds; c++) {
            roomHtml += `<option value='${c}'>${c} ${useXmltag('Extrabed')}</option>`
          }

          roomHtml += `
        </select>
        </div>
            `
        }
        if (Room.ExtraChild > 0 && Rate.TotalPrices.Child > 0) {
          roomHtml += `<button type='button' disabled='disabled' role='button' class='btn addChildren btnAddChildren-${Rate.RoomToken}' data-min-age='${minChildAge}' data-max-age='${maxChildAge}' data-room-code='${Rate.RoomToken}' data-toggle='modal' data-target='#addChildren-${Rate.RoomToken}' data-child-price='${Rate.TotalPrices.Child}'><span>${useXmltag('AddNew')} ${useXmltag('Chd')}</span><i class='fa fa-plus-square pr-1'></i></button>`
          roomHtml += childModal(Rate.RoomToken, minChildAge, maxChildAge)
          roomHtml += `<input type='hidden' data-room-code='${Rate.RoomToken}' name='roomChildArr[${Rate.RoomToken}]' id='roomChildArr-${Rate.RoomToken}' value=''>`
          roomHtml += `<input type='hidden' data-room-code='${Rate.RoomToken}' name='roomChildCount[${Rate.RoomToken}]' id='roomChildCount-${Rate.RoomToken}' value=''>`
          roomHtml += `<input type='hidden' id='roomChildPrice-${Rate.RoomToken}' value='${Rate.TotalPrices.Child}'>`

        }
        roomHtml += `</div>
                        </div>
                        <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel-${Rate.RoomToken}'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule-${Rate.RoomToken}'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>
                        `
        roomHtml += `<input type='hidden' value='${Rate.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${Rate.TotalPrices.CalculatedOnline}' data-amount='${Rate.TotalPrices.CalculatedOnline}' data-unit='${useXmltag(Rate.TotalPrices.currency)}' id='priceRoom${Rate.RoomToken}' class='priceRoom${Rate.RoomToken}'>
<input type='hidden' value='${value.NightsCount}' id='stayingTime${Rate.RoomToken}' class='stayingTime'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                       
                        <div class='detail_room_hotel'>
`

        if (Rate.Prices.length > 0) {
          $.each((Rate.Prices), function(index, Price) {
            roomHtml += `
                        <div class='details'>
                            <div class='AvailableSeprate site-bg-main-color site-bg-color-border-right-b '>
                            <span class="title-mobile--new">قیمت در تاریخ</span>
                                 ${Price.Date}
                            </div>
                            <div class='seprate'>
                                <span><b>${number_format(Price.CalculatedOnline)}</b>${Price.currency}<i class='fa fa-male checkIcon'></i><span class='tooltip-price'>${useXmltag('Adult')}</span></span>`
            if (Price.ExtraBed > 0 && Room.ExtraCapacity > 0 && availabilityBeds > 0) {
              roomHtml += `<span><b>${number_format(Price.ExtraBed)}</b>${Price.currency}<i data-availabilityBeds='${availabilityBeds}' class='fa fa-bed checkIcon'></i><span class='tooltip-price'>${useXmltag('Extrabed')}</span></span>`
            }
            if (Price.Child) {
              roomHtml += `<span><b>${number_format(Price.Child)}</b>${Price.currency} <i class='fas fa-baby-carriage'></i><span class='tooltip-price'>${useXmltag('Child')}</span></span>`
            }
            roomHtml += `</div>   
                    </div>`
          })
        }
        roomHtml += `
                    </div></div>`
        roomHtml += `</div></div>`
      })
      return roomHtml
    }
    let eachRoomHtmlExternal = function(Room, value, IsInternal) {
      let roomHtml = `<div class='hotel-detail-room-list'>
                        <div class='hotel-rooms-name-container'>
                            <span class='hotel-rooms-name'>${Room.RoomName}</span>
                        </div><!--.hotel-rooms-name-container-->
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-external-content-col'>
                                <div class='hotel-rooms-content'>
                                    <div class='roomRatesContainer'>
`
      $.each(Room.Rates, function(RateIndex, Rate) {

        roomHtml += `
                                <div class='roomRateItem'>
                                    <div class='divided-list divided-list-external'>
                                        <div class='divided-list-item'>
                                            <span><i class='fa fa-bed'></i>${Rate.Board.Name}</span>
                                        </div><!--.divided-list-item-->
                                        
                                        <div class='divided-list-item'>`
        if (Rate.ReservationState.Status == 'NonRefundable' || Rate.ReservationState.Status == 'IncludesFines') {
          roomHtml += `<span class='extradition online-badge'>
                                                <span class='online-txt' style='white-space: nowrap;'>
                                                ${useXmltag(Rate.ReservationState.Status)}</span>
                                            </span>`
        }

        roomHtml += `<div data-token='${Rate.RoomToken}' data-request_number='${value.RequestNumber}' class='DetailRoom DetailRoom_external showCancelRule isHide' id='btnCancelRule-${Rate.RoomToken}' data-RoomCode='${Rate.RoomToken}' style='opacity: 1; cursor: pointer;'>
                                                <span>${useXmltag('detailAndCacellation')}</span>
                                                <i class='fa fa-angle-down'></i>
                                            </div><!--DetailRoom-->
                                        </div><!--divided-list-item-->
                                     
                                    </div><!--divided-list-->
                                    <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                        <div class="divided-list">
                                        <div class="divided-list-item text-center">
                                            <span class="title_price">
                                                 ${translateXmlByParams('PriceTotalHotel', {'TotalNights': value.Result.NightsCount})}
                                            </span> `
        if(Rate.CalculatedDiscount.off_percent > 0 ){
          roomHtml += ` <span class='currency priceOff'>  <i class="price_number"> ${number_format(Rate.TotalPrices.afterChange)}</i>${useXmltag('Rial')} </span>`
        }

        roomHtml += `  <span class='price_number site-main-text-color'>
                                                <i> ${number_format(Rate.TotalPrices.CalculatedOnline)}</i>${useXmltag('Rial')}
                                           </span>
                                        </div><!--divided-list-->
                                    </div><!--divided-list divided-list-external-->
                                    <div class='divided-list divided-list-reserve border-0'>
                                        <input type='hidden' value='' id='FinalRoomCount${Rate.RoomToken}'>
                                        <input type='hidden' value='' id='FinalPriceRoom${Rate.RoomToken}'>
                                        <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                        <input type='hidden' value='1' name='RoomCount-${Rate.RoomToken}' id='RoomCount${Rate.RoomToken}'>
                                        <span class='label_reserve_input site-bg-main-color' id='reserve_input${Rate.RoomToken}' onClick="ReserveExternalApiHotel('${Rate.RoomToken}')">
                                            <span>${useXmltag('Reserve')}</span>
                                        </span>
                                    </div><!--divided-list-->
                                    <div class='detail_room_hotel'>
                                        <h4 class='reservation-state-title'>${useXmltag(Rate.ReservationState.Status)}</h4>
                                        <div class='refund-fees'></div>`

        roomHtml += `</div><!--detail_room_hotel-->
                        </div><!--roomRateItem-->
                        <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>`
        if (Rate.Prices.length > 0) {
          $.each((Rate.Prices), function(index, Price) {
            roomHtml += `<div class='details'>
                                        <div class='AvailableSeprate'>${Price.Date}</div>
                                            <div class='seprate'>
                                                <b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')}<i class='fa fa-check checkIcon'></i>
                                            </div>
                                        </div>`
          })
        }
        roomHtml += `<input type='hidden' value='${Rate.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${Rate.TotalPrices.CalculatedOnline}' data-amount='${Rate.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${Rate.RoomToken}' class='priceRoom${Rate.RoomToken}'>
<input type='hidden' value='${value.Result.NightsCount}' id='stayingTime${Rate.RoomToken}' class='stayingTime'>
                                                </div><!--DetailPriceView-->
                                            </div><!--RoomDescription-->
                                        </div><!--filter-content-->
                                    </div><!--filtertip-searchbox-->
                                </div><!--#boxCancelRule-->
                            </div><!--box-cancel-rule-->
                        </div><!--hotel-rooms-rule-row-->
                        `
      })

      roomHtml += `</div><!--roomRatesContainer-->
                        </div><!--hotel-rooms-content-->
                    </div><!--hotel-rooms-external-content-col-->
                </div><!--hotel-rooms-row-->
            </div><!--hotel-rooms-item-->
        </div><!--hotel-detail-room-list-->`
      return roomHtml

    }
    let eachRoomHtmlFlightio = function(Room, value, IsInternal) {

      let each_room_name = Room.RoomName.split('|')
      let total_room_info = Room.Rates[0]


      let roomHtml = `<div class='hotel-detail-room-list'>
                   
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-external-content-col'>
                                <div class='hotel-rooms-content'>
                                    <div class='roomRatesContainer'>
`

      $.each(Room.Rates, function(RateIndex, Rate) {

        roomHtml += `
                    
                                <div class='roomRateItem_second'>
                                
                                    <span class='hotel-rooms-name font-bold d-flex px-2'> <i class="fa fa-bed-empty"></i> ${each_room_name[RateIndex]}</span>
                                 
                                    <div class='d-flex justify-between px-2'><div class="d-flex">`

        if (Rate.Board && Rate.Board.Name) {
          roomHtml += `<div class='room_second_detail'>
                                            <span>${Rate.Board.Name}</span>
                                       </div>`
        }
        if (Rate.ReservationState.Status == 'NonRefundable' || Rate.ReservationState.Status == 'IncludesFines') {
          roomHtml += `<div class='room_second_detail mx-2'>
                            <span>${useXmltag(Rate.ReservationState.Status)}</span>
                        </div>`
        }

        roomHtml += `</div><div>`


        roomHtml += `

                                        </div><!--divided-list-item-->
                                     
                                    </div><!--divided-list-->
                                    
                                    
                                   `

        roomHtml += `
                        </div><!--roomRateItem-->
                       
                        `
      })
      roomHtml += `<input type='hidden' value='' id='tempInput${total_room_info.RoomToken}'>
                      <div class='d-flex justify-content-between p-2'>
                                        <div class="divided-list">
                                        <div class="divided-list-item text-center">
                                            <span class="title_price">
                                                 ${translateXmlByParams('PriceTotalHotel', {'TotalNights': value.Result.NightsCount})}
                                            </span>`
        if(total_room_info.CalculatedDiscount &&  total_room_info.CalculatedDiscount.off_percent > 0 ){
          roomHtml += ` <span class='currency priceOff'>  <i class="price_number"> ${number_format(total_room_info.TotalPrices.afterChange)}</i>${useXmltag('Rial')} </span>`
        }

        roomHtml += `  <span class='price_number'>
                                                <i class='site-main-text-color'> ${number_format(total_room_info.TotalPrices.CalculatedOnline)}</i>${useXmltag('Rial')}
                                           </span>
                                        </div><!--divided-list-->
                                    </div><!--divided-list divided-list-external-->`

      roomHtml +=`<div class='divided-list divided-list-reserve border-0'>
                                        <input type='hidden' value='' id='FinalRoomCount${total_room_info.RoomToken}'>
                                        <input type='hidden' value='' id='FinalPriceRoom${total_room_info.RoomToken}'>
                                        <input type='hidden' value='' id='tempInput${total_room_info.RoomToken}'>
                                        <input type='hidden' value='1' name='RoomCount-${total_room_info.RoomToken}' id='RoomCount${total_room_info.RoomToken}'>
                                        <span class='label_reserve_input site-bg-main-color' id='reserve_input${total_room_info.RoomToken}' onClick="ReserveExternalApiHotel('${total_room_info.RoomToken}')">
                                            <span>${useXmltag('Reserve')}</span>
                                        </span>
                                    </div><!--divided-list--> 
                                    </div>
                  <div class='detail_room_hotel'>
                                      <h4 class='reservation-state-title'>${useXmltag(total_room_info.ReservationState.Status)}</h4>
                  <div class='refund-fees'></div></div>`
      roomHtml +=` <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>`
        if (total_room_info.Prices.length > 0) {
          $.each((total_room_info.Prices), function(index, Price) {
            roomHtml += `<div class='details'>
                                        <div class='AvailableSeprate'>${Price.Date}</div>
                                            <div class='seprate'>
                                                <b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')}<i class='fa fa-check checkIcon'></i>
                                            </div>
                                        </div>`
          })
        }
        roomHtml += `<input type='hidden' value='${total_room_info.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${total_room_info.TotalPrices.CalculatedOnline}' data-amount='${total_room_info.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${total_room_info.RoomToken}' class='priceRoom${total_room_info.RoomToken}'>
<input type='hidden' value='${value.Result.NightsCount}' id='stayingTime${total_room_info.RoomToken}' class='stayingTime'>
                                                </div><!--DetailPriceView-->
                                            </div><!--RoomDescription-->
                                        </div><!--filter-content-->
                                    </div><!--filtertip-searchbox-->
                                </div><!--#boxCancelRule-->
                            </div><!--box-cancel-rule-->
                        </div><!--hotel-rooms-rule-row-->`
      roomHtml += `</div><!--roomRatesContainer-->
                        </div><!--hotel-rooms-content-->
                    </div><!--hotel-rooms-external-content-col-->
                </div><!--hotel-rooms-row-->
            </div><!--hotel-rooms-item-->
        </div><!--hotel-detail-room-list-->`
      return roomHtml

    }
    let generateRoomSelectForm = function(result, hotelValue, RequestNumber) {
      let modal = ''
      let eachRoom = ''
      let RoomIds = []
      $.each(result, function(roomIndex, Room) {
        $.each(Room.Rates, function(rateIndex, Rate) {
          RoomIds.push(Rate.RoomToken)
        })
        eachRoom += eachRoomHtml(Room, hotelValue, hotelValue.Result.IsInternal)
      })
      allRoomIds = RoomIds.join('/')

      let firstRoom = result[0]

      let html = `<form target='_self' action='' method='post' id='formHotelReserve' style='width: 100%;'>
        <input id='idHotel_reserve' name='idHotel_reserve' type='hidden' value='${hotelValue.Result.HotelIndex}'>
        <input id='nights_reserve' name='nights_reserve' type='hidden' value='${firstRoom.Rates[0].Prices.length}'>
        <input id='startDate_reserve' name='startDate_reserve' type='hidden' value='${hotelValue.History.StartDate}'>
        <input id='endDate_reserve' name='endDate_reserve' type='hidden' value='${hotelValue.History.EndDate}'>
        <input id='IdCity_Reserve' name='IdCity_Reserve' type='hidden' value='${hotelValue.Result.CityId}'>
        <input id='factorNumber' name='factorNumber' type='hidden' value=''>
        <input id='CurrencyCode' name='CurrencyCode' type='hidden' value=''>
        <input id='IsInternal' name='IsInternal' type='hidden' value='${hotelValue.Result.IsInternal}'>
        <input id='source_id' name='source_id' type='hidden' value='${hotelValue.Result.SourceId}'>
        <input type='hidden' value='${JSON.stringify(hotelValue.History.Rooms)}' name='searchRooms' id='searchRooms'>
        <input id='requestNumber' name='requestNumber' type='hidden' value='${RequestNumber}'>
        <input id='href' name='href' type='hidden' value='newPassengersDetail'>
`

      html += eachRoom

      let Rules = hotelValue.Result.Rules
      let minChildAge = maxChildAge = 0
      $.each(Rules, function(i, Rule) {
        if (Rule.Category == 'children' && Rule.Conditions !== null && typeof Rule.Conditions.max_infant_age !== 'undefined') {
          minChildAge = Rule.Conditions.max_infant_age
          maxChildAge = Rule.Conditions.max_child_age
        }
      })
      html += `<input type='hidden' name='CountRoom' id='CountRoom' value=''>
        <input type='hidden' name='TypeRoomHotel' id='TypeRoomHotel' value='${allRoomIds}'>
        <input type='hidden' name='allRoomIds' id='allRoomIds' value='${allRoomIds}'>
        <input type='hidden' name='TotalNumberRoom' id='TotalNumberRoom' value=''>
        <input type='hidden' id='TotalNumberRoom_Reserve' name='TotalNumberRoom_Reserve' value=''>
        <input type='hidden' id='TotalNumberExtraBed_Reserve' name='TotalNumberExtraBed_Reserve' value=''>
       `

      html += `
</form>`
      $('.RoomsContainer').append(html)
    }
    let ajaxGetPrices = function(RequestNumber, value) {
      return $.ajax({
        type: 'POST',
        url: amadeusPath + 'hotel_ajax.php',
        dataType: 'JSON',
        data: {
          requestNumber: RequestNumber,
          stars: value.Result.Stars,
          hotelIndex: value.Result.HotelIndex,
          sourceId: value.Result.SourceId,
          startDate: value.History.StartDate,
          cityName: value.History.City,
          countryName: value.History.Country,
          typeApplication: (value.History.IsInternal == '0' || (value.History.IsInternal == '1' && (value.Result.SourceId == '17'))) ? 'externalApi' : 'api',
          check_type_for_price_changes :  (value.History.IsInternal == '1') ? true : false ,
          flag: 'getPrices',
        },
        beforeSend: function() {

        },
        success: function(response) {
          $('#ThisPricesResult').val(JSON.stringify(response))

          if (response.Result.length > 0) {

            generateRoomSelectForm(response.Result, value, RequestNumber)
          } else {
            let msg = useXmltag('NoRoomsAvailable')
            $.alert({
              title: useXmltag('NoAvailableReserve'),
              content: msg,
              rtl: true,
              type: 'red',
            })
          }
        },
        error: function(error) {
          let msg = useXmltag('NoAvailableReserve')
          $.alert({
            title: useXmltag('Error'),
            content: msg,
            rtl: true,
            type: 'red',
          })
          $('.RoomsContainer').append(`<div class='hotel-detail-room-list'>
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row justify-content-center'><p class='mt-3 alert alert-danger'>${msg}</p></div></div></div>`)
        },
        complete: function() {
          $('#resultRoomHotel').hide()
        },
      })
    }
    let ajaxGetCancellationPolicy = function(cancelRoleBtn) {
      let RequestNumber = cancelRoleBtn.data('request_number')
      let RoomToken = cancelRoleBtn.data('token')
      let thisdetailBox = cancelRoleBtn.parents('.roomRateItem').find('.detail_room_hotel')
      thisdetailBox.addClass('active_detail')
      return $.ajax({
        type: 'POST',
        url: amadeusPath + 'hotel_ajax.php',
        dataType: 'JSON',
        data: {
          flag: 'getCancellationPolicy',
          RequestNumber: RequestNumber,
          RoomToken: RoomToken,
        },
        beforeSend: function() {

        },
        success: function(response) {
          result = response.Result

          if (result.Fees.length > 0) {
            boxHtml = `<ul>`
            $.each(result.Fees, function(index, Fee) {
              boxHtml += `<li>${useXmltag('From')}<span style='direction: ltr; display:inline-block'>${Fee.FromDate}</span> ${useXmltag('To')} <span style='direction: ltr; display:inline-block'>${Fee.ToDate}</span> ${useXmltag('CancelationAmount')} <span style='direction: ltr; display:inline-black'>${Fee.Amount}</span></li>`
            })
            boxHtml += `<ul>`

            thisdetailBox.find('.refund-fees').html(boxHtml)
          }

          if (result.Status.length > 0 && result.Status.Refundable) {
            thisdetailBox.find('h4.reservation-state-title').text(useXmltag('Refundable'))
          } else {
            thisdetailBox.find('h4.reservation-state-title').text(useXmltag('NonRefundable'))
          }
        },
        error: function(error) {
        },
      })
    }
    let generateMap = function(latitude, longitude, mapDiv = 'mapDiv') {
      if (typeof L === 'undefined') {
        console.error('Leaflet library (L) is not loaded.');
        return;
      }
      map = L.map(mapDiv).setView([latitude, longitude], 16)
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.iran-tech.com/">Iran Technology</a> contributors',
        // maxZoom: 18,
        // minZoom: 11,
      }).addTo(map)
      marker = L.marker([latitude, longitude]).addTo(map)

    }
    let generateHtmlForSearchHotel = function(data, parseJson) {

      let value = data.Result,
        searched_details = data.History,
        IsInternal = data.Result.IsInternal
      let addressTxt = value.ContactInformation.Address
      let hotelName = value.Name
      let currency = value.CurrencyTitle
      let Latitude = value.ContactInformation.Location.Latitude
      let Longitude = value.ContactInformation.Location.longitude
      let stars = value.Stars
      let description = value.ExtraData ? value.ExtraData.Description : ''


      if (parseJson.lang != 'fa') {
        hotelName = value.Name
        if (typeof value.NameEn !== 'undefined' && value.NameEn != '') {
          hotelName = value.NameEn
        }

        if (typeof value.ContactInformation.AddressEn !== 'undefined' && value.ContactInformation.AddressEn !== '') {
          addressTxt = value.ContactInformation.AddressEn
        }
      }
      let starsHtml = ''
      for (let star = 0; star < 5; star++) {
        let starOn = `<i class='fa fa-star' aria-hidden='true'></i>`
        let starOff = ``
        if (star < value.Stars) {
          starsHtml += starOn
        } else if (star >= value.Stars) {
          starsHtml += starOff
        }
      }

      let starText = ''
      if(value.Stars > 0 ) {
        starText = translateXmlByParams('starText', {'count': value.Stars})
      }



      let galleryHtml = ''

      // $.each(value.Pictures, function(index, picture) {
      //   galleryHtml += `<div class='hotel-thumb-item'><a data-fancybox='gallery' href='${picture.full}'><img src='${picture.medium}' alt='${hotelName}'></a></div>`
      // })

      $.each(value.Pictures, function(index, picture) {
        galleryHtml += `<img src='${picture.medium}' alt='${hotelName}'>`
      })

      $('.roomFinalPrice i').text(currency)
      // $('#CurrencyCode').val(value.CurrencyCode)
      if (value.IsInternal == true || value.IsInternal == 1 ) {
        $('.hotelDetailHotelName').text(hotelName)
      } else {
        $('.hotelDetailCityName').text(value.City)
        $('#destination_country').val(searched_details.Country)
        $('#destination_city').val(searched_details.City)
        $('#autoComplateSearchIN').val(searched_details.Country + ' - ' + searched_details.City)
      }


      $('#idCity').val(value.CityId)
      $('#nights').val(value.NightsCount)
      $('#startDate,#startDateForeign').val(searched_details.StartDate)
      $('#endDate,#endDateForeign').val(searched_details.EndDate)
      $('#stayingTime').val(value.NightsCount)
      // $('#countRoom').attr('data-rooms',JSON.stringify(searched_details.Rooms)).val(searched_details.Rooms.length).select2().trigger('change');

      $('span.stayingTime').text(`${value.NightsCount} ${useXmltag('Night')}`)
      let class_hotel_name = (IsInternal == '1')?'internal-hotel-name': 'external-hotel-name';
      let class_detail_hotel = (IsInternal == '1') ? 'internal-hotel-detail' : 'external-hotel-detail';
      let hotel_transfer = ''
      if(value.ExtraData && value.ExtraData.transfer != undefined) {
        hotel_transfer = ` <div class='hotel-rate-outer'>
                   <a href="javascript:" class="box-share-hotel">
                        <span>اشتراک گذاری</span>
                        <i class="fa-light fa-share-nodes"></i>
                    </a>`
        if(value.ExtraData.transfer.price == 0 ) {
          hotel_transfer +=`<span>(${useXmltag('Free')})</span>`
        }
        hotel_transfer +=` </div>
                    </div>
                </div>`
      }

      let rules = ''
      if(value.Rules.length> 0 ) {
        for (let i = 0; i < value.Rules.length; i++) {
          rules += `<div>
                    <h6 class='rulesHotel__title text-right'>${value.Rules[i]['Name']}</h6>
                    <div class='rulesHotel__answer'>${value.Rules[i]['Description']}</div>
                  </div>`
        }
      }

      if (galleryHtml != '') {
        hotelDetailContainer += `<div class='mBox parent-tour-image'>
    ${galleryHtml}
  `;

        if (value.Pictures.length > 5) {
          hotelDetailContainer += `
      <div class="more-image"> 
                <svg viewBox="0 0 24 24" width="1.5em" fill="currentColor" data-v-2c57d7f8="">
                    <path d="M20.251 4.5c1.24 0 2.25 1.01 2.25 2.249v10.5c0 .276-.058.536-.149.78l.004.005-.007.006a2.246 2.246 0 0 1-2.098 1.46H3.749A2.253 2.253 0 0 1 1.5 17.25V6.749c0-1.24 1.009-2.25 2.25-2.25h16.5Zm0 1.5H3.749A.75.75 0 0 0 3 6.749v8.096l1.987-3.12c.79-1.24 2.172-1.975 3.706-1.975h.06c1.553.02 2.938.79 3.703 2.06l.828 1.374a4.495 4.495 0 0 1 2.639-.853c1.427 0 2.76.66 3.566 1.766L21 16.172V6.749a.75.75 0 0 0-.749-.75Zm-5.197.75c1.21 0 2.196.985 2.196 2.196v.108a2.198 2.198 0 0 1-2.196 2.196h-.109a2.198 2.198 0 0 1-2.195-2.196v-.108c0-1.211.985-2.196 2.195-2.196h.11Z"></path>
                </svg>
        <span>${value.Pictures.length - 5}</span>
        ${useXmltag('otherImage')}
      </div>
    `;
        }

        hotelDetailContainer += `</div>`;
      }
      let hotelDetailContainer = `
            <div class='${class_hotel_name}'>
                <div class='hotel-name hotel-name_detail'>
                  <div class="hotel-name-rate-parent_detail">
                      <h1>${hotelName}</h1>
                  </div>
                  <div class="parent-hotel-stars-address">
                      <div class='hotel-rate'>
                          <div class='rp-cel-hotel-star hotel-stars'>  <span class="rp-cel-hotel-star_span"> ${starText} </span>  ${starsHtml}</div>
                      </div>
                      <div class='external-hotel-address text-left hotel-address hotel-result-item-content-location'>
                         <span class='address-text'>${addressTxt}</span>
                      </div>
                  </div>
                </div>
                <a href="javascript:" class="box-share-hotel">
                        <span>اشتراک گذاری</span>
                        <i class="fa-light fa-share-nodes"></i>
                </a>
               ${hotel_transfer}
            </div>
            <div class="parent-navigation-list-hotel">
                    <ul>
                        <li><a onclick="clickScroll('bed-hotel')" href="javascript:">انتخاب اتاق</a></li>
                        <li><a onclick="clickScroll('facilities-hotel')" href="javascript:">امکانات اتاق</a></li>
                        <li><a onclick="clickScroll('introducing-hotel')" href="javascript:">معرفی هتل</a></li>
                        <li><a onclick="clickScroll('rules-hotel')" href="javascript:">قوانین و مقررات</a></li>
                        <li><a onclick="clickScroll('map-hotel')" href="javascript:">مشاهده نقشه</a></li>
                    </ul>
                </div>

`
      // if(galleryHtml != '') {
      //   hotelDetailContainer += `<div class='hotel-khareji-thumb'>
      //               <div class='hotel-thumb-carousel owl-carousel'>${galleryHtml}</div>
      //           </div>`
      // }




      hotelDetailContainer +=`<div class=' RoomsContainer'>


            <div class='row'>
            
            </div>
            </div>
            
            <div class='hotel-panel ${parseJson.lang == 'fa' ? 'txtRight' : 'txtLeft'}'>
                <div class='hotel-desc'>`
      if(description){
        hotelDetailContainer += `
                  <div class="tabHotel">
                    <div class="tabHotel__buttons">
                      <button onclick="tabHotel('tabHotel__box1',event.target)" class="tabHotel__btns tabHotel__btns--active">${useXmltag('Descriptionhotel')}</button>
                      <button onclick="tabHotel('tabHotel__box2',event.target)" class="tabHotel__btns">${useXmltag('OsafarTermsandConditions')}</button>
                    </div>
                    <div>
                      <div id="tabHotel__box1" class="tabHotel__box"><p>${description}</p></div>
                      
                      <div id="tabHotel__box2" class="tabHotel__box" style="display:none">
                        <div class="rulesHotel">
                          ${rules}
                        </div>  
                      </div>
                    </div>
                  </div>
                  `
      }
      hotelDetailContainer += `<div class='hotel-fea'>
                        <div class='hotel-fea-title'>${useXmltag('PossibilitiesHotel')}
                        </div>
                        <div class='hotel-fea-inner'>

`

      let roomIcons = hotelIcons = ''
      if (typeof value.Facilities.HotelWithIcons != 'undefined') {
        if (value.Facilities.HotelWithIcons.length > 0) {
          $.each(value.Facilities.HotelWithIcons, function(index, value) {
            hotelIcons += `<div title='${value[0]}' class='hotel-fea-item-2'><i class='site-bg-main-color ${value[1]}'></i>${value[0]}</div>`
          })
          hotelDetailContainer += hotelIcons
        }
      } else if (typeof value.Facilities.Hotel.En.Base != 'undefined') {
        if (lang == 'fa') {
          if (value.Facilities.Hotel.Fa.Base.length > 0) {
            $.each(value.Facilities.Hotel.Fa.Base, function(index, value) {
              hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
            })
            hotelDetailContainer += hotelIcons
          }
        } else if (value.Facilities.Hotel.En.Base.length > 0) {
          $.each(value.Facilities.Hotel.En.Base, function(index, value) {
            hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
          })
          hotelDetailContainer += hotelIcons
        }
      } else {
        hotelDetailContainer += ``
      }
      hotelDetailContainer += `
  
        </div>
        <div class='hotel-fea-inner'>`
      if (lang == 'fa') {
        if (value.Facilities.Room.Fa.Base.length > 0) {
          roomIcons += `<div class='hotel-fea-title'>${useXmltag('PossibilitiesRoom')}</div>`
        }
      }else {
        if (value.Facilities.Room.En.Base.length > 0) {
          roomIcons += `<div class='hotel-fea-title'>${useXmltag('PossibilitiesRoom')}</div>`
        }
      }
      roomIcons += `<div class='hotel-fea-inner'>`
      if (typeof value.Facilities.RoomWithIcons != 'undefined') {
        if (value.Facilities.RoomWithIcons.length > 0) {
          $.each(value.Facilities.RoomWithIcons, function(index, value) {
            roomIcons += `<div title='${value[0]}' class='hotel-fea-item-2'><i class='site-bg-main-color ${value[1]}'></i>${value[0]}</div>`
          })


          hotelDetailContainer += roomIcons
        }
      } else if (typeof value.Facilities.Room.En.Base != 'undefined') {
        if (value.Facilities.Room.En.Base.length > 0) {
          $.each(value.Facilities.Room.En.Base, function(index, value) {
            hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
          })
          hotelDetailContainer += hotelIcons
        }
      }
      hotelDetailContainer += `</div>
                    </div>
                    <div class='hotel-fea-inner'>
                        <div class='rp-hotel-box'>
                            <div id='mapDiv' class='gmap3'></div>
                        </div>
                    </div><!-- End Map Section   -->
                </div>
            </div>
</div>`
      $('#hotelDetailContainer .content-detailHotel').addClass(class_detail_hotel).html('').append(hotelDetailContainer)

      loadArticles('Hotel')
    }
    let generateCarousel = function(selector) {
      $(selector).owlCarousel({
        items: 2,
        rtl: true,
        loop: true,
        center: true,
        margin: 5,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplaySpeed: 1000,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 1,
          },
          575: {
            items: 2,

          },
        },
      })
    }
    let priceRangeSlider = function(minPrice, maxPrice) {
      $('#slider-range').slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        step: 500000,
        animate: false,
        values: [minPrice, maxPrice],
        slide: function(event, ui) {
          let minRange = ui.values[0]
          let maxRange = ui.values[1]
          $('.filter-price-text span:nth-child(2) i').html(number_format(minRange))
          $('.filter-price-text span:nth-child(1) i').html(number_format(maxRange))
          let hotels = $('.hotel-result-item')
          hotels.hide().filter(function() {
            let price = parseInt($(this).data('price'), 10)
            return price >= minRange && price <= maxRange
          }).show()

        },
      })

      $('.filter-price-text span:nth-child(2) i').html(number_format(minPrice))
      $('.filter-price-text span:nth-child(1) i').html(number_format(maxPrice))
    }

    let hotelTypeMange = function(hotelTypeList) {
      let allHotelTypes = [];
      $("#filterHotelType :input.ShowByHotelFilters").each(function(index, item) {
        if(!hotelTypeList.includes(parseInt(item.value))){
             $(`.raste-item${item.value}`).remove()
        }
        allHotelTypes.push(item.value);
      });

    }
    $('body').delegate('#searchDate', 'click', function() {
      let page = $('#page').val()
      let href = amadeusPathByLang + page
      $('#formHotel').attr('action', href).submit()
    })
    $(document).on('click', '.reserve-hotel', function(e) {
      // $('#formHotel').attr('action',`${amadeusPathByLang}newPassengersDetail`);
      ReserveHotel()
    })
    $(document).on('click', '.DetailRoom_external.showCancelRule', function(e) {
      e.preventDefault()
      let _this = $(this)
      _this.find('i').toggleClass('rotate')
      if (_this.hasClass('isHide')) {
        _this.parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail')
        _this.toggleClass('isHide isShow')
        ajaxGetCancellationPolicy(_this)
      } else {
        _this.parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail')
        _this.toggleClass('isHide isShow')

      }
    })
    $('.datePersian').datepicker({
      numberOfMonths: 1,
      minDate: new Date(),
      dateFormat: 'yy-mm-dd',
      gotoCurrent: true,
      showButtonPanel: true,
    })
    if (gdsSwitch == 'searchHotel') {

      let data = $('#dataSearchHotel').val()


      let parsJson = JSON.parse(data)
      // let parsJson = data;
      // let value = [];
      parsJson.className = 'searchHotel'
      parsJson.method = 'searchHotel'

      let parsJsonCapacity = {}
      parsJsonCapacity.className = 'fullCapacity'
      parsJsonCapacity.method = 'getFullCapacitySite'
      parsJsonCapacity.id = 1
      parsJsonCapacity.is_json = 1

      let full_capacity_image = '';

      $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        data: JSON.stringify(parsJsonCapacity),
        success: function(data) {
          if(data.pic_url != '') {
            full_capacity_image = data.pic_url
          }else {
            full_capacity_image = amadeusPath + 'view/client/assets/images/fullCapacity.png'
          }
        }
      })





      $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        // url: amadeusPath + 'hotel_ajax.php',
        dataType: 'JSON',
        data: JSON.stringify(parsJson),
        beforeSend: function() {
          $('.loaderPublicForHotel').show()
          $('.silence_span').html(useXmltag('Loading'));
        },
        success: function(data) {

          let value = data.Hotels

          let advertises = data.Advertises
          let hotelType  = [];
          $('#webServiceType').val(data.WebServiceType)
          $('.silence_span').html(`<b id='countHotelHtml'>${data.Count}</b> ${useXmltag('silenceSpanHotel')}`)
          $('#hotelResultItem').remove()
          if (data.Count > 0) {
            $.each(value, function(index, item) {
              if(!hotelType.includes(item.type_code)) {
                hotelType.push(item.type_code)
              }


              let hotelIndex = null
              if (item.type_application == 'reservation') {
                hotelIndex = item.hotel_id
              } else {
                hotelIndex = item.HotelIndex
              }
              let facilitiesContent = ''
              if (item.type_application == 'reservation') {
                let html_li = ''
                if (typeof item.facilities != 'undefined') {
                  let html_li = '<div class="internal-hotel-facilities">'
                  $.each(item.facilities, function(j, facility) {

                    if (j < 10) {
                      html_li += `<span>${facility.title}</span>`
                    }

                  })
                  html_li += `</div>`

                  facilitiesContent = html_li
                }

              } else {
                let html_li = ''
                if (typeof item.facilities != 'undefined') {
                  let html_li = '<div class="internal-hotel-facilities">'
                  if (item.facilities.length > 1) {
                    $.each(item.facilities, function(j, facility) {

                      if (j < 10) {
                        html_li += `<span>${facility.title}</span>`
                      }

                    })

                  }


                  html_li += `</div>`
                  facilitiesContent = html_li
                }
              }
              let starHtml = ''
              if(item.star_code > 0) {
                starHtml += `<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M11.892 3.005c-.429.041-.8.325-.95.735l-1.73 5.182-5.087-.001a1.122 1.122 0 0 0-.675 2.021l4.077 3.078-1.834 5.504c-.153.465.011.974.407 1.261l.093.061c.383.224.868.203 1.232-.062l4.577-3.442 4.59 3.408c.4.292.936.292 1.331.005l.087-.07a1.12 1.12 0 0 0 .32-1.189l-1.856-5.477 4.078-3.079a1.12 1.12 0 0 0 .39-1.251 1.125 1.125 0 0 0-1.067-.768h-5.087l-1.724-5.163A1.131 1.131 0 0 0 12 3l-.108.005Z"></path></svg>`;
              }
              let starText = ''
              if(item.star_code > 0 ) {
                starText = item.star_code
              }

              let hotelStricke = 0
              let hotelPrice = 0
              if (item.discount_price > 0) {
                hotelStricke = item.min_room_price_without_discount
                hotelPrice = item.min_room_price
              } else {
                if (item.min_room_price > 0) {
                  hotelPrice = item.min_room_price
                } else {
                  hotelPrice = 0
                }
              }
              var buttonName = ''
              var style = ''
              if (hotelPrice > 0) {
                buttonName = useXmltag('ShowReservation')
                style = ''
              } else {
                buttonName = useXmltag('Inquire')
                if (item.type_application == 'reservation') {
                  buttonName = useXmltag('NonBookable')
                }
                style = 'style="background-color: #7d7d7d !important"'
              }
              let onClickAttr = ''
              let single_detail_link = ''
              let searched_rooms = $('#searchRooms').val()
              let nights = $('#stayingTime').val()
              let rooms_query_param = null
              if (searched_rooms)
                rooms_query_param = `&searchRooms=${searched_rooms}`
              else
                rooms_query_param = ''
              if (item.type_application == 'api') {
                // if(hotelPrice > 0 || hotelPrice = 0)
                // {
                onClickAttr = `hotelDetail('api','${hotelIndex}','${item.hotel_name_en}','${item.requestNumber}','${item.SourceId}',$(this))`
                single_detail_link = `${amadeusPathByLang}detailHotel/api/${item.HotelIndex}/${item.requestNumber}${rooms_query_param}`
                // }else{
                //     onClickAttr = `return false`;
                // }

                // $(itemAppend).find('.bookbtn').attr('onclick', onClickAttr);
              }
              if (item.type_application == 'reservation') {
                if (hotelPrice > 0) {
                  single_detail_link = `${amadeusPathByLang}roomHotelLocal/reservation/${hotelIndex}/${item.hotel_name_en}${rooms_query_param}`
                  onClickAttr = `hotelDetail('reservation', '${hotelIndex}', '${item.hotel_name_en}','','',$(this))`

                } else {
                  single_detail_link = '#'
                  onClickAttr = `return false`
                }

              }
              var specialHotelRabon = ''
              if (item.is_special == 'yes') {
                specialHotelRabon = `
                    <div class='ribbon-special-hotel'>${useXmltag( 'Specialhotel' )}</div>
                    `
              }
              var specialHotelRabonDiscount = `     
                    <div class='ribbon-hotel site-bg-color-dock-border-top'><span><i> %${item.discount}   </i></span></div>
                 `
              var apiHotelDiscountRabon = `
                     <div class='ribbon-hotel site-bg-color-dock-border-top'><span>${item.discount}%</span></div>`
              var rabonfinal = ''
              if (item.type_application == 'reservation') {
                if (item.discount > 0) {
                  rabonfinal = rabonfinal + specialHotelRabonDiscount
                }
              } else {
                if (item.discount > 0) {
                  rabonfinal = apiHotelDiscountRabon
                }
              }
              let mainItem =
                `<div class='hotelResultItem count count-${index}'> <div id='api${index}' class='hotel-result-item'
                     data-typeApplication='${item.type_application}' 
                     data-discount='${item.discount}'
                     data-priority='${item.priority}' 
                     data-price='${item.min_room_price}' 
                     data-star='${item.star_code}' 
                     data-HotelType='${item.type_code}' 
                     data-HotelName='${item.hotel_name}'
                     data-special='${item.is_special}'
                     >
                        <code style='display:none'></code>
                    <div>
                        <div class='hotel-result-item-image hotelImageResult hotelImageResult-${index}'>
                            <a target='_blank' href='${single_detail_link}'>
                                <img title='${item.hotel_name}' id='imageHotel-${index}' src='${item.pic}'>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class='hotel-result-item-content'>
                            <div class='hotel-result-item-text'>
                                    ${specialHotelRabon}
                                    <div class="parent-hotel-name-result">
                                <div class='d-flex align-items-center gap-10'>
                                    <a target='_blank' href='${single_detail_link}' class='hotel-result-item-name hotelNameResult hotelNameResult-${index}'>${item.hotel_name}</a>
                                    <kbd class='kbd_style'>S${item.SourceId}</kbd>
                                </div>
                                <span class='rp-cel-hotel-star hotelShowStar-${index}'>
                                  <span class='rp-cel-hotel-star_span'> ${starText} </span> 
                                     ${starHtml}
                                </span>
                                </div>
`

              if (item.pointClub > 0) {
                mainItem += `<div class='text_div_more_hotel m-auto'>
                        <i class='flat_cup'></i>
                            ${useXmltag('Yourpurchasepoints')} : <i class='site-main-text-color mr-1'> ${item.pointClub.toLocaleString()} ${useXmltag('Point')} </i>

                            </div>`

              }

              if (item.address) {
                mainItem += `
                                <span class='hotel-result-item-content-location hotelAddress hotelAddress-${index}'>
                                                        <span> ${useXmltag('Address')} : </span>

                                <span> ${item.address} </span>
                             <!-- <span class="text-white">${item.type}</span> -->
                                </span>`
              }
              // if (item.cancel_conditions) {
              //   mainItem += `<p class='hotel-result-item-description height95 hotelRules hotelRules-${index}'>${item.cancel_conditions}</p>`
              // }

              var mainPrice = ''

              if(nights > 1 ) {
                mainPrice = ` <h2 class='CurrencyCal' data-amount='${item.price_currency_total_night}'>${number_format(parseInt(item.price_currency_total_night))}</h2>`
              }else if(nights == 1 ) {
                mainPrice =  ` <h2 class='CurrencyCal' data-amount='${item.price_currency.AmountCurrency}'>${number_format(parseInt(item.price_currency.AmountCurrency))}</h2>`
              }


              if (facilitiesContent) {
                mainItem += `<ul class='hotelpreferences facilities facilities-${index}'>${facilitiesContent}</ul>`
              }
              mainItem += `</div>
                            <div class='hotel-result-item-bottom'>
                                <input type='hidden' id='starSortDep' name='starSortDep' value='${item.star_code}' class='hotelStar hotelStar-${index}'>
                                <input id='idHotel' name='idHotel' type='hidden' value='${hotelIndex}'  class='hotelId-${index}'>`
              if (item.price_currency.AmountCurrency > 0) {
                mainItem += `<div class='price-box-hotel'>`
                mainItem += `
                                <span class='nightText'> ${useXmltag('Price')} ${nights}   ${useXmltag('Night')}    </span> 
                                ${hotelStricke > 0 ? `
                                      <div class="d-flex style_Discount">
                                      <span class="currency priceOff CurrencyCal" 
                                      data-amount="${hotelStricke}">
                                      ${number_format(parseInt(hotelStricke))}
                                      </span> ${rabonfinal}
                                      </div>` : ''}
                                <div class="price_main">
                                 <span class='CurrencyText'>${item.price_currency.TypeCurrency}</span>
                                  ${mainPrice}
                                </div>
`
              }
              var mainButton = ''
              if (item.type_application == 'reservation') {
                mainButton = `<a class='bookbtn mt1 site-bg-main-color' ${style} onclick="${onClickAttr}"> ${buttonName} <svg data-v-2824aec9="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path data-v-2824aec9="" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg></a>`
              } else {
                mainButton = `<a target='_blank' href='${single_detail_link}' class='bookbtn mt1 site-bg-main-color' ${style}> ${buttonName} <svg data-v-2824aec9="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path data-v-2824aec9="" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg></a>`
              }
              var pricePerNight = ''
              if(nights > 1 ) {
                pricePerNight = ` <div class='d-flex align-items-center pricePerNight'>
                                      <h2 class='CurrencyCal' data-amount='${item.price_currency.AmountCurrency}'>${number_format(parseInt(item.price_currency.AmountCurrency))}</h2>
                                      <span>${translateXmlByParams('PriceForEachNight', {'Price': ''})}</span>
                                   </div>`
              }
              mainItem += ` ${mainButton}
                            ${pricePerNight}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
              $('#hotelResult').append(mainItem)
            })
          }
          else {

            $('.loaderPublicForHotel').hide()
            $('.loader-for-local-hotel-end').hide()
            $('.container_loading').hide()
            $('.loader-for-external-hotel-end').hide()
            // let htmlError = `<div class='userProfileInfo-messge'><div class='messge-login BoxErrorSearch'><div style='float: right;'>  <i class='fa fa-exclamation-triangle IconBoxErrorSearch'></i></div><div class='TextBoxErrorSearch'><p><br>${useXmltag('Nohotel')}<br><br></p></div></div></div>`
            let htmlError =
              `<div id='show_offline_request'>
                <div class='fullCapacity_div'>
                    <img src='${full_capacity_image}' alt='fullCapacity'>
                    <h2>${useXmltag('Nohotel')}</h2>
                </div>
            </div>`
            $('#hotelResult').html(htmlError)
          }
          // (Start) put advertise
          if (advertises.length > 0) {
            let mainAdvertise = '<div class="advertises">'
            $.each(advertises, function(index, item) {
              mainAdvertise += '<div class="advertise-item ">'
              mainAdvertise += item.content
              mainAdvertise += '</div>'
            })
            mainAdvertise += '</div>'
            $(mainAdvertise).insertBefore('#hotelResult')
          }

          // (end) put advertise
          priceRangeSlider(data.minPrice, data.maxPrice)
          hotelTypeMange(hotelType)
        },
        error: function(error) {
          $('.loader-for-external-hotel-end').hide()
          let htmlError = `<div class='userProfileInfo-messge'><div class='messge-login BoxErrorSearch'><div style='float: right;'>  <i class='fa fa-exclamation-triangle IconBoxErrorSearch'></i></div><div class='TextBoxErrorSearch'><p><br>${error.responseJSON.Message[0]}<br><br></p></div></div></div>`
          $('#hotelResult').html(htmlError)
        },
        complete: function() {

          $('.loaderPublicForHotel').hide()
          $('.loader-for-local-hotel-end').hide()
          $('.container_loading').hide()
          let sort_type = $('#sort_hotel_type').val()
          sortHotelList(sort_type)
          // sortHotelList('min_room_price')
          let cityId = $('#destination_city').val()
          loadArticles('Hotel', cityId)
        },
        // always: function () {
        //     $('.loaderPublicForHotel').hide();
        //     $('.loader-for-local-hotel-end').hide();
        //     $('.container_loading').hide();
        //     sortHotelList('min_room_price');
        //     loadArticles('Hotel',cityId);
        // }
      })
    }
    if (gdsSwitch == 'detailHotel') {
      let data_request = $('#dataDetailHotel').val()
      let parseJson = JSON.parse(data_request)

      $.ajax({
        type: 'POST',
        url: amadeusPath + 'hotel_ajax.php',
        dataType:'JSON',
        data: parseJson,
        beforeSend: function() {
          $('.loaderPublicForHotel').show()
        },
        success: function(response) {
          let data = response;

          if (data.Success && data.StatusCode == 200) {
            let WebServiceType = data.WebServiceType
            let RequestNumber = data.RequestNumber
            let value = data.Result
            let lat = value.ContactInformation.Location.latitude ? value.ContactInformation.Location.latitude : 0
            let lon = value.ContactInformation.Location.longitude ? value.ContactInformation.Location.longitude : 0
            $('[name="requestNumber"]').val(RequestNumber)
            $('[name="webServiceType"]').val(WebServiceType)
            generateHtmlForSearchHotel(data, parseJson)
            /*Activate Carousel*/
            generateCarousel('.owl-carousel')
            generateMap(lat, lon)
            $('#ThisHotelResult').val(JSON.stringify(data))
            $('.RoomsContainer').html(`<div id='resultRoomHotel'><div class='roomHotelLocal'><div class='loader-box-user-buy'><span></span><span>${useXmltag('Loading')}</span></div></div></div>`)
            $('.loaderPublicForHotel').fadeOut(500)
            setTimeout(function() {
              ajaxGetPrices(RequestNumber, data)
            }, 3000)
          } else {
            $.alert({
              title: 'خطا ',
              content: 'یک خطای غیر منتظره رخ داده . ',
              rtl: true,
              icon: 'fa shopping-cart',
              type: 'red',
            })
          }
        },
        error: function(error) {
          $.alert({
            title: 'خطا ',
            content: 'یک خطای غیر منتظره رخ داده . ',
            rtl: true,
            icon: 'fa shopping-cart',
            type: 'red',

          })

        },
        complete: function() {
          $('.loaderPublicForHotel').hide()

        },
        always: function() {
          $('.loaderPublicForHotel').hide()
        },
      })
    }
    $(document).on('click', '.show-map-modal', function() {
      $('.modal-body #mapContainer').remove()
      $('.modal-body').append('<div id="mapContainer" class="gmap3"></div>')
      let lat = $(this).data('latitude')
      let lng = $(this).data('longitude')

      map = L.map('mapContainer').setView([lng, lat], 15)
      // set map tiles source
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ' <a href="https://www.iran-tech.com/">Iran Technology</a>',
        // maxZoom: 18,
        // minZoom: 11,
      }).addTo(map)
      // add marker to the map
      marker = L.marker([lng, lat]).addTo(map)
      // add popup to the marker
      $('#map_modal').modal({
        show: true,
      })
    })
    $('#map_modal').on('shown.bs.modal', function() {
      setTimeout(function() {
        map.invalidateSize()
      }, 1)
    })
  })
})(jQuery)

function approveChildAges(RoomToken) {
  let roomChildArr = $(`#roomChildArr-${RoomToken}`)
  let roomChildCount = $(`#roomChildCount-${RoomToken}`)
  let array = []
  let childAgeSelect = $(`.childAge-${RoomToken}`)
  let cc = 0
  childAgeSelect.each(function(index, item) {
    let itemValue = $(item).val()
    cc = cc + itemValue.length
    array[index] = itemValue
  })
  roomChildArr.val(JSON.stringify(array))
  roomChildCount.val(cc)
  CalculateNewRoomPrice(RoomToken, true)

  $(`#addChildren-${RoomToken}`).modal('hide')
}


function item_search(CountryEn,DepartureCityEn,DepartureCityEn,city,country) {
  return `<li onclick="selectCity('${CountryEn}','${DepartureCityEn}', '- ${DepartureCityEn}')"> 
             <i class="div_c_sr_i">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
            </i>
             <div class="div_c_sr">
               <span class="c-text">
                  ${city}
               </span>
                <div class="yata_gdemo">
                  <i>${country}</i>
                </div>
             </div>
           </li>`
}

function CalculateNewRoomPrice(idRoom, isInternal = true, addChild = false) {

  let ThisAddChildBtn = $(`.btnAddChildren-${idRoom}`)
  let ThisRoomChildPrice = $(`#roomChildPrice-${idRoom}`)
  let ThisRoomChildArr = $(`#roomChildArr-${idRoom}`)
  let ThisRoomChildCount = $(`#roomChildCount-${idRoom}`)
  let ChildMinAge = ThisAddChildBtn.data('min-age')
  let ChildMaxAge = ThisAddChildBtn.data('max-age')
  let ThisRoomCountEl = $('#RoomCount' + idRoom)
  let ThisRoomPriceEl = $('#priceRoom' + idRoom)
  let StayingTimeEl = $('#stayingTime')
  let TypeRoomHotelEl = $('#TypeRoomHotel')
  let ThisFinalRoomCountEl = $('#FinalRoomCount' + idRoom)
  let ThisFinalRoomPriceEl = $('#FinalPriceRoom' + idRoom)
  let ThisTempInputEl = $('#tempInput' + idRoom)
  let ThisTempExtraBedEl = $('#tempExtraBed' + idRoom)
  let ThisExtraBedEl = $('#ExtraBed' + idRoom)

  let RoomCount = ThisRoomCountEl.val()
  let priceRoom = ThisRoomPriceEl.val()
  let priceRoomToShow = ThisRoomPriceEl.data('amount')
  let stayingTime = StayingTimeEl.val()
  let TypeRoomHotel = TypeRoomHotelEl.val()
  let currencyUnit = ThisRoomPriceEl.data('unit')

  let price = 0
  let ThisCount = 0
  let ThisExtraBedCount = 0
  price = parseInt(RoomCount) * parseInt(priceRoom)
  let priceToShow = parseInt(RoomCount) * priceRoomToShow
  ThisCount = parseInt(RoomCount)
  ThisExtraBedCount = parseInt(ThisExtraBedEl.val())

  ThisFinalRoomCountEl.val(ThisCount)
  ThisFinalRoomPriceEl.val(price)
  ThisFinalRoomPriceEl.data('amount', priceToShow)
  ThisTempInputEl.val(idRoom + '-' + ThisCount)
  ThisTempExtraBedEl.val(idRoom + '-' + ThisExtraBedCount)

  let priceHotel = 0
  let priceHotelToShow = 0
  let CountTotalRooms = 0
  let CountTotalExtraBeds = 0
  let resultIdRoom = TypeRoomHotel.split('/')


  let TotalNumberRoom_Reserve = []
  let TotalExtraBed_Reserve = []

  if (isInternal === true) {
    for (i = 0; i < resultIdRoom.length; i++) {
      let ThisResultFinalRoomCountEl = $('#FinalRoomCount' + resultIdRoom[i])
      let ThisResultFinalRoomPriceEl = $('#FinalPriceRoom' + resultIdRoom[i])
      let ThisResultTempInputEl = $('#tempInput' + resultIdRoom[i])
      let ThisResultExtraBedEl = $('#ExtraBed' + resultIdRoom[i])
      let ThisResultTempExtraBedEl = $('#tempExtraBed' + resultIdRoom[i])

      let ThisResultChildPriceEl = $('#roomChildPrice-' + resultIdRoom[i])
      let ThisResultRoomChildCountEl = $('#roomChildCount-' + resultIdRoom[i])
      let ThisResultRoomChildArrEl = $('#roomChildArr-' + resultIdRoom[i])

      if (ThisExtraBedEl.length > 0) {
        if (RoomCount <= 0 || RoomCount == useXmltag('Room')) {
          ThisExtraBedEl.val('').attr('disabled', 'disabled')
        } else {
          ThisExtraBedEl.removeAttr('disabled')
        }
      }
      if (ThisAddChildBtn.length > 0) {
        if (RoomCount <= 0 || RoomCount == useXmltag('Room')) {
          ThisAddChildBtn.attr('disabled', 'disabled')
        } else {
          if (addChild) {
            ThisRoomChildArr.val('')
            ThisRoomChildCount.val('')
            childAgeItem(idRoom, RoomCount, ChildMinAge, ChildMaxAge)
          }
          ThisAddChildBtn.removeAttr('disabled')
        }
      }
      let nights = stayingTime
      priceHotel = parseInt(priceHotel)
      let roomPrice = parseInt(ThisResultFinalRoomPriceEl.val())
      /*Room Price for each night*/
      let roomPriceAmount = parseInt(ThisResultFinalRoomPriceEl.data('amount'))
      /*Room Price For each night*/
      let finalRoomCount = parseInt(ThisResultFinalRoomCountEl.val())
      /*count of this room selected */
      let extraBedCount = parseInt(ThisResultExtraBedEl.val())
      /*count of extrabed */
      let extraBedPrice = parseInt(ThisResultExtraBedEl.data('price'))

      /*price foreach extra bed for hole staying time */
      let childCount = 0
      if (ThisResultRoomChildCountEl.val() !== '') {
        childCount = parseInt(ThisResultRoomChildCountEl.val())
      }
      /*count of extra children*/

      /*price for each children for hole staing time */

      let childPrice = 0
      if (ThisResultChildPriceEl.val() !== '' && (ThisResultChildPriceEl.val() !== 'undefined')) {
        childPrice = parseInt(ThisResultChildPriceEl.val())
      }


      if (finalRoomCount > 0) {
        priceHotel = priceHotel + roomPrice

        priceHotelToShow = priceHotelToShow + roomPriceAmount
        CountTotalRooms = parseInt(CountTotalRooms) + finalRoomCount
      }

      if (extraBedCount > 0) {
        let totalExtraBedPrice = parseInt(extraBedPrice * extraBedCount * RoomCount)
        priceHotel = parseInt(priceHotel) + totalExtraBedPrice
        priceHotelToShow = parseInt(priceHotelToShow) + totalExtraBedPrice
        CountTotalExtraBeds = parseInt(CountTotalExtraBeds) + extraBedCount
      }

      if (childPrice !== '' && childCount !== '' && typeof childCount != 'undefined') {
        if (childCount > 0) {
          let totalChildPrice = parseInt(childPrice * childCount)

          priceHotel = parseInt(priceHotel) + totalChildPrice
          priceHotelToShow = parseInt(priceHotelToShow) + totalChildPrice
        }
      }
      if (ThisResultTempInputEl.val() !== '' && ThisResultTempInputEl.val() !== 'undefined') {
        if (ThisResultFinalRoomCountEl.val() > 0) {
          TotalNumberRoom_Reserve.push(ThisResultTempInputEl.val())
        }
      }
      if (ThisResultTempExtraBedEl.val() !== '' && ThisResultTempExtraBedEl.val() !== 'undefined') {
        if (ThisResultExtraBedEl.val() > 0) {
          TotalExtraBed_Reserve.push(ThisResultTempExtraBedEl.val())
        }
      }
    }
  } else {
    if (isInternal === false) {
      TotalNumberRoom_Reserve = []
      priceHotel = parseInt(priceHotel) + parseInt(ThisFinalRoomPriceEl.val())
      priceHotelToShow = priceHotelToShow + ThisFinalRoomPriceEl.data('amount')
      CountTotalRooms = parseInt(CountTotalRooms) + parseInt(ThisFinalRoomCountEl.val())

      TotalNumberRoom_Reserve.push(ThisTempInputEl.val())
    }
  }

  $('#TotalNumberRoom_Reserve').val(TotalNumberRoom_Reserve.join())
  $('#TotalNumberExtraBed_Reserve').val(TotalExtraBed_Reserve.join())
  $('.roomFinalTxt').html(CountTotalRooms + ' ' + useXmltag('Selectedroom'))
  $('#TotalNumberRoom').val(CountTotalRooms)
  $('#TotalExtraBed').val(CountTotalExtraBeds)
  $('.roomFinalPrice').html(`${number_format(priceHotelToShow)} <i>${currencyUnit}</i>`)

  if (CountTotalRooms > 0) {
    $('#btnReserve').removeAttr('disabled')
  } else {
    $('#btnReserve').attr('disabled', 'disabled')
  }

}



//
// const number_format = function(yourNumber){
//     //Seperates the components of the number
//     if (yourNumber == null) {
//         yourNumber = 0;
//     }
//     let n = yourNumber.toString().split(".");
//
//
//     //Comma-fies the first part
//     n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//     //Combines the two sections
//     return n;
// };

function BuyHotelWithoutInputsApiNew(RoomId) {
  let webServiceType = $('#webServiceType').val()
  webServiceType = 'public'
  let requestNumber = $('#requestNumber').val()
  let thisPricesResult = $('#ThisPricesResult').val()
  let pricesDetail = JSON.parse(thisPricesResult)
  let hotelDetail = $('#ThisHotelResult').val()
  let hotelParse = JSON.parse(hotelDetail)
  let IdCity = hotelParse.Result.CityId
  let IdHotel = $('#idHotel_reserve').val()
  let SDate = $('#startDate_reserve').val()
  let EDate = $('#endDate_reserve').val()
  let Nights = $('#nights_reserve').val()

  let TotalNumberRoom_Reserve = RoomId + '-1'

  $('#TotalNumberRoom_Reserve').val(TotalNumberRoom_Reserve)

  let TotalNumberExtraBed_Reserve = 0
  let IsInternal = $('#IsInternal').val()
  let typeApplication = 'externalApi'
  let searchRooms = $('#searchRooms').val()
  let factorNumber = $('#factorNumber').val()
  // let requestNumber = $('input[name="requestNumber"]').val();
  let ajaxData = {
    searchRooms: searchRooms,
    IsInternal: IsInternal,
    IdCity: IdCity,
    IdHotel: IdHotel,
    SDate: SDate,
    EDate: EDate,
    Nights: Nights,
    Prices: JSON.stringify(pricesDetail.Result),
    PriceSessionId : pricesDetail.PriceSessionId,
    HotelDetail: hotelDetail,
    TotalNumberRoom_Reserve: TotalNumberRoom_Reserve,
    TotalNumberExtraBed_Reserve: TotalNumberExtraBed_Reserve,
    TypeApplication: typeApplication,
    factorNumber: factorNumber,
    requestNumber: requestNumber,
    webServiceType: webServiceType,
    flag: 'nextStepReserveApiHotelNew'
  }
  // return false;
  $.ajax({
    url: amadeusPath + 'hotel_ajax.php',
    data: ajaxData,
    // dataType: 'JSON',
    type: 'POST',
    success: function(data) {

      if (data.indexOf('success_NextStepReserveHotel') > -1) {
        let result = data.split(':')
        $('#factorNumber').val(result[1])

        $('#IsInternal').val(IsInternal)
        $('#searchRooms').val(searchRooms)
        let href = $('#href').val()
        // return false;
         $('#formHotelReserve').attr('action', amadeusPathByLang + href).submit()

      } else if (data.indexOf('error_NextStepReserveHotel') > -1) {
        $.alert({
          title: useXmltag('Reservationhotel'),
          icon: 'fa fa-trash',
          content: useXmltag('PleaseAgainBookingHotel'),
          rtl: true,
          type: 'red',
        })
      }
    },
  })
}

function childAgeItem(RoomToken, count, MinAge, MaxAge) {

  // count = $('#RoomCount'+RoomToken).val();
  html = ''
  for (c = 1; c <= count; c++) {
    let tpl = `<div class='room-child-age' >
<!--<span>
<label class="form-label" for="childAge-${RoomToken}-${c}">
</label>
<span class="close btn btn-xs removeChild">&times;</span>
</span>-->
<select data-placeholder='${useXmltag('Age')} ${useXmltag('Chd')} ( ${useXmltag('Room')} ${c} )' class='form-control select2 select2-repeatable childAge-${RoomToken}' id='childAge-${RoomToken}-${c}' multiple>`
    tpl += `<option value=''>انتخاب کنید</option>`
    for (age = MinAge; age <= MaxAge; age++) {
      tpl += `<option value='${age}'>${age} ${useXmltag('Year')}   </option>`
    }
    tpl += `</select>
</div>`
    html += tpl
  }

  if ($(`#addChildren-${RoomToken}`).length > 0) {
    $(`#addChildren-${RoomToken}`).find('.childAgesContainer').html(html)
    let childAgesSelector = $('.select2-repeatable')
    childAgesSelector.select2({
      placeholder: useXmltag('Select'),
      // allowClear: true,
      allowRepetitionForMultipleSelect: true,
    })
    $('.select2-search__field').on('click', function() {
      // remove select2-disabled class from all li under the dropdown
      $('.select2-dropdown .select2-results li').removeClass('select2-results__option--selected')
      // add select2-result-selectable class to all li which are missing the respective class
      $('.select2-dropdown .select2-results li').each(function() {
        if (!$(this).hasClass('select2-result-selectable'))
          $(this).addClass('select2-result-selectable')
      })
    })

    // had to include the following code as a hack since the click event required double click on 'select2-input' to invoke the event
    $('.select2-container-multi').on('mouseover', function() {
      $('.select2-search__field').click()
    })
  } else {

  }
}

function BuyHotelWithoutRegisterApiNew() {

  let IdCity = $('#IdCity_Reserve').val()
  let webServiceType = $('#webServiceType').val()
  let requestNumber = $('#requestNumber').val()
  let thisPricesResult = $('#ThisPricesResult').val()
  let pricesDetail = JSON.parse(thisPricesResult)
  let hotelDetail = $('#ThisHotelResult').val()

  let IdHotel = $('#idHotel_reserve').val()
  let source_id = $('#source_id').val()
  let SDate = $('#startDate_reserve').val()
  let EDate = $('#endDate_reserve').val()
  let Nights = $('#nights_reserve').val()
  let TotalNumberRoom_Reserve = $('#TotalNumberRoom_Reserve').val()
  let TotalNumberExtraBed_Reserve = $('#TotalNumberExtraBed_Reserve').val()
  let typeApplication = $('#typeApplication').val()
  let IsInternal = $('#IsInternal').val()
  let searchRooms = ''
  // let roomChildCount = {};
  let roomChildArr = {}

  if (typeApplication == 'api') {
    $('input[name^="roomChildArr"]').each(function(key, element) {
      let RoomToken = $(this).data('room-code')
      let value = $(this).val()
      roomChildArr[RoomToken] = {
        [key]: {
          arr: value,
        },
      }


    })
    $('input[name^="roomChildCount"]').each(function(index, item) {
      let RoomToken = $(this).data('room-code')
      let value = $(this).val()
      $.extend(roomChildArr[RoomToken][index],
        {
          count: value,
        })
      if (typeof roomChildArr[RoomToken][index] != 'undefined') {

        // roomChildArr[RoomToken][index][arr] = value;
        // roomChildArr[RoomToken][index][count] =
      }
    })
  }

  if (typeApplication == 'externalApi') {

    if(source_id == '17' && IsInternal == '1'){
      IsInternal = 0
    }
    searchRooms = $('#searchRooms').val()
  }
  let factorNumber = $('#factorNumber').val()

  // let requestNumber = $('input[name="requestNumber"]').val();

  var jsonRoomChild = JSON.stringify(roomChildArr)
  var ajaxData = {
    typeApplication: typeApplication,
    searchRooms: searchRooms,
    IsInternal: IsInternal,
    IdCity: IdCity,
    IdHotel: IdHotel,
    SDate: SDate,
    EDate: EDate,
    Nights: Nights,
    Prices: JSON.stringify(pricesDetail.Result),
    PriceSessionId : pricesDetail.PriceSessionId,
    HotelDetail: hotelDetail,
    TotalNumberRoom_Reserve: TotalNumberRoom_Reserve,
    TotalNumberExtraBed_Reserve: TotalNumberExtraBed_Reserve,
    /*todo: add child params here to be added on temprory*/
    // roomChildCount : roomChildCount,
    roomChildArr: roomChildArr,
    TypeApplication: typeApplication,
    factorNumber: factorNumber,
    requestNumber: requestNumber,
    webServiceType: webServiceType,
    flag: 'nextStepReserveApiHotelNew',
  }

  // return false;
  $.post(amadeusPath + 'hotel_ajax.php',
    ajaxData,
    function(data) {
      if (data.indexOf('success_NextStepReserveHotel') > -1) {
        let result = data.split(':')
        $('#factorNumber').val(result[1])
        $('#IsInternal').val(IsInternal)
        $('#searchRooms').val(searchRooms)
        let href = $('#href').val()
        // return false;
        $('#formHotelReserve').attr('action', amadeusPathByLang + href).submit()

      } else if (data.indexOf('error_NextStepReserveHotel') > -1) {

        $.alert({
          title: useXmltag('Reservationhotel'),
          icon: 'fa fa-trash',
          content: useXmltag('PleaseAgainBookingHotel'),
          rtl: true,
          type: 'red',
        })

      }

    })

}

function ReserveTemproryNew(factorNumber, typeApplication, requestNumber) {
  var final_reserve_btn = $('#final_ok_and_insert_passenger');
  if (!$('#RulsCheck').is(':checked')) {
    $.alert({
      title: useXmltag('Reservationhotel'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('ConfirmTermsFirst'),
      rtl: true,
      type: 'red',
    })
    return false
  }

  final_reserve_btn.attr('data-loading-title','Pending');
  // final_reserve_btn.attr('data-loading-title','Pending');

  loadingToggle(final_reserve_btn,true);
  // $('#final_ok_and_insert_passenger').text(useXmltag('Pending')).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress')

  // $('#loader_check').css('display', 'block')

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'hotel_ajax.php',
    dataType: 'JSON',
    data: {
      factorNumber: factorNumber,
      typeApplication: typeApplication,
      requestNumber: requestNumber,
      first_check : '1',
      flag: 'GetDataFromReport',
    },

    success: function(data) {
      if (data.book == 'PreReserve') {

        $('#total_price').val(data.total_price)

        if(data.price_changed == true){
          $('#PriceChange').removeClass('displayN')
          $('#PriceChange #total_price').html( number_format(data.total_payment_price) + useXmltag('Rial'))
          var element = $('.go_bank_click');
          // Get the current onclick attribute value
          var onclickContent = element.attr('onclick');
// Extract the JSON string
          var jsonString = onclickContent.match(/{.*}/)[0];

// Parse the JSON string
          var jsonObject = JSON.parse(jsonString);

// Modify the paymentPrice value
          jsonObject.paymentPrice = data.total_payment_price;

// Convert the JSON object back to a string
          var modifiedJsonString = JSON.stringify(jsonObject);

// Replace the original JSON string in the function call
          var modifiedFunctionCall = onclickContent.replace(jsonString, modifiedJsonString);
          element.attr('onclick', modifiedFunctionCall);


        }

        // if (data.type_application == 'api') {

        // $('#RequestNumber').val(data.RequestNumber);
        // $('#RequestPNR').val(data.RequestPNR);

        // }

        setTimeout(function() {
          final_reserve_btn.data('loading-title','Accepted');
          loadingToggle(final_reserve_btn,true);

          // $('#final_ok_and_insert_passenger').removeAttr('onclick').attr('disabled', true).css('cursor', 'not-allowed').text(useXmltag('Accepted'))

          $('.main-pay-content').css('display', 'flex')
          // $('#loader_check').css('display', 'none')
          $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow')
        }, 2000)


      }
      else if (data.book == 'OnRequest') {
        $('.counter').counter({})
        $('#timeConfirmHotel').val('yes')

        timeForConfirmHotel()
        $('#btn-final-Reserve').addClass('displayN')
        $('#showFactorNumber').html(useXmltag('Invoicenumber') + ': ' + data.factor_number)
        if (data.user_type == '5') {
          $('#onRequestOnlinePassenger').removeClass('displayN')
        } else {
          $('#onRequest').removeClass('displayN')
        }
      }
      else if (data.book == 'no') {
        alert(useXmltag('ThisHotelCanNotBooked'));
        setTimeout(function() {
          loadingToggle(final_reserve_btn,false);
          final_reserve_btn.removeAttr('onclick',true);
        }, 1000)
      }
      else if (data.book == 'Cancelled') {
        $('#timeConfirmHotel').val('no');
        $('#onRequest').addClass('displayN');
        $('#onRequestOnlinePassenger').addClass('displayN');
        $('#AdminChecking').addClass('displayN');
        $('#cancelHotel').removeClass('displayN');
        setTimeout(function() {
          loadingToggle(final_reserve_btn,false);
          final_reserve_btn.removeAttr('onclick',true);
        }, 1000)
      }
      else if (data.book == 'NoReserve') {
        if(data.error_comment) {
          alert(data.error_comment);
        }else{
          alert(useXmltag('ThisHotelCanNotBooked'));
        }

        setTimeout(function() {
          loadingToggle(final_reserve_btn,false);
          final_reserve_btn.removeAttr('onclick',true);
        }, 1000)
      }

    },
    error: function(xhr, ajaxOptions, thrownError) {
      if (thrownError == 'Not Acceptable') {
        $('#messageBook').html(useXmltag('ThisHotelCanNotBooked'))
      }
    },
  })
}

(function($) {
  jQuery(document).ready(function($) {
    $(document).on('click', '.external-hotel-facilities', function(e) {
      if($(this).css('height') != '32px' || $(this).css('height') == 'auto'){
        $(this).css({'height': "32px"});
      }else{
        $(this).css({'height': "auto"});
      }
    });
    //filterHotelStar
    $(document).on('click', '.hotelStarFilter', function() {
      let hotelList = $('.hotel-result-item')
      let isCheck = 0
      let countHotels = 0
      hotelList.hide()
      $('input:checkbox.hotelStarFilter').each(function() {
        let check = $(this).prop('checked')
        let val = $(this).val()
        if (check == true) {
          isCheck++
          hotelList.filter(function() {
            let star = $(this).data('star')
            if (val == star) {
              countHotels++
              return true
            }
            return val == star
          }).show()
          $('#countHotelHtml').html(countHotels)
        }
      })

      setTimeout(function() {
        if (isCheck == 0) {
          hotelList.show()
          $('#countHotelHtml').html(hotelList.length)
        }
      }, 30)

      $('html, body').animate({
        scrollTop: $('.sort-by-section').offset().top,
      }, 'slow')

    })
    // end filterHotelStar

    setTimeout(function() {
      let sort_type = $('#sort_hotel_type').val()
      sortHotelList(sort_type)
      $('#result').show()
    }, 3000)


    $(document).on('click', '.ShowByHotelFilters', function() {
      $('.Show_all').prop('checked', true)
      var hotelList = $('.hotel-result-item')
      var isCheck = 0
      let countHotels = 0
      hotelList.hide()
      $('input:checkbox.ShowByHotelFilters').each(function() {
        var check = $(this).prop('checked')
        var val = $(this).val()
        if (check == true) {
          isCheck++
          $('.Show_all').prop('checked', false)
          var Check = parseInt($(this).val())
          hotelList.filter(function() {
            var hotelType = parseInt($(this).data('hoteltype'), 10)
            if (hotelType == Check) {
              countHotels++
              return true
            }
            return hotelType == Check
          }).show()
        }

        $('#countHotelHtml').html(countHotels)

      })

      setTimeout(function() {
        if (isCheck == 0) {
          hotelList.show()
        }
      }, 30)
      $('html, body').animate({
        scrollTop: $('.sort-by-section').offset().top,
      }, 'slow')
    })







    //todo: filter on facilities must be add

    $(document).on('click', '.Show_all', function() {
      var hotelList = $('.hotel-result-item')
      $('#countHotelHtml').html(hotelList.length)
      hotelList.show()
      var check = $(this).prop('checked')
      if (check == true) {
        $('input:checkbox.ShowByHotelFilters').each(function() {
          $(this).prop('checked', false)
        })
      } else {
        $('.Show_all').prop('checked', true)
      }

      let scrollPosition = 0;
      if ($('.sort-by-section').length) {
        scrollPosition = $('.sort-by-section').offset().top;
      }

      $('html, body').animate({
        scrollTop: scrollPosition
      }, 'slow');
    })


    $(document).on('keyup', '#inputSearchHotel', function() {

      var hotels = $('.hotel-result-item')
      var inputSearchHotel = $(this).val().toLowerCase()

      hotels.hide().filter(function() {
        var hotelName = $(this).data('hotelname')

        var search = hotelName.indexOf(inputSearchHotel)
        if (search > -1) {
          return hotelName
        }

      }).show()

    })


  })
})(jQuery)

/*
 *
 * ٍEnd Custom Functions by Qorbani
 *
 * */

//show Hotel Room by ajax
function getInfoHotelRoomPriceForAjax() {

  //$('#img_loader').addClass('displayB');
  let idCity = $('#idCity').val()
  let idHotel = $('#idHotel_select').val()
  let startDate = $('#startDate').val()
  let endDate = $('#endDate').val()
  let nights = $('#nights').val()
  let hotelStar = $('#hotelStar').val()
  let CurrencyCode = $('#CurrencyCode').val()

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      city: idCity,
      idHotel: idHotel,
      startDate: startDate,
      endDate: endDate,
      nights: nights,
      hotelStar: hotelStar,
      CurrencyCode: CurrencyCode,
      flag: 'ShowRoomHotel',
    },
    function(data) {
      if (data) {
        $('#resultRoomHotel').html(data)
      } else {
        $('#resultRoomHotel').html(useXmltag('Errordisplayinginformation'))
      }
    })

}

function isAlfabetKeyFieldsHotel(evt, Input) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  // ascii code ro check mikone
  // if ((charCode > 31 && (charCode < 48 || charCode > 57))){
  if (charCode < 97 || charCode > 122) {
    if (charCode == 8 || charCode == 32 || charCode == 20) {
      return true
    } else {
      $.alert({
        title: useXmltag('Reservationhotel'),
        icon: 'fa shopping-cart',
        content: useXmltag('PleaseuseLatinlettersturnyourCapsLockkey'),
        rtl: true,
        type: 'red',
      })

      return false
    }
  }
  return true
}

function membersForHotel(mob, Email_Address, tel) {
  $('#messageInfo').html('')
  var mobile_regex = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
  if (mob == '') {
    $('#messageInfo').html(useXmltag('Fillingallfieldsrequired'))
    return false
  } else if (!mobile_regex.test(mob)) {
    $('#messageInfo').html(useXmltag('MobileNumberIncorrect'))
    return false

  } else if (Email_Address == '') {
    $('#Email').val('simple' + mob + '@info.com')
    return true
  } else if (!emailReg.test(Email_Address)) {
    $('#messageInfo').html(useXmltag('Theenteredemailformatnotcorrect'))
    return false

  }
  return true
}

/*** generate URL for Hotellocal search in sidebar
 insert slash character between parametrs ***/
function submitSearchHotelLocal() {
  let id_city = $('#autoComplateSearchIN_hidden').val()
  let start_date = $('#startDate').val()
  let end_date = $('#endDate').val()
  let stayingTime = $('#stayingTime').val()
  let hotelType = $('#hotelType').val()
  let has_type = $('#type').val()
  let Switch = 'searchHotel'

  /*let star = $("#star").val();
    let price = $("#price").val();*/

  if (id_city == '' || start_date == '' || end_date == '') {

    $.alert({
      title: useXmltag('Reservationhotel'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('Pleaseenterrequiredfields'),
      rtl: true,
      type: 'red',
    })
  } else {

    // let route = gdsSwitch;
    let address = ''
    if (typeof has_type != 'undefined' && has_type == 'new') {
      let searchRooms = ''
      var countRoom = $('#countRoom').val()
      for (i = 1; i <= countRoom; i++) {
        var adult = parseInt($('#adult' + i).val())
        child = parseInt($('#child' + i).val())
        if (adult > 0) {
          searchRooms = searchRooms + 'R:' + adult
          if (child > 0) {
            searchRooms = searchRooms + '-' + child
            for (j = 1; j <= child; j++) {
              child = $('#childAge' + i + j).val()
              if (j == 1 && child != undefined) {
                searchRooms = searchRooms + '-' + child
              } else if (child != undefined) {
                searchRooms = searchRooms + ',' + child
              }
            }
          } else {
            searchRooms = searchRooms + '-0-0'
          }
        }
      }

      address = `${amadeusPathByLang}${Switch}&type=new&city=${id_city}&startDate=${start_date}&nights=${stayingTime}&rooms=${searchRooms}`
    } else {
      address = `${amadeusPathByLang}${Switch}/${id_city}/${start_date}/${stayingTime}/all`
    }

    // let url = amadeusPathByLang + "resultHotelLocal/" + id_city + "/" + start_date + "/" + stayingTime + "/" + hotelType;
    /*if (hotelType != ''){
             url = url + "/" + hotelType;
         } else {
             url = url + "/all";
         }*/
    /*if (star != ''){
            url = url + "/" + star + "/" + price;
        }*/
    // return false;
    window.location.href = address
  }
}

function triggerHotelDetail(_this,section=null){
  hotelDetail(_this.data('hotel-type'),_this.data('hotel-id'),_this.data('hotel-name'),'','',null,section)
}
function hotelDetail(typeApplication, hotelId, hotelName, RequestNumber, sourceId,_this=null,section=null) {


  if(_this && _this.length){
    loadingToggle(_this);
  }



  let href = amadeusPathByLang

  if ((typeApplication == 'api' || typeApplication == 'externalApi') && (typeof RequestNumber != 'undefined')) {
    // if(sourceId=='17') {
    //     typeApplication = 'externalApi';
    // }
    href += `detailHotel/${typeApplication}/${hotelId}/${RequestNumber}`
  } else {
      hotelName = hotelName.replace(/ /g,"_");
      href += `roomHotelLocal/${typeApplication}/${hotelId}/${hotelName}`

  }
  if(section){
    href=href+'#'+section
  }


  $('#formHotel').attr('action', href).submit()

}


function ReserveExternalApiHotel(RoomToken) {
  let TotalNumberRoom_Reserve = RoomToken + '-1'
  $('#TotalNumberRoom_Reserve').val(TotalNumberRoom_Reserve)
  $.ajax({
    // dataType : 'HTML',
    type: 'POST',
    data: {
      flag: 'CheckedLogin',
    },
    url: amadeusPath + 'hotel_ajax.php',
    success: function(response) {
      if (response.indexOf('successLoginHotel') > -1) {
        $('#img').show()
        $('#reserve_input' + RoomToken).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag('Pending'))

        BuyHotelWithoutInputsApiNew(RoomToken)
      } else if (response.indexOf('errorLoginHotel') > -1) {
        $('#noLoginBuy').val(useXmltag('Bookingwithoutregistration')).attr('onClick', `popupBuyNoLogin('newApiHotelExternal','${RoomToken}')`)

        let isShowLoginPopup = $('#isShowLoginPopup').val()
        let useTypeLoginPopup = $('#useTypeLoginPopup').val()
        if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
          $('#login-popup').trigger('click')
        } else {
          popupBuyNoLogin('newApiHotelExternal', `'${RoomToken}'`)
        }
      }
    },
    error: function(error) {
      return false
    },
  })

}

function ReserveHotel() {

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      flag: 'CheckedLogin',
    },
    function(data) {

      if (data.indexOf('successLoginHotel') > -1) {
          $('#img').show()
          $('#btnReserve').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag('Pending'))
          if (gdsSwitch == 'roomHotelLocal') {
            // alert('tttt')
            BuyHotelWithoutRegister()
          } else {
            // alert('wwww')
            BuyHotelWithoutRegisterApiNew()
          }

      } else if (data.indexOf('errorLoginHotel') > -1) {
        $('#noLoginBuy').val(useXmltag('Bookingwithoutregistration'))

        let isShowLoginPopup = $('#isShowLoginPopup').val()

        let useTypeLoginPopup = $('#useTypeLoginPopup').val()

        if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
          $('#login-popup').trigger('click')
        } else {
          popupBuyNoLogin(useTypeLoginPopup)
        }


      }
    })

}

function BuyHotelWithoutRegister() {
  let IdCity = $('#IdCity_Reserve').val()
  let IdHotel = $('#idHotel_reserve').val()
  let SDate = $('#startDate_reserve').val()
  let EDate = $('#endDate_reserve').val()
  let Nights = $('#nights_reserve').val()
  let TotalNumberRoom_Reserve = $('#TotalNumberRoom_Reserve').val()
  let typeApplication = $('#typeApplication').val()
  let factorNumber = $('#factorNumber').val()
  var prepaymentPercentage = parseInt($('#prepaymentPercentage').val());
// alert('xxxxxx')
//   alert(prepaymentPercentage)
  $.post(amadeusPath + 'hotel_ajax.php',
    {
      IdCity: IdCity,
      IdHotel: IdHotel,
      SDate: SDate,
      EDate: EDate,
      Nights: Nights,
      TotalNumberRoom_Reserve: TotalNumberRoom_Reserve,
      TypeApplication: typeApplication,
      factorNumber: factorNumber,
      prepaymentPercentage: prepaymentPercentage,
      flag: 'nextStepReserveHotel',
    },
    function(data) {

      if (data.indexOf('success_NextStepReserveHotel') > -1) {

        let result = data.split(':')
        $('#factorNumber').val(result[1])
        let href = $('#href').val()
        // return false;

          $('#formHotelReserve').attr('action', amadeusPathByLang + href).submit()
      } else if (data.indexOf('error_NextStepReserveHotel') > -1) {

        $.alert({
          title: useXmltag('Reservationhotel'),
          icon: 'fa fa-trash',
          content: useXmltag('PleaseAgainBookingHotel'),
          rtl: true,
          type: 'red',
        })

      }

    })

}

function backToResultHotelLocal(idCity, startDate, night) {

  let link = `${amadeusPathByLang}searchHotel/${idCity}/${startDate}/${night}`
  window.location.href = link

}

function factorHotel() {

  var href = amadeusPathByLang + 'factorHotelLocal'
  window.location.href = href

}

/*function memberHotelLocalLogin() {
    // Rid Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    // Get values
    var email = $("#signin-email2").val();
    var pass = $("#signin-password2").val();
    var remember = $("#remember-me2:checked").val();
    if (remember == 'checked' || remember == 'on' || remember == 'true') {
        remember = 'on';
    } else {
        remember = 'off';
    }
    var organization = '';
    if($('#signin-organization2').length > 0){
        organization = $('#signin-organization2').val();
    }

    //check values
    if (!email) {
        $("#error-signin-email2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-email2").css("opacity", "1");
        $("#error-signin-email2").css("visibility", "visible");
        error = 1;
    }

    if (!pass) {
        $("#error-signin-password2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-password2").css("opacity", "1");
        $("#error-signin-password2").css("visibility", "visible");
        error = 1;
    }

    // send  for logon
    if (error == 0) {

        $.post(amadeusPath + 'user_ajax.php',
            {
                email: email,
                remember: remember,
                password: pass,
                organization: organization,
                setcoockie: "yes",
                flag: 'memberLogin'
            },
            function (data) {

                if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                    $(".cd-user-modal").trigger("click");
                    BuyHotelWithoutRegister();
                } else {

                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            email: email,
                            remember: remember,
                            password: pass,
                            flag: 'agencyLogin'
                        },
                        function (res) {
                            if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
                                $(".cd-user-modal").trigger("click");
                                BuyHotelWithoutRegister();
                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        })

                }
            })
    } else {
        return false;
    }

}*/

/*function memberExternalHotel() {
    // Rid Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    // Get values
    var email = $("#signin-email2").val();
    var pass = $("#signin-password2").val();
    var remember = $("#remember-me2:checked").val();
    if (remember == 'checked' || remember == 'on' || remember == 'true') {
        remember = 'on';
    } else {
        remember = 'off';
    }
    var organization = '';
    if($('#signin-organization2').length > 0){
        organization = $('#signin-organization2').val();
    }

    //check values
    if (!email) {
        $("#error-signin-email2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-email2").css("opacity", "1");
        $("#error-signin-email2").css("visibility", "visible");
        error = 1;
    }

    if (!pass) {
        $("#error-signin-password2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-password2").css("opacity", "1");
        $("#error-signin-password2").css("visibility", "visible");
        error = 1;
    }

    // send  for logon
    if (error == 0) {

        $.post(amadeusPath + 'user_ajax.php',
            {
                email: email,
                remember: remember,
                password: pass,
                organization: organization,
                setcoockie: "yes",
                flag: 'memberLogin'
            },
            function (data) {

                if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                    $(".cd-user-modal").trigger("click");
                    buyExternalHotelWithoutRegister();
                } else {

                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            email: email,
                            remember: remember,
                            password: pass,
                            flag: 'agencyLogin'
                        },
                        function (res) {
                            if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
                                $(".cd-user-modal").trigger("click");
                                BuyHotelWithoutRegister();
                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        })

                }
            })
    } else {
        return false;
    }

}*/


function persianLettersHotel(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode < 1570 || charCode > 1740) {
    if (charCode == 8 || charCode == 32 || charCode == 9) {
      return true
    } else {
      $.alert({
        title: useXmltag('Reservationhotel'),
        icon: 'fa shopping-cart',
        content: useXmltag('OnlyPersianLetters'),
        rtl: true,
        type: 'red',
      })
      return false
    }

  }
  return true
}


/**
 بررسی  مسافران وارد شده قبل از ارسال به صفحه فاکتور
 page : PassengerDetailHotelLocal.tpl
 **/
function checkHotelLocal(currentDate, numAdult) {

  var error1 = 0
  var error2 = 0
  var error3 = 0

  var min1 = $('.counter-analog').find('.part0').find('span:first-child').html()
  var min2 = $('.counter-analog').find('.part0').find('span:last-child').html()
  var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html()
  var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html()

  var timejoin = min1 + min2 + ':' + sec1 + sec2
  $('#time_remmaining').val(timejoin)

  var typeApplication = $('#typeApplication').val()
  if (numAdult > 0) {

    var adt = adultMembersHotel(currentDate, numAdult, typeApplication)
    if (adt == 'true') {
      error1 = 0
    } else {
      error1 = 1
    }
  }

  var leaderRoom = leaderRoomForHotel(typeApplication)
  if (leaderRoom) {
    error3 = 0
  } else {
    error3 = 1
  }

  if ($('#UsageNotLogin').val() && $('#UsageNotLogin').val() == 'yes') {
    var mob = $('#Mobile').val()
    var Email_Address = $('#Email').val()
    var tel = $('#Telephone').val()

    var mm = membersForHotel(mob, Email_Address, tel)

    if (mm == true || mm == 'true') {
      error2 = 0
    } else {
      error2 = 1
    }
    Email_Address = $('#Email').val()
  }


  if (error1 == 0 && error2 == 0 && error3 == 0) {
// alert('pppp')
    $.post(amadeusPath + 'hotel_ajax.php',
      {
        mobile: mob,
        telephone: tel,
        Email: Email_Address,
        flag: 'register_memeberHotel',
      },
      function(data) {
        if (data != '') {
          $('#idMember').val(data)
          $('#loader_check').show()
          $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag('Pending'))

          setTimeout(
            function() {
              $('#formPassengerDetailHotelLocal').submit()
            }, 3000)

        } else {

          $.alert({
            title: useXmltag('Reservationhotel'),
            icon: 'fa fa-cart-plus',
            content: useXmltag('Errorrecordinginformation'),
            rtl: true,
            type: 'red',
          })
          return false
        }
      })
  }

}

function checkHotelNew(currentDate, numAdult, childCount, RequestNumber ) {

  var validate1 = true
  var validate2 = true
  var validate3 = true
  var validate4 = true

  var min1 = $('.counter-analog').find('.part0').find('span:first-child').html()
  var min2 = $('.counter-analog').find('.part0').find('span:last-child').html()
  var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html()
  var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html()

  var timejoin = min1 + min2 + ':' + sec1 + sec2
  $('#time_remmaining').val(timejoin)

  var rooms_count = $('input[name="rooms_count"]').val()
  var typeApplication = $('#typeApplication').val()
  var source_id = $('#source_id').val()
  if (numAdult > 0) {
    if(source_id == '29') {
      var adult_check_validate = adultMembersHotelFlightio(currentDate, numAdult, typeApplication, rooms_count )
    }else{
      var adult_check_validate = adultMembersHotelWebservice(currentDate, numAdult, typeApplication, rooms_count )
    }
    validate1 = adult_check_validate
  }
  if (childCount > 0) {
    if(source_id == '29') {
      var children_check_validate = childMembersHotelFlightio(currentDate, numAdult, typeApplication, rooms_count)
    }else{
      var children_check_validate = childMembersHotelWebservice(currentDate, childCount, typeApplication, rooms_count)
    }

    validate4 = children_check_validate

  }

  var leaderRoom = leaderRoomForHotel(typeApplication)
  validate3 = leaderRoom

  if ($('#UsageNotLogin').val() && $('#UsageNotLogin').val() == 'yes') {
    var mobile = $('#Mobile').val()
    var email_address = $('#Email').val()
    var telephone = $('#Telephone').val()
    var hotel_member = membersForHotel(mobile, email_address, telephone)
    validate2 = hotel_member
  }

  if (validate1 && validate2 && validate3 && validate4) {
    var email_address = $('#Email').val()
    $.post(amadeusPath + 'hotel_ajax.php',
      {
        mobile: mobile,
        telephone: telephone,
        Email: email_address,
        flag: 'register_memeberNewHotel',
      },
      function(data) {
        if (data != '') {
          $('#idMember').val(data)
          $('#loader_check').show()
          $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag('Pending'))
          setTimeout(
            function() {
              $('#loader_check').hide()
              $('#formPassengerDetailHotelLocal').submit()
            }, 3000)

        } else {

          $.alert({
            title: useXmltag('Reservationhotel'),
            icon: 'fa fa-cart-plus',
            content: useXmltag('Errorrecordinginformation'),
            rtl: true,
            type: 'red',
          })
          return false
        }
      })
  }

}

function adultMembersHotelWebservice(currentDate, numAdult, typeApplication, rooms_count) {

  var source_id = $('#source_id').val()
  var is_internal = $('#is_internal').val()

  for (let rooms_number = 1; rooms_number <= rooms_count; rooms_number++) {
    if($(`#source_id`).val() == '17') {
      numAdult = $(`#adultCount${rooms_number}`).val()
    }

    for (let i = 1; i <= numAdult; i++) {
      let number_adult_finally = `${rooms_number}${i}`
      let message_element = $(`#messageA${number_adult_finally}`)
      let name_fa = $(`#nameFaA${number_adult_finally}`)
      let family_fa = $(`#familyFaA${number_adult_finally}`)
      let name_en = $(`#nameEnA${number_adult_finally}`)
      let family_en = $(`#familyEnA${number_adult_finally}`)
      let birthday = $(`#birthdayA${number_adult_finally}`)
      let birthday_en = $(`#birthdayEnA${number_adult_finally}`)
      let national_code = $(`#NationalCodeA${number_adult_finally}`)

      let passenger_nationality = $(`input[name=passengerNationalityA${number_adult_finally}]:checked`)

      let bed_type = $(`#BedType${number_adult_finally}`)
      let passport_number = $(`#passportNumberA${number_adult_finally}`)
      let passport_expiration = $(`#passportExpireA${number_adult_finally}`)

      message_element.html('')
      let gender = $(`#genderA${number_adult_finally} option:selected`).val()
      if ((typeApplication == 'api' || typeApplication == 'externalApi') && gender != 'Male' && gender != 'Female' && gender == '') {
        message_element.html(useXmltag('SpecifyGender'))
        return false
      }
      let hide_passport = false;
      let hide_name = false;

      if(source_id == '17'){
        hide_name = true;
        name_fa.hide();
        family_fa.hide();


        if(is_internal=='1'){
          passport_number.hide();
          passport_expiration.hide();
          hide_passport = true;
        }
      }else{
        hide_name = false;
      }

      /*Start of story*/
      let birth_val = birthday.val()
      if (is_internal =='1') {
        let checking_birthday = birth_val;
        if(passenger_nationality.val() == '1'){
          checking_birthday = birthday_en.val();
        }
        if (
          (name_fa.length > 0 && name_fa.val() == '') ||
          (family_fa.length > 0 && family_fa.val() == '') ||
          checking_birthday == '' ||
          (name_en.length > 0 && name_en.val() == '') ||
          (family_en.length > 0 && family_en.val() == '')
        ) {
          message_element.html(useXmltag('Fillingallfieldsrequired'))
          return false
        }

        if (passenger_nationality.val() == '0') {
          let national_code_value = national_code.val()
          if (national_code_value.length > 0) {
            let CheckEqualNationalCode = getNationalCode(national_code_value, national_code)
            if (CheckEqualNationalCode == false) {
              message_element.html(useXmltag('NationalCodeDuplicate'))
              return false
            }
            let z1 = /^[0-9]*\d$/
            let convertedCode = convertNumber(national_code_value)
            if (!z1.test(convertedCode)) {
              message_element.html(useXmltag('NationalCodeNumberOnly'))
              return false
            } else if ((national_code_value.toString().length != 10)) {

              message_element.html(useXmltag('OnlyTenDigitsNationalCode'))
              return false
            } else {
              let NCode = checkCodeMeli(convertNumber(national_code_value))
              if (!NCode) {
                message_element.html(useXmltag('EnteredCationalCodeNotValid'))
                return false
              }
            }
          } else {
            message_element.html(useXmltag('EnteredCationalCodeNotValid'))
            return false
          }
        }
        //بررسی تاریخ تولد

        if (birthday.length > 0 && birth_val.length > 0) {
          var splitit = birth_val.split('-')
          var JDate = require('jdate')
          var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]])
          var array = $.map(jdate2, function(value, index) {
            return [value]
          })
          var d = new Date(array[0])
          var n = Math.round(d.getTime() / 1000)
          if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
            message_element.html(useXmltag('BirthEnteredNotCorrect'))
            return false
          }
        }

      }

      /*End of local hotel */
      if (is_internal =='0') {
        let checking_birthday = birth_val;
        if(passenger_nationality.val() == '1'){
          checking_birthday = birthday_en.val();
        }
        if (
          (name_fa.length > 0 && name_fa.val() == '') ||
          (family_fa.length > 0 && family_fa.val() == '' ) ||
          checking_birthday == '' ||
          (name_en.length > 0 && name_en.val() == '' ) ||
          (family_en.length > 0 && family_en.val() == '')
        ) {
          message_element.html(useXmltag('Fillingallfieldsrequired'))
          return false
        }

        // if (passenger_nationality.val() == '0') {
        //   let national_code_value = national_code.val()
        //   if (national_code_value.length > 0) {
        //
        //     let CheckEqualNationalCode = getNationalCode(national_code_value, national_code)
        //     if (CheckEqualNationalCode == false) {
        //       message_element.html(useXmltag('NationalCodeDuplicate'))
        //       return false
        //     }
        //
        //     let z1 = /^[0-9]*\d$/
        //     let convertedCode = convertNumber(national_code_value)
        //     if (!z1.test(convertedCode)) {
        //       message_element.html(useXmltag('NationalCodeNumberOnly'))
        //       return false
        //     } else if ((national_code_value.toString().length != 10)) {
        //
        //       message_element.html(useXmltag('OnlyTenDigitsNationalCode'))
        //       return false
        //     } else {
        //       let NCode = checkCodeMeli(convertNumber(national_code_value))
        //       if (!NCode) {
        //         message_element.html(useXmltag('EnteredCationalCodeNotValid'))
        //         return false
        //       }
        //     }
        //   } else {
        //     message_element.html(useXmltag('EnteredCationalCodeNotValid'))
        //     return false
        //   }
        //
        // }

        if ((passport_number.val() == '' || passport_expiration.val() == '') && is_internal != '1') {
          message_element.html(useXmltag('FillingPassportRequired'))
          return false

        }


        //بررسی تاریخ تولد
        if(birthday_en.length > 0) {
          var b = birthday_en.val()
          if (b.length > 0) {
            var date = new Date(t)
            n = Math.round(date.getTime() / 1000)
            if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
              message_element.html(useXmltag('BirthEnteredNotCorrect'))
              return false
            }
          }
        }



        // var National_Code = national_code.val()
        // if (National_Code.length > 0) {
        //
        //   var CheckEqualNationalCode = getNationalCode(National_Code, national_code)
        //   if (CheckEqualNationalCode == false) {
        //     message_element.html(useXmltag('NationalCodeDuplicate'))
        //     return false
        //   }
        //
        //   var z1 = /^[0-9]*\d$/
        //   var convertedCode = convertNumber(National_Code)
        //   if (!z1.test(convertedCode)) {
        //     message_element.html(useXmltag('NationalCodeNumberOnly'))
        //     return false
        //   } else if ((National_Code.toString().length != 10)) {
        //
        //     message_element.html(useXmltag('OnlyTenDigitsNationalCode'))
        //     return false
        //   } else {
        //     var NCode = checkCodeMeli(convertNumber(National_Code))
        //     if (!NCode) {
        //       message_element.html(useXmltag('EnteredCationalCodeNotValid'))
        //       return false
        //     }
        //   }
        // }
        if(lang == 'fa') {
          var t = birthday.val()
          if (t.length > 0) {
            var splitit = t.split('-')
            var JDate = require('jdate')
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]])
            var array = $.map(jdate2, function(value, index) {
              return [value]
            })
            var d = new Date(array[0])
            var n = Math.round(d.getTime() / 1000)
            if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
              message_element.html(useXmltag('BirthEnteredNotCorrect'))
              return false
            }
          }
        }
        //بررسی تاریخ تولد

      }
      /*end of the story */
    }
  }
  return true
}
function adultMembersHotelFlightio(currentDate, numAdult, typeApplication, rooms_count) {

  var source_id = $('#source_id').val()
  var is_internal = $('#is_internal').val()

  for (let rooms_number = 1; rooms_number <= rooms_count; rooms_number++) {
    numAdult = $(`#adultCount${rooms_number}`).val()
    for (let i = 1; i <= numAdult; i++) {
      let number_adult_finally = `${rooms_number}${i}`
      let message_element = $(`#messageA${number_adult_finally}`)
      let name_fa = $(`#nameFaA${number_adult_finally}`)
      let family_fa = $(`#familyFaA${number_adult_finally}`)
      let national_code = $(`#NationalCodeA${number_adult_finally}`)

      let passenger_nationality = $(`input[name=passengerNationalityA${number_adult_finally}]:checked`)

      let bed_type = $(`#BedType${number_adult_finally}`)
      let passport_number = $(`#passportNumberA${number_adult_finally}`)

      message_element.html('')
      let gender = $(`#genderA${number_adult_finally} option:selected`).val()
      if ((typeApplication == 'api' || typeApplication == 'externalApi') && gender != 'Male' && gender != 'Female' && gender == '') {
        message_element.html(useXmltag('SpecifyGender'))
        return false
      }

      /*Start of story*/

      if (is_internal =='1') {

        if (
          (name_fa.length > 0 && name_fa.val() == '') ||
          (family_fa.length > 0 && family_fa.val() == '')
        ) {
          message_element.html(useXmltag('Fillingallfieldsrequired'))
          return false
        }

        if (passenger_nationality.val() == '0') {
          let national_code_value = national_code.val()
          if (national_code_value.length > 0) {
            let CheckEqualNationalCode = getNationalCode(national_code_value, national_code)
            if (CheckEqualNationalCode == false) {
              message_element.html(useXmltag('NationalCodeDuplicate'))
              return false
            }
            let z1 = /^[0-9]*\d$/
            let convertedCode = convertNumber(national_code_value)
            if (!z1.test(convertedCode)) {
              message_element.html(useXmltag('NationalCodeNumberOnly'))
              return false
            } else if ((national_code_value.toString().length != 10)) {

              message_element.html(useXmltag('OnlyTenDigitsNationalCode'))
              return false
            } else {
              let NCode = checkCodeMeli(convertNumber(national_code_value))
              if (!NCode) {
                message_element.html(useXmltag('EnteredCationalCodeNotValid'))
                return false
              }
            }
          } else {
            message_element.html(useXmltag('EnteredCationalCodeNotValid'))
            return false
          }
        }
        //بررسی تاریخ تولد


      }

      /*End of local hotel */
      if (is_internal =='0') {

        if (
          (name_fa.length > 0 && name_fa.val() == '') ||
          (family_fa.length > 0 && family_fa.val() == '' )) {
          message_element.html(useXmltag('Fillingallfieldsrequired'))
          return false
        }


        if ((passport_number.val() == '' && is_internal != '1')) {
          message_element.html(useXmltag('FillingPassportRequired'))
          return false

        }

      }
      /*end of the story */
    }
  }
  return true
}

function childMembersHotelWebservice(currentDate, numChild, typeApplication, count_rooms) {
  var source_id = $('#source_id').val()
  var is_internal = $('#is_internal').val()
  for (let rooms_number = 1; rooms_number <= count_rooms; rooms_number++) {
    if(source_id == '17') {
      numChild = $(`#childCount${rooms_number}`).val()
    }
    for (let i = 1; i <= numChild; i++) {
      let number_child_finaly = `${rooms_number}${i}`
      $('#messageC' + number_child_finaly).html('')
      var gender = ''
      if ($('#genderC' + number_child_finaly).length > 0) {
        gender = $('#genderC' + number_child_finaly + ' option:selected').val()
        if ((typeApplication == 'api' || typeApplication == 'externalApi') && gender != 'Male' && gender != 'Female') {
          $('#messageC' + number_child_finaly).html(useXmltag('SpecifyGender'))
          return false
        }
        if ((typeApplication == 'api' || typeApplication == 'externalApi') && ($('#nameFaC' + number_child_finaly).val() == '' || $('#familyFaC' + number_child_finaly).val() == '')) {

          $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))
          return false
        }
        if (typeApplication == 'externalApi') {

          if ($('#birthdayC' + number_child_finaly).val() == '' && $('#birthdayEnC' + number_child_finaly).val() == '') {
            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }
          if ($('#NameEnC' + number_child_finaly).val() == '') {
            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }
          if ($('#FamilyEnC' + number_child_finaly).val() == '') {
            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }
        }

        if ($('input[name=passengerNationalityC' + number_child_finaly + ']:checked').val() == '1') {

          if ((typeApplication == 'api' || typeApplication == 'externalApi') &&
            ($('#birthdayEnC' + number_child_finaly).val() == '' || $('#passportCountryC' + number_child_finaly).val() == ''
              || $('#passportNumberC' + number_child_finaly).val() == '' || $('#passportExpireC' + number_child_finaly).val() == '')) {

            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }

          //بررسی تاریخ تولد
          var t = $('#birthdayEnC' + number_child_finaly).val()
          if (t.length > 0) {
            var d = new Date(t)
            n = Math.round(d.getTime() / 1000)
            if ((currentDate - n) < 63072000 || 378691200 < (currentDate - n)) { // 12سال =(12*365+3)*24*60*60
              $('#messageC' + number_child_finaly).html(useXmltag('BirthEnteredNotCorrect'))
              return false
            }
          }


        } else {

          if (typeApplication == 'api') {
            if (($('#birthdayC' + number_child_finaly).val() == '' || $('#NationalCodeC' + number_child_finaly).val() == '')) {

              $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))
              return false
            }
          }
          var passport_number = $('#passportNumberC' + number_child_finaly).val()
          if (passport_number == '' && is_internal != '1') {

            $('#messageC' + number_child_finaly).html(useXmltag('FillingPassportRequired'))
            return false

          }

          var National_Code = $('#NationalCodeC' + number_child_finaly).val()
          if (National_Code && National_Code.length > 0) {

            var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeC' + number_child_finaly))

            if (CheckEqualNationalCode == false) {
              $('#messageC' + number_child_finaly).html(useXmltag('NationalCodeDuplicate'))

              return false
            }

            var z1 = /^[0-9]*\d$/
            var convertedCode = convertNumber(National_Code)
            if (!z1.test(convertedCode)) {
              $('#messageC' + number_child_finaly).html(useXmltag('NationalCodeNumberOnly'))
              return false
            } else if ((National_Code.toString().length != 10)) {

              $('#messageC' + number_child_finaly).html(useXmltag('OnlyTenDigitsNationalCode'))
              return false
            } else {
              var NCode = checkCodeMeli(convertNumber(National_Code))
              if (!NCode) {
                $('#messageC' + number_child_finaly).html(useXmltag('EnteredCationalCodeNotValid'))
                return false
              }
            }
          }

          //بررسی تاریخ تولد
          var t = $('#birthdayC' + number_child_finaly).val()
          if (t.length > 0) {
            var splitit = t.split('-')
            var JDate = require('jdate')
            var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]])
            var array = $.map(jdate2, function(value, index) {
              return [value]
            })
            var d = new Date(array[0])
            var n = Math.round(d.getTime() / 1000)
            if ((currentDate - n) < 63072000 || 378691200 < (currentDate - n)) {// 12سال =(12*365+3)*24*60*60
              $('#messageC' + number_child_finaly).html(useXmltag('BirthEnteredNotCorrect'))
              return false
            }
          }
        }
      }
    }
  }
  return true

}
function childMembersHotelFlightio(currentDate, numChild, typeApplication, count_rooms) {

  var source_id = $('#source_id').val()
  var is_internal = $('#is_internal').val()
  for (let rooms_number = 1; rooms_number <= count_rooms; rooms_number++) {

    numChild = $(`#childCount${rooms_number}`).val()

    for (let i = 1; i <= numChild; i++) {
      let number_child_finaly = `${rooms_number}${i}`
      $('#messageC' + number_child_finaly).html('')
      var gender = ''
      if ($('#genderC' + number_child_finaly).length > 0) {

        gender = $('#genderC' + number_child_finaly + ' option:selected').val()
        if ((typeApplication == 'api' || typeApplication == 'externalApi') && gender != 'Male' && gender != 'Female') {
          $('#messageC' + number_child_finaly).html(useXmltag('SpecifyGender'))
          return false
        }

        if ((typeApplication == 'api' || typeApplication == 'externalApi') && ($('#nameFaC' + number_child_finaly).val() == '' || $('#familyFaC' + number_child_finaly).val() == '')) {

          $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))
          return false
        }

        if (typeApplication == 'externalApi') {


          if ($('#NameFaC' + number_child_finaly).val() == '') {
            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }
          if ($('#FamilyFaC' + number_child_finaly).val() == '') {
            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }
        }

          if ($('input[name=passengerNationalityC' + number_child_finaly + ']:checked').val() == '1') {

          if ((typeApplication == 'api' || typeApplication == 'externalApi') && $('#passportNumberC' + number_child_finaly).val() == '' ) {

            $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))

            return false
          }


        } else {

          if (typeApplication == 'api') {
            if (( $('#NationalCodeC' + number_child_finaly).val() == '')) {

              $('#messageC' + number_child_finaly).html(useXmltag('Fillingallfieldsrequired'))
              return false
            }
          }
          var passport_number = $('#passportNumberC' + number_child_finaly).val()
          if (passport_number == '' && is_internal != '1') {

            $('#messageC' + number_child_finaly).html(useXmltag('FillingPassportRequired'))
            return false

          }

          var National_Code = $('#NationalCodeC' + number_child_finaly).val()
          if (National_Code && National_Code.length > 0) {

            var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeC' + number_child_finaly))

            if (CheckEqualNationalCode == false) {

              $('#messageC' + number_child_finaly).html(useXmltag('NationalCodeDuplicate'))

              return false
            }

            var z1 = /^[0-9]*\d$/
            var convertedCode = convertNumber(National_Code)
            if (!z1.test(convertedCode)) {

              $('#messageC' + number_child_finaly).html(useXmltag('NationalCodeNumberOnly'))
              return false
            } else if ((National_Code.toString().length != 10)) {

              $('#messageC' + number_child_finaly).html(useXmltag('OnlyTenDigitsNationalCode'))
              return false
            } else {

              var NCode = checkCodeMeli(convertNumber(National_Code))
              if (!NCode) {
                $('#messageC' + number_child_finaly).html(useXmltag('EnteredCationalCodeNotValid'))
                return false
              }
            }
          }
        }
      }
    }
  }

  return true

}


//todo: review reservation
function adultMembersHotel(currentDate, numAdult, typeApplication) {

  var error = 0
  for (let i = 1; i <= numAdult; i++) {

    $('#messageA' + i).html('')
    var gender = ''
    gender = $('#genderA' + i + ' option:selected').val()


    if ((typeApplication == 'api' || typeApplication == 'externalApi' || typeApplication == 'reservation') && gender != 'Male' && gender != 'Female') {
      $('#messageA' + i).html(useXmltag('SpecifyGender'))
      error = 1
    }

    if ((typeApplication == 'api' || typeApplication == 'externalApi' || typeApplication == 'reservation') && ($('#nameFaA' + i).val() == '' || $('#familyFaA' + i).val() == '')) {

      $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
      error = 1
    }

    if (typeApplication == 'api') {

      if ($('#BedType' + i).val() != 'Double' && $('#BedType' + i).val() != 'Twin') {
        $('#messageA' + i).html(useXmltag('PleaseSelectFlatLayoutType'))
        error = 1
      }


      if ($('#ZoneFlight').val() != 'Local') {
        if ($('#passportNumberA' + i).val() == '' || $('#passportExpireA' + i).val() == '') {
          $('#messageA' + i).html(useXmltag('FillingPassportRequired'))
          error = 1
        }
      }


    }
    else if (typeApplication == 'externalApi') {

      if ($('#birthdayA' + i).val() == '') {
        $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
        error = 1
      }
      if ($('#NameEnA' + i).val() == '') {
        $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
        error = 1
      }
      if ($('#FamilyEnA' + i).val() == '') {
        $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
        error = 1
      }
    }


    if ($('input[name=passengerNationalityA' + i + ']:checked').val() == '1') {

      if ((typeApplication == 'api' || typeApplication == 'externalApi' || typeApplication == 'reservation') &&
        ($('#birthdayEnA' + i).val() == '' || $('#passportCountryA' + i).val() == ''
          || $('#passportNumberA' + i).val() == '' || $('#passportExpireA' + i).val() == '')) {
        $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
        error = 1
      }

      //بررسی تاریخ تولد
      var t = $('#birthdayEnA' + i).val()
      if (t.length > 0) {
        var d = new Date(t)
        n = Math.round(d.getTime() / 1000)
        if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
          $('#messageA' + i).html(useXmltag('BirthEnteredNotCorrect'))
          error = 1
        }
      }


    } else {

      if (typeApplication == 'api' || typeApplication == 'reservation') {
        if ($('#birthdayA' + i).val() == '' || $('#NationalCodeA' + i).val() == '') {
          $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
          error = 1
        }
      }

      var National_Code = $('#NationalCodeA' + i).val()
      if (National_Code.length > 0) {

        var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeA' + i))
        if (CheckEqualNationalCode == false) {
          $('#messageA' + i).html(useXmltag('NationalCodeDuplicate'))
          error = 1
        }

        var z1 = /^[0-9]*\d$/
        var convertedCode = convertNumber(National_Code)
        if (!z1.test(convertedCode)) {
          $('#messageA' + i).html(useXmltag('NationalCodeNumberOnly'))
          error = 1
        } else if ((National_Code.toString().length != 10)) {

          $('#messageA' + i).html(useXmltag('OnlyTenDigitsNationalCode'))
          error = 1
        } else {
          var NCode = checkCodeMeli(convertNumber(National_Code))
          if (!NCode) {
            $('#messageA' + i).html(useXmltag('EnteredCationalCodeNotValid'))
            error = 1
          }
        }
      }

      //بررسی تاریخ تولد
      var t = $('#birthdayA' + i).val()
      if (t.length > 0) {
        var splitit = t.split('-')
        var JDate = require('jdate')
        var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]])
        var array = $.map(jdate2, function(value, index) {
          return [value]
        })
        var d = new Date(array[0])
        var n = Math.round(d.getTime() / 1000)
        if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
          $('#messageA' + i).html(useXmltag('BirthEnteredNotCorrect'))
          error = 1
        }
      }

    }

  }


  if (error == 0) {
    return 'true'
  } else {
    return 'false'
  }
}

function childMembersHotel(currentDate, numChild, typeApplication) {

  var error = 0
  for (let i = 1; i <= numChild; i++) {

    $('#messageC' + i).html('')
    var gender = ''
    if ($('#genderC' + i).length > 0) {
      gender = $('#genderC' + i + ' option:selected').val()


      if ((typeApplication == 'api' || typeApplication == 'externalApi') && gender != 'Male' && gender != 'Female') {
        $('#messageC' + i).html(useXmltag('SpecifyGender'))
        error = 1
      }

      if ((typeApplication == 'api' || typeApplication == 'externalApi') && ($('#nameFaC' + i).val() == '' || $('#familyFaC' + i).val() == '')) {

        $('#messageC' + i).html(useXmltag('Fillingallfieldsrequired'))
        error = 1
      }
      if (typeApplication == 'externalApi') {

        if ($('#birthdayC' + i).val() == '') {
          $('#messageC' + i).html(useXmltag('Fillingallfieldsrequired'))
          error = 1
        }
        if ($('#NameEnC' + i).val() == '') {
          $('#messageC' + i).html(useXmltag('Fillingallfieldsrequired'))
          error = 1
        }
        if ($('#FamilyEnC' + i).val() == '') {
          $('#messageC' + i).html(useXmltag('Fillingallfieldsrequired'))
          error = 1
        }
      }


      if ($('input[name=passengerNationalityC' + i + ']:checked').val() == '1') {

        if ((typeApplication == 'api' || typeApplication == 'externalApi') &&
          ($('#birthdayEnC' + i).val() == '' || $('#passportCountryC' + i).val() == ''
            || $('#passportNumberC' + i).val() == '' || $('#passportExpireC' + i).val() == '')) {
          $('#messageC' + i).html(useXmltag('Fillingallfieldsrequired'))
          error = 1
        }

        //بررسی تاریخ تولد
        var t = $('#birthdayEnC' + i).val()
        if (t.length > 0) {
          var d = new Date(t)
          n = Math.round(d.getTime() / 1000)
          if ((currentDate - n) < 63072000 || 378691200 < (currentDate - n)) { // 12سال =(12*365+3)*24*60*60
            $('#messageC' + i).html(useXmltag('BirthEnteredNotCorrect'))
            error = 1
          }
        }


      } else {

        if (typeApplication == 'api') {
          if ($('#birthdayA' + i).val() == '' || $('#NationalCodeA' + i).val() == '') {
            $('#messageA' + i).html(useXmltag('Fillingallfieldsrequired'))
            error = 1
          }
        }

        var National_Code = $('#NationalCodeA' + i).val()
        if (National_Code.length > 0) {

          var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCodeA' + i))
          if (CheckEqualNationalCode == false) {
            $('#messageA' + i).html(useXmltag('NationalCodeDuplicate'))
            error = 1
          }

          var z1 = /^[0-9]*\d$/
          var convertedCode = convertNumber(National_Code)
          if (!z1.test(convertedCode)) {
            $('#messageA' + i).html(useXmltag('NationalCodeNumberOnly'))
            error = 1
          } else if ((National_Code.toString().length != 10)) {

            $('#messageA' + i).html(useXmltag('OnlyTenDigitsNationalCode'))
            error = 1
          } else {
            var NCode = checkCodeMeli(convertNumber(National_Code))
            if (!NCode) {
              $('#messageA' + i).html(useXmltag('EnteredCationalCodeNotValid'))
              error = 1
            }
          }
        }

        //بررسی تاریخ تولد
        var t = $('#birthdayA' + i).val()
        if (t.length > 0) {
          var splitit = t.split('-')
          var JDate = require('jdate')
          var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]])
          var array = $.map(jdate2, function(value, index) {
            return [value]
          })
          var d = new Date(array[0])
          var n = Math.round(d.getTime() / 1000)
          if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
            $('#messageA' + i).html(useXmltag('BirthEnteredNotCorrect'))
            error = 1
          }
        }
      }
    }

  }


  if (error == 0) {
    return 'true'
  } else {
    return 'false'
  }
}


function leaderRoomForHotel(typeApplication) {

  $('#messagePassengerLeader').html('')

  if ($('#passenger_leader_room_fullName').val() == '') {
    $('#messagePassengerLeader').html(useXmltag('PleaseEnterFullNamePassengers'))
    return false
  } else if ($('#passenger_leader_room').val() == '') {
    $('#messagePassengerLeader').html(useXmltag('PleaseEnterMobilePassengers'))
    return false
  } else {
    return true
  }

  if ($('#email').val() == '' || $('#cellphoneNumber').val() == ''
    || $('#phoneNumber').val() == '' || $('#address').val() == '') {
    $('#messagePassengerLeader').html(useXmltag('Fillingallfieldsrequired'))
    return false
  } else {
    return true
  }
}

function addCommas(nStr) {
  nStr += ''
  x = nStr.split('.')
  x1 = x[0]
  x2 = x.length > 1 ? '.' + x[1] : ''
  var rgx = /(\d+)(\d{3})/
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2')
  }
  return x1 + x2
}

function ReserveTemprory(factorNumber, typeApplication) {

  if (!$('#RulsCheck').is(':checked')) {
    $.alert({
      title: useXmltag('Reservationhotel'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('ConfirmTermsFirst'),
      rtl: true,
      type: 'red',
    })
    return false
  }

  $('#final_ok_and_insert_passenger').text(useXmltag('Pending')).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress')

  $('#loader_check').css('display', 'block')

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      factorNumber: factorNumber,
      typeApplication: typeApplication,
      flag: 'HotelReserve',
    },
    function(data) {

      if (data.indexOf('error invalid SESSION') > -1) {

        $('#messageBook').html(data)

      } else {

        var obj = jQuery.parseJSON(data)

        if (obj['book'] == 'yes') {

          $('#total_price').val(obj['total_price'])

          if (obj['type_application'] == 'api') {

            $('#RequestNumber').val(obj['RequestNumber'])
            $('#RequestPNR').val(obj['RequestPNR'])

          }

          setTimeout(function() {
            $('#final_ok_and_insert_passenger').removeAttr('onclick').attr('disabled', true).css('cursor', 'not-allowed').text(useXmltag('Accepted'))

            $('.main-pay-content').css('display', 'flex')
            $('#loader_check').css('display', 'none')
            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow')
          }, 2000)


        } else if (obj['book'] == 'OnRequest') {

          if (obj['user_type'] == '5') {

            $('.counter').counter({})
            $('#timeConfirmHotel').val('yes')
            timeForConfirmHotel()

            $('#onRequestOnlinePassenger').removeClass('displayN')
            $('#btn-final-Reserve').addClass('displayN')
            $('#showFactorNumber').html(useXmltag('Invoicenumber') + ': ' + obj['factor_number'])

          } else {

            $('#onRequest').removeClass('displayN')
            $('#btn-final-Reserve').addClass('displayN')
            $('#showFactorNumber').html(useXmltag('Invoicenumber') + ': ' + obj['factor_number'])

          }


        } else if (obj['book'] == 'no') {

          $('#messageBook').html(useXmltag('ThisHotelCanNotBooked'))

          setTimeout(function() {
            $('#final_ok_and_insert_passenger').css('background-color', 'red').text(useXmltag('Errorconfirmation'))
          }, 1000)

        }


      }


    })


}

function showTypePayment(factorNumber, typeApplication, typeTrip, paymentPrice, serviceType, currencyCode, currencyEquivalent) {

  $('#payBankButton').html('')

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'hotel_ajax.php',
    dataType: 'JSON',
    data:
      {
        flag: 'createPayButton',
        factorNumber: factorNumber,
        typeApplication: typeApplication,
        typeTrip: typeTrip,
        paymentPrice: paymentPrice,
        serviceType: serviceType,
        currencyCode: currencyCode,
        currencyEquivalent: currencyEquivalent,
      },
    success: function(response) {

      if (currencyCode > 0) {
        $('#payCurrencyButton').html(response.result_currency)
        $('#currencyBanks').css('display', 'block')
      } else {
        $('#payBankButton').html(response.result_bank)
        $('#railBanks').css('display', 'block')
      }

      $('#payCreditButton').html(response.result_credit)

      $('.main-pay-content').css('display', 'flex')
      $('#loader_check').css('display', 'none')
      $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow')

    },
  })

}

function SelectTypeRoom(typeRom, count) {
  var twoBedUser = useXmltag('Twobeduser')
  var oneBedUser = useXmltag('Onebeduser')
  if (typeRom == 'Double') {
    $('#dropbtnSelectRoom' + count).html(twoBedUser)
  } else {
    $('#dropbtnSelectRoom' + count).html(oneBedUser)
  }
  $('#BedType' + count).val(typeRom)
}


function modalListForHotel(factorNumber) {
  $('.loaderPublicForHotel').fadeIn(700)
  setTimeout(function() {
    $('.loaderPublicForHotel').fadeOut(500)
    $('#ModalPublic').fadeIn(700)
  }, 3000)

  $.post(libraryPath + 'ModalCreatorForHotel.php',
    {
      Controller: 'user',
      Method: 'ModalShow',
      Param: factorNumber,
    },
    function(data) {
      $('#ModalPublicContent').html(data)
    })

}

function SendHotelEmailForOther() {

  $('#loaderTracking').fadeIn(500)
  $('#SendEmailForOther').attr('disabled', 'disabled')
  var email = $('#SendForOthers').val()
  var factorNumber = $('#factorNumber').val()
  var typeApplication = $('#typeApplication').val()

  var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/
  $('#SendForOthers').focus(function() {
    $('#SendForOthers').css('background', 'white')
  })

  if (email == '') {
    $('#SendForOthers').css('background', 'red')

    $.alert({
      title: useXmltag('Sendemail'),
      icon: 'fa fa-times',
      content: useXmltag('Pleaseenteremailaddress'),
      rtl: true,
      type: 'red',
    })

  } else if (!emailReg.test(email)) {
    $('#SendForOthers').css('background', 'red')

    $.alert({
      title: useXmltag('Sendemail'),
      icon: 'fa fa-times',
      content: useXmltag('Pleaseenteremailcorrectformat'),
      rtl: true,
      type: 'red',
    })
  } else {
    $.post(amadeusPath + 'hotel_ajax.php',
      {
        email: email,
        factor_number: factorNumber,
        typeApplication: typeApplication,
        flag: 'SendHotelEmailForOther',
      },
      function(data) {

        var res = data.split(':')
        if (data.indexOf('success') > -1) {
          $.alert({
            title: useXmltag('Sendemail'),
            icon: 'fa fa-check',
            content: res[1],
            rtl: true,
            type: 'green',
          })
          setTimeout(function() {
            $('#ModalSendEmail').fadeOut(700)
            $('#loaderTracking').fadeOut(500)
            $('#SendEmailForOther').attr('disabled', false)
            $('#SendForOthers').val(' ')
          }, 1000)

        } else {
          $.alert({
            title: useXmltag('Sendemail'),
            icon: 'fa fa-times',
            content: res[1],
            rtl: true,
            type: 'red',
          })
          $('#SendEmailForOther').attr('disabled', false)
          $('#loaderTracking').fadeOut(500)


        }

      })
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////Reservation///////////////////////////////////////////////////
function checkForReserve(idRoom) {
  var idHotel = $('#idHotel_reserve').val()
  var startDate = $('#startDate_reserve').val()
  var endDate = $('#endDate_reserve').val()

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      idRoom: idRoom,
      idHotel: idHotel,
      startDate: startDate,
      endDate: endDate,
      flag: 'checkForReserve',
    },
    function(data) {

      if (data.indexOf('success') > -1) {

        calculateRoomPricesForReservation(idRoom)

      } else {

        $.alert({
          title: useXmltag('Reservationhotel'),
          icon: 'fa fa-cart-plus',
          content: useXmltag('NoavailableReserveRoom'),
          rtl: true,
          type: 'red',
        })
        $('#RoomCount' + idRoom).prop('disabled', 'disabled')
      }


    })

}

function calculateRoomPricesForReservation(idRoom) {

  var RoomCount = $('#RoomCount' + idRoom).val()
  var TypeRoomHotel = $('#TypeRoomHotel').val()

  var CostkolHotelRoomEXT = $('#CostkolHotelRoom_EXT' + idRoom).val()
  var CostkolHotelRoomCHD = $('#CostkolHotelRoom_CHD' + idRoom).val()
  var CostkolHotelRoomDBL = $('#CostkolHotelRoom_DBL' + idRoom).val()


  var CostkolHotelRoomEXTToShow = $('#CostkolHotelRoom_EXT' + idRoom).data('amount')
  var CostkolHotelRoomCHDToShow = $('#CostkolHotelRoom_CHD' + idRoom).data('amount')
  var CostkolHotelRoomDBLToShow = $('#CostkolHotelRoom_DBL' + idRoom).data('amount')
  var currencyUnit = $('#CostkolHotelRoom_EXT' + idRoom).data('unit')

  optionExtraBed(idRoom, RoomCount)
  // var PrePrice = $('#prepaymentPercentage' + idRoom).data('unit')
  var prepayment_percentage = $('#prepaymentPercentage').data('amount')
  var price = parseInt(RoomCount) * parseInt(CostkolHotelRoomDBL)
  var priceToShow = parseInt(RoomCount) * CostkolHotelRoomDBLToShow
  var count = parseInt(RoomCount)
  final_prepayment_package_price=((price*prepayment_percentage)/100)

  // alert(final_prepayment_package_price)

  //////تخت اضافه//
  var ExtraBed = $('#ExtraBed' + idRoom).val()
  var ExtraChildBed = $('#ExtraChildBed' + idRoom).val()
  if (ExtraBed > 0) {
    price = parseInt(price) + (parseInt(ExtraBed) * parseInt(CostkolHotelRoomEXT))
    priceToShow = priceToShow + (parseInt(ExtraBed) * CostkolHotelRoomEXTToShow)
  }
  if (ExtraChildBed > 0) {

    price = parseInt(price) + (parseInt(ExtraChildBed) * parseInt(CostkolHotelRoomCHD))
    priceToShow = priceToShow + (parseInt(ExtraChildBed) * CostkolHotelRoomCHDToShow)
  }

  $('#FinalRoomCount_Reserve' + idRoom).val(count)
  $('#FinalPriceRoom_Reserve' + idRoom).val(price)
  $('#FinalPriceRoom_Reserve' + idRoom).data('amount', priceToShow)

  var priceHotel = 0
  var priceHotelToShow = 0
  var countHotel = 0
  var resultIdRoom = TypeRoomHotel.split('/')

  for (i = 0; i < resultIdRoom.length; i++) {

    if ($('#FinalRoomCount_Reserve' + resultIdRoom[i]).val() > 0) {
      priceHotel = parseInt(priceHotel) + parseInt($('#FinalPriceRoom_Reserve' + resultIdRoom[i]).val())
      priceHotelToShow = priceHotelToShow + $('#FinalPriceRoom_Reserve' + resultIdRoom[i]).data('amount')
      countHotel = parseInt(countHotel) + parseInt($('#FinalRoomCount_Reserve' + resultIdRoom[i]).val())
    }
  }

  $('.roomFinalTxt').html(countHotel + ' ' + useXmltag('Selectedroom'))
  $('.roomFinalPrice').html(number_format(priceHotelToShow) + ' ' + currencyUnit)
    $('.roomFinalPrepaymentPackagePrice').html(number_format(final_prepayment_package_price) + ' ' + currencyUnit )
    // $('.roomFinalPrepaymentPackage').html(PrePrice + ' (' + prepayment_percentage + ' % )')

  $('#btnReserve').attr('disabled', false)

  if(final_prepayment_package_price <= 0){
    $('.roomFinalPrepaymentPackagePrice').css({display: 'none'});
    // $('.roomFinalPrepaymentPackage').css({display: 'none'});

  }else{
    $('.roomFinalPrepaymentPackagePrice').css({display: 'block'});
    // $('.roomFinalPrepaymentPackage').css({display: 'block'});

  }

}

//end function calculateRoomPricesForReservation

function optionExtraBed(idRoom, countRoom) {

  var countExtraBeds = parseInt($('#maximum_extra_beds' + idRoom).val()) * countRoom
  var countExtraChdBeds = parseInt($('#maximum_extra_chd_beds' + idRoom).val()) * countRoom

  /*if (countExtraBeds>0){
        var optionExt = '<option value="">تخت</option>';
        for (i = 1; i <= countExtraBeds; i++) {
            optionExt += '<option value="' + i + '">' + i + '</option>';
        }
        $("#ExtraBed" + idRoom).html(optionExt);
        $("#ExtraBed" + idRoom).prop("disabled", false);
    }
    if (countExtraChdBeds>0){
        var optionExtChd = '<option value="">تخت</option>';
        for (i = 1; i <= countExtraChdBeds; i++) {
            optionExtChd += '<option value="' + i + '">' + i + '</option>';
        }
        $("#ExtraChildBed" + idRoom).html(optionExtChd);
        $("#ExtraChildBed" + idRoom).prop("disabled", false);
    }*/

  var optionExt = '<option value="">' + useXmltag('Extrabed') + '</option>'
  var selected_value =  $('#ExtraBedRoom' + idRoom).val()
  if (countExtraBeds > 0) {

    for (i = 1; i <= countExtraBeds; i++) {
      var text = i + useXmltag('Adult')
      var value = 'E:' + i
      var if_selected = value == selected_value ? 'selected' : '';
      optionExt += '<option value="' + value + '" '+if_selected+'>' + text + '</option>'
    }

  }
  var extra_child_from_age =  $('#extra_child_from_age' + idRoom).val()
  var extra_child_to_age =  $('#extra_child_to_age' + idRoom).val()

  if(!extra_child_from_age){
    extra_child_from_age = 0 ;
  }
  if(!extra_child_to_age){
    extra_child_to_age = 0 ;
  }
  if (countExtraChdBeds > 0) {

    for (j = 1; j <= countExtraChdBeds; j++) {
      if(extra_child_from_age == 0 && extra_child_to_age == 0 ) {
        var text = j + useXmltag('Child')
      }else{
        var text = j + translateXmlByParams('HotelExtraChildBed', {'from': extra_child_from_age ,'to': extra_child_to_age })
      }

      var value = 'CH:' + j
      var if_selected = value == selected_value ? 'selected' : '';
      optionExt += '<option value="' + value + '" '+if_selected+'>' + text + '</option>'
    }

  }
  if (countExtraBeds > 0 && countExtraChdBeds > 0) {
    if(extra_child_from_age == 0 && extra_child_to_age == 0 ) {
      var childText =  useXmltag('Child')
    }else{
      var childText =  translateXmlByParams('HotelExtraChildBed', {'from': extra_child_from_age ,'to': extra_child_to_age })
    }
    for (i = 1; i <= countExtraBeds; i++) {
      for (j = 1; j <= countExtraChdBeds; j++) {
        var text = i + useXmltag('Adult') + ' - ' + j + childText
        var value = 'E:' + i + '-' + 'CH:' + j
        var if_selected = value == selected_value ? 'selected' : '';
        optionExt += '<option value="' + value + '" '+if_selected+'>' + text + '</option>'
      }
    }

  }
  $('#ExtraBedRoom' + idRoom).html(optionExt)



}

function calculateExtraBedCount(idRoom) {

  var countExtraBed = $('#ExtraBedRoom' + idRoom).val()

  if (countExtraBed.indexOf('-') > -1) {

    var result = countExtraBed.split('-')
    var countExtra = result[0].split(':')
    var countExtraChild = result[1].split(':')
    var extra = countExtra[1]
    var extraChild = countExtraChild[1]
  } else {

    var countExtra = countExtraBed.split(':')
    if (countExtraBed.indexOf('E') > -1) {
      var extra = countExtra[1]
      var extraChild = 0
    } else {
      var extra = 0
      var extraChild = countExtra[1]
    }

  }

  $('#ExtraBed' + idRoom).val(extra)
  $('#ExtraChildBed' + idRoom).val(extraChild)

  calculateRoomPricesForReservation(idRoom)

}


function statusConfirmHotel(factorNumber) {

  var status = ''
  $(':radio').each(function() {
    var myval = $(this).prop('checked')
    if (myval == true) {
      status = $(this).val()
    }

  })

  var codeConfirmHotel = $('#codeConfirmHotel').val()
  var commentConfirmHotel = $('#commentConfirmHotel').val()

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      codeConfirmHotel: codeConfirmHotel,
      commentConfirmHotel: commentConfirmHotel,
      status: status,
      factorNumber: factorNumber,
      flag: 'ConfirmHotel',
    },
    function(data) {

      var res = data.split(':')

      if (data.indexOf('success') > -1) {

        $('#messageBook').html(res[1])
        $('#messageBook').css('color', 'green')

      } else {

        $('#messageBook').html(res[1])
        $('#messageBook').css('color', 'red')
      }
    })


}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////End Reservation///////////////////////////////////////////////


function searchRoomsString(countRoom) {
  var searchRooms = ''
  for (i = 1; i <= countRoom; i++) {
    var adult = parseInt($('#adult' + i).val())
    child = parseInt($('#child' + i).val())
    if (adult > 0) {
      searchRooms = searchRooms + 'R:' + adult
      if (child > 0) {
        searchRooms = searchRooms + '-' + child
        for (j = 1; j <= child; j++) {
          child = $('#childAge' + i + j).val()
          if (j == 1 && child != undefined) {
            searchRooms = searchRooms + '-' + child
          } else if (child != undefined) {
            searchRooms = searchRooms + ',' + child
          }
        }
      } else {
        searchRooms = searchRooms + '-0-0'
      }
    } else {
      $.alert({
        title: useXmltag('Reservationhotel'),
        icon: 'fa fa-cart-plus',
        content: useXmltag('LeastOneAdult'),
        rtl: true,
        type: 'red',
      })
      return ''
    }
  }
  return searchRooms
}

////////////// reservation external hotel ///////////////
function submitSearchExternalHotel() {
  $('#hotelResult').html('')
  $('.loader-for-external-hotel-end').show()
  $('#city_name_fa').html('')
  var country = $('#destination_country').val()
  var city = $('#destination_city').val()
  var start_date = $('#startDateForeign').val()
  var end_date = $('#endDateForeign').val()
  var staying_time = 1
  var staying_time_element = $('#stayingTimeForeign')
  var type = $('#type').val()
  var nationality = $('#nationality').val()

  if (staying_time_element.length > 0) {
    staying_time = staying_time_element.val()
  } else {
    staying_time = $('#stayingTime').val()
  }

  var countRoom = $('#countRoom').val()


  var i
  var j
  var searchRooms = searchRoomsString(countRoom)



  if (country == '' || city == '' || start_date == '' || end_date == '' || searchRooms == '') {

    $.alert({
      title: useXmltag('Reservationhotel'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('Pleaseenterrequiredfields'),
      rtl: true,
      type: 'red',
    })
  } else {
    let address = ''
    if (typeof type != 'undefined' && type == 'new') {
      address = `${amadeusPathByLang}resultExternalHotel?type=new&&nationality=${nationality}&country=${country}&city=${city}&start_date=${start_date}&end_date=${end_date}&nights=${staying_time}&rooms=${searchRooms}`
    } else {
      address = `${amadeusPathByLang}resultExternalHotel/${country}/${city}/${start_date}/${end_date}/${staying_time}/${searchRooms}`
    }

    // return false;
    window.location.href = address
    /*        $('#searchRooms').val(searchRooms);
                $('#typeApplication').val('externalApi');
                $.post(amadeusPath + 'external_hotel_ajax.php',
                    {
                        flag: 'getNumberOfRoomsExternalHotelRequested',
                        searchRooms: searchRooms
                    },
                    function (data) {

                        window.history.pushState({path: url}, "", url);
                        if (fromDetail == true) {
                            location.reload();
                        }

                        /!* *** List of hotels for preview alaki *** *!/
                        // getResultExternalHotelPreview(country, city, start_date, staying_time);

                        /!* *** List of hotels *** *!/
                        getResultExternalHotelSearch(country, city, start_date, staying_time, data);
                    });*/
  }

}


function externalHotelDetail(typeApplication, hotelId, hotelNameEn) {
  if (typeApplication == 'externalApi') {
    var href = amadeusPathByLang + 'roomExternalHotel/' + typeApplication + '/' + hotelId + '/' + hotelNameEn
  } else {
    var href = amadeusPathByLang + 'roomHotelLocal/' + typeApplication + '/' + hotelId + '/' + hotelNameEn
  }
  $('#typeApplication').val(typeApplication)
  $('#formHotel').attr('action', href).submit()
}

function reserveExternalHotel(id) {

  $('#roomId').val(id)

  $('#img-' + id).show()
  $('#btnReserve-' + id).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag('Pending'))

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      flag: 'CheckedLogin',
    },
    function(data) {

      if (data.indexOf('successLoginHotel') > -1) {

        buyExternalHotelWithoutRegister()

      } else if (data.indexOf('errorLoginHotel') > -1) {

        var isShowLoginPopup = $('#isShowLoginPopup').val()
        var useTypeLoginPopup = $('#useTypeLoginPopup').val()
        if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
          $('#login-popup').trigger('click')
        } else {
          popupBuyNoLogin(useTypeLoginPopup)
        }

      }

    })

}

function buyExternalHotelWithoutRegister() {

  let hotelId = $('#hotelId').val()
  let roomId = $('#roomId').val()
  let searchId = $('#searchIdApi').val()
  let loginId = $('#loginIdApi').val()
  let startDate = $('#startDate').val()
  let endDate = $('#endDate').val()
  let nights = $('#nights').val()
  let searchRooms = $('#searchRooms').val()
  let typeApplication = $('#typeApplication').val()

  $.post(amadeusPath + 'hotel_ajax.php',

    {
      hotelId: hotelId,
      roomId: roomId,
      searchId: searchId,
      loginId: loginId,
      startDate: startDate,
      endDate: endDate,
      nights: nights,
      searchRooms: searchRooms,
      typeApplication: typeApplication,
      flag: 'setTemproryExternalHotel',
    },
    function(data) {

      if (data.indexOf('success') > -1) {

        let result = data.split(':')
        $('#factorNumber').val(result[1])
        let href = $('#href').val()

        $('#formExternalHotelReserve').attr('action', amadeusPathByLang + href)
        $('#formExternalHotelReserve').submit()

      } else if (data.indexOf('error') > -1) {

        $.alert({
          title: useXmltag('Reservationhotel'),
          icon: 'fa fa-trash',
          content: useXmltag('PleaseAgainBookingHotel'),
          rtl: true,
          type: 'red',
        })

      }

    })

}

// kolahi
function HotelPopular(e){
  $('#listSearchCity').html("");
  $('#listSearchCity').html(`<h2>${useXmltag('Popularhotels')}</h2>`);
  setTimeout(function() {
    $.post(amadeusPath + 'hotel_ajax.php',
      {
        flag: e === 'externalHotel' ? 'flightExternalRoutesDefault' : 'popularCityForInternalHotel' ,
        self_Db: true,
      },
      function(data) {
        JSON.parse(data).forEach((index) => {
          if (lang === 'en' ||lang === 'ar' ){
            if(e === 'externalHotel'){
              let indexCountry;
              if(index.CountryEn !== null){
                indexCountry = index.CountryEn
              }else if(index.CountryFa !== null){
                indexCountry = index.CountryFa
              } else {
                indexCountry = " "
              }
              document.querySelector('#listSearchCity').innerHTML+=
                `<li onclick="selectCity(event , '${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityEn}','${index.DepartureCode}')"> 
                   <i class="div_c_sr_i">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                  </i>
                   <div class="div_c_sr">
                      <span class="c-text">
                        ${index.DepartureCityEn}
                      </span>
                      <div class="yata_gdemo">
                        <i>${indexCountry}</i>
                      </div>
                   </div>
                  </li>`;
            } else if(e === 'hotel') {
              document.querySelector('#listSearchCity').innerHTML+=
                `<li onclick="selectCity_internal('${index.id}','${index.city_name_en}')"> 
             <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
            </i>
             <div class="div_c_sr">
               <span class="c-text">
                  ${index.city_name_en}
               </span>
             </div>
           </li>`
            }
          } else if(lang == 'fa'){
            if(e === 'externalHotel'){
              let indexCountry;
              if(index.CountryFa !== null){
                indexCountry = index.CountryFa
              }else if(index.CountryEn !== null){
                indexCountry = index.CountryEn
              } else {
                indexCountry = " "
              }
              document.querySelector('#listSearchCity').innerHTML+=
                `<li onclick="selectCity(event , '${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityFa}','${index.DepartureCode}')"> 
                   <i class="div_c_sr_i">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                  </i>
                   <div class="div_c_sr">
                      <span class="c-text">
                        ${index.DepartureCityFa}
                      </span>
                      <div class="yata_gdemo">
                        <i>${indexCountry}</i>
                      </div>
                   </div>
                  </li>`;
            } else if(e === 'hotel') {
              document.querySelector('#listSearchCity').innerHTML+=
                `<li onclick="selectCity_internal('${index.id}','${index.city_name}')"> 
             <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
            </i>
             <div class="div_c_sr">
               <span class="c-text">
                  ${index.city_name}
               </span>
             </div>
           </li>`
            }
          }
        })
        $('#listSearchCity').removeClass('displayiN')
      })
  },10)
}
function hotelNothingFound(){
  $('#listSearchCity').html("");
  $('#listSearchCity').html(`
              <li class="listSearchCity_li listSearchCity_li_err"> 
               <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 351.1C218.8 351.1 192.8 369.5 177.6 385.9C168.7 395.6 153.5 396.3 143.7 387.3C133.1 378.3 133.4 363.1 142.4 353.4C164.3 329.5 202.3 303.1 256 303.1C309.7 303.1 347.7 329.5 369.6 353.4C378.6 363.1 378 378.3 368.3 387.3C358.5 396.3 343.3 395.6 334.4 385.9C319.2 369.5 293.2 351.1 256 351.1V351.1zM208.4 208C208.4 225.7 194 240 176.4 240C158.7 240 144.4 225.7 144.4 208C144.4 190.3 158.7 176 176.4 176C194 176 208.4 190.3 208.4 208zM304.4 208C304.4 190.3 318.7 176 336.4 176C354 176 368.4 190.3 368.4 208C368.4 225.7 354 240 336.4 240C318.7 240 304.4 225.7 304.4 208zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg>
               </i>
               <div class="div_c_sr">
                 <span class="c-text">
                    ${useXmltag('NothingFound')}
                 </span>
               </div>
             </li>`)
}
function hotelEnterThreeLetters(){
  $('#listSearchCity').html("");
  $('#listSearchCity').html(`
              <li class="EnterThreeLetters_li listSearchCity_li_err"> 
               <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M81.84 152.1C77.43 156.9 71.21 159.8 64.63 159.1C58.05 160.2 51.69 157.6 47.03 152.1L7.029 112.1C-2.343 103.6-2.343 88.4 7.029 79.03C16.4 69.66 31.6 69.66 40.97 79.03L63.08 101.1L118.2 39.94C127 30.09 142.2 29.29 152.1 38.16C161.9 47.03 162.7 62.2 153.8 72.06L81.84 152.1zM81.84 312.1C77.43 316.9 71.21 319.8 64.63 319.1C58.05 320.2 51.69 317.6 47.03 312.1L7.029 272.1C-2.343 263.6-2.343 248.4 7.029 239C16.4 229.7 31.6 229.7 40.97 239L63.08 261.1L118.2 199.9C127 190.1 142.2 189.3 152.1 198.2C161.9 207 162.7 222.2 153.8 232.1L81.84 312.1zM216 120C202.7 120 192 109.3 192 96C192 82.75 202.7 72 216 72H488C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H216zM192 256C192 242.7 202.7 232 216 232H488C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H216C202.7 280 192 269.3 192 256zM160 416C160 402.7 170.7 392 184 392H488C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416zM64 448C46.33 448 32 433.7 32 416C32 398.3 46.33 384 64 384C81.67 384 96 398.3 96 416C96 433.7 81.67 448 64 448z"/></svg>
               </i>
               <div class="div_c_sr">
                 <span class="c-text">
                    ${useXmltag('EnterThreeLetters')}
                 </span>
               </div>
             </li>`)
}
function hotelLoader(){
  $('#listSearchCity').html("");
  $('#listSearchCity').html(`
              <li class="hotelLoader_li"> 
                <div class="flight_loading_div">
                      <div class="flight_loading_div_loading"><div id="loading-spinner"></div></div>
                      <div class="loading-line"></div>
                </div>
              </li>`)
}
function openBoxPopular(e){

  HotelPopular(e);
  $("#autoComplateSearchIN,#destination_city,#destination_country,#autoComplateSearchIN_hidden").val("")
}
function searchCity(e) {
  let autoComplateSearchIN = $('#autoComplateSearchIN').val()
  if(autoComplateSearchIN.length == 0) {
    HotelPopular()
  }
  if(autoComplateSearchIN.length < 3){
    hotelEnterThreeLetters()
  }
  else if (autoComplateSearchIN.length > 2) {
    hotelLoader()
    setTimeout(()=>{
      $.post(amadeusPath + 'hotel_ajax.php',
        {
          inputSearchValue: autoComplateSearchIN,
          flag: e === 'externalHotel' ? 'searchCityForExternalHotel' : 'searchCityForInternalHotel' ,
          json:true,
        },
        function(data) {
          let data_parse = JSON.parse(data)
            if (data_parse.length > 0) {
              $('#listSearchCity').html('');
              data_parse.forEach((index) => {
                if (lang === 'en' || lang === 'ar'){
                  if(e === 'externalHotel'){
                    let indexCountry;
                    if(index.CountryEn !== null){
                      indexCountry = index.CountryEn
                    }else if(index.CountryFa !== null){
                      indexCountry = index.CountryFa
                    } else {
                      indexCountry = " "
                    }
                    document.querySelector('#listSearchCity').innerHTML+=
                      `<li onclick="selectCity(event , '${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityEn}','${index.DepartureCode}')"> 
                   <i class="div_c_sr_i">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                  </i>
                   <div class="div_c_sr">
                      <span class="c-text">
                        ${index.DepartureCityEn}
                      </span>
                      <div class="yata_gdemo">
                        <i>${indexCountry}</i>
                      </div>
                   </div>
                  </li>`;
                  } else if(e === 'hotel') {
                    document.querySelector('#listSearchCity').innerHTML+=
                      `<li onclick="selectCity_internal('${index.id}','${index.city_name_en}')"> 
             <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
            </i>
             <div class="div_c_sr">
               <span class="c-text">
                  ${index.city_name_en}
               </span>
             </div>
           </li>`
                  }
                } else if(lang == 'fa'){
                  if(e === 'externalHotel'){
                    let indexCountry;
                    if(index.CountryFa !== null){
                      indexCountry = index.CountryFa
                    }else if(index.CountryEn !== null){
                      indexCountry = index.CountryEn
                    } else {
                      indexCountry = " "
                    }
                    document.querySelector('#listSearchCity').innerHTML+= `
                  <li onclick="selectCity(event,'${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityFa}','${index.DepartureCode}')"> 
                   <i class="div_c_sr_i">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                  </i>
                   <div class="div_c_sr">
                      <span class="c-text">
                        ${index.DepartureCityFa == null ? index.DepartureCityEn : index.DepartureCityFa}
                      </span>
                      <div class="yata_gdemo">
                        <i>${indexCountry}</i>
                      </div>
                   </div>
                  </li>`
                  } else if(e === 'hotel') {
                    document.querySelector('#listSearchCity').innerHTML+=
                      `<li onclick="selectCity_internal('${index.id}','${index.city_name}')"> 
             <i class="div_c_sr_i">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
            </i>
             <div class="div_c_sr">
               <span class="c-text">
                  ${index.city_name}
               </span>
             </div>
           </li>`
                  }
                }
              })
            } else {
              hotelNothingFound();
            }
        })
    },300)
  }


}
$("body , html").click(function() {
  $('#listSearchCity').addClass('displayiN')
})

function selectCity_internal(id , name){
  $('#autoComplateSearchIN_hidden').val(id)
  $('#autoComplateSearchIN').val(name)
}

// kolahi



function selectCity( e, AirportEn , AirportFa , CountryEn , CountryFa , DepartureCityEn , DepartureCityFa , DepartureCode) {

  let CountryFaLet;
  let DepartureCityFaLet;

  if (lang === "fa"){
    if(CountryFa !== 'null'){
      CountryFaLet = CountryFa + ' - '
    }else if(CountryEn !== 'null'){
      CountryFaLet = CountryEn + ' - '
    } else {
      CountryFaLet = " "
    }
    if(DepartureCityFa !== 'null'){
      DepartureCityFaLet = DepartureCityFa
    }else if(DepartureCityEn !== 'null'){
      DepartureCityFaLet = DepartureCityEn
    } else {
      DepartureCityFaLet = " "
    }
  } else{
    if(CountryEn !== 'null'){
      CountryFaLet = CountryEn + ' - '
    }else if(CountryFa !== 'null'){
      CountryFaLet = CountryFa + ' - '
    } else {
      CountryFaLet = " "
    }
    if(DepartureCityEn !== 'null'){
      DepartureCityFaLet = DepartureCityEn
    }else if(DepartureCityFa !== 'null'){
      DepartureCityFaLet = DepartureCityFa
    } else {
      DepartureCityFaLet = " "
    }
  }
  $('#autoComplateSearchIN').val(CountryFaLet + DepartureCityFaLet)
  $('#destination_country').val(CountryEn)
  $('#destination_city_foreign').val(DepartureCityEn)
  $('#destination_city').val(DepartureCityEn)
  $('#listSearchCity').addClass('displayiN')
  e.stopPropagation();
}

function confirmAndBookingExternalHotel(factorNumber) {

  if (!$('#RulsCheck').is(':checked')) {
    $.alert({
      title: useXmltag('Reservationhotel'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('ConfirmTermsFirst'),
      rtl: true,
      type: 'red',
    })
    return false
  }

  $('#final_ok_and_insert_passenger').text(useXmltag('Pending')).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress')
  $('#loader_check').css('display', 'block')

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'hotel_ajax.php',
    dataType: 'JSON',
    data: {
      factorNumber: factorNumber,
      flag: 'externalHotelPreReserve',
    },
    success: function(data) {

      if (data.result == 'success') {

        setTimeout(function() {
          $('#final_ok_and_insert_passenger').removeAttr('onclick').attr('disabled', true).css('cursor', 'not-allowed').text(useXmltag('Accepted'))
          $('.s-u-p-factor-bank-change').show()
          $('#loader_check').css('display', 'none')
          $('html, body').animate({scrollTop: $('.main-pay-content').offset().top}, 'slow')
        }, 2000)

      } else {
        //$('#messageBook-externalHotel').html(data.message);
        $.alert({
          title: useXmltag('Reservationhotel'),
          icon: 'fa fa-cart-plus',
          content: useXmltag('Systemupdatingchargeminutes'),
          rtl: true,
          type: 'red',
        })
        return false
      }
    },
  })


}

function backToResultExternalHotel(city, startDate, endDate, night, rooms) {
  window.location.href = amadeusPathByLang + 'resultExternalHotel' + '/' + city + '/' + startDate + '/' + endDate + '/' + night + '/' + rooms
}

////////////// end reservation external hotel ///////////////


////////////// reservation bus ///////////////
function getResultReservationBus(origin, destination, deptDate, adult, child, infant, isShowAll) {

  $('.loaderPublicPage').fadeIn('slow')
  $.post(amadeusPath + 'hotel_ajax.php',
    {
      flag: 'getResultReservationBus',
      origin: origin,
      destination: destination,
      deptDate: deptDate,
      adult: adult,
      child: child,
      infant: infant,
      isShowAll: isShowAll,
      lang: lang,
    },
    function(data) {
      if (data) {
        $('#result').html(data)
        $('#dateSortSelectForBus').trigger('click')
        setTimeout(function() {
          $('.f-loader-check').fadeOut('slow')
          $('.loaderPublicPage').fadeOut('slow')
          $('#result').fadeIn()
        }, 1000)
      }

    })

}

function searchReservationBus(timeInterval) {

  $('#loader_check_submit_' + timeInterval).css('display', 'block')
  $('#sendFlight_' + timeInterval).css('opacity', '0.4').attr('onclick', false)

  /*var isShowAll = 'one';
    if ($('#isShowAll').hasClass('checked')) {
        isShowAll = 'all';
    }*/

  var origin = $('#origin_city').val()
  var destination = $('#destination_city').val()
  var dept_date = $('#dept_date_local').val()
  var adult = Number($('#qty1').val())
  var child = Number($('#qty2').val())
  var infant = Number($('#qty3').val())
  if (dept_date == '' || adult == '') {
    $.alert({
      title: useXmltag('Busreserve'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('Pleaseenterrequiredfields'),
      rtl: true,
      type: 'red',
    })
    $('#loader_check_submit').css('display', 'none')
    $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()')
  } else if (adult == 0) {
    $.alert({
      title: useXmltag('Busreserve'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('LeastOneAdult'),
      rtl: true,
      type: 'red',
    })
    $('#loader_check_submit').css('display', 'none')
    $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()')
  } else if ((adult + child) > 9 || infant > adult) {
    $('#loader_check_submit').css('display', 'none')
    $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSide()')
    $.alert({
      title: useXmltag('Busreserve'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('SumAdultsChildrenNoGreaterThanAdult'),
      rtl: true,
      type: 'red',
    })
  } else {
    if (dept_date.indexOf('/') > -1) {
      var dept_date_aa = dept_date.replace('/', '-')
      var date_final = dept_date_aa.replace('/', '-')
    } else {
      var date_final = dept_date
    }

    if (destination != '') {
      var ori_dep = origin + '-' + destination
    } else {
      var ori_dep = origin
    }

    var url = amadeusPathByLang + 'resultBus/' + ori_dep + '/' + date_final + '/' + adult + '-' + child + '-' + infant + '/' + timeInterval
    window.location.href = url
  }
}

function filterBus(obj) {

  $(obj).toggleClass('checked')
  var Filter = $(obj).parent('li').find('input')
  var FilterVal = $(obj).parent('li').find('input').val()
  var liTarget = $('li.' + FilterVal)

  if ($('.selectedTicket').html() == '') {
    var allTarget = $('.international-available-box.deptFlight')
  } else {
    var allTarget = $('.international-available-box.returnFlight')
  }


  $('.tzCBPart').parent('li').find('input')

  if ($(obj).parents('ul').hasClass('filter-type-ul')) {
    if ($(obj).parents('ul.filter-type-ul').find('.tzCBPart').hasClass('checked')) {
      if (FilterVal == 'all') {
        $(obj).parents('ul.filter-type-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked')
      } else {
        $('#filter-type').removeAttr('checked')
        $('#filter-type').siblings('.tzCBPart').removeClass('checked')
      }
    } else {
      $('#filter-type').siblings('.tzCBPart').addClass('checked')
    }
  }
  if ($(obj).parents('ul').hasClass('filter-seat-ul')) {
    if ($(obj).parents('ul.filter-seat-ul').find('.tzCBPart').hasClass('checked')) {
      if (FilterVal == 'all') {
        $(obj).parents('ul.filter-seat-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked')
      } else {
        $('#filter-seat').removeAttr('checked')
        $('#filter-seat').siblings('.tzCBPart').removeClass('checked')
      }
    } else {
      $('#filter-seat').siblings('.tzCBPart').addClass('checked')
    }
  }
  if ($(obj).parents('ul').hasClass('filter-airline-ul')) {
    if ($(obj).parents('ul.filter-airline-ul').find('.tzCBPart').hasClass('checked')) {
      if (FilterVal == 'all') {
        $(obj).parents('ul.filter-airline-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked')
      } else {
        $('#filter-airline').removeAttr('checked')
        $('#filter-airline').siblings('.tzCBPart').removeClass('checked')
      }
    } else {
      $('#filter-airline').siblings('.tzCBPart').addClass('checked')
    }
  }
  if ($(obj).parents('ul').hasClass('filter-time-ul')) {
    if ($(obj).parents('ul.filter-time-ul').find('.tzCBPart').hasClass('checked')) {
      if (FilterVal == 'all') {
        $(obj).parents('ul.filter-time-ul').find('.tzCBPart').not('.filter-to-check').removeClass('checked')
      } else {
        $('#filter-time').removeAttr('checked')
        $('#filter-time').siblings('.tzCBPart').removeClass('checked')
      }
    } else {
      $('#filter-time').siblings('.tzCBPart').addClass('checked')
    }
  }


  var filter_time = new Array()
  $.each($('ul.filter-time-ul li'), function(index, value) {
    if ($(this).find('span').hasClass('checked')) {
      filter_time.push($(this).find('span.checked').siblings('input').val())
    }
  })


  $.each(allTarget, function(index) {
    allTarget.hide().filter(function() {
      return (
        ($.inArray($(this).data('time'), filter_time) >= 0 || $.inArray('all', filter_time) >= 0)
      )
    }).show()

  })
}

////////////// end reservation bus ///////////////


////////// edit reserve hotel ////////////////
function editPassengerHotel() {

  $('#formEditHotel').submit(function(e) {

    var form = $(this)
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'hotel_ajax.php',
      data: form.serialize(),
      success: function(data) {
        var res = data.split(':')
        $.alert({
          title: useXmltag('ChangeReserve'),
          icon: 'fa fa-cart-plus',
          content: res[1],
          rtl: true,
          type: 'red',
        })
        setTimeout(function() {
          location.reload()
        }, 1000)
      },
    })

    e.preventDefault()
  })


}

function editTransferHotel(type) {

  $('#type').val(type)
  $('#formTransferHotel').submit(function(e) {

    var form = $(this)

    $.ajax({
      type: 'POST',
      url: amadeusPath + 'hotel_ajax.php',
      data: form.serialize(),
      success: function(data) {
        var res = data.split(':')
        $.alert({
          title: useXmltag('ChangeReserve'),
          icon: 'fa fa-cart-plus',
          content: res[1],
          rtl: true,
          type: 'red',
        })
        setTimeout(function() {
          location.reload()
        }, 1000)
      },
    })

    e.preventDefault()
  })


}

function addOneDayTour() {

  $('#formOneDayTour').submit(function(e) {

    var form = $(this)

    $.ajax({
      type: 'POST',
      url: amadeusPath + 'hotel_ajax.php',
      data: form.serialize(),
      success: function(data) {
        var res = data.split(':')
        $.alert({
          title: useXmltag('ChangeReserve'),
          icon: 'fa fa-cart-plus',
          content: res[1],
          rtl: true,
          type: 'red',
        })
        setTimeout(function() {
          location.reload()
        }, 1000)
      },
    })

    e.preventDefault()
  })


}

function deleteOneDayTour(factorNumber, idBook, price, title, totalPrice) {
  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: useXmltag('Editbookings'),
    icon: 'fa fa-clock',
    content: useXmltag('Editbookings'),
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: useXmltag('Approve'),
        btnClass: 'btn-green',
        action: function() {
          $.post(amadeusPath + 'hotel_ajax.php',
            {
              idBook: idBook,
              factorNumber: factorNumber,
              price: price,
              title: title,
              totalPrice: totalPrice,
              flag: 'deleteOneDayTour',
            },
            function(data) {

              var res = data.split(':')
              $.alert({
                title: useXmltag('Removechanges'),
                icon: 'fa fa-cart-plus',
                content: res[1],
                rtl: true,
                type: 'red',
              })
              setTimeout(function() {
                location.reload()
              }, 1000)

            })
        },
      },
      cancel: {
        text: useXmltag('Optout'),
        btnClass: 'btn-orange',
        action: function() {
          setTimeout(function() {
            location.reload()
          }, 1000)
        },
      },
    },
  })


}

function deleteRoom(id, type, factorNumber, roomCount) {
  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: useXmltag('Editbookings'),
    icon: 'fa fa-clock',
    content: useXmltag('ChangeRequest'),
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: useXmltag('Approve'),
        btnClass: 'btn-green',
        action: function() {
          $.post(amadeusPath + 'hotel_ajax.php',
            {
              id: id,
              type: type,
              factorNumber: factorNumber,
              roomCount: roomCount,
              flag: 'deleteRoomReservations',
            },
            function(data) {

              var res = data.split(':')
              $.alert({
                title: useXmltag('Removechanges'),
                icon: 'fa fa-cart-plus',
                content: res[1],
                rtl: true,
                type: 'red',
              })
              setTimeout(function() {
                location.reload()
              }, 1000)

            })
        },
      },
      cancel: {
        text: useXmltag('Optout'),
        btnClass: 'btn-orange',
        action: function() {
          setTimeout(function() {
            location.reload()
          }, 1000)
        },
      },
    },
  })


}

function addRoom(id, type, roomCount) {

  var extraBedSelect = $('#extraBedSelect' + id + roomCount).val()
  var extraChildBedSelect = $('#extraChildBedSelect' + id + roomCount).val()

  if ((extraBedSelect != 'تخت' && extraBedSelect > 0) || (extraChildBedSelect != 'تخت' && extraChildBedSelect > 0)) {

    $('#roomId').val(id)
    $('#typeBed').val(type)
    $('#roomCount').val(roomCount)
    $('#extraBed').val(extraBedSelect)
    $('#extraChildBed').val(extraChildBedSelect)

    $('#formAddRoom').submit()

  } else {
    $.alert({
      title: useXmltag('Exterabed'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('PleaseSelectNumberAdditionalBeds'),
      rtl: true,
      type: 'red',
    })
  }

}

function editDateReserve(factorNumber) {

  var startDate = $('#startDate').val()
  var endDate = $('#endDate').val()
  var night = $('#nights').val()

  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: useXmltag('Editbookings'),
    icon: 'fa fa-clock',
    content: useXmltag('ChangeRequest'),
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: useXmltag('Approve'),
        btnClass: 'btn-green',
        action: function() {
          $.post(amadeusPath + 'hotel_ajax.php',
            {
              factorNumber: factorNumber,
              startDate: startDate,
              endDate: endDate,
              night: night,
              flag: 'editDateReserve',
            },
            function(data) {

              var res = data.split(':')
              $.alert({
                title: useXmltag('Editbookings'),
                icon: 'fa fa-cart-plus',
                content: res[1],
                rtl: true,
                type: 'red',
              })
              setTimeout(function() {
                location.reload()
              }, 1000)

            })
        },
      },
      cancel: {
        text: useXmltag('Optout'),
        btnClass: 'btn-orange',
        action: function() {
          setTimeout(function() {
            location.reload()
          }, 1000)
        },
      },
    },
  })

}

function PreFactorReservationHotel(factorNumber, CurrencyCode, CurrencyEquivalent) {

  var form = document.createElement('form')
  form.setAttribute('method', 'POST')
  form.setAttribute('action', amadeusPathByLang + 'addRoomFactor')
  form.setAttribute('target', '_self')
  var hiddenField1 = document.createElement('input')
  hiddenField1.setAttribute('name', 'factorNumber')
  hiddenField1.setAttribute('value', factorNumber)
  var hiddenField2 = document.createElement('input')
  hiddenField2.setAttribute('name', 'typeApplication')
  hiddenField2.setAttribute('value', 'reservation')
  var hiddenField3 = document.createElement('input')
  hiddenField3.setAttribute('name', 'bookingStage')
  hiddenField3.setAttribute('value', 'preFactorDisplay')
  var hiddenField4 = document.createElement('input')
  hiddenField4.setAttribute('name', 'CurrencyCode')
  hiddenField4.setAttribute('value', CurrencyCode)
  var hiddenField5 = document.createElement('input')
  hiddenField5.setAttribute('name', 'CurrencyEquivalent')
  hiddenField5.setAttribute('value', CurrencyEquivalent)

  form.appendChild(hiddenField1)
  form.appendChild(hiddenField2)
  form.appendChild(hiddenField3)
  form.appendChild(hiddenField4)
  form.appendChild(hiddenField5)

  document.body.appendChild(form)
  form.submit()
  document.body.removeChild(form)

}


function BackToEditReserve(factorNumber) {
  var href = clientMainDomain + '/gds/editReserveHotel&id=' + factorNumber
  window.location = href
}


////////////////////////////////////////////////
//////////////////europcar/////////////////////
function submitSearchEuropcar() {

  var sourceStationId = $('#sourceStationId').val()
  var destStationId = $('#destStationId').val()
  var startDate = $('#startDate').val()
  var startTime = $('#startTime').val()
  var endDate = $('#endDate').val()
  var endTime = $('#endTime').val()

  if (sourceStationId == '' || startDate == '' || startTime == '' || endDate == '' || endTime == '') {
    $.alert({
      title: useXmltag('Reservationhotel'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('Pleaseenterrequiredfields'),
      rtl: true,
      type: 'red',
    })
  } else {

    if ($('#changeStations').prop('checked') == true) {
      $('#returnStations').removeClass('hidden').addClass('showHidden')
      var url = amadeusPathByLang + 'resultEuropcarLocal/' + sourceStationId + '-' + destStationId + '/'
        + startDate + 'T' + startTime + '/' + endDate + 'T' + endTime

    } else {
      $('#returnStations').removeClass('showHidden').addClass('hidden')
      var url = amadeusPathByLang + 'resultEuropcarLocal/' + sourceStationId + '/'
        + startDate + 'T' + startTime + '/' + endDate + 'T' + endTime

    }

    window.location.href = url

    /*
        var href = amadeusPathByLang + "resultEuropcarLocal/" + sourceStationId + "-" + destStationId + "/";
        $.post(amadeusPath + 'hotel_ajax.php',
            {
                startDate: startDate,
                endDate: endDate,
                flag: 'convertDateForEuropcar'
            },
            function (data) {

                var res = data.split('|');
                var url = href + res[0] + "T" + startTime + "/" + res[1] + "T" + endTime;
                //alert(url);
                window.location.href = url;

            });*/


  }

}


function reserveCar(idCar) {

  $('#idCar').val(idCar)

  $('#img').show()
  $('.buttonReserveHotel').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag('Pending'))

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      flag: 'CheckedLogin',
    },
    function(data) {

      if (data.indexOf('successLoginHotel') > -1) {

        viewCar()

      } else if (data.indexOf('errorLoginHotel') > -1) {

        $('#noLoginBuy').val(useXmltag('Bookingwithoutregistration'))
        var isShowLoginPopup = $('#isShowLoginPopup').val()
        var useTypeLoginPopup = $('#useTypeLoginPopup').val()
        if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
          $('#login-popup').trigger('click')
        } else {
          popupBuyNoLogin(useTypeLoginPopup)
        }

      }

    })

}

/*function memberEuropcarLogin() {

    // Rid Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    // Get values
    var email = $("#signin-email2").val();
    var pass = $("#signin-password2").val();
    var remember = $("#remember-me2:checked").val();
    if (remember == 'checked' || remember == 'on' || remember == 'true') {
        remember = 'on';
    } else {
        remember = 'off';
    }
    var organization = '';
    if($('#signin-organization2').length > 0){
        organization = $('#signin-organization2').val();
    }

    //check values
    if (!email) {
        $("#error-signin-email2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-email2").css("opacity", "1");
        $("#error-signin-email2").css("visibility", "visible");
        error = 1;
    }

    if (!pass) {
        $("#error-signin-password2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-password2").css("opacity", "1");
        $("#error-signin-password2").css("visibility", "visible");
        error = 1;
    }

    // send  for logon
    if (error == 0) {

        $.post(amadeusPath + 'user_ajax.php',
            {
                email: email,
                remember: remember,
                password: pass,
                organization: organization,
                setcoockie: "yes",
                flag: 'memberLogin'
            },
            function (data) {

                if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                    $(".cd-user-modal").trigger("click");
                    viewCar();
                } else {

                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            email: email,
                            remember: remember,
                            password: pass,
                            flag: 'agencyLogin'
                        },
                        function (res) {
                            if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
                                $(".cd-user-modal").trigger("click");
                                viewCar();
                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        })

                }
            })
    } else {
        return false;
    }

}*/

function viewCar() {
  var href = amadeusPathByLang + 'passengerDetailEuropcarLocal'
  $('#formCar').attr('action', href)
  $('#formCar').submit()
}

function calculateEuropcarPrices(idThings) {

  var allThingsId = $('#allThingsId').val()
  var paymentsPriceCar = $('#paymentsPriceCar').val()

  var selectThingsId = ''
  var selectThingsCount = ''
  var priceCar = 0
  //var countCar = 0;
  var id = allThingsId.split('/')

  for (i = 0; i < id.length; i++) {

    var price = $('#priceThings' + id[i]).val()
    var count = $('#countThings' + id[i]).val()
    var priceToShow = $('#priceThings' + id[i]).data('amount')

    if (count > 0) {
      priceCar = parseInt(priceCar) + parseInt(parseInt(price) * parseInt(count))
      priceCarToShow = parseInt(priceCar) + parseInt(parseInt(priceToShow) * parseInt(count))
      //countCar = parseInt(countCar) + parseInt(count);

      selectThingsId = selectThingsId + id[i] + '/'
      selectThingsCount = selectThingsCount + count + '/'

      $('#totalPriceThings' + id[i]).html(addCommas(parseInt(priceToShow) * parseInt(count)))
    } else {
      $('#totalPriceThings' + id[i]).html('')
    }
  }

  var paymentsPrice = parseInt(paymentsPriceCar) + parseInt(priceCar)
  var paymentsPriceToShow = parseInt(paymentsPriceCar) + parseInt(priceCarToShow)

  $('#paymentsPriceHtml').html(addCommas(paymentsPriceToShow))
  $('#paymentsPrice').val(paymentsPrice)

  $('#selectThingsId').val(selectThingsId)
  $('#selectThingsCount').val(selectThingsCount)

}

/**
 بررسی  مسافران وارد شده قبل از ارسال به صفحه فاکتور
 page : PassengerDetailHotelLocal.tpl
 **/
function checkPassengerCarLocal(currentDate) {

  $('#messageA1').html('')
  $('#message').html('')
  var error1 = 0
  var error2 = 0
  var error3 = 0
  var error4 = 0
  var error5 = 0

  var adt = adultMembersCar(currentDate)
  if (adt == 'true') {
    error1 = 0
  } else {
    error1 = 1
  }

  var mob = checkMobile($('#MobileA1').val())
  if (mob == 'true') {
    error4 = 0
  } else {
    error4 = 1
  }

  var email = checkEmail($('#EmailA1').val())
  if (email == 'true') {
    error5 = 0
  } else {
    error5 = 1
  }

  var tell = checkTelephone($('#TelephoneA1').val())
  if (tell == 'true') {
    error5 = 0
  } else {
    error5 = 1
  }


  $('#message').html('')
  if ($('#IdentityFileType').val() == null || $('#HabitationFileType').val() == null || $('#JobFileType').val() == null) {
    error3 = 1
    $('#message').html(useXmltag('Fillingallfieldsrequired'))
  }

  if (document.getElementById('IdentityFile').files.length == 0) {
    $('#message').html(useXmltag('Fillingallfieldsrequired'))
  }
  if (document.getElementById('HabitationFile').files.length == 0) {
    $('#message').html(useXmltag('Fillingallfieldsrequired'))
  }
  if (document.getElementById('JobFile').files.length == 0) {
    $('#message').html(useXmltag('Fillingallfieldsrequired'))
  }


  if ($('#UsageNotLogin').val() && $('#UsageNotLogin').val() == 'yes') {
    var mob = $('#Mobile').val()
    var Email_Address = $('#Email').val()
    var tel = $('#Telephone').val()
    var mm = membersForHotel(mob, Email_Address, tel)
    if (mm == 'true') {
      error2 = 0
    } else {
      error2 = 1
    }

  }


  if (error1 == 0 && error2 == 0 && error3 == 0 && error4 == 0 && error5 == 0) {
    // alert('rrrr')

    $.post(amadeusPath + 'hotel_ajax.php',
      {
        mobile: mob,
        telephone: tel,
        Email: Email_Address,
        flag: 'register_memeberHotel',
      },
      function(data) {
        if (data != '') {

          $('#IdMember').val(data)

          $('#loader_check').show()
          $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag('Pending'))

          setTimeout(
            function() {
              $('#loader_check').hide()
              $('#formPassengerDetailEuropcarLocal').submit()
            }, 3000)

        } else {

          $.alert({
            title: useXmltag('CarReservation'),
            icon: 'fa fa-cart-plus',
            content: useXmltag('Errorrecordinginformation'),
            rtl: true,
            type: 'red',
          })
          return false
        }
      })
  }

}

function adultMembersCar(currentDate) {

  var error = 0
  $('#messageA1').html('')
  var gender = $('#genderA1' + ' option:selected').val()
  var RefundType = $('#RefundTypeA1' + ' option:selected').val()
  var DrivingCrimesType = $('#DrivingCrimesTypeA1' + ' option:selected').val()

  if (gender != 'Male' && gender != 'Female') {
    $('#messageA1').html('<br>' + useXmltag('SpecifyGender'))
    error = 1
  }

  if ($('#nameFaA1').val() == '' || $('#familyFaA1').val() == '' || $('#birthdayA1').val() == ''
    || $('#MobileA1').val() == '' || $('#TelephoneA1').val() == '' || $('#EmailA1').val() == ''
    || $('#AddressA1').val() == '' || RefundType == '' || DrivingCrimesType == ''
  ) {

    $('#messageA1').html(useXmltag('Fillingallfieldsrequired'))
    error = 1
  }

  if ($('#ZoneFlight').val() != 'Local') {
    if ($('#passportNumberA1').val() == '' || $('#passportExpireA1').val() == '') {
      $('#messageA1').html(useXmltag('FillingPassportRequired'))
      error = 1
    }
  }


  // حداقل سن راننده
  if (age == '') {
    var minAge = (18 * 365 + 3) * 24 * 60 * 60
  } else {
    var minAge = (age * 365 + 3) * 24 * 60 * 60
  }

  if ($('input[name=passengerNationalityA1' + ']:checked').val() == '1') {

    if ($('#birthdayEnA1').val() == '' || $('#passportCountryA1').val() == '' || $('#passportNumberA1').val() == '' || $('#passportExpireA1').val() == '') {
      $('#messageA1').html(useXmltag('Fillingallfieldsrequired'))
      error = 1
    }

    //بررسی تاریخ تولد
    var t = $('#birthdayEnA1').val()
    var d = new Date(t)
    n = Math.round(d.getTime() / 1000)
    if ((currentDate - n) < minAge) {
      $('#messageA1').html(useXmltag('BirthEnteredNotCorrect'))
      error = 1
    }

  } else {

    if ($('#birthdayA1').val() == '' || $('#NationalCodeA1').val() == '') {
      $('#messageA1').html(useXmltag('Fillingallfieldsrequired'))
      error = 1

    }

    var National_Code = $('#NationalCodeA1').val()
    var CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCode'))
    if (CheckEqualNationalCode == false) {
      $('#messageA1').html('<br>' + useXmltag('NationalCodeDuplicate'))
      error = 1
    }

    var z1 = /^[0-9]*\d$/
    var convertedCode = convertNumber(National_Code)
    if (National_Code != '') {
      if (!z1.test(convertedCode)) {
        $('#messageA1').html('<br>' + useXmltag('NationalCodeNumberOnly'))
        error = 1
      } else if ((National_Code.toString().length != 10)) {

        $('#messageA1').html('<br>' + useXmltag('OnlyTenDigitsNationalCode'))
        error = 1
      } else {
        var NCode = checkCodeMeli(convertNumber(National_Code))
        if (!NCode) {
          $('#messageA1').html('<br>' + useXmltag('EnteredCationalCodeNotValid'))
          error = 1
        }
      }
    }

    //بررسی تاریخ تولد
    var t = $('#birthdayA1').val()
    var splitit = t.split('-')
    var JDate = require('jdate')
    var jdate2 = new JDate([splitit[0], splitit[1], splitit[2]])
    var array = $.map(jdate2, function(value, index) {
      return [value]
    })
    var d = new Date(array[0])
    var n = Math.round(d.getTime() / 1000)
    if ((currentDate - n) < minAge) {
      $('#messageA1').html(useXmltag('BirthEnteredNotCorrect'))
      error = 1
    }
  }


  if (error == 0) {
    return 'true'
  } else {
    return 'false'
  }
}

function checkMobile(mob) {
  $('#messageA1').html('')
  var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/
  var error_member = 0
  if (mob == '') {
    $('#messageA1').html(useXmltag('Fillingallfieldsrequired'))
    error_member = 1
  } else if (!mobregqx.test(mob)) {
    $('#messageA1').html('<br>' + useXmltag('MobileNumberIncorrect'))
    error_member = 1
  }

  if (error_member == 0) {
    return 'true'
  } else {
    return 'false'
  }
}

function checkEmail(email) {
  $('#messageA1').html('')
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
  var error_member = 0
  if (email == '') {
    $('#messageA1').html(useXmltag('Fillingallfieldsrequired'))
    error_member = 1
  } else if (!emailReg.test(email)) {
    $('#messageA1').html('<br>' + useXmltag('Pleaseenteremailcorrectformat'))
    error_member = 1
  }

  if (error_member == 0) {
    return 'true'
  } else {
    return 'false'
  }
}

function checkTelephone(tel) {
  var patt = new RegExp('[0-9]')
  var res = patt.test(tel)
  var error_member = 0
  if (tel == '') {
    $('#messageInfo').html(useXmltag('Fillingallfieldsrequired'))
    error_member = 1
  } else if (res == false) {
    $('#messageInfo').html('<br>' + useXmltag('Thefixedtelephonenumberonlycontainsnumber'))
    error_member = 1
  }

  if (error_member == 0) {
    return 'true'
  } else {
    return 'false'
  }


}


function reserveCarTemprory(factorNumber) {

  if (!$('#RulsCheck').is(':checked')) {
    $.alert({
      title: useXmltag('Carrental'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('ConfirmTermsFirst'),
      rtl: true,
      type: 'red',
    })
    return false
  }

  $('#final_ok_and_insert_passenger').text(useXmltag('Pending')).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress')
  $('#loader_check').css('display', 'block')

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      factorNumber: factorNumber,
      flag: 'CarReserve',
    },
    function(data) {

      var response = data.split(':')

      if (data.indexOf('error') > -1) {

        $('#messageBook').html(response[1])

      } else if (data.indexOf('successReserveCar') > -1) {

        setTimeout(function() {
          $('#final_ok_and_insert_passenger').removeAttr('onclick').attr('disabled', true).css('cursor', 'not-allowed').text(useXmltag('Accepted'))

          $('.s-u-p-factor-bank-change').show()
          $('#loader_check').css('display', 'none')
          $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow')
        }, 2000)

      }

    })

}

function backToResultEuropcarLocal(sourceStationId, destStationId, getCarDateTime, returnCarDateTime) {

  if (sourceStationId != destStationId) {
    var StationId = sourceStationId + '-' + destStationId
  } else {
    var StationId = sourceStationId
  }
  var href = amadeusPathByLang + 'resultEuropcarLocal' + '/' + StationId + '/' + getCarDateTime + '/' + returnCarDateTime
  window.location.href = href

}


function modalListForEuropcar(factorNumber) {

  //$('.loaderPublicForHotel').fadeIn(700);
  setTimeout(function() {
    $('.loaderPublicForHotel').fadeOut(500)
    $('#ModalPublic').fadeIn(700)
  }, 3000)

  $.post(libraryPath + 'ModalCreatorForEuropcar.php',
    {
      Controller: 'user',
      Method: 'ModalShow',
      factorNumber: factorNumber,
    },
    function(data) {
      $('#ModalPublicContent').html(data)
    })

}


function viewAllBus(obj) {
  $(obj).toggleClass('checked')
}


function selectSortHotel(obj) {
  let sortBy = $(obj).val()
  sortHotelList(sortBy)
}

function sortHotelList(sortBy) {

  let currentHotel = ''
  let allHotels = []
  let temp = []
  let current_sort_index = ''
  let current_sort_index_first = ''
  let typApplication = ''
  let special = ''
  let price = ''
  let priority = ''
  let arrayPrice = []
  let searchResult = $('#hotelResult').find('.hotelResultItem .hotel-result-item')

  searchResult.each(function() {

    currentHotel = $(this).parent()

    typApplication = $(this).data('typeapplication')
    special = $(this).data('special')


    if (sortBy == 'max_star_code' || sortBy == 'min_star_code') {

      if (parseInt($(this).data('star')) > 0) {
        current_sort_index = parseInt($(this).data('star'))
      } else {
        current_sort_index = 0
      }

      if (parseInt($(this).data('price')) > 0) {
        price = current_sort_index_first = parseInt($(this).data('price'))
        arrayPrice.push(price)
      } else {
        price = current_sort_index_first = 0
      }


    }
    else if (sortBy == 'max_room_price' || sortBy == 'min_room_price') {
      if (parseInt($(this).data('price')) > 0) {
        price = current_sort_index = parseInt($(this).data('price'))
        arrayPrice.push(price)
      } else {
        price = current_sort_index = 0
      }

      if (parseInt($(this).data('star')) > 0) {
        current_sort_index_first = parseInt($(this).data('star'))
      } else {
        current_sort_index_first = 0
      }

    }
    else if (sortBy == 'reservation') {
      if (parseInt($(this).data('reservation')) > 0) {
        typeapplication = current_sort_index = 'reservation'
        arrayPrice.push(typeapplication)
      } else {
        typeapplication = current_sort_index = 0
      }

      if (parseInt($(this).data('priority')) > 0) {
        current_sort_index_first = parseInt($(this).data('priority'))
      } else {
        current_sort_index_first = 1
      }

    }
    else if (sortBy == 'reservation_priority') {

      if (parseInt($(this).data('priority')) > 0) {
        current_sort_index = parseInt($(this).data('priority'))
      } else {
        current_sort_index = 0
      }

      if (parseInt($(this).data('price')) > 0) {
        price = current_sort_index_first = parseInt($(this).data('price'))
        arrayPrice.push(price)
      } else {
        price = current_sort_index_first = 0
      }

    }
    // current_sort_index_first => for sorting prices
    // current_sort_index => for sorting by nubmbers
    allHotels.push({
      'content': currentHotel.html(),
      'sortIndex': current_sort_index,
      'sortIndexFirst': current_sort_index_first,
      'typApplication': typApplication,
      'price': price,
      'special' : special
    })

  })

  if (sortBy == 'min_room_price' || sortBy == 'min_star_code') {

    for (let i = 0; i < parseInt(allHotels.length); i++) {
      for (let j = i; j < parseInt(allHotels.length); j++) {
        if (allHotels[j]['sortIndexFirst'] <= allHotels[i]['sortIndexFirst']) {
          temp = allHotels[i]
          allHotels[i] = allHotels[j]
          allHotels[j] = temp
        }
      }
    }

    for (let i = 0; i < parseInt(allHotels.length); i++) {
      for (let j = i; j < parseInt(allHotels.length); j++) {
        if (allHotels[j]['sortIndex'] <= allHotels[i]['sortIndex']) {
          temp = allHotels[i]
          allHotels[i] = allHotels[j]
          allHotels[j] = temp
        }
      }
    }

  }
  else if (sortBy == 'max_room_price' || sortBy == 'max_star_code' ) {

    for (let i = 0; i < parseInt(allHotels.length); i++) {
      for (let j = i; j < parseInt(allHotels.length); j++) {
        if (allHotels[j]['sortIndexFirst'] >= allHotels[i]['sortIndexFirst']) {
          temp = allHotels[i]
          allHotels[i] = allHotels[j]
          allHotels[j] = temp
        }
      }
    }

    for (let i = 0; i < parseInt(allHotels.length); i++) {
      for (let j = i; j < parseInt(allHotels.length); j++) {
        if (allHotels[j]['sortIndex'] >= allHotels[i]['sortIndex']) {
          temp = allHotels[i]
          allHotels[i] = allHotels[j]
          allHotels[j] = temp
        }
      }
    }


  }
  else if (sortBy ==  'reservation_priority') {
    // for (let i = 0; i < parseInt(allHotels.length); i++) {
    //   for (let j = i; j < parseInt(allHotels.length); j++) {
    //     if (allHotels[j]['sortIndex'] >= allHotels[i]['sortIndex']) {
    //
    //       temp = allHotels[i]
    //       allHotels[i] = allHotels[j]
    //       allHotels[j] = temp
    //     }
    //   }
    // }
    for (let i = 0; i < parseInt(allHotels.length); i++) {
      for (let j = i; j < parseInt(allHotels.length); j++) {
        if (allHotels[j]['sortIndexFirst'] <= allHotels[i]['sortIndexFirst']) {
          temp = allHotels[i]
          allHotels[i] = allHotels[j]
          allHotels[j] = temp
        }
      }
    }




  }

  function setInputFilter(textbox, inputFilter) {
    ['input', 'keydown', 'keyup', 'mousedown', 'mouseup', 'select', 'contextmenu', 'drop'].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value
          this.oldSelectionStart = this.selectionStart
          this.oldSelectionEnd = this.selectionEnd
        } else if (this.hasOwnProperty('oldValue')) {
          this.value = this.oldValue
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd)
        } else {
          this.value = ''
        }
      })
    })
  }


  $('.right_hotel_section').on('keyup', '.val_number_room', function() {
    let val_this = $(this).val()
    var re = new RegExp('^[0-9]+$')
    if (re.test(val_this)) {
      $(this).val(parseInt(val_this, 10))
    } else {
      $(this).val(0)
    }

    if (val_this > 9) {
      $(this).val(9)
    }

  })

  $('.right_hotel_section').on('click', '.plus_room', function() {
    let val_room = parseInt($(this).parent().find('.val_number_room').val())

    if (val_room < 9) {
      $(this).parent().find('.val_number_room').val(val_room + 1)
    }
    if (val_room == 'NaN') {
      $(this).parent().find('.val_number_room').val(1)
    } else {
    }
    if ($(this).data('type_application') == 'reservation') {
      checkForReserve($(this).data('room_token'))
    } else {
      CalculateNewRoomPrice($(this).data('room_token'), true, true)
    }
  })

  $('.right_hotel_section').on('click', '.minus_room', function() {
    let val_room = parseInt($(this).parent().find('.val_number_room').val())
    if (val_room > 0) {
      $(this).parent().find('.val_number_room').val(val_room - 1)
    }
    if ($(this).data('type_application') == 'reservation') {
      checkForReserve($(this).data('room_token'))
    } else {
      CalculateNewRoomPrice($(this).data('room_token'), true, true)
    }

  })


  $('#countHotel').html(parseInt(allHotels.length))


  // // اگر هتل رزرواسیون قیمت داشت بالاتر از همه نمایش بدهد
  // for (let i = 0; i < parseInt(allHotels.length); i++) {
  //   for (let j = i; j < parseInt(allHotels.length); j++) {
  //     if (allHotels[i]['typApplication'] == 'api' && allHotels[j]['typApplication'] == 'reservation' && allHotels[j]['price'] > 0) {
  //       temp = allHotels[i]
  //       allHotels[i] = allHotels[j]
  //       allHotels[j] = temp
  //     }
  //   }
  // }

  // sort by special hotels
  var specialHotels = []
  var noneSpecialHotels = []
  for (let i = 0; i < parseInt(allHotels.length); i++) {
    if(allHotels[i]['special'] == 'yes'){
      specialHotels.push(allHotels[i])
    }else {
      noneSpecialHotels.push(allHotels[i])
    }
  }
  allHotels = specialHotels.concat(noneSpecialHotels);


  if (allHotels.length > 0) {
    setTimeout(function() {
      /*let maxPrice = Math.max.apply(Math,arrayPrice);
            let minPrice = Math.min.apply(Math,arrayPrice);
            $(".filter-price-text span:nth-child(1) i").html(addCommas(maxPrice));
            $(".filter-price-text span:nth-child(2) i").html(addCommas(minPrice));*/
      $('#hotelResult').empty()
      for (let i = 0; i < parseInt(allHotels.length); i++) {
        if (allHotels[i]['price'] > 0) {
          $('#hotelResult').append('<div class="hotelResultItem">' + allHotels[i]['content'] + '</div>')
        }
      }
    }, 50)
  }


  setTimeout(function() {
    for (let i = 0; i < parseInt(allHotels.length); i++) {
      if (allHotels[i]['price'] == 0) {
        $('#hotelResult').append('<div class="hotelResultItem">' + allHotels[i]['content'] + '</div>')
      }
    }
  }, 100)


  /*$("body").on("click", ".DetailRoom_external", function () {
        $(this).parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail');
        $(this).find('i').toggleClass('rotate');
    });*/
  $('body').on('click', '.DetailRoom_local', function() {
    $(this).parents('.rate-item').find('.detail_room_hotel').toggleClass('active_detail')
    $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
  })

  /*
        var stickyEl = new Sticksy('.filter_hotel_boxes', {
            topSpacing: 100,
        })
        stickyEl.onStateChanged = function (state) {
            if (state === 'fixed') stickyEl.nodeRef.classList.add('widget--sticky')
            else stickyEl.nodeRef.classList.remove('widget--sticky')
        }*/

  // lazyView //
  /*if ($('#hotelResult').data('typeapp') == 'externalHotel') {
        setTimeout(function () {
            let newScript;
            newScript = document.createElement('script');
            newScript.type = 'text/javascript';
            newScript.src = amadeusPath + 'view/client/assets/js/lazyView/jquery.lazyView.min.js';
            document.getElementsByTagName("head")[0].appendChild(newScript);
            $('#hotelResult').lazyView();
        }, 110);
    }*/


}


$(document).ready(function() {

  $('body').on('click', '.myroom-hotel-item .close', function() {
    let roomNumber = $(this).parents('.myroom-hotel-item').data('roomnumber')
    $(this).parents('.myroom-hotel-item').remove()
    let countRoom = parseInt($('#countRoom').val()) - 1
    $('#countRoom option:selected').prop('selected', false)
    $('#countRoom option[value=' + countRoom + ']').prop('selected', true)
    let numberRoom = 1
    let numberText = useXmltag('First')
    $('.myroom-hotel-item').each(function() {
      $(this).data('roomnumber', numberRoom)
      if (numberRoom == 1) {
        numberText = useXmltag('First')
      } else if (numberRoom == 2) {
        numberText = useXmltag('Second')
      } else if (numberRoom == 3) {
        numberText = useXmltag('Third')
      } else if (numberRoom == 4) {
        numberText = useXmltag('Fourth')
      }
      $(this).find('.myroom-hotel-item-title').html(useXmltag('Room') + ' ' + numberText + '<span class="close"></span>')
      $(this).find('.myroom-hotel-item-info').find('input[name^=\'adult\']').attr('name', 'adult' + numberRoom)
      $(this).find('.myroom-hotel-item-info').find('input[name^=\'adult\']').attr('id', 'adult' + numberRoom)
      $(this).find('.myroom-hotel-item-info').find('input[name^=\'child\']').attr('name', 'child' + numberRoom)
      $(this).find('.myroom-hotel-item-info').find('input[name^=\'child\']').attr('id', 'child' + numberRoom)
      let numberChild = 1
      let inputNameSelectChildAge = $(this).find('.tarikh-tavalods .tarikh-tavalod-item')
      inputNameSelectChildAge.each(function() {
        $(this).find('select[name^=\'childAge\']').attr('name', 'childAge' + numberRoom + numberChild)
        $(this).find('select[name^=\'childAge\']').attr('id', 'childAge' + numberRoom + numberChild)
        numberChild++
      })
      numberRoom++
    })
  })

  $('body').on('#countRoom', 'change', function() {
    let roomCount = $('#countRoom').val()
    createRoomHotel(roomCount)
    $('.myroom-hotel').find('.myroom-hotel-item').remove()
    let code = createRoomHotel(roomCount)
    $('.myroom-hotel').append(code)
  })

  $('body').on('click', 'i.addParentEHotel', function() {
    let inputNum = $(this).siblings('.countParentEHotel').val()
    inputNum++
    if (inputNum <= 6) {
      $(this).siblings('.countParentEHotel').val(inputNum)
    }
  })

  $('body').on('click', 'i.minusParentEHotel', function() {

    let inputNum = $(this).siblings('.countParentEHotel').val()
    if (inputNum != 1) {
      inputNum--
      $(this).siblings('.countParentEHotel').val(inputNum)
    } else {
      $(this).siblings('.countParentEHotel').val('1')
    }
  })
  $('body').on('click', 'i.addChildEHotel', function() {
    let inputNum = $(this).siblings('.countChildEHotel').val()
    inputNum++
    if (inputNum <= 5) {
      $(this).siblings('.countChildEHotel').val(inputNum)
      let roomNumber = $(this).parents('.myroom-hotel-item').data('roomnumber')
      let htmlBox = createBirthdayCalendar(inputNum, roomNumber)
      $(this).parents('.myroom-hotel-item-info').find('.tarikh-tavalods').html(htmlBox)
    }
  })

  $('body').on('click', 'i.minusChildEHotel', function() {
    let inputNum = $(this).siblings('.countChildEHotel').val()
    if (inputNum != 0) {
      inputNum--
      $(this).siblings('.countChildEHotel').val(inputNum)
      let roomNumber = $(this).parents('.myroom-hotel-item').data('roomnumber')
      let htmlBox = createBirthdayCalendar(inputNum, roomNumber)
      $(this).parents('.myroom-hotel-item-info').find('.tarikh-tavalods').html(htmlBox)
    } else {
      $(this).siblings('.countChildEHotel').val('0')
    }
  })

})


function createRoomHotel(roomCount,roomsArray = null) {

  let HtmlCode = ''
  let i = 1
  let numberText = useXmltag('First')
  while (i <= roomCount) {
    if (i == 1) {
      numberText = useXmltag('First')
    } else if (i == 2) {
      numberText = useXmltag('Second')
    } else if (i == 3) {
      numberText = useXmltag('Third')
    } else if (i == 4) {
      numberText = useXmltag('Fourth')
    }
    HtmlCode +=
      '<div class="myroom-hotel-item" data-roomNumber="' + i + '">'
      + '<div class="myroom-hotel-item-title site-main-text-color">' + useXmltag('Room') + '  ' + numberText + '<span class="close"></span></div>'
      + '<div class="myroom-hotel-item-info">'
      + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
      + '<span>' + useXmltag('Adultnumber') + '<i>(12 ' + useXmltag('yearsandup') + ')</i></span>'
      + '<div>'
      + '<i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>'
      + '<input readonly class="countParentEHotel"  min="1" value="1" max="6" type="text" name="adult' + i + '" id="adult' + i + '">'
      + '<i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>'
      + '</div>'
      + '</div>'
      + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
      + '<span>' + useXmltag('Numberofchildren') + '<i>(' + useXmltag('Under') + ' 12 ' + useXmltag('Year') + '</i></span>'
      + '<div>'
      + '<i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>'
      + '<input readonly class="countChildEHotel" min="0" value="0" max="5" type="text" name="child' + i + '" id="child' + i + '">'
      + '<i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>'
      + '</div>'
      + '</div>'
      + '<div class="tarikh-tavalods">'
      + '</div>'
      + '</div>'
      + '</div>'

    i++
  }

  return HtmlCode
}

function createBirthdayCalendar(inputNum, roomNumber) {
  let i = 1
  let HtmlCode = ''
  let numberTextChild = ''
  while (i <= inputNum) {
    if (i == 1) {
      numberTextChild = useXmltag('First')
    } else if (i == 2) {
      numberTextChild = useXmltag('Second')
    } else if (i == 3) {
      numberTextChild = useXmltag('Third')
    } else if (i == 4) {
      numberTextChild = useXmltag('Fourth')
    }
    HtmlCode += '<div class="tarikh-tavalod-item">'
      + '<span>' + useXmltag('Childage') + ' <i>' + numberTextChild + '</i></span>'
      + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">'
      + '<option value="1">0 ' + useXmltag('To') + ' 1 ' + useXmltag('Year') + '</option>'
      + '<option value="2">1 ' + useXmltag('To') + ' 2 ' + useXmltag('Year') + '</option>'
      + '<option value="3">2 ' + useXmltag('To') + ' 3 ' + useXmltag('Year') + '</option>'
      + '<option value="4">3 ' + useXmltag('To') + ' 4 ' + useXmltag('Year') + '</option>'
      + '<option value="5">4 ' + useXmltag('To') + ' 5 ' + useXmltag('Year') + '</option>'
      + '<option value="6">5 ' + useXmltag('To') + ' 6 ' + useXmltag('Year') + '</option>'
      + '<option value="7">6 ' + useXmltag('To') + ' 7 ' + useXmltag('Year') + '</option>'
      + '<option value="8">7 ' + useXmltag('To') + ' 8 ' + useXmltag('Year') + '</option>'
      + '<option value="9">8 ' + useXmltag('To') + ' 9 ' + useXmltag('Year') + '</option>'
      + '<option value="10">9 ' + useXmltag('To') + ' 10 ' + useXmltag('Year') + '</option>'
      + '<option value="11">10 ' + useXmltag('To') + ' 11 ' + useXmltag('Year') + '</option>'
      + '<option value="12">11 ' + useXmltag('To') + ' 12 ' + useXmltag('Year') + '</option>'
      + '</select>'
      + '</div>'
    i++
  }
  return HtmlCode
}


function tabHotel(data , e){
  $(".tabHotel__box").hide();
  $(`#${data}`).show();
  $(".tabHotel__btns").removeClass("tabHotel__btns--active")
  e.classList.add("tabHotel__btns--active")
}

function researchAccordionBtnDetailHotel() {
  const ElemBtn = document.querySelector('.sidebar-detailHotel .filterBoxTop .filtertip_hotel_detail i');
  const ElemBox = document.querySelector('.sidebar-detailHotel .filterBoxTop .filtertip-searchbox-box1');
  if(ElemBtn && ElemBox) {
    ElemBtn.classList.toggle('fa-chevron-down')
    ElemBtn.classList.toggle('fa-chevron-up')
    ElemBox.classList.toggle('d-none')
  }

}


// function closeHotelReservationTab() {
//   $('.box-cancel-rule-col').addClass('display-none');
// }





function moreHotelReservationTab(element) {
  const $box = $(element).closest('.hotel-rooms-item').find('.box-cancel-rule-col');

  if ($box.hasClass('displayN') || $box.hasClass('display-none')) {
    $box.removeClass('displayN display-none');
  } else {
    $box.addClass('displayN');
  }
  // $box.toggleClass('displayN'); // یا منطق شرطی شما
}


$(document).ready(function () {
  setTimeout(function () {
      $('.mBox').mBox({
        imagesPerPage: 4,
        displayThumbnails: true
      });
  }, 3000);
});