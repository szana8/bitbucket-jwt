<template>
    <v-app left-fixed-sidebar top-fixed-toolbar>
        <header>
            <navigation></navigation>
        </header>


        <main>
            <sidebar v-if="user.authenticated"></sidebar>

            <v-content style="overflow: hidden">
                <router-view></router-view>
            </v-content>
        </main>
    </v-app>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        computed: mapGetters({
            user: 'auth/user',
        })
    }
</script>