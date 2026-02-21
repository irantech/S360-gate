<template>
  <div class="parent-tour-search">
    <div class="accordion_tour" id="tour-type">
      <div class="parent-accordion-side-bar">
        <div class="title-side-bar" id="title-two">
          <button
            class="btn btn-link btn-block btn-accordion-side-bar"
            type="button"
            data-toggle="collapse"
            data-target="#body-data-collapse-two"
            aria-expanded="true"
            aria-controls="body-data-collapse-two">
            <h2>جستجوی نام تور</h2>
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
          id="body-data-collapse-two"
          class="collapse show"
          aria-labelledby="title-two"
          data-parent="#tour-type">
          <div class="content-side-bar-tour-search">
            <form action="#" class="form-search-tour">
              <input
                type="text"
                v-model='tour_name'
                @input='setSearchedName()'
                placeholder="جستجوی نام تور" />
              <button type="button">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512">
                  <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                  <path
                    d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z" />
                </svg>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name : 'tour-name' ,
  data () {
    return {
      tour_name: ''
    }
  },
  methods :{
    setSearchedName() {
      this.$emit('setSearchedName' , this.tour_name)
    }
  }
}
</script>