<template>
  <div class="login container mt-5">
    <div class="row mx-2">
        <div class="col-md-12">
            <h2 class="text-center mb-3">Admin Prijava</h2>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input v-model="email" type="email" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Geslo</label>
                <input v-model="password" type="password" class="form-control">
            </div>
            <div class="mb-3" v-if="error">
              <p class="text-danger">{{error}}</p>
            </div>
            <button type="submit" @click="login()" class="btn btn-primary w-100">Prijava</button>
        </div>
    </div>
  </div>
</template>

<script>

import axios from '../../helpers/axios.js';
import {prepareAdminToken} from '../../helpers/functions.js';

export default {
  name: 'ShowTerm',
  data: function () {
    return {
        email: "",
        password: "",
        error: "",
    }
  },
  methods: {
    login() {
      if (!this.email || !this.password) {
        this.error = "Manjkajo podatki";
        return;
      }
      axios.post('/admin/login', {'email': this.email, 'password': this.password})
        .then((response) => {
          if (!response.data.token) {
            this.error = "Neveljavni podatki";
            return;
          }
          localStorage.setItem("token", response.data.token);
          console.log("login token: ", localStorage.getItem("token"));
          prepareAdminToken();
          this.$router.push({name: 'admin-index'});
          console.log("pushing");
        })
        .catch(() => {
          this.error = "Neveljavni podatki";
        })

    },
  },
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.login {
}

</style>
