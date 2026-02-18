<template>
  <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search p-1">
    <button type="button"
            @click="submitLocalSide(searchModule)"
            class="btn btn-searchBox-flight b-0"><span>{{ useXmltag('Search') }}</span></button>
  </div>
</template>

<script>
export  default {
  name : 'search_approve'  ,
  props :['searchModule'] ,
  data() {
    return {

    }
  }
}


</script>