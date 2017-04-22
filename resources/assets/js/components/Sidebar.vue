<template>
    <v-sidebar fixed>
        <v-list dense>
            <v-list-tile avatar class="mt-5">
                <v-list-tile-avatar>
                    <img src="https://vuetifyjs.com/public/doc-images/lists/1.jpg"/>
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>{{ user.data.email }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-divider class="mt-5" light />
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
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data() {
            return {
                itemGroup: [
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
                                { title: 'Avatar', href: '/system/avatar', icon: 'list' },
                                { title: 'Project', href: '/system/project', icon: 'list' },
                                { title: 'Workflow', href: '/system/workflow', icon: 'list' },
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
                        {
                            title: 'Project',
                            icon: 'settings applications',
                        },
                        { header: 'Inventory Management' },
                        { title: 'Item Inventory' }
                    ]
            }
        },
        computed: mapGetters({
            user: 'auth/user'
        })
    }
</script>