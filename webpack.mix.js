// Simplicity is the ultimate sophistication

let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/db/iban_2020.csv', 'public/csv/iban_2020.csv');

