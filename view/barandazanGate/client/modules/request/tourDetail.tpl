<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css" />
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{load_presentation_object filename="resultTourLocal" assign="objResult"}
{load_presentation_object filename="reservationTour" assign="objTour"}
{assign var="showTourToman" value = $objFunctions->isEnableSetting('toman')}
{if $showTourToman}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('toman')}
{else}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('Rial')}
{/if}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

<span id="SOFTWARE_LANG_SPAN" data-lang="{$smarty.const.SOFTWARE_LANG}" class="d-none"></span>

{if $smarty.const.SOFTWARE_LANG === 'en'}
    {assign var="countryTitleName" value="titleEn"}
{else}
    {assign var="countryTitleName" value="titleFa"}
{/if}

{if isset($smarty.post.factor_number)}
    {assign var="FactorNumber" value=$smarty.post.factor_number}
{else}
    {assign var="FactorNumber" value=$objResult->getFactorNumber()}
{/if}

{assign var="priceChanged" value=$objTour->getRequestPriceChanged($FactorNumber)}


{assign var="date" value="|"|explode:$smarty.post.selectDate}

{if $smarty.post.is_api eq '1'}
    {assign var="data_tour" value=['tour_code'=>$smarty.post.tourCode, 'start_date'=>$date[0],'type_tour'=>$smarty.post.typeTourReserve]}
    {assign var="infoTour" value=$objTour->infoTourByDateApi($data_tour)}

{else}
    {assign var="infoTour" value=$objTour->infoTourByDate($smarty.post.tourCode, $date[0],$smarty.post.typeTourReserve)}

{/if}


{$objResult->getInfoTourByIdTour($infoTour['id'],$smarty.post.is_api)}



{assign var="array_package" value=[]}

{assign var="hotels" value=$objTour->infoTourHotelByIdPackage($smarty.post.packageId,$smarty.post.is_api)}



{foreach from=$hotels item=hotel key=hotel_key}
    {assign var="hotel_information" value=$objTour->getHotelInformation($hotel['fk_hotel_id'],$smarty.post.is_api)}
    {assign var="tour_route_information" value=$objTour->infoTourRoutByIdPackage($infoTour['id'], $hotel['fk_city_id'],$smarty.post.is_api)}

    {$array_package['hotels'][$hotel_key] = $hotel_information}
    {$array_package['hotels'][$hotel_key]['night'] = $tour_route_information[0]['night']}
    {$array_package['hotels'][$hotel_key]['room_service'] = $tour_route_information[0]['room_service']}
{/foreach}



{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="index_name" value='name'}
    {assign var="index_name_tag" value='name_fa'}
    {assign var="index_city" value='city_name'}
{else}
    {assign var="index_name" value='name_en'}
    {assign var="index_name_tag" value='name_en'}
    {assign var="index_city" value='city_name_en'}
{/if}


{assign var="cities" value=[]}

{foreach $objResult->arrayTour['infoTourRout'] as $item}
    {$cities[]=$item[$index_name]}

{/foreach}


{if $smarty.post.typeTourReserve eq 'noOneDayTour'}

    {assign var="arrayTourPackage" value=$objResult->setInfoReserveTourPackage($smarty.post.packageId, $smarty.post.countRoom)}

{/if}

{assign var="arrayTypeVehicle" value=$objResult->getTypeVehicle($infoTour['id'])}
{if $infoTour['prepayment_percentage'] neq 0}
    {assign var="paymentStatusValue" value='prePayment'}
{else}
    {assign var="paymentStatusValue" value='fullPayment'}
{/if}

{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}



<section class="passengerDetailReservationTour">
    <form style="margin: 0 -10px" method="post" id="requestForm" action="{$smarty.const.ROOT_ADDRESS}/factorRequest"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8 col-12">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/tour.tpl" targetDetail=$targetDetail}
            </div>

            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/factor.tpl" targetDetail=$targetDetail}
        </div>
        {if $smarty.post.passengerCountADT gt 0}
            {assign var="price_adult" value=((($infoTour['adult_price_one_day_tour_r'] + $infoTour['change_price']) - $discount_counter['adult_amount'] ) * $smarty.post.passengerCountADT)}
        {/if}
        {if $smarty.post.passengerCountCHD gt 0}
            {assign var="price_child" value=((($infoTour['child_price_one_day_tour_r']+ $infoTour['change_price']) - $discount_counter['child_amount']) * $smarty.post.passengerCountCHD) }
        {/if}
        {if $smarty.post.passengerCountINF gt 0}
            {assign var="price_infant" value=((($infoTour['infant_price_one_day_tour_r'] + $infoTour['change_price'])- $discount_counter['child_amount'] )  * $smarty.post.passengerCountINF)}
        {/if}


        {if $smarty.post.typeTourReserve eq 'noOneDayTour'}
            <input type="hidden" id="packageId" name="packageId" value="{$smarty.post.packageId}">
            <input type="hidden" id="countRoom" name="countRoom" value="{$smarty.post.countRoom}">
            <input type="hidden" id="currencyTitleFa" name="currencyTitleFa"
                   value="{$smarty.post.currencyTitleFa}">
        {elseif $smarty.post.typeTourReserve eq 'oneDayTour'}
            <input type="hidden" id="adultPriceOneDayTourR" name="adultPriceOneDayTourR" value="{$price_adult}">
            <input type="hidden" id="adultCountOneDayTour" name="adultCountOneDayTour"
                   value="{$smarty.post.passengerCountADT}">
            <input type="hidden" id="childPriceOneDayTourR" name="childPriceOneDayTourR"
                   value="{$price_child}">
            <input type="hidden" id="childCountOneDayTour" name="childCountOneDayTour"
                   value="{$smarty.post.passengerCountCHD}">
            <input type="hidden" id="infantPriceOneDayTourR" name="infantPriceOneDayTourR"
                   value="{$price_infant}">
            <input type="hidden" id="infantCountOneDayTour" name="infantCountOneDayTour"
                   value="{$smarty.post.passengerCountINF}">
        {/if}




        <input type="hidden" id="typeTourReserve" name="typeTourReserve"
               value="{$smarty.post.typeTourReserve}">
        <input type="hidden" name="discountType" id="discountType" value="{$smarty.post.discountType}">
        <input type="hidden" name="discount" id="discount" value="{$smarty.post.discount}">

        <input type="hidden" id="idTour" name="idTour" value="{$infoTour['id']}">
        <input type="hidden" id="prepayment_percentage" name="prepayment_percentage"
               value="{$infoTour['prepayment_percentage']}">
        <input type="hidden" id="paymentStatus" name="paymentStatus" value="{$paymentStatusValue}">
        <input type="hidden" id="passengerCount" name="passengerCount" value="{$smarty.post.passengerCount}">
        <input type="hidden" id="cities" name="cities" value="{$smarty.post.cities}">
        <input type="hidden" id="serviceTitle" name="serviceTitle" value="{$smarty.post.serviceTitle}">
        <input type="hidden" id="startDate" name="startDate" value="{$date[0]}">
        <input type="hidden" id="endDate" name="endDate" value="{$date[1]}">
        <input type="hidden" id="totalPriceA" name="totalPriceA" value="{$smarty.post.totalPriceA}">
        <input type="hidden" id="totalPrice" name="totalPrice" value="{$smarty.post.totalPrice}">
        <input type="hidden" id="totalOriginPrice" name="totalOriginPrice" value="{$smarty.post.totalOriginPrice}">
        <input type="hidden" id="paymentPrice" name="paymentPrice" value="{$smarty.post.paymentPrice}">
        <input type="hidden" id="factorNumber" name="factorNumber" value="{$FactorNumber}">

        <input type="hidden" name="typeApplication" id="typeApplication" value="reservation">

        <input type="hidden" name="idMember" id="idMember" value="">

    </form>
</section>