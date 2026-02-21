<template>
   <div class="parent-price-discount-tour">
      <h5>شروع از قیمت:</h5>

      <div
         v-if="tour.discount && Number(tour.discount.discount.adult_amount) > 0"
         class="price-discount"
      >
      <span class="price-decoration">
        {{ Number(tour.discount.minPriceR).toLocaleString('en-US') }}
      </span>

         <div class="discount">
            {{ Number(tour.discount.discount.adult_amount) }}
            {{ tour.discount.is_toman ? 'تومان' : 'ریال' }}
         </div>
      </div>

      <div class="price-total">
         <div class="price-line">
            <span style="font-size: 20px;">
               {{ Number(tour.discount.discount.after_discount).toLocaleString('en-US') }}
            </span>
            <span class="main-currency">
            {{ tour.discount.is_toman ? 'تومان' : 'ریال' }}
            </span>
            <span v-if="tour.discount.minPriceA && Number(tour.discount.minPriceA) > 0" class="currency-plus">
              + {{ Number(tour.discount.minPriceA).toLocaleString('en-US') }}
              {{ tour.discount.CurrencyTitleFa }}
            </span>
         </div>
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
