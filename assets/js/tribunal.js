//require jQuery normally
const $ = require('jquery');
global.$ = global.jQuery = $;
require('../js/popUp.js');
require('../../vendor/eternicode/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
require('../../vendor/eternicode/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js');

const onclickTribunaux = document.querySelector('.onclick_tribunaux');

const blueArrow = document.querySelector('.angle_blue');

const myDropdownMenu2 = document.querySelector('.list_tribunaux');

const activeTribunalList = document.querySelector('.active_tribunal_liste');
const activeTribunalAutorite = document.querySelector('.active_tribunal_autorite');
const activeTribunalService = document.querySelector('.active_tribunal_service');
const activeNatureInfraction = document.querySelector('.active_nature_infraction');

let blueArrowValue = 0;

let url = document.URL;
let pathname = new URL(url).pathname;

window.onload = changeActiveButton();

onclickTribunaux.addEventListener('click', function(){
    if(blueArrowValue == 0){
        blueArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu2.style.display = 'block';
        myDropdownMenu2.style.opacity = '1';
        blueArrowValue = 1;
    }
    else{
        blueArrow.style.transform = 'rotate(0deg)';
        myDropdownMenu2.style.display = 'none';
        myDropdownMenu2.style.opacity = '0';
        blueArrowValue = 0;
    }
})

function changeActiveButton(){

    if (pathname == '/admin/tribunal') {
        blueArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu2.style.display = 'block';
        myDropdownMenu2.style.opacity = '1';
        activeTribunalList.style.color = '#4098f3';
        activeTribunalList.style.fontWeight = 'bold';
        blueArrowValue = 1;
    }

    if (pathname == '/admin/tribunal/autorite') {
        blueArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu2.style.display = 'block';
        myDropdownMenu2.style.opacity = '1';
        activeTribunalAutorite.style.color = '#4098f3';
        activeTribunalAutorite.style.fontWeight = 'bold';
        blueArrowValue = 1;
    }

    if (pathname == '/admin/tribunal/service') {
        blueArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu2.style.display = 'block';
        myDropdownMenu2.style.opacity = '1';
        activeTribunalService.style.color = '#4098f3';
        activeTribunalService.style.fontWeight = 'bold';
        blueArrowValue = 1;
    }
    if (pathname == '/admin/nature_infraction') {
        blueArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu2.style.display = 'block';
        myDropdownMenu2.style.opacity = '1';
        activeNatureInfraction.style.color = '#4098f3';
        activeNatureInfraction.style.fontWeight = 'bold';
        blueArrowValue = 1;
    }
    
}