<template>
  <div class="parent-flight-airlines">
    <div class="accordion" id="flight-airlines">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-four">
          <button class="btn btn-link btn-block btn-accordion-side-bar" type="button" data-toggle="collapse" data-target="#body-data-collapse-four" aria-expanded="true" aria-controls="body-data-collapse-four">
            <h2>{{ useXmltag('Airlines')}}</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z"/></svg>
          </button>
        </div>
        <div id="body-data-collapse-four" class="collapse show" aria-labelledby="title-four" data-parent="#flight-airlines">
          <div class="content-side-bar-flight-type">
            <div class="styled-checkbox">
              <input  @change="airlineFilterFlight('all_airline')"
                      type="checkbox" id="all-airline" :checked="all_airlines" value='all_airline' />
              <label for="all-airline">{{ useXmltag('All') }}</label>
            </div>
            <div v-for='minPrice in minPriceAirline' class="styled-checkbox">
              <input @change="airlineFilterFlight(minPrice.name_en)"
                     type="checkbox" :id="minPrice.name_en" :value="minPrice.name_en" />
              <label class="label-airline" :for="minPrice.name_en">
                <img :src="`/gds/pic/airline/${minPrice.name_en}.png`" alt="img-airline">
                <span>{{ minPrice.name }}</span>
                <h4>{{ minPrice.price }}</h4>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export  default  {
  name : 'airline' ,
  props :['type'] ,
  data(){
    return {
      airline_filter: ['all_airline'],
      all_airlines : 'checked'
    }
  },
  computed: {
    minPriceAirline() {
      if(this.type == 'domestic') {
        if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
          if(this.$store.state.typeTripFlight === 'dept')
          {
            return this.$store.state.minPriceAirline.dept;
          }else{
            return this.$store.state.minPriceAirline.return;
          }
        }else{
          return this.$store.state.minPriceAirline.dept;
        }
      }else{
        return this.$store.state.minPriceAirline;
      }
    }
  },
  methods :{
    airlineFilterFlight(airline) {
      if(!this.airline_filter.includes(airline)){
        this.airline_filter.push(airline)
      }else{
        let index = this.airline_filter.indexOf(airline);
        this.airline_filter.splice(index, 1);
      }
      if(this.airline_filter.length == 0 ) {
        this.all_airlines = 'checked'
        this.airline_filter = ["all_airline"]
      }
      else if(this.airline_filter.length > 0 && airline == 'all_airline'){
        this.all_airlines = 'checked'
        this.airline_filter.forEach(air => {
          if(air != 'all_airline') {
            document.getElementById(air).checked = false
          }
        })
        this.airline_filter = ["all_airline"]

      }
      else if(airline != 'all_airline'){
        this.all_airlines = ''
        if(this.airline_filter.includes('all_airline')){
          let index = this.airline_filter.indexOf('all_airline');
          this.airline_filter.splice(index, 1);
        }
      }
      this.$store.commit('airlineFilter', this.airline_filter);
    }
  }
}
</script>