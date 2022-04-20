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
                <label for="exampleInputPassword1" class="form-label">Geslo</label>
                <input type="password" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input v-model="password" type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" >Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Prijava</button>
        </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'ShowTerm',
  data: function () {
    return {
        email: "",
        password: "",
    }
  },
  methods: {
  },
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.login {
}

</style>
