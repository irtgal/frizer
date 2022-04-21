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
  created() {
    if (!localStorage.getItem("token")) {
      const adminSlug = this.$route.params.admin;
      this.$router.push(`/${adminSlug}/admin/prijava`);
      return;
    }
    prepareAdminToken();
  },
  mounted() {

  }
}
</script>