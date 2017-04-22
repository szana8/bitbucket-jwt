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
                jsontext: '',
                myDiagram: null,
                jsontext:  { "class": "go.GraphLinksModel",
                    "linkFromPortIdProperty": "fromPort",
                    "linkToPortIdProperty": "toPort",
                    "nodeDataArray": [
                        {"category":"Comment", "loc":"360 -10", "text":"Kookie Brittle", "key":-13},
                        {"key":-1, "category":"Start", "loc":"175 0", "text":"Start"},
                        {"key":0, "loc":"0 77", "text":"Preheat oven to 375 F"},
                        {"key":1, "loc":"175 100", "text":"In a bowl, blend: 1 cup margarine, 1.5 teaspoon vanilla, 1 teaspoon salt"},
                        {"key":2, "loc":"175 190", "text":"Gradually beat in 1 cup sugar and 2 cups sifted flour"},
                        {"key":3, "loc":"175 270", "text":"Mix in 6 oz (1 cup) Nestle's Semi-Sweet Chocolate Morsels"},
                        {"key":4, "loc":"175 370", "text":"Press evenly into ungreased 15x10x1 pan"},
                        {"key":5, "loc":"352 85", "text":"Finely chop 1/2 cup of your choice of nuts"},
                        {"key":6, "loc":"175 440", "text":"Sprinkle nuts on top"},
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
            var $ = go.GraphObject.make;
            this.myDiagram = $(go.Diagram, "workflowDiv", {
                initialContentAlignment: go.Spot.Center,
                allowDrop: true,  // must be true to accept drops from the Palette
                "LinkDrawn": showLinkLabel,  // this DiagramEvent listener is defined below
                "LinkRelinked": showLinkLabel,
                "animationManager.duration": 800, // slightly longer than default (600ms) animation
                "undoManager.isEnabled": true,  // enable undo & redo
                layout: $(go.TreeLayout, // specify a Diagram.layout that arranges trees
                    { angle: 90, layerSpacing: 35 })
            });

            function showLinkLabel(e) {
                var label = e.subject.findObject("LABEL");
                if (label !== null) label.visible = (e.subject.fromNode.data.figure === "Diamond");
            }

            var lightText = 'whitesmoke';

            // the template we defined earlier
            this.myDiagram.nodeTemplate =
                $(go.Node, "Auto",
                    { locationSpot: go.Spot.Center },
                    $(go.Shape, "RoundedRectangle",
                        {
                            fill: "white", // the default fill, if there is no data bound value
                            portId: "", cursor: "pointer",  // the Shape is the port, not the whole Node
                            // allow all kinds of links from and to this port
                            fromLinkable: true, fromLinkableSelfNode: true, fromLinkableDuplicates: true,
                            toLinkable: true, toLinkableSelfNode: true, toLinkableDuplicates: true
                        },
                        new go.Binding("fill", "color")),
                    $(go.TextBlock,
                        {
                            /*font: "bold 14px sans-serif",
                             stroke: '#fff',
                             margin: 6,  // make some extra space for the shape around the text
                             isMultiline: false,  // don't allow newlines in text
                             editable: true  // allow in-place editing by user
                             */
                            font: "bold 11pt Helvetica, Arial, sans-serif",
                            stroke: "#666666",
                            margin: 8,
                            maxSize: new go.Size(160, NaN),
                            wrap: go.TextBlock.WrapFit,
                            editable: true
                        },
                        new go.Binding("text", "text").makeTwoWay())  // the label shows the node data's text
                );
            myDiagram.linkTemplate =
                $(go.Link,  // the whole link panel
                    {
                        routing: go.Link.AvoidsNodes,
                        curve: go.Link.JumpOver,
                        corner: 5, toShortLength: 4,
                        relinkableFrom: true,
                        relinkableTo: true,
                        reshapable: true,
                        resegmentable: true,
                        // mouse-overs subtly highlight links:
                        mouseEnter: function(e, link) { link.findObject("HIGHLIGHT").stroke = "rgba(30,144,255,0.2)"; },
                        mouseLeave: function(e, link) { link.findObject("HIGHLIGHT").stroke = "transparent"; }
                    },
                    new go.Binding("points").makeTwoWay(),
                    $(go.Shape,  // the highlight shape, normally transparent
                        { isPanelMain: true, strokeWidth: 8, stroke: "transparent", name: "HIGHLIGHT" }),
                    $(go.Shape,  // the link path shape
                        { isPanelMain: true, stroke: "gray", strokeWidth: 2 }),
                    $(go.Shape,  // the arrowhead
                        { toArrow: "standard", stroke: null, fill: "gray"}),
                    $(go.Panel, "Auto",  // the link label, normally not visible
                        { visible: false, name: "LABEL", segmentIndex: 2, segmentFraction: 0.5},
                        new go.Binding("visible", "visible").makeTwoWay(),
                        $(go.Shape, "RoundedRectangle",  // the label shape
                            { fill: "#F8F8F8", stroke: null }),
                        $(go.TextBlock, "Yes",  // the label
                            {
                                textAlign: "center",
                                font: "10pt helvetica, arial, sans-serif",
                                stroke: "#333333",
                                editable: true
                            },
                            new go.Binding("text").makeTwoWay())
                    )
                );
            //var model = $(go.TreeModel);
            //model.nodeDataArray =

            //this.myDiagram.model = model;
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
                this.myDiagram.model = go.Model.fromJson(this.jsontext);
            },

            openWorkflowDialog : function()
            {
                this.setGoJS();
                this.dialog = true
            }

        }

    }
</script>