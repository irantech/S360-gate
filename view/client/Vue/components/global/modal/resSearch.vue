<template>
  <div class="modal-flight modal-searchBox" style='right:0 !important;'>
    <div class="parent-modal-flight">
      <div class="header-modal-flight">
        <h3>{{ useXmltag('searchAgain') }}</h3>
        <button @click="hideModal()">{{ useXmltag('JustReturn') }}</button>
      </div>
      <div class="body-modal-flight">
        <div class="new_search_box">
          <div class="tab-content" id="searchBoxContent">
            <div class="tab-pane active" id="Flight">
              <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
                <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
                  <switch_date />
                  <originDestination :stored_origin_cities='stored_origin_cities'
                                     :stored_arrival_cities='stored_arrival_cities'
                                     :type="'international'"/>
                  <date :type="'international'"/>
                  <passengers :type="'international'" />
                  <approve :searchModule="'international-flight'"/>

                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import passengers from '../searchBox/passengers'
import date from '../searchBox/date'
import switch_date from '../searchBox/switch'
import originDestination from '../searchBox/international/originDestination'

import approve from '../searchBox/approve'
export default {
  name: 'responsive-search-box',
 props :['stored_origin_cities' , 'stored_arrival_cities' , 'type'] ,
  components: {
    'passengers'  : passengers,
    'date'        : date,
    'switch_date'      : switch_date,
    'originDestination'      : originDestination,
    'approve'     : approve ,

  },
  methods : {
    hideModal () {
      this.$emit('closeFilterModal')
    }
  }
}
</script>
