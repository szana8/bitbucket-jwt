<template>

    <v-container>
        <v-row v-if="! loader">
            <v-col xs12="xs12" class="text-xs-center mt-5">
                <v-progress-circular indeterminate class="primary--text"/>
            </v-col>
        </v-row>

        <v-row v-if="loader">
            <v-col xs12="xs12">
                <v-card>
                    <v-card-row>
                        <v-card-title>
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
                    <v-card-row>
                        <v-card-text>
                            <form @submit.stop.prevent="submit" @keydown="form.errors.clear($event.target.name)">

                                <v-row>
                                    <v-col xs12>
                                        <v-select v-bind:items="metadata_types" item-text="name" v-model="form.typeList"label="Select" single-line/>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-text-field label="Key" v-model="form.key" single-line name="key"/>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-text-field label="Value" v-model="form.value" single-line name="value"/>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-text-field label="Description" v-model="form.description" multi-line
                                                      name="description"/>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-switch label="Enabled" primary v-model="form.enabled" light/>
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
        <v-row v-if="loader">

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
                        <v-col sm10 xs12 v-text="reponseMessage"/>
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
    import {mapActions} from 'vuex'
    import {isEmpty} from 'lodash'

    export default {
        data() {
            return {
                id: null,
                error: false,
                action: '',
                loader: false,
                isSuccess: false,
                reponseMessage: null,
                metadata_types: [
                    {'name': 'label', 'value': 'label'},
                    {'name': 'setting', 'value': 'setting'}
                ],

                form: new Form({
                    typeList: {
                        name: 'Please select one...',
                        value: null
                    },
                    type: null,
                    key: null,
                    value: null,
                    enabled: true,
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
                    this.form.typeList = {
                        value: response.data.data.type,
                        name: response.data.data.type
                    }
                    this.form.type = response.data.data.type
                    this.form.key = response.data.data.key
                    this.form.value = response.data.data.value
                    this.form.description = response.data.data.description
                    this.form.enabled = response.data.data.enabled == 'Y' ? true : false

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

        methods: {
            ...mapActions({
                create: 'metadata/create',
                edit: 'metadata/edit',
                update: 'metadata/update'
            }),

            backToMetadataMain: function () {
                this.$router.replace({name: 'metadata'})
            },

            submit: function () {
                if (this.$route.params.id != null)
                {
                    this.form.type = (typeof this.form.typeList.value != "undefined") ? this.form.typeList.value : ''
                    this.form.enabled = this.form.enabled == true ? 'Y' : 'N'

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
                    }).catch(error => {
                        console.log(error)
                    })
                }
                else
                {
                    this.form.type = (typeof this.form.typeList.value != "undefined") ? this.form.typeList.value : ''
                    this.form.enabled = this.form.enabled == true ? 'Y' : 'N'

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
                    }).catch(error => {

                    })
                }
            },

            setToDefault: function () {
                // Set to default
                /*this.form.type = {
                    value: null,
                    name: 'Please select one...'
                }
                this.form.key = null
                this.form.value = null
                this.form.description = null
                this.form.enabled = true*/
            }
        }
    }

</script>