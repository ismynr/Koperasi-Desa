require('./bootstrap');

import Alpine from 'alpinejs';
import $ from 'jquery';
window.$ = window.jQuery = $;

require( '../../node_modules/datatables.net/js/jquery.dataTables.js' );
require( '../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js' );

window.Alpine = Alpine;

Alpine.start();