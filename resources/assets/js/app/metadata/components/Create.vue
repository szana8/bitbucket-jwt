<template>
    <v-container>
        <v-row>
            <v-col xs12="xs12">
                <v-card>
                    <v-card-row>
                        <v-card-title>
                            <span>Create Metadata</span>
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
                    <v-card-row>
                        <v-card-text>
                            <form @submit.stop.prevent="submit" @keydown="form.errors.clear($event.target.name)">

                                <v-row>
                                    <v-col xs12>
                                        <v-select v-bind:items="metadata_types" item-text="name" v-model="form.type" label="Select" single-line />
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-text-field label="Key" v-model="form.key" v-bind:rules="[keyValidationError]" single-line name="key" />
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-text-field label="Value" v-model="form.value" single-line name="value" />
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-text-field label="Description" v-model="form.description" multi-line name="description" />
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-switch label="Enabled" primary v-model="form.enabled" light />
                                    </v-col>
                                </v-row>

                            </form>
                        </v-card-text>
                    </v-card-row>

                    <v-card-row actions>
                        <v-btn flat class="primary--text darken-1" v-on:click.native="submit">Save</v-btn>
                    </v-card-row>

                </v-card>
            </v-col>
        </v-row>
        <v-row>

            <v-col xs12="xs12" class="pt-5 text-xs-right">
                <v-btn floating="floating" primary v-on:click.native="backToMetadataMain">
                    <v-icon>reply</v-icon>
                </v-btn>
            </v-col>

        </v-row>

        <v-modal v-model="isSuccess" bottom>
            <v-card class="secondary white--text">
                <v-card-text class="subheading white--text">
                    <v-row>
                        <v-col sm10 xs12 v-text="reponseMessage" />
                        <v-col sm2 xs12>
                            <v-btn primary dark v-on:click.native="isSuccess = false">Close</v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-modal>

    </v-container>
</template>

<script>
    import { mapActions } from 'vuex'
    import { isEmpty } from 'lodash'

    export default {
        data() {
            return {
                isSuccess: false,
                reponseMessage: null,
                error: false,
                metadata_types: [
                    {'name': 'label', 'value': 'label'},
                    {'name': 'setting', 'value': 'setting'}
                ],
                form: new Form({
                    type       : {
                        value: null,
                        name: null
                    },
                    key        : null,
                    value      : null,
                    description: null,
                    enabled    : true
                })
            }
        },

        computed: {
            keyValidationError: function() {
                return true;
            }
        },

        watch: {

        },

        methods: {
            ...mapActions({
                create: 'metadata/create'
            }),

            backToMetadataMain: function ()
            {
                this.$router.replace({name: 'metadata'})
            },

            submit: function ()
            {
                this.form.type = (typeof this.form.type.value != "undefined") ? this.form.type.value : ''
                this.form.enabled = this.form.enabled == true ? 'Y' : 'N'

                this.create({
                    payload: {
                        form  : this.form,
                        errors: []
                    },
                    context: this
                }).then(response => {
                    this.reponseMessage = response.message
                    this.isSuccess = true
                    setDefault
                }).catch(error => {

                })
            },

            setDefault: function ()
            {
                this.form.type = null
                this.form.key = null
                this.form.value = null
                this.form.description = null
                this.form.enabled = true
            },

            keyValidationError: function() {
                if (this.form.errors.has('key'))
                    return this.form.errors.get('key')

                return true;
            }
        }
    }

</script>