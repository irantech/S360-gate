<template>
   <div>
      <template v-if="flight_type_li === 'system'">

         <template v-if="fee_cancel && fee_cancel.length">
            <div class="cancel-policy cancel_modal">
               <div class="cancel-policy-head">
                  <div class="cancel-policy-head-text">{{ useXmltag('DetailMoneyCancel') }}</div>
                  <div class="cancel-policy-class">
                     <span>{{ useXmltag('Classflight') }} :</span>
                     <span>{{ useXmltag('TypeClass') }}</span>
                  </div>
               </div>

               <div class="cancel-policy-inner">
                  <div
                     class="cancel-policy-item cancel_modal"
                     v-for="(item, index) in fee_cancel"
                     :key="index"
                  >
              <span class="cancel-policy-item-text site-main-text-color">
                {{ item.title }}
              </span>

                     <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color">
                {{ item.fine_text }}
              </span>
                  </div>
               </div>
            </div>
         </template>

         <template v-else>
            <div class="cancel-policy cancel_modal cancel-policy-charter1">
               <div class="cancel-policy-head">
                  <div class="cancel-policy-head-text">{{ useXmltag('DetailMoneyCancel') }}</div>
               </div>

               <span class="site-bg-main-color-admin">
            {{ useXmltag('Contactbackupunitinformationaboutamountconsignmentfines') }}
          </span>
            </div>
         </template>

      </template>


      <!-- قوانین آکاردئون -->
      <div id="accordion">
         <div class="card" v-for="(item,key) in data_rules.FareRules" :key="key">
            <div class="card-header" id="headingOne">
               <h5 class="mb-0">
                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne">
                     {{ item.CityPair }}
                  </button>
               </h5>
            </div>

            <div id="collapseOne" class="collapse show">
               <div class="card-body">
                  <div v-for="(item_detail,key_detail) in item.RuleDetails" :key="key_detail">
                     <div v-html="item_detail.Category"></div>
                     <br/> ---------<br/>
                     <div v-html="item_detail.Rules"></div>
                     <hr/>
                  </div>
               </div>
            </div>
         </div>

      </div>

   </div>
</template>

<script>
export default {
   name: 'rulesFlight',
   props: ['data_rules', 'fee_cancel', 'flight_type_li']
}
</script>
