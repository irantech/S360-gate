<template>
  <div class="filter-arrow">
    <a :href="previousDayUrl">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M233 239c9.4 9.4 9.4 24.6 0 33.9L73 433c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l143-143L39 113c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L233 239z"/></svg>
      <h4>{{ useXmltag('Previousday') }}</h4>
    </a>
    <a :href="nextDayUrl">
      <h4>{{ useXmltag('Nextday') }}</h4>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
    </a>
  </div>
</template>


<script>
export  default  {
  name : 'previousNextDay' ,
  props: ['type'] ,
  data() {
    return {
    }
  },
  computed :{
    todayDate() {
      return this.$store.state.isTodayDate
    },
    dataSearch() {
      return this.$store.state.setDataSearch.dataSearch
    },
    setDataSearch() {
      return this.$store.state.setDataSearch
    },
    nextDayUrl ()  {
      let link = ''
      if(this.type == 'domestic') {
        link = 'domestic-flight'
      }else{
        link = 'international-flight'
      }
      if(this.todayDate && this.dataSearch && this.dataSearch.MultiWay !='TwoWay') {
        return  `${this.amadeusPathByLang()}${link}/1/${this.dataSearch.origin}-${this.dataSearch.destination}/${this.setDataSearch.next}/Y/${this.dataSearch.adult}-${this.dataSearch.child}-${this.dataSearch.infant}`
      }
      return '#';
    },
    previousDayUrl(){
      let link = ''
      if(this.type == 'domestic') {
        link = 'domestic-flight'
      }else{
        link = 'international-flight'
      }
      if(this.todayDate && this.dataSearch && this.dataSearch.MultiWay !='TwoWay') {
        return  `${this.amadeusPathByLang()}${link}/1/${this.dataSearch.origin}-${this.dataSearch.destination}/${this.setDataSearch.prev}/Y/${this.dataSearch.adult}-${this.dataSearch.child}-${this.dataSearch.infant}`
      }
      return '#';
    }
  },
}
</script>