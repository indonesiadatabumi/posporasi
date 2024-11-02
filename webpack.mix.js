const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// vendor css
mix.styles([
	'node_modules/animate.css/animate.min.css',
	'node_modules/@fortawesome/fontawesome-free/css/all.min.css',
	'node_modules/jquery-ui-dist/jquery-ui.min.css',
	'node_modules/pace-js/themes/black/pace-theme-flash.css',
	'node_modules/perfect-scrollbar/css/perfect-scrollbar.css'
], 'public/assets/css/vendor.min.css');
mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/', 'public/assets/webfonts/');


// core css
var theme = 'default';
mix.sass('resources/scss/'+ theme +'/styles.scss', 'public/assets/css/app.min.css');
mix.copy('resources/scss/'+ theme +'/images/', 'public/assets/css/images/');


// vendor js
mix.combine([
	'node_modules/pace-js/pace.min.js',
	'node_modules/jquery/dist/jquery.min.js',
	'node_modules/jquery-ui-dist/jquery-ui.min.js',
	'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
	'node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js',
	'node_modules/js-cookie/dist/js.cookie.js'
], 'public/assets/js/vendor.min.js');


// core js
mix.combine([
	'resources/js/app.js'
], 'public/assets/js/app.min.js');


// demo js
mix.copy(['resources/js/demo/'], 'public/assets/js/demo/');

  	
// plugins
mix.copy('node_modules/@fortawesome', 'public/assets/plugins/@fortawesome');
mix.copy('node_modules/@fullcalendar', 'public/assets/plugins/@fullcalendar');
mix.copy('node_modules/@highlightjs', 'public/assets/plugins/@highlightjs');
mix.copy('node_modules/abpetkov-powerange', 'public/assets/plugins/abpetkov-powerange');
mix.copy('node_modules/angular', 'public/assets/plugins/angular');
mix.copy('node_modules/angular-ui-bootstrap', 'public/assets/plugins/angular-ui-bootstrap');
mix.copy('node_modules/angular-ui-router', 'public/assets/plugins/angular-ui-router');
mix.copy('node_modules/animate.css', 'public/assets/plugins/animate.css');
mix.copy('node_modules/apexcharts', 'public/assets/plugins/apexcharts');
mix.copy('node_modules/blueimp-file-upload', 'public/assets/plugins/blueimp-file-upload');
mix.copy('node_modules/blueimp-gallery', 'public/assets/plugins/blueimp-gallery');
mix.copy('node_modules/blueimp-canvas-to-blob', 'public/assets/plugins/blueimp-canvas-to-blob');
mix.copy('node_modules/blueimp-load-image', 'public/assets/plugins/blueimp-load-image');
mix.copy('node_modules/blueimp-tmpl', 'public/assets/plugins/blueimp-tmpl');
mix.copy('node_modules/bootstrap', 'public/assets/plugins/bootstrap');
mix.copy('node_modules/bootstrap-datepicker', 'public/assets/plugins/bootstrap-datepicker');
mix.copy('node_modules/bootstrap-daterangepicker', 'public/assets/plugins/bootstrap-daterangepicker');
mix.copy('node_modules/bootstrap-datetime-picker', 'public/assets/plugins/bootstrap-datetime-picker');
mix.copy('node_modules/bootstrap-icons', 'public/assets/plugins/bootstrap-icons');
mix.copy('node_modules/bootstrap-social', 'public/assets/plugins/bootstrap-social');
mix.copy('node_modules/bootstrap-timepicker', 'public/assets/plugins/bootstrap-timepicker');
mix.copy('node_modules/bootstrap3-wysihtml5-bower', 'public/assets/plugins/bootstrap3-wysihtml5-bower');
mix.copy('node_modules/chart.js', 'public/assets/plugins/chart.js');
mix.copy('node_modules/ckeditor', 'public/assets/plugins/ckeditor');
mix.copy('node_modules/clipboard', 'public/assets/plugins/clipboard');
mix.copy('node_modules/d3', 'public/assets/plugins/d3');
mix.copy('node_modules/datatables.net', 'public/assets/plugins/datatables.net');
mix.copy('node_modules/datatables.net-autofill', 'public/assets/plugins/datatables.net-autofill');
mix.copy('node_modules/datatables.net-autofill-bs5', 'public/assets/plugins/datatables.net-autofill-bs5');
mix.copy('node_modules/datatables.net-bs5', 'public/assets/plugins/datatables.net-bs5');
mix.copy('node_modules/datatables.net-buttons', 'public/assets/plugins/datatables.net-buttons');
mix.copy('node_modules/datatables.net-buttons-bs5', 'public/assets/plugins/datatables.net-buttons-bs5');
mix.copy('node_modules/datatables.net-colreorder', 'public/assets/plugins/datatables.net-colreorder');
mix.copy('node_modules/datatables.net-colreorder-bs5', 'public/assets/plugins/datatables.net-colreorder-bs5');
mix.copy('node_modules/datatables.net-fixedcolumns', 'public/assets/plugins/datatables.net-fixedcolumns');
mix.copy('node_modules/datatables.net-fixedcolumns-bs5', 'public/assets/plugins/datatables.net-fixedcolumns-bs5');
mix.copy('node_modules/datatables.net-fixedheader', 'public/assets/plugins/datatables.net-fixedheader');
mix.copy('node_modules/datatables.net-fixedheader-bs5', 'public/assets/plugins/datatables.net-fixedheader-bs5');
mix.copy('node_modules/datatables.net-keytable', 'public/assets/plugins/datatables.net-keytable');
mix.copy('node_modules/datatables.net-keytable-bs5', 'public/assets/plugins/datatables.net-keytable-bs5');
mix.copy('node_modules/datatables.net-responsive', 'public/assets/plugins/datatables.net-responsive');
mix.copy('node_modules/datatables.net-responsive-bs5', 'public/assets/plugins/datatables.net-responsive-bs5');
mix.copy('node_modules/datatables.net-rowreorder', 'public/assets/plugins/datatables.net-rowreorder');
mix.copy('node_modules/datatables.net-rowreorder-bs5', 'public/assets/plugins/datatables.net-rowreorder-bs5');
mix.copy('node_modules/datatables.net-scroller', 'public/assets/plugins/datatables.net-scroller');
mix.copy('node_modules/datatables.net-scroller-bs5', 'public/assets/plugins/datatables.net-scroller-bs5');
mix.copy('node_modules/datatables.net-select', 'public/assets/plugins/datatables.net-select');
mix.copy('node_modules/datatables.net-select-bs5', 'public/assets/plugins/datatables.net-select-bs5');
mix.copy('node_modules/datepickk', 'public/assets/plugins/datepickk');
mix.copy('node_modules/dropzone', 'public/assets/plugins/dropzone');
mix.copy('node_modules/flag-icon-css', 'public/assets/plugins/flag-icon-css');
mix.copy('node_modules/flot', 'public/assets/plugins/flot');
mix.copy('node_modules/gritter', 'public/assets/plugins/gritter');
mix.copy('node_modules/intro.js', 'public/assets/plugins/intro.js');
mix.copy('node_modules/ion-rangeslider', 'public/assets/plugins/ion-rangeslider');
mix.copy('node_modules/ionicons', 'public/assets/plugins/ionicons');
mix.copy('node_modules/isotope-layout', 'public/assets/plugins/isotope-layout');
mix.copy('node_modules/jquery', 'public/assets/plugins/jquery');
mix.copy('node_modules/jquery-knob', 'public/assets/plugins/jquery-knob');
mix.copy('node_modules/jquery-migrate', 'public/assets/plugins/jquery-migrate');
mix.copy('node_modules/jquery-mockjax', 'public/assets/plugins/jquery-mockjax');
mix.copy('node_modules/jquery-sparkline', 'public/assets/plugins/jquery-sparkline');
mix.copy('node_modules/jquery-ui-dist', 'public/assets/plugins/jquery-ui-dist');
mix.copy('node_modules/jquery.maskedinput', 'public/assets/plugins/jquery.maskedinput');
mix.copy('node_modules/js-cookie', 'public/assets/plugins/js-cookie');
mix.copy('node_modules/jstree', 'public/assets/plugins/jstree');
mix.copy('node_modules/jszip', 'public/assets/plugins/jszip');
mix.copy('node_modules/jvectormap-content', 'public/assets/plugins/jvectormap-content');
mix.copy('node_modules/jvectormap-next', 'public/assets/plugins/jvectormap-next');
mix.copy('node_modules/kbw-countdown', 'public/assets/plugins/kbw-countdown');
mix.copy('node_modules/lightbox2', 'public/assets/plugins/lightbox2');
mix.copy('node_modules/lity', 'public/assets/plugins/lity');
mix.copy('node_modules/masonry-layout', 'public/assets/plugins/masonry-layout');
mix.copy('node_modules/moment', 'public/assets/plugins/moment');
mix.copy('node_modules/nvd3', 'public/assets/plugins/nvd3');
mix.copy('node_modules/oclazyload', 'public/assets/plugins/oclazyload');
mix.copy('node_modules/pace-js', 'public/assets/plugins/pace-js');
mix.copy('node_modules/parsleyjs', 'public/assets/plugins/parsleyjs');
mix.copy('node_modules/pdfmake', 'public/assets/plugins/pdfmake');
mix.copy('node_modules/perfect-scrollbar', 'public/assets/plugins/perfect-scrollbar');
mix.copy('node_modules/photoswipe', 'public/assets/plugins/photoswipe');
mix.copy('node_modules/raphael', 'public/assets/plugins/raphael');
mix.copy('node_modules/select-picker', 'public/assets/plugins/select-picker');
mix.copy('node_modules/select2', 'public/assets/plugins/select2');
mix.copy('node_modules/simple-line-icons', 'public/assets/plugins/simple-line-icons');
mix.copy('node_modules/spectrum-colorpicker2', 'public/assets/plugins/spectrum-colorpicker2');
mix.copy('node_modules/summernote', 'public/assets/plugins/summernote');
mix.copy('node_modules/sweetalert', 'public/assets/plugins/sweetalert');
mix.copy('node_modules/swiper', 'public/assets/plugins/swiper');
mix.copy('node_modules/switchery', 'public/assets/plugins/switchery');
mix.copy('node_modules/tag-it', 'public/assets/plugins/tag-it');
mix.copy('node_modules/x-editable-bs4', 'public/assets/plugins/x-editable-bs4');