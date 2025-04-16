// import './bootstrap';
import { createApp } from 'vue';
import Antd from 'ant-design-vue';
import Axios from './axios.js';
import router from './router/index.js'
import 'ant-design-vue/dist/antd.css';
import ExampleComponent from './components/ExampleComponent.vue';
import AppSidebar from './components/AppSidebar.vue';


const app = createApp({
    components: {
        AppSidebar
    },
});

app.use (router);
app.use(Antd);
app.config.globalProperties.$axios = Axios;
app.mount('#app');

