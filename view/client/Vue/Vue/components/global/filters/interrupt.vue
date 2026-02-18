<template>
  <div class="parent-flight-time-move">
    <div class="accordion" id="flight-time-move">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-five">
          <button class="btn btn-link btn-block btn-accordion-side-bar" type="button" data-toggle="collapse" data-target="#body-data-collapse-five" aria-expanded="true" aria-controls="body-data-collapse-five">
            <h2>{{ useXmltag('Stop')}}</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z"/></svg>
          </button>
        </div>
        <div id="body-data-collapse-five" class="collapse show" aria-labelledby="title-four" data-parent="#flight-time-move">
          <div class="content-side-bar-flight-type">
            <div class="styled-checkbox">
              <input @change="interruptFilterFlight('all_stop')"
                     type="checkbox" id="all_stop" :checked="all_interrupt" value='all_stop' />
              <label for="all_stop">{{ useXmltag('All') }}</label>
            </div>
            <div v-for='interrupt in interruptFilter' class="styled-checkbox">
              <input @change="interruptFilterFlight(interrupt.name_en)" type="checkbox"
                     :id="interrupt.name_en" :value="interrupt.name_en" />
              <label class="label-airline" :for="interrupt.name_en">
                <span>{{ interrupt.name_fa }}</span>
                <h4>{{ interrupt.value }}</h4>
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
  name : 'interrupt-filter',
  data(){
    return {
      interrupt_filter: ['all_stop'],
      all_interrupt: 'checked'
    }
  },
  computed: {
    interruptFilter() {
      return this.$store.state.interrupt;
    }
  },
  methods : {
    interruptFilterFlight(interrupt){

      if(!this.interrupt_filter.includes(interrupt)){
        this.interrupt_filter.push(interrupt)
      }else{
        let index = this.interrupt_filter.indexOf(interrupt);
        this.interrupt_filter.splice(index, 1);
      }

      if(this.interrupt_filter.length == 0 ) {
        this.all_interrupt = 'checked'
        this.interrupt_filter = ["all_stop"]
      }
      else if(this.interrupt_filter.length > 0 && interrupt == 'all_stop'){
        this.all_interrupt = 'checked'
        this.interrupt_filter.forEach(stop => {
          if(stop != 'all_stop') {
            document.getElementById(stop).checked = false
          }
        })
        this.interrupt_filter = ["all_stop"]

      }
      else if(interrupt != 'all_stop'){
        this.all_interrupt = ''
        if(this.interrupt_filter.includes('all_stop')){
          let index = this.interrupt_filter.indexOf('all_stop');
          this.interrupt_filter.splice(index, 1);
        }
      }
      this.$store.commit('stopFilter', this.interrupt_filter);
    }
  }
}
</script>