
export function dayName(date) {
    var days = ['Ned', 'Pon', 'Tor', 'Sre', 'Čet', 'Pet', 'Sob'];
    var dateObj = new Date(date);
    return days[dateObj.getDay()];
  }

  export function formatDate(date) {
      var dateObj = new Date(date);
      return `${dateObj.getDate()}.${dateObj.getMonth()+1}`;
  }