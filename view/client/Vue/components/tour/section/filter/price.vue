<template>
   <div v-if="price_tour_filter && price_tour_filter.length" class="parent-price-basis">
      <div class="accordion_tour" id="price-basis">
         <div class="parent-accordion-side-bar">
            <div class="title-side-bar" id="title-one">
               <button
                  class="btn btn-link btn-block btn-accordion-side-bar"
                  type="button"
                  data-toggle="collapse"
                  data-target="#body-data-collapse-one"
                  aria-expanded="true"
                  aria-controls="body-data-collapse-one">
                  <h2>قیمت</h2>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z" />
                  </svg>
               </button>
            </div>
            <vue-slider
               v-model="value_price"
               :tooltip="'always'"
               :min="min_price_props"
               :max="max_price_props"
               @change="priceRangeSlider(value_price)">
               <template v-slot:tooltip="{value}">
                  <div
                     class="vue-slider-dot-tooltip-inner vue-slider-dot-tooltip-inner-top site-bg-main-color site-border-main-color">
                     {{ value | formatNumber }}
                  </div>
               </template>

               <template v-slot:process="{start, end, style, index}">
                  <div
                     class="vue-slider-process vue-slider-dot-tooltip-inner site-bg-main-color"
                     :style="[style]">
                     <!-- Can add custom elements here -->
                  </div>
               </template>
            </vue-slider>
         </div>
      </div>
   </div>
</template>

<script>
import VueSlider from "vue-slider-component"
import "vue-slider-component/theme/default.css"
export default {
   name: "tour-price",
   components: {
      VueSlider: VueSlider,
   },
   props: ["price_tour_filter"],
   data() {
      return {
        value_price : [0, 0],
        open_filer : false,
         styles: {
            "primary-color": main_color,
         },
      }
   },
   computed: {
      min_price_props() {
         if (this.price_tour_filter.length) return this.price_tour_filter[0]
      },
      max_price_props() {
         if (this.price_tour_filter.length) return this.price_tour_filter[this.price_tour_filter.length -1]
      },
   },
   watch : {
     price_tour_filter() {
       this.open_filer = true
       if (this.price_tour_filter.length){
         if (this.price_tour_filter) {
           this.value_price =  [this.price_tour_filter[0], this.price_tour_filter[this.price_tour_filter.length -1]]
         } else {
           this.value_price = [0, 0]
         }
       }else{
         this.value_price = [0, 0]
       }
       this.$emit("setPriceFilter", this.value_price, true)
     },
   },
   methods: {
       setPriceTourFilter(){
         if (this.price_tour_filter.length){
           if (this.price_tour_filter) {
             this.value_price =  [this.price_tour_filter[0], this.price_tour_filter[this.price_tour_filter.length -1]]
           } else {
             this.value_price = [0, 0]
           }
         }else{
           this.value_price = [0, 0]
         }

       },
      priceRangeSlider(value) {
         let check_min_max_price = true
         if (
            parseInt(value[0]) != parseInt(this.price_tour_filter[0]) ||
            parseInt(value[1]) != parseInt(this.price_tour_filter[this.price_tour_filter.length -1])
         ) {
            check_min_max_price = false
         } else {
            check_min_max_price = true
         }
         this.$emit("setPriceFilter", this.value_price, check_min_max_price)
      },
   },
   mounted () {
      if(!this.open_filer){
        this.setPriceTourFilter();
      }
   }
}
</script>
