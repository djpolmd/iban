
require('./bootstrap');

window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// import  DropDown  from './components/DropDown.vue';
Vue.component('v-select', vSelect)

import Dropdown from 'vue-simple-search-dropdown';
import vSelect from 'vue-select';

const app = new Vue({
    el: '#app',

    components: {
        Dropdown,
        vSelect,
    },

    methods: {

        selectChange: function () {
            console.log(this.selectedProduct);
            //do futher processing

        },
    }

});
