<template>
  <a :href="`/gds/${getLang()}/detailTour/${tour.id_same}/${slugName}`">
    <slot/>
  </a>
</template>
<script>
export default{
  name:'tour-section-item-link',
  props:{
    tour:{
      type:Object,
      required:true
    }
  },
  data() {
    return {
      slugName:''
    }
  },
  created() {
     console.log(this.tour.tour_name)
    this.slugName = (this.tour.tour_name_en??this.tour.tour_name).replace(/\s+/g, '-').toLowerCase()
  },
}
</script>