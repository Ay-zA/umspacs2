var hostname = window.location.hostname;
var baseURL = window.location.pathname.split('/')[1];
var selected_study_uid;

function getSeriesData() {
    var studyId = $(this).attr('data-study-id');
    var url = "src/components/php/api/service.php?action=getallseries&study_pk=" + studyId;
    $.getJSON(url, printSeries);
}

function getInstanceData() {

    var seriePk = $(this).attr('data-id');
    selected_serie_uid = $(this).attr('data-serie');

    var url = "src/components/php/api/service.php?action=getallinstances&serie_pk=" + seriePk;
    // console.log(url);
    $.getJSON(url, showInstance);
}

function getInstitutionName(studyId) {
  // TODO: getInstitutionName!
  return "TODO";

    // var url = "src/components/php/api/service.php?action=getInstitutionName&study_pk=" + studyId;
    // var res = $.ajax({
    //     url: url,
    //     async: false,
    //     dataType: 'json'
    // });
    // return $.parseJSON(res.responseText);
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

function searchStudies(pat_id, pat_name, modality, from_date, to_date) {

    pat_id = (typeof(pat_id) === 'undefined') ? '' : pat_id;
    pat_name = (typeof(pat_name) === 'undefined') ? '' : pat_name;
    modality = (typeof(modality) === 'undefined') ? '' : modality;
    from_date = (typeof(from_date) === 'undefined') ? '' : from_date;
    to_date = (typeof(to_date) === 'undefined') ? '' : to_date;

    url = "src/components/php/api/service.php?action=searchstudies&id=" + pat_id +
        "&name=" + pat_name +
        "&modality=" + modality +
        "&from=" + from_date +
        "&to=" + to_date;

    console.log(url);

    $.getJSON(url, printStudies);
}

function searchStudyByDate(from_date, to_date) {
    searchStudies(undefined, undefined, undefined, from_date, to_date);
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

function getModalities() {

}
// Help method

/*
var tableOffset = 20;
var $header = $("#patient-table > thead").clone();
var $fixedHeader = $(".header-fixed").append($header);
console.log(tableOffset);

$("#patient-table-div").bind("scroll", function() {
    var offset = $(this).scrollTop();
    console.log(offset);
    console.log(tableOffset);
    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
        $fixedHeader.show();
    }
    else if (offset <= tableOffset) {
        $fixedHeader.hide();
    }
});
*/
