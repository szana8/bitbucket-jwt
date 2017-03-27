<template>
    <v-toolbar class="primary">
        <v-toolbar-side-icon v-on:click.native="navBarRedirect('home')" />

        <v-toolbar-title>Laravel Issue Tracker</v-toolbar-title>

        <v-toolbar-items v-if="user.authenticated">
            <v-toolbar-item v-on:click.native="navBarRedirect('metadata')" v-if="user.authenticated">Metadata</v-toolbar-item>
            <v-toolbar-item v-on:click.native="signout" v-if="user.authenticated">Logout</v-toolbar-item>
        </v-toolbar-items>

        <v-toolbar-items v-if="!user.authenticated">
                <v-toolbar-item v-on:click.native="navBarRedirect('login')">Login</v-toolbar-item>
                <v-toolbar-item v-on:click.native="navBarRedirect('register')">Register</v-toolbar-item>
        </v-toolbar-items>
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