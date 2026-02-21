<template>
  <div class='modal_style_parent'>
    <div>
        <div class="row">
          <div class="col-md-12 modal-info">
            {{ useXmltag('RequestOfflineInfo') }}
          </div>
        </div>
        <div>
          <div class="row">
            <input type="hidden" name="infoRequestOffline" id="infoRequestOffline" value='<?php echo $Param ?>'>
            <div class="col-12 pt-3 ">
              <label style="float:right;">  {{ useXmltag('Namefamily') }}</label>
              <input v-model="form.full_name" class="form-control " type="text" id="fullName" name="fullName">
            </div>
            <div class="col-12 pt-3 ">
              <label style="float:right;"> {{ useXmltag('Phonenumber') }}</label>
              <input v-model="form.mobile" class="form-control " type="text" id="mobile" name="mobile">
            </div>
            <div class="col-12 pt-3 ">
              <label style="float:right;"> {{ useXmltag('Description') }}</label>
              <input  v-model="form.description" class="form-control " type="text" id="description" name="description">
            </div>
            <div class="col-12 d-flex justify-content-center align-content-center pt-3 mt-1">
              <input class="button_SMSReservationRequest" :style="`filter : blur(${blur_number}px)`" :disabled='is_disable' @click="requestServiceOffline()" type="button" :value="useXmltag('Submitapplication')">
            </div>
          </div>
        </div>

    </div>

  </div>
</template>

<script>

export default {
  props : ['dataSearch' , 'member'],
  name: 'requestModal',
  data() {
    return {
      form : {
        full_name  : '' ,
        mobile : '' ,
        requested_data  : '',
        description :''
      } ,
      is_disable : false ,
      blur_number : 0 ,
    }
  },
  methods: {
    async requestServiceOffline() {
      let _this = this
      _this.is_disable = true
      _this.blur_number = 2
      if(_this.form.full_name == '' && _this.form.mobile == '') {
        errorAlert( useXmltag("RequestOfflineService")  , useXmltag("PleaseEnterItems"))
        _this.blur_number = 0
        _this.is_disable = false
        return false
      }else if(!this.validateMobileNumber(_this.form.mobile)) {
        errorAlert( useXmltag("RequestOfflineService")  , useXmltag("PleaseEnterValidMobile"))
        _this.blur_number = 0
        _this.is_disable = false
        return false
      }
      else{
        _this.dataSearch.dataSearch.service = 'Flight'
        _this.form.requested_data = this.dataSearch.dataSearch

        await axios
          .post(
            amadeusPath + "ajax",
            {
              className: "requestOffline",
              method: "create",
              infoRequestOffline: JSON.stringify(_this.form.requested_data) ,
              fullName: _this.form.full_name,
              mobile: _this.form.mobile ,
              description: _this.form.description ,
            },
            {
              "Content-Type": "application/json",
            }
          )
          .then(function (response) {
            _this.blur_number = 0
            _this.is_disable = false;
            if (response.data.messageStatus == 'Success') {
              _this.form.full_name = "";
              _this.form.mobile = "";
              _this.$emit('close')
              successAlert(useXmltag("RequestOfflineService") , response.data.messageRequest)
            } else {
              errorAlert(useXmltag("RequestOfflineService") , response.data.messageRequest)
            }
          })
          .catch(function (error) {
            errorAlert(useXmltag("RequestOfflineService") , 'error has occured')
          });
      }

    } ,
    validateMobileNumber(mobile) {
      const validationRegex = /^[0-9]{11}$/;
      if (mobile.match(validationRegex)) {
        return true
      } else {
        return false
      }
    },
  } ,
  created() {
    let _this = this
    if(_this.member){
      _this.form.full_name = _this.member.name + ' ' + _this.member.family
      _this.form.mobile = _this.member.mobile
    }
  }
}
</script>
