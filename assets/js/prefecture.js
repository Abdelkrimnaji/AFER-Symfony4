//require jQuery normally
const $ = require('jquery');
global.$ = global.jQuery = $;
require('../js/popUp.js');
require('../../vendor/eternicode/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
require('../../vendor/eternicode/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js');

const onclickPrefecture = document.querySelector('.onclick_prefecture');

const purpleArrow = document.querySelector('.angle_purple');

const myDropdownMenu4 = document.querySelector('.list_prefectures');

const activePrefectureList = document.querySelector('.active_prefecture_liste');
const activePrefectureAutorite = document.querySelector('.active_prefecture_autorite');
const activePrefectureService = document.querySelector('.active_prefecture_service');

let purpleArrowValue = 0;

let url = document.URL;
let pathname = new URL(url).pathname;

window.onload = changeActiveButton();

onclickPrefecture.addEventListener('click', function(){
    if(purpleArrowValue == 0){
        purpleArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu4.style.display = 'block';
        myDropdownMenu4.style.opacity = '1';
        purpleArrowValue = 1;
    }
    else{
        purpleArrow.style.transform = 'rotate(0deg)';
        myDropdownMenu4.style.display = 'none';
        myDropdownMenu4.style.opacity = '0';
        purpleArrowValue = 0;
    }
})

function changeActiveButton(){

    if (pathname == '/admin/prefecture') {
        purpleArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu4.style.display = 'block';
        myDropdownMenu4.style.opacity = '1';
        activePrefectureList.style.color = '#9c2db3';
        activePrefectureList.style.fontWeight = 'bold';
        purpleArrowValue = 1;
    }

    if (pathname == '/admin/prefecture/autorite') {
        purpleArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu4.style.display = 'block';
        myDropdownMenu4.style.opacity = '1';
        activePrefectureAutorite.style.color = '#9c2db3';
        activePrefectureAutorite.style.fontWeight = 'bold';
        purpleArrowValue = 1;
    }

    if (pathname == '/admin/prefecture/service') {
        purpleArrow.style.transform = 'rotate(90deg)';
        myDropdownMenu4.style.display = 'block';
        myDropdownMenu4.style.opacity = '1';
        activePrefectureService.style.color = '#9c2db3';
        activePrefectureService.style.fontWeight = 'bold';
        purpleArrowValue = 1;
    }
}