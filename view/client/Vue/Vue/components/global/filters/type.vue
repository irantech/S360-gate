<template>
  <div class="parent-flight-type">
    <div class="accordion" id="flight-type">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-two">
          <button class="btn btn-link btn-block btn-accordion-side-bar" type="button" data-toggle="collapse" data-target="#body-data-collapse-two" aria-expanded="true" aria-controls="body-data-collapse-two">
            <h2>{{ useXmltag('Typeflight')}}</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z"/></svg>
          </button>
        </div>
        <div id="body-data-collapse-two" class="collapse show" aria-labelledby="title-two" data-parent="#flight-type">
          <div class="content-side-bar-flight-type">
            <div class="styled-checkbox">
              <input @change="typeFilterFlight('all_type_flight')"
                type="checkbox" id="all_type_flight" :checked="all_type_flight" value='all_type_flight'/>
              <label for="all_type_flight">{{ useXmltag('All') }}</label>
            </div>
            <div v-for='typeFlight in typeFlightFilter' class="styled-checkbox">
              <input @change="typeFilterFlight(typeFlight.name_en)"  type="checkbox"
                     :id="typeFlight.name_en" :value='typeFlight.name_en' />
              <label :for="typeFlight.name_en">{{typeFlight.name_fa}}</label>
              <h4>{{typeFlight.count}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  export  default  {
    name : 'type',
    data () {
      return {
        type_flight_filter: ['all_type_flight'],
        all_type_flight : 'checked'
      }
    },
    computed: {
      typeFlightFilter() {
        return this.$store.state.typeFlightFilter;
      }
    },
    methods :{
      typeFilterFlight(typeFlight){
        if(!this.type_flight_filter.includes(typeFlight)){
          this.type_flight_filter.push(typeFlight)
        }else{
          let index = this.type_flight_filter.indexOf(typeFlight);
          this.type_flight_filter.splice(index, 1);
        }
        if(this.type_flight_filter.length == 0 ) {
          this.all_type_flight = 'checked'
          this.type_flight_filter = ["all_type_flight"]
        }
        else if(this.type_flight_filter.length > 0 && typeFlight == 'all_type_flight'){
          this.all_type_flight = 'checked'
          this.type_flight_filter.forEach(type => {
            if(type != 'all_type_flight') {
              document.getElementById(type).checked = false
            }
          })
          this.type_flight_filter = ["all_type_flight"]

        }
        else if(typeFlight != 'all_type_flight'){
          this.all_type_flight = ''
          if(this.type_flight_filter.includes('all_type_flight')){
            let index = this.type_flight_filter.indexOf('all_type_flight');
            this.type_flight_filter.splice(index, 1);
          }
        }
        this.$store.commit('typeFlightFilter', this.type_flight_filter);
  }
    }
  }
</script>