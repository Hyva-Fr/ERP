/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/dimmers/script.js ***!
  \****************************************/
var ipDimmerRows = '#ipfilter-dimmer table tbody tr';
var modalURL = '/modals/ip-modal';
var modalContainer = '.modal-container:not(#modal-quantic)';
var dataContainer = '.ip-modal .two-sides-modal';
var modal = '.ip-modal';
var loader = '#loader';
var closeModal = '.ip-modal .modal-title > i';
var modalLeft = '.ip-modal .modal-left';
var unbanBtn = '#unban-ip';
var matIntervall;
$(document).ready(function () {
  $(ipDimmerRows).on('click', function () {
    var data = JSON.parse(this.dataset.info),
        token = $('meta[name="csrf-token"]').attr('content');
    $(loader).addClass('loaderDisplay');
    $(modalContainer).remove();
    $.post(modalURL, {
      '_token': token,
      'data': data
    }, function (html, status) {
      $(loader).removeClass('loaderDisplay');

      if (status === 'success') {
        $('body').append(html);
        $(modalContainer).addClass('show');
        setModalEvents();
        createMap();
      } else {
        console.log(html);
      }
    });
  });
});

function setModalEvents() {
  $(modalContainer).on('click', function (e) {
    if (!e.target.classList.contains('modal') && e.target.closest('.modal') === null) {
      closeOpenedModal();
    }
  });
  $(closeModal).on('click', function (e) {
    closeOpenedModal();
  });
  $(unbanBtn).on('click', function () {
    var id = $(dataContainer).data('id');
    $(loader).addClass('loaderDisplay');
    $(modalContainer).remove();
    $.post('/ajax/unban-ip', {
      id: id
    }, function (data, status) {
      $(loader).removeClass('loaderDisplay');

      if (status === 'success') {
        window.location = '/';
        console.log(data);
      } else {
        console.log(data);
      }
    });
  });
}

function closeOpenedModal() {
  $(modalContainer).removeClass('show');
  setTimeout(function () {
    $(modalContainer).remove();
  }, 250);
}

function createMap() {
  clearInterval(matIntervall);
  var lat = parseFloat($(modalLeft).data('lat')),
      lng = parseFloat($(modalLeft).data('lng'));
  var map = L.map('map').setView([lat, lng], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
  L.marker([lat, lng]).addTo(map);
  matIntervall = setInterval(function () {
    map.invalidateSize();
  }, 100);
}
/******/ })()
;