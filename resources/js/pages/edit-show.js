const fileLabels = '.file-form';
const picContainer = '.pics-container';
const fileInput = '.file-form input[type="file"]';
const fileTitle = '.file-title';
const fileBtn = '.file-form button[type="button"]';
const acceptPdf = 'application/pdf';
const acceptXls = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel';
const multiTrigger = '#new-images-container button[type="button"]';
const multiInput = '#files-trigger';
const filesList = '#new-files-lister';
const deleteImage = '.delete-image-mission';
const deleteURL = '/ajax/delete-mission-image';
const loader = '#loader';

$(document).ready(function(){

    $('input[type="text"]').attr('spellcheck', false);
    $('textarea').attr('spellcheck', false);
    $('input[type="text"]').attr('autocomplete', 'off');
    $('textarea').attr('autocomplete', 'off');
    $('input[type="email"]').attr('spellcheck', false);
    $('input[type="email"]').attr('autocomplete', 'off');

    $(fileBtn).on('click', function(){
        let input = $(this).next();
        input.click();
    });

    $(fileInput).on('change', function(){
        setFileName(this);
    });

    $(multiTrigger).on('click', function(){
        $(multiInput).click();
    });

    $(multiInput).on('change', function(){
        setFilesNames(this);
    });

    $(deleteImage).on('click', function(){
        setDeleteImage(this);
    });
});

function setFileName(elmt) {

    let file = elmt.files[0],
        split = file.name.split('.'),
        ext = split[split.length-1],
        accept = elmt.accept,
        message = $(elmt).closest(picContainer).data('replace');

    if (
        (accept === acceptPdf && ext === 'pdf')
        ||
        (accept === acceptXls && (ext === 'xls' || ext === 'xlsx'))
    ) {
        $(elmt).closest(fileLabels).find(fileTitle).html(file.name);
    } else {
        $(elmt).closest(fileLabels).find(fileTitle).html(message);
        $(elmt).val(null);
    }
}

function setFilesNames(elmt) {

    let files = elmt.files;
    let html = '';
    for (let i = 0; i < files.length; i++) {
       html += '<li><i class="fa-solid fa-image fa-lg fa-fw"></i>' + files[i].name + '</li>'
    }
    $(filesList).html(html);
}

function setDeleteImage(elmt) {

    let path = $(elmt).data('path'),
        id = $(elmt).data('id'),
        token = $('meta[name="csrf-token"]').attr('content');

    $(loader).addClass('loaderDisplay');

    $.post(deleteURL,
        {'_token': token, 'data': {'id': id, 'path': path}},
        function(data, status) {

            $(loader).removeClass('loaderDisplay');
            if (status === 'success') {

                if (data === 'ok') {
                    $(elmt).closest('.image-container').remove();
                }

            } else {
                console.log(html);
            }
        }
    )
}