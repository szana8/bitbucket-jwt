<template>
    <v-container fluid="fluid">
        <v-row class="mt-5">
            <v-col xs4="xs4"></v-col>
            <v-col xs4="xs4">
                <v-card>
                    <v-card-row class="blue">
                        <v-card-title>
                            <span class="white--text">Register</span>
                            <v-spacer></v-spacer>
                        </v-card-title>
                    </v-card-row>

                    <v-card-text>
                        <form @submit.stop.prevent="submit" @keydown="form.errors.clear($event.target.name)">
                            <v-row>
                                <v-col xs12>
                                    <v-text-field label="Name" v-model="form.profile.name" autofocus name="profile.name"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col xs12>
                                    <v-text-field label="Email" v-model="form.email" name="email"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col xs12>
                                    <v-text-field label="Password" type="password" v-model="form.password" name="password"></v-text-field>
                                </v-col>
                            </v-row>

                        </form>
                    </v-card-text>

                    <v-card-row actions>
                        <v-btn flat class="blue--text" v-on:click.native="submit" :disabled="form.errors.any()">Register</v-btn>
                    </v-card-row>

                </v-card>
            </v-col>
            <v-col xs4="xs4"></v-col>
        </v-row>
    </v-container>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                form: new Form({
                    email: null,
                    password: null,
                    profile: {
                        name: null,
                        type: "database"
                    }
                })
            }
        },

        computed: {
            passwordValidationError: function() {
                return this.form.errors.get('email')
            }
        },

        methods: {
            ...mapActions({
                register: 'auth/register'
            }),
            submit() {
                this.register({
                    payload: {
                        form: this.form
                    },
                    context: this
                })
            }
        }
    }
</script>