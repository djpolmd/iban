
require('./bootstrap');

window.Vue = require('vue');

// Vue.component('v-select', require('vue-select'));
// import vSelect  from './components/vSelect.vue';
Vue.component('v-select', vSelect);

import axios from "axios"
// import vSelect from 'vue-select'

// import StButton from "./components/Stbutton";
import vSelect from 'vue-select';

const app = new Vue({
    el: '#iban',

    data:
        {
            selected : [],
            checkedRaion : [],
        },
    components: {
        vSelect,
    },

    methods: {
        getOptions(search, loading) {
            loading(true)
            axios.get('/api/raion/1')
                .then(response => {
                    this.options = response.data.items
                    loading(false)
                });
        }
    }

});
