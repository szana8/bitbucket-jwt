<template>
    <v-container fluid="fluid">
        <v-row class="mt-5">
            <v-col xs4="xs4"></v-col>
            <v-col xs4="xs4">

                <v-card>
                    <v-card-row class="blue">
                        <v-card-title>
                            <span class="white--text">Login with your credentials</span>
                            <v-spacer></v-spacer>
                        </v-card-title>
                    </v-card-row>

                    <v-card-text>
                        <form @submit.stop.prevent="submit" @keydown="form.errors.clear($event.target.name)">
                            <v-row>
                                <v-col xs12>
                                    <v-text-field label="Email"
                                                  v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('email') }"
                                                  v-model="form.email"
                                                  name="email" />
                                    <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('email')">
                                        <div class="input-group__messages">
                                            <div class="input-group__error" v-text="form.errors.get('email')" />
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col xs12>
                                    <v-text-field type="password"
                                                  v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('password') }"
                                                  label="Password"
                                                  v-model="form.password"
                                                  name="password" />
                                    <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('password')">
                                        <div class="input-group__messages">
                                            <div class="input-group__error" v-text="form.errors.get('password')" />
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                        </form>
                    </v-card-text>

                    <v-card-row actions>
                        <v-btn info v-on:click.native="submit">Login</v-btn>
                    </v-card-row>
                </v-card>

            </v-col>
            <v-col xs4="xs4"></v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions} from 'vuex'
    import localforage from 'localforage'
    import {isEmpty} from 'lodash'

    export default {
        data() {
            return {
                form: new Form({
                    email   : null,
                    password: null
                })
            }
        },

        computed: {

        },

        methods: {
            ...mapActions({
                login: 'auth/login'
            }),
            submit() {
                this.login({
                    payload: {
                        form  : this.form,
                        errors: []
                    },
                    context: this
                }).then(() =>
                {
                    this.$router.replace({name: 'home'})
                }).catch(error =>
                {
                    console.log(error)
                })
            }
        }
    }
</script>