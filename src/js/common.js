var dateRegex = /^\d{4}\/(0?[1-9]|1[012])\/(0?[1-9]|[12][0-9]|3[01])$/;
var persianRegex = /^[\u0600-\u06FF\s]+$/;

function fix_name(name) {
  if (name === null || typeof(name) === 'undefined') return "N/A";
  name = name.replace(/[\^-]+/g, ' ');
  var output = "";
  name.split(' ').forEach(function(string) {
    output += string.charAt(0).toUpperCase() + string.slice(1).toLowerCase() + ' ';
  });
  return output.trim();
}

function isPersian(value) {
  return persianRegex.test(value);
}

function toReadableDate(MMDD, isPersian) {
  var backUp = MMDD = new Date(MMDD);
  MMDD.setHours(0, 0, 0, 0);
  var strDate = "";

  var today = new Date();
  today.setHours(0, 0, 0, 0);

  var yesterday = new Date();
  yesterday.setHours(0, 0, 0, 0);
  yesterday.setDate(yesterday.getDate() - 1);

  var tomorrow = new Date();
  tomorrow.setHours(0, 0, 0, 0);
  tomorrow.setDate(tomorrow.getDate() + 1);

  // console.log(MMDD.getTime(), today.getTime(), MMDD.getTime() == today.getTime());

  if (today.getTime() == MMDD.getTime()) {
    strDate = "Today";
  } else if (yesterday.getTime() == MMDD.getTime()) {
    strDate = "Yesterday";
  } else if (tomorrow.getTime() == MMDD.getTime()) {
    strDate = "Tomorrow";
  } else if (isPersian) {
    return to_persian_date(backUp);
  }

  return strDate;
}

function to_persian_date(datetime) {
  var date = datetime;
  if (typeof datetime.substr === 'function') {
    date = datetime.substr(0, 10);
  }
  date = new Date(date);
  date = persianDate(date);
  var year = date.pDate.year;
  var month = date.pDate.month;
  var day = date.pDate.date;
  var persian_date = year + '/' + month + '/' + day;
  persian_date = formatDate(persian_date);
  return persian_date;
}

function to_gregorian_date(datetime) {
  var pYear = parseInt(datetime.substr(0, 4));
  var pMonth = parseInt(datetime.substr(5, 2));
  var pDay = parseInt(datetime.substr(8, 2));
  var gDate = new persianDate([pYear, pMonth, pDay]).gDate;
  return formatDate(gDate);
}

function formatDate(date) {
  if (!date.getDate) {
    date = new Date(date);
  }
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

function isValidDate(date) {
  return dateRegex.test(date);
}

function getSex(sex, minify) {
  sex = sex || 'N/A';
  sex = sex.toLowerCase();
  if (minify)
    return (sex !== "m" && sex !== "f") ? "N" : sex.toUpperCase();
  return ((sex !== "m" && sex !== "f") ? "N/A" : (sex === "m") ? "Male" : "Female");
}

function convertStringDateToDate(date) {
  if (typeof date == 'undefined' || !date) {
    return;
  }
  if (date.indexOf('-') !== -1) {
    date = date.replace(/-/g, '/');
  }
  date = date.substr(0, 10);
  if (isValidDate(date))
    return new Date(date);

  var dateInfo = [
    date.substr(0, 4),
    date.substr(4, 2),
    date.substr(6, 2)
  ];

  var validDate = dateInfo.join('-');
  validDate = new Date(validDate);
  return validDate;
}

function getAge(date, fromDate) {
  if (!date || !fromDate) {
    return {
      age: 'N/A',
      type: ''
    };
  }
  // Year or Month or Day
  var type = "Year";
  var age = getYearDiffer(date, fromDate);
  if (age === 0) {
    type = "Month";
    age = getMonthDiffer(date, fromDate);
  }
  if (age === 0) {
    type = "Day";
    age = getDayDiffer(date, fromDate);
  }
  age = {
    age: age,
    type: type
  };
  // console.log(age);
  return (age.age !== "NAN") ? age : {
    age: 'N/A',
    type: 'N/A'
  };
}

function getYearDiffer(date, fromDate) {
  date = date || "N/A";
  fromDate = fromDate || new Date();
  var fromYear = fromDate.getFullYear();
  var dateYear = date.getFullYear();
  return dateYear - fromYear;
}

function getMonthDiffer(date, fromDate) {
  date = date || "N/A";
  fromDate = fromDate || new Date();

  var fromMonth = fromDate.getMonth();
  var dateMonth = date.getMonth();
  return dateMonth - fromMonth;
}

function getDayDiffer(date, fromDate) {
  date = date || "N/A";
  fromDate = fromDate || new Date();

  var fromDay = fromDate.getDate();
  var dateDay = date.getDate();
  return dateDay - fromDay;
}

function insertParam(key, value) {
  key = encodeURI(key);
  value = encodeURI(value);

  var kvp = document.location.search.substr(1).split('&');

  var i = kvp.length;
  var x;
  while (i--) {
    x = kvp[i].split('=');

    if (x[0] == key) {
      x[1] = value;
      kvp[i] = x.join('=');
      break;
    }
  }

  if (i < 0) {
    kvp[kvp.length] = [key, value].join('=');
  }

  //this will reload the page, it's likely better to store this until finished
  document.location.search = kvp.join('&');
}

function parseModality(modality) {
  return (modality === 'Modality' || modality === 'All') ? '' : modality.replace(/,\s/g, '\\\\');
}

function parseInstitution(institution) {
  return (institution === 'Institution' || institution === 'All') ? '' : institution;
}

var delay = (function() {
  var timer = 0;
  return function(callback, ms) {
    clearTimeout(timer);
    timer = setTimeout(callback, ms);
  };
})();

function hideMessageAfter(el, time) {
  setTimeout(function() {
    el.fadeOut();
  }, time);
}

function removeFromArray(array, item) {
  var index = array.indexOf(item);
  if (index > -1) {
      array.splice(index, 1);
  }
  return array;
}
