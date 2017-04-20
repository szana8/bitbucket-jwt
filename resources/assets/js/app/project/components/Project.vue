<template>
    <v-container fluid>
        <v-row>
            <v-col xs3="xs3">
                <v-container>
                    <v-card>
                        <v-toolbar>
                            <v-toolbar-title>Administration</v-toolbar-title>
                        </v-toolbar>
                        <v-list>
                            <v-list-item v-for="item in settings">
                                <v-divider v-if="item.divider" />
                                <v-list-tile>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-text="item.title" />
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list-item>
                        </v-list>

                    </v-card>
                </v-container>
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
                settings: [
                    {'title': 'Summary'},
                    {'title': 'Details'},
                    {'title': 'Issue Types', divider: true},
                    {'title': 'Workflows'},
                    {'title': 'Fields'},
                    {'title': 'Screen'},
                    {'title': 'User and Roles', divider: true},
                    {'title': 'Permissions'},
                    {'title': 'Notifications'},
                ]
            }
        }
    }
</script>