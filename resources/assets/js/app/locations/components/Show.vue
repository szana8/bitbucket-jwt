<template>
    <v-container fluid="fluid">
        <v-row v-if="! isLoaded">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <v-row v-if="isLoaded">
            <v-col xs12="xs12">
                <v-container>
                    <v-row class="mb-3">
                        <v-card>
                            <v-card-row>

                            </v-card-row>
                        </v-card>
                    </v-row>
                </v-container>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

    export default {
        data() {
            return {
                isLoaded: true
            }
        },

        mounted() {

        }
    }
</script>