<template>
   <div
      class="international-available-item-left-Cell my-slideup"
      v-if="
         (each_price_flight.capacity > 0 ||
            each_price_flight.source_id == '14' ||
            each_price_flight.source_id == '15') &&
         price_adult > 0
      ">
      <div class="inner-avlbl-itm">
         <div class="">
            <span class="iranL priceSortAdt">
               <template
                  v-if="each_price_flight.price.adult.with_discount > 0">
                  <i
                     class="iranB text-decoration-line displayb CurrencyCal d-block"
                     :data-amount="price_adult"
                     v-if="checkCurrency">
                     {{ price_adult | formatNumberDecimal }}
                  </i>
                  <i
                     class="iranB text-decoration-line site-main-text-color-drck CurrencyCal"
                     :data-amount="price_adult"
                     v-else>
                     {{
                        (($store.state.isCounter || $store.state.isSafar360) &&
                        each_price_flight.flight_type_li == "system" &&
                        !each_price_flight.is_foreign_airline
                           ? price_adult -
                             each_price_flight.price.adult.markup_amount
                           : price_adult) | formatNumber
                     }}
                  </i>

                  <div class="parent-new-price">
                     <i
                        class="iranB site-main-text-color-drck CurrencyCal"
                        :data-amount="
                           each_price_flight.price.adult.with_discount
                        "
                        v-if="checkCurrency">
                        {{ price_adult_with_discount | formatNumberDecimal }}
                     </i>
                     <i
                        class="iranB site-main-text-color-drck CurrencyCal"
                        :data-amount="
                           each_price_flight.price.adult.with_discount
                        "
                        v-else>
                        {{
                           (($store.state.isCounter ||
                              $store.state.isSafar360) &&
                           each_price_flight.flight_type_li == "system" &&
                           !each_price_flight.is_foreign_airline
                              ? price_adult_with_discount -
                                each_price_flight.price.adult.markup_amount
                              : price_adult_with_discount) | formatNumber
                        }}
                     </i>
                     <span class="CurrencyText">
                        {{ title_currency }}
                     </span>
                  </div>
               </template>
               <template v-else>
                  <i
                     class="iranB site-main-text-color-drck CurrencyCal"
                     :data-amount="price_adult"
                     v-if="checkCurrency">
                     {{ price_adult | formatNumberDecimal }}
                  </i>
                  <i
                     class="iranB site-main-text-color-drck CurrencyCal"
                     :data-amount="price_adult"
                     v-else>
                     {{
                        (($store.state.isCounter || $store.state.isSafar360) &&
                        each_price_flight.flight_type_li == "system" &&
                        !each_price_flight.is_foreign_airline
                           ? price_adult -
                             each_price_flight.price.adult.markup_amount
                           : price_adult) | formatNumber
                     }}
                  </i>
                  <span class="CurrencyText">
                     {{ title_currency }}
                  </span>
               </template>
            </span>
            <div class="SelectTicket">
               <template v-if="each_price_flight.source_id == 'special'">
                  <a
                     class="international-available-btn site-bg-main-color site-main-button-color-hover SendInfoReservationFlight"
                     :id="`btnReservationFlight_${each_price_flight.flight_id}`"
                     @click="
                        sendInfoReservationFlightForeign(
                           `${each_price_flight.flight_id}`
                        )
                     ">
                     {{ useXmltag("Selectionflight") }}
                  </a>
               </template>
               <template v-else>
                  <a
                     class="international-available-btn site-bg-main-color site-main-button-color-hover nextStepclass price-btn--new"
                     :id="`nextStep_${each_price_flight.flight_id.replace(
                        '#',
                        ''
                     )}`"
                     v-if="each_price_flight.return_route != ''">
                     {{ useXmltag("Selectionflight") }}
                     <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512">
                        <path
                           data-v-00f5dc0f=""
                           d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path>
                     </svg>
                  </a>
                  <a
                     class="international-available-btn site-bg-main-color site-main-button-color-hover nextStepclass"
                     :id="`nextStep_${each_price_flight.flight_id.replace(
                        '#',
                        ''
                     )}${each_price_flight.return_routes.flight_id_return.replace(
                        '#',
                        ''
                     )}`"
                     v-else>
                     {{ useXmltag("Selectionflight") }}
                  </a>
               </template>

               <input
                  type="hidden"
                  value=""
                  name="session_filght_Id"
                  id="session_filght_Id" />
               <span
                  class="f-loader-check f-loader-check-change"
                  :id="`loader_check_${each_price_flight.flight_id.replace(
                     '#',
                     ''
                  )}`"
                  style="display: none"></span>

               <input type="hidden" value="" class="CurrencyCode" />
               <input
                  type="hidden"
                  :value="each_price_flight.flight_id"
                  class="FlightID" />
               <input
                  type="hidden"
                  :value="each_price_flight.return_routes.return_flight_id"
                  class="ReturnFlightID" />
               <input type="hidden" :value="price_adult" class="AdtPrice" />
               <input
                  type="hidden"
                  :value="each_price_flight.price.child.price"
                  class="ChdPrice" />
               <input
                  type="hidden"
                  :value="each_price_flight.price.infant.price"
                  class="InfPrice" />
               <input
                  type="hidden"
                  :value="each_price_flight.cabin_type"
                  class="CabinType" />
               <input
                  type="hidden"
                  :value="each_price_flight.airline"
                  id="Airline_Code"
                  class="Airline_Code" />
               <input
                  type="hidden"
                  :value="each_price_flight.source_id"
                  id="SourceId"
                  class="SourceId" />
               <input
                  type="hidden"
                  :value="each_price_flight.flight_type_li"
                  id="FlightType"
                  class="FlightType" />
               <input
                  type="hidden"
                  :value="each_price_flight.unique_code"
                  id="uniqueCode"
                  class="uniqueCode" />
               <input
                  type="hidden"
                  :value="each_price_flight.capacity"
                  id="Capacity"
                  class="priceWithoutDiscount" />
               <input
                  type="hidden"
                  :value="data_search.dataSearch.adult"
                  id="CountAdult"
                  class="CountAdult" />
               <input
                  type="hidden"
                  :value="data_search.dataSearch.child"
                  id="CountChild"
                  class="CountChild" />
               <input
                  type="hidden"
                  :value="data_search.dataSearch.infant"
                  id="CountInfant"
                  class="CountInfant" />
               <input type="hidden" value="dept" class="FlightDirection" />
               <input
                  type="hidden"
                  value="reservation"
                  id="typeApplication"
                  class="typeApplication"
                  v-if="each_price_flight.source_id == 'special'" />
               <input
                  type="hidden"
                  value="privateCharter"
                  id="PrivateCharter"
                  class="PrivateCharter"
                  v-if="each_price_flight.source_id == 'special'" />
               <input
                  type="hidden"
                  :value="each_price_flight.flight_id"
                  id="IdPrivate"
                  class="IdPrivate"
                  v-if="each_price_flight.source_id == 'special'" />
               <input
                  type="hidden"
                  :value="each_price_flight.flight_id_return"
                  id="flight_id_return"
                  class="flight_id_return"
                  v-if="each_price_flight.source_id == 'special'" />
            </div>
            <div
               class="sandali-span2 d-block w-100 iranL site-main-text-color number-chairs--new">
               {{ each_price_flight.capacity }} {{ useXmltag("Chair") }}
            </div>
         </div>
      </div>
   </div>
   <div class="international-available-item-left-Cell my-slideup" v-else>
      <div class="inner-avlbl-itm">
         <div class="SelectTicket">
            <a class="international-available-btn flight-false">{{
               useXmltag("FullCapacity")
            }}</a>
         </div>
      </div>
   </div>
</template>

<script>
export default {
   name: "priceFlight",
   props: ["each_price_flight", "data_search"],
   data() {
      return {
         check_currency_data: true,
         source_allow_empty: [14, 15],
      }
   },
   computed: {
      checkCurrency() {
         let info_price = this.$store.state.priceCurrency
         if (this.check_currency_data) {
            return (
               Object.keys(info_price).length > 1 ||
               this.each_price_flight.currency_code > 0
            )
         }
         return this.check_currency_data
      },
      price_adult() {
         let info_price = this.$store.state.priceCurrency
         let price = this.each_price_flight.price.adult.price
         let price_with_out_currency =
            this.each_price_flight.price.adult.price_with_out_currency
         if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 1) {
               if (info_price.data.CurrencyCode > 0) {
                  this.check_currency_data = true
                  return (
                     price_with_out_currency / info_price.data.EqAmount
                  ).toFixed(2)
               }
            } else if (Object.keys(info_price.data).length === 0) {
               this.check_currency_data = false
               return price_with_out_currency
            }
         }

         return price
      },
      price_adult_with_discount() {
         let info_price = this.$store.state.priceCurrency
         let price = this.each_price_flight.price.adult.with_discount
         let price_discount_with_out_currency =
            this.each_price_flight.price.adult.price_discount_with_out_currency


         if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 1) {
               if (info_price.data.CurrencyCode > 0) {
                  this.check_currency_data = true
                  return (
                     price_discount_with_out_currency / info_price.data.EqAmount
                  ).toFixed(2)
               }
            } else if (Object.keys(info_price.data).length === 0) {
               this.check_currency_data = false
               return price_discount_with_out_currency
            }
         }
         return price
      },
      title_currency() {
         let info_price = this.$store.state.priceCurrency
         let type_currency = this.each_price_flight.price.adult.type_currency
         if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 0) {
               if (info_price.data.CurrencyCode > 0) {
                  return info_price.data.CurrencyTitleEn
               }
            } else if (Object.keys(info_price.data).length === 0) {
               return useXmltag("Rial")
            }
         }
         return type_currency
      },
   },
   methods: {
      checkSource() {
         return this.source_allow_empty.includes(
            this.each_price_flight.source_id
         )
      },
   },
}
</script>

<style scoped></style>