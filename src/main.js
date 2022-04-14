
import * as Vue from 'vue'
import App from './App.vue'

import axios from 'axios'

import "bootstrap/dist/css/bootstrap.min.css"

import "bootstrap/dist/js/bootstrap.js"

import 'bootstrap-icons/font/bootstrap-icons.css'

// components


import AddTerm from './components/Admin/AddTerm.vue';
import ShowTerm from './components/Admin/ShowTerm.vue';

const app = Vue.createApp(App);

app.component('AddTerm', AddTerm);
app.component('ShowTerm', ShowTerm);

app.config.globalProperties.axios=axios

app.mount('#app');
