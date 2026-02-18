<template>
   <div
      class="international-available-item-left-Cell my-slideup"
      v-if="
         (flight.capacity > 0 || flight.source_id == '14') && price_adult > 0
      ">
      <div class="inner-avlbl-itm">
         <div class="">
            <span class="iranL priceSortAdt">
               <template v-if="flight.price.adult.with_discount > 0">
                  <i
                     class="iranB text-decoration-line displayb CurrencyCal"
                     :data-amount="price_adult"
                     v-if="checkCurrency">
                     {{ price_adult | formatNumberDecimal }}
                  </i>
                  <i
                     class="iranB text-decoration-line site-main-text-color-drck CurrencyCal"
                     :data-amount="price_adult"
                     v-else>
                     {{
                        ((this.$store.state.isCounter ||
                           this.$store.state.isSafar360) &&
                        flight.flight_type_li == "system"
                           ? price_adult - flight.price.adult.markup_amount
                           : price_adult) | formatNumber
                     }}
                  </i>

                  <i
                     class="iranB site-main-text-color-drck CurrencyCal"
                     :data-amount="flight.price.adult.with_discount"
                     v-if="checkCurrency">
                     {{ price_adult_with_discount | formatNumberDecimal }}
                  </i>
                  <i
                     class="iranB site-main-text-color-drck CurrencyCal"
                     :data-amount="flight.price.adult.with_discount"
                     v-else>
                     {{
                        ((this.$store.state.isCounter ||
                           this.$store.state.isSafar360) &&
                        flight.flight_type_li == "system"
                           ? price_adult_with_discount -
                             flight.price.adult.markup_amount
                           : price_adult_with_discount) | formatNumber
                     }}
                     <span class="CurrencyText">
                        {{ title_currency }}
                     </span>
                  </i>
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
                        ((this.$store.state.isCounter ||
                           this.$store.state.isSafar360) &&
                        flight.flight_type_li == "system"
                           ? price_adult - flight.price.adult.markup_amount
                           : price_adult) | formatNumber
                     }}
                     <span class="CurrencyText">
                        {{ title_currency }}
                     </span>
                  </i>
               </template>
            </span>
            <div class="SelectTicket" id="typeFlightPeraian">
               <template v-if="flight.source_id == 'special'">
                  <a
                     class="international-available-btn site-bg-main-color site-main-button-color-hover SendInfoReservationFlight"
                     :id="`btnReservationFlight_${flight.flight_id}`"
                     @click="
                        sendInfoReservationFlightForeign(`${flight.flight_id}`)
                     ">
                     {{ useXmltag("Selectionflight") }}
                  </a>
               </template>
               <template v-else>
                  <button
                     type="button"
                     class="international-available-btn btn btn-block site-bg-main-color site-main-button-color-hover price-btn--new"
                     :class="{skeleton: is_show_loader}"
                     :disabled="is_show_loader"
                     :id="`select${this.$store.state.typeTripFlight}`"
                     @click="changeTripFlight(flight.capacity)">
                     <template
                        v-if="
                           this.data_search.MultiWay === 'TwoWay' &&
                           type != 'twoWay'
                        ">
                        <template
                           v-if="this.$store.state.typeTripFlight === 'dept'">
                           {{ useXmltag("PickWentFlight") }}
                        </template>
                        <template v-else>
                           {{ useXmltag("PickBackFlight") }}
                        </template>
                     </template>
                     <template v-else>
                        {{ useXmltag("Selectionflight") }}
                     </template>
                     <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                           d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path>
                     </svg>
                  </button>
               </template>
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
               <input
                  type="hidden"
                  value=""
                  name="session_filght_Id"
                  id="session_filght_Id" />
               <!--                    <a class="f-loader-check f-loader-check-change":id="`loader_check_${flight.flight_id}`" v-show="is_show_loader"></a>-->
               <input
                  type="hidden"
                  value="reservation"
                  id="typeApplication"
                  class="typeApplication"
                  v-if="flight.source_id == 'special'" />
               <input
                  type="hidden"
                  value="privateCharter"
                  id="PrivateCharter"
                  class="PrivateCharter"
                  v-if="flight.source_id == 'special'" />
               <input
                  type="hidden"
                  :value="flight.flight_id"
                  id="IdPrivate"
                  class="IdPrivate"
                  v-if="flight.source_id == 'special'" />
               <input
                  type="hidden"
                  :value="flight.flight_id_return"
                  id="flight_id_return"
                  class="flight_id_return"
                  v-if="flight.source_id == 'special'" />
            </div>
            <div class="international-available-airlines-log-info">
               <div class="esterdad-blit" v-if="flight.capacity > 0">
                  <span
                     class="sandali-span2 iranL sandali-span2-margin-right site-main-text-color">
                     <i class="font-chanhe"></i>
                     {{ flight.capacity }} {{ useXmltag("Chair") }}
                  </span>
               </div>
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
   props: ["data_search", "flight", "type"],
   data() {
      return {
         check_currency_data: true,
         request_number: 0,
         flight_id: 0,
         adult_count: 0,
         child_count: 0,
         infant_count: 0,
         source_id: 0,
         flight_direction: "dept",
         is_show_loader: false,
      }
   },
   methods: {
      changeTripFlight(capacity) {
         this.is_show_loader = true
         var _this = this
         let request_capacity =
            parseInt(_this.adult_count) + parseInt(_this.child_count)
         if (
            parseInt(capacity) >= request_capacity ||
            (_this.source_id == "14" && capacity < 1)
         ) {
            if (
               _this.data_search.MultiWay === "TwoWay" &&
               _this.type != "twoWay"
            ) {
               if (_this.$store.state.typeTripFlight === "dept") {

                  axios
                     .post(
                        amadeusPath + "ajax",
                        {
                           className: "newApiFlight",
                           method: "revalidateFlight",
                           Flight: _this.flight_id,
                           UniqueCode: _this.request_number,
                           SourceId: _this.source_id,
                           adt: _this.adult_count,
                           chd: _this.child_count,
                           inf: _this.infant_count,
                           FlightDirection: _this.flight_direction,
                        },
                        {
                           "Content-Type": "application/json",
                        }
                     )
                     .then(function (response) {
                        let id_selected = _this.flight_id
                        let id_btn =
                           "select" + _this.$store.state.typeTripFlight
                        const node =
                           document.getElementById(id_selected).lastChild
                        const clone = node.cloneNode(true)
                        document.getElementById("myList1").appendChild(clone)
                        document.getElementById(id_btn).remove()
                        setTimeout(function () {
                           _this.is_show_loader = false
                           // document.getElementById('loader_check_'+id_selected).style.display = 'none';
                           _this.$store.commit("setTypeTripFlight", "return")
                           _this.$store.commit(
                              "setFlightUniqId",
                              response.data.data.result_uniq_id
                           )
                        }, 1000)
                     })
                     .catch(function (error) {
                        _this.is_show_loader = false
                        _this.$swal({
                           icon: "error",
                           toast: true,
                           position: "bottom-end",
                           showConfirmButton: false,
                           timerProgressBar: true,
                           timer: 4000,
                           width: 600,
                           iconColor: "#FFFFFF",
                           background: "#FF0000",
                           title: `<span style="color:#FFFFFF">${error.response.data.data.result_message}</span>`,
                        })
                     })
               } else {
                  axios
                     .post(
                        amadeusPath + "ajax",
                        {
                           className: "newApiFlight",
                           method: "revalidateFlight",
                           Flight: _this.flight_id,
                           UniqueCode: _this.request_number,
                           SourceId: _this.source_id,
                           adt: _this.adult_count,
                           chd: _this.child_count,
                           inf: _this.infant_count,
                           FlightDirection: _this.$store.state.typeTripFlight,
                           uniq_id: _this.$store.state.flightUniqId,
                        },
                        {
                           "Content-Type": "application/json",
                        }
                     )
                     .then(function (response) {
                        if (
                           response.data.data.result_status == "SuccessLogged"
                        ) {
                           _this.sendDataToPassengerDetail(response.data.data)
                        } else {
                           _this.sendDataToPassengerDetailWithoutLogin(
                              response.data.data
                           )
                        }
                        // _this.is_show_loader = false;
                     })
                     .catch(function (error) {
                        _this.is_show_loader = false
                        _this.$swal({
                           icon: "error",
                           toast: true,
                           position: "bottom-end",
                           showConfirmButton: false,
                           timerProgressBar: true,
                           timer: 4000,
                           width: 600,
                           iconColor: "#FFFFFF",
                           background: "#2f2f2f",
                           title: `<span style="color:#FFFFFF">${error.response.data.data.result_message}</span>`,
                        })
                     })
               }
            } else {
               axios
                  .post(
                     amadeusPath + "ajax",
                     {
                        className: "newApiFlight",
                        method: "revalidateFlight",
                        Flight: _this.flight_id,
                        UniqueCode: _this.request_number,
                        SourceId: _this.source_id,
                        adt: _this.adult_count,
                        chd: _this.child_count,
                        inf: _this.infant_count,
                        FlightDirection: _this.flight_direction,
                     },
                     {
                        "Content-Type": "application/json",
                     }
                  )
                  .then(function (response) {
                     if (response.data.data.result_status == "SuccessLogged") {
                        _this.sendDataToPassengerDetail(response.data.data)
                     } else {
                        _this.sendDataToPassengerDetailWithoutLogin(
                           response.data.data
                        )
                     }
                     // _this.is_show_loader = false;
                  })
                  .catch(function (error) {
                     _this.is_show_loader = false
                     _this.$swal({
                        icon: "error",
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 4000,
                        width: 600,
                        iconColor: "#FFFFFF",
                        background: "#FF0000",
                        title: `<span style="color:#FFFFFF">${error.response.data.data.result_message}</span>`,
                     })
                  })
            }
         } else {
            _this.is_show_loader = false
            _this.$swal({
               icon: "error",
               toast: true,
               position: "bottom-end",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 4000,
               width: 600,
               iconColor: "#FFFFFF",
               background: "#480808",
               title: `<span style="color:#FFFFFF">${useXmltag(
                  "lowCapacityPassenger"
               )}</span>`,
            })
         }
      },
      sendDataToPassengerDetail(data) {
         let form = document.createElement("form")
         form.setAttribute("method", "POST")
         form.setAttribute(
            "action",
            amadeusPathByLang + "passengersDetailLocal"
         )

         let hiddenField = document.createElement("input")
         hiddenField.setAttribute("name", "temporary")
         hiddenField.setAttribute("value", data.result_uniq_id)
         form.appendChild(hiddenField)

         let hiddenField2 = document.createElement("input")
         hiddenField2.setAttribute("name", "ZoneFlight")
         hiddenField2.setAttribute("value", "Local")
         form.appendChild(hiddenField)
         form.appendChild(hiddenField2)
         document.body.appendChild(form)
         form.submit()
         document.body.removeChild(form)
      },
      sendDataToPassengerDetailWithoutLogin(data) {
         document.getElementById("session_filght_Id").value =
            data.result_uniq_id
         document.getElementById("ZoneFlight").value = "Local"
         let show_popup = document.getElementById("isShowLoginPopup").value


         if (show_popup === "1") {
            setTimeout(function () {
               document
                  .getElementsByClassName("cd-user-modal")[0]
                  .classList.add("is-visible")
            }, 1000)
         } else {
            this.sendDataToPassengerDetail(data)
         }
      },
   },
   computed: {
      checkCurrency() {
         this.request_number = this.flight.unique_code
         this.flight_id = this.flight.flight_id
         this.source_id = this.flight.source_id
         this.adult_count = this.data_search.dataSearch.adult
         this.child_count = this.data_search.dataSearch.child
         this.infant_count = this.data_search.dataSearch.infant
         let info_price = this.$store.state.priceCurrency
         if (this.check_currency_data) {
            return (
               Object.keys(info_price).length > 1 ||
               this.flight.currency_code > 0
            )
         }
         return this.check_currency_data
      },
      price_adult() {
         let info_price = this.$store.state.priceCurrency
         let price = this.flight.price.adult.price
         let price_with_out_currency =
            this.flight.price.adult.price_with_out_currency
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
         let price = this.flight.price.adult.with_discount
         let price_discount_with_out_currency =
            this.flight.price.adult.price_discount_with_out_currency
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
         let type_currency = this.flight.price.adult.type_currency
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
}
</script>

<style scoped></style>