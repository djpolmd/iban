<!--<v-select :options="books" label="title" v-model="selected">-->
    <template #search="{attributes, events}">
        <input
            class="vs__search"
            :required="!selected"
            v-bind="attributes"
            v-on="events"
        />
    </template>
<!--</v-select>-->

<style>
export default {
    mounted() {
        console.log('Component vSelect mounted.')
        }
    }
</style>
