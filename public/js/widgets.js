/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/widgets/index.js ***!
  \***************************************/
var widgetsTables = '.widget';
$(document).ready(function () {
  setWindowWidth();
  $(window).on('resize', function () {
    setWindowWidth();
  });
});

function setWindowWidth() {
  var widgets = $(widgetsTables);

  for (var i = 0; i < widgets.length; i++) {
    var cols = $(widgets[i]).find('.widget-head li').length,
        width = $(widgets[i]).width() / cols,
        lis = $(widgets[i]).find('li > span');

    for (var j = 0; j < lis.length; j++) {
      $(lis[j]).css({
        width: width
      });
    }
  }
}
/******/ })()
;