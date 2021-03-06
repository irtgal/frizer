import axios from './axios.js';


export function dayName(date) {
    var days = ['Ned', 'Pon', 'Tor', 'Sre', 'Čet', 'Pet', 'Sob'];
    var dateObj = new Date(date);
    return days[dateObj.getDay()];
  }

  export function formatDate(date) {
      var dateObj = new Date(date);
      return `${dateObj.getDate()}.${dateObj.getMonth()+1}`;
  }

  export function prepareAdminToken() {
    const token = localStorage.getItem("token");
    if (!token) {
      return;
    }
    axios.interceptors.request.use((request) => {
        request.headers = {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json',
        };
        return request;
      });
  }

  export function clearAdminToken() {
    axios.interceptors.request.handlers = [];
  }

