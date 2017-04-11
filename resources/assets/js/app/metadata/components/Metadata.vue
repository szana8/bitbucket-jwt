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
                                        <span>Metadata</span>
                                        <v-spacer></v-spacer>
                                        <v-text-field append-icon="search" label="Search" v-model="search" v-on:keyup.native.enter="searchMeta" single-line hide-details></v-text-field>
                                    </v-card-title>
                                </v-card-row>
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
                                                <v-btn primary floating small dark v-on:click.native="edit(item.id)">
                                                    <v-icon class="white--text">edit</v-icon>
                                                </v-btn>
                                                <v-btn error floating small dark v-on:click.native="destroyMeta(item.id)">
                                                    <v-icon class="white--text">delete</v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
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
                isLoaded        : false,
                metadata        : null,
                isSuccess       : false,
                pagination      : null,
                total_pages     : null,
                current_page    : null,
                reponseMessage  : '',
                issetPageNumber : false,
                axiosPagination : {
                    search: null,
                    page  : null
                },
            }

        },

        mounted () {
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
                    localforage.setItem('meta_page', newIndex);
                }

                this.axiosPagination.page = newIndex
                this.getList()
                // get next page data...
                this.issetPageNumber = false
            }

        },

        methods: {
            ...mapActions({
                destroy: 'metadata/destroy'
            }),

            getList: function ()
            {
                axios.get('/api/v1/metadata', {
                    params: this.axiosPagination
                }).then(response => {
                    if (response.data.pagination.total_pages < this.axiosPagination.page)
                    {
                        this.axiosPagination.page = response.data.pagination.total_pages
                        this.getList()
                    }
                    this.metadata = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                    this.isLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            },

            createMetadata: function()
            {
                this.$router.replace({ name: 'CreateMetadata' })
            },

            edit: function(metadata)
            {
                this.$router.replace({ name: 'EditMetadata', params: { id: metadata } })
            },

            destroyMeta: function(metadata)
            {
                this.destroy({
                    id: metadata,
                    context: this
                }).then(response => {
                    console.log(response)
                    this.reponseMessage = response.message
                    this.isSuccess = true
                }).catch(error => {
                    console.log(error)
                })
            },

            reloadList: function()
            {
                this.isSuccess = false
                this.getList()
            },

            searchMeta: function()
            {
                this.axiosPagination.search = this.search
                this.current_page = 1
                this.getList()
            }
        }
    }
</script>