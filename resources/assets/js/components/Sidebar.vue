<template>
    <v-sidebar v-bind:close-on-click="false">
        <v-list dense>
            <template v-for="item in itemGroup">
                <v-list-group v-if="item.items" v-bind:group="item.group" v-bind:key="item.title">
                    <v-list-item slot="item">
                        <v-list-tile ripple>
                            <v-list-tile-title v-text="item.title" />
                            <v-list-tile-action>
                                <v-icon>keyboard_arrow_down</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list-item>
                    <v-list-item v-for="subItem in item.items" v-bind:key="subItem.title" >
                        <v-list-tile ripple router :href="subItem.href">
                            <v-list-tile-title v-html="subItem.title.bold()" />
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
    </v-sidebar>
</template>

<script>


    export default {
        data () {
            return {

            }
        },

        computed: {
            itemGroup: function() {
                return [
                    { header: 'Settings', icon: 'settings' },
                    {
                        title: 'System',
                        icon: 'settings applications',
                        group: '/system',
                        items: [
                            { title: 'Metadata', href: '/system/metadata', icon: 'list' },
                            { title: 'List Of Values', href: '/system/list-of-values', icon: 'list' },
                            { title: 'User', href: '/system/user', icon: 'list' },
                            { title: 'Authorization', href: '/system/authorization', icon: 'list' },
                        ]
                    },
                    //{ title: 'Link' },
                    { divider: true },
                    { header: 'Setup' },
                    {
                        title: 'Organizations',
                        icon: 'settings applications',
                        group: '/setup/organizations',
                        items: [
                            { title: 'Locations', href: '/setup/organizations/locations', icon: 'list' },
                        ]
                    },
                    { header: 'Inventory Management' },
                    { title: 'Item Inventory' }
                ]
            }
        }
    }
</script>