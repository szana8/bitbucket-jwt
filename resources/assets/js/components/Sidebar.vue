<template>
    <v-sidebar>
        <v-list dense>
            <template>
                <v-list-group>
                    <v-list-item slot="item">
                        <v-list-tile v-on:click.native="navBarRedirect('metadata')">
                            <v-list-tile-title>Metadata</v-list-tile-title>
                        </v-list-tile>
                    </v-list-item>
                </v-list-group>
            </template>
        </v-list>
    </v-sidebar>
</template>

<script>


    export default {
        methods: {
            navBarRedirect (page) {
                console.log(page)
                this.$router.replace({ name: page })
            }
        }
    }
</script>