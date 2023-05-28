
import * as Vue from 'vue'
import App from './App.vue'

import router from './router.js';


import "bootstrap/dist/css/bootstrap.min.css"

import "bootstrap/dist/js/bootstrap.js"

import 'bootstrap-icons/font/bootstrap-icons.css'



  /*
  router.beforeEach((to, from) => {
    // ...
    // explicitly return false to cancel the navigation
    return false
  })
  */


// components
import Loader from './components/Loader.vue';
import AddTerm from './components/Admin/AddTerm.vue';
import ReserveTerm from './components/ReserveTerm.vue';

const app = Vue.createApp(App);

app.component('Loader', Loader);
app.component('AddTerm', AddTerm);
app.component('ReserveTerm', ReserveTerm);

app.use(router);
app.mount('#app');
