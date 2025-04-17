// import './bootstrap';
import { createApp } from 'vue';
import Antd from 'ant-design-vue';
import Axios from './axios.js';
import router from './router/index.js'
import 'ant-design-vue/dist/antd.css';
import VueApexCharts from 'vue3-apexcharts'
import App from './app.vue';

const app = createApp(App);

app.component('apexchart', VueApexCharts);
app.use (router);
app.use(Antd);
app.config.globalProperties.$axios = Axios;
app.mount('#app');

