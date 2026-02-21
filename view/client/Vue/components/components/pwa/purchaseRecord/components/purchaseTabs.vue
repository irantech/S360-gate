<template>
  <div class="filter-content padb10 padt10">
    <div
      v-for="(tab, key) in tabs"
      class="UserBuy-tab-link"
      :class="current_tab === tab.index ? 'active active-tab' : '' || form.loading ? 'disabled' : '' "
      :data-tab="`tab-${tab.index}`">
      <i class="fa-light" :class="tab.icon"></i>
      <input
        class="radio-custom"
        type="radio"
        @click="changeTab(tab.index)"
        :disabled="form.loading"
        :checked="key === 0"
        v-model="current_tab"
        :value="tab.index" />
      <span class="radio-custom-label">{{ tab.text }}</span>
    </div>
  </div>
</template>
<script>
export default {
  name: "purchase-tabs",
  props: ["form", "purchase_data", "searchTab" , "services"],
  methods: {
    async changeTab(index) {
      this.$emit("searchTab", index)
    },
  },
  data() {
    return{
      current_tab:'flight'
    }
  },
  computed : {
    tabs() {
        let services_tabs = []
        this.services.forEach( service =>  {

          if(service == 'Flight') {
            services_tabs.push(
            {
              index: "flight",
              text: useXmltag('Flight'),
              icon: "fa-plane",
            })
          }
          else if(service == 'Hotel') {
            services_tabs.push(
              {
                index: "hotel",
                text: useXmltag('Hotel'),
                icon: "fa-bed-empty",
              })
          }
          else if(service == 'Insurance') {
            services_tabs.push(
              {
                index: "insurance",
                text: useXmltag('Insurance'),
                icon: "fa-umbrella-simple",
              })
          }
          else if(service == 'Tour') {
            services_tabs.push(
              {
                index: "tour",
                text: useXmltag('Tour'),
                icon: "fa-backpack",
              })
          }
          else if(service == 'Bus') {
            services_tabs.push(
              {
                index: "bus",
                text:  useXmltag('Bus'),
                icon: "fa-bus-simple",
              })
          }
          else if(service == 'train') {
            services_tabs.push(
              {
                index: "train",
                text: useXmltag('Train'),
                icon: "fa-train-subway",
              })
          }

       })
       return services_tabs
    } ,

  }
}
</script>
