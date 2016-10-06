var $submitReport = $('#submit-report');
var $patientName = $('#patient-name');
var $patientId = $('#patient-id');
var $patientDOB = $('#patient-dob');
var $patientAge = $('#patient-age');
var $patientSex = $('#patient-sex');
var $studyMod = $('#study-mod');
var $studyPart = $('#study-part');
var $studyDate = $('#study-datetime');
var $reportDate = $('#report-date');
var $doctorName = $('#doctor-name');

$patientName.on('input', validateInputs);
$reportDate.on('input', validateInputs);
$doctorName.on('input', validateInputs);

function initForm() {
  var dob = convertStringDateToDate($patientDOB.val());
  $patientDOB.val(to_persian_date(dob));

  var studyTime = convertStringDateToDate($studyDate.val());
  var age = getAge(studyTime, dob);
  $patientAge.val(age.age + ' ' + age.type);

  var sex = getSex($patientSex.val());
  $patientSex.val(sex);

  var mod = $studyMod.val().substr(0, 2);
  $studyMod.val(mod);

  var part = $studyPart.val().split('\\').filter(function(data) {
    if (data === '')
      return false;
    return true;
  }).join('/');
  $studyPart.val(part);

  $studyDate.val(to_persian_date(studyTime));

  var reportDate = $reportDate.val();
  var persianToday = to_persian_date(formatDate(new Date()));
  if (reportDate === '') {
    $reportDate.val(persianToday);
  }
}

function validateInputs() {
  function setInvalid(el) {
    el.addClass('invalid');
  }

  function setValid(el) {
    el.removeClass('invalid');
  }
  var name = $('#patient-name').val();
  var reportDate = $reportDate.val();
  var doctorName = $doctorName.val();
  var invalidInputs= [];
  // console.log(name);

  if (name === '' || !isPersian(name)) {
    setInvalid($patientName.parent());
    invalidInputs.push('name');
  } else {
    setValid($patientName.parent());
    invalidInputs = removeFromArray(invalidInputs, 'name');
  }

  if (reportDate === '' || !isValidDate(reportDate)) {
    setInvalid($reportDate.parent());
    invalidInputs.push('reportDate');
  } else {
    setValid($reportDate.parent());
    invalidInputs = removeFromArray(invalidInputs, 'reportDate');
  }

  if (doctorName === '') {
    setInvalid($doctorName.parent());
    invalidInputs.push('DrName');
  } else {
    setValid($doctorName.parent());
    invalidInputs = removeFromArray(invalidInputs, 'DrName');
  }

  console.log(invalidInputs);
  if (invalidInputs.length > 0) {
    $submitReport.addClass('disabled');
    $submitReport.attr('disabled');
  } else {
    $submitReport.removeClass('disabled');
    $submitReport.removeAttr('disabled');
  }

}
