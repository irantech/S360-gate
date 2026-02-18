<template>
  <div @click.self="isActive = false" class="fixed-black " :class='isActive ? "active" : ""' :style='!isActive ? "display:none !important;":""'>
    <div
      class="cbox-count-nafar d-flex flex-column flex-nowrap p-3 active w-100">
      <div class='download_img d-flex align-items-center justify-content-center flex-column'>
        <img :src='`${getUrlWithoutLang()}view/client/Vue/assets/images/cloud.png`' alt='download_img'>
      </div>
      <h2 class='title_modal'>نصب نسخه تحت وب (IOS)</h2>
      <ul class='list_modal'>
        <li> 1 . ابتدا در نوار پایین بر روی دکمه <span><i class="fa-regular fa-arrow-up-from-square"></i> Share </span> بزنید.</li>
        <li> 2 . بر روی گزینه <span><i class="fa-regular fa-square-plus"></i> Add to Home Screen</span> بزنید.</li>
      </ul>
      <div @click="isActive = false" class="div_btn">
        <span class="btn btn-block btn-close site-bg-main-color">بستن</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isActive:false,
    }
  },
  methods: {},
  created(){
    if(this.isIOS()){
      // this.isActive = true
    }
  }
}
</script>

<style scoped>
.download_img > img{
  width: 100px;
  height: 100px;
  object-fit: contain;
}
.title_modal{
  font-size: 1.3rem;
  text-align: center;
  margin: 1rem 0 0 0;
  color: #696969;
}
.list_modal{
  padding: 1rem;
  margin: 0;
  margin-top: 0px;
  display: flex;
  flex-direction: column;
  text-align: right;
  gap: 15px;
  border-radius: 5px;
  background: #f9f9f9;
  margin-top: 1rem;
}
.list_modal > li{
  font-size: 14px;
  display: flex;
  align-items: center;
  text-align: right;
  flex-wrap: wrap;
}
.list_modal > li > i{
  width: 30px;
  height: 30px;
  display: flex;
  border-radius: 1rem 0 0 1rem;
  background: #fff;
  justify-content: center;
  align-items: center;
  margin-left: .5rem;
  padding: 1rem;
  font-size: 1rem;
}
.list_modal > li > span{
  margin: 0 .4rem;
  background: #d2d2d2;
  padding: 5px;
  border-radius: .4rem;
  display: flex;
  align-items: center;
}
.list_modal > li > span > i{
  margin-left: 5px;
}
</style>