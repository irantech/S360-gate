{load_presentation_object filename="resultTourLocal" assign="objTour"}
{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')}

{if $objTour->accessReservationTour() and $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}

    {load_presentation_object filename="reservationTour" assign="objResult"}
    {assign var="infoTour" value=$objResult->infoTourById($smarty.get.id)}
    {assign var="tourId" value=$infoTour['id']}

    {if $infoTour['user_id'] eq $smarty.session.userId}




            <div class="main-Content-top s-u-passenger-wrapper-change">
                <!-- بخش توضیحات جدید -->
                <div class="info-panel site-main-bg-color-light" style="margin-bottom: 20px; padding: 15px; border-radius: 8px; border-right: 4px solid #FF9800;">
                    <div style="display: flex; align-items: flex-start;">
                        <div style="margin-left: 15px; flex: 1;">
                            <h4 style="margin: 0 0 8px 0; color: #333; display: flex; align-items: center;">
                                <i class="zmdi zmdi-info-outline zmdi-hc-fw" style="color: #FF9800; margin-left: 8px;"></i>
                                راهنمای تغییر قیمت پکیج‌ها
                            </h4>
                            <p style="margin: 0; color: #555; line-height: 1.6; font-size: 14px;">
                                به میزانی که می خواهید به مبلغ همان تخت اضافه یا کم کنید
                                <span style="color: #F44336; font-weight: 500;">
                                    در صورتی که مبلغ کسر شده از کل مبلغ آن تخت بیشتر باشد ما این تغییر را اعمال نخواهیم کرد
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
        <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart5"></i> ##Pricechange##
    </span>
            <div class="panel-default-change site-border-main-color">
                <form id='changeTourPackagePricesForm' name="changeTourPackagePricesForm" method='post'
                      data-toggle="validator" enctype='multipart/form-data' action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">
                    <input type="hidden" name="flag" id="flag" value="changeTourPackagePrices"/>
                    <input type="hidden" name="itemId" id="itemId" value="{$smarty.get.id}"/>
                    <input type="hidden" name="tourId" id="tourId" value="{$infoTour['id_same']}"/>
                    <input type="hidden" name="userId" id="userId" value="{$infoTour['user_id']}"/>

                    <div class="s-u-result-item-change">

                        <div class="s-u-passenger-item no-star">
                            <label for="threeRoomPriceR">##Roomthreebed## (##Riali##):</label>
                            <div class="input-with-buttons">
                                <button type="button" class="btn-increase" onclick="activateInput('threeRoomPriceR', 'increase')">➕</button>
                                <button type="button" class="btn-decrease" onclick="activateInput('threeRoomPriceR', 'decrease')">➖</button>
                                <input type="hidden" name="threeRoomPriceR_change" id="threeRoomPriceR_change" value="">
                                <input type="text" name="threeRoomPriceR" id="threeRoomPriceR"
                                       value=""
                                       onkeypress="isDigit(this)" onkeyup="separator(this);" disabled>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="doubleRoomPriceR" >##Roomtwobed## (##Riali##):</label>
                            <div class="input-with-buttons">
                                <button type="button" class="btn-change btn-increase" onclick="activateInput('doubleRoomPriceR','increase')">➕</button>
                                <button type="button" class="btn-change btn-decrease" onclick="activateInput('doubleRoomPriceR','decrease')">➖</button>
                                <input type="hidden" name="doubleRoomPriceR_change" id="doubleRoomPriceR_change" value="">
                                <input type="text" name="doubleRoomPriceR" id="doubleRoomPriceR"
                                       value=""
                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" disabled>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="singleRoomPriceR" >##Roomonebed## (##Riali##):</label>
                            <div class="input-with-buttons">
                                <button type="button" class="btn-change btn-increase" onclick="activateInput('singleRoomPriceR','increase')">➕</button>
                                <button type="button" class="btn-change btn-decrease" onclick="activateInput('singleRoomPriceR','decrease')">➖</button>
                                <input type="hidden" name="singleRoomPriceR_change" id="singleRoomPriceR_change" value="">
                                <input type="text" name="singleRoomPriceR" id="singleRoomPriceR"
                                       value=""
                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" disabled>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="childWithBedPriceR">##Childwithbed##:</label>
                            <div class="input-with-buttons">
                                <button type="button" class="btn-change btn-increase" onclick="activateInput('childWithBedPriceR','increase')">➕</button>
                                <button type="button" class="btn-change btn-decrease" onclick="activateInput('childWithBedPriceR','decrease')">➖</button>
                                <input type="hidden" name="childWithBedPriceR_change" id="childWithBedPriceR_change" value="">
                                <input type="text" name="childWithBedPriceR" id="childWithBedPriceR"
                                       value=""
                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" disabled>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="infantWithoutBedPriceR" >##Babywithoutbed##:</label>
                            <div class="input-with-buttons">
                                <button type="button" class="btn-change btn-increase" onclick="activateInput('infantWithoutBedPriceR','increase')">➕</button>
                                <button type="button" class="btn-change btn-decrease" onclick="activateInput('infantWithoutBedPriceR','decrease')">➖</button>
                                <input type="hidden" name="infantWithoutBedPriceR_change" id="infantWithoutBedPriceR_change" value="">
                                <input type="text" name="infantWithoutBedPriceR" id="infantWithoutBedPriceR"
                                       value=""
                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" disabled>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="infantWithoutChairPriceR" >##Babywithoutchair##:</label>
                            <div class="input-with-buttons">
                                <button type="button" class="btn-change btn-increase" onclick="activateInput('infantWithoutChairPriceR','increase')">➕</button>
                                <button type="button" class="btn-change btn-decrease" onclick="activateInput('infantWithoutChairPriceR','decrease')">➖</button>
                                <input type="hidden" name="infantWithoutChairPriceR_change" id="infantWithoutChairPriceR_change" value="">
                                <input type="text" name="infantWithoutChairPriceR" id="infantWithoutChairPriceR"
                                       value=""
                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- دکمه ارسال -->
                    <div class="userProfileInfo-btn userProfileInfo-btn-change">
                        <input id="submitButton" class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                               type="submit" value="##Sendinformation##">
                    </div>
                </form>
            </div>
        </div>

        {assign var="get_list_change_package_price" value=$objResult->getListChangePricePackage($smarty.get.id , $infoTour['id_same'] )}
        {if $get_list_change_package_price}
        <div class="main-Content-bottom-table Dash-ContentL-B-Table ">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                <i class="icon-table"></i><h3>##PriceChangeList##</h3>
            </div>

            <table id="tourList"  class="display" cellspacing="0" width="100%">

                <thead>
                <tr>
                    <th>##Row##</th>
                    <th>##Roomthreebed## (##Riali##)</th>
                    <th>##Roomtwobed## (##Riali##)</th>
                    <th>##Roomonebed## (##Riali##)</th>
                    <th>##Childwithbed##</th>
                    <th>##Babywithoutbed##</th>
                    <th>##Babywithoutchair##</th>
                    <th>##Date##</th>
                </tr>
                </thead>

                <tbody>
                {assign var="number" value="0"}
                {foreach key=key item=item from=$get_list_change_package_price}
                    {$number=$number+1}

                    <tr>
                        <td>{$number}</td>
                        <td><span dir="ltr" style="direction: ltr; text-align: left; display: inline-block;">{if $item['three_room_price_r']}{$item['three_room_price_r']}{else}---{/if}</span></td>
                        <td><span dir="ltr" style="direction: ltr; text-align: left; display: inline-block;">{if $item['double_room_price_r']}{$item['double_room_price_r']}{else}---{/if}</span></td>
                        <td><span dir="ltr" style="direction: ltr; text-align: left; display: inline-block;">{if $item['single_room_price_r']}{$item['single_room_price_r']}{else}---{/if}</span></td>
                        <td><span dir="ltr" style="direction: ltr; text-align: left; display: inline-block;">{if $item['child_with_bed_price_r']}{$item['child_with_bed_price_r']}{else}---{/if}</span></td>
                        <td><span dir="ltr" style="direction: ltr; text-align: left; display: inline-block;">{if $item['infant_without_bed_price_r']}{$item['infant_without_bed_price_r']}{else}---{/if}</span></td>
                        <td><span dir="ltr" style="direction: ltr; text-align: left; display: inline-block;">{if $item['infant_without_chair_price_r']}{$item['infant_without_chair_price_r']}{else}---{/if}</span></td>
                        <td>{$item['created_at']}</td>
                    </tr>
                {/foreach}

            </table>
        </div>

    {/if}

    {else}
        <div class="userProfileInfo-messge">
            <div class="messge-login">##Noaccesstihspage##</div>
        </div>
    {/if}
{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">##Pleasslogin##</div>
    </div>
{/if}
{literal}
<script>
   // ذخیره وضعیت inputها
   const inputStates = {};
   let formSubmitted = false;

   // غیرفعال کردن همه inputها در ابتدا
   document.addEventListener('DOMContentLoaded', function() {
      const allInputs = document.querySelectorAll('.input-with-buttons input[type="text"]');
      allInputs.forEach(input => {
         input.disabled = true;
         // ذخیره مقدار اولیه
         inputStates[input.id] = {
            originalValue: input.value,
            changed: false,
            changeType: '',
            buttonsDisabled: false
         };
      });
   });

   // تابع برای فعال کردن input مورد نظر و تنظیم نوع تغییر
   function activateInput(fieldId, changeType) {
      if (formSubmitted) return;

      const targetInput = document.getElementById(fieldId);
      const hiddenField = document.getElementById(fieldId + "_change");
      const buttons = targetInput.parentElement.querySelectorAll('button');

      // اگر دکمه‌ها غیرفعال نیستند، input را فعال کن
      if (!inputStates[fieldId].buttonsDisabled) {
         targetInput.disabled = false;
         targetInput.focus();

         // تنظیم نوع تغییر و استایل مناسب
         hiddenField.value = changeType;
         inputStates[fieldId].changeType = changeType;

         if (changeType === "increase") {
            targetInput.classList.add('increase-active');
            targetInput.classList.remove('decrease-active');
         } else {
            targetInput.classList.add('decrease-active');
            targetInput.classList.remove('increase-active');
         }
      }
   }

   // بررسی تغییرات در inputها
   document.querySelectorAll('.input-with-buttons input[type="text"]').forEach(input => {
      input.addEventListener('blur', function() {
         if (formSubmitted) return;

         const fieldId = this.id;
         const hiddenField = document.getElementById(fieldId + "_change");
         const buttons = this.parentElement.querySelectorAll('button');

         // حذف کاما از مقدار برای بررسی عددی
         const numericValue = this.value.replace(/,/g, '');

         // اگر مقدار 0 است یا خالی است
         if (numericValue === '0' || numericValue === '') {
            // بازگشت به مقدار اصلی
            this.value = inputStates[fieldId].originalValue;
            this.disabled = true;
            hiddenField.value = '';

            // حذف استایل‌ها
            this.classList.remove('increase-active');
            this.classList.remove('decrease-active');

            // فعال کردن دکمه‌ها
            buttons.forEach(btn => {
               btn.disabled = false;
               btn.style.opacity = '1';
               btn.style.cursor = 'pointer';
            });

            // بازنشانی وضعیت
            inputStates[fieldId].changed = false;
            inputStates[fieldId].buttonsDisabled = false;
         }
         // اگر مقدار تغییر کرده و غیر صفر است
         else if (this.value !== inputStates[fieldId].originalValue) {
            inputStates[fieldId].changed = true;
            inputStates[fieldId].buttonsDisabled = true;

            // غیرفعال کردن دکمه‌های این فیلد
            buttons.forEach(btn => {
               btn.disabled = true;
               btn.style.opacity = '0.5';
               btn.style.cursor = 'not-allowed';
            });
         }
      });
   });

   // تابع برای بررسی اینکه حداقل یک فیلد پر شده است
   function hasAtLeastOneFieldFilled() {
      const fields = [
         'threeRoomPriceR', 'doubleRoomPriceR', 'singleRoomPriceR',
         'childWithBedPriceR', 'infantWithoutBedPriceR', 'infantWithoutChairPriceR'
      ];

      for (const field of fields) {
         const input = document.getElementById(field);
         const hiddenField = document.getElementById(field + "_change");
         const numericValue = input.value.replace(/,/g, '');

         if (numericValue && numericValue !== '0' && hiddenField.value) {
            return true;
         }
      }
      return false;
   }
</script>
{/literal}