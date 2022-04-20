<template>
  <div class="admin">

    <template v-if="!loading">
      <div class="text-center mb-3">
        <a class="text-muted" role="button" @click="reload()" style="font-size: 12px;">
          Dans smo {{ formatDate(dateNow()) }}
        </a>
      </div>

      <div class="dates container-fluid">
        <i class="bi bi-caret-left-fill left" @click="navigate(-loadDaysNumber)"></i>
        <div v-for="date in orderedDates" :key="date" class="date" :class="{'selected': date === selectedDate, 'no-terms': !hasTerms(date)}" @click="selectDate(date); togglePopup('showTerm', true)">
          <span class="day-name">{{dayName(date)}}</span>
          <span class="day-date">{{formatDate(date)}}</span>
          <span class="day-status" v-if="areTermsFull(date)">Polno</span>
          <span class="day-status" v-else-if="hasTerms(date)">Prosto</span>
          <span class="day-status" v-else>Bl Bula</span>
        </div>
        <i class="bi bi-caret-right-fill right" @click="navigate(loadDaysNumber)"></i>
      </div>

      <h5 class="text-center mt-3">{{dayName(this.selectedDate)}} {{formatDate(this.selectedDate)}}</h5>

      <div class="options" v-if="checkedTermIds.length > 0">
        <button v-if="!deleteLoading" type="button" class="btn btn-danger" @click="deleteChecked()"><i class="bi bi-trash trash m-1">Odstrani</i></button>
        <button v-else type="button" class="btn btn-danger">
          <div class="spinner-border" role="status" style="width: 1.2rem; height: 1.2rem">
            <span class="sr-only"></span>
          </div>
        </button>
      </div>

      <div class="terms container-fluid mt-3">
        <table class="table table-hover" v-if="timetable[selectedDate] && timetable[selectedDate].length != 0">
          <thead>
            <tr>
              <th>
                <input class="form-check-input" type="checkbox" :checked="checkedTermIds.length == timetable[selectedDate].length" @click="checkAll()">
              </th>
              <th>Čas</th>
              <th>Rezerviral</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="term in timetable[selectedDate]" :key="term.time" class="term" :class="{'reserved': term.reserved}">
              <td> 
                <input class="form-check-input" type="checkbox" :value="term.id" v-model="checkedTermIds">
              </td>
              <td class="term-time" @click="selectTerm(term)">{{term.time}}</td>
              <template v-if="term.reserved">
                <td v-if="term.reserved"  @click="selectTerm(term)">{{term.name}}</td>
              </template>
              <template v-else>
                <td @click="selectTerm(term)"></td>
              </template>
            </tr>
          </tbody>
        </table>

        <h3 v-else class="text-center">Ni terminov</h3>

      </div>

      <div class="container-fluid d-flex justify-content-center mt-3">
        <i class="bi bi-plus-circle-fill" id="add-term" @click="togglePopup('addTerm', true)"></i>
      </div>
    </template>

  </div>

  <add-term v-if="visible.addTerm" @cancel="togglePopup('addTerm', false)" :date="selectedDate" @saved="fetchTimetable" />
  <reserve-term v-if="selectedTerm" :admin="true" :term="selectedTerm" :types="types"
    @cancel="selectTerm(null)" @saved="fetchTimetable" />
  
</template>

<script>

import {backendUrl} from '../../config.js';
import {dayName, formatDate} from '../../helpers/functions.js';

export default {
  name: 'AdminIndex',
  data: function () {
    return {
      timetable: [],
      startDate: this.getStartDate(),
      selectedDate: null,
      types: [],

      loadDaysNumber: 4,

      loading: true,
      deleteLoading: false,

      checkedTermIds: [],

      selectedTerm: null,
      visible: {
        addTerm: false,
        showTerm: false,
        reserveTerm: false,
      },
    }
  },
  props: {
    msg: String
  },
  computed: {
    orderedDates() {
      return Object.keys(this.timetable).sort();
    }
  },
  methods: {
      fetchTimetable() {
        this.loading = true;
        this.axios.get(`${backendUrl}/admin/terms`, {params: {"start_date": this.startDate, "load_days": this.loadDaysNumber}})
            .then((response) => {
                this.timetable = response.data;
                
                // select first available date
                if (!this.selectedDate || !this.orderedDates.includes(this.selectedDate)) {
                  this.selectedDate = this.orderedDates[0];
                }
                this.loading = false;
            })
      },
      fetchTypes() {
        this.axios.get(`${backendUrl}/client/types`)
            .then((response) => {
                this.types = response.data;
            });
      },

      navigate(numberOfDays) {
        const date = new Date(this.startDate);
        date.setDate(date.getDate() + numberOfDays);
        this.startDate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
        this.fetchTimetable();
      },

      checkAll() {
        const allIds = this.timetable[this.selectedDate].map((term) => term.id);
        if (allIds.every((id) => this.checkedTermIds.includes(id))) {
          this.checkedTermIds = [];
        } else {
          this.checkedTermIds = allIds;
        }
      },

      deleteChecked() {
        if (this.checkedTermIds.length === 0) {
          return;
        }
        this.deleteLoading = true;
        this.axios.post(`${backendUrl}/admin/terms/delete`, {
          'ids': this.checkedTermIds,
        })
        .then(() => {
          this.fetchTimetable();
          this.checkedTermIds = [];
          });
      },

      selectTerm(term) {
        this.selectedTerm = term;
      },
      togglePopup(name, visible) {
        this.visible[name] = visible;
      },

      selectDate(date) {
        this.selectedDate = date;
      },
      hasTerms(date) {
        return this.timetable[date] && this.timetable[date].length !== 0;
      },
      areTermsFull(date) {
        if (!this.hasTerms(date)) {
          return false;
        }
        return this.timetable[date].every((term) => term.reserved);
      },
      getStartDate() {
        return this.dateNow();
      },
      dateNow() {
        let date = new Date();
        return `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
      },
      dayName(date) {
        return dayName(date);
      },
      formatDate(date) {
        return formatDate(date);
      },
      reload() {
        window.location.reload();
      }
  },
  created() {
      this.fetchTypes();
      this.fetchTimetable();
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

#add-term {
  font-size: 3em;
  cursor: pointer;
}
#add-term:hover {
  font-size: 3em;
  color: rgb(100,100,100);
}

.options {
  width: 100%;
  display: flex;
  align-content: center;
  justify-content: space-evenly;
}



</style>
