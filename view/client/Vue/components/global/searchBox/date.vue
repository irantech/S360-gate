<template>
  <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search p-1">
    <div class="form-group">

      <date-picker v-model="searchForm.departure_date_en" :inputFormat="format_datepicker"
                   :auto-submit="true" :locale="lang_datepicker"
                   :from="dateNow('-')"  mode="single"
                   class='back-flight input-searchBox-flight'
                   :column="column"
                   :placeholder="`${useXmltag('CheckInDate')}`"
                   name="dept_date"
                   :id="type == 'international' ? 'dept_date_foreign0' : 'dept_date_local'" :styles="styles"
      >
        <template #icon></template>
      </date-picker>
    </div>
    <div class="form-group">
      <date-picker-return v-model="searchForm.arrival_date_en"
                          :inputFormat="format_datepicker"
                          :auto-submit="true"
                          :column="column"
                          class='went-flight input-searchBox-flight'
                          :from="searchForm.departure_date_en|moment"
                          mode="single" :locale="lang_datepicker"
                          :placeholder="`${useXmltag('CheckOutDate')}`" name="dept_date_return"
                          :id="type == 'international' ? 'dept_date_foreign_return' : 'dept_date_local'"
                          :styles="styles" :disabled="searchForm.MultiWay == 'OneWay'">
        <template #icon></template>
      </date-picker-return>
    </div>
  </div>
</template>

<script>
  import datePicker from '@alireza-ab/vue-persian-datepicker'
  export  default {
   name : 'search-date'  ,
    props : ['type'] ,
   components: {
      'date-picker': datePicker,
      'date-picker-return': datePicker
   },
   data() {
     return {
       today_date: true,
       date_picker_departure: '',
       date_picker_return: '',
       format_datepicker: 'jYYYY-jMM-jDD',
       lang_datepicker: 'fa',
       svg_icon_1: `<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' version='1.1' x='0' y='0' viewBox='0 0 907.62 907.619' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><g xmlns='http://www.w3.org/2000/svg'><path d='M591.672,907.618c28.995,0,52.5-23.505,52.5-52.5V179.839l42.191,41.688c10.232,10.11,23.567,15.155,36.898,15.155   c13.541,0,27.078-5.207,37.347-15.601c20.379-20.625,20.18-53.865-0.445-74.244L626.892,15.155C617.062,5.442,603.803,0,589.993,0   c-0.104,0-0.211,0-0.314,0.001c-13.923,0.084-27.244,5.694-37.03,15.6l-129.913,131.48c-20.379,20.625-20.18,53.865,0.445,74.244   c20.626,20.381,53.866,20.181,74.245-0.445l41.747-42.25v676.489C539.172,884.113,562.677,907.618,591.672,907.618z'></path><path d='M315.948,0c-28.995,0-52.5,23.505-52.5,52.5v676.489l-41.747-42.25c-20.379-20.625-53.62-20.825-74.245-0.445   c-20.625,20.379-20.825,53.619-0.445,74.244l129.912,131.479c9.787,9.905,23.106,15.518,37.029,15.601   c0.105,0.001,0.21,0.001,0.315,0.001c13.81,0,27.07-5.442,36.899-15.155L484.44,760.78c20.625-20.379,20.824-53.619,0.445-74.244   c-20.379-20.626-53.62-20.825-74.245-0.445l-42.192,41.688V52.5C368.448,23.505,344.943,0,315.948,0z' style=''></path></g></g></svg>`,
       svg_icon_2: `<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0' y='0' viewBox='0 0 512 512' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g transform='matrix(-1,-1.2246467991473532e-16,1.2246467991473532e-16,-1,512,512)'><g xmlns='http://www.w3.org/2000/svg'><g><path d='M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20    c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285    l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018    l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z' style='' class=''></path></g></g></g></svg>`,
       styles: {
         'primary-color': main_color,
       },
       date_departure:'',
       date_return:'',
       column: {
         576: 1,  // under 576px, column count is 1
         992: 2,  // under 992px, column count is 2
       }
     }
   } ,
   filters: {
      moment: function (date) {
        let new_date =  new Date(date).toLocaleDateString('fa-IR-u-nu-latn' , {year:'numeric',month:'2-digit',day:'2-digit',formatMatcher:'basic'})
        return new_date.replace(/\//g, '-');
      }
    },
    computed : {
      searchForm() {
        return this.$store.state.formDataSearch
      }
    },
    mounted() {
      this.date_departure = this.searchForm.departure_date_en
      this.date_return = this.searchForm.arrival_date_en
      this.date_departure_start = this.searchForm.arrival_date_en
    }
  }
</script>