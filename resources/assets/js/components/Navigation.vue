<template>
    <v-toolbar class="primary" top-toolbar left-fixed-sidebar sidebar-under-toolbar>
        <v-toolbar-side-icon v-on:click.native="navBarRedirect('home')" />

        <v-toolbar-title>Laravel Issue Tracker</v-toolbar-title>

        <v-toolbar-items v-if="!user.authenticated">
                <v-toolbar-item v-on:click.native="navBarRedirect('login')">Login</v-toolbar-item>
                <v-toolbar-item v-on:click.native="navBarRedirect('register')">Register</v-toolbar-item>
        </v-toolbar-items>

        <v-btn icon dark v-if="user.authenticated">
            <v-icon>account_circle</v-icon>
        </v-btn>

        <v-menu bottom left offset-y origin="top right" transition="v-slide-y-transition">
            <v-btn icon dark slot="activator">
                <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
                <v-list-item>
                    <v-list-tile>
                        <v-list-tile-title>Help</v-list-tile-title>
                    </v-list-tile>
                </v-list-item>
                <v-list-item>
                    <v-list-tile v-on:click.native="signout">
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile>
                </v-list-item>
            </v-list>
        </v-menu>

    </v-toolbar>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        computed: mapGetters({
            user: 'auth/user',
        }),
        methods: {
            ...mapActions({
                logout: 'auth/logout'
            }),
            signout () {
                this.logout().then(() => {
                    this.$router.replace({ name: 'login' })
                })
            },
            navBarRedirect (page) {
                this.$router.replace({ name: page })
            }
        }
    }
</script>