var hostname = window.location.hostname;
var baseURL = window.location.pathname.split('/')[1];

function getSeriesData() {
  var studyId = $(this).attr('data-study-id');
  var url = 'src/components/php/api/service.php?action=getallseries&study_pk=' + studyId;
  $.getJSON(url, printSeries);
}

function getInstanceData(seriePk, cb) {
  var url = 'src/components/php/api/service.php?action=getallinstances&serie_pk=' + seriePk;
  $.getJSON(url, cb);
}

function getInstanceDataPromise(seriePk) {
  return new Promise(function (resolve, reject) {
    var url = 'src/components/php/api/service.php?action=getallinstances&serie_pk=' + seriePk;
    $.getJSON(url, resolve);
  });
}

function generateRequestURL(studyUID, serieUID, instanceUID, frame) {
  frame = (typeof frame === 'undefined') ? 0 : frame;

  var url = 'http://' + hostname + ':8080/wado?requestType=WADO' +
    '&studyUID=' + studyUID +
    '&seriesUID=' + serieUID +
    '&objectUID=' + instanceUID +
    '&frameNumber=' + frame;

  return url;
}

function searchStudies(patId, patName, modality, fromDate, toDate, institution, pageIndex, pageSize) {

  patId = (typeof patId === 'undefined') ? '' : patId;
  patName = (typeof patName === 'undefined') ? '' : patName;
  modality = (typeof modality === 'undefined') ? '' : modality;
  fromDate = (typeof fromDate === 'undefined') ? '' : fromDate;
  toDate = (typeof toDate === 'undefined') ? '' : toDate;
  institution = (typeof institution === 'undefined') ? '' : institution;
  pageIndex = (typeof pageIndex === 'undefined') ? 0 : pageIndex;
  pageSize = (typeof pageSize === 'undefined') ? 10 : pageSize;

  var url = 'src/components/php/api/service.php?action=searchstudies' +
    '&id=' + patId +
    '&name=' + patName +
    '&modality=' + modality +
    '&from=' + fromDate +
    '&to=' + toDate +
    '&institution=' + institution +
    '&page_index=' + pageIndex +
    '&page_size=' + pageSize;

  console.log(url);

  $.getJSON(url, printStudies);
}

function searchStudyByDate(fromDate, toDate) {
  searchStudies(undefined, undefined, undefined, fromDate, toDate, undefined);
}

function generateWeasisUrl(type, id) {

  var url = 'http://' + hostname + ':8080/weasis-pacs-connector/viewer?';
  switch (type) {
    case 'patient':
      url += 'patientID=' + id;
      break;
    case 'serie':
      url += 'seriesUID=' + id;
      break;
    default:
      url = '#';
  }
  return url;
}

function updateInsts() {
  var url = 'src/components/php/api/service.php?action=getalldynamicinsts';
  $.getJSON(url, console.log);
}

function updateMods() {
  var url = 'src/components/php/api/service.php?action=getalldynamicmods';
  $.getJSON(url, console.log);

}
