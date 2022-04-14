
import * as Vue from 'vue'
import App from './App.vue'

import axios from 'axios'

import "bootstrap/dist/css/bootstrap.min.css"

import "bootstrap/dist/js/bootstrap.js"

const app = Vue.createApp(App);

app.config.globalProperties.axios=axios

app.mount('#app');
