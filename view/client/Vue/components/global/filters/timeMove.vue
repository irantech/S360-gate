<template>
  <div class="parent-flight-time-move">
    <div class="accordion" id="flight-time-move">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-five">
          <button class="btn btn-link btn-block btn-accordion-side-bar" type="button" data-toggle="collapse" data-target="#body-data-collapse-five" aria-expanded="true" aria-controls="body-data-collapse-five">
            <h2>{{ useXmltag('Starttime')}}</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z"/></svg>
          </button>
        </div>
        <div id="body-data-collapse-five" class="collapse show" aria-labelledby="title-four" data-parent="#flight-time-move">
          <div class="content-side-bar-flight-type">
            <div class="styled-checkbox">
              <input @change="timeMoveFilterFlight('all_time')"
                type="checkbox" id="all_time" :checked="all_time_move" value='all_time' />
              <label for="all_time">{{ useXmltag('All') }}</label>
            </div>
            <div v-for='time in timeFilter' class="styled-checkbox">
              <input @change="timeMoveFilterFlight(time.time)" type="checkbox"
                     :id="time.time" :value="time.time" />
              <label class="label-airline" :for="time.time">
                <img :src="`/gds/pic/timeFilter/${time.time}.png`" alt="img-airline">
                <span>{{ time.name_fa }}</span>
                <h4>{{ time.value }}</h4>
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
  name : 'time-move',
  data(){
    return {
      time_move_filter: ['all_time'],
      all_time_move : 'checked'
    }
  },
  computed: {
    timeFilter() {
      return this.$store.state.timeFilter;
    }
  },
  methods : {
    timeMoveFilterFlight(time){
      if(!this.time_move_filter.includes(time)){
        this.time_move_filter.push(time)
      }else{
        let index = this.time_move_filter.indexOf(time);
        this.time_move_filter.splice(index, 1);
      }
      if(this.time_move_filter.length == 0 ) {
        this.all_time_move = 'checked'
        this.time_move_filter = ["all_time"]
      }
      else if(this.time_move_filter.length > 0 && time == 'all_time'){
        this.all_time_move = 'checked'
        this.time_move_filter.forEach(timeMove => {
          if(timeMove != 'all_time') {
            document.getElementById(timeMove).checked = false
          }
        })
        this.time_move_filter = ["all_time"]

      }
      else if(time != 'all_time'){
        this.all_time_move = ''
        if(this.time_move_filter.includes('all_time')){
          let index = this.time_move_filter.indexOf('all_time');
          this.time_move_filter.splice(index, 1);
        }
      }
      this.$store.commit('timeMoveFilter', this.time_move_filter);
    }
  }
}
</script>