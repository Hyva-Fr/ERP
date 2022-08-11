const blocks = '.refs-block';
const formHidden = '[name="form"]';
const addBtns = '.new-block';
const removeBtns = '.remove-block';
const buildBlock = '.build-block';
const buildBlockSpecial = '.build-block.special';
const editBlock = '.edit-block';
const lastBlock = '#last-block';
const headerType = '[name="header-format"]:checked';
const contentType = '[name="content-format"]:checked';
const footerType = '[name="footer-format"]:checked';
const closeFormEdit = '.close-form-edit';
const allBlocks = '.build-block:not(#last-block)';
const formEditor = '#form-editor';
const buildSpecials = '.build-block.special';
const refsEditor = '#refs-editor';
const dataStart = '.build-block.special[data-type="start"]';
const dataEnd = '.build-block.special[data-type="end"]';
const start = {type: "constructor"};
const end = {type: "constructor"};
const radiosBtns = '.form-builder .with-font';
const saveBtn = '#saveContent';
const submitBtn = '.form-submit';
const formForm = '.form-crud';
const addOpt = '#add-opt';
const urls = {
    "header": '/storage/media/templates/form/header/',
    "content": '/storage/media/templates/form/content/',
    "footer": '/storage/media/templates/form/footer/'
}
let form = (document.querySelector(formHidden)) ? JSON.parse(document.querySelector(formHidden).value) : null;

$(document).ready(function(){

    if ($(blocks)) {
        setRadioBtns();
        setForm(true);
        setBlockTransfert();
        onSubmitForm();
    }
});

function onSubmitForm() {

    $(submitBtn).on('click', function(e){
        e.preventDefault();
        let form = $(this).closest(formForm),
            blocks = $(buildBlock),
            submit = false;

        if (blocks.length > 1) {
            let last = $(blocks)[$(blocks).length - 2];
            submit = $(last).data('type') === 'end';
        }

        if (submit === false) {
            let message = $(refsEditor).data('endform');
            setWarningModal(message);
        } else {
            $(form).submit();
        }
    });
}

function setForm(init = false) {

    if (init === false) {

        form.header = $(headerType).val();
        form.main.format = $(contentType).val();
        form.footer = $(footerType).val();
        let blocks = $(buildBlock);
        let content = [];
        for (let i = 0; i < blocks.length; i++) {
            if (blocks[i].dataset.info) {
                content.push(blocks[i].dataset.info);
            }
        }
        form.main.content = content;
        $(formHidden).val(JSON.stringify(form));

    } else {

        setFormFromData();
    }
}

function setFormFromData() {
    
    if (form && document.querySelector('.form-edit-crud')) {

        let content = form.main.content,
            replacer = [];
        for (let i = 0; i < content.length; i++) {
            replacer.push(JSON.parse(content[i]));
        }

        form.main.content = replacer;

        for (let i = 0; i < replacer.length; i++) {

            let newBlock = replacer[i];

            if (newBlock.data !== 'start' && newBlock.data !== 'end') {
                classes = 'build-block';
            } else {
                classes = 'build-block special';
            }

            let pen = (newBlock.data !== 'end') ? '<i class="fa-solid fa-pen-to-square fa-lg fa-fw edit-block" data-json=\'' + JSON.stringify(newBlock) + '\'></i>' : '';
            let div = document.createElement('div');
            div.setAttribute('class', classes);
            div.dataset.type = newBlock.data;
            if (newBlock.message !== null) {
                div.dataset.message = newBlock.message;
            }
            div.dataset.info = JSON.stringify(newBlock);
            div.setAttribute('style', 'background-color: ' + newBlock.color + ';')
            let html = '<div><p class="block-title">' + newBlock.title + pen + '</p><small>' + newBlock.small + '</small></div><i class="fa-solid fa-circle-minus fa-lg fa-fw remove-block"></i>';
            div.innerHTML = html;
            let container = document.querySelector(formEditor),
                lastElement = document.querySelector(lastBlock);
            container.insertBefore(div, lastElement);

            setNewBlocksListeners(div);
            orderingBlocks();
        }

        $('[name="header-format"][value="' + form.header + '"]').click();
        $('[name="content-format"][value="' + form.main.format + '"]').click();
        $('[name="footer-format"][value="' + form.footer + '"]').click();
    }
}

function setBlockTransfert() {

    $(addBtns).on('click', function(){

        let data = $(this).data('json'),
            title = $(this).data('title'),
            small = $(this).data('small'),
            mess = $(this).data('message'),
            info = $(this).data('info'),
            blocks = $(buildSpecials),
            actualBlocks = $(buildBlock),
            startMessage = $(refsEditor).data('message'),
            newBlock = null,
            classes = null;

        if (blocks.length < 1 && data !== 'start') {
            setWarningModal(startMessage);
            return false
        }

        if (data === 'start' || data === 'end') {
            let message = checkConstructionContainers(data);
            if (message !== null) {
                setWarningModal(message.replaceAll("|", "'"))
                return false;
            }
        }

        if (data !== 'start' && data !== 'end') {
            if (actualBlocks[actualBlocks.length-2] && actualBlocks[actualBlocks.length-2].dataset.type === 'end') {
                setWarningModal(startMessage);
                return false
            }
            newBlock = formsTypes.options[data];
            newBlock.color = 'var(--yellow)';
            classes = 'build-block';
        } else {
            newBlock = (data === 'start') ? start : end;
            newBlock.color = (data === 'start') ? 'steelblue' : 'mediumpurple';
            if (data === 'start') {
                newBlock.options = info.options;
            }
            classes = 'build-block special';
        }
        newBlock.label = title;
        newBlock.small = small;
        if (data === 'end') {
            newBlock.data = 'end';
            newBlock.title = 'End section';
        }

        let pen = (data !== 'end') ? '<i class="fa-solid fa-pen-to-square fa-lg fa-fw edit-block" data-json=\'' + JSON.stringify(newBlock) + '\'></i>' : '';
        let div = document.createElement('div');
        div.setAttribute('class', classes);
        div.dataset.type = data;
        if (mess !== undefined) {
            div.dataset.message = mess;
        }
        div.dataset.info = JSON.stringify(newBlock);
        div.setAttribute('style', 'background-color: ' + newBlock.color + ';')
        let html = '<div><p class="block-title">' + newBlock.label + pen + '</p><small>' + newBlock.small + '</small></div><i class="fa-solid fa-circle-minus fa-lg fa-fw remove-block"></i>';
        div.innerHTML = html;
        let container = document.querySelector(formEditor),
            lastElement = document.querySelector(lastBlock);
        container.insertBefore(div, lastElement);

        setNewBlocksListeners(div);
        orderingBlocks();
        setForm();
        $(div).find(editBlock).click();
        return true;
    });
}

function checkConstructionContainers(data) {

    let blocks = $(buildSpecials);
    if (blocks.length > 0) {
        let last = $(blocks[blocks.length - 1]);
        if (last) {
            let type = last.data('type'),
                message = last.data('message');
            if (data === type) {
                return message;
            } else {
                return null;
            }
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function orderingBlocks() {

    let all = $(allBlocks);
    for (let i = 0; i < all.length; i++) {
        all[i].dataset.order = i+1;
    }
}

function setNewBlocksListeners(div) {

    $(div).find(removeBtns).on('click', function(){

        let type = $(div).data('type'),
            possibleNext = false;
        if (type === 'end') {

            let next = div.nextElementSibling;
            if (next && next.dataset.type === 'start') {
                $(next).remove();
            }

        } else if (type === 'start') {

            let previous = div.previousElementSibling;
            if (previous && previous.dataset.type === 'end') {
                $(previous).remove();
            } else if (!previous) {
                let next = getNextSibling(div, buildBlock);
                if (next) {
                    setWarningModal($(refsEditor).data('delete'));
                    possibleNext = true;
                }
            }
        }
        if (possibleNext === false) {
            $(this).closest(buildBlock).remove();
            setForm();
            orderingBlocks();
        }
    });

    $(div).find(editBlock).on('click', function(){

        let json = $(this).data('json');
        let persist = JSON.parse(this.dataset.json);
        let parent = this.closest('.build-block');
        let div = document.createElement('div');
        div.setAttribute('class', 'modal-container');
        div.setAttribute('id', 'form-type-edit');
        let html = '<div class="modal">';
        html += '<div class="modal-title">';
        html += '<h4>' + persist.label + '</h4>'
        html += '<i class="fa-solid fa-xmark fa-lg fa-fw close-form-edit"></i>';
        html += '</div>';
        html += '<div class="modal-content">';
        html += '<div class="modal-full">';
        html += setFormModalContent(json);
        html += '<button class="btn yellow" style="margin: 0 auto 10px;" type="button" id="saveContent">Save</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        div.innerHTML = html;
        div.dataset.order = this.closest('.build-block').dataset.order;
        document.body.appendChild(div);

        $(addOpt).on('click', function(){
            let opts = this.parentElement.querySelectorAll('.opts');
            for (let i = 0; i < opts.length; i++) {
                let minus = opts[i].querySelector('.remove-opt');
                if (minus) {
                    minus.parentElement.removeChild(minus);
                }
            }
            let label = document.createElement('label');
            label.setAttribute('class', 'form-control opts');
            label.innerHTML = '<span>Option ' + (opts.length+1) + '</span><i class="fa-solid fa-circle-minus fa-lg fa-fw remove-opt"></i><input class="get-data" name="options[]" type="text"/>';
            this.parentElement.insertBefore(label, this.parentElement.children[this.parentElement.children.length-1]);

            $('.remove-opt').on('click', function (){
                removeOptions(this);
            });
        });

        $(saveBtn).on('click', function(){
            let inputs = this.closest('.modal-full').querySelectorAll('.get-data');
            let options = [];
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].name === 'options[]') {
                    options.push(inputs[i].value)
                } else {
                    json[inputs[i].name] = inputs[i].value
                }
            }
            if (options.length > 0) {
                json.options = options;
            }
            json.title = persist.label;
            json.message = (parent.dataset.message) ? parent.dataset.message.replaceAll("'", "|") : null;
            json.data = parent.dataset.type;
            parent.dataset.info = JSON.stringify(json);
            setForm();
            $(closeFormEdit).click();
        });

        $(closeFormEdit).on('click', function(){
            div.classList.remove('displayEditor');
            setTimeout(function(){
                div.remove();
            }, 250);
        });

        setTimeout(function(){
            div.classList.add('displayEditor');
        }, 50);
    });
}

function removeOptions(elmt) {

    let lab = elmt.closest('label');
    let parent = elmt.closest('.modal-full');
    lab.parentElement.removeChild(lab);
    let os = parent.querySelectorAll('.opts');
    if (os.length > 1) {
        let last = os[os.length-1];
        let i = document.createElement('i');
        i.setAttribute('class', 'fa-solid fa-circle-minus fa-lg fa-fw remove-opt');
        last.insertBefore(i, last.children[1]);

        $(i).on('click', function(){
            removeOptions(this)
        })
    }
}

function getNextSibling (elem, selector) {

    let sibling = elem.nextElementSibling;

    while (sibling) {
        if (sibling.matches(selector) && sibling.id !== 'last-block') {
            return true;
        }
        sibling = sibling.nextElementSibling
    }
    return null;
};

function setFormModalContent(json) {

    let html = '';
    if (json.type === 'constructor') {
        html += '<label class="form-control"><span>Form title</span><input class="get-data" name="label" type="text" value="' + json.label + '"/></label>';
    } else {
        if (json.name === 'options') {
            html += '<label class="form-control"><span>Content</span><textarea class="get-data" name="content" >' + json.content + '</textarea></label>';
        } else {
            html += '<label class="form-control"><span>Label</span><input class="get-data" name="label" type="text" value="' + json.label + '"/></label>';
        }
        if (json.type === 'number') {
            html += '<label class="form-control"><span>Unit</span><input class="get-data" name="unit" type="text" value="' + json.unit + '"/></label>';
        }
        if (json.multiple === true) {
            html += '<button id="add-opt" type="button" class="btn">Add</button>';
            if (json.options.length === 0) {
                html += '<label class="form-control first-opt opts"><span>Option 1</span><input class="get-data" name="options[]" type="text"/></label>';
            } else {
                for (let i = 0; i < json.options.length; i++) {
                    let first = (i === 0) ? ' first-opt ' : ' ';
                    html += '<label class="form-control' + first + 'opts"><span>Option ' + (i+1) + '</span><input class="get-data" name="options[]" type="text" value="' + json.options[i] + '"/></label>';
                }
            }
        }
    }

    return html;
}

function setWarningModal(message) {

    let div = document.createElement('div');
    div.setAttribute('class', 'modal-container');
    div.setAttribute('id', 'form-type-edit');
    let html = '<div class="modal">';
    html += '<div class="modal-content">';
    html += '<div class="modal-full">';
    html += '<i class="red warning-message">' + message + '</i>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    div.innerHTML = html;
    document.body.appendChild(div);

    setTimeout(function(){
        div.classList.add('displayEditor');
    }, 50);

    setTimeout(function(){
        div.classList.remove('displayEditor');
    }, 3000)

    setTimeout(function(){
        div.remove();
    }, 3250);
}

function setRadioBtns() {

    let btns = $(radiosBtns);
    for (let i = 0; i < btns.length; i++) {
        let btn = btns[i],
            bg = $(btn).closest('.creator-formats').find('.split-preview'),
            id = $(bg).attr('id').replace('-pic-preview', '');
        $(btn).on('input', function(){
            setForm();
            $(bg).css({'background-image': 'url("' + urls[id] + this.value + '.jpg")'})
        });
    }
}