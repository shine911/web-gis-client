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
                    id="input-group-dormitoryzone"
                    label="Dormitoryzone:"
                    label-for="input-dormitoryzone"
                    description="Your dormitoryzone"
                >
                    <b-form-input id="input-roomcode" v-model="form.dormitoryzone" type="text"
                                  placeholder="dormitoryzone"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-range"
                    label="Range:"
                    label-for="input-range"
                    description="Your range"
                >
                    <b-form-input
                        id="input-range"
                        v-model="form.range"
                        type="text"
                        placeholder="range"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-floor"
                    label="Floor:"
                    label-for="input-floor"
                    description="Your floor"
                >
                    <b-form-input
                        id="input-floor"
                        v-model="form.floor"
                        type="number"
                        placeholder="Floor"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-buildingcode"
                    label="BuildingCode:"
                    label-for="input-roomcode"
                    description="Your roomcode"
                >
                    <b-form-input
                        id="input-roomquantity"
                        v-model="form.roomquantity"
                        type="number"
                        placeholder="roomquantity"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-roomcapity"
                    lable="Room capity:"
                    label-for="input-roomcapity"
                    description="Your Roomcapity"
                >
                    <b-form-input id="input-roomcapity" v-model="form.roomcapity" type="number" placeholder="Room capity"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-floorcapity"
                    label="Floorcapity:"
                    label-for="input-floorcapity"
                    description="Your floorcapity"
                >
                    <b-form-input id="input-floorcapity" v-model="form.floorcapity" type="number" placeholder="floorcapity"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-cook"
                    label="cook:"
                    label-for="input-cook"
                    description="Your cook"
                >
                    <b-form-input id="input-cook" v-model="form.cook" type="text"
                                  placeholder="Cook"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-roomarea"
                    label="roomarea:"
                    label-for="input-roomarea"
                    description="Your roomarea"
                >
                    <b-form-input
                        id="input-roomarea"
                        v-model="form.roomarea"
                        type="number"
                        placeholder="Room area"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-building"
                    label="building:"
                    label-for="input-building"
                    description="Your building"
                >
                    <b-form-input
                        id="input-building"
                        v-model="form.building"
                        type="text"
                        placeholder="building"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-contruclevel"
                    label="contruclevel:"
                    label-for="input-contruclevel"
                    description="Your contruclevel"
                >
                    <b-form-input id="input-contruclevel" v-model="form.contruclevel" type="text" placeholder="Contruclevel"></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-state"
                    label="state:"
                    label-for="input-state"
                    description="Your state"
                >
                    <b-form-input id="input-state" v-model="form.state" type="text" placeholder="state"></b-form-input>
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
                    id="input-group-startusingyear"
                    label="startusingyear:"
                    label-for="input-startusingyear"
                    description="Your startusingyear"
                >
                    <b-form-input
                        id="input-startusingyear"
                        v-model="form.startusingyear"
                        type="text"
                        placeholder="startusingyear"
                    ></b-form-input>
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
            axios.put('/api/dormitory/' + this.form.id,
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
                axios.delete('/api/dormitory/'+this.form.id).then(
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
                dormitoryzone: "",
                range: "",
                floor: "",
                roomquantity: "",
                roomcapity: "",
                floorcapity: "",
                cook: "",
                roomarea: "",
                building: "",
                contruclevel: "",
                state: "",
                area: "",
                startusingyear: "",
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
