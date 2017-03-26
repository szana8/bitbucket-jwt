<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <div class="alert alert-danger" v-if="form.errors.any()">
                            Could not sign you in with those details.
                        </div>

                        <form class="form-horizontal" role="form" @submit.prevent="submit">

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="form.email" autofocus>
                                    <span class="error text-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="form.password">
                                    <span class="error text-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Login</button>

                                    <a class="btn btn-link" href="#">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                form: new Form({
                    email: null,
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
                        form: this.form
                    },
                    context: this
                }).then(() => {
                    this.$router.replace({ name: 'home' })
                })
            }
        }
    }
</script>