<template>
    <div class="parent-border-flight-information">
      <div class="parent-box-flight-information">
        {{ useXmltag('Returnflight')}}
        <div class="parent-click-travel-data" v-for='( detail_flight , index ) in return_detail_flight'>
          <div class="parent-airplane-stop"  v-if="detail_flight.is_transit">
            <div class="airplane-stop">
              <svg xmlns="http://www.w3.org/2000/svg" width="" height="" fill="" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
              </svg>
              <h3>{{ useXmltag('Stopat')}} : {{ detail_flight.departure.departure_city}}({{ detail_flight.departure.departure_airport}})</h3>
              <i>|</i>
              <span>{{ detail_flight.transit }}</span>
              <i>|</i>
              <span>{{ detail_flight.departure_date }}</span>
            </div>
          </div>
          <div class="title-click-travel-data">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M381 114.9L186.1 41.8c-16.7-6.2-35.2-5.3-51.1 2.7L89.1 67.4C78 73 77.2 88.5 87.6 95.2l146.9 94.5L136 240 77.8 214.1c-8.7-3.9-18.8-3.7-27.3 .6L18.3 230.8c-9.3 4.7-11.8 16.8-5 24.7l73.1 85.3c6.1 7.1 15 11.2 24.3 11.2H248.4c5 0 9.9-1.2 14.3-3.4L535.6 212.2c46.5-23.3 82.5-63.3 100.8-112C645.9 75 627.2 48 600.2 48H542.8c-20.2 0-40.2 4.8-58.2 14L381 114.9zM0 480c0 17.7 14.3 32 32 32H608c17.7 0 32-14.3 32-32s-14.3-32-32-32H32c-17.7 0-32 14.3-32 32z"/></svg>
            <h4>{{ useXmltag('Flight')}} {{ detail_flight.departure.departure_code }} {{ useXmltag('On')}} {{ detail_flight.arrival.arrival_code }}</h4>
          </div>
          <div class="details-click-travel">
            <div class="parent-data-clock-flight">
              <div class="data-clock-flight-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 128C89.31 128 32 185.3 32 256C32 326.7 89.31 384 160 384C230.7 384 288 326.7 288 256C288 185.3 230.7 128 160 128z"/></svg>
                <article>
                  <h3>{{ detail_flight.departure_time }}</h3>
                  <p>{{ detail_flight.departure_date }}</p>
                </article>
              </div>
              <div class="data-clock-flight-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 240C218.5 240 240 218.5 240 192C240 165.5 218.5 144 192 144C165.5 144 144 165.5 144 192C144 218.5 165.5 240 192 240zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 32C103.6 32 32 103.6 32 192C32 207.6 37.43 229 48.56 255.4C59.47 281.3 74.8 309.4 92.14 337.5C126.2 392.8 166.6 445.7 192 477.6C217.4 445.7 257.8 392.8 291.9 337.5C309.2 309.4 324.5 281.3 335.4 255.4C346.6 229 352 207.6 352 192C352 103.6 280.4 32 192 32z"/></svg>
                <article>
                  <h3>{{ detail_flight.arrival_time }}</h3>
                  <p>{{ detail_flight.arrival_date }}</p>
                </article>
              </div>
              <span class="time-flight">
                                                                {{ detail_flight.duration_flight_time }}
                                                            </span>
            </div>
            <div class="parent-airport">
              <div class="airport-item">
                <h3>{{ detail_flight.departure.departure_city }}</h3>
                <p>{{ detail_flight.departure.departure_airport }} ({{ detail_flight.departure.departure_code }})</p>
              </div>
              <div class="airport-item">
                <h3>{{ detail_flight.arrival.arrival_city }}</h3>
                <p>{{ detail_flight.arrival.arrival_airport }} ({{ detail_flight.arrival.arrival_code }})</p>
              </div>
            </div>
          </div>
          <div class="option-click-travel">
            <div class="option-item">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 0C304 0 336 74.04 336 112.1V154.1L496 254.1C504.1 260.1 512 270.1 512 282.1V347.2C512 357.2 507 367.2 499 373.2C491 379.2 480 381.2 471 378.2L336 335.2V376.2L387 416.2C395 422.2 400 431.2 400 441.2V480.2C400 490.2 395 500.2 387 505.2C379 511.3 368.1 513.3 360 511.3L256 480.2L152 510.2C142 513.3 132 511.3 124 505.2C116 499.2 112 490.2 112 480.2V440.2C112 430.2 116 421.2 124 415.2L176 376.2V335.2L41 378.2C31 381.2 20 379.2 12 373.2C4 367.2 0 357.2 0 347.2V282.1C0 271.1 6 259.1 16 254.1L176 153.1V112.1C176 74.04 207 0 256 0V0zM256 33.02C233 33.02 208 81.04 208 113.1V172.1L32 282.1V347.2L208 292.1V392.2L144 440.2V480.2L256 448.2L368 480.2V440.2L304 392.2V292.1L480 347.2V282.1L304 171.1V112.1C304 81.04 278 33.02 256 33.02V33.02z"/></svg>
              <div class="">
                <span>{{ useXmltag('Typeairline')}}::</span>
                <h6>{{ detail_flight.aircraft.aircraft_name }}</h6>
              </div>
            </div>
            <div class="option-item"  v-if=" detail_flight.source_id =='14'"    @click='getBaggage()'>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 24C0 10.7 10.7 0 24 0H72c30.9 0 56 25.1 56 56V408c0 4.4 3.6 8 8 8h72H496 616c13.3 0 24 10.7 24 24s-10.7 24-24 24H544c0 26.5-21.5 48-48 48s-48-21.5-48-48H256c0 26.5-21.5 48-48 48s-48-21.5-48-48H136c-30.9 0-56-25.1-56-56V56c0-4.4-3.6-8-8-8H24C10.7 48 0 37.3 0 24zM360 48c-4.4 0-8 3.6-8 8V96h96V56c0-4.4-3.6-8-8-8H360zM496 96h48c35.3 0 64 28.7 64 64V288c0 35.3-28.7 64-64 64H256c-35.3 0-64-28.7-64-64V160c0-35.3 28.7-64 64-64h48V56c0-30.9 25.1-56 56-56h80c30.9 0 56 25.1 56 56V96zM256 144c-8.8 0-16 7.2-16 16V288c0 8.8 7.2 16 16 16h32V144H256zm80 0V304H464V144H336zM544 304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16H512V304h32z"/></svg>
              <div class="">
                <span :id='`${detail_flight.flight_id}`'>{{ useXmltag('BaggageRule')}}</span>
                <h6>{{detail_flight.baggage.baggage_statement}}</h6>
              </div>
            </div>
            <div class="option-item" v-else>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 96V48C128 21.49 149.5 0 176 0H336C362.5 0 384 21.49 384 48V96H448C483.3 96 512 124.7 512 160V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V160C0 124.7 28.65 96 64 96H128zM160 96H352V48C352 39.16 344.8 32 336 32H176C167.2 32 160 39.16 160 48V96zM128 128V448H384V128H128zM32 160V416C32 433.7 46.33 448 64 448H96V128H64C46.33 128 32 142.3 32 160zM480 416V160C480 142.3 465.7 128 448 128H416V448H448C465.7 448 480 433.7 480 416z"/></svg>
              <div class="">
                <span>{{ useXmltag('Permissibleamount')}}:</span>
                <h6>{{ detail_flight.baggage.baggage_statement }}</h6>
              </div>
            </div>
            <div class="option-item">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M576 208C549.5 208 528 229.5 528 256C528 282.5 549.5 304 576 304V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V304C26.51 304 48 282.5 48 256C48 229.5 26.51 208 0 208V128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V208zM64 96C46.33 96 32 110.3 32 128V182.7C60.25 195 80 223.2 80 256C80 288.8 60.25 316.1 32 329.3V384C32 401.7 46.33 416 64 416H512C529.7 416 544 401.7 544 384V329.3C515.7 316.1 496 288.8 496 256C496 223.2 515.7 195 544 182.7V128C544 110.3 529.7 96 512 96H64z"/></svg>
              <div class="">
                <span>{{ useXmltag('Classrate')}}:</span>
                <h6>{{ detail_flight.cabin_type }}</h6>
              </div>
            </div>
            <div class="option-item">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M79.66 0H126.1C146.9 0 166.8 8.073 181.7 22.51L422.6 255.6L422.3 255.1H528C536.8 255.1 544 263.2 544 271.1C544 280.8 536.8 287.1 528 287.1H296.4C292.2 287.1 288.1 288.5 284 289.6L88.56 341.7C74.08 345.6 63.1 358.7 63.1 373.7C63.1 387.6 72.66 400 85.7 404.8L282.8 477.1C288.1 479 293.7 480 299.4 480H528C536.8 480 544 487.2 544 496C544 504.8 536.8 512 528 512H299.4C289.1 512 280.6 510.3 271.8 507.1L74.68 434.8C49.04 425.4 31.1 401 31.1 373.7C31.1 344.2 51.82 318.4 80.32 310.8L86.99 309L32.74 58.14C26.28 28.24 49.06 .0003 79.66 .0003L79.66 0zM79.66 32C69.46 32 61.86 41.41 64.02 51.38L117.9 300.8L275.8 258.7C282.5 256.9 289.4 256 296.4 256H376.1L159.5 45.51C150.5 36.84 138.6 32 126.1 32L79.66 32zM400 352C408.8 352 416 359.2 416 368C416 376.8 408.8 384 400 384H239.1C231.2 384 223.1 376.8 223.1 368C223.1 359.2 231.2 352 239.1 352H400z"/></svg>
              <div class="">
                <span>{{ useXmltag('Typeflight')}}:</span>
                <h6>{{ detail_flight.seat_class }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Modal v-model="showModal"  :rtl=true wrapper-class="modal-wrapper">
        <body-modal :data_detail="data_modal"></body-modal>
      </Modal>
    </div>
</template>

<script>
import bodyModal from '../global/modal/bodyModal';
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css'
export default {
  name: 'detailReturnFlight',
  props: ['dept_detail_flight' , 'return_detail_flight'],
  components:{
    'Modal' : VueModal,
    'body-modal': bodyModal
  },
  computed : {
    dataSearch() {
      return this.$store.state.setDataSearch.dataSearch
    },
  },
  data(){
    return{
      data_baggage : [],
      data_modal : [] ,
      showModal: false
    }
  },
  methods :{
    getBaggage(){
      document.getElementById(this.dept_detail_flight[0].flight_id).classList.add('skeleton');
      let _this = this;
      axios.post(amadeusPath + 'ajax',
        {
          className: 'newApiFlight',
          method: 'getInfoBaggage',
          request_number: _this.dept_detail_flight[0].request_number,
          flight_id :_this.dept_detail_flight[0].flight_id,
          source_id :_this.dept_detail_flight[0].source_id
        },
        {
          'Content-Type': 'application/json'
        }).then(function (response) {
        console.log(response.data.data);
        _this.data_baggage = response.data.data ;
        _this.callModal(_this.data_baggage)
        document.getElementById(_this.dept_detail_flight[0].flight_id).classList.remove('skeleton');
      }).catch(function (error) {
      });


    },
    callModal(value){
      this.data_modal = value ;
      this.showModal = true
    }
  }
}
</script>

<style scoped>

</style>