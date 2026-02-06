
{assign var="client_id" value=$smarty.const.CLIENT_ID}
{assign var="carId" value=$smarty.const.CAR_ID}
{assign var="carType" value=$smarty.const.CAR_TYPE}
{assign var="rentDate" value=$smarty.const.RENT_DATE}
{assign var="rentPlace" value=$smarty.const.RENT_PLACE}
{assign var="deliveryDate" value=$smarty.const.DELIVERY_DATE}
{assign var="deliveryPlace" value=$smarty.const.DELIVERY_PLACE}
{load_presentation_object filename="user" assign="objUser"}
{assign var="user_info" value=$objUser->getProfileGds({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}
{assign var="userid" value=$objSession->getUserId()}
{load_presentation_object filename="mainCity" assign="objCity"}
<section class="form-reservation-car">
        <div class="container">
                <div class="title-car">
                        <img src="assets/images/reserveCar/title-img.png" alt="img-title">
                        <h5>##OrderRegistration##</h5>
                </div>
                <div class="parent-form-car">
                     <form data-toggle="validator" id="order_reserve_car" method="post"  enctype="multipart/form-data" >

                            <input type="hidden" name="className"  id='className' value="rentCar">
                            <input type="hidden" name="method" id='method'  value="orderReserveCar">
                            <input type="hidden" name="carId" value="{$carId}">
                            <input type="hidden" name="carType" value="{$carType}">
                                <div class="form-car-reservation-grid">
                                        <div class="item-input-car ">
                                                <label for="count_people">
                                                        ##Count##
                                                        <span>
                                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                <input type="text" id="count_people" name="count_people" placeholder="##PassengerFour##">
                                                <i class="icon-input-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path></svg>
                                                </i>
                                        </div>
                                        <div class="item-input-car ">
                                                <label for="date-lease">
                                                        ##rentDate##
                                                        <span>
                                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                {if $rentDate}
                                                <input type="text" id="rent_date" name="rent_date" value='{$rentDate}'  placeholder="{$rentDate}" >
                                                {else}
                                                <input type="text" id="rent_date" name="rent_date"  placeholder="##rentDate##" >
                                                {/if}
                                                <i class="icon-input-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path></svg>
                                                </i>
                                        </div>
                                        <div class="item-input-car state">
                                                <label>
                                                        ##rentPlace##
                                                        <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"/></svg></span>
                                                </label>
                                                <select class="select2 selectCountry" name="rent_place" id="rent_place">
                                                        <option value="" disabled selected>##ChoseOption##...</option>
                                                        {if $client_id=='304'}
                                                        {foreach $obj_main_page->getCarCityList() as $key => $city}
                                                                <option value="{$city['id']}" {if $rentPlace==$city['id']} selected {/if}>
                                                                        ##State## {$city['name']}
                                                                </option>
                                                        {/foreach}
                                                        {else}
                                                        {foreach $objCity->getCityAll() as $key => $city}
                                                                <option value="{$city['id']}" {if $rentPlace==$city['id']} selected {/if}>
                                                                        ##State## {$city['name']}
                                                                </option>
                                                        {/foreach}
                                                        {/if}
                                                        <option value="202" {if $rentPlace==202} selected {/if}>سایر</option>
                                                </select>
                                                <i class="icon-input-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 240C218.5 240 240 218.5 240 192C240 165.5 218.5 144 192 144C165.5 144 144 165.5 144 192C144 218.5 165.5 240 192 240zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 32C103.6 32 32 103.6 32 192C32 207.6 37.43 229 48.56 255.4C59.47 281.3 74.8 309.4 92.14 337.5C126.2 392.8 166.6 445.7 192 477.6C217.4 445.7 257.8 392.8 291.9 337.5C309.2 309.4 324.5 281.3 335.4 255.4C346.6 229 352 207.6 352 192C352 103.6 280.4 32 192 32z"></path></svg>
                                                </i>
                                        </div>
                                        <div class="item-input-car ">
                                                <label for="delivery-date">
                                                        ##Deliverydate##
                                                        <span>
                                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                {if $deliveryDate}
                                                        <input type="text" id="delivery_date" name="delivery_date" value='{$deliveryDate}'  placeholder="{$delivery_date}" >
                                                {else}
                                                        <input type="text" id="delivery_date" name="delivery_date"  placeholder="##Deliverydate##" >
                                                {/if}
                                                <i class="icon-input-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path></svg>
                                                </i>
                                        </div>
                                        <div class="item-input-car state">
                                                <label>
                                                        ##recivePlace##
                                                        <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"/></svg></span>
                                                </label>
                                                <select class="select2 selectCountry" name="delivery_place" id="delivery_place">
                                                        <option value="" disabled selected>##ChoseOption##...</option>
                                                       {if $client_id=='304'}
                                                        {foreach $obj_main_page->getCarCityList() as $key => $city}
                                                                <option value="{$city['id']}" {if $deliveryPlace==$city['id']} selected {/if}>
                                                                        ##State## {$city['name']}
                                                                </option>
                                                        {/foreach}
                                                        {else}
                                                       {foreach $objCity->getCityAll() as $key => $city}
                                                               <option value="{$city['id']}" {if $deliveryPlace==$city['id']} selected {/if}>
                                                                       ##State## {$city['name']}
                                                               </option>
                                                       {/foreach}
                                                        {/if}
                                                        <option value="202" {if $deliveryPlace==202} selected {/if}>سایر</option>

                                                </select>
                                                <i class="icon-input-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 240C218.5 240 240 218.5 240 192C240 165.5 218.5 144 192 144C165.5 144 144 165.5 144 192C144 218.5 165.5 240 192 240zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 32C103.6 32 32 103.6 32 192C32 207.6 37.43 229 48.56 255.4C59.47 281.3 74.8 309.4 92.14 337.5C126.2 392.8 166.6 445.7 192 477.6C217.4 445.7 257.8 392.8 291.9 337.5C309.2 309.4 324.5 281.3 335.4 255.4C346.6 229 352 207.6 352 192C352 103.6 280.4 32 192 32z"></path></svg>
                                                </i>
                                        </div>
                                        <div class="item-input-car ">
                                                <label for="name">
                                                        ##Namefamily##
                                                        <span>
                                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                {if $user_info['name'] || $user_info['family']}
                                                <input type="text" id="name" name="name" value='{$user_info['name']} {$user_info['family']}' placeholder=" ##YourNameFamily##...">
                                                {else}
                                                <input type="text" id="name" name="name" value='' placeholder=" ##YourNameFamily##...">
                                                {/if}
                                                <i class="icon-input-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path></svg>
                                                </i>
                                        </div>
                                        <div class="item-input-car">
                                                <label for="email">ایمیل
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                {if $user_info['email']}
                                                        <input type="text" id="email" name="email" value='{$user_info['email']}' placeholder=" ##emailUser##...">
                                                {else}
                                                        <input type="text" id="email" name="email" value='' placeholder=" ##emailUser##...">
                                                {/if}
                                                <i class="icon-input-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM32 128V167.9L227.6 311.3C244.5 323.7 267.5 323.7 284.4 311.3L480 167.9V128C480 110.3 465.7 96 448 96H63.1C46.33 96 31.1 110.3 31.1 128H32zM32 207.6V384C32 401.7 46.33 416 64 416H448C465.7 416 480 401.7 480 384V207.6L303.3 337.1C275.1 357.8 236.9 357.8 208.7 337.1L32 207.6z"></path></svg></i>
                                        </div>
                                        <div class="item-input-car">
                                                <label for="mobile">
                                                        ##YourMobileNumber##
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                {if $user_info['mobile']}
                                                        <input type="text" id="mobile" name="mobile" value='{$user_info['mobile']}' placeholder=" ##YourMobileNumber##...">
                                                {else}
                                                        <input type="text" id="mobile" name="mobile" value='' placeholder=" ##YourMobileNumber##...">
                                                {/if}
                                                <i class="fa-light fa-phone-rotary icon-input-item"></i>
                                        </div>
                                        <div class="item-input-car">
                                                <label for="mobile">
                                                        ##Securitycode##
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                                        </span>
                                                </label>
                                                <div class="itemCapcha w-100" >
                                                        <input  type="number" placeholder="##Securitycode##" name="item-captcha" id="item-captcha">
                                                        <i class="icon-input-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 192V128C96 57.31 153.3 0 224 0C294.7 0 352 57.31 352 128V192H368C412.2 192 448 227.8 448 272V432C448 476.2 412.2 512 368 512H80C35.82 512 0 476.2 0 432V272C0 227.8 35.82 192 80 192H96zM128 192H320V128C320 74.98 277 32 224 32C170.1 32 128 74.98 128 128V192zM32 432C32 458.5 53.49 480 80 480H368C394.5 480 416 458.5 416 432V272C416 245.5 394.5 224 368 224H80C53.49 224 32 245.5 32 272V432z"/></svg>
                                                        </i>
                                                        <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid=" alt="captcha image">
                                                        <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                                                </div>
                                                <i class="fa-light fa-phone-rotary icon-input-item"></i>
                                        </div>

                                </div>

                            <button type="submit" class="btn-reservation-car submit-button">
                                    ##ReserveCar##
                            </button>
                        </form>
                </div>
        </div>
</section>

