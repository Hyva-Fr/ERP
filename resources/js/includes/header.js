const aside = 'aside';
const burger = '#burger-icon';

$(document).ready(function(){

    setAsidePosition();
    listenBurgerEvent();

    $(window).resize(function(){
        setAsidePosition();
    });
});

function setAsidePosition() {

    if (window.innerWidth > 1079) {

        $(aside).removeClass('open');
        $(burger).removeClass('open fa-xmark').addClass('fa-bars');
    }
}

function listenBurgerEvent() {

    $(burger).on('click', function(){

        if ($(burger).hasClass('open')) {
            $(aside).removeClass('open');
            $(burger).removeClass('open fa-xmark').addClass('fa-bars');
        } else {
            $(burger).removeClass('fa-bars').addClass('open fa-xmark');
            $(aside).addClass('open');
        }
    });
}