<template>
  <div class="show-term" v-if="!loading && term && term.reserved && types">
    <i class="bi bi-check-circle check"></i>
    <h1>Vse štima</h1>
    <div class="details mt-5">
        <div class="form-group">
            <label>Čas termina</label>
            <h3>{{fullTermTime()}} ob {{term.time}}</h3>
        </div>
        <div class="form-group mt-3">
            <label>Ime</label>
            <h3>{{term.name }}</h3>
        </div>
        <div class="form-group mt-3">
            <label>Storitev</label>
            <h3>{{getType(term.type).name}}</h3>
        </div>
        <div class="form-group mt-3">
            <label>Cena</label>
            <h3>{{getType(term.type).price}}€</h3>
        </div>
        <div class="form-group mt-3">
            <label>Email</label>
            <h3>{{term.contact || '/' }} </h3>
        </div>
    </div>
  </div>
  <div v-else-if="!loading" class="show-term">
    <i class="bi bi-x-circle-fill check"></i>
    <h1>Nekej ne štima</h1>
  </div>
</template>

<script>
import axios from '../../helpers/axios.js';
import {dayName, formatDate} from '../../helpers/functions.js';
import State from '../../helpers/State.js';

export default {
  name: 'ShowTerm',
  data: function () {
    return {
      loading: true,
      term: null,
      types: [],
    }
  },
  methods: {
    termId() {
      return State.term?.id;
    },
    fetchTerm() {
      this.loading = true;
      axios.get(`/client/terms/${this.termId()}`)
          .then((response) => {
              this.term = response.data;
          })
          .finally(() => {this.loading = false;});
    },
    fetchTypes() {
      axios.get(`/client/types`)
          .then((response) => {
              this.types = response.data;
          });
    },
    getType(typeId) {
      return this.types.find((type) => type.id === typeId);
    },
    fullTermTime() {
        return `${dayName(this.term.date)}, ${formatDate(this.term.date)}`;
    }
  },
  created() {
    this.fetchTypes();
    this.fetchTerm();
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
