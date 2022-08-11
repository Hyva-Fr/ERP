const asideListContainer = '#aside-list-container';
const asideLists = '.aside-list';
const dropdowns = '.dropdown';
const selectedDropdowns = '.dropdown.show';
const triggers = '.aside-list > span';
const angle = '.fa-angle-down';
const aside = 'aside';

$(document).ready(function(){

    setDropdownMaxHeight();

    $(triggers).on('click', function(){

        let dropdown = $(this).closest(asideLists).children(dropdowns),
            height = 0,
            children = dropdown.children();

        for (let i = 0; i < children.length; i++) {
            height += 33;
        }

        if (dropdown.hasClass('show')) {
            $(this).find(angle).removeClass('rotate');
            dropdown.removeClass('show');
            dropdown.css('max-height', 0);
        } else {
            $(this).find(angle).addClass('rotate');
            dropdown.addClass('show');
            dropdown.css('max-height', height + 'px');
        }
    });
});

function setDropdownMaxHeight() {

    let dropdowns = $(selectedDropdowns);
    for (let i = 0; i < dropdowns.length; i++) {
        let dropdown = $(dropdowns[i]),
            children = dropdown.children(),
            height = 0;
        for (let j = 0; j < children.length; j++) {
            height += 33;
        }
        dropdown.css('max-height', height + 'px');
    }

    setTimeout(function(){
        $(aside).removeClass('display');
    }, 1000);
}