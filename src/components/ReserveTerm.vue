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
                <label >Email</label>
                <input type="email" class="form-control" v-model="contact" />
            </div>
            <p v-if="error" class="text-danger my-1 text-center">{{error}}</p>

        </template>

      </div>
      <div class="modal-footer justify-content-between">

        <template v-if="admin">
          <button  @click="remove" type="button" class="btn btn-danger"  data-dismiss="modal">Odstrani</button>
          <button v-if="term.reserved" @click="clearTerm" type="button" class="btn btn-secondary" data-dismiss="modal">Počisti rezervacijo</button>
          <button @click="saveAdmin" type="button" class="btn btn-dark">Shrani</button>
        </template>

        <template v-else>
          <button v-if="!sendingData" @click="saveClient" type="button" class="btn btn-dark btn-lg w-100">Rezerviraj</button>
          
          <button v-else type="button" class="btn btn-dark btn-lg w-100 flex-centered">
            <div class="spinner-border" role="status">
              <span class="sr-only"></span>
            </div>
          </button>

        </template>

      </div>
    </div>
  </div>
</div>
</div>
</template>

<script>

import {dayName, formatDate} from '../helpers/functions.js';
import State from '../helpers/State.js';
import axios from '../helpers/axios.js';

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
        sendingData: false,
    }
  },
  mounted() {
    if (!this.admin) {
      this.contact = localStorage.getItem('email') || "";
    }
  },
  methods: {
      cancel() {
          this.$emit('cancel');
      },
      saveClient() {
        this.error = '';
        if (!this.name.trim() || !this.typeId || !this.contact) {
          this.error = 'Manjkajo podatki';
          return;
        }
        if (!this.isValidEmail(this.contact)) {
          this.error = 'Vnesite pravilen email naslov';
          return;
        }
        this.sendingData = true;
        axios.patch(`/client/terms/${this.term.id}`, {
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
            localStorage.setItem('email', this.contact);
            State.setTerm(this.term);
            this.$router.push({name: 'confirmation'});
          });

      },
      saveAdmin() {
        if (this.term.reserved) {
          this.cancel();
          return;
        }
        this.error = '';
        if (!this.name.trim() || !this.typeId) {
          this.error = 'Izpolnite vsa polja';
          return;
        }
        if (this.contact && !this.isValidEmail(this.contact)) {
          this.error = 'Vnesite pravilen email naslov';
          return;
        }
        axios.patch(`/admin/terms/${this.term.id}`, {
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
            this.$emit('saved');
            this.cancel();
          })

      },
      clearTerm() {
        axios.patch(`/admin/terms/${this.term.id}`, {
          'reserved': false,
        })
        .then(() => {
          this.$emit('saved');
          this.cancel();
        })
      },
      remove() {
          axios.delete(`/admin/terms/${this.term.id}`)
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
      },
      isValidEmail(email){
        return String(email).toLowerCase()
          .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          );
      },

  }
}
</script>

<style scoped>
</style>
