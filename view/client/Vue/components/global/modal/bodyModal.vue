<template>
  <div class='modal_style_parent'>
    <div class='modal_style modal_style-new' v-for='data_baggage in data_detail'>
      <span>{{data_baggage.origin}}</span>
      <span>{{data_baggage.destination}}</span>
      <span v-if="data_baggage.amount_baggage == null">{{useXmltag('NoBaggage')}}</span>
      <span v-else>{{data_baggage.amount_baggage}}</span>
      <hr>
    </div>
  </div>
</template>

<script>

export default {
  name: 'bodyModal',
  props:['data_detail'],



}
</script>
