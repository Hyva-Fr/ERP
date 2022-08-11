const ipDimmerRows = '#ipfilter-dimmer table tbody tr';
const modalURL = '/modals/ip-modal';
const modalContainer = '.modal-container:not(#modal-quantic)';
const dataContainer = '.ip-modal .two-sides-modal';
const modal = '.ip-modal';
const loader = '#loader';
const closeModal = '.ip-modal .modal-title > i';
const modalLeft = '.ip-modal .modal-left';
const unbanBtn = '#unban-ip';
let matIntervall;

$(document).ready(function(){

    $(ipDimmerRows).on('click', function(){

        let data = JSON.parse(this.dataset.info),
            token = $('meta[name="csrf-token"]').attr('content');

        $(loader).addClass('loaderDisplay');
        $(modalContainer).remove();

        $.post(modalURL,
            {'_token': token, 'data': data},
            function(html, status) {

                $(loader).removeClass('loaderDisplay');
                if (status === 'success') {

                    $('body').append(html);
                    $(modalContainer).addClass('show');
                    setModalEvents();
                    createMap();

                } else {
                    console.log(html);
                }
            }
        )
    })
});

function setModalEvents() {

    $(modalContainer).on('click', function(e){
        if (!e.target.classList.contains('modal') && e.target.closest('.modal') === null) {
            closeOpenedModal();
        }
    })

    $(closeModal).on('click', function(e){
        closeOpenedModal();
    })

    $(unbanBtn).on('click', function(){

        let id = $(dataContainer).data('id');
        $(loader).addClass('loaderDisplay');
        $(modalContainer).remove();

        $.post('/ajax/unban-ip', {id: id}, function(data, status){
            $(loader).removeClass('loaderDisplay');
            if (status === 'success') {
                window.location = '/';
                console.log(data)
            } else {
                console.log(data);
            }
        })
    })
}

function closeOpenedModal() {

    $(modalContainer).removeClass('show');
    setTimeout(function(){
        $(modalContainer).remove();
    }, 250);
}

function createMap() {

    clearInterval(matIntervall);
    let lat = parseFloat($(modalLeft).data('lat')),
        lng = parseFloat($(modalLeft).data('lng'));
    let map = L.map('map').setView([lat, lng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
    L.marker([lat, lng]).addTo(map);

    matIntervall = setInterval(function () {
        map.invalidateSize();
    }, 100);
}