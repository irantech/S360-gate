<template>
   <div class="d-flex flex-wrap gap-4"  >

      <div
         class="align-items-center d-flex flex-wrap justify-content-center p-3 py-4 site-bg-main-color w-100">
         <span class="font-weight-bold font-13"> {{ useXmltag('userAccount')}}</span>
      </div>

      <div  v-if="!user_data" class="d-flex flex-wrap gap-4 px-3 w-100">
         <div
            class="align-items-center bg-white d-flex flex-wrap gap-3 p-4 rounded-lg w-100">
            <div class="d-flex gap-4">
               <div class="d-flex flex-wrap" style="height: 55px">
                  <svg
                     style="width: 55px; border-radius: 50%; fill: #fff"
                     class="site-stroke-main-color-70 site-bg-main-color-50"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 194.438 194.43">
                     <g
                        id="Group_11591"
                        data-name="Group 11591"
                        transform="translate(6 6)">
                        <g id="profile-user" transform="translate(0 0)">
                           <path
                              id="Path_23422"
                              data-name="Path 23422"
                              d="M91.219,0a91.215,91.215,0,1,0,91.219,91.215A91.22,91.22,0,0,0,91.219,0Zm0,27.274A30.171,30.171,0,1,1,61.052,57.446,30.173,30.173,0,0,1,91.219,27.275ZM91.2,158.582a66.946,66.946,0,0,1-43.594-16.075,12.857,12.857,0,0,1-4.512-9.773,30.428,30.428,0,0,1,30.576-30.42h35.108a30.384,30.384,0,0,1,30.528,30.42A12.825,12.825,0,0,1,134.8,142.5,66.922,66.922,0,0,1,91.2,158.582Z"
                              transform="translate(0 -0.001)"
                              stroke-width="12" />
                        </g>
                     </g>
                  </svg>
               </div>
               <div class="d-flex flex-wrap gap-2">
                  <span class="font-13 font-weight-bold">{{ useXmltag('Login')}} / {{ useXmltag('SetAccount')}}</span>
                  <p class='w-100 ' :class="`${getLang() == 'en' ? 'text-left' : 'text-right'}`">
                    {{ useXmltag('WithApplication')}}
                    {{ client_data.client_name }}
                    {{ useXmltag('useBenefit')}}

                  </p>
               </div>
            </div>

            <div
               class="d-flex flex-wrap w-100 align-items-center justify-content-center">
               <a :href="`/gds/${getLang()}/loginUser`" class="btn btn-sm font-13 site-bg-main-color-50">
                 {{ useXmltag('loginOrSignIn')}}
               </a>
            </div>
         </div>
      </div>

      <a :href="`/gds/${getLang()}/contactUs`"   class="d-flex text-dark flex-wrap gap-4 px-3 w-100">
         <div
            class="align-items-center bg-white d-flex flex-wrap gap-3 p-4 rounded-lg w-100">
            <span class="fa-phone far font-17"></span>
            <span class="font-13 font-weight-bold"> {{ useXmltag('Contactus')}} </span>
         </div>
      </a>

      <a :href="`/gds/${getLang()}/aboutUs`"  class="d-flex text-dark flex-wrap gap-4 px-3 w-100">
         <div
            class="align-items-center bg-white d-flex flex-wrap gap-3 p-4 rounded-lg w-100">
            <span class="fa-badge-check fal font-17"></span>
            <span class="font-13 font-weight-bold">{{ useXmltag('AboutUs')}}</span>
         </div>
      </a>

      <a :href="`/gds/${getLang()}/rules`" class="d-flex text-dark flex-wrap gap-4 px-3 w-100">

         <div
            class="align-items-center bg-white d-flex flex-wrap gap-3 p-4 rounded-lg w-100">
            <span class="fa-book-open far font-17"></span>
            <span class="font-13 font-weight-bold">{{ useXmltag('NabaeBaghdadRules')}}</span>
         </div>
      </a>
   </div>

</template>
<style>
body {
   background-color: #f8f8f8;
}
</style>
<script>
import footerSection from "./../components/footer"

export default {
   name: "information",
   components: {
      "footer-section": footerSection,
   },
   props: ["pwa_page_data"],
   data() {
      return {
         form: {
            loading: false,
            name: null,
            family: null,
            gender: null,
            birth_date: null,
            mobile: null,
            address: null,
            email: null,
            register_date: null,
            updated_date: null,
            counter_type: null,
            agency_name: null,
         },
         logout_form: {
            loading: false,
         },
      }
   },
   created() {
     this.$store.dispatch("pwaGetUserProfile")
     this.$store.dispatch("pwaGetClientData", this.api_gds_client_data())
      // this.$store.dispatch("pwaGetUserProfile")
      // this.$store.dispatch("pwaGetClientData", this.api_gds_client_data())
   },
   computed: {
      user_data() {
         let user_profile = this.$store.state.user_profile.data
         if (user_profile) {
            this.form.name = user_profile.name
            this.form.family = user_profile.family
            this.form.gender = user_profile.gender
            this.form.email = user_profile.email
            this.form.birth_date = user_profile.birthday
            this.form.mobile = user_profile.mobile
            this.form.address = user_profile.address
            this.form.register_date = user_profile.register_date
            this.form.updated_date = user_profile.last_modify
            this.form.agency_name = user_profile.agency_name
            this.form.counter_type = user_profile.counter_type
         }
         return user_profile
      },
      client_data() {
         return this.$store.state.pwa_page
      },
   },
   methods: {
   },
}
</script>
