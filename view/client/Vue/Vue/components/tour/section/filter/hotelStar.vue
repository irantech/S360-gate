<template>
   <div class="parent-tour-star">
      <div class="accordion_tour" id="tour-star">
         <div class="parent-accordion-side-bar">
            <div class="title-side-bar" id="title-three">
               <button
                  class="btn btn-link btn-block btn-accordion-side-bar"
                  type="button"
                  data-toggle="collapse"
                  data-target="#body-data-collapse-three"
                  aria-expanded="true"
                  aria-controls="body-data-collapse-three">
                  <h2>ستاره هتل</h2>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z" />
                  </svg>
               </button>
            </div>

            <div
               id="body-data-collapse-three"
               class="collapse show"
               aria-labelledby="title-three"
               data-parent="#tour-star">
               <div class="content-side-bar-tour-star">
                  <div
                     v-for="(star, index) in availableStars"
                     :key="index"
                     class="styled-checkbox">
                     <input
                        v-model="selected_stars"
                        :value="star"
                        type="checkbox"
                        :id="`${star}-star`" />
                     <label :for="`${star}-star`">
                        <span class="">
                           <svg
                              v-for="i in star"
                              :key="i"
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 576 512">
                              <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                              <path
                                 d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                           </svg>
                        </span>
                        <h4>{{ star }} ستاره</h4>
                     </label>
                  </div>

                  <div class="styled-checkbox">
                     <input
                        type="checkbox"
                        value="0"
                        v-model="selected_stars"
                        id="zero-star" />
                     <label for="zero-star">
                        <h4>نمایش هتل های بدون ستاره</h4>
                     </label>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
export default {
   name: "hotel-star",
   data() {
      return {
         none_star: false,
         selected_stars: [],
      }
   },
   computed: {
      availableStars() {
         return this.$store.state.tours.filters.defaultData.hotel_stars
      },
      customFilters: {
         get() {
            return this.$store.state.tours.filters.customData
         },
         set(new_val) {
            this.$store.commit("setTourCustomFilters", new_val)
         },
      },
   },
   methods: {
      setSearchedName() {
         this.$emit("setHotelStar", this.selected_stars)
      },
   },
   watch: {
      selected_stars(newValue) {
         if (newValue) {
            this.setSearchedName()
         }
      },
   },
}
</script>
