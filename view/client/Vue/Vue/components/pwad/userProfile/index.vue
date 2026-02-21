<template>
   <div v-if="user_data">
      <div class="py-2">
         <div class="py-2 d-flex flex-wrap">
            <div style="max-width: 576px" class="container">
               <div
                  class="main-Content-top d-flex flex-wrap s-u-passenger-wrapper-change">
                  <span
                     class="s-u-last-p-bozorgsal w-100 s-u-last-p-bozorgsal-change site-main-text-color">
                     <i
                        class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i>
                     اطلاعات مشتری
                  </span>

                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="name" class="flr">نام:</label>
                     <input
                        class="form-control"
                        type="text"
                        v-model="form.name"
                        id="name"
                        placeholder="نام" />
                  </div>

                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="family" class="flr"> نام خانوادگی:</label>
                     <input
                        class="form-control"
                        type="text"
                        name="family"
                        v-model="form.family"
                        id="family"
                        value="سروشیان"
                        placeholder="نام خانوادگی " />
                  </div>

                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group no-star w-50">
                     <label class="flr">جنسیت مسافر:</label>
                     <select
                        class="form-select w-100 bg-white"
                        v-model="form.gender"
                        name="gender">
                        <option value="" selected="selected">
                           جنسیت مسافر
                        </option>
                        <option value="Male">مرد</option>
                        <option value="Female">زن</option>
                     </select>
                  </div>

                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label class="flr"> تاریخ تولد:</label>

                     <date_picker
                        popover
                        id="birth_date"
                        locale="fa"
                        :auto-submit="true"
                        v-model="form.birth_date"
                        format="jYYYY-jMM-jDD"
                        popover="bottom-right" />
                  </div>
                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="mobile" class="flr">شماره موبایل:</label>
                     <input
                        class="form-control"
                        type="text"
                        name="mobile"
                        v-model="form.mobile"
                        id="mobile"
                        value="09123493154"
                        placeholder="شماره موبایل" />
                  </div>
                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group no-star w-50">
                     <label for="address" class="flr">آدرس:</label>
                     <input
                        class="form-control"
                        type="text"
                        v-model="form.address"
                        name="address"
                        id="address"
                        value=""
                        placeholder="آدرس" />
                  </div>
                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="email" class="flr"> ایمیل:</label>
                     <input
                        class="form-control"
                        type="text"
                        name="email"
                        v-model="form.email"
                        id="email"
                        value="a@a.com"
                        placeholder="ایمیل"
                        disabled="disabled" />
                  </div>

                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="mobile" class="flr"> تاریخ عضویت:</label>

                     <input
                        class="form-control"
                        v-model="form.register_date"
                        type="text"
                        value="1397-03-28"
                        disabled="disabled" />
                  </div>

                  <div
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="mobile" class="flr">تاریخ آخرین تغییر :</label>

                     <input
                        class="form-control"
                        type="text"
                        v-model="form.updated_date"
                        value="1400-11-20"
                        disabled="disabled" />
                  </div>

                  <div
                     v-if="
                        user_data.fk_counter_type_id >= 1 &&
                        user_data.fk_counter_type_id < 5
                     "
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="mobile" class="flr"> نوع کانتر:</label>
                     <input
                        class="form-control"
                        v-model="form.counter_type"
                        type="text"
                        value="کانتر طلایی"
                        disabled="disabled" />
                  </div>

                  <div
                     v-if="
                        user_data.fk_counter_type_id >= 1 &&
                        user_data.fk_counter_type_id < 5
                     "
                     class="s-u-passenger-item s-u-passenger-item-change form-group w-50">
                     <label for="mobile" class="flr"> نام آژانس مربوطه:</label>
                     <input
                        class="form-control"
                        type="text"
                        v-model="form.agency_name"
                        value="ایران تکنولوژی"
                        disabled="disabled" />
                  </div>
               </div>
            </div>

           <div class="col-md-9 mt-5">
             <button
               :disabled="form.loading"
               @click="updateForm"
               class="btn btnSub site-bg-main-color">
               به روزرسانی
             </button>
             <app-loading-spinner
               style="left: 20px; top: 6px"
               class="loading-spinner-holder"
               :loading="form.loading"></app-loading-spinner>
           </div>
            <div class="col-md-12 mt-2">
               <a @click="rules_loading = true" href="/gds/rules">
                  <button

                     :disabled="rules_loading"
                     class="btn btn-block btn-light">
                     قوانین و مقررات
                  </button>
               </a>
               <app-loading-spinner
                  style="left: 20px; top: 6px"
                  class="loading-spinner-holder"
                  :loading="rules_loading"></app-loading-spinner>
            </div>

            <div class="col-md-12 mt-2">
               <a @click="contact_us_loading = true" href="/gds/contactUs">
                  <button
                     :disabled="contact_us_loading"
                     class="btn btn-block btn-light">
                     تماس با ما
                  </button>
               </a>
               <app-loading-spinner
                  style="left: 20px; top: 6px"
                  class="loading-spinner-holder"
                  :loading="contact_us_loading"></app-loading-spinner>
            </div>

            <div class="col-md-12 mt-2">
               <a @click="about_us_loading = true" href="/gds/aboutUs">
                  <button
                     :disabled="about_us_loading"
                     @click="about_us_loading = true"
                     class="btn btn-block btn-light">
                     درباره ی ما
                  </button>
               </a>
               <app-loading-spinner
                  style="left: 20px; top: 6px"
                  class="loading-spinner-holder"
                  :loading="about_us_loading"></app-loading-spinner>
            </div>



            <div class="col-md-3 mt-2">
               <button
                  :disabled="form.loading"
                  @click="logout"
                  class="btn btnSub btn-outline-danger">
                  خروج
               </button>
               <app-loading-spinner
                  style="left: 20px; top: 6px"
                  class="loading-spinner-holder"
                  :loading="logout_form.loading"></app-loading-spinner>
            </div>
         </div>
         <footer-section :page="pwa_page_data.index"></footer-section>
      </div>
   </div>
   <div v-else>
      <app-loading-spinner
         class="w-100-vh mx-auto"
         :loading="true"></app-loading-spinner>
   </div>
</template>
<script>
import footerSection from "./../components/footer"

export default {
   name: "pwaUserProfile",
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
         about_us_loading: false,
         contact_us_loading: false,
         rules_loading: false,
      }
   },
   created() {
      this.$store.dispatch("pwaGetUserProfile")
      this.$store.dispatch("pwaGetClientData", this.api_gds_client_data())
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
      async updateForm() {
         this.form.loading = true
         let _this = this
         await axios
            .post(
               amadeusPath + "ajax",
               {
                  className: "user",
                  method: "apiUpdateUser",
                  form: _this.form,
               },
               {
                  "Content-Type": "application/json",
               }
            )
            .then(async function (response) {
               _this.$swal({
                  icon: "success",
                  toast: true,
                  position: "bottom",
                  showConfirmButton: false,
                  timerProgressBar: true,
                  timer: 4000,
                  title: "ویرایش شد",
               })
               _this.form.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.form.loading = false
            })
      },

      async logout() {
         this.logout_form.loading = true
         let _this = this

         await axios
            .post(amadeusPath + "user_ajax.php?flag=signout&Type=App", {
               flag: "signout",
               Type: "App",
            })
            .then(async function (response) {
               // console.log(_this.client_data.online_url)

               window.location.href = _this.client_data.online_url.replace(
                  "fa",
                  "app"
               )
            })
            .catch(function (error) {
               console.log(error)
               _this.logout_form.loading = false
            })
      },
   },
}
</script>
