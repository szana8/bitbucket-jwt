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
                        {"key":-1, "category":"Start", "loc":"80.95597839355469 25.209302325581397", "text":"Start"},
                        {"key":0, "category":"Open", "loc":"80.95597839355469 101.71860465116279", "text":"Open"},
                        {"key":1, "loc":"80.95597839355469 169.3186046511628", "text":"In Progress"},
                        {"key":2, "loc":"37 236.91860465116278", "text":"On Hold"},
                        {"key":3, "loc":"127.95597839355469 236.91860465116278", "text":"Testing"},
                        {"key":6, "loc":"127.95597839355469 304.5186046511628", "text":"Closed"},
                        {"key":-2, "category":"End", "loc":"91.95597839355464 381.6674418604649", "text":"End"}
                    ],
                    "linkDataArray": [
                        {"from":-1, "to":0, "fromPort":"B", "toPort":"T", "points":[ 80.95597839355469,50.418604651162795,80.95597839355469,60.418604651162795,80.95597839355469,67.9186046511628,80.95597839355469,67.9186046511628,80.95597839355469,75.4186046511628,80.95597839355469,85.4186046511628 ]},
                        {"from":1, "to":2, "fromPort":"B", "toPort":"T", "points":[ 80.95597839355469,185.61860465116277,80.95597839355469,195.61860465116277,80.95597839355469,203.11860465116277,37,203.11860465116277,37,210.61860465116277,37,220.61860465116277 ]},
                        {"from":3, "to":6, "fromPort":"B", "toPort":"T", "points":[ 127.95597839355469,253.21860465116276,127.95597839355469,263.21860465116276,127.95597839355469,270.71860465116276,127.95597839355469,270.71860465116276,127.95597839355469,278.21860465116276,127.95597839355469,288.21860465116276 ]},
                        {"from":6, "to":-2, "fromPort":"B", "toPort":"T", "points":[127.95597839355469,320.8186046511628,127.95597839355469,330.8186046511628,127.95597839355469,340.8186046511628,91.95597839355469,340.8186046511628,91.95597839355469,350.8186046511628,91.95597839355469,360.8186046511628]},
                        {"from":0, "to":1, "fromPort":"B", "toPort":"T", "points":[80.95597839355469,118.0186046511628,80.95597839355469,128.0186046511628,80.95597839355469,133.5,80.95597839355469,133.5,80.95597839355469,143.01860465116278,80.95597839355469,153.01860465116278]},
                        {"from":1, "to":3, "fromPort":"B", "toPort":"T", "points":[ 80.95597839355469,185.61860465116277,80.95597839355469,195.61860465116277,80.95597839355469,203.11860465116277,127.95597839355469,203.11860465116277,127.95597839355469,210.61860465116277,127.95597839355469,220.61860465116277 ]},
                        {"from":2, "to":1, "fromPort":"B", "toPort":"L", "points":[ 37,253.21860465116276,37,263.21860465116276,37,263.21860465116276,-12,263.21860465116276,-12,156,36.45597839355469,156,36.45597839355469,154.8186046511628,36.45597839355469,164.8186046511628 ]},
                        {"from":3, "to":1, "fromPort":"B", "toPort":"R", "points":[ 127.95597839355469,253.21860465116276,127.95597839355469,263.21860465116276,127.95597839355469,263.21860465116276,172,263.21860465116276,172,156,125.45597839355469,156,125.45597839355469,154.8186046511628,125.45597839355469,164.8186046511628 ]},
                        {"from":2, "to":-2, "fromPort":"B", "toPort":"T", "points":[37,253.21860465116276,37,263.21860465116276,37,260,37,260,37,332,91.95597839355469,332,91.95597839355469,350.8186046511628,91.95597839355469,360.8186046511628]}
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