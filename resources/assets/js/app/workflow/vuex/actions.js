

export const create = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.post('/api/v1/workflow').then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}

export const update = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.patch('/api/v1/workflow/' + payload.id).then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}


export const destroy = ({dispatch}, {id, context, error}) => {
    return new Promise((resolve, reject) => {
        axios.delete('/api/v1/workflow/' + id).then(response => {
            resolve(response.data)
        }).catch(error => {
            reject(error)
        })
    })
}

export const initGoJS = () => {
    var $ = go.GraphObject.make;
    var myDiagram = $(go.Diagram, "workflowDiv", {
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
    myDiagram.nodeTemplate =
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

    // Disable diagram modifications, but allow navigation and selection
    myDiagram.isReadOnly = true;
    //var model = $(go.TreeModel);
    //model.nodeDataArray =

    //this.myDiagram.model = model;
    return myDiagram;
}