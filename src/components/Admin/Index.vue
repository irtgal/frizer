<template>
  <div class="admin">

      <div class="dates container-fluid">
        <div v-for="date in orderedDates" :key="date" class="date" :class="{'selected': date === selectedDate}" @click="selectDate(date)">
          <span class="day-name">{{dayName(date)}}</span>
          <span class="day-date">{{formatDate(date)}}</span>
          <span class="day-status not-available" v-if="hasTerms(date)">Prosto</span>
          <span class="day-status available" v-else>Bl Bula</span>
        </div>
      </div>

      <div class="terms container-fluid">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Čas</th>
              <th>Rezerviral</th>
              <th>Kontakt</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="term in timetable[selectedDate]" :key="term.time" class="term" :class="{'reserved': term.reserved}">
              <td class="term-time">{{term.time}}</td>
              <template v-if="term.reserved">
                <td v-if="term.reserved">{{term.name}}</td>
                <td v-if="term.reserved">{{term.contact}}</td>
              </template>
              <template v-else>
                <td></td>
                <td></td>
              </template>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="container-fluid d-flex justify-content-center mt-5">
        <p>Dela</p><i class="bi bi-clipboard"></i>
      </div>


  </div>
</template>

<script>

import {backendUrl} from '../../config.js';

export default {
  name: 'AdminIndex',
  data: function () {
    return {
      timetable: [],
      allTimes: [],
      selectedDate: null,
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
        this.axios.get(`${backendUrl}/admin/terms`)
            .then((response) => {
                this.timetable = response.data;
                // select first available date
                if (!this.selectedDate) {
                  this.selectedDate = this.orderedDates[0];
                }
            });
      },
      getTermsForTime(time) {
        const terms = [];
        for (const date of this.orderedDates) {
          const termAtTime = this.timetable[date].find((term) => term.time == time) || null;
          terms.push(termAtTime);
        }
        return terms;
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
      selectDate(date) {
        this.selectedDate = date;
      },
      hasTerms(date) {
        return this.timetable[date].length !== 0;
      },
      dayName(date) {
        var days = ['Ned', 'Pon', 'Tor', 'Sre', 'Čet', 'Pet', 'Sob'];
        var dateObj = new Date(date);
        return days[dateObj.getDay()];
      },
      formatDate(date) {
          var dateObj = new Date(date);
          return `${dateObj.getDate()}.${dateObj.getMonth()}`;
      },
  },
  created() {
      this.fetchTimetable();
  },
  mounted() {
      this.getAllTimes();
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


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
  background: rgba(220, 53, 69, 0.8);
}

.term-time {
  font-size: 1.1em;
  font-weight: bold;
}

/* NAVIGATION */
.dates {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-left: 5vw;
  padding-right: 5vw;
}

.date {
  flex: 1;
  display: grid;
  align-content: center;
  justify-content: center;
  background: rgba(210,210,210, 0.5);
  border-right: 2px rgb(210,210,210) solid;
  padding: 10px;
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
  color: rgb(98,107,115);
}
.selected .day-date {
  color: rgb(200,200,200) !important;
}
.day-status {
  font-size: 0.8em;
  font-weight: 500;
}
.selected .day-status {
  color: rgba(220,220,220, 0.9);
}



</style>
