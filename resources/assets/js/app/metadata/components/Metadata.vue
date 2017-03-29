<template>
    <v-container fluid>
        <v-row>
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-col xl12="xl12">
                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>Metadata</span>
                                        <v-spacer></v-spacer>
                                        <div>
                                            <v-menu bottom left origin="top right" transition="v-scale-transition">
                                                <v-btn icon dark slot="activator" class="grey--text text--darken-2">
                                                    <v-icon>more_vert</v-icon>
                                                </v-btn>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-list-tile>
                                                            <v-list-tile-title>Export List</v-list-tile-title>
                                                        </v-list-tile>
                                                    </v-list-item>
                                                </v-list>
                                            </v-menu>
                                        </div>
                                    </v-card-title>
                                </v-card-row>
                            </v-card>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col xl12="xl12">
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
                                        <td>
                                            <v-switch input-value="true" v-bind:value="item.enabled == 'Y' ? 'true' : 'false' " primary light />
                                        </td>
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
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col xs12="xs12" class="mt-3">
                            <v-pagination v-bind:length.number="total_pages" circle v-model="current_page" />
                        </v-col>
                    </v-row>
                </v-container>
            </v-col>
        </v-row>
        <v-row>
            <v-col xs12="xs12" class="pt-5 text-xs-right">
                <v-btn floating="floating" error>
                    <v-icon>add</v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {

        data() {
            return {
                metadata        : null,
                pagination      : null,
                total_pages     : null,
                current_page    : null,
                showSearchClosed: false,
                searchText      : '',
                showSearchInput : false,
                axiosPagination : {
                    search: null,
                    page  : null
                }
            }
        },

        mounted () {
            axios.get('/api/v1/metadata').then(response =>
            {
                this.metadata = response.data.data
                this.pagination = response.data.pagination
                this.total_pages = response.data.pagination.total_pages
                this.current_page = response.data.pagination.current_page
            })
        },

        watch: {
            current_page: function (newIndex)
            {
                console.log(newIndex)
                this.current_page = newIndex
                this.axiosPagination.page = newIndex
                this.getList()
                // get next page data...
            },
            searchText  : function (value)
            {
                this.current_page = 1
                this.axiosPagination.page = 1
                this.axiosPagination.search = value;
                value != '' ? this.showSearchClosed = true : this.showSearchClosed = false
            }
        },

        methods: {
            getList        : function ()
            {
                axios.get('/api/v1/metadata', {
                    params: this.axiosPagination
                }).then(response =>
                {
                    this.metadata = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    //this.current_page = response.data.pagination.current_page
                }).catch(error =>
                {
                    console.log(error)
                })
            },
            clearSearchText: function ()
            {
                // clear the search field
                this.searchText = ''
                // than reload the list
                this.getList()
            }
        }
    }
</script>