var hostname = window.location.hostname;
var baseURL = window.location.pathname.split('/')[1];
var ch_patId;
var ch_patName;
var ch_accession;
var ch_modality;
var ch_fromDate;
var ch_toDate;
var ch_institution;

function getSeriesData(studyId, cb) {
  if (typeof studyId === 'undefined') console.error('StudyId is not defiend');
  var url = 'src/components/php/api/service.php?action=getallseries&study_pk=' + studyId;
  $.getJSON(url, cb);
}

function getInstanceData(seriePk, cb) {
  if (typeof seriePk === 'undefined') console.error('Undefiend Series Pk');
  var url = 'src/components/php/api/service.php?action=getallinstances&serie_pk=' + seriePk;
  console.log(url);
  $.getJSON(url, cb);
}

function getInstanceDataPromise(seriePk) {
  return new Promise(function(resolve, reject) {
    var url = 'src/components/php/api/service.php?action=getallinstances&serie_pk=' + seriePk;
    $.getJSON(url, resolve);
  });
}

function WADO(studyUID, serieUID, instanceUID, frame) {
  frame = frame || 0;
  var url = 'http://' + hostname + ':8080/wado?requestType=WADO' +
    '&studyUID=' + studyUID +
    '&seriesUID=' + serieUID +
    '&objectUID=' + instanceUID +
    '&frameNumber=' + frame;

  $.ajax({
    url: url,
    Dattype: 'text/html',
    success: function(data) {
      console.log('HI');
      console.log(data);
    }
  });

}

function generateRequestURL(studyUID, serieUID, instanceUID, frame) {
  frame = frame || 0;

  var url = 'http://' + hostname + ':8080/wado?requestType=WADO' +
    '&studyUID=' + studyUID +
    '&seriesUID=' + serieUID +
    '&objectUID=' + instanceUID +
    '&frameNumber=' + frame;
  return url;
}

function loadStudyPage(pageIndex, pageSize) {
  $loading.css('display', 'flex');
  pageIndex = pageIndex - 1 || 0;
  pageSize = pageSize || defaultPageSize;

  if (pageIndex < 0)
    pageIndex = 0;
  if (pageSize < 1)
    pageSize = 1;

  var url = 'src/components/php/api/service.php?action=searchstudies' +
    '&id=' + ch_patId +
    '&name=' + ch_patName +
    '&accession=' + ch_accession +
    '&modality=' + ch_modality +
    '&from=' + ch_fromDate +
    '&to=' + ch_toDate +
    '&institution=' + ch_institution +
    '&page_index=' + pageIndex +
    '&page_size=' + pageSize;

  console.log(url);

  $.getJSON(url, printStudies);

}

function searchStudies(patId, patName, accession, modality, fromDate, toDate, institution, pageIndex, pageSize) {
  ch_patId = patId || '';
  ch_patName = patName || '';
  ch_accession = accession || '';
  ch_modality = modality || '';
  ch_fromDate = fromDate || '';
  ch_toDate = toDate || '';
  ch_institution = institution || '';
  pageIndex = pageIndex || 0;
  pageSize = pageSize || defaultPageSize;

  loadStudyPage(pageIndex, pageSize);

}

function searchStudyByDate(fromDate, toDate) {
  searchStudies(undefined, undefined, undefined, undefined, fromDate, toDate, undefined);
}

function generateWeasisUrl(type, id) {

  var url = 'http://' + hostname + ':8080/weasis-pacs-connector/viewer?';
  switch (type) {
    case 'patient':
      url += 'patientID=' + id;
      break;
    case 'study':
      url += 'studyUID=' + id;
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
