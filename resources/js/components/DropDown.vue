<template>
    <div class=".select2">
        <Dropdown
            :options="[ {!! $ecocod !!} ]"
            v-on:selected="validateSelection"
            v-on:filter="getDropdownValues"
            :disabled="false"
            :maxItem="500"
            placeholder="Selectați vă rog opționea">
        </Dropdown>
    </div>
</template>

<script>
    import Dropdown from 'vue-simple-search-dropdown';
</script>
