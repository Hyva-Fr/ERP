const hider = document.querySelector('#hider');

if (hider) {

    window.print();
    window.onafterprint = function(){
        window.close();
    }
}