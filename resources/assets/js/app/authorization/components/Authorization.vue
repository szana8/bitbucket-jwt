<template>
    <v-container fluid>

        <!-- Role Loader -->
        <v-row v-if="! isRolesLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <!-- End Role Loader -->

        <v-row v-if="isRolesLoaded">
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-col xs12="xs12">
                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>Roles</span>
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
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Permissions</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="item in roles">
                                    <tr>
                                        <td v-text="item.name"></td>
                                        <td v-text="item.display_name"></td>
                                        <td v-text="item.description"></td>
                                        <td>
                                            <v-btn slot="activator" secondary>Show</v-btn>
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
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col xs12="xs12" class="mt-3">
                            <v-pagination v-bind:length.number="total_pages.roles" circle v-model="roles_current_page"/>
                        </v-col>
                    </v-row>

                </v-container>
            </v-col>
        </v-row>

        <!-- Loader -->
        <v-row v-if="! isPermissionsLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <!-- End Loader -->


        <v-row v-if="isPermissionsLoaded" class="mt-5 pb-5">
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-col xs12="xs12">
                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>Permissions</span>
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
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="item in permissions">
                                    <tr>
                                        <td v-text="item.name"></td>
                                        <td v-text="item.display_name"></td>
                                        <td v-text="item.description"></td>
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
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col xs12="xs12" class="mt-3">
                            <v-pagination v-bind:length.number="total_pages.permissions" circle v-model="permissions_current_page"/>
                        </v-col>
                    </v-row>

                </v-container>
            </v-col>
        </v-row>

    </v-container>
</template>

<script>
    import localforage from 'localforage'
    import {mapActions} from 'vuex'

    export default {

        data() {
            return {
                roles: null,
                permissions: null,
                isRolesLoaded: false,
                isPermissionsLoaded: false,
                isSuccess: false,
                pagination: {
                    roles: null,
                    permission: null
                },
                total_pages: {
                    roles: null,
                    permissions: null
                },
                roles_current_page: null,
                permissions_current_page: null,
                reponseMessage: '',
                issetPageNumber: {
                    roles: null,
                    permissions: null
                },
                axiosPagination: {
                    roles: {
                        search: null,
                        page: null
                    },
                    permissions: {
                        search: null,
                        page: null
                    }
                },
            }
        },

        mounted () {

            console.log(this.$router)

            localforage.getItem('roles_page').then(page => {
                if (page) {
                    this.issetPageNumber.roles = true
                    this.axiosPagination.roles.page = page
                    this.roles_current_page = page
                }
                else {
                    this.roles_current_page = 1
                }
            })

            localforage.getItem('permissions_page').then(page => {
                if (page) {
                    this.issetPageNumber.permissions = true
                    this.axiosPagination.permissions.page = page
                    this.permissions_current_page = page
                }
                else {
                    this.permissions_current_page = 1
                }
            })

        },

        watch: {

            roles_current_page: function (newIndex) {
                if (!this.issetPageNumber.roles) {
                    localforage.setItem('roles_page', newIndex);
                }

                this.axiosPagination.roles.page = newIndex
                this.getRolesList()
                // get next page data...
                this.issetPageNumber.roles = false
            },

            permissions_current_page: function (newIndex) {
                if (! this.issetPageNumber.permissions) {
                    localforage.setItem('permissions_page', newIndex);
                }

                this.axiosPagination.permissions.page = newIndex
                this.getPermissionsList()
                // get next page data...
                this.issetPageNumber.permissions = false
            }

        },

        methods: {

            getRolesList: function () {
                axios.get('/api/v1/roles', {
                    params: this.axiosPagination.roles
                }).then(response => {
                    if (response.data.pagination.total_pages < this.axiosPagination.roles.page) {
                        this.axiosPagination.roles.page = response.data.pagination.total_pages
                        this.getRolesList()
                    }

                    this.roles = response.data.data
                    this.pagination.roles = response.data.pagination
                    this.total_pages.roles = response.data.pagination.total_pages
                    this.roles_current_page = response.data.pagination.current_page
                    this.isRolesLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            },

            getPermissionsList: function () {
                axios.get('/api/v1/permissions', {
                    params: this.axiosPagination.permissions
                }).then(response => {
                    if (response.data.pagination.total_pages < this.axiosPagination.permissions.page) {
                        this.axiosPagination.permissions.page = response.data.pagination.total_pages
                        this.getPermissionsList()
                    }

                    this.permissions = response.data.data
                    this.pagination.permissions = response.data.pagination
                    this.total_pages.permissions = response.data.pagination.total_pages
                    this.permissions_current_page = response.data.pagination.current_page
                    this.isPermissionsLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            },

        }

    }
</script>