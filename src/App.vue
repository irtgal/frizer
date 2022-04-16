<script>
import AdminIndex from './components/Admin/Index.vue';
import ClientIndex from './components/Client/Index.vue';
import TermConfirmation from './components/Client/TermConfirmation.vue';

const routes = {
  
  '/admin': AdminIndex,
  '/': ClientIndex,
  '/potrditev': TermConfirmation,
}
export default {
  data() {
    return {
      currentPath: window.location.hash
    }
  },
  computed: {
    currentView() {
      return routes[this.currentPath.slice(1) || '/'] || ClientIndex
    }
  },
  mounted() {
    window.addEventListener('hashchange', () => {
      this.currentPath = window.location.hash
    })
  }
}
</script>


<template>
  <div class="app">
    <component :is="currentView" />
  </div>
</template>
<style>
.app {
  margin-top: 20px;
}
.shade {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgb(0,0,0,0.6);
    height: 100vh;
}
.close-btn {
    padding: 10px;
    cursor: pointer;
}


/* TERMS */
.terms {
  display: grid;
  margin-top: 2em;
  padding-left: 8vw !important;
  padding-right: 8vw !important;
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
  padding: 15px !important;
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
  width: 100%;
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

td {
  vertical-align: middle;
}

</style>