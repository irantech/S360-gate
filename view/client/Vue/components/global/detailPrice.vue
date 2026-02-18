<template>
  <div :class="{'parent-person-click-price col-3 p-0' : windowWidth >  576 }">
    <article>
      <span>{{useXmltag('Adt')}} :</span>
      <h6 v-if="flight.price.adult.has_discount=='yes'">{{flight.price.adult.with_discount | formatNumber}} {{flight.price.adult.type_currency}}</h6>
      <h6 v-else>{{flight.price.adult.price | formatNumber}} {{flight.price.adult.type_currency}}</h6>
    </article>
    <article>
      <span>{{useXmltag('Chd')}} :</span>
      <h6 v-if="flight.price.child.price > 0 ">{{flight.price.child.price | formatNumber}}</h6>
      <h6 v-else>{{useXmltag('PreInvoiceStep')}}</h6>
    </article>
    <article>
      <span>{{useXmltag('Infant')}} :</span>
      <h6 v-if="flight.price.infant.price > 0 ">{{flight.price.infant.price | formatNumber}}</h6>
      <h6 v-else>{{useXmltag('PreInvoiceStep')}}</h6>
    </article>
  </div>
</template>

<script>
  export default {
    name : 'detail-price' ,
    props : ['flight'] ,
    data() {
      return {
        windowWidth : window.innerWidth
      }
    }
  }
</script>