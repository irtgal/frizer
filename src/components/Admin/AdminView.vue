<template>
  <router-view id="admin-view" />
</template>
<script>
import {prepareAdminToken} from '../../helpers/functions.js'
export default {
  data() {
    return {
    }
  },
  computed: {
  },
  watch:{
    '$route' (to, from){
      if (from.name === "login") {
        prepareAdminToken();
      }
    }
  },
  created() {
    prepareAdminToken();
  },
  mounted() {

  }
}
</script>