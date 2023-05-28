<template>
  <router-view id="admin-view" />
</template>
<script>
import {prepareAdminToken, clearAdminToken} from '../../helpers/functions.js'
import axios from '../../helpers/axios.js';
import router from '../../router.js';
export default {
  data() {
    return {
    }
  },
  computed: {
  },
  created() {
    if (localStorage.getItem("token")) {
      prepareAdminToken();
    }
  // Add a response interceptor
  axios.interceptors.response.use((response) => {
      return response;
    }, (error) => {
      console.log("ERROR", error.response.status);
        // if unauthorised
        if (error.response.status === 401) {
            clearAdminToken();
            router.push({name: 'login'});          
        }                                         
      return Promise.reject(error);
    });
  },
  mounted() {

  }
}
</script>