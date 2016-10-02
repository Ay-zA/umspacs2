$('#patient-table tbody').on('click', 'tr',  patientRowClicked);
// $('#patient-table tbody').on('dblclick', 'tr', openPanel);

$('#series-table tbody').on('click', 'tr', serieRowClicked);
$('#series-table tbody').on('dblclick', "tr", handelSerieDoubleClick);

$('#today').on('click', loadToday);
$('#today-xs').on('click', loadToday);
$('#all').on('click', loadAll);
$('#all-xs').on('click', loadAll);
$('#yesterday').on('click', loadYesterday);
$('#last-week').on('click', loadWeek);
$('#last-month').on('click', loadMonth);

// $('#today').on('click', hideSearchSection);
// $('#today-xs').on('click', hideSearchSection);
// $('#yesterday').on('click', hideSearchSection);
// $('#last-week').on('click', hideSearchSection);
// $('#last-month').on('click', hideSearchSection);

$('#all').on('click', showSearchSection);
$(".searchButton").on('click', function() {
  toggleSearchSection();
});


$('#search-from input[type="search"]').on('input', function() {
  delay(searchByInput, 500);
});

$('#search-from input[type="text"]').on('input', function() {
  if (isValidDate($(this).val()))
    delay(searchByInput, 500);
});

$('#search-from select').on('change', function(e) {
  delay(searchByInput, 500);
});

$('#search-from #searchByTo').on('change', function(e) {
  changeTab('#all');
});
$('#search-from #searchByFrom').on('change', function(e) {
  console.log('a');
  changeTab('#all');
});

$(document).click(closeNavbar);
