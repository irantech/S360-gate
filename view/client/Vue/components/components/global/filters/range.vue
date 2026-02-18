<template>
  <div class="parent-price-basis">
    <div class="accordion" id="price-basis">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-one">
          <button class="btn btn-link btn-block btn-accordion-side-bar" type="button" data-toggle="collapse" data-target="#body-data-collapse-one" aria-expanded="true" aria-controls="body-data-collapse-one">
            <h2>{{ useXmltag('Price')}}</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z"/></svg>
          </button>
        </div>
        <div id="body-data-collapse-one" class="collapse show" aria-labelledby="title-one" data-parent="#price-basis">
          <div class="content-side-bar-price-basis">
            <vue-slider v-model="value_price" :tooltip="'always'" :min="min_price_props" :max="max_price_props"
                        @change="priceRangeSlider(value_price)">
              <template  v-slot:tooltip="{value}">
                <div
                  class="vue-slider-dot-tooltip-inner vue-slider-dot-tooltip-inner-top site-bg-main-color site-border-main-color">
                  {{ value| formatNumber }}
                </div>
              </template>

              <template v-slot:process="{ start, end, style, index }">
                <div class="vue-slider-process vue-slider-dot-tooltip-inner site-bg-main-color" :style="[style]">
                  <!-- Can add custom elements here -->
                </div>
              </template>
            </vue-slider>


<!--            <div class="parent-dot-line">-->
<!--              <div class="dott"></div>-->
<!--              <div class="line-dott"></div>-->
<!--              <div class="dott"></div>-->
<!--            </div>-->
<!--            <div class="parent-number-price">-->
<!--              <h4>{{ useXmltag('From')}} 1,996,400 ریال</h4>-->
<!--              <h4>{{ useXmltag('To')}} 3,101,000 ریال</h4>-->
<!--            </div>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
export  default  {
  name : 'range' ,
  props: ['type'] ,
  components: {
    'VueSlider': VueSlider
  },
  data() {
    return {
      min_price_props: 0,
      max_price_props: 0,
      value_price : [0,0],
      styles: {
        'primary-color': main_color,
      },
    }

  },
  computed : {
    price() {
      if(this.type == 'domestic') {
        if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
          if(this.$store.state.typeTripFlight=== 'dept')
          {
            return this.$store.state.price.dept;
          }else{
            return this.$store.state.price.return;
          }
        }else{
          return this.$store.state.price.dept;
        }
      }else{
        return this.$store.state.price;
      }
    },
  },
  watch : {
    price() {
      if (this.price) {
        this.min_price_props = this.price.min_price
        this.max_price_props = this.price.max_price
        this.value_price = [this.price.min_price, this.price.max_price]
        this.$store.commit('priceFilter', this.value_price , true);
      }
    }
  } ,
  methods : {
    priceRangeSlider(value) {
      if(this.type == 'domestic'){
        let check_min_max_price = true
        if(parseInt(value[0]) != parseInt(this.price.min_price) || parseInt(value[1])!= parseInt(this.price.max_price)){
          check_min_max_price = false;
        }else{
          check_min_max_price = true;
        }
        this.$store.commit('priceFilter', this.value_price , check_min_max_price);
      }else{
        this.$store.commit('priceFilter', this.value_price , true);
      }
    },
  }
}
</script>