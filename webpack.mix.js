// Simplicity is the ultimate sophistication

let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    // .extract(['vue'])
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/db/iban_2020.csv', 'public/csv/iban_2020.csv');
    //  .copy('node_modules/vue-multiselect/lib/vue-multiselect.min.js', 'public/js/vue-multiselect.min.js');
