var date_regex = /^\d{4}\/(0?[1-9]|1[012])\/(0?[1-9]|[12][0-9]|3[01])$/;

function fix_name(name) {
  if(name === null || typeof(name) === 'undefined') return "N/A";
  name = name.replace(/[\^-]+/g, ' ');
  var output = "";
  name.split(' ').forEach(function(string) {
    output += string.charAt(0).toUpperCase() + string.slice(1).toLowerCase() + ' ';
  });
  return output.trim();
}

function to_persian_date(datetime) {
  var date = datetime.substr(0, 10);
  date = new Date(date);
  date = persianDate(date);
  var year = date.pDate.year;
  var month = date.pDate.month;
  var day = date.pDate.date;
  var persian_date = year + '/' + month + '/' + day;
  // console.log(persian_date);
  return persian_date;
}

function to_gregorian_date(datetime) {
  var pYear = parseInt(datetime.substr(0, 4));
  var pMonth = parseInt(datetime.substr(5, 2));
  var pDay = parseInt(datetime.substr(8, 2));

  var gDate = new persianDate([pYear, pMonth, pDay]).gDate;
  return format_date(gDate);
}

function format_date(date) {
  var dd = date.getDate();
  var mm = date.getMonth() + 1; //January is 0!

  var yyyy = date.getFullYear();
  if (dd < 10)
    dd = '0' + dd;
  if (mm < 10)
    mm = '0' + mm;
  return yyyy + '/' + mm + '/' + dd;
}

function get_date(dateTime) {
  return dateTime.toJSON().slice(0, 10);
}
function get_time(dateTime) {
  return dateTime.slice(10, 16);
}
function is_valid_date(date) {
  return date_regex.test(date);
}

function get_sex(sex) {
  return ( (sex !== "M" && sex !== "F") ? "N/A" : (sex == "M") ? "Male" : "Female" );
}

function get_age(date) {
  date = date || "N/A";
  var currYear = new Date().getFullYear();
  var birthYear = +date.substr(0,4);
  return ( date !== "NAN")  ? +currYear - birthYear  : 'N/A';
}

var delay = (function() {
  var timer = 0;
  return function(callback, ms) {
    clearTimeout(timer);
    timer = setTimeout(callback, ms);
  };
})();
