
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
            selectedRaion : [],
            selectedLocality : [],
            checkedRaion : [],
            dbOptions : [],
            urlLocallity : [],

        },
    components: {
        vSelect,
    },

    methods: {
        getOptions(search, loading) {
            loading(true)
            axios.get('http://iban.test/api/locality/40')
                .then(response => {
                    this.options = response.data.items
                    loading(false)
                });
        }
    },

    mounted () {
        axios.get('http://iban.test/api/locality/41')
            .then(r => {
                    // var formatted = []
                    this.selectedLocality = r.data[0];
                    for (let i = 0; i < r.data.length; i++) {
                        this.dbOptions.push(r.data[i]);

                         // formatted[i] = { value: r.data[i].id, text: r.data[i].name }
                    }
                },
                error => {
                    console.error(error)
                }
            )
    }

});
