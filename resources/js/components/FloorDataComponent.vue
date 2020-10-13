<template>
    <div class="row">
        <b-col cols="12">
            <b-spinner v-if="loading" label="Loading..."></b-spinner>
            <b-form v-if="!loading">
                <b-form-group
                    id="input-group-id"
                    label="ID:"
                    label-for="input-id"
                    description="You cannot change id."
                >
                    <b-form-input id="input-id" v-model="form.id" type="text" placeholder="ID"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-roomcode"
                    label="Roomcode:"
                    label-for="input-roomcode"
                    description="Your roomcode"
                >
                    <b-form-input id="input-roomcode" v-model="form.roomcode" type="text"
                                  placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-roomnamevi"
                    label="Roomcode:"
                    label-for="input-roomnamevi"
                    description="Your roomname"
                >
                    <b-form-input
                        id="input-roomnamevi"
                        v-model="form.roomnamevi"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-roomnameen"
                    label="Roomcode:"
                    label-for="input-roomnameen"
                    description="Your roomnameen"
                >
                    <b-form-input
                        id="input-roomnameen"
                        v-model="form.roomnamen"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-buildingcode"
                    label="BuildingCode:"
                    label-for="input-roomcode"
                    description="Your roomcode"
                >
                    <b-form-input
                        id="input-roomcode"
                        v-model="form.buildingcode"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-block"
                    lable="Block:"
                    label-for="input-block"
                    description="Your block"
                >
                    <b-form-input id="input-block" v-model="form.block" type="text" placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-floor"
                    label="Floor:"
                    label-for="input-floor"
                    description="Your floor"
                >
                    <b-form-input id="input-floor" v-model="form.floor" type="text" placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-zonecode"
                    label="Zonecode:"
                    label-for="input-zonecode"
                    description="Your zonecode"
                >
                    <b-form-input id="input-zonecode" v-model="form.zonecode" type="text"
                                  placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-campuscode"
                    label="CampusCode:"
                    label-for="input-campuscode"
                    description="Your campuscode"
                >
                    <b-form-input
                        id="input-campuscode"
                        v-model="form.campuscode"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-usingpurposecode"
                    label="usingpurposecode:"
                    label-for="input-usingpurposecode"
                    description="Your usingpurposecode"
                >
                    <b-form-input
                        id="input-usingpurposecode"
                        v-model="form.usingpurposecode"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-length"
                    label="length:"
                    label-for="input-length"
                    description="Your length"
                >
                    <b-form-input id="input-length" v-model="form.length" type="text" placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-width"
                    label="width:"
                    label-for="input-width"
                    description="Your width"
                >
                    <b-form-input id="input-width" v-model="form.width" type="text" placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-area"
                    label="area:"
                    label-for="input-area"
                    description="Your area"
                >
                    <b-form-input id="input-area" v-model="form.area" type="text" placeholder="Name"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-roomcapacity"
                    label="roomcapacity:"
                    label-for="input-roomcapacity"
                    description="Your roomcapacity"
                >
                    <b-form-input
                        id="input-roomcapacity"
                        v-model="form.roomcapacity"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-managementagencycode"
                    label="managementagencycode:"
                    label-for="input-managementagencycode"
                    description="Your managementagencycode"
                >
                    <b-form-input
                        id="input-managementagencycode"
                        v-model="form.managementagencycode"
                        type="text"
                        placeholder="Name"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-note"
                    label="note:"
                    label-for="input-note"
                    description="Your note"
                >
                    <b-form-input id="input-note" v-model="form.note" type="text" placeholder="Name"></b-form-input>
                </b-form-group>
                <!-- Map Editor -->
                <b-button
                    :disabled="drawType!=null"
                    variant="primary"
                    title="Draw polygon"
                    @click="drawType='polygon'"
                >
                    <b-icon-hexagon></b-icon-hexagon>
                </b-button>
                <b-button
                    :disabled="drawType!=null"
                    variant="primary"
                    title="Draw circle"
                    @click="drawType='circle'"
                >
                    <b-icon-circle></b-icon-circle>
                </b-button>
                <b-button
                    :disabled="selectedFeatures.length==0"
                    variant="primary"
                    title="Delete polygon"
                    @click="deleteFeature"
                >
                    <b-icon-trash></b-icon-trash>
                </b-button>
                <b-button
                    :disabled="drawType==null"
                    variant="primary"
                    title="Stop draw"
                    @click="drawType=undefined"
                >
                    <b-icon-stop></b-icon-stop>
                </b-button>

                <div class="map-css">
                    <vl-map
                        class="map"
                        ref="map"
                        @mounted="onMapMounted"
                        :load-tiles-while-animating="true"
                        :load-tiles-while-interacting="true"
                    >
                        <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation"></vl-view>
                        <vl-layer-tile class="base-layer" :z-index="0">
                            <vl-source-osm></vl-source-osm>
                        </vl-layer-tile>

                        <vl-layer-vector class="source-layer" :z-index="1">
                            <vl-source-vector ident="draw-target" :features.sync="features"></vl-source-vector>
                            <vl-style-box>
                                <vl-style-stroke color="green" :width="3"></vl-style-stroke>
                                <vl-style-fill color="rgba(255,255,255,0.5)"></vl-style-fill>
                            </vl-style-box>
                        </vl-layer-vector>
                        <vl-interaction-draw v-if="drawType" source="draw-target"
                                             :type="drawType"></vl-interaction-draw>
                        <vl-interaction-modify source="draw-target"></vl-interaction-modify>
                        <vl-interaction-snap source="draw-target" :priority="10"></vl-interaction-snap>
                        <vl-interaction-select :features.sync="selectedFeatures"
                                               v-if="drawType == null"></vl-interaction-select>
                        <p v-if="loading">Loading map, please wait...</p>
                    </vl-map>
                </div>

                <b-button type="button" @click="onSubmit" variant="primary">Submit</b-button>
                <b-button type="button" @click="onDelete" variant="danger">Delete</b-button>
            </b-form>
        </b-col>
    </div>
</template>

<script>
import axios from "axios";
import ScaleLine from "ol/control/ScaleLine";
import FullScreen from "ol/control/FullScreen";
import OverviewMap from "ol/control/OverviewMap";
import ZoomSlider from "ol/control/ZoomSlider";

export default {
    props: {
        data: Object,
        url: String,
    },
    data() {
        return {
            loading: false,
            zoom: 16,
            center: [11774094.696107, 1122418.043939],
            rotation: 0,
            features: [],
            feature: [],
            drawType: "polygon",
            selectedFeatures: [],
        };
    },
    mounted() {
        this.loading = true;
        axios.get(this.url).then((res) => {
            this.features = res.data.features;
            this.loading = false;
        });
    },
    methods: {
        onSubmit() {
            this.loading = true;
            //convert map to geom
            let geom = JSON.stringify(this.features[0].geometry.coordinates)
            this.form.geom = geom;
            axios.put('/api/room/' + this.form.id,
                {
                    data: this.form,
                }).then((_) => {
                this.loading = false;
            });
        },
        deleteFeature: function (_) {
            function isEqualsFeature(emt) {
                return emt.id === this.selectedFeatures[0].id;
            }

            //console.log(this.features.findIndex(isEqualsFeature, this));
            let id = this.features.findIndex(isEqualsFeature, this);
            this.features.splice(id, 1);
            this.selectedFeatures = [];
        },
        onDelete() {
            this.loading = true;
            if(confirm('Are you sure delete?')){
                axios.delete('/api/room/'+this.form.id).then(
                    (_) => {
                        let url = window.location.href
                        url = url.slice(0, url.lastIndexOf('/'));
                        url = url.slice(0, url.lastIndexOf('/'));
                        window.location.href = url
                    }
                );
            }
            this.loading = false;
            return false;
        },
        onMapMounted() {
            // now ol.Map instance is ready and we can work with it directly
            this.$refs.map.$map.getControls().extend([
                new ScaleLine(),
                new FullScreen(),
                new OverviewMap({
                    collapsed: false,
                    collapsible: true,
                }),
                new ZoomSlider(),
            ]);
        },
    },

    computed: {
        form: function () {
            if (this.data != null) {
                return this.data;
            }
            return {
                id: "",
                roomcode: "",
                roomnamevi: "",
                roomnameen: "",
                buildingcode: "",
                block: "",
                floor: "",
                zonecode: "",
                capuscode: "",
                usingpurposecode: "",
                length: "",
                width: "",
                area: "",
                roomcapacity: "",
                managementagencycode: "",
                note: "",
            };
        },
    },
};
</script>
<style scoped>
.map {
    height: 500px;
    margin: .5rem 0;
}
</style>
