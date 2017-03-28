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
                                    <v-text-field label="Email" v-model="form.email" name="email"></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col xs12>
                                    <v-text-field type="password" label="Password" :rules="[passwordValidationError]" v-model="form.password" name="password"></v-text-field>
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
            passwordValidationError: function() {
                if(this.form.errors.has('password')) {
                    return this.form.errors.get('password')
                }

                return;
            }
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
                    /*localforage.getItem('intended').then((name) => {
                     if ( isEmpty(name) ) {
                     this.$router.replace({ name: 'home' })
                     return
                     }

                     this.$router.replace({ name: name })
                     })*/

                    this.$router.replace({name: 'home'})
                }).catch(error =>
                {
                    console.log(error)
                })
            }
        }
    }
</script>