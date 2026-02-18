<template>
  <div class="select inp-s-num adt box-of-count-nafar">
    <div
      @click="form[strategy].options.passengers_number = true"
      class="box-of-count-nafar-boxes">
      <span class="text-count-nafar">
        {{ form[strategy].passengers_number.rooms.length }} اتاق
      </span>
      <span class="fas fa-caret-down down-count-nafar"></span>
    </div>
    <div
      class="cbox-count-nafar p-1"
      :class="form[strategy].options.passengers_number ? 'd-block' : 'd-none'">
      <div
        class="d-flex flex-wrap box-hotel-foreign"
        v-for="(room, key) in form[strategy].passengers_number.rooms">
        اتاق {{ key + 1 }}
        <button
          class="mr-auto icon-close"
          v-if="form[strategy].passengers_number.rooms.length > 1"
          @click="removeRoom(key)">
          <i class="fa fa-close"></i>
        </button>
        <div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
          <div class="row align-items-center">
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="type-of-count-nafar">
                <h6>بزرگسال</h6>
                (بزرگتر از ۱۲ سال)
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="num-of-count-nafar">
                <i
                  @click="increaseCount('adult', key)"
                  class="fas fa-plus counting-of-count-nafar"></i>
                <i
                  class="number-count counting-of-count-nafar"
                  data-value="l-bozorgsal"
                  id="bozorgsal"
                  >{{ room.adult.value }}</i
                >
                <i
                  @click="decreaseCount('adult', key)"
                  class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
          <div class="row align-items-center">
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="type-of-count-nafar">
                <h6>کودک</h6>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-6">
              <div class="num-of-count-nafar">
                <i
                  @click="increaseCount('child', key)"
                  class="fas fa-plus counting-of-count-nafar"></i>
                <i
                  class="number-count counting-of-count-nafar"
                  data-value="l-bozorgsal"
                  >{{ room.child.value }}</i
                >
                <i
                  @click="decreaseCount('child', key)"
                  class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="child-select" v-for="(age, child_key) in room.child.age">
          <select
            class="bg-transparent border pointer"
            @change="changeAge(key, child_key, $event)">
            <option v-for="(i, k) in 12" :value="i">{{ k }} تا {{ i }}</option>
          </select>
        </div>
      </div>
      <button class="addroom" @click="addRoom">افزودن اتاق</button>

      <div class="div_btn">
        <span @click="accept_data" class="btn btn-close site-bg-main-color"
          >تأیید</span
        >
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "passenger-count-box",
  props: ["form", "strategy"],

  methods: {
    removeRoom(room_key) {
      this.form[this.strategy].passengers_number.rooms.splice(room_key, 1)
    },
    addRoom() {
      let new_room = {
        adult: {
          value: 1,
        },
        child: {
          value: 0,
          age: [],
        },
      }
      this.form[this.strategy].passengers_number.rooms.push(new_room)
    },
    changeAge(room_key, child_key, event) {
      this.form[this.strategy].passengers_number.rooms[room_key].child.age[
        child_key
      ].value = event.target.value
    },
    increaseCount(passenger_index, room_key) {
      let current_passenger_count =
        this.form[this.strategy].passengers_number.rooms[room_key][
          passenger_index
        ].value

      let child_count =
        this.form[this.strategy].passengers_number.rooms[room_key].child.value
      let adult_count =
        this.form[this.strategy].passengers_number.rooms[room_key].adult.value

      if (adult_count < 6 && child_count < 6) {
        this.form[this.strategy].passengers_number.rooms[room_key][
          passenger_index
        ].value = current_passenger_count + 1

        if (passenger_index === "child") {
          let age_template = {
            value: 1,
          }
          this.form[this.strategy].passengers_number.rooms[room_key][
            passenger_index
          ].age.push(age_template)
        }
      } else {
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: "بیشتر از 6 مجاز نیست",
        })
      }
    },
    decreaseCount(passenger_index, room_key) {
      let current_passenger_count =
        this.form[this.strategy].passengers_number.rooms[room_key][
          passenger_index
        ].value

      if (current_passenger_count > 0) {
        if (
          passenger_index !== "adult" ||
          this.form[this.strategy].passengers_number.rooms[room_key].adult
            .value > 1
        ) {
          this.form[this.strategy].passengers_number.rooms[room_key][
            passenger_index
          ].value = current_passenger_count - 1

          if (passenger_index === "child") {
            this.form[this.strategy].passengers_number.rooms[room_key][
              passenger_index
            ].age.splice(-1)
          }
        }
      }
    },
    accept_data() {
      this.form[this.strategy].options.passengers_number = false
    },
  },
}
</script>
