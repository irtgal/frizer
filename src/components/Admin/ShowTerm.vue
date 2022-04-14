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
            <label for="exampleInputEmail1">Čas termina</label>
            <h3>{{fullTermTime()}} ob {{term.time}}</h3>
        </div>

        <template v-if="term.reserved">
            <div class="form-group">
                <label>Rezerviral</label>
                <h3>{{term.name }}</h3>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Kontakt</label>
                <h3>{{term.contact}} </h3>
            </div>
        </template>

      </div>
      <div class="modal-footer justify-content-between">
        <button  @click="remove" type="button" class="btn btn-danger"  data-dismiss="modal">Odstrani</button>
        <button  @click="clear" type="button" class="btn btn-secondary" data-dismiss="modal">Počisti rezervacijo</button>
        <button @click="cancel" type="button" class="btn btn-dark">Zapri</button>
      </div>
    </div>
  </div>
</div>
</div>
</template>

<script>

import {backendUrl} from '../../config.js';
import {dayName, formatDate} from '../../helpers/functions.js';

export default {
  name: 'ShowTerm',
  props: {
    term: Object,
  },
  data: function () {
    return {
        start: null,
        end: null,
        error: '',
    }
  },
  methods: {
      cancel() {
          this.$emit('cancel');
      },
      save() {
          console.log('Save', backendUrl);
      },
      remove() {
          this.axios.delete(`${backendUrl}/admin/terms/${this.term.id}`)
            .then(() => {
                this.$emit('saved');
                this.cancel();
            })
      },
      fullTermTime() {
          console.log(dayName(this.term.date));
          return `${dayName(this.term.date)}, ${formatDate(this.term.date)}`;
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
