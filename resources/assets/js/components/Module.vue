<template>
    <v-container fluid="fluid">

        <!-- Loader icon -->
        <v-row v-if="! isLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <!-- End Loader icon -->

        <!-- Module base -->
        <v-row v-if="isLoaded">
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-col xs12="xs12">

                            <v-card>
                                <v-card-row>
                                    <v-card-title>
                                        <span>{{ title }}</span>
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
                            {{ content }}
                        </v-col>
                    </v-row>

                </v-container>
            </v-col>
        </v-row>
        <!-- End Module base -->

    </v-container>
</template>

<script>
    export default {
        props: ['isLoaded']
    }
</script>