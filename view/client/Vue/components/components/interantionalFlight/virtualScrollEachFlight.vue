<template>

  <div>
    <div class="international-available-box foreign deptFlight"
         :class="[source.time_flight_name ,source.flight_type_li] ">
       <span class="hidden-data">
          {{index}}
       </span>
      <template v-if='data_search.dataSearch.MultiWay=="multi_destination"'>
        <each-multi-flight :each_flight="source" :data_search="data_search" :key_flight="index" ></each-multi-flight>
      </template>
      <template v-else>
        <each-flight :each_flight="source" :data_search="data_search" :key_flight="index" ></each-flight>
      </template>
      <div class="clear"></div>
    </div>
  </div>
</template>

<script>
import eachFlight from './eachFlight'
import eachMultiFlight from './eachMultiFlight'

export default {
  name: 'virtualScrollEachFlight',
  components:{
    'eachFlight': eachFlight,
    'eachMultiFlight': eachMultiFlight,
  },
  props: {
    index: { // index of current item
      type: Number
    },
    source: {
      type: Object,
      default () {
        return {}
      }
    },
    data_search:{
      type:Object,
      default () {
        return {}
      }
    }
  },

}
</script>

<style scoped>

</style>