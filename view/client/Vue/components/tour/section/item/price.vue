<template>
  <div class="parent-price-discount-tour">
    <h5>شروع از قیمت:</h5>
    <div v-if='tour.discount && Number(tour.discount.discount.adult_amount) > 0'
         class="price-discount">
      <span class="price-decoration">
        {{ Number(tour.discount.minPriceR).toLocaleString('en-US') }}
      </span>
      <div class="discount">
        {{Number(tour.discount.discount.adult_amount)}} ریال
      </div>
    </div>
    <div class="price-total">
      <h2>
        {{ Number(tour.discount.discount.after_discount).toLocaleString('en-US') }}
      </h2>
      <span>ریال</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'tour-section-item-price',
  props: {
    tour: {
      type: Object,
      required: true,
    },
  },
}
</script>
