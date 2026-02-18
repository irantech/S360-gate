<template>
  <div class="parent-flight-class">
    <div class="accordion" id="flight-class">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-three">
          <button class="btn btn-link btn-block btn-accordion-side-bar" type="button" data-toggle="collapse" data-target="#body-data-collapse-three" aria-expanded="true" aria-controls="body-data-collapse-three">
            <h2>{{ useXmltag('Classflight')}}</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z"/></svg>
          </button>
        </div>
        <div id="body-data-collapse-three" class="collapse show" aria-labelledby="title-three" data-parent="#flight-class">
          <div class="content-side-bar-flight-type">
            <div class="styled-checkbox">
              <input  @change="seatClassFilterFlight('all_seat_class')"
                      type="checkbox" id="all-class" :checked="all_seat_class" value='all_seat_class' />
              <label for="all-class">{{ useXmltag('All')}}</label>
            </div>
            <div v-for='seatClass in seatClassFilter' class="styled-checkbox">
              <input @change="seatClassFilterFlight(seatClass.name_en)" type="checkbox"
                     :id="seatClass.name_en" :value='seatClass.name_en' />
              <label :for="seatClass.name_en">{{seatClass.name_fa}}</label>
              <h4>{{seatClass.count}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export  default  {
  name : 'seatClass' ,
  data () {
    return {
      seat_class_filter: ['all_seat_class'],
      all_seat_class : 'checked'
    }
  },
  computed: {
    seatClassFilter() {
      return this.$store.state.seatClassFilter;
    }
  } ,
  methods: {
    seatClassFilterFlight(classFilter) {
      if(!this.seat_class_filter.includes(classFilter)){
        this.seat_class_filter.push(classFilter)
      }else{
        let index = this.seat_class_filter.indexOf(classFilter);
        this.seat_class_filter.splice(index, 1);
      }
      if(this.seat_class_filter.length == 0 ) {
        this.all_seat_class = 'checked'
        this.seat_class_filter = ["all_seat_class"]
      }
      else if(this.seat_class_filter.length > 0 && classFilter == 'all_seat_class'){
        this.all_seat_class = 'checked'
        this.seat_class_filter.forEach(seatClass => {
         if(seatClass != 'all_seat_class') {
           document.getElementById(seatClass).checked = false
         }
        })
        this.seat_class_filter = ["all_seat_class"]

      }
      else if(classFilter != 'all_seat_class'){
        this.all_seat_class = ''
        if(this.seat_class_filter.includes('all_seat_class')){
          let index = this.seat_class_filter.indexOf('all_seat_class');
          this.seat_class_filter.splice(index, 1);
        }
      }
      this.$store.commit('seatClassFilter', this.seat_class_filter);
    }
  }
}
</script>