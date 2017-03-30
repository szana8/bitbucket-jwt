<template>
    <v-sidebar>
        <v-list dense>
            <template v-for="item in itemGroup">
                <v-list-group v-if="item.items">
                    <v-list-item slot="item">
                        <v-list-tile>
                            <v-list-tile-title v-text="item.title" />
                            <v-list-tile-action>
                                <v-icon>keyboard_arrow_down</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list-item>
                    <v-list-item v-for="subItem in item.items">
                        <v-list-tile v-model="subItem.active" v-on:click.native="navBarRedirect(subItem.name)">
                            <v-list-tile-title v-text="subItem.title"   />
                        </v-list-tile>
                    </v-list-item>
                </v-list-group>
                <v-subheader v-else-if="item.header" v-text="item.header" />
                <v-divider v-else-if="item.divider" light />
                <v-list-item v-else>
                    <v-list-tile>
                        <v-list-tile-title v-text="item.title" />
                    </v-list-tile>
                </v-list-item>
            </template>
        </v-list>
        <!--
        <v-list dense>
            <template>
                <v-subheader>Settings</v-subheader>
                <v-divider light />
                <v-list-group>
                    <v-list-item>
                        <v-list-tile>
                            <v-list-tile-title>System</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>keyboard_arrow_down</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>

                        <v-list-tile v-on:click.native="navBarRedirect('metadata')">
                            <v-list-tile-title>Metadata</v-list-tile-title>
                        </v-list-tile>
                    </v-list-item>
                </v-list-group>
            </template>
        </v-list>
        -->
    </v-sidebar>
</template>

<script>


    export default {
        data () {
            return {
                itemGroup: [
                    { header: 'Settings', icon: 'settings' },
                    {
                        title: 'System',
                        icon: 'settings applications',
                        group: '/system',
                        items: [
                            { title: 'Metadata', name: 'metadata', icon: 'list', active: true },
                        ]
                    },
                    //{ title: 'Link' },
                    { divider: true },
                    { header: 'Modules' },
                    { title: 'Issue' }
                ]
            }
        },

        methods: {
            navBarRedirect (page) {
                console.log(page)
                this.$router.replace({ name: page })
            }
        }
    }
</script>