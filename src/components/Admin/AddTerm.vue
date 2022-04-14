<template>
<div class="shade">
<div class="modal fade show d-block" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Dodaj termine</h5>
        <span class="close-btn" @click="cancel"><i class="bi bi-x-lg"></i></span>
      </div>
      <div class="modal-body my-2">
        <div class="form-group">
            <label for="exampleInputEmail1">Začetek izmene</label>
            <input type="time" v-model="start" class="form-control" id="start" step="1800">
        </div>
        <div class="form-group mt-3">
            <label for="exampleInputEmail1">Konec izmene</label>
            <input type="time" v-model="end" class="form-control" id="end" step="1800">
        </div>
        <p v-if="error" class="text-danger">{{error}}</p>
      </div>
      <div class="modal-footer">
        <button  @click="cancel" type="button" class="btn btn-light" data-dismiss="modal">Nehej</button>
        <button @click="save" type="button" class="btn btn-dark">Shrani</button>
      </div>
    </div>
  </div>
</div>
</div>
</template>

<script>

import {backendUrl} from '../../config.js';

export default {
  name: 'AddTerm',
  props: {
    date: String,
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
        console.log(this.start, typeof this.end);
        if (!this.start || !this.end) {
            this.error = "Manjkajo podatki"
            return;
        }
        let startMinutes = this.start.split(':')[1].trim();
        let endMinutes = this.start.split(':')[1].trim();
        console.log(startMinutes, endMinutes);
        if (startMinutes != '00' && startMinutes != '30') {
          console.log('Start ni: ', startMinutes);
          startMinutes = (parseInt(startMinutes) > 30) ? '00' : '30';
        }
        if (endMinutes != '00' && endMinutes != '30') {
          endMinutes = (parseInt(endMinutes) > 30) ? '00' : '30';
        }
        this.start = `${this.start.split(':')[0]}:${startMinutes}`;
        this.end = `${this.end.split(':')[0]}:${endMinutes}`;

        this.axios.post(`${backendUrl}/admin/terms`, {'start': this.start, 'end': this.end, 'date': this.date})
            .then((response) => {
                console.log('Response:', response);
                this.$emit('saved');
                this.cancel();
            });
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
