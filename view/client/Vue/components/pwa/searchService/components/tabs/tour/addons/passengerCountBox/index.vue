<template>
  <div class="select inp-s-num adt box-of-count-nafar">
    <div
      @click="form[strategy].options.passengers_number = true"
      class="box-of-count-nafar-boxes">
      <span class="text-count-nafar">
        {{ form[strategy].passengers_number.adult.value }} {{ useXmltag('Adult') }} ,
        {{ form[strategy].passengers_number.child.value }} {{ useXmltag('Child') }} ,
        {{ form[strategy].passengers_number.infant.value }} {{ useXmltag('Baby') }}
      </span>
      <span class="fas fa-caret-down down-count-nafar"></span>
    </div>
    <div
      class="cbox-count-nafar"
      :class="form[strategy].options.passengers_number ? 'd-block' : 'd-none'">
      <div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-6">
            <div class="type-of-count-nafar">
              <h6>{{ useXmltag('OlderThanTwelve') }}</h6>
              {{ useXmltag('Adult') }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-6">
            <div class="num-of-count-nafar">
              <i
                @click="increaseCount('adult')"
                class="fas fa-plus counting-of-count-nafar"></i>
              <i
                class="number-count counting-of-count-nafar"
                data-value="l-bozorgsal"
                id="bozorgsal"
                >{{ form[strategy].passengers_number.adult.value }}</i
              >
              <i
                @click="decreaseCount('adult')"
                class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 cbox-count-nafar-ch koodak-num">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-6">
            <div class="type-of-count-nafar">
              <h6>{{ useXmltag('Child') }} </h6>
              {{ useXmltag('BetweenTwoAndTwelve') }
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-6">
            <div class="num-of-count-nafar">
              <i
                @click="increaseCount('child')"
                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
              <i
                class="number-count counting-of-count-nafar"
                data-number="0"
                data-min="0"
                data-value="l-kodak"
                >{{ form[strategy].passengers_number.child.value }}</i
              >
              <i
                @click="decreaseCount('child')"
                class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 cbox-count-nafar-ch nozad-num">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-6">
            <div class="type-of-count-nafar">
              <h6>{{ useXmltag('Baby') }}</h6>
              {{ useXmltag('YoungerThanTwo') }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-6">
            <div class="num-of-count-nafar">
              <i
                @click="increaseCount('infant')"
                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
              <i
                class="number-count counting-of-count-nafar"
                data-number="0"
                data-min="0"
                data-value="l-nozad"
                >{{ form[strategy].passengers_number.infant.value }}</i
              >
              <i
                @click="decreaseCount('infant')"
                class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="div_btn">
        <span @click="accept_data" class="btn btn-close"> {{ useXmltag('Approve') }}</span>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "passenger-count-box",
  props: ["form", "strategy"],

  methods: {
    increaseCount(passenger_index) {
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
          this.form[this.strategy].passengers_number[passenger_index].value =
            current_passenger_count + 1
        } else {
          this.$swal({
            icon: "error",
            toast: true,
            position: "bottom",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 4000,
            title:useXmltag('SumAdultsChildrenNoGreaterThanAdult'),
          })
        }
      } else {
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
