function CtViewer(element, option) {
  var _this = this;
  var option = option || {};
  var activeCt = option.StartIndex || 0;

  var canSlide = function () {
    var canSlide = true;

    if(_this.cts.length < 2)
      canSlide = false;

    return canSlide;
  }

  var updateActive = function () {
    _this.cts.each(function (index) {
      $(this).removeClass('active');
    });
    console.log(activeCt);
    $(_this.cts[activeCt]).addClass('active');
  };

  _this.ctContainer = element;
  _this.cts = element.children('.ct');

  _this.cts.each(function() {
    $(this).removeClass('active');
  });

  console.log($(_this.cts[0]));

  _this.next = function() {
    if (!canSlide()) return;
    activeCt = (activeCt + 1) % _this.cts.length;
    updateActive();
  }

  _this.prev = function() {
    if (!canSlide()) return;
    activeCt =(activeCt < 1) ? _this.cts.length - 1 : activeCt - 1;
 ;
    updateActive();
  }

  updateActive();
}
