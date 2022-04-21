
<template>

  <router-view/>

</template>

<script>

export default {
  data() {
    return {
    }
  },
  computed: {
  },
  created() {
  },
  mounted() {

  }
}
</script>
<style>
#app {
  margin-top: 20px;
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
  color: rgb(78,87,95);
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


/* MODALS */
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
    padding: 5px 10px 5px 15px;
    cursor: pointer;
    font-size: 1.2em;
}


/* UTILS */
.spinner-container {
  display: grid;
  justify-items: center;
  align-content: center;
  align-items: center;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

td {
  vertical-align: middle;
}

.flex-centered {
  display: flex !important;
  justify-content: center !important;
  align-content: center !important;
}

</style>