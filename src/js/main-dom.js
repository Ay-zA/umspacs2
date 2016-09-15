function showInstance(data) {
  var output = "";
  $.each(data, function(i, obj) {

    var request = generateRequestURL(selected_study_uid, selected_serie_uid, obj.sop_iuid);
    output += '<div class="col-sm-12 full-height"><img class="img-responsive thumb-img" src="' + request + '" /></div>';
  });

  $thumb.html(output);
  var $selected_serie = $('#series-table tbody tr.active');

  $selected_serie.attr('loaded', 'true');
  var seried_id = $selected_serie.attr('data-id');
  instance_data[seried_id] = output;
  var rowoutput = '<div class="row">' + output + '</div>';
  $modal.html(rowoutput);

}

function loadInstanceData() {
  var $selected_serie = $('#series-table tbody tr.active');
  var serie_id = $selected_serie.attr('data-id');

  $thumb.html(instance_data[serie_id]);

  var rowoutput = '<div class="row">' + instance_data[serie_id] + '</div>';
  $modal.html(rowoutput);

}

function printSeries(data) {
  var output = "";

  $.each(data, function(i, obj) {
    output += '<tr loaded="false" data-id=' + obj.pk + ' data-serie=' + obj.series_iuid + '>';
    output += '<td>' + ((obj.body_part !== null) ? obj.body_part : 'N/A') + '</td>';
    output += '<td>' + obj.num_instances + '</td>';
    output += '<td>' + obj.series_desc + '</td>';
    var url = generateWeasisUrl('serie', obj.series_iuid);
    output += '<td class="hidden-xs"><a class="weasis-btn flat-btn" href="' + url + '"><span class="glyphicon glyphicon-eye-open"></span></button><td>';
    output += '</tr>';
  });
  var patName = $('#patient-table tr.active td[data-type="pat_name"]').text();
  var $selectedPatient = $('#patient-table tbody tr.active');
  var selectedPatientId = $selectedPatient.children('td[data-type="pat_id"]').text();

  $seriesSectionHeader.html(patName);
  $modalHeader.html(patName);
  $seriesTable.html(output);

  series_data[selectedPatientId] = output;

  $selectedPatient.attr('loaded', 'true');

  showResultSection();
}

function loadSeriesData() {
  var $selectedPatient = $('#patient-table tbody tr.active');
  var selectedPatientId = $selectedPatient.children('td[data-type="pat_id"]').text();
  $seriesTable.html(series_data[selectedPatientId]);
  showResultSection();
}

function printStudies(data) {
  totalStudy = data.total;
  var page = 1;
  var page_size = 1000;
  var output = "";
  for (var i = (page - 1) * page_size; i < page * page_size; i++) {
    if (!data[i]) break;
    output += '<tr loaded="false" data-iuid=' + data[i].study_iuid + ' data-study-id=' + data[i].study_pk + '>';
    output += '<td data-type="pat_id">' + data[i].pat_id + '</td>';
    output += '<td data-type="pat_name"><b>' + fix_name(data[i].pat_name) + '</b>/' + get_sex(data[i].pat_sex) + '/' + get_age(data[i].pat_birthdate) + '</td>';
    output += '<td data-type="institution">' + fix_name(data[i].institution) + '</td>';
    output += '<td data-type="modality">' + data[i].mods_in_study + '</td>';
    output += '<td data-type="study_date">' + to_persian_date(data[i].study_datetime) + '</td>';
    output += '<td data-type="study_time">' + get_time(data[i].study_datetime) + '</td>';
    output += '<td class="hidden-xs" data-type="num_series">' + data[i].num_series + '</td>';
    output += '<td class="hidden-xs" data-type="num_instances">' + data[i].num_instances + '</td>';
    var url = generateWeasisUrl('patient', data[i].pat_id);
    output += '<td><a class="weasis-btn flat-btn hidden-xs" href="' + url + '"><span class="glyphicon glyphicon-eye-open"></span></button></td>';
    output += '</tr>';
  }
  $('#noresult').css('display', data.length === 0 ? 'flex' : 'none');
  $('#patient-table_wrapper').css('display', data.length === 0 ? 'none' : 'block ');

  $patient_table.html(output);

  initStudyDataTable();
  initPagination();
}

function initStudyDataTable() {
  if (!$dataTable) {
    $dataTable = $('#patient-table').DataTable({
      'searching': false,
      'pageLength': defaultPageSize,
      'bPaginate': false,
      'info': false
    });

    $('#patient-table').on('page.dt', function() {
      clearSearchInputs();
    });
  }
}

function initPagination() {
  pageCount = Math.ceil(totalStudy / defaultPageSize);
  generatePagination(pageCount);
}

function generatePagination(pageCount) {
  if (pageCount < 0)
    pageCount = 0;
  var output =
    '<li>' +
    ' <a href="#" aria-label="Previous">' +
    '   <span aria-hidden="true">&laquo;</span>' +
    ' </a>';

  var firstPage = currentPageIndex <= 5 ? 1 : (currentPageIndex - 5);
  var lastPage = currentPageIndex  < (pageCount - 5) ? (currentPageIndex + 5) : pageCount;

  for (var i = firstPage; i <= lastPage ; i++) {
    output += '<li data-page-index="' + i + '"><a href="#">' + i + '</a></li>';
  }

  output +=
    '<li>' +
    ' <a href="#" aria-label="Next">' +
    '  <span aria-hidden="true">&raquo;</span>' +
    ' </a>' +
    '</li>';

  $paginationList.html(output);
  $paginationList.css('display', pageCount === 0 ? 'none' : 'inline-block');
  activeStudyPage();
  $paginationList.children('li').on('click', handleStudyPageClick);
}

function handleStudyPageClick(e) {
  var page2Go = $(e.target).text();
  changeStudyPageTo(page2Go);
}

function changeStudyPageTo(page) {
  loadStudyPage(page);
  activeStudyPage(page);
}

function activeStudyPage(page) {
  currentPageIndex = +page || currentPageIndex;
  $paginationList.children('li[data-page-index="' + currentPageIndex + '"]').addClass('active');

}
