<template>
    <v-container fluid>

        <loader v-if="! isLoaded"></loader>

        <v-row v-if="isLoaded">

            <v-col xl12="xl12" xs12="xs12">
                <v-card>
                    <v-card-row>
                        <v-card-title>
                            <span>Locations</span>
                            <v-spacer></v-spacer>
                            <v-text-field append-icon="search" label="Search" v-model="search" v-on:keyup.native.enter="searchLocation" single-line hide-details></v-text-field>
                        </v-card-title>
                    </v-card-row>
                    <table>
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Address Line</th>
                            <th>Town or City</th>
                            <th>Country</th>
                            <th>Postal Code</th>
                            <th>Region</th>
                            <th>Phone number</th>
                            <th width="200px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="location in locations">
                            <tr>
                                <td v-text="location.location_code"></td>
                                <td v-text="location.description.substring(1, 25)"></td>
                                <td v-text="location.address_line_1.substring(1,25)"></td>
                                <td v-text="location.town_or_city"></td>
                                <td v-text="location.country"></td>
                                <td v-text="location.postal_code"></td>
                                <td v-text="location.region"></td>
                                <td v-text="location.phone_number"></td>
                                <td>
                                    <v-row>
                                        <v-col xs4="xs4">
                                            <v-btn primary flat v-on:click.native="show(item.id)">
                                                <v-icon>remove_red_eye</v-icon>
                                            </v-btn>
                                        </v-col>
                                        <v-col xs4="xs4">
                                            <v-btn primary flat v-on:click.native="edit(item.id)">
                                                <v-icon>edit</v-icon>
                                            </v-btn>
                                        </v-col>
                                        <v-col xs4="xs4">
                                            <v-btn error flat v-on:click.native="destroyLocation(item.id)">
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
                                <td colspan="9" class="text-xs-right pr-4">
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
</template>

<script>
    import localforage from 'localforage'
    import { mapActions } from 'vuex'

    export default {

        data() {

            return {
                search: '',
                isLoaded        : false,
                locations        : null,
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
            localforage.getItem('locations_page').then(page => {
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
                    localforage.setItem('locations_page', newIndex);
                }

                this.axiosPagination.page = newIndex
                this.getList()
                // get next page data...
                this.issetPageNumber = false
            }

        },

        methods: {
            ...mapActions({
                destroy: 'locations/destroy'
            }),

            getList: function ()
            {
                axios.get('/api/v1/locations', {
                    params: this.axiosPagination
                }).then(response => {
                    if (response.data.pagination.total_pages < this.axiosPagination.page)
                    {
                        this.axiosPagination.page = response.data.pagination.total_pages
                        this.getList()
                    }
                    this.locations = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                    this.total_count = response.data.pagination.total_count
                    this.isLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            },

            show : function(location)
            {
                this.$router.replace({ name: 'ShowLocation', params: { id: location } })
            },

            reloadList: function()
            {
                this.isSuccess = false
                this.getList()
            },

            searchLocation: function() {
                this.axiosPagination.search = this.search
                this.current_page = 1
                this.getList()
            }
        }
    }
</script>