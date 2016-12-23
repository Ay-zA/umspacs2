function CtViewer(element, option) {
  var _this = this;
  option = option || {};
  var activeCt = option.StartIndex || 0;
  var isPaused = option.isPaused || true;
  var interval;


  var updateActive = function() {
    _this.cts.each(function(index) {
      $(this).removeClass('active');
    });
    // console.log(activeCt);
    $(_this.cts[activeCt]).addClass('active');
  };

  _this.ctContainer = element;
  _this.cts = element.children('.ct');
  _this.itemsCount = _this.cts.length;

  _this.canSlide = function() {
    var canSlide = true;

    if (_this.itemsCount < 2)
      canSlide = false;

    return canSlide;
  };

  _this.cts.each(function() {
    $(this).removeClass('active');
  });

  // console.log($(_this.cts[0]));

  _this.next = function() {
    if (!_this.canSlide()) return;
    activeCt = (activeCt + 1) % _this.cts.length;
    updateActive();
  };

  _this.prev = function() {
    if (!_this.canSlide()) return;
    activeCt = (activeCt < 1) ? _this.cts.length - 1 : activeCt - 1;
    updateActive();
  };

  _this.togglePause = function () {
    if(isPaused) {
      _this.play(8);
    } else {
      _this.pause();
    }
  };

  _this.play = function (speed) {
    if(!!interval) {
      _this.pause();
    }
    interval = setInterval(_this.next, 1000/speed);
    isPaused = false;
  };

  _this.pause = function () {
    if(!!interval) {
      clearInterval(interval);
    }
    isPaused = true;
  };
  updateActive();
}
