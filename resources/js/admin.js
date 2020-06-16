
require('./bootstrap');

window.Vue = require('vue');
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
};

Vue.component('v-select', vSelect);

import VueSimpleAlert from "vue-simple-alert";
import axios from "axios"
import vSelect from 'vue-select';
import { loadProgressBar } from 'axios-progress-bar';
import VueAxios from 'vue-axios';
import axiosRetry from 'axios-retry';


Vue.use(VueSimpleAlert);
Vue.use(VueAxios, axios)

axiosRetry(axios, { retryDelay: axiosRetry.exponentialDelay});

const admin = new Vue({
    el: '#iban',
    props: ['myProps'],
    data:
        {
            selectedRaion :   [],   // binded v-model for selected Raion
            selectedLocality :[],   // binded v-model for selected Locality
            selectedEcocod :  [],   // binded v-model for Economic cod
            optionsEcocod :   [],
            raionOptions :    [],
            localityOptions : [],
            IbanOptions :     [],
            IbanResponce:     [],
            IbanId: [],
            ifVisible : true,
            alertBox : false,
            checkEd : false,
            statusOnPress: '',
            IbanSearch: [],
        },


    components: {
        vSelect,

    },

    methods: {
        getOptions() {
            this.ifVisible = true;
            this.localityOptions = [];
            loadProgressBar();

            axios.get('/api/locality/'+this.getIdRaion())
                .then(response => {
                    this.selectedLocality = response.data[0];
                        for (let i = 0; i < response.data.length; i++)
                        {
                            this.localityOptions.push(response.data[i])
                        }
                })
                .catch(error => {
                    this.$alert(error.response);
                    this.IbanResponce = '';
                    console.log(error.response);
                })
            },

        checkIban(){
          if(this.IbanOptions)  this.ifVisible = true;
        },

         getIban() {
            this.ifVisible = true;
            loadProgressBar();
            var url = '/api/get_iban?token=' +
                api_token + '&ecocod=' +
                this.selectedEcocod.id  + '&raion=' +
                this.selectedRaion.name + '&locality=' +
                this.selectedLocality.id;

             axios.get(url)
                .then(response => {
                    this.IbanResponce = response.data;
                    console.log(response);
                })
                .catch(error => {
                    this.$alert("Iban nu a fost gasit!");
                    this.IbanResponce = '';
                    console.log(error.response);
                });
        },

        async getIbanId()
        {
            var url = '/api/get_iban_id?token=' +
                api_token + '&ecocod=' +
                this.selectedEcocod.id  + '&raion=' +
                this.selectedRaion.name + '&locality=' +
                this.selectedLocality.id;
            loadProgressBar();

             await
                axios.get(url)
                .then(response => {
                    this.IbanId = response.data;
                    console.log(response);
                    return true
                })
                .catch(error => {
                    this.statusOnPress = error.response.statusText;
                    console.log(error.response);
                    return false
                });
        },

        async postIban(){
            if (this.checkEd === false)
            {
                    var url = '/api/add_iban?token=' + api_token
                        + '&iban=' + this.IbanResponce;
                    loadProgressBar();

                    this.axios.post(url, {
                        'axios-retry': {
                            retries: 3
                        }})
                        .then(response => {
                            this.statusOnPress = response.data;
                            console.log(response.data)
                            this.$alert(response.data + ' : Iban a fost adaugat cu succeses. ', 'Succes!', 'success');

                        })
                        .catch(error => {
                            this.statusOnPress = error.response.statusText;
                            console.log(error.response);
                            console.log('Checkbox status = ' + this.checkEd);
                            this.$alert(error.response.data + error.response.statusText, 'Atenție', "warning");
                        });
            }
             else {
                // Get ID from Selected options

                this.getIbanId();

                //mothod PUT post

                var url = '/api/put_iban/' + this.IbanId+
                               '?token='   + api_token
                             + '&iban='    + this.IbanResponce;
                loadProgressBar();

                axios.put(url)
                    .then(response => {
                        this.statusOnPress = response.data;
                        console.log(response.data + ' : Iban a fost modificat cu succeses. ');
                        this.$alert(response.data + ' : Iban a fost modificat cu succeses. ','Succes!','success');

                    })
                    .catch(error => {
                        this.statusOnPress = error.response.statusText;
                        console.log(error.response.statusText);
                        console.log('Checkbox status = ' + this.checkEd);
                        this.$alert(error.response.data + error.response.statusText,'Atenție', "warning");
                    });
             }
            this.IbanResponce = []; // v-model for input
        },

        // Delete Iban from database
        async deleteIban(){
            const [requestIban] = await Promise.all([
                this.getIbanId()
            ]);

            var url = '/api/delete_iban/'
                + this.IbanId
                + '?token=' + api_token;
            loadProgressBar();

            axios.delete(url)
                .then(response => {
                    this.statusOnPress = response.data;
                    console.log(response);
                    this.$alert(response.data + ' : Iban a fost șters cu succeses. ', 'Succes!', 'success');

                })
                .catch(error => {
                    this.statusOnPress = error.response.statusText;
                    console.log(error.response.statusText);
                    this.$alert(error.response.data + ' - Inceracti mai tirziu','Atenție', "warning");
                });
            this.IbanResponce = [];
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
        loadProgressBar();
            axios.get('/api/raion')
                .then(r => {
                        this.selectedRaion = r.data[0];
                        for (let i = 0; i < r.data.length; i++) {
                            this.raionOptions.push(r.data[i]);
                        }
                    },
                    error => {
                        console.error(error)
                    }
            ),

            //  get data for "selectedLocality" model
            axios.get('/api/locality/1')
                .then(r => {
                        // var formatted = []
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
