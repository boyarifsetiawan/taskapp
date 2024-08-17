import './bootstrap';
import { createApp } from 'vue';
import App from './src/App.vue';
import router from './src/router';
import ToastPlugin from 'vue-toast-notification';
import { createPinia } from 'pinia';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { Bootstrap5Pagination } from 'laravel-vue-pagination'
import VueApexCharts from "vue3-apexcharts";
import BaseButton from './src/components/BaseButton.vue'
import Error from './src/components/Error.vue'
import BaseInput from './src/components/BaseInput.vue'


createApp(App)
.use(ToastPlugin)
.use(router)
.use(createPinia())
.use(VueApexCharts)
.component('Bootstrap5Pagination',Bootstrap5Pagination)
.component('BaseButton', BaseButton)
.component('BaseInput', BaseInput)
.component('Error', Error)
.mount('#app');