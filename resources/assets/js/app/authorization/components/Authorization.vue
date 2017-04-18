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
                                        <v-text-field append-icon="search" label="Search" v-model="searchRole" v-on:keyup.native.enter="searchForRole" single-line hide-details></v-text-field>
                                    </v-card-title>
                                </v-card-row>
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th>Permissions</th>
                                        <th width="80px"></th>
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
                                                <v-row>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn primary flat v-on:click.native="edit(item.id)">
                                                            <v-icon>edit</v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn error flat v-on:click.native="destroyRole(item.id)">
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
                                                Total number of roles: {{ total_count.roles }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </v-card>
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
                                        <v-text-field append-icon="search" label="Search" v-model="searchPermission" v-on:keyup.native.enter="searchForPermission" single-line hide-details></v-text-field>
                                    </v-card-title>
                                </v-card-row>
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th width="80px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="item in permissions">
                                        <tr>
                                            <td v-text="item.name"></td>
                                            <td v-text="item.display_name"></td>
                                            <td v-text="item.description"></td>
                                            <td>
                                                <v-row>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn primary flat v-on:click.native="edit(item.id)">
                                                            <v-icon>edit</v-icon>
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col xs6="xs6" sm4="sm2">
                                                        <v-btn error flat v-on:click.native="destroyPermission(item.id)">
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
                                            <td colspan="4" class="text-xs-right pr-4">
                                                Total number of permissions: {{ total_count.permissions }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </v-card>
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
                searchRole: '',
                searchPermission: '',
                permissions: null,
                isRolesLoaded: false,
                isPermissionsLoaded: false,
                isSuccess: false,
                total_count: {
                    roles: null,
                    permissions: null
                },
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
                    this.total_count.roles = response.data.pagination.total_count
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
                    this.total_count.permissions = response.data.pagination.total_count
                    this.isPermissionsLoaded = true
                }).catch(error => {
                    console.log(error)
                })
            },

            searchForRole: function() {
                this.axiosPagination.roles.search = this.searchRole
                this.roles_current_page = 1
                this.getRolesList()
            },

            searchForPermission: function() {
                this.axiosPagination.permissions.search = this.searchPermission
                this.permissions_current_page = 1
                this.getPermissionsList()
            }

        }

    }
</script>