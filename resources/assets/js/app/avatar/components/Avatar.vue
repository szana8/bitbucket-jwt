<template>
    <v-container>

        <loader v-if="! isLoaded"></loader>

        <v-row v-if="isLoaded">
            <v-col xs12="xs12">
                <v-card>
                    <v-card-row>
                        <v-card-title>
                            <span>Avatar</span>
                            <v-spacer></v-spacer>
                            <v-text-field append-icon="search" label="Search" v-model="search" v-on:keyup.native.enter="searchMeta" single-line hide-details></v-text-field>
                        </v-card-title>
                    </v-card-row>
                    <v-card-row>

                    </v-card-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import localforage from 'localforage'
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                avatarFile: '',
                search  : '',
                isLoaded: false,
                avatar        : null,
                isSuccess       : false,
                pagination      : null,
                total_pages     : null,
                current_page    : null,
                total_count: null,
                reponseMessage  : '',
                issetPageNumber : false,
                axiosPagination : {
                    search: null,
                    page  : null
                },
            }
        },

        mounted () {
            this.getList()
        },

        methods: {
            getList: function ()
            {
                axios.get('/api/v1/avatar', {
                    params: this.axiosPagination
                }).then(response =>
                {
                    if (response.data.pagination.total_pages < this.axiosPagination.page) {
                        this.axiosPagination.page = response.data.pagination.total_pages
                        this.getList()
                    }
                    this.avatar = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                    this.total_count = response.data.pagination.total_count
                    this.isLoaded = true
                }).catch(error =>
                {
                    console.log(error)
                })
            }
        }
    }
</script>