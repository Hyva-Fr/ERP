const filtersFormBtn = '.crud-filters button[type="submit"]';
const paginationLinks = '.pagination-links > a';
const URL = location.pathname;
const tableContainer = '.crud-table-container';
const htmlReplacerCrud = '#crud-ajax';
const crudLoader = '#crud-loader';
const saveBtn = '.form-crud button[type="submit"]';
const required = '.form-crud :required';
const grants = '[name="constants[]"]';
const loader = '#loader';
const formCrud = '.form-crud';

$(document).ready(function(){

    setListenersCrud();
    setTinyMCE('#email-content');
    //setFormControl();
    grantsRuler();
    setLoaderOnSaveAction();
});

function setLoaderOnSaveAction() {

    $(formCrud).on('submit', function(){
        $(loader).addClass('loaderDisplay');
    });
}

function setListenersCrud() {

    $(filtersFormBtn).on('click', function(e){

        e.preventDefault();
        let radios = $('[name="crud-order"]'),
            check = 'asc';

        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked === true) {
                check = $(radios[i]).val()
            }
        }

        ajaxFromCrud({
            _token : $('[name="_token"]').val(),
            filter : $('[name="crud-filter"]').val(),
            order : check,
            page: $('.pagination-page-number.active').html(),
            pagination: $('[name="crud-per-page"]').val(),
            search : $('[name="crud-search"]').val()
        });
    })

    $(paginationLinks).on('click', function(e){

        e.preventDefault();
        let pageNb = this.href.split('?page=')[1];
        let radios = $('[name="crud-order"]'),
            check = 'asc';

        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked === true) {
                check = $(radios[i]).val()
            }
        }

        ajaxFromCrud({
            _token: $('meta[name="csrf-token"]').attr('content'),
            page: pageNb,
            filter : $('[name="crud-filter"]').val(),
            order : check,
            pagination: $('[name="crud-per-page"]').val(),
            search : $('[name="crud-search"]').val()
        });

    })
}

function ajaxFromCrud(data) {

    $(crudLoader).addClass('visible');
    $.ajax({
        url: URL,
        type: 'GET',
        data: data,
        success: function(html) {
            $(htmlReplacerCrud).replaceWith(html);
            setListenersCrud();
        }
    });
}

function setTinyMCE(id) {

    if ($(id).length > 0) {

        tinymce.init({
            selector: id,
            statusbar: false,
            plugins: 'lists link emoticons media',
            resize: false,
            toolbar: 'undo redo | blocks | bold italic link media | alignleft aligncenter alignright | indent outdent | bullist numlist | emoticons'
        });
    }
}

function setFormControl() {

    checkValidateStatement();
    $(required).on('input', function(e){
        checkValidateStatement()
    });
    $(required).on('change', function(e){
        checkValidateStatement()
    });
}

function checkValidateStatement() {

    let fields = $(required),
        allFieldsLength = fields.length,
        disabled = false;

    for (let i = 0; i < fields.length; i++) {
        let field = $(fields[i]),
            tag = $(field).prop("tagName").toLowerCase(),
            type = (tag !== 'input') ? tag : $(field).attr('type'),
            value = $(field).val();

        if (value) {

            if (value.length < 1) {
                disabled = true;
                break;
            }

        } else {

            console.log(tag)
        }
    }

    $(saveBtn).attr('disabled', disabled);
}

function grantsRuler() {

    let checkboxes = $(grants);
    if (checkboxes.length > 0) {

        $(checkboxes).on('input', function(){

            let check = false;
            for (let i = 0; i < checkboxes.length; i++) {

                if ($(checkboxes[i]).prop('checked') === true) {
                    check = true;
                    break;
                }
            }

            if (check === false) {
                $('[value="BASIC_GROUP"]').prop('checked', true);
            }
        });
    }
}