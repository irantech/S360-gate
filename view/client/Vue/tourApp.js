

import Vue from 'vue';
import {MyMixin} from './functionVue';
import store from './jsVuex/store';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// If you don't need the styles, do not connect
window.Vue = Vue;

import tourApp from './components/tour/index.vue';
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
import VueSkeletonLoader from 'skeleton-loader-vue';
Vue.component('tourApp', tourApp);

// Register the component globally
Vue.component('vue-skeleton-loader', VueSkeletonLoader);
Vue.use(VuePersianDatetimePicker, {
    name: 'date_picker',
    props: {
        editable: false,
        color: main_color,
        autoSubmit: true,
    }
});





Vue.use(VueSweetalert2);
/* Class => site-bg-main-color */
window.axios = require('axios');
Vue.mixin(MyMixin);
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
});
Vue.filter("formatNumberDecimal", function (value) {
    return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
const app = new Vue({
    store: store,
    el: '#vueApp'
});

