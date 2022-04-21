<template>
  <div class="spinner-container">
    <div class="spinner-border" role="status">
      <span class="sr-only"></span>
    </div>
    <h4 class="mt-3" v-if="showOneMoment">Še čisto malo</h4>
  </div>
</template>

<script>

export default {
  name: 'ShowTerm',
  data: function () {
    return {
        showOneMoment: false,
    }
  },
  methods: {
  },
  mounted() {
    setTimeout(() => {this.showOneMoment = true}, 3000);
  },
  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.show-term {
  width: 80%;
  margin: auto;
  text-align: center;
  margin-top: 2em;
}
.details {
}
.check {
  font-size: 4em;
}

</style>
