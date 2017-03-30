<template>

    <v-container>
        <!-- Load animation -->
        <v-row v-if="! loader">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>
        <!-- End load animation -->


        <v-row v-if="loader">
            <v-col xs12="xs12">
                <v-card>

                    <!-- Header -->
                    <v-card-row>
                        <v-card-title>
                            <v-btn icon class="grey--text text--darken-2" v-on:click.native="backToMetadataMain">
                                <v-icon>keyboard_arrow_left</v-icon>
                            </v-btn>
                            <span>{{action}} Metadata</span>
                            <v-spacer></v-spacer>
                            <v-menu bottom left origin="top right" transition="v-scale-transition">
                                <v-btn icon dark slot="activator" class="grey--text text--darken-2">
                                    <v-icon>more_vert</v-icon>
                                </v-btn>
                                <v-list>
                                    <v-list-item>
                                        <v-list-tile>
                                            <v-list-tile-title>Help</v-list-tile-title>
                                        </v-list-tile>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-card-title>
                    </v-card-row>
                    <!-- End Header -->


                    <v-card-row>
                        <v-card-text>
                            <form @submit.stop.prevent="submit" @keydown="form.errors.clear($event.target.name)">
                                <v-row>
                                    <v-col xs12>
                                        <v-select v-bind:items="metadata_types" item-text="type" v-model="type" label="Select" />
                                        <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('type')">
                                            <div class="input-group__messages">
                                                <div class="input-group__error" v-text="form.errors.get('type')" />
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col xs12>
                                        <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('key') }" label="Key" v-model="form.key" single-line name="key"/>
                                        <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('key')">
                                            <div class="input-group__messages">
                                                <div class="input-group__error" v-text="form.errors.get('key')" />
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col xs12>
                                        <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('value') }" label="Value" v-model="form.value" single-line name="value"/>
                                        <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('value')">
                                            <div class="input-group__messages">
                                                <div class="input-group__error" v-text="form.errors.get('value')" />
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col xs12>
                                        <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('description') }" label="Description" v-model="form.description" multi-line name="description"/>
                                        <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('description')">
                                            <div class="input-group__messages">
                                                <div class="input-group__error" v-text="form.errors.get('description')" />
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col xs12>
                                        <v-switch label="Enabled" primary v-model="form.enableSwitch" light/>
                                    </v-col>
                                </v-row>
                            </form>
                        </v-card-text>
                    </v-card-row>
                    <v-card-row actions>
                        <v-btn v-bind:loading="loading"  flat class="primary--text darken-1" v-on:click.native="submit">Save</v-btn>
                    </v-card-row>
                </v-card>
            </v-col>
        </v-row>


        <!-- Reponse -->
        <v-modal v-model="isSuccess" bottom>
            <v-card class="secondary white--text">
                <v-card-text class="subheading white--text">
                    <v-row>
                        <v-col sm10 xs12 v-text="reponseMessage"/>
                        <v-col sm2 xs12>
                            <v-btn primary dark v-on:click.native="isSuccess = false">Close</v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-modal>
        <!-- End Response -->

    </v-container>
</template>

<script>
    import { mapActions } from 'vuex'
    import { isEmpty } from 'lodash'

    export default {
        data() {
            return {
                id: null,
                type: {
                    type: 'Please select one...',
                    value: null
                },
                error: false,
                action: '',
                loader: false,
                loading: false,
                isSuccess: false,
                reponseMessage: null,
                metadata_types: [
                    {'type': 'label', 'value': 'label'},
                    {'type': 'setting', 'value': 'setting'}
                ],

                form: new Form({
                    enableSwitch: true,
                    type: null,
                    key: null,
                    value: null,
                    enabled: 'Y',
                    description: null
                })
            }
        },

        mounted: function () {
            if (this.$route.params.id)
            {
                this.id = this.$route.params.id
                axios.get('api/v1/metadata/' + this.$route.params.id).then(response => {
                    this.action = 'Edit'
                    this.type = { 'type': response.data.data.type, 'value': response.data.data.type }
                    this.form.type = response.data.data.type
                    this.form.key = response.data.data.key
                    this.form.value = response.data.data.value
                    this.form.description = response.data.data.description
                    this.form.enableSwitch = response.data.data.enabled == 'Y' ? true : false

                    this.loader = true
                }).catch(error => {
                    console.log(error)
                })
            }
            else {
                this.action = 'Create'
                this.loader = true
            }
        },

        watch: {

            type: function(newValue) {
                if(newValue)
                    this.form.errors.clear('type')
            }

        },

        methods: {

            ...mapActions({
                create: 'metadata/create',
                update: 'metadata/update'
            }),

            backToMetadataMain: function () {
                this.$router.replace({name: 'metadata'})
            },

            checkType: function()
            {
                this.form.type = (typeof this.type.value != "undefined") ? this.type.value : ''
                this.form.enabled = this.form.enableSwitch == true ? 'Y' : 'N'
            },

            updateMetadata: function() {
               this.checkType()

                this.update({
                    payload: {
                        errors: [],
                        form: this.form,
                        id: this.$route.params.id
                    },
                    context: this
                }).then(response => {
                    this.reponseMessage = response.message
                    this.isSuccess = true
                    this.loading = false
                }).catch(error => {
                    console.log(error)
                    this.loading = false
                })
            },

            createMetadata: function() {
                this.checkType()

                this.create({
                    payload: {
                        errors: [],
                        form: this.form
                    },
                    context: this
                }).then(response => {
                    this.reponseMessage = response.message
                    this.isSuccess = true
                    this.setToDefault()
                    this.loading = false
                }).catch(error => {
                    console.log(error)
                    this.loading = false
                })
            },


            submit: function () {
                this.loading = true

                if (this.$route.params.id != null)
                    this.updateMetadata()
                else
                    this.createMetadata()
            }
        }
    }

</script>