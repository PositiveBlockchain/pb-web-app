<template>
    <div id="map-category-filter">
        <div class="filter-buttons">
            <button type="button" v-for="category in categories" v-on:click.prevent="selectCategory(category)"
                    class="p-2 m-1 rounded hover:bg-green-500 hover:text-white"
                    :class="[isSelected(category) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600', '']">
                {{category.name}}
            </button>
        </div>
        <div class="">
            <button type="button" class="p-2 bg-green-500 text-white m-1 rounded hover:bg-green-500 hover:text-white"
                    v-on:click="clearFilter()">
                clear all x
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MapProjectCategoryFilterComponent",
        props: {
            categories: {type: Array},
            selectedCategories: {type: Array}
        },
        methods: {
            clearFilter() {
                eventHub.$emit('on-click-clear-filter');
            },
            selectCategory(category) {
                if (this.isSelected(category) === undefined) {
                    eventHub.$emit('on-select-map-add-category', category);
                } else {
                    eventHub.$emit('on-select-map-remove-category', category);
                }
            },
            isSelected(category) {
                return this.selectedCategories.find(element => element.term_id === category.term_id);
            }
        },
    }
</script>

<style scoped>

</style>
