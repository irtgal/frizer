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
      { 
        path: '',
        component: ClientIndex
      },
      {
        path: 'potrditev',
        name: 'confirmation',
        component: TermConfirmation
      },

      // ADMIN ROUTES    
      {
          path: 'admin',
          name: 'admin',
          component: AdminView,
          children: [
            {
                path: 'prijava',
                name: 'login',
                component: AdminLogin,
            },
              {
                path: '',
                name: 'admin-index',
                component: AdminIndex,
              },
          ]
        },
    ]
  },
  { path: "/:catchAll(.*)", component: NotFound }

  ]



  const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHistory(),
    routes, // short for `routes: routes`
  })

  export default router;