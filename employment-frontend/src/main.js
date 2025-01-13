import { createApp } from 'vue'
import App from './App.vue'
import store from './store';
import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000/api'
import './assets/styles/tailwind.css';


const app = createApp(App);
app.use(store);
app.mount('#app');
app.config.globalProperties.axios = axios;
app.config.globalProperties.$url = 'http://localhost:8000/api'
