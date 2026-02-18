<template>
  <div class="select position-unset inp-s-num adt box-of-count-nafar">
    <div
      @click="form[strategy].options.passengers_number = true"
      class="box-of-count-nafar-boxes">
      <span class="text-count-nafar">
        {{ form[strategy].passengers_number.rooms.length }} اتاق
      </span>
      <span class="fas fa-caret-down down-count-nafar"></span>
    </div>
    <div
      @click.self="accept_data"
      class="fixed-black"
      :class="form[strategy].options.passengers_number ? 'active' : ''">
      <div
        class="cbox-count-nafar d-flex flex-column flex-row-reverse flex-wrap p-3"
        :class="form[strategy].options.passengers_number ? 'active' : ' '">
        <div class="w-100 mb-3 p-0">
          <h3 class="font-weight-bold m-0 font-19">مسافران</h3>
        </div>

        <div
          class="d-flex w-100 flex-wrap box-hotel-foreign"
          v-for="(room, key) in form[strategy].passengers_number.rooms">
          <span class="font-weight-bold m-0 font-19">اتاق {{ key + 1 }}</span>

          <button
            class="mr-auto icon-close"
            v-if="form[strategy].passengers_number.rooms.length > 1"
            @click="removeRoom(key)">
            <i class="fa fa-close"></i>
          </button>
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
                    @click="increaseCount(passenger_index.index, key)"
                    :class="
                      canAdd(passenger_index.index, key, false)
                        ? ''
                        : 'opacity-5'
                    "
                    class="fas fa-plus m-0 counting-of-count-nafar site-bg-main-color"></i>
                  <i
                    class="number-count counting-of-count-nafar"
                    data-value="l-bozorgsal"
                    id="bozorgsal"
                    >{{ room[passenger_index.index].value }}</i
                  >
                  <i
                    @click="decreaseCount(passenger_index.index, key)"
                    class="fas fa-minus m-0 counting-of-count-nafar minus-nafar site-bg-main-color"></i>
                </div>
              </div>

              <div
                class="d-flex w-100 p-0 flex-wrap"
                v-if="passenger_index.index === 'child'">
                <div
                  class="child-select p-0 w-100"
                  v-for="(age, child_key) in room.child.age">
                  <span class="text-muted small">
                    سن کودک {{ alphabet_number[child_key + 1] }}</span
                  >
                  <select
                    class="bg-transparent border pointer"
                    @change="changeAge(key, child_key, $event)">
                    <option v-for="(i, k) in 12" :value="i">
                      {{ k }} تا {{ i }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex w-100 p-0 flex-wrap">
          <button class="addroom" @click="addRoom">افزودن اتاق</button>
        </div>

        <div class="div_btn">
          <span
            @click="accept_data"
            class="btn btn-block btn-close site-bg-main-color"
            >تأیید</span
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
          title: "بزرگسال",
          text: "(بزرگتر از ۱۲ سال)",
        },
        {
          index: "child",
          title: "کودک",
          text: "(بین 2 الی 12 سال)",
        },
      ],
      alphabet_number: {
        1: "اول",
        2: "دوم",
        3: "سوم",
        4: "چهارم",
        5: "پنجم",
        6: "ششم",
      },
    }
  },
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
    canAdd(passenger_index, room_key, show_error = true) {
      let current_passenger_count =
        this.form[this.strategy].passengers_number.rooms[room_key][
          passenger_index
        ].value

      let index_count =
        this.form[this.strategy].passengers_number.rooms[room_key][passenger_index].value


      let max_count =
        this.form[this.strategy].passengers_number[passenger_index].max


      if (index_count < max_count) {
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
            title: "بیشتر از "+max_count+" مجاز نیست",
          })
        }
        return false
      }
    },
    increaseCount(passenger_index, room_key) {
      let current_passenger_count =
        this.form[this.strategy].passengers_number.rooms[room_key][
          passenger_index
        ].value

      if (this.canAdd(passenger_index, room_key)) {
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
