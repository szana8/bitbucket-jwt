<template>
    <v-sidebar height="auto">
        <v-list dense>
            <template>

            </template>
        </v-list>
    </v-sidebar>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        computed: mapGetters({
            sidebar: 'sidebar',
        }),

        data() {
            return {
                showSearchClosed: false,
                searchText: null
            }
        },

        methods: {
            clearSearchText: function() {
                this.searchText = ''
                //this.showSearchClosed = false
            }
        },

        watch: {
            searchText: function(value) {
                if ( value != '') {
                    this.globalSearchValue = value;
                    this.showSearchClosed = true
                }
                else {
                    this.globalSearchValue = ''
                    this.showSearchClosed = false
                }
            }
        }
    }
</script>