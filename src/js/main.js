var $thumb = $('#thumb-div');
var $modal = $('#viewer-modal .modal-body');
var $modalHeader = $('#viewer-modal .modal-title');
var $patient_table = $('#patient-table tbody');
var $seriesTable = $('#series-table tbody');
var $resultSection = $('#result-section');
var $seriesSectionHeader = $('#result-section .section-header h4');
var $paginationList = $('#study-pagination .pagination');

var $idSearchInput = $('#searchById');
var $nameSearchInput = $('#searchByName');
var $institutionSearchInput;
var $modalitySearchInput;
var $accessionSearchInput = $('#searchByAccession');
var $fromDateSearchInput = $('#searchByFrom');
var $toDateSearchInput = $('#searchByTo');


var $dataTable = false;
var selected_study_uid;

var series_data = {};
var instance_data = {};

var totalStudy = 0;
var defaultPageSize = 10;
var currentPageIndex = 1;

var ctViewer;

function patientRowClicked() {
  clearInstance();
  var rows = $('#patient-table tbody tr');
  var loaded = $(this).attr('loaded');
  var studyId = $(this).attr('data-study-id');
  selected_study_uid = $(this).attr('data-iuid');

  rows.removeClass('active');
  $(this).addClass('active');

  if (loaded === true) {
    loadSeriesData();
  } else {
    getSeriesData(studyId, printSeries);
  }
}

function openWeasis(e) {
  console.log("ERR");
  var id = $(e.target).closest('tr').attr('data-uid').text();
  var url = generateWeasisUrl('study', id);
  window.open(url);
}

function openPanel(e) {
  var id = $(e.target).closest('tr').attr("data-study-id");
  window.open('panel.php?pat_id=' + id);
}

function searchByInput() {
  $institutionSearchInput = $('#searchByInstitution').parent().children('button').children('span');
  $modalitySearchInput = $('#searchByModality').parent().children('button').children('span');

  hideResultSection(false);
  resetStudyTable();
  currentPageIndex = 1;

  var id = $idSearchInput.val();
  var name = $nameSearchInput.val();
  var institution = $institutionSearchInput.text();
  var modality = $modalitySearchInput.text();
  var accession = $accessionSearchInput.val();
  var fromDate = $fromDateSearchInput.val();
  var toDate = $toDateSearchInput.val();

  modality = parseModality(modality);
  institution = parseInstitution(institution);
  fromDate = isValidDate(fromDate) ? to_gregorian_date(fromDate) : "";
  toDate = isValidDate(toDate) ? to_gregorian_date(toDate) : "";

  searchStudies(id, name, accession, modality, fromDate, toDate, institution);
}

function loadAll(e) {
  currentPageIndex = 1;
  changeTab('#all');
  clearSearchInputs();
  clearInstance();
  searchStudies();
  resetStudyTable();
}

function loadToday() {
  currentPageIndex = 1;
  changeTab('#today');

  var today = formatDate(new Date());
  today = to_persian_date(today);

  $toDateSearchInput.val(today);
  $fromDateSearchInput.val(today);

  searchByInput();
  resetStudyTable();
}

function loadYesterday() {
  currentPageIndex = 1;
  changeTab('#yesterday');
  var today = formatDate(new Date());
  today = to_persian_date(today);

  var yesterday = new Date();
  yesterday.setDate(yesterday.getDate() - 1);
  yesterday = formatDate(yesterday);
  yesterday = to_persian_date(yesterday);

  $toDateSearchInput.val(yesterday);
  $fromDateSearchInput.val(yesterday);

  searchByInput();
  resetStudyTable();
}

function loadWeek() {
  currentPageIndex = 1;
  changeTab('#last-week');

  var today = formatDate(new Date());
  today = to_persian_date(today);

  var lastweek = new Date();
  lastweek.setDate(lastweek.getDate() - 7);
  lastweek = formatDate(lastweek);
  lastweek = to_persian_date(lastweek);

  $toDateSearchInput.val(today);
  $fromDateSearchInput.val(lastweek);

  searchByInput();
  resetStudyTable();
}

function loadMonth() {
  currentPageIndex = 1;
  changeTab('#last-month');

  var today = formatDate(new Date());
  today = to_persian_date(today);

  var lastMonth = new Date();
  lastMonth.setDate(lastMonth.getDate() - 30);
  lastMonth = formatDate(lastMonth);
  lastMonth = to_persian_date(lastMonth);

  $toDateSearchInput.val(today);
  $fromDateSearchInput.val(lastMonth);

  searchByInput();
  resetStudyTable();
}


function serieRowClicked() {
  selected_serie_uid = $(this).attr('data-serie');
  var seriePk = $(this).attr('data-id');
  var loaded = $(this).attr('loaded');
  var rows = $('#series-table tbody tr');
  rows.removeClass('active');
  $(this).addClass('active');
  if (loaded === true) {
    loadInstanceData();
  } else {
    getInstanceData(seriePk, showInstance);
  }

}

function showSerie(series_iuid) {
  selected_serie_uid = series_iuid;
  toggleModal();
}

function handelSerieDoubleClick(e) {
  e.preventDefault();
  toggleModal();
}

function toggleModal() {

  $('#viewer-modal').modal('toggle');

  // TODO:0 Scroll
  //FIXME:0 async func x__x
  delay(function() {
    initCtViewer();
  }, 200);

}

function initCtViewer() {
  var viewer = $('#viewer');
  ctViewer = new CtViewer(viewer);

  if (isFirefox) {

    viewer.bind('DOMMouseScroll', function(e) {
      if (e.originalEvent.detail > 0) {
        ctViewer.next();
      } else {
        ctViewer.prev();
      }
      return false;
    });
  } else {
    viewer.bind('mousewheel', function(e) {
      if (e.originalEvent.wheelDelta < 0) {
        ctViewer.next();
      } else {
        ctViewer.prev();
      }
      return false;
    });
  }
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
  } else {
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

function closeSearchSection() {
  $('#search-section').slideUp();
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

function handelResetSearchInput() {
  var $searchInput = $(this).parent().children('input');
  var oldVal = $searchInput.val();
  //TODO: Clear Value
  $searchInput.val('');
  var newVal = $searchInput.val();
  // TODO: flan inja bashe
  if(oldVal !== newVal)
    searchByInput();
}
