<!--<v-select :options="options" label="title" v-model="selected">-->
    <template #search="{attributes, events}">
        <v-select
            :items="dbOptions"
            v-model="dbSelect"
            label="Select"
            single-line
            item-text="name"
            item-value="id"
        ></v-select>
    </template>
<!--</v-select>-->


<script>
    import axios from 'axios'
    import vSelect from 'vue-select';

    export default {
        name: 'vueSelect',
        data () {
            return {
                dbSelect: '',
                dbOptions: [],
            }
        },
        mounted () {
            axios.get('http://iban.test/api/raion/1')
                .then(r => {
                        // var formatted = []
                        for (let i = 0; i < r.data.length; i++) {
                            this.dbOptions.push(r.data[i])
                            // formatted[i] = { value: r.data[i].id, text: r.data[i].name }
                        }
                    },
                    error => {
                        console.error(error)
                    }
                )
        }
    }
</script>
