import Axios from './axios.js';


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
    Axios.interceptors.request.use((request) => {
        request.headers = {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json',
        };
        return request;
      });

  }

