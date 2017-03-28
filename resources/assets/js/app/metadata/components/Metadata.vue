<template>
    <v-container fluid>
        <v-row class="">
            <v-col xs12="xs12">
                <v-toolbar class="transparent">
                    <v-btn icon="icon"><v-icon>search</v-icon></v-btn>
                    <v-text-field class="grey--text" v-model="searchText" single-line></v-text-field>
                    <v-btn icon="icon" v-if="showSearchClosed" v-on:click.native="clearSearchText"><v-icon>close</v-icon></v-btn>
                </v-toolbar>
            </v-col>
            <v-col xs12="xs12">
                <v-table-overflow>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th>Enabled</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <template v-for="item in metadata">
                        <tr>
                            <td v-text="item.type"></td>
                            <td v-text="item.key"></td>
                            <td v-text="item.value"></td>
                            <td v-text="item.description"></td>
                            <td v-text="item.enabled"></td>
                            <td>
                                <v-btn primary floating small dark>
                                    <v-icon class="white--text">edit</v-icon>
                                </v-btn>
                                <v-btn error floating small dark>
                                    <v-icon class="white--text">delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                </v-table-overflow>
            </v-col>
        </v-row>
        <v-row>
            <v-col xs4="xs4" class="mt-3">
                <v-pagination v-bind:length.number="total_pages" circle v-model="current_page" />
            </v-col>
        </v-row>
        <v-row>
            <v-col xs12="xs12" class="pt-5 text-xs-right">
                <v-btn floating error style="position:absolute;bottom:0;right:0px;z-index:1000;">
                    <v-icon>add</v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import {isEmpty} from 'lodash'

    export default {
        computed: mapGetters({
            sidebar: 'sidebar',
        }),

        data() {
            return {
                metadata: null,
                pagination: null,
                total_pages: null,
                current_page: null,
                search: '',
                axiosPagination: {
                    page  : null
                }
            }
        },

        computed: {
            searchValue: function() {

            }
        },

        mounted () {
            axios.get('/api/v1/metadata').then(response => {
                this.metadata = response.data.data
                this.pagination = response.data.pagination
                this.total_pages = response.data.pagination.total_pages
                this.current_page = response.data.pagination.current_page
            })
        },

        watch: {
            current_page: function (newIndex) {
                this.current_page = newIndex
                this.axiosPagination.page = newIndex
                this.getList()
                // get next page data...
            },
            search: function(value) {
                console.log(value)
            }
        },

        methods: {
            ...mapActions({
                register: 'metadata'
            }),
            getList: function() {
                axios.get('/api/v1/metadata', {
                    params: {
                        page: this.axiosPagination.page,
                        search: this.sidebar.search
                    }
                }).then(response => {
                    this.metadata = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                })
            }
        }
    }
</script>