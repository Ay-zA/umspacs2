var $thumb = $('#thumb-div');
var $modal = $('#myModal .modal-body');
var $modalHeader = $('#myModal .modal-title');
var $patient_table = $('#patient-table tbody');
var $seriesTable = $('#series-table tbody');
var $resultSection = $('#result-section');
var $seriesSectionHeader = $('#result-section .section-header h4');
var $paginationList = $('#study-pagination .pagination');

var $dataTable = false;
var selected_study_uid;

var series_data = {};
var instance_data = {};

var totalStudy = 0;
var defaultPageSize = 10;
var currentPageIndex = 1;

function patientRowClicked() {
  clearInstance();
  var rows = $('#patient-table tbody tr');
  rows.removeClass('active');
  $(this).addClass('active');
  selected_study_uid = $(this).attr('data-iuid');
}

function openWeasis(e) {
  var id = $(e.target).closest('tr').children('td[data-type="pat_id"]').text();
  var url = generateWeasisUrl('patient', id);
  window.open(url);
}

function openPanel(e) {
  var id = $(e.target).closest('tr').attr("data-study-id");
  window.open('panel.php?pat_id=' + id);
}

function searchByInput() {
  hideResultSection(false);
  resetStudyTable();
  currentPageIndex = 1;
  var id = $('#searchById').val();
  var name = $('#searchByName').val();
  var institution = $('#searchByInstitution').parent().children('button').children('span').text();
  var from_date = $('#searchByFrom').val();
  var to_date = $('#searchByTo').val();
  var modality = $('#searchByModality').parent().children('button').children('span').text();

  modality = parseModality(modality);
  institution = parseInstitution(institution);
  from_date = isValidDate(from_date) ? to_gregorian_date(from_date) : "";
  to_date = isValidDate(to_date) ? to_gregorian_date(to_date) : "";

  searchStudies(id, name, modality, from_date, to_date, institution);
}

function loadAll(e) {
  resetStudyTable();
  currentPageIndex = 1;
  changeTab('#all');
  clearSearchInputs();
  clearInstance();
  searchStudies();
}

function loadToday() {
  resetStudyTable();
  currentPageIndex = 1;
  changeTab('#today');
  var today = new Date();
  today = get_date(today);
  searchStudyByDate(today, today);
}

function loadYesterday() {
  resetStudyTable();
  currentPageIndex = 1;
  changeTab('#yesterday');
  var yesterday = new Date();
  yesterday.setDate(yesterday.getDate() - 1);
  yesterday = get_date(yesterday);
  searchStudyByDate(yesterday, yesterday);
}

function loadWeek() {
  resetStudyTable();
  currentPageIndex = 1;
  changeTab('#last-week');

  var curr = new Date();
  var lastweek = new Date();
  lastweek.setDate(curr.getDate() - 7);
  curr = get_date(curr);
  lastweek = get_date(lastweek);
  searchStudyByDate(lastweek, curr);
}

function loadMonth() {
  resetStudyTable();
  currentPageIndex = 1;
  changeTab('#last-month');
  var curr = new Date();
  var lastmonth = new Date();
  lastmonth.setDate(curr.getDate() - 30);
  curr = get_date(curr);
  lastmonth = get_date(lastmonth);
  searchStudyByDate(lastmonth, curr);
}


function serieRowClicked() {
  selected_serie_uid = $(this).attr('data-serie');
  var rows = $('#series-table tbody tr');
  rows.removeClass('active');
  $(this).addClass('active');

}

function toggleModal(modalId) {
  $('#myModal').modal('toggle');
}

function clearInstance() {
  $thumb.html("");
  $modal.html("");
}

function changeTab(tab_id) {
  $("nav.navbar li>a").parent().removeClass('active');
  $(tab_id).parent().addClass('active');
  $(tab_id + '-xs').parent().addClass('active');
  hideResultSection(false);
}

function hideResultSection(animate) {
  animate = (typeof animate === 'undefined') ? true : animate;

  if (animate === true) {
    $.when($resultSection.fadeOut()).done(function() {
      $('#study-section').removeClass('under-result');
    });
  }
  else {
    $resultSection.hide();
      $('#study-section').removeClass('under-result');
  }
}

function showResultSection() {
  $resultSection.fadeIn();
  $('#study-section').addClass('under-result');
  selectFirstSerie();
}

function clearSearchInputs() {
  $('#search-from input').val("");
  $('#search-from select').val('').selectpicker('refresh');
}

function hideSearchSection() {
  $('#search-section').slideUp();
}

function showSearchSection() {
  $('#search-section').slideDown();
}

function toggleSearchSection() {
  $('#search-section').slideToggle();
}

function selectFirstSerie() {
  $('#series-table tbody tr:first').click();
}

function closeNavbar(event) {
  var clickover = $(event.target);
  var _opened = $(".navbar-collapse").hasClass("in");
  if (_opened === true && !clickover.hasClass("navbar-toggle"))
    $("button.navbar-toggle").click();
}
