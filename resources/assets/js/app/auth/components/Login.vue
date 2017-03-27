<template>
    <md-layout :md-gutter="24">
        <md-layout md-align="center">
        </md-layout>

        <md-layout md-align="center">

            <md-layout md-align="center">
                <md-card style="width: 100%;">

                    <md-card-header>
                        <div class="md-title">Login with your credentials</div>
                    </md-card-header>

                    <md-card-content>
                        <form @submit.stop.prevent="submit" @keydown="form.errors.clear($event.target.name)">

                            <md-input-container v-bind:class="{ 'md-input-invalid': this.form.errors.has('password') }">
                                <label>Email</label>
                                <md-input name="email" v-model="form.email"></md-input>
                                <span class="md-error" v-if="this.form.errors.has('email')" v-text="this.form.errors.get('email')"></span>
                            </md-input-container>

                            <md-input-container v-bind:class="{ 'md-input-invalid': this.form.errors.has('password') }">
                                <label>Password</label>
                                <md-input type="password" name="password" required v-model="form.password"></md-input>
                                <span class="md-error" v-if="this.form.errors.has('password')" v-text="this.form.errors.get('password')"></span>
                            </md-input-container>

                        </form>
                    </md-card-content>

                    <md-card-actions>
                        <md-button class="md-raised md-primary" :disabled="this.form.errors.any()" @click.native="submit" @keydown="this.form.errors.clear($event.target.name)">
                            Login
                        </md-button>
                    </md-card-actions>

                </md-card>
            </md-layout>

        </md-layout>

        <md-layout md-align="center">
        </md-layout>
    </md-layout>
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