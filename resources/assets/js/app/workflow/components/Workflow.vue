<template>
    <v-container>
        <v-row>
            <v-col xs12="xs12">
                <v-btn primary dark @click.native="openWorkflowDialog()">Open Dialog</v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col xs12="xs12">
                <v-text-field v-model="jsontext" multi-line></v-text-field>
            </v-col>
        </v-row>

        <v-dialog v-model="dialog" persistent width="80%">
            <v-card-row>
                <v-card-title>Workflow</v-card-title>
            </v-card-row>
            <v-card-row>
                <v-card-text>
                    <div id="workflowDiv" style="border: solid 0px black; height: 500px"></div>
                </v-card-text>
            </v-card-row>
            <v-card-row actions>
                <v-btn class="green--text darken-1" flat="flat" @click.native="saveWorkflow">Save</v-btn>
                <v-btn class="green--text darken-1" flat="flat" @click.native="dialog = false">Cancel</v-btn>
            </v-card-row>
        </v-dialog>

    </v-container>
</template>

<script>
    import localforage from 'localforage'
    import { mapActions } from 'vuex'

    export default {

        data() {
            return {
                dialog: false,
                myDiagram: null,
                jsontext:  { "class": "go.GraphLinksModel",
                    "linkFromPortIdProperty": "fromPort",
                    "linkToPortIdProperty": "toPort",
                    "nodeDataArray": [
                        {"category":"Comment", "loc":"360 -10", "text":"Kookie Brittle", "key":-13},
                        {"key":-1, "category":"Start", "loc":"175 0", "text":"Start", "post-functions": [{"name": "function_name", "class": "class"}]},
                        {"key":0, "loc":"0 77", "text":"Preheat oven to 375 F"},
                        {"key":1, "loc":"175 100", "text":"In a bowl, blend: 1 cup margarine, 1.5 teaspoon vanilla, 1 teaspoon salt"},
                        {"key":2, "loc":"175 190", "text":"Gradually beat in 1 cup sugar and 2 cups sifted flour", "post-functions": [{"name": "function_name", "class": "class"}]},
                        {"key":3, "loc":"175 270", "text":"Mix in 6 oz (1 cup) Nestle's Semi-Sweet Chocolate Morsels"},
                        {"key":4, "loc":"175 370", "text":"Press evenly into ungreased 15x10x1 pan", "post-functions": [{"name": "function_name", "class": "class"}]},
                        {"key":5, "loc":"352 85", "text":"Finely chop 1/2 cup of your choice of nuts", "post-functions": [{"name": "function_name", "class": "class"}]},
                        {"key":6, "loc":"175 440", "text":"Sprinkle nuts on top", "post-functions": [{"name": "function_name", "class": "class"}]},
                        {"key":7, "loc":"175 500", "text":"Bake for 25 minutes and let cool"},
                        {"key":8, "loc":"175 570", "text":"Cut into rectangular grid"},
                        {"key":-2, "category":"End", "loc":"175 640", "text":"Enjoy!"}
                    ],
                    "linkDataArray": [
                        {"from":1, "to":2, "fromPort":"B", "toPort":"T"},
                        {"from":2, "to":3, "fromPort":"B", "toPort":"T"},
                        {"from":3, "to":4, "fromPort":"B", "toPort":"T"},
                        {"from":4, "to":6, "fromPort":"B", "toPort":"T"},
                        {"from":6, "to":7, "fromPort":"B", "toPort":"T"},
                        {"from":7, "to":8, "fromPort":"B", "toPort":"T"},
                        {"from":8, "to":-2, "fromPort":"B", "toPort":"T"},
                        {"from":-1, "to":0, "fromPort":"B", "toPort":"T"},
                        {"from":-1, "to":1, "fromPort":"B", "toPort":"T"},
                        {"from":-1, "to":5, "fromPort":"B", "toPort":"T"},
                        {"from":5, "to":4, "fromPort":"B", "toPort":"T"},
                        {"from":0, "to":4, "fromPort":"B", "toPort":"T"}
                    ]}
            }
        },

        mounted () {
            this.initGoJS().then(response => {
                this.myDiagram = response;
            }).catch(error => {
                console.log(error)
            })
        },

        methods: {
            ...mapActions({
                initGoJS: 'workflow/initGoJS'
            }),

            saveWorkflow: function()
            {
                this.jsontext = this.myDiagram.model.toJson()
                this.dialog = false
            },

            setGoJS: function()
            {
                this.myDiagram.model = go.Model.fromJson(this.jsontext)
            },

            openWorkflowDialog : function()
            {
                this.setGoJS();
                this.dialog = true
            }

        }

    }
</script>