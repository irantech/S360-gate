<template>
   <div class="parent-tour-types">
      <div class="accordion_tour" id="tour-types">
         <div class="parent-accordion-side-bar">
            <div class="title-side-bar" id="title-four">
               <button
                  class="btn btn-link btn-block btn-accordion-side-bar"
                  type="button"
                  data-toggle="collapse"
                  data-target="#body-data-collapse-four"
                  aria-expanded="true"
                  aria-controls="body-data-collapse-four">
                  <h2>نوع حمل و نقل</h2>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z" />
                  </svg>
               </button>
            </div>
            <div
               id="body-data-collapse-four"
               class="collapse show"
               aria-labelledby="title-four"
               data-parent="#tour-types">
               <div class="content-side-bar-tour-type">
<!--                  <div class="styled-checkbox">
                     <input
                        type="checkbox"
                        value="0"
                        id="00-vehicle-type"
                        v-model="selectedVehicle"
                        checked="checked" />
                     <label for="00-vehicle-type"> همه </label>
                  </div>-->
                  <div
                     v-for="(type, index) in availableVehicles"
                     :key="index"
                     class="styled-checkbox">
                     <input
                        type="checkbox"
                        :value="type"
                        :id="`${index}-vehicle-company`"
                        v-model="selectedVehicle" />
                     <label :for="`${index}-vehicle-company`">
                        {{ type }}
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
   name: "transportation-type",
   data() {
      return {
         none_star: false,
         selectedVehicle: [],
      }
   },
   computed: {
      availableVehicles() {
         return this.$store.state.tours.filters.defaultData.vehicle_types
      }
   },
   methods: {
      setVehicle() {
         this.$emit("setVehicle", this.selectedVehicle)
      },
   },
   watch: {
      selectedVehicle(newValue) {
         if (newValue) {
            this.setVehicle()
         }
      },
   },
}
</script>
