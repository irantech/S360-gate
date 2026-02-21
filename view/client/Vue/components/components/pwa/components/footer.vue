<template>
  <div class="menu_fixed_bottom">
    <div class="phone-bottom">
      <a
        v-for="link in links"
        :key="link.index"
        :href="`app?to=${link.index}`"
        class="nav-link text-dark font-weight-bold"
        :class="page === link.index ? 'active site-main-text-color' : ''"
        data-index="0">
        <i
          :class="
            (page === link.index ? 'site-main-text-color ' : ' ') + link.icon
          "
          class="far"></i>
        <span
          :class="page === link.index ? 'site-main-text-color' : ''"
          class="nav-text"
          >{{ link.title }}</span
        >
        <app-loading-spinner
          class="loading-spinner-holder"
          :loading="loading['search-service']"></app-loading-spinner>
      </a>


    </div>
  </div>
</template>

<script>
export default {
  name: "footer-section",
  props: ["page"],
  data() {
    return {
      loading: {
        "search-service": false,
        "purchase-record": false,
        "user-profile": false,
      },
      links: [
        {
          index: "search-service",
          title: useXmltag('Home'),
          icon: "fa-home-lg",
        },
        {
          index: "purchase-record",
          title: useXmltag('Buyarchive'),
          icon: "fa-suitcase-rolling",
        },
        {
          index: "profile",
          title: useXmltag('userAccount'),
          icon: "fa-user",
        },
      ],
    }
  },
  methods: {
    // A method that is called when a user clicks on a link in the footer. It dispatches an action to the store.
    async changePage(index) {
      await this.$store.dispatch("pwaChangePage", {
        index: index,
      })
    },
  },


}
</script>
