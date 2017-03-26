<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>



                    <div class="panel-body">
                        <form class="form-horizontal" role="form" @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)">

                            <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('profile.name') }">
                                <label for="email" class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="profile.name" autofocus v-model="form.profile.name">
                                    <span class="error text-danger" v-if="form.errors.has('profile.name')" v-text="form.errors.get('profile.name')"></span>
                                </div>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('email') }">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" v-model="form.email">
                                    <span class="error text-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                                </div>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('password') }">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="form.password">
                                    <span class="error text-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
                                        Register
                                    </button>
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
                    password: null,
                    profile: {
                        name: null,
                        type: "database"
                    }
                })
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