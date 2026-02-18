<template>
  <div class='col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1'>
    <div class="select inp-s-num adt div-searchBox-flight  box-of-count-passenger-js">
      <input :id="type == 'international' ? 'qtyf1' : 'qty1'"  type="hidden" class="internal-adult-js" v-model='searchForm.adult'>
      <input :id="type == 'international' ? 'qtyf2' : 'qty2'"  type="hidden" class="internal-child-js" v-model='searchForm.child'>
      <input :id="type == 'international' ? 'qtyf3' : 'qty3'"  type="hidden" class="internal-infant-js" v-model='searchForm.infant'>
      <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js" @click='openPassengerBox()'>
        <span class="text-count-passenger text-count-passenger-js">{{ searchForm.adult }} {{ useXmltag('Adult') }} ,{{ searchForm.child }} {{ useXmltag('Child') }} ,{{ searchForm.infant }} {{ useXmltag('Baby') }}</span>
        <span class="fas fa-caret-down down-count-passenger"></span>
      </div>
      <div v-show='passenger_box' class="count-passenger-box">
        <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="type-of-count-passenger"><h6>  {{ useXmltag('Adult') }} </h6>{{ useXmltag('OlderThanTwelve') }}
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="num-of-count-passenger">
                <div class="counting-of-count-passenger"   @click="addPassenger('adult')">
                  <svg :class="{'disable_add' : total_count >= 9}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                </div>
                <i class="number-count counting-of-count-passenger"
                   :data-number="searchForm.adult" data-min="1" data-search="internal" data-type="adult">{{ searchForm.adult }}</i>
                <div class="counting-of-count-passenger" @click="minusPassenger('adult')">
                  <svg :class="{'disable_add' : searchForm.adult <= 1}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 cbox-count-passenger-ch child-number-js">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="type-of-count-passenger">
                <h6> {{ useXmltag('Child') }}  </h6>{{ useXmltag('BetweenTwoAndTwelve') }}
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="num-of-count-passenger">
                <div class="counting-of-count-passenger"  @click="addPassenger('child')">
                  <svg :class="{'disable_add' : total_count >= 9}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                </div>
                <i class="number-count counting-of-count-passenger" :data-number="searchForm.child" data-min="0" data-search="internal" data-type="child">{{ searchForm.child }}</i>
                <div class="counting-of-count-passenger" @click="minusPassenger('child')">
                  <svg :class="{'disable_add' : searchForm.child == 0 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 cbox-count-passenger-ch infant-number-js">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="type-of-count-passenger">
                <h6> {{ useXmltag('Baby') }}  </h6>{{ useXmltag('YoungerThanTwo') }}
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="num-of-count-passenger">
                <div class="counting-of-count-passenger" @click="addPassenger('infant')">
                  <svg :class="{'disable_add' : total_count >= 9}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                </div>
                <i class="number-count counting-of-count-passenger"
                   :data-number="searchForm.infant" data-min="0">{{ searchForm.infant }}</i>
                <div class="counting-of-count-passenger" @click="minusPassenger('infant')">
                  <svg :class="{'disable_add' : searchForm.infant == 0 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="div_btn">
          <span class="btn btn-close " @click='closePassengerBox()'>{{ useXmltag('Approve') }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default  {
    name : 'passengers' ,
    props: ['type'] ,
    data() {
      return {
        passenger_box : false ,
      }
    },
    methods  : {
      openPassengerBox () {
        this.passenger_box = ! this.passenger_box
      },
      closePassengerBox() {
        this.passenger_box = false
      },
      addPassenger(type) {

        if(type == 'adult') {
          if(this.searchForm.adult < 9  && this.total_count < 9){
            ++this.searchForm.adult;

          }
        }else if(type == 'child') {
          if(this.searchForm.child < 9 && this.total_count < 9){
            ++this.searchForm.child;
          }
        }else if(type == 'infant') {
          if (this.searchForm.infant < 9 && this.total_count < 9) {
            ++this.searchForm.infant;
          }
        }
      },
      minusPassenger(type) {
        if(type == 'adult') {
          if(this.searchForm.adult > 1 ){
            --this.searchForm.adult;
          }
        }else if(type == 'child') {
          if(this.searchForm.child >= 1 ){
            --this.searchForm.child;
          }
        }else if(type == 'infant') {
          if (this.searchForm.infant >= 1) {
            --this.searchForm.infant;
          }
        }
      }

    } ,
    computed : {
      total_count (){
        return parseInt(this.searchForm.adult) + parseInt(this.searchForm.child) + parseInt(this.searchForm.infant)
      },
      searchForm() {
        return this.$store.state.formDataSearch
      }
    }
  }
</script>