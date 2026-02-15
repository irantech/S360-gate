<template>
   <div class="select position-unset inp-s-num adt box-of-count-nafar">
      <div
         @click="form[strategy].options.passengers = true"
         class="box-of-count-nafar-boxes">
         <span class="text-count-nafar" v-if='form[strategy].passengers.count || form[strategy].duration'>
            {{ form[strategy].passengers.count }} مسافر ,
            {{ form[strategy].duration }} روزه
         </span>
        <span class="text-count-nafar" v-else>
            اطلاعات بیمه
         </span>
         <span class="fas fa-caret-down down-count-nafar"></span>
      </div>
      <div
         @click.self="accept_data"
         class="fixed-black"
         :class="form[strategy].options.passengers ? 'active' : ''">
         <div
            class="cbox-count-nafar p-3"
            :class="form[strategy].options.passengers ? 'active' : ''">
            <div class="col-md-12 mb-3 p-0">
               <h3 class="font-weight-bold m-0 font-19">اطلاعات بیمه</h3>
            </div>

            <div class="col-md-12 p-0 bozorg-num mb-2">
               <div
                  class="align-items-center d-flex flex-wrap justify-content-between row">
                  <div class="d-flex p-0">
                     <div class="type-of-count-nafar">
                        <h6>تعداد مسافران</h6>
                        <span class="text-muted">حداقل یک نفر</span>
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
                           >{{ form[strategy].passengers.count }}</i
                        >
                        <i
                           @click="decreaseCount('passengers_count')"
                           :class="
                              form[strategy].passengers.count <= 1
                                 ? 'opacity-5'
                                 : ''
                           "
                           class="fas fa-minus m-0 counting-of-count-nafar minus-nafar site-bg-main-color"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-md-12 p-0 bozorg-num mb-2">
               <div
                  class="align-items-center d-flex flex-wrap justify-content-between row">
                  <div class="d-flex p-0">
                     <div class="type-of-count-nafar">
                        <h6>مدت سفر</h6>
                        <span class="text-muted">حداقل پنج روز</span>
                     </div>
                  </div>
                  <div class="d-flex p-0">
                    <div class="form-group">
                      <select
                        class="form-group w-100"
                        v-model="form[strategy].duration">
                        <option value="0" selected disabled>انتخاب مدت سفر</option>
                        <option value="5">تا 5 روز</option>
                        <option value="7">تا 7 روز</option>
                        <option value="8">تا 8 روز</option>
                        <option value="15">تا 15 روز</option>
                        <option value="23">تا 23 روز</option>
                        <option value="31">تا 31 روز</option>
                        <option value="45">تا 45 روز</option>
                        <option value="62">تا 62 روز</option>
                        <option value="92">تا 92 روز</option>
                        <option value="182">تا 182 روز</option>
                        <option value="186">تا 186 روز</option>
                        <option value="365">تا 365 روز</option>
                      </select>
                    </div>
                  </div>
               </div>
            </div>

            <div class="div_btn">
               <span
                  @click="accept_data"
                  class="btn btn-block btn-close site-bg-main-color"
                  >تأیید</span
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
         let passenger_max = this.form[this.strategy].passengers.max
         let all_passengers_count = this.form[this.strategy].passengers.count

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
                  title: "حداکثر تعداد مسافران " + passenger_max + " نفر است.",
               })
            }
            return false
         }
      },
      increaseCount() {
         if (this.canAdd()) {
            let current_passenger_count =
               this.form[this.strategy].passengers.count

            this.form[this.strategy].passengers.count =
               current_passenger_count + 1
         }
      },
      decreaseCount() {
         let current_passenger_count = this.form[this.strategy].passengers.count

         if (current_passenger_count > 1) {
            this.form[this.strategy].passengers.count =
               current_passenger_count - 1
         }
      },
      accept_data() {
         this.form[this.strategy].options.passengers = false
      },
   },
}
</script>
