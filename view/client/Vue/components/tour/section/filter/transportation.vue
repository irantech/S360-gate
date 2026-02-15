<template>
  <div class="parent-tour-transfer">
    <div class="accordion_tour" id="tour-transfer">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-five">
          <button
            class="btn btn-link btn-block btn-accordion-side-bar"
            type="button"
            data-toggle="collapse"
            data-target="#body-data-collapse-five"
            aria-expanded="true"
            aria-controls="body-data-collapse-five">
            <h2>شرکت حمل و نقل</h2>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 384 512">
              <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
              <path
                d="M167 143c9.4-9.4 24.6-9.4 33.9 0L361 303c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-143-143L41 337c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L167 143z" />
            </svg>
          </button>
        </div>
        <div
          id="body-data-collapse-five"
          class="collapse show"
          aria-labelledby="title-five"
          data-parent="#tour-transfer">
          <div class="content-side-bar-tour-type">



            <div
              v-for="(vehicle, index) in availableTransportCompany"
              :key="index"
              class="styled-checkbox">
              <input
                type="checkbox"
                :value="vehicle.abbreviation"
                :id="`${index}-vehicle-dwdwdwd2`"
                v-model="selectedTransportCompany" />
              <label :for="`${index}-vehicle-dwdwdwd2`">
                <img  :src="vehicle.logo_address" :alt="'img-' + vehicle.name_en">
                {{  vehicle.name_fa ? vehicle.name_fa : vehicle.name  }}
              </label>
              <i v-if="vehicle.type	== 'هواپیما'" class="parent-svg-type-transfer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 167.4l-24 0c0 8.2 4.2 15.8 11.1 20.2L312 167.4zM473.3 270.6l12.9-20.2h0l-12.9 20.2zm-6.1 82.8l-7.3 22.9 7.3-22.9zM312 303.7l7.3-22.9c-7.3-2.3-15.3-1-21.5 3.5s-9.8 11.7-9.8 19.4h24zm0 72.3H288c0 7.6 3.6 14.7 9.6 19.2L312 376zm57.6 43.2l-14.4 19.2h0l14.4-19.2zM358 487.4l7.1-22.9 0 0L358 487.4zM256 456l7.1-22.9c-4.6-1.4-9.5-1.4-14.1 0L256 456zM154 487.4l-7.1-22.9h0l7.1 22.9zm-11.6-68.2l14.4 19.2-14.4-19.2zM200 376l14.4 19.2c6-4.5 9.6-11.6 9.6-19.2l-24 0zm0-72.3l24 0c0-7.7-3.7-14.9-9.8-19.4s-14.2-5.8-21.5-3.5l7.3 22.9zM44.9 353.3l7.3 22.9h0l-7.3-22.9zm-6.1-82.8L25.8 250.3l0 0 12.9 20.2zM200 167.4l12.9 20.2c6.9-4.4 11.1-12 11.1-20.2H200zM256 0c-17.4 0-31.1 8.8-40.7 18.7c-9.6 9.9-16.9 22.4-22.4 34.8C182.1 78 176 107.3 176 128h48c0-13.4 4.4-36.1 12.8-55.1c4.2-9.4 8.7-16.4 12.9-20.7c4.1-4.2 6.2-4.2 6.3-4.2V0zm80 128c0-20.6-5.8-49.8-16.5-74.4c-5.4-12.4-12.7-25-22.4-34.9C287.2 8.6 273.4 0 256 0V48c.6 0 2.8 .1 6.8 4.2c4.2 4.3 8.6 11.2 12.7 20.6C283.8 91.7 288 114.4 288 128l48 0zm0 39.4V128l-48 0v39.4l48 0zm150.2 83L324.9 147.1l-25.9 40.4L460.3 290.8l25.9-40.4zM512 297.5c0-19.1-9.7-36.9-25.8-47.2l-25.9 40.4c2.3 1.5 3.7 4 3.7 6.7h48zm0 40.6V297.5H464v40.6h48zm-52.2 38.1c25.8 8.3 52.2-11 52.2-38.1H464c0-5.4 5.3-9.3 10.4-7.6l-14.6 45.7zM304.7 326.5l155.1 49.6 14.6-45.7L319.3 280.8l-14.6 45.7zM336 376V303.7H288V376h48zm-38.4 19.2l57.6 43.2L384 400l-57.6-43.2-28.8 38.4zm57.6 43.2c-2-1.5-3.2-3.9-3.2-6.4h48c0-12.6-5.9-24.4-16-32l-28.8 38.4zM352 432v42.1h48V432H352zm0 42.1c0-5.6 4.5-10.1 10.1-10.1v48c20.9 0 37.9-17 37.9-37.9H352zM362.1 464c1 0 2 .2 3 .4l-14.1 45.9c3.6 1.1 7.4 1.7 11.1 1.7V464zm3 .4l-102-31.4-14.1 45.9 102 31.4 14.1-45.9zM248.9 433.1l-102 31.4 14.1 45.9 102-31.4-14.1-45.9zm-102 31.4c1-.3 2-.4 3-.4l0 48c3.8 0 7.5-.6 11.1-1.7l-14.1-45.9zm3-.4c5.6 0 10.1 4.5 10.1 10.1H112c0 20.9 17 37.9 37.9 37.9l0-48zM160 474.1l0-42.1H112v42.1h48zm0-42.1c0 2.5-1.2 4.9-3.2 6.4L128 400c-10.1 7.6-16 19.4-16 32h48zm-3.2 6.4l57.6-43.2-28.8-38.4L128 400l28.8 38.4zM176 303.7l0 72.3 48 0 0-72.3-48 0zM52.2 376.2l155.1-49.6-14.6-45.7L37.6 330.5l14.6 45.7zM0 338.1c0 27.1 26.4 46.4 52.2 38.1L37.6 330.5c5.2-1.7 10.4 2.2 10.4 7.6H0zm0-40.6l0 40.6H48l0-40.6H0zm25.8-47.2C9.7 260.6 0 278.4 0 297.5H48c0-2.7 1.4-5.3 3.7-6.7L25.8 250.3zM187.1 147.1L25.8 250.3l25.9 40.4L212.9 187.6l-25.9-40.4zM176 128v39.4h48V128H176z"/></svg>
              </i>
              <i v-else-if="vehicle.type	== 'قطار'" class="parent-svg-type-transfer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M352 48c26.5 0 48 21.5 48 48v96H48V96c0-26.5 21.5-48 48-48H352zM48 352V240H400V352c0 26.5-21.5 48-48 48H96c-26.5 0-48-21.5-48-48zM96 0C43 0 0 43 0 96V352c0 42.8 28 79 66.6 91.4L39 471c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l57-57H318.1l57 57c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-27.6-27.6C420 431 448 394.8 448 352V96c0-53-43-96-96-96H96zM224 360a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>
              </i>
              <i v-else-if="vehicle.type	== 'کشتی'" class="parent-svg-type-transfer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M331.7 96h97.5C413.4 78.9 367.2 48 256 48C153.8 48 101.8 78.3 83.5 96h96.8c5.5-9.6 15.9-16 27.7-16l96 0c11.8 0 22.2 6.4 27.7 16zM432 144H280v80H432V144zM80 144v80H232V144H80zm0 128V376c0 13.3 10.7 24 24 24H332.2 408c13.3 0 24-10.7 24-24V272H80zM42.2 70C67.9 38.7 135.8 0 256 0C384.6 0 446 38.6 470.4 70.6c7.5 9.8 9.6 20.9 9.6 29.9V128c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32V376c0 25-12.7 47-32 59.9V488c0 13.3-10.7 24-24 24s-24-10.7-24-24V448H332.2 112v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V435.9C44.7 423 32 401 32 376V256c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32V100.4C32 91.6 34 80 42.2 70zM144 304a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm224 0a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
              </i>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name : 'transportation',
  data() {
    return {
      none_star: false,
      selectedTransportCompany: [],
    }
  },
  computed: {
    availableTransportCompany() {
      return this.$store.state.tours.filters.defaultData.vehicles
    }
  },
  methods: {
    setTransportCompany() {
      this.$emit("setTransportCompany", this.selectedTransportCompany)
    },
  },
  watch: {
    selectedTransportCompany(newValue) {

      if (newValue) {
        this.setTransportCompany()
      }
    },
  },
}
</script>