import 'date-input-polyfill/date-input-polyfill.scss';
import Input from 'date-input-polyfill/input';

window.dateInput = Input;

var supports_time = require('time-input-polyfill/core/helpers/supportsTime')
var loadJS = require('time-input-polyfill/core/helpers/loadJS')

document.addEventListener('DOMContentLoaded', checkTimeSupport());  

$(document).on('ModalLoad', checkTimeSupport);

document.addEventListener(`DOMContentLoaded`, () => {
    addPickers();
});

function addPickers() {    
    Input.addPickerToOtherInputs();
    // Check if type="date" is supported.
    if(!Input.supportsDateInput()) {
      Input.addPickerToDateInputs();
    }
};

function checkTimeSupport() {    
    if (!supports_time) {
      loadJS(
        'https://cdn.jsdelivr.net/npm/time-input-polyfill@1.0.9/dist/time-input-polyfill.min.js',
        function() {
          var $inputs = [].slice.call(
            document.querySelectorAll('input[type="time"]')
          )
          $inputs.forEach(function($input) {
            new TimePolyfill($input)
          })
        }
      )
    }
}