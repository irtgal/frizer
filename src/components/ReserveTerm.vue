<template>
<div class="shade">
<div class="modal fade show d-block" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Termin</h5>
        <span class="close-btn" @click="cancel"><i class="bi bi-x-lg"></i></span>
      </div>
      <div class="modal-body my-2">
        <div class="form-group">
            <label >Čas termina</label>
            <h3>{{fullTermTime()}} ob {{term.time}}</h3>
        </div>

        <template v-if="admin && term.reserved">
            <div class="form-group">
                <label>Rezerviral</label>
                <h3>{{term.name }}</h3>
            </div>
            <div class="form-group">
                <label >Storitev</label>
                <h3 v-if="types.length > 0">{{getType(term.type).name}}</h3>
            </div>
            <div class="form-group">
                <label >Kontakt</label>
                <h3>{{term.contact || '/'}} </h3>
            </div>
        </template>

        <template v-else>
            <div class="form-group mt-3">
                <label >Ime</label>
                <input type="text" class="form-control" v-model="name" />
            </div>
            <div class="form-group mt-3">
              <label>Storitev</label>
              <select class="form-control" v-model="typeId">
                <option v-for="type in types" v-bind:value="type.id" :key="type.id">{{type.name}} - {{type.price}}€</option>
              </select>
            </div>
            <div class="form-group mt-3">
                <label >Kontakt</label>
                <input type="text" class="form-control" v-model="contact" />
            </div>
            <p v-if="error" class="text-danger my-1 text-center">{{error}}</p>

        </template>

      </div>
      <div class="modal-footer justify-content-between">

        <template v-if="admin">
          <button  @click="remove" type="button" class="btn btn-danger"  data-dismiss="modal">Odstrani</button>
          <button v-if="term.reserved" @click="clearTerm" type="button" class="btn btn-secondary" data-dismiss="modal">Počisti rezervacijo</button>
          <button @click="save" type="button" class="btn btn-dark">Shrani</button>
        </template>

        <template v-else>
          <button @click="save" type="button" class="btn btn-dark btn-lg w-100">Rezerviraj</button>          
        </template>

      </div>
    </div>
  </div>
</div>
</div>
</template>

<script>

import {backendUrl} from '../config.js';
import {dayName, formatDate} from '../helpers/functions.js';

export default {
  name: 'ReserveTerm',
  props: {
    term: Object,
    types: Array,
    admin: Boolean,
  },
  data: function () {
    return {
        name: '',
        contact: '',
        typeId: 0,
        error: '',
    }
  },
  methods: {
      cancel() {
          this.$emit('cancel');
      },
      save() {
        if (this.term.reserved) {
          this.cancel();
          return;
        }
        if (!this.name.trim() || !this.typeId) {
          this.error = 'Ime in tip storitve sta obvezna';
          return;
        }
        this.axios.patch(`${backendUrl}/client/terms/${this.term.id}`, {
          'reserved': true,
          'name': this.name,
          'contact': this.contact,
          'type': this.typeId,
        })
          .then((response) => {
            if (response.data.error) {
              this.error = response.data.error;
              this.$emit('saved');
              return;
            }
            if (this.admin) {
              this.$emit('saved');
              this.cancel();
              return;
            }
            window.location.hash = `/potrditev`;
          })

      },
      clearTerm() {
        this.axios.patch(`${backendUrl}/client/terms/${this.term.id}`, {
          'reserved': false,
        })
        .then(() => {
          this.$emit('saved');
          this.cancel();
        })
      },
      remove() {
          this.axios.delete(`${backendUrl}/admin/terms/${this.term.id}`)
            .then(() => {
                this.$emit('saved');
                this.cancel();
            })
      },
      getType(typeId) {        
        return this.types.find((type) => type.id = typeId);
      },
      fullTermTime() {
        return `${dayName(this.term.date)}, ${formatDate(this.term.date)}`;
      }
  }
}
</script>

<style scoped>
</style>
