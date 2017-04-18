<template>
    <v-container fluid>
        <!-- Loader -->
        <loader v-if="! isLoaded"></loader>
        <!-- End Loader -->

        <v-row v-if="isLoaded">
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-col xs12="xs12">
                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>Users</span>
                                        <v-spacer></v-spacer>
                                        <v-text-field append-icon="search" label="Search" v-model="search" v-on:keyup.native.enter="searchMeta" single-line hide-details></v-text-field>
                                    </v-card-title>
                                </v-card-row>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Name</th>
                                            <th>Roles</th>
                                            <th>Type</th>
                                            <th width="80px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="user in users">
                                        <tr>
                                            <td v-text="user.email" />
                                            <td v-text="user.profile[0].name" />
                                            <td v-text="user.profile[0].type" />
                                            <td></td>
                                            <td>
                                                <v-row>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn primary flat v-on:click.native="edit(item.id)">
                                                            <v-icon>edit</v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn error flat v-on:click.native="destroyUser(item.id)">
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
                                            <td colspan="5" class="text-xs-right pr-4">
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

    </v-container>
</template>

<script>
    import localforage from 'localforage'
    import { mapActions } from 'vuex'

    export default {
        data () {

            return {
                isLoaded        : false,
                users           : null,
                isSuccess       : false,
                pagination      : null,
                total_pages     : null,
                total_count     : null,
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
            localforage.getItem('user_page').then(page => {
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
                    localforage.setItem('user_page', newIndex);
                }

                this.axiosPagination.page = newIndex
                this.getList()
                // get next page data...
                this.issetPageNumber = false
            }

        },

        methods: {

            getList: function()
            {
                axios.get('/api/v1/users', {
                    params: this.axiosPagination
                }).then(response => {
                    if (response.data.pagination.total_pages < this.axiosPagination.page)
                    {
                        this.axiosPagination.page = response.data.pagination.total_pages
                        this.getList()
                    }
                    this.users = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                    this.total_count = response.data.pagination.total_count
                    this.isLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            }

        }

    }
</script>