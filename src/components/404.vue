<template>
  <div class="error">
    <i class="bi bi-x-circle-fill check"></i>
    <h1>Stran ne obstaja</h1>
  </div>
</template>

<script>

export default {
  name: '404',
  data: function () {
    return {
    }
  },
  methods: {
  }
  
}
</script>
<style scoped>
.error {
  width: 80%;
  margin: auto;
  text-align: center;
  margin-top: 2em;
}
.check {
  font-size: 4em;
}

</style>