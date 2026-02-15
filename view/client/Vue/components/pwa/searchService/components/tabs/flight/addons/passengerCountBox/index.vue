<template>
  <div class="select position-unset inp-s-num adt box-of-count-nafar">
    <div
      @click="form[strategy].options.passengers_number = true"
      class="box-of-count-nafar-boxes">
      <span class="text-count-nafar">
        {{ form[strategy].passengers_number.adult.value }} {{ useXmltag('Adult')}} ,
        {{ form[strategy].passengers_number.child.value }} {{ useXmltag('Child')}} ,
        {{ form[strategy].passengers_number.infant.value }} {{ useXmltag('Baby')}}
      </span>
      <span class="fas fa-caret-down down-count-nafar"></span>
    </div>
    <div
      @click.self="accept_data"
      class="fixed-black"
      :class="form[strategy].options.passengers_number ? 'active' : ''">
      <div
        class="cbox-count-nafar p-3"
        :class="form[strategy].options.passengers_number ? 'active' : ' '">
        <div class="col-md-12 mb-3 p-0">
          <h3 class="font-weight-bold m-0 font-19">{{ useXmltag('Passenger')}}</h3>
        </div>

        <div
          v-for="passenger_index in passengers_index"
          class="col-md-12 p-0 bozorg-num mb-2">
          <div
            class="align-items-center d-flex flex-wrap justify-content-between row">
            <div class="d-flex p-0">
              <div class="type-of-count-nafar">
                <h6>{{ passenger_index.title }}</h6>
                <span class="text-muted">
                  {{ passenger_index.text }}
                </span>
              </div>
            </div>
            <div class="d-flex p-0">
              <div class="num-of-count-nafar">
                <i
                  @click="increaseCount(passenger_index.index)"
                  :class="
                    canAdd(passenger_index.index, false) ? '' : 'opacity-5'
                  "
                  class="fas fa-plus m-0 counting-of-count-nafar site-bg-main-color"></i>
                <i
                  class="number-count counting-of-count-nafar"
                  data-value="l-bozorgsal"
                  id="bozorgsal"
                  >{{
                    form[strategy].passengers_number[passenger_index.index]
                      .value
                  }}</i
                >
                <i
                  @click="decreaseCount(passenger_index.index)"
                  :class="
                    form[strategy].passengers_number[passenger_index.index]
                      .value <=
                    form[strategy].passengers_number[passenger_index.index].min
                      ? 'opacity-5'
                      : ''
                  "
                  class="fas fa-minus m-0 counting-of-count-nafar minus-nafar site-bg-main-color"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="div_btn">
          <span
            @click="accept_data"
            class="btn btn-block btn-close site-bg-main-color"
            >{{ useXmltag('Approve')}}</span
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "passenger-count-box",
  props: ["form", "strategy"],
  data() {
    return {
      passengers_index: [
        {
          index: "adult",
          title: useXmltag('Adult'),
          text: useXmltag('OlderThanTwelve'),
        },
        {
          index: "child",
          title:useXmltag('Child'),
          text: useXmltag('BetweenTwoAndTwelve'),
        },
        {
          index: "infant",
          title: useXmltag('Baby'),
          text:  useXmltag('YoungerThanTwo'),
        },
      ],
    }
  },
  methods: {
    canAdd(passenger_index, show_error = true) {
      let passenger_max = this.form[this.strategy].passengers_number.max
      let current_passenger_count =
        this.form[this.strategy].passengers_number[passenger_index].value
      let all_passengers_count = 0
      let all_passengers_index = ["adult", "child", "infant"]
      for (let item in all_passengers_index) {
        all_passengers_count +=
          this.form[this.strategy].passengers_number[all_passengers_index[item]]
            .value
      }
      if (all_passengers_count <= passenger_max) {
        let child_count = this.form[this.strategy].passengers_number.child.value
        let adult_count = this.form[this.strategy].passengers_number.adult.value
        let infant_count =
          this.form[this.strategy].passengers_number.infant.value

        if (
          passenger_index !== "infant" ||
          child_count + adult_count > infant_count
        ) {
          return true
        } else {
          if (show_error) {
            this.$swal({
              icon: "error",
              toast: true,
              position: "bottom",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 4000,
              title: useXmltag('SumAdultsChildrenNoGreaterThanAdult'),
            })
          }

          return false
        }
      } else {
        if (show_error) {
          this.$swal({
            icon: "error",
            toast: true,
            position: "bottom",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            title: useXmltag('maximum') + useXmltag('Countpassengers') + passenger_max + useXmltag('People'),
          })
        }
        return false
      }
    },
    increaseCount(passenger_index) {
      if (this.canAdd(passenger_index)) {
        let current_passenger_count =
          this.form[this.strategy].passengers_number[passenger_index].value

        this.form[this.strategy].passengers_number[passenger_index].value =
          current_passenger_count + 1
      }
    },
    decreaseCount(passenger_index) {
      let current_passenger_count =
        this.form[this.strategy].passengers_number[passenger_index].value

      if (current_passenger_count > 0) {
        if (
          passenger_index !== "adult" ||
          this.form[this.strategy].passengers_number.adult.value > 1
        ) {
          this.form[this.strategy].passengers_number[passenger_index].value =
            current_passenger_count - 1
        }
      }
    },
    accept_data() {
      this.form[this.strategy].options.passengers_number = false
    },
  },
}
</script>
