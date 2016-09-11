var hostname = window.location.hostname;
var baseURL = window.location.pathname.split('/')[1];

function getSeriesData() {
    var studyId = $(this).attr('data-study-id');
    var url = "src/components/php/api/service.php?action=getallseries&study_pk=" + studyId;
    $.getJSON(url, printSeries);
}

function getInstanceData(seriePk, cb) {
    var url = "src/components/php/api/service.php?action=getallinstances&serie_pk=" + seriePk;
    // console.log(url);
    $.getJSON(url, cb);
}
function getInstanceDataPromise(seriePk) {
    return new Promise(function(resolve, reject) {
      var url = "src/components/php/api/service.php?action=getallinstances&serie_pk=" + seriePk;
      // console.log(url);
      $.getJSON(url, resolve);
    });
}

function generateRequestURL(study_UID, serie_UID, instance_UID, frame) {
    frame = (typeof(frame) === 'undefined') ? 0 : frame;
    // console.log(study_UID);
    // console.log(serie_UID);
    // console.log(instance_UID);
    // console.log(frame);
    // console.log(hostname);

    var url = 'http://' + hostname + ':8080/wado?requestType=WADO' +
        '&studyUID=' + study_UID +
        '&seriesUID=' + serie_UID +
        '&objectUID=' + instance_UID +
        '&frameNumber=' + frame;

    // console.log(url);
    return url;
}

function searchStudies(pat_id, pat_name, modality, from_date, to_date,institution) {

    pat_id = (typeof(pat_id) === 'undefined') ? '' : pat_id;
    pat_name = (typeof(pat_name) === 'undefined') ? '' : pat_name;
    modality = (typeof(modality) === 'undefined') ? '' : modality;
    from_date = (typeof(from_date) === 'undefined') ? '' : from_date;
    to_date = (typeof(to_date) === 'undefined') ? '' : to_date;
    institution = (typeof(institution) === 'undefined') ? '' : institution;

    var url = "src/components/php/api/service.php?action=searchstudies&id=" + pat_id +
        "&name=" + pat_name +
        "&modality=" + modality +
        "&from=" + from_date +
        "&to=" + to_date+
        "&institution=" + institution;

    console.log(url);
    // $("#patient-table").DataTable({
    //   "searching": false,
    //   "iDisplayLength": 5,
    //   "iTotalRecords": 5,
    //   "iTotalDisplayRecords": 5,
    //   // 'bserverSide': true,
    //
    //   "ajax": {
    //     "url": url,
    //     "dataSrc": function ( json ) {
    //       var data = [];
    //       for ( var i=0, ien=json.length ; i<ien ; i++ ) {
    //         // output += '<tr loaded="false" data-iuid=' + data[i].study_iuid + ' data-study-id=' + data[i].study_pk + '>';
    //         // output += '<td data-type="pat_id">' + data[i].pat_id + '</td>';
    //         // output += '<td data-type="pat_name"><b>' + fix_name(data[i].pat_name) + '</b>/' + get_sex(data[i].pat_sex) + '/' + get_age(data[i].pat_birthdate) + '</td>';
    //         // output += '<td data-type="institution">' + fix_name(data[i].institution) + '</td>';
    //         // output += '<td data-type="modality">' + data[i].mods_in_study + '</td>';
    //         // output += '<td data-type="study_date">' + to_persian_date(data[i].study_datetime) + '</td>';
    //         // output += '<td data-type="study_time">' + get_time(data[i].study_datetime) + '</td>';
    //         // output += '<td class="hidden-xs" data-type="num_series">' + data[i].num_series + '</td>';
    //         // output += '<td class="hidden-xs" data-type="num_instances">' + data[i].num_instances + '</td>';
    //         // var url = generateWeasisUrl('patient', data[i].pat_id);
    //         // output += '<td><a class="weasis-btn flat-btn hidden-xs" href="' + url + '"><span class="glyphicon glyphicon-eye-open"></span></a></td>';
    //         // output += '</tr>';
    //         data.push(
    //           {
    //            '0': json[i].pat_id,
    //            '1': json[i].pat_name,
    //            '2': json[i].institution,
    //            '3': json[i].mods_in_study,
    //            '4': to_persian_date(json[i].study_datetime),
    //            '5': get_time(json[i].study_datetime),
    //            '6': json[i].num_series,
    //            '7': json[i].num_instances,
    //            '8': '<a class="weasis-btn flat-btn hidden-xs" href="' + generateWeasisUrl('patient', json[i].pat_id) + '"><span class="glyphicon glyphicon-eye-open"></span></a>'
    //          });
    //       }
    //       return data;
    //     }
    //   },
    //   "bFilter": false,
    //   "bAutoWidth": false,
    //   "bInfo": false,
    //   "bLengthChange": false,
    //   "sPaginationType": "full_numbers",
    //   "fnDrawCallback": function() {
    //     if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
    //       $('.dataTables_paginate').css("display", "block");
    //       $('.dataTables_length').css("display", "block");
    //       $('.dataTables_filter').css("display", "block");
    //     } else {
    //       $('.dataTables_paginate').css("display", "none");
    //       $('.dataTables_length').css("display", "none");
    //       $('.dataTables_filter').css("display", "none");
    //     }
    //   },
    // });
    $.getJSON(url, printStudies);
}

function searchStudyByDate(from_date, to_date) {
    searchStudies(undefined, undefined, undefined, from_date, to_date, undefined);
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
            url = "#";
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
