<template>
  <div class="admin">

    <template v-if="!loading">
      <div class="text-center mb-3">
        <a class="text-muted" role="button" @click="reload()" style="font-size: 12px;">
          Dans smo {{ formatDate(dateNow()) }}
        </a>
      </div>

      <div class="dates container-fluid">
        <i class="bi bi-caret-left-fill left" @click="goLeft()"></i>
        <div v-for="date in orderedDates" :key="date" class="date" :class="{'selected': date === selectedDate, 'no-terms': !hasTerms(date)}" @click="selectDate(date)">
          <span class="day-name">{{dayName(date)}}</span>
          <span class="day-date">{{formatDate(date)}}</span>
          <span class="day-status" v-if="hasTerms(date)">Prosto</span>
          <span class="day-status" v-else>Bl Bula</span>
        </div>
        <i class="bi bi-caret-right-fill right" @click="goRight()"></i>
      </div>

      <h5 class="text-center mt-3">{{dayName(this.selectedDate)}} {{formatDate(this.selectedDate)}}</h5>

      <div class="terms container-fluid">
        <table class="table table-hover" v-if="timetable[selectedDate] && timetable[selectedDate].length != 0">
          <thead>
            <tr>
              <th>Čas</th>
              <th>Rezerviral</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="term in timetable[selectedDate]" :key="term.time" class="term" :class="{'reserved': term.reserved}" @click="selectTerm(term)">
              <td class="term-time">{{term.time}}</td>
              <template v-if="term.reserved">
                <td v-if="term.reserved">{{term.name}}</td>
              </template>
              <template v-else>
                <td></td>
              </template>
            </tr>
          </tbody>
        </table>
        <h3 v-else class="text-center">Ni terminov</h3>
      </div>

      <div class="container-fluid d-flex justify-content-center mt-3">
        <i class="bi bi-plus-circle-fill" id="add-term" @click="toggleAddTerm(true)"></i>
      </div>
    </template>

  </div>

  <add-term v-if="addTermPopup" @cancel="toggleAddTerm(false)" :date="selectedDate" @saved="fetchTimetable" />
  <show-term v-if="selectedTerm" @cancel="selectTerm(null)" :term="selectedTerm" @saved="fetchTimetable" />
  
</template>

<script>

import {backendUrl} from '../../config.js';
import {dayName, formatDate} from '../../helpers/functions.js';

export default {
  name: 'AdminIndex',
  data: function () {
    return {
      timetable: [],
      allTimes: [],
      startDate: this.getStartDate(),
      loadDaysNumber: 4,
      selectedDate: null,

      loading: true,

      addTermPopup: false,
      showTermPopup: false,
      selectedTerm: null,
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
                console.log('Timetable: ',this.timetable);
                // select first available date
                if (!this.selectedDate || !this.orderedDates.includes(this.selectedDate)) {
                  this.selectedDate = this.orderedDates[0];
                }
                this.loading = false;
            });
      },

      goRight() {
        const date = new Date(this.startDate);
        date.setDate(date.getDate() + this.loadDaysNumber);  
        this.startDate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
        console.log(this.startDate);
        this.fetchTimetable();
      },
      goLeft() {
        const date = new Date(this.startDate);
        date.setDate(date.getDate() - this.loadDaysNumber);  
        this.startDate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
        console.log(this.startDate);
        this.fetchTimetable();
      },


      toggleAddTerm(show) {
        this.addTermPopup = show;
      },
      selectTerm(term) {
        this.selectedTerm = term;
      },


      selectDate(date) {
        this.selectedDate = date;
      },
      hasTerms(date) {
        return this.timetable[date] && this.timetable[date].length !== 0;
      },
      getStartDate() {
        return this.dateNow();
      },
      dateNow() {
        let date = new Date();
        return `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
      },

      getAllTimes() {
          let time =  '6:00';
          let i =0;
          while (time.split(':')[0] != '24' && i < 100) {
              this.allTimes.push(time);
              let newMinutes = "00";
              if (time.split(':')[1] == "00") {
                  newMinutes = "30";
              }
              let newHours = parseInt(time.split(':')[0]);
              newHours = (newMinutes == "00") ?  newHours + 1 : newHours;
              newHours = (newHours > 9) ? newHours : "0" + newHours;
              time = `${newHours}:${newMinutes}`;
              i ++;
          }
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
      this.fetchTimetable();
  },
  mounted() {
      this.getAllTimes();
      console.log(this.getStartDate());
  }
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


/* TERMS */
.terms {
  display: grid;
  padding-left: 5vw;
  padding-right: 5vw;
  margin-top: 2em;
}

.terms table {
  text-align: center;
}

.term:hover {
  cursor: pointer;
}

.term.reserved {
  background: rgba(220, 53, 69, 0.6);
}

.term-time {
  font-size: 1.1em;
  font-weight: bold;
}

/* NAVIGATION */

.left, .right {
  font-size: 3em;
  cursor: pointer;
}
.left:hover, .right:hover {
  color: rgb(100,100,100);
}

.dates {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-left: 20px;
  padding-right: 20px;
  max-width: 94vw;
}

.date {
  flex: 1;
  display: grid;
  align-content: center;
  justify-content: center;
  background: rgba(210,210,210, 0.5);
  border-right: 2px rgb(190,190,190) solid;
  padding: 10px;
  white-space: nowrap;
}
.date.no-terms {
}
.date.selected {
  background: #000;
}
.date:hover {
  cursor: pointer;
}
.date:last-of-type {
  border-right: none;
}
.date span {
  text-align: center;
}

.day-name {
  font-size: 1em;
}
.selected .day-name {
  color: white;
}
.selected .day-name {
  color: rgba(220,220,220, 0.9);
}
.day-date {
  font-size: 1.5em;
  font-weight: bold;
  color: rgb(88,97,105);
}
.selected .day-date {
  color: rgb(230,230,230) !important;
}
.day-status {
  font-size: 0.8em;
  font-weight: 500;
}
.selected .day-status {
  color: rgba(220,220,220, 0.9);
}



</style>
