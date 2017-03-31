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
                            <v-btn icon class="grey--text text--darken-2" v-on:click.native="backToListOfValueMain">
                                <v-icon>keyboard_arrow_left</v-icon>
                            </v-btn>
                            <span>{{action}} List Of Value</span>
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
                                        <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('name') }"
                                                      label="Name"
                                                      v-model="form.name"
                                                      single-line
                                                      name="name"/>
                                        <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('name')">
                                            <div class="input-group__messages">
                                                <div class="input-group__error" v-text="form.errors.get('name')" />
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col xs12>
                                        <v-select v-bind:items="lov_types"
                                                  item-text="type"
                                                  v-model="type"
                                                  label="Select" />
                                        <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('datatype')">
                                            <div class="input-group__messages">
                                                <div class="input-group__error" v-text="form.errors.get('datatype')" />
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>

                            </form>
                        </v-card-text>
                    </v-card-row>
                    <v-card-row actions>
                        <v-btn v-bind:loading="loading" flat class="primary--text darken-1" v-on:click.native="submit">Save</v-btn>
                    </v-card-row>
                </v-card>

                <!-- From Table card -->
                <v-card class="mt-5" v-if="loader && type.value == 1">
                        <v-card-text>

                            <v-row>
                                <v-col xs12>
                                    <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('table_name') }"
                                                  label="Table Name"
                                                  v-model="form.table_name"
                                                  single-line
                                                  name="table_name"/>
                                    <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('table_name')">
                                        <div class="input-group__messages">
                                            <div class="input-group__error" v-text="form.errors.get('table_name')" />
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col xs12>
                                    <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('column') }"
                                                  label="Column"
                                                  v-model="form.column"
                                                  single-line
                                                  name="column"/>
                                    <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('column')">
                                        <div class="input-group__messages">
                                            <div class="input-group__error" v-text="form.errors.get('column')" />
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col xs12>
                                    <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('condition') }"
                                                  label="Condition"
                                                  v-model="form.condition"
                                                  multi-line
                                                  name="condition"/>
                                    <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('condition')">
                                        <div class="input-group__messages">
                                            <div class="input-group__error" v-text="form.errors.get('condition')" />
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>

                        </v-card-text>
                </v-card>
                <!-- End From Table card -->

                <!-- From List card -->
                <v-card class="mt-5" v-if="loader && type.value == 2">
                    <v-card-text>

                        <v-row>
                            <v-col xs12>
                                <v-text-field v-bind:class="{ 'input-group--error input-group--dirty': form.errors.has('lookups') }"
                                              label="Value"
                                              v-model="list_value"
                                              single-line
                                              name="lookups"
                                              v-on:keyup.enter.native="addValueToList" />
                                <div class="input-group__details" style="margin-top:-30px;color:red;" v-if="form.errors.has('lookups')">
                                    <div class="input-group__messages">
                                        <div class="input-group__error" v-text="form.errors.get('lookups')" />
                                    </div>
                                </div>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col xs12>
                                <v-chip close v-for="item in lookups" v-model="item.chip" class="primary white--text">{{item.value}}</v-chip>
                            </v-col>
                        </v-row>

                    </v-card-text>
                </v-card>
                <!-- End From List card -->

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
                chip1: true,
                type: {
                    type: 'Please select one...',
                    value: null
                },
                error: false,
                action: '',
                loader: false,
                loading: false,
                isSuccess: false,
                list_value: '',
                reponseMessage: null,
                lov_types: [
                    {'type': 'From Table', 'value': 1},
                    {'type': 'From List', 'value': 2 }
                ],
                lookups: [],
                form: new Form({
                    datatype: null,
                    name: '',
                    table_name: '',
                    column: '',
                    condition: '',
                    lookups: []
                })
            }
        },

        watch: {
            type: function(newValue) {
                if(newValue)
                    this.form.errors.clear('datatype');

                    this.form.datatype = newValue.value
            }
        },

        mounted: function () {
            if (this.$route.params.id)
            {
                this.id = this.$route.params.id;
                axios.get('api/v1/ListOfValues/' + this.$route.params.id).then(response => {
                    this.action = 'Edit';
                    console.log(response)
                    this.form.name = response.data.data.name
                    this.type = { 'type': response.data.data.datatypeName, 'value': response.data.data.datatype }
                    this.form.datatype = response.data.data.datatype

                    if (response.data.data.datatype == 1)
                    {
                        this.form.table_name = response.data.data.table_name
                        this.form.column = response.data.data.column
                        this.form.condition = response.data.data.condition
                    }
                    else
                    {
                        for (let item in response.data.data.lookups)
                        {
                            this.lookups.push({ value: response.data.data.lookups[item].value, chip: true });
                        }

                    }

                    this.loader = true
                }).catch(error => {
                    console.log(error)
                })
            }
            else {
                this.action = 'Create';
                this.loader = true
            }
        },

        methods: {

            ...mapActions({
                create: 'listofvalues/create',
                update: 'listofvalues/update'
            }),

            updateListOfValue: function()
            {
                for(let item in this.lookups)
                {
                    if(this.lookups[item].chip != false)
                        this.form.lookups.push({'value': this.lookups[item].value });
                }


                this.update({
                    payload: {
                        id: this.$route.params.id,
                        errors: [],
                        form: this.form
                    },
                    context: this
                }).then(response => {
                    this.reponseMessage = response.message;
                    this.isSuccess = true;
                    this.loading = false
                }).catch(error => {
                    console.log(error);
                    this.loading = false
                })
            },

            closeChip: function()
            {
                console.log('Close')
            },

            createListOfValue: function()
            {
                for(let item in this.lookups)
                {
                    if(this.lookups[item].chip != false)
                        this.form.lookups.push({'value': this.lookups[item].value });
                }


                this.create({
                    payload: {
                        errors: [],
                        form: this.form
                    },
                    context: this
                }).then(response => {
                    this.reponseMessage = response.message;
                    this.isSuccess = true;
                    this.setToDefault();
                    this.loading = false
                }).catch(error => {
                    console.log(error);
                    this.loading = false
                })
            },

            submit: function()
            {
                this.loading = true;

                if (this.$route.params.id != null)
                    this.updateListOfValue();
                else
                    this.createListOfValue()
            },

            backToListOfValueMain: function () {
                this.$router.replace({name: 'listofvalues'})
            },

            addValueToList: function(event)
            {
                this.form.errors.clear('lookups');
                this.lookups.push({ value: this.list_value, chip: true });
                this.list_value = ''
            },

            setToDefault: function()
            {
                this.form.datatype = null;
                this.form.name = '';
                this.form.table_name = '';
                this.form.column = '';
                this.form.condition = '';
                this.form.lookups = [];
                this.lookups = [];
                this.type = {
                    type: 'Please select one...',
                    value: null
                }
            }

        }
    }
</script>