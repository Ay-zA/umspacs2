  var $info = $('#result-information');

  function showInstance(data) {
    var output = "";
    $.each(data, function(i, obj) {
      // WADO(selected_study_uid, selected_serie_uid, obj.sop_iuid);
      var request = generateRequestURL(selected_study_uid, selected_serie_uid, obj.sop_iuid);
      output += '<div class="col-sm-12 full-height ct"><img class="img-responsive thumb-img" src="' + request + '" /></div>';
    });

    $thumb.html(output);
    var $selected_serie = $('#series-table tbody tr.active');
    $selected_serie.attr('loaded', 'true');
    var seried_id = $selected_serie.attr('data-id');
    instance_data[seried_id] = output;
    var rowoutput = '<div id="viewer" class="row">' + output + '</div>';
    $modal.html(rowoutput);

  }

  function loadInstanceData() {
    var $selected_serie = $('#series-table tbody tr.active');
    var serie_id = $selected_serie.attr('data-id');

    $thumb.html(instance_data[serie_id]);

    var rowoutput = '<div id="viewer" class="row">' + instance_data[serie_id] + '</div>';
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
      output += '<td class="hidden-xs"><a class="weasis-btn flat-btn" href="' + url + '"><span class="glyphicon glyphicon-eye-open"></span></button></td>';
      output += '<td class="visible-xs"><a class="weasis-btn flat-btn" onclick="showSerie(\'' + obj.series_iuid + '\')"><span class="glyphicon glyphicon-eye-open"></span></button></td>';
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
    totalStudy = data.studyCount;
    totalSerie = data.serieCount;
    totalInstance = data.instanceCount;
    var output = "";
    var i = 0;
    while (data[i]) {
      output += '<tr loaded="false" data-iuid=' + data[i].study_iuid + ' data-study-id=' + data[i].study_pk + '>';
      output += '<td data-type="pat_id">' + data[i].pat_id + '</td>';

      var birthDate = convertStringDateToDate(data[i].pat_birthdate);
      var studyDate = convertStringDateToDate(data[i].study_datetime);

      var age = getAge(studyDate, birthDate);

      output += '<td data-type="pat_name"><b>' + fix_name(data[i].pat_name) + '</b> <div class="personal-info">' +
        '<span class="label label-default">' + age.age + ' ' + age.type + '</span>' +
        '<span class="gender gender-' + getSex(data[i].pat_sex, true) + ' label label-default">' + getSex(data[i].pat_sex, true) + '</span>' +
        '</div></td>';
      output += '<td data-type="institution">' + fix_name(data[i].institution) + '</td>';
      output += '<td data-type="accession">' + fix_name(data[i].accession_no) + '</td>';
      output += '<td data-type="modality">' + data[i].mods_in_study + '</td>';
      output += '<td data-type="study_date">' + toReadableDate(data[i].study_datetime, true) + ' ' + get_time(data[i].study_datetime) + '</td>';
      output += '<td class="hidden-xs" data-type="num_series"><span class="label label-default" style="margin-right:2px;">' + data[i].num_series + ' Series </span><span class="label label-default">' + data[i].num_instances + ' Images </span>' + '</td>';
      var url = generateWeasisUrl('study', data[i].study_iuid);
      output += '<td data-type="weasis"><a class="weasis-btn flat-btn hidden-xs" href="' + url + '"><span class="glyphicon glyphicon-eye-open"></span></a><a class="weasis-btn flat-btn hidden-xs" href="report.php?study_id=' + data[i].study_id + '"><span class="glyphicon glyphicon-list-alt"></span></a></td>';
      output += '</tr>';
      i++;
    }

    $('#noresult').css('display', data.length === 0 ? 'flex' : 'none');
    $('#patient-table_wrapper').css('display', data.length === 0 ? 'none' : 'block ');

    $patient_table.html(output);
    initStudyDataTable();
    initPagination();
    generateInformation(totalStudy, totalSerie, totalInstance);
    $loading.hide();
  }

  function initStudyDataTable() {
    if (!$dataTable) {
      $dataTable = $('#patient-table').DataTable({
        'searching': false,
        'pageLength': defaultPageSize,
        'bPaginate': false,
        'info': false,
        'responsive': true,
        'bSort': true,
        "aaSorting": []
      });

      $('#patient-table').on('page.dt', function() {
        clearSearchInputs();
      });
      $('#patient-table_wrapper #patient-table').closest('div').addClass('table-responsive');
    }
  }

  function resetStudyTable() {
    if ($dataTable)
      $dataTable.destroy();
    $dataTable = false;
    delay(initStudyDataTable, 500);
  }

  function initPagination() {
    pageCount = Math.ceil(totalStudy / defaultPageSize);
    generatePagination(pageCount);
  }

  function generatePagination(pageCount) {
    if (pageCount < 0)
      pageCount = 0;

    var maxPageCount = 5;
    var startPageIndex;
    var endPageIndex;
    var trigger = (maxPageCount + 1) / 2;
    if (currentPageIndex <= trigger) {
      startPageIndex = 1;
      endPageIndex = maxPageCount < pageCount ? maxPageCount : pageCount;

    } else if (currentPageIndex > pageCount - trigger) {
      startPageIndex = pageCount - maxPageCount + 1;
      endPageIndex = pageCount;

    } else {
      startPageIndex = currentPageIndex - trigger + 1;
      endPageIndex = currentPageIndex + trigger - 1;
      endPageIndex = endPageIndex < pageCount ? endPageIndex : pageCount;
    }
    var output =
      '<li data-page-index="first">' +
      ' <a href="#" aria-label="Previous">' +
      '   <span aria-hidden="true">&laquo;</span>' +
      ' </a>';


    for (var i = startPageIndex; i <= endPageIndex; i++) {
      output += '<li data-page-index="' + i + '"><a href="#">' + i + '</a></li>';
    }

    output +=
      '<li data-page-index="last">' +
      ' <a href="#" aria-label="Next">' +
      '  <span aria-hidden="true">&raquo;</span>' +
      ' </a>' +
      '</li>';

    $paginationList.html(output);
    $paginationList.css('display', pageCount === 0 ? 'none' : 'inline-block');
    $info.css('display', pageCount === 0 ? 'none' : 'block');
    activeStudyPage();
    $paginationList.children('li').on('click', handleStudyPageClick);
  }

  function handleStudyPageClick(e) {
    hideResultSection(false);
    var $el = $(e.target);
    var page2Go = $el.closest('li').attr('data-page-index');
    switch (page2Go) {
      case 'first':
        page2Go = 1;
        break;
      case 'last':
        page2Go = pageCount;
        break;
    }
    changeStudyPageTo(page2Go);
  }

  function changeStudyPageTo(page) {

    if (page < 1)
      page = 1;
    if (page > pageCount)
      page = pageCount;

    loadStudyPage(page);
    activeStudyPage(page);
    resetStudyTable();
  }

  function activeStudyPage(page) {
    currentPageIndex = +page || currentPageIndex;
    if (currentPageIndex < 1)
      currentPageIndex = 1;
    if (currentPageIndex > pageCount)
      currentPageIndex = pageCount;

    var prev = $paginationList.children('li:first');
    var next = $paginationList.children('li:last');

    prev.removeClass('disabled');
    if (currentPageIndex === 1)
      prev.addClass('disabled');

    next.removeClass('disabled');
    if (currentPageIndex === pageCount)
      next.addClass('disabled');

    $paginationList.children('li').removeClass('active');
    $paginationList.children('li[data-page-index="' + currentPageIndex + '"]').addClass('active');

  }

  function generateInformation(totalStudy, totalSerie, totalInstance) {
    var startResultIndex = (currentPageIndex - 1) * defaultPageSize + 1;
    var endResultIndex = startResultIndex + defaultPageSize - 1;
    if (endResultIndex > totalStudy) {
      endResultIndex = totalStudy;
    }
    var output = '<p> showing result ' + startResultIndex + ' to ' + endResultIndex + '.<br />' + totalStudy + ' studies, ' + totalSerie + ' series, ' + totalInstance + ' images founded.';
    $info.html(output);

  }
