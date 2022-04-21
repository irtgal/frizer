
import * as Vue from 'vue'
import App from './App.vue'


import "bootstrap/dist/css/bootstrap.min.css"

import "bootstrap/dist/js/bootstrap.js"

import 'bootstrap-icons/font/bootstrap-icons.css'

// ROUTER
import * as VueRouter from 'vue-router';

import BaseView from './components/BaseView.vue';
import NotFound from './components/404.vue';

import ClientIndex from './components/Client/Index.vue';
import TermConfirmation from './components/Client/TermConfirmation.vue';

import AdminView from './components/Admin/AdminView.vue';
import AdminLogin from './components/Admin/Login.vue';
import AdminIndex from './components/Admin/Index.vue';

const routes = [

  {
    path: '/:admin',
    name: 'base',
    component: BaseView,
    children: [
      // CLIENT ROUTES
      { path: '', component: ClientIndex },
      { path: 'potrditev', component: TermConfirmation },

      // ADMIN ROUTES    
      {
          path: 'admin',
          name: 'admin',
          component: AdminView,
          children: [
              {
                path: '',
                name: 'admin-index',
                component: AdminIndex,
              },
              {
                  path: 'prijava',
                  name: 'login',
                  component: AdminLogin,
              },
          ]
        },
    ]
  },
  { path: "/:catchAll(.*)", component: NotFound }

  ]



  const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes, // short for `routes: routes`
  })

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
