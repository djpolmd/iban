
require('./bootstrap');

window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// import  DropDown  from './components/DropDown.vue';
import Dropdown from 'vue-simple-search-dropdown';

const app = new Vue({
    el: '#app',

    components: {
        Dropdown
    }

});
