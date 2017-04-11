<template>
    <v-container fluid="fluid">
        <v-row v-if="! isLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <v-row v-if="isLoaded">
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-col xs12="xs12">
                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>Locations</span>
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
                        <v-col xs12="xs12">
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
                                    <th></th>
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
                                            <v-btn primary floating small dark v-on:click.native="show(location.id)">
                                                <v-icon class="white--text">remove_red_eye</v-icon>
                                            </v-btn>
                                            <v-btn primary floating small dark v-on:click.native="edit(location.id)">
                                                <v-icon class="white--text">edit</v-icon>
                                            </v-btn>
                                            <v-btn error floating small dark v-on:click.native="destroyMeta(location.id)">
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
                isLoaded        : false,
                locations        : null,
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
            }
        }
    }
</script>