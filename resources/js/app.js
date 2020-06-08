
require('./bootstrap');

window.Vue = require('vue');

Vue.component('v-select', vSelect);

import axios from "axios"

import vSelect from 'vue-select';

const app = new Vue({
    el: '#iban',

    data:
        {
            selectedRaion :   [],   // binded v-model for selected Raion
            selectedLocality :[],   // binded v-model for selected Locality
            selectedEcocod :  [],   // binded v-model for Economic cod
            optionsEcocod :   [],
            raionOptions :    [],
            localityOptions : [],
            IbanOptions :     [],
            ifVisible : false,
            alertBox : false,
        },
    components: {
        vSelect,
    },

    methods: {
        getOptions() {
            this.ifVisible = true;
            this.localityOptions = [];
            axios.get('/api/locality/'+this.getIdRaion())
                .then(response => {
                    this.selectedLocality = response.data[0];
                    for (let i = 0; i < response.data.length; i++) {
                        this.localityOptions.push(response.data[i]);
                    }
                },

                error => {
                    console.error(error)
                     this.alertBox = true;
                 }
            )},

        checkIban(){
          if(this.IbanOptions)  this.ifVisible = true;
        },

        getIban() {
            this.ifVisible = true;

            var url = '/api/get_iban_operator?token=' +
                api_token + '&ecocod=' +
                this.selectedEcocod.id  + '&raion=' +
                this.selectedRaion.name + '&locality=' +
                this.selectedLocality.id;

            axios.get(url)
                .then(response => {
                    this.options = response.data.items;
                error => {
                    console.error(error)
                    this.alertBox = true;
                    }
            });

        },
        //  Getters for ID
        getIdEcocod(){
            return this.selectedEcocod.id;
        },

        getIdRaion(){
            return this.selectedRaion.id;
        },

        getIdLocality(){
            return this.selectedLocality.id;
        }

    },

    mounted () {
            axios.get('/api/raion_operator?token='+api_token)
                .then(r => {
                        this.selectedRaion = r.data;
                            this.raionOptions.push(r.data);

                    },
                    error => {
                        console.error(error)
                    }
            ),

            //  get data for "selectedLocality" model
            axios.get('/api/locality_operator?token='+api_token)
                .then(r => {
                        this.selectedLocality = r.data[0];
                        for (let i = 0; i < r.data.length; i++) {
                            this.localityOptions.push(r.data[i]);
                        }
                    },
                    error => {
                        console.error(error)
                    }
                ),

            axios.get('/api/ecocod')
                .then(r => {
                        this.selectedEcocod = r.data[0];
                        for (let i = 0; i < r.data.length; i++) {
                            this.optionsEcocod.push(r.data[i]);
                        }
                    },
                    error => {
                        console.error(error)
                    }
                )
    }

});
