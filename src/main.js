
import * as Vue from 'vue'
import App from './App.vue'


import "bootstrap/dist/css/bootstrap.min.css"

import "bootstrap/dist/js/bootstrap.js"

import 'bootstrap-icons/font/bootstrap-icons.css'

// components


import Loader from './components/Loader.vue';
import AddTerm from './components/Admin/AddTerm.vue';
import ReserveTerm from './components/ReserveTerm.vue';

const app = Vue.createApp(App);

app.component('Loader', Loader);
app.component('AddTerm', AddTerm);
app.component('ReserveTerm', ReserveTerm);


app.mount('#app');
