<template>
    <v-container fluid>
        <v-row v-if="! isLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>

        <v-row v-if="isLoaded">
            <v-col xs12="xs12">
                <v-container>
                    <v-row>
                        <v-col xs12="xs12">
                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>List Of Values</span>
                                        <v-spacer></v-spacer>
                                        <v-text-field append-icon="search" label="Search" v-model="search" v-on:keyup.native.enter="searchLov" single-line hide-details></v-text-field>
                                    </v-card-title>
                                </v-card-row>

                                <table>
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Datatype</th>
                                        <th>Table</th>
                                        <th>Column</th>
                                        <th>Condition</th>
                                        <th>Values</th>
                                        <th width="80px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="item in listofvalues">
                                        <tr>
                                            <td v-text="item.name" />
                                            <td v-text="item.datatypeName" />
                                            <td v-text="item.table_name" />
                                            <td v-text="item.column" />
                                            <td v-text="item.condition" />
                                            <td>
                                                <v-menu v-if="item.datatype==2" transition="v-slide-y-transition" origin="top center" top right>
                                                    <v-btn slot="activator" secondary>Show</v-btn>
                                                    <v-list>
                                                        <v-list-item v-for="values in item.lookups">
                                                            <v-list-tile>
                                                                <v-list-tile-title v-text="values.value" />
                                                            </v-list-tile>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </td>
                                            <td>
                                                <v-row>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn primary flat dark v-on:click.native="edit(item.id)">
                                                            <v-icon>edit</v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn error flat dark v-on:click.native="destroyListOfValue(item.id)">
                                                            <v-icon>delete</v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-xs-right pr-4">
                                                Total number of records: {{ total_count }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </v-card>
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
        <v-row v-if="isLoaded">
            <v-col xs12="xs12" class="pt-5 text-xs-right">
                <v-btn floating="floating" error v-on:click.native="createMetadata">
                    <v-icon>add</v-icon>
                </v-btn>
            </v-col>
        </v-row>

        <v-modal v-model="isSuccess" bottom>
            <v-card class="secondary white--text">
                <v-card-text class="subheading white--text">
                    <v-row>
                        <v-col sm10 xs12 v-text="reponseMessage"/>
                        <v-col sm2 xs12>
                            <v-btn primary dark v-on:click.native="reloadList">Close</v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-modal>

    </v-container>
</template>

<script>
    import localforage from 'localforage'
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                search: '',
                isLoaded: false,
                isSuccess       : false,
                pagination      : null,
                total_pages     : null,
                listofvalues     : null,
                current_page    : null,
                total_pages     : null,
                current_page    : null,
                total_count: null,
                reponseMessage  : '',
                issetPageNumber : false,
                axiosPagination : {
                    search: null,
                    page  : null
                }
            }
        },

        mounted() {
            localforage.getItem('meta_page').then(page => {
                if(page)
                {
                    this.issetPageNumber = true
                    this.axiosPagination.page = page
                    this.current_page = page
                }
                else
                {
                    this.current_page = 1
                }
            })
        },

        watch: {
            current_page: function (newIndex)
            {
                if (! this.issetPageNumber) {
                    localforage.setItem('listofvalues_page', newIndex);
                }

                this.axiosPagination.page = newIndex
                this.getList()
                // get next page data...
                this.issetPageNumber = false
            }
        },

        methods: {

            ...mapActions({
                destroy: 'listofvalues/destroy'
            }),

            getList: function ()
            {
                axios.get('/api/v1/ListOfValues', {
                    params: this.axiosPagination
                }).then(response => {
                    console.log(response)
                    if (response.data.pagination.total_pages < this.axiosPagination.page)
                    {
                        this.axiosPagination.page = response.data.pagination.total_pages
                        this.getList()
                    }
                    this.listofvalues = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                    this.total_count = response.data.pagination.total_count
                    this.isLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            },

            createMetadata: function()
            {
                this.$router.replace({ name: 'CreateListOfValue' })
            },

            edit: function(lov)
            {
                this.$router.replace({ name: 'EditListOfValue', params: { id: lov } })
            },

            destroyListOfValue: function(lov)
            {
                this.destroy({
                    id: lov,
                    context: this
                }).then(response => {
                    this.reponseMessage = response.message
                    this.isSuccess = true
                }).catch(error => {
                    console.log(error)
                })
            },

            reloadList: function()
            {
                console.log('asd')
                this.isSuccess = false
                this.getList()
            },

            searchLov: function()
            {
                this.axiosPagination.search = this.search
                this.current_page = 1
                this.getList()
            }
        }
    }
</script>