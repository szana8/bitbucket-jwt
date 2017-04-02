<template>
    <v-container fluid>

        <!-- Loader -->
        <v-row v-if="! isLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <!-- End Loader -->

        <v-row v-if="isLoaded">
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
                        </v-col>
                    </v-row>


                </v-container>
            </v-col>
        </v-row>

    </v-container>
</template>

<script>
    export default {

        data() {
            return {
                isLoaded        : true,
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
        }

    }
</script>