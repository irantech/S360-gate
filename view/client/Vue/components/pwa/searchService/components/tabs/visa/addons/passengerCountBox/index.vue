<template>
   <div class="select position-unset inp-s-num adt box-of-count-nafar">
      <div
         @click="form.local.options.passengers = true"
         class="box-of-count-nafar-boxes">
         <span class="text-count-nafar" v-if='form.local.passengers.count || form.local.duration'>
            {{ form.local.passengers.count }} {{ useXmltag('Passenger') }}
         </span>
        <span class="text-count-nafar" v-else>
           {{ useXmltag('Informationpassenger') }}
         </span>
         <span class="fas fa-caret-down down-count-nafar"></span>
      </div>
      <div
         @click.self="accept_data"
         class="fixed-black"
         :class="form.local.options.passengers ? 'active' : ''">
         <div
            class="cbox-count-nafar p-3"
            :class="form.local.options.passengers ? 'active' : ''">
            <div class="col-md-12 mb-3 p-0">
               <h3 class="font-weight-bold m-0 font-19">{{ useXmltag('Informationpassenger') }}</h3>
            </div>

            <div class="col-md-12 p-0 bozorg-num mb-2">
               <div
                  class="align-items-center d-flex flex-wrap justify-content-between row">
                  <div class="d-flex p-0">
                     <div class="type-of-count-nafar">
                        <h6>{{ useXmltag('Countpassengers') }}</h6>
                        <span class="text-muted">{{ useXmltag('AtLeastOnePerson') }}</span>
                     </div>
                  </div>
                  <div class="d-flex p-0">
                     <div class="num-of-count-nafar">
                        <i
                           @click="increaseCount('passengers_count')"
                           :class="
                              canAdd('passengers_count', false)
                                 ? ''
                                 : 'opacity-5'
                           "
                           class="fas fa-plus m-0 counting-of-count-nafar site-bg-main-color"></i>
                        <i
                           class="number-count counting-of-count-nafar"
                           data-value="l-bozorgsal"
                           id="bozorgsal"
                           >{{ form.local.passengers.count }}</i
                        >
                        <i
                           @click="decreaseCount('passengers_count')"
                           :class="
                              form.local.passengers.count <= 1
                                 ? 'opacity-5'
                                 : ''
                           "
                           class="fas fa-minus m-0 counting-of-count-nafar minus-nafar site-bg-main-color"></i>
                     </div>
                  </div>
               </div>
            </div>



            <div class="div_btn">
               <span
                  @click="accept_data"
                  class="btn btn-block btn-close site-bg-main-color"
                  >{{ useXmltag('Approve') }}</span
               >
            </div>
         </div>
      </div>
   </div>
</template>
<script>
export default {
   name: "passenger-count-box",
   props: ["form", "strategy"],
   data() {
      return {
         passengers_index: [
            {
               duration_index: "0",
               count: "0",
            },
         ],
      }
   },
   methods: {
      canAdd(show_error = true) {
         let passenger_max = this.form.local.passengers.max
         let all_passengers_count = this.form.local.passengers.count

         if (all_passengers_count < passenger_max) {
            return true
         } else {
            if (show_error) {
               this.$swal({
                  icon: "error",
                  toast: true,
                  position: "bottom",
                  showConfirmButton: false,
                  timer: 4000,
                  timerProgressBar: true,
                  title: useXmltag('maximum') + useXmltag('Countpassengers') + passenger_max + useXmltag('People'),
               })
            }
            return false
         }
      },
      increaseCount() {
         if (this.canAdd()) {
            let current_passenger_count =
               this.form.local.passengers.count

            this.form.local.passengers.count =
               current_passenger_count + 1
         }
      },
      decreaseCount() {
         let current_passenger_count = this.form.local.passengers.count

         if (current_passenger_count > 1) {
            this.form.local.passengers.count =
               current_passenger_count - 1
         }
      },
      accept_data() {
         this.form.local.options.passengers = false
      },
   },
}
</script>
