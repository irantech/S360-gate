export let MyMixin

MyMixin = {
   methods: {
      useXmltag(value) {
         return useXmltag(value)
      },
      successAlert(title , message) {
         return successAlert(title , message)
      },
      errorAlert(title , message) {
         return errorAlert(title , message)
      },
      getLang() {
         return lang
      },
      getUrlWithoutLang() {
         return amadeusPath
      },
      rootMainPath() {
         return rootMainPath
      },
      /*  ConvertCurrency(value_id,value_flag,value_title){
            return ConvertCurrency(value_id,value_flag,value_title)
        },*/
      getDefaultCurrencyInfo() {
         return currency_info
      },
      showSearchBoxTicket() {
         return showSearchBoxTicket()
      },
      changeWays_(value) {
         return changeWays_(value)
      },
      changeWays(value) {
         return changeWays(value)
      },
      submitLocalSide(value) {
         return submitLocalSide(value)
      },
      amadeusPathByLang() {
         return amadeusPathByLang
      },
      getrules(value) {
         return getrules(value)
      },
      dateNow(value) {
         return dateNow(value)
      },
      send_info_passengers() {
         return send_info_passengers()
      },
      main_bg_color() {
         return main_color
      },
      loadingToggle(_this, status) {
         return loadingToggle(_this, status)
      },
      convertJalaliToGregorian(jDate, elem) {
         if (jDate !== null && elem !== null) {
            return convertJalaliToGregorian(jDate, elem)
         }
      },
      translateXmlByParams(tag, params) {
         return translateXmlByParams(tag, params)
      },
      getUserAccount() {
         $("#lowest").toggle()
         return getUserAccount()
      },
      api_gds_client_data() {
         let available_services = [
            "Bus",
            "Flight",
            "Entertainment",
            "Insurance",
            "Tour",
            "Hotel",
            "Train",
            "Visa",
         ]
         let parsed_client_services_detail = JSON.parse(client_services_detail)
         console.log('parsed_client_services_detail' , parsed_client_services_detail)
         // var filteredArray=[]
         //  var filteredArray=parsed_client_services_detail.filter(
         //      item => {
         //         console.log(item.MainService)
         //         return available_services.some(e => {
         //            return e === item.MainService
         //         })
         //      }
         //    );

         // var filteredArray = parsed_client_services_detail.filter(f => available_services.some(
         //   e=>f['MainService']
         // ));

         var filteredArray = parsed_client_services_detail.filter(item => {
            return available_services.includes(item.MainService)
         })
         return {
            client_data: client_data,
            client_name: client_name,
            client_id: client_id,
            online_url: online_url,
            project_files: project_files,
            client_services: JSON.parse(client_services),
            lang : this.getLang(),
            client_services_detail: filteredArray,
         }
      },
      isInArray(value, array) {
         return array.indexOf(value) > -1
      },
      sendInfoReservationFlightForeign(flight_id) {
         return sendInfoReservationFlightForeign(flight_id)
      },
      popupBuyNoLogin(type) {
         return popupBuyNoLogin(type)
      },
      reversOriginDestination() {
         return reversOriginDestination()
      },
      reservation_status(item) {
         switch (item) {
            case "nothing":
               return this.useXmltag('Unknown')
            case "credit":
               return this.useXmltag('Validity')
            case "OnRequest":
               return this.useXmltag('UserRequest')
            case "prereserve":
            case "PreReserve":
               return this.useXmltag('Prereservation')
            case "temporaryReservation":
            case "TemporaryReservation":
               return this.useXmltag('Prereservation')
            case "TemporaryPreReserve":
               return this.useXmltag('Temporaryprebooking')
            case "NoReserve":
               return this.useXmltag('NotReseve')
            case "book":
            case "BookedSuccessfully":
               return this.useXmltag('Definitivereservation')
            case "cancel":
            case "Cancelled":
            case "Cancellation":
            case "CancelFromEuropcar":
            case "TemporaryCancellation":
               return this.useXmltag('Canceled')
            case "error":
               return this.useXmltag('reserveErro')
            default:
               return item
         }
      },
      isIOS() {
         return (
            [
               "iPad Simulator",
               "iPhone Simulator",
               "iPod Simulator",
               "iPad",
               "iPhone",
               "iPod",
            ].includes(navigator.platform) ||
            // iPad on iOS 13 detection
            (navigator.userAgent.includes("Mac") && "ontouchend" in document)
         )
      },
   },
}
