const widgetsTables = '.widget';

$(document).ready(function(){

    setWindowWidth();

    $(window).on('resize', function(){
        setWindowWidth();
    })
});

function setWindowWidth() {

    let widgets = $(widgetsTables);
    for (let i = 0; i < widgets.length; i++) {
        let cols = $(widgets[i]).find('.widget-head li').length,
            width = $(widgets[i]).width() / cols,
            lis = $(widgets[i]).find('li > span');
        for (let j = 0; j < lis.length; j++) {
            $(lis[j]).css({width: width})
        }
    }
}