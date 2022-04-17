<template>

  <!-- spinner -->
  <div v-if="firstLoad" class="spinner-container">
    <div class="spinner-border" role="status">
      <span class="sr-only"></span>
    </div>
  </div>

  <div v-else class="admin">

    <template v-if="!loading && firstAvailableDate">

      <div class="text-center">
        <a class="text-muted" role="button" @click="reload()" style="font-size: 12px;">
          Dans smo {{ formatDate(dateNow()) }}
        </a>
      </div>
      <div class="dates container-fluid mt-4">
        
        <!-- right icon -->
        <i v-if="firstAvailableDate < orderedDates[0]" class="bi bi-caret-left-fill left" @click="navigate(-loadDaysNumber)"></i>
        <i v-else class="bi bi-caret-left-fill left" style="visibility: hidden;"></i>
       
        <!-- dates -->
        <div v-for="date in orderedDates" :key="date" class="date" :class="{'selected': date === selectedDate, 'no-terms': !hasTerms(date)}" @click="selectDate(date)">
          <span class="day-name">{{dayName(date)}}</span>
          <span class="day-date">{{formatDate(date)}}</span>
          <span class="day-status" v-if="hasTerms(date)">Prosto</span>
          <span class="day-status" v-else>Bl Bula</span>
        </div>

        <!-- left icon -->
        <i v-if="lastAvailableDate > orderedDates[orderedDates.length -1]" class="bi bi-caret-right-fill right" @click="navigate(loadDaysNumber)"></i>
        <i v-else class="bi bi-caret-right-fill left" style="visibility: hidden;"></i>

      </div>

      <h5 class="text-center mt-3">{{dayName(this.selectedDate)}} {{formatDate(this.selectedDate)}}</h5>

      <div class="terms container-fluid">
        <table class="table table-hover" v-if="timetable[selectedDate] && timetable[selectedDate].length != 0">
          <thead>
            <tr>
              <th>Čas</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="term in timetable[selectedDate]" :key="term.time" class="term" :class="{'reserved': term.reserved}"  @click="selectTerm(term)">
              <td class="term-time">{{term.time}}</td>
            </tr>
          </tbody>
        </table>
        <template v-else>
        <h3 class="text-center mt-5">Ni terminov</h3>
        <i class="bi bi-emoji-frown text-center" style="font-size: 2em;"></i>
        </template>

      </div>

    </template>

    <div v-else-if="!loading" class="no-available-terms">
        <i class="bi bi-emoji-frown" style="font-size: 3em;"></i>     
        <h3 class="mt-2">Trenutno ni na voljo nobenih terminov</h3> 
    </div>

  </div>

  <reserve-term v-if="selectedTerm" :admin="false"
   @cancel="selectTerm(null)" :term="selectedTerm" :types="types" @saved="fetchTimetable" />
  
</template>

<script>

import {backendUrl} from '../../config.js';
import {dayName, formatDate} from '../../helpers/functions.js';
import State from '../../helpers/State.js';

export default {
  name: 'AdminIndex',
  data: function () {
    return {
      timetable: [],
      startDate: null,
      firstAvailableDate: null,
      lastAvailableDate: null,
      selectedDate: null,
      types: [],

      loadDaysNumber: 3,

      loading: true,
      firstLoad: true,

      selectedTerm: null,
    }
  },
  props: {
    msg: String
  },
  computed: {
    orderedDates() {
      if (!this.timetable) {
        return [];
      }
      return Object.keys(this.timetable).sort();
    }
  },
  methods: {
      fetchTimetable() {
        this.loading = true;
        this.axios.get(`${backendUrl}/client/terms`, {params: {"start_date": this.startDate, "load_days": this.loadDaysNumber}})
            .then((response) => {
                this.timetable = response.data.timetable;
                this.firstAvailableDate = response.data["first_available_date"];
                this.lastAvailableDate = response.data["last_available_date"];
                if (!this.startDate) {
                  this.startDate = this.firstAvailableDate;
                }
                // select first available date
                if (!this.selectedDate || !this.orderedDates.includes(this.selectedDate)) {
                  this.selectedDate = this.orderedDates[0];
                }
            })
            .finally(() => {
              this.loading = false;
              this.firstLoad = false;
            });
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
      selectTerm(term) {
        this.selectedTerm = term;
        State.setTerm(term);
      },
      selectDate(date) {
        this.selectedDate = date;
      },

      hasTerms(date) {
        return this.timetable[date] && this.timetable[date].length !== 0;
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

.no-terms * {
  opacity: 0.7;
}

.no-available-terms {
  display: grid;
  text-align: center;
  align-items: center;
  align-self: center;
  margin: 0 10vw;
}





</style>
