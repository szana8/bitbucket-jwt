<template>
    <md-toolbar color="primary">
        <md-button class="md-icon-button" v-on:click.native="navBarRedirect('home')">
            <md-icon>menu</md-icon>
        </md-button>
        <h2 class="md-title" style="flex: 1">Laravel Issue Tracker</h2>

        <md-button v-on:click.native="navBarRedirect('login')">Login</md-button>
        <md-button v-on:click.native="navBarRedirect('register')">Register</md-button>

        <md-button v-on:click.native="signout">Logout</md-button>

    </md-toolbar>
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