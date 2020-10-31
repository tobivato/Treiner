/**
 * First we will load all of this project's JavaScript dependencies.
 */
window.baseUrl = window.location.protocol + "//" + location.host.split(":")[0] + "/";

require('./bootstrap');

window.places = require('places.js/index');

require('./copyable');

require('./stripe');

require('./places');

require('./custom-file');

require('./select2');

require('./maxchars');

require('./showhide');

require('./polyfill');

require('./modals');

require('./tooltip');

require('./signup-complete');