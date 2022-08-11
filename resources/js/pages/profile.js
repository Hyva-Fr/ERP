const picTrigger = '#pic-trigger';
const inputFile = '#file-trigger';
const filePreview = '#profile-avatar-preview';
const input = '#user-avatar';
const deleteAvatar = '#delete-avatar';
const submits = '.profile-container button[type="submit"]';
const loader = '#loader';

$(document).ready(function(){

    setEvents();
});

function setEvents() {

    $(picTrigger).on('click', function(){
        $(inputFile).click();
    });

    $(inputFile).on('change', function(){
        previewFile(this);
    });

    $(deleteAvatar).on('click', function(){
        replaceByDefault();
    });

    $(submits).on('click', function(e){
        e.preventDefault();
        ajaxSubmit(this)
    });
}

function previewFile(elmt) {

    let file = $(elmt).get(0).files[0];
    if (file) {

        let reader = new FileReader();
        reader.onload = function(){
            $(input).val(reader.result);
            $(filePreview).css({'background-image': 'url("' + reader.result + '")'})
        }
        reader.readAsDataURL(file);
    }
}

function replaceByDefault() {

    let data = $(deleteAvatar).data('url');
    $(input).val('');
    $(filePreview).css({'background-image': 'url("' + data + '")'});
    $(inputFile).val(null);
}

function ajaxSubmit(elmt) {

    let form = $(elmt).closest('form'),
        method = $(form).attr('method'),
        action = $(form).attr('action'),
        data = {};

    $(loader).addClass('loaderDisplay');

    $.each(form.serializeArray(), function(i, field) {
        let ins = $('input[name=' + field.name + ']');
        if (field.name) {
            data[field.name] = $.trim(field.value)
        }
    })

    $.ajax({
        url: action,
        method: method,
        data: data,
        success: function (html) {

            $(loader).removeClass('loaderDisplay');
            $('[action="' + action + '"]').replaceWith($(html).find('[action="' + action + '"]'));
            setEvents();
        },
        error: function(error) {

            $(loader).removeClass('loaderDisplay');
            if (isJson(error.responseText)) {

                error = JSON.parse(error.responseText);
                let errosContainer = $('[action="' + action + '"] .errors-container');

                let html = '<p class="partials error">' +  error.message + '</p>';
                html += '<ul class="partials errors-list">';

                for (const key in error.errors) {

                    html += '<li class="error">' + key.replaceAll('_', ' ') + ':<ul>';
                    let errs = error.errors[key];
                    for (let i = 0; i < errs.length; i++) {
                        html += '<li class="error">' + errs[i] + '</li>'
                    }
                    html += '</ul></li>';
                }
                html += '</ul>';
                errosContainer.html(html);
            }
        }
    });
}

function isJson(str) {

    try {
        JSON.parse(str);
        return true;
    } catch {
        return false;
    }
}