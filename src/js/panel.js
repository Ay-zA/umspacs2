var QueryString = function() {
  // This function is anonymous, is executed immediately and
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    // If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
      // If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
      query_string[pair[0]] = arr;
      // If third or later entry with this name
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  }
  return query_string;
}();
var $slider;
var pat_id = QueryString.pat_id;
var viewer = $("#viewer");
var selected_serie_uid;

function getInstanceDataAndShowInPanel(serie_pk) {
  getInstanceData(serie_pk, showInPanel);
}

function showInPanel(data) {
  var output = "";

  output += '<ul id="imageGallery">';

  $.each(data, function(i, obj) {
    var request = generateRequestURL(study_uid, selected_serie_uid, obj.sop_iuid);
    output += '<li data-thumb="' + request + '">' +
      '<img src="' + request + '" />' +
      '</li>';
  });

  output += '</ul>';

  viewer.html(output);
  var $selected_serie = $('#viewer-serie-list li.active');
  $selected_serie.attr('loaded', 'true');

  delay(createSlider, 10);

  function createSlider() {
    $slider = $('#imageGallery').lightSlider({
      gallery: true,
      item: 1,
      loop: true,
      speed: 200,
      pause: 400,
      // thumbItem: 9,
      slideMargin: 0,
      enableDrag: true,
      currentPagerPosition: 'left'
      // onSliderLoad: function(el) {
      //   el.lightGallery({
      //     selector: '#imageGallery .lslide'
      //   });
      // }
    });
  } //
  $('#play').click(function() {
    $slider.play();
  });
}

function handleSerieClick(e) {
  selected_serie_uid = $(e.target).attr('data-serie-uid');
  var serie_pk = $(this).attr('data-serie-pk');
  getInstanceDataAndShowInPanel(serie_pk);
}

function activeLink(e) {
  $('#viewer-serie-list li').removeClass('active');
  var id = $(e.target).parent('li').addClass('active');
}


$('.serie-link').on('click', activeLink);
$('.serie-link').on('click', handleSerieClick);
