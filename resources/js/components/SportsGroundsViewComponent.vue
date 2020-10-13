<template>
    <div>
        <vl-map id="map2" ref="map2" style="height: 500px" :load-tiles-while-animating="true"
                :load-tiles-while-interacting="true">
            <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation">
                <vl-layer-tile class="base-layer" :z-index="0">
                    <vl-source-osm></vl-source-osm>
                </vl-layer-tile>
                <vl-layer-vector :z-index="1">
                    <vl-source-vector  :features.sync="sportGrounds"></vl-source-vector>
                </vl-layer-vector>
                <vl-layer-vector id="sport" :z-index="2">
                    <vl-source-vector :features.sync="features"></vl-source-vector>
                    <vl-style-box>
                        <vl-style-icon src="./assets/images/icon_red.svg" :scale="1"></vl-style-icon>
                    </vl-style-box>
                </vl-layer-vector>


                <vl-interaction-select :features.sync="selectedFeatures" :layers="['sport']">
                    <template slot-scope="select">
                        <!-- select styles -->
                        <vl-style-box>
                            <vl-style-icon src="./assets/images/icon_blue.svg" :scale="1"></vl-style-icon>
                        </vl-style-box>
                        <!--// select styles -->

                        <!-- selected feature popup -->
                        <vl-overlay class="feature-popup" v-for="feature in select.features" :key="feature.id"
                                    :id="feature.id" :position="pointOnSurface(feature.geometry)" :auto-pan="true"
                                    :auto-pan-animation="{ duration: 300 }" :offset="[10, 10]">
                            <template slot-scope="popup">
                                <section class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            Thông tin địa điểm
                                            <a class="card-header-icon" title="Close"
                                               @click="selectedFeatures = selectedFeatures.filter(f => f.id !== feature.id)">x</a>
                                        </div>
                                        <div class="content">
                                            <ul>
                                                <li>Địa điểm: {{feature.properties.diadiem}}</li>
                                                <li>Khu Vực: {{feature.properties.makhuvuc}} - {{feature.properties.tenkhuvuc}}</li>
                                                <li>Tên: {{feature.properties.tendiadiem}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                            </template>
                        </vl-overlay>
                        <!--// selected popup -->
                    </template>
                </vl-interaction-select>

                <b-spinner v-if="loading"></b-spinner>
            </vl-view>
        </vl-map>
    </div>
</template>

<script>
import axios from "axios";
import {findPointOnSurface} from "vuelayers/lib/ol-ext";
import ScaleLine from "ol/control/ScaleLine";
import FullScreen from "ol/control/FullScreen";
import OverviewMap from "ol/control/OverviewMap";
import ZoomSlider from "ol/control/ZoomSlider";

export default {
    data() {
        return {
            features: [],
            zoom: 16,
            center: [11774094.696107, 1122418.043939],
            rotation: 0,
            loading: false,
            selectedFeatures: [],
            sportGrounds: [],
        };
    },
    mounted() {
        /*
         * Shine911 load sports grounds
         * Use direct GEOSERVER service
         */
        this.loading = true
        axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Aextracurricular_points&maxFeatures=50&outputFormat=application%2Fjson')
            .then(res => {
                this.features = res.data.features
                this.loading = false;
            })
        axios.get('http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3Asports_grounds&maxFeatures=50&outputFormat=application%2Fjson')
        .then(res=>{
            this.sportGrounds = res.data.features;
            this.loading = false;
        })
    },
    methods: {
        pointOnSurface: findPointOnSurface,
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
}
</script>

<style scoped>

</style>
