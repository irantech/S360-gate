<template>
  <div class="cheng-money" @click='displayCurrency()'>
    <div >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M558.1 64L535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23-64.6 0 0 0H160v16c0 35.3-28.7 64-64 64H80v93.5L50.7 314.7 32 333.5V128c0-35.3 28.7-64 64-64H383.6l.4 0 174.1 0zM560 320V226.5l29.3-29.3L608 178.5V384c0 35.3-28.7 64-64 64H146.5l0 0-64.6 0 23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-23 23L256 400c.1 0 .3 0 .4 0H480V384c0-35.3 28.7-64 64-64h16zM320 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
      <h4>{{ currency_title }}</h4>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"></path></svg>
    <ul class="money-filter_ul arrow-up2" :class="{'active_money-filter' : show_currency}">
      <li class="change-currency-item main" @click="ConvertCurrency('0','Iran.png','ریال ایران')">
        <div>
          <span>
            <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/Iran.png`" alt="img">
                  {{useXmltag('Rial')}}
          </span>
        </div>
      </li>
      <li v-for='currency in list_currency' @click="ConvertCurrency(currency)">
        <div>
              <span>
                <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/${currency.CurrencyFlag}`" alt="img">
                  {{currency.CurrencyTitle}}
              </span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name : 'currency' ,
  data() {
    return {
      show_currency : false ,
      list_currency : [] ,
      currency_title : useXmltag('Rial') ,
      currency_info: ''
    }
  },

  methods : {
    displayCurrency() {
      this.show_currency = ! this.show_currency
    },
    listCurrency() {
      let _this = this
      axios.post(amadeusPath + 'ajax',
        {
          className: 'newApiFlight',
          method: 'listCurrency',
          is_json: true,
        },
        {
          'Content-Type': 'application/json',
        }).then(function(response) {
        _this.list_currency = response.data.data
      }).catch(function(error) {
        _this.list_currency = []
      })
    },
    ConvertCurrency(currency) {
      let _this = this
      if (currency === '0') {
        _this.currency_title = useXmltag('Rial')
      }
      else if (this.dataSearch.software_lang === 'fa') {
        _this.currency_title = currency.CurrencyTitle
      }else{
        _this.currency_title = currency.CurrencyTitleEn
      }
      axios.post(amadeusPath + 'ajax', {
        className: 'currencyEquivalent',
        method: 'CurrencyEquivalent',
        code: currency.CurrencyCode,
        is_json: true,
      }, {
        'Content-Type': 'application/json',
      }).then(function(response) {
        _this.show_currency = false
        _this.$store.commit('setPriceCurrency', response.data)
      }).catch(function(error) {
        console.log(error)
      })
    } ,
    getCurrencyInfo() {
      let _this = this
      axios.post(amadeusPath + 'ajax',
        {
          className: 'newApiFlight',
          method: 'infoCurrency',
          is_json: true,
        },
        {
          'Content-Type': 'application/json',
        }).then(function(response) {
        _this.currency_info = response.data.data
        if (_this.dataSearch.software_lang !== 'fa') {
          _this.currency_title = _this.currency_info.CurrencyTitleEn
        } else {
          console.log(_this.currency_info.CurrencyTitleFa)
          if(_this.currency_info.CurrencyTitleFa) {
            _this.currency_title = _this.currency_info.CurrencyTitleFa
          }else{
            _this.currency_title = useXmltag('Rial')
          }

        }

      }).catch(function(error) {
        console.log(error)
      })

    },
  } ,
  computed: {
    dataSearch() {
      return this.$store.state.setDataSearch.dataSearch
    }
  },
  mounted() {
    this.getCurrencyInfo();
    this.listCurrency()
  }
}
</script>